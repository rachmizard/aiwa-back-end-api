<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
	use Notifiable;
    protected $table = 'admins';
    public $timestamps = true;
    protected $fillable = ['username', 'password', 'email', 'last_login', 'login_at'];
    protected $primaryKey = 'id';

	public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

}
