<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PeriodeResource extends Resource
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
            'judul' => $this->judul,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
