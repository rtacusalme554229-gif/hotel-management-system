@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Rooms</h2>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">Add Room</a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Room No</th>
                    <th>Room Type</th>
                    <th>Floor</th>
                    <th>Price</th>
                    <th>Status</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Actions</th>
                    @elseif(auth()->user()->role === 'guest')
                        <th>Reserve</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->id }}</td>
                        <td>{{ $room->room_no }}</td>
                        <td>{{ $room->room_type }}</td>
                        <td>{{ $room->floor }}</td>
                        <td>₱{{ number_format($room->price, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($room->status == 'available') bg-success
                                @elseif($room->status == 'reserved') bg-warning text-dark
                                @elseif($room->status == 'occupied') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>

                        @if(auth()->user()->role === 'admin')
                            <td>
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @elseif(auth()->user()->role === 'guest')
                            <td>
                                @if($room->status === 'available')
                                    <a href="{{ route('reservations.create', $room->id) }}" class="btn btn-sm btn-success">
                                        Reserve
                                    </a>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No rooms found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection