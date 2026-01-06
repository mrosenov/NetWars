<?php

namespace App\Http\Controllers;

use App\Models\ServerSoftwares;
use App\Support\Format;
use Illuminate\Http\Request;

class ServerSoftwaresController extends Controller
{

    public function index() {
        $hacker = auth()->user();

        // All software owned by user
        $software = $hacker->software()->orderBy('type')->orderByDesc('version')->get();

        // Used disk = sum sizes (MB)
        $storageUsedMb = (int) $software->sum('size');

        // Total disk across all owned servers
        $storageTotalMb = (int) $hacker->totalStorageMb();

        // Free disk
        $storageFreeMb = max(0, $storageTotalMb - $storageUsedMb);

        // Percent used for UI
        $pct = $storageTotalMb > 0 ? (int) round(($storageUsedMb / $storageTotalMb) * 100) : 0;
        $pct = max(0, min(100, $pct));


        return view('pages.software.index', [
            'hacker' => $hacker,
            'software' => $software,

            // raw MB values (good for calculations)
            'storageUsedMb' => $storageUsedMb,
            'storageTotalMb' => $storageTotalMb,
            'storageFreeMb' => $storageFreeMb,
            'pct' => $pct,

            // formatted for display
            'storageUsed' => Format::storage($storageUsedMb),
            'storageTotal' => Format::storage($storageTotalMb),
            'storageFree' => Format::storage($storageFreeMb),
        ]);
    }

    public function destroy(Request $request, ServerSoftwares $software) {
        $hacker = $request->user();

        $data = $request->validate([
            'target' => ['required', 'in:local,remote'],
        ]);

        $localNetwork = $hacker->network;

        if (!$localNetwork) {
            abort(404, 'Local network not found.');
        }

        if ($data['target'] === 'local') {
            $targetNetwork = $localNetwork;
        }
        else {
            $targetNetwork = $hacker->connectedNetwork();

            if (!$targetNetwork) {
                abort(404, 'No remote target network found.');
            }
        }

        app(UserProcessController::class)->start('delete', [
            'software_id' => $software->id,
            'target_network_id' => $targetNetwork->id,
            'size_mb' => $software->size,
        ]);

        return redirect()->route('tasks.index');

    }

    public function json(ServerSoftwares $software) {

        $spec = $software->requirements ?? [];

        $ramUsage = $this->convertRAMUsage(data_get($spec, 'ram_mb', 0));

        return response()->json([
            'name' => $software->name,
            'version' => $software->version,
            'license' => 'None',
            'type' => $software->type,
            'size' => $software->convertSize()['size'] . $software->convertSize()['unit'],
            'usage' => $ramUsage['value'].$ramUsage['unit'],
            'created' => $software->created_at?->format('Y-m-d H:i:s'),

        ]);
    }

    public function convertRAMUsage(float $mb): array {
        if ($mb < 1000) {
            return [
                'value' => $mb,
                'unit'  => 'MB'
            ];
        }

        if ($mb < 1024 * 1024) {
            return [
                'value' => round($mb / 1000, 1),
                'unit'  => 'GB'
            ];
        }

        return [
            'value' => round($mb / (1000 * 1000), 1),
            'unit'  => 'TB'
        ];
    }
}
