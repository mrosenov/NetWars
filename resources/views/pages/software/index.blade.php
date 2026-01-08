@section('title', 'Software')

<x-app-layout>

    @include('pages.software.subnav')
    @if (session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert type="danger">
            {{ session('error') }}
        </x-alert>
    @endif
    <div class="flex flex-col gap-5 lg:flex-row">
            <div class="w-full lg:flex-1">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                    <div class="flex items-center gap-2 border-b border-slate-200/70 bg-white/40 px-4 py-3 text-xs text-slate-600 dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                        <div class="inline-flex items-center gap-2">
                            <span class="grid size-6 place-items-center rounded-md border border-slate-200 bg-white/80 dark:border-white/10 dark:bg-white/5">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                                </svg>
                            </span>
                            <span class="font-semibold text-slate-800 dark:text-slate-100">File System</span>
                        </div>
                    </div>

                    <table class="w-full table-fixed">
                        <colgroup>
                            <col class="w-[58%]" />
                            <col class="w-[12%]" />
                            <col class="w-[10%]" />
                            <col class="w-[20%]" />
                        </colgroup>

                        <thead>
                            <tr class="border-b border-slate-200/70 bg-white/40 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400">
                                <th class="px-4 py-3 font-semibold">Software name</th>
                                <th class="px-4 py-3 font-semibold">Version</th>
                                <th class="px-4 py-3 font-semibold">Size</th>
                                <th class="px-4 py-3 font-semibold text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                            @foreach($software as $soft)
                                @php
                                    $softSize = \App\Support\Format::storageHuman($soft->size);
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
                                                    {{ $soft->name }}.{{ $soft->type }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                            {{ $soft->version }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="text-sm text-slate-700 dark:text-slate-200">
                                            <span class="font-semibold">{{ $softSize }}</span>
                                        </div>
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
                                            @if($hacker->isConnected())
                                                <form method="POST" action="{{ route('target.software.upload') }}">
                                                    @csrf
                                                    <input type="hidden" name="software_id" value="{{ $soft->id }}">
                                                    <button title="Upload to {{ $hacker->connectedNetwork()->ip }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-green-500 dark:text-green-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            @if(!$soft->isRunning())
                                                <form method="POST" action="{{ route('tasks.install', $soft->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="install">
                                                    <input type="hidden" name="target" value="local">
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
                                                <input type="hidden" name="target" value="local">
                                                <button title="Delete" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-red-500 dark:orange-red-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('software.external.backup', $soft->id) }}">
                                                @csrf
                                                <button title="Backup" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:hover:bg-white/10 text-fuchsia-500 dark:fuchsia-red-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
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

            <!-- RIGHT: HDD GAUGE (smaller) -->
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
</x-app-layout>
