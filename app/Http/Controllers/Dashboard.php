<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index() {
        $user = auth()->user();
        $OverallResources = $user->OverallResources();
        $external = $user->OverallResources()['externalDrive'];
        $servers = $user->servers;
        $connectivity = $user->connectivity()->with('service')->get();

        $hw = new HardwarePartsController();
        $connectivityInfo = $hw->prettyNetwork(data_get($connectivity[0]->service->specifications, 'connectivity_mbps'));

        return view('pages.dashboard.index',
            compact('user','OverallResources', 'external', 'servers', 'connectivityInfo')
        );
    }
}
