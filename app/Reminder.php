<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'master_reminder';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = ['judul', 'cron_followup', 'cron_jamaah_berangkat', 'cron_jamaah_pulang', 'cron_sinkronisasi'];
}
