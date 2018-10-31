<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterItinerary extends Model
{
    //
    protected $table = 'master_itenaries';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $fillable = ['detailjadwal_id', 'judul', 'tanggal_itinerary', 'link'];
}
