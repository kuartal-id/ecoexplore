<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Records which one-off content seeders have run (see SampleContentSeeder), so
        // app:post-deploy can call them on every release without re-creating content
        // an admin has since edited or deleted.
        Schema::create('seed_markers', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->timestamp('ran_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seed_markers');
    }
};
