<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItineraryItem extends Model
{
    protected $guarded = ['id'];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    /** Resolve the referenced journey or listing (any publish state, so saved stops never vanish). */
    public function item(): Journey|Listing|null
    {
        return match ($this->item_type) {
            'journey' => Journey::find($this->item_id),
            'listing' => Listing::find($this->item_id),
            default => null,
        };
    }
}
