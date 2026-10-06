<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JourneyController as AdminJourneyController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Auth\KuartalIdLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarbonController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RestorationController;
use Illuminate\Support\Facades\Route;

// NOTE: /.htaccess refuses URLs whose first segment is a framework directory (app, config,
// storage, vendor, docs, lang, ...). tests/Unit/WebRootHtaccessTest.php checks every route.

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/explore', [JourneyController::class, 'index'])->name('explore');
Route::get('/journeys/{journey:slug}', [JourneyController::class, 'show'])->name('journeys.show');
Route::get('/directory/{type}', [DirectoryController::class, 'index'])->name('directory.index');
Route::get('/directory/{type}/{slug}', [DirectoryController::class, 'show'])->name('directory.show');
Route::get('/restore', [RestorationController::class, 'index'])->name('restore.index');
Route::get('/restore/{project:slug}', [RestorationController::class, 'show'])->name('restore.show');
Route::get('/carbon', [CarbonController::class, 'show'])->name('carbon');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/offline', [PageController::class, 'offline'])->name('offline');
Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/locale/{locale}', LocaleController::class)->name('locale');

// Checkout: kind = journey | listing | restore.
Route::get('/book/{kind}/{slug}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/book/{kind}/{slug}', [CheckoutController::class, 'store'])->middleware('throttle:10,1')->name('checkout.store');
Route::get('/bookings/{booking:reference}', [BookingController::class, 'show'])->name('bookings.show');
Route::post('/bookings/{booking:reference}/payment-method', [BookingController::class, 'paymentMethod'])->middleware('throttle:20,1')->name('bookings.payment-method');

// Local email/password accounts (kept alongside Kuartal ID).
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:6,1');
    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->middleware('throttle:6,1')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// "Masuk dengan Kuartal ID" -- OIDC against id.kuartal.id (see KuartalIdLoginController).
Route::get('/auth/kuartal-id/redirect', [KuartalIdLoginController::class, 'redirect'])->name('login.kuartal-id');
Route::get('/auth/kuartal-id/callback', [KuartalIdLoginController::class, 'callback'])->name('login.kuartal-id.callback');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');

    // Itineraries live under /account so no new top-level URL segment is introduced
    // (tests/Unit/WebRootHtaccessTest checks every first segment against /.htaccess).
    Route::get('/account/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
    Route::post('/account/itineraries', [ItineraryController::class, 'store'])->middleware('throttle:20,1')->name('itineraries.store');
    Route::get('/account/itineraries/{itinerary}', [ItineraryController::class, 'show'])->name('itineraries.show');
    Route::delete('/account/itineraries/{itinerary}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');
    Route::post('/account/itineraries/{itinerary}/items', [ItineraryController::class, 'addItem'])->middleware('throttle:20,1')->name('itineraries.items.store');
    Route::patch('/account/itineraries/{itinerary}/items/{item}', [ItineraryController::class, 'updateItem'])->name('itineraries.items.update');
    Route::delete('/account/itineraries/{itinerary}/items/{item}', [ItineraryController::class, 'removeItem'])->name('itineraries.items.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/mark-paid', [AdminBookingController::class, 'markPaid'])->name('bookings.mark-paid');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');

    Route::get('/journeys', [AdminJourneyController::class, 'index'])->name('journeys.index');
    Route::get('/journeys/create', [AdminJourneyController::class, 'create'])->name('journeys.create');
    Route::post('/journeys', [AdminJourneyController::class, 'store'])->name('journeys.store');
    Route::get('/journeys/{journey}/edit', [AdminJourneyController::class, 'edit'])->name('journeys.edit');
    Route::put('/journeys/{journey}', [AdminJourneyController::class, 'update'])->name('journeys.update');
    Route::delete('/journeys/{journey}', [AdminJourneyController::class, 'destroy'])->name('journeys.destroy');

    Route::get('/listings', [AdminListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [AdminListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [AdminListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [AdminListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [AdminListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [AdminListingController::class, 'destroy'])->name('listings.destroy');
});
