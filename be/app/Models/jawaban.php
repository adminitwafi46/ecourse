<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'kuis_id',
        'answer',
        'salah_benar'
    ];
}
