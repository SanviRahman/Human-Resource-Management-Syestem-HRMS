<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payroll;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        $payrolls = [
            [
                'employee_id' => 1,
                'payroll_month' => '2026-03-01',
                'basic_salary' => 8000,
                'allowance' => 2000,
                'deduction' => 800,
                'tax' => 1200,
                'net_pay' => 8000,
                'status' => 'processed',
            ],
            [
                'employee_id' => 2,
                'payroll_month' => '2026-03-01',
                'basic_salary' => 6500,
                'allowance' => 1500,
                'deduction' => 650,
                'tax' => 950,
                'net_pay' => 6400,
                'status' => 'processed',
            ],
            [
                'employee_id' => 3,
                'payroll_month' => '2026-03-01',
                'basic_salary' => 5500,
                'allowance' => 1200,
                'deduction' => 550,
                'tax' => 800,
                'net_pay' => 5350,
                'status' => 'pending',
            ],
            [
                'employee_id' => 4,
                'payroll_month' => '2026-03-01',
                'basic_salary' => 6000,
                'allowance' => 1400,
                'deduction' => 600,
                'tax' => 900,
                'net_pay' => 5900,
                'status' => 'approved',
            ],
        ];

        foreach ($payrolls as $payroll) {
            Payroll::create($payroll);
        }
    }
}