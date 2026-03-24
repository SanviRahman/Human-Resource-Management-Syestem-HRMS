<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interview;
use App\Models\JobApplication;

class InterviewSeeder extends Seeder
{
    public function run(): void
    {
        $sarah = JobApplication::where('candidate_name', 'Sarah Wilson')->first();
        $david = JobApplication::where('candidate_name', 'David Chen')->first();

        if ($sarah) {
            Interview::updateOrCreate(
                [
                    'job_application_id' => $sarah->id,
                    'title' => 'Technical Interview',
                ],
                [
                    'interview_type' => 'Technical',
                    'scheduled_at' => now()->addDay()->setTime(14, 0),
                    'status' => 'scheduled',
                    'notes' => 'Frontend technical round',
                ]
            );
        }

        if ($david) {
            Interview::updateOrCreate(
                [
                    'job_application_id' => $david->id,
                    'title' => 'Final Round',
                ],
                [
                    'interview_type' => 'Final',
                    'scheduled_at' => now()->addDays(3)->setTime(10, 0),
                    'status' => 'scheduled',
                    'notes' => 'Final marketing round',
                ]
            );
        }
    }
}