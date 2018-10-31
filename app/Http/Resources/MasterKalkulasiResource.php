<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MasterKalkulasiResource extends Resource
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
            'harga_default' => $this->harga_default,
            'harga_promo' => $this->harga_promo,
            'harga_infant' => $this->harga_infant,
            'harga_full' => $this->harga_full,
            'harga_lite' => $this->harga_lite,
            'diskon_balita_uhud' => $this->diskon_balita_uhud,
            'diskon_balita_nur' => $this->diskon_balita_nur,
            'diskon_balita_rhm' => $this->diskon_balita_rhm,
            'diskon_balita_standar' => (int) $this->diskon_balita_standar,
            'harga_visa' => $this->harga_visa
        ];
    }
}
