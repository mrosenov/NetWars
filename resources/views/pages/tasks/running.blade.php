@section('title', 'Running software')

<x-app-layout>
    @include('pages.tasks.subnav')

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_16rem] gap-4 h-full">
        <!-- LEFT: your existing card (shrinks because right column exists) -->
        <x-ui.card title="Running Software">
            <x-slot:icon>
                <x-lucide-file-stack class="w-4 h-4" />
            </x-slot:icon>

            <table class="w-full text-sm text-left">
                <thead class="text-xs text-text-secondary uppercase bg-background-secondary/50 border-b border-border border-default">
                    <tr>
                        <th scope="col" class="px-4 py-2 w-40">Software</th>
                        <th scope="col" class="px-4 py-2 w-32">Version</th>
                        <th scope="col" class="px-4 py-2 w-28">RAM Usage</th>
                        <th scope="col" class="px-4 py-2 w-16 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($running as $task)
                    @php
                        $taskRam = (float)($task->ram_usage ?? 0);
                        $rowPct = $ramTotal['value'] > 0 ? round(($taskRam / $ramTotal['value']) * 100, 1) : 0;
                    @endphp

                    <tr class="hover:bg-background-secondary transition-colors border border-border">
                        <td class="px-4 py-3 text-slate-700 dark:text-white/80 font-mono text-md whitespace-nowrap font-bold">
                            {{ $task->software->name }}.{{ $task->software->type }}
                        </td>

                        <td class="px-4 py-3 font-mono text-xs font-bold whitespace-nowrap text-emerald-600 dark:text-emerald-400">
                            {{ $task->software->version }}
                        </td>

                        <td class="px-4 py-3 font-mono text-xs font-bold whitespace-nowrap">
                            <span class="font-semibold">{{ $task->ram_usage_formatted }}</span>
                            <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">{{ $rowPct }}%</span>
                        </td>

                        <td class="px-4 py-3 text-left text-text-secondary text-xs whitespace-nowrap">
                            <div class="flex justify-start gap-2">
                                <button type="submit" data-modal-open="swModal" data-hw-id="{{ $task->software->id }}" aria-label="Info" class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-blue-300 hover:text-blue-600 hover:bg-blue-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-blue-500/40 dark:hover:bg-blue-500/10 dark:hover:text-blue-300">
                                    <x-lucide-info class="w-4 h-4" />
                                </button>

                                <form method="POST" action="{{ route('tasks.uninstall', $task->id) }}">
                                    @csrf
                                    <button type="submit"
                                            aria-label="Stop"
                                            class="grid gap-2 aspect-square size-9 place-items-center rounded-md border border-slate-200 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)] hover:border-red-300 hover:text-red-600 hover:bg-red-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                        <x-lucide-x class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-ui.card>

        <!-- RIGHT: chart column (stacked cards) -->
        <div class="flex flex-col gap-4 h-full">
            <x-ui.chart-stats
                title="CPU Usage"
                :percent="$cpu_pct"
                :used="$cpuUsedHuman"
                :total="$cpuTotalHuman"
            >
                <x-slot:icon>
                    <x-lucide-cpu class="w-4 h-4" />
                </x-slot:icon>
            </x-ui.chart-stats>

            <x-ui.chart-stats
                title="RAM Usage"
                :percent="$ram_pct"
                :used="$ramUsedHuman"
                :total="$ramTotalHuman"
            >
                <x-slot:icon>
                    <x-lucide-pie-chart class="w-4 h-4" />
                </x-slot:icon>
            </x-ui.chart-stats>
        </div>
    </div>
</x-app-layout>
