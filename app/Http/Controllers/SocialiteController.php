<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use DB;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;


class SocialiteController extends Controller {

    private $language;
    private $data = array();

    public function __construct(Request $request) {
        $this->language = $request->segment(1);
        App::setLocale($this->language);
        $this->data['language'] = $this->language;
    }

    public function redirect(Request $request) {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback() {
        $driver = Socialite::driver('facebook')->fields([
            'id',
            'name',
            'first_name',
            'last_name',
            'email',
            'gender'
        ]);
        if (!empty($driver)) {
            $user = $driver->user();
            $checkFacebookEmailInDb = DB::table('users')
                    ->where('email', $user->user['email'])
                    ->first();
            if ($checkFacebookEmailInDb) {
                User::where('email', $user->user['email'])
                        ->update(array(
                            'facebook_id' => $user->user['id']
                ));
            } else {
                User::create([
                    'first_name' => $user->user['first_name'],
                    'last_name' => $user->user['last_name'],
                    'email' => $user->user['email'],
                    'gender' => $user->user['gender'],
                    'password' => bcrypt($user->user['email']),
                    'facebook_id' => $user->user['id']
                ]);
            }

            $data = array('email' => $user->user['email'], 'password' => $user->user['email']);
            if (Auth::attempt($data)) {
                $userId = Auth::user()->id;
                DB::table('users')
                        ->where('id', $userId)
                        ->update(['online'=> 1]);
                return redirect('/' . $this->language . '/home');
            } else {
                return redirect('/' . $this->language . '/login');
            }
        }
    }

}
