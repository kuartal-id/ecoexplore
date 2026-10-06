<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\ItineraryItem;
use App\Models\Journey;
use App\Models\Listing;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function index()
    {
        return view('itineraries.index', [
            'itineraries' => auth()->user()->itineraries()->withCount('items')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'start_date' => ['nullable', 'date'],
        ]);

        $itinerary = auth()->user()->itineraries()->create([
            'title' => $data['title'],
            'start_date' => $data['start_date'] ?? null,
        ]);

        return redirect()->route('itineraries.show', $itinerary)
            ->with('status', __('ui.itinerary.created'));
    }

    public function show(Itinerary $itinerary)
    {
        abort_unless($itinerary->user_id === auth()->id(), 403);

        $itinerary->load('items');

        return view('itineraries.show', [
            'itinerary' => $itinerary,
            'stops' => $itinerary->items->map(fn (ItineraryItem $item) => [
                'item' => $item,
                'ref' => $item->item(),
            ])->filter(fn (array $row) => $row['ref'] !== null),
        ]);
    }

    public function destroy(Itinerary $itinerary)
    {
        abort_unless($itinerary->user_id === auth()->id(), 403);
        $itinerary->delete();

        return redirect()->route('itineraries.index')
            ->with('status', __('ui.itinerary.deleted'));
    }

    public function addItem(Request $request, Itinerary $itinerary)
    {
        abort_unless($itinerary->user_id === auth()->id(), 403);

        $data = $request->validate([
            'item_type' => ['required', 'in:journey,listing'],
            'item_id' => ['required', 'integer', 'min:1'],
            'day' => ['nullable', 'integer', 'min:1', 'max:90'],
        ]);

        $exists = match ($data['item_type']) {
            'journey' => Journey::published()->whereKey($data['item_id'])->exists(),
            'listing' => Listing::published()->whereKey($data['item_id'])->exists(),
        };

        abort_unless($exists, 422);

        $day = $data['day'] ?? 1;

        $item = $itinerary->items()
            ->where('item_type', $data['item_type'])
            ->where('item_id', $data['item_id'])
            ->first();

        if ($item === null) {
            $position = (int) $itinerary->items()->where('day', $day)->max('position') + 1;
            $item = $itinerary->items()->create(['item_type' => $data['item_type'], 'item_id' => $data['item_id'], 'day' => $day, 'position' => $position]);
            $created = true;
        } else {
            $created = false;
        }

        return back()->with('status', $created
            ? __('ui.itinerary.added', ['name' => $itinerary->title])
            : __('ui.itinerary.exists', ['name' => $itinerary->title]));
    }

    public function updateItem(Request $request, Itinerary $itinerary, ItineraryItem $item)
    {
        abort_unless($itinerary->user_id === auth()->id() && $item->itinerary_id === $itinerary->id, 403);

        $data = $request->validate([
            'day' => ['required', 'integer', 'min:1', 'max:90'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $item->update([
            'day' => $data['day'],
            'position' => (int) $itinerary->items()->where('day', $data['day'])->where('id', '!=', $item->id)->max('position') + 1,
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('status', __('ui.itinerary.updated'));
    }

    public function removeItem(Itinerary $itinerary, ItineraryItem $item)
    {
        abort_unless($itinerary->user_id === auth()->id() && $item->itinerary_id === $itinerary->id, 403);
        $item->delete();

        return back()->with('status', __('ui.itinerary.removed'));
    }
}
