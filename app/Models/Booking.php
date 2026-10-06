<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * An order for anything sold on Ecoexplore. See the bookings migration and docs/PAYMENTS.md.
 * payment_status/status/paid_at are guarded: only App\Services\Payments\BookingPayments
 * changes them.
 */
class Booking extends Model
{
    public const SOURCE_SITE = 'ecoexplore';

    public const REFERENCE_PREFIX = 'ECO';

    public const PAYMENT_METHODS = ['card', 'bank_transfer', 'ewallet'];

    public const PAYMENT_PENDING = 'pending';

    public const PAYMENT_PAID = 'paid';

    public const PAYMENT_FAILED = 'failed';

    public const PAYMENT_EXPIRED = 'expired';

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_CANCELLED = 'cancelled';

    /** item_type values => model classes (also the morph map). */
    public const ITEM_TYPES = [
        'journey' => Journey::class,
        'listing' => Listing::class,
        'restoration_project' => RestorationProject::class,
    ];

    protected $fillable = [
        'purpose', 'item_type', 'item_id', 'item_name', 'user_id',
        'contact_name', 'contact_email', 'contact_phone',
        'start_date', 'end_date', 'quantity', 'unit_price_idr', 'amount_idr',
        'payment_method', 'notes', 'meta', 'locale',
    ];

    protected $hidden = ['access_token'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'paid_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'meta' => 'array',
            'quantity' => 'integer',
            'unit_price_idr' => 'integer',
            'amount_idr' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->reference ??= static::newReference();
            $booking->source_site ??= static::SOURCE_SITE;
            $booking->access_token ??= Str::random(48);
            $booking->payment_status ??= static::PAYMENT_PENDING;
            $booking->status ??= static::STATUS_PENDING;
            $booking->currency ??= 'IDR';
        });
    }

    /** ECO-YYMMDD-XXXXXX (no 0/O/1/I), unique. Fits Midtrans' 50-char order_id. */
    public static function newReference(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $suffix = '';
            for ($i = 0; $i < 6; $i++) {
                $suffix .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }
            $reference = static::REFERENCE_PREFIX.'-'.now()->format('ymd').'-'.$suffix;
        } while (static::where('reference', $reference)->exists());

        return $reference;
    }

    public function getRouteKeyName(): string
    {
        return 'reference';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(BookingEvent::class)->orderBy('id');
    }

    public function item(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isOpen(): bool
    {
        return $this->payment_status === self::PAYMENT_PENDING && $this->status === self::STATUS_PENDING;
    }

    public function record(string $type, array $data = [], ?int $actorId = null): BookingEvent
    {
        return $this->events()->create([
            'type' => $type,
            'data' => $data ?: null,
            'actor_user_id' => $actorId,
        ]);
    }
}
