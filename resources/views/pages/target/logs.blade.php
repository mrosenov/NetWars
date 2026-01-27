@section('title', 'Logs')

<x-app-layout>
    <section class="space-y-5">
        @include('pages.internet.partials.search')
        {{-- Top Tabs --}}
        @include('pages.target.subnav')
        {{-- Top Tabs --}}

        @if (session('status'))
            <x-alert type="success">
                {{ session('status') }}
            </x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="danger">
                {{ $errors->first() }}
            </x-alert>
        @endif

        <div class="flex flex-col lg:flex-row gap-5 items-start">
            <div class="w-full">
                <form method="POST" action="{{ route('user.logs.save') }}">
                    <x-ui.card title="Logs">
                        <x-slot:icon>
                            <x-lucide-scroll-text class="w-5 h-5" />
                        </x-slot:icon>

                            @csrf
                            <input type="hidden" name="target" value="remote">

                            <div class="px-5 py-4 space-y-2">
                            @if($network->owner->type === 'download')
                                <textarea class="w-full rounded-xl bg-background-primary resize-y border border-border focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300" readonly>Download Center doesn't record logs.</textarea>
                            @else
                                <textarea name="content" rows="25" class="w-full rounded-xl bg-background-primary resize-y border border-border focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 text-sm">{{ $content }}</textarea>
                            @endif
                            </div>

                            <x-slot:footer>
                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/20 disabled:opacity-60 disabled:cursor-not-allowed dark:bg-white dark:text-slate-900 dark:hover:bg-white/90 dark:focus:ring-white/20" @if($network->owner->type === 'download')disabled @endif>
                                    Save
                                </button>
                            </x-slot:footer>
                    </x-ui.card>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
