<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use DB;
use Auth;

class GoogleLoginController extends Controller {

    private $language;
    private $data = array();

    public function __construct(Request $request) {
        $this->language = $request->segment(1);
        App::setLocale($this->language);
        $this->data['language'] = $this->language;
    }

    public function redirect(Request $request) {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        $user = Socialite::driver('google')->user();
        if (!empty($user)) {
            $checkGoogleEmailInDb = DB::table('users')->where('email', $user->email)->first();
            if ($checkGoogleEmailInDb) {
                User::where('email', $user->email)
                        ->update(array(
                            'google_id' => $user->id
                ));
            } else {

                User::create([
                    'first_name' => $user->user['name']['givenName'],
                    'last_name' => $user->user['name']['familyName'],
                    'email' => $user->email,
                    'password' => bcrypt($user->email),
                    'google_id' => $user->id
                ]);
            }

            $data = array('email' => $user->email, 'password' => $user->email);

            if (Auth::attempt($data)) {
                $userId = Auth::user()->id;
                DB::table('users')
                        ->where('id', $userId)
                        ->update(['online' => 1]);
                return redirect('/' . $this->language . '/home');
            } else {
                return redirect('/' . $this->language . '/login');
            }
        }
    }

}
