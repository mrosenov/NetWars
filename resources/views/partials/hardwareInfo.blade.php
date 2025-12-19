<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glowGreen">
    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
        <div class="flex items-center gap-3">
            <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
              <svg viewBox="0 0 24 24" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16v10H4z"/><path d="M8 20h8"/><path d="M12 14v6"/>
              </svg>
            </span>
            <div>
                <div class="text-sm font-semibold">Hardware Information</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">Local rig status • polled 3s ago</div>
            </div>
        </div>
        <span class="rounded-lg bg-green-500/10 px-2 py-1 text-[10px] font-semibold text-green-700 dark:text-green-300">
            STABLE
        </span>
    </div>

    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <!-- Metric card -->
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">Processor</div>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400">0.5 GHz</span>
                </div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-lg font-semibold">0.5</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">GHz</div>
                </div>
                <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-white/10">
                    <div class="h-2 w-1/4 rounded-full bg-gradient-to-r from-green-500/70 to-cyan-400/70"></div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">Hard Drive</div>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400">100 MB</span>
                </div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-lg font-semibold">100</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">MB</div>
                </div>
                <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-white/10">
                    <div class="h-2 w-2/5 rounded-full bg-gradient-to-r from-cyan-400/70 to-green-500/70"></div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">Memory</div>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400">256 MB</span>
                </div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-lg font-semibold">256</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">MB</div>
                </div>
                <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-white/10">
                    <div class="h-2 w-3/5 rounded-full bg-gradient-to-r from-green-500/70 to-cyan-400/70"></div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">Internet</div>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400">1 Mbit/s</span>
                </div>
                <div class="mt-2 flex items-end justify-between">
                    <div class="text-lg font-semibold">1</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Mbit/s</div>
                </div>
                <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-white/10">
                    <div class="h-2 w-1/3 rounded-full bg-gradient-to-r from-cyan-400/70 to-green-500/70"></div>
                </div>
            </div>

            <div class="sm:col-span-2 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                <div class="flex items-center justify-between">
                    <div class="text-xs text-slate-500 dark:text-slate-400">External HD</div>
                    <span class="rounded-lg bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600 dark:bg-white/10 dark:text-slate-300">
                        NONE
                    </span>
                </div>
                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                    No external volumes detected. Attach drive to enable offline payload storage.
                </div>
            </div>
        </div>
    </div>
</div>
