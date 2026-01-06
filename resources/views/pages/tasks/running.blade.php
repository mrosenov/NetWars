@section('title', 'Running software')

<x-app-layout>
    @include('pages.tasks.subnav')

{{--    @php--}}
{{--        // Example expected vars (adapt to your controller)--}}
{{--        // $running = collection of running softwares--}}
{{--        // each: name, type, version, ram_mb--}}
{{--        // $ramUsedMb, $ramTotalMb--}}

{{--        $ramUsedMb  = $ramUsedMb  ?? 24;--}}
{{--        $ramTotalMb = $ramTotalMb ?? 256;--}}

{{--        $pct = $ramTotalMb > 0 ? round(($ramUsedMb / $ramTotalMb) * 100) : 0;--}}
{{--        $pct = max(0, min(100, $pct));--}}
{{--    @endphp--}}

    <div class="flex flex-col gap-5 lg:flex-row">
        <!-- LEFT: TABLE (bigger) -->
        <div class="w-full lg:flex-1">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                <div class="flex items-center gap-2 border-b border-slate-200/70 bg-white/40 px-4 py-3 text-xs text-slate-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                    <div class="inline-flex items-center gap-2">
                    <span class="grid size-6 place-items-center rounded-md border border-slate-200 bg-white/80 dark:border-white/10 dark:bg-white/5">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </span>
                        <span class="font-semibold text-slate-800 dark:text-slate-100">Running software</span>
                    </div>
                </div>

                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[58%]" />
                        <col class="w-[12%]" />
                        <col class="w-[15%]" />
                        <col class="w-[15%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 bg-white/40 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400">
                        <th class="px-4 py-3 font-semibold">Software name</th>
                        <th class="px-4 py-3 font-semibold">Version</th>
                        <th class="px-4 py-3 font-semibold">RAM usage</th>
                        <th class="px-4 py-3 font-semibold text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach($running as $task)
                        @php
                            $taskRam = (float)($task->usage ?? 0);
                            $rowPct = $ramTotal['value'] > 0 ? round(($taskRam / $ramTotal['value']) * 100, 1) : 0;
                        @endphp

                        <tr class="align-middle hover:bg-slate-50/70 transition dark:hover:bg-white/5">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="grid size-7 place-items-center rounded-md border border-slate-200 bg-white/80 text-slate-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" d="M4 6h16v12H4z" />
                                            <path stroke-linecap="round" d="M7 9h10M7 12h6" />
                                        </svg>
                                    </span>

                                    <div class="min-w-0">
                                        <div class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">
                                            {{ $task->software->name }}.{{ $task->software->type }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                    {{ $task->software->version }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-slate-700 dark:text-slate-200">
                                    <span class="font-semibold">{{ (int)$task->usage_formatted['value'] }} {{ $task->usage_formatted['unit'] }}</span>
                                    <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">{{ $rowPct }}%</span>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-3 text-slate-500 dark:text-slate-400">

                                    <!-- INFO -->
                                    <button type="button" data-modal-open="swModal" data-hw-id="{{ $task->software->id }}" aria-label="Info" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-cyan-600 hover:text-cyan-700 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 dark:text-cyan-300 dark:hover:text-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-400/40">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M12 8h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </button>

                                    <!-- STOP -->
                                    <form method="POST" action="{{ route('tasks.uninstall', $task->id) }}">
                                        @csrf
                                        <button type="submit" aria-label="Stop" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-red-50 text-red-500 hover:text-red-600 dark:border-white/10 dark:bg-white/5 dark:hover:bg-red-500/10 dark:text-red-400 dark:hover:text-red-300 focus:outline-none focus:ring-2 focus:ring-red-400/40" >
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <rect x="5.25" y="5.25" width="13.5" height="13.5" rx="2.25" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT: RAM GAUGE (smaller) -->
        <div class="w-full lg:w-[260px]">
            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                @php
                    $r = 42;
                    $c = 2 * M_PI * $r;
                    $offset = $c - ($c * ($pct / 100));
                @endphp

                <div class="mt-2 flex items-center justify-center">
                    <div class="relative">
                        <!-- SVG -->
                        <svg width="128" height="128" viewBox="0 0 128 128" class="block">
                            <circle cx="64" cy="64" r="{{ $r }}" class="text-slate-200 dark:text-white/10" stroke="currentColor" stroke-width="10" fill="none" />
                            <circle cx="64" cy="64" r="{{ $r }}" class="text-emerald-500/80 dark:text-emerald-400/80" stroke="currentColor" stroke-width="10" fill="none" stroke-linecap="round" stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $offset }}" transform="rotate(-90 64 64)" />
                        </svg>

                        <!-- % centered better -->
                        <div class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-[58%] text-xl font-bold text-slate-900 dark:text-white">
                            {{ $pct }}%
                        </div>
                    </div>
                </div>
                <div class="mt-1 text-center text-[11px] font-semibold tracking-wide text-slate-500 dark:text-slate-400">
                    RAM Usage
                </div>

                <div class="mt-3 text-center text-[11px] text-slate-600 dark:text-slate-300">
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $ramUsed['value'] }} {{ $ramUsed['unit'] }}</span>
                    <span class="text-slate-400 dark:text-slate-500">/</span>
                    <span class="font-semibold text-red-600/80 dark:text-red-400/80">{{ $ramTotal['value'] }} {{ $ramTotal['unit'] }}</span>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
