@section('title', 'Software')

<x-app-layout>

    @include('pages.software.subnav')
    @if (session('success'))
        <x-alert type="success" class="mb-2">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert type="danger" class="mb-2">
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
                                    <button title="Info" type="button" data-modal-open="swModal" data-hw-id="{{ $soft->id }}" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-blue-500/40 dark:hover:bg-blue-500/10 dark:hover:text-blue-300">
                                        <x-lucide-info class="w-5 h-5"/>
                                    </button>

                                    @if($hacker->isConnected())
                                        <form method="POST" action="{{ route('target.software.upload') }}">
                                            @csrf
                                            <input type="hidden" name="software_id" value="{{ $soft->id }}">
                                            <button title="Upload to {{ $hacker->connectedNetwork()->ip }}" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-green-300 hover:text-green-600 hover:bg-green-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-green-500/40 dark:hover:bg-green-500/10 dark:hover:text-green-300">
                                                <x-lucide-upload-cloud class="w-5 h-5"/>
                                            </button>
                                        </form>
                                    @endif

                                    @if(!$soft->isRunning())
                                        <form method="POST" action="{{ route('tasks.install', $soft->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="install">
                                            <input type="hidden" name="target" value="local">
                                            <button title="Install" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-orange-300 hover:text-orange-600 hover:bg-orange-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-orange-500/40 dark:hover:bg-orange-500/10 dark:hover:text-orange-300">
                                                <x-lucide-refresh-cw class="w-5 h-5"/>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('tasks.uninstall', $soft->runningInstance->id) }}">
                                            @csrf
                                            <input type="hidden" name="action" value="uninstall">
                                            <button title="Uninstall" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                                <x-lucide-ban class="w-5 h-5" />
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('software.destroy', $soft->id) }}">
                                        @csrf
                                        <input type="hidden" name="target" value="local">
                                        <button title="Delete" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                            <x-lucide-trash-2 class="w-5 h-5" />
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('software.external.backup', $soft->id) }}">
                                        @csrf
                                        <button title="Backup" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-fuchsia-600 hover:bg-fuchsia-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-fuchsia-500/40 dark:hover:bg-fuchsia-500/10 dark:hover:text-fuchsia-300">
                                            <x-lucide-hard-drive class="w-5 h-5" />
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
