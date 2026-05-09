<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StaffController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && trim($user->role) === 'admin') {
        return redirect('/admin/dashboard');
    }

    if ($user && in_array(trim($user->role), ['staff', 'manager'])) {
        return redirect('/staff/dashboard');
    }

    return redirect('/guest/dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        $today = Carbon::now('Asia/Manila')->toDateString();

        $totalRooms = \App\Models\Room::count();

        /*
        |--------------------------------------------------------------------------
        | Date-Based Room Logic
        |--------------------------------------------------------------------------
        | Reserved rooms can still be booked for other non-overlapping dates.
        | Only checked-in rooms are counted as occupied today.
        */
        $occupiedToday = \App\Models\Reservation::where('status', 'checked_in')->count();
        $bookableRooms = max($totalRooms - $occupiedToday, 0);

        $totalGuests = \App\Models\Guest::count();
        $totalReservations = \App\Models\Reservation::count();

        $pendingReservations = \App\Models\Reservation::where('status', 'pending')->count();

        $upcomingReservations = \App\Models\Reservation::whereIn('status', ['pending', 'accepted'])
            ->whereDate('check_in_date', '>=', $today)
            ->count();

        $activeStays = \App\Models\Reservation::where('status', 'checked_in')->count();

        $totalPayments = \App\Models\Payment::count();
        $totalRevenue = \App\Models\Payment::sum('amount');

        $recentPayments = \App\Models\Payment::with(['reservation.guest.user', 'reservation.room'])
            ->latest()
            ->take(5)
            ->get();

        $revenueChart = \App\Models\Payment::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();

        $reservationChart = \App\Models\Reservation::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'bookableRooms',
            'occupiedToday',
            'totalGuests',
            'totalReservations',
            'pendingReservations',
            'upcomingReservations',
            'activeStays',
            'totalPayments',
            'totalRevenue',
            'recentPayments',
            'revenueChart',
            'reservationChart'
        ));
    })->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Guest Management
    |--------------------------------------------------------------------------
    */
    Route::get('/guests', [GuestController::class, 'index'])
        ->name('guests.index');

    Route::get('/guests/{guest}/edit', [GuestController::class, 'edit'])
        ->name('guests.edit');

    Route::put('/guests/{guest}', [GuestController::class, 'update'])
        ->name('guests.update');

    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])
        ->name('guests.destroy');

    /*
    |--------------------------------------------------------------------------
    | Room Management
    |--------------------------------------------------------------------------
    */
    Route::get('/rooms/create', [RoomController::class, 'create'])
        ->name('rooms.create');

    Route::post('/rooms', [RoomController::class, 'store'])
        ->name('rooms.store');

    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])
        ->name('rooms.edit');

    Route::put('/rooms/{room}', [RoomController::class, 'update'])
        ->name('rooms.update');

    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
        ->name('rooms.destroy');

    /*
    |--------------------------------------------------------------------------
    | Staff Management
    |--------------------------------------------------------------------------
    */
    Route::get('/staff', [StaffController::class, 'index'])
        ->name('staff.index');

    Route::get('/staff/create', [StaffController::class, 'create'])
        ->name('staff.create');

    Route::post('/staff', [StaffController::class, 'store'])
        ->name('staff.store');

    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])
        ->name('staff.edit');

    Route::put('/staff/{staff}', [StaffController::class, 'update'])
        ->name('staff.update');

    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])
        ->name('staff.destroy');
});

