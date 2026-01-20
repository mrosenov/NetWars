@props(['href', 'active' => false,])

<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold text-text-secondary transition-colors hover:bg-[var(--bg-secondary)]/50 hover:text-text-primary', 'bg-background-primary border border-green-500/30 shadow-sm text-text-primary' => $active,]) }}>
    <span @class(['grid h-6 w-6 place-items-center rounded-lg', 'text-accent-primary' => $active, 'text-text-primary/80' => ! $active,])>
        {{ $icon }}
    </span>

    {{ $slot }}
</a>
