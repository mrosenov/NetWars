<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NPC extends Model
{
    protected $fillable = [
        'server_id',
        'hardware_id',
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
}
