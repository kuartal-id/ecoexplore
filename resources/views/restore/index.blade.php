@extends('layouts.app')

@section('title', __('ui.restore.title'))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="leaf" size="14"/> {{ __('ui.restore.eyebrow') }}</span>
    <h1>{!! __('ui.restore.h1', ['em' => '<em>'.e(__('ui.restore.h1_em')).'</em>']) !!}</h1>
    <p>{{ __('ui.restore.lead') }}</p>
    <div class="filter-row">
        <a href="{{ route('restore.index') }}" @class(['pill', 'on' => ! $type])>{{ __('ui.common.all') }}</a>
        @foreach (\App\Models\RestorationProject::TYPES as $t)
            <a href="{{ route('restore.index', ['type' => $t]) }}" @class(['pill', 'on' => $type === $t])>{{ __('ui.restore.type.'.$t) }}</a>
        @endforeach
    </div>
</section>

<section class="section tight">
    @include('partials.sample-notice', ['text' => __('ui.restore.sample_notice')])
    <div class="cards-grid">
        @forelse ($projects as $project)
            @include('partials.restore-card')
        @empty
            <div class="empty">{{ __('ui.restore.empty') }}</div>
        @endforelse
    </div>
</section>

<section class="section alt">
    <div class="split narrow">
        <div>
            <div class="eyebrow">{{ __('ui.restore.how_eyebrow') }}</div>
            <h2>{{ __('ui.restore.how_title') }}</h2>
        </div>
        <ol class="steps">
            <li><b>{{ __('ui.restore.how_1') }}</b><span>{{ __('ui.restore.how_1_text') }}</span></li>
            <li><b>{{ __('ui.restore.how_2') }}</b><span>{{ __('ui.restore.how_2_text') }}</span></li>
            <li><b>{{ __('ui.restore.how_3') }}</b><span>{{ __('ui.restore.how_3_text') }}</span></li>
        </ol>
    </div>
</section>
@endsection
