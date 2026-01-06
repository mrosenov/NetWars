<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerSoftwares extends Model
{
    protected $table = 'software';

    protected $fillable = ['id',
        'user_id',
        'software_id'
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function owner() {
        return $this->morphTo();
    }

    public function isRunning():bool {
        return RunningSoftware::where('software_id', $this->id)->exists();
    }

    public function runningInstance() {
        return $this->hasOne(RunningSoftware::class, 'software_id');
    }

    public function convertSize() {
        $size = 0;

        $unit = '';
        if ($this->size > 1000) {
            $size = round($this->size / 1000, 2);
            $unit = 'GB';
        }
        elseif ($this->size < 1000) {
            $size = round($this->size, 2);
            $unit = 'MB';
        }

        return [
            'size' => $size,
            'unit' => $unit
        ];
    }
}
