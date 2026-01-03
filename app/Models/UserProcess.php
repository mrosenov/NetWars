<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProcess extends Model
{
    //
    protected $fillable = [
        'user_id',
        'resource_type',
        'action',
        'metadata',
        'work_units',
        'ideal_seconds',
        'cpu_power_snapshot',
        'share_percent',
        'status',
        'started_at',
        'ends_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
