<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HardwarePartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hardware_parts')->insert([
            [
                'name' => 'Generic µATX Server Board',
                'type' => 'motherboard',
                'price' => 0,
                'specifications' => json_encode([
                    'socket' => 'GEN1',
                    'ram_slots' => 2,
                    'ram_type' => 'ddr2',
                    'max_ram_mb' => 512,
                    'hdd' => true,
                    'ssd' => false,
                    'nvme' => false,
                    'bandwidth_mbps' => 10
                ]),
                'requirements' => null,
            ],
            [
                'name' => 'Single-Core Budget CPU',
                'type' => 'cpu',
                'price' => 0,
                'specifications' => json_encode([
                    'cores' => 1,
                    'base_clock_mhz' => 500,
                    'socket' => 'GEN1',
                ]),
                'requirements' => json_encode([
                    'socket' => 'GEN1',
                ]),
            ],
            [
                'name' => '256 MB DDR2 RAM',
                'type' => 'ram',
                'price' => 0,
                'specifications' => json_encode([
                    'capacity_mb' => 256,
                    'type' => 'ddr2',
                ]),
                'requirements' => json_encode([
                    'ram_type' => 'ddr2',
                ])
            ],
            [
                'name' => '100MB HDD',
                'type' => 'disk',
                'price' => 0,
                'specifications' => json_encode([
                    'capacity_mb' => 100,
                    'type' => 'hdd',
                ]),
                'requirements' => json_encode([
                    'hdd' => true,
                ]),
            ],
            [
            'name' => '10 Mbps Cisco Switch',
            'type' => 'network',
            'price' => 0,
            'specifications' => json_encode([
                'bandwidth_mbps' => 10,
            ]),
            'requirements' => json_encode([
                'bandwidth_mbps' => 10,
            ]),
            ],
            [
                'name' => 'External WD 100MB',
                'type' => 'externalDrive',
                'price' => 100,
                'specifications' => json_encode([
                    'capacity_mb' => 100,
                ]),
                'requirements' => null,
            ]
        ]);
    }
}
