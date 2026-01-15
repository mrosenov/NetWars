<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight">Provision Identity</h1>
        <p class="text-sm text-text-secondary mt-1">Create your operator profile.</p>
    </div>

    <div class="bg-background-secondary border border-default border-border shadow-lg">
        <div class="p-5 border-b border-border border-default">
            <div class="text-xs uppercase tracking-widest text-text-secondary">Register</div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="p-5 space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs text-text-secondary mb-1">Username</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
                @error('name')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs text-text-secondary mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
                @error('email')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs text-text-secondary mb-1">Password</label>
                <input id="password" name="password" type="password" required class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
                @error('password')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs text-text-secondary mb-1">Confirm password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none focus:border-[var(--accent-primary)]" />
            </div>

            <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold border border-default border-border bg-background-primary hover:bg-background-secondary transition-colors">
                Create account
            </button>

            <div class="pt-2 text-xs text-text-secondary">
                Already registered? <a href="{{ route('login') }}" class="text-accent-primary hover:underline">Login</a>
            </div>
        </form>
    </div>

    <div class="mt-6 text-center text-xs text-text-secondary opacity-80">
        <span class="text-accent-primary">//</span> Your credentials are encrypted in transit.
    </div>
</x-guest-layout>
