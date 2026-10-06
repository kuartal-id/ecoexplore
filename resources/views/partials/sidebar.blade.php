{{-- Tablet landscape (700–1180px): persistent app-style rail. --}}
<aside class="tablet-sidebar" aria-label="{{ __('ui.nav.main') }}">
    @include('partials.logo')
    <a href="{{ route('home') }}"><x-icon name="home"/><span>{{ __('ui.nav.home') }}</span></a>
    <a href="{{ route('explore') }}"><x-icon name="compass"/><span>{{ __('ui.nav.explore') }}</span></a>
    <a href="{{ route('directory.index', 'accommodations') }}"><x-icon name="bed"/><span>{{ __('ui.nav.stays') }}</span></a>
    <a href="{{ route('directory.index', 'transport') }}"><x-icon name="car"/><span>{{ __('ui.nav.transport') }}</span></a>
    <a href="{{ route('restore.index') }}"><x-icon name="leaf"/><span>{{ __('ui.nav.restore') }}</span></a>
    <a href="{{ route('carbon') }}"><x-icon name="cloud"/><span>{{ __('ui.nav.carbon') }}</span></a>
    <a href="{{ auth()->check() ? route('account') : route('login') }}"><x-icon name="user"/><span>{{ auth()->check() ? __('ui.nav.trips') : __('ui.nav.login') }}</span></a>
    <div class="sidebar-tools">
        <button type="button" data-theme-toggle aria-label="{{ __('ui.nav.theme') }}"><x-icon name="moon" class="theme-moon"/><x-icon name="sun" class="theme-sun"/></button>
        <a href="{{ route('locale', app()->getLocale() === 'id' ? 'en' : 'id') }}" class="sidebar-lang">{{ app()->getLocale() === 'id' ? 'EN' : 'ID' }}</a>
    </div>
</aside>
