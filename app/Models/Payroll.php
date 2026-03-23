<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'payroll_month',
        'basic_salary',
        'allowance',
        'deduction',
        'tax',
        'net_pay',
        'status',
    ];

    protected $casts = [
        'payroll_month' => 'date',
    ];
}