<x-guest-layout>
    <div class="card-hack h-full">
        <div class="bg-background-secondary px-4 py-3 border-b border-border border-default flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-accent-primary">
                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/>
            </svg>
            <h3 class="text-sm font-bold uppercase tracking-wider text-text-primary">
                Password Reset
            </h3>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="py-2 text-center">
                <label for="email" class="block text-xs text-text-secondary mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="w-[430px] bg-background-primary border border-default border-border px-5 py-2 mb-3 text-sm outline-none focus:border-[var(--accent-primary)]" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 mb-2" />
            </div>

            <div class="py-2 text-center">
                <label for="password" class="block text-xs text-text-secondary mb-1">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="w-[430px] bg-background-primary border border-default border-border px-5 py-2 mb-3 text-sm outline-none focus:border-[var(--accent-primary)]" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 mb-2" />
            </div>

            <div class="py-2 text-center">
                <label for="password_confirmation" class="block text-xs text-text-secondary mb-1">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-[430px] bg-background-primary border border-default border-border px-5 py-2 mb-3 text-sm outline-none focus:border-[var(--accent-primary)]" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 mb-2" />
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
