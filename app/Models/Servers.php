<?php

namespace App\Models;

use App\Http\Controllers\UserProcessController;
use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
        'name', 'owner_type', 'user_id', 'npc_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function owner() {
        return $this->morphTo();
    }

    public function softwares(): \Illuminate\Database\Eloquent\Relations\HasMany|Servers {
        return $this->hasMany(ServerSoftwares::class);
    }

    public function resources(): \Illuminate\Database\Eloquent\Relations\HasMany|Servers {
        return $this->hasMany(ServerResources::class, 'server_id');
    }

    public function network() {
        return $this->morphOne(UserNetwork::class, 'owner');
    }

    public function getResourceTotalsAttribute(): array
    {
        $this->loadMissing('resources.hardware');

        $resources = $this->resources;

        $totals = [
            'clock_mhz' => 0,
            'ram_mb' => 0,
            'storage_mb' => 0,
            'cpu_compute' => 0,
            'stability' => 0,
            'power_supply' => 0,
        ];

        foreach ($resources as $resource) {
            $hw = $resource->hardware;
            if (!$hw) continue;
            if ($hw->type === 'motherboard') continue;

            $spec = $hw->specifications ?? [];

            if ($hw->type === 'ram') {
                $totals['ram_mb'] += (int) data_get($spec, 'capacity_mb', 0);
            }

            if ($hw->type === 'disk') {
                $totals['storage_mb'] += (float) ($spec['capacity_mb'] ?? 0);
            }

            if ($hw->type === 'cpu') {
                $totals['clock_mhz'] += (float) ($spec['clock_mhz'] ?? 0);
                $totals['cpu_compute'] += (int) ($spec['compute_power'] ?? 0);
            }

            $totals['stability'] = max($totals['stability'], (int) ($spec['stability'] ?? 0));
            $totals['power_supply'] = max($totals['power_supply'], (int) ($spec['max_power_w'] ?? 0));
        }

        return $totals;
    }
}
