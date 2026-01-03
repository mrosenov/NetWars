<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkLogfile extends Model
{
    protected $table = 'network_logfiles';
    protected $primaryKey = 'network_id';
    public $incrementing = false;

    protected $fillable = [
        'network_id','content','tamper_count','last_tampered_at'
    ];

    protected $casts = [
        'last_tampered_at' => 'datetime',
    ];
}
