<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Net Wars') }} - @yield('title')</title>

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

                        {{ $slot }}

                        <!-- Footer -->
                        @include('partials.footer')
                        <!-- Footer -->
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
    </body>
</html>
