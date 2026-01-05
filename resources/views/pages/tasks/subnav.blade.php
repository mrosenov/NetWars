<div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
    <div class="flex items-center justify-between px-3 py-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('tasks.index') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('tasks.index')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('tasks.index'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('tasks.index')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                    </svg>
                </span>
                All Tasks
            </a>

            <a href="{{ route('tasks.cpu') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('tasks.cpu')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('tasks.cpu'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('tasks.cpu')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                    </svg>
                </span>
                CPU Tasks
            </a>

            <a href="{{ route('tasks.network') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('tasks.network')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('tasks.network'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('tasks.network')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </span>
                Download Manager
            </a>

            <a href="{{ route('tasks.running') }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white', 'bg-white dark:bg-white/10 ring-1 ring-slate-200 dark:ring-white/10 shadow-sm hover:ring-slate-300' => request()->routeIs('tasks.running')])>
                <span @class(['grid h-6 w-6 place-items-center rounded-lg text-cyan-700 dark:text-cyan-300' => request()->routeIs('tasks.running'),'grid h-6 w-6 place-items-center rounded-lg text-slate-700 dark:text-slate-200' => !request()->routeIs('tasks.running')])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </span>
                Running Software
            </a>
        </div>
    </div>
</div>
