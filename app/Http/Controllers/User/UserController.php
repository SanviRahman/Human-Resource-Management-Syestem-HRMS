<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $employee = $this->getAuthenticatedEmployee();

        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $calendarDate = Carbon::create($year, $month, 1);
        $monthStart = $calendarDate->copy()->startOfMonth();
        $monthEnd = $calendarDate->copy()->endOfMonth();

        $recentNotifications = collect();
        $unreadNotificationCount = 0;

        if (Schema::hasTable('notifications') && class_exists(Notification::class)) {
            $notificationQuery = Notification::query()->latest();

            if ($employee && Schema::hasColumn('notifications', 'employee_id')) {
                $notificationQuery->where('employee_id', $employee->id);
            }

            $recentNotifications = (clone $notificationQuery)->take(10)->get();

            if (Schema::hasColumn('notifications', 'is_read')) {
                $unreadNotificationCount = (clone $notificationQuery)
                    ->where('is_read', false)
                    ->count();
            }
        }

        $payrollMonthOptions = collect();
        $selectedPayrollMonth = null;
        $selectedPayrollMonthLabel = now()->format('F Y');
        $payrollRecords = collect();
        $latestPayroll = null;
        $totalPayslips = 0;
        $totalNetPay = 0;
        $processedPayslips = 0;
        $pendingPayslips = 0;

        if (! $employee) {
            return view('user.dashboard', [
                'employee' => null,
                'totalLeaveDays' => 24,
                'usedLeaveDays' => 0,
                'pendingRequestsCount' => 0,
                'approvedRequestsCount' => 0,
                'calendarMonthLabel' => $calendarDate->format('F Y'),
                'calendarDays' => [],
                'recentAttendance' => collect(),
                'leaveRequests' => collect(),
                'recentNotifications' => $recentNotifications,
                'unreadNotificationCount' => $unreadNotificationCount,
                'prevMonthUrl' => route('dashboard', [
                    'tab' => 'attendance',
                    'month' => $calendarDate->copy()->subMonth()->month,
                    'year' => $calendarDate->copy()->subMonth()->year,
                ]),
                'nextMonthUrl' => route('dashboard', [
                    'tab' => 'attendance',
                    'month' => $calendarDate->copy()->addMonth()->month,
                    'year' => $calendarDate->copy()->addMonth()->year,
                ]),
                'payrollMonthOptions' => $payrollMonthOptions,
                'selectedPayrollMonthValue' => null,
                'selectedPayrollMonthLabel' => $selectedPayrollMonthLabel,
                'payrollRecords' => $payrollRecords,
                'latestPayroll' => $latestPayroll,
                'totalPayslips' => $totalPayslips,
                'totalNetPay' => $totalNetPay,
                'processedPayslips' => $processedPayslips,
                'pendingPayslips' => $pendingPayslips,
            ]);
        }

        $totalLeaveDays = 24;

        $usedLeaveDays = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->sum('days');

        $pendingRequestsCount = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')
            ->count();

        $approvedRequestsCount = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->count();

        $recentAttendance = Attendance::where('employee_id', $employee->id)
            ->orderByDesc('attendance_date')
            ->take(5)
            ->get();

        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $attendanceMap = Attendance::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->get()
            ->keyBy(function ($item) {
                return $item->attendance_date->format('Y-m-d');
            });

        $approvedLeaves = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->where(function ($query) use ($monthStart, $monthEnd) {
                $query->whereBetween('start_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                    ->orWhereBetween('end_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                    ->orWhere(function ($q) use ($monthStart, $monthEnd) {
                        $q->where('start_date', '<=', $monthStart->toDateString())
                            ->where('end_date', '>=', $monthEnd->toDateString());
                    });
            })
            ->get();

        $leaveDateMap = [];

        foreach ($approvedLeaves as $leave) {
            $periodStart = $leave->start_date->copy()->lt($monthStart)
                ? $monthStart->copy()
                : $leave->start_date->copy();

            $periodEnd = $leave->end_date->copy()->gt($monthEnd)
                ? $monthEnd->copy()
                : $leave->end_date->copy();

            foreach (CarbonPeriod::create($periodStart, $periodEnd) as $date) {
                $leaveDateMap[$date->format('Y-m-d')] = 'leave';
            }
        }

        $calendarDays = [];

        for ($i = 0; $i < $monthStart->dayOfWeek; $i++) {
            $calendarDays[] = null;
        }

        for ($day = 1; $day <= $monthEnd->day; $day++) {
            $date = $monthStart->copy()->day($day);
            $key = $date->format('Y-m-d');

            $status = $leaveDateMap[$key] ?? optional($attendanceMap->get($key))->status;

            $calendarDays[] = [
                'day' => $day,
                'date' => $key,
                'status' => $status,
                'is_today' => $date->isToday(),
            ];
        }

        while (count($calendarDays) % 7 !== 0) {
            $calendarDays[] = null;
        }

        $prevDate = $calendarDate->copy()->subMonth();
        $nextDate = $calendarDate->copy()->addMonth();

        $payrollBaseQuery = Payroll::with('employee')
            ->where('employee_id', $employee->id);

        $latestPayroll = (clone $payrollBaseQuery)
            ->orderByDesc('payroll_month')
            ->first();

        $payrollMonthOptions = (clone $payrollBaseQuery)
            ->orderByDesc('payroll_month')
            ->get(['payroll_month'])
            ->map(function ($item) {
                return Carbon::parse($item->payroll_month)->startOfMonth();
            })
            ->unique(function ($item) {
                return $item->format('Y-m');
            })
            ->values();

        $requestedPayrollMonth = $request->get('payroll_month');

        if ($requestedPayrollMonth) {
            try {
                $selectedPayrollMonth = Carbon::createFromFormat('Y-m', $requestedPayrollMonth)->startOfMonth();
            } catch (\Throwable $e) {
                $selectedPayrollMonth = null;
            }
        }

        if (! $selectedPayrollMonth && $payrollMonthOptions->isNotEmpty()) {
            $selectedPayrollMonth = $payrollMonthOptions->first()->copy();
        }

        if ($selectedPayrollMonth) {
            $selectedPayrollMonthLabel = $selectedPayrollMonth->format('F Y');

            $payrollRecords = (clone $payrollBaseQuery)
                ->whereBetween('payroll_month', [
                    $selectedPayrollMonth->copy()->startOfMonth()->toDateString(),
                    $selectedPayrollMonth->copy()->endOfMonth()->toDateString(),
                ])
                ->orderByDesc('payroll_month')
                ->get();
        } else {
            $payrollRecords = (clone $payrollBaseQuery)
                ->orderByDesc('payroll_month')
                ->get();

            if ($latestPayroll) {
                $selectedPayrollMonthLabel = Carbon::parse($latestPayroll->payroll_month)->format('F Y');
            }
        }

        $totalPayslips = $payrollRecords->count();
        $totalNetPay = $payrollRecords->sum('net_pay');
        $processedPayslips = $payrollRecords->where('status', 'processed')->count();
        $pendingPayslips = $payrollRecords->where('status', 'pending')->count();

        return view('user.dashboard', [
            'employee' => $employee,
            'totalLeaveDays' => $totalLeaveDays,
            'usedLeaveDays' => $usedLeaveDays,
            'pendingRequestsCount' => $pendingRequestsCount,
            'approvedRequestsCount' => $approvedRequestsCount,
            'calendarMonthLabel' => $calendarDate->format('F Y'),
            'calendarDays' => $calendarDays,
            'recentAttendance' => $recentAttendance,
            'leaveRequests' => $leaveRequests,
            'recentNotifications' => $recentNotifications,
            'unreadNotificationCount' => $unreadNotificationCount,
            'prevMonthUrl' => route('dashboard', [
                'tab' => 'attendance',
                'month' => $prevDate->month,
                'year' => $prevDate->year,
            ]),
            'nextMonthUrl' => route('dashboard', [
                'tab' => 'attendance',
                'month' => $nextDate->month,
                'year' => $nextDate->year,
            ]),
            'payrollMonthOptions' => $payrollMonthOptions,
            'selectedPayrollMonthValue' => $selectedPayrollMonth ? $selectedPayrollMonth->format('Y-m') : null,
            'selectedPayrollMonthLabel' => $selectedPayrollMonthLabel,
            'payrollRecords' => $payrollRecords,
            'latestPayroll' => $latestPayroll,
            'totalPayslips' => $totalPayslips,
            'totalNetPay' => $totalNetPay,
            'processedPayslips' => $processedPayslips,
            'pendingPayslips' => $pendingPayslips,
        ]);
    }

    public function storeLeaveRequest(Request $request)
    {
        $request->validate([
            'leave_type' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
        ]);

        $employee = $this->getAuthenticatedEmployee();

        if (! $employee) {
            return redirect()
                ->route('dashboard', ['tab' => 'attendance'])
                ->withInput(['show_leave_modal' => 1])
                ->withErrors([
                    'employee' => 'Employee record not linked with this user. Please set employees.user_id = logged in user id.',
                ]);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) + 1;

        $hasOverlap = LeaveRequest::where('employee_id', $employee->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate->toDateString(), $endDate->toDateString()])
                    ->orWhereBetween('end_date', [$startDate->toDateString(), $endDate->toDateString()])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate->toDateString())
                            ->where('end_date', '>=', $endDate->toDateString());
                    });
            })
            ->exists();

        if ($hasOverlap) {
            return redirect()
                ->route('dashboard', ['tab' => 'attendance'])
                ->withInput(['show_leave_modal' => 1])
                ->withErrors([
                    'leave_type' => 'You already have a pending or approved leave request within this date range.',
                ]);
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => $request->leave_type,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'days' => $days,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        return redirect()
            ->route('dashboard', ['tab' => 'attendance'])
            ->with('success', 'Leave request submitted successfully.');
    }

    public function downloadPayslipPdf(Payroll $payroll)
    {
        $employee = $this->getAuthenticatedEmployee();
        abort_unless($employee && $payroll->employee_id === $employee->id, 403);

        $payroll->load('employee');

        $pdf = Pdf::loadView('user.payroll.pdf.single', [
            'payroll' => $payroll,
            'employee' => $payroll->employee,
            'user' => auth()->user(),
        ])->setPaper('a4', 'portrait');

        $fileName = 'payslip-' . auth()->user()->employeeID . '-' . Carbon::parse($payroll->payroll_month)->format('Y-m') . '.pdf';

        return $pdf->download($fileName);
    }

    public function exportPayrollReport(Request $request)
    {
        $employee = $this->getAuthenticatedEmployee();
        abort_unless($employee, 403);

        $requestedPayrollMonth = $request->get('payroll_month');
        $monthDate = $requestedPayrollMonth
            ? Carbon::createFromFormat('Y-m', $requestedPayrollMonth)->startOfMonth()
            : now()->startOfMonth();

        $records = Payroll::with('employee')
            ->where('employee_id', $employee->id)
            ->whereBetween('payroll_month', [
                $monthDate->copy()->startOfMonth()->toDateString(),
                $monthDate->copy()->endOfMonth()->toDateString(),
            ])
            ->orderByDesc('payroll_month')
            ->get();

        abort_if($records->isEmpty(), 404, 'No payroll records found for the selected month.');

        $pdf = Pdf::loadView('user.payroll.pdf.report', [
            'records' => $records,
            'employee' => $employee,
            'user' => auth()->user(),
            'monthDate' => $monthDate,
            'totalNetPay' => $records->sum('net_pay'),
            'totalAllowance' => $records->sum('allowance'),
            'totalDeduction' => $records->sum('deduction'),
            'totalTax' => $records->sum('tax'),
        ])->setPaper('a4', 'portrait');

        $fileName = 'payroll-report-' . auth()->user()->employeeID . '-' . $monthDate->format('Y-m') . '.pdf';

        return $pdf->download($fileName);
    }

    private function getAuthenticatedEmployee()
    {
        $user = auth()->user();

        if (! $user) {
            return null;
        }

        return Employee::where('user_id', $user->id)->first();
    }
}