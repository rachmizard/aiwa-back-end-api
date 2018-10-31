<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Anggota;
use App\Http\Resources\AgenResource;
use Hash;
use Storage;
use Illuminate\Support\Facades\Input;

class AgenControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AgenResource::collection(User::all());
    }

    public function retrieveByApproved()
    {
        return AgenResource::collection(User::where('status', '=', '1')->get());
    }

    public function retrieveMySubAgen(Request $request, $id)
    {
        if ($id == 'SM140') {
            return AgenResource::collection(User::where(['status' => '1'])->get());
        }else{
            return AgenResource::collection(User::where(['status' => '1', 'koordinator' => $id])->get());            
        }
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
        $agent = $request->isMethod('put') ? User::findOrFail($request->id) : new User;
        $agent->nama = $request->input('nama');
        $agent->email = $request->input('email');
        $agent->username = $request->input('username');
        $agent->password = Hash::make($request->input('password'));
        $agent->jenis_kelamin = $request->input('jenis_kelamin');
        $agent->no_ktp = $request->input('no_ktp');
        $agent->alamat = $request->input('alamat');
        $agent->no_telp = $request->input('no_telp');
        $agent->status = $request->input('status');
        $agent->bank = $request->input('bank');
        $agent->no_rekening = $request->input('no_rekening');
        $agent->fee_reguler = $request->input('fee_reguler');
        $agent->fee_promo = $request->input('fee_promo');
        $agent->nama_rek_beda = $request->input('nama_rek_beda');
        $agent->website = $request->input('website');
        $agent->koordinator = $request->input('koordinator');
        if ($agent->save()) {
            return response()->json(['success' => 'Berhasil di tambahkan!']);
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
        return new AgenResource(User::findOrFail($id));
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
        $agent = $request->isMethod('put') ? User::findOrFail($request->id) : new User;
        $agent->nama = $request->input('nama');
        $agent->email = $request->input('email');
        $agent->username = $request->input('username');
        $agent->password = Hash::make($request->input('password'));
        $agent->jenis_kelamin = $request->input('jenis_kelamin');
        $agent->no_ktp = $request->input('no_ktp');
        $agent->alamat = $request->input('alamat');
        $agent->no_telp = $request->input('no_telp');
        $agent->status = $request->input('status');
        $agent->bank = $request->input('bank');
        $agent->no_rekening = $request->input('no_rekening');
        $agent->fee_reguler = $request->input('fee_reguler');
        $agent->fee_promo = $request->input('fee_promo');
        $agent->nama_rek_beda = $request->input('nama_rek_beda');
        $agent->website = $request->input('website');
        $agent->koordinator = $request->input('koordinator');
        if ($agent->update()) {
            return response()->json(['success' => 'Berhasil di edit!']);
        }
    }

    public function profile(Request $request, $id)
    {
       $agen = User::find($id);
       $files = Input::file('upload');
       if ($request->file('upload')) {
           $name = str_random(15). '.' .$files->getClientOriginalExtension();
           if (file_exists(public_path('storage/images/'. $agen->foto))) {
                Storage::delete(public_path('storage/images/'. $agen->foto));
                   $path = public_path('storage/images/');
                   $files->move($path, $name);
                   $agen->foto = $name;
                   $agen->save();
                   return response()->json(['success' => 'Success']);
           }else{
               $path = public_path('storage/images/');
               $files->move($path, $name);
               $agen->foto = $name;
               $agen->save();
               return response()->json(['success' => 'Success']);
           }
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $agent = User::findOrFail($request->id);
        if ($agent->delete()) {
            return response()->json(['success' => 'Berhasil di hapus']);
        }
    }
}
