@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Staff Dashboard</h2>
    <p class="text-muted mb-0">Monitor daily hotel operations and front desk activity.</p>
</div>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Today Reservations</p>
                <h3 class="card-value">{{ $todayReservations }}</h3>
                <p class="card-subtext">New bookings today</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Pending Approvals</p>
                <h3 class="card-value">{{ $pendingReservations }}</h3>
                <p class="card-subtext">Waiting for action</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Today Payments</p>
                <h3 class="card-value">{{ $todayPayments }}</h3>
                <p class="card-subtext">Transactions today</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Today Revenue</p>
                <h3 class="card-value text-success">₱{{ number_format($todayRevenue, 2) }}</h3>
                <p class="card-subtext">Earnings today</p>
            </div>
        </div>
    </div>

</div>

<div class="row g-4 mt-2">

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Total Rooms</p>
                <h3 class="card-value">{{ $totalRooms }}</h3>
                <p class="card-subtext">All registered rooms</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Available Rooms</p>
                <h3 class="card-value">{{ $availableRooms }}</h3>
                <p class="card-subtext">Ready for booking</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <p class="card-label">Total Reservations</p>
                <h3 class="card-value">{{ $totalReservations }}</h3>
                <p class="card-subtext">All booking records</p>
            </div>
        </div>
    </div>

</div>
@endsection