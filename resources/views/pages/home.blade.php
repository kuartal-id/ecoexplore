@extends('layouts.app')

@section('title', __('ui.home.title'))

@section('content')
<section class="hero">
    <div class="hero-copy">
        <span class="pill"><x-icon name="leaf" size="14"/> {{ __('ui.home.pill') }}</span>
        <h1>{!! __('ui.home.h1', ['em' => '<em>'.e(__('ui.home.h1_em')).'</em>']) !!}</h1>
        <p>{{ __('ui.home.lead') }}</p>
        <div class="hero-actions">
            <a href="{{ route('explore') }}" class="btn btn-primary">{{ __('ui.home.cta_explore') }} <x-icon name="arrow" size="18"/></a>
            <a href="{{ route('restore.index') }}" class="btn btn-ghost">{{ __('ui.home.cta_restore') }}</a>
        </div>
        <div class="trust-row">
            <span><x-icon name="users" size="16"/> {{ __('ui.home.trust_local') }}</span>
            <span><x-icon name="shield" size="16"/> {{ __('ui.home.trust_small') }}</span>
            <span><x-icon name="cloud" size="16"/> {{ __('ui.home.trust_carbon') }}</span>
        </div>
    </div>
    <div class="hero-visual">
        <div class="stamp" aria-hidden="true">
            <svg viewBox="0 0 120 120">
                <defs><path id="stamp-ring" d="M60,60 m-45,0 a45,45 0 1,1 90,0 a45,45 0 1,1 -90,0"/></defs>
                <circle class="stamp-bg" cx="60" cy="60" r="59"/>
                <circle class="stamp-ring" cx="60" cy="60" r="52"/>
                <text><textPath href="#stamp-ring">ECOEXPLORE • RINJANI • LOMBOK •</textPath></text>
            </svg>
            <span class="stamp-core"><x-icon name="leaf" size="30"/></span>
        </div>
        <div class="hero-photo" style="background-image:linear-gradient(180deg,transparent 35%,rgba(4,18,22,.82)),url('{{ asset('assets/img/hero.svg') }}')">
            <div>
                <span>{{ __('ui.home.photo_eyebrow') }}</span>
                <h2>{{ __('ui.home.photo_title') }}</h2>
                <p>{{ __('ui.home.photo_text') }}</p>
            </div>
        </div>
        @if ($project = $projects->first())
            <a class="impact-float" href="{{ route('restore.show', $project) }}">
                <small>{{ __('ui.home.float_label') }}</small>
                <strong>{{ $project->tr('title') }}</strong>
                <div class="progress"><i style="width: {{ max(2, $project->progressPercent()) }}%"></i></div>
                <span>{{ __('ui.restore.funded_of', ['n' => $project->funded_units, 't' => $project->target_units, 'unit' => $project->tr('unit_label')]) }}</span>
            </a>
        @endif
    </div>
</section>

<section class="stats" aria-label="{{ __('ui.home.stats_label') }}">
    <div><b>{{ $counts['journeys'] }}</b><span>{{ __('ui.home.stat_journeys') }}</span></div>
    <div><b>{{ $counts['listings'] }}</b><span>{{ __('ui.home.stat_listings') }}</span></div>
    <div><b>{{ $counts['projects'] }}</b><span>{{ __('ui.home.stat_projects') }}</span></div>
    <div><b>3</b><span>{{ __('ui.home.stat_types') }}</span></div>
</section>

<section class="section">
    <div class="section-head">
        <div>
            <div class="eyebrow">{{ __('ui.home.dir_eyebrow') }}</div>
            <h2>{{ __('ui.home.dir_title') }}</h2>
        </div>
        <a href="{{ route('explore') }}">{{ __('ui.common.see_all') }} →</a>
    </div>
    @include('partials.directory-grid')
</section>

<section class="dark-section">
    <div class="section-head">
        <div>
            <div class="eyebrow">{{ __('ui.home.journeys_eyebrow') }}</div>
            <h2>{{ __('ui.home.journeys_title') }}</h2>
        </div>
        <a href="{{ route('explore') }}">{{ __('ui.home.journeys_all', ['n' => $counts['journeys']]) }} →</a>
    </div>
    <div class="cards-grid scroller">
        @foreach ($featured as $journey)
            @include('partials.journey-card')
        @endforeach
    </div>
</section>

<section class="section">
    <div class="split">
        <div class="split-photo" style="background-image:url('{{ asset('assets/img/village.svg') }}')"></div>
        <div>
            <div class="eyebrow">{{ __('ui.home.why_eyebrow') }}</div>
            <h2>{{ __('ui.home.why_title') }}</h2>
            <p>{{ __('ui.home.why_text') }}</p>
            <div class="feature-list">
                @foreach (['local', 'small', 'restore', 'honest'] as $k)
                    <div><x-icon name="check" size="22" class="ok-text"/><b>{{ __('ui.home.why_'.$k) }}</b><small>{{ __('ui.home.why_'.$k.'_text') }}</small></div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section alt">
    <div class="restore-band">
        <div>
            <div class="eyebrow">{{ __('ui.home.restore_eyebrow') }}</div>
            <h2>{{ __('ui.home.restore_title') }}</h2>
            <p>{{ __('ui.home.restore_text') }}</p>
            <div class="hero-actions">
                <a href="{{ route('restore.index') }}" class="btn btn-primary">{{ __('ui.home.cta_restore') }}</a>
                <a href="{{ route('carbon') }}" class="btn btn-ghost">{{ __('ui.home.cta_carbon') }}</a>
            </div>
        </div>
        <div class="impact-grid light">
            <a href="{{ route('restore.index', ['type' => 'coral']) }}"><x-icon name="waves" size="28"/><b>{{ __('ui.restore.type.coral') }}</b><small>{{ __('ui.home.tile_coral') }}</small></a>
            <a href="{{ route('restore.index', ['type' => 'mangrove']) }}"><x-icon name="leaf" size="28"/><b>{{ __('ui.restore.type.mangrove') }}</b><small>{{ __('ui.home.tile_mangrove') }}</small></a>
            <a href="{{ route('restore.index', ['type' => 'forest']) }}"><x-icon name="tree" size="28"/><b>{{ __('ui.restore.type.forest') }}</b><small>{{ __('ui.home.tile_forest') }}</small></a>
            <a href="{{ route('carbon') }}"><x-icon name="cloud" size="28"/><b>{{ __('ui.nav.carbon') }}</b><small>{{ __('ui.home.tile_carbon') }}</small></a>
        </div>
    </div>
</section>
@endsection
