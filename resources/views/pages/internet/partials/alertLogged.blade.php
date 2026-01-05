@if(Auth::user()->isConnected())
    <x-alert type="warning">
        You are currently logged to <a href="{{ route('target.logs') }}" class="no-underline text-cyan-400 hover:text-cyan-200">{{ Auth::user()->network->connected->ip }}</a>. Would you like to <a href="{{ route('target.logout') }}" class="no-underline text-cyan-400 hover:text-cyan-200">log out?</a>
    </x-alert>
@endif
