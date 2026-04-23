@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">Payment Details</h2>
    <p class="text-muted mb-0">Review your booking charges before confirming payment.</p>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Reservation Summary</h5>

                <div class="mb-3">
                    <strong>Guest:</strong> {{ $reservation->guest->user->name }}
                </div>

                <div class="mb-3">
                    <strong>Room:</strong> Room {{ $reservation->room->room_no }} - {{ $reservation->room->room_type }}
                </div>

                <div class="mb-3">
                    <strong>Check In:</strong> {{ $reservation->check_in_date }}
                </div>

                <div class="mb-3">
                    <strong>Check Out:</strong> {{ $reservation->check_out_date }}
                </div>

                <div class="mb-3">
                    <strong>Nights:</strong> {{ $nights }}
                </div>

                <div class="mb-0">
                    <strong>Reservation Status:</strong>
                    <span class="badge bg-success">Accepted</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Payment Breakdown</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span>Room Rate</span>
                    <span>₱{{ number_format($roomRate, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Nights</span>
                    <span>{{ $nights }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₱{{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Service Fee</span>
                    <span>₱{{ number_format($serviceFee, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Tax (5%)</span>
                    <span>₱{{ number_format($tax, 2) }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <strong>Total</strong>
                    <strong class="text-success">₱{{ number_format($finalTotal, 2) }}</strong>
                </div>

                <form method="POST" action="{{ route('payments.pay', $reservation->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Payment Method</label>
                        <select name="payment_method" class="form-select rounded-3" required>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="card">Credit Card</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark rounded-3 py-2">
                            Confirm Payment
                        </button>
                        <a href="{{ route('my.reservations') }}" class="btn btn-outline-secondary rounded-3 py-2">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection