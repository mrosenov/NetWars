<?php

namespace App\Models;

use App\Http\Controllers\HardwarePartsController;
use Illuminate\Database\Eloquent\Model;

class NPC extends Model
{
    protected $fillable = [
        'server_id',
        'hardware_id',
        'service_id',
    ];
    protected $table = 'npc';

    protected $casts = [
        'metadata' => 'array',
    ];

    public function servers() {
        return $this->morphMany(Servers::class, 'owner');
    }

    public function resources() {
        return $this->morphMany(ServerResources::class, 'owner');
    }

    public function network() {
        return $this->morphOne(UserNetwork::class, 'owner');
    }

    public function connectivity() {
        return $this->network->connectivity;
    }

    public function software(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(ServerSoftwares::class, 'owner');
    }

    public function TotalStorage() {
        $resources = $this->resources()->with('hardware')->get();

        $storage = 0;

        foreach ($resources as $resource) {
            $hardware = $resource->hardware;

            if (!$hardware || $hardware->type !== 'disk') continue;

            $spec = $hardware->specifications ?? [];
            $storage += (float) data_get($spec, 'capacity_gb', 0);
        }

        if ($storage < 1) {
            $unit = 'MB';
            $storage = round($storage * 1000);
        }
        elseif ($storage < 1000) {
            $unit = 'GB';
        }
        else {
            $storage = round($storage / 1000,1);
            $unit = 'TB';
        }

        return [
            'capacity' => $storage,
            'unit' => $unit,
        ];

    }

    public function TotalUsedStorage()
    {
        $size = 0;

        foreach ($this->software as $soft) {
            $size += $soft->size; // MB
        }

        if ($size < 1000) {
            $unit = 'MB';
        } elseif ($size < 1000 * 1000) {
            $unit = 'GB';
            $size = round($size / 1000, 2);
        } else {
            $unit = 'TB';
            $size = round($size / (1000 * 1000), 2);
        }

        return [
            'totalUsed' => $size,
            'unit' => $unit,
        ];
    }


    public function OverallResources(): array
    {
        // Make sure we don't N+1 query hardware_parts
        $resources = $this->resources()->with('hardware')->get();

        // Sum in base units
        $totals = [
            'clock_ghz' => 0.0,
            'ram_gb' => 0.0,
            'psu_w' => 0.0,
            'disk_gb' => 0.0,
        ];

        foreach ($resources as $resource) {
            $hw = $resource->hardware;

            if (!$hw) {
                continue;
            }

            // Exclude motherboard
            if ($hw->type === 'motherboard') {
                continue;
            }

            $spec = is_array($hw->specifications) ? $hw->specifications : (array) $hw->specifications;

            switch ($hw->type) {
                case 'cpu':
                    $mhz = (float) (data_get($spec, 'clock_ghz') ?? 0);
                    $totals['clock_ghz'] += $mhz;
                    break;

                case 'ram':
                    $mb = (int) (data_get($spec, 'capacity_mb') ?? 0);
                    $totals['ram_gb'] += $mb;
                    break;

                case 'psu':
                    $mb = (int) (data_get($spec, 'max_power_w') ?? 0);
                    $totals['psu_w'] += $mb;
                    break;

                case 'disk':
                    $mb = (float) (data_get($spec, 'capacity_gb') ?? 0);
                    $totals['disk_gb'] += $mb;
                    break;

            }
        }

        $connectivity = $this->connectivity();

        $hw = new HardwarePartsController();
        $connectivityInfo = $hw->prettyNetwork(data_get($connectivity->specifications, 'connectivity_mbps'));

        $hw = new HardwarePartsController();
        return [
            'CPU' => $hw->prettyCpu($totals['clock_ghz']),
            'RAM' => $hw->prettyRAM($totals['ram_gb']),
            'PSU' => $hw->prettyPSU($totals['psu_w']),
            'Disk' => $hw->prettyStorage($totals['disk_gb']),
            'Connectivity' => $connectivityInfo,
        ];
    }

}
