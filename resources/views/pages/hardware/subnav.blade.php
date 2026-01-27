<x-ui.subnav>
    <x-ui.subnav-link :href="route('user.hardware')" :active="request()->routeIs('user.hardware')">
        <x-slot:icon>
            <x-lucide-server-cog class="w-5 h-5" />
        </x-slot:icon>
        My Hardware
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('user.hardware')" :active="request()->routeIs('user.hardware')">
        <x-slot:icon>
            <x-lucide-package-plus class="w-5 h-5" />
        </x-slot:icon>
        Buy new server
    </x-ui.subnav-link>

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
