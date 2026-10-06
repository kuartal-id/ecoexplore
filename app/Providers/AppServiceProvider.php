<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // bookings.item_type stores these short names instead of class names.
        Relation::morphMap(Booking::ITEM_TYPES);
    }
}
