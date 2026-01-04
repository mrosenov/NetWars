<?php

namespace Database\Seeders;

use App\Http\Controllers\UserNetworkController;
use App\Models\ServerResources;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create main user
        $user = User::create([
            'name' => 'Mitko Rosenov',
            'email' => 'mitkorosenov@live.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $server = $user->servers()->create();

        # Assign default server parts 1 - Motherboard, 2 - CPU, 3 - RAM, 4 - Storage(HDD)
        $types = ['motherboard', 'cpu', 'ram', 'disk', 'network', 'psu'];

        $startingParts = [];

        foreach ($types as $type) {
            $startingParts[$type] = \App\Models\HardwareParts::query()
                ->where('type', $type)
                ->orderByRaw("CAST(JSON_EXTRACT(specifications, '$.tier') AS UNSIGNED) ASC")
                ->first();
        }

        foreach ($startingParts as $part) {
            $user->resources()->create([
                'server_id' => $server->id,
                'hardware_id' => $part->id,
            ]);
        }

        $ip = UserNetworkController::generateIp();
        $username = UserNetworkController::generateUsername();

        $user->network()->create([
            'hardware_id' => 61,
            'connectivity_id' => 74,
            'ip' => $ip,
            'user' => $username,
            'password' => Str::random(8),
        ]);

        $user->software()->create([
            'type' => 'crc',
            'name' => 'Amateur Cracker',
            'version' => '1.0',
            'size' => 21
        ]);
        $user->software()->create([
            'type' => 'hash',
            'name' => 'Amateur Hasher',
            'version' => '1.0',
            'size' => 21
        ]);
    }
}
