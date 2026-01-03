<?php

namespace App\Http\Controllers;

use App\Models\ServerSoftwares;
use Illuminate\Http\Request;

class TargetController extends Controller
{

    public function index() {
        $user = auth()->user();
        $target = $user->connectedNetwork();

        return view('pages.target.index', [
            'target' => $target,
            'user' => $user,
        ]);
    }

    public function software() {
        $user = auth()->user();
        $targetNetwork = $user?->connectedNetwork();

        if (!$targetNetwork) {
            return redirect('internet');
        }

        $target = $targetNetwork->owner;

        $totalArr = $target->TotalStorage();
        $usedArr = $target->TotalUsedStorage();

        $totalMb = $this->toMb((float) ($totalArr['capacity'] ?? 0), (string) ($totalArr['unit'] ?? 'MB'));
        $usedMb = $this->toMb((float) ($usedArr['totalUsed'] ?? 0), (string) ($usedArr['unit'] ?? 'MB'));

        $percentageStorage = 0;

        if ($totalMb > 0) {
            $percentageStorage = round(min(($usedMb / $totalMb) * 100, 100), 2);
        }

        $color = '000000';
        if ($percentageStorage < 50) {
            $color = '16a34a';
        }
        elseif ($percentageStorage > 50 && $percentageStorage < 75) {
            $color = 'fff000';
        }
        elseif ($percentageStorage > 75) {
            $color = 'a31616';
        }

        $circleChart = [
            'PercentageStorage' => $percentageStorage,
            'ChartColor' => $color,
        ];

        $TargetUsage = [
            'totalStorage' => $totalArr,
            'usedStorage' => $usedArr,
            'circleChart' => $circleChart,
        ];

        return view('pages.target.software', [
            'targetNetwork' => $targetNetwork,
            'user' => $user,
            'TargetUsage' => $TargetUsage,
            'software' => $target->software,
            'targetNetTotalsMb' => $this->getTargetNetTotals(),
        ]);
    }

    public function getTargetNetTotals() {

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


    public function download(ServerSoftwares $software) {
        $user = auth()->user();

        $copy = $software->replicate();
        $copy->owner()->associate($user);
        $copy->save();

        return redirect()->back()->with('success', 'Software downloaded successfully.');
    }

    public function logout() {
        $user = auth()->user();
        $user->network()->update([
            'connected_to_network_id' => null,
        ]);

        return redirect()->route('internet.index')->with('logout_ok', 'Logged out successfully.');
    }
}
