@extends('layouts.app')

@section('content')
@php
    $hour = now()->format('H');

    if ($hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour < 18) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
    }
@endphp

<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Guest Dashboard</h2>
    <p class="text-muted mb-0">Track your bookings, approvals, and payments.</p>
</div>

<!-- PREMIUM WELCOME CARD -->
<div class="card border-0 shadow-sm rounded-4 mb-4"
     style="background: linear-gradient(135deg, #1e3a8a, #2563eb); color: white;">
    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">

        <div>
            <h4 class="fw-bold mb-1">
                {{ $greeting }}, {{ auth()->user()->name }} 👋
            </h4>
            <p class="mb-0 opacity-75">
                Welcome back! Here's a quick overview of your bookings and payments.
            </p>
        </div>

        <div class="text-end mt-3 mt-md-0">
            <small class="opacity-75 d-block">
                {{ now()->format('l, F d, Y') }}
            </small>
            <small class="opacity-75 d-block">
                {{ now()->format('h:i A') }}
            </small>
        </div>

    </div>
</div>

<!-- SMART ALERT -->
@if($approvedReservations > $paidReservations)
    <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">
        <strong>Reminder:</strong> You have approved reservation(s) waiting for payment.
    </div>
@endif

<div class="row g-4 mb-4">

    <!-- TOTAL RESERVATIONS -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Reservations</p>
                        <h3 class="card-value">{{ $totalReservations }}</h3>
                        <p class="card-subtext">Total booking records</p>
                    </div>
                    <div class="dashboard-icon icon-blue">
                        <i class="bi bi-journal-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- APPROVED -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Approved</p>
                        <h3 class="card-value">{{ $approvedReservations }}</h3>
                        <p class="card-subtext">Approved reservations</p>
                    </div>
                    <div class="dashboard-icon icon-green">
                        <i class="bi bi-patch-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAID -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Paid</p>
                        <h3 class="card-value">{{ $paidReservations }}</h3>
                        <p class="card-subtext">Completed payments</p>
                    </div>
                    <div class="dashboard-icon icon-dark">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- LATEST RESERVATION -->
<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <div>
                <h5 class="fw-bold mb-1">Latest Reservation</h5>
                <p class="text-muted mb-0">Your most recent booking details</p>
            </div>
        </div>

        @if($latestReservation)
            <div class="row g-4 align-items-center">

                <div class="col-md-4">
                    @if(!empty($latestReservation->room->image))
                        <img
                            src="{{ asset('storage/' . $latestReservation->room->image) }}"
                            alt="Room Image"
                            class="img-fluid rounded-4 shadow-sm"
                            style="width: 100%; height: 220px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-4 bg-light text-muted shadow-sm"
                             style="width: 100%; height: 220px;">
                            No Room Image
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Room</small>
                                <strong>Room {{ $latestReservation->room->room_no }} - {{ $latestReservation->room->room_type }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Status</small>
                                <span class="badge
                                    @if($latestReservation->status === 'pending') bg-warning text-dark
                                    @elseif($latestReservation->status === 'accepted') bg-success
                                    @elseif($latestReservation->status === 'declined') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($latestReservation->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Check In</small>
                                <strong>{{ $latestReservation->check_in_date }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Check Out</small>
                                <strong>{{ $latestReservation->check_out_date }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Guests</small>
                                <strong>{{ $latestReservation->number_of_guests }}</strong>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-3 h-100">
                                <small class="text-muted d-block mb-1">Total Amount</small>
                                <strong class="text-success">₱{{ number_format($latestReservation->total_amount, 2) }}</strong>
                            </div>
                        </div>

                        @if(!empty($latestReservation->special_requests))
                            <div class="col-12">
                                <div class="border rounded-4 p-3">
                                    <small class="text-muted d-block mb-1">Special Requests</small>
                                    <strong>{{ $latestReservation->special_requests }}</strong>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-2 text-muted">
                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                </div>
                <h6 class="fw-bold">No reservation yet</h6>
                <p class="text-muted mb-0">Start by browsing rooms and making your first booking.</p>
            </div>
        @endif
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="row g-3">
    <div class="col-md-6">
        <a href="{{ route('rooms.index') }}"
           class="btn btn-success w-100 rounded-4 py-3 fw-semibold shadow-sm">
            <i class="bi bi-building me-2"></i> Browse Rooms
        </a>
    </div>

    <div class="col-md-6">
        <a href="{{ route('my.reservations') }}"
           class="btn btn-dark w-100 rounded-4 py-3 fw-semibold shadow-sm">
            <i class="bi bi-journal-text me-2"></i> My Reservations
        </a>
    </div>
</div>
@endsection