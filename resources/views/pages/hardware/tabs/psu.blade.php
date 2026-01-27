<table class="w-full text-sm text-left">
    <thead class="text-xs text-text-secondary uppercase bg-background-secondary/50 border-b border-border border-default">
        <tr class="border border-default">
            <th scope="col" class="px-4 py-2 w-40">Name</th>
            <th scope="col" class="px-4 py-2 w-32">Watts</th>
            <th scope="col" class="px-4 py-2 w-32">Specifications</th>
            <th scope="col" class="px-4 py-2 w-28">Price</th>
            <th scope="col" class="px-4 py-2 w-16 text-left"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($powerSupplies as $psu)
        <tr class="hover:bg-slate-300 dark:hover:bg-background-secondary transition-colors border border-border">
            <td class="px-4 py-3 text-slate-700 dark:text-white/80 font-mono text-md whitespace-nowrap font-bold">
                {{ $psu->name }}
            </td>
            <td class="px-4 py-3 text-slate-700 dark:text-white/80 font-mono text-md whitespace-nowrap font-bold">
                {{ \App\Support\Format::wattHuman($psu->specifications['max_power_w']) }}
            </td>
            <td class="px-4 py-3">
                <div class="flex flex-wrap gap-1 text-[11px]">
                    @foreach(explode(' · ', $psu->specs_label) as $spec)
                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                            {{ $spec }}
                        </span>
                    @endforeach
                    @if($psu->reqs_label)
                        @foreach(explode(' · ', $psu->reqs_label) as $req)
                            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                {{ $req }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </td>
            <td class="px-4 py-3 text-emerald-600 dark:text-emerald-400 font-mono text-md whitespace-nowrap font-bold">
                @if($psu->id == $installedSupply->id)
                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                @else
                    ${{ number_format($psu->price) }}
                @endif
            </td>
            <td class="px-4 py-3 text-right">
                @if($psu->id != $installedSupply->id)
                    <button type="button" data-modal-open="buyModal" data-hw-id="{{ $psu->id }}" data-buy-type="psu" class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10">
                        <x-lucide-shopping-cart class="w-4 h-4" />
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
