<?php

namespace App\Services;

/**
 * Trip carbon estimate using the ILLUSTRATIVE factors in config/carbon.php.
 * Not an audited methodology; results are not verified offsets (see README).
 */
class CarbonEstimator
{
    public const DEFAULTS = [
        'origin' => 'jakarta',
        'flight_class' => 'economy',
        'return_trip' => true,
        'travellers' => 2,
        'nights' => 3,
        'stay' => 'eco_lodge',
        'car_km' => 120,
        'boat_trips' => 2,
        'boat_type' => 'fast_boat',
        'diet' => 'mixed',
    ];

    /**
     * @param  array<string, mixed>  $input  validated input (see CarbonController)
     * @return array{total_kg: float, per_person_kg: float, breakdown: array<string, float>, contribution_idr: int, version: string, input: array<string, mixed>}
     */
    public function estimate(array $input): array
    {
        $in = array_merge(self::DEFAULTS, array_filter($input, fn ($v) => $v !== null && $v !== ''));
        $c = config('carbon');

        $travellers = max(1, (int) $in['travellers']);
        $nights = max(0, (int) $in['nights']);
        $days = max(1, $nights + 1);

        $km = (float) ($c['origins'][$in['origin']]['km'] ?? 0);
        $legs = filter_var($in['return_trip'], FILTER_VALIDATE_BOOLEAN) ? 2 : 1;
        $flight = $km * $legs * ($c['flight_kg_per_pkm'][$in['flight_class']] ?? $c['flight_kg_per_pkm']['economy']) * $travellers;

        $boat = (int) $in['boat_trips'] * ($c['boat_kg_per_trip'][$in['boat_type']] ?? 0) * $travellers;
        $car = (float) $in['car_km'] * $c['car_kg_per_km'];
        $rooms = (int) ceil($travellers / 2);
        $stay = $nights * $rooms * ($c['stay_kg_per_room_night'][$in['stay']] ?? 0);
        $food = $days * $travellers * ($c['food_kg_per_person_day'][$in['diet']] ?? 0);

        $breakdown = array_map(fn ($v) => round($v, 1), [
            'flights' => $flight,
            'boats' => $boat,
            'ground' => $car,
            'stay' => $stay,
            'food' => $food,
        ]);

        $total = round(array_sum($breakdown), 1);

        return [
            'total_kg' => $total,
            'per_person_kg' => round($total / $travellers, 1),
            'breakdown' => $breakdown,
            'contribution_idr' => (int) (round($total * $c['suggested_contribution_idr_per_kg'] / 1000) * 1000),
            'version' => $c['version'],
            'input' => $in,
        ];
    }
}
