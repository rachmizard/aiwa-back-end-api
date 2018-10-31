<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MasterNotifikasiResource extends Resource
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
            'anggota_id' => $this->anggota_id,
            'pesan' => $this->pesan,
            'status' => $this->status,
            'tgl' => $this->created_at->diffForHumans(),
        ];
    }
}
