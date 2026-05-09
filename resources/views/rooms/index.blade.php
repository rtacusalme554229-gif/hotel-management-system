@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1">Rooms</h2>

        @if(auth()->user()->role === 'guest')
            <p class="text-muted mb-0">Browse rooms and choose the best one for your stay.</p>
        @else
            <p class="text-muted mb-0">Manage hotel rooms, pricing, and availability.</p>
        @endif
    </div>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('rooms.create') }}" class="btn btn-dark rounded-3 px-4">
            <i class="bi bi-plus-circle me-1"></i> Add Room
        </a>
    @endif
</div>

<div class="row g-4">
    @forelse($rooms as $room)
        <div class="col-md-6 col-lg-4">
            <div class="room-card">

                <div class="room-image-wrap">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="room-image" alt="Room Image">
                    @else
                        <div class="no-image">No Image</div>
                    @endif

                    <span class="room-status
                        @if($room->status === 'available') status-available
                        @elseif($room->status === 'reserved') status-reserved
                        @elseif($room->status === 'occupied') status-occupied
                        @else status-default
                        @endif">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>

                <div class="room-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h4 class="fw-bold mb-1">Room {{ $room->room_no }}</h4>
                            <p class="text-muted mb-1">{{ ucfirst($room->room_type) }}</p>
                            <p class="mb-1">Floor: <strong>{{ $room->floor }}</strong></p>
                        </div>

                        <div class="room-price">
                            &#8369;{{ number_format($room->price, 2) }}
                        </div>
                    </div>

                    @if($room->reservations->count() > 0)
                        <div class="reserved-dates-box">
                            <strong>Reserved / Booked Dates:</strong>

                            @foreach($room->reservations->take(3) as $reservation)
                                <div class="reserved-date-item">
                                    {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}

                                    <span class="mini-status">
                                        {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                    </span>
                                </div>
                            @endforeach

                            @if($room->reservations->count() > 3)
                                <small class="text-muted">
                                    +{{ $room->reservations->count() - 3 }} more reservation(s)
                                </small>
                            @endif
                        </div>
                    @else
                        <div class="available-note">
                            No upcoming reservations yet.
                        </div>
                    @endif

                    <div class="room-actions mt-3">
                        <button class="btn btn-outline-dark rounded-3 w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#roomModal{{ $room->id }}">
                            View Details
                        </button>

                        @if(auth()->user()->role === 'guest')
                            {{-- Guest can still reserve even if room is marked reserved.
                                The ReservationController will block only overlapping dates. --}}
                            @if($room->status === 'occupied')
                                <a href="{{ route('reservations.create', $room->id) }}"
                                   class="btn btn-warning rounded-3 w-100 mt-2">
                                    Reserve Future Date
                                </a>
                            @else
                                <a href="{{ route('reservations.create', $room->id) }}"
                                   class="btn btn-success rounded-3 w-100 mt-2">
                                    Reserve Room
                                </a>
                            @endif
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('rooms.edit', $room->id) }}"
                                   class="btn btn-primary rounded-3 flex-fill">
                                    Edit
                                </a>

                                <form action="{{ route('rooms.destroy', $room->id) }}"
                                      method="POST"
                                      class="flex-fill"
                                      onsubmit="return confirm('Delete this room?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger rounded-3 w-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ROOM DETAILS MODAL --}}
        <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Room {{ $room->room_no }} Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}"
                                 class="img-fluid rounded-4 mb-4"
                                 style="width:100%; max-height:320px; object-fit:cover;"
                                 alt="Room Image">
                        @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Room Information</h6>

                                <p><strong>Room No:</strong> {{ $room->room_no }}</p>
                                <p><strong>Room Type:</strong> {{ ucfirst($room->room_type) }}</p>
                                <p><strong>Floor:</strong> {{ $room->floor }}</p>
                                <p><strong>Price:</strong> &#8369;{{ number_format($room->price, 2) }}</p>
                                <p>
                                    <strong>Status:</strong>
                                    <span class="badge
                                        @if($room->status === 'available') bg-success
                                        @elseif($room->status === 'reserved') bg-secondary
                                        @elseif($room->status === 'occupied') bg-danger
                                        @else bg-dark
                                        @endif">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Reservation Schedule</h6>

                                @if($room->reservations->count() > 0)
                                    <div class="schedule-list">
                                        @foreach($room->reservations as $reservation)
                                            <div class="schedule-item">
                                                <div>
                                                    <strong>
                                                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
                                                    </strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        Status: {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-success rounded-3">
                                        This room has no scheduled reservations yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        @if(auth()->user()->role === 'guest')
                            <a href="{{ route('reservations.create', $room->id) }}"
                               class="btn btn-success rounded-3">
                                Reserve Room
                            </a>
                        @endif

                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <div class="col-12">
            <div class="alert alert-light border rounded-4 text-center">
                No rooms found.
            </div>
        </div>
    @endforelse
</div>

<style>
    .room-card {
        background: #ffffff;
        border-radius: 22px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        height: 100%;
        transition: 0.25s ease;
    }

    .room-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
    }

    .room-image-wrap {
        position: relative;
        height: 230px;
        background: #f8fafc;
    }

    .room-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        display: block;
    }

    .no-image {
        width: 100%;
        height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        background: #f8fafc;
    }

    .room-status {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        color: white;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
    }

    .status-available {
        background: #16a34a;
    }

    .status-reserved {
        background: #6b7280;
    }

    .status-occupied {
        background: #dc2626;
    }

    .status-default {
        background: #111827;
    }

    .room-body {
        padding: 22px;
    }

    .room-price {
        color: #15803d;
        font-weight: 900;
        white-space: nowrap;
    }

    .reserved-dates-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 14px;
        margin-top: 14px;
        font-size: 14px;
    }

    .reserved-date-item {
        margin-top: 8px;
        color: #111827;
    }

    .mini-status {
        display: inline-block;
        margin-left: 6px;
        padding: 3px 7px;
        border-radius: 999px;
        background: #e5e7eb;
        color: #374151;
        font-size: 11px;
        font-weight: 800;
    }

    .available-note {
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 16px;
        padding: 12px 14px;
        margin-top: 14px;
        font-weight: 700;
        font-size: 14px;
    }

    .schedule-list {
        display: grid;
        gap: 10px;
    }

    .schedule-item {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px;
    }
</style>

@endsection