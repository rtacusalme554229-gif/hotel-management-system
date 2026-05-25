<nav class="top-navbar">
    <div>
        <h5 class="navbar-title mb-0">Pinnacle Hotel and Suites </h5>
        <small class="navbar-subtitle">Professional booking and operations dashboard</small>
    </div>

    <div class="navbar-user-area">
        <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="user-info">
            <div class="user-name">{{ auth()->user()->name }}</div>

            <span class="user-role role-{{ auth()->user()->role }}">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
    </div>
</nav>

<style>
    .top-navbar {
        height: 78px;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
        padding: 0 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar-title {
        font-size: 20px;
        font-weight: 800;
        color: #111827;
    }

    .navbar-subtitle {
        color: #6b7280;
        font-size: 13px;
    }

    .navbar-user-area {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #111827, #1e3a8a);
        color: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
    }

    .user-info {
        text-align: right;
        line-height: 1.2;
    }

    .user-name {
        font-size: 14px;
        font-weight: 800;
        color: #111827;
        text-transform: capitalize;
    }

    .user-role {
        display: inline-block;
        margin-top: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        color: #ffffff;
    }

    .role-admin {
        background: #111827;
    }

    .role-staff {
        background: #2563eb;
    }

    .role-manager {
        background: #7c3aed;
    }

    .role-guest {
        background: #059669;
    }

    .logout-btn {
        border: 1px solid #111827;
        background: transparent;
        color: #111827;
        border-radius: 999px;
        padding: 9px 18px;
        font-weight: 700;
        transition: 0.2s ease;
    }

    .logout-btn:hover {
        background: #111827;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .top-navbar {
            height: auto;
            padding: 18px;
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .navbar-user-area {
            width: 100%;
            justify-content: space-between;
        }

        .user-info {
            text-align: left;
        }
    }
</style>