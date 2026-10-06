@extends('layouts.app')
@section('title', $booking->reference)
@section('body_class', 'admin')
@section('content')
<section class="section admin-wrap">
    <div class="eyebrow">{{ __('ui.admin.title') }} · {{ __('ui.admin.bookings') }}</div>
    <h1 class="admin-h1">{{ $booking->reference }}</h1>
    @include('admin.nav')
    <div class="admin-grid">
        <div class="panel">
            <h2 class="block-title">{{ __('ui.admin.details') }}</h2>
            <dl class="kv">
                <dt>{{ __('ui.booking.item') }}</dt><dd>{{ $booking->item_name }} <small class="muted">({{ $booking->item_type }} #{{ $booking->item_id }})</small></dd>
                <dt>{{ __('ui.admin.purpose') }}</dt><dd>{{ __('ui.purpose.'.$booking->purpose) }} · source: {{ $booking->source_site }}</dd>
                <dt>{{ __('ui.booking.date') }}</dt><dd>{{ $booking->start_date?->format('Y-m-d') ?? '—' }} @if ($booking->end_date) → {{ $booking->end_date->format('Y-m-d') }} @endif</dd>
                <dt>{{ __('ui.booking.quantity') }}</dt><dd>{{ $booking->quantity }} × {{ idr($booking->unit_price_idr) }} @if (! empty($booking->meta['nights'])) × {{ $booking->meta['nights'] }} {{ __('ui.checkout.nights') }} @endif</dd>
                <dt>{{ __('ui.booking.total') }}</dt><dd><b>{{ idr($booking->amount_idr) }}</b> {{ $booking->currency }}</dd>
                <dt>{{ __('ui.checkout.contact') }}</dt><dd>{{ $booking->contact_name }}<br>{{ $booking->contact_email }}<br>{{ $booking->contact_phone }}</dd>
                <dt>{{ __('ui.admin.account') }}</dt><dd>{{ $booking->user ? $booking->user->email : __('ui.admin.guest') }}</dd>
                <dt>{{ __('ui.checkout.notes') }}</dt><dd>{{ $booking->notes ?: '—' }}</dd>
                <dt>{{ __('ui.checkout.payment') }}</dt><dd>{{ $booking->payment_method ? __('ui.payment.'.$booking->payment_method) : '—' }} · <span class="badge badge-{{ $booking->payment_status }}">{{ __('ui.payment_status.'.$booking->payment_status) }}</span> @if ($booking->paid_at) · {{ $booking->paid_at->format('Y-m-d H:i') }} ({{ $booking->payment_provider }} {{ $booking->payment_reference }}) @endif</dd>
                <dt>Status</dt><dd><span class="badge badge-{{ $booking->status }}">{{ __('ui.status.'.$booking->status) }}</span></dd>
            </dl>
        </div>
        <div class="panel">
            @if ($booking->isOpen())
                <h2 class="block-title">{{ __('ui.admin.mark_paid_title') }}</h2>
                <p class="muted small">{{ __('ui.admin.mark_paid_help') }}</p>
                <form method="post" action="{{ route('admin.bookings.mark-paid', $booking) }}" class="stack">
                    @csrf
                    <label class="field">{{ __('ui.admin.transfer_reference') }}<input type="text" name="transfer_reference" value="{{ old('transfer_reference') }}" required maxlength="120"></label>
                    @error('transfer_reference')<em class="err">{{ $message }}</em>@enderror
                    <label class="check"><input type="checkbox" name="confirm" value="1"> {{ __('ui.admin.confirm_received', ['amount' => idr($booking->amount_idr)]) }}</label>
                    @error('confirm')<em class="err">{{ $message }}</em>@enderror
                    <button class="btn btn-primary" type="submit">{{ __('ui.admin.mark_paid') }}</button>
                </form>
                <form method="post" action="{{ route('admin.bookings.cancel', $booking) }}" class="stack top-gap">
                    @csrf
                    <label class="field">{{ __('ui.admin.cancel_reason') }}<input type="text" name="reason" maxlength="200"></label>
                    <button class="btn btn-ghost small" type="submit" onclick="return confirm('{{ __('ui.admin.cancel_confirm') }}')">{{ __('ui.admin.cancel') }}</button>
                </form>
            @endif
            <h2 class="block-title">{{ __('ui.admin.history') }}</h2>
            <ul class="events">
                @foreach ($booking->events as $e)
                    <li><b>{{ $e->type }}</b> <small class="muted">{{ $e->created_at?->format('Y-m-d H:i') }} @if ($e->actor) · {{ $e->actor->email }} @endif</small>@if ($e->data)<code>{{ json_encode($e->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code>@endif</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endsection
