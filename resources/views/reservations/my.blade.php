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
                    <th>Payment Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td class="text-center">{{ $reservation->id }}</td>

                        <td>
                            <strong>Room {{ $reservation->room->room_no ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $reservation->room->room_type ?? '' }}</small>
                        </td>

                        <td>
                            <strong>Check In:</strong> {{ $reservation->check_in_date }}<br>
                            <strong>Check Out:</strong> {{ $reservation->check_out_date }}

                            @if($reservation->checked_in_at)
                                <br><small class="text-primary">
                                    Checked in: {{ $reservation->checked_in_at->format('Y-m-d h:i A') }}
                                </small>
                            @endif

                            @if($reservation->checked_out_at)
                                <br><small class="text-secondary">
                                    Checked out: {{ $reservation->checked_out_at->format('Y-m-d h:i A') }}
                                </small>
                            @endif
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
                                @elseif($reservation->status === 'checked_in') bg-primary
                                @elseif($reservation->status === 'checked_out') bg-secondary
                                @elseif($reservation->status === 'declined') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($reservation->payment)
                                <div class="d-flex flex-column gap-2 align-items-center">
                                    <span class="badge bg-success">Paid</span>

                                    <a href="{{ route('payments.receipt', $reservation->payment->id) }}"
                                       class="btn btn-outline-dark btn-sm rounded-3">
                                        View Receipt
                                    </a>
                                </div>
                            @elseif($reservation->status === 'accepted')
                                <a href="{{ route('payments.show', $reservation->id) }}"
                                   class="btn btn-primary btn-sm rounded-3">
                                    Pay Now
                                </a>
                            @elseif($reservation->status === 'pending')
                                <span class="badge bg-warning text-dark">Waiting Approval</span>
                            @elseif($reservation->status === 'declined')
                                <span class="badge bg-danger">Declined</span>
                            @else
                                <span class="badge bg-warning text-dark">Unpaid</span>
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