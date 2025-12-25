<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNetwork;
use Auth;
use Illuminate\Http\Request;

class InternetController extends Controller
{
    public function index() {
        $user = auth()->user()->load('network.connected');

        $ip = $user->network?->connected?->ip ?? '1.2.3.4';

        return redirect()->route('internet.show', ['ip' => $ip]);
    }

    public function show(string $ip) {
        $network = UserNetwork::where('ip', $ip)->with(['owner', 'hardware'])->firstOrFail();
        $metadata = $network->owner->metadata;

        return view('pages.internet.show', compact('network', 'metadata'));
    }
}
