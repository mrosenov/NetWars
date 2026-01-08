<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalSoftware extends Model
{
    protected $fillable = ['name', 'version', 'size', 'requirements'];

    protected $casts = [
        'requirements' => 'array',
    ];
    public function owner() {
        return $this->morphTo();
    }
}
