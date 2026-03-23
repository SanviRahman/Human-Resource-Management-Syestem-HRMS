<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@company.com',
                'department' => 'Engineering',
                'designation' => 'Senior Developer',
                'status' => 'active',
                'joining_date' => '2022-03-15',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@company.com',
                'department' => 'Marketing',
                'designation' => 'Marketing Manager',
                'status' => 'active',
                'joining_date' => '2021-11-22',
            ],
            [
                'name' => 'Mike Chen',
                'email' => 'mike.chen@company.com',
                'department' => 'Sales',
                'designation' => 'Sales Representative',
                'status' => 'probation',
                'joining_date' => '2023-01-10',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@company.com',
                'department' => 'HR',
                'designation' => 'HR Specialist',
                'status' => 'active',
                'joining_date' => '2020-08-05',
            ],
            [
                'name' => 'Alex Rivera',
                'email' => 'alex.rivera@company.com',
                'department' => 'Finance',
                'designation' => 'Financial Analyst',
                'status' => 'inactive',
                'joining_date' => '2022-06-18',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}