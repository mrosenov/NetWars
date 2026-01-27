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

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_550px] gap-4">
            <x-ui.card title="Software">
                <x-slot:icon>
                    <x-lucide-folder-archive class="w-5 h-5" />
                </x-slot:icon>

                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-text-secondary uppercase bg-background-secondary/50 border-b border-border border-default">
                        <tr>
                            <th scope="col" class="px-4 py-2 w-40">Software</th>
                            <th scope="col" class="px-4 py-2 w-32">Version</th>
                            <th scope="col" class="px-4 py-2 w-28">Size</th>
                            <th scope="col" class="px-4 py-2 w-16 text-left">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($software as $soft)
                        @php
                            $softSize = \App\Support\Format::storageHuman($soft->size);
                        @endphp
                        <tr class="hover:bg-background-secondary transition-colors border border-border">
                            <td class="px-4 py-3 text-slate-700 dark:text-white/80 font-mono text-md whitespace-nowrap font-bold">
                                {{ $soft->name }}.{{ $soft->type }}
                            </td>

                            <td class="px-4 py-3 font-mono text-xs font-bold whitespace-nowrap text-emerald-600 dark:text-emerald-400">
                                {{ $soft->version }}
                            </td>

                            <td class="px-4 py-3 text-slate-700 dark:text-white/80 font-mono text-md whitespace-nowrap font-bold">
                                {{ $softSize }}
                            </td>

                            <td class="px-4 py-3 text-left text-text-secondary text-xs whitespace-nowrap">
                                <div class="flex justify-start gap-2">
                                    <button type="submit" data-modal-open="swModal" data-hw-id="{{ $soft->id }}" aria-label="Info" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-blue-500/40 dark:hover:bg-blue-500/10 dark:hover:text-blue-300">
                                        <x-lucide-info class="w-5 h-5" />
                                    </button>

                                    <form method="POST" action="{{ route('target.software.download', $soft->id) }}">
                                        @csrf
                                        <input type="hidden" name="action" value="download">
                                        <button title="Download" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-green-300 hover:text-green-600 hover:bg-green-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-green-500/40 dark:hover:bg-green-500/10 dark:hover:text-green-300">
                                            <x-lucide-download-cloud class="w-5 h-5" />
                                        </button>
                                    </form>

                                    @if(!$soft->isRunning())
                                        <form method="POST" action="{{ route('tasks.install', $soft->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="install">
                                            <input type="hidden" name="target" value="remote">
                                            <button title="Install" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-orange-300 hover:text-orange-600 hover:bg-orange-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-orange-500/40 dark:hover:bg-orange-500/10 dark:hover:text-orange-300">
                                                <x-lucide-rotate-cw class="w-5 h-6" />
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('tasks.uninstall', $soft->runningInstance->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="uninstall">
                                            <button title="Uninstall" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                                <x-lucide-square class="w-5 h-5" />
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('software.destroy', $soft->id) }}">
                                        @csrf
                                        <input type="hidden" name="target" value="remote">
                                        <button title="Delete" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                            <x-lucide-trash-2 class="w-5 h-6" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-ui.card>

            <div class="max-w-[550px] w-full space-y-4">
                <x-ui.card title="Network">
                    <x-slot:icon>
                        <x-lucide-network class="w-4 h-4" />
                    </x-slot:icon>

                    <div class="mt-5 mb-5 text-center text-xs text-slate-500 dark:text-slate-400">
                        <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $connectivity }}</span>
                        <br/>
                        <span>({{ $download }} - {{ $upload }})</span>
                    </div>

                    <div class="flex justify-center">
                        <form method="POST" action="{{ route('target.software.upload') }}" class="w-[90%] sm:w-[80%] space-y-3">
                            @csrf

                            <select
                                name="software_id"
                                class="w-full appearance-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-white/10 dark:bg-white/5 dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/20">
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

                            <button
                                class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                Upload
                            </button>
                        </form>
                    </div>
                </x-ui.card>


            <x-ui.chart-stats title="Storage Usage" :percent="$pct" :used="$storageUsed" :total="$storageTotal" class="mb-3">
                <x-slot:icon>
                    <x-lucide-hard-drive class="w-4 h-4" />
                </x-slot:icon>
            </x-ui.chart-stats>
            </div>
        </div>
    </section>
</x-app-layout>
