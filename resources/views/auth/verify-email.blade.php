<x-guest-layout>
    @if (session('status') == 'verification-link-sent')
    <div class="mb-5 bg-green-500/10 border border-green-500/30 p-3 text-xs text-green-400 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>
        </svg>
        <span>
            A new verification link has been sent to the email address you provided during registration.
        </span>
    </div>
    @endif

    <div class="card-hack h-full">
        <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-accent-primary">
                <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="m16 19 2 2 4-4"/>
            </svg>
            <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                Email Verification Required
            </h3>
        </div>
        <div class="p-0">
            <div class="px-3 py-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>
        </div>

        <div class="px-4 py-4 bg-background-secondary/30 border-t border-border border-default flex justify-end gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[var(--bg-primary)] bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-500 border border-red-500/50 hover:bg-red-500/10 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                    Log Out
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>
