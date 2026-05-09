@extends('layouts.app')

@section('content')

@php
    $bookableRate = $totalRooms ? round(($bookableRooms / $totalRooms) * 100) : 0;

    $stats = [
        ['Bookable Rooms', $bookableRooms, 'Rooms available for future dates', 'bi-check-circle', 'green'],
        ['Active Stays', $activeStays, 'Guests currently checked in', 'bi-door-closed', 'blue'],
        ['Today Arrivals', $todayCheckIns, 'Expected check-ins today', 'bi-box-arrow-in-right', 'amber'],
        ['Today Departures', $todayCheckOuts, 'Expected check-outs today', 'bi-box-arrow-right', 'cyan'],
        ['Pending Requests', $pendingReservations, 'Waiting for admin approval', 'bi-hourglass-split', 'gray'],
        ['Today Revenue', 'PHP '.number_format($todayRevenue, 2), $todayPayments.' payment transaction(s)', 'bi-cash-stack', 'navy', true],
    ];
@endphp

<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Staff Dashboard</h2>
    <p class="text-muted mb-0">
        Front desk operations overview for check-ins, check-outs, rooms, and daily activity.
    </p>
</div>

<div class="staff-hero mb-4">
    <div>
        <small>Front Desk Operations</small>
        <h3>Welcome, {{ auth()->user()->name }} 👋</h3>
        <p>
            Manage guest arrivals, departures, active stays, and daily front desk transactions.
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
        Rooms are date-based. A reserved room can still be booked for another non-overlapping date.
    </span>
</div>

<div class="row g-3 mb-4">
    @foreach($stats as $s)
        <div class="col-md-4">
            <div class="staff-card {{ $s[5] ?? false ? 'dark' : '' }}">
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
                        Based on current active stays, not future reservations.
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
                        <small>Completed Check-ins</small>
                        <h4>{{ $completedCheckIns }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mini-box">
                        <small>Completed Check-outs</small>
                        <h4>{{ $completedCheckOuts }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mini-box">
                        <small>Upcoming Bookings</small>
                        <h4>{{ $upcomingReservations }}</h4>
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
                    <i class="bi bi-building"></i> View Rooms
                </a>

                <a href="{{ route('reservations.index') }}">
                    <i class="bi bi-calendar-check"></i> Check In / Check Out
                </a>

                <a href="{{ route('payments.index') }}">
                    <i class="bi bi-credit-card"></i> View Payments
                </a>

                <a href="{{ route('reports.index') }}">
                    <i class="bi bi-file-earmark-pdf"></i> View Reports
                </a>

                <a href="{{ route('activity-logs.index') }}">
                    <i class="bi bi-clock-history"></i> Activity Logs
                </a>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-lg-6">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Today’s Arrivals</h5>
                    <p class="text-muted mb-0">Guests scheduled to check in today.</p>
                </div>

                <span class="pill">{{ $todayArrivals->count() }}</span>
            </div>

            <div class="operation-list">
                @forelse($todayArrivals as $reservation)
                    <div class="operation-item">
                        <div>
                            <strong>{{ $reservation->guest->user->name ?? 'N/A' }}</strong>

                            <p class="mb-1">
                                Room {{ $reservation->room->room_no ?? 'N/A' }}
                                • {{ $reservation->room->room_type ?? '' }}
                            </p>

                            <small>
                                Payment:
                                @if($reservation->payment)
                                    <span class="text-success fw-bold">Paid</span>
                                @else
                                    <span class="text-warning fw-bold">Unpaid</span>
                                @endif
                            </small>
                        </div>

                        <span class="status status-{{ $reservation->status }}">
                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                        </span>
                    </div>
                @empty
                    <div class="empty-box">
                        No scheduled arrivals today.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Today’s Departures</h5>
                    <p class="text-muted mb-0">Guests scheduled to check out today.</p>
                </div>

                <span class="pill">{{ $todayDepartures->count() }}</span>
            </div>

            <div class="operation-list">
                @forelse($todayDepartures as $reservation)
                    <div class="operation-item">
                        <div>
                            <strong>{{ $reservation->guest->user->name ?? 'N/A' }}</strong>

                            <p class="mb-1">
                                Room {{ $reservation->room->room_no ?? 'N/A' }}
                                • {{ $reservation->room->room_type ?? '' }}
                            </p>

                            @if($reservation->checked_in_at)
                                <small>
                                    Checked in:
                                    {{ $reservation->checked_in_at->format('M d, Y h:i A') }}
                                </small>
                            @else
                                <small class="text-muted">Not checked in yet</small>
                            @endif
                        </div>

                        <span class="status status-{{ $reservation->status }}">
                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                        </span>
                    </div>
                @empty
                    <div class="empty-box">
                        No scheduled departures today.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<style>
.staff-hero {
    background: linear-gradient(135deg, #0f172a, #1e40af);
    color: #ffffff;
    padding: 26px;
    border-radius: 20px;
    display: flex;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 16px 35px rgba(15, 23, 42, 0.16);
}

.staff-hero small {
    color: #facc15;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.staff-hero h3 {
    font-weight: 900;
    margin: 8px 0;
}

.staff-hero p {
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

.staff-card {
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

.staff-card.dark {
    background: #111827;
    color: #ffffff;
}

.staff-card small {
    color: #64748b;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 12px;
}

.staff-card.dark small,
.staff-card.dark p {
    color: rgba(255,255,255,0.70);
}

.staff-card h3 {
    font-size: 28px;
    font-weight: 900;
    margin: 6px 0;
}

.staff-card p {
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

.green { background:#16a34a; }
.blue { background:#2563eb; }
.amber { background:#f59e0b; }
.cyan { background:#06b6d4; }
.gray { background:#6b7280; }
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

.operation-list {
    display: grid;
    gap: 12px;
}

.operation-item {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    gap: 14px;
}

.operation-item p {
    color: #64748b;
}

.operation-item small {
    color: #64748b;
}

.pill {
    background: #111827;
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 900;
}

.status {
    height: fit-content;
    white-space: nowrap;
    padding: 6px 10px;
    border-radius: 999px;
    color: #ffffff;
    font-size: 11px;
    font-weight: 900;
}

.status-pending {
    background: #f59e0b;
    color: #111827;
}

.status-accepted {
    background: #16a34a;
}

.status-checked_in {
    background: #2563eb;
}

.status-checked_out {
    background: #6b7280;
}

.status-declined {
    background: #dc2626;
}

.empty-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    color: #64748b;
}

@media(max-width: 768px) {
    .staff-hero {
        flex-direction: column;
    }

    .hero-date {
        text-align: left;
    }

    .operation-item {
        flex-direction: column;
    }
}
</style>

@endsection