<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
        $totalRooms = \App\Models\Room::count();
        $availableRooms = \App\Models\Room::where('status', 'available')->count();
        $totalGuests = \App\Models\Guest::count();
        $totalReservations = \App\Models\Reservation::count();
        $totalPayments = \App\Models\Payment::count();
        $totalRevenue = \App\Models\Payment::sum('amount');

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalGuests',
            'totalReservations',
            'totalPayments',
            'totalRevenue'
        ));
    })->name('admin.dashboard');

    Route::get('/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');

    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
});

/*
|--------------------------------------------------------------------------
| Staff / Manager Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/staff/dashboard', function () {
        $totalRooms = \App\Models\Room::count();
        $availableRooms = \App\Models\Room::where('status', 'available')->count();
        $totalReservations = \App\Models\Reservation::count();
        $totalPayments = \App\Models\Payment::count();
        $totalRevenue = \App\Models\Payment::sum('amount');

        return view('staff.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'totalReservations',
            'totalPayments',
            'totalRevenue'
        ));
    })->name('staff.dashboard');
});

/*
|--------------------------------------------------------------------------
| Reservation Management for Admin + Staff/Manager
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

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(ReservationController::class)->approve($id);
    })->name('reservations.approve');

    Route::post('/reservations/{id}/decline', function ($id) {
        $user = Auth::user();

        if (! $user || ! in_array(trim($user->role), ['admin', 'staff', 'manager'])) {
            abort(403, 'Unauthorized access.');
        }

        return app(ReservationController::class)->decline($id);
    })->name('reservations.decline');
});

/*
|--------------------------------------------------------------------------
| Payments for Admin + Staff/Manager
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
            ]
        );

        $totalReservations = \App\Models\Reservation::where('guest_id', $guest->id)->count();

        $approvedReservations = \App\Models\Reservation::where('guest_id', $guest->id)
            ->where('status', 'accepted')
            ->count();

        $paidReservations = \App\Models\Payment::whereHas('reservation', function ($query) use ($guest) {
            $query->where('guest_id', $guest->id);
        })->count();

        $latestReservation = \App\Models\Reservation::with('room')
            ->where('guest_id', $guest->id)
            ->latest()
            ->first();

        return view('guest.dashboard', compact(
            'totalReservations',
            'approvedReservations',
            'paidReservations',
            'latestReservation'
        ));
    })->name('guest.dashboard');

    Route::get('/reserve/{room}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'myReservations'])->name('my.reservations');

    Route::post('/pay/{id}', [PaymentController::class, 'pay'])->name('payments.pay');
});

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

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

require __DIR__ . '/auth.php';