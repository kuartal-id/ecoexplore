<nav class="admin-nav" aria-label="Admin">
    <a href="{{ route('admin.dashboard') }}" @class(['on' => request()->routeIs('admin.dashboard')])>{{ __('ui.admin.dashboard') }}</a>
    <a href="{{ route('admin.bookings.index') }}" @class(['on' => request()->routeIs('admin.bookings.*')])>{{ __('ui.admin.bookings') }}</a>
    <a href="{{ route('admin.journeys.index') }}" @class(['on' => request()->routeIs('admin.journeys.*')])>{{ __('ui.admin.journeys') }}</a>
    <a href="{{ route('admin.listings.index') }}" @class(['on' => request()->routeIs('admin.listings.*')])>{{ __('ui.admin.listings') }}</a>
</nav>
