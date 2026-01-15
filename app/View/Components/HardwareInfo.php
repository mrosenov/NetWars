<?php

namespace App\View\Components;

use App\Support\Format;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HardwareInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $hacker = auth()->user();

        $resources = $hacker->totalResources();

        $cpu = Format::cpuHuman($resources['clock_mhz']);
        $ram = Format::ramHuman($resources['ram_mb']);
        $storage = Format::storageHuman($resources['storage_mb']);
        $external = Format::storageHuman($resources['external_mb']);
        $connectivity = Format::connectivityHuman($hacker->network->connectivity->specifications['connectivity_mbps']);
        $servers = $hacker->servers;

        return view('components.hardware-info', [
            'cpu' => $cpu,
            'ram' => $ram,
            'storage' => $storage,
            'external' => $external,
            'connectivity' => $connectivity,
            'servers' => $servers,
        ]);
    }
}
