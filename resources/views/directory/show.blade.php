@extends('layouts.app')

@section('title', $listing->name)
@section('description', $listing->tr('summary'))
@section('body_class', $listing->canBeBooked() ? 'has-book-bar' : '')

@section('content')
<section class="package-hero">
    <div class="package-photo short" style="background-image:linear-gradient(180deg,transparent 30%,rgba(4,18,22,.85)),url('{{ asset($listing->image ?: 'assets/img/hero.svg') }}')">
        <div>
            <span class="pill on-dark">{{ __('ui.directory.types.'.$listing->type) }} · {{ $listing->subtypeLabel() }}</span>
            <h1>{{ $listing->name }}</h1>
            <p><x-icon name="pin" size="16"/> {{ $listing->location }}</p>
        </div>
    </div>
</section>

<section class="section package-layout">
    <div>
        @include('partials.sample-notice', ['text' => __('ui.directory.sample_notice')])
        <div class="eyebrow">{{ __('ui.journey.overview') }}</div>
        <h2>{{ $listing->tr('summary') }}</h2>
        <p class="lead">{{ $listing->tr('description') }}</p>
        @if ($features = $listing->trList('features'))
            <div class="tag-list">
                @foreach ($features as $feature)<span class="pill"><x-icon name="check" size="14"/> {{ $feature }}</span>@endforeach
            </div>
        @endif
        <p><a class="link" href="{{ route('directory.index', $type) }}">← {{ __('ui.directory.back', ['type' => __('ui.directory.types.'.$listing->type)]) }}</a></p>
    </div>

    <aside class="booking-card">
        @if ($listing->canBeBooked())
            <div class="eyebrow">{{ __('ui.journey.book_title') }}</div>
            <div class="price">{{ idr($listing->price_idr) }} <small>/ {{ __('ui.unit.'.$listing->price_unit) }}</small></div>
            <p>{{ str_contains((string) $listing->subtype, 'concierge') ? __('ui.directory.concierge_note') : __('ui.journey.price_note') }}</p>
            <a class="btn btn-primary full" href="{{ route('checkout.create', ['listing', $listing->slug]) }}">{{ __('ui.directory.book_cta') }} <x-icon name="arrow" size="18"/></a>
            <div class="booking-perks">
                <span><x-icon name="shield" size="14"/> {{ __('ui.journey.perk_pay_later') }}</span>
                <span><x-icon name="users" size="14"/> {{ __('ui.journey.perk_local') }}</span>
            </div>
        @else
            <div class="eyebrow">{{ __('ui.directory.info_title') }}</div>
            @if ($listing->price_idr)
                <div class="price">± {{ idr($listing->price_idr) }} <small>/ {{ __('ui.unit.'.$listing->price_unit) }}</small></div>
            @endif
            <p>{{ __('ui.directory.info_text') }}</p>
            <a class="btn btn-ghost full" href="{{ route('explore') }}">{{ __('ui.home.cta_explore') }}</a>
        @endif
    </aside>
</section>

@if ($related->isNotEmpty())
<section class="section">
    <div class="section-head"><div><div class="eyebrow">{{ __('ui.directory.types.'.$listing->type) }}</div><h2>{{ __('ui.directory.more') }}</h2></div></div>
    <div class="cards-grid scroller">
        @foreach ($related as $listing_)
            @include('partials.listing-card', ['listing' => $listing_])
        @endforeach
    </div>
</section>
@endif

@if ($listing->canBeBooked())
<div class="mobile-book-bar">
    <div><b>{{ idr($listing->price_idr) }}</b><small>/ {{ __('ui.unit.'.$listing->price_unit) }}</small></div>
    <a class="btn btn-primary" href="{{ route('checkout.create', ['listing', $listing->slug]) }}">{{ __('ui.directory.book_cta') }}</a>
</div>
@endif
@endsection
