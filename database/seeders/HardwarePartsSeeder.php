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
        # Motherboard List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'Salvaged Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 80,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 1,
                        'socket' => 'LGA1156',
                        'max_ram_mb' => 2000,
                        'ram_type' => 'DDR2',
                        'stability_bonus' => 0,
                        'tier' => 1,
                    ]),
                ],
                [
                    'name' => 'Basic Consumer Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 200,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 2,
                        'socket' => 'AM3',
                        'max_ram_mb' => 4000,
                        'ram_type' => 'DDR3',
                        'stability_bonus' => 1,
                        'tier' => 2,
                    ]),
                ],
                [
                    'name' => 'Standard DDR3 Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 450,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 3,
                        'socket' => 'LGA1155',
                        'max_ram_mb' => 8000,
                        'ram_type' => 'DDR3',
                        'stability_bonus' => 2,
                        'tier' => 3,
                    ]),
                ],
                [
                    'name' => 'Performance DDR3 Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 800,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 4,
                        'socket' => 'AM3+',
                        'max_ram_mb' => 16000,
                        'ram_type' => 'DDR3',
                        'stability_bonus' => 3,
                        'tier' => 4,
                    ]),
                ],
                [
                    'name' => 'Entry DDR4 Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 1300,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 5,
                        'socket' => 'LGA1150',
                        'max_ram_mb' => 32000,
                        'ram_type' => 'DDR4',
                        'stability_bonus' => 4,
                        'tier' => 5,
                    ]),
                ],
                [
                    'name' => 'DDR4 Server Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 2200,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 6,
                        'socket' => 'LGA1151',
                        'max_ram_mb' => 64000,
                        'ram_type' => 'DDR4',
                        'stability_bonus' => 5,
                        'tier' => 6,
                    ]),
                ],
                [
                    'name' => 'High-End DDR4 Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 3600,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 7,
                        'socket' => 'AM4',
                        'max_ram_mb' => 128000,
                        'ram_type' => 'DDR4',
                        'stability_bonus' => 6,
                        'tier' => 7,
                    ]),
                ],
                [
                    'name' => 'DDR5 Server Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 5500,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 8,
                        'socket' => 'LGA1200',
                        'max_ram_mb' => 256000,
                        'ram_type' => 'DDR5',
                        'stability_bonus' => 7,
                        'tier' => 8,
                    ]),
                ],
                [
                    'name' => 'Enterprise Logic Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 9000,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 9,
                        'socket' => 'LGA1700',
                        'max_ram_mb' => 512000,
                        'ram_type' => 'DDR5',
                        'stability_bonus' => 8,
                        'tier' => 9,
                    ]),
                ],
                [
                    'name' => 'Quantum Control Board',
                    'category' => 'hardware',
                    'type' => 'motherboard',
                    'price' => 18000,
                    'specifications' => json_encode([
                        'max_cpu_tier' => 10,
                        'socket' => 'AM5',
                        'max_ram_mb' => 1024000,
                        'ram_type' => 'DDR5+',
                        'stability_bonus' => 10,
                        'tier' => 10,
                    ]),
                ],
            ]);

        # CPU List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'Single-Core Salvaged CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 100,
                    'specifications' => json_encode([
                        'cores' => 1,
                        'clock_mhz' => 500,
                        'compute_power' => 50,
                        'stability' => 70,
                        'power_draw_w' => 35,
                        'tier' => 1,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1156',
                    ]),
                ],
                [
                    'name' => 'Dual-Core Office CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 250,
                    'specifications' => json_encode([
                        'cores' => 2,
                        'clock_mhz' => 1000,
                        'compute_power' => 120,
                        'stability' => 75,
                        'power_draw_w' => 45,
                        'tier' => 2,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'AM3',
                    ]),
                ],
                [
                    'name' => 'Quad-Core Consumer CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 600,
                    'specifications' => json_encode([
                        'cores' => 4,
                        'clock_mhz' => 1500,
                        'compute_power' => 300,
                        'stability' => 80,
                        'power_draw_w' => 65,
                        'tier' => 3,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1155',
                    ]),
                ],
                [
                    'name' => 'Quad-Core Performance CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 1000,
                    'specifications' => json_encode([
                        'cores' => 4,
                        'clock_mhz' => 2000,
                        'compute_power' => 450,
                        'stability' => 85,
                        'power_draw_w' => 75,
                        'tier' => 4,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'AM3+',
                    ]),
                ],
                [
                    'name' => 'Hexa-Core Modern CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 1800,
                    'specifications' => json_encode([
                        'cores' => 6,
                        'clock_mhz' => 2500,
                        'compute_power' => 700,
                        'stability' => 88,
                        'power_draw_w' => 95,
                        'tier' => 5,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1150',
                    ]),
                ],
                [
                    'name' => 'Octa-Core Performance CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 2800,
                    'specifications' => json_encode([
                        'cores' => 8,
                        'clock_mhz' => 3000,
                        'compute_power' => 1100,
                        'stability' => 90,
                        'power_draw_w' => 125,
                        'tier' => 6,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1151',
                    ]),
                ],
                [
                    'name' => '12-Core Server CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 4500,
                    'specifications' => json_encode([
                        'cores' => 12,
                        'clock_mhz' => 3500,
                        'compute_power' => 1700,
                        'stability' => 93,
                        'power_draw_w' => 155,
                        'tier' => 7,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'AM4',
                    ]),
                ],
                [
                    'name' => '16-Core Datacenter CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 7000,
                    'specifications' => json_encode([
                        'cores' => 16,
                        'clock_mhz' => 4000,
                        'compute_power' => 2500,
                        'stability' => 95,
                        'power_draw_w' => 185,
                        'tier' => 8,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1200',
                    ]),
                ],
                [
                    'name' => '32-Core Enterprise CPU',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 12000,
                    'specifications' => json_encode([
                        'cores' => 32,
                        'clock_mhz' => 5000,
                        'compute_power' => 4000,
                        'stability' => 97,
                        'power_draw_w' => 220,
                        'tier' => 9,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'LGA1700',
                    ]),
                ],
                [
                    'name' => 'Quantum Compute Core',
                    'category' => 'hardware',
                    'type' => 'cpu',
                    'price' => 25000,
                    'specifications' => json_encode([
                        'cores' => 64,
                        'clock_mhz' => 6000,
                        'compute_power' => 8000,
                        'stability' => 99,
                        'power_draw_w' => 280,
                        'tier' => 10,
                    ]),
                    'requirements' => json_encode([
                        'socket' => 'AM5',
                    ]),
                ],
            ]);

        # RAM List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'Scrap DDR2 Stick',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 50,
                    'specifications' => json_encode([
                        'capacity_mb' => 256,
                        'ram_type' => 'DDR2',
                        'speed_mhz' => 400,
                        'stability' => 70,
                        'power_draw_w' => 5,
                        'tier' => 1,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR2',
                    ]),
                ],
                [
                    'name' => 'Old DDR3 Module',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 120,
                    'specifications' => json_encode([
                        'capacity_mb' => 512,
                        'ram_type' => 'DDR3',
                        'speed_mhz' => 800,
                        'stability' => 75,
                        'power_draw_w' => 6,
                        'tier' => 2,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR3',
                    ]),
                ],
                [
                    'name' => 'Budget DDR3 Kit',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 300,
                    'specifications' => json_encode([
                        'capacity_mb' => 1024,
                        'ram_type' => 'DDR3',
                        'speed_mhz' => 1333,
                        'stability' => 80,
                        'power_draw_w' => 7,
                        'tier' => 3,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR3',
                    ]),
                ],
                [
                    'name' => 'Consumer DDR3 Pro',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 600,
                    'specifications' => json_encode([
                        'capacity_mb' => 1536,
                        'ram_type' => 'DDR3',
                        'speed_mhz' => 1600,
                        'stability' => 85,
                        'power_draw_w' => 8,
                        'tier' => 4,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR3',
                    ]),
                ],
                [
                    'name' => 'Entry DDR4 Stick',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 900,
                    'specifications' => json_encode([
                        'capacity_mb' => 2048,
                        'ram_type' => 'DDR4',
                        'speed_mhz' => 2400,
                        'stability' => 88,
                        'power_draw_w' => 9,
                        'tier' => 5,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR4',
                    ]),
                ],
                [
                    'name' => 'DDR4 Performance Module',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 1500,
                    'specifications' => json_encode([
                        'capacity_mb' => 3072,
                        'ram_type' => 'DDR4',
                        'speed_mhz' => 3000,
                        'stability' => 90,
                        'power_draw_w' => 10,
                        'tier' => 6,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR4',
                    ]),
                ],
                [
                    'name' => 'DDR4 Server Grade',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 2600,
                    'specifications' => json_encode([
                        'capacity_mb' => 4096,
                        'ram_type' => 'DDR4',
                        'speed_mhz' => 3200,
                        'stability' => 93,
                        'power_draw_w' => 11,
                        'tier' => 7,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR4',
                    ]),
                ],
                [
                    'name' => 'DDR5 Early Gen',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 4200,
                    'specifications' => json_encode([
                        'capacity_mb' => 5120,
                        'ram_type' => 'DDR5',
                        'speed_mhz' => 4800,
                        'stability' => 95,
                        'power_draw_w' => 12,
                        'tier' => 8,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR5',
                    ]),
                ],
                [
                    'name' => 'DDR5 Enterprise',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 7000,
                    'specifications' => json_encode([
                        'capacity_mb' => 6144,
                        'ram_type' => 'DDR5',
                        'speed_mhz' => 5600,
                        'stability' => 97,
                        'power_draw_w' => 14,
                        'tier' => 9,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR5',
                    ]),
                ],
                [
                    'name' => 'Quantum Memory Array',
                    'category' => 'hardware',
                    'type' => 'ram',
                    'price' => 15000,
                    'specifications' => json_encode([
                        'capacity_mb' => 8192,
                        'ram_type' => 'DDR5+',
                        'speed_mhz' => 7200,
                        'stability' => 99,
                        'power_draw_w' => 18,
                        'tier' => 10,
                    ]),
                    'requirements' => json_encode([
                        'ram_type' => 'DDR5+',
                    ]),
                ],
            ]);

        # Power Supply List
        DB::table('hardware_parts')->insert([
            [
                'name' => 'Unstable Power Brick',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 40,
                'specifications' => json_encode([
                    'max_power_w' => 150,
                    'efficiency' => 60,
                    'stability_bonus' => -5,
                    'tier' => 1,
                ]),
            ],
            [
                'name' => 'Generic PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 120,
                'specifications' => json_encode([
                    'max_power_w' => 300,
                    'efficiency' => 70,
                    'stability_bonus' => -2,
                    'tier' => 2,
                ]),
            ],
            [
                'name' => 'Budget Certified PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 260,
                'specifications' => json_encode([
                    'max_power_w' => 450,
                    'efficiency' => 75,
                    'stability_bonus' => 0,
                    'tier' => 3,
                ]),
            ],
            [
                'name' => 'Standard Bronze PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 480,
                'specifications' => json_encode([
                    'max_power_w' => 600,
                    'efficiency' => 80,
                    'stability_bonus' => 2,
                    'tier' => 4,
                ]),
            ],
            [
                'name' => 'Silver Grade PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 850,
                'specifications' => json_encode([
                    'max_power_w' => 750,
                    'efficiency' => 85,
                    'stability_bonus' => 3,
                    'tier' => 5,
                ]),
            ],
            [
                'name' => 'Gold Modular PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 1400,
                'specifications' => json_encode([
                    'max_power_w' => 1000,
                    'efficiency' => 90,
                    'stability_bonus' => 5,
                    'tier' => 6,
                ]),
            ],
            [
                'name' => 'Platinum Server PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 2400,
                'specifications' => json_encode([
                    'max_power_w' => 1400,
                    'efficiency' => 92,
                    'stability_bonus' => 7,
                    'tier' => 7,
                ]),
            ],
            [
                'name' => 'Datacenter Redundant PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 4200,
                'specifications' => json_encode([
                    'max_power_w' => 2000,
                    'efficiency' => 94,
                    'stability_bonus' => 9,
                    'tier' => 8,
                ]),
            ],
            [
                'name' => 'Dark Energy PSU',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 7500,
                'specifications' => json_encode([
                    'max_power_w' => 3000,
                    'efficiency' => 96,
                    'stability_bonus' => 12,
                    'tier' => 9,
                ]),
            ],
            [
                'name' => 'Quantum Flux Power Core',
                'category' => 'hardware',
                'type' => 'psu',
                'price' => 14000,
                'specifications' => json_encode([
                    'max_power_w' => 5000,
                    'efficiency' => 99,
                    'stability_bonus' => 20,
                    'tier' => 10,
                ]),
            ],
        ]);

        # Disk List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'Rusty HDD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 60,
                    'specifications' => json_encode([
                        'capacity_mb' => 100,
                        'speed' => 40,
                        'stealth_bonus' => 0,
                        'tier' => 1,
                    ]),
                ],
                [
                    'name' => 'Old SATA HDD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 120,
                    'specifications' => json_encode([
                        'capacity_mb' => 250,
                        'speed' => 60,
                        'stealth_bonus' => 1,
                        'tier' => 2,
                    ]),
                ],
                [
                    'name' => 'Consumer HDD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 250,
                    'specifications' => json_encode([
                        'capacity_mb' => 500,
                        'speed' => 80,
                        'stealth_bonus' => 1,
                        'tier' => 3,
                    ]),
                ],
                [
                    'name' => 'Hybrid SSHD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 500,
                    'specifications' => json_encode([
                        'capacity_mb' => 1000,
                        'speed' => 120,
                        'stealth_bonus' => 2,
                        'tier' => 4,
                    ]),
                ],
                [
                    'name' => 'Entry SSD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 900,
                    'specifications' => json_encode([
                        'capacity_mb' => 2000,
                        'speed' => 300,
                        'stealth_bonus' => 3,
                        'tier' => 5,
                    ]),
                ],
                [
                    'name' => 'NVMe SSD',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 1600,
                    'specifications' => json_encode([
                        'capacity_mb' => 4000,
                        'speed' => 600,
                        'stealth_bonus' => 4,
                        'tier' => 6,
                    ]),
                ],
                [
                    'name' => 'Encrypted NVMe',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 2800,
                    'specifications' => json_encode([
                        'capacity_mb' => 8000,
                        'speed' => 900,
                        'stealth_bonus' => 6,
                        'tier' => 7,
                    ]),
                ],
                [
                    'name' => 'Enterprise Flash Array',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 5000,
                    'specifications' => json_encode([
                        'capacity_mb' => 12000,
                        'speed' => 1300,
                        'stealth_bonus' => 8,
                        'tier' => 8,
                    ]),
                ],
                [
                    'name' => 'Dark Storage Core',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 8500,
                    'specifications' => json_encode([
                        'capacity_mb' => 20000,
                        'speed' => 1800,
                        'stealth_bonus' => 10,
                        'tier' => 9,
                    ]),
                ],
                [
                    'name' => 'Quantum Data Vault',
                    'category' => 'hardware',
                    'type' => 'disk',
                    'price' => 15000,
                    'specifications' => json_encode([
                        'capacity_mb' => 30000,
                        'speed' => 3000,
                        'stealth_bonus' => 15,
                        'tier' => 10,
                    ]),
                ],
            ]);

        # External Drive List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'USB Stick Cache',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 50,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 0.1,
                        'backup_slots' => 0,
                        'stealth_bonus' => 0,
                        'access_speed' => 20,
                        'tier' => 1,
                    ]),
                ],
                [
                    'name' => 'Portable HDD',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 75,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 0.5,
                        'backup_slots' => 1,
                        'stealth_bonus' => 0,
                        'access_speed' => 30,
                        'tier' => 2,
                    ]),
                ],
                [
                    'name' => 'Encrypted USB Drive',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 150,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 1,
                        'backup_slots' => 1,
                        'stealth_bonus' => 2,
                        'access_speed' => 40,
                        'tier' => 3,
                    ]),
                ],
                [
                    'name' => 'External Backup HDD',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 200,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 1.5,
                        'backup_slots' => 2,
                        'stealth_bonus' => 1,
                        'access_speed' => 50,
                        'tier' => 4,
                    ]),
                ],
                [
                    'name' => 'Portable SSD',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 250,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 2.0,
                        'backup_slots' => 2,
                        'stealth_bonus' => 3,
                        'access_speed' => 120,
                        'tier' => 5,
                    ]),
                ],
                [
                    'name' => 'Encrypted External SSD',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 275,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 2.5,
                        'backup_slots' => 3,
                        'stealth_bonus' => 5,
                        'access_speed' => 200,
                        'tier' => 6,
                    ]),
                ],
                [
                    'name' => 'Cold Storage Vault',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 300,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 3.0,
                        'backup_slots' => 3,
                        'stealth_bonus' => 6,
                        'access_speed' => 80,
                        'tier' => 7,
                    ]),
                ],
                [
                    'name' => 'Shadow Backup Node',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 350,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 3.5,
                        'backup_slots' => 4,
                        'stealth_bonus' => 8,
                        'access_speed' => 150,
                        'tier' => 8,
                    ]),
                ],
                [
                    'name' => 'Dark Archive Array',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 400,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 4.0,
                        'backup_slots' => 5,
                        'stealth_bonus' => 12,
                        'access_speed' => 250,
                        'tier' => 9,
                    ]),
                ],
                [
                    'name' => 'Quantum Offsite Vault',
                    'category' => 'hardware',
                    'type' => 'externalDrive',
                    'price' => 450,
                    'specifications' => json_encode([
                        'extra_capacity_gb' => 4.5,
                        'backup_slots' => 6,
                        'stealth_bonus' => 20,
                        'access_speed' => 500,
                        'tier' => 10,
                    ]),
                ],
            ]);

        # Network List
        DB::table('hardware_parts')->insert([
                [
                    'name' => 'NetLink S10',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 0,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 1,
                        'latency_ms' => 150,
                        'max_connections' => 1,
                        'trace_resistance' => 0,
                        'tier' => 1,
                    ]),
                ],
                [
                    'name' => 'EdgeWave D20',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 100,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 10,
                        'latency_ms' => 90,
                        'max_connections' => 2,
                        'trace_resistance' => 1,
                        'tier' => 2,
                    ]),
                ],
                [
                    'name' => 'MetroSwitch M50',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 250,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 50,
                        'latency_ms' => 60,
                        'max_connections' => 3,
                        'trace_resistance' => 2,
                        'tier' => 3,
                    ]),
                ],
                [
                    'name' => 'FiberEdge F100',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 500,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 100,
                        'latency_ms' => 40,
                        'max_connections' => 5,
                        'trace_resistance' => 3,
                        'tier' => 4,
                    ]),
                ],
                [
                    'name' => 'FiberEdge F250',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 750,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 250,
                        'latency_ms' => 30,
                        'max_connections' => 8,
                        'trace_resistance' => 4,
                        'tier' => 5,
                    ]),
                ],
                [
                    'name' => 'CoreSwitch G1',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 1500,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 1000,
                        'latency_ms' => 20,
                        'max_connections' => 13,
                        'trace_resistance' => 6,
                        'tier' => 6,
                    ]),
                ],
                [
                    'name' => 'CoreSwitch G2.5',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 2000,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 2500,
                        'latency_ms' => 15,
                        'max_connections' => 21,
                        'trace_resistance' => 8,
                        'tier' => 7,
                    ]),
                ],
                [
                    'name' => 'HyperSwitch H5',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 3000,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 5000,
                        'latency_ms' => 10,
                        'max_connections' => 34,
                        'trace_resistance' => 11,
                        'tier' => 8,
                    ]),
                ],
                [
                    'name' => 'DataCore X10',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 3750,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 10000,
                        'latency_ms' => 5,
                        'max_connections' => 55,
                        'trace_resistance' => 15,
                        'tier' => 9,
                    ]),
                ],
                [
                    'name' => 'Backbone Z25',
                    'category' => 'hardware',
                    'type' => 'network',
                    'price' => 5000,
                    'specifications' => json_encode([
                        'bandwidth_mbps' => 25000,
                        'latency_ms' => 1,
                        'max_connections' => 100,
                        'trace_resistance' => 25,
                        'tier' => 10,
                    ]),
                ],
            ]);

        # Servers List
        DB::table('hardware_parts')->insert([
            [
                'name' => 'Server 2',
                'category' => 'server',
                'type' => 'server',
                'price' => 1000,
                'specifications' => null,
                'requirements' => json_encode([
                    'servers_count' => 1
                ])
            ],
            [
                'name' => 'Server 3',
                'category' => 'server',
                'type' => 'server',
                'price' => 5000,
                'specifications' => null,
                'requirements' => json_encode([
                    'servers_count' => 2
                ])
            ],
            [
                'name' => 'Server 4',
                'category' => 'server',
                'type' => 'server',
                'price' => 10000,
                'specifications' => null,
                'requirements' => json_encode([
                    'servers_count' => 3
                ])
            ],
        ]);

        # Internet List
        DB::table('hardware_parts')->insert([
            [
                'name' => 'Copper Line',
                'category' => 'service',
                'type' => 'internet',
                'price' => 0,
                'specifications' => json_encode([
                    'connectivity_mbps' => 1
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 1
                ])
            ],
            [
                'name' => 'DSL Core',
                'category' => 'service',
                'type' => 'internet',
                'price' => 50,
                'specifications' => json_encode([
                    'connectivity_mbps' => 10
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 10
                ])
            ],
            [
                'name' => 'Metro Link',
                'category' => 'service',
                'type' => 'internet',
                'price' => 100,
                'specifications' => json_encode([
                    'connectivity_mbps' => 50
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 50
                ])
            ],
            [
                'name' => 'Fiber Start',
                'category' => 'service',
                'type' => 'internet',
                'price' => 300,
                'specifications' => json_encode([
                    'connectivity_mbps' => 100
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 100
                ])
            ],
            [
                'name' => 'Fiber Plus',
                'category' => 'service',
                'type' => 'internet',
                'price' => 1000,
                'specifications' => json_encode([
                    'connectivity_mbps' => 250
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 250
                ])
            ],
            [
                'name' => 'Giga Stream',
                'category' => 'service',
                'type' => 'internet',
                'price' => 2500,
                'specifications' => json_encode([
                    'connectivity_mbps' => 1000
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 1000
                ])
            ],
            [
                'name' => 'Giga Stream Pro',
                'category' => 'service',
                'type' => 'internet',
                'price' => 10000,
                'specifications' => json_encode([
                    'connectivity_mbps' => 2500
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 2500
                ])
            ],
            [
                'name' => 'HyperFiber X',
                'category' => 'service',
                'type' => 'internet',
                'price' => 25000,
                'specifications' => json_encode([
                    'connectivity_mbps' => 5000
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 5000
                ])
            ],
            [
                'name' => 'Datacenter Link',
                'category' => 'service',
                'type' => 'internet',
                'price' => 50000,
                'specifications' => json_encode([
                    'connectivity_mbps' => 10000
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 10000
                ])
            ],
            [
                'name' => 'Quantum Backbone',
                'category' => 'service',
                'type' => 'internet',
                'price' => 100000,
                'specifications' => json_encode([
                    'connectivity_mbps' => 25000
                ]),
                'requirements' => json_encode([
                    'bandwidth_mbps' => 25000
                ])
            ],
        ]);
    }
}
