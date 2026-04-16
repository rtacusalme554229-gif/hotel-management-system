@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h5>Total Rooms</h5>
                    <h2>{{ $totalRooms }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h5>Available Rooms</h5>
                    <h2>{{ $availableRooms }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-info text-white">
                <div class="card-body">
                    <h5>Total Guests</h5>
                    <h2>{{ $totalGuests }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-warning text-dark">
                <div class="card-body">
                    <h5>Total Reservations</h5>
                    <h2>{{ $totalReservations }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-secondary text-white">
                <div class="card-body">
                    <h5>Total Payments</h5>
                    <h2>{{ $totalPayments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h2>₱{{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection