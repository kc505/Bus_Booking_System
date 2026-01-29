<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\CheckInController as AdminCheckInController;
use App\Http\Controllers\Admin\AgencyManagementController;
use App\Http\Controllers\Admin\RouteManagementController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================================================
// PUBLIC ROUTES
// ============================================================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
Route::get('/agencies/{agency}', [AgencyController::class, 'show'])->name('agencies.show');
Route::get('/search', [TripController::class, 'search'])->name('trips.search');

// ============================================================================
// AUTHENTICATED ROUTES
// ============================================================================

Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // TRIP BOOKING (Original System)
    Route::get('/trips/search', function () {
        return view('trips.search');
    })->name('trips.search.page');
    Route::get('/trips/{id}/book', [TripController::class, 'book'])->name('trips.book');
    Route::post('/bookings', [TripController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}/payment', [TripController::class, 'payment'])->name('bookings.payment');
    Route::post('/bookings/{id}/pay', [TripController::class, 'processPayment'])->name('bookings.pay');
    Route::get('/bookings/{id}/success', [TripController::class, 'success'])->name('bookings.success');
    Route::get('/payment/status-check/{reference}', [TripController::class, 'checkStatusAjax'])->name('payment.check.ajax');
    Route::post('/payment/check/{reference}', [TripController::class, 'checkPaymentStatus'])->name('bookings.check-status');
    Route::get('/payment/poll/{booking}/{reference}', [TripController::class, 'pollPaymentStatus']);
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{id}/download', [TicketController::class, 'download'])->name('tickets.download');

    // MULTI-AGENCY BOOKING
    Route::get('/routes/select/{agency}', [RouteController::class, 'select'])->name('routes.select');
    Route::get('/seats/select', [BookingController::class, 'selectSeats'])->name('seats.select');

    // ADJUSTED THIS LINE TO ALLOW GET & POST (Fixes MethodNotAllowed)
    Route::match(['get', 'post'], '/booking/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

    Route::post('/booking/process', [BookingController::class, 'processPayment'])->name('booking.process');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/ticket', [BookingController::class, 'showTicket'])->name('bookings.ticket');
    Route::get('/bookings/{booking}/download-pdf', [BookingController::class, 'downloadPDF'])->name('bookings.download-pdf');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // API ENDPOINTS (AJAX) - CRITICAL: Must be inside auth middleware
    Route::get('/api/routes/info', [RouteController::class, 'getRouteInfo'])->name('api.routes.info');
    Route::get('/api/seats/availability', [BookingController::class, 'getSeatAvailability'])->name('api.seats.availability');
});

// ============================================================================
// SHARED ADMIN & STAFF (CONDUCTOR) ROUTES
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // CHECK-IN (Accessible by both Musango Admin and Musango Conductor)
    Route::get('/checkin', [AdminCheckInController::class, 'index'])->name('admin.checkin');

    // FIXED: Added the search route that matches JavaScript
    Route::get('/checkin/search', [AdminCheckInController::class, 'search'])->name('admin.checkin.search');

    // FIXED: Updated routes to match JavaScript fetch URLs
    Route::post('/checkin/{booking}/check-in', [AdminCheckInController::class, 'checkIn'])->name('admin.bookings.checkIn');
    Route::post('/checkin/{booking}/no-show', [AdminCheckInController::class, 'markNoShow'])->name('admin.bookings.noShow');
    Route::get('/checkin/{booking}', [AdminCheckInController::class, 'show'])->name('admin.bookings.show');

});

// ============================================================================
// ADMIN ROUTES
// ============================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // TRIP MANAGEMENT
    Route::get('/trips', [AdminController::class, 'manageTrips'])->name('admin.trips.index');
    Route::get('/trips/create', [AdminController::class, 'createTrip'])->name('admin.trips.create');
    Route::post('/trips', [AdminController::class, 'storeTrip'])->name('admin.trips.store');
    Route::get('/trips/{id}/edit', [AdminController::class, 'editTrip'])->name('admin.trips.edit');
    Route::patch('/trips/{id}', [AdminController::class, 'updateTrip'])->name('admin.trips.update');
    Route::delete('/trips/{id}', [AdminController::class, 'deleteTrip'])->name('admin.trips.delete');


    // USERS & SETTINGS
     // USERS
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');

    // SETTINGS
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings.index');

    // AGENCY MANAGEMENT
    Route::resource('agencies', AgencyManagementController::class)->names([
        'index' => 'admin.agencies.index',
        'create' => 'admin.agencies.create',
        'store' => 'admin.agencies.store',
        'show' => 'admin.agencies.show',
        'edit' => 'admin.agencies.edit',
        'update' => 'admin.agencies.update',
        'destroy' => 'admin.agencies.destroy',
    ]);

    // ROUTE MANAGEMENT
    Route::resource('routes', RouteManagementController::class)->names([
        'index' => 'admin.routes.index',
        'create' => 'admin.routes.create',
        'store' => 'admin.routes.store',
        'show' => 'admin.routes.show',
        'edit' => 'admin.routes.edit',
        'update' => 'admin.routes.update',
        'destroy' => 'admin.routes.destroy',
    ]);

    // REPORTS
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('admin.reports.revenue');
    Route::get('/reports/bookings', [ReportController::class, 'bookings'])->name('admin.reports.bookings');
    Route::get('/reports/agencies', [ReportController::class, 'agencies'])->name('admin.reports.agencies');

    // BOOKING MANAGEMENT
    Route::get('/all-bookings', [AdminController::class, 'allBookings'])->name('admin.bookings.all');
    Route::get('/bookings/{id}', [AdminController::class, 'viewBooking'])->name('admin.bookings.view');
    Route::post('/bookings/{id}/refund', [AdminController::class, 'processRefund'])->name('admin.bookings.refund');
});

require __DIR__.'/auth.php';
