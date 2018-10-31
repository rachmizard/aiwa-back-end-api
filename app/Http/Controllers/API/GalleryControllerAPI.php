<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\MasterGallery;

class GalleryControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GalleryResource::collection(MasterGallery::all());
    }

    public function retrieveByDashboard(Request $request)
    {
        return GalleryResource::collection(MasterGallery::where('status', '!=', 'archived')->where('tipe', '=', 'foto')->paginate(4));
    }

    public function retrieveByFoto(Request $request)
    {
        return GalleryResource::collection(MasterGallery::where('status', '!=', 'archived')->where('tipe', '=', 'foto')->get());
    }

    public function retrieveByVideo(Request $request)
    {
        return GalleryResource::collection(MasterGallery::where('status', '!=', 'archived')->where('tipe', '=', 'video')->get());
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
