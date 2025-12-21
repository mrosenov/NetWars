<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerResources extends Model
{
    protected $casts = [
        'value' => 'float',
        'meta'  => 'json',
    ];

    /**
     * Normalized numeric value (GHz / GB / Gbit)
     */
    public function getNormalizedValueAttribute(): float {
        return match ($this->type) {
            'cpu'     => round($this->value / 1000, 2), // MHz → GHz
            'ram'     => round($this->value / 1024, 2), // MB → GB
            'disk'    => round($this->value / 1024, 2), // MB → GB
            'network' => round($this->value / 1024, 2), // Mbps → Gbps
            default   => (float) $this->value,
        };
    }

    /**
     * Human unit label
     */
    public function getUnitAttribute(): string {
        return match ($this->type) {
            'cpu'     => 'GHz',
            'ram',
            'disk'    => 'GB',
            'network' => 'Gbps',
            default   => '',
        };
    }

    /**
     * Fully formatted value (for UI)
     * Example: "2.5 GHz", "8 GB"
     */
    public function getFormattedValueAttribute(): string {
        return $this->normalized_value . ' ' . $this->unit;
    }
}
