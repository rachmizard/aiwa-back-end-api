<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GalleryHotelResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        // $myvalue = $this->deskripsi;
        // $arr = explode(' ',trim($myvalue));
        return [
                 'id' => $this->id, 
                'file' => 'aiwaapps.com/storage/gallery/'. $this->file, 
                'tanggal' => $this->tanggal, 
                'judul' => 'Foto hotel '. $this->hotel->nama_hotel, 
                'deskripsi' => $this->deskripsi, 
                'tipe' => $this->tipe
        ];
    }
}
