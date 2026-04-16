@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning">
        <h4 class="mb-0">Edit Room</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Room Number</label>
                <input type="text" name="room_no" class="form-control" value="{{ old('room_no', $room->room_no) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Room Type</label>
                <input type="text" name="room_type" class="form-control" value="{{ old('room_type', $room->room_type) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Floor</label>
                <input type="number" name="floor" class="form-control" value="{{ old('floor', $room->floor) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $room->price) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="reserved" {{ $room->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="inactive" {{ $room->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Room</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection