<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <nav class="text-xs text-slate-500 dark:text-slate-400 flex flex-wrap gap-1">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-700 dark:hover:text-slate-200">Net Wars</a>

            @stack('breadcrumbs')

            <span>/</span>
            <span class="text-slate-700 dark:text-slate-200">@yield('title')</span>
        </nav>

        <h1 class="mt-1 text-xl font-semibold tracking-tight">@yield('title')</h1>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
            Run Diagnostics
        </button>

        <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
            Deploy Patch
        </button>
        <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm dark:border-white/10 dark:bg-white/5">
            <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
            <span class="text-slate-600 dark:text-slate-300">Threat level</span>
            <span class="font-semibold text-slate-900 dark:text-slate-100">LOW</span>
        </span>
    </div>
</div>
