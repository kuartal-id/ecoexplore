<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journey;
use App\Support\ImageUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JourneyController extends Controller
{
    use BilingualFields;

    public function index(): View
    {
        return view('admin.journeys.index', ['journeys' => Journey::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.journeys.form', ['journey' => new Journey(['is_published' => false, 'duration_days' => 1, 'duration_nights' => 0, 'min_pax' => 1, 'max_pax' => 12, 'category' => 'heritage', 'difficulty' => 'easy'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $journey = Journey::create($this->validated($request));

        return redirect()->route('admin.journeys.edit', $journey)->with('status', __('ui.admin.saved'));
    }

    public function edit(Journey $journey): View
    {
        return view('admin.journeys.form', compact('journey'));
    }

    public function update(Request $request, Journey $journey): RedirectResponse
    {
        $journey->update($this->validated($request, $journey));

        return redirect()->route('admin.journeys.edit', $journey)->with('status', __('ui.admin.saved'));
    }

    public function destroy(Journey $journey): RedirectResponse
    {
        // Bookings keep item_name, so history survives; unpublishing is usually better.
        $journey->delete();

        return redirect()->route('admin.journeys.index')->with('status', __('ui.admin.deleted'));
    }

    public function updateImage(Request $request, Journey $journey): RedirectResponse
    {
        $journey->image = ImageUploader::handle($request, 'image', 'journeys');
        $journey->save();

        return redirect()->route('admin.journeys.edit', $journey)->with('status', __('ui.admin.image_updated'));
    }

    public function destroyImage(Journey $journey): RedirectResponse
    {
        $journey->image = null;
        $journey->save();

        return redirect()->route('admin.journeys.edit', $journey)->with('status', __('ui.admin.image_removed'));
    }

    private function validated(Request $request, ?Journey $journey = null): array
    {
        $data = $request->validate([
            'slug' => ['required', 'alpha_dash', 'max:120', Rule::unique('journeys', 'slug')->ignore($journey?->id)],
            'title_id' => ['required', 'string', 'max:160'],
            'title_en' => ['required', 'string', 'max:160'],
            'tagline_id' => ['nullable', 'string', 'max:200'], 'tagline_en' => ['nullable', 'string', 'max:200'],
            'summary_id' => ['nullable', 'string', 'max:600'], 'summary_en' => ['nullable', 'string', 'max:600'],
            'description_id' => ['nullable', 'string', 'max:5000'], 'description_en' => ['nullable', 'string', 'max:5000'],
            'itinerary_id' => ['nullable', 'string', 'max:10000'], 'itinerary_en' => ['nullable', 'string', 'max:10000'],
            'includes_id' => ['nullable', 'string', 'max:3000'], 'includes_en' => ['nullable', 'string', 'max:3000'],
            'excludes_id' => ['nullable', 'string', 'max:3000'], 'excludes_en' => ['nullable', 'string', 'max:3000'],
            'impact_id' => ['nullable', 'string', 'max:2000'], 'impact_en' => ['nullable', 'string', 'max:2000'],
            'category' => ['required', Rule::in(Journey::CATEGORIES)],
            'region' => ['required', 'string', 'max:160'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:30'],
            'duration_nights' => ['required', 'integer', 'min:0', 'max:30'],
            'price_idr' => ['required', 'integer', 'min:0', 'max:1000000000'],
            'min_pax' => ['required', 'integer', 'min:1', 'max:100'],
            'max_pax' => ['required', 'integer', 'gte:min_pax', 'max:100'],
            'difficulty' => ['required', Rule::in(['easy', 'moderate', 'challenging'])],
            'image' => ['nullable', 'string', 'max:255'],
            'community_partner' => ['nullable', 'string', 'max:160'],
            'carbon_kg_pp' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        return [
            'slug' => $data['slug'],
            'title' => $this->pair($data, 'title'),
            'tagline' => $this->pair($data, 'tagline'),
            'summary' => $this->pair($data, 'summary'),
            'description' => $this->pair($data, 'description'),
            'itinerary' => $this->itinerary($data),
            'includes' => $this->lines($data, 'includes'),
            'excludes' => $this->lines($data, 'excludes'),
            'impact' => $this->pair($data, 'impact'),
            'category' => $data['category'],
            'region' => $data['region'],
            'duration_days' => $data['duration_days'],
            'duration_nights' => $data['duration_nights'],
            'price_idr' => $data['price_idr'],
            'min_pax' => $data['min_pax'],
            'max_pax' => $data['max_pax'],
            'difficulty' => $data['difficulty'],
            'image' => $data['image'] ?? null,
            'community_partner' => $data['community_partner'] ?? null,
            'carbon_kg_pp' => $data['carbon_kg_pp'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
        ];
    }
}
