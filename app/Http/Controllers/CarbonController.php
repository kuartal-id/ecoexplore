<?php

namespace App\Http\Controllers;

use App\Models\RestorationProject;
use App\Services\CarbonEstimator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CarbonController extends Controller
{
    public function show(Request $request, CarbonEstimator $estimator): View
    {
        $c = config('carbon');
        $calculated = $request->hasAny(['origin', 'travellers', 'nights']);

        $input = $calculated ? $request->validate([
            'origin' => ['nullable', Rule::in(array_keys($c['origins']))],
            'flight_class' => ['nullable', Rule::in(array_keys($c['flight_kg_per_pkm']))],
            'return_trip' => ['nullable', 'boolean'],
            'travellers' => ['nullable', 'integer', 'min:1', 'max:50'],
            'nights' => ['nullable', 'integer', 'min:0', 'max:60'],
            'stay' => ['nullable', Rule::in(array_keys($c['stay_kg_per_room_night']))],
            'car_km' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'boat_trips' => ['nullable', 'integer', 'min:0', 'max:20'],
            'boat_type' => ['nullable', Rule::in(array_keys($c['boat_kg_per_trip']))],
            'diet' => ['nullable', Rule::in(array_keys($c['food_kg_per_person_day']))],
        ]) : [];

        if ($calculated && ! $request->has('return_trip')) {
            $input['return_trip'] = false; // Unchecked checkbox.
        }

        return view('carbon.show', [
            'result' => $estimator->estimate($input),
            'calculated' => $calculated,
            'factors' => $c,
            'projects' => RestorationProject::published()->orderBy('sort_order')->take(3)->get(),
        ]);
    }
}
