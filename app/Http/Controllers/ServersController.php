<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\HardwareParts;
use App\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ServersController extends Controller
{
    public function json(Request $request) {
        $hacker = $request->user();

        $currentServers = $hacker->servers()->count();
        $nextServer = $currentServers + 1;

        // Installed network device
        $netHardware = $hacker->network?->hardware;

        $maxConnections = (int) data_get($netHardware, 'specifications.max_connections', 0);

        // Capacity check: next server must not exceed max_connections
        if ($nextServer > $maxConnections) {
            return response()->json([
                'name' => "Server {$nextServer}",
                'server_number' => $nextServer,
                'reason' => 'Max connections reached, buy better switch.',
            ]);
        }

        if ($nextServer <= 4) {
            $part = HardwareParts::query()->where('category', 'server')->where('type', 'server')->where('requirements->servers_count', $currentServers)->first();

            if (!$part) {
                return response()->json([
                    'name' => "Server {$nextServer}",
                    'server_number' => $nextServer,
                    'reason' => 'Offer not configured',
                ]);
            }

            $price = (float) $part->price;

            return response()->json([
                'name' => "Server - {$nextServer}",
                'price' => Format::moneyHuman($price),
            ]);
        }
        else {
            $basePrice = 25000;
            $steps = intdiv(($nextServer - 4), 3);
            $price = $basePrice + ($steps * 10000);

            return response()->json([
                'name' => "Server - {$nextServer}",
                'price' => Format::moneyHuman($price),
            ]);
        }
    }

    public function buy(Request $request) {
        $hacker = $request->user();

        $data = $request->validate([
            'bankAccount' => ['required', 'string', 'exists:bank_accounts,iban',
                Rule::exists('bank_accounts', 'iban')->where(function ($q) use ($hacker) {
                    $q->where('user_id', $hacker->id);
                }),
            ]
        ]);

        $currentServers = $hacker->servers()->count();
        $nextServer = $currentServers + 1;

        // Installed network device
        $netHardware = $hacker->network?->hardware;

        $maxConnections = (int) data_get($netHardware, 'specifications.max_connections', 0);

        if ($nextServer > $maxConnections) {
            return redirect()->route('user.hardware')->with('error', 'Max connections reached, buy better switch.');
        }

        if ($nextServer <= 4) {
            $part = HardwareParts::query()->where('category', 'server')->where('type', 'server')->where('requirements->servers_count', $currentServers)->first();

            if (!$part) {
                return redirect()->route('user.hardware')->with('error', 'Server offer not found.');
            }

            $price = (float) $part->price;
        }
        else {
            $basePrice = 25000;
            $steps = intdiv(($nextServer - 4), 3);
            $price = $basePrice + ($steps * 10000);
        }

        return DB::transaction(function () use ($hacker, $data, $price, $nextServer) {

            /** Lock bank account */
            $account = BankAccount::where('user_id', $hacker->id)->where('iban', $data['bankAccount'])->lockForUpdate()->firstOrFail();

            /** Re-check balance under lock (prevents double-spend) */
            if ((float) $account->balance < (float) $price) {
                return redirect()->route('user.hardware')->with('error', 'Insufficient balance.');
            }

            /** Deduct funds */
            $account->balance = (float) $account->balance - $price;
            $account->save();

            $server = $hacker->servers()->create([
                'name' => "Server {$nextServer}",
            ]);

            /** Assign starting parts for the server */
            $types = ['motherboard', 'cpu', 'ram', 'disk', 'psu'];

            $startingParts = [];

            foreach ($types as $type) {
                $startingParts[$type] = \App\Models\HardwareParts::query()
                    ->where('type', $type)
                    ->orderByRaw("CAST(JSON_EXTRACT(specifications, '$.tier') AS UNSIGNED) ASC")
                    ->first();
            }

            foreach ($startingParts as $part) {
                $hacker->resources()->create([
                    'server_id' => $server->id,
                    'hardware_id' => $part->id,
                ]);
            }

            $humanPrice = Format::moneyHuman($price);

            return redirect()->route('user.hardware')->with('success', "Purchased {$server->name} for {$humanPrice}.");
        });
    }
}
