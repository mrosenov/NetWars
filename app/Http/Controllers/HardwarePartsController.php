<?php

namespace App\Http\Controllers;

use App\Models\HardwareParts;
use App\Models\Servers;
use App\Support\Format;
use Illuminate\Http\Request;

class HardwarePartsController extends Controller
{

    public function index() {
        $hacker = auth()->user();
        $servers = $hacker->servers;

        $totalResources = $hacker->totalResources();

        $connectivity = Format::connectivity($hacker->network->connectivity->specifications['connectivity_mbps']);

        return view('pages.hardware.index', [
            'hacker' => $hacker,
            'servers' => $servers,
            'totalCPU' => Format::cpu($totalResources['clock_mhz']),
            'totalDisk' => Format::storage($totalResources['storage_mb']),
            'totalRAM' => Format::ram($totalResources['ram_mb']),
            'totalExternal' => Format::storage($totalResources['external_mb']),
            'connectivity' => $connectivity,
        ]);
    }

    public function server(Servers $server) {
        $InstalledMotherboard = $server->resources->first(fn ($r) => $r->hardware?->type === 'motherboard')?->hardware;
        $InstalledCPU = $server->resources->first(fn ($r) => $r->hardware?->type === 'cpu')?->hardware;
        $InstalledRAM = $server->resources->first(fn ($r) => $r->hardware?->type === 'ram')?->hardware;
        $InstalledSupply = $server->resources->first(fn ($r) => $r->hardware?->type === 'psu')?->hardware;
        $InstalledStorage = $server->resources->first(fn ($r) => $r->hardware?->type === 'disk')?->hardware;
        $InstalledNetwork = $server->owner->network?->hardware;

        return view('pages.hardware.server', [
            'server' => $server,
            'cpus' => $this->getCPUList($server),
            'motherboards' => $this->getMotherboard($server),
            'rams' => $this->getRAMList($server),
            'powerSupplies' => $this->getPSUList($server),
            'storages' => $this->getDiskList($server),
            'networks' => $this->getNetworkList($server),

            'installedMotherboard' => $InstalledMotherboard,
            'installedCPU' => $InstalledCPU,
            'installedRAM' => $InstalledRAM,
            'installedSupply' => $InstalledSupply,
            'installedStorage' => $InstalledStorage,
            'installedNetwork' => $InstalledNetwork,
        ]);
    }

    public function getMotherboard(Servers $server) {
        $server->load(['resources.hardware']);

        $installedMobo = $server->resources->first(fn ($r) => $r->hardware?->type === 'motherboard')?->hardware;

        return HardwareParts::where('type', 'motherboard')->where('specifications->tier', '>=', $installedMobo->specifications['tier'])->orderBy('price', 'asc')->get();
    }

    public function getCPUList(Servers $server) {
        $server->load(['resources.hardware']);

        $motherboard = $server->resources->first(fn ($r) => $r->hardware?->type === 'motherboard')?->hardware;

        $mbSpec = $motherboard?->specifications ?? [];
        $mbSocket = $mbSpec['socket'] ?? null;

        $installedCpuPower = (int) (
            $server->resources->first(fn ($r) => $r->hardware?->type === 'cpu')?->hardware?->specifications['compute_power'] ?? 0
        );

        $cpus = HardwareParts::where('type', 'cpu')
            ->where('specifications->compute_power', '>=', $installedCpuPower)
            ->orderBy('price', 'asc')
            ->get()
            ->map(function ($cpu) use ($mbSocket, $installedCpuPower) {
                $req = $cpu->requirements ?? [];
                $spec = $cpu->specifications ?? [];

                $reasons = [];

                if (($req['socket'] ?? null) !== $mbSocket) {
                    $reasons[] = 'Incompatible socket';
                }

                if (($spec['clock_mhz'] ?? 0) <= $installedCpuPower) {
                    $reasons[] = 'Not an upgrade';
                }

                $cpu->is_compatible = empty($reasons);
                $cpu->disabled_reason = implode(', ', $reasons);

                return $cpu;
            });

        return $cpus;
    }

