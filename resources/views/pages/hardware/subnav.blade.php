<x-ui.subnav>
    <x-ui.subnav-link :href="route('user.hardware')" :active="request()->routeIs('user.hardware')">
        <x-slot:icon>
            <x-lucide-server-cog class="w-5 h-5" />
        </x-slot:icon>
        My Hardware
    </x-ui.subnav-link>

    <button data-modal-open="buyServerModal" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary">
        <span class="grid h-6 w-6 place-items-center rounded-lg">
            <x-lucide-package-plus class="w-5 h-5" />
        </span>
        Buy new server
    </button>

    <x-ui.subnav-link :href="route('user.hardware')" :active="request()->routeIs('user.hardware')">
        <x-slot:icon>
            <x-lucide-globe class="w-5 h-5" />
        </x-slot:icon>
        Internet
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('user.hardware')" :active="request()->routeIs('user.hardware')">
        <x-slot:icon>
            <x-lucide-hard-drive class="w-5 h-5" />
        </x-slot:icon>
        External HDD
    </x-ui.subnav-link>
</x-ui.subnav>
