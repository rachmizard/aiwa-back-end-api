<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';
    // public $fillable = ['no_ktp', 'nama', 'jenis_kelamin', '', '', '', '', '', '', '', '', ''];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
