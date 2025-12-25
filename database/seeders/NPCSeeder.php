<?php

namespace Database\Seeders;

use App\Http\Controllers\UserNetworkController;
use App\Models\NPC;
use App\Models\UserNetwork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NPCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Main NPCs
        $mainNPCs = [
            ['name' => '1st WhoIs', 'type' => 'whois', 'threat' => 'high'],
            ['name' => '2nd WhoIs', 'type' => 'whois', 'threat' => 'high'],
            ['name' => '3rd WhoIs', 'type' => 'whois', 'threat' => 'high'],
            ['name' => '4th WhoIs', 'type' => 'whois', 'threat' => 'high'],

            ['name' => 'FBI', 'type' => 'law_enforcement', 'threat' => 'high'],
            ['name' => 'CIA', 'type' => 'intelligence', 'threat' => 'high'],

            ['name' => 'ICBC', 'type' => 'bank', 'threat' => 'medium'],
            ['name' => 'JP Chase & Co.', 'type' => 'bank', 'threat' => 'medium'],
            ['name' => 'HSBC', 'type' => 'bank', 'threat' => 'medium'],

            ['name' => 'Mandrill ISP', 'type' => 'isp', 'threat' => 'medium'],

            ['name' => 'Download Center', 'type' => 'download', 'threat' => 'medium'],

            ['name' => 'Puzzle #1', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #2', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #3', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #4', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #5', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #6', 'type' => 'puzzle', 'threat' => 'low'],
            ['name' => 'Puzzle #7', 'type' => 'puzzle', 'threat' => 'low'],
        ];

        # Create main NPCs
        foreach ($mainNPCs as $index => $data) {
            $npc = NPC::create([
                'name' => $data['name'],
                'type' => $data['type'],
                'threat' => $data['threat'],
            ]);

            $username = UserNetworkController::generateUsername();
            $ip = $index === 0 ? '1.2.3.4' : UserNetworkController::generateIp();

            $npc->network()->create([
                'hardware_id' => 5,
                'ip' => $ip,
                'user' => $username,
                'password' => Str::random(8),
            ]);
        }

        # Update main NPCs with essential information
        $mainNPCsID = [1,2,3,4];
        NPC::whereKey(1)->update([
            'metadata' => [
                'text' => 'Welcome to the First Whois server. Enjoy our services!',
                'recommendations' => [
                    'title' => 'Recommended Sites',
                    'items' => [
                        [
                            'ip' => '127.0.0.1',
                            'url' => 'https://example.com/cia',
                            'label' => 'CIA Portal',
                        ],
                        [
                            'ip' => '127.0.0.1',
                            'url' => 'https://example.com/fbi',
                            'label' => 'FBI Database',
                        ],
                    ],
                ],
            ],
        ]);

        # Random NPCs
        for ($i = 1; $i < count($mainNPCs); $i++) {
            $npc = NPC::create([
                'name' => 'Random NPC '.$i,
                'type' => 'normal',
                'threat' => 'none',
            ]);

            $username = UserNetworkController::generateUsername();
            $ip = UserNetworkController::generateIp();

            $npc->network()->create([
                'hardware_id' => 5,
                'ip' => $ip,
                'user' => $username,
                'password' => Str::random(8),
            ]);
        }

    }
}
