<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HardwareParts extends Model
{
    protected $casts = [
        'specifications' => 'array',
        'requirements'   => 'array',
    ];
}
