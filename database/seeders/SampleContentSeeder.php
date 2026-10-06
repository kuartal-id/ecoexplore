<?php

namespace Database\Seeders;

use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the MVP sample content (9 Lombok journeys, directory listings, restoration
 * projects) ONCE. Safe to run on every deploy (app:post-deploy does): after the first
 * successful run it records `sample-content-v1` in seed_markers and does nothing again,
 * so admin edits and deletions are never overwritten. Within a run it is also idempotent
 * (firstOrCreate by slug).
 *
 *   php artisan db:seed --class=Database\\Seeders\\SampleContentSeeder --force
 *
 * To ship more sample content later, add a new seeder with a new marker key.
 */
class SampleContentSeeder extends Seeder
{
    public const MARKER = 'sample-content-v1';

    public function run(): void
    {
        if (DB::table('seed_markers')->where('key', self::MARKER)->exists()) {
            $this->command?->info('Sample content already seeded ('.self::MARKER.'); nothing to do.');

            return;
        }

        DB::transaction(function () {
            foreach (require __DIR__.'/data/journeys.php' as $row) {
                Journey::firstOrCreate(['slug' => $row['slug']], $row + ['is_published' => true]);
            }

            foreach (require __DIR__.'/data/listings.php' as $row) {
                Listing::firstOrCreate(['slug' => $row['slug']], $row + ['is_published' => true]);
            }

            foreach (require __DIR__.'/data/restoration.php' as $row) {
                RestorationProject::firstOrCreate(['slug' => $row['slug']], $row + ['is_published' => true, 'funded_units' => 0]);
            }

            DB::table('seed_markers')->insert(['key' => self::MARKER, 'ran_at' => now()]);
        });

        $this->command?->info('Sample content seeded ('.self::MARKER.').');
    }
}
