<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pinnacle Hotel and Suites </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .main-wrapper {
            min-height: 100vh;
        }

        .content-area {
            background: #f5f7fb;
            min-height: 100vh;
        }

        .page-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #eef2f7;
        }

        .dashboard-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            transition: all 0.25s ease;
            background: #ffffff;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.10);
        }

        .card-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .card-value {
            font-size: 30px;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        .card-subtext {
            color: #6b7280;
            margin-top: 8px;
            margin-bottom: 0;
            font-size: 14px;
        }

        .dashboard-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 22px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }

        .icon-blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .icon-green { background: linear-gradient(135deg, #16a34a, #15803d); }
        .icon-cyan { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .icon-yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .icon-gray { background: linear-gradient(135deg, #6b7280, #4b5563); }
        .icon-dark { background: linear-gradient(135deg, #111827, #1f2937); }

        .currency {
            font-family: Arial, sans-serif;
            font-weight: inherit;
        }
    </style>
</head>
<body>

<div class="d-flex main-wrapper">
    @auth
        @include('partials.sidebar')
    @endauth

    <div class="flex-grow-1 content-area">
        @auth
            @include('partials.navbar')
        @endauth

        <div class="container-fluid px-4 py-4">
            @include('partials.alerts')
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>