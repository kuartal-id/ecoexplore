<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use App\Services\BookingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Checkout for journeys, bookable listings and restoration contributions. Guests may book
 * with contact details; signed-in users get the booking on their account.
 */
class CheckoutController extends Controller
{
    public function __construct(private BookingService $bookings) {}

    public function create(Request $request, string $kind, string $slug): View
    {
        $item = BookingService::findItem($kind, $slug) ?? abort(404);
        $quantity = $this->defaultQuantity($item, (int) $request->query('quantity', 0));

        return view('checkout.create', [
            'item' => $item,
            'kind' => $kind,
            'slug' => $slug,
            'quantity' => $quantity,
            'price' => BookingService::price($item, $quantity),
            'limits' => $this->limits($item),
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request, string $kind, string $slug): RedirectResponse
    {
        $item = BookingService::findItem($kind, $slug) ?? abort(404);
        [$min, $max] = $this->limits($item);
        $needsDate = ! $item instanceof RestorationProject;
        $isStay = $item instanceof Listing && $item->isStay();

        $data = $request->validate([
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:40', 'regex:/^[0-9+()\-\s]{6,40}$/'],
            'quantity' => ['required', 'integer', "min:{$min}", "max:{$max}"],
            'start_date' => [$needsDate ? 'required' : 'nullable', 'date', 'after_or_equal:'.now()->addDay()->toDateString()],
            'end_date' => [$isStay ? 'required' : 'nullable', 'date', 'after:start_date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(Booking::PAYMENT_METHODS)],
            'accept_terms' => ['accepted'],
        ]);

        if ($isStay && \Illuminate\Support\Carbon::parse($data['start_date'])->diffInDays(\Illuminate\Support\Carbon::parse($data['end_date'])) > 30) {
            throw \Illuminate\Validation\ValidationException::withMessages(['end_date' => __('ui.checkout.max_nights', ['nights' => 30])]);
        }

        if (! $isStay) {
            $data['end_date'] = $this->endDate($item, $data['start_date'] ?? null);
        }

        $booking = $this->bookings->create($item, $data, $request->user());

        // Lets this browser re-open the confirmation without an account.
        $request->session()->push('bookings.access', $booking->reference);

        return redirect()->route('bookings.show', $booking)->with('status', __('ui.checkout.created'));
    }

    /** @return array{0: int, 1: int} */
    private function limits(Model $item): array
    {
        return match (true) {
            $item instanceof Journey => [max(1, $item->min_pax), max(1, $item->max_pax)],
            $item instanceof RestorationProject => [1, 500],
            $item instanceof Listing && $item->isStay() => [1, 6],
            default => [1, 20],
        };
    }

    private function defaultQuantity(Model $item, int $requested): int
    {
        [$min, $max] = $this->limits($item);
        $default = $item instanceof Journey ? max($min, 2) : 1;

        return max($min, min($max, $requested ?: $default));
    }

    private function endDate(Model $item, ?string $start): ?string
    {
        if (! $start || ! $item instanceof Journey) {
            return null;
        }

        return \Illuminate\Support\Carbon::parse($start)->addDays(max(0, $item->duration_days - 1))->toDateString();
    }
}
