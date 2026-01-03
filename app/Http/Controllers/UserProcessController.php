<?php

namespace App\Http\Controllers;

use App\Models\ServerSoftwares;
use App\Models\UserNetwork;
use App\Models\UserProcess;
use App\Services\NetworkLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserProcessController extends Controller
{
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

    public function start(Request $request) {
        $user = auth()->user();

        $data = $request->validate([
            'action' => 'required|string|in:install,log,bruteforce,scan,ssh,ftp',
            'metadata' => 'array',
        ]);

        $action = $data['action'];
        $metadata = $data['metadata'] ?? [];

        return DB::transaction(function () use ($user, $action, $metadata) {

            $cpu_power = $this->getUserCpuPowerTotal();

            if ($cpu_power <= 0) {
                abort(422, 'No CPU resources available.');
            }

            $workUnits = $this->computeWorkUnits($action, $metadata);

            // Ideal seconds at 100% share
            $idealSeconds = (int) max(1, ceil($workUnits / $cpu_power));

            $now = Carbon::now();

            $process = UserProcess::create([
                'user_id' => $user->id,
                'resource_type' => 'cpu',
                'action' => $action,
                'metadata' => $metadata,
                'work_units' => $workUnits,
                'ideal_seconds' => $idealSeconds,
                'cpu_power_snapshot' => $cpu_power,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);

            // Rebalance all running CPU processes (including new one)
            $this->rebalanceUserCpuProcesses($user->id);

            return response()->json([
                'process_id' => $process->id,
                'status' => 'started',
            ]);
        });
    }

    public function rebalanceUserCpuProcesses(int $userId) {

        $now = now();

        // Lock rows to avoid race conditions when starting multiple processes quickly
        $processes = UserProcess::where('user_id', $userId)->where('resource_type', 'cpu')->where('status', 'running')->orderBy('id')->lockForUpdate()->get();

        $n = $processes->count();
        if ($n === 0) {
            return;
        }

        // Even split. Priority of process might be implemented later.
        $newShare = (int) max(1, floor(100 / $n));

        foreach ($processes as $process) {
            $oldShare = (int) max(1, $process->share_percent);

            // If started_at missing, treat as started now
            $startedAt = $process->started_at ?? $now;

            $elapsedReal = max(0, $now->diffInSeconds($startedAt));
            $elapsedIdeal = (int) floor($elapsedReal * ($oldShare / 100));

            $remainingIdeal = max(0, $process->ideal_seconds - $elapsedIdeal);

            // If ideal is done, mark completed immediately
            if ($remainingIdeal <= 0) {
                $process->status = 'completed';
                $process->completed_at = $now;
                $process->ends_at = $now;
                $process->share_percent = $newShare;
                $process->save();
                continue;
            }

            $newRemainingReal = (int) ceil($remainingIdeal * (100 / $newShare));
            $newEndsAt = $now->copy()->addSeconds($newRemainingReal);

            $process->share_percent = $newShare;
            $process->ends_at = $newEndsAt;

            // Important: do NOT change started_at here (keeps history)
            $process->save();
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

        return DB::transaction(function () use ($user, $direction, $software, $sizeMb) {
            $net = $this->getUserNetTotals();
            $downMBps = $net['down_bps'];

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
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);

            $this->rebalanceUserNetProcesses($user->id, $direction);

            return response()->json([
                'process_id' => $process->id,
                'ideal_seconds' => $idealSeconds,
                'ends_at' => $process->ends_at,
            ]);

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
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($idealSeconds),
            ]);


            $this->rebalanceUserNetProcesses($user->id, $direction);

            return response()->json([
                'process_id' => $process->id,
                'ideal_seconds' => $idealSeconds,
                'ends_at' => $process->ends_at,
            ]);
        });

    }


    public function rebalanceUserNetProcesses(int $userId, string $direction): void {
        $now = now();

        $query = UserProcess::where('user_id', $userId)->where('resource_type', 'network')->where('status', 'running');
        $query->whereIn('action', $direction === 'download' ? ['download'] : ['upload']);

        $processes = $query->orderBy('id')->lockForUpdate()->get();

        $n = $processes->count();
        if ($n === 0) return;

        $newShare = (int) max(1, floor(100 / $n));

        foreach ($processes as $process) {
            $oldShare = (int) max(1, $process->share_percent);
            $startedAt = $process->started_at ?? $now;

            $elapsedReal = max(0, $now->diffInSeconds($startedAt));
            $elapsedIdeal = (int) floor($elapsedReal * ($oldShare / 100));

            $remainingIdeal = max(0, $process->ideal_seconds - $elapsedIdeal);

            if ($remainingIdeal <= 0) {
                $process->status = 'completed';
                $process->completed_at = $now;
                $process->ends_at = $now;
                $process->share_percent = $newShare;
                $process->save();
                continue;
            }

            $newRemainingReal = (int) ceil($remainingIdeal * (100 / $newShare));
            $process->share_percent = $newShare;
            $process->ends_at = $now->copy()->addSeconds($newRemainingReal);
            $process->save();
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

    public function applyCpuProcessEffects(UserProcess $p, NetworkLogService $logs): void {
        if ($p->action !== 'log') return;

        $m = $p->metadata ?? [];
        $networkId = $m['network_id'] ?? null;
        $baseHash  = $m['base_hash'] ?? null;

        if (!$networkId || !$baseHash) {
            $p->status = 'failed';
            $p->save();
            return;
        }

        // Use payload_text if present, else fallback to metadata (not recommended)
        $content = $p->payload_text ?? ($m['content'] ?? null);
        if ($content === null) {
            $p->status = 'failed';
            $p->save();
            return;
        }

        // This is your existing safe-save (checks expected hash)
        $logs->saveEdited(
            networkId: (int) $networkId,
            actorId: (int) $p->user_id,
            newContent: $content,
            expectedBaseHash: $baseHash
        );
    }

}
