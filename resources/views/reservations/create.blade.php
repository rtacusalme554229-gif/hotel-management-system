@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Reserve Room {{ $room->room_no }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf

            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="mb-3">
                <label class="form-label">Room Number</label>
                <input type="text" class="form-control" value="{{ $room->room_no }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Room Type</label>
                <input type="text" class="form-control" value="{{ $room->room_type }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Price per Day</label>
                <input type="text" class="form-control" value="₱{{ number_format($room->price, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Check In Date</label>
                <input type="date" name="check_in_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Check Out Date</label>
                <input type="date" name="check_out_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Number of Guests</label>
                <input type="number" name="number_of_guests" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Special Requests</label>
                <textarea name="special_requests" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit Reservation</button>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection