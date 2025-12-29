@section('title', 'Software')

<x-app-layout>
    <section class="space-y-5">
        {{-- Top Tabs --}}
        <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
            <div class="flex items-center justify-between px-3 py-2">
                <div class="flex items-center gap-2">
                    <a href="#" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white">
                        <span class="grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </span>
                        Logs
                    </a>

                    <a href="#" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold bg-white text-slate-900 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300 dark:bg-white/10 dark:text-white dark:ring-white/10 dark:hover:bg-white/15">
                        <span class="grid h-6 w-6 place-items-center rounded-lg  text-cyan-700 dark:text-cyan-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                            </svg>
                        </span>
                        Software
                    </a>

                    <a href="#" class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-white/5">
                        <span class="grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200">
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="size-5">
                                <path d="M17 16l4-4m0 0l-4-4 m4 4h-14m5 8 H6a3 3 0 01-3-3V7a3 3 0 013-3h7"></path>
                            </svg>
                        </span>
                        Logout
                    </a>
                </div>

                <a href="#" class="rounded-lg bg-cyan-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-400">
                    Help
                </a>
            </div>
        </div>

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
                            @php
                                $rows = [
                                    ['name' => 'Advanced Cracker', 'ext' => 'crc',  'version' => '5.9', 'size' => '696 MB', 'version_color' => 'text-red-500',  'size_color' => 'text-red-500'],
                                    ['name' => 'Basic Cracker',    'ext' => 'crc',  'version' => '1.0', 'size' => '28 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                    ['name' => 'Basic Hasher',     'ext' => 'hash', 'version' => '1.0', 'size' => '26 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                    ['name' => 'Basic Port Scan',  'ext' => 'scan', 'version' => '1.0', 'size' => '23 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                    ['name' => 'Basic Firewall',   'ext' => 'fwl',  'version' => '1.0', 'size' => '23 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                    ['name' => 'Basic Hidder',     'ext' => 'hdr',  'version' => '1.0', 'size' => '17 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                    ['name' => 'Basic Seeker',     'ext' => 'skr',  'version' => '1.0', 'size' => '17 MB',  'version_color' => 'text-green-600','size_color' => 'text-green-600'],
                                ];
                            @endphp

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
                                            <button type="button" data-modal-open="swModal" data-hw-id="{{ $soft->id }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-cyan-600 dark:text-cyan-300">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" stroke="currentColor" stroke-width="2"/>
                                                    <path d="M12 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    <path d="M12 8h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                                </svg>
                                            </button>

                                            <form method="POST" action="{{ route('target.software.download', $soft->id) }}">
                                                @csrf
                                                <button class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-green-500 dark:text-green-400">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                        <path d="M12 3v10m0 0 4-4m-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M4 17v3h16v-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
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
            </div>

            {{-- Right: Upload + Usage --}}
            <div class="w-1/4">
                <div class="space-y-5">
                    {{-- Upload card --}}
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                        <div class="p-5">
                            <button class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                Upload…
                            </button>

                            <div class="mt-4 text-center text-xs text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-700 dark:text-slate-200">1000 Mbit</span>
                                <span class="mx-1">/</span>
                                <span>(125MB/s - 62.5MB/s)</span>
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
                        <div class="grid grid-cols-2 gap-3 p-5 text-sm">
                            <div class="rounded-xl bg-slate-50 p-4 dark:bg-white/5">
                                <div class="text-xs text-slate-500 dark:text-slate-400">Modules</div>
                                <div class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">7</div>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-4 dark:bg-white/5">
                                <div class="text-xs text-slate-500 dark:text-slate-400">Downloads</div>
                                <div class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">1,284</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
