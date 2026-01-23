@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'card-hack h-full']) }}>
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

            <div class="ml-auto flex items-center gap-2">
                @isset($counter)
                    <span class="rounded-lg bg-cyan-500/10 px-2 py-1 text-[10px] font-semibold text-cyan-700 dark:text-cyan-300">
                        {{ $counter }}
                    </span>
                @endisset

                @isset($type)
                    <span @class(['rounded-lg px-2 py-1 text-[10px] font-semibold', 'bg-green-500/10 text-green-700 dark:text-green-300' => strtolower($type) === 'vpc', 'bg-purple-500/10 text-purple-700 dark:text-purple-300' => strtolower($type) === 'whois',
                    'bg-orange-500/10 text-orange-700 dark:text-orange-300' => strtolower($type) === 'npc',
                    'bg-cyan-500/10 text-cyan-700 dark:text-cyan-300' => !in_array(strtolower($type), ['vpc','whois','npc'])])>
                        {{ $type }}
                    </span>
                @endisset

                @isset($header)
                    {{ $header }}
                @endisset
            </div>
        </div>

    <div class="p-0 overflow-x-auto">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="bg-background-secondary px-4 py-3 border-t border-border border-default flex items-center justify-between text-xs text-text-muted">
            {{ $footer }}
        </div>
    @endisset
</div>
