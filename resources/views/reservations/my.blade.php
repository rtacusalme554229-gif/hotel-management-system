@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">My Reservations</h2>
    <p class="text-muted mb-0">Track your bookings, approval status, and payment progress.</p>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Room</th>
                    <th>Stay Details</th>
                    <th>Guests</th>
                    <th>Total Amount</th>
                    <th>Special Request</th>
                    <th>Reservation Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td class="text-center">{{ $reservation->id }}</td>

                        <td>
                            <strong>Room {{ $reservation->room->room_no }}</strong><br>
                            <small class="text-muted">{{ $reservation->room->room_type }}</small>
                        </td>

                        <td>
                            <strong>Check In:</strong> {{ $reservation->check_in_date }}<br>
                            <strong>Check Out:</strong> {{ $reservation->check_out_date }}
                        </td>

                        <td class="text-center">{{ $reservation->number_of_guests }}</td>

                        <td class="text-center fw-bold text-success">
                            ₱{{ number_format($reservation->total_amount, 2) }}
                        </td>

                        <td>
                            @if($reservation->special_requests)
                                <span class="badge bg-light text-dark border">
                                    {{ $reservation->special_requests }}
                                </span>
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <span class="badge
                                @if($reservation->status === 'pending') bg-warning text-dark
                                @elseif($reservation->status === 'accepted') bg-success
                                @elseif($reservation->status === 'declined') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($reservation->status === 'accepted')
                                @if(!$reservation->payment)
                                    <a href="{{ route('payments.show', $reservation->id) }}" class="btn btn-primary btn-sm rounded-3">
                                        Pay
                                    </a>
                                @else
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <span class="badge bg-success">Paid</span>
                                        <a href="{{ route('payments.receipt', $reservation->payment->id) }}"
                                           class="btn btn-outline-dark btn-sm rounded-3">
                                            View Receipt
                                        </a>
                                    </div>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No reservations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection