@section('title', 'My Hardware')

<x-app-layout>
    {{-- Top subnav (tabs) --}}
    @include('pages.hardware.subnav')

    {{-- Main container --}}
    <div class="rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
        {{-- Top resource cards --}}
        <div class="border-b border-slate-200/70 px-5 py-5 dark:border-white/10">
            <div class="flex flex-wrap items-center justify-center gap-3 md:justify-center">
                {{-- CPU --}}
                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white/70 dark:border-white/10 dark:bg-white/5">
                        <svg class="h-5 w-5 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 9h6v6H9z"/><path d="M4 9h3"/><path d="M17 9h3"/><path d="M4 15h3"/><path d="M17 15h3"/><path d="M9 4v3"/><path d="M15 4v3"/><path d="M9 17v3"/><path d="M15 17v3"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $totalCPU['value'] }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $totalCPU['unit'] }}</div>
                    </div>
                </div>

                {{-- HDD / Drive speed --}}
                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white/70 dark:border-white/10 dark:bg-white/5">
                        <svg class="h-5 w-5 text-slate-700 dark:text-slate-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 7h16v10H4z"/><path d="M7 17h.01"/><path d="M10 17h.01"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $totalDisk['value'] }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $totalDisk['unit'] }}</div>
                    </div>
                </div>

                {{-- RAM --}}
                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white/70 dark:border-white/10 dark:bg-white/5">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9h18v6H3z"/><path d="M7 9V7"/><path d="M11 9V7"/><path d="M15 9V7"/><path d="M19 9V7"/><path d="M7 15v2"/><path d="M11 15v2"/><path d="M15 15v2"/><path d="M19 15v2"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $totalRAM['value'] }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $totalRAM['unit'] }}</div>
                    </div>
                </div>

                {{-- Internet --}}
                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white/70 dark:border-white/10 dark:bg-white/5">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"/>
                            <path d="M2 12h20"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $connectivity['value'] }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $connectivity['unit'] }}</div>
                    </div>
                </div>

                {{-- Storage --}}
                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/5">
                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 bg-white/70 dark:border-white/10 dark:bg-white/5">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 2h10v20H7z"/>
                            <path d="M9 6h6"/>
                            <path d="M9 10h6"/>
                            <path d="M9 14h6"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $totalExternal['value'] }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ $totalExternal['unit'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content area --}}
        <div class="p-5">
            <div class="grid grid-cols-1 gap-5 lg:grid-cols-12">
                {{-- Left: server list (bigger) --}}
                <div class="lg:col-span-9">
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-slate-500 dark:text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 7h16v10H4z"/><path d="M7 17h.01"/><path d="M10 17h.01"/>
                                </svg>
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">Servers</div>
                            </div>

                            <a href="#" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-200 dark:hover:bg-white/10">
                                Upgrade
                            </a>
                        </div>

                        <div class="p-5">
                            @forelse($servers ?? [] as $i => $server)
                                @php
                                $cpu = \App\Support\Format::cpu($server->resource_totals['clock_mhz']);
                                $storage = \App\Support\Format::storage($server->resource_totals['storage_mb']);
                                $ram = \App\Support\Format::ram($server->resource_totals['ram_mb']);
                                @endphp
                                <div class="mt-2 rounded-xl border border-slate-200 bg-white/70 p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                        {{-- Left: Title --}}
                                        <div class="flex items-center gap-4">
                                            <div class="grid h-12 w-12 place-items-center rounded-xl border border-slate-200 bg-white dark:border-white/10 dark:bg-white/5">
                                                <svg class="h-6 w-6 text-slate-700 dark:text-slate-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M4 7h16v10H4z"/><path d="M8 21h8"/>
                                                </svg>
                                            </div>

                                            <div class="min-w-0">
                                                <div class="flex items-center gap-3">
                                                    <div class="truncate text-base font-extrabold text-slate-900 dark:text-white">
                                                        Server #{{ $i + 1 }}
                                                    </div>
                                                </div>

                                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                    CPU • Storage • RAM
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Middle: Stat pills --}}
                                        <div class="flex flex-wrap items-center gap-2">
                                            {{-- CPU --}}
                                            <div class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm dark:border-white/10 dark:bg-white/5">
                                                <svg class="h-4 w-4 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9 9h6v6H9z"/><path d="M4 9h3"/><path d="M17 9h3"/>
                                                </svg>
                                                <span class="font-semibold text-slate-900 dark:text-white">{{ $cpu['value'] ?? 0 }}</span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $cpu['unit'] }}</span>
                                            </div>

                                            {{-- Storage --}}
                                            <div class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm dark:border-white/10 dark:bg-white/5">
                                                <svg class="h-4 w-4 text-slate-700 dark:text-slate-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M4 7h16v10H4z"/><path d="M7 17h.01"/><path d="M10 17h.01"/>
                                                </svg>
                                                <span class="font-semibold text-slate-900 dark:text-white">{{ $storage['value'] ?? 0 }}</span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $storage['unit'] }}</span>
                                            </div>

                                            {{-- RAM --}}
                                            <div class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm dark:border-white/10 dark:bg-white/5">
                                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M3 9h18v6H3z"/>
                                                </svg>
                                                <span class="font-semibold text-slate-900 dark:text-white">{{ $ram['value'] ?? 0 }}</span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $ram['unit'] }}</span>
                                            </div>
                                        </div>

                                        {{-- Right: Stability + Button --}}
                                        <div class="flex items-center justify-between gap-4 lg:justify-end">
                                            <a href="{{ route('user.hardware.server', $server->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:border-cyan-300 hover:text-cyan-700 dark:border-white/10 dark:bg-white/5 dark:text-slate-200 dark:hover:bg-white/10 dark:hover:border-cyan-400/40 dark:hover:text-cyan-300 focus:outline-none focus:ring-2 focus:ring-cyan-400/40">
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M12 3v18"/>
                                                    <path d="M5 10l7-7 7 7"/>
                                                </svg>
                                                Upgrade
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 dark:border-white/10 dark:text-slate-400">
                                    No servers yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right: small “blank” space (as in screenshot) / optional panel --}}
                <div class="lg:col-span-3">
                    <div class="rounded-2xl border border-slate-200 bg-white/70 p-5 shadow-sm dark:border-white/10 dark:bg-white/5">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">Summary</div>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            This area can be used for quick actions, tips, or a small chart later.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
