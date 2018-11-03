<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
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
