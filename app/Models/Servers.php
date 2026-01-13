<?php

namespace App\Models;

use App\Http\Controllers\UserProcessController;
use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
        'owner_type', 'user_id', 'npc_id', 'meta'
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
        $resources = $this->relationLoaded('resources')
            ? $this->resources
            : $this->resources()->with('hardware')->get();

        $totals = [
            'clock_mhz' => 0,
            'ram_mb' => 0,
            'storage_mb' => 0,
            'cpu_compute' => 0,
            'stability' => 0,
        ];


        foreach ($resources as $resource) {
            $hw = $resource?->hardware;
            if (!$hw) continue;
            if ($hw->type === 'motherboard') continue;

            $spec = $hw->specifications ?? [];

            $totals['clock_mhz'] += (float) ($spec['clock_mhz'] ?? 0);
            if ($hw->type === 'ram') {
                $totals['ram_mb'] += (int) ($spec['capacity_mb'] ?? 0);
            }


            // Disk: capacity_gb -> MB
            if ($hw->type === 'disk') {
                $totals['storage_mb'] += (float)$spec['capacity_mb'] ?? 0;
            }


            $totals['cpu_compute'] += (int) ($spec['compute_power'] ?? 0);
            $totals['stability'] = max($totals['stability'], (int) ($spec['stability'] ?? 0));
        }

        return $totals;
    }
}
