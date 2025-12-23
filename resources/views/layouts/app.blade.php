<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-mono overflow-x-hidden dark:bg-[#070A0F]">
        <!-- App shell background -->
        <div class="min-h-full crt grain bg-slate-50 text-slate-900 dark:bg-[#070A0F] dark:text-slate-100">
            <!-- Top bar -->
            @include('partials.header')
            <!-- Top bar -->

            <div class="mx-auto max-w-[1400px] px-4 sm:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-5 py-6">
                    <!-- Sidebar -->
                    @include('partials.sidebar')
                    <!-- Sidebar -->

                    <!-- Main content -->
                    <main class="space-y-5">
                        <!-- Breadcrumb + quick actions -->
                        @include('partials.breadcrumb')
                        <!-- Breadcrumb + quick actions -->

                        <!-- Top grid: Hardware + General info -->
                        <section class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                            <!-- Hardware Information -->
                            @include('partials.hardwareInfo')
                            <!-- Hardware Information -->

                            <!-- General Info -->
{{--                            @include('partials.generalInfo')--}}
                            <!-- General Info -->
                        </section>

                        <!-- Middle grid: News + Wanted + Round + Leaderboard -->
                        <section class="grid grid-cols-1 xl:grid-cols-12 gap-5">
                            <!-- News feed -->
{{--                            @include('partials.gameNews')--}}
                            <!-- News feed -->


                            <!-- Right column stack -->
                            <div class="xl:col-span-5 grid grid-cols-1 gap-5">
                                <!-- FBI Wanted -->
{{--                                @include('partials.fbiWanted')--}}
                                <!-- FBI Wanted -->

                                <!-- Round info -->
{{--                                @include('partials.roundInfo')--}}
                                <!-- Round info -->

                                <!-- Top users -->
{{--                                @include('partials.ranking')--}}
                                <!-- Top users -->
                            </div>
                        </section>

                        <!-- Announcements table -->
                        <section class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
{{--                            @include('partials.announcements')--}}
                        </section>

                        <!-- Footer -->
                        <footer class="pb-10 pt-2 text-xs text-slate-500 dark:text-slate-400">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>© 2025 — Net Wars • Modern control panel concept</div>
                                <div class="flex flex-wrap gap-3">
                                    <a href="#" class="hover:underline">Terms</a>
                                    <a href="#" class="hover:underline">Privacy</a>
                                    <a href="#" class="hover:underline">Discord</a>
                                    <a href="#" class="hover:underline">Stats</a>
                                </div>
                            </div>
                        </footer>
                    </main>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @include('modals.sample')
        <!-- Modal -->

        <script>
            // Lightweight modal controller: open/close, ESC, backdrop click
            (function () {
                function openModal(id) {
                    const modal = document.getElementById(id);
                    if (!modal) return;
                    modal.classList.remove("hidden");
                    modal.setAttribute("aria-hidden", "false");
                    document.body.style.overflow = "hidden";

                    // focus first autofocus element (or first input/button)
                    const focusEl =
                        modal.querySelector("[autofocus]") ||
                        modal.querySelector("button, [href], input, select, textarea, [tabindex]:not([tabindex='-1'])");
                    focusEl && focusEl.focus();
                }

                function closeModal(id) {
                    const modal = document.getElementById(id);
                    if (!modal) return;
                    modal.classList.add("hidden");
                    modal.setAttribute("aria-hidden", "true");
                    document.body.style.overflow = "";
                }

                // Open buttons
                document.addEventListener("click", (e) => {
                    const openBtn = e.target.closest("[data-modal-open]");
                    if (openBtn) openModal(openBtn.getAttribute("data-modal-open"));

                    const closeBtn = e.target.closest("[data-modal-close]");
                    if (closeBtn) closeModal(closeBtn.getAttribute("data-modal-close"));
                });

                // ESC to close (closes topmost visible modal by z-index assumption)
                document.addEventListener("keydown", (e) => {
                    if (e.key !== "Escape") return;
                    const openModals = [...document.querySelectorAll('[id][aria-hidden="false"]')];
                    if (!openModals.length) return;
                    closeModal(openModals[openModals.length - 1].id);
                });
            })();
        </script>
        <script>
            // Theme toggle with persistence + keyboard shortcut (CTRL+L)
            (function () {
                const root = document.documentElement;
                const btn = document.getElementById("themeToggle");

                // init from localStorage OR system preference (fallback)
                const saved = localStorage.getItem("hw-theme");
                if (saved === "light") root.classList.remove("dark");
                if (saved === "dark") root.classList.add("dark");
                if (!saved) {
                    const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
                    root.classList.toggle("dark", prefersDark);
                }

                function toggleTheme() {
                    root.classList.toggle("dark");
                    localStorage.setItem("hw-theme", root.classList.contains("dark") ? "dark" : "light");
                }

                btn.addEventListener("click", toggleTheme);

                window.addEventListener("keydown", (e) => {
                    const isCtrlL = (e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === "l");
                    if (isCtrlL) {
                        e.preventDefault();
                        toggleTheme();
                    }
                });
            })();
        </script>
{{--        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">--}}
{{--            @include('layouts.navigation')--}}

{{--            <!-- Page Heading -->--}}
{{--            @isset($header)--}}
{{--                <header class="bg-white dark:bg-gray-800 shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
{{--            @endisset--}}

{{--            <!-- Page Content -->--}}
{{--            <main>--}}
{{--                {{ $slot }}--}}
{{--            </main>--}}
{{--        </div>--}}
    </body>
</html>
