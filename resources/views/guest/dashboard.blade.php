@extends('layouts.app')

@section('content')

@php
    $stats = [
        ['My Reservations', $totalReservations, 'All booking records', 'bi-calendar-check', 'blue'],
        ['Approved', $approvedReservations, 'Confirmed reservations', 'bi-check-circle', 'green'],
        ['Pending', $pendingReservations, 'Waiting for admin approval', 'bi-hourglass-split', 'amber'],
        ['Paid', $paidReservations, 'Completed payments', 'bi-credit-card', 'cyan'],
        ['Bookable Rooms', $bookableRooms, 'Rooms available for date selection', 'bi-building', 'gray'],
    ];
@endphp

<div class="guest-hero mb-4">
    <div>
        <small>Guest Portal</small>
        <h2>Welcome, {{ auth()->user()->name }} 👋</h2>
        <p>
            Manage your reservations, view payment status, and explore available rooms for your next stay.
        </p>

        <div class="hero-actions">
            <a href="{{ route('rooms.index') }}" class="btn btn-light rounded-3 px-4">
                <i class="bi bi-building me-1"></i> Browse Rooms
            </a>

            <a href="{{ route('my.reservations') }}" class="btn btn-outline-light rounded-3 px-4">
                <i class="bi bi-calendar-check me-1"></i> My Reservations
            </a>

            <a href="{{ route('guest.profile.edit') }}" class="btn btn-warning rounded-3 px-4">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
        </div>
    </div>

    <div class="hero-profile">
        @if($guest->profile_photo)
            <img src="{{ asset('storage/' . $guest->profile_photo) }}"
                 class="hero-profile-img"
                 alt="Profile Photo">
        @else
            <div class="hero-profile-initial">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif

        <span>{{ now('Asia/Manila')->format('l') }}</span>
        <strong>{{ now('Asia/Manila')->format('M d, Y') }}</strong>
    </div>
</div>

<div class="logic-note mb-4">
    <i class="bi bi-info-circle"></i>
    <span>
        Reserved rooms may still be booked for different non-overlapping dates. Choose your preferred date when reserving.
    </span>
</div>

