<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterNotifikasi extends Model
{
    //
    protected $table = 'master_notifikasis';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['anggota_id', 'pesan', 'status'];
}