/*
|--------------------------------------------------------------------------
| Staff / Manager Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'staff'])->group(function () {

    Route::get('/staff/dashboard', function () {
        $today = Carbon::now('Asia/Manila')->toDateString();

        $totalRooms = \App\Models\Room::count();

        $activeStays = \App\Models\Reservation::where('status', 'checked_in')->count();
        $bookableRooms = max($totalRooms - $activeStays, 0);

        $todayCheckIns = \App\Models\Reservation::whereDate('check_in_date', $today)
            ->whereIn('status', ['accepted', 'checked_in'])
            ->count();

        $todayCheckOuts = \App\Models\Reservation::whereDate('check_out_date', $today)
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->count();

        $completedCheckIns = \App\Models\Reservation::whereDate('checked_in_at', $today)
            ->count();

        $completedCheckOuts = \App\Models\Reservation::whereDate('checked_out_at', $today)
            ->count();

        $pendingReservations = \App\Models\Reservation::where('status', 'pending')
            ->count();

        $upcomingReservations = \App\Models\Reservation::whereIn('status', ['pending', 'accepted'])
            ->whereDate('check_in_date', '>=', $today)
            ->count();

        $todayPayments = \App\Models\Payment::whereDate('created_at', $today)
            ->count();

        $todayRevenue = \App\Models\Payment::whereDate('created_at', $today)
            ->sum('amount');

        $todayArrivals = \App\Models\Reservation::with(['guest.user', 'room', 'payment'])
            ->whereDate('check_in_date', $today)
            ->whereIn('status', ['accepted', 'checked_in'])
            ->latest()
            ->take(6)
            ->get();

        $todayDepartures = \App\Models\Reservation::with(['guest.user', 'room', 'payment'])
            ->whereDate('check_out_date', $today)
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->latest()
            ->take(6)
            ->get();

        return view('staff.dashboard', compact(
            'totalRooms',
            'bookableRooms',
            'activeStays',
            'todayCheckIns',
            'todayCheckOuts',
            'completedCheckIns',
            'completedCheckOuts',
            'pendingReservations',
            'upcomingReservations',
            'todayPayments',
            'todayRevenue',
            'todayArrivals',
            'todayDepartures'
        ));
    })->name('staff.dashboard');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index');
});

/*
|--------------------------------------------------------------------------
| Reservation Management
|--------------------------------------------------------------------------
| Admin can approve/decline.
| Staff/Manager can check in/check out.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/reservations', function (Request $request) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(ReservationController::class)->index($request);
    })->name('reservations.index');

    Route::post('/reservations/{id}/approve', function ($id) {
        $user = Auth::user();

        if (! $user || trim($user->role) !== 'admin') {
            abort(403, 'Only admin can approve reservations.');
        }

        return app(ReservationController::class)->approve($id);
    })->name('reservations.approve');

    Route::post('/reservations/{id}/decline', function ($id) {
        $user = Auth::user();

        if (! $user || trim($user->role) !== 'admin') {
            abort(403, 'Only admin can decline reservations.');
        }

        return app(ReservationController::class)->decline($id);
    })->name('reservations.decline');

    Route::post('/reservations/{id}/check-in', function ($id) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['staff', 'manager'])) {
            abort(403, 'Only staff can check in guests.');
        }

        return app(ReservationController::class)->checkIn($id);
    })->name('reservations.checkin');

    Route::post('/reservations/{id}/check-out', function ($id) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['staff', 'manager'])) {
            abort(403, 'Only staff can check out guests.');
        }

        return app(ReservationController::class)->checkOut($id);
    })->name('reservations.checkout');
});

/*
|--------------------------------------------------------------------------
| Payments for Admin + Staff / Manager
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/payments', function () {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(PaymentController::class)->index();
    })->name('payments.index');
});

/*
|--------------------------------------------------------------------------
| Reports for Admin + Staff / Manager
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/reports', function (Request $request) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(ReportController::class)->index($request);
    })->name('reports.index');

    Route::get('/reports/download', function (Request $request) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(ReportController::class)->download($request);
    })->name('reports.download');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'guest.role'])->group(function () {

    Route::get('/guest/dashboard', function () {
        $guest = \App\Models\Guest::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone_number' => null,
                'address' => null,
                'profile_photo' => null,
            ]
        );

        $today = Carbon::now('Asia/Manila')->toDateString();

        $totalReservations = \App\Models\Reservation::where('guest_id', $guest->id)
            ->count();

        $approvedReservations = \App\Models\Reservation::where('guest_id', $guest->id)
            ->where('status', 'accepted')
            ->count();

        $paidReservations = \App\Models\Payment::whereHas('reservation', function ($query) use ($guest) {
            $query->where('guest_id', $guest->id);
        })->count();

        $pendingReservations = \App\Models\Reservation::where('guest_id', $guest->id)
            ->where('status', 'pending')
            ->count();

        $activeStay = \App\Models\Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->where('status', 'checked_in')
            ->latest()
            ->first();

        $upcomingReservation = \App\Models\Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->whereDate('check_in_date', '>=', $today)
            ->orderBy('check_in_date', 'asc')
            ->first();

        $latestReservation = \App\Models\Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->latest()
            ->first();

        $recentReservations = \App\Models\Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Guest Dashboard Room Logic
        |--------------------------------------------------------------------------
        | This count shows total rooms available for date selection.
        | ReservationController blocks only overlapping dates.
        */
        $bookableRooms = \App\Models\Room::count();

        return view('guest.dashboard', compact(
            'guest',
            'totalReservations',
            'approvedReservations',
            'paidReservations',
            'pendingReservations',
            'activeStay',
            'upcomingReservation',
            'latestReservation',
            'recentReservations',
            'bookableRooms'
        ));
    })->name('guest.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Guest Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/guest/profile/edit', [GuestProfileController::class, 'edit'])
        ->name('guest.profile.edit');

    Route::put('/guest/profile/update', [GuestProfileController::class, 'update'])
        ->name('guest.profile.update');

    /*
    |--------------------------------------------------------------------------
    | Guest Reservations / Payments
    |--------------------------------------------------------------------------
    */
    Route::get('/reserve/{room}', [ReservationController::class, 'create'])
        ->name('reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    Route::get('/my-reservations', [ReservationController::class, 'myReservations'])
        ->name('my.reservations');

    Route::get('/pay/{id}', [PaymentController::class, 'show'])
        ->name('payments.show');

    Route::post('/pay/{id}', [PaymentController::class, 'pay'])
        ->name('payments.pay');

    Route::get('/payment-receipt/{id}', [PaymentController::class, 'receipt'])
        ->name('payments.receipt');
});

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/rooms', [RoomController::class, 'index'])
        ->name('rooms.index');

    Route::get('/check-user', function () {
        return Auth::user();
    })->name('check.user');
});

/*
|--------------------------------------------------------------------------
| Temporary Utility Route
|--------------------------------------------------------------------------
*/
Route::get('/force-logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';