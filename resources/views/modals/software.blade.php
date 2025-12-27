<div id="swModal" class="fixed inset-0 z-[999] hidden" aria-hidden="true">
    <!-- Backdrop -->
    <div data-modal-close="swModal" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div role="dialog" aria-modal="true" aria-labelledby="swModalTitle" class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-white/10 dark:bg-[#070A0F]">
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
                        <div id="swModalTitle" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Software Information
                        </div>
                    </div>
                </div>

                <button type="button" data-modal-close="swModal" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100" aria-label="Close modal">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-5 py-4 space-y-6">

                <!-- Basic Information -->
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 dark:bg-white/5 dark:text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-slate-600 dark:text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Basic Information
                    </div>

                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                        <tr>
                            <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Name</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-name></td>
                        </tr>
                        <tr>
                            <td class="bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Version</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-version></td>
                        </tr>
                        <tr>
                            <td class="bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Licensed to</td>
                            <td class="px-4 py-2 font-semibold text-red-600 dark:text-red-400" data-sw-license></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Detailed Information -->
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 dark:bg-white/5 dark:text-slate-200">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-slate-600 dark:text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Detailed Information
                    </div>

                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                        <tr>
                            <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Type</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-type></td>
                        </tr>
                        <tr>
                            <td class="bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Size</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-size></td>
                        </tr>
                        <tr>
                            <td class="bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">RAM usage</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-usage></td>
                        </tr>
                        <tr>
                            <td class="bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Created</td>
                            <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-sw-created></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
