@section('title', 'Internet')
<x-app-layout>
    <!-- INTERNET PANEL (Index / Login / Hack in one) -->
    <section class="space-y-5">

        <!-- IP BAR -->
        @include('pages.internet.partials.search')
        @include('pages.internet.partials.alertLogged')
        <!-- IP BAR -->

        <!-- TABS + CONTENT -->
        <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
            <!-- Subnavigation -->
            @include('pages.internet.partials.navigation')
            <!-- Subnavigation -->

            <div class="p-5">
                <div class="text-center text-sm font-semibold text-slate-900 dark:text-slate-100">
                    Choose your attack method:
                </div>

                <div class="mt-6 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <form method="POST" action="{{ route('internet.attack.bruteforce', $ip) }}">
                        @csrf
                        <button type="submit" class="w-56 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-[#070A0F]/60">
                            <div class="flex flex-col items-center text-center gap-3">
                                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-green-500/10 text-green-700 dark:text-green-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                    </svg>
                                </div>

                                <div>
                                    <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                        Bruteforce attack
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        v{{ $cracker->version }}
                                    </div>
                                </div>
                            </div>
                        </button>
                    </form>

                    <div class="w-56 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-[#070A0F]/60">

                        <div class="flex flex-col items-center text-center gap-3">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-cyan-500/10 text-cyan-700 dark:text-cyan-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
                                </svg>
                            </div>

                            <div>
                                <div class="text-sm font-semibold text-red-600 dark:text-red-400">
                                    Exploit attack
                                </div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                    No Port Scan.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</x-app-layout>
