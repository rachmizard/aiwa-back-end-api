<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterHotelResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\GalleryHotelResource;
use App\MasterGallery;
use App\Master_Hotel;

class MasterHotelControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieveHotelByKota(Request $request, $kota)
    {
        return MasterHotelResource::collection(Master_Hotel::where('status', '!=', 'archived')->where('kota', $kota)->paginate(100000));
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
    public function retrieveHotelByKotaDetail($id)
    {
        return new MasterHotelResource(Master_Hotel::findOrFail($id));
    }


    public function retrieveFotoByHotel($id)
    {
        // return new MasterHotelResource(Master_Hotel::with('gallery')->where('kota', $kota)->findOrFail($id));
        return GalleryHotelResource::collection(MasterGallery::where('status', '!=', 'archived')->where('judul', '=', $id)->where('tipe', 'foto_hotel')->get());
    }

    public function retrieveVideoByHotel($id)
    {
        return GalleryHotelResource::collection(MasterGallery::where('status', '!=', 'archived')->where('judul', '=', $id)->where('tipe', 'video_hotel')->get());   
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
