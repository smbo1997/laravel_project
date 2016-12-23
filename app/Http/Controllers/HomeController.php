<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $online = Auth::user()->online;
        $userId = Auth::id();
//        if ($online !== 1) {
            DB::table('users')
                    ->where('id', $userId)
                    ->update(['online' => 1]);
//        }

        return view('home');
    }

}
