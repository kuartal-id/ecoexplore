<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Directory entries: accommodation, culinary, attraction, eco_shop, transport, guide.
        // `subtype` narrows it (e.g. transport: flight_concierge, ferry_concierge, car_driver;
        // guide: trek_organiser). Bookable listings have a price and price_unit.
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->index();
            $table->string('subtype', 40)->nullable();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('location');
            $table->json('summary')->nullable();     // (json) {"id","en"}
            $table->json('description')->nullable(); // (json)
            $table->json('features')->nullable();    // {"id": [...], "en": [...]}
            $table->unsignedBigInteger('price_idr')->nullable();
            $table->string('price_unit', 20)->nullable(); // night, person, day, trip, booking
            $table->boolean('is_bookable')->default(false);
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
