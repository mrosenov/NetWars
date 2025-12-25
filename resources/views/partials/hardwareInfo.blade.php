@php use Illuminate\Support\Facades\Auth; @endphp
<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glowGreen">
    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
        <div class="flex items-center gap-3">
            <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
              <svg viewBox="0 0 24 24" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v10H4z"/><path d="M8 20h8"/><path d="M12 14v6"/>
              </svg>
            </span>
            <div>
                <div class="text-sm font-semibold">Hardware Information</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">Active servers: {{count(Auth::user()->servers)}}</div>
            </div>
        </div>
        <span class="rounded-lg bg-green-500/10 px-2 py-1 text-[10px] font-semibold text-green-700 dark:text-green-300">
            STABLE
        </span>
    </div>

    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Metric card -->
            @foreach(Auth::user()->OverallResources() as $key => $resource)

                @if($key == 'externalDrive')
                    @continue
                @endif

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $key }}
                        </div>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400">0%</span>
                    </div>

                    <div class="mt-2 flex items-end justify-between">
                        <div class="text-lg font-semibold">
                            0 / {{ number_format($resource['value'], 1) }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            {{ $resource['unit'] }}
                        </div>
                    </div>

                    <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-white/10 overflow-hidden">
                        <div class="h-2 rounded-full bg-gradient-to-r from-cyan-400/70 to-green-500/70 transition-all duration-300" style="width: 50%"></div>
                    </div>
                </div>
            @endforeach

            @php
                $external = Auth::user()->OverallResources()['externalDrive'];
            @endphp
            <div class="lg:col-span-4 sm:col-span-2 rounded-xl border border-slate-200 bg-white p-4 shadow-sm
            dark:border-white/10 dark:bg-[#0B1020]/40">

                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">External HDD</div>
                    @if ($external['value'] > 0)
                        <a href="#"
                           class="rounded-lg bg-emerald-100 px-2 py-1 text-[10px] font-semibold text-emerald-700
                      dark:bg-emerald-500/10 dark:text-emerald-300">
                            {{ $external['value'] }} {{ $external['unit'] }}
                        </a>
                    @else
                        <span class="rounded-lg bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600
                         dark:bg-white/10 dark:text-slate-300">
                            NONE
                        </span>
                    @endif
                </div>

                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                    @if ($external['value'] > 0)
                        External storage available. Click to access attached volumes.
                    @else
                        No external volumes detected. Attach drive to enable offline payload storage.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
