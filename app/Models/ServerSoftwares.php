<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerSoftwares extends Model
{
    protected $table = 'software';

    protected $fillable = ['id'];

    public function owner() {
        return $this->morphTo();
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
