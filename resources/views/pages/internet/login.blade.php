@section('title', 'Internet')
<x-app-layout>
    <section class="space-y-5">
        @include('pages.internet.partials.search')
        @include('pages.internet.partials.alertLogged')

        @if (session('logout_ok'))
            <x-alert type="warning" class="mb-2">
                {{ session('logout_ok') }}
            </x-alert>
        @endif
        @if (session('status'))
            <x-alert type="warning" class="mb-2">
                {{ session('status') }}
            </x-alert>
        @endif
        @if (session('error'))
            <x-alert type="danger" class="mb-2">
                {{ session('error') }}
            </x-alert>
        @endif
        @if (session('success'))
            <x-alert type="success" class="mb-2">
                {{ session('success') }}
            </x-alert>
        @endif

        @include('pages.internet.partials.navigation')
        <x-ui.card title="Access Terminal">
            <x-slot:icon>
                <x-lucide-user class="w-4 h-4" />
            </x-slot:icon>

            <div class="mx-auto mt-5 mb-5 max-w-[500px] bg-background-secondary border border-default border-border shadow-lg">
                <div class="p-5 border-b border-border border-default">
                    <div class="text-center text-xs uppercase tracking-widest text-text-secondary">Enter username and password to continue.</div>
                </div>

                @if(session('login_error'))
                    <div class="mt-3 mx-auto w-5/6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2 text-sm text-red-700 dark:text-red-300">
                        {{ session('login_error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('internet.login', ['ip' => $ip]) }}" class="p-5 space-y-4">
                    @csrf

                    <div>
                        <label for="username" class="block text-xs text-text-secondary mb-1">Username</label>
                        <input id="username" name="username" @if($isHacked) value="{{ $victim->user }}" @endif placeholder="Username" class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm text-accent-primary outline-none focus:border-[var(--accent-primary)]">
                    </div>

                    <div>
                        <label for="password" class="block text-xs text-text-secondary mb-1">Password</label>
                        <input id="password" name="password" type="password" @if($isHacked) value="{{ $victim->password }}" @endif placeholder="Password" class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm text-accent-primary outline-none focus:border-[var(--accent-primary)]">
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold border border-default border-border bg-background-primary hover:bg-background-secondary hover:text-accent-secondary transition-colors">
                        Login
                    </button>
                </form>
            </div>
        </x-ui.card>
    </section>
</x-app-layout>
