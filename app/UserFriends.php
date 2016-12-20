<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model {

    protected $fillable = [
        'from_user', 'to_user', 'status'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

}
