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

    public function hardware() {
        return $this->belongsTo(HardwareParts::class, 'hardware_id');
    }
}
