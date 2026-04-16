<div class="bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">Menu</h4>

    <ul class="nav flex-column">

        @if(auth()->user()->role === 'admin')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-secondary rounded' : '' }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('guests.index') }}"
                   class="nav-link text-white {{ request()->routeIs('guests.*') ? 'bg-secondary rounded' : '' }}">
                    Manage Guests
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('staff.index') }}"
                   class="nav-link text-white {{ request()->routeIs('staff.*') ? 'bg-secondary rounded' : '' }}">
                    Manage Staff
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('rooms.index') }}"
                   class="nav-link text-white {{ request()->routeIs('rooms.*') ? 'bg-secondary rounded' : '' }}">
                    Manage Rooms
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('reservations.index') }}"
                   class="nav-link text-white {{ request()->routeIs('reservations.*') ? 'bg-secondary rounded' : '' }}">
                    Manage Reservations
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('payments.index') }}"
                   class="nav-link text-white {{ request()->routeIs('payments.*') ? 'bg-secondary rounded' : '' }}">
                    Payments
                </a>
            </li>
        @endif

        @if(in_array(auth()->user()->role, ['staff', 'manager']))
            <li class="nav-item mb-2">
                <a href="{{ route('staff.dashboard') }}"
                   class="nav-link text-white {{ request()->routeIs('staff.dashboard') ? 'bg-secondary rounded' : '' }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('rooms.index') }}"
                   class="nav-link text-white {{ request()->routeIs('rooms.*') ? 'bg-secondary rounded' : '' }}">
                    Rooms
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('reservations.index') }}"
                   class="nav-link text-white {{ request()->routeIs('reservations.*') ? 'bg-secondary rounded' : '' }}">
                    Manage Reservations
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('payments.index') }}"
                   class="nav-link text-white {{ request()->routeIs('payments.*') ? 'bg-secondary rounded' : '' }}">
                    Payments
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'guest')
            <li class="nav-item mb-2">
                <a href="{{ route('guest.dashboard') }}"
                   class="nav-link text-white {{ request()->routeIs('guest.dashboard') ? 'bg-secondary rounded' : '' }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('rooms.index') }}"
                   class="nav-link text-white {{ request()->routeIs('rooms.*') ? 'bg-secondary rounded' : '' }}">
                    Available Rooms
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('my.reservations') }}"
                   class="nav-link text-white {{ request()->routeIs('my.reservations') ? 'bg-secondary rounded' : '' }}">
                    My Reservations
                </a>
            </li>
        @endif

    </ul>
</div>