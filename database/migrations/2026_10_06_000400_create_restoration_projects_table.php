<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Restoration marketplace: coral, mangrove, forest/watershed projects people can fund.
        Schema::create('restoration_projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('type', 20)->index(); // coral, mangrove, forest
            $table->json('title');
            $table->json('summary')->nullable();
            $table->json('description')->nullable();
            $table->string('location');
            $table->string('partner')->nullable();
            $table->json('unit_label');            // (json) e.g. {"en": "coral frame", "id": "rangka terumbu"}
            $table->unsignedBigInteger('unit_price_idr');
            $table->unsignedInteger('target_units')->default(0);
            $table->unsignedInteger('funded_units')->default(0); // incremented only by markPaid()
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restoration_projects');
    }
};
