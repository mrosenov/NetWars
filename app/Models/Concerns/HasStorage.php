<?php

namespace App\Models\Concerns;

use App\Models\ServerSoftwares;
use App\Models\UserProcess;

trait HasStorage
{
    /**
     * Total storage capacity in MB
     */
    public function totalStorageMb(): int
    {
        $totals = $this->totalResources();

        return (int) ($totals['storage_mb'] ?? 0);
    }

    /**
     * Used storage in MB (installed software)
     */
    public function usedStorageMb(): int
    {
        return (int) ServerSoftwares::where('owner_type', static::class)
            ->where('owner_id', $this->id)
            ->sum('size');
    }

    /**
     * Available storage in MB
     */
    public function availableStorageMb(): int
    {
        $total = $this->totalStorageMb();
        $used  = $this->usedStorageMb();

        return max(0, $total - $used);
    }
}
