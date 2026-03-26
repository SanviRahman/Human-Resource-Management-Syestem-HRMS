<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerformanceReview;

class PerformanceReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'employee_id' => 1,
                'review_period' => 'Q1 2026 Review',
                'score' => 4.5,
                'status' => 'completed',
                'remarks' => 'Excellent performance',
                'review_date' => '2026-03-10',
            ],
            [
                'employee_id' => 2,
                'review_period' => 'Q1 2026 Review',
                'score' => 4.2,
                'status' => 'completed',
                'remarks' => 'Strong communication and execution',
                'review_date' => '2026-03-11',
            ],
            [
                'employee_id' => 3,
                'review_period' => 'Q1 2026 Review',
                'score' => 3.9,
                'status' => 'completed',
                'remarks' => 'Good performance overall',
                'review_date' => '2026-03-12',
            ],
        ];

        foreach ($reviews as $review) {
            PerformanceReview::updateOrCreate(
                [
                    'employee_id' => $review['employee_id'],
                    'review_period' => $review['review_period'],
                ],
                $review
            );
        }
    }
}