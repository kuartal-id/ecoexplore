<?php

namespace Tests\Feature;

use App\Mail\BookingReceived;
use App\Models\Booking;
use App\Models\Journey;
use App\Models\User;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SampleContentSeeder::class);
        Mail::fake();
    }

    /** @return array<string, mixed> */
    private function form(array $overrides = []): array
    {
        return array_merge([
            'contact_name' => 'Sari Wulandari',
            'contact_email' => 'sari@example.com',
            'contact_phone' => '+62 812 3456 7890',
            'quantity' => 2,
            'start_date' => now()->addDays(14)->toDateString(),
            'payment_method' => 'bank_transfer',
            'accept_terms' => '1',
        ], $overrides);
    }

    public function test_guest_can_book_a_journey_with_a_server_side_price(): void
    {
        $response = $this->post('/book/journey/rinjani-responsible-trek', $this->form([
            'amount_idr' => 1, 'unit_price_idr' => 1, 'payment_status' => 'paid', 'status' => 'confirmed',
        ]));

        $booking = Booking::sole();
        $response->assertRedirect(route('bookings.show', $booking));

        $this->assertMatchesRegularExpression('/^ECO-\d{6}-[A-HJ-NP-Z2-9]{6}$/', $booking->reference);
        $this->assertSame('ecoexplore', $booking->source_site);
        $this->assertSame('tour', $booking->purpose);
        $this->assertSame('journey', $booking->item_type);
        $this->assertSame(Journey::where('slug', 'rinjani-responsible-trek')->value('id'), $booking->item_id);
        $this->assertSame('Rinjani Responsible Trek', $booking->item_name);
        $this->assertSame(2850000, (int) $booking->unit_price_idr);
        $this->assertSame(5700000, (int) $booking->amount_idr);
        $this->assertSame('IDR', $booking->currency);
        $this->assertSame('bank_transfer', $booking->payment_method);
        $this->assertSame('pending', $booking->payment_status);
        $this->assertSame('pending', $booking->status);
        $this->assertNull($booking->paid_at);
        $this->assertNull($booking->user_id);
        $this->assertSame('sari@example.com', $booking->contact_email);
        $this->assertSame(now()->addDays(15)->toDateString(), $booking->end_date->toDateString(), '2D/1N ends the next day.');
        $this->assertGreaterThanOrEqual(40, strlen($booking->access_token));
        $this->assertTrue($booking->events()->where('type', 'created')->exists());

        Mail::assertSent(BookingReceived::class, fn ($mail) => $mail->hasTo('sari@example.com'));
    }

    public function test_ops_inbox_gets_a_copy_when_configured(): void
    {
        config(['ecoexplore.ops_email' => 'ops@example.com']);

        $this->post('/book/journey/aik-berik-geotour', $this->form());

        Mail::assertSent(BookingReceived::class, fn ($mail) => $mail->hasTo('sari@example.com') && $mail->hasBcc('ops@example.com'));
    }

    public function test_confirmation_page_shows_reference_amount_and_pending_payment(): void
    {
        $this->post('/book/journey/aik-berik-geotour', $this->form(['payment_method' => 'ewallet']));
        $booking = Booking::sole();

        $this->get(route('bookings.show', $booking))
            ->assertOk()
            ->assertSee($booking->reference)
            ->assertSee('Rp 1.600.000')
            ->assertSee(__('ui.payment_status.pending'))
            ->assertSee(__('ui.payment.ewallet'));
    }

    public function test_signed_in_user_booking_is_attached_to_the_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/book/journey/lombok-food-farm-table', $this->form());

        $booking = Booking::sole();
        $this->assertSame($user->id, $booking->user_id);
        $this->get('/account')->assertOk()->assertSee($booking->reference);
    }

    public function test_stay_is_priced_per_room_per_night(): void
    {
        $this->post('/book/listing/bamboo-eco-stay-gili-air', $this->form([
            'quantity' => 2,
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(13)->toDateString(),
        ]))->assertRedirect();

        $booking = Booking::sole();
        $this->assertSame('listing', $booking->item_type);
        $this->assertSame('stay', $booking->purpose);
        $this->assertSame(650000 * 2 * 3, (int) $booking->amount_idr);
    }

    public function test_stay_requires_an_end_date_and_is_capped(): void
    {
        $this->post('/book/listing/bamboo-eco-stay-gili-air', $this->form())->assertSessionHasErrors('end_date');
        $this->post('/book/listing/bamboo-eco-stay-gili-air', $this->form([
            'end_date' => now()->addDays(60)->toDateString(),
        ]))->assertSessionHasErrors('end_date');
        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_concierge_transport_and_guide_bookings_have_their_purpose(): void
    {
        $this->post('/book/listing/flight-concierge-lombok', $this->form(['quantity' => 1]));
        $this->post('/book/listing/car-driver-full-day', $this->form(['quantity' => 2]));
        $this->post('/book/listing/rinjani-trekking-organiser', $this->form(['quantity' => 3]));

        $this->assertSame(['concierge', 'transport', 'guide'], Booking::orderBy('id')->pluck('purpose')->all());
        $this->assertSame([150000, 1500000, 7800000], Booking::orderBy('id')->pluck('amount_idr')->map(fn ($a) => (int) $a)->all());
    }

    public function test_restoration_contribution_needs_no_date(): void
    {
        $this->post('/book/restore/east-lombok-mangrove-planting', $this->form(['quantity' => 10, 'start_date' => null]))->assertRedirect();

        $booking = Booking::sole();
        $this->assertSame('restoration', $booking->purpose);
        $this->assertSame('restoration_project', $booking->item_type);
        $this->assertSame(1000000, (int) $booking->amount_idr);
        $this->assertNull($booking->start_date);
    }

    public function test_validation(): void
    {
        $this->post('/book/journey/rinjani-responsible-trek', $this->form([
            'quantity' => 1, // min 2 for this trek
            'start_date' => now()->toDateString(),
            'payment_method' => 'bitcoin',
            'accept_terms' => null,
            'contact_email' => 'not-an-email',
        ]))->assertSessionHasErrors(['quantity', 'start_date', 'payment_method', 'accept_terms', 'contact_email']);

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_bookings_are_private(): void
    {
        $this->post('/book/journey/aik-berik-geotour', $this->form());
        $booking = Booking::sole();

        // A different browser (fresh session), another user, and a wrong token all get 404.
        $this->flushSession();
        $this->get(route('bookings.show', $booking))->assertNotFound();
        $this->get(route('bookings.show', $booking).'?t=wrong')->assertNotFound();
        $this->actingAs(User::factory()->create())->get(route('bookings.show', $booking))->assertNotFound();
        $this->post(route('bookings.payment-method', $booking), ['payment_method' => 'card'])->assertNotFound();

        // The private link from the email works, and so does an admin.
        auth()->logout();
        $this->flushSession();
        $this->get(route('bookings.show', $booking).'?t='.$booking->access_token)->assertOk();
        $this->flushSession();
        $this->actingAs(User::factory()->admin()->create())->get(route('bookings.show', $booking))->assertOk();
    }

    public function test_access_token_is_never_serialised(): void
    {
        $this->post('/book/journey/aik-berik-geotour', $this->form());

        $this->assertArrayNotHasKey('access_token', Booking::sole()->toArray());
    }

    public function test_customer_can_change_the_payment_method_but_it_never_marks_paid(): void
    {
        $this->post('/book/journey/aik-berik-geotour', $this->form());
        $booking = Booking::sole();

        $this->post(route('bookings.payment-method', $booking), ['payment_method' => 'card'])
            ->assertRedirect(route('bookings.show', $booking));

        $booking->refresh();
        $this->assertSame('card', $booking->payment_method);
        $this->assertSame('pending', $booking->payment_status);
        $this->assertSame('pending', $booking->status);
        $this->assertNull($booking->paid_at);
        $this->assertTrue($booking->events()->where('type', 'payment_method_selected')->exists());

        $this->post(route('bookings.payment-method', $booking), ['payment_method' => 'paid'])->assertSessionHasErrors('payment_method');
    }

    public function test_no_route_lets_a_browser_mark_a_booking_paid(): void
    {
        $this->post('/book/journey/aik-berik-geotour', $this->form());
        $booking = Booking::sole();

        foreach (['/bookings/'.$booking->reference.'/paid', '/bookings/'.$booking->reference.'/confirm', '/payments/return?order_id='.$booking->reference.'&transaction_status=settlement'] as $url) {
            $this->get($url);
            $this->post($url, ['payment_status' => 'paid']);
        }

        $this->assertSame('pending', $booking->fresh()->payment_status);
    }

    public function test_references_are_unique(): void
    {
        $refs = collect(range(1, 300))->map(fn () => Booking::newReference());

        $this->assertSame(300, $refs->unique()->count());
        $refs->each(fn ($r) => $this->assertStringStartsWith('ECO-'.now()->format('ymd').'-', $r));
    }
}
