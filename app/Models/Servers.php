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

    public function getResourceTotalsAttribute(): array {
        $resources = $this->relationLoaded('resources') ? $this->resources : $this->resources()->with('hardware')->get();

        $totals = [
            'ram_mb' => 0,
            'storage_gb' => 0,
            'down_mbps' => 0.0,
            'up_mbps' => 0.0,
            'cpu_compute' => 0,
            'stability' => 0,
        ];

        $net = app()->make(UserProcessController::class)->getUserNetTotals();

        $totals['down_mbps'] += (float) ($net['down_mbps'] ?? 0);
        $totals['up_mbps'] += (float) ($net['up_mbps'] ?? 0);

        foreach ($resources as $resource) {

            $hw = $resource?->hardware ?? null;

            if ($hw->type === 'motherboard') continue;

            $spec = $hw?->specifications ?? [];

            $totals['ram_mb'] += (int) ($spec['capacity_mb'] ?? 0);
            $totals['storage_gb'] += (int) ($spec['capacity_gb'] ?? 0);

            $totals['cpu_compute'] += (int) ($spec['compute_power'] ?? 0);

            // simple approach: take max stability among parts (or compute weighted)
            $totals['stability'] = max($totals['stability'], (int) ($spec['stability'] ?? 0));
        }

        return $totals;
    }
}
