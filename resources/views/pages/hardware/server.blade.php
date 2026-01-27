@section('title', 'Upgrade Server')

<x-app-layout>
    @include('pages.hardware.subnav')

    @if ($errors->any())
        <x-alert type="danger" class="mb-2">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

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

    <div class="rounded-xl border border-border border-default bg-background-secondary shadow-sm backdrop-blur">

        <nav class="flex items-center gap-1 px-3 pt-2 border-b border-border border-default bg-background-secondary/60" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <x-ui.tab id="tabs-mobo" target="tabs-mobo-panel" active>
                <x-lucide-circuit-board class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">Motherboard</span>
            </x-ui.tab>

            <x-ui.tab id="tabs-cpu" target="tabs-cpu-panel" active>
                <x-lucide-cpu class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">CPU</span>
            </x-ui.tab>

            <x-ui.tab id="tabs-ram" target="tabs-ram-panel" active>
                <x-lucide-memory-stick class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">RAM</span>
            </x-ui.tab>

            <x-ui.tab id="tabs-storage" target="tabs-storage-panel" active>
                <x-lucide-hard-drive class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">Storage</span>
            </x-ui.tab>

            <x-ui.tab id="tabs-psu" target="tabs-psu-panel" active>
                <x-lucide-zap class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">Power Supply</span>
            </x-ui.tab>

            <x-ui.tab id="tabs-networkCard" target="tabs-networkCard-panel" active>
                <x-lucide-network class="w-4 h-4 text-text-secondary transition group-[.active]:text-accent-primary" />
                <span class="transition group-[.active]:text-text-primary">Network Card</span>
            </x-ui.tab>

            <span class="inline-flex items-center rounded-md bg-blue-400/10 px-2 py-1 text-xs font-medium text-blue-400 inset-ring inset-ring-blue-400/30 ml-auto">
                {{ $server->name }}
            </span>
        </nav>

        <div class="p-4 bg-background-secondary/40">
            <div id="tabs-mobo-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                    @include('pages.hardware.tabs.motherboards')
            </div>

            <div id="tabs-cpu-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                @include('pages.hardware.tabs.cpu')
            </div>

            <div id="tabs-ram-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                @include('pages.hardware.tabs.ram')
            </div>

            <div id="tabs-storage-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                @include('pages.hardware.tabs.storage')
            </div>

            <div id="tabs-psu-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                @include('pages.hardware.tabs.psu')
            </div>

            <div id="tabs-networkCard-panel" role="tabpanel" aria-labelledby="tabs-basic-item-1">
                @include('pages.hardware.tabs.network-card')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[role="tablist"]').forEach(tablist => {
                const tabs = Array.from(tablist.querySelectorAll('[role="tab"][data-tab]'));

                function activateTab(tab) {
                    const targetSel = tab.getAttribute('data-tab');
                    const panel = targetSel ? document.querySelector(targetSel) : null;
                    if (!panel) return;

                    // Tabs
                    tabs.forEach(t => {
                        const isActive = t === tab;
                        t.classList.toggle('active', isActive);
                        t.setAttribute('aria-selected', isActive ? 'true' : 'false');

                        // Underline + active text
                        t.classList.toggle('border-accent-primary', isActive);
                        t.classList.toggle('text-text-primary', isActive);

                        // Icon color
                        const icon = t.querySelector('svg');
                        if (icon) {
                            icon.classList.toggle('text-accent-primary', isActive);
                            icon.classList.toggle('text-text-secondary', !isActive);
                        }
                    });

                    // Panels (only those controlled by this tablist)
                    const panels = Array.from(document.querySelectorAll('[role="tabpanel"]'))
                        .filter(p => tabs.some(t => t.getAttribute('aria-controls') === p.id));

                    panels.forEach(p => p.classList.toggle('hidden', p !== panel));
                }

                tabs.forEach(tab => tab.addEventListener('click', () => activateTab(tab)));
                activateTab(tabs.find(t => t.classList.contains('active')) || tabs[0]);
            });
        });
    </script>

    @include('modals.buyModal')
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
            const openBtn = e.target.closest('[data-modal-open="buyModal"]');
            if (openBtn) {
                const modal = document.getElementById('buyModal');
                if (!modal) return;

                const id = openBtn.dataset.hwId;
                const type = openBtn.dataset.buyType;

                if (!id || !type) return;

                // open immediately (so user sees it even while loading)
                openModal(modal);

                // set hidden inputs
                const hiddenId = modal.querySelector('[data-buy-hardware-id]');
                if (hiddenId) hiddenId.value = id;

                const typeInput = modal.querySelector('[data-buy-type-input]');
                if (typeInput) typeInput.value = type;

                // loading state
                const nameEl  = modal.querySelector('[data-buy-name]');
                const priceEl = modal.querySelector('[data-buy-price]');
                const specsEl = modal.querySelector('[data-buy-specs]');

                if (nameEl)  nameEl.textContent = 'Loading...';
                if (priceEl) priceEl.textContent = '';
                if (specsEl) specsEl.textContent = '';

                try {
                    const res = await fetch(`/hardware/${id}/json`, {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    const data = await res.json();

                    if (nameEl)  nameEl.textContent  = data.name ?? 'Name missing';
                    if (priceEl) priceEl.textContent = data.price != null ? `$${data.price}` : 'Price missing';
                    if (specsEl) specsEl.textContent = data.specs ?? 'Specs missing';
                } catch (err) {
                    if (nameEl) nameEl.textContent = 'Error loading hardware';
                    console.error(err);
                }

                return; // important so it doesn't fall through to close logic
            }

            // CLOSE (backdrop, X button, Cancel)
            const closeBtn = e.target.closest('[data-modal-close="buyModal"]');
            if (closeBtn) {
                const modal = document.getElementById('buyModal');
                if (!modal) return;
                closeModal(modal);
            }
        });

        // ESC closes
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Escape') return;
            const modal = document.getElementById('buyModal');
            if (!modal || modal.classList.contains('hidden')) return;
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            document.documentElement.classList.remove('overflow-hidden');
        });
    </script>

</x-app-layout>
