@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'card-hack h-full']) }}>
    @if($title || isset($icon) || isset($header))
        <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
            @isset($icon)
                <span class="text-accent-primary">
                    {{ $icon }}
                </span>
            @endisset

            @if($title)
                <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                    {{ $title }}
                </h3>
            @endif

            @isset($header)
                {{ $header }}
            @endisset
        </div>
    @endif

    <div class="p-0 overflow-x-auto">
        {{ $slot }}
    </div>
</div>