<div class="row g-3 mb-4">
    @foreach($stats as $stat)
        <div class="col-md-6 col-xl">
            <div class="guest-stat-card">
                <div>
                    <small>{{ $stat[0] }}</small>
                    <h3>{{ $stat[1] }}</h3>
                    <p>{{ $stat[2] }}</p>
                </div>

                <div class="stat-icon {{ $stat[4] }}">
                    <i class="bi {{ $stat[3] }}"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4 mb-4">

    <div class="col-lg-7">
        <div class="panel h-100">
            <div class="panel-head">
                <div>
                    <h5>Your Current / Upcoming Stay</h5>
                    <p>Quick view of your most important booking.</p>
                </div>
            </div>

            @if($activeStay)
                <div class="featured-booking active">
                    <div class="booking-badge bg-primary">
                        Currently Checked In
                    </div>

                    <h4>Room {{ $activeStay->room->room_no ?? 'N/A' }}</h4>
                    <p class="room-type">{{ $activeStay->room->room_type ?? 'Room' }}</p>

                    <div class="booking-grid">
                        <div>
                            <small>Check In</small>
                            <strong>{{ \Carbon\Carbon::parse($activeStay->check_in_date)->format('M d, Y') }}</strong>
                        </div>

                        <div>
                            <small>Check Out</small>
                            <strong>{{ \Carbon\Carbon::parse($activeStay->check_out_date)->format('M d, Y') }}</strong>
                        </div>

                        <div>
                            <small>Payment</small>
                            @if($activeStay->payment)
                                <strong class="text-success">Paid</strong>
                            @else
                                <strong class="text-warning">Unpaid</strong>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($upcomingReservation)
                <div class="featured-booking">
                    <div class="booking-badge
                        @if($upcomingReservation->status === 'pending') bg-warning text-dark
                        @elseif($upcomingReservation->status === 'accepted') bg-success
                        @else bg-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $upcomingReservation->status)) }}
                    </div>

                    <h4>Room {{ $upcomingReservation->room->room_no ?? 'N/A' }}</h4>
                    <p class="room-type">{{ $upcomingReservation->room->room_type ?? 'Room' }}</p>

                    <div class="booking-grid">
                        <div>
                            <small>Check In</small>
                            <strong>{{ \Carbon\Carbon::parse($upcomingReservation->check_in_date)->format('M d, Y') }}</strong>
                        </div>

                        <div>
                            <small>Check Out</small>
                            <strong>{{ \Carbon\Carbon::parse($upcomingReservation->check_out_date)->format('M d, Y') }}</strong>
                        </div>

                        <div>
                            <small>Payment</small>
                            @if($upcomingReservation->payment)
                                <strong class="text-success">Paid</strong>
                            @elseif($upcomingReservation->status === 'accepted')
                                <a href="{{ route('payments.show', $upcomingReservation->id) }}" class="pay-link">
                                    Pay Now
                                </a>
                            @else
                                <strong class="text-muted">Waiting Approval</strong>
                            @endif
                        </div>
                    </div>

                    @if($upcomingReservation->special_requests)
                        <div class="special-request">
                            <strong>Special Request:</strong>
                            {{ $upcomingReservation->special_requests }}
                        </div>
                    @endif
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                    <h5>No upcoming reservation yet</h5>
                    <p>Browse rooms and create your next booking at Pinnacle Hotel and Suites .</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-dark rounded-3 px-4">
                        Browse Rooms
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel h-100">
            <div class="panel-head">
                <div>
                    <h5>Quick Actions</h5>
                    <p>Common guest actions.</p>
                </div>
            </div>

            <div class="quick-actions">
                <a href="{{ route('rooms.index') }}">
                    <i class="bi bi-building"></i>
                    <div>
                        <strong>Browse Rooms</strong>
                        <span>Choose a room and preferred dates</span>
                    </div>
                </a>

                <a href="{{ route('my.reservations') }}">
                    <i class="bi bi-calendar-check"></i>
                    <div>
                        <strong>My Reservations</strong>
                        <span>View booking and payment status</span>
                    </div>
                </a>

                <a href="{{ route('guest.profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    <div>
                        <strong>Edit Profile</strong>
                        <span>Update your name, phone, address, and photo</span>
                    </div>
                </a>

                @if($upcomingReservation && !$upcomingReservation->payment && $upcomingReservation->status === 'accepted')
                    <a href="{{ route('payments.show', $upcomingReservation->id) }}">
                        <i class="bi bi-credit-card"></i>
                        <div>
                            <strong>Pay Reservation</strong>
                            <span>Complete payment for approved booking</span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-lg-8">
        <div class="panel h-100">
            <div class="panel-head">
                <div>
                    <h5>Recent Reservations</h5>
                    <p>Your latest booking activity.</p>
                </div>

                <a href="{{ route('my.reservations') }}" class="btn btn-outline-dark btn-sm rounded-3">
                    View All
                </a>
            </div>

            <div class="reservation-list">
                @forelse($recentReservations as $reservation)
                    <div class="reservation-item">
                        <div>
                            <strong>Room {{ $reservation->room->room_no ?? 'N/A' }}</strong>
                            <p class="mb-1">
                                {{ $reservation->room->room_type ?? 'Room' }}
                                •
                                {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}
                                to
                                {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}
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
                        No reservations yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel h-100">
            <div class="panel-head">
                <div>
                    <h5>Guest Information</h5>
                    <p>Your registered contact details.</p>
                </div>
            </div>

            <div class="profile-box">
                @if($guest->profile_photo)
                    <img src="{{ asset('storage/' . $guest->profile_photo) }}"
                         class="profile-avatar-img"
                         alt="Profile Photo">
                @else
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                <h5>{{ auth()->user()->name }}</h5>
                <p>{{ auth()->user()->email }}</p>

                <div class="profile-detail">
                    <i class="bi bi-telephone"></i>
                    <span>{{ $guest->phone_number ?? 'No phone number' }}</span>
                </div>

                <div class="profile-detail">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $guest->address ?? 'No address' }}</span>
                </div>

                <a href="{{ route('guest.profile.edit') }}" class="btn btn-dark rounded-3 w-100 mt-3">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>

</div>

<style>
.guest-hero {
    background:
        linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.92)),
        url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1400&auto=format&fit=crop');
    background-size: cover;
    background-position: center;
    color: #ffffff;
    padding: 32px;
    border-radius: 24px;
    display: flex;
    justify-content: space-between;
    gap: 24px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
}

.guest-hero small {
    color: #facc15;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.guest-hero h2 {
    font-weight: 900;
    margin: 10px 0;
}

.guest-hero p {
    max-width: 640px;
    color: rgba(255,255,255,0.82);
}

.hero-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 18px;
}

.hero-profile {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    padding: 16px;
    border-radius: 18px;
    text-align: center;
    height: fit-content;
    min-width: 170px;
}

.hero-profile span {
    display: block;
    color: rgba(255,255,255,0.75);
    font-size: 13px;
    margin-top: 10px;
}

