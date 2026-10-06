<?php

namespace App\Console\Commands;

use App\Models\Journey;
use App\Models\Listing;
use Illuminate\Console\Command;

class SyncContentImages extends Command
{
    protected $signature = 'ecoexplore:sync-images';

    protected $description = 'Point seeder-known journeys/listings at their packaged photos. Only touches rows that still use a placeholder or packaged photo — owner uploads in assets/uploads are never overwritten.';

    public function handle(): int
    {
        $updated = 0;
        $skipped = 0;

        foreach (['journeys' => Journey::class, 'listings' => Listing::class] as $file => $model) {
            foreach (require database_path('seeders/data/'.$file.'.php') as $row) {
                $record = $model::where('slug', $row['slug'])->first();
                if (! $record) {
                    continue; // deleted by an admin — respect that
                }

                $current = $record->image;

                // Never clobber something the owner uploaded through the admin panel.
                if (is_string($current) && str_starts_with($current, 'assets/uploads/')) {
                    $skipped++;
                    continue;
                }

                if ($current === $row['image']) {
                    continue;
                }

                $record->image = $row['image'];
                $record->save();
                $updated++;
                $this->line(sprintf('%s %-42s %s', $record->slug, (string) $current, (string) $row['image']));
            }
        }

        $this->info("Images synced: {$updated} updated, {$skipped} owner-uploaded left untouched.");

        return self::SUCCESS;
    }
}
