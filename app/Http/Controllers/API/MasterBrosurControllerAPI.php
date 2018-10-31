<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MasterBrosur;
use App\Http\Resources\MasterBrosurResource;

class MasterBrosurControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MasterBrosurResource::collection(MasterBrosur::all());
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
        $brosur = $request->isMethod('put') ? MasterBrosur::findOrFail($request->id) : new MasterBrosur;
        $brosur->file_brosur = $request->file_brosur;
        $brosur->description = $request->description;
        if ($brosur->save()) {
            return response()->json(['success' => 'Brosur berhasil di tambahkan!']);
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
        return new MasterBrosurResource(MasterBrosur::findOrFail($id));
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
        $brosur = $request->isMethod('patch') ? MasterBrosur::findOrFail($request->id) : new MasterBrosur;
        $brosur->file_brosur = $request->file_brosur;
        $brosur->description = $request->description;
        if ($brosur->save()) {
            return response()->json(['success' => 'Brosur berhasil di update!']);
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
        $brosur = MasterBrosur::findOrFail($request->id);
        if ($brosur->delete()) {
            return response()->json(['success' => 'Brosur berhasil di hapus!']);
        }
    }
}
