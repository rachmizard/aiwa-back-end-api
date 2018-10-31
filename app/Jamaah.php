<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Anggota;
use Carbon\Carbon;

class Jamaah extends Model
{
    protected $table = 'jamaah';
    public $fillable = ['id', 'id_umrah', 'id_jamaah', 'tgl_daftar', 'nama', 'tgl_berangkat', 'tgl_pulang', 'maskapai', 'marketing', 'staff', 'no_telp', 'marketing_fee', 'koordinator', 'koordinator_fee', 'top', 'top_fee', 'status', 'diskon_marketing', 'tgl_transfer', 'periode'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function anggota()
    {
    	return $this->belongsTo(User::class, 'marketing', 'id');
    }

    public function koordinatorJamaah()
    {
        return $this->belongsTo(User::class, 'koordinator', 'id');
    }

    public function topJamaah()
    {
        return $this->belongsTo(User::class, 'top', 'id');
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['diskon_marketing'] = number_format($value,2,',','.');;
    }
}
