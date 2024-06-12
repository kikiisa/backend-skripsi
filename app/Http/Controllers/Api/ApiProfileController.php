<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function update(Request $request)
    {
        $data = User::find($request->id)->first();
        $validasi = Validator::make($request->all(), [
            'old' => 'required',
            'new' => 'required|min:6',
            'konfirmasi' => 'required|same:new' 
        ],[
            'old.required' => 'Password lama harus diisi',
            'new.required' => 'Password baru harus diisi',
            'new.min' => 'Password baru minimal 6 karakter',
            'konfirmasi.required' => 'Konfirmasi password harus diisi',
            'konfirmasi.same' => 'Konfirmasi password harus sama dengan password baru'
        ]);
        if($validasi->fails())
        {
            return response()->json($validasi->errors(), 422);
        }
           
        if(Hash::check($request->old,$data->password))
        {
            $data->update([
                "password" => Hash::make($request->new)
            ]);
            if($data)
            {
                return response()->json([
                    "message" => "Berhasil Mengubah Password" 
                ],200);
            }else{
                return response()->json([
                    "message" => "Terjadi kesalahan"
                ],500);
            }
            return response()->json($data);
        }else{
            return response()->json([
                "data" => ["Password lama tidak sesuai"]
            ],422);
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
        //
    }
}
