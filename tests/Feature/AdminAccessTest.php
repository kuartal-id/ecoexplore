<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Journey;
use App\Models\Listing;
use App\Models\User;
use App\Services\BookingService;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SampleContentSeeder::class);
        Mail::fake();
    }

    private function booking(string $method = 'bank_transfer'): Booking
    {
        return app(BookingService::class)->create(BookingService::findItem('journey', 'aik-berik-geotour'), [
            'contact_name' => 'Rina', 'contact_email' => 'rina@example.com', 'contact_phone' => '0812345678',
            'quantity' => 2, 'start_date' => now()->addWeek()->toDateString(), 'end_date' => null,
            'payment_method' => $method, 'notes' => null,
        ], null);
    }

    /** @return array<string, array{0: string, 1: string}> */
    public static function adminRoutes(): array
    {
        return [
            'dashboard' => ['get', '/admin'],
            'bookings' => ['get', '/admin/bookings'],
            'journeys' => ['get', '/admin/journeys'],
            'new journey' => ['get', '/admin/journeys/create'],
            'store journey' => ['post', '/admin/journeys'],
            'listings' => ['get', '/admin/listings'],
            'new listing' => ['get', '/admin/listings/create'],
            'store listing' => ['post', '/admin/listings'],
        ];
    }

    #[DataProvider('adminRoutes')]
    public function test_guests_are_sent_to_login(string $method, string $uri): void
    {
        $this->{$method}($uri)->assertRedirect(route('login'));
    }

    #[DataProvider('adminRoutes')]
    public function test_non_admins_get_403(string $method, string $uri): void
    {
        $this->actingAs(User::factory()->create())->{$method}($uri)->assertForbidden();
    }

    #[DataProvider('adminRoutes')]
    public function test_admins_get_in(string $method, string $uri): void
    {
        $response = $this->actingAs(User::factory()->admin()->create())->{$method}($uri);

        $method === 'get' ? $response->assertOk() : $response->assertSessionHasErrors();
    }

    public function test_non_admin_cannot_mark_paid(): void
    {
        $booking = $this->booking();

        $this->actingAs(User::factory()->create())
            ->post(route('admin.bookings.mark-paid', $booking), ['transfer_reference' => 'x', 'confirm' => '1'])
            ->assertForbidden();
        $this->assertSame('pending', $booking->fresh()->payment_status);
    }

    public function test_admin_sees_bookings_and_marks_a_bank_transfer_paid(): void
    {
        $admin = User::factory()->admin()->create();
        $booking = $this->booking();

        $this->actingAs($admin)->get('/admin/bookings')->assertOk()->assertSee($booking->reference);
        $this->get(route('admin.bookings.show', $booking))->assertOk()->assertSee('rina@example.com');

        $this->post(route('admin.bookings.mark-paid', $booking), ['transfer_reference' => ''])
            ->assertSessionHasErrors(['transfer_reference', 'confirm']);
        $this->assertSame('pending', $booking->fresh()->payment_status);

        $this->post(route('admin.bookings.mark-paid', $booking), ['transfer_reference' => 'BCA 06/10 #7781', 'confirm' => '1'])
            ->assertRedirect(route('admin.bookings.show', $booking));

        $booking->refresh();
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('confirmed', $booking->status);
        $this->assertSame('manual_bank_transfer', $booking->payment_provider);
        $this->assertSame('BCA 06/10 #7781', $booking->payment_reference);
        $this->assertSame($admin->id, $booking->events()->where('type', 'paid')->value('actor_user_id'));
        Mail::assertSent(BookingConfirmed::class);

        $this->get('/admin/bookings?payment_status=paid')->assertSee($booking->reference);
    }

    public function test_admin_can_cancel_an_open_booking(): void
    {
        $booking = $this->booking();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.bookings.cancel', $booking), ['reason' => 'Customer asked'])
            ->assertRedirect();

        $this->assertSame('cancelled', $booking->fresh()->status);
    }

    public function test_admin_journey_crud(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $payload = [
            'slug' => 'tetebatu-rice-terraces', 'title_id' => 'Sawah Tetebatu', 'title_en' => 'Tetebatu Rice Terraces',
            'summary_id' => 'Ringkasan', 'summary_en' => 'Summary',
            'itinerary_id' => "Pagi\nJalan kaki di sawah\n\nSiang\nMakan siang", 'itinerary_en' => "Morning\nRice field walk\n\nNoon\nLunch",
            'includes_id' => "Pemandu\nMakan siang", 'includes_en' => "Guide\nLunch",
            'category' => 'heritage', 'region' => 'Tetebatu', 'duration_days' => 1, 'duration_nights' => 0,
            'price_idr' => 650000, 'min_pax' => 1, 'max_pax' => 8, 'difficulty' => 'easy', 'is_published' => '1',
        ];

        $this->post('/admin/journeys', $payload)->assertRedirect();
        $journey = Journey::where('slug', 'tetebatu-rice-terraces')->firstOrFail();
        $this->assertSame('Tetebatu Rice Terraces', $journey->title['en']);
        $this->assertSame('Pagi', $journey->itinerary['id'][0]['title']);
        $this->assertCount(2, $journey->itinerary['en']);
        $this->assertSame(['Guide', 'Lunch'], $journey->includes['en']);
        $this->get('/journeys/tetebatu-rice-terraces')->assertOk();
        $this->get(route('admin.journeys.edit', $journey))->assertOk()->assertSee('Rice field walk');

        $this->put(route('admin.journeys.update', $journey), ['price_idr' => 700000, 'is_published' => null] + $payload)->assertRedirect();
        $this->assertSame(700000, (int) $journey->fresh()->price_idr);
        $this->assertFalse($journey->fresh()->is_published);
        $this->get('/journeys/tetebatu-rice-terraces')->assertNotFound();

        $this->delete(route('admin.journeys.destroy', $journey))->assertRedirect(route('admin.journeys.index'));
        $this->assertModelMissing($journey);
    }

    public function test_admin_listing_crud(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $payload = [
            'type' => 'transport', 'subtype' => 'scooter_rental', 'slug' => 'kuta-scooter-rental', 'name' => 'Kuta Scooter Rental',
            'location' => 'Kuta', 'summary_id' => 'Sewa motor', 'summary_en' => 'Scooter hire',
            'features_id' => "Helm\nAsuransi", 'features_en' => "Helmet\nInsurance",
            'price_idr' => 90000, 'price_unit' => 'day', 'is_bookable' => '1', 'is_published' => '1',
        ];

        $this->post('/admin/listings', $payload)->assertRedirect();
        $listing = Listing::where('slug', 'kuta-scooter-rental')->firstOrFail();
        $this->assertSame(['Helmet', 'Insurance'], $listing->features['en']);
        $this->get('/directory/transport/kuta-scooter-rental')->assertOk()->assertSee('Scooter Rental');
        $this->get('/book/listing/kuta-scooter-rental')->assertOk();

        $this->put(route('admin.listings.update', $listing), ['is_bookable' => null] + $payload)->assertRedirect();
        $this->get('/book/listing/kuta-scooter-rental')->assertNotFound();

        $this->delete(route('admin.listings.destroy', $listing))->assertRedirect();
        $this->assertModelMissing($listing);
    }

    public function test_admin_can_upload_and_clear_a_journey_image(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        $journey = Journey::factory()->create(['image' => null]);

        // 1x1 PNG written by hand so the test does not depend on GD.
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $tmp = tempnam(sys_get_temp_dir(), 'up');
        file_put_contents($tmp, $png);
        $file = new \Illuminate\Http\UploadedFile($tmp, 'photo.png', 'image/png', null, true);

        $this->post(route('admin.journeys.image', $journey), ['image' => $file])->assertRedirect(route('admin.journeys.edit', $journey));

        $image = $journey->fresh()->image;
        $this->assertNotNull($image);
        $this->assertStringStartsWith('assets/uploads/journeys/', $image);
        $this->assertFileExists(public_path($image));

        $this->delete(route('admin.journeys.image.remove', $journey))->assertRedirect(route('admin.journeys.edit', $journey));
        $this->assertNull($journey->fresh()->image);

        @unlink(public_path($image));
    }

    public function test_admin_command_grants_and_revokes(): void
    {
        $user = User::factory()->create(['email' => 'ops@example.com']);

        $this->artisan('ecoexplore:admin', ['email' => 'ops@example.com'])->assertSuccessful();
        $this->assertTrue($user->fresh()->is_admin);

        $this->artisan('ecoexplore:admin', ['email' => 'ops@example.com', '--revoke' => true])->assertSuccessful();
        $this->assertFalse($user->fresh()->is_admin);

        $this->artisan('ecoexplore:admin', ['email' => 'missing@example.com'])->assertFailed();
    }
}
