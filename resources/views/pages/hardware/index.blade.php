@section('title', 'My Hardware')

<x-app-layout>
    {{-- Top subnav (tabs) --}}
    @include('pages.hardware.subnav')

    {{-- Statistics --}}
    @include('pages.hardware.stats')

    {{-- Main container --}}
    <x-ui.card title="Servers">
        <x-slot:icon>
            <x-lucide-server class="w-5 h-5" />
        </x-slot:icon>

            <table class="w-full border-collapse">
                <tbody>
                    @foreach($servers ?? [] as $server)
                        @php
                            $cpu = \App\Support\Format::cpu($server->resource_totals['clock_mhz']);
                            $storage = \App\Support\Format::storage($server->resource_totals['storage_mb']);
                            $ram = \App\Support\Format::ram($server->resource_totals['ram_mb']);
                        @endphp
                        <tr class="hover:bg-slate-300/50 dark:hover:bg-background-secondary transition-colors border border-border">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-border bg-background-primary text-text-primary">
                                        <x-lucide-server class="w-5 h-5" />
                                    </div>

                                    <div>
                                        <div class="text-sm font-semibold text-text-primary">{{ $server->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-cpu class="w-4 h-4 text-blue-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $cpu['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $cpu['unit'] }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-hard-drive class="w-4 h-4 text-orange-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $storage['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $storage['unit'] }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-memory-stick class="w-4 h-4 text-green-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $ram['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $ram['unit'] }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('user.hardware.server', $server->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-border hover:border-accent-secondary hover:text-accent-secondary bg-background-primary px-4 py-2 text-sm font-semibold text-text-primary hover:bg-background-secondary transition">
                                    <x-lucide-arrow-up class="w-4 h-4" />
                                    Upgrade
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </x-ui.card>
</x-app-layout>
