<?php

namespace Tests\Feature;

use App\Services\CarbonEstimator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Illustrative MVP estimator; must stay clearly labelled and never claim verified offsets. */
class CarbonEstimatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_trip_matches_the_documented_illustrative_factors(): void
    {
        $r = app(CarbonEstimator::class)->estimate([]);

        // Jakarta 1,150 km x 2 legs x 0.15 x 2 travellers.
        $this->assertSame(690.0, $r['breakdown']['flights']);
        $this->assertSame(32.0, $r['breakdown']['boats']);   // 2 fast-boat trips x 8 kg x 2
        $this->assertSame(22.8, $r['breakdown']['ground']);  // 120 km x 0.19 (shared car)
        $this->assertSame(36.0, $r['breakdown']['stay']);    // 3 nights x 1 room x 12 (eco-lodge)
        $this->assertSame(36.0, $r['breakdown']['food']);    // 4 days x 2 x 4.5 (mixed)
        $this->assertSame(816.8, $r['total_kg']);
        $this->assertSame(408.4, $r['per_person_kg']);
        $this->assertSame(204000, $r['contribution_idr']);
        $this->assertSame(config('carbon.version'), $r['version']);
    }

    public function test_choices_change_the_result(): void
    {
        $estimator = app(CarbonEstimator::class);
        $base = $estimator->estimate([]);

        $this->assertLessThan($base['total_kg'], $estimator->estimate(['return_trip' => false])['total_kg']);
        $this->assertGreaterThan($base['total_kg'], $estimator->estimate(['flight_class' => 'business'])['total_kg']);
        $this->assertLessThan($base['total_kg'], $estimator->estimate(['origin' => 'lombok'])['total_kg']);
        $this->assertLessThan($base['total_kg'], $estimator->estimate(['diet' => 'plant_based', 'stay' => 'homestay'])['total_kg']);
        $this->assertGreaterThan($base['total_kg'], $estimator->estimate(['travellers' => 4])['total_kg']);
    }

    public function test_unknown_choices_fall_back_safely(): void
    {
        $r = app(CarbonEstimator::class)->estimate(['flight_class' => 'rocket', 'stay' => 'castle', 'travellers' => 0, 'nights' => -3]);

        $this->assertGreaterThanOrEqual(0, $r['total_kg']);
        $this->assertSame(0.0, $r['breakdown']['stay']);
    }

    public function test_page_shows_estimate_and_the_disclaimer(): void
    {
        $this->get('/carbon')->assertOk()
            ->assertSee('817')
            ->assertSee(__('ui.carbon.disclaimer_title'))
            ->assertSee(config('carbon.version'));

        $this->get('/carbon?origin=bali&travellers=1&nights=2&flight_class=economy&stay=homestay&diet=plant_based&car_km=50&boat_trips=0&boat_type=fast_boat')
            ->assertOk();
    }

    public function test_english_page_says_illustrative_and_not_an_offset(): void
    {
        $this->withUnencryptedCookie('locale', 'en')->get('/carbon')->assertOk()
            ->assertSee('Illustrative')
            ->assertSee('must not be presented as verified offsets', false);
    }

    public function test_invalid_input_is_rejected(): void
    {
        $this->get('/carbon?origin=mars&travellers=999&nights=2')->assertSessionHasErrors(['origin', 'travellers']);
    }
}
