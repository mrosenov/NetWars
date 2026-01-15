<?php

namespace App\View\Components;

use App\Http\Controllers\UserProcessController;
use App\Models\UserProcess;
use App\Support\Format;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public string $active;

    /**
     * Create a new component instance.
     */
    public function __construct(string $active = '')
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $ramUsage = app(UserProcessController::class)->UserRamUsage();

        // Some dumbass way for the routes, but this is the fastest way I could think of at the moment, at least better than dealing with tons of HTML.
        $routes = [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'home'
            ],
            [
                'label' => 'Task Manager',
                'route' => 'tasks.index',
                'icon' => 'activity'
            ],
            [
                'label' => 'Software',
                'route' => 'software.index',
                'icon' => 'folder-code'
            ],
            [
                'label' => 'Internet',
                'route' => 'internet.index',
                'icon' => 'globe'
            ],
            [
                'label' => 'Network Log',
                'route' => 'user.logs',
                'icon' => 'file-pen-line'
            ],
            [
                'label' => 'Hardware',
                'route' => 'user.hardware',
                'icon' => 'hard-drive'
            ],
        ];

        return view('components.sidebar', [
            'routes' => $routes,
            'ramUsage' => $ramUsage,
        ]);
    }
}
