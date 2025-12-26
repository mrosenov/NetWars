<?php

namespace App\Http\Controllers;

use App\Models\NPC;
use App\Models\Servers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NPCController extends Controller
{
    public static function generateHardware(NPC $npc, Servers $server): void
    {
        $username = UserNetworkController::generateUsername();
        $ip = ($npc->name === '1st WhoIs') ? '1.2.3.4' : UserNetworkController::generateIp();

        // Type -> hardware id sets
        $profiles = [
            'tier10' => [ // whois / law_enforcement / intelligence
                'resources' => [10, 20, 30, 40, 50],
                'network' => 70,
                'connectivity' => 78,
            ],
            'tier7' => [ // bank / isp / download
                'resources' => [7, 17, 27, 37, 47],
                'network' => 67,
                'connectivity' => 77
            ],
            'tier3' => [ // default
                'resources' => [3, 13, 23, 33, 43],
                'network' => 63,
                'connectivity' => 76
            ],
        ];

        $type = $npc->type;

        $profile = (in_array($type, ['whois', 'law_enforcement', 'intelligence'], true) ? $profiles['tier10'] : in_array($type, ['bank', 'isp', 'download'], true)) ? $profiles['tier7'] : $profiles['tier3'];

        // Create all resources in a loop
        foreach ($profile['resources'] as $hardwareId) {
            $npc->resources()->create([
                'server_id'   => $server->id,
                'hardware_id' => $hardwareId,
            ]);
        }

        // Create network
        $npc->network()->create([
            'hardware_id' => $profile['network'],
            'connectivity_id' => $profile['connectivity'],
            'ip'          => $ip,
            'user'        => $username,
            'password'    => Str::random(8),
        ]);
    }
}
