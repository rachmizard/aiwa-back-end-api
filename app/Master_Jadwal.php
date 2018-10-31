<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master_Jadwal extends Model
{
    //
    protected $table = 'master_jadwals';
    public $timestamps = true;
    protected $fillable = [
      'id_jadwal',
      'promo',
      'tgl_berangkat',
      'jam_berangkat',
      'rute_berangkat',
      'pesawat_berangkat',
      'tgl_pulang',
      'jam_pulang',
      'rute_pulang',
      'pesawat_pulang',
      'maskapai',
      'jml_hari',
      'seat_total',
      'seat_terpakai',
      'sisa',
      'passpor',
      'moffa',
      'visa',
      'status',
      'tgl_manasik',
      'jam_manasik',
      'itinerary',
      'paket',
      'periode'
    ];

    protected $casts = [
        'paket' => 'array',
    ];
}
