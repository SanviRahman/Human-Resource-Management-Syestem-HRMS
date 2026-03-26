<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceGoal extends Model
{
    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}