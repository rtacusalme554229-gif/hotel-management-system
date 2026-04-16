@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Guest Dashboard</h2>

    <div class="alert alert-success">
        Welcome, {{ auth()->user()->name }} 👋
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h5>Total Reservations</h5>
                    <h2>{{ $totalReservations }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h5>Approved Reservations</h5>
                    <h2>{{ $approvedReservations }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body">
                    <h5>Paid Reservations</h5>
                    <h2>{{ $paidReservations }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            Latest Reservation
        </div>
        <div class="card-body">
            @if($latestReservation)
                <p><strong>Room:</strong> {{ $latestReservation->room->room_no }} - {{ $latestReservation->room->room_type }}</p>
                <p><strong>Check In:</strong> {{ $latestReservation->check_in_date }}</p>
                <p><strong>Check Out:</strong> {{ $latestReservation->check_out_date }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge
                        @if($latestReservation->status === 'pending') bg-warning text-dark
                        @elseif($latestReservation->status === 'accepted') bg-success
                        @elseif($latestReservation->status === 'declined') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($latestReservation->status) }}
                    </span>
                </p>
            @else
                <p class="mb-0">No reservation yet.</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('rooms.index') }}" class="btn btn-success w-100">Browse Rooms</a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="{{ route('my.reservations') }}" class="btn btn-primary w-100">My Reservations</a>
        </div>
    </div>
</div>
@endsection