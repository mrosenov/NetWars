@section('title', 'Dashboard')
<x-app-layout>
    <!-- Top grid: Hardware + General info -->
    <section class="grid grid-cols-1 gap-5">
        <!-- Hardware Information -->
        @include('partials.hardwareInfo')
        @php
            $usedGhz  = $usedGhz  ?? 0.15;
            $totalGhz = $totalGhz ?? 1.5;
            $running  = $running  ?? 1;

            $pct = $totalGhz > 0 ? ($usedGhz / $totalGhz) * 100 : 0;
            $pct = max(0, min(100, $pct));
        @endphp

        <div class="w-full max-w-md rounded-2xl border border-white/10 bg-gradient-to-b from-[#15181d] to-[#0f1115] shadow-lg">
            {{-- Header --}}
            <div class="flex items-center gap-2 border-b border-white/10 px-5 py-3">
                <svg class="h-4 w-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="6" height="6"/>
                    <path d="M4 9h3M17 9h3M9 4v3M15 4v3"/>
                </svg>
                <span class="text-sm font-semibold text-slate-200">CPU Usage</span>
            </div>

            {{-- Body --}}
            <div class="px-5 py-4">
                <div class="flex items-end justify-between">
                    <div class="text-2xl font-bold tracking-tight text-cyan-400">
                        {{ rtrim(rtrim(number_format($usedGhz, 2), '0'), '.') }} GHz
                    </div>
                    <div class="text-sm text-slate-400">
                        of {{ rtrim(rtrim(number_format($totalGhz, 2), '0'), '.') }} GHz
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="mt-3 h-2 w-full rounded-full bg-white/10">
                    <div class="h-2 rounded-full bg-cyan-400"
                         style="width: {{ $pct }}%"></div>
                </div>

                {{-- Meta --}}
                <div class="mt-2 text-xs text-slate-400">
                    {{ number_format($pct, 1) }}% utilized<br>
                    {{ $running }} software running
                </div>
            </div>
        </div>

        <!-- Hardware Information -->

        <!-- General Info -->
        {{--                            @include('partials.generalInfo')--}}
        <!-- General Info -->
    </section>

    <!-- Middle grid: News + Wanted + Round + Leaderboard -->
    <section class="grid grid-cols-1 xl:grid-cols-12 gap-5">
        <!-- News feed -->
        {{-- @include('partials.gameNews')--}}
        <!-- News feed -->


        <!-- Right column stack -->
        <div class="xl:col-span-5 grid grid-cols-1 gap-5">
            <!-- FBI Wanted -->
            {{--                                @include('partials.fbiWanted')--}}
            <!-- FBI Wanted -->

            <!-- Round info -->
            {{--                                @include('partials.roundInfo')--}}
            <!-- Round info -->

            <!-- Top users -->
            {{--                                @include('partials.ranking')--}}
            <!-- Top users -->
        </div>
    </section>

    <!-- Announcements table -->
    <section class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
        {{-- @include('partials.announcements')--}}
    </section>
    <!-- Announcements table -->
</x-app-layout>
