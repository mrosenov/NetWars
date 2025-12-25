<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardwarePartsController extends Controller
{
    public function prettyCpu(float $ghz): array {
        return ['value' => round($ghz, 1), 'unit' => 'GHz'];
    }

    public function prettyPSU(int $watts): array {
        if ($watts < 1000) {
            return ['value' => $watts, 'unit' => 'Watt'];
        }

        return ['value' => $watts, 'unit' => 'kW'];
    }

    public function prettyNetwork(int $mbps): array {
        if ($mbps >= 1000) {
            return ['value' => round($mbps / 1, 1), 'unit' => 'Gbps'];
        }
        return ['value' => round($mbps, 0), 'unit' => 'Mbps'];
    }

    public function prettyStorage(int $gb): array {
        if ($gb < 1000) {
            return ['value' => $gb, 'unit' => 'GB'];
        }

        return ['value' => round($gb / 1000,1), 'unit' => 'TB'];
    }
}
