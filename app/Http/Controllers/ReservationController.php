<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create($roomId)
    {
        $room = Room::where('status', 'available')->findOrFail($roomId);

        return view('reservations.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
        ]);

        $guest = Guest::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone_number' => null,
                'address' => null,
            ]
        );

        $room = Room::findOrFail($request->room_id);

        if ($room->status !== 'available') {
            return back()->withErrors([
                'room_id' => 'This room is not available for reservation.',
            ])->withInput();
        }

        $hasConflict = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                          ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors([
                'room_id' => 'This room is already reserved for the selected dates.',
            ])->withInput();
        }

        $days = max(
            1,
            \Carbon\Carbon::parse($request->check_in_date)
                ->diffInDays(\Carbon\Carbon::parse($request->check_out_date))
        );

        $totalAmount = $room->price * $days;

        Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'reservation_date' => now()->toDateString(),
            'number_of_guests' => $request->number_of_guests,
            'special_requests' => $request->special_requests,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('my.reservations')->with('success', 'Reservation submitted successfully.');
    }

    public function myReservations()
    {
        $guest = Guest::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'phone_number' => null,
                'address' => null,
            ]
        );

        $reservations = Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->latest()
            ->get();

        return view('reservations.my', compact('reservations'));
    }

    public function index(Request $request)
    {
        $query = Reservation::with(['guest.user', 'room', 'payment']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('guest.user', function ($guestQuery) use ($search) {
                    $guestQuery->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('room', function ($roomQuery) use ($search) {
                    $roomQuery->where('room_no', 'like', '%' . $search . '%')
                              ->orWhere('room_type', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('status') && in_array($request->status, ['pending', 'accepted', 'declined'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('check_in_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('check_in_date', '<=', $request->end_date);
        }

        $reservations = $query->latest()->get();

        return view('reservations.index', compact('reservations'));
    }

    public function approve($id)
    {
        $reservation = Reservation::with(['room', 'guest.user'])->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be approved.');
        }

        $reservation->update([
            'status' => 'accepted',
        ]);

        $reservation->room->update([
            'status' => 'reserved',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Reservation Approved',
            'description' => 'Approved reservation #' . $reservation->id . ' for guest ' . ($reservation->guest->user->name ?? 'N/A'),
        ]);

        return back()->with('success', 'Reservation approved.');
    }

    public function decline($id)
    {
        $reservation = Reservation::with(['room', 'guest.user'])->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be declined.');
        }

        $reservation->update([
            'status' => 'declined',
        ]);

        $reservation->room->update([
            'status' => 'available',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Reservation Declined',
            'description' => 'Declined reservation #' . $reservation->id . ' for guest ' . ($reservation->guest->user->name ?? 'N/A'),
        ]);

        return back()->with('success', 'Reservation declined.');
    }
}