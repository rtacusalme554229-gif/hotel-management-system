<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guest: Reservation Form
    |--------------------------------------------------------------------------
    */
    public function create(Room $room)
    {
        return view('reservations.create', compact('room'));
    }

    /*
    |--------------------------------------------------------------------------
    | Guest: Store Reservation
    |--------------------------------------------------------------------------
    */
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

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT LOGIC:
        | Prevent same room from being reserved if dates overlap.
        |--------------------------------------------------------------------------
        |
        | Existing reservation:
        | check_in_date < requested checkout
        | AND
        | check_out_date > requested check-in
        |
        | This allows:
        | Old: May 5 - May 10
        | New: May 10 - May 12
        |
        | But blocks:
        | Old: May 5 - May 10
        | New: May 8 - May 12
        |
        */
        $hasConflict = Reservation::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'accepted', 'checked_in'])
            ->where(function ($query) use ($request) {
                $query->where('check_in_date', '<', $request->check_out_date)
                    ->where('check_out_date', '>', $request->check_in_date);
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->with('error', 'This room is already reserved for the selected dates. Please choose another date or room.');
        }

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $totalAmount = $days * $room->price;

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

        return redirect()
            ->route('my.reservations')
            ->with('success', 'Reservation submitted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin / Staff: View All Reservations
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $reservations = Reservation::with(['guest.user', 'room', 'payment'])
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->whereHas('guest.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($roomQuery) use ($search) {
                        $roomQuery->where('room_no', 'like', "%{$search}%")
                            ->orWhere('room_type', 'like', "%{$search}%");
                    });
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('check_in_date', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('check_out_date', '<=', $request->end_date);
            })
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin: Approve Reservation
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Only pending reservations can be approved.');
        }

        /*
        |--------------------------------------------------------------------------
        | Re-check conflict before approval
        |--------------------------------------------------------------------------
        | This prevents admin from approving if another reservation already blocks
        | the same room and date range.
        */
        $hasConflict = Reservation::where('room_id', $reservation->room_id)
            ->where('id', '!=', $reservation->id)
            ->whereIn('status', ['accepted', 'checked_in'])
            ->where(function ($query) use ($reservation) {
                $query->where('check_in_date', '<', $reservation->check_out_date)
                    ->where('check_out_date', '>', $reservation->check_in_date);
            })
            ->exists();

        if ($hasConflict) {
            return back()->with('error', 'This reservation conflicts with another approved reservation.');
        }

        $reservation->update([
            'status' => 'accepted',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Room status note:
        |--------------------------------------------------------------------------
        | The room becomes reserved after approval.
        | Even if another guest wants a future date, the controller still checks
        | exact dates before allowing reservation.
        */
        $reservation->room->update([
            'status' => 'reserved',
        ]);

        return back()->with('success', 'Reservation approved and room reserved.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin: Decline Reservation
    |--------------------------------------------------------------------------
    */
    public function decline($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        if (!in_array($reservation->status, ['pending', 'accepted'])) {
            return back()->with('error', 'This reservation cannot be declined.');
        }

        $reservation->update([
            'status' => 'declined',
        ]);

        $this->refreshRoomStatus($reservation->room);

        return back()->with('success', 'Reservation declined successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Staff: Check In
    |--------------------------------------------------------------------------
    */
    public function checkIn($id)
    {
        $reservation = Reservation::with(['room', 'payment'])->findOrFail($id);

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

    /*
    |--------------------------------------------------------------------------
    | Staff: Check Out
    |--------------------------------------------------------------------------
    */
    public function checkOut($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        if ($reservation->status !== 'checked_in') {
            return back()->with('error', 'Only checked-in guests can be checked out.');
        }

        $reservation->update([
            'status' => 'checked_out',
            'checked_out_at' => Carbon::now('Asia/Manila'),
        ]);

        $this->refreshRoomStatus($reservation->room);

        return back()->with('success', 'Guest checked out successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Guest: My Reservations
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Helper: Refresh Room Status
    |--------------------------------------------------------------------------
    |
    | If a room has a checked-in guest, it stays occupied.
    | If it has an accepted future/current reservation, it stays reserved.
    | Otherwise, it becomes available.
    */
    private function refreshRoomStatus(Room $room)
    {
        $hasCheckedIn = Reservation::where('room_id', $room->id)
            ->where('status', 'checked_in')
            ->exists();

        if ($hasCheckedIn) {
            $room->update(['status' => 'occupied']);
            return;
        }

        $hasAcceptedReservation = Reservation::where('room_id', $room->id)
            ->where('status', 'accepted')
            ->exists();

        if ($hasAcceptedReservation) {
            $room->update(['status' => 'reserved']);
            return;
        }

        $room->update(['status' => 'available']);
    }
}