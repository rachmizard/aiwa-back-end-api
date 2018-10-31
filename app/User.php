<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\AgenResetPasswordNotification;
use App\Notifications\BroadcastNotification;
use Notification;

class User extends Model
{
    // HasApiTokens
    use Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id',
        'nama', 'email', 'password', 'username', 'password', 'jenis_kelamin', 'no_ktp', 'alamat', 'no_telp', 'status', 'koordinator', 'bank', 'no_rekening', 'fee_reguler', 'fee_promo', 'nama_rek_beda', 'website', 'device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'device_token'
    ];

    public function jamaah()
    {
        return $this->hasMany('App\Jamaah', 'id');
    }

    public function koordinatorJamaah()
    {
        return $this->hasMany('App\Jamaah', 'id');
    }

    public function topJamaah()
    {
        return $this->hasMany('App\Jamaah', 'id');
    }

    public function prospek()
    {
        return $this->hasMany('App\Prospek', 'id');
    }

    public function prospekCount()
    {
        return $this->belongsTo('App\Prospek');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'koordinator', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AgenResetPasswordNotification($token));
    }

    // /**
    //  * Route notifications for the FCM channel.
    //  *
    //  * @return string
    //  */
    // public function routeNotificationForFcm()
    // {
    //     return $this->device_token;
    // }

}
