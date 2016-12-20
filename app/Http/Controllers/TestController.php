<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;

class TestController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function myprofile() {
        return view('user/myprofile');
    }

}
