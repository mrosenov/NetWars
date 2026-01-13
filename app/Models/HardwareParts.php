<?php

namespace App\Models;

use App\Support\Format;
use Illuminate\Database\Eloquent\Model;

class HardwareParts extends Model
{
    protected $casts = [
        'specifications' => 'array',
        'requirements'   => 'array',
    ];

    public function getSpecsLabelAttribute(): string {
        $s = $this->specifications ?? [];

        $parts = [];

        if ($this->type === 'motherboard') {

            if (!empty($s['socket'])) {
                $parts[] = $s['socket'];
            }

            if (!empty($s['ram_type'])) {
                $parts[] = $s['ram_type'];
            }

//            if (!empty($s['max_ram_mb'])) {
//                $mb = Format::ramHuman($s['max_ram_mb']);
//                $parts[] = $mb.' RAM';
//            }

            if (!empty($s['max_cpu_tier'])) {
                $parts[] = 'CPU Tier '.$s['max_cpu_tier'];
            }

            if (!empty($s['stability_bonus'])) {
                $parts[] = $s['stability_bonus'].'% stab';
            }

        }
        elseif ($this->type === 'cpu') {

            if (!empty($s['tier'])) {
                $parts[] = 'Tier '.$s['tier'];
            }

            if (!empty($s['cores'])) {
                $parts[] = $s['cores'] . ' cores';
            }

            if (!empty($s['clock_mhz'])) {
                $parts[] = rtrim(number_format($s['clock_mhz'] / 1000, 2), '0.') . ' GHz';
            }

            if (!empty($s['compute_power'])) {
                $parts[] = $s['compute_power'] . ' CP';
            }

            if (!empty($s['power_draw_w'])) {
                $parts[] = $s['power_draw_w'] . ' W';
            }

            if (!empty($s['stability'])) {
                $parts[] = $s['stability'] . '% stab';
            }

        }
        elseif ($this->type === 'ram') {
            if (!empty($s['tier'])) {
                $parts[] = 'Tier '.$s['tier'];
            }

//            if (!empty($s['ram_type'])) {
//                $parts[] = $s['ram_type'];
//            }

            if (!empty($s['speed_mhz'])) {
                $parts[] = Format::cpuHuman($s['speed_mhz']);
            }

            if (!empty($s['stability'])) {
                $parts[] = $s['stability'].'% stab';
            }

            if (!empty($s['capacity_mb'])) {
                $parts[] = Format::ramHuman($s['capacity_mb']);
            }

            if (!empty($s['power_draw_w'])) {
                $parts[] = Format::wattHuman($s['power_draw_w']);
            }
        }
        elseif ($this->type === 'psu') {
            if (!empty($s['tier'])) {
                $parts[] = 'Tier '.$s['tier'];
            }
            if (!empty($s['efficiency'])) {
                $parts[] = 'Efficiency '.$s['efficiency'];
            }
            if (!empty($s['max_power_w'])) {
                $parts[] = Format::wattHuman($s['max_power_w']);
            }
            if (!empty($s['stability_bonus'])) {
                $parts[] = $s['stability_bonus'].'% stab';
            }
        }
        elseif ($this->type === 'disk') {
            if (!empty($s['tier'])) {
                $parts[] = 'Tier '.$s['tier'];
            }
            if (!empty($s['speed'])) {
                $parts[] = Format::diskSpeedHuman($s['speed']);
            }
        }
        elseif ($this->type === 'network') {
            if (!empty($s['tier'])) {
                $parts[] = 'Tier '.$s['tier'];
            }
            if (!empty($s['max_connections'])) {
                $parts[] = $s['max_connections'].' Servers';
            }
            if (!empty($s['bandwidth_mbps'])) {
                $parts[] = Format::netSpeedHuman($s['bandwidth_mbps']);
            }
        }

        return implode(' · ', $parts);
    }

    public function getReqsLabelAttribute(): string {
        $s = $this->requirements ?? [];

        $parts = [];

        if ($this->type === 'cpu') {
            if (!empty($s['socket'])) {
                $parts[] = $s['socket'];
            }
        }
        elseif ($this->type === 'ram') {
            if (!empty($s['ram_type'])) {
                $parts[] = $s['ram_type'];
            }
        }

        return implode(' · ', $parts);
    }
}
