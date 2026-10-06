<?php

namespace Database\Seeders;

use App\Models\Journey;
use App\Models\Listing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Ships the Indonesia-wide expansion content (7 new journeys across geoparks, national
 * parks, biosphere reserves, World Heritage and wildlife areas + new directory listings
 * incl. villas, hotels, eco-lodges, eco B&Bs and bookable activities) AFTER the original
 * Lombok sample set. Marker-gated like SampleContentSeeder so it runs exactly once and
 * never overwrites admin edits or deletions. Within a run it is idempotent (firstOrCreate
 * by slug).
 *
 *   php artisan db:seed --class=Database\\Seeders\\IndonesiaContentSeeder --force
 */
class IndonesiaContentSeeder extends Seeder
{
    public const MARKER = 'indonesia-content-v1';

    public function run(): void
    {
        if (DB::table('seed_markers')->where('key', self::MARKER)->exists()) {
            $this->command?->info('Indonesia content already seeded ('.self::MARKER.'); nothing to do.');

            return;
        }

        DB::transaction(function () {
            foreach (require __DIR__.'/data/journeys.php' as $row) {
                Journey::firstOrCreate(['slug' => $row['slug']], $row + ['is_published' => true]);
            }

            foreach (require __DIR__.'/data/listings.php' as $row) {
                Listing::firstOrCreate(['slug' => $row['slug']], $row + ['is_published' => true]);
            }

            DB::table('seed_markers')->insert(['key' => self::MARKER, 'ran_at' => now()]);
        });

        $this->command?->info('Indonesia content seeded ('.self::MARKER.').');
    }
}
