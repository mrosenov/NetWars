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

        $server = $user->servers()->create([
            'meta' => null
        ]);

        # Assign default server parts 1 - Motherboard, 2 - CPU, 3 - RAM, 4 - Storage(HDD)
        for ($i = 1; $i <= 4; $i++) {
            $user->resources()->create([
                'server_id' => $server->id,
                'hardware_id' => $i
            ]);
        }

        $ip = UserNetworkController::generateIp();
        $username = UserNetworkController::generateUsername();

        $user->network()->create([
            'hardware_id' => 5,
            'ip' => $ip,
            'user' => $username,
            'password' => Str::random(8),
        ]);
    }
}
