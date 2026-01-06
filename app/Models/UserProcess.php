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
        $metadata = $this->metadata;
        $network = UserNetwork::findOrFail($metadata['target_network_id']);

        $hacker = auth()->user();

        if ($network->ip === $hacker->network->ip) {
            $network->ip = 'localhost';
        }
//dd($this->user->cracker);
        if ($this->action === 'bruteforce') {
            $matches = [
                'text' => 'Bruteforce with ' ?? 'Unknown',
                'software' => "{$this->user->cracker->name} v{$this->user->cracker->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'on',
            ];
        }
        elseif ($this->action === 'download') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Downloading ' ?? 'Unknown',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'from',
            ];
        }
        elseif ($this->action === 'upload') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Uploading ' ?? 'Unknown',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'on',
            ];
        }
        elseif ($this->action === 'install') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Installing ' ?? 'Unknown',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'on',
            ];
        }
        elseif ($this->action === 'uninstall') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Uninstalling ' ?? 'Unknown',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'from',
            ];
        }
        elseif ($this->action === 'delete') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Deleting ' ?? 'Unknown',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}" ?? 'Unknown',
                'what' => 'from',
            ];
        }
        elseif ($this->action === 'log') {
            $matches = [
                'text' => 'Edit ',
                'software' => 'log',
                'target' => "{$network->ip}",
                'what' => 'on',
            ];
        }

        return $matches;
    }
}
