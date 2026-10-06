<div class="table-wrap">
<table class="table">
    <thead><tr><th>{{ __('ui.booking.reference') }}</th><th>{{ __('ui.booking.item') }}</th><th>{{ __('ui.checkout.contact') }}</th><th>{{ __('ui.booking.date') }}</th><th>{{ __('ui.booking.total') }}</th><th>{{ __('ui.checkout.payment') }}</th><th>Status</th></tr></thead>
    <tbody>
    @forelse ($bookings as $b)
        <tr>
            <td><a class="link" href="{{ route('admin.bookings.show', $b) }}">{{ $b->reference }}</a><br><small class="muted">{{ $b->created_at->format('Y-m-d H:i') }}</small></td>
            <td>{{ $b->item_name }}<br><small class="muted">{{ __('ui.purpose.'.$b->purpose) }} × {{ $b->quantity }}</small></td>
            <td>{{ $b->contact_name }}<br><small class="muted">{{ $b->contact_email }}</small></td>
            <td>{{ $b->start_date?->format('Y-m-d') ?? '—' }}</td>
            <td>{{ idr($b->amount_idr) }}</td>
            <td>{{ $b->payment_method ? __('ui.payment.'.$b->payment_method) : '—' }}<br><span class="badge badge-{{ $b->payment_status }}">{{ __('ui.payment_status.'.$b->payment_status) }}</span></td>
            <td><span class="badge badge-{{ $b->status }}">{{ __('ui.status.'.$b->status) }}</span></td>
        </tr>
    @empty
        <tr><td colspan="7" class="muted">{{ __('ui.admin.no_bookings') }}</td></tr>
    @endforelse
    </tbody>
</table>
</div>
