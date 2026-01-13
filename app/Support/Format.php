<?php

namespace App\Support;

class Format
{

    public static function cpu(int|float $mhz, int $precision = 1): array
    {
        if ($mhz <= 0) {
            return [
                'value' => 0,
                'unit'  => 'MHz',
                'text'  => '0 MHz',
            ];
        }

        if ($mhz < 1000) {
            return [
                'value' => (int) $mhz,
                'unit'  => 'MHz',
                'text'  => (int) $mhz . ' MHz',
            ];
        }

        $ghz = $mhz / 1000;

        return [
            'value' => round($ghz, $precision),
            'unit'  => 'GHz',
            'text'  => round($ghz, $precision) . ' GHz',
        ];
    }

    public static function cpuHuman(int|float $mhz, int $precision = 1): string
    {
        $cpu = self::cpu($mhz, $precision);
        return $cpu['value'].' '.$cpu['unit'];
    }

    public static function watt(int|float $watt, int $precision = 2): array
    {
        if ($watt >= 1000) {
            return [
                'value' => round($watt / 1000, $precision),
                'unit'  => 'kW',
            ];
        }

        return [
            'value' => (int) $watt,
            'unit'  => 'Watts',
        ];
    }

    public static function wattHuman(int|float $watt, int $precision = 1): string
    {
        $watt = self::watt($watt, $precision);
        return $watt['value'].' '.$watt['unit'];
    }

    public static function ram(int|float $mb, int $precision = 2): array
    {
        if ($mb >= 1024) {
            return [
                'value' => round($mb / 1024, $precision),
                'unit'  => 'GB',
            ];
        }

        return [
            'value' => (int) $mb,
            'unit'  => 'MB',
        ];
    }

    public static function ramHuman(int|float $mb, int $precision = 2): string
    {
        $f = self::ram($mb, $precision);
        return $f['value'] . ' ' . $f['unit'];
    }

    public static function storage(int|float $mb, int $precision = 2): array
    {
        if ($mb >= 1000) {
            return ['value' => round($mb / 1000, $precision), 'unit' => 'GB'];
        }
        return ['value' => (int) $mb, 'unit' => 'MB'];
    }

    public static function storageHuman(int|float $mb, int $precision = 2): string
    {
        $f = self::storage($mb, $precision);
        return $f['value'] . ' ' . $f['unit'];
    }

    public static function diskSpeed(float $mbs, int $precision = 2): array {
        if ($mbs >= 1000) {
            return ['value' => round($mbs / 1000, $precision), 'unit' => 'Gb/s'];
        }
        return ['value' => (int) $mbs, 'unit' => 'MB/s'];
    }

    public static function diskSpeedHuman(float $mbs, int $precision = 2): string {
        $f = self::diskSpeed($mbs, $precision);
        return $f['value'] . ' ' . $f['unit'];
    }

    public static function netSpeed(float $mbps, int $precision = 2): array
    {
        if ($mbps >= 1000) {
            return [
                'value' => round($mbps / 1000, $precision),
                'unit'  => 'Gbps',
            ];
        }

        return [
            'value' => round($mbps, $precision),
            'unit'  => 'Mbps',
        ];
    }

    public static function netSpeedHuman(float $mbps, int $precision = 2): string
    {
        $f = self::netSpeed($mbps, $precision);
        return "{$f['value']} {$f['unit']}";
    }

    public static function connectivity(float|int $mbps, int $precision = 2): array
    {
        if ($mbps >= 1000) {
            return [
                'value' => round($mbps / 1000, $precision),
                'unit'  => 'Gbps',
            ];
        }

        return [
            'value' => (int) $mbps,
            'unit'  => 'Mbps',
        ];
    }

    public static function connectivityHuman(float|int $mbps, int $precision = 2): string
    {
        $f = self::connectivity($mbps, $precision);
        return "{$f['value']} {$f['unit']}";
    }
}
