<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $reservedRooms = Room::where('status', 'reserved')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        $totalGuests = Guest::count();

        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $acceptedReservations = Reservation::where('status', 'accepted')->count();
        $declinedReservations = Reservation::where('status', 'declined')->count();

        $totalPayments = Payment::count();
        $totalRevenue = Payment::sum('amount');

        $revenueData = Payment::select(
            DB::raw('DATE(payment_date) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueLabels = $revenueData->pluck('date');
        $revenueValues = $revenueData->pluck('total');

        $reservationData = Reservation::select(
            DB::raw('DATE(reservation_date) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $reservationLabels = $reservationData->pluck('date');
        $reservationValues = $reservationData->pluck('total');

        return view('reports.index', compact(
            'totalRooms',
            'availableRooms',
            'reservedRooms',
            'occupiedRooms',
            'totalGuests',
            'totalReservations',
            'pendingReservations',
            'acceptedReservations',
            'declinedReservations',
            'totalPayments',
            'totalRevenue',
            'revenueLabels',
            'revenueValues',
            'reservationLabels',
            'reservationValues'
        ));
    }
}