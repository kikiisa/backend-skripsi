<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;

class SliderController extends Controller
{
    private $path = 'data/slider/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Slider::all();
        return view('slider.index',compact('data'));
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
            'judul' => 'required|string',
            'gambar' => 'required|mimes:jpeg,jpg,png,webp|max:2048',
        ]);
        $gambar = $request->file('gambar');
        $name = $gambar->hashName();
        $gambar->move($this->path,$name);
        $data = Slider::create([
            'uuid' => Uuid::uuid4()->toString(), 
            'judul' => $request->judul,
            'image' => $this->path.$name,   
        ]);
        if($data)
        {
            return redirect()->route('slider.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('slider.index')->with('error','Data Gagal Disimpan');
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
        $data = Slider::all()->where('uuid',$id)->first();
        return view('slider.edit',compact('data'));
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
        $data = Slider::find($id);
        if($request->hasFile('gambar'))
        {
            $request->validate([
                'judul' => 'required|string',
                'gambar' => 'required|mimes:jpeg,jpg,png,webp|max:2048', 
            ]);
            File::delete($data->image);
            $gambar = $request->file('gambar');
            $name = $gambar->hashName();
            $gambar->move($this->path,$name);
            $data->update([
               'judul' => $request->judul,
               'image' => $this->path.$name,
            ]);
            if($data)
            {
                return redirect()->back()->with('success','Data Berhasil');
            }else{
                return redirect()->back()->with('error','Data Gagal Disimpan');
            }
        }else{
            $request->validate([
                'judul' => 'required|string',
            ]);
            $data->update($request->all());
            if($data)
            {
                return redirect()->back()->with('success','Data Berhasil');
            }else{
                return redirect()->back()->with('error','Data Gagal Disimpan');
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
        $data = Slider::find($id);
        File::delete($data->image);
        $data->delete();
        if($data)
        {
            return redirect()->back()->with('success','Data Berhasil');
        }else{
            return redirect()->back()->with('error','Data Gagal Disimpan');
        }
    }
}
