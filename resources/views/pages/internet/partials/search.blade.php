<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between p-4">
        <div class="flex w-full items-center gap-3">
            <div class="shrink-0 text-sm text-slate-700 dark:text-slate-200">IP Address:</div>

            <div class="flex-1 flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 focus-within:ring-2 focus-within:ring-cyan-500/40 dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                <span class="text-green-600 dark:text-green-300 text-sm">$</span>
                <input placeholder="1.2.3.4"
                       class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                       @if(isset($network))value="{{$network->ip}}"@endif
                />
            </div>

            <button class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-xs font-semibold text-cyan-700 shadow-sm dark:text-cyan-300">
                GO
            </button>
        </div>

        <div class="flex items-center gap-2 sm:pl-3">
            <button class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm hover:-translate-y-0.5 hover:shadow-md transition dark:border-white/10 dark:bg-white/5" title="Home">
                🏠
            </button>
            <button class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white shadow-sm hover:-translate-y-0.5 hover:shadow-md transition dark:border-white/10 dark:bg-white/5" title="Refresh">
                🔄
            </button>
        </div>
    </div>
</div>
