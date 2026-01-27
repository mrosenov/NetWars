@props(['id', 'target', 'active' => false])

<button type="button" id="{{ $id }}" data-tab="#{{ $target }}" aria-controls="{{ $target }}" role="tab" aria-selected="{{ $active ? 'true' : 'false' }}" @class(['tab group inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold transition','border-b-2 border-transparent rounded-t-lg', 'hover:bg-background-primary/30', 'text-text-secondary hover:text-text-primary', 'active' => $active,])>
    {{ $slot }}
</button>
