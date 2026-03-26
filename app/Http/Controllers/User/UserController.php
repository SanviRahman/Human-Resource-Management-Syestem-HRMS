<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Employee;
use App\Models\Event;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
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

        // Notification section
        $recentNotifications = Schema::hasTable('notifications')
            ? Notification::latest()->take(10)->get()
            : collect();

        // Notification count
        $unreadNotificationCount = Schema::hasTable('notifications')
            ? Notification::where('is_read', false)->count()
            : 0;

        return view('user.dashboard', compact(
            'employees',
            'allEmployees',
            'employeeStats',
            'departments',
            'totalEmployees',
            'activeEmployees',
            'recentNotifications',
            'newEmployeesThisMonth',
            'activePercentage',
            'pendingLeaveRequests',
            'approvedLeavesThisMonth',
            'monthlyPayroll',
            'departmentOverview',
            'maxDepartmentCount',
            'recentActivities',
            'upcomingEvents'
        ));
    }
}
