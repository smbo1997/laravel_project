<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App;
use App\Http\Requests;
use Auth;
use DB;

class LoginController extends Controller {

    private $language;
    private $data = array();

    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this->middleware('guest', ['except' => 'logout']);
        $this->language = $request->segment(1);
        App::setLocale($this->language);
        $this->data['language'] = $this->language;
        $this->redirectTo = '/' . $this->language . '/home';
    }

   
    public function showLoginForm() {
        return view('auth.login')->with($this->data);
    }

    public function logout(Request $request, $language) {
        $currentuser = Auth::user()->id;
        DB::table('users')
                ->where('id', $currentuser)
                ->update(['online' => 0]);
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/' . $language . '/login');
    }

}
