<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_position_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'status',
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}