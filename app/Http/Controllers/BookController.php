<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
class BookController extends Controller
{
    private $path = 'data/buku/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Book::with('kategori')->get();
        $kategori = Kategori::all();
        return view('buku.index',compact('data','kategori'));
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
            'id_buku' => 'required|unique:books',
            'judul' => 'required',
            'kategori' => 'required',
            'pengarang' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
          
            'cover' => 'required|mimes:jpeg,jpg,png,webp|max:2048',
        ],[
            'id_buku.required' => 'Nomor Buku Wajib Diisi',
            'id_buku.unique' => 'Nomor Buku Tidak Boleh Sama',
        ]);
        $file = $request->file('cover');
        $name = $file->hashName();
        $file->move($this->path,$name);
        $data = Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'kategori_id' => $request->kategori,
            'id_buku' => $request->id_buku,
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'pengarang' => $request->pengarang,
            'tahun_terbit' => $request->tahun,
            'stock' => 1,
            'cover' => $this->path.$name,
            'deskripsi' => $request->deskripsi,
        ]);
        if($data)
        {
            return redirect()->route('buku.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('buku.index')->with('error','Data Gagal Disimpan');
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
        $kategori = Kategori::all();
        $data = Book::all()->where('uuid',$id)->first();
        return view('buku.edit',compact('kategori','data'));
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
        $data = Book::find($id);
        if($request->hasFile('cover'))
        {
            $request->validate([
                'id_buku' => 'required',
                'kategori' => 'required',
                'judul' => 'required',
                'pengarang' => 'required',
                'tahun' => 'required',
             
                'deskripsi' => 'required',
                'cover' => 'required|mimes:pdf|max:2048',
            ]);
            File::delete($data->cover);
            $file = $request->file('cover');
            $name = $file->hashName();
            $file->move($this->path,$name);
            $data->update([
                'id_buku' => $request->id_buku,
                'kategori_id' => $request->kategori,
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'tahun_terbit' => $request->tahun,
                'stock' => $data->stock,
                'cover' => $this->path.$name,
                'deskripsi' => $request->deskripsi,
            ]);
            if($data)
            {
                return redirect()->route('buku.index')->with('success','Data Berhasil');   
            }else{
                return redirect()->route('buku.index')->with('error','Data Gagal Disimpan');
            }
        }else{
            $request->validate([
                'id_buku' => 'required',
                'kategori' => 'required',
                'judul' => 'required',
                'pengarang' => 'required',
                'tahun' => 'required',
                'deskripsi' => 'required',
            ]);
            $data->update([
                'id_buku' => $request->id_buku,
                'kategori_id' => $request->kategori,
                'judul' => $request->judul,
                'pengarang' => $request->pengarang,
                'tahun_terbit' => $request->tahun,
                'stock' => $data->stock,
                'deskripsi' => $request->deskripsi,
            ]);
            if($data)
            {
                return redirect()->route('buku.index')->with('success','Data Berhasil');   
            }else{
                return redirect()->route('buku.index')->with('error','Data Gagal Disimpan');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Book::find($id);
        File::delete($data->cover);
        $data->delete();
        if($data)
        {
            return redirect()->route('buku.index')->with('success','Data Berhasil');   
        }else{
            return redirect()->route('buku.index')->with('error','Data Gagal Disimpan');
        }
    }
}
