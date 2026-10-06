@extends('layouts.app')

@section('title', $journey->tr('title'))
@section('description', $journey->tr('summary'))
@section('body_class', 'has-book-bar')

@section('content')
<section class="package-hero">
    <div class="package-photo" style="background-image:linear-gradient(180deg,transparent 30%,rgba(4,18,22,.85)),url('{{ asset($journey->image ?: 'assets/img/hero.svg') }}')">
        <div>
            <span class="pill on-dark">{{ __('ui.category.'.$journey->category) }} · {{ $journey->durationLabel() }}</span>
            <h1>{{ $journey->tr('title') }}</h1>
            <p>{{ $journey->tr('tagline') }}</p>
        </div>
    </div>
</section>

<section class="section package-layout">
    <div>
        @include('partials.sample-notice')
        <div class="eyebrow">{{ __('ui.journey.overview') }}</div>
        <h2>{{ $journey->tr('summary') }}</h2>
        <p class="lead">{{ $journey->tr('description') }}</p>

        <div class="tag-list">
            <span class="pill"><x-icon name="clock" size="14"/> {{ $journey->durationLabel() }}</span>
            <span class="pill"><x-icon name="mountain" size="14"/> {{ __('ui.difficulty.'.$journey->difficulty) }}</span>
            <span class="pill"><x-icon name="users" size="14"/> {{ __('ui.journey.group', ['min' => $journey->min_pax, 'max' => $journey->max_pax]) }}</span>
            <span class="pill"><x-icon name="pin" size="14"/> {{ $journey->region }}</span>
        </div>

        <h3 class="block-title">{{ __('ui.journey.itinerary') }}</h3>
        <div class="timeline">
            @foreach ($journey->trList('itinerary') as $step)
                <div><b>{{ $step['title'] ?? '' }}</b><p>{{ $step['body'] ?? '' }}</p></div>
            @endforeach
        </div>

        <div class="two-col">
            <div>
                <h3 class="block-title">{{ __('ui.journey.includes') }}</h3>
                <ul class="check-list">@foreach ($journey->trList('includes') as $line)<li><x-icon name="check" size="16"/> {{ $line }}</li>@endforeach</ul>
            </div>
            <div>
                <h3 class="block-title">{{ __('ui.journey.excludes') }}</h3>
                <ul class="check-list muted-list">@foreach ($journey->trList('excludes') as $line)<li>– {{ $line }}</li>@endforeach</ul>
            </div>
        </div>

        <div class="community-box">
            <div class="eyebrow">{{ __('ui.journey.impact') }}</div>
            <p>{{ $journey->tr('impact') }}</p>
            @if ($journey->community_partner)<p><b>{{ __('ui.journey.partner') }}:</b> {{ $journey->community_partner }}</p>@endif
            @if ($journey->carbon_kg_pp)
                <p><x-icon name="cloud" size="16"/> {{ __('ui.journey.carbon', ['kg' => $journey->carbon_kg_pp]) }} <a class="link" href="{{ route('carbon') }}">{{ __('ui.journey.carbon_link') }}</a></p>
            @endif
        </div>
    </div>

    <aside class="booking-card" id="book">
        <div class="eyebrow">{{ __('ui.journey.book_title') }}</div>
        <div class="price">{{ idr($journey->price_idr) }} <small>/ {{ __('ui.unit.person') }}</small></div>
        <p>{{ __('ui.journey.price_note') }}</p>
        <form method="get" action="{{ route('checkout.create', ['journey', $journey->slug]) }}" class="stack">
            <label class="field">{{ __('ui.checkout.travellers') }}
                <select name="quantity">
                    @for ($i = $journey->min_pax; $i <= $journey->max_pax; $i++)
                        <option value="{{ $i }}" @selected($i === max($journey->min_pax, 2))>{{ $i }}</option>
                    @endfor
                </select>
            </label>
            <button class="btn btn-primary full" type="submit">{{ __('ui.journey.book_cta') }} <x-icon name="arrow" size="18"/></button>
        </form>
        <div class="booking-perks">
            <span><x-icon name="shield" size="14"/> {{ __('ui.journey.perk_pay_later') }}</span>
            <span><x-icon name="users" size="14"/> {{ __('ui.journey.perk_local') }}</span>
            <span><x-icon name="leaf" size="14"/> {{ __('ui.journey.perk_impact') }}</span>
        </div>
    </aside>
</section>

@if ($related->isNotEmpty())
<section class="section">
    <div class="section-head"><div><div class="eyebrow">{{ __('ui.journey.related') }}</div><h2>{{ __('ui.journey.related_title') }}</h2></div></div>
    <div class="cards-grid scroller">
        @foreach ($related as $journey_)
            @include('partials.journey-card', ['journey' => $journey_])
        @endforeach
    </div>
</section>
@endif

<div class="mobile-book-bar">
    <div><small>{{ __('ui.common.from') }}</small><b>{{ idr($journey->price_idr) }}</b><small>/ {{ __('ui.unit.person') }}</small></div>
    <a class="btn btn-primary" href="{{ route('checkout.create', ['journey', $journey->slug]) }}">{{ __('ui.journey.book_cta') }}</a>
</div>
@endsection
