<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Net Wars') }}</title>

    <!-- Fonts (optional) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Safe CRT overlay (no negative left/right => no x-scroll) */
        .crt{
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }
        .crt::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 10;
            opacity: 0.18;
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,0.04),
                rgba(255,255,255,0.04) 1px,
                rgba(0,0,0,0) 3px,
                rgba(0,0,0,0) 6px
            );
            mix-blend-mode: overlay;
        }
        .crt::after{
            content:"";
            position:absolute;
            left:0; right:0;
            top:-30%;
            height:28%;
            pointer-events:none;
            z-index:11;
            opacity:.10;
            background: linear-gradient(to bottom, transparent, rgba(34,211,238,.25), transparent);
            filter: blur(1px);
            animation: scanTop 6s linear infinite;
            will-change: top;
        }
        @keyframes scan {
            0%   { transform: translateY(-20%); }
            100% { transform: translateY(120%); }
        }

        @keyframes scanTop{
            0%   { top:-30%; }
            100% { top:130%; }
        }

        /* Small grain */
        .grain {
            background-image:
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.06) 0 1px, transparent 2px),
                radial-gradient(circle at 70% 60%, rgba(255, 255, 255, 0.05) 0 1px, transparent 2px),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.04) 0 1px, transparent 2px);
            background-size: 140px 140px;
        }
    </style>

    <script>
        // Apply theme ASAP to avoid flash (runs before body paint)
        (function () {
            const saved = localStorage.getItem('hw-theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body class="h-full overflow-x-hidden font-mono antialiased
             bg-slate-50 text-slate-900 dark:bg-[#070A0F] dark:text-slate-100">
<div class="crt grain min-h-screen flex flex-col">
    <!-- Top mini bar (guest) -->
    <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-slate-50/85 backdrop-blur dark:border-white/10 dark:bg-[#070A0F]/65">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div class="flex h-14 items-center justify-between">
                <a href="/" class="flex items-center gap-3">
                    <div class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <div class="text-[11px] uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">
                            {{ config('app.name', 'Net Wars') }}
                        </div>
                        <div class="text-sm font-semibold">
                            Access Node
                            <span class="ml-2 text-[11px] font-normal text-slate-500 dark:text-slate-400">auth</span>
                        </div>
                    </div>
                </a>

                <button type="button" id="themeToggle" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5" aria-label="Toggle theme">
                    <svg id="sunIcon" viewBox="0 0 24 24" class="h-4 w-4 text-amber-500 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 3v2M12 19v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M3 12h2M19 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                    <svg id="moonIcon" viewBox="0 0 24 24" class="h-4 w-4 text-cyan-600 dark:hidden" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>
                    </svg>
                    <span>Mode</span>
                    <span class="rounded-lg bg-slate-100 px-2 py-0.5 text-[10px] text-slate-600 dark:bg-white/10 dark:text-slate-300">
                        CTRL+L
                    </span>
                </button>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="mx-auto max-w-6xl w-full px-4 sm:px-6 flex-1 flex items-center py-6">
        <div class="w-full">
            {{ $slot }}
        </div>
    </main>

    <footer class="mt-auto mx-auto max-w-6xl w-full px-4 sm:px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>© {{ date('Y') }} — {{ config('app.name', 'Net Wars') }}</div>
            <div class="flex flex-wrap gap-3">
                <a href="#" class="hover:underline">Terms</a>
                <a href="#" class="hover:underline">Privacy</a>
                <a href="#" class="hover:underline">Discord</a>
            </div>
        </div>
    </footer>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const root = document.documentElement;
        const btn = document.getElementById("themeToggle");

        if (!btn) {
            console.warn("themeToggle button not found");
            return;
        }

        // Ensure we start from saved theme (or system preference)
        const saved = localStorage.getItem("hw-theme");
        const prefersDark = window.matchMedia?.("(prefers-color-scheme: dark)")?.matches;

        if (saved === "dark" || (!saved && prefersDark)) root.classList.add("dark");
        else root.classList.remove("dark");

        const setTheme = (isDark) => {
            root.classList.toggle("dark", isDark);
            localStorage.setItem("hw-theme", isDark ? "dark" : "light");
        };

        const toggleTheme = () => setTheme(!root.classList.contains("dark"));

        btn.addEventListener("click", (e) => {
            e.preventDefault();
            toggleTheme();
        });

        // Shortcut CTRL+L / CMD+L
        window.addEventListener("keydown", (e) => {
            const isCtrlL = (e.ctrlKey || e.metaKey) && e.key.toLowerCase() === "l";
            if (!isCtrlL) return;
            e.preventDefault();
            toggleTheme();
        });
    });
</script>
</body>
</html>
