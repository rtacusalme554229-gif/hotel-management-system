@extends('layouts.app')

@section('content')

@php
    $rate = $totalRooms ? round($availableRooms / $totalRooms * 100) : 0;

    $stats = [
        ['Rooms', $totalRooms, 'bi-building', 'blue'],
        ['Available', $availableRooms, 'bi-check-circle', 'green'],
        ['Guests', $totalGuests, 'bi-people', 'cyan'],
        ['Reservations', $totalReservations, 'bi-calendar-check', 'amber'],
        ['Payments', $totalPayments, 'bi-credit-card', 'gray'],
        ['Revenue', '₱'.number_format($totalRevenue,2), 'bi-cash-stack', 'navy', true],
    ];
@endphp

<div class="mb-4">
    <h2 class="fw-bold">Admin Dashboard</h2>
    <p class="text-muted">StayEase Hotel operations overview.</p>
</div>

<!-- HERO -->
<div class="hero mb-4">
    <div>
        <small>Business Center</small>
        <h3>Welcome, {{ auth()->user()->name }} 👋</h3>
        <p>Monitor hotel performance, bookings, and revenue.</p>
    </div>
    <div>
        <strong>{{ now()->format('M d, Y') }}</strong>
    </div>
</div>

<!-- STATS -->
<div class="row g-3 mb-4">
    @foreach($stats as $s)
    <div class="col-md-4">
        <div class="card-stat {{ $s[5] ?? '' ? 'dark' : '' }}">
            <div>
                <small>{{ $s[0] }}</small>
                <h3>{{ $s[1] }}</h3>
            </div>
            <div class="icon {{ $s[3] }}">
                <i class="bi {{ $s[2] }}"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- PERFORMANCE + ACTIONS -->
<div class="row g-4 mb-4">

    <div class="col-lg-8">
        <div class="panel">
            <h5>Performance</h5>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span>Room Availability</span>
                    <strong>{{ $rate }}%</strong>
                </div>

                <div class="progress">
                    <div class="progress-bar bg-success" style="--progress-width: {{ $rate }}%;"></div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mini-box">
                        <small>Reservations</small>
                        <h4>{{ $totalReservations }}</h4>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mini-box">
                        <small>Revenue</small>
                        <h4>₱{{ number_format($totalRevenue,2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel">
            <h5>Quick Actions</h5>

            <div class="actions">
                @foreach([
                    ['rooms.index','Manage Rooms'],
                    ['reservations.index','Reservations'],
                    ['payments.index','Payments'],
                    ['reports.index','Reports']
                ] as $a)
                    <a href="{{ route($a[0]) }}">{{ $a[1] }}</a>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- RECENT PAYMENTS -->
<div class="panel">
    <h5>Recent Payments</h5>

    <table class="table">
        <thead>
            <tr>
                <th>Guest</th>
                <th>Room</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentPayments as $p)
            <tr>
                <td>{{ $p->reservation->guest->user->name ?? 'N/A' }}</td>
                <td>Room {{ $p->reservation->room->room_no ?? '-' }}</td>
                <td class="text-success fw-bold">₱{{ number_format($p->amount,2) }}</td>
            </tr>
            @empty
            <tr><td colspan="3">No data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.hero{
    background:#0f172a;color:#fff;padding:20px;border-radius:15px;
    display:flex;justify-content:space-between;
}

.card-stat{
    background:#fff;padding:15px;border-radius:12px;
    display:flex;justify-content:space-between;
    border:1px solid #eee;
}
.card-stat.dark{background:#111827;color:#fff;}

.icon{
    width:45px;height:45px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;color:#fff;
}
.blue{background:#2563eb;}
.green{background:#16a34a;}
.cyan{background:#06b6d4;}
.amber{background:#f59e0b;}
.gray{background:#6b7280;}
.navy{background:#020617;}

.panel{
    background:#fff;padding:20px;border-radius:12px;border:1px solid #eee;
}

.mini-box{
    background:#f8fafc;padding:15px;border-radius:10px;
}

.actions a{
    display:block;padding:10px;margin-bottom:8px;
    background:#f1f5f9;border-radius:8px;text-decoration:none;
}

.actions a:hover{background:#111827;color:#fff;}

.progress{height:8px;background:#eee;border-radius:10px;}
.progress-bar {
    height: 9px;
    border-radius: 999px;
    width: var(--progress-width);
}
</style>

@endsection