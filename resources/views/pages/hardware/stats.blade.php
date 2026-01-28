<div class="mb-2 border border-border border-default bg-background-secondary shadow-sm backdrop-blur">
    <div class="flex items-center justify-center px-3 py-2 gap-2">
        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-blue-400">
                    <x-lucide-cpu class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $totalCPU['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $totalCPU['unit'] }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-orange-400">
                    <x-lucide-hard-drive class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $totalDisk['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $totalDisk['unit'] }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-green-400">
                    <x-lucide-memory-stick class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $totalRAM['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $totalRAM['unit'] }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-yellow-400">
                    <x-lucide-zap class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $totalPowerSupply['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $totalPowerSupply['unit'] }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-sky-400">
                    <x-lucide-globe class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $connectivity['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $connectivity['unit'] }}</span>
            </div>
        </div>

        <div class="inline-flex items-center gap-3 px-3 py-2 rounded-xl border border-border bg-background-secondary/60 text-text-secondary shadow-sm backdrop-blur transition hover:bg-background-secondary hover:text-text-primary">
                <span class="grid h-8 w-8 place-items-center rounded-lg border border-border bg-background-primary text-fuchsia-400">
                    <x-lucide-hard-drive class="w-5 h-5" />
                </span>

            <div class="flex flex-col leading-tight">
                <span class="text-sm font-bold text-text-primary">{{ $totalExternal['value'] }}</span>
                <span class="text-[11px] uppercase tracking-wide text-text-secondary">{{ $totalExternal['unit'] }}</span>
            </div>
        </div>
    </div>
</div>
