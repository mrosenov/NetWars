<div class="mb-2 border border-border border-default bg-background-secondary shadow-sm backdrop-blur">
    <div class="flex items-center justify-between px-3 py-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('tasks.index') }}"
                @class([
                     'inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary',
                     'bg-background-primary border border-green-500/30 shadow-sm' => request()->routeIs('tasks.index'),
                ])>
                <span @class([
                    'grid h-6 w-6 place-items-center rounded-lg',
                    'text-accent-primary' => request()->routeIs('tasks.index'),
                    'text-text-primary/80' => !request()->routeIs('tasks.index'),
                ])>
                    <x-lucide-list-todo class="size-4" />
                </span>
                All Tasks
            </a>

            <a href="{{ route('tasks.cpu') }}"
                @class([
                     'inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary',
                     'bg-background-primary border border-green-500/30 shadow-sm' => request()->routeIs('tasks.cpu'),
                ])>
                <span @class([
                    'grid h-6 w-6 place-items-center rounded-lg',
                    'text-accent-primary' => request()->routeIs('tasks.cpu'),
                    'text-text-primary/80' => !request()->routeIs('tasks.cpu'),
                ])>
                    <x-lucide-cpu class="size-4" />
                </span>
                CPU Tasks
            </a>

            <a href="{{ route('tasks.network') }}"
                @class([
                     'inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary',
                     'bg-background-primary border border-green-500/30 shadow-sm' => request()->routeIs('tasks.network'),
                ])>
                <span @class([
                    'grid h-6 w-6 place-items-center rounded-lg',
                    'text-accent-primary' => request()->routeIs('tasks.network'),
                    'text-text-primary/80' => !request()->routeIs('tasks.network'),
                ])>
                    <x-lucide-cloud-download class="size-4" />
                </span>
                Network Manager
            </a>

            <a href="{{ route('tasks.running') }}"
                @class([
                     'inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary',
                     'bg-background-primary border border-green-500/30 shadow-sm' => request()->routeIs('tasks.running'),
                ])>
                <span @class([
                    'grid h-6 w-6 place-items-center rounded-lg',
                    'text-accent-primary' => request()->routeIs('tasks.running'),
                    'text-text-primary/80' => !request()->routeIs('tasks.running'),
                ])>
                    <x-lucide-monitor-play class="size-4" />
                </span>
                Running Software
            </a>
        </div>
    </div>
</div>
