@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Admin Dashboard</h2>
    <p class="text-muted mb-0">Overview of hotel operations, reservations, and revenue.</p>
</div>

<div class="row g-4">

    <!-- ROOMS -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Rooms</p>
                        <h3 class="card-value">{{ $totalRooms }}</h3>
                        <p class="card-subtext">Total registered rooms</p>
                    </div>
                    <div class="dashboard-icon icon-blue">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AVAILABLE -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Available</p>
                        <h3 class="card-value">{{ $availableRooms }}</h3>
                        <p class="card-subtext">Rooms ready for booking</p>
                    </div>
                    <div class="dashboard-icon icon-green">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GUESTS -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Guests</p>
                        <h3 class="card-value">{{ $totalGuests }}</h3>
                        <p class="card-subtext">Registered guest accounts</p>
                    </div>
                    <div class="dashboard-icon icon-cyan">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RESERVATIONS -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Reservations</p>
                        <h3 class="card-value">{{ $totalReservations }}</h3>
                        <p class="card-subtext">All booking records</p>
                    </div>
                    <div class="dashboard-icon icon-yellow">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAYMENTS -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Payments</p>
                        <h3 class="card-value">{{ $totalPayments }}</h3>
                        <p class="card-subtext">Successful payment records</p>
                    </div>
                    <div class="dashboard-icon icon-gray">
                        <i class="bi bi-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REVENUE -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Revenue</p>
                        <h3 class="card-value text-success">₱{{ number_format($totalRevenue, 2) }}</h3>
                        <p class="card-subtext">Total collected payments</p>
                    </div>
                    <div class="dashboard-icon icon-dark">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection