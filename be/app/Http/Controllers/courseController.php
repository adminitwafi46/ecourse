<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model course
use App\Models\course;
//model bab
use App\Models\bab;
//fasad db
use Illuminate\Support\Facades\DB;

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

        //ambil babs dari course dengan  course_id = id
        $babs = bab::where('course_id', $id)->get();

        return response()->json([
            //message course found
            'message' => 'Course found',
            'data' => $course,
            'babs' => $babs
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

    //my_courses
    public function my_courses()
    {
        //get all courses dari tabel assign_course where user_id == auth()->user()->id dan dijoin dengan courses dengan assign_course.course_id 
        $courses = DB::table('assign_course')
            ->join('courses', 'assign_course.course_id', '=', 'courses.id')
            //joind instructor_id dengan id pada users
            ->join('users', 'courses.instructor_id', '=', 'users.id')
            ->where('assign_course.user_id', auth()->user()->id)
            ->select('courses.*', 'users.name as instructor')
            ->get(); 

        return response()->json([
            //message courses found
            'message' => 'Courses found',
            'data' => $courses
        ]);
    }

    public function learn_now($id){
        //cek apakah user terdaftar di course (cek di table assign_course)
        $assign_course = DB::table('assign_course')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $id)
            ->first();

        //jika tidak terdaftar
        if (!$assign_course) {
            return response()->json([
                //message user not registered in this course
                'message' => 'User not registered in this course'
            ], 400);
        }

        //deskripsi kursus
        $course = course::find($id);
        //materi pertama diambil dengan alur ambil bab pertama dengan first() dan ambil materi dengan materi pertama dengan first()
        $materi = bab::where('course_id', $id)->first();
        $materi->materi = DB::table('materis')
            ->where('bab_id', $materi->id)
            ->first();


        //ambil babs dari course dengan  course_id = id, di setiap bab ambil materi yang bab_id = babs.id . 
        $babs = bab::where('course_id', $id)->get();
        foreach ($babs as $bab) {
            $bab->materi = DB::table('materis')
                ->where('bab_id', $bab->id)
                ->get();
        }

        return response()->json([
            //message course found
            'message' => 'Course found',
            'babs' => $babs,
            'course' => $course,
            'materi' => $materi,
        ]);
    }

    public function dataCourse($id)
    {
        //ambil 1 materi berdasarkan id dr tabel materis 
        $materi = DB::table('materis')
            ->where('id', $id)
            ->first();

        //pada bab id, cek di tabel bab
        $bab = bab::find($materi->bab_id);

        //cek apakah user terdaftar di course (cek di table assign_course)
        $assign_course = DB::table('assign_course')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $bab->course_id)
            ->first();

            //jika tidak terdaftar
        if (!$assign_course) {
            return response()->json([
                //message user not registered in this course
                'message' => 'User not registered in this course'
            ], 400);
        }

        return response()->json([
            //message materi found
            'message' => 'Materi found',
            'materi' => $materi,
            'bab' => $bab
        ]);
    }
    
}
