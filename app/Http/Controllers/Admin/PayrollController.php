<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PayrollController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'payroll_month' => ['required', 'date'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowance' => ['nullable', 'numeric', 'min:0'],
            'deduction' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'processed', 'approved'])],
        ]);

        $validated['allowance'] = $validated['allowance'] ?? 0;
        $validated['deduction'] = $validated['deduction'] ?? 0;
        $validated['tax'] = $validated['tax'] ?? 0;
        $validated['net_pay'] = ($validated['basic_salary'] + $validated['allowance']) - ($validated['deduction'] + $validated['tax']);

        Payroll::create($validated);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'payroll', 'payroll_month' => \Carbon\Carbon::parse($validated['payroll_month'])->format('Y-m')])
            ->with('success', 'Payroll record created successfully.');
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'payroll_month' => ['required', 'date'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowance' => ['nullable', 'numeric', 'min:0'],
            'deduction' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'processed', 'approved'])],
        ]);

        $validated['allowance'] = $validated['allowance'] ?? 0;
        $validated['deduction'] = $validated['deduction'] ?? 0;
        $validated['tax'] = $validated['tax'] ?? 0;
        $validated['net_pay'] = ($validated['basic_salary'] + $validated['allowance']) - ($validated['deduction'] + $validated['tax']);

        $payroll->update($validated);

        return redirect()
            ->route('admin.dashboard', ['tab' => 'payroll', 'payroll_month' => \Carbon\Carbon::parse($validated['payroll_month'])->format('Y-m')])
            ->with('success', 'Payroll record updated successfully.');
    }

    public function destroy(Payroll $payroll)
    {
        $month = $payroll->payroll_month ? $payroll->payroll_month->format('Y-m') : now()->format('Y-m');

        $payroll->delete();

        return redirect()
            ->route('admin.dashboard', ['tab' => 'payroll', 'payroll_month' => $month])
            ->with('success', 'Payroll record deleted successfully.');
    }
}