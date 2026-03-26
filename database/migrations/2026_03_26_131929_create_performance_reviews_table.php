<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('review_period')->nullable(); // e.g. Q1 2026 Review
            $table->decimal('score', 3, 1)->default(0); // e.g. 4.2
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->text('remarks')->nullable();
            $table->date('review_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};