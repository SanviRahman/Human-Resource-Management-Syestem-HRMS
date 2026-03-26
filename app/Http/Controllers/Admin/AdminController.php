<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Interview;
use App\Models\JobApplication;
use App\Models\JobPosition;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\Payroll;
use App\Models\PerformanceGoal;
use App\Models\PerformanceReview;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->get('search');
        $department = $request->get('department');

        $employeeQuery = Employee::query();

        if (! empty($search)) {
            $employeeQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        if (! empty($department) && $department !== 'all') {
            $employeeQuery->where('department', $department);
        }

        $employees = $employeeQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allEmployees = Employee::orderBy('name')->get();

        $employeeStats = [
            'total'     => Employee::count(),
            'active'    => Employee::where('status', 'active')->count(),
            'probation' => Employee::where('status', 'probation')->count(),
            'inactive'  => Employee::where('status', 'inactive')->count(),
        ];

        $departments = Employee::whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        $now        = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd   = $now->copy()->endOfMonth();

        // dashboard
        $totalEmployees        = $employeeStats['total'];
        $activeEmployees       = $employeeStats['active'];
        $newEmployeesThisMonth = Employee::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        $activePercentage      = $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0;

        $pendingLeaveRequests = Schema::hasTable('leave_requests')
            ? LeaveRequest::where('status', 'pending')->count()
            : 0;

        $approvedLeavesThisMonth = Schema::hasTable('leave_requests')
            ? LeaveRequest::where('status', 'approved')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count()
            : 0;

        $monthlyPayroll = Schema::hasTable('payrolls')
            ? Payroll::whereBetween('payroll_month', [
            $monthStart->toDateString(),
            $monthEnd->toDateString(),
        ])->sum('net_pay')
            : 0;

        $departmentOverview = Employee::select('department', DB::raw('COUNT(*) as total'))
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        $maxDepartmentCount = $departmentOverview->max('total') ?: 1;

        $recentActivities = collect();
        if (Schema::hasTable('activities') && class_exists(Activity::class)) {
            $recentActivities = Activity::latest()
                ->take(5)
                ->get()
                ->map(function ($activity) {
                    return [
                        'title'     => $activity->title,
                        'desc'      => $activity->description,
                        'time'      => $activity->created_at ? $activity->created_at->diffForHumans() : '',
                        'dot_class' => match ($activity->type) {
                            'success' => 'dot-green',
                            'warning' => 'dot-yellow',
                            default   => 'dot-blue',
                        },
                    ];
                });
        }

        $upcomingEvents = collect();
        if (Schema::hasTable('events') && class_exists(Event::class)) {
            $upcomingEvents = Event::whereDate('event_date', '>=', $now->toDateString())
                ->orderBy('event_date')
                ->take(3)
                ->get()
                ->map(function ($event) {
                    $eventTime = Carbon::parse($event->event_date);

                    return [
                        'title'    => $event->title,
                        'subtitle' => $event->subtitle,
                        'time'     => $eventTime->isToday()
                            ? 'Today ' . $eventTime->format('h:i A')
                            : ($eventTime->isTomorrow()
                                ? 'Tomorrow ' . $eventTime->format('h:i A')
                                : $eventTime->format('M d, Y h:i A')),
                        'bg_class' => match ($event->type) {
                            'success' => 'event-green',
                            'warning' => 'event-orange',
                            default   => 'event-blue',
                        },
                    ];
                });
        }

        // attendance section
        $attendanceStats = [
            'total_leave_days'  => Schema::hasTable('leave_requests') ? LeaveRequest::sum('days') : 0,
            'used_leave'        => Schema::hasTable('leave_requests') ? LeaveRequest::where('status', 'approved')->sum('days') : 0,
            'pending_requests'  => Schema::hasTable('leave_requests') ? LeaveRequest::where('status', 'pending')->count() : 0,
            'approved_requests' => Schema::hasTable('leave_requests') ? LeaveRequest::where('status', 'approved')->count() : 0,
        ];

        $recentAttendance = Schema::hasTable('attendances')
            ? Attendance::with('employee')->latest('attendance_date')->take(10)->get()
            : collect();

        $leaveRequests = Schema::hasTable('leave_requests')
            ? LeaveRequest::with('employee')->latest()->take(10)->get()
            : collect();

        $attendanceMonth = $request->get('attendance_month', now()->format('Y-m'));
        $calendarBase    = Carbon::createFromFormat('Y-m', $attendanceMonth)->startOfMonth();
        $calendarStart   = $calendarBase->copy()->startOfWeek(Carbon::SUNDAY);
        $calendarEnd     = $calendarBase->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $attendanceCalendar = [];
        $current            = $calendarStart->copy();

        while ($current <= $calendarEnd) {
            $attendanceCalendar[] = [
                'date'             => $current->copy(),
                'day'              => $current->day,
                'is_current_month' => $current->month === $calendarBase->month,
                'is_today'         => $current->isToday(),
            ];
            $current->addDay();
        }

        $attendanceMonthLabel = $calendarBase->format('F Y');
        $prevAttendanceMonth  = $calendarBase->copy()->subMonth()->format('Y-m');
        $nextAttendanceMonth  = $calendarBase->copy()->addMonth()->format('Y-m');

        // payroll section
        $selectedPayrollMonth = $request->get('payroll_month', now()->format('Y-m'));
        $payrollMonthDate     = Carbon::createFromFormat('Y-m', $selectedPayrollMonth)->startOfMonth();

        $payrollQuery = Payroll::with('employee')
            ->whereYear('payroll_month', $payrollMonthDate->year)
            ->whereMonth('payroll_month', $payrollMonthDate->month)
            ->orderByDesc('created_at');

        $payrollRecords = $payrollQuery->get();

        $payrollStats = [
            'total_employees' => $payrollRecords->count(),
            'total_payroll'   => $payrollRecords->sum('net_pay'),
            'processed'       => $payrollRecords->where('status', 'processed')->count(),
            'pending'         => $payrollRecords->where('status', 'pending')->count(),
        ];

        $availablePayrollMonths = Payroll::selectRaw('DATE_FORMAT(payroll_month, "%Y-%m") as month_value')
            ->distinct()
            ->orderByDesc('month_value')
            ->pluck('month_value');

        if (! $availablePayrollMonths->contains($selectedPayrollMonth)) {
            $availablePayrollMonths = $availablePayrollMonths->prepend($selectedPayrollMonth)->unique()->values();
        }

        $payrollMonthLabel = $payrollMonthDate->format('F Y');

        // Reqruitment Section
        $openPositions = Schema::hasTable('job_positions')
            ? JobPosition::withCount('applications')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get()
            : collect();

        $recentApplications = Schema::hasTable('job_applications')
            ? JobApplication::with('jobPosition')
            ->latest()
            ->take(5)
            ->get()
            : collect();

        $upcomingInterviews = Schema::hasTable('interviews')
            ? Interview::with('jobApplication.jobPosition')
            ->where('scheduled_at', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get()
            : collect();

        $performanceOverview = [
            'avg_score'            => 0,
            'completed_reviews'    => 0,
            'total_reviews'        => 0,
            'goals_met_percentage' => 0,
        ];

        // performance Section
        $recentPerformanceReviews = collect();

        if (Schema::hasTable('performance_reviews')) {
            $performanceOverview['avg_score'] = round(
                (float) PerformanceReview::where('status', 'completed')->avg('score'),
                1
            );

            $performanceOverview['completed_reviews'] = PerformanceReview::where('status', 'completed')->count();
            $performanceOverview['total_reviews']     = PerformanceReview::count();

            $recentPerformanceReviews = PerformanceReview::with('employee')
                ->where('status', 'completed')
                ->latest('review_date')
                ->take(5)
                ->get();
        }

        if (Schema::hasTable('performance_goals')) {
            $totalGoals     = PerformanceGoal::count();
            $completedGoals = PerformanceGoal::where('status', 'completed')->count();

            $performanceOverview['goals_met_percentage'] = $totalGoals > 0
                ? round(($completedGoals / $totalGoals) * 100)
                : 0;
        }

        // Notification section
        $recentNotifications = Schema::hasTable('notifications')
            ? Notification::latest()->take(10)->get()
            : collect();

        //Admin settings section
        $roleStats = [
            'admin' => 0,
            'hr'    => 0,
            'user'  => 0,
        ];

        if (Schema::hasTable('users')) {
            $roleStats['admin'] = User::where('role', 'admin')->count();
            $roleStats['hr']    = User::where('role', 'hr')->count();
            $roleStats['user']  = User::where('role', 'user')->count();
        }

        $systemSettings = Schema::hasTable('system_settings')
            ? SystemSetting::first()
            : null;

        // Notification count
        $unreadNotificationCount = Schema::hasTable('notifications')
            ? Notification::where('is_read', false)->count()
            : 0;
            
        return view('admin.dashboard', compact(
            'employees',
            'allEmployees',
            'employeeStats',
            'departments',
            'search',
            'department',
            'totalEmployees',
            'activeEmployees',
            'newEmployeesThisMonth',
            'activePercentage',
            'pendingLeaveRequests',
            'approvedLeavesThisMonth',
            'monthlyPayroll',
            'departmentOverview',
            'maxDepartmentCount',
            'recentActivities',
            'upcomingEvents',
            'attendanceStats',
            'recentAttendance',
            'leaveRequests',
            'attendanceCalendar',
            'attendanceMonthLabel',
            'prevAttendanceMonth',
            'nextAttendanceMonth',
            'payrollRecords',
            'payrollStats',
            'selectedPayrollMonth',
            'availablePayrollMonths',
            'payrollMonthLabel',
            'openPositions',
            'recentApplications',
            'upcomingInterviews',
            'performanceOverview',
            'recentPerformanceReviews',
            'recentNotifications',
            'roleStats',
            'systemSettings',
            'unreadNotificationCount',
        ));
    }
}
