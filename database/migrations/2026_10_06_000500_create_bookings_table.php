<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row per order (tour, stay, transport, guide, restoration...). Shaped for a later
        // central Midtrans integration (Kuartal Financial Group): `reference` is the order_id
        // sent to the gateway, `source_site` tells the central service which site owns it,
        // `amount_idr` is the gross_amount. Only App\Services\Payments\BookingPayments::markPaid()
        // may move payment_status to `paid` -- never a browser redirect. See docs/PAYMENTS.md.
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 40)->unique();          // ECO-261006-7KQ2XD
            $table->string('source_site', 40)->default('ecoexplore')->index();
            $table->string('purpose', 30)->index();             // tour, stay, transport, guide, restoration, concierge...
            $table->string('item_type', 40);                    // journey, listing, restoration_project
            $table->unsignedBigInteger('item_id');
            $table->string('item_name');                        // snapshot at booking time
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone', 40)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('quantity')->default(1);    // travellers / nights / units
            $table->unsignedBigInteger('unit_price_idr');
            $table->unsignedBigInteger('amount_idr');           // total, whole rupiah
            $table->char('currency', 3)->default('IDR');
            $table->string('payment_method', 30)->nullable();   // card, bank_transfer, ewallet
            $table->string('payment_status', 20)->default('pending')->index(); // pending, paid, failed, expired, refunded
            $table->string('status', 20)->default('pending')->index();         // pending, confirmed, cancelled, completed
            $table->string('payment_provider', 40)->nullable(); // e.g. midtrans, manual_bank_transfer
            $table->string('payment_reference')->nullable();    // gateway transaction id
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            $table->string('locale', 5)->default('id');
            $table->string('access_token', 64);                 // lets a guest re-open their confirmation
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });

        Schema::create('booking_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->string('type', 40); // created, payment_method_selected, paid, confirmed, cancelled, email_sent
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('data')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_events');
        Schema::dropIfExists('bookings');
    }
};
