<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model {

    protected $fillable = [
        'id', 'user_id', 'image'
    ];

}
