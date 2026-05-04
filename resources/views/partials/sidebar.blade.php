<div class="text-white d-flex flex-column sidebar"
     style="width: 270px; min-height: 100vh; background: linear-gradient(180deg, #0f172a 0%, #111827 100%);">

    <style>
        .sidebar-link {
            color: rgba(255,255,255,0.75);
            transition: all 0.2s ease;
            display: block;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
        }

        .sidebar-active {
            background: #ffffff;
            color: #111827 !important;
            font-weight: 600;
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
        }

        .sidebar-title {
            letter-spacing: 1px;
        }
    </style>

    <div class="px-4 py-4 border-bottom border-secondary-subtle">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center"
                 style="width: 46px; height: 46px; background: linear-gradient(135deg, #d4af37, #f5d76e); color: #111827; font-weight: 700;">
                H
            </div>
            <div>
                <h5 class="mb-0 fw-bold text-white">StayEase Hotel</h5>
                <small class="text-light opacity-75">Management System</small>
            </div>
        </div>
    </div>

    <div class="px-3 py-4 flex-grow-1">
        <small class="text-uppercase text-light opacity-50 fw-semibold px-2 sidebar-title">
            Navigation
        </small>

        <ul class="nav flex-column mt-3">

            @if(auth()->user()->role === 'admin')
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('guests.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('guests.*') ? 'sidebar-active' : '' }}">
                        Manage Guests
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('staff.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('staff.*') ? 'sidebar-active' : '' }}">
                        Manage Staff
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('rooms.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                        Manage Rooms
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('reservations.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('reservations.*') ? 'sidebar-active' : '' }}">
                        Reservations
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('payments.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('payments.*') ? 'sidebar-active' : '' }}">
                        Payments
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('reports.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('reports.*') ? 'sidebar-active' : '' }}">
                        Reports
                    </a>
                </li>
            @endif

            @if(in_array(auth()->user()->role, ['staff', 'manager']))
                <li class="mb-2">
                    <a href="{{ route('staff.dashboard') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('staff.dashboard') ? 'sidebar-active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('rooms.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                        Rooms
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('reservations.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('reservations.*') ? 'sidebar-active' : '' }}">
                        Reservations
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('payments.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('payments.*') ? 'sidebar-active' : '' }}">
                        Payments
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('reports.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('reports.*') ? 'sidebar-active' : '' }}">
                        Reports
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('activity-logs.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('activity-logs.*') ? 'sidebar-active' : '' }}">
                        Activity Logs
                    </a>
                </li>
            @endif

            @if(auth()->user()->role === 'guest')
                <li class="mb-2">
                    <a href="{{ route('guest.dashboard') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('guest.dashboard') ? 'sidebar-active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('rooms.index') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('rooms.*') ? 'sidebar-active' : '' }}">
                        Available Rooms
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('my.reservations') }}"
                       class="nav-link sidebar-link rounded-3 px-3 py-2 {{ request()->routeIs('my.reservations') ? 'sidebar-active' : '' }}">
                        My Reservations
                    </a>
                </li>
            @endif

        </ul>
    </div>

    <div class="px-4 py-3 border-top border-secondary-subtle">
        <small class="text-light opacity-50">
            Business Dashboard UI
        </small>
    </div>
</div>