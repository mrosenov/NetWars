@section('title', 'Internet')

<x-app-layout>
    @include('pages.internet.partials.search')
    @include('pages.internet.partials.alertLogged')

    @if (session('logout_ok'))
        <x-alert type="warning" class="mb-2">
            {{ session('logout_ok') }}
        </x-alert>
    @endif
    @if (session('status'))
        <x-alert type="warning" class="mb-2">
            {{ session('status') }}
        </x-alert>
    @endif
    @if (session('error'))
        <x-alert type="danger" class="mb-2">
            {{ session('error') }}
        </x-alert>
    @endif
    @if (session('success'))
        <x-alert type="success" class="mb-2">
            {{ session('success') }}
        </x-alert>
    @endif

    <section class="space-y-5">
        <div class="w-full max-w-[350px]">
            @php
                $counter = 2;
            @endphp
            <x-ui.card title="Important IPs">
                <x-slot:icon>
                    <x-lucide-network class="w-4 h-4" />
                </x-slot:icon>

                <x-slot:counter>
                    {{ $counter }} Total
                </x-slot:counter>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5 text-xs text-slate-500 dark:text-slate-400">
                            <th class="px-4 py-2 text-left font-medium">IP</th>
                            <th class="px-4 py-2 text-right font-medium">Type</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    {{-- Empty state example --}}
                    {{-- <tr>--}}
                    {{--<td colspan="2" class="px-4 py-6 text-center text-xs text-slate-400 dark:text-slate-500">--}}
                    {{--No IPs found yet--}}
                    {{--</td>--}}
                    {{--</tr>--}}
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
                <x-slot:footer>
                    <span class="text-xs text-slate-500 dark:text-slate-400">WhoIs IPs will be listed here once found.</span>
                </x-slot:footer>
            </x-ui.card>
        </div>
    </section>
</x-app-layout>
