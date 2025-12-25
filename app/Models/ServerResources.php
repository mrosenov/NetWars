<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerResources extends Model
{
    protected $fillable = [
        'server_id',
        'hardware_id',
        'user_id',
        'npc_id',
    ];

    public function owner() {
        return $this->morphTo();
    }

    public function server() {
        return $this->belongsTo(Servers::class, 'server_id');
    }

    public function hardware() {
        return $this->belongsTo(HardwareParts::class, 'hardware_id');
    }
}
