@section('title', 'External Drive')

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

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_16rem] gap-4 h-full">
        <x-ui.card title="File System">
            <x-slot:icon>
                <x-lucide-folder-open class="w-4 h-4" />
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
                        <tr class="hover:bg-slate-300/50 dark:hover:bg-background-secondary transition-colors border border-border">
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
                                    <form method="POST" action="{{ route('software.external.copy', $soft->id) }}">
                                        @csrf
                                        <button title="Copy" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-green-300 hover:text-green-600 hover:bg-green-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-green-500/40 dark:hover:bg-green-500/10 dark:hover:text-green-300">
                                            <x-lucide-download-cloud class="w-5 h-5"/>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('software.external.destroy', $soft->id) }}">
                                        @csrf
                                        <button title="Copy" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                            <x-lucide-trash-2 class="w-5 h-5" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-ui.card>

        <div class="flex flex-col gap-4 h-full">
            <x-ui.chart-stats title="Storage Usage" :percent="$pct" :used="$storageUsed" :total="$storageTotal">
                <x-slot:icon>
                    <x-lucide-hard-drive class="w-4 h-4" />
                </x-slot:icon>
            </x-ui.chart-stats>
        </div>
    </div>
</x-app-layout>
