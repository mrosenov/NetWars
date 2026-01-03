<?php

namespace App\Http\Controllers;

use App\Console\Commands\NetworkLogfile;
use App\Models\UserProcess;
use App\Services\NetworkLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NetworkLogfileController extends Controller
{
    public function show(NetworkLogService $logs) {
        $user = auth()->user();
        $networkId = $user?->connectedNetwork()?->id;

        if (!$networkId) {
            return redirect('internet.index')->with('status', 'No network connected.');
        }

        $log = $logs->get($networkId);

        return view('pages.target.logs', [
            'networkId' => $networkId,
            'content' => (string) $log->content,
            'baseHash' => $logs->baseHash((string) $log->content),
        ]);
    }

    public function save(Request $request, int $networkId)
    {
        $user = $request->user();

        $data = $request->validate([
            'content' => ['nullable', 'string'],
            'base_hash' => ['nullable', 'string'],
        ]);

        // Only error you want: already saving for this network
        $already = UserProcess::where('user_id', $user->id)
            ->where('resource_type', 'cpu')
            ->where('action', 'log')
            ->where('status', 'running')
            ->where('metadata->network_id', $networkId)
            ->exists();

        if ($already) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Save already in progress.',
                ], 409);
            }
            return back()->withErrors('Save already in progress.');
        }

        $userProcess = new UserProcessController();

        // Compute work based on content size
        $bytes = strlen($data['content']);
        $kb = (int) max(1, ceil($bytes / 1024));

        $workUnits = 1;
        $cpuPower = (int) max(1, $userProcess->getUserCpuPowerTotal($user->id));

        $idealSeconds = 3;

        $now = now();

        $process = DB::transaction(function () use ($user, $networkId, $data, $workUnits, $idealSeconds, $cpuPower, $now, $userProcess) {
            $p = UserProcess::create([
                'user_id' => $user->id,
                'resource_type' => 'cpu',
                'action' => 'log',
                'metadata' => [
                    'network_id' => $networkId,
                    'content' => $data['content'],
                ],
                'work_units' => $workUnits,
                'ideal_seconds' => $idealSeconds,
                'cpu_power_snapshot' => $cpuPower,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);


            $userProcess->rebalanceUserCpuProcesses($user->id);

            return $p;
        });

        if ($request->wantsJson()) {
            return response()->json([
                'process_id' => $process->id,
                'duration_seconds' => $process->ideal_seconds,
                'ends_at' => $process->ends_at->toISOString(),
            ]);
        }

        return back()->with('status', 'Saving started.');
    }

    public function logSaveStatus(Request $request, int $networkId)
    {
        $user = $request->user();
        $now = now();

        $p = UserProcess::where('user_id', $user->id)
            ->where('resource_type', 'cpu')
            ->where('action', 'log')
            ->where('metadata->network_id', $networkId)
            ->orderByDesc('id')
            ->first();

        if (!$p) {
            return response()->json(['status' => 'none']);
        }

        // If already completed/failed
        if (in_array($p->status, ['completed', 'failed'], true)) {
            return response()->json([
                'process_id' => $p->id,
                'status' => $p->status,
                'progress' => $p->status === 'completed' ? 1.0 : 0.0,
                'remaining_seconds' => 0,
                'ends_at' => optional($p->ends_at)->toISOString(),
            ]);
        }

        // Running but missing timestamps -> treat as none
        if (!$p->started_at || !$p->ends_at) {
            return response()->json([
                'process_id' => $p->id,
                'status' => 'running',
                'progress' => 0.0,
                'remaining_seconds' => 0,
                'ends_at' => null,
            ]);
        }

        $startTs = $p->started_at->timestamp;
        $endTs   = $p->ends_at->timestamp;
        $nowTs   = $now->timestamp;

        $total = max(1, $endTs - $startTs);
        $remaining = max(0, $endTs - $nowTs);
        $elapsed = $total - $remaining;

        $progress = min(1.0, max(0.0, $elapsed / $total));

        // IMPORTANT: if time is over, consider it completed for UI
        // (even if your artisan command hasn’t flipped status yet)
        if ($remaining === 0) {

            $p->update(['status' => 'completed', 'completed_at' => $now]);

            $nLogService = new NetworkLogService();
            $nLogService->saveEdited($networkId,$user->id,$p->metadata['content']);

            return response()->json([
                'process_id' => $p->id,
                'status' => 'completed',
                'progress' => 1.0,
                'remaining_seconds' => 0,
                'ends_at' => $p->ends_at->toISOString(),
            ]);
        }

        return response()->json([
            'process_id' => $p->id,
            'status' => 'running',
            'progress' => $progress,
            'remaining_seconds' => $remaining,
            'ends_at' => $p->ends_at->toISOString(),
        ]);
    }

    public function content(int $networkId, NetworkLogService $logs)
    {
        // TODO: add auth/permission checks for reading logs
        $content = $logs->get($networkId) ?? '';

        return response()->json([
            'content' => $content,
            'base_hash' => hash('sha256', $content),
        ]);
    }

    public function finalizeLogSave(Request $request, int $networkId, NetworkLogService $logs)
    {
        $user = $request->user();
        $now = now();

        return DB::transaction(function () use ($user, $networkId, $logs, $now) {

            $p = UserProcess::where('user_id', $user->id)
                ->where('resource_type', 'cpu')
                ->where('action', 'log')
                ->where('status', 'running')
                ->where('metadata->network_id', $networkId)
                ->lockForUpdate()
                ->first();

            if (!$p) {
                return response()->json(['status' => 'noop']);
            }

            if (!$p->ends_at || $p->ends_at->isFuture()) {
                return response()->json(['status' => 'still_running']);
            }

            $newContent = $p->metadata['content'] ?? '';
            // Force-save (no conflicts): use CURRENT base hash
            $currentContent = $logs->get($networkId) ?? '';
            $expectedBaseHash = hash('sha256', $currentContent);

            $logs->saveEdited(
                networkId: $networkId,
                actorId: $user->id,
                newContent: $newContent,
            );

            $p->status = 'completed';
            $p->completed_at = $now;
            $p->ends_at = $now;
            $p->save();

            $userProcess = new UserProcessController();
            $userProcess->rebalanceUserCpuProcesses($user->id);

            return response()->json(['status' => 'completed']);
        });
    }



//    public function save(Request $request, int $networkId, NetworkLogService $logs) {
//        // TODO: enforce permissions: require root/admin + connected session, etc.
//
//        // Optional: rate limit saves (recommended)
//        // $request->validate([...]) then throttle middleware on route
//
//        $data = $request->validate([
//            'content' => ['required', 'string'],
//            'base_hash' => ['required', 'string', 'size:64'], // sha256 hex
//        ]);
//
//        $actorId = $request->user()?->id; // adapt to your auth/player system
//
//        $logs->saveEdited(
//            networkId: $networkId,
//            actorId: $actorId,
//            newContent: $data['content'],
//            expectedBaseHash: $data['base_hash']
//        );
//
//        return redirect()->back()->with('status', 'Saved.');
//    }
}
