<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MasterBrosurResource extends Resource
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
            'file_brosur' => 'test.heksasecurity.com/storage/brosur/'. $this->file_brosur,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
