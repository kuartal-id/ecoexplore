<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Payments\BookingPayments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('payment_status');
        $q = trim((string) $request->query('q', ''));

        $bookings = Booking::query()
            ->when(in_array($status, ['pending', 'paid', 'failed', 'expired'], true), fn ($query) => $query->where('payment_status', $status))
            ->when($q !== '', fn ($query) => $query->where(fn ($w) => $w
                ->where('reference', 'like', "%{$q}%")
                ->orWhere('contact_email', 'like', "%{$q}%")
                ->orWhere('contact_name', 'like', "%{$q}%")))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'status', 'q'));
    }

    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', ['booking' => $booking->load('events.actor', 'user')]);
    }

    /**
     * Manual confirmation once ops has SEEN the money arrive (e.g. a bank transfer on the
     * statement). Goes through the same BookingPayments::markPaid() a gateway webhook uses.
     */
    public function markPaid(Request $request, Booking $booking, BookingPayments $payments): RedirectResponse
    {
        $data = $request->validate([
            'transfer_reference' => ['required', 'string', 'max:120'],
            'confirm' => ['accepted'],
        ]);

        if (! $booking->isOpen()) {
            return back()->with('error', __('ui.admin.not_open'));
        }

        $payments->markPaid(
            $booking,
            provider: 'manual_'.($booking->payment_method ?: 'bank_transfer'),
            providerReference: $data['transfer_reference'],
            actorId: $request->user()->id,
        );

        return redirect()->route('admin.bookings.show', $booking)->with('status', __('ui.admin.marked_paid'));
    }

    public function cancel(Request $request, Booking $booking, BookingPayments $payments): RedirectResponse
    {
        $data = $request->validate(['reason' => ['nullable', 'string', 'max:200']]);

        $payments->cancel($booking, $request->user()->id, $data['reason'] ?? null);

        return redirect()->route('admin.bookings.show', $booking)->with('status', __('ui.admin.cancelled'));
    }
}
