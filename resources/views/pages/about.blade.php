@extends('layouts.app')

@section('title', __('ui.about.title'))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="leaf" size="14"/> Ecoexplore</span>
    <h1>{{ __('ui.about.h1') }}</h1>
    <p>{{ __('ui.about.lead') }}</p>
</section>
<section class="section tight prose">
    <h2>{{ __('ui.about.what_title') }}</h2>
    <p>{{ __('ui.about.what_text') }}</p>
    <h2>{{ __('ui.about.principles_title') }}</h2>
    <ul class="check-list">
        @foreach (['local', 'small', 'restore', 'honest'] as $k)
            <li><x-icon name="check" size="16"/> <span><b>{{ __('ui.home.why_'.$k) }}</b> — {{ __('ui.home.why_'.$k.'_text') }}</span></li>
        @endforeach
    </ul>
    <h2>{{ __('ui.about.company_title') }}</h2>
    <p>{{ config('ecoexplore.legal_entity') ?: __('ui.about.company_pending') }}</p>
</section>
@endsection
