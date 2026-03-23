<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'event_date',
        'type',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];
}