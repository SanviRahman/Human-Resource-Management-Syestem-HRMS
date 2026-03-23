<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS Portal Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    /* ================= Sidebar Styles ================= */
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
        direction: ltr;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
    }

    /* Sidebar Icon Colors */
    .nav-item-link.dashboard-icon .material-icons-round {
        background-image: linear-gradient(135deg, #10b981, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        display: inline-block;
    }

    .nav-item-link.employee-icon .material-icons-round {
        color: #7b1fa2;
    }

    .nav-item-link.attendance-icon .material-icons-round {
        color: #3b82f6;
    }

    .nav-item-link.attendance-icon span.attendance-text {
        color: #7b1fa2;
    }

    .nav-item-link.payroll-icon .material-icons-round {
        color: #f97316;
    }

    .nav-item-link.recruitment-icon .material-icons-round {
        color: #e91e63;
    }

    .nav-item-link.performance-icon .material-icons-round {
        color: #7b1fa2;
    }

    .nav-item-link.notifications-icon .material-icons-round {
        color: #eab308;
    }

    .nav-item-link.settings-icon .material-icons-round {
        color: #7b1fa2;
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

    /* ================= Main Content & Headers ================= */
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
        background-color: #1f2937;
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 50%;
    }

    /* Mobile Header */
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
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1045;
    }

    /* ================= Common Cards ================= */
    .custom-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #eaeaea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        height: 100%;
        margin-bottom: 20px;
    }

    /* ================= Dashboard Section Styles ================= */
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

    .metric-title {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 15px;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .metric-trend.positive {
        color: #10b981;
        font-size: 0.85rem;
    }

    .metric-trend.negative {
        color: #ef4444;
        font-size: 0.85rem;
    }

    .card-icon {
        font-size: 1.5rem;
    }

    .icon-blue {
        color: #3b82f6;
    }

    .icon-green {
        color: #10b981;
    }

    .icon-orange {
        color: #f97316;
    }

    .icon-purple {
        color: #8b5cf6;
    }

    .dept-item {
        margin-bottom: 15px;
    }

    .dept-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 5px;
        color: #374151;
    }

    .custom-progress {
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .custom-progress-bar {
        background-color: #111827;
        height: 100%;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-top: 5px;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .dot-green {
        background-color: #10b981;
    }

    .dot-blue {
        background-color: #3b82f6;
    }

    .dot-yellow {
        background-color: #eab308;
    }

    .activity-content {
        flex-grow: 1;
    }

    .activity-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: #1f2937;
        margin: 0;
    }

    .activity-desc {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #9ca3af;
        white-space: nowrap;
    }

    .event-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .event-blue {
        background-color: #f0f4ff;
    }

    .event-green {
        background-color: #f0fdf4;
    }

    .event-orange {
        background-color: #fff7ed;
    }

    .event-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: #1f2937;
        margin: 0;
    }

    .event-subtitle {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0;
    }

    .event-time {
        font-size: 0.85rem;
        font-weight: 500;
        color: #374151;
        margin-top: 5px;
    }

    /* ================= Employee Management Styles ================= */
    .emp-summary-card {
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid #eaeaea;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        height: 100%;
        margin-bottom: 20px;
    }

    .emp-summary-value {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .emp-summary-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .text-green {
        color: #10b981;
    }

    .text-orange {
        color: #f97316;
    }

    .text-red {
        color: #ef4444;
    }

    .search-input-group {
        background: #f3f4f6;
        border-radius: 8px;
        padding: 5px 15px;
        display: flex;
        align-items: center;
    }

    .search-input-group input {
        border: none;
        background: transparent;
        box-shadow: none;
        outline: none;
        padding-left: 10px;
        width: 100%;
    }

    .search-input-group .material-icons-round {
        color: #9ca3af;
        font-size: 20px;
    }

    .filter-select {
        background-color: #f3f4f6;
        border: none;
        border-radius: 8px;
        padding: 10px 15px;
        color: #4b5563;
    }

    .employee-table th {
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #eaeaea;
        padding: 15px;
        font-size: 0.9rem;
    }

    .employee-table td {
        vertical-align: middle;
        padding: 15px;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
        font-size: 0.9rem;
    }

    .emp-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .emp-email {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-active {
        background-color: #111827;
        color: #fff;
    }

    .status-probation {
        background-color: #f3f4f6;
        color: #374151;
    }

    .status-inactive {
        background-color: #ef4444;
        color: #fff;
    }

    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        color: #6b7280;
        transition: color 0.2s;
    }

    .action-btn:hover.edit-btn {
        color: #111827;
    }

    .action-btn:hover.delete-btn {
        color: #ef4444;
    }

    .action-btn .material-icons-round {
        font-size: 20px;
    }


    /* ================= Attendance & Leave Specific Styles ================= */

    /* Summary Cards */
    .att-summary-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #eaeaea;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        height: 100%;
    }

    .att-icon-wrapper i {
        font-size: 32px;
    }

    .att-value {
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
        line-height: 1.1;
    }

    .att-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0;
        margin-top: 4px;
    }

    /* Calendar Styles */
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .calendar-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .cal-nav-btn {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 3px 6px;
        cursor: pointer;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cal-nav-btn:hover {
        background: #f9fafb;
        color: #111827;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        gap: 8px 4px;
    }

    .calendar-day-header {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
        padding-bottom: 5px;
    }

    .calendar-date {
        font-size: 0.85rem;
        color: #374151;
        width: 28px;
        height: 28px;
        line-height: 28px;
        margin: 0 auto;
        border-radius: 50%;
        cursor: pointer;
    }

    .calendar-date:hover:not(.active) {
        background-color: #e5e7eb;
    }

    .calendar-date.active {
        background-color: #111827;
        color: #fff;
        font-weight: 500;
    }

    /* Legend */
    .cal-legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #4b5563;
        margin-bottom: 8px;
    }

    .cal-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .cal-dot.green {
        background-color: #10b981;
    }

    .cal-dot.red {
        background-color: #ef4444;
    }

    .cal-dot.yellow {
        background-color: #eab308;
    }

    /* Common Table Utilities */
    .data-table th {
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #eaeaea;
        padding: 15px;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .data-table td {
        vertical-align: middle;
        padding: 15px;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
        font-size: 0.9rem;
    }

    .type-badge {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        background-color: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
        display: inline-block;
        font-weight: 500;
    }

    /* Action Buttons (Approve/Reject) */
    .btn-approve {
        color: #10b981;
        border: 1px solid #10b981;
        background: transparent;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-approve:hover {
        background: #f0fdf4;
    }

    .btn-reject {
        color: #ef4444;
        border: 1px solid #ef4444;
        background: transparent;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-reject:hover {
        background: #fef2f2;
    }




    /* ================= Payroll Specific Styles ================= */

    /* Action Buttons for Payroll Table */
    .btn-outline-action {
        background-color: transparent;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        color: #4b5563;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-action:hover {
        background-color: #f3f4f6;
        color: #111827;
        border-color: #9ca3af;
    }

    .btn-outline-action .material-icons-round {
        font-size: 16px;
        /* Icon size optimized for the small button */
    }





    /* ================= Recruitment Specific Styles ================= */

    /* Top Green Banner */
    .recruitment-banner {
        background-color: #10b981;
        /* Green color from image */
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
    }

    /* Individual Items inside the columns */
    .recruitment-item {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 12px;
        background-color: #fafafa;
        /* Default light background */
        border: 1px solid #f3f4f6;
    }

    .recruitment-item:last-child {
        margin-bottom: 0;
    }

    /* Background Color Variants */
    .bg-light-gray {
        background-color: #f8f9fa !important;
    }

    .bg-light-blue {
        background-color: #f0f8ff !important;
        /* Very light blue */
        border-color: #e0f2fe !important;
    }

    /* Status Badge Variant for Active */
    .bg-light-green {
        background-color: #d1fae5 !important;
    }

    .text-green {
        color: #059669 !important;
    }




    /* ================= Performance Specific Styles ================= */

    /* Top Gradient Banner */
    .performance-banner {
        background: linear-gradient(135deg, #b026ff, #ec4899);
        /* Purple to Pink gradient */
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
    }

    /* Review Items Background */
    .review-item {
        padding: 15px 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        /* Light gray background like image */
        border: 1px solid #f3f4f6;
    }


    /* ================= Notifications Specific Styles ================= */

    /* Top Gradient Banner */
    .notifications-banner {
        background: linear-gradient(135deg, #f97316, #ef4444);
        /* Orange to Red gradient */
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
    }

    /* Notification Alert Items */
    .notification-alert-item {
        padding: 15px 20px;
        border-radius: 8px;
        border: 1px solid transparent;
    }

    /* Background & Border Colors */
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

    /* Small Colored Dot */
    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }







    /* ================= Admin Settings Specific Styles ================= */

    /* Top Dark Banner */
    .settings-banner {
        background-color: #1f2937;
        /* Dark navy/gray color like the image */
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
    }

    /* Role Items */
    .role-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        /* Light gray background */
        border: 1px solid #f3f4f6;
        margin-bottom: 12px;
    }

    .role-item:last-child {
        margin-bottom: 0;
    }

    /* Role Badges */
    .role-badge {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .bg-light-red {
        background-color: #fee2e2;
    }

    .text-red {
        color: #ef4444;
    }

    .bg-light-blue {
        background-color: #eff6ff;
    }

    .text-blue {
        color: #3b82f6;
    }

    /* Ensure green classes are present if not already added */
    .bg-light-green {
        background-color: #d1fae5;
    }

    .text-green {
        color: #059669;
    }

    /* System Setting Items */
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .setting-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }


    /* ================= Section Toggling ================= */
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

        .action-bar-mobile {
            flex-direction: column;
            gap: 15px;
            align-items: stretch !important;
        }

        .action-bar-mobile>div {
            width: 100%;
            justify-content: space-between;
        }

        .search-input-group {
            width: 100% !important;
        }
    }
    </style>
</head>

<body>

    <div class="mobile-header">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <span class="material-icons-round">menu</span>
        </button>
        <h5 class="m-0 fw-bold" id="mobile-page-title">Dashboard</h5>
        <div class="notification-icon">
            <i class="material-icons-round">notifications</i>
            <span class="notification-badge">3</span>
        </div>
    </div>

    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div id="sidebar">
        <div class="sidebar-brand">
            HRMS Portal
            <button class="close-sidebar" onclick="toggleSidebar()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="sidebar-nav">
            <a class="nav-item-link dashboard-icon active" onclick="switchTab('dashboard', this)">
                <i class="material-icons-round">bar_chart</i> Dashboard
            </a>
            <a class="nav-item-link employee-icon" onclick="switchTab('employee', this)">
                <i class="material-icons-round">groups</i> Employee Management
            </a>
            <a class="nav-item-link attendance-icon" onclick="switchTab('attendance', this)">
                <i class="material-icons-round">calendar_month</i> Attendance & Leave
            </a>
            <a class="nav-item-link payroll-icon" onclick="switchTab('payroll', this)">
                <i class="material-icons-round">monetization_on</i> Payroll Management
            </a>
            <a class="nav-item-link recruitment-icon" onclick="switchTab('recruitment', this)">
                <i class="material-icons-round">track_changes</i> Recruitment
            </a>
            <a class="nav-item-link performance-icon" onclick="switchTab('performance', this)">
                <i class="material-icons-round">trending_up</i> Performance Management
            </a>
            <a class="nav-item-link notifications-icon" onclick="switchTab('notifications', this)">
                <i class="material-icons-round">notifications</i> Notifications
            </a>
            <a class="nav-item-link settings-icon" onclick="switchTab('settings', this)">
                <i class="material-icons-round">settings</i> Admin Settings
            </a>
            <a class="nav-item-link logout-icon">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger btn-sm fw-bold shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-pill transition-all hover-shadow">

                        <i class="material-icons-round">logout</i> Logout
                    </button>
                </form>
            </a>
        </div>
        <div class="sidebar-footer">
            <div class="admin-badge">Admin Access</div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content">
        <div class="top-header desktop-top-header">
            <h4 id="page-title">Dashboard</h4>
            <div class="notification-icon">
                <i class="material-icons-round">notifications</i>
                <span class="notification-badge">3</span>
            </div>
        </div>

        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section active">
            <div class="welcome-banner">
                <h2>Welcome back, {{ Auth::user()->employeeID }}!</h2>
                <p>Here's an overview of your team metrics and recent activities.</p>
            </div>

            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Total Employees</div>
                            <i class="material-icons-round card-icon icon-blue">groups</i>
                        </div>
                        <div class="metric-value">{{ $totalEmployees }}</div>
                        <div class="metric-trend positive">Updated Just Now</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Active Employees</div>
                            <i class="material-icons-round card-icon icon-green">trending_up</i>
                        </div>
                        <div class="metric-value">{{ $activeEmployees }}</div>
                        <div class="metric-trend positive">Current Status</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Pending Leave Requests</div>
                            <i class="material-icons-round card-icon icon-orange">calendar_month</i>
                        </div>
                        <div class="metric-value">{{ $pendingLeaves }}</div>
                        <div class="metric-trend negative">Needs Attention</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Monthly Payroll</div>
                            <i class="material-icons-round card-icon icon-purple">monetization_on</i>
                        </div>
                        <div class="metric-value">${{ number_format($monthlyPayroll) }}</div>
                        <div class="metric-trend positive">This Month</div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-lg-6">
                    <div class="custom-card">
                        <h6 class="mb-4">Department Overview</h6>

                        @foreach($departments as $dept)
                        <div class="dept-item">
                            <div class="dept-label">
                                <span>{{ $dept->name }}</span>
                                <span>{{ $dept->count }} employees</span>
                            </div>
                            <div class="custom-progress">
                                <div class="custom-progress-bar" style="width: {{ $dept->percentage }}%;"></div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="custom-card">
                        <h6 class="mb-4">Recent Activities</h6>

                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-dot {{ $activity->color }}"></div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $activity->title }}</p>
                                <p class="activity-desc">{{ $activity->desc }}</p>
                            </div>
                            <div class="activity-time">{{ $activity->time }}</div>
                        </div>
                        @empty
                        <p class="text-muted small">No recent activities found.</p>
                        @endforelse

                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <div class="custom-card">
                        <h6 class="mb-3">Upcoming Events & Reminders</h6>

                        @forelse($upcomingEvents as $event)
                        <div class="event-card {{ $event->color_class }}">
                            <div>
                                <p class="event-title">{{ $event->title }}</p>
                                <p class="event-subtitle">{{ $event->subtitle }}</p>
                            </div>
                            <div class="event-time">{{ $event->time }}</div>
                        </div>
                        @empty
                        <p class="text-muted small">No upcoming events at the moment.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Section -->
        <div id="employee" class="content-section">

            <div class="d-flex justify-content-between align-items-center mb-4 action-bar-mobile">
                <div class="d-flex gap-3 flex-wrap flex-grow-1">
                    <div class="search-input-group" style="width: 280px; max-width: 100%;">
                        <i class="material-icons-round">search</i>
                        <input type="text" placeholder="Search employees...">
                    </div>
                    <select class="form-select filter-select" style="width: 180px;">
                        <option>All Departments</option>
                        <option>Engineering</option>
                        <option>Marketing</option>
                        <option>Sales</option>
                        <option>HR</option>
                        <option>Finance</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark d-flex align-items-center gap-2 px-3">
                        <i class="material-icons-round" style="font-size: 18px;">download</i> Export
                    </button>
                    <button class="btn btn-dark d-flex align-items-center gap-2 px-3">
                        <i class="material-icons-round" style="font-size: 18px;">add</i> Add Employee
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-2">
                <div class="col-sm-6 col-lg-3">
                    <div class="emp-summary-card">
                        <p class="emp-summary-value text-dark">248</p>
                        <p class="emp-summary-label">Total Employees</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="emp-summary-card">
                        <p class="emp-summary-value text-green">235</p>
                        <p class="emp-summary-label">Active</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="emp-summary-card">
                        <p class="emp-summary-value text-orange">8</p>
                        <p class="emp-summary-label">On Probation</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="emp-summary-card">
                        <p class="emp-summary-value text-red">5</p>
                        <p class="emp-summary-label">Inactive</p>
                    </div>
                </div>
            </div>

            <div class="custom-card">
                <h6 class="mb-4 text-dark" style="font-weight: 600;">Employee Directory (5 employees)</h6>
                <div class="table-responsive">
                    <table class="table employee-table mb-0">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>ID</th>
                                <th>Department</th>
                                <th>Position</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="emp-name">John Doe</p>
                                    <p class="emp-email">john.doe@company.com</p>
                                </td>
                                <td>EMP001</td>
                                <td>Engineering</td>
                                <td>Senior Developer</td>
                                <td>3/15/2022</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <button class="action-btn edit-btn"><i
                                            class="material-icons-round">edit_square</i></button>
                                    <button class="action-btn delete-btn"><i
                                            class="material-icons-round">delete_outline</i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Sarah Johnson</p>
                                    <p class="emp-email">sarah.johnson@company.com</p>
                                </td>
                                <td>EMP002</td>
                                <td>Marketing</td>
                                <td>Marketing Manager</td>
                                <td>11/22/2021</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <button class="action-btn edit-btn"><i
                                            class="material-icons-round">edit_square</i></button>
                                    <button class="action-btn delete-btn"><i
                                            class="material-icons-round">delete_outline</i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Mike Chen</p>
                                    <p class="emp-email">mike.chen@company.com</p>
                                </td>
                                <td>EMP003</td>
                                <td>Sales</td>
                                <td>Sales Representative</td>
                                <td>1/10/2023</td>
                                <td><span class="status-badge status-probation">Probation</span></td>
                                <td>
                                    <button class="action-btn edit-btn"><i
                                            class="material-icons-round">edit_square</i></button>
                                    <button class="action-btn delete-btn"><i
                                            class="material-icons-round">delete_outline</i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Emily Davis</p>
                                    <p class="emp-email">emily.davis@company.com</p>
                                </td>
                                <td>EMP004</td>
                                <td>HR</td>
                                <td>HR Specialist</td>
                                <td>8/5/2020</td>
                                <td><span class="status-badge status-active">Active</span></td>
                                <td>
                                    <button class="action-btn edit-btn"><i
                                            class="material-icons-round">edit_square</i></button>
                                    <button class="action-btn delete-btn"><i
                                            class="material-icons-round">delete_outline</i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Alex Rivera</p>
                                    <p class="emp-email">alex.rivera@company.com</p>
                                </td>
                                <td>EMP005</td>
                                <td>Finance</td>
                                <td>Financial Analyst</td>
                                <td>6/18/2022</td>
                                <td><span class="status-badge status-inactive">Inactive</span></td>
                                <td>
                                    <button class="action-btn edit-btn"><i
                                            class="material-icons-round">edit_square</i></button>
                                    <button class="action-btn delete-btn"><i
                                            class="material-icons-round">delete_outline</i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Attendance Section -->
        <div id="attendance" class="content-section">

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #3b82f6;"><i
                                class="material-icons-round">calendar_month</i></div>
                        <div>
                            <p class="att-value">24</p>
                            <p class="att-label">Total Leave Days</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #10b981;"><i
                                class="material-icons-round">schedule</i></div>
                        <div>
                            <p class="att-value">8</p>
                            <p class="att-label">Used Leave</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #f59e0b;"><i
                                class="material-icons-round">error_outline</i></div>
                        <div>
                            <p class="att-value">2</p>
                            <p class="att-label">Pending Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #8b5cf6;"><i
                                class="material-icons-round">check_circle_outline</i></div>
                        <div>
                            <p class="att-value">12</p>
                            <p class="att-label">Approved Requests</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-lg-4">
                    <div class="custom-card h-100 d-flex flex-column">
                        <h6 class="mb-4 text-dark" style="font-weight: 600;">Calendar</h6>

                        <div class="calendar-wrapper border rounded p-3 mb-4 flex-grow-1"
                            style="background: #fafafa; border-color: #eaeaea !important;">
                            <div class="calendar-header">
                                <button class="cal-nav-btn"><i class="material-icons-round"
                                        style="font-size:16px;">chevron_left</i></button>
                                <h6>March 2026</h6>
                                <button class="cal-nav-btn"><i class="material-icons-round"
                                        style="font-size:16px;">chevron_right</i></button>
                            </div>

                            <div class="calendar-grid">
                                <div class="calendar-day-header">Su</div>
                                <div class="calendar-day-header">Mo</div>
                                <div class="calendar-day-header">Tu</div>
                                <div class="calendar-day-header">We</div>
                                <div class="calendar-day-header">Th</div>
                                <div class="calendar-day-header">Fr</div>
                                <div class="calendar-day-header">Sa</div>

                                <div class="calendar-date">1</div>
                                <div class="calendar-date">2</div>
                                <div class="calendar-date">3</div>
                                <div class="calendar-date">4</div>
                                <div class="calendar-date">5</div>
                                <div class="calendar-date">6</div>
                                <div class="calendar-date">7</div>
                                <div class="calendar-date">8</div>
                                <div class="calendar-date">9</div>
                                <div class="calendar-date">10</div>
                                <div class="calendar-date">11</div>
                                <div class="calendar-date">12</div>
                                <div class="calendar-date">13</div>
                                <div class="calendar-date">14</div>
                                <div class="calendar-date">15</div>
                                <div class="calendar-date">16</div>
                                <div class="calendar-date">17</div>
                                <div class="calendar-date">18</div>
                                <div class="calendar-date">19</div>
                                <div class="calendar-date">20</div>
                                <div class="calendar-date">21</div>
                                <div class="calendar-date">22</div>
                                <div class="calendar-date active">23</div>
                                <div class="calendar-date">24</div>
                                <div class="calendar-date">25</div>
                                <div class="calendar-date">26</div>
                                <div class="calendar-date">27</div>
                                <div class="calendar-date">28</div>
                                <div class="calendar-date">29</div>
                                <div class="calendar-date">30</div>
                                <div class="calendar-date">31</div>
                                <div class="calendar-date text-muted" style="opacity: 0.5;">1</div>
                                <div class="calendar-date text-muted" style="opacity: 0.5;">2</div>
                                <div class="calendar-date text-muted" style="opacity: 0.5;">3</div>
                                <div class="calendar-date text-muted" style="opacity: 0.5;">4</div>
                            </div>
                        </div>

                        <div>
                            <p class="mb-2" style="font-weight: 600; font-size: 0.9rem; color: #1f2937;">Legend:</p>
                            <div class="cal-legend-item">
                                <div class="cal-dot green"></div> Present
                            </div>
                            <div class="cal-legend-item">
                                <div class="cal-dot red"></div> Leave
                            </div>
                            <div class="cal-legend-item">
                                <div class="cal-dot yellow"></div> Half Day
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="custom-card h-100">
                        <h6 class="mb-4 text-dark" style="font-weight: 600;">Recent Attendance</h6>
                        <div class="table-responsive">
                            <table class="table data-table mb-0">
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
                                    <tr>
                                        <td>2/1/2024</td>
                                        <td>09:00</td>
                                        <td>17:30</td>
                                        <td>8.5h</td>
                                        <td><span class="status-badge status-active px-3 py-1">Present</span></td>
                                    </tr>
                                    <tr>
                                        <td>2/2/2024</td>
                                        <td>09:15</td>
                                        <td>17:45</td>
                                        <td>8.5h</td>
                                        <td><span class="status-badge bg-light text-dark border px-3 py-1">Late</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2/3/2024</td>
                                        <td>09:00</td>
                                        <td>13:00</td>
                                        <td>4h</td>
                                        <td><span class="status-badge bg-light text-muted border px-3 py-1">Half
                                                day</span></td>
                                    </tr>
                                    <tr>
                                        <td>2/4/2024</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>0h</td>
                                        <td><span class="status-badge status-inactive px-3 py-1">Absent</span></td>
                                    </tr>
                                    <tr>
                                        <td>2/5/2024</td>
                                        <td>08:45</td>
                                        <td>17:15</td>
                                        <td>8.5h</td>
                                        <td><span class="status-badge status-active px-3 py-1">Present</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="text-dark m-0" style="font-weight: 600;">Leave Requests</h6>
                            <button class="btn btn-dark d-flex align-items-center gap-2 px-3">
                                <i class="material-icons-round" style="font-size: 18px;">add</i> Apply for Leave
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table data-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Dates</th>
                                        <th>Days</th>
                                        <th>Applied</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="emp-name">John Doe</p>
                                            <p class="emp-email">EMP001</p>
                                        </td>
                                        <td><span class="type-badge">Vacation</span></td>
                                        <td>
                                            <p class="m-0" style="font-size:0.85rem; color:#374151;">2/15/2024</p>
                                            <p class="m-0" style="font-size:0.8rem; color:#6b7280;">to 2/19/2024</p>
                                        </td>
                                        <td>5 day(s)</td>
                                        <td>1/20/2024</td>
                                        <td>
                                            <span
                                                class="status-badge bg-light text-muted border d-inline-flex align-items-center gap-1">
                                                <i class="material-icons-round" style="font-size:14px;">schedule</i>
                                                Pending
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn-approve">Approve</button>
                                                <button class="btn-reject">Reject</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="emp-name">Sarah Johnson</p>
                                            <p class="emp-email">EMP002</p>
                                        </td>
                                        <td><span class="type-badge">Sick</span></td>
                                        <td>
                                            <p class="m-0" style="font-size:0.85rem; color:#374151;">2/10/2024</p>
                                            <p class="m-0" style="font-size:0.8rem; color:#6b7280;">to 2/12/2024</p>
                                        </td>
                                        <td>3 day(s)</td>
                                        <td>2/8/2024</td>
                                        <td>
                                            <span
                                                class="status-badge status-active d-inline-flex align-items-center gap-1">
                                                <i class="material-icons-round" style="font-size:14px;">check_circle</i>
                                                Approved
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="emp-name">Mike Chen</p>
                                            <p class="emp-email">EMP003</p>
                                        </td>
                                        <td><span class="type-badge">Personal</span></td>
                                        <td>
                                            <p class="m-0" style="font-size:0.85rem; color:#374151;">2/20/2024</p>
                                            <p class="m-0" style="font-size:0.8rem; color:#6b7280;">to 2/20/2024</p>
                                        </td>
                                        <td>1 day(s)</td>
                                        <td>2/5/2024</td>
                                        <td>
                                            <span
                                                class="status-badge status-inactive d-inline-flex align-items-center gap-1">
                                                <i class="material-icons-round" style="font-size:14px;">cancel</i>
                                                Rejected
                                            </span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payroll Section -->
        <div id="payroll" class="content-section">

            <div class="d-flex justify-content-between align-items-center mb-4 action-bar-mobile">
                <div class="d-flex gap-3">
                    <select class="form-select filter-select" style="width: 180px; font-size: 0.9rem;">
                        <option>February 2024</option>
                        <option>January 2024</option>
                        <option>December 2023</option>
                    </select>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn bg-white border d-flex align-items-center gap-2 px-3 text-dark"
                        style="font-size: 0.9rem; font-weight: 500;">
                        <i class="material-icons-round text-muted" style="font-size: 18px;">calculate</i> Generate
                        Payroll
                    </button>
                    <button class="btn bg-white border d-flex align-items-center gap-2 px-3 text-dark"
                        style="font-size: 0.9rem; font-weight: 500;">
                        <i class="material-icons-round text-muted" style="font-size: 18px;">file_download</i> Export
                        Report
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #3b82f6;"><i class="material-icons-round">groups</i>
                        </div>
                        <div>
                            <p class="att-value">4</p>
                            <p class="att-label">Total Employees</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #10b981;"><i
                                class="material-icons-round">attach_money</i></div>
                        <div>
                            <p class="att-value">$25,650</p>
                            <p class="att-label">Total Payroll</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #8b5cf6;"><i
                                class="material-icons-round">trending_up</i></div>
                        <div>
                            <p class="att-value">2</p>
                            <p class="att-label">Processed</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="att-summary-card">
                        <div class="att-icon-wrapper" style="color: #f97316;"><i
                                class="material-icons-round">description</i></div>
                        <div>
                            <p class="att-value">1</p>
                            <p class="att-label">Pending</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom-card">
                <h6 class="mb-4 text-dark" style="font-weight: 600;">Payroll Records - February 2024</h6>

                <div class="table-responsive">
                    <table class="table data-table mb-0">
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
                            <tr>
                                <td>
                                    <p class="emp-name">John Doe</p>
                                    <p class="emp-email">EMP001</p>
                                </td>
                                <td>Engineering</td>
                                <td>$8,000</td>
                                <td>$2,000</td>
                                <td>$800</td>
                                <td>$1,200</td>
                                <td style="font-weight: 600; color: #1f2937;">$8,000</td>
                                <td><span class="status-badge status-active px-3 py-1">Processed</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">visibility</i></button>
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">file_download</i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Sarah Johnson</p>
                                    <p class="emp-email">EMP002</p>
                                </td>
                                <td>Marketing</td>
                                <td>$6,500</td>
                                <td>$1,500</td>
                                <td>$650</td>
                                <td>$950</td>
                                <td style="font-weight: 600; color: #1f2937;">$6,400</td>
                                <td><span class="status-badge status-active px-3 py-1">Processed</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">visibility</i></button>
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">file_download</i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Mike Chen</p>
                                    <p class="emp-email">EMP003</p>
                                </td>
                                <td>Sales</td>
                                <td>$5,500</td>
                                <td>$1,200</td>
                                <td>$550</td>
                                <td>$800</td>
                                <td style="font-weight: 600; color: #1f2937;">$5,350</td>
                                <td><span class="status-badge bg-light text-muted border px-3 py-1">Pending</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">visibility</i></button>
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">file_download</i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="emp-name">Emily Davis</p>
                                    <p class="emp-email">EMP004</p>
                                </td>
                                <td>HR</td>
                                <td>$6,000</td>
                                <td>$1,400</td>
                                <td>$600</td>
                                <td>$900</td>
                                <td style="font-weight: 600; color: #1f2937;">$5,900</td>
                                <td><span class="status-badge bg-white text-dark border px-3 py-1">Approved</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">visibility</i></button>
                                        <button class="btn-outline-action"><i
                                                class="material-icons-round">file_download</i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Recruitment Section -->
        <div id="recruitment" class="content-section">

            <div class="recruitment-banner mb-4">
                <h3 class="fw-bold mb-2">Recruitment Management</h3>
                <p class="mb-0">Manage job postings, track applications, and schedule interviews</p>
            </div>

            <div class="row g-4">

                <div class="col-lg-4">
                    <div class="custom-card h-100 p-0 overflow-hidden">
                        <div class="p-3 border-bottom border-light">
                            <h6 class="m-0 fw-bold text-dark">Open Positions</h6>
                        </div>
                        <div class="p-3">

                            <div class="recruitment-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">Senior Frontend Developer</h6>
                                        <p class="text-muted small mb-0">Engineering &bull; 12 applicants</p>
                                    </div>
                                    <span class="status-badge bg-light-green text-green px-2 py-1">Active</span>
                                </div>
                            </div>

                            <div class="recruitment-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">Marketing Specialist</h6>
                                        <p class="text-muted small mb-0">Marketing &bull; 8 applicants</p>
                                    </div>
                                    <span class="status-badge bg-light-green text-green px-2 py-1">Active</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="custom-card h-100 p-0 overflow-hidden">
                        <div class="p-3 border-bottom border-light">
                            <h6 class="m-0 fw-bold text-dark">Recent Applications</h6>
                        </div>
                        <div class="p-3">

                            <div class="recruitment-item bg-light-gray">
                                <h6 class="fw-bold mb-1 text-dark">Sarah Wilson</h6>
                                <p class="text-muted small mb-1">Applied for Senior Frontend Developer</p>
                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">2 hours ago</p>
                            </div>

                            <div class="recruitment-item bg-light-gray">
                                <h6 class="fw-bold mb-1 text-dark">David Chen</h6>
                                <p class="text-muted small mb-1">Applied for Marketing Specialist</p>
                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">5 hours ago</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="custom-card h-100 p-0 overflow-hidden">
                        <div class="p-3 border-bottom border-light">
                            <h6 class="m-0 fw-bold text-dark">Upcoming Interviews</h6>
                        </div>
                        <div class="p-3">

                            <div class="recruitment-item bg-light-blue">
                                <h6 class="fw-bold mb-1 text-dark">Technical Interview</h6>
                                <p class="text-muted small mb-1">John Smith - Frontend Dev</p>
                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">Tomorrow 2:00 PM</p>
                            </div>

                            <div class="recruitment-item bg-light-blue">
                                <h6 class="fw-bold mb-1 text-dark">Final Round</h6>
                                <p class="text-muted small mb-1">Lisa Johnson - Marketing</p>
                                <p class="text-muted small mb-0" style="font-size: 0.75rem;">Friday 10:00 AM</p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Performance Management Section -->
        <div id="performance" class="content-section">

            <div class="performance-banner mb-4">
                <h3 class="fw-bold mb-2">Performance Management</h3>
                <p class="mb-0">Track goals, conduct reviews, and manage employee performance</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="custom-card h-100">
                        <h6 class="mb-4 text-dark fw-bold">Performance Overview</h6>

                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light"
                            style="border-color: #f3f4f6 !important;">
                            <span class="text-dark" style="font-weight: 500;">Avg. Performance Score</span>
                            <span class="fw-bold text-success" style="font-size: 1.1rem;">4.2/5.0</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light"
                            style="border-color: #f3f4f6 !important;">
                            <span class="text-dark" style="font-weight: 500;">Reviews Completed</span>
                            <span class="fw-bold text-dark" style="font-size: 1.1rem;">23/30</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark" style="font-weight: 500;">Goals Met</span>
                            <span class="fw-bold" style="font-size: 1.1rem; color: #3b82f6;">85%</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="custom-card h-100">
                        <h6 class="mb-4 text-dark fw-bold">Recent Reviews</h6>

                        <div class="review-item">
                            <h6 class="fw-bold mb-1 text-dark">John Doe</h6>
                            <p class="text-muted small mb-0">Q1 2024 Review &bull; Score: 4.5/5</p>
                        </div>

                        <div class="review-item mt-3">
                            <h6 class="fw-bold mb-1 text-dark">Sarah Johnson</h6>
                            <p class="text-muted small mb-0">Q1 2024 Review &bull; Score: 4.2/5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Notifications Section -->
        <div id="notifications" class="content-section">

            <div class="notifications-banner mb-4">
                <h3 class="fw-bold mb-2">Notifications & Reminders</h3>
                <p class="mb-0">Stay updated with important HR notifications and reminders</p>
            </div>

            <div class="custom-card">
                <h6 class="mb-4 text-dark fw-bold">Recent Notifications</h6>

                <div class="notification-alert-item bg-light-blue border-blue">
                    <div class="d-flex align-items-start gap-3">
                        <div class="mt-1"><span class="notif-dot bg-blue"></span></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Leave Request Approval</h6>
                            <p class="text-muted small mb-1">Sarah Johnson's vacation request has been approved</p>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">2 hours ago</p>
                        </div>
                    </div>
                </div>

                <div class="notification-alert-item bg-light-green border-green mt-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="mt-1"><span class="notif-dot bg-green"></span></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">New Employee Onboarding</h6>
                            <p class="text-muted small mb-1">Alex Rivera has completed onboarding process</p>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">4 hours ago</p>
                        </div>
                    </div>
                </div>

                <div class="notification-alert-item bg-light-yellow border-yellow mt-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="mt-1"><span class="notif-dot bg-yellow"></span></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Performance Review Reminder</h6>
                            <p class="text-muted small mb-1">Q1 performance reviews are due in 3 days</p>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">1 day ago</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Settings Section -->
        <div id="settings" class="content-section">

            <div class="settings-banner mb-4">
                <h3 class="fw-bold mb-2">Admin Settings</h3>
                <p class="mb-0">Manage system settings, user roles, and permissions</p>
            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="custom-card h-100">
                        <h6 class="mb-4 text-dark fw-bold">User Roles & Permissions</h6>

                        <div class="role-item">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Administrator</h6>
                                <p class="text-muted small mb-0">Full system access</p>
                            </div>
                            <span class="role-badge bg-light-red text-red">3 users</span>
                        </div>

                        <div class="role-item">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">HR Manager</h6>
                                <p class="text-muted small mb-0">HR operations access</p>
                            </div>
                            <span class="role-badge bg-light-blue text-blue">8 users</span>
                        </div>

                        <div class="role-item">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Employee</h6>
                                <p class="text-muted small mb-0">Limited self-service access</p>
                            </div>
                            <span class="role-badge bg-light-green text-green">235 users</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="custom-card h-100">
                        <h6 class="mb-4 text-dark fw-bold">System Settings</h6>

                        <div class="setting-item">
                            <span class="text-dark">Company Name</span>
                            <span class="text-muted">Acme Corporation</span>
                        </div>

                        <div class="setting-item">
                            <span class="text-dark">Fiscal Year</span>
                            <span class="text-muted">Jan - Dec</span>
                        </div>

                        <div class="setting-item">
                            <span class="text-dark">Currency</span>
                            <span class="text-muted">USD ($)</span>
                        </div>

                        <div class="setting-item">
                            <span class="text-dark">Time Zone</span>
                            <span class="text-muted">EST (UTC-5)</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Sidebar Toggle for Mobile View
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('show-sidebar');
        overlay.style.display = sidebar.classList.contains('show-sidebar') ? 'block' : 'none';
    }

    // Tab Switching Logic
    function switchTab(sectionId, element) {
        // 1. Update Active Class in Sidebar
        document.querySelectorAll('.nav-item-link').forEach(link => link.classList.remove('active'));
        element.classList.add('active');

        // 2. Update Content Sections
        document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(sectionId).classList.add('active');

        // 3. Extract Clean Title Text (Ignoring the Icon Text)
        const tempElement = element.cloneNode(true);
        const icon = tempElement.querySelector('.material-icons-round');
        if (icon) icon.remove(); // Remove icon text from copy
        const pageTitleText = tempElement.textContent.replace(/\s+/g, ' ').trim(); // Clean up spaces

        // 4. Set Header Titles
        document.getElementById('page-title').innerText = pageTitleText;
        document.getElementById('mobile-page-title').innerText = pageTitleText;

        // 5. Close Sidebar on Mobile if open
        if (window.innerWidth < 992) toggleSidebar();
    }
    </script>
</body>

</html>