@php($url = route('bookings.show', $booking).'?t='.$booking->access_token)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<body style="margin:0;background:#f5f8f5;font-family:Poppins,Arial,sans-serif;color:#102c33">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:24px 12px">
<tr><td align="center">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#fff;border:1px solid #dce7e1;border-radius:18px;padding:28px">
<tr><td>
    <p style="font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#657b7e;margin:0 0 8px">Ecoexplore · {{ $booking->reference }}</p>
    <h1 style="font-size:24px;margin:0 0 12px">{{ $kind === 'confirmed' ? __('ui.mail.confirmed_title') : __('ui.mail.received_title') }}</h1>
    <p style="line-height:1.6">{{ __('ui.mail.hello', ['name' => $booking->contact_name]) }}</p>
    <p style="line-height:1.6">{{ $kind === 'confirmed' ? __('ui.mail.confirmed_text') : __('ui.mail.received_text') }}</p>
    <table role="presentation" width="100%" cellpadding="6" style="border-top:1px solid #dce7e1;margin:16px 0;font-size:14px">
        <tr><td style="color:#657b7e">{{ __('ui.booking.item') }}</td><td align="right"><b>{{ $booking->item_name }}</b></td></tr>
        @if ($booking->start_date)<tr><td style="color:#657b7e">{{ __('ui.booking.date') }}</td><td align="right">{{ $booking->start_date->translatedFormat('j M Y') }}</td></tr>@endif
        <tr><td style="color:#657b7e">{{ __('ui.booking.quantity') }}</td><td align="right">{{ $booking->quantity }}</td></tr>
        <tr><td style="color:#657b7e">{{ __('ui.booking.total') }}</td><td align="right"><b>{{ idr($booking->amount_idr) }}</b></td></tr>
        <tr><td style="color:#657b7e">{{ __('ui.checkout.payment') }}</td><td align="right">{{ $booking->payment_method ? __('ui.payment.'.$booking->payment_method) : '—' }} · {{ __('ui.payment_status.'.$booking->payment_status) }}</td></tr>
    </table>
    <p><a href="{{ $url }}" style="display:inline-block;background:#19e45a;color:#03210d;padding:12px 18px;border-radius:999px;font-weight:700;text-decoration:none">{{ __('ui.mail.view_booking') }}</a></p>
    <p style="font-size:12px;color:#657b7e;line-height:1.6">{{ __('ui.mail.private_link') }}</p>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>
