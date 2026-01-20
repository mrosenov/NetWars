<div {{ $attributes->merge(['class' => 'mb-2 border border-border border-default bg-background-secondary shadow-sm backdrop-blur']) }}>
    <div class="flex items-center justify-between px-3 py-2">
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>
