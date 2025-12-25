<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConnectivity extends Model
{

    protected $fillable = ['service_id'];

    public function owner(): \Illuminate\Database\Eloquent\Relations\MorphTo {
        return $this->morphTo();
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(HardwareParts::class, 'service_id');
    }
}
