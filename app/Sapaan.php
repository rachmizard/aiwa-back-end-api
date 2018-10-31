<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sapaan extends Model
{
    protected $table = 'master_sapaan';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['text_sapaan'];
    
}
