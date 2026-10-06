<a href="{{ route('directory.show', [$listing->segment(), $listing->slug]) }}" class="listing-card">
    <div class="card-image short" style="background-image:url('{{ asset($listing->image ?: 'assets/img/hero.svg') }}')">
        <span class="card-chip">{{ $listing->subtypeLabel() }}</span>
        <span class="card-chip sample">{{ __('ui.common.sample') }}</span>
    </div>
    <div class="card-body">
        <div class="eyebrow"><x-icon name="pin" size="12"/> {{ $listing->location }}</div>
        <h3>{{ $listing->name }}</h3>
        <p>{{ $listing->tr('summary') }}</p>
        <div class="card-meta">
            @if ($listing->price_idr)
                <span>{{ $listing->is_bookable ? '' : '±' }}{{ idr($listing->price_idr) }} <small class="muted">/ {{ __('ui.unit.'.$listing->price_unit) }}</small></span>
            @else
                <span class="muted">{{ __('ui.directory.info_only') }}</span>
            @endif
            <span class="{{ $listing->canBeBooked() ? 'ok-text' : 'muted' }}">{{ $listing->canBeBooked() ? __('ui.directory.bookable') : __('ui.directory.directory') }}</span>
        </div>
    </div>
</a>
