<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersExternalStorage extends Model
{
    public function hardware() {
        return $this->belongsTo(HardwareParts::class, 'hardware_id');
    }
}
