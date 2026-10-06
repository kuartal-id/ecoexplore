<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\Payments\BookingPayments;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function show(Request $request, Booking $booking): View
    {
        $this->authorizeAccess($request, $booking);

        return view('bookings.show', [
            'booking' => $booking,
            'item' => $booking->item,
            'bank' => array_filter(config('ecoexplore.bank_transfer', [])),
        ]);
    }

    /**
     * Change the chosen payment method while the booking is still pending. This only
     * records the customer's choice; it never marks anything as paid.
     */
    public function paymentMethod(Request $request, Booking $booking, BookingPayments $payments): RedirectResponse
    {
        $this->authorizeAccess($request, $booking);

        $data = $request->validate(['payment_method' => ['required', Rule::in(Booking::PAYMENT_METHODS)]]);

        $payments->selectMethod($booking, $data['payment_method'], $request->user()?->id);

        return redirect()->route('bookings.show', $booking)->with('status', __('ui.booking.method_saved'));
    }

    /**
     * Owner (signed in), admin, this browser's session (just booked), or the private link
     * from the booking email (?t=access_token).
     */
    private function authorizeAccess(Request $request, Booking $booking): void
    {
        $user = $request->user();

        if ($user && ($user->id === $booking->user_id || $user->isAdmin())) {
            return;
        }

        if (in_array($booking->reference, (array) $request->session()->get('bookings.access', []), true)) {
            return;
        }

        $token = $request->query('t');

        if (is_string($token) && $token !== '' && hash_equals($booking->access_token, $token)) {
            $request->session()->push('bookings.access', $booking->reference);

            return;
        }

        abort(404);
    }
}
