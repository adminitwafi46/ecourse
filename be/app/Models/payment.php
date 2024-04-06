<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'user_id',
        'course_id',
        'invoice',
        'status',
        'price',
        'payment_url',
        'payment_at'
    ];
}
