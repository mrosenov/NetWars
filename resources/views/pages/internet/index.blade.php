@section('title', 'Internet')
<x-app-layout>
    <!-- INTERNET PANEL (Index / Login / Hack in one) -->
    <section class="space-y-5">

        <!-- IP BAR -->
        @include('pages.internet.partials.search')
        <!-- IP BAR -->


        <!-- TABS + CONTENT -->
        <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur
              dark:border-white/10 dark:bg-white/5">

            <!-- Tabs -->
            <div class="flex items-center justify-between border-b border-slate-200/70 px-4 py-3 dark:border-white/10">
                <div class="flex items-center gap-2">
                    <button data-tab="index"
                            class="tab-btn inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                 bg-slate-100 text-slate-900 dark:bg-white/10 dark:text-slate-100">
                        <span class="text-cyan-600 dark:text-cyan-300">🗂️</span> Index
                    </button>

                    <button data-tab="login"
                            class="tab-btn inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5">
                        <span class="text-green-600 dark:text-green-300">🔑</span> Login
                    </button>

                    <button data-tab="hack"
                            class="tab-btn inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5">
                        <span class="text-red-600 dark:text-red-400">⚡</span> Hack
                    </button>
                </div>
                @php
                    $isVpc = isset($network) && $network->owner_type === \App\Models\User::class;
                @endphp

                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                    {{ $isVpc ? 'bg-green-400/10 text-green-400 inset-ring inset-ring-green-500/20' : 'bg-blue-400/10 text-blue-400 inset-ring inset-ring-blue-400/30'}}">
                    {{ $isVpc ? 'VPC' : 'NPC' }}
                </span>
            </div>

            <!-- INDEX TAB -->
            <div data-panel="index" class="tab-panel p-5">
                <div class="mt-2 text-sm text-slate-700 dark:text-slate-200">
                    {{ $metadata['text'] ?? '' }}
                </div>

                <div class="mt-5 space-y-2">
                    @if($title = data_get($metadata, 'recommendations.title'))
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            {{ $title }}
                        </div>
                    @endif
                        @forelse (data_get($metadata, 'recommendations.items', []) as $recommendation)
                            <a href="{{ data_get($recommendation, 'url') }}" class="group block rounded-xl px-3 py-2 transition hover:bg-slate-100 dark:hover:bg-white/5">
                                <span class="font-semibold text-slate-900 dark:text-slate-100">
                                    {{ data_get($recommendation, 'ip') }}
                                </span>
                                <span class="text-slate-500 dark:text-slate-400">—</span>
                                <span class="text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-slate-100">
                                    {{ data_get($recommendation, 'label') }}
                                </span>
                            </a>
                        @empty
                            {{-- nothing to show --}}
                        @endforelse
                </div>
            </div>

            <!-- LOGIN TAB -->
            <div data-panel="login" class="tab-panel hidden p-6">
                <div class="mx-auto max-w-xl rounded-2xl border border-slate-200 bg-white shadow-sm
                  dark:border-white/10 dark:bg-[#070A0F]/60">
                    <div class="px-6 py-5 border-b border-slate-200/70 dark:border-white/10 text-center">
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Enter username and password to continue.
                        </div>
                    </div>

                    <div class="px-6 py-6 space-y-4">
                        <div class="flex items-center rounded-xl bg-slate-100 px-3 py-2
                      focus-within:ring-2 focus-within:ring-cyan-500/40
                      dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                            <div class="mr-2 grid h-9 w-9 place-items-center rounded-xl bg-white/60 dark:bg-white/5">👤</div>
                            <input placeholder="Username"
                                   class="w-full bg-transparent border-0 p-0 text-sm text-slate-900
                     placeholder:text-slate-400 focus:outline-none focus:ring-0
                     dark:text-slate-100 dark:placeholder:text-slate-500" />
                        </div>

                        <div class="flex items-center rounded-xl bg-slate-100 px-3 py-2
                      focus-within:ring-2 focus-within:ring-cyan-500/40
                      dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                            <div class="mr-2 grid h-9 w-9 place-items-center rounded-xl bg-white/60 dark:bg-white/5">🔒</div>
                            <input type="password" placeholder="Password"
                                   class="w-full bg-transparent border-0 p-0 text-sm text-slate-900
                     placeholder:text-slate-400 focus:outline-none focus:ring-0
                     dark:text-slate-100 dark:placeholder:text-slate-500" />
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-5 py-2.5 text-xs font-semibold
                           text-cyan-700 shadow-sm dark:text-cyan-300">
                                Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HACK TAB -->
            <div data-panel="hack" class="tab-panel hidden p-6">
                <div class="text-center text-sm font-semibold text-slate-900 dark:text-slate-100">
                    Choose your attack method:
                </div>

                <div class="mt-6 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <div class="w-56 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition
                    hover:-translate-y-0.5 hover:shadow-md
                    dark:border-white/10 dark:bg-[#070A0F]/60">
                        <div class="flex items-start gap-3">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-green-500/10 text-green-700 dark:text-green-300">🔐</div>
                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">Bruteforce attack</div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">v1.0</div>
                            </div>
                        </div>
                    </div>

                    <div class="w-56 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition
                    hover:-translate-y-0.5 hover:shadow-md
                    dark:border-white/10 dark:bg-[#070A0F]/60">
                        <div class="flex items-start gap-3">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-cyan-500/10 text-cyan-700 dark:text-cyan-300">🐞</div>
                            <div>
                                <div class="text-sm font-semibold text-red-600 dark:text-red-400">Exploit attack</div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">No Port Scan.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        // Simple tabs (no dependencies)
        (function () {
            const root = document.currentScript?.previousElementSibling || document;
            const btns = root.querySelectorAll(".tab-btn");
            const panels = root.querySelectorAll(".tab-panel");

            function setActive(tab) {
                btns.forEach(b => {
                    const active = b.getAttribute("data-tab") === tab;
                    b.classList.toggle("bg-slate-100", active);
                    b.classList.toggle("text-slate-900", active);
                    b.classList.toggle("dark:bg-white/10", active);
                    b.classList.toggle("dark:text-slate-100", active);

                    b.classList.toggle("text-slate-500", !active);
                    b.classList.toggle("dark:text-slate-400", !active);
                });

                panels.forEach(p => {
                    p.classList.toggle("hidden", p.getAttribute("data-panel") !== tab);
                });
            }

            btns.forEach(b => b.addEventListener("click", () => setActive(b.getAttribute("data-tab"))));

            // default
            setActive("index");
        })();
    </script>

</x-app-layout>
