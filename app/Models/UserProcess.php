<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProcess extends Model
{
    //
    protected $fillable = [
        'user_id',
        'resource_type',
        'action',
        'metadata',
        'work_units',
        'ideal_seconds',
        'cpu_power_snapshot',
        'share_percent',
        'status',
        'started_at',
        'ends_at',
        'completed_at',
        'ideal_done',
        'last_progress_at',
        'remaining_ideal_seconds',
    ];

    protected $casts = [
        'metadata' => 'array',
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_progress_at'  => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function whatAction(): array {

        if ($this->action === 'bruteforce') {
            $metadata = $this->metadata;
            $network = UserNetwork::findOrFail($metadata['target_network_id']);

            $matches = [
                'text' => 'Bruteforce with: ' ?? 'Unknown',
                'software' => "{$this->user->cracker->name} v{$this->user->cracker->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
            ];
        }

        return $matches;
    }
}
