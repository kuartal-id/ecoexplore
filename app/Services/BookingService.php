<?php

namespace App\Services;

use App\Mail\BookingReceived;
use App\Models\Booking;
use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use App\Models\User;
use App\Services\Payments\BookingPayments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Creates bookings from the checkout form. Prices are always computed here from the
 * catalogue -- never taken from the browser.
 */
class BookingService
{
    public function __construct(private BookingPayments $payments) {}

    /** Map the URL "kind" to the item model. */
    public static function findItem(string $kind, string $slug): ?Model
    {
        $item = match ($kind) {
            'journey' => Journey::published()->where('slug', $slug)->first(),
            'listing' => Listing::published()->where('slug', $slug)->first(),
            'restore' => RestorationProject::published()->where('slug', $slug)->first(),
            default => null,
        };

        if ($item instanceof Listing && ! $item->canBeBooked()) {
            return null;
        }

        return $item;
    }

    public static function itemType(Model $item): string
    {
        return array_search($item::class, Booking::ITEM_TYPES, true) ?: 'journey';
    }

    /** @return array{unit: int, quantity: int, amount: int, nights: int|null} */
    public static function price(Model $item, int $quantity, ?string $start = null, ?string $end = null): array
    {
        $nights = null;

        if ($item instanceof Listing && $item->isStay() && $start && $end) {
            $nights = max(1, (int) Carbon::parse($start)->diffInDays(Carbon::parse($end)));
        }

        $unit = match (true) {
            $item instanceof Journey => (int) $item->price_idr,
            $item instanceof Listing => (int) $item->price_idr,
            $item instanceof RestorationProject => (int) $item->unit_price_idr,
            default => 0,
        };

        // Stays: price per room-night x rooms x nights. Everything else: unit x quantity.
        $multiplier = $nights ? $nights * $quantity : $quantity;

        return ['unit' => $unit, 'quantity' => $quantity, 'amount' => $unit * $multiplier, 'nights' => $nights];
    }

    /** @param  array<string, mixed>  $data  validated checkout input */
    public function create(Model $item, array $data, ?User $user): Booking
    {
        $price = self::price($item, (int) $data['quantity'], $data['start_date'] ?? null, $data['end_date'] ?? null);

        $booking = DB::transaction(function () use ($item, $data, $user, $price) {
            $booking = Booking::create([
                'purpose' => $item->purpose(),
                'item_type' => self::itemType($item),
                'item_id' => $item->getKey(),
                'item_name' => $item instanceof Listing ? $item->name : $item->tr('title', 'en'),
                'user_id' => $user?->id,
                'contact_name' => $data['contact_name'],
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'] ?? null,
                'start_date' => $data['start_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'quantity' => $price['quantity'],
                'unit_price_idr' => $price['unit'],
                'amount_idr' => $price['amount'],
                'notes' => $data['notes'] ?? null,
                'meta' => array_filter(['nights' => $price['nights'], 'price_unit' => $item instanceof Listing ? $item->price_unit : null]),
                'locale' => app()->getLocale(),
            ]);

            $booking->record('created', ['amount_idr' => $booking->amount_idr], $user?->id);

            if (! empty($data['payment_method'])) {
                $this->payments->selectMethod($booking, $data['payment_method'], $user?->id);
            }

            return $booking;
        });

        try {
            $mail = Mail::to($booking->contact_email);
            if ($ops = config('ecoexplore.ops_email')) {
                $mail->bcc($ops); // Ops gets a copy of every new booking.
            }
            $mail->send(new BookingReceived($booking));
            $booking->record('email_sent', ['mail' => 'booking_received']);
        } catch (Throwable $e) {
            report($e);
        }

        return $booking->refresh();
    }
}
