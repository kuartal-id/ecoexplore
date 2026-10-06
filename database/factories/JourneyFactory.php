<?php

namespace Database\Factories;

use App\Models\Journey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Journey>
 */
class JourneyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => 'journey-'.Str::random(8),
            'title' => ['id' => 'Perjalanan uji', 'en' => 'Test journey'],
            'tagline' => ['id' => null, 'en' => null],
            'summary' => ['id' => null, 'en' => null],
            'description' => ['id' => null, 'en' => null],
            'itinerary' => null,
            'includes' => null,
            'excludes' => null,
            'impact' => ['id' => null, 'en' => null],
            'category' => 'heritage',
            'region' => 'Lombok',
            'duration_days' => 2,
            'duration_nights' => 1,
            'price_idr' => 1000000,
            'min_pax' => 1,
            'max_pax' => 8,
            'difficulty' => 'easy',
            'image' => null,
            'community_partner' => null,
            'carbon_kg_pp' => null,
            'sort_order' => 0,
            'is_published' => false,
            'is_featured' => false,
        ];
    }
}
