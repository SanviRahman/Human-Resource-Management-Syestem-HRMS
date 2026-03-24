<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;
use App\Models\JobPosition;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $frontend = JobPosition::where('title', 'Senior Frontend Developer')->first();
        $marketing = JobPosition::where('title', 'Marketing Specialist')->first();

        if ($frontend) {
            JobApplication::updateOrCreate(
                [
                    'job_position_id' => $frontend->id,
                    'candidate_name' => 'Sarah Wilson',
                ],
                [
                    'candidate_email' => 'sarah@example.com',
                    'candidate_phone' => '01700000001',
                    'status' => 'applied',
                ]
            );
        }

        if ($marketing) {
            JobApplication::updateOrCreate(
                [
                    'job_position_id' => $marketing->id,
                    'candidate_name' => 'David Chen',
                ],
                [
                    'candidate_email' => 'david@example.com',
                    'candidate_phone' => '01700000002',
                    'status' => 'applied',
                ]
            );
        }
    }
}