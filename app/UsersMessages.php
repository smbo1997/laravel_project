<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersMessages extends Model {

     protected $fillable = [
        'from_user', 'to_user', 'content','created_at','images','delivered'
    ];

}
