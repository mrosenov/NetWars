@section('title', 'Internet')
<x-app-layout>
    <!-- INTERNET PANEL (Index / Login / Hack in one) -->
    <section class="space-y-5">

        <!-- IP BAR -->
        @include('pages.internet.partials.search')
        <!-- IP BAR -->

        <!-- TABS + CONTENT -->
        <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
            <!-- Subnavigation -->
            @include('pages.internet.partials.navigation')
            <!-- Subnavigation -->

            <div class="p-5">
                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                    {{ $metadata['text'] ?? '' }}
                </div>

                <div class="mt-5 space-y-2">
                    @if($title = data_get($metadata, 'recommendations.title'))
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            {{ $title }}
                        </div>
                    @endif
                    @forelse (data_get($metadata, 'recommendations.items', []) as $recommendation)
                        <a href="{{ data_get($recommendation, 'url') }}" class="group block rounded-xl px-3 py-2 transition hover:bg-slate-100 dark:hover:bg-white/5">
                            <span class="font-semibold text-slate-900 dark:text-slate-100">
                                {{ data_get($recommendation, 'ip') }}
                            </span>
                            <span class="text-slate-500 dark:text-slate-400">—</span>
                            <span class="text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-slate-100">
                                {{ data_get($recommendation, 'label') }}
                            </span>
                        </a>
                    @empty
                        {{-- nothing to show --}}
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
