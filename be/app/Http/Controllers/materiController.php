<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materi;
use Illuminate\Support\Facades\Validator;

class materiController extends Controller
{
    //constructor
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //store, validasi bab_id, name, jenis
    public function store(Request $request)
    {
        //if jenis is text, maka save, tanpa else
        if ($request->jenis == 'text') {
            //save
            $materi = materi::create([
                'bab_id' => $request->bab_id,
                'name' => $request->name,
                'description' => $request->description,
                'jenis' => 'text',
                'isi' => $request->text,
                'status' => "unpublished"
            ]);

            //response
            return response()->json([
                'message' => 'Materi created',
                'data' => $materi
            ], 200);
        }

        //if jenis is video, maka save, tanpa else
        if ($request->jenis == 'video') {
            //simpan nama file video dengan timestamp dan simpan ke folder public/materi_video, nama file disimpan ke variabel $nama_file
            $nama_file = time()."_".$request->video->getClientOriginalName();
            $request->video->move('materi_video', $nama_file);

            //save
            $materi = materi::create([
                'bab_id' => $request->bab_id,
                'name' => $request->name,
                'description' => $request->description,
                'jenis' => 'video',
                'isi' => $nama_file,
                'status' => "unpublished"
            ]);

            //response
            return response()->json([
                'message' => 'Materi created',
                'data' => $materi
            ], 200);
        }
        
    }

}
