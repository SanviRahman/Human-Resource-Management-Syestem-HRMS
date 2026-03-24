<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'job_application_id',
        'title',
        'interview_type',
        'scheduled_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}