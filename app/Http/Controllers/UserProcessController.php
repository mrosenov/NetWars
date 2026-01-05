<?php

namespace App\Http\Controllers;

use App\Models\HackedNetworks;
use App\Models\ServerSoftwares;
use App\Models\UserNetwork;
use App\Models\UserProcess;
use App\Services\NetworkLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserProcessController extends Controller
{

    public function index() {
        $hacker = auth()->user();
        $connection = $this->getUserNetTotals();

        $tasks = $hacker->tasks()->where('status', 'running')->get();

        return view('pages.tasks.index', [
            'tasks' => $tasks,
            'connection' => $connection,
            'downloadSpeed' => $this->getActiveDownloadSpeeds(),
            'uploadSpeed' => $this->getActiveUploadSpeeds(),
        ]);
    }

    public function cpu_index() {
        $hacker = auth()->user();

        $tasks = $hacker->tasks()->where('status', 'running')->where('resource_type', 'cpu')->get();

        return view('pages.tasks.cpu', [
            'tasks' => $tasks,
        ]);
    }

    public function network_index() {
        $hacker = auth()->user();

        $tasks = $hacker->tasks()->where('status', 'running')->where('resource_type', 'network')->get();

        return view('pages.tasks.network', [
            'tasks' => $tasks,
            'downloadSpeed' => $this->getActiveDownloadSpeeds(),
            'uploadSpeed' => $this->getActiveUploadSpeeds(),
        ]);
    }

    public function getUserCpuPowerTotal(): int {

        $user = auth()->user();
        $resources = $user->resources()->with('hardware')->get();

        $cpu_power = 0;
        foreach ($resources as $resource) {
            $hw = $resource->hardware;

            if (!$hw) {
                continue;
            }

            if ($hw->type != 'cpu') {
                continue;
            }

            $spec = is_array($hw->specifications) ? $hw->specifications : (array) $hw->specifications;

            $cpu_power += (int) data_get($spec, 'compute_power', 0);
        }

        return (int) $cpu_power;
    }

    public function computeWorkUnits(string $action, array $metadata): int {
        return match ($action) {
            'install' => 20_000 + (int)($metadata['software_size'] ?? 1) * 15_000,

            'log' => 5_000 + (int)($metadata['file_kb'] ?? 50) * 30,

            'bruteforce' => (int)(50_000 * (2 ** max(0, ((int)($metadata['difficulty'] ?? 1)) - 1))),

            'scan' => 30_000 + (int)($metadata['ports'] ?? 10) * 900 + (int)($metadata['target_security'] ?? 1) * 20_000,

            'exploit_ssh' => 60_000 + (int)($metadata['service_security'] ?? 1) * 25_000,

            'exploit_ftp' => 45_000 + (int)($metadata['service_security'] ?? 1) * 20_000,

            default => 30_000,
        };
    }

    public function calculateProcessDuration(string $action, array $metadata): float {
        $base = match ($action) {
            'install' => 12,
            'log' => 3,
            'bruteforce' => 10,
            'scan' => 30,
            'exploit_ssh' => 15,
            'exploit_ftp' => 12,
            default => 10,
        };

        $multiplier = match ($action) {

            // Bruteforce scales with a hasher version
            'bruteforce' => isset($metadata['hasher_version']) && is_numeric($metadata['hasher_version']) ? (float) $metadata['hasher_version'] : 1.0,

            // Scans scale with security level
            'scan' => isset($metadata['security_level']) && is_numeric($metadata['security_level']) ? 1 + ((int) $metadata['security_level'] * 0.2) : 1.0,

            // Exploits scale with difficulty
            'exploit_ssh', 'exploit_ftp' => isset($metadata['difficulty']) && is_numeric($metadata['difficulty']) ? 1 + ((int) $metadata['difficulty'] * 0.3) : 1.0,

            // Install scales with software size
            'install' => isset($metadata['size_mb']) && is_numeric($metadata['size_mb']) ? max(1.0, (float) $metadata['size_mb'] / 10) : 1.0,

            // Logs are fixed time
            'log' => 1.0,

            default => 1.0,
        };

        return max(1, (int) ceil($base * $multiplier));
    }

    public function start($action, $metadata = []) {
        $user = auth()->user();

        return DB::transaction(function () use ($user, $action, $metadata) {

            $cpu_power = $this->getUserCpuPowerTotal();

            if ($cpu_power <= 0) {
                abort(422, 'No CPU resources available.');
            }

            $workUnits = $this->computeWorkUnits($action, $metadata);

            $duration = $this->calculateProcessDuration($action, $metadata);
            $duration = max(1, (int) ceil($duration - ($cpu_power / 100)));


            $now = Carbon::now();

            $process = UserProcess::create([
                'user_id' => $user->id,
                'resource_type' => 'cpu',
                'action' => $action,
                'metadata' => $metadata,
                'work_units' => $workUnits,
                'ideal_seconds' => $duration,
                'remaining_ideal_seconds' => $duration,
                'ideal_done' => 0,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => $cpu_power,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration),
            ]);

            // Rebalance all running CPU processes (including new one)
            $this->rebalanceUserCpuProcesses($user->id);
        });
    }

    public function rebalanceUserCpuProcesses(int $userId): void
    {
        $now = now();

        $processes = UserProcess::where('user_id', $userId)
            ->where('resource_type', 'cpu')
            ->where('status', 'running')
            ->orderBy('id')
            ->lockForUpdate()
            ->get();

        $n = $processes->count();
        if ($n === 0) return;

        $newShare = (int) max(1, floor(100 / $n));

        foreach ($processes as $p) {
            $oldShare = (int) max(1, (int) $p->share_percent);

            // Initialize for old rows
            if ($p->remaining_ideal_seconds === null) {
                $p->remaining_ideal_seconds = (int) $p->ideal_seconds;
            }
            if ($p->last_progress_at === null) {
                $p->last_progress_at = $p->started_at ?? $now;
            }

            $deltaReal = max(0, $now->timestamp - $p->last_progress_at->timestamp);
            $deltaIdeal = (int) floor($deltaReal * ($oldShare / 100));

            $p->remaining_ideal_seconds = (int) max(0, $p->remaining_ideal_seconds - $deltaIdeal);
            $p->last_progress_at = $now;

            if ($p->remaining_ideal_seconds <= 0) {
                $p->status = 'completed';
                $p->completed_at = $now;
                $p->ends_at = $now;
                $p->share_percent = $newShare;
                $p->save();
                continue;
            }

            $remainingReal = (int) ceil($p->remaining_ideal_seconds * (100 / $newShare));

            $p->share_percent = $newShare;
            $p->ends_at = $now->copy()->addSeconds($remainingReal);
            $p->save();
        }
    }

    public function getUserNetTotals() {

        $user = auth()->user();
        $hwService = $user->connectivity();

        $spec = is_array($hwService->specifications) ? $hwService->specifications : (array) $hwService->specifications;
        $connectivity = $spec['connectivity_mbps'];

        $downBps = max(0.0001, $connectivity / 8);
        $upBps = max(0.0001, $connectivity / 16);

        return [
            'down_mbps' => max(0, $downBps),
            'up_mbps'   => max(0, $upBps),
        ];
    }

    public function getActiveDownloadSpeeds(): array {
        $user = auth()->user();
        $net = $this->getUserNetTotals();
        $totalDownMbps = (float) ($net['down_mbps'] ?? 0);

        $totalDownBps = (int) floor(($totalDownMbps * 1_000_000) / 8);

        $downloads = UserProcess::where('user_id', $user->id)
            ->where('resource_type', 'network')
            ->where('action', 'download')
            ->where('status', 'running')
            ->get();

        $result = [];

        foreach ($downloads as $p) {
            $share = max(1, (int) $p->share_percent);
            $bps = (int) floor($totalDownBps * ($share / 100));

            $result[$p->id] = [
                'bps'   => $bps,
                'kbps'  => round($bps / 1024, 1),
                'mbps'  => round(($bps * 8) / 1_000_000, 2),
                'share' => $share,
            ];
        }

        return $result;
    }

    public function getActiveUploadSpeeds(): array {
        $user = auth()->user();
        $net = $this->getUserNetTotals();
        $totalUploadMbps = (float) ($net['up_mbps'] ?? 0);

        $totalUploadBps = (int) floor(($totalUploadMbps * 1_000_000) / 16);

        $downloads = UserProcess::where('user_id', $user->id)
            ->where('resource_type', 'network')
            ->where('action', 'upload')
            ->where('status', 'running')
            ->get();

        $result = [];

        foreach ($downloads as $p) {
            $share = max(1, (int) $p->share_percent);
            $bps = (int) floor($totalUploadBps * ($share / 100));

            $result[$p->id] = [
                'bps'   => $bps,
                'kbps'  => round($bps / 1024, 1),
                'mbps'  => round(($bps * 16) / 1_000_000, 2),
                'share' => $share,
            ];
        }

        return $result;
    }


    public function startDownload(Request $request, ServerSoftwares $software) {
        $user = auth()->user();

        $direction = 'download';
        $sizeMb = (float) $software->size;

        if (!$software) {
            abort(404, 'Software not found.');
        }

        $availableMb = $user->availableStorageMb();

        if ($software->size > $availableMb) {
            abort(403, 'You do not have enough storage space.');
        }

        $alreadyOwned = ServerSoftwares::query()
            ->where('owner_type', \App\Models\User::class)
            ->where('owner_id', $user->id)
            ->where('type', $software->type)
            ->where('version', $software->version)
            ->exists();

        if ($alreadyOwned) {
            return redirect()->route('target.software')->with('error', 'You already own this software.');
        }

        return DB::transaction(function () use ($user, $direction, $software, $sizeMb) {
            $net = $this->getUserNetTotals();
            $downMBps = $net['down_mbps'];

            if ($downMBps <= 0) {
                abort(422, "No {$direction} link bandwidth available.");
            }

            $idealSeconds = (int) max(1, ceil($sizeMb / $downMBps));
            $now = now();

            $process = UserProcess::create([
                'user_id' => $user->id,
                'resource_type' => 'network',
                'action' => 'download',
                'metadata' => [
                    'direction' => $direction,
                    'software_id' => $software->id,
                    'target_network_id' => $user->connectedNetwork()->id,
                    'software_name' => $software->name,
                    'size_bytes' => $sizeMb,
                    'size_mb' => (float) $software->size,
                    'rate_snapshot_mbps' => $downMBps,
                ],
                'work_units' => $sizeMb,
                'ideal_seconds' => $idealSeconds,
                'remaining_ideal_seconds' => $idealSeconds,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);

            $this->rebalanceUserNetProcesses($user->id, $direction);

            return redirect()->route('tasks.index');
        });

    }

    public function startUpload(Request $request) {
        $user = auth()->user();

        $data = $request->validate([
            'software_id' => ['required', 'integer', 'exists:software,id'],
        ]);

        $software = ServerSoftwares::find($data['software_id']);

        if (!$software) {
            abort(404, 'Software not found.');
        }

        if ($software->owner_type !== \App\Models\User::class || (int) $software->owner_id !== (int) $user->id) {
            abort(403, 'You do not own this software.');
        }

        $targetNetwork = $user->connectedNetwork();

        if (!$targetNetwork) {
            abort(404, 'No target network found.');
        }

        $availableMb = $targetNetwork->owner->availableStorageMb();

        if ($software->size > $availableMb) {
            abort(403, 'Target server does not have enough storage space.');
        }

        $pendingUploadsMb = UserProcess::where('resource_type', 'network')->where('action', 'upload')->where('status', 'running')->where('metadata->target_network_id', $targetNetwork->id)->sum('metadata->size_mb');

        if ($software->size > ($availableMb - $pendingUploadsMb)) {
            abort(403, 'Not enough free storage (uploads in progress).');
        }

        $alreadyOnTarget = ServerSoftwares::query()
            ->where('owner_type', get_class($targetNetwork->owner))
            ->where('owner_id', (int) $targetNetwork->owner->id)
            ->where('type', $software->type)
            ->where('version', $software->version)
            ->exists();

        if ($alreadyOnTarget) {
            return redirect()->route('target.software')->with('error', 'The software already exists on the target network.');
        }

        $direction = 'upload';
        $sizeMb = (float) $software->size;

        return DB::transaction(function () use ($user, $direction, $software, $sizeMb) {
            $net = $this->getUserNetTotals();
            $upMBps = $net['up_mbps'];

            if ($upMBps <= 0) {
                abort(422, "No {$direction}link bandwidth available.");
            }

            $idealSeconds = (int) max(1, ceil($sizeMb / $upMBps));
            $now = now();

            $process = UserProcess::create([
                'user_id' => $user->id,
                'resource_type' => 'network',
                'action' => 'upload',
                'metadata' => [
                    'direction' => $direction,
                    'software_id' => $software->id,
                    'target_network_id' => $user->connectedNetwork()->id,
                    'software_name' => $software->name,
                    'size_bytes' => $sizeMb,
                    'size_mb' => (float) $software->size,
                    'rate_snapshot_mbps' => $upMBps,
                ],
                'work_units' => $sizeMb,
                'ideal_seconds' => $idealSeconds,
                'remaining_ideal_seconds' => $idealSeconds,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);


            $this->rebalanceUserNetProcesses($user->id, $direction);

            return redirect()->route('tasks.index');
        });

    }


    public function rebalanceUserNetProcesses(int $userId, string $direction): void {
        $now = now();

        $query = UserProcess::where('user_id', $userId)->where('resource_type', 'network')->where('status', 'running');

        $query->whereIn('action', $direction === 'download' ? ['download'] : ['upload']);

        $processes = $query->orderBy('id')->lockForUpdate()->get();

        $n = $processes->count();
        if ($n === 0) return;

        $base = intdiv(100, $n);
        $rem  = 100 - ($base * $n);

        foreach ($processes as $i => $p) {
            $newShare = $base + ($i < $rem ? 1 : 0);
            $oldShare = (int) max(1, (int) $p->share_percent);

            // init for older rows
            if ($p->remaining_ideal_seconds === null) {
                $p->remaining_ideal_seconds = (int) $p->ideal_seconds;
            }
            if ($p->last_progress_at === null) {
                $p->last_progress_at = $p->started_at ?? $now;
            }

            $deltaReal = max(0, $p->last_progress_at->diffInSeconds($now));
            $deltaIdeal = (int) floor($deltaReal * ($oldShare / 100));

            $p->remaining_ideal_seconds = (int) max(0, $p->remaining_ideal_seconds - $deltaIdeal);
            $p->last_progress_at = $now;

            if ($p->remaining_ideal_seconds <= 0) {
                $p->status = 'completed';
                $p->completed_at = $now;
                $p->ends_at = $now;
                $p->share_percent = $newShare;
                $p->save();
                continue;
            }

            $newRemainingReal = (int) ceil($p->remaining_ideal_seconds * (100 / $newShare));

            $p->share_percent = $newShare;
            $p->ends_at = $now->copy()->addSeconds($newRemainingReal);
            $p->save();
        }
    }


    public function applyNetworkProcessEffects(UserProcess $process): void {
        $metadata = $process->metadata ?? [];

        $softwareId = $metadata['software_id'] ?? null;
        $networkId = $metadata['target_network_id'] ?? null;

        $software = ServerSoftwares::find($softwareId);
        $targetNetwork = UserNetwork::find($networkId);

        if (!$software) return;
        if (!$targetNetwork) return;

        if ($process->action === 'download') {
            $copy = $software->replicate();
            $copy->owner()->associate($process->user);
            $copy->save();

            app(\App\Services\NetworkLogService::class)->appendLine($networkId,
                sprintf("[%s] - [%s] downloaded [%s.%s (%s)] from localhost", now()->format('Y-m-d H:i:s'), $process->user->network->ip, $copy->name, $copy->type, $copy->version)
            );
        }

        if ($process->action === 'upload') {
            $copy = $software->replicate();
            $copy->owner()->associate($targetNetwork->owner);
            $copy->save();

            app(\App\Services\NetworkLogService::class)->appendLine($networkId,
                sprintf("[%s] - [%s] uploaded [%s.%s (%s)] at localhost", now()->format('Y-m-d H:i:s'), $process->user->network->ip, $copy->name, $copy->type, $copy->version)
            );
        }
    }

    public function applyCpuProcessEffects(UserProcess $process, NetworkLogService $logs): void {

        if ($process->action === 'bruteforce') {

            $network = UserNetwork::findOrFail($process->metadata['target_network_id']);
            $hacked = new HackedNetworks();

            $hacked->create([
                'user_id' => $process->user->id,
                'network_id' => $network->id,
                'user' => $network->user,
                'password' => $network->password,
                'ip' => $network->ip,
            ]);

            $logs->saveEdited($process->user->network->id, $process->user->id,
                sprintf("[%s] - [%s] successfully penetrated into [%s]", now()->format('Y-m-d H:i:s'), $process->user->network->ip, $network->ip)
            );
        }

    }

    public function status(Request $request) {
        $user = $request->user();
        $now = now();

        $tasks = UserProcess::where('user_id', $user->id)
            ->whereIn('status', ['running', 'completed', 'failed'])
            ->orderByDesc('id')
            ->get()
            ->map(function ($p) use ($now) {
                $started = $p->started_at?->toISOString();
                $ends = $p->ends_at?->toISOString();

                $progress = 0.0;
                $remaining = 0;

                if ($p->status === 'running' && $p->started_at && $p->ends_at) {
                    $total = max(1, $p->ends_at->timestamp - $p->started_at->timestamp);
                    $remaining = max(0, $p->ends_at->timestamp - $now->timestamp);
                    $elapsed = $total - $remaining;
                    $progress = min(1.0, max(0.0, $elapsed / $total));
                } elseif ($p->status === 'completed') {
                    $progress = 1.0;
                }

                return [
                    'id' => $p->id,
                    'status' => $p->status,
                    'started_at' => $started,
                    'ends_at' => $ends,
                    'progress' => $progress,
                    'remaining_seconds' => $remaining,
                    'action' => $p->action,
                    'resource_type' => $p->resource_type,
                ];
            });

        return response()->json([
            'now' => $now->toISOString(),
            'tasks' => $tasks,
        ]);
    }

    public function finalize(Request $request, UserProcess $process) {
        $user = $request->user();
        $now = now();

        // Only allow finalizing your own running tasks
        if ($process->user_id !== $user->id) {
            abort(403, "What the fuck?");
        }

        return DB::transaction(function () use ($process, $now) {
            // lock row to prevent double-finalize
            $p = UserProcess::whereKey($process->id)->lockForUpdate()->first();

            if (!$p || $p->status !== 'running') {
                return response()->json(['status' => 'noop']);
            }

            if (!$p->ends_at || $p->ends_at->isFuture()) {
                return response()->json(['status' => 'still_running']);
            }

            $this->applyCpuProcessEffects($p, app(NetworkLogService::class));
            $this->applyNetworkProcessEffects($p);

            $p->status = 'completed';
            $p->completed_at = $now;
            $p->ends_at = $now;
            $p->save();

            $this->rebalanceUserCpuProcesses($process->user->id);
            $this->rebalanceUserNetProcesses($p->user->id, $p->action);

            return response()->json([
                'status' => 'completed',
            ]);
        });
    }

    public function cancel(Request $request, UserProcess $process) {
        $user = $request->user();

        if ($process->user_id !== $user->id) {
            abort(403, "What the fuck?");
        }

        if ($process->status !== 'running') {
            return response()->json(['status' => 'noop']);
        }

        $process->status = 'canceled';
        $process->completed_at = now();
        $process->ends_at = now();
        $process->save();

        $this->rebalanceUserCpuProcesses($user->id);

        return response()->json(['status' => 'canceled']);
    }

}
