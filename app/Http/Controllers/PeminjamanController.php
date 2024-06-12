<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Peminjaman::with('user','book')->get();
        // dd($data);
        return view('peminjaman.index',compact('data'));
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

    public function changeStatus(Request $request)
    {
        $data = Peminjaman::with('user','book')->where('id',$request->id)->first();
        
        if($request->status == "kembali")
        {
            $book = Book::find($request->book_id);
            $book->update([
                "stock" => $book->stock+1
            ]);
            $createdTransaction = Transaksi::create([
                'uuid' => Uuid::uuid4()->toString(),
                'nomor_buku' => $data->book->id_buku,
                'judul_buku' =>  $data->book->judul,
                'mahasiswa' => $data->user->name,
                'tanggal_pinjam' => $data->created_at,
                'tanggal_kembali' => Carbon::today(),
            ]);
            $data->update([
                'status' => $request->status
            ]);
            if($data && $createdTransaction && $book)
            {
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'error']);
            }
        }else{
            $data->update([
                'status' => $request->status
            ]);
            if($data)
            {
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'error']);
            }

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data = Peminjaman::find($id);
        $data->delete();
        if($data)
        {
            return redirect()->route('peminjaman.index')->with('success','Berhasil');
        }else{
            return redirect()->route('peminjaman.index')->with('error','Gagal');
        }
    }
}
