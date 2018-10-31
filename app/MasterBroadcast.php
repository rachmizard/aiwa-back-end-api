<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBroadcast extends Model
{
    //
    protected $table = 'master_broadcasts';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['judul', 'pesan', 'tipe']
}
