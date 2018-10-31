<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MasterHotelResource extends Resource
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
        return [
            'id' => $this->id,
            'nama_hotel' => $this->nama_hotel,
            'kota' => $this->kota,
            'link_map' => 'https://www.google.com/maps/?q='. $this->link_map,
            'skor' => $this->skor,
            'wifi' => $this->wifi,
            'park' => $this->park,
            'kamar_rokok' => $this->kamar_rokok,
            'kamar_ac' => $this->kamar_ac,
            'kamar_keluarga' => $this->kamar_keluarga,
            'makanan_enak' => $this->makanan_enak,
            'info' => $this->info,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
