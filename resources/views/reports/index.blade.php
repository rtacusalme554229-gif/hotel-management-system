@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1">Reports Dashboard</h2>
        <p class="text-muted mb-0">Business overview of hotel operations, reservations, and revenue.</p>
    </div>

    <a href="{{ route('reports.download', request()->query()) }}" class="btn btn-dark rounded-3 px-4 shadow-sm">
        <i class="bi bi-file-earmark-pdf me-2"></i> Download PDF
    </a>
</div>

<div class="card border-0 rounded-4 shadow-sm mb-4">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Start Date</label>
                    <input type="date" name="start_date" class="form-control rounded-3" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">End Date</label>
                    <input type="date" name="end_date" class="form-control rounded-3" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-3 flex-fill">
                        Filter Report
                    </button>

                    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary rounded-3 flex-fill">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if($data['startDate'] && $data['endDate'])
    <div class="alert alert-info border-0 rounded-4 shadow-sm mb-4">
        Showing report from
        <strong>{{ $data['startDate'] }}</strong>
        to
        <strong>{{ $data['endDate'] }}</strong>.
    </div>
@endif

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Total Rooms</p>
                        <h3 class="card-value">{{ $data['totalRooms'] }}</h3>
                        <p class="card-subtext">Registered hotel rooms</p>
                    </div>
                    <div class="dashboard-icon icon-blue">
                        <i class="bi bi-building"></i>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Available</span>
                    <strong>{{ $data['availableRooms'] }}</strong>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Reserved</span>
                    <strong>{{ $data['reservedRooms'] }}</strong>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Occupied</span>
                    <strong>{{ $data['occupiedRooms'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Reservations</p>
                        <h3 class="card-value">{{ $data['totalReservations'] }}</h3>
                        <p class="card-subtext">Reservation records</p>
                    </div>
                    <div class="dashboard-icon icon-yellow">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>

                <hr>

                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-warning text-dark">Pending: {{ $data['pendingReservations'] }}</span>
                    <span class="badge bg-success">Accepted: {{ $data['acceptedReservations'] }}</span>
                    <span class="badge bg-primary">Checked In: {{ $data['checkedInReservations'] }}</span>
                    <span class="badge bg-secondary">Checked Out: {{ $data['checkedOutReservations'] }}</span>
                    <span class="badge bg-danger">Declined: {{ $data['declinedReservations'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label">Revenue</p>
                        <h3 class="card-value text-success">₱{{ number_format($data['totalRevenue'], 2) }}</h3>
                        <p class="card-subtext">{{ $data['totalPayments'] }} payment transaction(s)</p>
                    </div>
                    <div class="dashboard-icon icon-dark">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>

                <hr>

                <div class="small text-muted">
                    Generated at:<br>
                    <strong class="text-dark">{{ $data['generatedAt'] }}</strong>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Business Summary</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Category</th>
                        <th>Metric</th>
                        <th class="text-center">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rooms</td>
                        <td>Available Rooms</td>
                        <td class="text-center">{{ $data['availableRooms'] }}</td>
                    </tr>
                    <tr>
                        <td>Rooms</td>
                        <td>Occupied Rooms</td>
                        <td class="text-center">{{ $data['occupiedRooms'] }}</td>
                    </tr>
                    <tr>
                        <td>Reservations</td>
                        <td>Checked In Guests</td>
                        <td class="text-center">{{ $data['checkedInReservations'] }}</td>
                    </tr>
                    <tr>
                        <td>Reservations</td>
                        <td>Checked Out Guests</td>
                        <td class="text-center">{{ $data['checkedOutReservations'] }}</td>
                    </tr>
                    <tr>
                        <td>Payments</td>
                        <td>Total Revenue</td>
                        <td class="text-center fw-bold text-success">₱{{ number_format($data['totalRevenue'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection