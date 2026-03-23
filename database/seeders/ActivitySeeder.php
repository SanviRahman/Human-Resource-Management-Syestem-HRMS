<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'title' => 'New employee onboarded',
                'description' => 'Sarah Johnson',
                'type' => 'success',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'title' => 'Leave request approved',
                'description' => 'Mike Chen',
                'type' => 'info',
                'created_at' => now()->subHours(4),
                'updated_at' => now()->subHours(4),
            ],
            [
                'title' => 'Payroll processed',
                'description' => 'System',
                'type' => 'success',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'title' => 'Performance review submitted',
                'description' => 'Alex Rivera',
                'type' => 'warning',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'title' => 'New job posting created',
                'description' => 'HR Team',
                'type' => 'info',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}