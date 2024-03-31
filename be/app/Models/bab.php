<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bab extends Model
{
    use HasFactory;
    //fillable 
    protected $fillable = [
        'course_id',
        'name',
        'description'
    ];
}
