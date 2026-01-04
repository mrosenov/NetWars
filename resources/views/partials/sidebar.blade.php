<aside class="lg:sticky lg:top-20 h-fit">
    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
        <div class="px-4 py-4 border-b border-slate-200/70 dark:border-white/10">
            <div class="flex items-center justify-between">
                <div class="text-xs uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">Navigation</div>
            </div>
        </div>

        <nav class="p-2">
            <!-- Nav item helper: group for hover glow -->
            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="{{route('dashboard')}}">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M3 12l9-9 9 9"/><path d="M9 21V9h6v12"/>
                    </svg>
                  </span>
                <span class="font-semibold">Home</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">H</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="{{ route('tasks.index') }}">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>
                  </span>
                <span>Task Manager</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">T</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 2l3 7h7l-5.5 4 2.5 7-7-4.5L5 20l2.5-7L2 9h7z"/>
                    </svg>
                  </span>
                <span>Software</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">S</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="{{ route('internet.index') }}">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18"/><path d="M12 3a15 15 0 0 0 0 18"/>
                    </svg>
                  </span>
                <span>Internet</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">I</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M4 4h16v6H4z"/><path d="M4 14h16v6H4z"/><path d="M8 8h.01M8 18h.01"/>
                    </svg>
                  </span>
                <span>Hardware</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">W</span>
            </a>

            <div class="my-2 border-t border-slate-200/70 dark:border-white/10"></div>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                  </span>
                <span>Finances</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">$</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M3 5h18v14H3z"/><path d="M7 9h10"/><path d="M7 13h7"/>
                    </svg>
                  </span>
                <span>Hacked Database</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">DB</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                  </span>
                <span>Missions</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">M</span>
            </a>

            <a class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition hover:bg-slate-100 dark:hover:bg-white/5" href="#">
                  <span class="grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M17 11a5 5 0 0 0-10 0"/><path d="M12 11v6"/><path d="M7 21h10"/>
                    </svg>
                  </span>
                <span>Ranking</span>
                <span class="ml-auto text-[10px] text-slate-500 dark:text-slate-400">R</span>
            </a>
        </nav>
    </div>
</aside>
