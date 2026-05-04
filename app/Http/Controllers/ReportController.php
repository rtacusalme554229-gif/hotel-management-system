<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);

        return view('reports.index', compact('data'));
    }

    public function download(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('reports.pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('hotel-management-report.pdf');
    }

    private function getReportData(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $reservationQuery = Reservation::query();
        $paymentQuery = Payment::query();

        if ($startDate && $endDate) {
            $reservationQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);

            $paymentQuery->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => Carbon::now()->format('F d, Y h:i A'),

            'totalRooms' => Room::count(),
            'availableRooms' => Room::where('status', 'available')->count(),
            'reservedRooms' => Room::where('status', 'reserved')->count(),
            'occupiedRooms' => Room::where('status', 'occupied')->count(),

            'totalReservations' => (clone $reservationQuery)->count(),
            'pendingReservations' => (clone $reservationQuery)->where('status', 'pending')->count(),
            'acceptedReservations' => (clone $reservationQuery)->where('status', 'accepted')->count(),
            'checkedInReservations' => (clone $reservationQuery)->where('status', 'checked_in')->count(),
            'checkedOutReservations' => (clone $reservationQuery)->where('status', 'checked_out')->count(),
            'declinedReservations' => (clone $reservationQuery)->where('status', 'declined')->count(),

            'totalPayments' => (clone $paymentQuery)->count(),
            'totalRevenue' => (clone $paymentQuery)->sum('amount'),
        ];
    }
}