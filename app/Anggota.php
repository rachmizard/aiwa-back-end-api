<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jamaah;
class Anggota extends Model
{
	protected $table = 'anggotas';
    // public $fillable = ['no_ktp', 'nama', 'jenis_kelamin', '', '', '', '', '', '', '', '', ''];
    public $timestamps = true;
    protected $primaryKey = 'id';
    
	// public function jamaah()
 //    {
 //    	return $this->hasMany('App\Jamaah');
 //    }
}
