<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faqs';
    public $fillable = ['id', 'judul', 'jawaban'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
