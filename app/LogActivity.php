<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $table = 'logs';
    public $fillable = ['subjek', 'user_id', 'tanggal'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
