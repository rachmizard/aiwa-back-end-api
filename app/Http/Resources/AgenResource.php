<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AgenResource extends Resource
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
        if ($this->foto == null) {
         
            return [
                'id' => $this->id,
                'no_ktp' => $this->no_ktp,
                'nama' => $this->nama,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_telp' => $this->no_telp,
                'alamat' => $this->alamat,
                'email' => $this->email,
                'username' => $this->username,
                'password' => $this->password,
                'status' => $this->status,
                'bank' => $this->bank,
                'no_rekening' => $this->no_rekening,
                'fee_reguler' => $this->fee_reguler,
                'fee_promo' => $this->fee_promo,
                'nama_rek_beda' => $this->nama_rek_beda,
                'website' => $this->website,
                'koordinator' => $this->koordinator,
                'foto' => 'http://aiwaapps.com/storage/images/default.png',
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ];   
        }else{
            return [
                'id' => $this->id,
                'no_ktp' => $this->no_ktp,
                'nama' => $this->nama,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_telp' => $this->no_telp,
                'alamat' => $this->alamat,
                'email' => $this->email,
                'username' => $this->username,
                'password' => $this->password,
                'status' => $this->status,
                'bank' => $this->bank,
                'no_rekening' => $this->no_rekening,
                'fee_reguler' => $this->fee_reguler,
                'fee_promo' => $this->fee_promo,
                'nama_rek_beda' => $this->nama_rek_beda,
                'website' => $this->website,
                'koordinator' => $this->koordinator,
                'foto' => 'http://aiwaapps.com/storage/images/'. $this->foto,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ];
        }
    }
}
