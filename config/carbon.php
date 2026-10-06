<?php

// Trip carbon estimator -- ILLUSTRATIVE MVP FACTORS ONLY.
//
// These numbers are rounded, illustrative values chosen so the estimator gives a sensible
// order of magnitude. They are NOT an audited carbon accounting methodology, are not
// sourced per factor, and results must never be advertised as verified offsets. Before
// launch, replace this file with a versioned methodology (sources/evidence per factor,
// transport classes, accommodation and food methodology, uncertainty handling, project
// additionality and impact reporting). See README "Carbon methodology".
return [

    'version' => 'illustrative-mvp-2026-10',

    // Approximate one-way air distance to Lombok (LOP), km. Rounded.
    'origins' => [
        'lombok' => ['label' => 'Lombok (no flight)', 'km' => 0],
        'bali' => ['label' => 'Bali (Denpasar)', 'km' => 110],
        'surabaya' => ['label' => 'Surabaya', 'km' => 470],
        'yogyakarta' => ['label' => 'Yogyakarta', 'km' => 800],
        'jakarta' => ['label' => 'Jakarta', 'km' => 1150],
        'singapore' => ['label' => 'Singapore', 'km' => 1700],
        'kuala_lumpur' => ['label' => 'Kuala Lumpur', 'km' => 1950],
        'perth' => ['label' => 'Perth', 'km' => 2300],
        'sydney' => ['label' => 'Sydney', 'km' => 4700],
        'tokyo' => ['label' => 'Tokyo', 'km' => 5600],
        'amsterdam' => ['label' => 'Amsterdam', 'km' => 11900],
    ],

    // kg CO2e per passenger-km (illustrative, includes a rough non-CO2 uplift).
    'flight_kg_per_pkm' => [
        'economy' => 0.15,
        'premium' => 0.23,
        'business' => 0.43,
    ],

    // kg CO2e per passenger per boat crossing (e.g. Lombok - Gili).
    'boat_kg_per_trip' => [
        'fast_boat' => 8.0,
        'public_ferry' => 4.0,
    ],

    // kg CO2e per vehicle-km, shared across the travelling party.
    'car_kg_per_km' => 0.19,

    // kg CO2e per room-night (rooms = travellers / 2, rounded up).
    'stay_kg_per_room_night' => [
        'homestay' => 8.0,
        'eco_lodge' => 12.0,
        'hotel' => 20.0,
        'resort' => 45.0,
    ],

    // kg CO2e per person per day of food.
    'food_kg_per_person_day' => [
        'plant_based' => 2.5,
        'mixed' => 4.5,
        'meat_heavy' => 7.0,
    ],

    // Suggested VOLUNTARY restoration contribution shown next to the result. It is a
    // contribution to local restoration, NOT an offset purchase.
    'suggested_contribution_idr_per_kg' => 250,
];
