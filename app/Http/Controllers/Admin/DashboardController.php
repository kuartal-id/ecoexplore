<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Journey;
use App\Models\Listing;
use App\Models\RestorationProject;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'pending' => Booking::where('payment_status', Booking::PAYMENT_PENDING)->where('status', Booking::STATUS_PENDING)->count(),
                'confirmed' => Booking::where('status', Booking::STATUS_CONFIRMED)->count(),
                'paid_idr' => (int) Booking::where('payment_status', Booking::PAYMENT_PAID)->sum('amount_idr'),
                'journeys' => Journey::count(),
                'listings' => Listing::count(),
                'projects' => RestorationProject::count(),
            ],
            'recent' => Booking::latest()->take(8)->get(),
        ]);
    }
}
