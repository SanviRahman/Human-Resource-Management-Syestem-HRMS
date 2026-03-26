<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerformanceGoal;

class PerformanceGoalSeeder extends Seeder
{
    public function run(): void
    {
        $goals = [
            [
                'employee_id' => 1,
                'title' => 'Complete frontend dashboard',
                'description' => 'Deliver complete HRMS dashboard UI',
                'status' => 'completed',
                'due_date' => '2026-03-15',
            ],
            [
                'employee_id' => 2,
                'title' => 'Launch marketing campaign',
                'description' => 'Run Q1 campaign successfully',
                'status' => 'completed',
                'due_date' => '2026-03-18',
            ],
            [
                'employee_id' => 3,
                'title' => 'Increase monthly sales',
                'description' => 'Reach sales target for the quarter',
                'status' => 'pending',
                'due_date' => '2026-03-30',
            ],
        ];

        foreach ($goals as $goal) {
            PerformanceGoal::updateOrCreate(
                [
                    'employee_id' => $goal['employee_id'],
                    'title' => $goal['title'],
                ],
                $goal
            );
        }
    }
}