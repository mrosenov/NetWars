@section('title', 'Upgrade Server')

<x-app-layout>
    @include('pages.hardware.subnav')

    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/40 dark:bg-red-500/10 dark:text-red-300">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <x-alert type="danger">
            {{ session('error') }}
        </x-alert>
    @endif
    <div class="flex flex-col gap-5 lg:flex-row">
        <div class="flex flex-col gap-5 lg:w-1/2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade Motherboard
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[30%]" />
                        <col class="w-[34%]" />
                        <col class="w-[13%]" />
                        <col class="w-[13%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500
                   dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($motherboards as $motherboard)
                        <tr class="relative group hover:bg-slate-50 dark:hover:bg-white/5 hover:bg-slate-50/70">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $motherboard->name }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $motherboard->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($motherboard->id == $installedMotherboard->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    {{ \App\Support\Format::moneyHuman($motherboard->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($motherboard->id != $installedMotherboard->id)
                                    <button type="button" data-modal-open="buyModal" data-hw-id="{{ $motherboard->id }}" data-buy-type="motherboard" class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg class="h-5 w-5 text-cyan-600 dark:text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9h18v6H3z"></path><path d="M7 9V7"></path><path d="M11 9V7"></path><path d="M15 9V7"></path><path d="M19 9V7"></path><path d="M7 15v2"></path><path d="M11 15v2"></path><path d="M15 15v2"></path><path d="M19 15v2"></path>
                    </svg>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade RAM
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[40%]" />
                        <col class="w-[12%]" />
                        <col class="w-[32%]" />
                        <col class="w-[10%]" />
                        <col class="w-[10%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Clock</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($rams as $ram)
                        <tr class="relative group {{ $ram->is_compatible ? 'hover:bg-slate-50 dark:hover:bg-white/5' : 'opacity-50 cursor-not-allowed' }} hover:bg-slate-50/70 dark:hover:bg-white/5">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $ram->name }}
                            </td>

                            <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200">
                                {{ \App\Support\Format::ramHuman($ram->specifications['capacity_mb']) }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $ram->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                    @foreach(explode(' · ', $ram->reqs_label) as $req)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                    {{ $req }}
                                </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($ram->id == $installedRAM->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    ${{ number_format($ram->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($ram->id != $installedRAM->id)
                                    <button type="button" @disabled(!$ram->is_compatible) class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition {{ $ram->is_compatible ? 'border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10' : 'border-slate-300 text-slate-400 dark:border-white/10 dark:text-slate-500'}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 17.25v-.228a4.5 4.5 0 0 0-.12-1.03l-2.268-9.64a3.375 3.375 0 0 0-3.285-2.602H7.923a3.375 3.375 0 0 0-3.285 2.602l-2.268 9.64a4.5 4.5 0 0 0-.12 1.03v.228m19.5 0a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3m19.5 0a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3m16.5 0h.008v.008h-.008v-.008Zm-3 0h.008v.008h-.008v-.008Z" />
                    </svg>

                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade Storage
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[40%]" />
                        <col class="w-[12%]" />
                        <col class="w-[32%]" />
                        <col class="w-[10%]" />
                        <col class="w-[10%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Space</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($storages as $storage)
                        <tr class="relative group hover:bg-slate-50 hover:bg-slate-50/70 dark:hover:bg-white/5">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $storage->name }}
                            </td>

                            <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200">
                                {{ \App\Support\Format::storageHuman($storage->specifications['capacity_mb']) }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $storage->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                    @if($storage->reqs_label)
                                        @foreach(explode(' · ', $storage->reqs_label) as $req)
                                            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                            {{ $req }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($storage->id == $installedStorage->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    ${{ number_format($storage->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($storage->id != $installedStorage->id)
                                    <button type="button" class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col gap-5 lg:w-1/2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                    </svg>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade CPU
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[36%]" />
                        <col class="w-[12%]" />
                        <col class="w-[32%]" />
                        <col class="w-[10%]" />
                        <col class="w-[10%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Clock</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($cpus as $cpu)
                        <tr class="relative group {{ $cpu->is_compatible ? 'hover:bg-slate-50 dark:hover:bg-white/5' : 'opacity-50 cursor-not-allowed' }} hover:bg-slate-50/70 dark:hover:bg-white/5">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $cpu->name }}
                            </td>

                            <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200">
                                {{ \App\Support\Format::cpuHuman($cpu->specifications['clock_mhz']) }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $cpu->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                    @foreach(explode(' · ', $cpu->reqs_label) as $req)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                        {{ $req }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($cpu->id == $installedCPU->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    ${{ number_format($cpu->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($cpu->id != $installedCPU->id)
                                    <button type="button" @disabled(!$cpu->is_compatible) class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition {{ $cpu->is_compatible ? 'border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10' : 'border-slate-300 text-slate-400 dark:border-white/10 dark:text-slate-500'}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>

                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade Power Supply
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[40%]" />
                        <col class="w-[12%]" />
                        <col class="w-[32%]" />
                        <col class="w-[10%]" />
                        <col class="w-[10%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Watts</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($powerSupplies as $psu)
                        <tr class="relative group hover:bg-slate-50 hover:bg-slate-50/70 dark:hover:bg-white/5">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $psu->name }}
                            </td>

                            <td class="px-4 py-2 text-sm text-slate-700 dark:text-slate-200">
                                {{ \App\Support\Format::wattHuman($psu->specifications['max_power_w']) }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $psu->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                    @if($psu->reqs_label)
                                        @foreach(explode(' · ', $psu->reqs_label) as $req)
                                            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                            {{ $req }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($psu->id == $installedSupply->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    ${{ number_format($psu->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($psu->id != $installedSupply->id)
                                    <button type="button" class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/70 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5">

                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-slate-200/70 bg-white/40 px-4 py-3 dark:border-white/10 dark:bg-white/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-cyan-600 dark:text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.652a3.75 3.75 0 0 1 0-5.304m5.304 0a3.75 3.75 0 0 1 0 5.304m-7.425 2.121a6.75 6.75 0 0 1 0-9.546m9.546 0a6.75 6.75 0 0 1 0 9.546M5.106 18.894c-3.808-3.807-3.808-9.98 0-13.788m13.788 0c3.808 3.807 3.808 9.98 0 13.788M12 12h.008v.008H12V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>

                    <div class="text-sm font-semibold text-slate-900 dark:text-white">
                        Upgrade Network Card
                    </div>
                </div>

                {{-- Table --}}
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[40%]" />
                        <col class="w-[30%]" />
                        <col class="w-[20%]" />
                        <col class="w-[10%]" />
                    </colgroup>

                    <thead>
                    <tr class="border-b border-slate-200/70 text-left text-[11px] uppercase tracking-wide text-slate-500 dark:border-white/10 dark:text-slate-400">
                        <th class="px-4 py-2 font-semibold">Name</th>
                        <th class="px-4 py-2 font-semibold">Specs</th>
                        <th class="px-4 py-2 font-semibold">Price</th>
                        <th class="px-4 py-2 font-semibold text-center"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @foreach ($networks as $network)
                        <tr class="relative group hover:bg-slate-50 hover:bg-slate-50/70 dark:hover:bg-white/5">
                            <td class="px-4 py-2 text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $network->name }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 text-[11px]">
                                    @foreach(explode(' · ', $network->specs_label) as $spec)
                                        <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300">
                                        {{ $spec }}
                                    </span>
                                    @endforeach
                                    @if($network->reqs_label)
                                        @foreach(explode(' · ', $network->reqs_label) as $req)
                                            <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-600 dark:bg-white/10 dark:text-slate-300 border border-purple-500">
                                            {{ $req }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                @if($network->id == $installedNetwork->id)
                                    <span class="text-slate-600 dark:text-slate-300">Installed</span>
                                @else
                                    ${{ number_format($network->price) }}
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                @if($network->id != $installedNetwork->id)
                                    <button type="button" class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-semibold transition border-cyan-500 text-cyan-600 hover:bg-cyan-50 dark:text-cyan-400 dark:hover:bg-cyan-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('modals.buyModal')
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('[data-modal-open="buyModal"]');
            if (!btn) return;

            const id = btn.dataset.hwId;
            if (!id) return;

            const modal = document.getElementById('buyModal');
            if (!modal) return;

            const type = btn.dataset.buyType;
            if (!type) return;

            // set hidden input for form submit
            const hiddenId = modal.querySelector('[data-buy-hardware-id]');
            if (hiddenId) hiddenId.value = id;

            modal.querySelector('[data-buy-type-input]').value = type;

            // set "loading" state
            modal.querySelector('[data-buy-name]').textContent = type;

            try {
                const res = await fetch(`/hardware/${id}/json`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                modal.querySelector('[data-buy-name]').textContent = data.name ?? 'Name missing';
                modal.querySelector('[data-buy-price]').textContent = data.price ?? 'Price missing';
                modal.querySelector('[data-buy-specs]').textContent = data.specs ?? 'Specs missing';
            } catch (err) {
                modal.querySelector('[data-buy-name]').textContent = 'Error';
                console.error(err);
            }
        });
    </script>
</x-app-layout>
