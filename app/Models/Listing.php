<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasTranslations;

    /** Directory types => URL segment. */
    public const TYPES = [
        'accommodation' => 'accommodations',
        'culinary' => 'culinary',
        'attraction' => 'attractions',
        'eco_shop' => 'eco-shops',
        'transport' => 'transport',
        'guide' => 'guides',
    ];

    /** Booking purpose per listing type (stored on bookings.purpose). */
    public const PURPOSES = [
        'accommodation' => 'stay',
        'transport' => 'transport',
        'guide' => 'guide',
        'attraction' => 'activity',
        'culinary' => 'activity',
        'eco_shop' => 'shop',
    ];

    public const PRICE_UNITS = ['night', 'person', 'day', 'trip', 'booking'];

    protected array $translatable = ['summary', 'description', 'features'];

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_bookable' => 'boolean',
            'price_idr' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public static function typeFromSegment(string $segment): ?string
    {
        $type = array_search($segment, self::TYPES, true);

        return $type === false ? null : $type;
    }

    public function segment(): string
    {
        return self::TYPES[$this->type] ?? 'accommodations';
    }

    public function purpose(): string
    {
        if ($this->subtype && str_contains($this->subtype, 'concierge')) {
            return 'concierge';
        }

        return self::PURPOSES[$this->type] ?? 'service';
    }

    public function canBeBooked(): bool
    {
        return $this->is_bookable && $this->price_idr > 0;
    }

    public static function labelForSubtype(?string $subtype): string
    {
        if (! $subtype) {
            return '';
        }

        $key = 'ui.subtype.'.$subtype;

        return \Illuminate\Support\Facades\Lang::has($key) ? __($key) : \Illuminate\Support\Str::headline($subtype);
    }

    public function subtypeLabel(): string
    {
        return self::labelForSubtype($this->subtype ?: $this->type);
    }

    /** Stays are priced per night and need a check-out date. */
    public function isStay(): bool
    {
        return $this->type === 'accommodation';
    }
}
