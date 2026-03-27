<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HRMS Portal Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    /* ================= Sidebar ================= */
    #sidebar {
        width: 260px;
        background: #ffffff;
        border-right: 1px solid #eaeaea;
        height: 100vh;
        position: fixed;
        display: flex;
        flex-direction: column;
        z-index: 1050;
        transition: transform 0.3s ease-in-out;
    }

    .sidebar-brand {
        padding: 20px;
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-sidebar {
        display: none;
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
    }

    .sidebar-nav {
        flex-grow: 1;
        padding: 10px;
        overflow-y: auto;
    }

    .nav-item-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #555;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .nav-item-link .material-icons-round {
        font-size: 24px;
        margin-right: 15px;
    }

    .nav-item-link.dashboard-icon .material-icons-round {
        background-image: linear-gradient(135deg, #10b981, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }

    .nav-item-link.attendance-icon .material-icons-round {
        color: #3b82f6;
    }

    .nav-item-link.notifications-icon .material-icons-round {
        color: #eab308;
    }

    .nav-item-link:hover,
    .nav-item-link.active {
        background-color: #f0f4ff;
        color: #2563eb;
    }

    .sidebar-footer {
        padding: 15px;
        border-top: 1px solid #eaeaea;
        display: flex;
        align-items: center;
    }

    .admin-badge {
        background-color: #f3f4f6;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        color: #4b5563;
        width: 100%;
        text-align: center;
    }

    /* ================= Main Content ================= */
    #main-content {
        margin-left: 260px;
        padding: 20px 30px;
        min-height: 100vh;
        transition: margin-left 0.3s ease-in-out;
    }

    .top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    }

    .top-header h4 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .notification-icon {
        position: relative;
        font-size: 1.2rem;
        color: #555;
        cursor: pointer;
    }

    .notification-icon .material-icons-round {
        font-size: 28px;
    }

    .notification-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background-color: #111827;
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .mobile-header {
        display: none;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #fff;
        border-bottom: 1px solid #eaeaea;
        position: sticky;
        top: 0;
        z-index: 1040;
    }

    .mobile-menu-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        padding: 0;
    }

    #sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1045;
    }

    /* ================= Common ================= */
    .custom-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #eaeaea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        height: 100%;
        margin-bottom: 20px;
    }

    .metric-title {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 10px;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .card-icon {
        font-size: 1.7rem;
    }

    .icon-blue {
        color: #3b82f6;
    }

    .icon-green {
        color: #10b981;
    }

    .icon-orange {
        color: #f59e0b;
    }

    .icon-purple {
        color: #a855f7;
    }

    /* ================= Dashboard ================= */
    .welcome-banner {
        background: linear-gradient(135deg, #1d4ed8, #8b5cf6);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .welcome-banner h2 {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .welcome-banner p {
        margin: 0;
        opacity: 0.9;
    }

    /* ================= Notifications ================= */
    .notifications-banner {
        background: linear-gradient(135deg, #f97316, #ef4444);
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
    }

    .notification-alert-item {
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid transparent;
    }

    .bg-light-blue {
        background-color: #f0f4ff;
    }

    .border-blue {
        border-color: #e0e7ff;
    }

    .bg-blue {
        background-color: #3b82f6;
    }

    .bg-light-green {
        background-color: #f0fdf4;
    }

    .border-green {
        border-color: #dcfce7;
    }

    .bg-green {
        background-color: #10b981;
    }

    .bg-light-yellow {
        background-color: #fffbeb;
    }

    .border-yellow {
        border-color: #fef3c7;
    }

    .bg-yellow {
        background-color: #f59e0b;
    }

    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    /* ================= Attendance ================= */
    .attendance-summary-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .summary-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        flex-shrink: 0;
    }

    .summary-icon-box .material-icons-round {
        font-size: 28px;
    }

    .attendance-calendar-box {
        border: 1px solid #eaeaea;
        border-radius: 12px;
        padding: 16px;
    }

    .calendar-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .calendar-nav-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        background: #fff;
        text-decoration: none;
    }

    .calendar-nav-btn:hover {
        background: #f9fafb;
        color: #111827;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 10px;
        text-align: center;
    }

    .calendar-weekday {
        font-size: 0.82rem;
        color: #6b7280;
        font-weight: 500;
    }

    .calendar-day {
        width: 34px;
        height: 34px;
        margin: 0 auto;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.92rem;
        color: #111827;
    }

    .calendar-day.empty {
        visibility: hidden;
    }

    .calendar-day.present {
        background: rgba(16, 185, 129, 0.14);
        color: #047857;
        font-weight: 600;
    }

    .calendar-day.leave {
        background: rgba(239, 68, 68, 0.14);
        color: #b91c1c;
        font-weight: 600;
    }

    .calendar-day.half_day {
        background: rgba(234, 179, 8, 0.18);
        color: #a16207;
        font-weight: 600;
    }

    .calendar-day.late {
        background: rgba(59, 130, 246, 0.14);
        color: #1d4ed8;
        font-weight: 600;
    }

    .calendar-day.absent {
        background: rgba(244, 63, 94, 0.14);
        color: #be123c;
        font-weight: 600;
    }

    .calendar-day.is-today {
        background: #111827 !important;
        color: #ffffff !important;
        font-weight: 700;
    }

    .legend-list {
        margin-top: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #374151;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 4px;
        display: inline-block;
    }

    .legend-dot.present {
        background: #22c55e;
    }

    .legend-dot.leave {
        background: #ef4444;
    }

    .legend-dot.half_day {
        background: #eab308;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
    }

    .status-pill.present {
        background: #111827;
        color: #ffffff;
    }

    .status-pill.late {
        background: #e5e7eb;
        color: #374151;
    }

    .status-pill.half_day {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pill.absent {
        background: #f43f5e;
        color: #ffffff;
    }

    .status-pill.leave {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-pill.pending {
        background: #f3f4f6;
        color: #374151;
    }

    .status-pill.approved {
        background: #111827;
        color: #ffffff;
    }

    .status-pill.rejected {
        background: #e11d48;
        color: #ffffff;
    }

    .leave-type-badge {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: 0.78rem;
        color: #111827;
        background: #fff;
    }

    .attendance-table td,
    .attendance-table th,
    .leave-table td,
    .leave-table th {
        vertical-align: middle;
    }

    .apply-leave-btn {
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
    }

    .modal-content {
        border: 0;
        border-radius: 16px;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: white;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }


    /* Payroll section */
    .nav-item-link.payroll-icon .material-icons-round {
        color: #f97316;
    }

    .payroll-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .payroll-filter-select {
        min-width: 185px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 10px 12px;
        background: #fff;
        color: #111827;
    }

    .payroll-toolbar-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .payroll-action-btn {
        border-radius: 10px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
    }

    .payroll-table td,
    .payroll-table th {
        vertical-align: middle;
    }

    .payroll-employee-name {
        font-weight: 600;
        color: #111827;
    }

    .payroll-employee-sub {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 2px;
    }

    .status-pill.processed {
        background: #111827;
        color: #ffffff;
    }

    .status-pill.pending {
        background: #f3f4f6;
        color: #374151;
    }

    .status-pill.approved {
        background: #f3f4f6;
        color: #111827;
    }

    .payroll-icon-btn {
        width: 36px;
        height: 36px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #111827;
        background: #fff;
    }

    .payroll-icon-btn:hover {
        background: #f9fafb;
        color: #111827;
    }

    @media (max-width: 991.98px) {
        .payroll-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .payroll-toolbar-actions {
            width: 100%;
        }

        .payroll-toolbar-actions .btn,
        .payroll-filter-select {
            width: 100%;
        }
    }



    /* ================= Sections ================= */
    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
        animation: fadeIn 0.4s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* ================= Responsive ================= */
    @media (max-width: 991.98px) {
        #sidebar {
            transform: translateX(-100%);
        }

        #sidebar.show-sidebar {
            transform: translateX(0);
        }

        .close-sidebar {
            display: block;
        }

        #main-content {
            margin-left: 0;
            padding: 15px;
        }

        .mobile-header {
            display: flex;
        }

        .desktop-top-header {
            display: none;
        }
    }
    </style>
