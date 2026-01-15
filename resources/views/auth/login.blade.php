<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Access Terminal</h1>
        <p class="text-sm text-text-secondary mt-1">Authenticate to continue.</p>
    </div>

    <div class="bg-background-secondary border border-default border-border shadow-lg">
        <div class="p-5 border-b border-border border-default">
            <div class="text-xs uppercase tracking-widest text-text-secondary">Login</div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="p-5 space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs text-text-secondary mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
                @error('email')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs text-text-secondary mb-1">Password</label>
                <input id="password" name="password" type="password" required
                       class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
                @error('password')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between gap-3">
                <label class="inline-flex items-center gap-2 text-xs text-text-secondary select-none">
                    <input type="checkbox" name="remember" class="accent-[var(--accent-primary)]" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs text-text-secondary hover:text-accent-primary transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold border border-default border-border bg-background-primary hover:bg-background-secondary hover:text-accent-secondary transition-colors">
                Login
            </button>

            <div class="pt-2 text-xs text-text-secondary">
                No account? <a href="{{ route('register') }}" class="text-accent-primary hover:underline">Register</a>
            </div>
        </form>
    </div>

    <div class="mt-6 text-center text-xs text-text-secondary opacity-80">
        <span class="text-accent-primary">//</span> Authorized access only.
    </div>
</x-guest-layout>
