@extends('layouts.app')

@section('content')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Reports Dashboard</h2>
    <p class="text-muted mb-0">Overview of system performance and operations</p>
</div>

<div class="row g-4">

    <!-- ROOMS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <small class="text-muted fw-semibold text-uppercase">Rooms</small>
                <h3 class="fw-bold mt-2">{{ $totalRooms }}</h3>
                <div class="mt-3 small text-muted">
                    Available: <strong>{{ $availableRooms }}</strong><br>
                    Reserved: <strong>{{ $reservedRooms }}</strong><br>
                    Occupied: <strong>{{ $occupiedRooms }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- GUESTS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <small class="text-muted fw-semibold text-uppercase">Guests</small>
                <h3 class="fw-bold mt-2">{{ $totalGuests }}</h3>
                <p class="text-muted mt-3 mb-0">Total registered users</p>
            </div>
        </div>
    </div>

    <!-- RESERVATIONS -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <small class="text-muted fw-semibold text-uppercase">Reservations</small>
                <h3 class="fw-bold mt-2">{{ $totalReservations }}</h3>

                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <span class="badge bg-warning text-dark px-3 py-2">
                        Pending: {{ $pendingReservations }}
                    </span>
                    <span class="badge bg-success px-3 py-2">
                        Accepted: {{ $acceptedReservations }}
                    </span>
                    <span class="badge bg-danger px-3 py-2">
                        Declined: {{ $declinedReservations }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- PAYMENTS -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <small class="text-muted fw-semibold text-uppercase">Payments</small>
                <h3 class="fw-bold mt-2">{{ $totalPayments }}</h3>
                <p class="text-muted mt-3 mb-0">Completed transactions</p>
            </div>
        </div>
    </div>

    <!-- REVENUE -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <small class="text-muted fw-semibold text-uppercase">Revenue</small>
                <h3 class="fw-bold mt-2 text-success">
                    ₱{{ number_format($totalRevenue, 2) }}
                </h3>
                <p class="text-muted mt-3 mb-0">Total earnings</p>
            </div>
        </div>
    </div>

</div>

<!-- CHARTS -->
<div class="row mt-4 g-4">

    <!-- REVENUE CHART -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Revenue Trend</h5>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- RESERVATION CHART -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Reservations Trend</h5>
                <canvas id="reservationChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
    // Convert PHP → JS safely
    const revenueLabels = JSON.parse('@json($revenueLabels)');
    const revenueValues = JSON.parse('@json($revenueValues)');

    const reservationLabels = JSON.parse('@json($reservationLabels)');
    const reservationValues = JSON.parse('@json($reservationValues)');

    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueValues,
                borderColor: '#16a34a',
                backgroundColor: 'rgba(22,163,74,0.15)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });

    // Reservation Chart
    new Chart(document.getElementById('reservationChart'), {
        type: 'bar',
        data: {
            labels: reservationLabels,
            datasets: [{
                label: 'Reservations',
                data: reservationValues,
                backgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
</script>
@endsection