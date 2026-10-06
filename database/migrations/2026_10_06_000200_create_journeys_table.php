<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Curated tour packages ("journeys"). Text columns marked (json) hold
        // {"id": "...", "en": "..."} so content can be shown in Indonesian or English.
        Schema::create('journeys', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title');                 // (json)
            $table->json('tagline')->nullable();   // (json)
            $table->json('summary')->nullable();   // (json)
            $table->json('description')->nullable(); // (json)
            $table->string('category', 40)->index(); // dive, trek, highland, geotour, food, culture
            $table->string('region');
            $table->unsignedTinyInteger('duration_days')->default(1);
            $table->unsignedTinyInteger('duration_nights')->default(0);
            $table->unsignedBigInteger('price_idr'); // per person, whole rupiah
            $table->unsignedSmallInteger('min_pax')->default(1);
            $table->unsignedSmallInteger('max_pax')->default(12);
            $table->string('difficulty', 20)->default('easy'); // easy, moderate, challenging
            $table->string('image')->nullable();
            $table->json('itinerary')->nullable(); // {"id": [{"title","body"}], "en": [...]}
            $table->json('includes')->nullable();  // {"id": ["..."], "en": [...]}
            $table->json('excludes')->nullable();
            $table->json('impact')->nullable();    // (json) community / regenerative note
            $table->string('community_partner')->nullable();
            $table->unsignedInteger('carbon_kg_pp')->nullable(); // illustrative on-trip estimate
            $table->boolean('is_published')->default(true)->index();
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
