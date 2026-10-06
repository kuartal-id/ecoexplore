<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ListingController extends Controller
{
    use BilingualFields;

    public function index(Request $request): View
    {
        $type = array_key_exists((string) $request->query('type'), Listing::TYPES) ? $request->query('type') : null;

        return view('admin.listings.index', [
            'listings' => Listing::when($type, fn ($q) => $q->where('type', $type))->orderBy('type')->orderBy('sort_order')->get(),
            'type' => $type,
        ]);
    }

    public function create(): View
    {
        return view('admin.listings.form', ['listing' => new Listing(['is_published' => false, 'type' => 'accommodation'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $listing = Listing::create($this->validated($request));

        return redirect()->route('admin.listings.edit', $listing)->with('status', __('ui.admin.saved'));
    }

    public function edit(Listing $listing): View
    {
        return view('admin.listings.form', compact('listing'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $listing->update($this->validated($request, $listing));

        return redirect()->route('admin.listings.edit', $listing)->with('status', __('ui.admin.saved'));
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->delete();

        return redirect()->route('admin.listings.index')->with('status', __('ui.admin.deleted'));
    }

    private function validated(Request $request, ?Listing $listing = null): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(array_keys(Listing::TYPES))],
            'subtype' => ['nullable', 'alpha_dash', 'max:40'],
            'slug' => ['required', 'alpha_dash', 'max:120', Rule::unique('listings', 'slug')->ignore($listing?->id)],
            'name' => ['required', 'string', 'max:160'],
            'location' => ['required', 'string', 'max:160'],
            'summary_id' => ['nullable', 'string', 'max:600'], 'summary_en' => ['nullable', 'string', 'max:600'],
            'description_id' => ['nullable', 'string', 'max:5000'], 'description_en' => ['nullable', 'string', 'max:5000'],
            'features_id' => ['nullable', 'string', 'max:3000'], 'features_en' => ['nullable', 'string', 'max:3000'],
            'price_idr' => ['nullable', 'integer', 'min:0', 'max:1000000000'],
            'price_unit' => ['nullable', Rule::in(Listing::PRICE_UNITS)],
            'image' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        return [
            'type' => $data['type'],
            'subtype' => $data['subtype'] ?? null,
            'slug' => $data['slug'],
            'name' => $data['name'],
            'location' => $data['location'],
            'summary' => $this->pair($data, 'summary'),
            'description' => $this->pair($data, 'description'),
            'features' => $this->lines($data, 'features'),
            'price_idr' => $data['price_idr'] ?? null,
            'price_unit' => $data['price_unit'] ?? null,
            'image' => $data['image'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_bookable' => $request->boolean('is_bookable'),
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
