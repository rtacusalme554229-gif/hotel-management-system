<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pinnacle Hotel and Suites  - Premium Report</title>

    <style>
        @page {
            margin: 28px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .report-wrapper {
            width: 100%;
        }

        .header {
            background: #0f172a;
            color: #ffffff;
            padding: 24px 28px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 6px 0;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 12px;
            color: #dbe3f0;
            margin: 0;
            text-align: center;
        }

        .meta-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #f8fafc;
            border: 1px solid #dbe2ea;
            border-left: 5px solid #0f172a;
        }

        .meta-box td {
            padding: 12px 16px;
            font-size: 11px;
            line-height: 1.6;
        }

        .section-title {
            font-size: 17px;
            font-weight: bold;
            color: #0f172a;
            margin: 24px 0 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #0f172a;
        }

        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-bottom: 22px;
        }

        .summary-grid td {
            width: 25%;
            vertical-align: top;
        }

        .summary-card {
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            padding: 14px 14px 12px;
            background: #ffffff;
            min-height: 76px;
        }

        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .summary-value {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
            line-height: 1.15;
        }

        .summary-value.revenue {
            color: #15803d;
            font-size: 18px;
        }

        .summary-sub {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.4;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .data-table thead th {
            background: #0f172a;
            color: #ffffff;
            padding: 10px 12px;
            font-size: 11px;
            text-align: left;
        }

        .data-table tbody td {
            border: 1px solid #dbe2ea;
            padding: 9px 12px;
            font-size: 11px;
        }

        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-success {
            color: #15803d;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dbe2ea;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 9px;
            border-radius: 999px;
            font-weight: bold;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-yellow {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-gray {
            background: #e5e7eb;
            color: #374151;
        }
    </style>
</head>
<body>
<div class="report-wrapper">

    <!-- HEADER -->
    <div class="header">
        <div class="header-title">Pinnacle Hotel and Suites </div>
        <div class="header-subtitle">Premium Business Operations Report</div>
    </div>

    <!-- REPORT META -->
    <table class="meta-box">
        <tr>
            <td>
                <strong>Generated:</strong> {{ $data['generatedAt'] }}<br>
                @if($data['startDate'] && $data['endDate'])
                    <strong>Report Period:</strong> {{ $data['startDate'] }} to {{ $data['endDate'] }}
                @else
                    <strong>Report Period:</strong> All Records
                @endif
            </td>
        </tr>
    </table>

    <!-- EXECUTIVE SUMMARY -->
    <div class="section-title">Executive Summary</div>

    <table class="summary-grid">
        <tr>
            <td>
                <div class="summary-card">
                    <div class="summary-label">Total Rooms</div>
                    <div class="summary-value">{{ $data['totalRooms'] }}</div>
                    <div class="summary-sub">Registered room inventory</div>
                </div>
            </td>

            <td>
                <div class="summary-card">
                    <div class="summary-label">Reservations</div>
                    <div class="summary-value">{{ $data['totalReservations'] }}</div>
                    <div class="summary-sub">Bookings under selected period</div>
                </div>
            </td>

            <td>
                <div class="summary-card">
                    <div class="summary-label">Payments</div>
                    <div class="summary-value">{{ $data['totalPayments'] }}</div>
                    <div class="summary-sub">Completed payment transactions</div>
                </div>
            </td>

            <td>
                <div class="summary-card">
                    <div class="summary-label">Total Revenue</div>
                    <div class="summary-value revenue">PHP {{ number_format($data['totalRevenue'], 2) }}</div>
                    <div class="summary-sub">Revenue collected from payments</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- ROOM SUMMARY -->
    <div class="section-title">Room Summary</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th class="text-center">Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Rooms</td>
                <td class="text-center">{{ $data['totalRooms'] }}</td>
            </tr>
            <tr>
                <td>Available Rooms</td>
                <td class="text-center">{{ $data['availableRooms'] }}</td>
            </tr>
            <tr>
                <td>Reserved Rooms</td>
                <td class="text-center">{{ $data['reservedRooms'] }}</td>
            </tr>
            <tr>
                <td>Occupied Rooms</td>
                <td class="text-center">{{ $data['occupiedRooms'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- RESERVATION SUMMARY -->
    <div class="section-title">Reservation Summary</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-center">Count</th>
                <th>Indicator</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pending</td>
                <td class="text-center">{{ $data['pendingReservations'] }}</td>
                <td><span class="badge badge-yellow">Pending Review</span></td>
            </tr>
            <tr>
                <td>Accepted</td>
                <td class="text-center">{{ $data['acceptedReservations'] }}</td>
                <td><span class="badge badge-blue">Approved</span></td>
            </tr>
            <tr>
                <td>Checked In</td>
                <td class="text-center">{{ $data['checkedInReservations'] }}</td>
                <td><span class="badge badge-green">In-House</span></td>
            </tr>
            <tr>
                <td>Checked Out</td>
                <td class="text-center">{{ $data['checkedOutReservations'] }}</td>
                <td><span class="badge badge-gray">Completed Stay</span></td>
            </tr>
            <tr>
                <td>Declined</td>
                <td class="text-center">{{ $data['declinedReservations'] }}</td>
                <td><span class="badge badge-red">Declined</span></td>
            </tr>
        </tbody>
    </table>

    <!-- PAYMENT SUMMARY -->
    <div class="section-title">Payment Summary</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Metric</th>
                <th class="text-center">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Payment Records</td>
                <td class="text-center">{{ $data['totalPayments'] }}</td>
            </tr>
            <tr>
                <td>Total Revenue</td>
                <td class="text-center text-success">PHP {{ number_format($data['totalRevenue'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Generated by Pinnacle Hotel and Suites  Management System • Premium Operations Report
    </div>

</div>
</body>
</html>