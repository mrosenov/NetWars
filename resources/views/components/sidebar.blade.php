<aside id="sidebar" class="fixed left-0 top-14 h-[calc(100vh-3.5rem)] bg-background-secondary border-default border-r border-border transition-all duration-300 z-40 overflow-y-auto w-64 -translate-x-full lg:translate-x-0" data-collapsed="false"> {{-- 'w-64 -translate-x-full lg:translate-x-0' --}}
    <div class="py-4">
        <div class="px-3 pb-3 flex items-center justify-between">
            <!-- Desktop collapse button removed per requirements (menu stays expanded on large screens) -->
            <button id="sidebarCollapse" class="hidden" aria-hidden="true" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
            </button>
        </div>
        <nav class="space-y-1 px-2">
            @foreach($routes as $route)
                @php
                    $active = $route['active'] ?? $route['route'];
                    $isActive = is_array($active) ? request()->routeIs(...$active) : request()->routeIs($active);
                @endphp
                <a href="{{ route($route['route']) }}" class="group flex items-center px-3 py-2.5 text-sm font-medium transition-all duration-200 border-l-2 border-transparent hover:bg-[var(--bg-primary)] hover:border-text-accent-primary {{ $isActive ? 'text-accent-primary bg-background-primary' : 'text-text-secondary group-hover:text-accent-primary' }}">
                    <x-dynamic-component :component="'lucide-' . $route['icon']" class="mr-3 h-4 w-4 transition-colors {{ $isActive ? 'text-accent-primary' : 'text-text-secondary group-hover:text-accent-primary' }}" />
                    <span class="flex-1 sidebar-label">{{ $route['label'] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 opacity-0 group-hover:opacity-100 text-accent-primary transition-opacity sidebar-arrow {{ $isActive ? 'opacity-100' : '' }}">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- System Status Footer --}}
    <div class="absolute bottom-0 w-full p-4 border-t border-border border-default bg-background-secondary text-xs text-text-secondary sidebar-footer">
        <div class="flex justify-between mb-1">
            <span>CPU</span>
            <span class="text-accent-primary">12%</span>
        </div>
        <div class="w-full bg-background-primary h-1 mb-2">
            <div class="bg-[var(--accent-primary)] h-1 w-[12%]"></div>
        </div>
        <div class="flex justify-between mb-1">
            <span>RAM</span>
            <span class="text-accent-secondary">{{ $ramUsage['pct'] }}%</span>
        </div>
        <div class="w-full bg-background-primary h-1">
            <div class="bg-[var(--accent-secondary)] h-1 w-[{{ $ramUsage['pct'] }}%]"></div>
        </div>
    </div>
</aside>
