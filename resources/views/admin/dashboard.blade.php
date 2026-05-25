@extends('layouts.app')

@section('content')

@php
    $bookableRate = $totalRooms ? round(($bookableRooms / $totalRooms) * 100) : 0;

    $stats = [
        ['Total Rooms', $totalRooms, 'All registered rooms', 'bi-building', 'blue'],
        ['Bookable Rooms', $bookableRooms, 'Available for future date selection', 'bi-check-circle', 'green'],
        ['Occupied Today', $occupiedToday, 'Currently checked-in rooms', 'bi-door-closed', 'red'],
        ['Guests', $totalGuests, 'Registered guest accounts', 'bi-people', 'cyan'],
        ['Reservations', $totalReservations, 'All booking records', 'bi-calendar-check', 'amber'],
        ['Revenue', 'PHP '.number_format($totalRevenue, 2), $totalPayments.' payment transaction(s)', 'bi-cash-stack', 'navy', true],
    ];

    $revenueLabels = $revenueChart->pluck('date')->toArray();
    $revenueValues = $revenueChart->pluck('total')->toArray();

    $reservationLabels = $reservationChart->pluck('date')->toArray();
    $reservationValues = $reservationChart->pluck('total')->toArray();
@endphp

<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Admin Dashboard</h2>
    <p class="text-muted mb-0">
        Pinnacle Hotel and Suites  operations overview based on date-based reservation logic.
    </p>
</div>

<div class="hero mb-4">
    <div>
        <small>Business Operations Center</small>
        <h3>Welcome, {{ auth()->user()->name }} 👋</h3>
        <p>
            Monitor room availability, upcoming bookings, active stays, payments, and revenue.
        </p>
    </div>

    <div class="hero-date">
        <span>{{ now('Asia/Manila')->format('l') }}</span>
        <strong>{{ now('Asia/Manila')->format('M d, Y') }}</strong>
    </div>
</div>

<div class="logic-note mb-4">
    <i class="bi bi-info-circle"></i>
    <span>
        Reserved rooms may still be booked for different non-overlapping dates.
        The system blocks only conflicting date ranges.
    </span>
</div>

