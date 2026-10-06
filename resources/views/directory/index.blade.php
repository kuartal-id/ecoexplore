@extends('layouts.app')

@section('title', __('ui.directory.types.'.$model))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="grid" size="14"/> {{ __('ui.directory.eyebrow') }}</span>
    <h1>{{ __('ui.directory.types.'.$model) }}</h1>
    <p>{{ __('ui.directory.leads.'.$model) }}</p>
    <div class="filter-row">
        @foreach (\App\Models\Listing::TYPES as $t => $seg)
            <a href="{{ route('directory.index', $seg) }}" @class(['pill', 'on' => $t === $model])>{{ __('ui.directory.types.'.$t) }}</a>
        @endforeach
    </div>
    @if ($subtypes->count() > 1)
        <div class="filter-row">
            <a href="{{ route('directory.index', $type) }}" @class(['pill', 'small-pill', 'on' => ! $subtype])>{{ __('ui.common.all') }}</a>
            @foreach ($subtypes as $st)
                <a href="{{ route('directory.index', [$type, 'subtype' => $st]) }}" @class(['pill', 'small-pill', 'on' => $subtype === $st])>{{ \App\Models\Listing::labelForSubtype($st) }}</a>
            @endforeach
        </div>
    @endif
</section>

<section class="section tight">
    @include('partials.sample-notice', ['text' => __('ui.directory.sample_notice')])
    @if ($listings->isEmpty())
        <div class="empty">{{ __('ui.directory.empty') }}</div>
    @else
        <div class="cards-grid">
            @foreach ($listings as $listing)
                @include('partials.listing-card')
            @endforeach
        </div>
    @endif
</section>
@endsection
