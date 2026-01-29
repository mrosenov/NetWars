<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserNetwork extends Model
{
    //
    protected $fillable = [
        'user_id',
        'npc_id',
        'hardware_id',
        'ip',
        'user',
        'password',
        'connectivity_id',
        'connected_to_network_id',
    ];

    protected array $bestSoftwareCache = [];

    public function owner() {
        return $this->morphTo();
    }

    public function connected() {
        return $this->belongsTo(UserNetwork::class, 'connected_to_network_id');
    }

    public function hardware() {
        return $this->belongsTo(HardwareParts::class, 'hardware_id');
    }

    public function connectivity() {
        return $this->belongsTo(HardwareParts::class, 'connectivity_id');
    }

    public function software() {
        return $this->hasMany(ServerSoftwares::class, 'network_id');
    }


    public function runningSoftware() {
        return $this->hasMany(RunningSoftware::class, 'network_id');
    }

    public function bestRunningSoftwareByType(string $type): ?ServerSoftwares {
        if (array_key_exists($type, $this->bestSoftwareCache)) {
            return $this->bestSoftwareCache[$type];
        }

        $softwareTable = (new ServerSoftwares)->getTable();
        $runningTable  = (new RunningSoftware)->getTable();

        return $this->bestSoftwareCache[$type] = ServerSoftwares::query()
            ->select("{$softwareTable}.*")
            ->join($runningTable, "{$runningTable}.software_id", '=', "{$softwareTable}.id")
            ->where("{$runningTable}.network_id", $this->id)
            ->where("{$softwareTable}.type", $type)
            ->orderByDesc("{$softwareTable}.version")
            ->first();
    }

    public function hasher(): ?ServerSoftwares {
        return $this->bestRunningSoftwareByType('hash');
    }

    public function cracker(): ?ServerSoftwares
    {
        return $this->bestRunningSoftwareByType('crc');
    }

}
