<a href="{{ route('journeys.show', $journey) }}" class="listing-card">
    <div class="card-image" style="background-image:url('{{ asset($journey->image ?: 'assets/img/photos/hero.jpg') }}')">
        <span class="card-chip">{{ $journey->durationLabel() }}</span>
    </div>
    <div class="card-body">
        <div class="eyebrow">{{ __('ui.category.'.$journey->category) }} · {{ $journey->region }}</div>
        <h3>{{ $journey->tr('title') }}</h3>
        <p>{{ \Illuminate\Support\Str::limit($journey->tr('summary'), 130) }}</p>
        <div class="card-meta">
            <span>{{ __('ui.common.from') }} {{ idr($journey->price_idr) }} <small class="muted">/ {{ __('ui.unit.person') }}</small></span>
            <span class="muted">{{ __('ui.difficulty.'.$journey->difficulty) }}</span>
        </div>
    </div>
</a>
