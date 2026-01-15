<div class="card-hack h-full">
    <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
        <x-lucide-hard-drive class="w-4 h-4 text-accent-primary" />
        <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
            Hardware Information
        </h3>
    </div>
    <div class="p-0">
        <table class="w-full text-sm text-left">
            <tbody>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-cpu class="w-4 h-4 text-accent-primary" />
                    Processor
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ $cpu }}
                </td>
            </tr>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-hard-drive class="w-4 h-4 text-accent-secondary" />
                    Hard Drive
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ $storage }}
                </td>
            </tr>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-memory-stick class="w-4 h-4 text-green-500" />
                    Memory
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ $ram }}
                </td>
            </tr>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-globe class="w-4 h-4 text-blue-500" />
                    Internet
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ $connectivity }}
                </td>
            </tr>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-save class="w-4 h-4 text-gray-500" />
                    External HDD
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ $external }}
                </td>
            </tr>
            <tr class="border-b border-border border-default last:border-0 hover:bg-[var(--bg-secondary)]/50 transition-colors">
                <td class="px-4 py-3 flex items-center gap-3 text-text-secondary font-medium">
                    <x-lucide-server class="w-4 h-4 text-purple-500" />
                    Servers
                </td>
                <td class="px-4 py-3 text-text-primary text-right font-mono">
                    {{ count($servers) }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
