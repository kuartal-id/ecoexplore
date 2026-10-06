<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 120);
            $table->date('start_date')->nullable();
            $table->timestamps();
        });

        Schema::create('itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained()->cascadeOnDelete();
            $table->string('item_type', 20); // journey | listing
            $table->unsignedBigInteger('item_id');
            $table->unsignedSmallInteger('day')->default(1);
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('notes', 500)->nullable();
            $table->timestamps();

            $table->unique(['itinerary_id', 'item_type', 'item_id']);
            $table->index(['itinerary_id', 'day']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_items');
        Schema::dropIfExists('itineraries');
    }
};
