{{-- New header --}}
<header class="fixed top-0 left-0 right-0 h-14 bg-background-secondary border-default border-b border-border z-40 flex items-center justify-between px-4 shadow-lg">
    <div class="flex items-center gap-4">
        <!-- Mobile menu button (only visible on small screens) -->
        <button id="sidebarToggle" class="p-1 hover:text-accent-primary transition-colors lg:hidden" aria-label="Open menu" aria-controls="sidebar" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M4 5h16"/>
                <path d="M4 12h16"/>
                <path d="M4 19h16"/>
            </svg>
        </button>
        <div class="flex items-center gap-2 group cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-accent-primary group-hover:rotate-12 transition-transform">
                <path d="M12 19h8"/>
                <path d="m4 17 6-6-6-6"/>
            </svg>
            <h1 class="text-xl font-bold tracking-tighter hover-glitch">
                Net<span class="text-accent-primary">Wars</span>
            </h1>
        </div>
    </div>

    <div class="flex items-center gap-6">
        {{-- ONE HEADER BUTTON -> DROPDOWN WITH ALL STATS --}}
        <div class="relative" x-data="{ open:false }">
            <button type="button" @click="open = !open" @keydown.escape.window="open=false" class="flex items-center gap-2 px-3 py-2 rounded-lg border border-border bg-background-secondary text-text-secondary hover:text-accent-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
                </svg>
                <span class="text-xs font-semibold tracking-wide">Info</span>
                <svg class="w-3 h-3 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z" clip-rule="evenodd"/>
                </svg>
            </button>

            {{-- Dropdown / panel --}}
            <div x-show="open" x-transition @click.outside="open=false" class="fixed left-1/2 -translate-x-1/2 top-16 md:absolute md:left-auto md:top-auto md:right-0 md:mt-2 md:translate-x-0 w-[min(92vw,380px)] rounded-xl border border-border bg-background-secondary shadow-lg p-4 text-xs z-50">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">IP</span>
                        <span class="text-accent-primary font-bold tracking-widest">{{ $network->ip }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">Username</span>
                        <span class="text-text-primary font-semibold">{{ $network->user }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">Password</span>
                        <span class="flex items-center gap-2">
                            <span class="text-text-primary font-bold">{{ $network->password }}</span>
                            <a href="#" class="text-text-secondary hover:text-accent-primary">
                                [ CHANGE ]
                            </a>
                        </span>
                    </div>

                    <div class="h-px bg-border-primary/60 my-2"></div>

                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">Uptime</span>
                        <span class="text-text-primary font-semibold">2026-01-15 12:00</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">Money</span>
                        <span class="text-accent-primary font-semibold">{{ $balance }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-text-secondary">Online players</span>
                        <span class="text-text-primary font-semibold">1000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs text-text-secondary border-l border-border border-default pl-4">
            {{-- Mission Alert Button --}}
            <button id="openMissionModal" class="relative p-2 hover:text-accent-primary transition-colors group mr-2" aria-label="View alerts" aria-controls="missionModal" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 group-hover:animate-swing">
                    <path d="M10.268 21a2 2 0 0 0 3.464 0"/>
                    <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
            </button>

            <!-- Desktop user links -->
            <div class="hidden lg:flex items-center gap-2">
                <a href="#" class="flex items-center gap-1 hover:text-accent-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg> mrosenov
                </a>
                <a href="#" class="flex items-center gap-1 hover:text-accent-primary transition-colors ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg> Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{route('logout')}}" onclick="event.preventDefault();this.closest('form').submit();" class="group inline-flex items-center gap-2 px-3 py-2 text-xs hover:text-red-500 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 16l4-4m0 0l-4-4 m4 4h-14m5 8 H6a3 3 0 01-3-3V7a3 3 0 013-3h7"></path>
                        </svg>
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>

            <!-- Mobile user dropdown (only on small screens) -->
            <div class="relative lg:hidden">
                <button id="userMenuButton" class="flex items-center gap-1 p-2 hover:text-accent-primary transition-colors" aria-label="User menu" aria-controls="userMenu" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 opacity-80">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

                <div id="userMenu" class="absolute right-0 mt-2 w-44 bg-background-secondary border border-default border-border shadow-lg hidden z-50">
                    <div class="px-3 py-2 text-xs text-text-secondary border-b border-border border-default">
                        Signed in as <span class="text-text-primary font-bold">mrosenov</span>
                    </div>
                    <a href="#" class="block px-3 py-2 text-xs hover:bg-background-primary/10 hover:text-accent-primary transition-colors">
                        Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{route('logout')}}" onclick="event.preventDefault();this.closest('form').submit();" class="group inline-flex items-center gap-2 px-3 py-2 text-xs hover:text-red-500 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17 16l4-4m0 0l-4-4 m4 4h-14m5 8 H6a3 3 0 01-3-3V7a3 3 0 013-3h7"></path>
                            </svg>
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
            <div class="ml-2">
                <button class="p-2 rounded-none border border-default border-border hover:bg-background-primary/10/10 transition-colors group relative overflow-hidden" aria-label="Toggle theme" id="themeToggle" aria-pressed="false">
                    <div class="relative z-10">
                        <svg id="themeIconMoon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:-rotate-12">
                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                        </svg>
                        <svg id="themeIconSun" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:rotate-90 hidden">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2"></path>
                            <path d="M12 20v2"></path>
                            <path d="m4.93 4.93 1.41 1.41"></path>
                            <path d="m17.66 17.66 1.41 1.41"></path>
                            <path d="M2 12h2"></path>
                            <path d="M20 12h2"></path>
                            <path d="m6.34 17.66-1.41 1.41"></path>
                            <path d="m19.07 4.93-1.41 1.41"></path>
                        </svg>
                    </div>
                    <div class="absolute inset-0 bg-accent-primary/5 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                </button>
            </div>
        </div>
    </div>
</header>
