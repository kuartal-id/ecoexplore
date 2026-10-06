<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Journey;
use App\Models\RestorationProject;
use App\Services\BookingService;
use App\Services\Payments\BookingPayments;
use App\Services\Payments\PaymentAmountMismatch;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/** BookingPayments is the only place payment state changes (gateway webhook or admin). */
class BookingPaymentsTest extends TestCase
{
    use RefreshDatabase;

    private BookingPayments $payments;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SampleContentSeeder::class);
        Mail::fake();
        $this->payments = app(BookingPayments::class);
    }

    private function book(string $kind, string $slug, int $quantity = 2, string $method = 'bank_transfer'): Booking
    {
        return app(BookingService::class)->create(BookingService::findItem($kind, $slug), [
            'contact_name' => 'Budi', 'contact_email' => 'budi@example.com', 'contact_phone' => '0812345678',
            'quantity' => $quantity, 'start_date' => now()->addWeek()->toDateString(), 'end_date' => null,
            'payment_method' => $method, 'notes' => null,
        ], null);
    }

    public function test_mark_paid_confirms_and_sends_the_confirmation_email(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');

        $this->payments->markPaid($booking, 'midtrans', 'TX-123', 1600000);

        $booking->refresh();
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('confirmed', $booking->status);
        $this->assertSame('midtrans', $booking->payment_provider);
        $this->assertSame('TX-123', $booking->payment_reference);
        $this->assertNotNull($booking->paid_at);
        $this->assertNotNull($booking->confirmed_at);
        $types = $booking->events()->orderBy('id')->pluck('type')->all();
        $this->assertSame('created', $types[0]);
        $this->assertSame(['paid', 'confirmed', 'email_sent'], array_slice($types, -3));
        Mail::assertSent(BookingConfirmed::class, fn ($m) => $m->hasTo('budi@example.com'));
    }

    public function test_mark_paid_is_idempotent(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');

        $this->payments->markPaid($booking, 'midtrans', 'TX-1');
        $paidAt = $booking->fresh()->paid_at;
        $this->travel(5)->minutes();
        $this->payments->markPaid($booking->fresh(), 'midtrans', 'TX-1');

        $this->assertEquals($paidAt, $booking->fresh()->paid_at);
        $this->assertSame(1, $booking->events()->where('type', 'paid')->count());
        Mail::assertSent(BookingConfirmed::class, 1);
    }

    public function test_amount_mismatch_leaves_the_booking_unpaid_and_is_recorded(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');

        try {
            $this->payments->markPaid($booking, 'midtrans', 'TX-9', 1000);
            $this->fail('Expected PaymentAmountMismatch');
        } catch (PaymentAmountMismatch) {
        }

        $this->assertSame('pending', $booking->fresh()->payment_status);
        $this->assertTrue($booking->events()->where('type', 'payment_amount_mismatch')->exists());
        Mail::assertNotSent(BookingConfirmed::class);
    }

    public function test_paid_restoration_contribution_credits_the_project(): void
    {
        $booking = $this->book('restore', 'rinjani-watershed-trees', 25);
        $project = RestorationProject::where('slug', 'rinjani-watershed-trees')->firstOrFail();

        $this->assertSame(0, (int) $project->fresh()->funded_units, 'Unpaid contributions do not count.');

        $this->payments->markPaid($booking, 'manual_bank_transfer', 'BCA 06/10');
        $this->payments->markPaid($booking->fresh(), 'manual_bank_transfer', 'BCA 06/10');

        $this->assertSame(25, (int) $project->fresh()->funded_units);
    }

    public function test_payment_for_a_cancelled_booking_is_flagged_not_confirmed(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');
        $this->payments->cancel($booking);

        $this->payments->markPaid($booking->fresh(), 'midtrans', 'TX-late');

        $booking->refresh();
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('cancelled', $booking->status);
        $this->assertTrue($booking->events()->where('type', 'paid_after_cancellation')->exists());
        Mail::assertNotSent(BookingConfirmed::class);
    }

    public function test_select_method_keeps_payment_pending(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');

        foreach (Booking::PAYMENT_METHODS as $method) {
            $this->payments->selectMethod($booking, $method);
            $this->assertSame($method, $booking->fresh()->payment_method);
            $this->assertSame('pending', $booking->fresh()->payment_status);
        }

        $this->expectException(\InvalidArgumentException::class);
        $this->payments->selectMethod($booking, 'cash');
    }

    public function test_paid_booking_cannot_be_cancelled_or_failed(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');
        $this->payments->markPaid($booking, 'midtrans');

        $this->payments->cancel($booking->fresh());
        $this->payments->markFailed($booking->fresh(), 'midtrans');

        $this->assertSame('paid', $booking->fresh()->payment_status);
        $this->assertSame('confirmed', $booking->fresh()->status);
    }

    public function test_mark_failed_and_expired(): void
    {
        $a = $this->book('journey', 'aik-berik-geotour');
        $b = $this->book('journey', 'aik-berik-geotour');

        $this->payments->markFailed($a, 'midtrans');
        $this->payments->markFailed($b, 'midtrans', 'expired');

        $this->assertSame('failed', $a->fresh()->payment_status);
        $this->assertSame('expired', $b->fresh()->payment_status);
    }

    public function test_price_change_after_booking_does_not_change_the_amount(): void
    {
        $booking = $this->book('journey', 'aik-berik-geotour');
        Journey::where('slug', 'aik-berik-geotour')->update(['price_idr' => 9_999_999]);

        $this->assertSame(1600000, (int) $booking->fresh()->amount_idr);
    }
}
