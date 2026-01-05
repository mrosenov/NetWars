<?php

namespace App\Support;

class Format
{
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
}
