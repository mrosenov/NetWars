<form method="GET" action="{{ route('internet.index') }}">
    <div class="mb-6 bg-background-secondary border border-default border-border p-4 flex items-center justify-between">
        <div class="flex w-full items-center gap-3">
            <div class="shrink-0 text-sm text-slate-700 dark:text-slate-200">
                IP Address:
            </div>
            <input type="text" name="ip" placeholder="1.2.3.4" value="{{ request('ip') }}" class="w-full bg-background-primary border border-default border-border px-3 py-2 text-sm outline-none text-accent-primary">

            <button type="submit" class="px-3 py-2 rounded-none border border-default border-border transition-colors group relative overflow-hidden text-sm">
                <x-lucide-search class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:-rotate-12 group-hover:text-accent-secondary" />
            </button>

            <a href="{{ route('internet.show', '1.2.3.4') }}" class="px-3 py-2 text-accent-primary group-hover:text-accent-secondary rounded-none border border-default border-border transition-colors group relative overflow-hidden text-sm">
                <x-lucide-home class="w-5 h-5 text-accent-primary transition-transform duration-300 group-hover:text-accent-secondary"/>
            </a>
        </div>
    </div>
</form>
