@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Reservations</h2>
</div>

<div class="mb-3">
    <a href="{{ route('reservations.index') }}"
       class="btn btn-sm {{ $selectedStatus === 'all' ? 'btn-dark' : 'btn-outline-dark' }}">
        All
    </a>

    <a href="{{ route('reservations.index', ['status' => 'pending']) }}"
       class="btn btn-sm {{ $selectedStatus === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning' }}">
        Pending
    </a>

    <a href="{{ route('reservations.index', ['status' => 'accepted']) }}"
       class="btn btn-sm {{ $selectedStatus === 'accepted' ? 'btn-success' : 'btn-outline-success' }}">
        Accepted
    </a>

    <a href="{{ route('reservations.index', ['status' => 'declined']) }}"
       class="btn btn-sm {{ $selectedStatus === 'declined' ? 'btn-danger' : 'btn-outline-danger' }}">
        Declined
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Guests</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservations as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->guest->user->name ?? 'N/A' }}</td>
                        <td>{{ $r->room->room_no ?? 'N/A' }} ({{ $r->room->room_type ?? 'N/A' }})</td>
                        <td>{{ $r->check_in_date }}</td>
                        <td>{{ $r->check_out_date }}</td>
                        <td>{{ $r->number_of_guests }}</td>
                        <td>₱{{ number_format($r->total_amount, 2) }}</td>
                        <td>
                            <span class="badge
                                @if($r->status === 'pending') bg-warning text-dark
                                @elseif($r->status === 'accepted') bg-success
                                @elseif($r->status === 'declined') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td>
                            @if($r->status === 'pending')
                                <form action="{{ route('reservations.approve', $r->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form action="{{ route('reservations.decline', $r->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Decline</button>
                                </form>
                            @else
                                <span class="text-muted">No action</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No reservations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection