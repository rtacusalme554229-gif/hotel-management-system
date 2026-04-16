<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;

class PaymentController extends Controller
{
    public function pay($id)
    {
        $reservation = Reservation::with('room', 'payment')->findOrFail($id);

        if ($reservation->status !== 'accepted') {
            return back()->with('error', 'Only approved reservations can be paid.');
        }

        if ($reservation->payment) {
            return back()->with('error', 'This reservation is already paid.');
        }

        Payment::create([
            'reservation_id' => $reservation->id,
            'guest_id' => $reservation->guest_id,
            'amount' => $reservation->total_amount,
            'payment_method' => 'cash',
            'payment_date' => now()->toDateString(),
            'status' => 'paid',
        ]);

        return back()->with('success', 'Payment successful.');
    }

    public function index()
    {
        $payments = Payment::with(['reservation.room', 'reservation.guest.user'])
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }
}