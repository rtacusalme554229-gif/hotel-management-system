<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 py-3">
    <div class="container-fluid">

        <div>
            <h5 class="mb-0 fw-bold text-dark">Hotel Management System</h5>
            <small class="text-muted">Professional booking and operations dashboard</small>
        </div>

        <div class="d-flex align-items-center gap-3 ms-auto">
            <div class="text-end">
                <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                <span class="badge rounded-pill
                    @if(auth()->user()->role === 'admin') bg-dark
                    @elseif(in_array(auth()->user()->role, ['staff', 'manager'])) bg-primary
                    @else bg-success
                    @endif">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-dark rounded-pill px-3">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>