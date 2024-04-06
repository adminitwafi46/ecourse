<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model jawaban
use App\Models\jawaban;

class jawabanController extends Controller
{
    //show list jawaban by kuis_id
    public function index($kuis_id)
    {
        //get jawaban by kuis_id
        $jawaban = jawaban::where('kuis_id', $kuis_id)->get();

        //response
        return response()->json([
            'message' => 'List jawaban',
            'data' => $jawaban
        ], 200);
    }

    //store jawaban, by kuis_id
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'kuis_id' => 'required',
            'answer' => 'required',
        ]);

        //create jawaban
        $jawaban = jawaban::create([
            'kuis_id' => $request->kuis_id,
            'answer' => $request->answer,
            'salah_benar' => 0
        ]);

        //response
        return response()->json([
            'message' => 'Jawaban created',
            'data' => $jawaban
        ], 200);
    }

    //update jawaban, by id, jadi benar / jadi 1
    public function benar($id)
    {
        
        
        //get jawaban by id
        $jawaban1 = jawaban::find($id);
        //get semua jawaban by kuis_id
        $jawaban_all = jawaban::where('kuis_id', $jawaban1->kuis_id)->get();
        //ubah semua $jawaban_all menjadi salah_benar = 0
        foreach ($jawaban_all as $jawaban) {
            $jawaban->update([
                'salah_benar' => 0
            ]);
        }


        //get jawaban by id
        $jawaban1 = jawaban::find($id);
        //update jawaban
        $jawaban1->update([
            'salah_benar' => 1
        ]);

        //response
        return response()->json([
            'message' => 'Jawaban updated',
            'data' => $jawaban1
        ], 200);
    }

    //destroy jawaban, by id
    public function destroy($id)
    {
        //get jawaban by id
        $jawaban = jawaban::find($id);
        //delete jawaban
        $jawaban->delete();

        //response
        return response()->json([
            'message' => 'Jawaban deleted'
        ], 200);
    }
}
