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

    public function whatAction2(): array {
        $metadata = $this->metadata;
        $network = UserNetwork::findOrFail($metadata['target_network_id']);

        $hacker = auth()->user();

        if ($network->ip === $hacker->network->ip) {
            $network->ip = 'localhost';
        }

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
            $software = !empty($metadata['software_id']) ? ServerSoftwares::findOrFail($metadata['software_id']) : ExternalSoftware::findOrFail($metadata['external_software_id']);
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
        elseif ($this->action === 'copy') {
            $software = ExternalSoftware::findOrFail($metadata['external_software_id']);
            $matches = [
                'text' => 'Copying ',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "{$network->ip}",
                'what' => 'to',
            ];
        }
        elseif ($this->action === 'backup') {
            $software = ServerSoftwares::findOrFail($metadata['software_id']);
            $matches = [
                'text' => 'Backup ',
                'software' => "{$software->name} v{$software->version}" ?? 'Unknown',
                'target' => "External Drive",
                'what' => 'on',
            ];
        }

        return $matches;
    }

    public function whatAction(array $ctx = []): array
    {
        $meta = $this->metadata ?? [];

        $networksById = $ctx['networksById'] ?? collect();
        $softwareById = $ctx['softwareById'] ?? collect();
        $externalById = $ctx['externalById'] ?? collect();
        $hackerIp = $ctx['hacker_ip'] ?? null;

        $network = $networksById->get($meta['target_network_id'] ?? null);
        $ip = $network?->ip ?? 'Unknown';

        if ($hackerIp && $network && $network->ip === $hackerIp) {
            $ip = 'localhost';
        }

        $softwareStr = function () use ($meta, $softwareById, $externalById) {
            if (!empty($meta['software_id'])) {
                $s = $softwareById->get($meta['software_id']);
                return $s ? "{$s->name} v{$s->version}" : 'Unknown';
            }
            if (!empty($meta['external_software_id'])) {
                $s = $externalById->get($meta['external_software_id']);
                return $s ? "{$s->name} v{$s->version}" : 'Unknown';
            }
            return 'Unknown';
        };

        $make = fn ($text, $software, $what, $target = null) => [
            'text' => $text,
            'software' => $software ?: 'Unknown',
            'target' => $target ?? $ip,
            'what' => $what,
        ];

        return match ($this->action) {
            'bruteforce' => $make(
                'Bruteforce with',
                $this->user?->cracker ? "{$this->user->cracker->name} v{$this->user->cracker->version}" : 'Unknown',
                'on'
            ),
            'download' => $make('Downloading', $softwareStr(), 'from'),
            'upload' => $make('Uploading', $softwareStr(), 'on'),
            'install' => $make('Installing', $softwareStr(), 'on'),
            'uninstall' => $make('Uninstalling', $softwareStr(), 'from'),
            'delete' => $make('Deleting', $softwareStr(), 'from'),
            'copy' => $make('Copying', $softwareStr(), 'to'),
            'log' => $make('Edit', 'log', 'on'),
            'backup' => $make('Backup', $softwareStr(), 'on', 'External Drive'),
            default => $make('Unknown', 'Unknown', 'on'),
        };
    }
}
