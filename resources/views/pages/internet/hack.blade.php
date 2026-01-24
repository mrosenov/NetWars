@section('title', 'Internet')
<x-app-layout>
    <section class="space-y-5">
        @include('pages.internet.partials.search')
        @include('pages.internet.partials.alertLogged')

        @include('pages.internet.partials.navigation')

        <x-ui.card title="Choose your attack method">
            <x-slot:icon>
                <x-lucide-code-xml class="w-4 h-4" />
            </x-slot:icon>

            <div class="mt-5 mb-5 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <form method="POST" action="{{ route('internet.attack.bruteforce', $ip) }}">
                    @csrf
                    <button type="submit" class="w-56 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-[#070A0F]/60">
                        <div class="flex flex-col items-center text-center gap-3">
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-green-500/10 text-green-700 dark:text-green-300">
                                <x-lucide-terminal class="w-6 h-6" />
                            </div>

                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                    Bruteforce Attack
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
                            <x-lucide-bug class="w-6 h-6" />
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
        </x-ui.card>
    </section>
</x-app-layout>
