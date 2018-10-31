<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterKalkulasiResource;
use App\MasterKalkulasi;

class MasterKalkulasiControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MasterKalkulasiResource::collection(MasterKalkulasi::paginate(20));
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
        // $kalkulasi = $request->isMethod('put') ? MasterKalkulasi::findOrFail($request->id) : new MasterKalkulasi;
        // $kalkulasi = $request->all();
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
        $kalkulasi = $request->isMethod('put') ? MasterKalkulasi::findOrFail($request->id) : new MasterKalkulasi;
        $kalkulasi->update([
                'harga_default' => $request->input('harga_default'),
                'harga_promo' => $request->input('harga_promo'),
                'harga_infant' => $request->input('harga_infant'),
                'harga_full' => $request->input('harga_full'),
                'diskon_balita_uhud' => $request->input('diskon_balita_uhud'),
                'diskon_balita_nur' => $request->input('diskon_balita_nur'),
                'diskon_balita_rhm' => $request->input('diskon_balita_rhm'),
                'diskon_balita_standar' => $request->input('diskon_balita_standar'),
                'harga_visa' => $request->input('harga_visa'),
            ]);
            return response()->json(['success' => 'Berhasil di update!']);
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
