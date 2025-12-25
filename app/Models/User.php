<?php

namespace App\Models;

use App\Http\Controllers\UserNetworkController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted() {

        static::created(function ($user) {

            # Assign default server to player when registers.
            $server = $user->servers()->create([
                'meta' => null
            ]);

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

            # Assign network to the player.
            $username = UserNetworkController::generateUsername();
            $ip = UserNetworkController::generateIp();

            $user->network()->create([
                'hardware_id' => 61,
                'ip' => $ip,
                'user' => $username,
                'password' => Str::random(8),
            ]);

        });
    }

    public function servers() {
        return $this->morphMany(Servers::class, 'owner');
    }

    public function network() {
        return $this->morphOne(UserNetwork::class, 'owner');
    }

    public function isConnected(): bool {
        return (bool) $this->network?->connected_to_network_id;
    }

    public function connectedNetwork() {
        return $this->network?->connected;
    }

    public function externalStorage() {
        return $this->hasOne(UsersExternalStorage::class, 'user_id');
    }

    public function resources() {
        return $this->morphMany(ServerResources::class, 'owner');
    }

    public function OverallResources(): array
    {
        // Make sure we don't N+1 query hardware_parts
        $resources = $this->resources()->with('hardware')->get();

        // Sum in base units
        $totals = [
            'clock_ghz' => 0.0,
            'ram_gb' => 0.0,
            'psu_w' => 0.0,
            'disk_gb' => 0.0,
            'externalDrive_gb' => 0.0,
            'network_mbps' => 0.0,
        ];

        foreach ($resources as $resource) {
            $hw = $resource->hardware;

            if (!$hw) {
                continue;
            }

            // Exclude motherboard
            if ($hw->type === 'motherboard') {
                continue;
            }

            $spec = is_array($hw->specifications) ? $hw->specifications : (array) $hw->specifications;

            switch ($hw->type) {
                case 'cpu':
                    $mhz = (int) (data_get($spec, 'clock_ghz') ?? 0);
                    $totals['clock_ghz'] += $mhz;
                    break;

                case 'ram':
                    $mb = (int) (data_get($spec, 'capacity_gb') ?? 0);
                    $totals['ram_gb'] += $mb;
                    break;

                case 'psu':
                    $mb = (int) (data_get($spec, 'max_power_w') ?? 0);
                    $totals['psu_w'] += $mb;
                    break;

                case 'disk':
                    $mb = (int) (data_get($spec, 'capacity_gb') ?? 0);
                    $totals['disk_gb'] += $mb;
                    break;

            }
        }

        // Networks (network hardware is on user_networks)
        $userNetworks = $this->network()->with('hardware')->get();

        foreach ($userNetworks as $net) {
            $hw = $net->hardware;
            if (!$hw || $hw->type !== 'network') continue;

            $spec = $hw->specifications ?? [];
            $totals['network_mbps'] += (float) data_get($spec, 'bandwidth_mbps', 0);
        }

        $userStorages = $this->externalStorage()->with('hardware')->get();

        foreach ($userStorages as $storage) {
            $hw = $storage->hardware;

            if (!$hw || $hw->type !== 'externalDrive') continue;

            $spec = $hw->specifications ?? [];
            $totals['externalDrive_gb'] += (float) data_get($spec, 'extra_capacity_gb', 0);
        }

        return [
            'CPU' => $this->prettyCpu($totals['clock_ghz']),
            'RAM' => $this->prettyStorage($totals['ram_gb']),
            'PSU' => $this->prettyPSU($totals['psu_w']),
            'Disk' => $this->prettyStorage($totals['disk_gb']),
            'externalDrive' => $this->prettyStorage($totals['externalDrive_gb']),
            'Network' => $this->prettyNetwork($totals['network_mbps']),
        ];
    }

    private function prettyCpu(float $ghz): array {
        return ['value' => round($ghz, 1), 'unit' => 'GHz'];
    }

    private function prettyPSU(int $watts): array {
        if ($watts < 1000) {
            return ['value' => $watts, 'unit' => 'Watt'];
        }

        return ['value' => $watts, 'unit' => 'kW'];
    }

    private function prettyNetwork(int $mbps): array {
        if ($mbps >= 1000) {
            return ['value' => round($mbps / 1, 1), 'unit' => 'Gbps'];
        }
        return ['value' => round($mbps, 0), 'unit' => 'Mbps'];
    }

    private function prettyStorage(int $gb): array {
        if ($gb < 1000) {
            return ['value' => $gb, 'unit' => 'GB'];
        }

        return ['value' => round($gb / 1000,1), 'unit' => 'TB'];
    }

}
