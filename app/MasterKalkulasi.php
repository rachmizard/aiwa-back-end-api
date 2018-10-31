<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterKalkulasi extends Model
{
    //
    protected $table = 'master_kalkulasis';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'harga_default', 'harga_promo', 'harga_infant', 'harga_lite', 'harga_full','diskon_balita_uhud', 'diskon_balita_nur', 'diskon_balita_rhm', 'diskon_balita_standar', 'harga_visa'];
}
