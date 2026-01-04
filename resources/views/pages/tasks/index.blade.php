@section('title', 'Task Manager')

<x-app-layout>
    @include('pages.tasks.subnav')

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
        <table class="w-full table-fixed">
            <colgroup>
                <col class="w-[46%]" />
                <col class="w-[36%]" />
                <col class="w-[12%]" />
                <col class="w-[6%]" />
            </colgroup>

            <thead class="hidden lg:table-header-group">
            <tr class="border-b border-slate-200/70 bg-white/40 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:bg-white/5 dark:text-slate-400">
                <th class="px-5 py-3 font-semibold">Task</th>
                <th class="px-5 py-3 font-semibold">Progress</th>
                <th class="px-5 py-3 font-semibold">Stats</th>
                <th class="px-5 py-3 font-semibold text-right"> </th>
            </tr>
            </thead>

            <tbody class="divide-y divide-slate-200/70 dark:divide-white/10" id="tasksTbody">
            @foreach ($tasks as $task)
                @php
                    $status = $task->status ?? 'running';
                    $startedIso = optional($task->started_at)->toISOString();
                    $endsIso = optional($task->ends_at)->toISOString();
                @endphp

                <tr class="align-middle hover:bg-slate-50/70 transition dark:hover:bg-white/5"
                    data-task-id="{{ $task->id }}"
                    data-status="{{ $status }}"
                    data-started-at="{{ $startedIso }}"
                    data-ends-at="{{ $endsIso }}"
                    data-finalize-url="{{ route('tasks.finalize', ['process' => $task->id]) }}"
                    data-cancel-url="{{ route('tasks.cancel', ['process' => $task->id]) }}"
                >
                    <!-- Task label -->
                    <td class="px-4 py-3 sm:px-5">
                        <div class="min-w-0">
                            <div class="text-sm leading-6 text-slate-700 dark:text-slate-200">
                                <span class="text-slate-500 dark:text-slate-400">{{ $task->whatAction()['text'] }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $task->whatAction()['software'] }}</span>
                                <span class="text-slate-500 dark:text-slate-400">on</span>
                                <span class="font-medium text-slate-800 dark:text-slate-200">{{ $task->whatAction()['target'] }}</span>
                            </div>
                        </div>

                        <!-- Mobile-only meta -->
                        <div class="mt-2 lg:hidden">
                            <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                                <span class="font-semibold text-slate-600 dark:text-slate-300" data-role="pct">0%</span>
                                <span data-role="time">--</span>
                            </div>
                            <div class="mt-1.5 h-3 rounded-md border border-slate-300 bg-white/60 p-[2px] dark:border-white/10 dark:bg-white/5">
                                <div class="h-full w-0 rounded-[5px] bg-cyan-500/80 dark:bg-cyan-400/80" data-role="bar"></div>
                            </div>
                        </div>
                    </td>

                    <!-- Progress (desktop/tablet) -->
                    <td class="hidden px-4 py-3 sm:px-5 lg:table-cell">
                        <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                            <span class="font-semibold text-slate-600 dark:text-slate-300" data-role="pct">0%</span>
                            <span data-role="time">--</span>
                        </div>
                        <div class="mt-1.5 h-3 rounded-md border border-slate-300 bg-white/60 p-[2px] dark:border-white/10 dark:bg-white/5">
                            <div class="h-full w-0 rounded-[5px] bg-cyan-500/80 dark:bg-cyan-400/80" data-role="bar"></div>
                        </div>
                    </td>

                    <!-- Stats (desktop/tablet) -->
                    <td class="hidden px-4 py-3 sm:px-5 lg:table-cell">
                        <div class="flex items-center gap-6 text-xs text-slate-600 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="grid h-4 w-4 place-items-center rounded border border-slate-300 bg-white/70 dark:border-white/10 dark:bg-white/5">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-emerald-500/80"></span>
                                </span>
                                <span class="font-medium">{{ $task->share_percent }}%</span>
                            </div>
                        </div>
                    </td>

                    <!-- Close -->
                    <td class="px-4 py-3 sm:px-5">
                        <div class="flex justify-end">
                            <button type="button" data-role="close" data-cancel-url="{{ route('tasks.cancel', ['process' => $task->id]) }}" class="grid aspect-square size-9 place-items-center rounded-md border border-slate-200 bg-white/70 text-slate-600 shadow-[0_1px_2px_rgba(0,0,0,0.08)]
                                       hover:border-red-300 hover:text-red-600 hover:bg-red-50
                                       dark:border-white/10 dark:bg-white/5 dark:text-slate-300 dark:hover:border-red-500/40 dark:hover:bg-red-500/10 dark:hover:text-red-300
                                       focus:outline-none focus:ring-2 focus:ring-cyan-400/40
                                       disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white/70 disabled:hover:text-slate-600 disabled:hover:border-slate-200"
                                    aria-label="Close"
                                    @if($status !== 'running') disabled @endif>
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M7 7l10 10M17 7L7 17" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const statusUrl = @json(route('tasks.status'));
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        const rows = Array.from(document.querySelectorAll('tr[data-task-id]'));
        const rowMap = new Map(rows.map(r => [String(r.dataset.taskId), r]));

        // Track finalize timers + in-flight finalize calls
        const finalizeTimeouts = new Map(); // taskId => timeoutId
        const finalizeInFlight = new Set(); // taskId

        // ---------------- Utils ----------------
        function fmtHMS(totalSec) {
            totalSec = Math.max(0, totalSec | 0);
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            return `${h}h:${m}m:${s}s`;
        }

        function clamp(n, a, b) { return Math.max(a, Math.min(b, n)); }

        function computeFromTimestamps(startIso, endIso) {
            const start = Date.parse(startIso);
            const end = Date.parse(endIso);
            const now = Date.now();

            if (!Number.isFinite(start) || !Number.isFinite(end) || end <= start) {
                return { pct: 0, remaining: 0, done: false };
            }

            const total = end - start;
            const remainingMs = Math.max(0, end - now);
            const elapsed = total - remainingMs;
            const pct = clamp(elapsed / total, 0, 1);
            return { pct, remaining: Math.ceil(remainingMs / 1000), done: remainingMs === 0 };
        }

        function setCloseDisabled(row, disabled) {
            const btn = row.querySelector('[data-role="close"]');
            if (!btn) return;
            btn.disabled = !!disabled;
        }

        function updateRowUI(row, pct, remainingSeconds, status) {
            const pctEls = row.querySelectorAll('[data-role="pct"]');
            const timeEls = row.querySelectorAll('[data-role="time"]');
            const barEls  = row.querySelectorAll('[data-role="bar"]');

            const pctText = Math.round(pct * 100) + '%';
            pctEls.forEach(el => el.textContent = pctText);
            timeEls.forEach(el => el.textContent = fmtHMS(remainingSeconds));
            barEls.forEach(el => el.style.width = Math.round(pct * 100) + '%');

            // Disable close when not running
            setCloseDisabled(row, status !== 'running');

            // Optional style tweak
            row.classList.toggle('opacity-60', status === 'completed');
        }

        function anyRunning() {
            return rows.some(r => r.dataset.status === 'running');
        }

        // ---------------- Finalize (called once at ends_at) ----------------
        async function finalizeTask(row) {
            const id = String(row.dataset.taskId);
            const url = row.dataset.finalizeUrl;

            if (!url) return;
            if (finalizeInFlight.has(id)) return;

            finalizeInFlight.add(id);

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    credentials: 'same-origin',
                });

                if (!res.ok) return;

                const data = await res.json();

                if (data.status === 'completed') {
                    // simplest: refresh entire page so the table is accurate
                    window.location.reload();
                    return;
                }

                // If still running (client clock skew), schedule a short retry
                if (data.status === 'still_running') {
                    setTimeout(() => finalizeTask(row), 500);
                }
            } catch (e) {
                console.error(e);
            } finally {
                finalizeInFlight.delete(id);
            }
        }

        function scheduleFinalize(row) {
            const id = String(row.dataset.taskId);
            if (row.dataset.status !== 'running') return;

            const endsAt = row.dataset.endsAt;
            if (!endsAt) return;

            const endMs = Date.parse(endsAt);
            if (!Number.isFinite(endMs)) return;

            // Clear previous timer if exists (ends_at might change after sync)
            if (finalizeTimeouts.has(id)) {
                clearTimeout(finalizeTimeouts.get(id));
                finalizeTimeouts.delete(id);
            }

            const delayMs = Math.max(0, endMs - Date.now());
            const tid = setTimeout(() => finalizeTask(row), delayMs + 50); // small buffer
            finalizeTimeouts.set(id, tid);
        }

        // ---------------- Local UI ticker (accurate progress/time) ----------------
        function tickUI() {
            for (const row of rows) {
                const status = row.dataset.status || 'running';

                if (status === 'running') {
                    const startIso = row.dataset.startedAt;
                    const endIso = row.dataset.endsAt;

                    if (startIso && endIso) {
                        const { pct, remaining, done } = computeFromTimestamps(startIso, endIso);
                        updateRowUI(row, pct, remaining, 'running');

                        if (done) {
                            // UI reaches 100% immediately; finalize will handle server completion
                            updateRowUI(row, 1, 0, 'completed');
                            setCloseDisabled(row, true);
                        }
                    } else {
                        // If timestamps missing, still disable close
                        setCloseDisabled(row, false);
                    }
                } else if (status === 'completed') {
                    updateRowUI(row, 1, 0, 'completed');
                    setCloseDisabled(row, true);
                } else {
                    // failed/unknown
                    updateRowUI(row, 0, 0, status);
                    setCloseDisabled(row, true);
                }
            }

            setTimeout(tickUI, 200);
        }

        // ---------------- Status sync (simple, low-frequency) ----------------
        let syncTimer = null;

        async function syncOnce() {
            // Stop syncing if no running tasks
            if (!anyRunning()) {
                if (syncTimer) { clearInterval(syncTimer); syncTimer = null; }
                return;
            }

            try {
                const res = await fetch(statusUrl, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });

                if (!res.ok) return;

                const data = await res.json();

                for (const t of data.tasks || []) {
                    const row = rowMap.get(String(t.id));
                    if (!row) continue;

                    // Update truth from server
                    if (t.status) row.dataset.status = t.status;
                    if (t.started_at) row.dataset.startedAt = t.started_at;
                    if (t.ends_at) row.dataset.endsAt = t.ends_at;

                    // If it is still running, ensure finalize is scheduled exactly at ends_at
                    if (row.dataset.status === 'running') {
                        scheduleFinalize(row);
                    } else {
                        // not running => no finalize timer needed
                        const id = String(row.dataset.taskId);
                        if (finalizeTimeouts.has(id)) {
                            clearTimeout(finalizeTimeouts.get(id));
                            finalizeTimeouts.delete(id);
                        }
                        setCloseDisabled(row, true);
                    }
                }
            } catch (e) {
                console.error(e);
            }

            // Stop syncing if everything finished
            if (!anyRunning() && syncTimer) {
                clearInterval(syncTimer);
                syncTimer = null;
            }
        }

        // ---------------- Init ----------------
        // Initialize rows from server-rendered dataset, schedule finalize for running tasks
        for (const row of rows) {
            row.dataset.status = row.dataset.status || 'running';

            if (row.dataset.status === 'running') {
                scheduleFinalize(row);
                setCloseDisabled(row, false);
            } else {
                setCloseDisabled(row, true);
            }
        }

        // Start accurate local UI updates
        tickUI();

        // Keep status endpoint (simple), but only if there are running tasks
        if (anyRunning()) {
            syncOnce();
            syncTimer = setInterval(syncOnce, 5000);
        }
    </script>
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('[data-role="close"]');
            if (!btn) return;

            const row = btn.closest('tr[data-task-id]');
            if (!row) return;

            // Only cancel running tasks
            if (row.dataset.status !== 'running') return;

            const url = row.dataset.cancelUrl; // data-cancel-url -> cancelUrl
            if (!url) return;

            // Prevent double clicks
            btn.disabled = true;

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    credentials: 'same-origin',
                });

                if (!res.ok) {
                    btn.disabled = false;
                    return;
                }

                // Refresh content (simple + reliable)
                window.location.reload();
            } catch (err) {
                console.error(err);
                btn.disabled = false;
            }
        });

    </script>

</x-app-layout>
