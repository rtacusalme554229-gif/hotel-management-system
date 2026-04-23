@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Payment Records</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Guest</th>
                    <th>Reservation</th>
                    <th>Room</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $p)
                <tr>
                    <!-- ID -->
                    <td class="text-center">{{ $p->id }}</td>

                    <!-- Guest -->
                    <td>
                        <strong>{{ $p->reservation->guest->user->name ?? 'N/A' }}</strong><br>
                        <small class="text-muted">
                            {{ $p->reservation->guest->user->email ?? '' }}
                        </small>
                    </td>

                    <!-- Reservation -->
                    <td class="text-center">
                        #{{ $p->reservation_id }}
                    </td>

                    <!-- Room -->
                    <td>
                        <strong>Room {{ $p->reservation->room->room_no ?? 'N/A' }}</strong><br>
                        <small class="text-muted">
                            {{ $p->reservation->room->room_type ?? '' }}
                        </small>
                    </td>

                    <!-- Amount -->
                    <td class="text-center fw-bold text-success">
                        ₱{{ number_format($p->amount, 2) }}
                    </td>

                    <!-- Method -->
                    <td class="text-center">
                        <span class="badge bg-info text-dark">
                            {{ ucfirst($p->payment_method) }}
                        </span>
                    </td>

                    <!-- Date -->
                    <td class="text-center">
                        {{ $p->payment_date }}
                    </td>

                    <!-- Status -->
                    <td class="text-center">
                        <span class="badge bg-success">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No payment records found
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>
@endsection