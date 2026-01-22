<x-ui.subnav>
    <x-ui.subnav-link :href="route('software.index')" :active="request()->routeIs('software.index')">
        <x-slot:icon>
            <x-lucide-folder-archive class="size-4" />
        </x-slot:icon>
        Software
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('software.external')" :active="request()->routeIs('software.external')">
        <x-slot:icon>
            <x-lucide-hard-drive class="size-4" />
        </x-slot:icon>
        External Drive
    </x-ui.subnav-link>
</x-ui.subnav>
