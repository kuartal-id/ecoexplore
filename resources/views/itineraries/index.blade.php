@extends('layouts.app')

@section('title', __('ui.itinerary.title'))

@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="pin" size="14"/> {{ __('ui.itinerary.eyebrow') }}</span>
    <h1>{{ __('ui.itinerary.title') }}</h1>
    <p>{{ __('ui.account.itineraries_hint') }}</p>
</section>

<section class="section tight">
    <div class="card">
        <form method="post" action="{{ route('itineraries.store') }}">
            @csrf
            <div class="form-grid">
                <label>{{ __('ui.itinerary.name') }}
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('ui.itinerary.name_placeholder') }}" required maxlength="120">
                    @error('title')<em class="err">{{ $message }}</em>@enderror
                </label>
                <label>{{ __('ui.itinerary.start') }} <small>({{ __('ui.common.optional') }})</small>
                    <input type="date" name="start_date" value="{{ old('start_date') }}">
                    @error('start_date')<em class="err">{{ $message }}</em>@enderror
                </label>
            </div>
            <button class="btn btn-primary" type="submit">{{ __('ui.itinerary.save') }} <x-icon name="arrow" size="18"/></button>
        </form>
    </div>
</section>

<section class="section tight">
    @if ($itineraries->isEmpty())
        <div class="empty">{{ __('ui.itinerary.empty') }} <span class="muted">{{ __('ui.itinerary.empty_hint') }}</span></div>
    @else
        <div class="trip-list">
            @foreach ($itineraries as $itin)
                <div class="trip-row">
                    <a href="{{ route('itineraries.show', $itin) }}">
                        <div>
                            <b>{{ $itin->title }}</b>
                            <small>
                                {{ trans_choice('ui.itinerary.stop_count', $itin->items_count, ['n' => $itin->items_count]) }}
                                @if ($itin->start_date) · {{ $itin->start_date->translatedFormat('j M Y') }}@endif
                            </small>
                        </div>
                    </a>
                    <form method="post" action="{{ route('itineraries.destroy', $itin) }}" onsubmit="return confirm('{{ __('ui.itinerary.confirm_delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost small" type="submit">{{ __('ui.admin.delete') }}</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
