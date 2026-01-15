<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
<body style="margin: 0; font-family: Inter,Sans-Serif,serif">
    <div class="min-h-screen bg-background-primary text-text-primary font-mono selection:bg-accent-primary selection:text-background-primary">
        <div class="scanlines"></div>

        <x-header />

        <div class="pt-14 flex">
            {{-- Mobile Sidebar Overlay --}}
            <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 hidden lg:hidden"></div>

            {{--Sidebar--}}
            <x-sidebar />

            {{-- Main Content --}}
            <main id="mainContent" class="flex-1 p-4 ml-0 lg:ml-64 transition-all duration-300">
                {{-- Breadcrumb / Page Title --}}
                <div class="mb-6 bg-background-secondary border border-default border-border p-4 flex items-center justify-between">
                    <h2 class="text-xl font-light text-text-primary">
                        Dashboard
                    </h2>
                </div>

                <div class="mb-6 text-xs text-text-secondary flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <span>/</span>
                    <span>Dashboard</span>
                </div>

                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        (function () {
            // Theme toggle (light/dark)
            const themeToggle = document.getElementById('themeToggle');
            const themeIconMoon = document.getElementById('themeIconMoon');
            const themeIconSun = document.getElementById('themeIconSun');
            const root = document.documentElement;

            function applyTheme(theme, persist = true) {
                root.classList.remove('light', 'dark');
                root.classList.add(theme);

                // Icon logic: show moon in light mode (switch to dark), show sun in dark mode (switch to light)
                if (themeIconMoon) themeIconMoon.classList.toggle('hidden', theme === 'dark');
                if (themeIconSun) themeIconSun.classList.toggle('hidden', theme !== 'dark');

                if (themeToggle) themeToggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
                if (persist) localStorage.setItem('theme', theme);
            }

            function getInitialTheme() {
                const saved = localStorage.getItem('theme');
                if (saved === 'light' || saved === 'dark') return saved;
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            // Set initial theme ASAP
            applyTheme(getInitialTheme(), false);

            themeToggle?.addEventListener('click', () => {
                const next = root.classList.contains('dark') ? 'light' : 'dark';
                applyTheme(next, true);
            });

            // If user hasn't chosen a theme, keep in sync with OS changes
            const mql = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;
            if (mql) {
                mql.addEventListener?.('change', (e) => {
                    const saved = localStorage.getItem('theme');
                    if (saved === 'light' || saved === 'dark') return;
                    applyTheme(e.matches ? 'dark' : 'light', false);
                });
            }

            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');
            const collapseBtn = document.getElementById('sidebarCollapse');


            const userMenuBtn = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');

            const openBtn = document.getElementById('openMissionModal');
            const modal = document.getElementById('missionModal');
            const modalPanel = document.getElementById('missionModalPanel');

            function isLg() {
                return window.matchMedia('(min-width: 1024px)').matches;
            }

            function setAriaExpanded(el, val) {
                if (!el) return;
                el.setAttribute('aria-expanded', val ? 'true' : 'false');
            }
// ----- User menu (mobile dropdown) -----
            function openUserMenu() {
                if (!userMenu) return;
                userMenu.classList.remove('hidden');
                setAriaExpanded(userMenuBtn, true);
            }

            function closeUserMenu() {
                if (!userMenu) return;
                userMenu.classList.add('hidden');
                setAriaExpanded(userMenuBtn, false);
            }

            function toggleUserMenu() {
                if (!userMenuBtn || !userMenu) return;
                const isOpen = !userMenu.classList.contains('hidden');
                isOpen ? closeUserMenu() : openUserMenu();
            }

            userMenuBtn?.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleUserMenu();
            });

            userMenu?.addEventListener('click', (e) => {
                // allow clicking inside menu without closing immediately
                e.stopPropagation();
            });

            document.addEventListener('click', () => {
                if (!userMenu || userMenu.classList.contains('hidden')) return;
                closeUserMenu();
            });



            // ----- Sidebar (mobile off-canvas + desktop collapse) -----
            function openMobileSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                setAriaExpanded(toggleBtn, true);
            }

            function closeMobileSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                setAriaExpanded(toggleBtn, false);
            }

            function handleSidebarToggle() {
                if (!sidebar || !overlay || !toggleBtn) return;

                // Requirement: toggle button is for mobile only.
                if (isLg()) return;

                // On mobile: slide in/out
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                isOpen ? closeMobileSidebar() : openMobileSidebar();
            }

            toggleBtn?.addEventListener('click', handleSidebarToggle);

            overlay?.addEventListener('click', closeMobileSidebar);

            // Ensure correct state on resize
            window.addEventListener('resize', () => {
                if (isLg()) closeUserMenu();
                if (isLg()) {
                    overlay?.classList.add('hidden');
                    sidebar?.classList.remove('translate-x-0');
                    sidebar?.classList.add('lg:translate-x-0');
                    setAriaExpanded(toggleBtn, false);
                } else {
                    // Mobile should start closed
                    sidebar?.classList.add('-translate-x-full');
                    sidebar?.classList.remove('translate-x-0');
                    overlay?.classList.add('hidden');
                    setAriaExpanded(toggleBtn, false);
                }
            });

            // ----- Modal -----
            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setAriaExpanded(openBtn, true);

                // entrance animation
                modal.classList.add('animate-in', 'fade-in');
                modalPanel?.classList.add('animate-in', 'zoom-in-95', 'slide-in-from-bottom-2');

                // focus first close button
                const close = modal.querySelector('[data-modal-close]');
                close?.focus();
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                setAriaExpanded(openBtn, false);
                openBtn?.focus();
            }

            openBtn?.addEventListener('click', openModal);

            modal?.addEventListener('click', (e) => {
                // click outside panel closes
                if (e.target === modal) closeModal();
            });

            modal?.querySelectorAll('[data-modal-close]')?.forEach((btn) => {
                btn.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (userMenu && !userMenu.classList.contains('hidden')) closeUserMenu();
                    if (!modal?.classList.contains('hidden')) closeModal();
                    if (!isLg() && overlay && !overlay.classList.contains('hidden')) closeMobileSidebar();
                }
            });

            // Initial state: mobile closed, desktop expanded
            if (!isLg()) closeMobileSidebar();
        })();
    </script>
</body>
</html>
