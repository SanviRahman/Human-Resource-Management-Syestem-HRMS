<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Leave Request Approval',
                'message' => "Sarah Johnson's vacation request has been approved",
                'type' => 'info',
                'is_read' => false,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'title' => 'New Employee Onboarding',
                'message' => 'Alex Rivera has completed onboarding process',
                'type' => 'success',
                'is_read' => false,
                'created_at' => now()->subHours(4),
                'updated_at' => now()->subHours(4),
            ],
            [
                'title' => 'Performance Review Reminder',
                'message' => 'Q1 performance reviews are due in 3 days',
                'type' => 'warning',
                'is_read' => false,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::updateOrCreate(
                [
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                ],
                $notification
            );
        }
    }
}