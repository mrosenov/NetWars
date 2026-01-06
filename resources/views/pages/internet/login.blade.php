@section('title', 'Internet')
<x-app-layout>
    <!-- INTERNET PANEL (Index / Login / Hack in one) -->
    <section class="space-y-5">

        <!-- IP BAR -->
        @include('pages.internet.partials.search')
        @include('pages.internet.partials.alertLogged')
        <!-- IP BAR -->
        @if (session('error'))
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        @endif
        @if (session('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif
        <!-- TABS + CONTENT -->
        <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">
            <!-- Subnavigation -->
            @include('pages.internet.partials.navigation')
            <!-- Subnavigation -->

            <div class="p-5">

                <div class="mx-auto max-w-xl rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#070A0F]/60">
                    <div class="px-6 py-5 border-b border-slate-200/70 dark:border-white/10 text-center">
                        <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Enter username and password to continue.
                        </div>

                        @if(session('login_ok'))
                            <div class="mt-3 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
                                {{ session('login_ok') }}
                            </div>
                        @endif

                        @if(session('login_error'))
                            <div class="mt-3 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm text-red-700 dark:text-red-300">
                                {{ session('login_error') }}
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('internet.login', ['ip' => $ip]) }}" class="px-6 py-6 space-y-4">
                        @csrf

                        <div class="flex items-center rounded-xl bg-slate-100 px-3 py-2 focus-within:ring-2 focus-within:ring-cyan-500/40 dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                            <div class="mr-2 grid h-9 w-9 place-items-center rounded-xl bg-white/60 dark:bg-white/5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input name="username"
                                   @if($isHacked) value="{{ $victim->user }}" @endif
                                   placeholder="Username"
                                   class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                            />
                        </div>

                        <div class="flex items-center rounded-xl bg-slate-100 px-3 py-2 focus-within:ring-2 focus-within:ring-cyan-500/40 dark:bg-white/5 dark:focus-within:ring-cyan-400/40">
                            <div class="mr-2 grid h-9 w-9 place-items-center rounded-xl bg-white/60 dark:bg-white/5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>

                            <input name="password" type="password"
                                   @if($isHacked) value="{{ $victim->password }}" @endif
                                   placeholder="Password"
                                   class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                            />
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-5 py-2.5 text-xs font-semibold text-cyan-700 shadow-sm dark:text-cyan-300">
                                Login
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
