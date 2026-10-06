@extends('layouts.app')

@section('title', __('ui.carbon.title'))

@php($in = $result['input'])
@section('content')
<section class="subhero compact">
    <span class="pill"><x-icon name="cloud" size="14"/> {{ __('ui.carbon.eyebrow') }}</span>
    <h1>{!! __('ui.carbon.h1', ['em' => '<em>'.e(__('ui.carbon.h1_em')).'</em>']) !!}</h1>
    <p>{{ __('ui.carbon.lead') }}</p>
</section>

<section class="section tight carbon-layout">
    <form class="carbon-form" method="get" action="{{ route('carbon') }}#result">
        <label class="full">{{ __('ui.carbon.origin') }}
            <select name="origin">
                @foreach ($factors['origins'] as $key => $o)
                    <option value="{{ $key }}" @selected($in['origin'] === $key)>{{ $o['label'] }}{{ $o['km'] ? ' · ~'.num($o['km']).' km' : '' }}</option>
                @endforeach
            </select>
        </label>
        <label>{{ __('ui.carbon.flight_class') }}
            <select name="flight_class">
                @foreach (array_keys($factors['flight_kg_per_pkm']) as $k)<option value="{{ $k }}" @selected($in['flight_class'] === $k)>{{ __('ui.carbon.class.'.$k) }}</option>@endforeach
            </select>
        </label>
        <label class="check"><input type="checkbox" name="return_trip" value="1" @checked(filter_var($in['return_trip'], FILTER_VALIDATE_BOOLEAN))> {{ __('ui.carbon.return_trip') }}</label>
        <label>{{ __('ui.carbon.travellers') }}<input type="number" name="travellers" min="1" max="50" value="{{ $in['travellers'] }}" inputmode="numeric"></label>
        <label>{{ __('ui.carbon.nights') }}<input type="number" name="nights" min="0" max="60" value="{{ $in['nights'] }}" inputmode="numeric"></label>
        <label>{{ __('ui.carbon.stay') }}
            <select name="stay">
                @foreach (array_keys($factors['stay_kg_per_room_night']) as $k)<option value="{{ $k }}" @selected($in['stay'] === $k)>{{ __('ui.carbon.stays.'.$k) }}</option>@endforeach
            </select>
        </label>
        <label>{{ __('ui.carbon.diet') }}
            <select name="diet">
                @foreach (array_keys($factors['food_kg_per_person_day']) as $k)<option value="{{ $k }}" @selected($in['diet'] === $k)>{{ __('ui.carbon.diets.'.$k) }}</option>@endforeach
            </select>
        </label>
        <label>{{ __('ui.carbon.car_km') }}<input type="number" name="car_km" min="0" max="5000" value="{{ $in['car_km'] }}" inputmode="numeric"><small>{{ __('ui.carbon.car_hint') }}</small></label>
        <label>{{ __('ui.carbon.boat_trips') }}<input type="number" name="boat_trips" min="0" max="20" value="{{ $in['boat_trips'] }}" inputmode="numeric"></label>
        <label>{{ __('ui.carbon.boat_type') }}
            <select name="boat_type">
                @foreach (array_keys($factors['boat_kg_per_trip']) as $k)<option value="{{ $k }}" @selected($in['boat_type'] === $k)>{{ __('ui.carbon.boats.'.$k) }}</option>@endforeach
            </select>
        </label>
        <button class="btn btn-primary full" type="submit">{{ __('ui.carbon.calculate') }}</button>
    </form>

    <div class="carbon-result" id="result">
        <div class="eyebrow">{{ $calculated ? __('ui.carbon.result') : __('ui.carbon.example') }}</div>
        <div class="big-number">{{ num($result['total_kg']) }}<small> kg CO₂e</small></div>
        <p>{{ __('ui.carbon.per_person', ['kg' => num($result['per_person_kg'])]) }}</p>
        @php($max = max(1, max($result['breakdown'])))
        <div class="breakdown">
            @foreach ($result['breakdown'] as $k => $kg)
                <div><span>{{ __('ui.carbon.parts.'.$k) }}</span><div class="bar"><i style="width: {{ round($kg / $max * 100) }}%"></i></div><b>{{ num($kg) }} kg</b></div>
            @endforeach
        </div>
        <div class="offset-suggest">
            <b>{{ __('ui.carbon.contribute_title') }}</b>
            <strong>{{ idr($result['contribution_idr']) }}</strong>
            <span>{{ __('ui.carbon.contribute_text') }}</span>
            <a class="btn btn-primary small" href="{{ route('restore.index') }}">{{ __('ui.home.cta_restore') }}</a>
        </div>
        <div class="disclaimer" role="note">
            <b>{{ __('ui.carbon.disclaimer_title') }}</b>
            <p>{{ __('ui.carbon.disclaimer') }}</p>
            <small>{{ __('ui.carbon.version', ['v' => $result['version']]) }}</small>
        </div>
    </div>
</section>

<section class="section tight">
    <details class="factors">
        <summary>{{ __('ui.carbon.factors_title') }}</summary>
        <p class="muted">{{ __('ui.carbon.factors_intro') }}</p>
        <table class="table">
            <tbody>
                @foreach ($factors['flight_kg_per_pkm'] as $k => $v)<tr><td>{{ __('ui.carbon.parts.flights') }} · {{ __('ui.carbon.class.'.$k) }}</td><td>{{ $v }} kg / pkm</td></tr>@endforeach
                @foreach ($factors['boat_kg_per_trip'] as $k => $v)<tr><td>{{ __('ui.carbon.boats.'.$k) }}</td><td>{{ $v }} kg / {{ __('ui.carbon.per_crossing') }}</td></tr>@endforeach
                <tr><td>{{ __('ui.carbon.parts.ground') }}</td><td>{{ $factors['car_kg_per_km'] }} kg / km</td></tr>
                @foreach ($factors['stay_kg_per_room_night'] as $k => $v)<tr><td>{{ __('ui.carbon.stays.'.$k) }}</td><td>{{ $v }} kg / {{ __('ui.carbon.per_room_night') }}</td></tr>@endforeach
                @foreach ($factors['food_kg_per_person_day'] as $k => $v)<tr><td>{{ __('ui.carbon.diets.'.$k) }}</td><td>{{ $v }} kg / {{ __('ui.carbon.per_person_day') }}</td></tr>@endforeach
            </tbody>
        </table>
    </details>
</section>
@endsection
