@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>My Reservations</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Guests</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->room->room_no }} - {{ $reservation->room->room_type }}</td>
                        <td>{{ $reservation->check_in_date }}</td>
                        <td>{{ $reservation->check_out_date }}</td>
                        <td>{{ $reservation->number_of_guests }}</td>
                        <td>₱{{ number_format($reservation->total_amount, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($reservation->status === 'pending') bg-warning text-dark
                                @elseif($reservation->status === 'accepted') bg-success
                                @elseif($reservation->status === 'declined') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td>
                            @if($reservation->status === 'accepted')
                                @if(!$reservation->payment)
                                    <form action="{{ route('payments.pay', $reservation->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">Pay</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Paid</span>
                                @endif
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection