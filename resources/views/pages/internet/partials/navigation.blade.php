<x-ui.subnav>
    <x-ui.subnav-link :href="route('internet.show', $ip)" :active="request()->routeIs('internet.show')">
        <x-slot:icon>
            <x-lucide-info class="size-5" />
        </x-slot:icon>
        Info
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('internet.loginShow', $ip)" :active="request()->routeIs('internet.loginShow')">
        <x-slot:icon>
            <x-lucide-key-round class="size-5" />
        </x-slot:icon>
        Login
    </x-ui.subnav-link>

    <x-ui.subnav-link :href="route('internet.hackShow', $ip)" :active="request()->routeIs('internet.hackShow')">
        <x-slot:icon>
            <x-lucide-square-terminal class="size-5" />
        </x-slot:icon>
        Hack
    </x-ui.subnav-link>
</x-ui.subnav>
