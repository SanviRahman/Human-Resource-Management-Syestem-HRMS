<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'department',
        'designation',
        'status',
        'joining_date',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];
}