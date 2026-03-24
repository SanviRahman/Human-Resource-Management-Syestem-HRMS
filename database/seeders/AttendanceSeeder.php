<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'employee_id' => 1,
                'attendance_date' => '2026-03-20',
                'check_in' => '09:00',
                'check_out' => '17:30',
                'work_hours' => 8.5,
                'status' => 'present',
            ],
            [
                'employee_id' => 2,
                'attendance_date' => '2026-03-21',
                'check_in' => '09:15',
                'check_out' => '17:45',
                'work_hours' => 8.5,
                'status' => 'late',
            ],
            [
                'employee_id' => 3,
                'attendance_date' => '2026-03-22',
                'check_in' => '09:00',
                'check_out' => '13:00',
                'work_hours' => 4.0,
                'status' => 'half_day',
            ],
            [
                'employee_id' => 4,
                'attendance_date' => '2026-03-23',
                'check_in' => null,
                'check_out' => null,
                'work_hours' => 0,
                'status' => 'absent',
            ],
            [
                'employee_id' => 5,
                'attendance_date' => '2026-03-24',
                'check_in' => '08:45',
                'check_out' => '17:15',
                'work_hours' => 8.5,
                'status' => 'present',
            ],
        ];

        foreach ($records as $record) {
            Attendance::updateOrCreate(
                [
                    'employee_id' => $record['employee_id'],
                    'attendance_date' => $record['attendance_date'],
                ],
                $record
            );
        }
    }
}