<div id="buyServerModal" class="fixed inset-0 z-[999] hidden" aria-hidden="true">
    <!-- Backdrop -->
    <div data-modal-close="buyServerModal" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div role="dialog" aria-modal="true" aria-labelledby="BuyServerModalTitle" class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-white/10 dark:bg-[#070A0F]">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <!-- icon -->
                        <x-lucide-server-cog class="w-5 h-5 text-cyan-600 dark:text-cyan-300" />
                    </span>

                    <div>
                        <div id="BuyServerModalTitle" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Server Information
                        </div>
                    </div>
                </div>

                <button type="button" data-modal-close="buyServerModal" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100" aria-label="Close modal">
                    <x-lucide-x class="w-4 h-4" />
                </button>
            </div>

            <!-- Body -->
            <div class="px-5 py-4 space-y-6">
                <!-- Basic Information -->
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 dark:bg-white/5 dark:text-slate-200">
                        <x-lucide-info class="w-4 h-4 text-slate-600 dark:text-slate-400" />
                        Basic Information
                    </div>

                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                            <tr>
                                <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Name</td>
                                <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-buy-name></td>
                            </tr>
                            <tr>
                                <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Price</td>
                                <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-buy-price>$</td>
                            </tr>
                            <tr>
                                <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Reason</td>
                                <td class="px-4 py-2 text-red-900 dark:text-red-400" data-buy-reason></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form method="POST" action="{{ route('user.server.buy') }}" class="space-y-6">
                @csrf
                {{-- Bank account select --}}
                <div class="flex justify-center">
                    <select class="w-full max-w-lg appearance-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-white/10 dark:bg-white/5 dark:text-white dark:focus:border-cyan-400 dark:focus:ring-cyan-400/20" name="bankAccount" required >
                        @foreach ($bankAccounts as $bankAccount)
                            <option value="{{ $bankAccount->iban }}">{{ $bankAccount->iban }}({{App\Support\Format::moneyHuman($bankAccount->balance)}})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200/70 dark:border-white/10">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-cyan-600 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/40 dark:bg-cyan-500 dark:hover:bg-cyan-400">
                        Buy
                    </button>

                    <button type="button" data-modal-close="buyServerModal" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-200 dark:hover:bg-white/10">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
