<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $network = Auth::user()?->connectedNetwork();
        return view('layouts.app', [
            'network' => $network
        ]);
    }
}
