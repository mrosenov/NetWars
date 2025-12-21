<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
        'owner_type', 'user_id', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function softwares(): \Illuminate\Database\Eloquent\Relations\HasMany|Servers {
        return $this->hasMany(ServerSoftwares::class);
    }

    public function resources(): \Illuminate\Database\Eloquent\Relations\HasMany|Servers {
        return $this->hasMany(ServerResources::class, 'server_id');
    }

}
