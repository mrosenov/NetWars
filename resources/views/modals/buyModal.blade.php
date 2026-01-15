<div id="buyModal" class="fixed inset-0 z-[999] hidden" aria-hidden="true">
    <!-- Backdrop -->
    <div data-modal-close="buyModal" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div role="dialog" aria-modal="true" aria-labelledby="BuyModalTitle" class="w-full max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-white/10 dark:bg-[#070A0F]">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-200/70 px-5 py-4 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-white/5">
                        <!-- icon -->
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-cyan-600 dark:text-cyan-300" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l9 4-9 4-9-4 9-4z"/>
                            <path d="M3 10l9 4 9-4"/>
                            <path d="M3 18l9 4 9-4"/>
                        </svg>
                    </span>

                    <div>
                        <div id="BuyModalTitle" class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                            Hardware Information
                        </div>
                    </div>
                </div>

                <button type="button" data-modal-close="buyModal" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/5 dark:text-slate-100" aria-label="Close modal">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18"/>
                        <path d="M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-5 py-4 space-y-6">
                <!-- Basic Information -->
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 dark:bg-white/5 dark:text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-slate-600 dark:text-slate-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
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
                                <td class="w-1/3 bg-slate-50 px-4 py-2 text-slate-600 dark:bg-white/5 dark:text-slate-400">Specifications</td>
                                <td class="px-4 py-2 text-slate-900 dark:text-slate-100" data-buy-specs></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form method="POST" action="{{ route('user.hardware.buy') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="server_id" value="{{ $server->id }}">
                <input type="hidden" name="buy_type" value="" data-buy-type-input>
                <input type="hidden" name="hardware_id" value="" data-buy-hardware-id>

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

                    <button type="button" data-modal-close="buyModal" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-slate-200 dark:hover:bg-white/10">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
