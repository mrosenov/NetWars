<?php

namespace App\Models;

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
        static::creating(function ($user) {
            // Generates a random IP-like string
            $user->game_ip = rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);

            // Generates a random 8-character string
            $user->ssh_password = Str::random(8);
        });
    }

    public function servers() {
        return $this->hasMany(Servers::class, 'user_id');
    }

    public function resources(): HasManyThrough {
        return $this->hasManyThrough(
            ServerResources::class,
            Servers::class,
            'user_id',     // FK on servers
            'server_id',   // FK on server_resources
            'id',          // PK on users
            'id'           // PK on servers
        );
    }

    public function totalResourceValue(?string $ownerType = 'player'): float {
        $q = $this->resources();

        if ($ownerType !== null) {
            // filter through the intermediate servers table
            $q->where('servers.owner_type', $ownerType);
        }

        return (float) $q->sum('value');
    }

    public function totalResourcesByType(?string $ownerType = 'player'): array {
        $query = $this->resources()
            ->selectRaw('type, COALESCE(SUM(value), 0) as total')
            ->groupBy('type');

        if ($ownerType !== null) {
            // HasManyThrough already joins `servers`
            $query->where('servers.owner_type', $ownerType);
        }

        return $query
            ->pluck('total', 'type')
            ->map(fn ($v) => (float) $v)
            ->toArray();
    }

    public function totalResourcesByTypeNormalized(?string $ownerType = 'player'): array {
        $rawTotals = $this->resources()
            ->where('server_resources.type', '!=', 'motherboard')
            ->when($ownerType !== null, function ($q) use ($ownerType) {
                $q->where('servers.owner_type', $ownerType);
            })
            ->selectRaw('type, COALESCE(SUM(value), 0) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        return collect($rawTotals)->mapWithKeys(function ($value, $type) {

            [$normalized, $unit] = match ($type) {
                'cpu'     => [round($value / 1000, 2), 'GHz'],
                'ram'     => [round($value / 1024, 2), 'GB'],
                'disk'    => [round($value / 1024, 2), 'GB'],
                'network' => [round($value / 1024, 2), 'Gbps'],
                default   => [(float) $value, ''],
            };

            return [$type => [
                'raw'             => (float) $value,
                'normalized'      => $normalized,
                'unit'            => $unit,
                'formatted_value' => trim($normalized . ' ' . $unit),
            ]];
        })->toArray();
    }
}
