<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Operator::all();
        return view('operator.index',compact('data'));
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
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password',
        ]);
        $data = Operator::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if($data)
        {
            return redirect()->route('operator.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('operator.index')->with('error','Data Gagal Disimpan');
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
        $data = Operator::all()->where('uuid',$id)->first();
        return view('operator.edit',compact('data'));
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
        $data = Operator::find($id);
        if($request->password == "")
        {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
            ]);
            $data->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);
            if($data)
            {
                return redirect()->route('operator.index')->with('success','Data Berhasil');
            }else{
                return redirect()->route('operator.index')->with('error','Data Gagal Disimpan');
            }
        }else{
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:5',
                'password_confirmation' => 'required|same:password',
            ]);
            $data->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            if($data)
            {
                return redirect()->route('operator.index')->with('success','Data Berhasil');
            }else{
                return redirect()->route('operator.index')->with('error','Data Gagal Disimpan');
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
        $data = Operator::find($id);
        $data->delete();
        if($data)
        {
            return redirect()->route('operator.index')->with('success','Data Berhasil');
        }else{
            return redirect()->route('operator.index')->with('error','Data Gagal Dihapus');
        }
    }
}
