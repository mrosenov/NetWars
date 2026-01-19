<?php

namespace App\Models;

use App\Support\Format;
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

    public function getProcessorUsageAttribute(): int {
        return (int) ($this->software->requirements['clock_mhz'] ?? 0);
    }

    public function getProcessorUsageFormattedAttribute(): string {
        $mhz = $this->processor_usage;

        return Format::cpuHuman($mhz);
    }

    public function getRAMUsageAttribute(): int {
        return (int) ($this->software->requirements['ram_mb'] ?? 0);
    }

    public function getRAMUsageFormattedAttribute(): string {
        $mb = $this->ram_usage;

        return Format::ramHuman($mb);
    }
}
