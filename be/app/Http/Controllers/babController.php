<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model bab
use App\Models\bab;
//validasi
use Illuminate\Support\Facades\Validator;

class babController extends Controller
{
    //constructor
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //store, validasi name, description, course_id
    public function store(Request $request)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'course_id' => 'required'
        ]);

        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        //create bab
        $bab = bab::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $request->course_id
        ]);

        //response
        return response()->json([
            'message' => 'Bab created',
            'data' => $bab
        ], 200);
    }

    //index, validasi request->course_id
    public function index(Request $request)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'course_id' => 'required'
        ]);

        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        //get bab by course_id
        $bab = bab::where('course_id', $request->course_id)->get();

        //response
        return response()->json([
            'message' => 'Bab by course_id ' . $request->course_id . ' found',
            'data' => $bab
        ], 200);
    }

    //show bab by id
    public function show($id)
    {
        //find bab by id
        $bab = bab::find($id);

        //if not found
        if (!$bab) {
            return response()->json([
                'message' => 'Bab not found'
            ], 404);
        }

        //response
        return response()->json([
            'message' => 'Bab found',
            'data' => $bab
        ], 200);
    }

    //update bab by id
    public function update(Request $request, $id)
    {
        //find bab by id
        $bab = bab::find($id);

        //if not found
        if (!$bab) {
            return response()->json([
                'message' => 'Bab not found'
            ], 404);
        }

        //update bab
        $bab->name = $request->name;
        $bab->description = $request->description;
        $bab->save();

        //response
        return response()->json([
            'message' => 'Bab updated',
            'data' => $bab
        ], 200);
    }

    //destroy bab by id
    public function destroy($id)
    {
        //find bab by id
        $bab = bab::find($id);

        //if not found
        if (!$bab) {
            return response()->json([
                'message' => 'Bab not found'
            ], 404);
        }

        //delete bab
        $bab->delete();

        //response
        return response()->json([
            'message' => 'Bab deleted'
        ], 200);
    }
}
