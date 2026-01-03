@section('title', 'Logs')

<x-app-layout>
    <section class="space-y-5">
        {{-- Top Tabs --}}
        @include('pages.target.subnav')
        {{-- Top Tabs --}}

        @if (session('status'))
            <x-alert type="success">
                {{ session('status') }}
            </x-alert>
        @endif

        @if (session('login_ok'))
            <x-alert type="success">
                {{ session('login_ok') }}
            </x-alert>
        @endif

        <div class="flex flex-col lg:flex-row gap-5 items-start">
            <div class="w-full">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">Software</div>
                    </div>
                    <form method="POST" action="{{ route('target.logs.save', ['networkId' => $networkId]) }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="base_hash" value="{{ $baseHash }}">
                        <div class="px-5 py-4 space-y-2">
                            <textarea id="logs-content" name="content" rows="25"
                                class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 font-mono text-sm text-slate-900 shadow-sm
                                       placeholder:text-slate-400
                                       focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300
                                       dark:border-white/10 dark:bg-white/5 dark:text-white dark:placeholder:text-white/40
                                       dark:focus:ring-white/15 dark:focus:border-white/20">{{ $content }}</textarea>
                        </div>
                        <div class="flex items-center justify-end gap-3 border-t border-slate-200/70 px-5 py-4 dark:border-white/10">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/20 dark:bg-white dark:text-slate-900 dark:hover:bg-white/90 dark:focus:ring-white/20">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
</x-app-layout>

