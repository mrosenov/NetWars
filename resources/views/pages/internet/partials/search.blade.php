<form method="GET" action="{{ route('internet.index') }}">
    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between p-4">

            {{-- IP Search --}}
            <div class="flex w-full items-center gap-3">
                <div class="shrink-0 text-sm text-slate-700 dark:text-slate-200">
                    IP Address:
                </div>

                <div class="flex-1 flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 focus-within:ring-2 focus-within:ring-cyan-500/40 dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                    <span class="text-green-600 dark:text-green-300 text-sm">$</span>
                    <input type="text" name="ip" placeholder="1.2.3.4" value="{{ request('ip') }}" class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500" />
                </div>

                <button type="submit" class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-xs font-semibold text-cyan-700 shadow-sm dark:text-cyan-300">
                    GO
                </button>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 sm:pl-3">
                {{-- Home --}}
                <a href="{{ route('internet.show', '1.2.3.4') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm text-slate-600 hover:-translate-y-0.5 hover:scale-[1.02] active:scale-95 hover:shadow-md hover:text-cyan-600 transition dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:text-cyan-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </a>
            </div>

        </div>
    </div>
</form>
