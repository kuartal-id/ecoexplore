@extends('layouts.app')

@section('title', $itinerary->title)

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="pin" size="14"/> {{ __('ui.itinerary.eyebrow') }}</span>
    <h1>{{ $itinerary->title }}</h1>
    <p>
        @if ($itinerary->start_date){{ $itinerary->start_date->translatedFormat('j M Y') }} · @endif
        {{ trans_choice('ui.itinerary.stop_count', $stops->count(), ['n' => $stops->count()]) }}
    </p>
    <div class="hero-actions">
        <a class="btn btn-ghost small" href="{{ route('itineraries.index') }}">{{ __('ui.itinerary.title') }}</a>
        <a class="btn btn-ghost small" href="{{ route('explore') }}">{{ __('ui.home.cta_explore') }}</a>
    </div>
</section>

<section class="section tight">
    @if ($stops->isEmpty())
        <div class="empty">{{ __('ui.itinerary.no_stops') }}</div>
    @else
        @foreach ($stops->groupBy('item.day') as $day => $rows)
            <h2 class="block-title itin-day">{{ __('ui.itinerary.day', ['n' => $day]) }}</h2>
            <div class="trip-list itin-list">
                @foreach ($rows as $row)
                    @php($ref = $row['ref'])
                    @php($item = $row['item'])
                    @php($isJourney = $ref instanceof \App\Models\Journey)
                    <div class="trip-row itin-stop">
                        <a href="{{ $isJourney ? route('journeys.show', $ref) : route('directory.show', [$ref->segment(), $ref]) }}">
                            <div>
                                <b>{{ $isJourney ? $ref->tr('title') : $ref->name }}</b>
                                <small>
                                    {{ $isJourney ? __('ui.category.'.$ref->category) : __('ui.subtype.'.($ref->subtype ?? $ref->type)) }}
                                    @isset($ref->price_idr) · {{ idr($ref->price_idr) }}@endisset
                                </small>
                                @if ($item->notes)<small>{{ $item->notes }}</small>@endif
                            </div>
                        </a>
                        <div class="itin-actions">
                            @if ($isJourney || $ref->canBeBooked())
                                <a class="btn btn-primary small" href="{{ route('checkout.create', [$isJourney ? 'journey' : 'listing', $ref->slug]) }}">{{ __('ui.itinerary.book') }}</a>
                            @else
                                <span class="badge">{{ __('ui.itinerary.unbookable') }}</span>
                            @endif
                            <details class="itin-edit">
                                <summary class="btn btn-ghost small">{{ __('ui.admin.edit') }}</summary>
                                <form class="form-grid" method="post" action="{{ route('itineraries.items.update', [$itinerary, $item]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <label>{{ __('ui.itinerary.day_label') }}
                                        <input type="number" name="day" value="{{ $item->day }}" min="1" max="90" required inputmode="numeric">
                                    </label>
                                    <label>{{ __('ui.itinerary.notes') }}
                                        <input type="text" name="notes" value="{{ $item->notes }}" placeholder="{{ __('ui.itinerary.notes_placeholder') }}" maxlength="500">
                                    </label>
                                    <button class="btn btn-ghost small" type="submit">{{ __('ui.itinerary.update') }}</button>
                                </form>
                            </details>
                            <form method="post" action="{{ route('itineraries.items.destroy', [$itinerary, $item]) }}" onsubmit="return confirm('{{ __('ui.itinerary.confirm_remove') }}')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-ghost small" type="submit">{{ __('ui.admin.delete') }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
</section>
@endsection
