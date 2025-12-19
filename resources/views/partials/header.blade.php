<header class="sticky top-0 z-50 border-b border-slate-200/70 bg-slate-50/85 backdrop-blur dark:border-white/10 dark:bg-[#070A0F]/65">
    <div class="mx-auto max-w-[1400px] px-4 sm:px-6">
        <div class="flex h-14 items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                    <!-- grid icon -->
                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-500 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/>
                    </svg>
                </div>

                <div class="leading-tight">
                    <div class="text-[11px] uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">
                        Net Wars
                    </div>
                    <div class="text-sm font-semibold">
                        <span class="glitch animate-glitch" data-text="Control Panel">Control Panel</span>
                        <span class="ml-2 text-[11px] font-normal text-slate-500 dark:text-slate-400">
                    v1.0.0<span class="animate-blink">_</span>
                  </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="hidden sm:flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs shadow-sm dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                    <span class="text-slate-500 dark:text-slate-400">IP</span>
                    <span class="font-semibold tracking-wide text-slate-900 dark:text-slate-100">74.225.236.3</span>
                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                    <span class="text-slate-500 dark:text-slate-400">uptime</span>
                    <span class="text-slate-700 dark:text-slate-200">3d 1h</span>
                </div>

                <div class="hidden md:flex items-center gap-2">
                    <a href="{{route('profile.edit')}}" class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="text-slate-700 dark:text-slate-100">{{ Auth::user()->name }}</span>
                    </a>

                    <a href="#" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                        Settings
                    </a>
                    <!-- Trigger (example) -->
                    <button type="button" data-modal-open="hwModal" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                        Open Modal
                    </button>

                    <button id="themeToggle" class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow" type="button" aria-label="Toggle theme">
                        <svg id="sunIcon" viewBox="0 0 24 24" class="h-4 w-4 text-amber-500 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 3v2M12 19v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M3 12h2M19 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                            <circle cx="12" cy="12" r="4"/>
                        </svg>
                        <svg id="moonIcon" viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:hidden" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>
                        </svg>
                        <span class="text-slate-700 dark:text-slate-100">Mode</span>
                        <span class="rounded-lg bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600 dark:bg-white/10 dark:text-slate-300">CTRL+L</span>
                    </button>

                    <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
