<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
    <div class="flex items-center justify-between px-3 py-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('software.index') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('software.index')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('software.index'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('software.index')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                </span>
                Software
            </a>

            <a href="{{ route('software.external') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('software.external')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('software.external'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('software.external')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </span>
                External Drive
            </a>
        </div>
    </div>
</div>
