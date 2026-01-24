<x-ui.subnav>
    <x-ui.subnav-link :href="route('target.logs')" :active="request()->routeIs('target.logs')">
        <x-slot:icon>
            <x-lucide-scroll-text class="size-5" />
        </x-slot:icon>
        Logs
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('target.software')" :active="request()->routeIs('target.software')">
        <x-slot:icon>
            <x-lucide-folder-code class="size-5" />
        </x-slot:icon>
        Software
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('target.logout')" :active="request()->routeIs('target.logout')">
        <x-slot:icon>
            <x-lucide-log-out class="size-5" />
        </x-slot:icon>
        Logout
    </x-ui.subnav-link>
</x-ui.subnav>
