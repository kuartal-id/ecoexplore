@extends('layouts.app')

@section('title', __('ui.explore.title'))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="compass" size="14"/> Lombok</span>
    <h1>{!! __('ui.explore.h1', ['em' => '<em>'.e(__('ui.explore.h1_em')).'</em>']) !!}</h1>
    <p>{{ __('ui.explore.lead') }}</p>
    <form class="searchbar" method="get" action="{{ route('explore') }}" role="search">
        @if ($category)<input type="hidden" name="category" value="{{ $category }}">@endif
        <input type="search" name="q" value="{{ $q }}" placeholder="{{ __('ui.explore.search_placeholder') }}" aria-label="{{ __('ui.explore.search_placeholder') }}">
        <button class="btn btn-primary" type="submit">{{ __('ui.common.search') }}</button>
    </form>
    <div class="filter-row">
        <a href="{{ route('explore', array_filter(['q' => $q])) }}" @class(['pill', 'on' => ! $category])>{{ __('ui.common.all') }}</a>
        @foreach (\App\Models\Journey::CATEGORIES as $cat)
            <a href="{{ route('explore', array_filter(['category' => $cat, 'q' => $q])) }}" @class(['pill', 'on' => $category === $cat])>{{ __('ui.category.'.$cat) }}</a>
        @endforeach
    </div>
</section>

<section class="section tight">
    @include('partials.sample-notice')
    @if ($journeys->isEmpty())
        <div class="empty">{{ __('ui.explore.empty') }}</div>
    @else
        <div class="cards-grid">
            @foreach ($journeys as $journey)
                @include('partials.journey-card')
            @endforeach
        </div>
    @endif
</section>

<section class="section alt">
    <div class="section-head">
        <div>
            <div class="eyebrow">{{ __('ui.home.dir_eyebrow') }}</div>
            <h2>{{ __('ui.explore.dir_title') }}</h2>
        </div>
    </div>
    @include('partials.directory-grid')
</section>
@endsection
