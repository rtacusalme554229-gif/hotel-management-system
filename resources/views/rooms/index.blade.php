@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">Rooms</h2>
        <p class="text-muted mb-0">
            @if(auth()->user()->role === 'guest')
                Browse available rooms and choose the best one for your stay
            @else
                Manage all hotel rooms and availability
            @endif
        </p>
    </div>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('rooms.create') }}" class="btn btn-primary rounded-3 px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Add Room
        </a>
    @endif
</div>

<div class="row g-4">

@forelse($rooms as $room)
    <div class="col-md-4">
        <div class="card shadow-sm rounded-4 border-0 h-100">

            <!-- CLICKABLE IMAGE / TOP -->
            <button type="button"
                    class="border-0 bg-transparent p-0 text-start"
                    data-bs-toggle="modal"
                    data-bs-target="#roomModal{{ $room->id }}">
                @if($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}"
                         alt="Room Image"
                         style="height:200px; width:100%; object-fit:cover; border-radius:15px 15px 0 0;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light text-muted"
                         style="height:200px; border-radius:15px 15px 0 0;">
                        No Image
                    </div>
                @endif
            </button>

            <!-- BODY -->
            <div class="card-body">
                <h5 class="fw-bold mb-1">Room {{ $room->room_no }}</h5>
                <p class="text-muted mb-1">{{ $room->room_type }}</p>

                <p class="mb-1">
                    <small class="text-muted">Floor:</small>
                    <strong>{{ $room->floor }}</strong>
                </p>

                <p class="fw-bold text-success mb-2">
                    ₱{{ number_format($room->price, 2) }}
                </p>

                <span class="badge bg-{{
                    $room->status == 'available' ? 'success' :
                    ($room->status == 'occupied' ? 'danger' : 'secondary')
                }}">
                    {{ ucfirst($room->status) }}
                </span>
            </div>

            <!-- ACTIONS -->
            <div class="card-footer bg-white border-0">

                @if(auth()->user()->role === 'admin')
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <button type="button"
                                class="btn btn-sm btn-outline-dark rounded-3"
                                data-bs-toggle="modal"
                                data-bs-target="#roomModal{{ $room->id }}">
                            View
                        </button>

                        <a href="{{ route('rooms.edit', $room->id) }}"
                           class="btn btn-sm btn-outline-primary rounded-3">
                            Edit
                        </a>

                        <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                              onsubmit="return confirm('Delete this room?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger rounded-3">
                                Delete
                            </button>
                        </form>
                    </div>

                @elseif(in_array(auth()->user()->role, ['staff', 'manager']))
                    <div class="d-grid gap-2">
                        <button type="button"
                                class="btn btn-sm btn-outline-dark rounded-3"
                                data-bs-toggle="modal"
                                data-bs-target="#roomModal{{ $room->id }}">
                            View Details
                        </button>
                    </div>

                @elseif(auth()->user()->role === 'guest')
                    <div class="d-grid gap-2">
                        <button type="button"
                                class="btn btn-outline-dark rounded-3"
                                data-bs-toggle="modal"
                                data-bs-target="#roomModal{{ $room->id }}">
                            View Details
                        </button>

                        @if($room->status === 'available')
                            <a href="{{ route('reservations.create', $room->id) }}"
                               class="btn btn-success rounded-3">
                                Reserve Room
                            </a>
                        @else
                            <button class="btn btn-secondary rounded-3" disabled>
                                Not Available
                            </button>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ROOM DETAILS MODAL -->
    <div class="modal fade" id="roomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Room {{ $room->room_no }} Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4 align-items-start">

                        <div class="col-md-6">
                            @if($room->image)
                                <img src="{{ asset('storage/' . $room->image) }}"
                                     alt="Room Image"
                                     class="img-fluid rounded-4 shadow-sm"
                                     style="width:100%; height:300px; object-fit:cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-4 shadow-sm"
                                     style="width:100%; height:300px;">
                                    No Image Available
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Room Number</small>
                                <h4 class="fw-bold mb-0">Room {{ $room->room_no }}</h4>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Room Type</small>
                                <strong>{{ ucfirst($room->room_type) }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Floor</small>
                                <strong>{{ $room->floor }}</strong>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Price</small>
                                <strong class="text-success fs-5">₱{{ number_format($room->price, 2) }}</strong>
                            </div>

                            <div class="mb-4">
                                <small class="text-muted d-block mb-1">Status</small>
                                <span class="badge bg-{{
                                    $room->status == 'available' ? 'success' :
                                    ($room->status == 'occupied' ? 'danger' : 'secondary')
                                }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>

                            <div class="border rounded-4 p-3 bg-light">
                                <small class="text-muted d-block mb-2">Room Overview</small>
                                <p class="mb-0">
                                    This {{ $room->room_type }} room is located on floor {{ $room->floor }} and is currently
                                    <strong>{{ $room->status }}</strong>.
                                    It is priced at <strong>₱{{ number_format($room->price, 2) }}</strong>.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-primary rounded-3">
                            Edit Room
                        </a>
                    @endif

                    @if(auth()->user()->role === 'guest')
                        @if($room->status === 'available')
                            <a href="{{ route('reservations.create', $room->id) }}" class="btn btn-success rounded-3">
                                Reserve This Room
                            </a>
                        @else
                            <button class="btn btn-secondary rounded-3" disabled>
                                Not Available
                            </button>
                        @endif
                    @endif

                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>

@empty

    <div class="col-12 text-center py-5">
        <h5 class="text-muted">No rooms found</h5>
        <p class="text-muted">
            @if(auth()->user()->role === 'admin')
                Start by adding your first room
            @else
                No rooms are available right now
            @endif
        </p>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('rooms.create') }}" class="btn btn-primary rounded-3 mt-2">
                Add Room
            </a>
        @endif
    </div>

@endforelse

</div>

@endsection