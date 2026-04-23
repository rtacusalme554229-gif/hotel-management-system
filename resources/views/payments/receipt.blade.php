@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">Payment Successful</h2>
                    <p class="text-muted mb-0">Your payment has been recorded successfully.</p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Receipt ID:</strong></div>
                    <div class="col-md-6 text-md-end">#{{ $payment->id }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Guest Name:</strong></div>
                    <div class="col-md-6 text-md-end">{{ $payment->reservation->guest->user->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Room:</strong></div>
                    <div class="col-md-6 text-md-end">
                        Room {{ $payment->reservation->room->room_no }} - {{ $payment->reservation->room->room_type }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Payment Method:</strong></div>
                    <div class="col-md-6 text-md-end">{{ ucfirst($payment->payment_method) }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6"><strong>Payment Date:</strong></div>
                    <div class="col-md-6 text-md-end">{{ $payment->payment_date }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6"><strong>Total Paid:</strong></div>
                    <div class="col-md-6 text-md-end fw-bold text-success">
                        ₱{{ number_format($payment->amount, 2) }}
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('my.reservations') }}" class="btn btn-dark rounded-3 px-4">
                        Back to My Reservations
                    </a>
                    <a href="{{ route('guest.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection