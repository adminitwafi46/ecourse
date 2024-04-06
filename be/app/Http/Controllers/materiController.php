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
         //if jenis is pdf, maka save, tanpa else
        if ($request->jenis == 'pdf') {
            //simpan nama file pdf dengan timestamp dan simpan ke folder public/materi_pdf, nama file disimpan ke variabel $nama_file
            $nama_file = time()."_".$request->pdf->getClientOriginalName();
            $request->pdf->move('materi_pdf', $nama_file);

            //save
            $materi = materi::create([
                'bab_id' => $request->bab_id,
                'name' => $request->name,
                'description' => $request->description,
                'jenis' => 'pdf',
                'isi' => $nama_file,
                'status' => "unpublished"
            ]);

            //response
            return response()->json([
                'message' => 'Materi created',
                'data' => $materi
            ], 200);}

            //if jenis is youtube, maka save, tanpa else
        if ($request->jenis == 'youtube') {
            //ubah url youtube menjadi kode watch yotub, misal https://www.youtube.com/watch?v=fUmZBc4UUDE&pp=ygUfd2VsY29tZSB0byBzdG9jayB2aWRlbyB0ZW1wbGF0ZQ%3D%3D yg diambil adalah fUmZBc4UUDE saja
            $url = explode("=", $request->text);
            $url = $url[1];
            //& dan seterusnya dihilangkan
            $url = explode("&", $url);
            $url = $url[0];


            //save
            $materi = materi::create([
                'bab_id' => $request->bab_id,
                'name' => $request->name,
                'description' => $request->description,
                'jenis' => 'youtube',
                'isi' => $url,
                'status' => "unpublished"
            ]);

            //response
            return response()->json([
                'message' => 'Materi created',
                'data' => $materi
            ], 200);
        }

        if ($request->jenis == 'quiz') {
            //save
            $materi = materi::create([
                'bab_id' => $request->bab_id,
                'name' => $request->name,
                'description' => $request->description,
                'jenis' => 'quiz',
                'isi' => "kuis",
                'status' => "unpublished"
            ]);

            //response
            return response()->json([
                'message' => 'Materi created',
                'data' => $materi
            ], 200);
        }

    }

    //index, validasi bab_id
    public function index($bab_id)
    {
        //ambil materi berdasarkan bab_id
        $materi = materi::where('bab_id', $bab_id)->get();

        //response
        return response()->json([
            'message' => 'List materi',
            'data' => $materi
        ], 200);
    }

    //show, validasi id
    public function show($id)
    {
        //ambil materi berdasarkan id
        $materi = materi::find($id);

        //jika materi tidak ditemukan
        if (!$materi) {
            //response
            return response()->json([
                'message' => 'Materi not found'
            ], 404);
        }

        //response
        return response()->json([
            'message' => 'Materi found',
            'data' => $materi
        ], 200);
    }

    //update dengan parameter id
    public function update(Request $request, $id){
        //ambil data materi
        $materi = materi::find($id);
        //jika jenis materi == text
        if ($materi->jenis == 'text') {
            //update
            $materi->update([
                'name' => request('name'),
                'description' => request('description'),
                'isi' => $request->isi
            ]);
        }

        //jika jenis materi == video, hanya ubah name dan description
        if ($materi->jenis == 'video') {
            //update
            $materi->update([
                'name' => request('name'),
                'description' => request('description')
            ]);
        }

        //jika jenis materi == pdf, hanya ubah name dan description
        if ($materi->jenis == 'pdf') {
            //update
            $materi->update([
                'name' => request('name'),
                'description' => request('description')
            ]);
        }

        //jika jenis materi == youtube
        if ($materi->jenis == 'youtube') {
            //ubah url youtube menjadi kode watch yotub, misal https://www.youtube.com/watch?v=fUmZBc4UUDE&pp=ygUfd2VsY29tZSB0byBzdG9jayB2aWRlbyB0ZW1wbGF0ZQ%3D%3D yg diambil adalah fUmZBc4UUDE saja
            $url = explode("=", $request->isi);
            $url = $url[1];
            //& dan seterusnya dihilangkan
            $url = explode("&", $url);
            $url = $url[0];

            //update
            $materi->update([
                'name' => request('name'),
                'description' => request('description'),
                'isi' => $url
            ]);
        }

        //response
        return response()->json([
            'message' => 'Materi updated',
            'data' => $materi
        ], 200);

    }

    //destroy dengan parameter id
    public function destroy($id)
    {
        //ambil data materi
        $materi = materi::find($id);
        //jika materi tidak ditemukan
        if (!$materi) {
            //response
            return response()->json([
                'message' => 'Materi not found'
            ], 404);
        }

        //hapus materi
        $materi->delete();

        //response
        return response()->json([
            'message' => 'Materi deleted'
        ], 200);
    }
       
        
}
