@section('title', 'Logs')

<x-app-layout>
    <section class="space-y-5">
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
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Logs</div>
                </div>

                <form id="logSaveForm" method="POST" action="{{ route('user.logs.save') }}">
                    @csrf
                    <input type="hidden" name="target" value="local">
                    {{-- Editor --}}
                    <div id="logEditorWrap" class="px-5 py-4 space-y-2">
                            <textarea id="logs-content" name="content" rows="25" class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 font-mono text-sm text-slate-900 shadow-sm
                            placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300 dark:border-white/10 dark:bg-white/5 dark:text-white dark:placeholder:text-white/40
                            dark:focus:ring-white/15 dark:focus:border-white/20">{{ $content }}</textarea>

                    </div>

                    {{-- Saving UI --}}
                    <div id="savingWrap" class="hidden px-5 py-6">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">Saving logs…</div>

                        <div class="mt-3 w-full bg-slate-200 dark:bg-white/10 rounded-md h-3 overflow-hidden">
                            <div id="saveProgressBar" class="h-3 w-0 bg-emerald-500"></div>
                        </div>

                        <div id="saveTimer" class="mt-2 text-sm text-slate-600 dark:text-white/70"></div>

                        <div id="saveHint" class="mt-3 text-xs text-slate-500 dark:text-white/50">
                            Please wait. You can’t save again until this finishes.
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-200/70 px-5 py-4 dark:border-white/10">
                        <button id="saveBtn" type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                       disabled:opacity-60 disabled:cursor-not-allowed
                                       dark:bg-white dark:text-slate-900 dark:hover:bg-white/90 dark:focus:ring-white/20">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </section>
</x-app-layout>
