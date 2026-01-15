<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Net Wars') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <body style="margin: 0; font-family: Inter,Sans-Serif,serif">
    <div class="min-h-screen bg-background-primary text-text-primary font-mono selection:bg-accent-primary selection:text-background-primary">
        <div class="scanlines"></div>

        <!-- Top bar -->
        <header class="sticky top-0 z-40 bg-background-secondary border-default border-b border-border shadow-lg">
            <div class="max-w-5xl mx-auto h-14 px-4 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-accent-primary group-hover:rotate-12 transition-transform">
                        <path d="M12 19h8"/>
                        <path d="m4 17 6-6-6-6"/>
                    </svg>
                    <span class="text-lg font-bold tracking-tighter hover-glitch">Net<span class="text-accent-primary">Wars</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-xs text-text-secondary hover:text-[var(--accent-primary)] transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="text-xs text-text-secondary hover:text-[var(--accent-primary)] transition-colors">Create Account</a>

                    <!-- Theme toggle -->
                    <button class="p-2 rounded-none border border-default border-border hover:bg-[var(--bg-primary)]/10 transition-colors group relative overflow-hidden" aria-label="Toggle theme" id="themeToggle" aria-pressed="false">
                        <div class="relative z-10">
                            <svg id="themeIconMoon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:-rotate-12">
                                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                            </svg>
                            <svg id="themeIconSun" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:rotate-90 hidden">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2"></path>
                                <path d="M12 20v2"></path>
                                <path d="m4.93 4.93 1.41 1.41"></path>
                                <path d="m17.66 17.66 1.41 1.41"></path>
                                <path d="M2 12h2"></path>
                                <path d="M20 12h2"></path>
                                <path d="m6.34 17.66-1.41 1.41"></path>
                                <path d="m19.07 4.93-1.41 1.41"></path>
                            </svg>
                        </div>
                        <div class="absolute inset-0 bg-accent-primary/5 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="max-w-5xl mx-auto px-4 py-10">
            <div class="max-w-md mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        (function () {
            const root = document.documentElement;
            const key = 'theme';

            function applyTheme(theme) {
                root.classList.remove('light', 'dark');
                root.classList.add(theme);
                const isDark = theme === 'dark';
                const moon = document.getElementById('themeIconMoon');
                const sun = document.getElementById('themeIconSun');
                if (moon && sun) {
                    moon.classList.toggle('hidden', isDark);
                    sun.classList.toggle('hidden', !isDark);
                }
                const toggle = document.getElementById('themeToggle');
                if (toggle) toggle.setAttribute('aria-pressed', String(isDark));
            }

            function getPreferredTheme() {
                const stored = localStorage.getItem(key);
                if (stored === 'light' || stored === 'dark') return stored;
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            applyTheme(getPreferredTheme());

            const btn = document.getElementById('themeToggle');
            if (btn) {
                btn.addEventListener('click', () => {
                    const current = root.classList.contains('dark') ? 'dark' : 'light';
                    const next = current === 'dark' ? 'light' : 'dark';
                    localStorage.setItem(key, next);
                    applyTheme(next);
                });
            }
        })();
    </script>
    </body>
</html>
