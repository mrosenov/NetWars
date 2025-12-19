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
    <body class="h-full font-mono overflow-x-hidden">
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
                            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                    <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                      <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l9 4-9 4-9-4 9-4z"/><path d="M3 10l9 4 9-4"/><path d="M3 18l9 4 9-4"/>
                      </svg>
                    </span>
                                        <div>
                                            <div class="text-sm font-semibold">General Info</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Account & session telemetry</div>
                                        </div>
                                    </div>
                                    <span class="rounded-lg bg-cyan-500/10 px-2 py-1 text-[10px] font-semibold text-cyan-700 dark:text-cyan-300">
                    BASIC
                  </span>
                                </div>

                                <div class="p-5">
                                    <dl class="grid grid-cols-1 gap-3">
                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <dt class="text-xs text-slate-500 dark:text-slate-400">Reputation</dt>
                                            <dd class="text-sm font-semibold">
                                                4 <span class="text-xs font-normal text-slate-500 dark:text-slate-400">Ranked #441</span>
                                            </dd>
                                        </div>

                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <dt class="text-xs text-slate-500 dark:text-slate-400">Running tasks</dt>
                                            <dd class="text-sm font-semibold">0</dd>
                                        </div>

                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <dt class="text-xs text-slate-500 dark:text-slate-400">Connected to</dt>
                                            <dd class="text-sm font-semibold text-slate-700 dark:text-slate-200">No one</dd>
                                        </div>

                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <dt class="text-xs text-slate-500 dark:text-slate-400">Mission</dt>
                                            <dd class="text-sm font-semibold">None</dd>
                                        </div>

                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <dt class="text-xs text-slate-500 dark:text-slate-400">Clan</dt>
                                            <dd class="flex items-center gap-2">
                                                <span class="text-sm font-semibold">[b4] b4</span>
                                                <span class="rounded-lg bg-green-500/10 px-2 py-1 text-[10px] font-semibold text-green-700 dark:text-green-300">MASTER</span>
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </section>

                        <!-- Middle grid: News + Wanted + Round + Leaderboard -->
                        <section class="grid grid-cols-1 xl:grid-cols-12 gap-5">
                            <!-- News feed -->
                            <div class="xl:col-span-7 rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                    <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                      <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16v16H4z"/><path d="M8 8h8"/><path d="M8 12h8"/><path d="M8 16h5"/>
                      </svg>
                    </span>
                                        <div>
                                            <div class="text-sm font-semibold">News</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Latest ops chatter</div>
                                        </div>
                                    </div>
                                    <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                        View all
                                    </button>
                                </div>

                                <div class="p-5">
                                    <ul class="space-y-3">
                                        <li class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-cyan-700 dark:text-cyan-300">anonuser</div>
                                                    <div class="mt-0.5 text-sm">seized FBI suspect known as <span class="font-semibold">really</span></div>
                                                    <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">2025-11-28 21:45:43</div>
                                                </div>
                                                <span class="rounded-lg bg-cyan-500/10 px-2 py-1 text-[10px] font-semibold text-cyan-700 dark:text-cyan-300">INTEL</span>
                                            </div>
                                        </li>

                                        <li class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-cyan-700 dark:text-cyan-300">ghostie</div>
                                                    <div class="mt-0.5 text-sm">seized FBI suspect known as <span class="font-semibold">really</span></div>
                                                    <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">2025-11-28 16:28:56</div>
                                                </div>
                                                <span class="rounded-lg bg-green-500/10 px-2 py-1 text-[10px] font-semibold text-green-700 dark:text-green-300">TRACE</span>
                                            </div>
                                        </li>

                                        <li class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-cyan-700 dark:text-cyan-300">anonuser</div>
                                                    <div class="mt-0.5 text-sm">seized FBI suspect known as <span class="font-semibold">really</span></div>
                                                    <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">2025-11-28 10:15:49</div>
                                                </div>
                                                <span class="rounded-lg bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600 dark:bg-white/10 dark:text-slate-300">LOG</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Right column stack -->
                            <div class="xl:col-span-5 grid grid-cols-1 gap-5">
                                <!-- FBI Wanted -->
                                <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                        <div class="flex items-center gap-3">
                      <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                      </span>
                                            <div>
                                                <div class="text-sm font-semibold">FBI Wanted List</div>
                                                <div class="text-xs text-slate-500 dark:text-slate-400">Active warrants</div>
                                            </div>
                                        </div>
                                        <span class="rounded-lg bg-green-500/10 px-2 py-1 text-[10px] font-semibold text-green-700 dark:text-green-300">
                      FBI
                    </span>
                                    </div>
                                    <div class="p-5">
                                        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="text-sm font-semibold">No wanted IPs ATM</div>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Keep your head down. Rotation will update automatically.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Round info -->
                                <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                        <div class="text-sm font-semibold">Round Info</div>
                                        <span class="rounded-lg bg-cyan-500/10 px-2 py-1 text-[10px] font-semibold text-cyan-700 dark:text-cyan-300">ROUND 66</span>
                                    </div>
                                    <div class="p-5 space-y-3">
                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Name</div>
                                            <div class="text-sm font-semibold">ROUND-66</div>
                                        </div>
                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Started</div>
                                            <div class="text-sm font-semibold">2025-11-16</div>
                                        </div>
                                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-[#0B1020]/40">
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Age</div>
                                            <div class="text-sm font-semibold">33 days</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Top users -->
                                <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                        <div class="text-sm font-semibold">Top 7 Users</div>
                                        <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                            View ranking
                                        </button>
                                    </div>

                                    <div class="p-5 overflow-x-auto">
                                        <table class="min-w-full text-sm">
                                            <thead class="text-xs text-slate-500 dark:text-slate-400">
                                            <tr class="border-b border-slate-200/70 dark:border-white/10">
                                                <th class="py-2 pr-3 text-left font-semibold">#</th>
                                                <th class="py-2 pr-3 text-left font-semibold">User</th>
                                                <th class="py-2 text-right font-semibold">Reputation</th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">1</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">r0b33</td>
                                                <td class="py-2 text-right font-semibold">2,809,730</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">2</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">ghostie</td>
                                                <td class="py-2 text-right font-semibold">2,483,688</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">3</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">Noxyro</td>
                                                <td class="py-2 text-right font-semibold">2,375,643</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">4</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">swifty09</td>
                                                <td class="py-2 text-right font-semibold">2,306,724</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">5</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">really</td>
                                                <td class="py-2 text-right font-semibold">1,531,273</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">6</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">BACKDOOR</td>
                                                <td class="py-2 text-right font-semibold">510,266</td>
                                            </tr>
                                            <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                                <td class="py-2 pr-3">7</td>
                                                <td class="py-2 pr-3 font-semibold text-cyan-700 dark:text-cyan-300">NotOnline</td>
                                                <td class="py-2 text-right font-semibold">508,031</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Round Info + Top Users -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-5">



                                </div>
                            </div>
                        </section>

                        <!-- Announcements table -->
                        <section class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                            <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                                <div class="flex items-center gap-3">
                  <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M4 19h16"/><path d="M6 17V5h12v12"/><path d="M8 7h8"/><path d="M8 11h8"/><path d="M8 15h6"/>
                    </svg>
                  </span>
                                    <div>
                                        <div class="text-sm font-semibold">Game News & Announcements</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Patch notes • balancing • clan ops</div>
                                    </div>
                                </div>
                                <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs shadow-sm hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
                                    View all
                                </button>
                            </div>

                            <div class="p-5 overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="text-xs text-slate-500 dark:text-slate-400">
                                    <tr class="border-b border-slate-200/70 dark:border-white/10">
                                        <th class="py-2 pr-4 text-left font-semibold">Date</th>
                                        <th class="py-2 pr-4 text-left font-semibold">Title</th>
                                        <th class="py-2 text-right font-semibold">Author</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                                    <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                        <td class="py-3 pr-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">2025-03-25 10:46</td>
                                        <td class="py-3 pr-4">
                                            <a href="#" class="font-semibold text-cyan-700 hover:underline dark:text-cyan-300">
                                                Round 59/60 Changes — Bulk Research, Puzzle Trail Improvements & Bug Fixes
                                            </a>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Deployment complete • checksum verified
                                            </div>
                                        </td>
                                        <td class="py-3 text-right text-slate-700 dark:text-slate-200">Ney Wars Development Team</td>
                                    </tr>

                                    <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                        <td class="py-3 pr-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">2022-12-11 09:34</td>
                                        <td class="py-3 pr-4">
                                            <a href="#" class="font-semibold text-cyan-700 hover:underline dark:text-cyan-300">
                                                Round 35 — Hardware Price Balance
                                            </a>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Market normalization & anti-inflation rules
                                            </div>
                                        </td>
                                        <td class="py-3 text-right text-slate-700 dark:text-slate-200">Net Wars Development Team</td>
                                    </tr>

                                    <tr class="hover:bg-slate-100/70 dark:hover:bg-white/5">
                                        <td class="py-3 pr-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">2022-11-06 05:33</td>
                                        <td class="py-3 pr-4">
                                            <a href="#" class="font-semibold text-cyan-700 hover:underline dark:text-cyan-300">
                                                Round 34 — Game Balancing, Clan Rework, Anti-Cheat & Alt Prevention
                                            </a>
                                            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                                Protocol hardening • telemetry upgrades
                                            </div>
                                        </td>
                                        <td class="py-3 text-right text-slate-700 dark:text-slate-200">Net Wars Development Team</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-t border-slate-200/70 px-5 py-4 text-xs text-slate-500 dark:border-white/10 dark:text-slate-400">
                                Tip: Press <span class="rounded-lg bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-700 dark:bg-white/10 dark:text-slate-200">/</span> to focus search (hook up later).
                            </div>
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
        <div
            id="hwModal"
            class="fixed inset-0 z-[999] hidden"
            aria-hidden="true"
        >
            <!-- Backdrop -->
            <div
                data-modal-close="hwModal"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            ></div>

            <!-- Panel -->
            <div class="relative flex min-h-full items-center justify-center p-4">
                <div
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="hwModalTitle"
                    class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-white/10 dark:bg-[#070A0F]"
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                        <div class="flex items-center gap-3">
          <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
            <!-- icon -->
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2l9 4-9 4-9-4 9-4z"/><path d="M3 10l9 4 9-4"/><path d="M3 18l9 4 9-4"/>
            </svg>
          </span>
                            <div>
                                <div id="hwModalTitle" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                    Secure Prompt
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    Enter payload parameters
                                </div>
                            </div>
                        </div>

                        <button
                            type="button"
                            data-modal-close="hwModal"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100"
                            aria-label="Close modal"
                        >
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 6L6 18"/><path d="M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-5 py-4">
                        <label class="block text-xs text-slate-500 dark:text-slate-400">Command</label>
                        <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 dark:border-white/10 dark:bg-white/5">
                            <span class="text-green-600 dark:text-green-300">$</span>
                            <input
                                type="text"
                                class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                                placeholder="deploy --target=74.225.236.3 --mode=stealth"
                                autofocus
                            />
                        </div>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-white/10 dark:bg-white/5">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Status</div>
                                <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">
                                    READY <span class="ml-2 inline-block h-2 w-2 rounded-full bg-green-500"></span>
                                </div>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-white/10 dark:bg-white/5">
                                <div class="text-[11px] uppercase tracking-widest text-slate-500 dark:text-slate-400">Auth</div>
                                <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-slate-100">TOKEN_OK</div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col-reverse gap-2 border-t border-slate-200/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-end dark:border-white/10">
                        <button
                            type="button"
                            data-modal-close="hwModal"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-xs font-semibold text-cyan-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:text-cyan-300"
                        >
                            Execute
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
