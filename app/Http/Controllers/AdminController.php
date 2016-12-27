<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Languages;
use DB;
use App\User;
class AdminController extends Controller
{
    public function __construct(Request $request) {
        $this->middleware('auth');
        $lang = new Languages();
        $this->data['language'] =$lang->language;

    }


    public function index(){
        return view('admin/admin');
    }

    public function home_ad(Request $request,$language ){
        $result = $request->all();
        $admin = DB::table('admin')
            ->where('email',$result['email'])
            ->where('password',$result['password'])
        ->first();
        if(!empty($admin)){
            return redirect('/' . $language . '/usersadmin');
//            return view('adminka');
        }
        else{
            echo'datark';
        }

    }

    public function usersadmin(){
        $users = User::all();
//        foreach ($users as $user) {
//            print_r ($user->first_name);
//        }

        return view('adminka', ['users' => $users]);
    }
}
