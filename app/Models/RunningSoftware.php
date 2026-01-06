<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunningSoftware extends Model
{
    protected $fillable = [
        'software_id',
        'network_id',
    ];

    public function software() {
        return $this->belongsTo(ServerSoftwares::class, 'software_id');
    }

    public function getUsageAttribute(): int {
        return (int) ($this->software->requirements['ram_mb'] ?? 0);
    }

    public function getUsageFormattedAttribute(): array {
        $mb = $this->usage;

        if ($mb >= 1024) {
            return [
                'value' => round($mb / 1024, 2),
                'unit'  => 'GB',
            ];
        }

        return [
            'value' => $mb,
            'unit'  => 'MB',
        ];
    }
}
