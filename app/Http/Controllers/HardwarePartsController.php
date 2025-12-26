<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardwarePartsController extends Controller
{
    public function prettyCpu(float $ghz): array {
        if ($ghz < 1) {
            return ['value' => round($ghz * 1000), 'unit' => 'MHz'];
        }
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
            return ['value' => round($mbps / 1000, 1), 'unit' => 'Gbit/s'];
        }
        return ['value' => round($mbps, 0), 'unit' => 'MBit/s'];
    }

    public function prettyRAM(int $mb): array {
        if ($mb < 1024) {
            return [
                'value' => $mb,
                'unit'  => 'MB'
            ];
        }

        if ($mb < 1024 * 1024) {
            return [
                'value' => round($mb / 1024, 1),
                'unit'  => 'GB'
            ];
        }

        return [
            'value' => round($mb / (1024 * 1024), 1),
            'unit'  => 'TB'
        ];
    }

    public function prettyStorage(float $gb): array
    {
        if ($gb < 1) {
            return [
                'value' => round($gb * 1000),
                'unit'  => 'MB'
            ];
        }

        if ($gb < 1000) {
            return [
                'value' => $gb == (int)$gb ? (int)$gb : round($gb, 1),
                'unit'  => 'GB'
            ];
        }

        $value = $gb / 1000;

        return [
            'value' => $value == (int)$value ? (int)$value : round($value, 1),
            'unit'  => 'TB'
        ];
    }
}
