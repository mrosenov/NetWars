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

    public function hackedNetwork() {
        return $this->hasOne(HackedNetworks::class, 'network_id');
    }

    public function isHacked(): bool {
        return $this->hackedNetwork()->exists();
    }

    public function runningSoftware() {
        return $this->hasMany(RunningSoftware::class, 'network_id');
    }

    public function cracker() {
        return $this->hasOneThrough(ServerSoftwares::class, RunningSoftware::class, 'network_id', 'id', 'id', 'software_id')
            ->where('software.type', 'crc')
            ->orderByDesc('software.version');
    }

    public function hasher() {
        return $this->hasOneThrough(ServerSoftwares::class, RunningSoftware::class, 'network_id', 'id', 'id', 'software_id')
            ->where('software.type', 'hash')
            ->orderByDesc('software.version');
    }
}
