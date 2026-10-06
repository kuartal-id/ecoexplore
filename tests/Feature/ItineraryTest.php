<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\Listing;
use App\Models\User;
use Database\Seeders\IndonesiaContentSeeder;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItineraryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([\Database\Seeders\SampleContentSeeder::class, \Database\Seeders\IndonesiaContentSeeder::class]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/account/itineraries')->assertRedirect(route('login'));
        $this->post('/account/itineraries', ['title' => 'Trip'])->assertRedirect(route('login'));
    }

    public function test_user_can_create_an_itinerary(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/itineraries', ['title' => 'Komodo week', 'start_date' => '2026-11-01'])
            ->assertRedirect();

        $it = $user->itineraries()->first();
        $this->assertSame('Komodo week', $it->title);
        $this->assertSame('2026-11-01', $it->start_date->toDateString());
    }

    public function test_itinerary_title_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/account/itineraries', ['title' => ''])
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('itineraries', 0);
    }

    public function test_user_can_add_journey_and_listing_stops(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan A']);
        $journey = Journey::where('slug', 'komodo-island-safari')->firstOrFail();
        $listing = Listing::where('slug', 'ubud-garden-villa')->firstOrFail();

        $this->actingAs($user)->post(route('itineraries.items.store', $itin), [
            'item_type' => 'journey', 'item_id' => $journey->id, 'day' => 1,
        ])->assertRedirect();

        $this->actingAs($user)->post(route('itineraries.items.store', $itin), [
            'item_type' => 'listing', 'item_id' => $listing->id, 'day' => 2,
        ])->assertRedirect();

        $this->assertSame(2, $itin->items()->count());
        $this->assertSame(1, $itin->items()->where('day', 1)->count());
        $this->assertSame(1, $itin->items()->where('day', 2)->count());
    }

    public function test_duplicate_stop_is_not_added_twice(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan B']);
        $journey = Journey::published()->firstOrFail();

        $payload = ['item_type' => 'journey', 'item_id' => $journey->id];

        $this->actingAs($user)->post(route('itineraries.items.store', $itin), $payload)->assertRedirect();
        $this->actingAs($user)->post(route('itineraries.items.store', $itin), $payload)->assertRedirect();

        $this->assertSame(1, $itin->items()->count());
    }

    public function test_unknown_or_unpublished_item_is_rejected(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan C']);

        $this->actingAs($user)->post(route('itineraries.items.store', $itin), [
            'item_type' => 'journey', 'item_id' => 999999,
        ])->assertUnprocessable();

        $this->actingAs($user)->post(route('itineraries.items.store', $itin), [
            'item_type' => 'listing', 'item_id' => 999999,
        ])->assertUnprocessable();
    }

    public function test_user_cannot_view_or_edit_another_users_itinerary(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();
        $itin = $owner->itineraries()->create(['title' => 'Private plan']);
        $journey = Journey::published()->firstOrFail();
        $item = $itin->items()->create(['item_type' => 'journey', 'item_id' => $journey->id, 'day' => 1]);

        $this->actingAs($stranger)->get(route('itineraries.show', $itin))->assertForbidden();
        $this->actingAs($stranger)->post(route('itineraries.items.store', $itin), [
            'item_type' => 'journey', 'item_id' => $journey->id,
        ])->assertForbidden();
        $this->actingAs($stranger)->patch(route('itineraries.items.update', [$itin, $item]), [
            'day' => 2,
        ])->assertForbidden();
        $this->actingAs($stranger)->delete(route('itineraries.items.destroy', [$itin, $item]))->assertForbidden();
        $this->actingAs($stranger)->delete(route('itineraries.destroy', $itin))->assertForbidden();

        $this->assertDatabaseCount('itineraries', 1);
        $this->assertDatabaseCount('itinerary_items', 1);
    }

    public function test_user_can_update_and_remove_a_stop(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan D']);
        $journey = Journey::published()->firstOrFail();
        $item = $itin->items()->create(['item_type' => 'journey', 'item_id' => $journey->id, 'day' => 1]);

        $this->actingAs($user)->patch(route('itineraries.items.update', [$itin, $item]), [
            'day' => 3, 'notes' => 'Second sunrise',
        ])->assertRedirect();

        $this->assertSame(3, $item->fresh()->day);
        $this->assertSame('Second sunrise', $item->fresh()->notes);

        $this->actingAs($user)->delete(route('itineraries.items.destroy', [$itin, $item]))->assertRedirect();
        $this->assertSame(0, $itin->items()->count());
    }

    public function test_itinerary_show_lists_stops_with_book_links(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan E']);
        $journey = Journey::where('slug', 'rinjani-responsible-trek')->firstOrFail();
        $itin->items()->create(['item_type' => 'journey', 'item_id' => $journey->id, 'day' => 1]);

        $this->actingAs($user)->get(route('itineraries.show', $itin))
            ->assertOk()
            ->assertSee('Rinjani Responsible Trek')
            ->assertSee(route('checkout.create', ['journey', 'rinjani-responsible-trek']), false);
    }

    public function test_deleting_itinerary_cascades_to_items(): void
    {
        $user = User::factory()->create();
        $itin = $user->itineraries()->create(['title' => 'Plan F']);
        $journey = Journey::published()->firstOrFail();
        $itin->items()->create(['item_type' => 'journey', 'item_id' => $journey->id, 'day' => 1]);

        $this->actingAs($user)->delete(route('itineraries.destroy', $itin))->assertRedirect();

        $this->assertDatabaseCount('itineraries', 0);
        $this->assertDatabaseCount('itinerary_items', 0);
    }
}
