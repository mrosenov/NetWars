<?php

namespace App\Http\Controllers;

use App\Models\ServerSoftwares;
use App\Support\Format;
use Illuminate\Http\Request;

class TargetController extends Controller
{

    public function index() {
        return redirect()->route('target.logs');
    }

    public function software() {
        $hacker = auth()->user();
        $targetNetwork = $hacker?->connectedNetwork();

        if (!$targetNetwork) {
            return redirect('internet');
        }

        $victim = $targetNetwork->owner;
        $software = $victim->software()->orderBy('type')->orderByDesc('version')->get();

        // Used disk = sum sizes (MB)
        $storageUsedMb = (int) $software->sum('size');

        // Total disk across all owned servers
        $storageTotalMb = (int) $victim->totalStorageMb();

        // Free disk
        $storageFreeMb = max(0, $storageTotalMb - $storageUsedMb);

        // Percent used for UI
        $pct = $storageTotalMb > 0 ? (int) round(($storageUsedMb / $storageTotalMb) * 100) : 0;
        $pct = max(0, min(100, $pct));

        // Connectivity
        $connectivity = Format::connectivityHuman($targetNetwork->connectivity->specifications['connectivity_mbps']);
        $net = $this->getNetTotals();
        $down = Format::netSpeedHuman($net['down_mbps']);
        $up = Format::netSpeedHuman($net['up_mbps']);

        return view('pages.target.software', [
            'hacker' => $hacker,
            'network' => $targetNetwork,
            'victim' => $victim,
            'software' => $software,

            // raw MB values (good for calculations)
            'storageUsedMb' => $storageUsedMb,
            'storageTotalMb' => $storageTotalMb,
            'storageFreeMb' => $storageFreeMb,
            'pct' => $pct,

            // formatted for display
            'storageUsed' => Format::storageHuman($storageUsedMb),
            'storageTotal' => Format::storageHuman($storageTotalMb),
            'storageFree' => Format::storageHuman($storageFreeMb),

            // Internet
            'connectivity' => $connectivity,
            'download' => $down,
            'upload' => $up,
        ]);

//        $target = $targetNetwork->owner;
//
//        $totalArr = $target->TotalStorage();
//        $usedArr = $target->TotalUsedStorage();
//
//        $totalMb = $this->toMb((float) ($totalArr['capacity'] ?? 0), (string) ($totalArr['unit'] ?? 'MB'));
//        $usedMb = $this->toMb((float) ($usedArr['totalUsed'] ?? 0), (string) ($usedArr['unit'] ?? 'MB'));
//
//        $percentageStorage = 0;
//
//        if ($totalMb > 0) {
//            $percentageStorage = round(min(($usedMb / $totalMb) * 100, 100), 2);
//        }
//
//        $color = '000000';
//        if ($percentageStorage < 50) {
//            $color = '16a34a';
//        }
//        elseif ($percentageStorage > 50 && $percentageStorage < 75) {
//            $color = 'fff000';
//        }
//        elseif ($percentageStorage > 75) {
//            $color = 'a31616';
//        }
//
//        $circleChart = [
//            'PercentageStorage' => $percentageStorage,
//            'ChartColor' => $color,
//        ];
//
//        $TargetUsage = [
//            'totalStorage' => $totalArr,
//            'usedStorage' => $usedArr,
//            'circleChart' => $circleChart,
//        ];

//        return view('pages.target.software', [
//            'network' => $targetNetwork,
//            'user' => $user,
//            'TargetUsage' => $TargetUsage,
//            'software' => $target->software,
//            'targetNetTotalsMb' => $this->getTargetNetTotals(),
//        ]);
    }

    public function getNetTotals() {

        $user = auth()->user();
        $hwService = $user->connectedNetwork()->connectivity;

        $spec = is_array($hwService->specifications) ? $hwService->specifications : (array) $hwService->specifications;
        $connectivity = $spec['connectivity_mbps'];

        $downMbps = max(0.0001, $connectivity / 8);
        $upMbps = max(0.0001, $connectivity / 16);

        return [
            'down_mbps' => max(0, $downMbps),
            'up_mbps'   => max(0, $upMbps),
        ];
    }

    private function toMb(float $value, string $unit): float {
        $unit = strtoupper(trim($unit));

        return match ($unit) {
            'MB' => $value,
            'GB' => $value * 1000,
            'TB' => $value * 1000 * 1000,
            default => $value,
        };
    }


    public function logout() {
        $user = auth()->user();
        $user->network()->update([
            'connected_to_network_id' => null,
        ]);

        return redirect()->route('internet.index')->with('logout_ok', 'Logged out successfully.');
    }
}
