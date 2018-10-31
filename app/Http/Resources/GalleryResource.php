<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class GalleryResource extends Resource
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
                'file' => 'aiwaapps.com/storage/gallery/'. $this->file, 
                'tanggal' => $this->tanggal, 
                'judul' => $this->judul, 
                'deskripsi' => $this->deskripsi, 
                'tipe' => $this->tipe
            ];
    }
}
