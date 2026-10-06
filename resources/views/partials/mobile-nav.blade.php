{{-- Phones: bottom tab bar like a travel app. --}}
<nav class="mobile-nav" aria-label="{{ __('ui.nav.main') }}">
    <a href="{{ route('home') }}" @class(['on' => request()->routeIs('home')])><x-icon name="home"/><span>{{ __('ui.nav.home') }}</span></a>
    <a href="{{ route('explore') }}" @class(['on' => request()->routeIs('explore', 'journeys.*', 'directory.*')])><x-icon name="compass"/><span>{{ __('ui.nav.explore') }}</span></a>
    <a href="{{ route('restore.index') }}" @class(['on' => request()->routeIs('restore.*')])><x-icon name="leaf"/><span>{{ __('ui.nav.restore') }}</span></a>
    <a href="{{ route('carbon') }}" @class(['on' => request()->routeIs('carbon')])><x-icon name="cloud"/><span>{{ __('ui.nav.carbon') }}</span></a>
    <a href="{{ auth()->check() ? route('account') : route('login') }}" @class(['on' => request()->routeIs('account', 'login', 'register', 'bookings.*')])><x-icon name="user"/><span>{{ __('ui.nav.trips') }}</span></a>
</nav>
