<div class="flex items-center justify-between border-b border-slate-200/70 px-4 py-3 dark:border-white/10">
    <div class="flex items-center gap-2">
        <a href="{{ route('internet.show', $ip) }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5', 'bg-slate-100 dark:bg-white/10 dark:text-slate-100' => request()->routeIs('internet.show')])>
            <span class="text-cyan-600 dark:text-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
            </span> Info
        </a>

        <a href="{{ route('internet.loginShow', $ip) }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5', 'bg-slate-100 dark:bg-white/10 dark:text-slate-100' => request()->routeIs('internet.loginShow')])>
            <span class="text-cyan-600 dark:text-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                </svg>
            </span> Login
        </a>

        <a href="{{ route('internet.hackShow', $ip) }}" @class(['inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5', 'bg-slate-100 dark:bg-white/10 dark:text-slate-100' => request()->routeIs('internet.hackShow')])>
            <span class="text-cyan-600 dark:text-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m6.75 7.5 3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </span> Hack
        </a>
    </div>

    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $targetType['classes'] }}">
        {{ $targetType['label'] }}
    </span>
</div>
