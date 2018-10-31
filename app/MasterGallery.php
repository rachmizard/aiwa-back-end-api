<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterGallery extends Model
{
    //
    protected $table = 'master_galleries';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $fillable = ['id', 'file', 'tanggal', 'judul', 'deskripsi', 'tipe', 'status'];

    public function hotel()
    {
    	return $this->belongsTo(Master_Hotel::class, 'judul', 'id');
    }

}
