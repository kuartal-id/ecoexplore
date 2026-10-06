<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JourneyController extends Controller
{
    public function index(Request $request): View
    {
        $category = in_array($request->query('category'), Journey::CATEGORIES, true) ? $request->query('category') : null;
        $q = trim((string) $request->query('q', ''));

        $journeys = Journey::published()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->orderBy('sort_order')
            ->get();

        if ($q !== '') {
            $needle = mb_strtolower($q);
            $journeys = $journeys->filter(fn (Journey $j) => str_contains(mb_strtolower(
                implode(' ', [$j->tr('title'), $j->tr('summary'), $j->region, $j->tr('title', 'en'), $j->tr('title', 'id')])
            ), $needle))->values();
        }

        return view('journeys.index', [
            'journeys' => $journeys,
            'category' => $category,
            'q' => $q,
            'listingCounts' => Listing::published()->selectRaw('type, count(*) as n')->groupBy('type')->pluck('n', 'type'),
        ]);
    }

    public function show(Journey $journey): View
    {
        abort_unless($journey->is_published, 404);

        return view('journeys.show', [
            'journey' => $journey,
            'related' => Journey::published()->whereKeyNot($journey->id)->orderByRaw('category = ? desc', [$journey->category])->orderBy('sort_order')->take(3)->get(),
        ]);
    }
}
