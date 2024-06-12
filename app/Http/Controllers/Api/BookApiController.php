<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Book::with('kategori')->paginate(5);
        return response()->json([
            'success' => true,  
            'response' => 'index',
            'data' => $data
        ]);
    }


    public function search(Request $request,$id)
    {
        $data = Book::with('kategori')->where('judul','like','%'.$id.'%')->paginate(1);
        return response()->json([
            'success' => true,
            'response' => 'search',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'pengembalian' => 'required'
        ]);
        $book = Book::find($request->idBook);
        if($book->stock > 0){
            DB::beginTransaction();
            try{
                $book->stock = $book->stock - 1;
                $book->save();
                Peminjaman::create([
                    'uuid' => Uuid::uuid4()->toString(),
                    'user_id' => $request->idUser,
                    'buku_id' => $request->idBook,
                    'pinjam' => Carbon::now(),
                    'kembali' => $request->pengembalian,
                    'ket' => $request->keterangan,
                    'status' => 'proses'
                ]);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'response' => 'Transaksi Berhasil',
                    'data' => $request->all()
                ]);
            }catch(\Exception $e){
                DB::rollback();
                return response()->json([
                    'success' => true,
                    'response' => 'Transaksi Gagal',
                   
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'response' => 'Stok habis'
            ]);
        }
       
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Book::with('kategori')->find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
