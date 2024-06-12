<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class KategoriController extends Controller
{

    private $path = 'data/kategori/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kategori::all();
        return view('kategori.index',compact('data'));
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
            'judul' => 'required',
            'gambar' => 'required|mimes:jpeg,jpg,png,webp|max:2048', 
        ]);
        $gambar = $request->file('gambar');
        $name = $gambar->hashName();
        $gambar->move($this->path,$name);
        $data = Kategori::create([
           'uuid' => Uuid::uuid4()->toString(),
           'slug' => Str::slug($request->judul),
           'judul' => $request->judul,
           'gambar' => $this->path.$name,
        ]);
        if($data)
        {
            return redirect()->route('kategori.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('kategori.index')->with('error','Data Gagal');
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
        $data = Kategori::all()->where('uuid',$id)->first();
        return view('kategori.edit',compact('data'));
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
        $data = Kategori::find($id);
        if($request->hasFile('gambar'))
        {
            $request->validate([
                'judul'  => 'required',
                'gambar' => 'required|mimes:jpeg,jpg,png,webp|max:2048',
            ]);
            File::delete($data->gambar);
            $gambar = $request->file('gambar');
            $name = $gambar->hashName();
            $gambar->move($this->path,$name);
            $data->update([
                'slug' => Str::slug($request->judul),
                'judul' => $request->judul,
                'gambar' => $this->path.$name,
            ]);
            if($data)
            {
                return redirect()->route('kategori.index')->with('success','Data Berhasil');
            }else{
                return redirect()->route('kategori.index')->with('error','Data Gagal');
            }
        }else{
            $request->validate([
                'judul' => 'required',
            ]);
            $data->update($request->all());
            if($data)
            {
                return redirect()->route('kategori.index')->with('success','Data Berhasil');
            }else{
                return redirect()->route('kategori.index')->with('error','Data Gagal');
            }
        }
        // File::delete($data->gambar);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        File::delete($data->gambar);
        $data->delete();
        if($data)
        {
            return redirect()->route('kategori.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('kategori.index')->with('error','Data Gagal');
        }
    }
}
