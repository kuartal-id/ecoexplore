<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kuartal ID (id.kuartal.id) `sub` claim. Null for local email/password accounts
            // that have never signed in with Kuartal ID.
            $table->string('kuartal_id')->nullable()->unique()->after('id');
            $table->string('avatar_url', 2048)->nullable()->after('email');
            $table->string('phone', 40)->nullable()->after('avatar_url');
            $table->string('locale', 5)->nullable()->after('phone');
            // Granted only with `php artisan ecoexplore:admin <email>`.
            $table->boolean('is_admin')->default(false)->after('locale');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['kuartal_id']);
            $table->dropColumn(['kuartal_id', 'avatar_url', 'phone', 'locale', 'is_admin']);
        });
    }
};
