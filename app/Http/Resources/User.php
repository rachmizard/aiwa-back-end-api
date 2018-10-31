<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'email' => $this->email,
            'login_at' => $this->login_at,
            'last_login' => $this->last_login,
        ];
    }

    public function with($request){
        return [
            'version' => '1.0.0',
            'authot_url' => url('http://instagram.com/rachmizard')
        ];
    }
}
