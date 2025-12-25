@section('title', 'Dashboard')
<x-app-layout>
    <!-- Top grid: Hardware + General info -->
    <section class="grid grid-cols-1 xl:grid-cols-2 gap-5">
        <!-- Hardware Information -->
        @include('partials.hardwareInfo')
        <!-- Hardware Information -->

        <!-- General Info -->
        {{--                            @include('partials.generalInfo')--}}
        <!-- General Info -->
    </section>

    <!-- Middle grid: News + Wanted + Round + Leaderboard -->
    <section class="grid grid-cols-1 xl:grid-cols-12 gap-5">
        <!-- News feed -->
        {{-- @include('partials.gameNews')--}}
        <!-- News feed -->


        <!-- Right column stack -->
        <div class="xl:col-span-5 grid grid-cols-1 gap-5">
            <!-- FBI Wanted -->
            {{--                                @include('partials.fbiWanted')--}}
            <!-- FBI Wanted -->

            <!-- Round info -->
            {{--                                @include('partials.roundInfo')--}}
            <!-- Round info -->

            <!-- Top users -->
            {{--                                @include('partials.ranking')--}}
            <!-- Top users -->
        </div>
    </section>

    <!-- Announcements table -->
    <section class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/5 dark:shadow-glow">
        {{-- @include('partials.announcements')--}}
    </section>
    <!-- Announcements table -->
</x-app-layout>
