@extends('layouts.app')

@section('title', __('ui.booking.title').' '.$booking->reference)

@section('content')
<section class="confirmation">
    <div class="success-icon">{{ $booking->isPaid() ? '✓' : '…' }}</div>
    <div class="eyebrow">{{ __('ui.booking.reference') }} {{ $booking->reference }}</div>
    <h1>{{ $booking->isPaid() ? __('ui.booking.h1_confirmed') : __('ui.booking.h1_received') }}</h1>
    <p>{{ $booking->isPaid() ? __('ui.booking.lead_confirmed', ['email' => $booking->contact_email]) : __('ui.booking.lead_received', ['email' => $booking->contact_email]) }}</p>

    <div class="confirmation-grid">
        <div><span>{{ __('ui.booking.item') }}</span><b>{{ $item instanceof \App\Models\Listing ? $item->name : ($item?->tr('title') ?: $booking->item_name) }}</b></div>
        <div><span>{{ __('ui.booking.date') }}</span><b>{{ $booking->start_date ? $booking->start_date->translatedFormat('j M Y') : '—' }}@if ($booking->end_date && ! $booking->end_date->equalTo($booking->start_date)) – {{ $booking->end_date->translatedFormat('j M Y') }}@endif</b></div>
        <div><span>{{ __('ui.booking.quantity') }}</span><b>{{ $booking->quantity }}@if (! empty($booking->meta['nights'])) × {{ trans_choice('ui.booking.nights', $booking->meta['nights'], ['n' => $booking->meta['nights']]) }}@endif</b></div>
        <div><span>{{ __('ui.booking.total') }}</span><b>{{ idr($booking->amount_idr) }}</b></div>
    </div>

    <div class="status-row">
        <span class="badge badge-{{ $booking->status }}">{{ __('ui.status.'.$booking->status) }}</span>
        <span class="badge badge-{{ $booking->payment_status }}">{{ __('ui.payment_status.'.$booking->payment_status) }}</span>
    </div>

    <div class="payment-box">
        @if ($booking->isPaid())
            <h2>{{ __('ui.booking.paid_title') }}</h2>
            <p>{{ __('ui.booking.paid_text', ['date' => $booking->paid_at?->translatedFormat('j M Y H:i')]) }}</p>
        @elseif ($booking->isOpen())
            <h2>{{ __('ui.booking.pay_title') }}</h2>
            <p>{{ __('ui.booking.pay_text') }}</p>

            <form method="post" action="{{ route('bookings.payment-method', $booking) }}" class="pay-switch">
                @csrf
                <div class="payment-methods">
                    @foreach (\App\Models\Booking::PAYMENT_METHODS as $m)
                        <label @class(['on' => $booking->payment_method === $m])>
                            <input type="radio" name="payment_method" value="{{ $m }}" @checked($booking->payment_method === $m)> {{ __('ui.payment.'.$m) }}
                        </label>
                    @endforeach
                </div>
                <button class="btn btn-ghost small" type="submit">{{ __('ui.booking.save_method') }}</button>
            </form>

            @if ($booking->payment_method === 'bank_transfer')
                <div class="bank-box">
                    <b>{{ __('ui.payment.bank_transfer') }}</b>
                    @if (count($bank) === 3)
                        <p>{{ __('ui.booking.bank_details', ['bank' => $bank['bank_name'], 'name' => $bank['account_name'], 'number' => $bank['account_number']]) }}</p>
                        <p>{{ __('ui.booking.bank_reference', ['ref' => $booking->reference, 'amount' => idr($booking->amount_idr)]) }}</p>
                    @else
                        <p>{{ __('ui.booking.bank_pending') }}</p>
                    @endif
                </div>
            @else
                <div class="bank-box">
                    <b>{{ __('ui.payment.'.($booking->payment_method ?: 'card')) }}</b>
                    <p>{{ __('ui.booking.gateway_pending') }}</p>
                </div>
            @endif
        @else
            <h2>{{ __('ui.status.'.$booking->status) }}</h2>
            <p>{{ __('ui.booking.closed_text') }}</p>
        @endif
    </div>

    <div class="hero-actions center">
        @auth<a class="btn btn-primary" href="{{ route('account') }}">{{ __('ui.booking.my_trips') }}</a>@endauth
        <a class="btn btn-ghost" href="{{ route('explore') }}">{{ __('ui.booking.keep_exploring') }}</a>
    </div>
</section>
@endsection
