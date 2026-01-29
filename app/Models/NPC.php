<?php

namespace App\Models;

use App\Http\Controllers\HardwarePartsController;
use App\Models\Concerns\HasStorage;
use Illuminate\Database\Eloquent\Model;

class NPC extends Model
{
    use HasStorage;
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

    public function totalStorageMb(): int {
        $totals = $this->totalResources();
        return (int) ($totals['storage_mb'] ?? 0);
    }

    public function totalResources(): array {
        $this->loadMissing('servers.resources.hardware');
        $servers = $this->servers;

        $totals = [
            'ram_mb' => 0,
            'storage_mb' => 0,
            'down_mbps' => 0.0,
            'up_mbps' => 0.0,
            'cpu_compute' => 0,
            'stability' => 0,
        ];

        foreach ($servers as $server) {
            $t = $server->resource_totals;

            $totals['ram_mb'] += (int) ($t['ram_mb'] ?? 0);
            $totals['storage_mb'] += (int) ($t['storage_mb'] ?? 0);
            $totals['down_mbps'] += (float) ($t['down_mbps'] ?? 0);
            $totals['up_mbps'] += (float) ($t['up_mbps'] ?? 0);
            $totals['cpu_compute'] += (int) ($t['cpu_compute'] ?? 0);
            $totals['stability'] = max($totals['stability'], (int) ($t['stability'] ?? 0));
        }

        return $totals;
    }

}
