@section('title', 'My Hardware')

<x-app-layout>
    {{-- Top subnav (tabs) --}}
    @include('pages.hardware.subnav')

    {{-- Statistics --}}
    @include('pages.hardware.stats')

    @if (session('success'))
        <x-alert type="success" class="mb-2">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert type="danger" class="mb-2">
            {{ session('error') }}
        </x-alert>
    @endif

    {{-- Main container --}}
    <x-ui.card title="Servers">
        <x-slot:icon>
            <x-lucide-server class="w-5 h-5" />
        </x-slot:icon>

            <table class="w-full border-collapse">
                <tbody>
                    @foreach($servers ?? [] as $server)
                        @php
                            $cpu = \App\Support\Format::cpu($server->resource_totals['clock_mhz']);
                            $storage = \App\Support\Format::storage($server->resource_totals['storage_mb']);
                            $ram = \App\Support\Format::ram($server->resource_totals['ram_mb']);
                        @endphp
                        <tr class="hover:bg-slate-300/50 dark:hover:bg-background-secondary transition-colors border border-border">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="grid h-10 w-10 place-items-center rounded-lg border border-border bg-background-primary text-text-primary">
                                        <x-lucide-server class="w-5 h-5" />
                                    </div>

                                    <div>
                                        <div class="text-sm font-semibold text-text-primary">{{ $server->name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-cpu class="w-4 h-4 text-blue-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $cpu['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $cpu['unit'] }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-hard-drive class="w-4 h-4 text-orange-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $storage['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $storage['unit'] }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border bg-background-primary text-text-secondary">
                                        <x-lucide-memory-stick class="w-4 h-4 text-green-400" />
                                        <span class="text-sm font-semibold text-text-primary">{{ $ram['value'] }}</span>
                                        <span class="text-xs text-text-secondary">{{ $ram['unit'] }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('user.hardware.server', $server->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-border hover:border-accent-secondary hover:text-accent-secondary bg-background-primary px-4 py-2 text-sm font-semibold text-text-primary hover:bg-background-secondary transition">
                                    <x-lucide-arrow-up class="w-4 h-4" />
                                    Upgrade
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </x-ui.card>

    @include('modals.buyServerModal')
    <script>
        function openModal(modal) {
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            document.documentElement.classList.add('overflow-hidden');
        }

        function closeModal(modal) {
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            document.documentElement.classList.remove('overflow-hidden');
        }

        document.addEventListener('click', async (e) => {
            // OPEN
            const openBtn = e.target.closest('[data-modal-open="buyServerModal"]');
            if (openBtn) {
                const modal = document.getElementById('buyServerModal');
                if (!modal) return;

                // open immediately (so user sees it even while loading)
                openModal(modal);

                // loading state
                const nameEl = modal.querySelector('[data-buy-name]');
                const priceEl = modal.querySelector('[data-buy-price]');
                const reasonEl = modal.querySelector('[data-buy-reason]');

                if (nameEl) nameEl.textContent = 'Loading...';
                if (priceEl) priceEl.textContent = '';
                if (reasonEl) reasonEl.textContent = '';

                try {
                    const res = await fetch(`/hardware/servers/server_json`, {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    const data = await res.json();

                    if (nameEl) nameEl.textContent  = data.name ?? 'Name missing';
                    if (priceEl) priceEl.textContent = data.price != null ? `${data.price}` : '';
                    if (reasonEl) reasonEl.textContent = data.reason != null ? `${data.reason}` : '';
                } catch (err) {
                    if (nameEl) nameEl.textContent = 'Error loading server';
                    console.error(err);
                }

                return; // important so it doesn't fall through to close logic
            }

            // CLOSE (backdrop, X button, Cancel)
            const closeBtn = e.target.closest('[data-modal-close="buyServerModal"]');
            if (closeBtn) {
                const modal = document.getElementById('buyServerModal');
                if (!modal) return;
                closeModal(modal);
            }
        });

        // ESC closes
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const modal = document.getElementById('buyServerModal');
            if (!modal || modal.classList.contains('hidden')) return;
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            document.documentElement.classList.remove('overflow-hidden');
        });
    </script>
</x-app-layout>
