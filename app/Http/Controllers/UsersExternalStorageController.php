<?php

namespace App\Http\Controllers;

use App\Models\ExternalSoftware;
use App\Models\ServerSoftwares;
use App\Models\UserProcess;
use App\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersExternalStorageController extends Controller
{

    public function index() {
        $hacker = auth()->user();
        $software = $hacker->externalSoftware()->orderBy('type')->orderByDesc('version')->get();

        $externalStorageUsedMb = (int) $software->sum('size');

        // Total external disk assigned to user
        $externalStorageTotalMb = (int) $hacker->totalExternalStorageMb();

        // Free disk
        $externalStorageFreeMb = max(0, $externalStorageTotalMb - $externalStorageUsedMb);

        // Percent used for UI
        $pct = $externalStorageTotalMb > 0 ? (int) round(($externalStorageUsedMb / $externalStorageTotalMb) * 100) : 0;
        $pct = max(0, min(100, $pct));

        return view('pages.software.external', [
            'hacker' => $hacker,
            'software' => $software,

            // raw MB values (good for calculations)
            'storageUsedMb' => $externalStorageUsedMb,
            'storageTotalMb' => $externalStorageTotalMb,
            'storageFreeMb' => $externalStorageFreeMb,
            'pct' => $pct,

            // formatted for display
            'storageUsed' => Format::storageHuman($externalStorageUsedMb),
            'storageTotal' => Format::storageHuman($externalStorageTotalMb),
            'storageFree' => Format::storageHuman($externalStorageFreeMb),
        ]);
    }

    public function copy(ExternalSoftware $software) {
        $hacker = auth()->user();

        if (!$software) {
            abort(404, 'Software not found.');
        }

        $sizeMb = (float) $software->size;
        $availableMb = $hacker->availableStorageMb();

        $diskSpeed = $hacker->externalStorage->hardware->specifications['access_speed'];

        if ($software->size > $availableMb) {
            abort(403, 'You do not have enough storage space.');
        }

        $alreadyOwned = ServerSoftwares::query()
            ->where('owner_type', \App\Models\User::class)
            ->where('owner_id', $hacker->id)
            ->where('type', $software->type)
            ->where('version', $software->version)
            ->exists();

        if ($alreadyOwned) {
            return redirect()->route('software.index')->with('error', 'You already own this software.');
        }

        return DB::transaction(function () use ($hacker, $software, $sizeMb, $diskSpeed) {

            $duration = app(UserProcessController::class)->calculateProcessDuration('copy', ['size_mb' => $sizeMb, 'access_speed' => $diskSpeed]);
            $now = now();

            $process = UserProcess::create([
                'user_id' => $hacker->id,
                'resource_type' => 'disk',
                'action' => 'copy',
                'metadata' => [
                    'external_software_id' => $software->id,
                    'target_network_id' => $hacker->network->id,
                    'external_software_name' => $software->name,
                    'size_mb' => (float) $software->size,
                ],
                'work_units' => 0,
                'ideal_seconds' => $duration,
                'remaining_ideal_seconds' => $duration,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration),
            ]);

            // TODO: Apply disk effect to divide speed maybe?

            return redirect()->route('tasks.index');
        });
    }

    public function backup(ServerSoftwares $software) {
        $hacker = auth()->user();

        if (!$software) {
            abort(404, 'Software not found.');
        }

        $alreadyOwned = ExternalSoftware::query()
            ->where('owner_type', \App\Models\User::class)
            ->where('owner_id', $hacker->id)
            ->where('type', $software->type)
            ->where('version', $software->version)
            ->exists();

        if ($alreadyOwned) {
            return redirect()->route('software.index')->with('error', 'You already have a backup of this software.');
        }

        $sizeMb = (float) $software->size;

        $availableMb = $hacker->availableExternalStorageMb();

        if ($software->size > $availableMb) {
            abort(403, 'You do not have enough storage space.');
        }

        $diskSpeed = $hacker->externalStorage->hardware->specifications['access_speed'];

        return DB::transaction(function () use ($hacker, $software, $sizeMb, $diskSpeed) {

            $duration = app(UserProcessController::class)->calculateProcessDuration('backup', ['size_mb' => $sizeMb, 'access_speed' => $diskSpeed]);
            $now = now();

            $process = UserProcess::create([
                'user_id' => $hacker->id,
                'resource_type' => 'disk',
                'action' => 'backup',
                'metadata' => [
                    'software_id' => $software->id,
                    'target_network_id' => $hacker->network->id,
                    'software_name' => $software->name,
                    'size_mb' => (float) $software->size,
                ],
                'work_units' => 0,
                'ideal_seconds' => $duration,
                'remaining_ideal_seconds' => $duration,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration),
            ]);

            // TODO: Apply disk effect to divide speed maybe?

            return redirect()->route('tasks.index');
        });
    }

    public function destroy(Request $request, ExternalSoftware $software) {
        $hacker = $request->user();

        $sizeMb = (float) $software->size;
        $diskSpeed = $hacker->externalStorage->hardware->specifications['access_speed'];

        return DB::transaction(function () use ($hacker, $software, $sizeMb, $diskSpeed) {

            $duration = app(UserProcessController::class)->calculateProcessDuration('ex_delete', ['size_mb' => $sizeMb, 'access_speed' => $diskSpeed]);
            $now = now();

            $process = UserProcess::create([
                'user_id' => $hacker->id,
                'resource_type' => 'disk',
                'action' => 'delete',
                'metadata' => [
                    'external_software_id' => $software->id,
                    'target_network_id' => $hacker->network->id,
                    'software_name' => $software->name,
                    'size_mb' => (float) $software->size,
                ],
                'work_units' => 0,
                'ideal_seconds' => $duration,
                'remaining_ideal_seconds' => $duration,
                'last_progress_at' => $now,
                'cpu_power_snapshot' => 0,
                'share_percent' => 100,
                'status' => 'running',
                'started_at' => $now,
                'ends_at' => $now->copy()->addSeconds($duration),
            ]);

            // TODO: Apply disk effect to divide speed maybe?

            return redirect()->route('tasks.index');
        });

    }
}
