<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'birthday', 'gender', 'facebook_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getData() {
        //return $this->belongsTo('App\UserFriends', 'from_user', 'id');
        return $this->hasMany('App\UserFriends', 'id', 'from_user');
    }

}
