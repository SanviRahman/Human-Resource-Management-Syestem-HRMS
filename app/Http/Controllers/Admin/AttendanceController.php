<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'attendance_date' => [
                'required',
                'date',
                Rule::unique('attendances', 'attendance_date')->where(function ($query) use ($request) {
                    return $query->where('employee_id', $request->employee_id);
                }),
            ],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'status' => ['required', Rule::in(['present', 'late', 'half_day', 'absent', 'leave'])],
        ]);

        $validated['work_hours'] = $this->calculateWorkHours(
            $validated['check_in'] ?? null,
            $validated['check_out'] ?? null
        );

        Attendance::create($validated);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Attendance record created successfully.');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'attendance_date' => [
                'required',
                'date',
                Rule::unique('attendances', 'attendance_date')
                    ->ignore($attendance->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('employee_id', $request->employee_id);
                    }),
            ],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'status' => ['required', Rule::in(['present', 'late', 'half_day', 'absent', 'leave'])],
        ]);

        $validated['work_hours'] = $this->calculateWorkHours(
            $validated['check_in'] ?? null,
            $validated['check_out'] ?? null
        );

        $attendance->update($validated);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Attendance record deleted successfully.');
    }

    private function calculateWorkHours(?string $checkIn, ?string $checkOut): float
    {
        if (!$checkIn || !$checkOut) {
            return 0;
        }

        $in = Carbon::createFromFormat('H:i', $checkIn);
        $out = Carbon::createFromFormat('H:i', $checkOut);

        if ($out->lessThanOrEqualTo($in)) {
            return 0;
        }

        return round($in->diffInMinutes($out) / 60, 2);
    }
}