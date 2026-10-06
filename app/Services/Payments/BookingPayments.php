<?php

namespace App\Services\Payments;

use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\RestorationProject;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Throwable;

/**
 * The ONLY place that changes a booking's payment state.
 *
 * - selectMethod(): the customer picks card / bank transfer / e-wallet. Stores the method,
 *   payment_status stays `pending`. No money moves; no gateway is integrated yet.
 * - markPaid(): called by a VERIFIED payment notification (future Midtrans webhook, see
 *   docs/PAYMENTS.md) or by an admin who has confirmed a bank transfer arrived. Never call
 *   it from a browser redirect / return URL. Idempotent: a repeated notification is a no-op.
 *   Fulfilment is automatic: the booking is confirmed, restoration units are credited to
 *   the project, and the confirmation email is sent.
 * - markFailed() / cancel(): the other terminal transitions.
 */
class BookingPayments
{
    public function selectMethod(Booking $booking, string $method, ?int $actorId = null): Booking
    {
        if (! in_array($method, Booking::PAYMENT_METHODS, true)) {
            throw new InvalidArgumentException("Unknown payment method [{$method}].");
        }

        if (! $booking->isOpen()) {
            return $booking;
        }

        $from = $booking->payment_method;
        $booking->payment_method = $method;
        $booking->payment_status = Booking::PAYMENT_PENDING;
        $booking->save();

        if ($from !== $method) {
            $booking->record('payment_method_selected', ['from' => $from, 'to' => $method], $actorId);
        }

        return $booking;
    }

    /**
     * @param  string  $provider  e.g. 'midtrans', 'manual_bank_transfer'
     * @param  string|null  $providerReference  gateway transaction id / bank transfer note
     * @param  int|null  $amountIdr  amount the gateway says was paid; must equal amount_idr when given
     * @param  array<string, mixed>  $data  extra (non-secret) details to keep on the audit event
     */
    public function markPaid(
        Booking $booking,
        string $provider,
        ?string $providerReference = null,
        ?int $amountIdr = null,
        array $data = [],
        ?int $actorId = null,
        ?CarbonInterface $paidAt = null,
    ): Booking {
        $justPaid = DB::transaction(function () use ($booking, $provider, $providerReference, $amountIdr, $data, $actorId, $paidAt) {
            /** @var Booking $locked */
            $locked = Booking::whereKey($booking->getKey())->lockForUpdate()->firstOrFail();

            if ($locked->isPaid()) {
                return false; // Duplicate notification: already fulfilled.
            }

            if ($amountIdr !== null && $amountIdr !== (int) $locked->amount_idr) {
                return 'mismatch';
            }

            $now = now();
            $locked->forceFill([
                'payment_status' => Booking::PAYMENT_PAID,
                'payment_provider' => $provider,
                'payment_reference' => $providerReference,
                'paid_at' => $paidAt ?? $now,
            ]);

            $wasCancelled = $locked->status === Booking::STATUS_CANCELLED;

            if (! $wasCancelled) {
                $locked->status = Booking::STATUS_CONFIRMED;
                $locked->confirmed_at = $now;
            }

            $locked->save();
            $locked->record('paid', array_filter(['provider' => $provider, 'reference' => $providerReference] + $data), $actorId);

            if ($wasCancelled) {
                // Money arrived for a cancelled booking: keep it cancelled, flag for ops (refund).
                $locked->record('paid_after_cancellation', [], $actorId);
                Log::warning('Payment received for a cancelled booking; needs manual follow-up.', ['reference' => $locked->reference]);

                return false;
            }

            $locked->record('confirmed', [], $actorId);
            $this->fulfil($locked);

            return true;
        });

        if ($justPaid === 'mismatch') {
            // Recorded outside the (rolled back) transaction so ops can see it.
            $booking->record('payment_amount_mismatch', ['provider' => $provider, 'reported' => $amountIdr, 'expected' => $booking->amount_idr], $actorId);
            Log::warning('Payment amount mismatch; booking left unpaid.', ['reference' => $booking->reference]);

            throw new PaymentAmountMismatch("Paid amount {$amountIdr} does not match {$booking->amount_idr} for {$booking->reference}.");
        }

        $booking->refresh();

        if ($justPaid === true) {
            $this->sendConfirmation($booking);
        }

        return $booking;
    }

    public function markFailed(Booking $booking, string $provider, string $reason = 'failed', ?int $actorId = null): Booking
    {
        if (! $booking->isOpen()) {
            return $booking;
        }

        $booking->forceFill([
            'payment_status' => $reason === 'expired' ? Booking::PAYMENT_EXPIRED : Booking::PAYMENT_FAILED,
            'payment_provider' => $provider,
        ])->save();
        $booking->record('payment_'.$booking->payment_status, ['provider' => $provider], $actorId);

        return $booking;
    }

    public function cancel(Booking $booking, ?int $actorId = null, ?string $reason = null): Booking
    {
        if ($booking->isPaid() || $booking->status === Booking::STATUS_CANCELLED) {
            return $booking; // Paid bookings need a refund flow (not built yet).
        }

        $booking->forceFill(['status' => Booking::STATUS_CANCELLED, 'cancelled_at' => now()])->save();
        $booking->record('cancelled', array_filter(['reason' => $reason]), $actorId);

        return $booking;
    }

    /** Automatic fulfilment for each purpose. Runs inside the markPaid() transaction. */
    private function fulfil(Booking $booking): void
    {
        if ($booking->item_type === 'restoration_project') {
            RestorationProject::whereKey($booking->item_id)->increment('funded_units', $booking->quantity);
        }

        // Tours, stays, transport, guides: confirmation is the fulfilment for the MVP
        // (ops arranges the trip with the partner). Inventory holds come later.
    }

    private function sendConfirmation(Booking $booking): void
    {
        try {
            Mail::to($booking->contact_email)->send(new BookingConfirmed($booking));
            $booking->record('email_sent', ['mail' => 'booking_confirmed']);
        } catch (Throwable $e) {
            // The payment is recorded either way; a mail failure must not undo it.
            report($e);
            $booking->record('email_failed', ['mail' => 'booking_confirmed']);
        }
    }
}
