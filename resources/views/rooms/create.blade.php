@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Add Room</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Room Number</label>
                <input type="text" name="room_no" class="form-control" value="{{ old('room_no') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Room Type</label>
                <input type="text" name="room_type" class="form-control" value="{{ old('room_type') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Floor</label>
                <input type="number" name="floor" class="form-control" value="{{ old('floor') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                    <option value="occupied">Occupied</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Save Room</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection