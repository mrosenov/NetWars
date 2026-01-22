@props([
    'title' => 'Stats',
    'percent' => 0,
    'used' => null,
    'total' => null,
    'radius' => 46,
    'stroke' => 12,
    'warn' => 50,
    'danger' => 75,
])

@php
    $pct = max(0, min(100, (float) $percent));

    $r = (float) $radius;
    $c = 2 * M_PI * $r;
    $offset = $c - ($c * ($pct / 100));

    $ringClass = $pct <= $warn ? 'stroke-emerald-500' : ($pct < $danger ? 'stroke-amber-500' : 'stroke-red-500');

    $textClass = $pct <= $warn ? 'text-emerald-500' : ($pct < $danger ? 'text-amber-500' : 'text-red-500');
@endphp

<div {{ $attributes->merge(['class' => 'card-hack']) }}>
    <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
        @isset($icon)
            <span class="text-accent-primary">
                {{ $icon }}
            </span>
        @endisset

        <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
            {{ $title }}
        </h3>
    </div>

    <div class="p-4 flex flex-col items-center justify-center gap-4">
        <div class="relative size-40">
            <svg viewBox="0 0 120 120" class="size-full -rotate-90">
                <circle cx="60" cy="60" r="{{ $r }}" fill="none" class="stroke-slate-200 dark:stroke-white/10" stroke-width="{{ $stroke }}" />
                <circle cx="60" cy="60" r="{{ $r }}" fill="none" class="{{ $ringClass }}" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $offset }}" />
            </svg>

            <div class="absolute inset-0 grid place-items-center text-center">
                <div class="text-2xl font-bold text-text-primary">{{ (int) round($pct) }}%</div>
            </div>
        </div>

        @if(!is_null($used) && !is_null($total))
            <div class="w-full space-y-2 text-sm text-center">
                <span class="{{ $textClass }}">{{ $used }}</span>
                /
                <span class="text-emerald-700">{{ $total }}</span>
            </div>
        @endif
    </div>
</div>
