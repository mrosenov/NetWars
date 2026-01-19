@section('title', 'Running software')

<x-app-layout>
    @include('pages.tasks.subnav')

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_16rem] gap-4 h-full">
        <!-- LEFT: your existing card (shrinks because right column exists) -->
        <div class="card-hack h-full">
            <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
                <x-lucide-file-stack class="w-4 h-4 text-accent-primary" />
                <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                    Running Software
                </h3>
            </div>

            <div class="p-0 overflow-x-auto">
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
            </div>
        </div>

        @php
            $r = 46;
            $c = 2 * M_PI * $r;
            $offset = $c - ($c * ($ram_pct / 100));
        @endphp

        <!-- RIGHT: chart column (stacked cards) -->
        <div class="flex flex-col gap-4 h-full">
            <!-- RAM card -->
            <div class="card-hack">
                <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
                    <x-lucide-pie-chart class="w-4 h-4 text-accent-primary" />
                    <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                        RAM Usage
                    </h3>
                </div>

                <div class="p-4 flex flex-col items-center justify-center gap-4">
                    <div class="relative size-40">
                        <svg viewBox="0 0 120 120" class="size-full -rotate-90">
                            <circle cx="60" cy="60" r="46" fill="none" class="stroke-slate-200 dark:stroke-white/10" stroke-width="12" />
                            <circle cx="60" cy="60" r="{{ $r }}" fill="none" class="{{ $ram_pct <= 50 ? 'stroke-emerald-500' : ($ram_pct < 75 ? 'stroke-amber-500' : 'stroke-red-500')}}" stroke-width="12" stroke-linecap="round" stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $offset }}" />
                        </svg>

                        <div class="absolute inset-0 grid place-items-center text-center">
                            <div class="text-lg font-bold text-text-primary">{{ $ram_pct }}%</div>
                        </div>
                    </div>

                    <div class="w-full space-y-2 text-sm text-center">
                        <span class="{{ $ram_pct <= 50 ? 'text-emerald-500' : ($ram_pct < 75 ? 'text-amber-500' : 'text-red-500')}}">{{ $ramUsedHuman }}</span> / <span class="text-emerald-700">{{ $ramTotalHuman }}</span>
                    </div>

{{--                    <div class="w-full space-y-2 text-sm">--}}
{{--                        <div class="flex items-center justify-between">--}}
{{--                            <div class="flex items-center gap-2">--}}
{{--                                <span class="size-2.5 rounded-full bg-blue-500"></span>--}}
{{--                                <span class="text-text-secondary">System</span>--}}
{{--                            </div>--}}
{{--                            <span class="font-mono text-xs text-text-secondary">38%</span>--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center justify-between">--}}
{{--                            <div class="flex items-center gap-2">--}}
{{--                                <span class="size-2.5 rounded-full bg-emerald-500"></span>--}}
{{--                                <span class="text-text-secondary">Apps</span>--}}
{{--                            </div>--}}
{{--                            <span class="font-mono text-xs text-text-secondary">24%</span>--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center justify-between">--}}
{{--                            <div class="flex items-center gap-2">--}}
{{--                                <span class="size-2.5 rounded-full bg-red-500"></span>--}}
{{--                                <span class="text-text-secondary">Other</span>--}}
{{--                            </div>--}}
{{--                            <span class="font-mono text-xs text-text-secondary">16%</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>

            @php
                $r = 46;
                $c = 2 * M_PI * $r;
                $offset = $c - ($c * ($cpu_pct / 100));
            @endphp
            <!-- CPU card -->
            <div class="card-hack">
                <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
                    <x-lucide-cpu class="w-4 h-4 text-accent-primary" />
                    <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                        CPU Usage
                    </h3>
                </div>

                <div class="p-4 flex flex-col items-center justify-center gap-4">
                    <div class="relative size-40">
                        <svg viewBox="0 0 120 120" class="size-full -rotate-90">
                            <circle cx="60" cy="60" r="46" fill="none" class="stroke-slate-200 dark:stroke-white/10" stroke-width="12" />
                            <circle cx="60" cy="60" r="{{ $r }}" fill="none" class="{{ $cpu_pct <= 50 ? 'stroke-emerald-500' : ($ram_pct < 75 ? 'stroke-amber-500' : 'stroke-red-500')}}" stroke-width="12" stroke-linecap="round" stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $offset }}" />
                        </svg>

                        <div class="absolute inset-0 grid place-items-center text-center">
                            <div class="text-2xl font-bold text-text-primary">{{$cpu_pct}}%</div>
                        </div>
                    </div>
                    <div class="w-full space-y-2 text-sm text-center">
                        <span class="{{ $cpu_pct <= 50 ? 'text-emerald-500' : ($cpu_pct < 75 ? 'text-amber-500' : 'text-red-500')}}">{{ $cpuUsedHuman }}</span> / <span class="text-emerald-700">{{ $cpuTotalHuman }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
