<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Requests;
class ForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $language;
    private $data = array();

    public function __construct(Request $request) {
        $this->middleware('guest');
        $this->language = $request->segment(1);
        App::setLocale($this->language);
        $this->data['language'] = $this->language;
    }

    public function showLinkRequestForm() {
        return view('auth.passwords.email')->with($this->data);
    }

}
