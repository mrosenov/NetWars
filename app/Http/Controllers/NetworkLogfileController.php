<?php

namespace App\Http\Controllers;

use App\Models\UserProcess;
use App\Services\NetworkLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NetworkLogfileController extends Controller
{
    public function show(NetworkLogService $logs) {
        // TODO: enforce permissions: player must have access to this network / machine
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

    public function save(Request $request, int $networkId, NetworkLogService $logs) {
        $data = $request->validate([
            'content' => ['required', 'string'],
            'base_hash' => ['required', 'string', 'size:64'], // sha256 hex
        ]);

        $user = $request->user();
        $actorId = $user->id;

        # Prevent multiple concurrent log-save processes for same network/user
        $alreadyRunning = UserProcess::where('user_id', $actorId)
            ->where('resource_type', 'cpu')
            ->where('action', 'log')
            ->where('status', 'running')
            ->where('metadata->target_network_id', $networkId)
            ->exists();

        if ($alreadyRunning) {
            return redirect()->back()->withErrors('A log save is already in progress for this network.');
        }

        // Determine file size from content (KB) for work units
        $bytes = strlen($data['content']); // bytes (UTF-8: may differ slightly; good enough)
        $kb = (int) max(1, ceil($bytes / 1024));

        // Work units for log edit (simple)
        $workUnits = 2_000 + ($kb * 120); // tune constants later

        $userProcess = new UserProcessController();
        // Compute total user cpu power (your existing aggregator)
        $cpuPowerTotal = $userProcess->getUserCpuPowerTotal($actorId);
        if ($cpuPowerTotal <= 0) {
            return redirect()->back()->withErrors('No CPU resources available.');
        }

        $idealSeconds = (int) max(1, ceil($workUnits / $cpuPowerTotal));

        $now = now();

        $process = DB::transaction(function () use ($actorId, $networkId, $data, $workUnits, $idealSeconds, $cpuPowerTotal, $now, $userProcess) {
            $p = UserProcess::create([
                'user_id' => $actorId,
                'resource_type' => 'cpu',
                'action' => 'log',
                'metadata' => [
                    'network_id' => $networkId,
                    'base_hash' => $data['base_hash'],
                    'content_kb' => (int) $workUnits, // optional debug
                ],
                'work_units' => $workUnits,
                'ideal_seconds' => $idealSeconds,
                'cpu_power_snapshot' => $cpuPowerTotal,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);

            $userProcess->rebalanceUserCpuProcesses($actorId);

            return $p;
        });

        // UX: redirect back and show “saving started”
        return redirect()->back()->with('status', "Saving scheduled (process #{$process->id}).");
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
