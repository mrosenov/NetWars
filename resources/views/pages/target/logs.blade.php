{{-- resources/views/pages/target/logs.blade.php --}}
@section('title', 'Logs')

<x-app-layout>
    <section class="space-y-5">
        {{-- Top Tabs --}}
        @include('pages.target.subnav')
        {{-- Top Tabs --}}

        @if (session('status'))
            <x-alert type="success">
                {{ session('status') }}
            </x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="danger">
                {{ $errors->first() }}
            </x-alert>
        @endif

        <div class="flex flex-col lg:flex-row gap-5 items-start">
            <div class="w-full">
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                        <div class="text-sm font-semibold text-slate-900 dark:text-white">Logs</div>
                    </div>

                    <form id="logSaveForm" method="POST" action="{{ route('target.logs.save', ['networkId' => $networkId]) }}">
                        @csrf
                        <input type="hidden" name="base_hash" value="{{ $baseHash }}">

                        {{-- Editor --}}
                        <div id="logEditorWrap" class="px-5 py-4 space-y-2">
                            <textarea id="logs-content" name="content" rows="25"
                                      class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 font-mono text-sm text-slate-900 shadow-sm
                                       placeholder:text-slate-400
                                       focus:outline-none focus:ring-2 focus:ring-slate-900/10 focus:border-slate-300
                                       dark:border-white/10 dark:bg-white/5 dark:text-white dark:placeholder:text-white/40
                                       dark:focus:ring-white/15 dark:focus:border-white/20">{{ $content }}</textarea>
                        </div>

                        {{-- Saving UI --}}
                        <div id="savingWrap" class="hidden px-5 py-6">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">Saving logs…</div>

                            <div class="mt-3 w-full bg-slate-200 dark:bg-white/10 rounded-md h-3 overflow-hidden">
                                <div id="saveProgressBar" class="h-3 w-0 bg-emerald-500"></div>
                            </div>

                            <div id="saveTimer" class="mt-2 text-sm text-slate-600 dark:text-white/70"></div>

                            <div id="saveHint" class="mt-3 text-xs text-slate-500 dark:text-white/50">
                                Please wait. You can’t save again until this finishes.
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-slate-200/70 px-5 py-4 dark:border-white/10">
                            <button id="saveBtn" type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                       disabled:opacity-60 disabled:cursor-not-allowed
                                       dark:bg-white dark:text-slate-900 dark:hover:bg-white/90 dark:focus:ring-white/20">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const networkId = @json($networkId);

        const form = document.getElementById('logSaveForm');
        const saveBtn = document.getElementById('saveBtn');

        const logEditorWrap = document.getElementById('logEditorWrap');
        const savingWrap = document.getElementById('savingWrap');

        const bar = document.getElementById('saveProgressBar');
        const timer = document.getElementById('saveTimer');

        const textarea = document.getElementById('logs-content');
        const baseHashInput = document.querySelector('input[name="base_hash"]');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        let initialContent = textarea.value;     // used to detect “dirty”
        let savingInProgress = false;
        let countdownTimer = null;

        function fmt(sec) {
            sec = Math.max(0, sec|0);
            const m = Math.floor(sec/60);
            const s = sec%60;
            return m > 0 ? `${m}:${String(s).padStart(2,'0')}` : `${s}s`;
        }

        function showSavingUI() {
            logEditorWrap.classList.add('hidden');
            savingWrap.classList.remove('hidden');
            savingInProgress = true;
            updateSaveEnabled();
        }

        function showEditorUI() {
            savingWrap.classList.add('hidden');
            logEditorWrap.classList.remove('hidden');
            savingInProgress = false;
            updateSaveEnabled();
        }

        function updateSaveEnabled() {
            const unchanged = textarea.value === initialContent;
            saveBtn.disabled = savingInProgress || unchanged;
        }

        textarea.addEventListener('input', updateSaveEnabled);

        async function refreshLogContent() {
            const res = await fetch(`/networks/${networkId}/logs/content`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
            if (!res.ok) return;

            const data = await res.json();
            if (typeof data.content === 'string') textarea.value = data.content;
            if (typeof data.base_hash === 'string' && baseHashInput) baseHashInput.value = data.base_hash;

            // After refresh, this becomes the new “unchanged” baseline
            initialContent = textarea.value;
            updateSaveEnabled();
        }

        async function finalizeLogSave() {
            const res = await fetch(`/networks/${networkId}/log-save/finalize`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                credentials: 'same-origin',
            });

            if (!res.ok) throw new Error(`Finalize failed: HTTP ${res.status}`);
            return await res.json();
        }

        function startLocalCountdown(endsAtIso) {
            if (countdownTimer) clearInterval(countdownTimer);

            const endMs = Date.parse(endsAtIso);
            if (!Number.isFinite(endMs)) {
                timer.textContent = 'Saving...';
                return;
            }

            const totalMs = Math.max(1, endMs - Date.now());
            const startMs = Date.now();

            countdownTimer = setInterval(() => {
                const now = Date.now();
                const remainingMs = Math.max(0, endMs - now);
                const elapsedMs = Math.min(totalMs, now - startMs);

                const pct = Math.max(0, Math.min(100, Math.round((elapsedMs / totalMs) * 100)));
                bar.style.width = pct + '%';
                timer.textContent = `Saving... ${fmt(Math.ceil(remainingMs / 1000))} remaining`;

                if (remainingMs <= 0) {
                    clearInterval(countdownTimer);
                    countdownTimer = null;
                    // once countdown hits 0, finalize immediately
                    completeIfReady();
                }
            }, 200); // smooth enough without spamming server
        }

        async function completeIfReady() {
            try {
                timer.textContent = 'Applying...';
                bar.style.width = '100%';

                const fin = await finalizeLogSave();
                if (fin.status === 'still_running') {
                    // edge case: client clock skew; retry once shortly
                    setTimeout(completeIfReady, 300);
                    return;
                }

                timer.textContent = 'Updating...';
                await refreshLogContent();
                timer.textContent = 'Saved.';
                setTimeout(() => showEditorUI(), 400);
            } catch (e) {
                console.error(e);
                timer.textContent = 'Save failed. Try again.';
                setTimeout(() => showEditorUI(), 800);
            }
        }

        // ------------- Page-load resume logic (1 request) -------------
        async function resumeIfSaving() {
            try {
                const res = await fetch(`/networks/${networkId}/log-save-status`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                if (!res.ok) return;

                const data = await res.json();

                if (data.status === 'running') {
                    showSavingUI();
                    // Use ends_at so we can count down locally
                    if (data.ends_at) {
                        startLocalCountdown(data.ends_at);
                    } else {
                        timer.textContent = 'Saving...';
                    }
                    return;
                }

                // If backend reports completed (or none), just ensure editor is enabled + baseline correct
                showEditorUI();
                // optional: ensure content is up-to-date on page load
                await refreshLogContent();

            } catch (e) {
                console.error(e);
                showEditorUI();
            }
        }

        // ------------- Intercept Save (1 request to start + no polling spam) -------------
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Prevent pointless saves
            if (textarea.value === initialContent) return;
            if (savingInProgress) return;

            try {
                showSavingUI();

                const formData = new FormData(form);

                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: formData,
                    credentials: 'same-origin',
                });

                if (res.status === 409) {
                    // already saving
                    timer.textContent = 'Save already in progress...';
                    // resume state by calling resume once
                    await resumeIfSaving();
                    return;
                }

                if (!res.ok) {
                    const txt = await res.text();
                    throw new Error(`Save start failed: HTTP ${res.status} ${txt}`);
                }

                const data = await res.json();
                bar.style.width = '0%';
                timer.textContent = 'Saving...';

                // Start the countdown from ends_at; no polling.
                if (data.ends_at) startLocalCountdown(data.ends_at);
                else {
                    // fallback: fixed 3s
                    const fallbackEnd = new Date(Date.now() + 3000).toISOString();
                    startLocalCountdown(fallbackEnd);
                }

            } catch (err) {
                console.error(err);
                timer.textContent = 'Save failed. Try again.';
                setTimeout(() => showEditorUI(), 800);
            }
        });

        // init
        updateSaveEnabled();
        resumeIfSaving();
    </script>

</x-app-layout>
