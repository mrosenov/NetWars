@section('title', 'Software')

@push('breadcrumbs')
    <span>/</span>
    <a href="{{ route('internet.index') }}" class="hover:text-slate-700 dark:hover:text-slate-200">Internet</a>

    <span>/</span>
    <a href="{{ route('internet.show', $network->ip) }}" class="hover:text-slate-700 dark:hover:text-slate-200">
        {{ $network->ip }}
    </a>
@endpush

<x-app-layout>
    <section class="space-y-5">
        @include('pages.internet.partials.search')
        {{-- Top Tabs --}}
        @include('pages.target.subnav')
        {{-- Top Tabs --}}

        @if (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif

        {{-- Main Layout --}}
        <div class="flex flex-col lg:flex-row gap-5 items-start">
            {{-- Left: Software Table --}}
            <div class="w-3/4">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">Software</div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                            <tr class="bg-slate-50 text-xs text-slate-500 dark:bg-white/5 dark:text-slate-400">
                                <th class="w-10 px-4 py-2 text-left font-medium"></th>
                                <th class="px-4 py-2 text-left font-medium">Software name</th>
                                <th class="px-4 py-2 text-left font-medium">Version</th>
                                <th class="px-4 py-2 text-left font-medium">Size</th>
                                <th class="px-4 py-2 text-left font-medium">Actions</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                            @foreach($software as $soft)
                                <tr class="hover:bg-slate-50/70 transition dark:hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-amber-500/10 text-amber-700 dark:text-amber-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                            </svg>
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">
                                        {{ $soft['name'] }}<span class="text-slate-400 dark:text-slate-500">.{{ $soft['type'] }}</span>
                                    </td>

                                    <td class="px-4 py-3 font-semibold {{ $soft['version_color'] }}">
                                        {{ $soft['version'] }}
                                    </td>

                                    <td class="px-4 py-3 font-semibold {{ $soft['size_color'] }}">
                                        {{ $soft->convertSize()['size'] }}{{ $soft->convertSize()['unit'] }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                                            <button title="Info" type="button" data-modal-open="swModal" data-hw-id="{{ $soft->id }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-cyan-600 dark:text-cyan-300">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/>
                                                    <path d="M12 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    <path d="M12 8h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                </svg>
                                            </button>

                                            <form method="POST" action="{{ route('target.software.download', $soft->id) }}">
                                                @csrf
                                                <input type="hidden" name="action" value="download">
                                                <button title="Download" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-green-500 dark:text-green-400">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                        <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M4 17v3h16v-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            @if(!$soft->isRunning())
                                                <form method="POST" action="{{ route('tasks.install', $soft->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="install">
                                                    <input type="hidden" name="target" value="remote">
                                                    <button title="Install" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-orange-500 dark:orange-green-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('tasks.uninstall', $soft->runningInstance->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="uninstall">
                                                    <button title="Uninstall" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-red-500 dark:orange-red-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 0 1 7.5 5.25h9a2.25 2.25 0 0 1 2.25 2.25v9a2.25 2.25 0 0 1-2.25 2.25h-9a2.25 2.25 0 0 1-2.25-2.25v-9Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right: Upload + Usage --}}
            <div class="w-1/4">
                <div class="space-y-5">
                    {{-- Upload card --}}
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                        <div class="p-5">

                            {{-- Dropdown (matches your existing style) --}}
                            <form method="POST" action="{{ route('target.software.upload') }}">
                                @csrf
                                <div class="mb-4">
                                    <div class="relative">
                                        <select class="w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-white/10 dark:bg-white/5 dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/20"
                                            name="software_id">
                                            @foreach($user->software->groupBy('type') as $type => $software)
                                                <optgroup label="{{ strtoupper($type) }}">
                                                    @foreach($software as $soft)
                                                        <option value="{{ $soft->id }}">
                                                            {{ $soft->name }} (v{{ number_format($soft->version, 1) }})
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                    Upload
                                </button>
                            </form>
                            <div class="mt-4 text-center text-xs text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $network->connectivity->specifications['connectivity_mbps'] }} Mbps</span>
                                <span class="mx-1">/</span>
                                <span>({{ $targetNetTotalsMb['down_mbps'] }}MB/s - {{ $targetNetTotalsMb['up_mbps'] }}MB/s)</span>
                            </div>

                            <div class="mt-6 flex flex-col items-center">
                                <div class="relative grid place-items-center rounded-full" style="width: 230px;height: 230px;background: conic-gradient(#{{$TargetUsage['circleChart']['ChartColor']}} {{ $TargetUsage['circleChart']['PercentageStorage'] }}%, rgba(148,163,184,.35) 0);">
                                    <div class="grid place-items-center rounded-full bg-white dark:bg-[#14161b]"
                                         style="width: 186px; height: 186px;">
                                        <div class="text-3xl font-semibold text-slate-900 dark:text-slate-400 drop-shadow">
                                            {{ $TargetUsage['circleChart']['PercentageStorage'] }}%
                                        </div>
                                    </div>

                                    <div class="pointer-events-none absolute inset-0 rounded-full"
                                         style="background: radial-gradient(circle at center, transparent 60%, transparent 60%),
                                         repeating-conic-gradient(rgba(15,23,42,.18) 0 2deg, transparent 2deg 12deg);
                                         -webkit-mask: radial-gradient(circle, transparent 63%, #000 64%);
                                         mask: radial-gradient(circle, transparent 63%, #000 64%);">

                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <div class="text-base font-semibold text-slate-900 dark:text-white">HDD Usage</div>
                                    <div class="mt-1 text-sm">
                                        <span class="font-semibold text-green-600">
                                            {{ number_format($TargetUsage['usedStorage']['totalUsed'], 2) }} {{ $TargetUsage['usedStorage']['unit'] }}
                                        </span>
                                        <span class="text-slate-400 dark:text-slate-500">/</span>
                                        <span class="font-semibold text-red-600">
                                            {{ number_format($TargetUsage['totalStorage']['capacity'], 2) }} {{ $TargetUsage['totalStorage']['unit'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Optional: quick stats card (fits your existing style) --}}
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                        <div class="border-b border-slate-200/70 px-5 py-4 text-sm font-semibold dark:border-white/10">
                            Quick Stats
                        </div>
                        <div class="grid grid-cols-1 gap-1 p-5 text-sm">
                            <div class="rounded-xl bg-slate-50 p-4 dark:bg-white/5">
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    Next software reset: 1 minutes
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
