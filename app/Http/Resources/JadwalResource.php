<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JadwalResource extends Resource
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
            "jadwal" => array([
                  "id" => (string) $this->id_jadwal,
                  "promo" => $this->promo,
                  "tgl_berangkat" => $this->tgl_berangkat,
                  "jam_berangkat" => $this->jam_berangkat,
                  "rute_berangkat" => $this->rute_berangkat,
                  "pesawat_berangkat" => $this->pesawat_berangkat,
                  "tgl_pulang" => $this->tgl_pulang,
                  "jam_pulang" => $this->jam_pulang,
                  "rute_pulang" => $this->rute_pulang,
                  "pesawat_pulang" => $this->pesawat_pulang,
                  "maskapai" => $this->maskapai,
                  "jml_hari" => $this->jml_hari,
                  "seat_total" => $this->seat_total,
                  "seat_terpakai" => $this->seat_terpakai,
                  "sisa" => $this->sisa,
                  "passpor" => $this->passpor,
                  "moffa" => $this->moffa,
                  "visa" => $this->visa,
                  "status" => $this->status,
                  "tgl_manasik" => $this->tgl_manasik,
                  "jam_manasik" => $this->jam_manasik,
                  "itinerary" => $this->itinerary,
                  "paket" => $this->paket
            ])
        ];
    }
}
