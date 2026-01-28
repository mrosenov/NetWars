<?php

namespace App\Models;

use App\Http\Controllers\HardwarePartsController;
use App\Http\Controllers\UserNetworkController;
use App\Http\Controllers\UserProcessController;
use App\Models\Concerns\HasStorage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasStorage;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'version',
        'type',
        'size',
        'requirements',
        'is_hidden',
        'owner_type',
        'owner_id',
        'connected_to_network_id',
        'server_id',
        'hardware_id',
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
                'name' => 'Server 1'
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
                'connectivity_id' => 74,
                'ip' => $ip,
                'user' => $username,
                'password' => Str::random(8),
            ]);

        });
    }

    public function servers() {
        return $this->morphMany(Servers::class, 'owner');
    }

    public function connectivity() {
        return $this->network->connectivity;
    }

    public function network() {
        return $this->morphOne(UserNetwork::class, 'owner');
    }

    public function isConnected(): bool {
        return (bool) $this->network?->connected_to_network_id;
    }

    public function TotalStorage() {
        return 1;
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

    public function software(): \Illuminate\Database\Eloquent\Relations\MorphMany {
        return $this->morphMany(ServerSoftwares::class, 'owner');
    }

    public function externalSoftware() {
        return $this->morphMany(ExternalSoftware::class, 'owner');
    }

    public function tasks() {
        return $this->hasMany(UserProcess::class, 'user_id');
    }

    public function getCrackerAttribute(): ?ServerSoftwares {
        return $this->network?->cracker();
    }

    public function getHasherAttribute(): ?ServerSoftwares {
        return $this->network?->hasher();
    }

    /** auth()->user()->hackedVictims()->with('network')->get(); */
    public function hackedVictims(): User|\Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(HackedNetworks::class, 'user_id');
    }

    /** $isHacked = auth()->user()->hasHackedNetwork($visitedNetwork->id); */
    public function hasHackedNetwork(int $networkId): bool {
        return $this->hackedVictims()->where('network_id', $networkId)->exists();
    }

    public function hackedNetworkEntry(int $networkId) {
        return $this->hackedVictims()->where('network_id', $networkId)->first();
    }

    public function bankAccounts() {
        return $this->hasMany(BankAccount::class, 'user_id');
    }

    public function totalBalance() {
        $accounts = $this->bankAccounts;
        return $accounts->sum('balance');
    }

    public function totalStorageMb(): int {
        $totals = $this->totalResources();
        return (int) ($totals['storage_mb'] ?? 0);
    }

    public function totalUsedExternalStorageMb(): float {
        return $this->externalSoftware->sum(fn ($soft) => (float) $soft->size);
    }

    public function availableExternalStorageMb(): float {
        return max(0, $this->totalExternalStorageMb() - $this->totalUsedExternalStorageMb());
    }

    public function totalExternalStorageMb(): int {
        $totals = $this->totalResources();
        return (int) ($totals['external_mb'] ?? 0);
    }

    public function totalUsedStorageMb(): float {
        return $this->software->sum(fn ($soft) => (float) $soft->size);
    }

    public function availableStorageMb(): float {
        return max(0, $this->totalStorageMb() - $this->totalUsedStorageMb());
    }

    public function totalResources(): array
    {
        $servers = $this->servers()->with(['resources.hardware'])->get();

        $totals = [
            'clock_mhz' => 0,
            'ram_mb' => 0,
            'storage_mb' => 0,
            'external_mb' => 0,
            'down_mbps' => 0.0,
            'up_mbps' => 0.0,
            'cpu_compute' => 0,
            'stability' => 0,
            'power_supply' => 0,
        ];

        $net = app()->make(UserProcessController::class)->getUserNetTotals();
        $totals['down_mbps'] += (float) ($net['down_mbps'] ?? 0);
        $totals['up_mbps'] += (float) ($net['up_mbps'] ?? 0);

        $ExtraCapacityGb = (float) ($this->externalStorage->hardware->specifications['extra_capacity_gb'] ?? 0);
        $totals['external_mb'] += (int) round($ExtraCapacityGb * 1000);

        foreach ($servers as $server) {
            $t = $server->resource_totals;

            $totals['clock_mhz'] += (int) ($t['clock_mhz'] ?? 0);
            $totals['ram_mb'] += (int) ($t['ram_mb'] ?? 0);
            $totals['storage_mb'] += (int) ($t['storage_mb'] ?? 0);
            $totals['down_mbps'] += (float) ($t['down_mbps'] ?? 0);
            $totals['up_mbps'] += (float) ($t['up_mbps'] ?? 0);
            $totals['cpu_compute'] += (int) ($t['cpu_compute'] ?? 0);
            $totals['stability'] = max($totals['stability'], (int) ($t['stability'] ?? 0));
            $totals['power_supply'] += (int) ($t['power_supply'] ?? 0);
        }

        return $totals;
    }

}
