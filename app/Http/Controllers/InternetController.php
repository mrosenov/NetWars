<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNetwork;
use App\Services\NetworkLogService;
use Auth;
use Illuminate\Http\Request;

class InternetController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user()->load('network.connected');

        // 1) If user typed an IP in the search bar -> redirect to /internet/{ip}
        if ($request->filled('ip')) {
            $validated = $request->validate([
                'ip' => ['required', 'ip'], // validates IPv4 or IPv6
            ]);

            return redirect()->route('internet.show', ['ip' => $validated['ip']]);
        }

        // 2) Otherwise keep your "auto-redirect to connected ip" behavior
        $ip = $user->network?->connected?->ip ?? null;

        if ($ip) {
            return redirect()->route('internet.show', ['ip' => $ip]);
        }

        return view('pages.internet.index');
    }

    public function show(string $ip) {
        // Optional extra safety (routes already restrict, but this is explicit)
        abort_unless(filter_var($ip, FILTER_VALIDATE_IP), 404);

        $network = UserNetwork::where('ip', $ip)->with(['owner', 'hardware'])->firstOrFail();
        $metadata = $network->owner->metadata;
        $targetType = $this->targetType($ip);

        return view('pages.internet.show',[
            'ip' => $ip,
            'metadata' => $metadata,
            'network' => $network,
            'targetType' => $targetType,
        ]);
    }

    public function login(Request $request, string $ip) {

        abort_unless(filter_var($ip, FILTER_VALIDATE_IP), 404);

        $network = UserNetwork::where('ip', $ip)->with(['owner'])->firstOrFail();

        $hacker = auth()->user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:64'],
            'password' => ['required', 'string', 'max:128'],
        ]);

        $key = "internet.login.attempts.{$network->id}";
        $attempts = (int) session($key, 0);
        if ($attempts >= 6) {
            return back()->with('login_error', 'Too many attempts. Connection temporarily locked.');
        }

        // Pull the “real” credentials from the model (or metadata)
        $realUser = $network->user;
        $realPass = $network->password;

        $ok = ($data['username'] === $realUser) && ($data['password'] === $realPass);

        if (!$ok) {
            session([$key => $attempts + 1]);
            return back()->withInput($request->only('username'))->with('login_error', 'Access denied: invalid credentials.');
        }

        $player = auth()->user();
        $player->network->update([
            'connected_to_network_id' => $network->id,
        ]);

        session()->forget($key);

        if (($network->owner->type ?? null) !== 'download') {
            app(NetworkLogService::class)->appendLine(
                $network->id,
                sprintf(
                    "[%s] - [%s] logged in as root",
                    now()->format('Y-m-d H:i:s'),
                    $hacker->network->ip
                )
            );
        }

//        if ($network->owner instanceof NPC && $network->owner->type =! 'download') {
//            app(NetworkLogService::class)->appendLine($network->id,
//                sprintf("[%s] - [%s] logged in as root", now()->format('Y-m-d H:i:s'), $hacker->network->ip)
//            );
//        }

        return redirect()->route('target.logs')->with('login_ok', 'Login successful. Shell target granted.');
    }

    public function targetType($ip) {
        $network = UserNetwork::where('ip', $ip)->with(['owner', 'hardware'])->firstOrFail();

        $isVpc = isset($network) && $network->owner_type === User::class;

        if ($isVpc) {
            $label = 'VPC';
            $classes = 'bg-green-500/10 text-green-400 inset-ring inset-ring-green-500/20';
        } elseif (isset($network->owner) && $network->owner->type === 'whois') {
            $label = 'WhoIs';
            $classes = 'bg-purple-400/10 text-purple-400 inset-ring inset-ring-purple-400/30';
        } else {
            $label = 'NPC';
            $classes = 'bg-blue-400/10 text-blue-400 inset-ring inset-ring-blue-400/30';
        }

        return ['label' => $label, 'classes' => $classes];
    }

    public function loginShow(string $ip) {
        $targetType = $this->targetType($ip);

        return view('pages.internet.login', [
            'ip' => $ip,
            'targetType' => $targetType,
        ]);
    }

    public function hackShow(string $ip) {
        $targetType = $this->targetType($ip);

        return view('pages.internet.hack', [
            'ip' => $ip,
            'targetType' => $targetType,
        ]);
    }

}
