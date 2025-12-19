<x-guest-layout>
    <div class="min-h-20 flex items-center justify-center px-4 bg-slate-50 dark:bg-[#070A0F]">
        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur
                    dark:border-white/10 dark:bg-white/5 dark:shadow-[0_0_0_1px_rgba(34,211,238,.25),0_0_30px_rgba(34,211,238,.10)]">

            <div class="px-6 py-5 border-b border-slate-200/70 dark:border-white/10">
                <div class="text-[11px] uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">
                    Net Wars
                </div>
                <h1 class="mt-1 text-lg font-semibold text-slate-900 dark:text-slate-100">
                    Access Terminal
                </h1>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Authenticate to continue.
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="px-6 py-5 space-y-4">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="rounded-xl border border-green-500/20 bg-green-500/10 px-4 py-3 text-xs text-green-700 dark:text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs text-slate-500 dark:text-slate-400">Email</label>
                    <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2
                                dark:border-white/10 dark:bg-white/5">
                        <span class="text-green-600 dark:text-green-300 text-sm">$</span>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="operator@node.local"
                            class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                        />
                    </div>
                    @error('email')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs text-slate-500 dark:text-slate-400">Password</label>
                    <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2
                                dark:border-white/10 dark:bg-white/5">
                        <span class="text-cyan-600 dark:text-cyan-300 text-sm">#</span>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full bg-transparent border-0 p-0 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0 dark:text-slate-100 dark:placeholder:text-slate-500"
                        />
                    </div>
                    @error('password')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember / Forgot -->
                <div class="flex items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-cyan-600 focus:ring-cyan-500
                                   dark:border-white/20 dark:bg-white/5"
                        />
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs font-semibold text-cyan-700 hover:underline dark:text-cyan-300">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between gap-3 pt-2">
                    <a href="{{ route('register') }}"
                       class="text-xs font-semibold text-slate-700 hover:underline dark:text-slate-200">
                        Create account
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl border border-cyan-500/30 bg-cyan-500/10 px-4 py-2 text-xs font-semibold
                               text-cyan-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md
                               dark:text-cyan-300"
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
