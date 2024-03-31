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
            'level' => 'required',
            'category' => 'required',
            'date' => 'required'
        ]);

        $request->instructor_id = auth()->user()->id;
        //jika image tidak ada, maka berikan nilai "tidak ada"
        if (!$request->hasFile('image')) {
            $request->image = 'tidak ada';
        }else{
            //validate image
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            //jika tidak valid
            if ($request->fails()) {
                return response()->json([
                    //message image not valid
                    'message' => 'Image not valid'
                ], 400);
            }

            //jika valid
            $image = $request->file('image');
            $image->move('course_images', $image->getClientOriginalName());
            $request->image = $image->getClientOriginalName();

        }
        //$request->image is an image. upload it to public/course_images
        

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

    //show
    public function show($id)
    {
        //find course, join instructor_id dengan id pada users
        $course = course::join('users', 'courses.instructor_id', '=', 'users.id')
            ->select('courses.*', 'users.name as instructor')
            ->where('courses.id', $id)
            ->first();
        //if not found
        if (!$course) {
            return response()->json([
                //message course not found
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            //message course found
            'message' => 'Course found',
            'data' => $course
        ]);
    }

    //index
    public function index(Request $request)
    {
        //ambil row dan page
        $row = $request->row ?? 10;
        $page = $request->page ?? 1;
        //jika ada query search
        if ($request->search) {
            //get all courses, join instructor_id dengan id pada users, where name like search
            $courses = course::join('users', 'courses.instructor_id', '=', 'users.id')
                ->select('courses.*', 'users.name as instructor')
                ->where('courses.name', 'like', '%'.$request->search.'%')
                //paginate dengan row dan page
                ->paginate($row, ['*'], 'page', $page);
            return response()->json([
                //message courses found
                'message' => 'Courses found',
                'data' => $courses
            ]);
        }
        //get all courses, join instructor_id dengan id pada users
        $courses = course::join('users', 'courses.instructor_id', '=', 'users.id')
            ->select('courses.*', 'users.name as instructor')
            ->paginate($row, ['*'], 'page', $page);

        return response()->json([
            //message courses found
            'message' => 'Courses found',
            'data' => $courses
        ]);
    }

    //update
    public function update(Request $request, $id)
    {
        //find course
        $course = course::find($id);
        //if not found
        if (!$course) {
            return response()->json([
                //message course not found
                'message' => 'Course not found'
            ], 404);
        }

        //validate
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'level' => 'required',
            'category' => 'required',
            'date' => 'required'
        ]);

        //jika image tidak ada, maka berikan nilai "tidak ada"
        if (!$request->hasFile('image')) {
            $request->image = 'tidak ada';
        }else{
            //validate image
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            //jika tidak valid
            if ($request->fails()) {
                return response()->json([
                    //message image not valid
                    'message' => 'Image not valid'
                ], 400);
            }

            //jika valid
            $image = $request->file('image');
            $image->move('course_images', $image->getClientOriginalName());
            $request->image = $image->getClientOriginalName();

        }
        //$request->image is an image. upload it to public/course_images

        //update course
        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'level' => $request->level,
            'category' => $request->category,
            'date' => $request->date,
            'status' => $request->status    
        ]);

        return response()->json([
            //message course updated successfully
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    //destroy
    public function destroy($id)
    {
        //find course
        $course = course::find($id);
        //if not found
        if (!$course) {
            return response()->json([
                //message course not found
                'message' => 'Course not found'
            ], 404);
        }

        //delete course
        $course->delete();

        return response()->json([
            //message course deleted successfully
            'message' => 'Course deleted successfully'
        ]);
    }
}