.hero-profile strong {
    display: block;
}

.hero-profile-img,
.hero-profile-initial {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    margin: 0 auto;
}

.hero-profile-img {
    object-fit: cover;
    border: 3px solid #facc15;
}

.hero-profile-initial {
    background: #ffffff;
    color: #1e40af;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 900;
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

.guest-stat-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 20px;
    min-height: 130px;
    display: flex;
    justify-content: space-between;
    gap: 14px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
    height: 100%;
}

.guest-stat-card small {
    color: #64748b;
    font-size: 12px;
    font-weight: 900;
    text-transform: uppercase;
}

.guest-stat-card h3 {
    font-size: 28px;
    font-weight: 900;
    margin: 6px 0;
}

.guest-stat-card p {
    color: #64748b;
    margin-bottom: 0;
    font-size: 13px;
}

.stat-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 20px;
}

.blue { background:#2563eb; }
.green { background:#16a34a; }
.amber { background:#f59e0b; }
.cyan { background:#06b6d4; }
.gray { background:#6b7280; }

.panel {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
}

.panel-head {
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 14px;
    margin-bottom: 20px;
}

.panel-head h5 {
    font-weight: 900;
    margin-bottom: 4px;
}

.panel-head p {
    color: #64748b;
    margin-bottom: 0;
    font-size: 14px;
}

.featured-booking {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 24px;
    position: relative;
}

.featured-booking.active {
    background: #eff6ff;
    border-color: #bfdbfe;
}

.booking-badge {
    display: inline-block;
    color: #ffffff;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 900;
    margin-bottom: 14px;
}

.featured-booking h4 {
    font-weight: 900;
    margin-bottom: 4px;
}

.room-type {
    color: #64748b;
    margin-bottom: 18px;
}

.booking-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.booking-grid div {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 14px;
}

.booking-grid small {
    display: block;
    color: #64748b;
    font-weight: 800;
    margin-bottom: 5px;
}

.booking-grid strong {
    font-weight: 900;
}

.pay-link {
    color: #2563eb;
    font-weight: 900;
    text-decoration: none;
}

.special-request {
    margin-top: 16px;
    padding: 14px;
    border-radius: 14px;
    background: #fff7ed;
    border-left: 4px solid #f59e0b;
}

.empty-state {
    text-align: center;
    padding: 34px 20px;
}

.empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 18px;
    background: #f8fafc;
    color: #1e40af;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
}

.empty-state h5 {
    font-weight: 900;
}

.empty-state p {
    color: #64748b;
}

.quick-actions {
    display: grid;
    gap: 12px;
}

.quick-actions a {
    text-decoration: none;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    color: #111827;
    border-radius: 16px;
    padding: 16px;
    display: flex;
    gap: 14px;
    align-items: center;
    transition: 0.2s ease;
}

.quick-actions a:hover {
    background: #111827;
    color: #ffffff;
    transform: translateX(4px);
}

.quick-actions i {
    color: #f59e0b;
    font-size: 22px;
}

.quick-actions strong {
    display: block;
    font-weight: 900;
}

.quick-actions span {
    color: #64748b;
    font-size: 13px;
}

.quick-actions a:hover span {
    color: rgba(255,255,255,0.75);
}

.reservation-list {
    display: grid;
    gap: 12px;
}

.reservation-item {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    gap: 14px;
}

.reservation-item p,
.reservation-item small {
    color: #64748b;
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

.profile-box {
    text-align: center;
}

.profile-avatar,
.profile-avatar-img {
    width: 74px;
    height: 74px;
    border-radius: 50%;
    margin: 0 auto 16px;
}

.profile-avatar {
    background: linear-gradient(135deg, #0f172a, #1e40af);
    color: #facc15;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 900;
}

.profile-avatar-img {
    object-fit: cover;
    border: 3px solid #facc15;
    display: block;
}

.profile-box h5 {
    font-weight: 900;
    margin-bottom: 4px;
}

.profile-box p {
    color: #64748b;
    margin-bottom: 18px;
}

.profile-detail {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
    margin-bottom: 10px;
}

.profile-detail i {
    color: #1e40af;
}

@media(max-width: 992px) {
    .guest-hero {
        flex-direction: column;
    }

    .hero-profile {
        text-align: left;
    }

    .hero-profile-img,
    .hero-profile-initial {
        margin-left: 0;
    }

    .booking-grid {
        grid-template-columns: 1fr;
    }

    .reservation-item {
        flex-direction: column;
    }
}
</style>

@endsection