</head>

<body>
    @php
    $userName = auth()->user()->name ?? 'User';
    @endphp

    <div class="mobile-header">
        <button class="mobile-menu-btn" type="button" onclick="toggleSidebar()">
            <span class="material-icons-round">menu</span>
        </button>

        <h5 class="m-0 fw-bold" id="mobile-page-title">Dashboard</h5>

        <div class="notification-icon js-open-notifications">
            <i class="material-icons-round">notifications</i>
            @if (($unreadNotificationCount ?? 0) > 0)
            <span class="notification-badge">
                {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
            </span>
            @endif
        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div id="sidebar">
        <div class="sidebar-brand">
            HRMS Portal
            <button class="close-sidebar" type="button" onclick="toggleSidebar()">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        <div class="sidebar-nav">
            <a href="#" class="nav-item-link dashboard-icon active" data-section="dashboard">
                <i class="material-icons-round">bar_chart</i>
                Dashboard
            </a>

            <a href="#" class="nav-item-link attendance-icon" data-section="attendance">
                <i class="material-icons-round">calendar_month</i>
                <span>My Attendance</span>
            </a>

            <a href="#" class="nav-item-link payroll-icon" data-section="payrolls">
                <i class="material-icons-round">account_balance_wallet</i>
                My Payslips
            </a>

            <a href="#" class="nav-item-link notifications-icon" data-section="notifications">
                <i class="material-icons-round">notifications</i>
                Notifications
            </a>

            <div class="nav-item-link">
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger btn-sm fw-bold shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-pill w-100 justify-content-center">
                        <i class="material-icons-round">logout</i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="admin-badge">User Access</div>
        </div>
    </div>

    <div id="main-content">
        <div class="top-header desktop-top-header">
            <h4 id="page-title">Dashboard</h4>

            <div class="notification-icon js-open-notifications">
                <i class="material-icons-round">notifications</i>
                @if (($unreadNotificationCount ?? 0) > 0)
                <span class="notification-badge">
                    {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                </span>
                @endif
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section active">
            <div class="welcome-banner">
                <h2>Welcome back, {{ $userName }}</h2>
                <p>Here's an overview of your attendance, leave balance, and recent requests.</p>
            </div>

            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $totalLeaveDays ?? 0 }}</div>
                            <div class="metric-title mb-0">Total Leave Days</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-blue">calendar_month</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $usedLeaveDays ?? 0 }}</div>
                            <div class="metric-title mb-0">Used Leave</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-green">schedule</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $pendingRequestsCount ?? 0 }}</div>
                            <div class="metric-title mb-0">Pending Requests</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-orange">error_outline</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $approvedRequestsCount ?? 0 }}</div>
                            <div class="metric-title mb-0">Approved Requests</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-purple">check_circle</i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-lg-6">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold">Recent Attendance</h6>
                            <a href="#" class="text-decoration-none fw-semibold"
                                onclick="openAttendanceTab(); return false;">
                                View All
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table attendance-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentAttendance as $attendance)
                                    <tr>
                                        <td>{{ $attendance->attendance_date->format('n/j/Y') }}</td>
                                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($attendance->work_hours, 2), '0'), '.') }}h
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $attendance->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No attendance records found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold">Recent Leave Requests</h6>
                            <button type="button" class="btn btn-dark apply-leave-btn" data-bs-toggle="modal"
                                data-bs-target="#applyLeaveModal">
                                <span class="material-icons-round" style="font-size:18px;">add</span>
                                Apply for Leave
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table leave-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Dates</th>
                                        <th>Days</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($leaveRequests as $leave)
                                    <tr>
                                        <td>
                                            <span class="leave-type-badge">{{ ucfirst($leave->leave_type) }}</span>
                                        </td>
                                        <td>
                                            {{ $leave->start_date->format('n/j/Y') }}
                                            <br>
                                            <small class="text-muted">to {{ $leave->end_date->format('n/j/Y') }}</small>
                                        </td>
                                        <td>{{ $leave->days }} day(s)</td>
                                        <td>
                                            <span class="status-pill {{ $leave->status }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No leave requests found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Section -->
        <div id="attendance" class="content-section">
            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $totalLeaveDays ?? 0 }}</div>
                            <div class="metric-title mb-0">Total Leave Days</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-blue">calendar_month</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $usedLeaveDays ?? 0 }}</div>
                            <div class="metric-title mb-0">Used Leave</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-green">schedule</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $pendingRequestsCount ?? 0 }}</div>
                            <div class="metric-title mb-0">Pending Requests</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-orange">error_outline</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $approvedRequestsCount ?? 0 }}</div>
                            <div class="metric-title mb-0">Approved Requests</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-purple">check_circle</i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-lg-5">
                    <div class="custom-card">
                        <h6 class="mb-3 fw-bold">Calendar</h6>

                        <div class="attendance-calendar-box">
                            <div class="calendar-header-bar">
                                <a href="{{ $prevMonthUrl }}" class="calendar-nav-btn">
                                    <span class="material-icons-round" style="font-size:18px;">chevron_left</span>
                                </a>

                                <div class="fw-semibold">{{ $calendarMonthLabel }}</div>

                                <a href="{{ $nextMonthUrl }}" class="calendar-nav-btn">
                                    <span class="material-icons-round" style="font-size:18px;">chevron_right</span>
                                </a>
                            </div>

                            <div class="calendar-grid">
                                @foreach (['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $weekDay)
                                <div class="calendar-weekday">{{ $weekDay }}</div>
                                @endforeach

                                @foreach ($calendarDays as $calendarDay)
                                @if (!$calendarDay)
                                <div class="calendar-day empty">0</div>
                                @else
                                <div class="calendar-day {{ $calendarDay['status'] ?? '' }} {{ $calendarDay['is_today'] ? 'is-today' : '' }}"
                                    title="{{ $calendarDay['date'] }}">
                                    {{ $calendarDay['day'] }}
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="legend-list">
                            <div class="legend-item">
                                <span class="legend-dot present"></span>
                                <span>Present</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot leave"></span>
                                <span>Leave</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot half_day"></span>
                                <span>Half Day</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="custom-card">
                        <h6 class="mb-3 fw-bold">Recent Attendance</h6>

                        <div class="table-responsive">
                            <table class="table attendance-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentAttendance as $attendance)
                                    <tr>
                                        <td>{{ $attendance->attendance_date->format('n/j/Y') }}</td>
                                        <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($attendance->work_hours, 2), '0'), '.') }}h
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $attendance->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No attendance records found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h6 class="mb-0 fw-bold">Leave Requests</h6>

                            <button type="button" class="btn btn-dark apply-leave-btn" data-bs-toggle="modal"
                                data-bs-target="#applyLeaveModal">
                                <span class="material-icons-round" style="font-size:18px;">add</span>
                                Apply for Leave
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table leave-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Dates</th>
                                        <th>Days</th>
                                        <th>Applied</th>
                                        <th>Status</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($leaveRequests as $leave)
                                    <tr>
                                        <td>
                                            <span class="leave-type-badge">{{ ucfirst($leave->leave_type) }}</span>
                                        </td>
                                        <td>
                                            {{ $leave->start_date->format('n/j/Y') }}
                                            <br>
                                            <small class="text-muted">to {{ $leave->end_date->format('n/j/Y') }}</small>
                                        </td>
                                        <td>{{ $leave->days }} day(s)</td>
                                        <td>{{ $leave->created_at->format('n/j/Y') }}</td>
                                        <td>
                                            <span class="status-pill {{ $leave->status }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $leave->reason ?: '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No leave requests found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll Section -->

        <div id="payrolls" class="content-section">
            <div class="payroll-toolbar">
                <form method="GET" action="{{ route('dashboard') }}">
                    <input type="hidden" name="tab" value="payrolls">

                    <select name="payroll_month" class="payroll-filter-select" onchange="this.form.submit()">
                        @if ($payrollMonthOptions->isEmpty())
                        <option value="">{{ $selectedPayrollMonthLabel }}</option>
                        @else
                        @foreach ($payrollMonthOptions as $monthOption)
                        <option value="{{ $monthOption->format('Y-m') }}"
                            {{ $selectedPayrollMonthValue === $monthOption->format('Y-m') ? 'selected' : '' }}>
                            {{ $monthOption->format('F Y') }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </form>

                <div class="payroll-toolbar-actions">
                    <button type="button" class="btn btn-outline-dark payroll-action-btn" disabled>
                        <span class="material-icons-round" style="font-size:18px;">receipt_long</span>
                        Latest Payslip
                    </button>

                    <button type="button" class="btn btn-outline-dark payroll-action-btn" disabled>
                        <span class="material-icons-round" style="font-size:18px;">download</span>
                        Export Report
                    </button>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $totalPayslips }}</div>
                            <div class="metric-title mb-0">Total Payslips</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-blue">groups</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">${{ number_format($totalNetPay, 2) }}</div>
                            <div class="metric-title mb-0">Total Payroll</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-green">attach_money</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $processedPayslips }}</div>
                            <div class="metric-title mb-0">Processed</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-purple">trending_up</i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card attendance-summary-card">
                        <div>
                            <div class="metric-value">{{ $pendingPayslips }}</div>
                            <div class="metric-title mb-0">Pending</div>
                        </div>
                        <div class="summary-icon-box">
                            <i class="material-icons-round icon-orange">description</i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <div class="custom-card">
                        <h6 class="mb-4 fw-bold">Payroll Records - {{ $selectedPayrollMonthLabel }}</h6>

                        <div class="table-responsive">
                            <table class="table payroll-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Basic Salary</th>
                                        <th>Allowances</th>
                                        <th>Deductions</th>
                                        <th>Tax</th>
                                        <th>Net Pay</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payrollRecords as $payroll)
                                    <tr>
                                        <td>
                                            <div class="payroll-employee-name">
                                                {{ $payroll->employee->name ?? ($employee->name ?? 'N/A') }}
                                            </div>
                                            <div class="payroll-employee-sub">
                                                {{ auth()->user()->employeeID ?? 'EMPLOYEE' }}
                                            </div>
                                        </td>
                                        <td>{{ $payroll->employee->department ?? '-' }}</td>
                                        <td>${{ number_format($payroll->basic_salary, 2) }}</td>
                                        <td>${{ number_format($payroll->allowance, 2) }}</td>
                                        <td>${{ number_format($payroll->deduction, 2) }}</td>
                                        <td>${{ number_format($payroll->tax, 2) }}</td>
                                        <td class="fw-semibold">${{ number_format($payroll->net_pay, 2) }}</td>
                                        <td>
                                            <span class="status-pill {{ strtolower($payroll->status) }}">
                                                {{ ucfirst($payroll->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="javascript:void(0)" class="payroll-icon-btn" title="View">
                                                    <span class="material-icons-round"
                                                        style="font-size:18px;">visibility</span>
                                                </a>
                                                <a href="javascript:void(0)" class="payroll-icon-btn" title="Download">
                                                    <span class="material-icons-round"
                                                        style="font-size:18px;">download</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-5">
                                            No payroll records found for {{ $selectedPayrollMonthLabel }}.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Section -->
        <div id="notifications" class="content-section">
            <div class="notifications-banner mb-4">
                <h3 class="fw-bold mb-2">Notifications & Reminders</h3>
                <p class="mb-0">Stay updated with important HR notifications and reminders.</p>
            </div>

            <div class="custom-card">
                <h6 class="mb-4 text-dark fw-bold">Recent Notifications</h6>

                @forelse($recentNotifications as $notification)
                @php
                $wrapperClass = 'bg-light-blue border-blue';
                $dotClass = 'bg-blue';

                if (($notification->type ?? '') === 'success') {
                $wrapperClass = 'bg-light-green border-green';
                $dotClass = 'bg-green';
                } elseif (($notification->type ?? '') === 'warning') {
                $wrapperClass = 'bg-light-yellow border-yellow';
                $dotClass = 'bg-yellow';
                }
                @endphp

                <div class="notification-alert-item {{ $wrapperClass }} {{ !$loop->first ? 'mt-3' : '' }}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="mt-1">
                            <span class="notif-dot {{ $dotClass }}"></span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $notification->title }}</h6>
                            <p class="text-muted small mb-1">{{ $notification->message }}</p>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                                {{ $notification->created_at?->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">No notifications found.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Apply Leave Modal -->
    <div class="modal fade" id="applyLeaveModal" tabindex="-1" aria-labelledby="applyLeaveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom border-0">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="applyLeaveModalLabel">Apply for Leave</h5>
                        <p class="mb-0 small text-white-50">Fill in the form and submit your leave request.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.leave-requests.store') }}">
                    @csrf
                    <input type="hidden" name="show_leave_modal" value="1">
                    <input type="hidden" name="tab" value="attendance">

                    <div class="modal-body p-4">
                        @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="leave_type" class="form-label">Leave Type</label>
                                <select name="leave_type" id="leave_type"
                                    class="form-select @error('leave_type') is-invalid @enderror" required>
                                    <option value="">Select leave type</option>
                                    <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>Sick
                                    </option>
                                    <option value="vacation" {{ old('leave_type') === 'vacation' ? 'selected' : '' }}>
                                        Vacation</option>
                                    <option value="casual" {{ old('leave_type') === 'casual' ? 'selected' : '' }}>Casual
                                    </option>
                                    <option value="personal" {{ old('leave_type') === 'personal' ? 'selected' : '' }}>
                                        Personal</option>
                                </select>
                                @error('leave_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="leave_days" class="form-label">Total Days</label>
                                <input type="number" name="days" id="leave_days"
                                    class="form-control @error('days') is-invalid @enderror" value="{{ old('days') }}"
                                    min="1" readonly required>
                                @error('days')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="leave_start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="leave_start_date"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="leave_end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="leave_end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="leave_reason" class="form-label">Reason</label>
                                <textarea name="reason" id="leave_reason" rows="5"
                                    class="form-control @error('reason') is-invalid @enderror"
                                    placeholder="Write your reason here...">{{ old('reason') }}</textarea>
                                @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light px-4 rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark px-4 rounded-pill">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (!sidebar || !overlay) return;

        sidebar.classList.toggle('show-sidebar');
        overlay.style.display = sidebar.classList.contains('show-sidebar') ? 'block' : 'none';
    }

    function getPageTitleFromLink(link) {
        if (!link) return 'Dashboard';

        const cloned = link.cloneNode(true);
        const icon = cloned.querySelector('.material-icons-round');
        if (icon) icon.remove();

        return cloned.textContent.replace(/\s+/g, ' ').trim() || 'Dashboard';
    }

    function removeNotificationBadges() {
        document.querySelectorAll('.notification-badge').forEach(badge => badge.remove());
    }

    function markNotificationsAsRead() {
        removeNotificationBadges();
    }

    function switchTab(sectionId, element = null, options = {}) {
        const {
            updateUrl = true,
                closeMobileSidebar = true
        } = options;

        if (!sectionId) return;

        document.querySelectorAll('.nav-item-link[data-section]').forEach(link => {
            link.classList.remove('active');
        });

        if (element) {
            element.classList.add('active');
        } else {
            const matchedLink = document.querySelector('.nav-item-link[data-section="' + sectionId + '"]');
            if (matchedLink) {
                matchedLink.classList.add('active');
                element = matchedLink;
            }
        }

        document.querySelectorAll('.content-section').forEach(section => {
            section.classList.remove('active');
        });

        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.classList.add('active');
        }

        const pageTitleText = getPageTitleFromLink(element);

        const pageTitle = document.getElementById('page-title');
        const mobilePageTitle = document.getElementById('mobile-page-title');

        if (pageTitle) pageTitle.textContent = pageTitleText;
        if (mobilePageTitle) mobilePageTitle.textContent = pageTitleText;

        if (updateUrl) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', sectionId);
            window.history.replaceState({}, '', url);
        }

        if (sectionId === 'notifications') {
            markNotificationsAsRead();
        }

        if (closeMobileSidebar && window.innerWidth < 992) {
            const sidebar = document.getElementById('sidebar');
            if (sidebar && sidebar.classList.contains('show-sidebar')) {
                toggleSidebar();
            }
        }
    }

    function openNotificationsTab() {
        const notificationLink = document.querySelector('.nav-item-link[data-section="notifications"]');
        switchTab('notifications', notificationLink);
    }

    function openAttendanceTab() {
        const attendanceLink = document.querySelector('.nav-item-link[data-section="attendance"]');
        switchTab('attendance', attendanceLink);
    }

    function updateLeaveDays() {
        const startInput = document.getElementById('leave_start_date');
        const endInput = document.getElementById('leave_end_date');
        const daysInput = document.getElementById('leave_days');

        if (!startInput || !endInput || !daysInput) return;

        const startValue = startInput.value;
        const endValue = endInput.value;

        if (!startValue || !endValue) {
            daysInput.value = '';
            return;
        }

        const startDate = new Date(startValue + 'T00:00:00');
        const endDate = new Date(endValue + 'T00:00:00');

        if (endDate < startDate) {
            daysInput.value = '';
            return;
        }

        const diffTime = endDate.getTime() - startDate.getTime();
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

        daysInput.value = diffDays > 0 ? diffDays : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-item-link[data-section]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                switchTab(this.dataset.section, this);
            });
        });

        document.querySelectorAll('.js-open-notifications').forEach(icon => {
            icon.addEventListener('click', function() {
                openNotificationsTab();
            });
        });

        const startInput = document.getElementById('leave_start_date');
        const endInput = document.getElementById('leave_end_date');

        if (startInput) startInput.addEventListener('change', updateLeaveDays);
        if (endInput) endInput.addEventListener('change', updateLeaveDays);

        updateLeaveDays();

        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'dashboard';
        const activeLink = document.querySelector('.nav-item-link[data-section="' + activeTab + '"]');

        if (activeLink) {
            switchTab(activeTab, activeLink, {
                updateUrl: false,
                closeMobileSidebar: false
            });
        }

        @if($errors-> any() && old('show_leave_modal'))
        openAttendanceTab();
        const leaveModalEl = document.getElementById('applyLeaveModal');
        if (leaveModalEl) {
            const leaveModal = new bootstrap.Modal(leaveModalEl);
            leaveModal.show();
        }
        @endif
    });
    </script>
</body>

</html>