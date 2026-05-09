@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Reservation Management</h2>
    <p class="text-muted mb-0">Search, filter, and manage hotel reservations efficiently.</p>
</div>

<!-- FILTER CARD -->
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('reservations.index') }}">
            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted">Search</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control rounded-3"
                        placeholder="Guest name, room no, or room type"
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted">Status</label>
                    <select name="status" class="form-select rounded-3">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ request('status') === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted">Start Date</label>
                    <input
                        type="date"
                        name="start_date"
                        class="form-control rounded-3"
                        value="{{ request('start_date') }}"
                    >
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted">End Date</label>
                    <input
                        type="date"
                        name="end_date"
                        class="form-control rounded-3"
                        value="{{ request('end_date') }}"
                    >
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-3 flex-fill">
                        Filter
                    </button>

                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary rounded-3 flex-fill">
                        Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- RESERVATION TABLE -->
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Stay Details</th>
                        <th>Total Amount</th>
                        <th>Special Request</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Check-In / Check-Out</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="text-center">{{ $reservation->id }}</td>

                            <td>
                                <strong>{{ $reservation->guest->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $reservation->guest->user->email ?? '' }}</small>
                            </td>

                            <td>
                                <strong>Room {{ $reservation->room->room_no ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $reservation->room->room_type ?? '' }}</small>
                            </td>

                            <td>
                                <strong>Check In:</strong> {{ $reservation->check_in_date }}<br>
                                <strong>Check Out:</strong> {{ $reservation->check_out_date }}<br>
                                <small class="text-muted">
                                    Guests: {{ $reservation->number_of_guests }}
                                </small>
                            </td>

                            <td class="text-center fw-bold text-success">
                                &#8369;{{ number_format($reservation->total_amount, 2) }}
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
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unpaid</span>
                                @endif
                            </td>

                            <td>
                                @if($reservation->checked_in_at)
                                    <small>
                                        <strong>In:</strong>
                                        {{ $reservation->checked_in_at->format('Y-m-d h:i A') }}
                                    </small><br>
                                @else
                                    <small class="text-muted">Not checked in</small><br>
                                @endif

                                @if($reservation->checked_out_at)
                                    <small>
                                        <strong>Out:</strong>
                                        {{ $reservation->checked_out_at->format('Y-m-d h:i A') }}
                                    </small>
                                @else
                                    <small class="text-muted">Not checked out</small>
                                @endif
                            </td>

                            <td class="text-center">

                                <!-- VIEW BUTTON: ADMIN + STAFF -->
                                <button class="btn btn-dark btn-sm rounded-3 mb-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $reservation->id }}">
                                    View
                                </button>

                                <!-- ADMIN ONLY: APPROVE / DECLINE -->
                                @if(auth()->user()->role === 'admin' && $reservation->status === 'pending')
                                    <form action="{{ route('reservations.approve', $reservation->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-3 mb-1">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('reservations.decline', $reservation->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm rounded-3 mb-1">
                                            Decline
                                        </button>
                                    </form>
                                @endif

                                <!-- STAFF ONLY: CHECK IN -->
                                @if(in_array(auth()->user()->role, ['staff', 'manager']) && $reservation->status === 'accepted')
                                    <form action="{{ route('reservations.checkin', $reservation->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-primary btn-sm rounded-3 mb-1">
                                            Check In
                                        </button>
                                    </form>
                                @endif

                                <!-- STAFF ONLY: CHECK OUT -->
                                @if(in_array(auth()->user()->role, ['staff', 'manager']) && $reservation->status === 'checked_in')
                                    <form action="{{ route('reservations.checkout', $reservation->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-warning btn-sm rounded-3 mb-1">
                                            Check Out
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No reservations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODALS -->
@foreach($reservations as $reservation)
<div class="modal fade" id="viewModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Reservation #{{ $reservation->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Guest Information</h6>

                        <p class="mb-2">
                            <strong>Name:</strong>
                            {{ $reservation->guest->user->name ?? 'N/A' }}
                        </p>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            {{ $reservation->guest->user->email ?? 'N/A' }}
                        </p>

                        @if(!empty($reservation->guest->phone_number))
                            <p class="mb-2">
                                <strong>Phone:</strong>
                                {{ $reservation->guest->phone_number }}
                            </p>
                        @endif

                        @if(!empty($reservation->guest->address))
                            <p class="mb-2">
                                <strong>Address:</strong>
                                {{ $reservation->guest->address }}
                            </p>
                        @endif

                        <hr>

                        <h6 class="fw-bold mb-3">Stay Details</h6>

                        <p class="mb-2">
                            <strong>Check In Date:</strong>
                            {{ $reservation->check_in_date }}
                        </p>

                        <p class="mb-2">
                            <strong>Check Out Date:</strong>
                            {{ $reservation->check_out_date }}
                        </p>

                        <p class="mb-2">
                            <strong>Guests:</strong>
                            {{ $reservation->number_of_guests }}
                        </p>

                        @if($reservation->checked_in_at)
                            <p class="mb-2">
                                <strong>Checked In At:</strong>
                                {{ $reservation->checked_in_at->format('Y-m-d h:i A') }}
                            </p>
                        @endif

                        @if($reservation->checked_out_at)
                            <p class="mb-2">
                                <strong>Checked Out At:</strong>
                                {{ $reservation->checked_out_at->format('Y-m-d h:i A') }}
                            </p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Room Information</h6>

                        @if(!empty($reservation->room->image))
                            <img src="{{ asset('storage/' . $reservation->room->image) }}"
                                 class="img-fluid rounded-3 mb-3"
                                 style="max-height: 220px; object-fit: cover; width: 100%;">
                        @endif

                        <p class="mb-2">
                            <strong>Room No:</strong>
                            {{ $reservation->room->room_no ?? 'N/A' }}
                        </p>

                        <p class="mb-2">
                            <strong>Room Type:</strong>
                            {{ $reservation->room->room_type ?? 'N/A' }}
                        </p>

                        <p class="mb-2">
                            <strong>Room Status:</strong>
                            {{ ucfirst($reservation->room->status ?? 'N/A') }}
                        </p>

                        <p class="mb-2">
                            <strong>Total Amount:</strong>
                            &#8369;{{ number_format($reservation->total_amount, 2) }}
                        </p>

                        <p class="mb-2">
                            <strong>Payment:</strong>
                            @if($reservation->payment)
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Unpaid</span>
                            @endif
                        </p>

                        <p class="mb-0">
                            <strong>Reservation Status:</strong>
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
                        </p>
                    </div>
                </div>

                @if(!empty($reservation->special_requests))
                    <div class="mt-4">
                        <h6 class="fw-bold mb-2">Special Requests</h6>
                        <div class="bg-light rounded-3 p-3 border-start border-4 border-warning">
                            {{ $reservation->special_requests }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal-footer">

                <!-- ADMIN ONLY: APPROVE / DECLINE -->
                @if(auth()->user()->role === 'admin' && $reservation->status === 'pending')
                    <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success rounded-3">
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('reservations.decline', $reservation->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger rounded-3">
                            Decline
                        </button>
                    </form>
                @endif

                <!-- STAFF ONLY: CHECK IN -->
                @if(in_array(auth()->user()->role, ['staff', 'manager']) && $reservation->status === 'accepted')
                    <form action="{{ route('reservations.checkin', $reservation->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary rounded-3">
                            Check In
                        </button>
                    </form>
                @endif

                <!-- STAFF ONLY: CHECK OUT -->
                @if(in_array(auth()->user()->role, ['staff', 'manager']) && $reservation->status === 'checked_in')
                    <form action="{{ route('reservations.checkout', $reservation->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning rounded-3">
                            Check Out
                        </button>
                    </form>
                @endif

                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection