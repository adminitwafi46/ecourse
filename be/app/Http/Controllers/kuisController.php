<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//model kuis
use App\Models\kuis;
//model jawaban
use App\Models\jawaban;

class kuisController extends Controller
{
    //index kuis by materi_id
    public function index($materi_id)
    {
        //get kuis by materi_id
        $kuis = kuis::where('materi_id', $materi_id)->get();

        //response
        return response()->json([
            'message' => 'List kuis',
            'data' => $kuis
        ], 200);
    }

    //store kuis
    public function store(Request $request)
    {
        //validate
        $request->validate([
            'materi_id' => 'required',
            'question' => 'required'
        ]);

        //create kuis
        $kuis = kuis::create([
            'materi_id' => $request->materi_id,
            'question' => $request->question
        ]);

        //response
        return response()->json([
            'message' => 'Kuis created',
            'data' => $kuis
        ], 200);
    }

    //show kuis by id
    public function show($id)
    {
        //get kuis by id
        $kuis = kuis::find($id);

        //response
        return response()->json([
            'message' => 'Detail kuis',
            'data' => $kuis
        ], 200);
    }

    //update kuis by id
    public function update(Request $request, $id)
    {
        //get kuis by id
        $kuis = kuis::find($id);

        //jika kuis tidak ditemukan
        if (!$kuis) {
            //response
            return response()->json([
                'message' => 'Kuis not found'
            ], 404);
        }

        //update kuis
        $kuis->update([
            'question' => $request->question
        ]);

        //response
        return response()->json([
            'message' => 'Kuis updated',
            'data' => $kuis
        ], 200);
    }

    //delete kuis by id, hapus kuis dan jawaban
    public function destroy($id)
    {
        //get kuis by id
        $kuis = kuis::find($id);

        //jika kuis tidak ditemukan
        if (!$kuis) {
            //response
            return response()->json([
                'message' => 'Kuis not found'
            ], 404);
        }

        //get jawaban by kuis_id
        $jawaban = jawaban::where('kuis_id', $kuis->id)->get();

        //hapus jawaban
        foreach ($jawaban as $jawaban) {
            $jawaban->delete();
        }

        //hapus kuis
        $kuis->delete();

        //response
        return response()->json([
            'message' => 'Kuis deleted'
        ], 200);
    }
}
