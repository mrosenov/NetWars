<x-guest-layout>

    @if (session('status'))
        <div class="mb-5 bg-green-500/10 border border-green-500/30 p-3 text-xs text-green-400 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>
            </svg>
            <span>
            {{ session('status') }}
        </span>
        </div>
    @endif

    <div class="card-hack h-full">
        <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-accent-primary">
                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/>
            </svg>
            <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                Password Forgotten
            </h3>
        </div>
        <div class="p-0">
            <div class="px-3 py-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="text-center">
                <label for="email" class="block text-xs text-text-secondary mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-[430px] bg-background-primary border border-default border-border px-5 py-2 mb-3 text-sm outline-none focus:border-[var(--accent-primary)]" />

                <x-input-error :messages="$errors->get('email')" class="mt-2 mb-2" />
            </div>
            <div class="px-4 py-4 bg-background-secondary/30 border-t border-border border-default flex justify-end gap-3">
                <button class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[var(--bg-primary)] bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
