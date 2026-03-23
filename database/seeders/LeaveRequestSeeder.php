<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveRequest;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $leaveRequests = [
            [
                'employee_id' => 1,
                'leave_type' => 'Vacation',
                'start_date' => '2024-02-15',
                'end_date' => '2024-02-19',
                'days' => 5,
                'status' => 'pending',
                'reason' => 'Family trip',
            ],
            [
                'employee_id' => 2,
                'leave_type' => 'Sick',
                'start_date' => '2024-02-10',
                'end_date' => '2024-02-12',
                'days' => 3,
                'status' => 'approved',
                'reason' => 'Medical leave',
            ],
            [
                'employee_id' => 3,
                'leave_type' => 'Personal',
                'start_date' => '2024-02-20',
                'end_date' => '2024-02-20',
                'days' => 1,
                'status' => 'rejected',
                'reason' => 'Personal work',
            ],
        ];

        foreach ($leaveRequests as $leaveRequest) {
            LeaveRequest::create($leaveRequest);
        }
    }
}