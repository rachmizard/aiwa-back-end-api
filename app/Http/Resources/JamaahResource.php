<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JamaahResource extends Resource
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
            'id_umrah' => $this->id_umrah,
            'tgl_daftar'  => date('d M Y', strtotime($this->tgl_daftar)),
            'nama'  => $this->nama,
            'tgl_berangkat' => date('d M Y', strtotime($this->tgl_berangkat)),
            'tgl_pulang' => date('d M Y', strtotime($this->tgl_pulang)),
            // 'marketing' => new AgenResource($this->anggota),// create an object relationship
            'marketing_name' => $this->anggota['nama'],
            'marketing' => $this->marketing,
            'staff' => $this->staff,
            'no_telp' => $this->no_telp,
            'marketing_fee' => $this->marketing_fee,
            'koordinator' => $this->koordinator,
            'koordinator_fee' => $this->koordinator_fee,
            'top' => $this->top,
            'top_fee' => $this->top_fee,
            'status' => $this->status,
            'tgl_transfer' => date('d M Y', strtotime($this->tgl_transfer))
        ];
    }
}
