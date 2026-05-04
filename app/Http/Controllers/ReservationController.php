<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Room $room)
    {
        return view('reservations.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:255',
        ]);

        $guest = Guest::where('user_id', Auth::id())->first();

        if (!$guest) {
            return back()->with('error', 'Guest profile not found.');
        }

        $room = Room::findOrFail($request->room_id);

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $totalAmount = $days * $room->price;

        // ✅ ONLY CREATE RESERVATION (NO ROOM STATUS CHANGE YET)
        Reservation::create([
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'reservation_date' => Carbon::now('Asia/Manila')->toDateString(),
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'number_of_guests' => $request->number_of_guests,
            'special_requests' => $request->special_requests,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('my.reservations')
            ->with('success', 'Reservation submitted successfully.');
    }

    public function index()
    {
        $reservations = Reservation::with(['guest.user', 'room', 'payment'])
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    // ✅ ADMIN APPROVE → ROOM BECOMES RESERVED
    public function approve($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        $reservation->update([
            'status' => 'accepted',
        ]);

        $reservation->room->update([
            'status' => 'reserved',
        ]);

        return back()->with('success', 'Reservation approved and room reserved.');
    }

    // ❌ DECLINE → ROOM BACK TO AVAILABLE
    public function decline($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        $reservation->update([
            'status' => 'declined',
        ]);

        $reservation->room->update([
            'status' => 'available',
        ]);

        return back()->with('success', 'Reservation declined.');
    }

    // 🏨 CHECK-IN → ROOM OCCUPIED
    public function checkIn($id)
    {
        $reservation = Reservation::with('room', 'payment')->findOrFail($id);

        if (!$reservation->payment) {
            return back()->with('error', 'Guest must pay before check-in.');
        }

        if ($reservation->status !== 'accepted') {
            return back()->with('error', 'Only accepted reservations can be checked in.');
        }

        $reservation->update([
            'status' => 'checked_in',
            'checked_in_at' => Carbon::now('Asia/Manila'),
        ]);

        $reservation->room->update([
            'status' => 'occupied',
        ]);

        return back()->with('success', 'Guest checked in successfully.');
    }

    // 🏁 CHECK-OUT → ROOM AVAILABLE
    public function checkOut($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        if ($reservation->status !== 'checked_in') {
            return back()->with('error', 'Only checked-in guests can be checked out.');
        }

        $now = Carbon::now('Asia/Manila');

        $reservation->update([
            'status' => 'checked_out',
            'checked_out_at' => $now,
        ]);

        $reservation->room->update([
            'status' => 'available',
        ]);

        return back()->with('success', 'Guest checked out successfully.');
    }

    public function myReservations()
    {
        $guest = Guest::where('user_id', Auth::id())->first();

        if (!$guest) {
            return back()->with('error', 'Guest not found.');
        }

        $reservations = Reservation::with(['room', 'payment'])
            ->where('guest_id', $guest->id)
            ->latest()
            ->get();

        return view('reservations.my', compact('reservations'));
    }
}