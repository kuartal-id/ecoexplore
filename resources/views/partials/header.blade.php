<header class="site-header">
    <div class="header-inner">
        @include('partials.logo')
        <nav class="main-nav" aria-label="{{ __('ui.nav.main') }}">
            <a href="{{ route('explore') }}" @class(['active' => request()->routeIs('explore', 'journeys.*')])>{{ __('ui.nav.explore') }}</a>
            <a href="{{ route('directory.index', 'accommodations') }}" @class(['active' => request()->is('directory/accommodations*')])>{{ __('ui.nav.stays') }}</a>
            <a href="{{ route('directory.index', 'transport') }}" @class(['active' => request()->is('directory/transport*')])>{{ __('ui.nav.transport') }}</a>
            <a href="{{ route('restore.index') }}" @class(['active' => request()->routeIs('restore.*')])>{{ __('ui.nav.restore') }}</a>
            <a href="{{ route('carbon') }}" @class(['active' => request()->routeIs('carbon')])>{{ __('ui.nav.carbon') }}</a>
        </nav>
        <div class="header-actions">
            @include('partials.locale-switch')
            <button type="button" class="icon-btn" data-theme-toggle aria-label="{{ __('ui.nav.theme') }}" title="{{ __('ui.nav.theme') }}">
                <x-icon name="moon" size="18" class="theme-moon"/><x-icon name="sun" size="18" class="theme-sun"/>
            </button>
            @auth
                <a href="{{ route('account') }}" class="icon-btn icon-link" aria-label="{{ __('ui.nav.account') }}" title="{{ __('ui.nav.account') }}"><x-icon name="user" size="18"/></a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost small">{{ __('ui.nav.login') }}</a>
            @endauth
            <a href="{{ route('explore') }}" class="btn btn-primary small">{{ __('ui.nav.book') }}</a>
        </div>
    </div>
</header>
