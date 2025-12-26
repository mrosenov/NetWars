@php use Illuminate\Support\Facades\Auth; @endphp
<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glowGreen">
    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
        <div class="flex items-center gap-3">
            <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
              <svg viewBox="0 0 24 24" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v10H4z"/><path d="M8 20h8"/><path d="M12 14v6"/>
              </svg>
            </span>
            <div>
                <div class="text-sm font-semibold">Hardware Information</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">Active servers: {{ count($servers) }}</div>
            </div>
        </div>
    </div>

    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Metric card -->
            @php
                $resourceIcons = [
                    'CPU' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />',
                    'RAM' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />',
                    'PSU' => '<path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />',
                    'Disk' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />',
                    'externalDrive' => '<path stroke-linecap="round" stroke-linejoin="round" d="m9 13.5 3 3m0 0 3-3m-3 3v-6m1.06-4.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />',
                    'Connectivity' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 0 1 1.06 0Z" />',
                ];
            @endphp

            @foreach($OverallResources as $key => $resource)
                @php
                    $icon = $resourceIcons[$key] ?? 'chart-bar';
                @endphp

                <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">

                    {{-- Icon --}}
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-500/10 text-cyan-500">
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            {!! $icon !!}
                        </svg>
                    </div>

                    {{-- Text --}}
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                           @if($key == 'externalDrive')
                                External HDD
                            @else
                                {{ $key }}
                           @endif
                        </span>
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ number_format($resource['value']) }}<span class="text-sm">{{ $resource['unit'] }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
