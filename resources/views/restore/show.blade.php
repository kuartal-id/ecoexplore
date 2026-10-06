@extends('layouts.app')

@section('title', $project->tr('title'))
@section('description', $project->tr('summary'))
@section('body_class', 'has-book-bar')

@section('content')
<section class="package-hero">
    <div class="package-photo short" style="background-image:linear-gradient(180deg,transparent 30%,rgba(4,18,22,.85)),url('{{ asset($project->image ?: 'assets/img/forest.svg') }}')">
        <div>
            <span class="pill on-dark">{{ __('ui.restore.type.'.$project->type) }} · {{ $project->location }}</span>
            <h1>{{ $project->tr('title') }}</h1>
            <p>{{ $project->tr('summary') }}</p>
        </div>
    </div>
</section>

<section class="section package-layout">
    <div>
        @include('partials.sample-notice', ['text' => __('ui.restore.sample_notice')])
        <div class="eyebrow">{{ __('ui.journey.overview') }}</div>
        <h2>{{ $project->tr('summary') }}</h2>
        <p class="lead">{{ $project->tr('description') }}</p>
        <div class="community-box">
            <div class="eyebrow">{{ __('ui.restore.progress') }}</div>
            <div class="progress big"><i style="width: {{ $project->progressPercent() }}%"></i></div>
            <p>{{ __('ui.restore.funded_of', ['n' => num($project->funded_units), 't' => num($project->target_units), 'unit' => $project->tr('unit_label')]) }}</p>
            @if ($project->partner)<p><b>{{ __('ui.journey.partner') }}:</b> {{ $project->partner }}</p>@endif
            <p class="muted small">{{ __('ui.restore.not_offset') }}</p>
        </div>
    </div>

    <aside class="booking-card">
        <div class="eyebrow">{{ __('ui.restore.fund_title') }}</div>
        <div class="price">{{ idr($project->unit_price_idr) }} <small>/ {{ $project->tr('unit_label') }}</small></div>
        <form method="get" action="{{ route('checkout.create', ['restore', $project->slug]) }}" class="stack">
            <label class="field">{{ __('ui.restore.units', ['unit' => $project->tr('unit_label')]) }}
                <input type="number" name="quantity" min="1" max="500" value="1" inputmode="numeric">
            </label>
            <button class="btn btn-primary full" type="submit">{{ __('ui.restore.fund_cta') }} <x-icon name="arrow" size="18"/></button>
        </form>
        <div class="booking-perks">
            <span><x-icon name="shield" size="14"/> {{ __('ui.journey.perk_pay_later') }}</span>
            <span><x-icon name="leaf" size="14"/> {{ __('ui.restore.perk_updates') }}</span>
        </div>
    </aside>
</section>

<div class="mobile-book-bar">
    <div><b>{{ idr($project->unit_price_idr) }}</b><small>/ {{ $project->tr('unit_label') }}</small></div>
    <a class="btn btn-primary" href="{{ route('checkout.create', ['restore', $project->slug]) }}">{{ __('ui.restore.fund_cta') }}</a>
</div>
@endsection
