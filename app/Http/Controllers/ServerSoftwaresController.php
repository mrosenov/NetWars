<?php

namespace App\Http\Controllers;

use App\Models\ServerSoftwares;
use Illuminate\Http\Request;

class ServerSoftwaresController extends Controller
{
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
