<x-ui.subnav>
    <x-ui.subnav-link
        :href="route('tasks.index')"
        :active="request()->routeIs('tasks.index')"
    >
        <x-slot:icon>
            <x-lucide-list-todo class="size-4" />
        </x-slot:icon>

        All Tasks
    </x-ui.subnav-link>

    <x-ui.subnav-link
        :href="route('tasks.cpu')"
        :active="request()->routeIs('tasks.cpu')"
    >
        <x-slot:icon>
            <x-lucide-cpu class="size-4" />
        </x-slot:icon>

        CPU Tasks
    </x-ui.subnav-link>

    <x-ui.subnav-link
        :href="route('tasks.network')"
        :active="request()->routeIs('tasks.network')"
    >
        <x-slot:icon>
            <x-lucide-cloud-download class="size-4" />
        </x-slot:icon>

        Network Manager
    </x-ui.subnav-link>

    <x-ui.subnav-link
        :href="route('tasks.running')"
        :active="request()->routeIs('tasks.running')"
    >
        <x-slot:icon>
            <x-lucide-monitor-play class="size-4" />
        </x-slot:icon>

        Running Software
    </x-ui.subnav-link>
</x-ui.subnav>
