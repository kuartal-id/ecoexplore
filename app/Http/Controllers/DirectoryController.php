<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectoryController extends Controller
{
    public function index(Request $request, string $type): View
    {
        $model = Listing::typeFromSegment($type) ?? abort(404);
        $subtype = $request->query('subtype');

        $listings = Listing::published()->where('type', $model)
            ->when(is_string($subtype) && $subtype !== '', fn ($q) => $q->where('subtype', $subtype))
            ->orderBy('sort_order')->orderBy('name')->get();

        $subtypes = Listing::published()->where('type', $model)->whereNotNull('subtype')->distinct()->orderBy('subtype')->pluck('subtype');

        return view('directory.index', compact('listings', 'model', 'type', 'subtype', 'subtypes'));
    }

    public function show(string $type, string $slug): View
    {
        $model = Listing::typeFromSegment($type) ?? abort(404);
        $listing = Listing::published()->where('type', $model)->where('slug', $slug)->firstOrFail();

        return view('directory.show', [
            'listing' => $listing,
            'type' => $type,
            'related' => Listing::published()->where('type', $model)->whereKeyNot($listing->id)->orderBy('sort_order')->take(3)->get(),
        ]);
    }
}
