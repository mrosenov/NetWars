<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
    <div class="flex items-center justify-between px-3 py-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('target.logs') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('target.logs')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('target.logs'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('target.logs')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </span>
                Logs
            </a>

            <a href="{{ route('target.software') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('target.software')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('target.software'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('target.software')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                </span>
                Software
            </a>

            <a href="{{ route('target.logout') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('target.logout')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('target.logout'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('target.logout')])>
                    <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="size-5">
                        <path d="M17 16l4-4m0 0l-4-4 m4 4h-14m5 8 H6a3 3 0 01-3-3V7a3 3 0 013-3h7"></path>
                    </svg>
                </span>
                Logout
            </a>
        </div>

        <a href="#" class="rounded-lg bg-cyan-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-400">
            Help
        </a>
    </div>
</div>
