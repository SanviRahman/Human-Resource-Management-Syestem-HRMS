<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'leave_type' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
        ]);

        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);

        $validated['days'] = $start->diffInDays($end) + 1;
        $validated['status'] = 'pending';

        LeaveRequest::create($validated);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Leave request created successfully.');
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $leaveRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Leave request updated successfully.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();

        return redirect()
            ->route('admin.dashboard', ['tab' => 'attendance'])
            ->with('success', 'Leave request deleted successfully.');
    }
}