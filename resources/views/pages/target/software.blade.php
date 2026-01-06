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
                                            <form method="POST" action="{{ route('software.destroy', $soft->id) }}">
                                                @csrf
                                                <input type="hidden" name="target" value="remote">
                                                <button title="Delete" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-red-500 dark:orange-red-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
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
                            <div class="mb-5 text-center text-xs text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $connectivity }}</span>
                                <br/>
                                <span>({{ $download }} - {{ $upload }})</span>
                            </div>
                            <form method="POST" action="{{ route('target.software.upload') }}">
                                @csrf
                                <div class="mb-4">
                                    <div class="relative">
                                        <select class="w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-white/10 dark:bg-white/5 dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/20"
                                            name="software_id">
                                            @foreach($hacker->software->groupBy('type') as $type => $software)
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
                        </div>
                    </div>

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
                            HDD Usage
                        </div>

                        <div class="mt-3 text-center text-[11px] text-slate-600 dark:text-slate-300">
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $storageUsed }}</span>
                            <span class="text-slate-400 dark:text-slate-500">/</span>
                            <span class="font-semibold text-red-600/80 dark:text-red-400/80">{{ $storageTotal }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
