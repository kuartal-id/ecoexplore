# Payments

## Today (MVP)

- At checkout the customer picks **bank transfer**, **e-wallet** or **card**. The booking is
  stored with that `payment_method`, `payment_status = pending`, `status = pending`. No money
  moves and the UI says so ("no charge now").
- The customer can change the method on the confirmation page while the booking is pending.
- **Bank transfer:** if `ECOEXPLORE_BANK_*` are all set, the confirmation page shows the account
  and the booking reference to use as the transfer note; otherwise it says the team will send
  instructions. When ops sees the money arrive, an admin opens `/admin/bookings/{reference}`,
  enters the bank statement reference, ticks the confirmation box and presses **Mark paid**.
- E-wallet / card bookings stay pending until a gateway is integrated (ops can still confirm
  them manually the same way once paid by another channel).

## The one place payment state changes

`App\Services\Payments\BookingPayments`:

| Method | Called by | Effect |
|---|---|---|
| `selectMethod($booking, $method)` | checkout, confirmation page | stores the method; stays `pending` |
| `markPaid($booking, $provider, $providerRef, $amountIdr, $data, $actorId, $paidAt)` | **verified webhook** or admin | `payment_status=paid`, `paid_at`, `status=confirmed`, fulfilment, confirmation email |
| `markFailed($booking, $provider, 'failed'\|'expired')` | webhook | `payment_status=failed/expired` |
| `cancel($booking)` | admin | `status=cancelled` (not for paid bookings: refunds are a later feature) |

`markPaid()` is idempotent (row lock in a transaction; a repeat notification is a no-op),
refuses an amount that differs from `amount_idr` (`PaymentAmountMismatch`, recorded as a
`payment_amount_mismatch` event), and flags money that arrives for a cancelled booking
(`paid_after_cancellation`, stays cancelled, logged for a manual refund). Fulfilment:
restoration bookings add `quantity` to the project's `funded_units`; every purpose gets the
`BookingConfirmed` email. All transitions are written to `booking_events`.

Booking fields gateways need: `reference` (ECO-YYMMDD-XXXXXX, use it as the gateway
`order_id`), `source_site = 'ecoexplore'`, `purpose` (tour / stay / transport / concierge / guide
/ restoration), `item_type` + `item_id`, payer `contact_*` (+ `user_id` when signed in),
`amount_idr`, `currency = IDR`, `payment_method`, `payment_status`, `status`, `paid_at`,
`payment_provider`, `payment_reference`.

## Adding a gateway (suggested: Midtrans Snap)

1. Env: `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION`,
   `ECOEXPLORE_PAYMENT_GATEWAY=midtrans`. Never commit the server key.
2. "Pay now" on `bookings/show` (only when `isOpen()`): server-side create a Snap transaction
   with `order_id = reference`, `gross_amount = amount_idr`, enabled payments filtered by
   `payment_method` (card → `credit_card`; e-wallet → `gopay`, `shopeepay`, `qris`, ...; bank
   transfer → `bca_va`, `bni_va`, `bri_va`, `permata_va`, ...). Store the Snap token in
   `meta`. Redirect or open Snap.
3. Webhook: `POST /payments/midtrans/notify` (exclude it from CSRF, throttle it, add it to the
   web-root tests). In the controller:
   - verify `signature_key == sha512(order_id . status_code . gross_amount . ServerKey)`;
   - optionally re-fetch `GET /v2/{order_id}/status` from Midtrans and trust that response;
   - find the booking by `reference` (and `source_site`);
   - `settlement`, or `capture` with `fraud_status=accept` →
     `BookingPayments::markPaid($booking, 'midtrans', $transaction_id, (int) $gross_amount, ['payment_type' => ...])`;
   - `deny` / `cancel` → `markFailed(..., 'failed')`; `expire` → `markFailed(..., 'expired')`;
     `pending` → nothing;
   - catch `PaymentAmountMismatch` and still answer 200 (it is recorded for ops);
   - always answer 200 quickly once the signature is valid, so Midtrans stops retrying.
4. The **finish/return URL only shows the booking page** ("we are confirming your payment").
   It must never call `markPaid()`: return URLs can be forged or replayed.
5. Tests: signature rejection, idempotent repeat notification, amount mismatch, expire, and
   that the return URL leaves the booking pending.
