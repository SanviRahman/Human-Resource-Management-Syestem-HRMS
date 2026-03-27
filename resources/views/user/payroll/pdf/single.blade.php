<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payslip</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #111827; }
        .header { margin-bottom: 24px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 6px; }
        .subtitle { color: #6b7280; }
        .card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; margin-bottom: 18px; }
        .row { width: 100%; margin-bottom: 8px; }
        .label { color: #6b7280; width: 35%; display: inline-block; }
        .value { width: 60%; display: inline-block; font-weight: bold; }
        .summary-table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .summary-table th, .summary-table td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        .summary-table th { background: #f3f4f6; }
        .net-pay { font-size: 18px; font-weight: bold; color: #111827; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Payslip</div>
        <div class="subtitle">Payroll Month: {{ \Carbon\Carbon::parse($payroll->payroll_month)->format('F Y') }}</div>
    </div>

    <div class="card">
        <div class="row">
            <span class="label">Employee Name</span>
            <span class="value">{{ $employee->name ?? 'N/A' }}</span>
        </div>
        <div class="row">
            <span class="label">Employee ID</span>
            <span class="value">{{ $user->employeeID ?? 'N/A' }}</span>
        </div>
        <div class="row">
            <span class="label">Department</span>
            <span class="value">{{ $employee->department ?? '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Designation</span>
            <span class="value">{{ $employee->designation ?? '-' }}</span>
        </div>
        <div class="row">
            <span class="label">Status</span>
            <span class="value">{{ ucfirst($payroll->status) }}</span>
        </div>
    </div>

    <table class="summary-table">
        <thead>
            <tr>
                <th>Component</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td>${{ number_format($payroll->basic_salary, 2) }}</td>
            </tr>
            <tr>
                <td>Allowance</td>
                <td>${{ number_format($payroll->allowance, 2) }}</td>
            </tr>
            <tr>
                <td>Deduction</td>
                <td>${{ number_format($payroll->deduction, 2) }}</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>${{ number_format($payroll->tax, 2) }}</td>
            </tr>
            <tr>
                <td class="net-pay">Net Pay</td>
                <td class="net-pay">${{ number_format($payroll->net_pay, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>