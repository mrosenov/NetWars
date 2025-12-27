@props([
    'type' => 'info',
])

@php
    $base = 'flex items-center justify-between gap-4 rounded-xl border px-5 py-3 shadow-sm';

    $styles = match ($type) {
        'success' => 'border-emerald-500/25 bg-gradient-to-r from-emerald-900/40 to-emerald-800/30 text-emerald-100',
        'warning' => 'border-amber-500/30 bg-gradient-to-r from-amber-900/40 to-amber-800/30 text-amber-100',
        'danger', 'error' => 'border-red-500/30 bg-gradient-to-r from-red-900/40 to-red-800/30 text-red-100',
        default => 'border-blue-500/20 bg-gradient-to-r from-blue-900/40 to-blue-800/30 text-blue-100',
    };

    $icon = match ($type) {
        'success' => ['char' => '✓', 'wrap' => 'bg-emerald-500/20 text-emerald-200'],
        'warning' => ['char' => '!', 'wrap' => 'bg-amber-500/25 text-amber-200'],
        'danger', 'error' => ['char' => '×', 'wrap' => 'bg-red-500/25 text-red-200'],
        default => ['char' => 'i', 'wrap' => 'bg-blue-500/20 text-blue-200'],
    };

    $actionColor = match ($type) {
        'success' => 'text-emerald-200',
        'warning' => 'text-amber-200',
        'danger', 'error' => 'text-red-200',
        default => 'text-blue-200',
    };
@endphp

<div {{ $attributes->merge(['class' => "$base $styles"]) }}>
    <div class="flex items-center gap-3">
        <div class="flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold {{ $icon['wrap'] }}">
            {{ $icon['char'] }}
        </div>

        <div class="text-sm">
            {{ $slot }}
        </div>
    </div>

    @isset($action)
        <div class="shrink-0 text-sm font-semibold {{ $actionColor }}">
            {{ $action }}
        </div>
    @endisset
</div>
