@extends('layouts.app')

@php
    $isJourney = $item instanceof \App\Models\Journey;
    $isListing = $item instanceof \App\Models\Listing;
    $isRestore = $item instanceof \App\Models\RestorationProject;
    $isStay = $isListing && $item->isStay();
    $title = $isListing ? $item->name : $item->tr('title');
    $unitLabel = $isRestore ? $item->tr('unit_label') : ($isListing ? __('ui.unit.'.$item->price_unit) : __('ui.unit.person'));
    $qtyLabel = match (true) {
        $isJourney => __('ui.checkout.travellers'),
        $isStay => __('ui.checkout.rooms'),
        $isRestore => __('ui.restore.units', ['unit' => $item->tr('unit_label')]),
        $isListing && $item->price_unit === 'person' => __('ui.checkout.people'),
        $isListing && $item->price_unit === 'day' => __('ui.checkout.days'),
        default => __('ui.checkout.quantity'),
    };
    $minDate = now()->addDay()->toDateString();
    $method = old('payment_method', 'bank_transfer');
@endphp

@section('title', __('ui.checkout.title'))
@section('body_class', 'checkout-page')

@section('content')
<div class="checkout">
    <form class="checkout-main" method="post" action="{{ route('checkout.store', [$kind, $slug]) }}" data-checkout data-unit="{{ $price['unit'] }}" data-stay="{{ $isStay ? 1 : 0 }}" novalidate>
        @csrf
        <ol class="stepper" aria-label="{{ __('ui.checkout.steps') }}">
            <li class="on"><span>1</span>{{ __('ui.checkout.step_details') }}</li>
            <li class="on"><span>2</span>{{ __('ui.checkout.step_payment') }}</li>
            <li><span>3</span>{{ __('ui.checkout.step_confirm') }}</li>
        </ol>
        <div class="eyebrow">{{ __('ui.checkout.eyebrow') }}</div>
        <h1>{{ $isRestore ? __('ui.checkout.h1_restore') : __('ui.checkout.h1') }}</h1>

        @if ($errors->any())
            <div class="flash flash-err" role="alert">{{ __('ui.checkout.fix_errors') }}</div>
        @endif

        <h3 class="block-title">{{ $isRestore ? __('ui.checkout.contribution') : __('ui.checkout.trip') }}</h3>
        <div class="form-grid">
            <label>{{ $qtyLabel }}
                <input type="number" name="quantity" value="{{ old('quantity', $quantity) }}" min="{{ $limits[0] }}" max="{{ $limits[1] }}" required inputmode="numeric" data-qty>
                @error('quantity')<em class="err">{{ $message }}</em>@enderror
            </label>
            @unless ($isRestore)
                <label>{{ $isStay ? __('ui.checkout.check_in') : ($isJourney ? __('ui.checkout.start_date') : __('ui.checkout.service_date')) }}
                    <input type="date" name="start_date" value="{{ old('start_date') }}" min="{{ $minDate }}" required data-start>
                    @error('start_date')<em class="err">{{ $message }}</em>@enderror
                </label>
            @endunless
            @if ($isStay)
                <label>{{ __('ui.checkout.check_out') }}
                    <input type="date" name="end_date" value="{{ old('end_date') }}" min="{{ $minDate }}" required data-end>
                    @error('end_date')<em class="err">{{ $message }}</em>@enderror
                </label>
            @endif
        </div>

        <h3 class="block-title">{{ __('ui.checkout.contact') }}</h3>
        @guest
            <p class="muted small">{!! __('ui.checkout.guest_hint', ['login' => '<a class="link" href="'.route('login').'">'.e(__('ui.nav.login')).'</a>']) !!}</p>
        @endguest
        <div class="form-grid">
            <label>{{ __('ui.checkout.name') }}
                <input type="text" name="contact_name" value="{{ old('contact_name', $user?->name) }}" required autocomplete="name">
                @error('contact_name')<em class="err">{{ $message }}</em>@enderror
            </label>
            <label>{{ __('ui.checkout.email') }}
                <input type="email" name="contact_email" value="{{ old('contact_email', $user?->email) }}" required autocomplete="email">
                @error('contact_email')<em class="err">{{ $message }}</em>@enderror
            </label>
            <label>{{ __('ui.checkout.phone') }}
                <input type="tel" name="contact_phone" value="{{ old('contact_phone', $user?->phone) }}" required autocomplete="tel" placeholder="+62 8xx">
                @error('contact_phone')<em class="err">{{ $message }}</em>@enderror
            </label>
            <label class="span-2">{{ __('ui.checkout.notes') }}
                <textarea name="notes" rows="3" placeholder="{{ __('ui.checkout.notes_placeholder') }}">{{ old('notes') }}</textarea>
            </label>
        </div>

        <h3 class="block-title">{{ __('ui.checkout.payment') }}</h3>
        <div class="pay-options" role="radiogroup">
            @foreach (['bank_transfer' => 'bank', 'ewallet' => 'wallet', 'card' => 'card'] as $m => $icon)
                <label class="checkout-option pay-option">
                    <input type="radio" name="payment_method" value="{{ $m }}" @checked($method === $m)>
                    <span class="pay-icon"><x-icon :name="$icon" size="22"/></span>
                    <span><b>{{ __('ui.payment.'.$m) }}</b><p>{{ __('ui.payment.'.$m.'_hint') }}</p></span>
                </label>
            @endforeach
        </div>
        @error('payment_method')<em class="err">{{ $message }}</em>@enderror
        <p class="pay-note"><x-icon name="shield" size="16"/> {{ __('ui.checkout.no_charge') }}</p>

        <label class="check terms">
            <input type="checkbox" name="accept_terms" value="1" @checked(old('accept_terms'))>
            <span>{!! __('ui.checkout.accept', ['terms' => '<a class="link" href="'.route('terms').'" target="_blank">'.e(__('ui.footer.terms')).'</a>', 'privacy' => '<a class="link" href="'.route('privacy').'" target="_blank">'.e(__('ui.footer.privacy')).'</a>']) !!}</span>
        </label>
        @error('accept_terms')<em class="err">{{ $message }}</em>@enderror

        <div class="checkout-submit">
            <div class="mobile-total"><small>{{ __('ui.checkout.total') }}</small><b data-total>{{ idr($price['amount']) }}</b></div>
            <button class="btn btn-primary" type="submit">{{ __('ui.checkout.submit') }} <x-icon name="arrow" size="18"/></button>
        </div>
    </form>

    <aside class="order-card">
        <div class="order-image" style="background-image:url('{{ asset($item->image ?: 'assets/img/hero.svg') }}')"></div>
        <div class="order-body">
            <div class="eyebrow">{{ $isJourney ? $item->durationLabel() : ($isRestore ? __('ui.restore.type.'.$item->type) : __('ui.directory.types.'.$item->type)) }}</div>
            <h3>{{ $title }}</h3>
            <p>{{ $isListing ? $item->location : ($isRestore ? $item->location : $item->region) }}</p>
            <div class="order-line"><span>{{ __('ui.checkout.unit_price') }}</span><b>{{ idr($price['unit']) }} / {{ $unitLabel }}</b></div>
            <div class="order-line"><span>{{ $qtyLabel }}</span><b data-qty-out>{{ old('quantity', $quantity) }}</b></div>
            @if ($isStay)<div class="order-line"><span>{{ __('ui.checkout.nights') }}</span><b data-nights-out>1</b></div>@endif
            <div class="order-total"><span>{{ __('ui.checkout.total') }}</span><strong data-total>{{ idr($price['amount']) }}</strong></div>
            <p class="small muted">{{ __('ui.checkout.total_note') }}</p>
        </div>
    </aside>
</div>
@endsection
