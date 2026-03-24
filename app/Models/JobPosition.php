<?php

namespace App\Models;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $fillable = [
        'title',
        'department',
        'description',
        'status',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}