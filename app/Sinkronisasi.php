<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sinkronisasi extends Model
{
    protected $table = 'master_sinkronisasi';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['tahun', 'status'];

}
