<?php

namespace App\View\Components;

use App\Support\Format;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
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
        $network = $hacker->network;
        $balance = Format::moneyHuman($hacker->totalBalance());

        return view('components.header', [
            'hacker' => $hacker,
            'network' => $network,
            'balance' => $balance,
        ]);
    }
}
