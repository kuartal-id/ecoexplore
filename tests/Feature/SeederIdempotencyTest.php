<?php

namespace Tests\Feature;

use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use Database\Seeders\IndonesiaContentSeeder;
use Database\Seeders\SampleContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** The post-deploy step runs SampleContentSeeder on every release; it must only seed once. */
class SeederIdempotencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeds_once_and_never_overwrites_owner_edits(): void
    {
        $this->seed(SampleContentSeeder::class);
        $this->seed(IndonesiaContentSeeder::class);
        $counts = [Journey::count(), Listing::count(), RestorationProject::count()];
        $this->assertSame(16, $counts[0]);
        $this->assertSame(32, $counts[1]);
        $this->assertSame(6, $counts[2]);

        Journey::where('slug', 'aik-berik-geotour')->update(['price_idr' => 1234000]);
        Journey::where('slug', 'remnants-of-samalas')->delete();
        Listing::where('slug', 'komodo-snorkel-day-trip')->delete();

        $this->seed(SampleContentSeeder::class);
        $this->seed(IndonesiaContentSeeder::class);
        $this->artisan('db:seed', ['--class' => SampleContentSeeder::class, '--force' => true])->assertSuccessful();
        $this->artisan('db:seed', ['--class' => IndonesiaContentSeeder::class, '--force' => true])->assertSuccessful();

        $this->assertSame(1234000, (int) Journey::where('slug', 'aik-berik-geotour')->value('price_idr'));
        $this->assertFalse(Journey::where('slug', 'remnants-of-samalas')->exists(), 'A deleted sample must not come back.');
        $this->assertFalse(Listing::where('slug', 'komodo-snorkel-day-trip')->exists(), 'A deleted listing must not come back.');
        $this->assertSame([15, $counts[1] - 1, 6], [Journey::count(), Listing::count(), RestorationProject::count()]);
        $this->assertDatabaseHas('seed_markers', ['key' => 'sample-content-v1']);
        $this->assertDatabaseHas('seed_markers', ['key' => 'indonesia-content-v1']);
    }

    public function test_every_journey_has_bilingual_content_and_a_sample_itinerary(): void
    {
        $this->seed(SampleContentSeeder::class);
        $this->seed(IndonesiaContentSeeder::class);

        foreach (Journey::all() as $journey) {
            foreach (['id', 'en'] as $locale) {
                $this->assertNotEmpty($journey->title[$locale]);
                $this->assertNotEmpty($journey->summary[$locale]);
                $this->assertNotEmpty($journey->itinerary[$locale]);
            }
            $this->assertGreaterThan(0, $journey->price_idr);
            // Multi-day trips: at least one block per day. Day trips are split into time blocks.
            $this->assertGreaterThanOrEqual($journey->duration_days, count($journey->itinerary['en']), $journey->slug);
            $this->assertCount(count($journey->itinerary['id']), $journey->itinerary['en'], $journey->slug);
        }
    }
}
