<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NPC extends Model
{
    protected $table = 'npc';

    protected $casts = [
        'metadata' => 'array',
    ];

    public function network() {
        return $this->morphOne(UserNetwork::class, 'owner');
    }
}
