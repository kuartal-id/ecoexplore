<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * `php artisan migrate --seed`. No users or admins are seeded: register (or sign in
     * with Kuartal ID) and run `php artisan ecoexplore:admin <email>`.
     */
    public function run(): void
    {
        $this->call(SampleContentSeeder::class);
    }
}
