<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterVoucher extends Model
{
    //
    protected $table = 'master_vouchers';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $fillable = ['anggota_id', 'file', 'deskripsi'];
}
