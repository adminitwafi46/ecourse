<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model course
use App\Models\course;

class courseController extends Controller
{
    //store
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
            'level' => 'required',
            'category' => 'required',
            'date' => 'required'
        ]);

        $request->instructor_id = auth()->user()->id;

        //create course
        $course = course::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'instructor_id' => auth()->user()->id,
            'image' => $request->image,
            'level' => $request->level,
            'category' => $request->category,
            'date' => $request->date
        
        ]);

        return response()->json([
            //message course created successfully
            'message' => 'Course created successfully',
            'data' => $course
        ]);
    }
}
