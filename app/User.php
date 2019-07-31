<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function approval()
    {
        return $this->hasMany('App\Approval');
    }
    public function approvalStatusEmpty()
    {
        return $this->hasMany('App\Approval')->where('status',null);
    }
    public function approvalStatusPending()
    {
        return $this->hasMany('App\Approval')->where('status',0);
    }
    public function approvalStatusReject()
    {
        return $this->hasMany('App\Approval')->where('status',1)->orderBy('created_at', 'desc');
    }
    public function approvalStatusAccept()
    {
        return $this->hasMany('App\Approval')->where('status',2);
    }

}
