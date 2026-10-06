@extends('layouts.app')

@section('title', __('ui.account.title'))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="user" size="14"/> {{ __('ui.account.eyebrow') }}</span>
    <h1>{{ __('ui.account.hello', ['name' => $user->name]) }}</h1>
    <p>{{ $user->email }}</p>
    <div class="hero-actions">
        @if ($user->isAdmin())<a class="btn btn-ghost small" href="{{ route('admin.dashboard') }}">{{ __('ui.admin.title') }}</a>@endif
        @unless ($user->kuartal_id)
            <a class="btn btn-ghost small" href="{{ route('login.kuartal-id', ['redirect' => '/account']) }}">{{ __('ui.account.connect_kuartal') }}</a>
        @else
            <span class="pill"><x-icon name="shield" size="14"/> {{ __('ui.account.kuartal_linked') }}</span>
        @endunless
        <form method="post" action="{{ route('logout') }}">@csrf<button class="btn btn-ghost small" type="submit"><x-icon name="logout" size="16"/> {{ __('ui.nav.logout') }}</button></form>
    </div>
</section>

<section class="section tight">
    <h2 class="block-title">{{ __('ui.account.bookings') }}</h2>
    @if ($bookings->isEmpty())
        <div class="empty">{{ __('ui.account.no_bookings') }} <a class="link" href="{{ route('explore') }}">{{ __('ui.home.cta_explore') }}</a></div>
    @else
        <div class="trip-list">
            @foreach ($bookings as $b)
                <a class="trip-row" href="{{ route('bookings.show', $b) }}">
                    <div><b>{{ $b->item_name }}</b><small>{{ $b->reference }} · {{ $b->start_date?->translatedFormat('j M Y') ?? __('ui.purpose.'.$b->purpose) }}</small></div>
                    <div class="trip-meta">
                        <span class="badge badge-{{ $b->payment_status }}">{{ __('ui.payment_status.'.$b->payment_status) }}</span>
                        <b>{{ idr($b->amount_idr) }}</b>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>
@endsection
