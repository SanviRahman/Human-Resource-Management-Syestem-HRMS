<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\Activity;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();

        // Top summary
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();

        // payroll_month যদি date/month column হয়
        $monthlyPayroll = Payroll::whereBetween('payroll_month', [
                $monthStart->toDateString(),
                $monthEnd->toDateString()
            ])
            ->sum('net_pay');

        // Trend / extra info
        $newEmployeesThisMonth = Employee::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        $approvedLeavesThisMonth = LeaveRequest::where('status', 'approved')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();

        $activePercentage = $totalEmployees > 0
            ? round(($activeEmployees / $totalEmployees) * 100)
            : 0;

        // Department overview
        $departmentOverview = Employee::select('department', DB::raw('COUNT(*) as total'))
            ->whereNotNull('department')
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        $maxDepartmentCount = $departmentOverview->max('total') ?: 1;

        // Recent activities
        $recentActivities = Activity::latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                return [
                    'title' => $activity->title,
                    'desc' => $activity->description,
                    'time' => $activity->created_at->diffForHumans(),
                    'dot_class' => match ($activity->type) {
                        'success' => 'dot-green',
                        'warning' => 'dot-yellow',
                        default => 'dot-blue',
                    },
                ];
            });

        // Upcoming events
        $upcomingEvents = Event::whereDate('event_date', '>=', $now->toDateString())
            ->orderBy('event_date')
            ->take(3)
            ->get()
            ->map(function ($event) use ($now) {
                return [
                    'title' => $event->title,
                    'subtitle' => $event->subtitle,
                    'time' => $event->event_date->isToday()
                        ? 'Today ' . $event->event_date->format('h:i A')
                        : ($event->event_date->isTomorrow()
                            ? 'Tomorrow ' . $event->event_date->format('h:i A')
                            : $event->event_date->format('M d, Y h:i A')),
                    'bg_class' => match ($event->type) {
                        'success' => 'event-green',
                        'warning' => 'event-orange',
                        default => 'event-blue',
                    },
                ];
            });

        return view('admin.dashboard', compact(
            'totalEmployees',
            'activeEmployees',
            'pendingLeaveRequests',
            'monthlyPayroll',
            'newEmployeesThisMonth',
            'approvedLeavesThisMonth',
            'activePercentage',
            'departmentOverview',
            'maxDepartmentCount',
            'recentActivities',
            'upcomingEvents'
        ));
    }
}