<div class="row g-3 mb-4">
    @foreach($stats as $s)
        <div class="col-md-4">
            <div class="card-stat {{ $s[5] ?? false ? 'dark' : '' }}">
                <div>
                    <small>{{ $s[0] }}</small>
                    <h3>{{ $s[1] }}</h3>
                    <p>{{ $s[2] }}</p>
                </div>

                <div class="icon {{ $s[4] }}">
                    <i class="bi {{ $s[3] }}"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4 mb-4">

    <div class="col-lg-8">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Room Booking Capacity</h5>
                    <p class="text-muted mb-0">
                        Shows how many rooms are still bookable based on current occupied stays.
                    </p>
                </div>

                <strong>{{ $bookableRate }}%</strong>
            </div>

            <div class="progress mb-4">
                <div class="progress-bar bg-success" style="--progress-width: {{ $bookableRate }}%;"></div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="mini-box">
                        <small>Pending Approval</small>
                        <h4>{{ $pendingReservations }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mini-box">
                        <small>Upcoming Bookings</small>
                        <h4>{{ $upcomingReservations }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mini-box">
                        <small>Active Stays</small>
                        <h4>{{ $activeStays }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel h-100">
            <h5 class="fw-bold mb-3">Quick Actions</h5>

            <div class="actions">
                <a href="{{ route('rooms.index') }}">
                    <i class="bi bi-building"></i> Manage Rooms
                </a>

                <a href="{{ route('reservations.index') }}">
                    <i class="bi bi-calendar-check"></i> Review Reservations
                </a>

                <a href="{{ route('payments.index') }}">
                    <i class="bi bi-credit-card"></i> View Payments
                </a>

                <a href="{{ route('reports.index') }}">
                    <i class="bi bi-file-earmark-pdf"></i> Generate Reports
                </a>
            </div>
        </div>
    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-8">
        <div class="panel h-100">
            <h5 class="fw-bold mb-3">Revenue Trend</h5>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel h-100">
            <h5 class="fw-bold mb-3">Reservation Activity</h5>
            <canvas id="reservationChart" height="190"></canvas>
        </div>
    </div>

</div>

<div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-1">Recent Payments</h5>
            <p class="text-muted mb-0">Latest completed payment transactions.</p>
        </div>

        <a href="{{ route('payments.index') }}" class="btn btn-outline-dark btn-sm rounded-3">
            View All
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentPayments as $payment)
                    <tr>
                        <td>
                            <strong>{{ $payment->reservation->guest->user->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $payment->reservation->guest->user->email ?? '' }}</small>
                        </td>

                        <td>
                            Room {{ $payment->reservation->room->room_no ?? 'N/A' }}<br>
                            <small class="text-muted">{{ $payment->reservation->room->room_type ?? '' }}</small>
                        </td>

                        <td class="text-success fw-bold">
                            PHP {{ number_format($payment->amount, 2) }}
                        </td>

                        <td>
                            {{ $payment->created_at->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No payment records yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.hero {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    color: #ffffff;
    padding: 26px;
    border-radius: 20px;
    display: flex;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 16px 35px rgba(15, 23, 42, 0.16);
}

.hero small {
    color: #facc15;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero h3 {
    font-weight: 900;
    margin: 8px 0;
}

.hero p {
    margin-bottom: 0;
    color: rgba(255,255,255,0.78);
}

.hero-date {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    padding: 14px 18px;
    border-radius: 16px;
    text-align: right;
    height: fit-content;
}

.hero-date span {
    display: block;
    color: rgba(255,255,255,0.75);
    font-size: 13px;
}

.logic-note {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e40af;
    padding: 14px 18px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
}

.card-stat {
    background: #ffffff;
    padding: 20px;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    gap: 16px;
    min-height: 130px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
}

.card-stat.dark {
    background: #111827;
    color: #ffffff;
}

.card-stat small {
    color: #64748b;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 12px;
}

.card-stat.dark small,
.card-stat.dark p {
    color: rgba(255,255,255,0.70);
}

.card-stat h3 {
    font-size: 28px;
    font-weight: 900;
    margin: 6px 0;
}

.card-stat p {
    margin-bottom: 0;
    color: #64748b;
    font-size: 13px;
}

.icon {
    width: 48px;
    height: 48px;
    min-width: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 21px;
}

.blue { background:#2563eb; }
.green { background:#16a34a; }
.red { background:#dc2626; }
.cyan { background:#06b6d4; }
.amber { background:#f59e0b; }
.navy { background:#020617; }

.panel {
    background: #ffffff;
    padding: 24px;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
}

.progress {
    height: 10px;
    background: #e5e7eb;
    border-radius: 999px;
}

.progress-bar {
    height: 10px;
    border-radius: 999px;
    width: var(--progress-width);
}

.mini-box {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    padding: 18px;
    border-radius: 16px;
}

.mini-box small {
    color: #64748b;
    font-weight: 800;
}

.mini-box h4 {
    font-weight: 900;
    margin: 8px 0 0;
}

.actions {
    display: grid;
    gap: 12px;
}

.actions a {
    text-decoration: none;
    color: #111827;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px;
    font-weight: 800;
    transition: 0.2s ease;
}

.actions a:hover {
    background: #111827;
    color: #ffffff;
    transform: translateX(4px);
}

.actions i {
    color: #f59e0b;
    margin-right: 8px;
}

.table thead th {
    background: #111827;
    color: #ffffff;
    font-size: 13px;
}

@media(max-width: 768px) {
    .hero {
        flex-direction: column;
    }

    .hero-date {
        text-align: left;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueLabels = @json($revenueLabels);
    const revenueValues = @json($revenueValues);

    const reservationLabels = @json($reservationLabels);
    const reservationValues = @json($reservationValues);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueValues,
                borderWidth: 3,
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    new Chart(document.getElementById('reservationChart'), {
        type: 'bar',
        data: {
            labels: reservationLabels,
            datasets: [{
                label: 'Reservations',
                data: reservationValues,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection