<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriApiController extends Controller
{   

    public function index(Request $request)
    {
        if($request->has("all"))
        {
            $data = Kategori::all();
            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        }else{
            $data = Kategori::all()->take(3);
            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        }
    }

    

    public function getKategoriById($id)
    {
        $data = Kategori::all()->where("slug",$id)->first();
        $book = Book::with('kategori')->where("kategori_id",$data->id);
        if($data->count() > 0)
        {
            return response()->json([
                'success' => true,
                'title'   => $data->judul,
                'data'    => $book->paginate(5)
            ]);
        }else{
            return response()->json([
                'success' => false,
                'data'    => []
            ]);
        }
    
    }
}
