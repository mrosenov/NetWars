<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\HardwareParts;
use App\Models\ServerResources;
use App\Models\Servers;
use App\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $hacker = auth()->user();
        $bankAccounts = $hacker->bankAccounts;

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

            'hacker' => $hacker,
            'bankAccounts' => $bankAccounts,
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

    public function json(HardwareParts $hardware) {
        return response()->json([
            'id' => $hardware->id,
            'name' => $hardware->name,
            'price' => Format::moneyHuman($hardware->price),
            'specs' => $hardware->getSpecsLabelAttribute()
        ]);
    }

    public function buy(Request $request) {
        $hacker = auth()->user();

        $data = $request->validate([
            'server_id' => ['required', 'integer', 'exists:servers,id',
                Rule::exists('servers', 'id')->where(function ($q) use ($hacker) {
                    $q->where('owner_type', get_class($hacker))->where('owner_id', $hacker->id);
                })
            ],
            'buy_type' => ['required', 'string', 'in:motherboard,cpu,ram,psu,disk,externalDrive,network,server,internet'],
            'hardware_id' => ['required', 'integer', 'exists:hardware_parts,id'],
            'bankAccount' => ['required', 'string', 'exists:bank_accounts,iban',
                Rule::exists('bank_accounts', 'iban')->where(function ($q) use ($hacker) {
                    $q->where('user_id', $hacker->id);
                }),
            ],
        ]);

        return DB::transaction(function () use ($hacker, $data) {

            // Lock bank account
            $account = BankAccount::where('user_id', $hacker->id)->where('iban', $data['bankAccount'])->lockForUpdate()->firstOrFail();

            // Lock server row (optional but good)
            $server = Servers::whereKey($data['server_id'])->lockForUpdate()->firstOrFail();

            // Lock the hardware being bought
            $hardware = HardwareParts::whereKey($data['hardware_id'])->lockForUpdate()->firstOrFail();

            // Ensure the hardware type matches the buy_type
            if ($hardware->type !== $data['buy_type']) {
                return back()->withErrors([
                    'hardware_id' => 'Selected hardware does not match the requested upgrade type.',
                ])->withInput();
            }

            $price = (float) $hardware->price;

            // Re-check balance under lock (prevents double-spend)
            if ((float) $account->balance < $price) {
                return back()->withErrors(['bankAccount' => 'Insufficient funds.'])->withInput();
            }

            // Lock the "slot" row on server_resources for this server+type
            $slot = ServerResources::where('server_id', $server->id)->whereHas('hardware', fn($q) => $q->where('type', $data['buy_type']))->with('hardware')->lockForUpdate()->first();

            if (!$slot) {
                $slot = new ServerResources();
                $slot->server_id = $server->id;
            }

            // Deduct funds
            $account->balance = (float) $account->balance - $price;
            $account->save();

            // Update installed hardware in that slot
            $slot->hardware_id = $hardware->id;
            $slot->save();

            // TODO: Add logs for purchases, deducting money from which account how much was spent, what was bought. when it was bought, something like server upgrade history with old and new hardware.
            // TODO: Add transaction history for bank account

            return redirect()->back()->with('status', "Purchased {$hardware->name} for \${$price}.");
        });

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
