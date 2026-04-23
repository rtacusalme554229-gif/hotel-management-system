<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($id)
    {
        $reservation = Reservation::with(['room', 'payment', 'guest.user'])->findOrFail($id);

        if ($reservation->status !== 'accepted') {
            return redirect()->route('my.reservations')
                ->with('error', 'Only approved reservations can be paid.');
        }

        if ($reservation->payment) {
            return redirect()->route('payments.receipt', $reservation->payment->id)
                ->with('success', 'This reservation is already paid.');
        }

        $checkIn = \Carbon\Carbon::parse($reservation->check_in_date);
        $checkOut = \Carbon\Carbon::parse($reservation->check_out_date);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $roomRate = $reservation->room->price;
        $subtotal = $roomRate * $nights;
        $serviceFee = 100;
        $tax = $subtotal * 0.05;
        $finalTotal = $subtotal + $serviceFee + $tax;

        return view('payments.show', compact(
            'reservation',
            'nights',
            'roomRate',
            'subtotal',
            'serviceFee',
            'tax',
            'finalTotal'
        ));
    }

    public function pay($id)
    {
        $reservation = Reservation::with(['room', 'payment', 'guest.user'])->findOrFail($id);

        if ($reservation->status !== 'accepted') {
            return redirect()->route('my.reservations')
                ->with('error', 'Only approved reservations can be paid.');
        }

        if ($reservation->payment) {
            return redirect()->route('payments.receipt', $reservation->payment->id)
                ->with('success', 'This reservation is already paid.');
        }

        $checkIn = \Carbon\Carbon::parse($reservation->check_in_date);
        $checkOut = \Carbon\Carbon::parse($reservation->check_out_date);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        $subtotal = $reservation->room->price * $nights;
        $serviceFee = 100;
        $tax = $subtotal * 0.05;
        $finalTotal = $subtotal + $serviceFee + $tax;

        $paymentMethod = request('payment_method', 'cash');

        $payment = Payment::create([
            'reservation_id' => $reservation->id,
            'guest_id' => $reservation->guest_id,
            'amount' => $finalTotal,
            'payment_method' => $paymentMethod,
            'payment_date' => now()->toDateString(),
            'status' => 'paid',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Payment Completed',
            'description' => 'Completed payment for reservation #' . $reservation->id . ' by guest ' . ($reservation->guest->user->name ?? 'N/A'),
        ]);

        return redirect()->route('payments.receipt', $payment->id)
            ->with('success', 'Payment successful.');
    }

    public function receipt($id)
    {
        $payment = Payment::with(['reservation.room', 'reservation.guest.user'])->findOrFail($id);

        return view('payments.receipt', compact('payment'));
    }

    public function index()
    {
        $payments = Payment::with(['reservation.room', 'reservation.guest.user'])
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }
}