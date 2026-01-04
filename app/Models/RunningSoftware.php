<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunningSoftware extends Model
{
    public function software() {
        return $this->belongsTo(ServerSoftwares::class, 'software_id');
    }
}
