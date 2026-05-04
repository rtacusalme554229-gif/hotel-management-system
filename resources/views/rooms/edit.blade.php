@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 fw-bold">Edit Room</h3>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('rooms.update', $room->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Room No</label>
                    <input type="text" name="room_no" class="form-control rounded-3" value="{{ old('room_no', $room->room_no) }}" required>
                    @error('room_no') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Type</label>
                    <input type="text" name="room_type" class="form-control rounded-3" value="{{ old('room_type', $room->room_type) }}" required>
                    @error('room_type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor</label>
                    <input type="text" name="floor" class="form-control rounded-3" value="{{ old('floor', $room->floor) }}" required>
                    @error('floor') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control rounded-3" value="{{ old('price', $room->price) }}" required>
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Room Status</label>
                    <div class="alert alert-light border rounded-3 mb-0">
                        <strong>{{ ucfirst($room->status) }}</strong>
                        <br>
                        <small class="text-muted">
                            Status is automatically updated by reservation, check-in, and check-out actions.
                        </small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Room Image</label>
                    <input type="file" name="image" class="form-control rounded-3">
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                @if($room->image)
                    <div class="mb-3">
                        <p class="mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $room->image) }}"
                             alt="Room Image"
                             width="180"
                             class="rounded-3 shadow-sm">
                    </div>
                @endif

                <button type="submit" class="btn btn-primary rounded-3">Update Room</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary rounded-3">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection