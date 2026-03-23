<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Team Meeting',
                'subtitle' => 'Engineering Department',
                'event_date' => now()->addDay()->setTime(14, 0),
                'type' => 'info',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Performance Review Deadline',
                'subtitle' => 'Q1 2024 Reviews',
                'event_date' => now()->addDays(3)->setTime(17, 0),
                'type' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Payroll Processing',
                'subtitle' => 'Monthly salary disbursement',
                'event_date' => now()->addDays(7)->setTime(10, 0),
                'type' => 'warning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}