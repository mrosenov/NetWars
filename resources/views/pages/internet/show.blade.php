@section('title', 'Internet')
<x-app-layout>
    <section class="space-y-5">
        @include('pages.internet.partials.search')
        @include('pages.internet.partials.alertLogged')

        @if (session('logout_ok'))
            <x-alert type="warning" class="mb-2">
                {{ session('logout_ok') }}
            </x-alert>
        @endif
        @if (session('status'))
            <x-alert type="warning" class="mb-2">
                {{ session('status') }}
            </x-alert>
        @endif
        @if (session('error'))
            <x-alert type="danger" class="mb-2">
                {{ session('error') }}
            </x-alert>
        @endif

        @include('pages.internet.partials.navigation')

        <x-ui.card title="Info">
            <x-slot:icon>
                <x-lucide-info class="w-4 h-4" />
            </x-slot:icon>

            <x-slot:type>
                {{ $targetType['label'] }}
            </x-slot:type>

            <span class="px-4 py-3 flex items-center justify-between text-md text-text-muted">
                {{ $metadata['text'] ?? '' }}
            </span>

            @if($title = data_get($metadata, 'recommendations.title'))
                <span class="px-4 py-3 flex items-center justify-between text-md text-text-muted">
                    {{ $title }}
                </span>
            @endif

            @forelse (data_get($metadata, 'recommendations.items', []) as $recommendation)
                <a href="{{ data_get($recommendation, 'url') }}" class="group block rounded-none px-7 py-2 transition hover:bg-slate-100 dark:hover:bg-white/5 group-hover:text-accent-primary">
                    <span class="font-semibold text-slate-900 dark:text-slate-100 group-hover:text-accent-primary">
                        {{ data_get($recommendation, 'ip') }}
                    </span>
                    <span class="text-slate-500 dark:text-slate-400">—</span>
                    <span class="text-slate-700 dark:text-slate-200 group-hover:text-accent-primary">
                        {{ data_get($recommendation, 'label') }}
                    </span>
                </a>
            @empty
                {{-- nothing to show --}}
            @endforelse
        </x-ui.card>
    </section>
</x-app-layout>
