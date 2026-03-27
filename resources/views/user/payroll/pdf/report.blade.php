<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payroll Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .header { margin-bottom: 20px; }
        .title { font-size: 22px; font-weight: bold; }
        .subtitle { color: #6b7280; margin-top: 4px; }
        .meta { margin-top: 14px; margin-bottom: 18px; }
        .meta div { margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .totals { margin-top: 18px; }
        .totals div { margin-bottom: 6px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Payroll Report</div>
        <div class="subtitle">{{ $monthDate->format('F Y') }}</div>
    </div>

    <div class="meta">
        <div><strong>Employee:</strong> {{ $employee->name ?? 'N/A' }}</div>
        <div><strong>Employee ID:</strong> {{ $user->employeeID ?? 'N/A' }}</div>
        <div><strong>Department:</strong> {{ $employee->department ?? '-' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Payroll Month</th>
                <th>Basic Salary</th>
                <th>Allowance</th>
                <th>Deduction</th>
                <th>Tax</th>
                <th>Net Pay</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->payroll_month)->format('F Y') }}</td>
                    <td>${{ number_format($record->basic_salary, 2) }}</td>
                    <td>${{ number_format($record->allowance, 2) }}</td>
                    <td>${{ number_format($record->deduction, 2) }}</td>
                    <td>${{ number_format($record->tax, 2) }}</td>
                    <td>${{ number_format($record->net_pay, 2) }}</td>
                    <td>{{ ucfirst($record->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div>Total Allowance: ${{ number_format($totalAllowance, 2) }}</div>
        <div>Total Deduction: ${{ number_format($totalDeduction, 2) }}</div>
        <div>Total Tax: ${{ number_format($totalTax, 2) }}</div>
        <div>Total Net Pay: ${{ number_format($totalNetPay, 2) }}</div>
    </div>
</body>
</html>