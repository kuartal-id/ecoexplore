@php($itemType = $journey ?? null ? 'journey' : 'listing')
@php($ref = $journey ?? $listing)
<div class="add-itin">
    @auth
        @php($mine = auth()->user()->itineraries)
        @if ($mine->isEmpty())
            <p class="muted small">{!! __('ui.itinerary.login_first', ['login' => '<a class="link" href="'.route('itineraries.index').'">'.e(__('ui.itinerary.create')).'</a>']) !!}</p>
        @else
            <form method="post" action="{{ route('itineraries.items.store', $mine->first()) }}" class="add-itin-form">
                @csrf
                <input type="hidden" name="item_type" value="{{ $itemType }}">
                <input type="hidden" name="item_id" value="{{ $ref->id }}">
                <label class="sr-only" for="itin-{{ $itemType }}-{{ $ref->id }}">{{ __('ui.itinerary.title') }}</label>
                <select id="itin-{{ $itemType }}-{{ $ref->id }}" name="itinerary" onchange="this.form.action = '{{ url('/account/itineraries') }}/' + this.value + '/items'">
                    @foreach ($mine as $itin)
                        <option value="{{ $itin->id }}">{{ $itin->title }}</option>
                    @endforeach
                </select>
                <button class="btn btn-ghost small" type="submit"><x-icon name="pin" size="16"/> {{ __('ui.itinerary.add') }}</button>
            </form>
        @endif
    @else
        <p class="muted small">{!! __('ui.itinerary.login_first', ['login' => '<a class="link" href="'.route('login').'">'.e(__('ui.nav.login')).'</a>']) !!}</p>
    @endauth
</div>
