<?php

namespace App\Support;

class Format
{
    public static function ram(int|float $mb, int $precision = 2): array
    {
        if ($mb >= 1000) {
            return [
                'value' => round($mb / 1000, $precision),
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
