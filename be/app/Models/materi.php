<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materi extends Model
{
    use HasFactory;
    //fillable 
    protected $fillable = [
        'bab_id',
        'name',
        'description',
        'jenis', //jenis
        'isi',
        'status'
    ];
}
