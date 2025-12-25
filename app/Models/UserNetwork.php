<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
