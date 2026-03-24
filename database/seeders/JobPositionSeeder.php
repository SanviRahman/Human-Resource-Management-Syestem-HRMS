<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosition;

class JobPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            [
                'title' => 'Senior Frontend Developer',
                'department' => 'Engineering',
                'description' => 'Frontend development role',
                'status' => 'active',
            ],
            [
                'title' => 'Marketing Specialist',
                'department' => 'Marketing',
                'description' => 'Marketing team role',
                'status' => 'active',
            ],
        ];

        foreach ($positions as $position) {
            JobPosition::updateOrCreate(
                ['title' => $position['title']],
                $position
            );
        }
    }
}