    public function getRAMList(Servers $server) {
        $server->load(['resources.hardware']);

        $motherboard = $server->resources->first(fn ($r) => $r->hardware?->type === 'motherboard')?->hardware;
        $mbSpec = $motherboard?->specifications ?? [];
        $mbRamType = $mbSpec['ram_type'] ?? null;

        $installedRam = $server->resources->first(fn ($r) => $r->hardware?->type === 'ram')?->hardware;

        $rams = HardwareParts::where('type', 'ram')->where('specifications->tier', '>=', $installedRam->specifications['tier'])->orderBy('price', 'asc')->get()
            ->map(function ($ram) use ($mbRamType) {
                $req = $ram->requirements ?? [];
                $spec = $ram->specifications ?? [];

                $reasons = [];

                if (($req['ram_type'] ?? null) !== $mbRamType) {
                    $reasons[] = 'Incompatible RAM type';
                }

                $ram->is_compatible = empty($reasons);
                $ram->disabled_reason = implode(', ', $reasons);
                return $ram;
            });

        return $rams;
    }

    public function getPSUList(Servers $server) {
        $server->load(['resources.hardware']);
        $installedSupply = $server->resources->first(fn ($r) => $r->hardware?->type === 'psu')?->hardware;

        return HardwareParts::where('type', 'psu')->where('specifications->max_power_w' , '>=', $installedSupply->specifications['max_power_w'])->orderBy('price', 'asc')->get();
    }

    public function getDiskList(Servers $server) {
        $server->load(['resources.hardware']);
        $InstalledStorage = $server->resources->first(fn ($r) => $r->hardware?->type === 'disk')?->hardware;

        return HardwareParts::where('type', 'disk')->where('specifications->capacity_mb', '>=', $InstalledStorage->specifications['capacity_mb'])->orderBy('price', 'asc')->get();
    }

    public function getNetworkList(Servers $server) {
        $server->load('owner.network.hardware');
        $InstalledNetwork = $server->owner->network?->hardware;

        return HardwareParts::where('type', 'network')->where('specifications->bandwidth_mbps', '>=', $InstalledNetwork->specifications['bandwidth_mbps'])->orderBy('price', 'asc')->get();
    }

    public function prettyCpu(float $ghz): array {
        if ($ghz < 1) {
            return ['value' => round($ghz * 1000), 'unit' => 'MHz'];
        }
        return ['value' => round($ghz, 1), 'unit' => 'GHz'];
    }

    public function prettyPSU(int $watts): array {
        if ($watts < 1000) {
            return ['value' => $watts, 'unit' => 'Watt'];
        }

        return ['value' => $watts, 'unit' => 'kW'];
    }

    public function prettyNetwork(int $mbps): array {
        if ($mbps >= 1000) {
            return ['value' => round($mbps / 1000, 1), 'unit' => 'Gbit/s'];
        }
        return ['value' => round($mbps, 0), 'unit' => 'MBit/s'];
    }

    public function prettyRAM(int $mb): array {
        if ($mb < 1024) {
            return [
                'value' => $mb,
                'unit'  => 'MB'
            ];
        }

        if ($mb < 1024 * 1024) {
            return [
                'value' => round($mb / 1024, 1),
                'unit'  => 'GB'
            ];
        }

        return [
            'value' => round($mb / (1024 * 1024), 1),
            'unit'  => 'TB'
        ];
    }

    public function prettyStorage(float $gb): array
    {
        if ($gb < 1) {
            return [
                'value' => round($gb * 1000),
                'unit'  => 'MB'
            ];
        }

        if ($gb < 1000) {
            return [
                'value' => $gb == (int)$gb ? (int)$gb : round($gb, 1),
                'unit'  => 'GB'
            ];
        }

        $value = $gb / 1000;

        return [
            'value' => $value == (int)$value ? (int)$value : round($value, 1),
            'unit'  => 'TB'
        ];
    }
}
