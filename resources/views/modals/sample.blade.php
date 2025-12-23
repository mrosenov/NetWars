<div id="hwModal" class="fixed inset-0 z-[999] hidden" aria-hidden="true">
    <!-- Backdrop -->
    <div data-modal-close="hwModal" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div role="dialog" aria-modal="true" aria-labelledby="hwModalTitle" class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-white/10 dark:bg-[#070A0F]">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <!-- icon -->
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l9 4-9 4-9-4 9-4z"/>
                            <path d="M3 10l9 4 9-4"/>
                            <path d="M3 18l9 4 9-4"/>
                        </svg>
                    </span>

                    <div>
                        <div id="hwModalTitle" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Secure Prompt
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Enter payload parameters
                        </div>
                    </div>
                </div>

                <button type="button" data-modal-close="hwModal" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100" aria-label="Close modal">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-5 py-4">
                <label class="block text-xs text-slate-500 dark:text-slate-400">Command</label>
                <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-white/10 dark:bg-white/5">
                    <span class="text-green-600 dark:text-green-300">$</span>
                    <input type="text" class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500" placeholder="deploy --target=74.225.236.3 --mode=stealth" autofocus/>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-white/10 dark:bg-white/5">
                        <div class="text-[11px] uppercase tracking-widest text-slate-500 dark:text-slate-400">
                            Status
                        </div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">
                            READY
                            <span class="ml-2 inline-block h-2 w-2 rounded-full bg-green-500"></span>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-white/10 dark:bg-white/5">
                        <div class="text-[11px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Auth</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">TOKEN_OK</div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex flex-col-reverse gap-2 border-t border-slate-200/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-end dark:border-white/10">
                <button type="button" data-modal-close="hwModal" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100">
                    Cancel
                </button>
                <button type="button" class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-xs font-semibold text-cyan-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:text-cyan-300">
                    Execute
                </button>
            </div>
        </div>
    </div>
</div>
