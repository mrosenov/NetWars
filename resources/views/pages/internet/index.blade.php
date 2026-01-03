@section('title', 'Internet')

<x-app-layout>
    <section class="space-y-5">
        <!-- IP BAR -->
        @include('pages.internet.partials.search')
        <!-- IP BAR -->
        @if (session('logout_ok'))
            <x-alert type="warning">
                {{ session('logout_ok') }}
            </x-alert>
        @endif
        {{-- Important IPs --}}
        <div class="w-full max-w-[300px]">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                    <div class="text-sm font-semibold">Important IPs</div>
                    <span class="rounded-lg bg-cyan-500/10 px-2 py-1 text-[10px] font-semibold text-cyan-700 dark:text-cyan-300">
                        1 TOTAL
                    </span>
                </div>

                {{-- Table --}}
                <div class="overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 text-xs text-slate-500 dark:text-slate-400">
                            <th class="px-4 py-2 text-left font-medium">IP</th>
                            <th class="px-4 py-2 text-right font-medium">Type</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                        {{-- Empty state example --}}
{{--                        <tr>--}}
{{--                            <td colspan="2" class="px-4 py-6 text-center text-xs text-slate-400 dark:text-slate-500">--}}
{{--                                No IPs found yet--}}
{{--                            </td>--}}
{{--                        </tr>--}}
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition">
                            <td class="px-4 py-3 font-mono text-xs">
                                1.2.3.4
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-purple-400/10 text-purple-400 inset-ring inset-ring-purple-400/30">
                                    WhoIs
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Footer / Hint --}}
                <div class="border-t border-slate-200/70 px-4 py-3 text-[11px] text-slate-500 dark:border-white/10 dark:text-slate-400 bg-slate-50/50 dark:bg-white/[0.03] rounded-b-2xl">
                    <span class="font-semibold text-slate-600 dark:text-slate-300">HINT:</span>
                    WhoIs IPs will be listed here once found.
                </div>

            </div>

        </div>
    </section>
</x-app-layout>
