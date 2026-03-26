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
        <button class="mobile-menu-btn" type="button" onclick="toggleSidebar()">
            <span class="material-icons-round">menu</span>
        </button>

        <h5 class="m-0 fw-bold" id="mobile-page-title">Dashboard</h5>

        <div class="notification-icon js-open-notifications" style="cursor: pointer;">
            <i class="material-icons-round">notifications</i>
            @if(($unreadNotificationCount ?? 0) > 0)
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
                <i class="material-icons-round">bar_chart</i> Dashboard
            </a>

            <a href="#" class="nav-item-link attendance-icon" data-section="attendance">
                <i class="material-icons-round">calendar_month</i> Attendance & Leave
            </a>

            <a href="#" class="nav-item-link notifications-icon" data-section="notifications">
                <i class="material-icons-round">notifications</i> Notifications
            </a>

            <div class="nav-item-link logout-icon">
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger btn-sm fw-bold shadow-sm px-4 py-2 d-flex align-items-center gap-2 rounded-pill w-100 justify-content-center">
                        <i class="material-icons-round">logout</i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="admin-badge">User Access</div>
        </div>
    </div>



    <!-- Main Content -->
    <div id="main-content">
        <div class="top-header desktop-top-header">
            <h4 id="page-title">Dashboard</h4>

            <div class="notification-icon js-open-notifications" style="cursor: pointer;">
                <i class="material-icons-round">notifications</i>
                @if(($unreadNotificationCount ?? 0) > 0)
                <span class="notification-badge">
                    {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                </span>
                @endif
            </div>
        </div>

        <!-- Dashboard Section -->
        <div id="dashboard" class="content-section active">
            <div class="welcome-banner">
                <h2>Welcome back to user dashboard</h2>
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
                        <div class="metric-trend positive">+{{ $newEmployeesThisMonth }} joined this month</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Active Employees</div>
                            <i class="material-icons-round card-icon icon-green">trending_up</i>
                        </div>
                        <div class="metric-value">{{ $activeEmployees }}</div>
                        <div class="metric-trend positive">{{ $activePercentage }}% of total employees</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Pending Leave Requests</div>
                            <i class="material-icons-round card-icon icon-orange">calendar_month</i>
                        </div>
                        <div class="metric-value">{{ $pendingLeaveRequests }}</div>
                        <div class="metric-trend negative">{{ $approvedLeavesThisMonth }} approved this month</div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="custom-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="metric-title">Monthly Payroll</div>
                            <i class="material-icons-round card-icon icon-purple">monetization_on</i>
                        </div>
                        <div class="metric-value">${{ number_format($monthlyPayroll, 2) }}</div>
                        <div class="metric-trend positive">{{ now()->format('F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-lg-6">
                    <div class="custom-card">
                        <h6 class="mb-4">Department Overview</h6>

                        @forelse($departmentOverview as $department)
                        @php
                        $width = $maxDepartmentCount > 0 ? ($department->total / $maxDepartmentCount) * 100 : 0;
                        @endphp

                        <div class="dept-item">
                            <div class="dept-label">
                                <span>{{ $department->department }}</span>
                                <span>{{ $department->total }} employees</span>
                            </div>
                            <div class="custom-progress">
                                <div class="custom-progress-bar" style="width: {{ $width }}%;"></div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No department data found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="custom-card">
                        <h6 class="mb-4">Recent Activities</h6>

                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-dot {{ $activity['dot_class'] }}"></div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $activity['title'] }}</p>
                                <p class="activity-desc">{{ $activity['desc'] }}</p>
                            </div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No recent activities found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-12">
                    <div class="custom-card">
                        <h6 class="mb-3">Upcoming Events & Reminders</h6>

                        @forelse($upcomingEvents as $event)
                        <div class="event-card {{ $event['bg_class'] }}">
                            <div>
                                <p class="event-title">{{ $event['title'] }}</p>
                                <p class="event-subtitle">{{ $event['subtitle'] }}</p>
                            </div>
                            <div class="event-time">{{ $event['time'] }}</div>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No upcoming events found.</p>
                        @endforelse
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

                @forelse($recentNotifications as $notification)
                @php
                $wrapperClass = 'bg-light-blue border-blue';
                $dotClass = 'bg-blue';

                if ($notification->type === 'success') {
                $wrapperClass = 'bg-light-green border-green';
                $dotClass = 'bg-green';
                } elseif ($notification->type === 'warning') {
                $wrapperClass = 'bg-light-yellow border-yellow';
                $dotClass = 'bg-yellow';
                }
                @endphp

                <div class="notification-alert-item {{ $wrapperClass }} {{ !$loop->first ? 'mt-3' : '' }}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="mt-1"><span class="notif-dot {{ $dotClass }}"></span></div>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    let isMarkingNotificationsRead = false;

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

    async function markNotificationsAsRead() {
        if (isMarkingNotificationsRead) return;

        isMarkingNotificationsRead = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await fetch("{{ route('admin.notifications.read-all') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (response.ok) {
                removeNotificationBadges();
            }
        } catch (error) {
            console.error('Failed to mark notifications as read:', error);
        } finally {
            isMarkingNotificationsRead = false;
        }
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

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar navigation
        document.querySelectorAll('.nav-item-link[data-section]').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const sectionId = this.dataset.section;
                switchTab(sectionId, this);
            });
        });

        // Desktop + mobile bell click
        document.querySelectorAll('.js-open-notifications').forEach(icon => {
            icon.addEventListener('click', function() {
                openNotificationsTab();
            });
        });

        // Load active tab from query string
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'dashboard';

        const activeLink = document.querySelector('.nav-item-link[data-section="' + activeTab + '"]');
        if (activeLink) {
            switchTab(activeTab, activeLink, {
                updateUrl: false,
                closeMobileSidebar: false
            });
        } else {
            const dashboardLink = document.querySelector('.nav-item-link[data-section="dashboard"]');
            if (dashboardLink) {
                switchTab('dashboard', dashboardLink, {
                    updateUrl: false,
                    closeMobileSidebar: false
                });
            }
        }
    });
    </script>
</body>

</html>
