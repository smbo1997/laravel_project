<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Languages;
use DB;
use App\User;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
    public function __construct(Request $request) {
        $lang = new Languages();
        $this->data['language'] =$lang->language;

    }


    public function index($language){

        $value = Session::get('adminuser');
        if($value>0){
            return redirect('/' . $language . '/usersadmin');
        }
        else{
            return view('admin/admin');
        }
    }

    public function home_ad(Request $request,$language ){
        $result = $request->all();

        $admin = DB::table('admin')
            ->where('email',$result['email'])
            ->where('password',$result['password'])
        ->first();
        if(!empty($admin)){
            Session::put('adminuser',count($admin));

            return redirect('/' . $language . '/usersadmin');
        }
        else{
            return redirect('/' . $language . '/admin');
        }

    }

    public function usersadmin($language){
        $value = Session::get('adminuser');
        $users = User::all();
        if(!empty($value))

            return view('adminka', ['users' => $users]);
        else
            return redirect('/' . $language . '/admin');
    }

    public function update_user(Request $request){
        $result = $request->all();
        $user_id = $result['id_user'];
        $first_name = $result['first_name'];
        $last_name = $result['last_name'];
        $update_user = User::where('id', '=', $user_id)->update(['first_name' =>  $first_name , 'last_name' => $last_name]);
    }

    public function delete_user(Request $request){
        $result = $request->all();
        $user_id = $result['id_user'];
        $affectedRows = User::where('id', '=', $user_id)->delete();
    }
    public function user_view($id){
        $user = DB::table('users')
            ->where('id', $id)
            ->select('id', 'first_name', 'last_name', 'birthday', 'image')
            ->first();

        $user_images = DB::table('images')
            ->where('user_id', $id)
            ->select('id', 'user_id', 'image')
            ->get();
        $userId = $id;
        $user_friends = DB::table('users')
            ->leftJoin('user_friends', function($join) use($id) {
                $join->on('users.id', '=', 'user_friends.from_user')
                    ->where('user_friends.to_user', '=', $id)
                    ->orOn('users.id', '=', 'user_friends.to_user')
                    ->Where('user_friends.from_user', '=', $id);
            })
            ->where('user_friends.status', '1')
            ->get();

        $this->data['user'] = $user;
        $this->data['user_images'] = $user_images;
        $this->data['user_friends'] = $user_friends;
        $this->data['from_id'] = $id;
        return view('admin/userprofil')->with($this->data);
//        return view('admin/userprofil');
    }

    public function user_messagesadmin(Request $request) {
        $datas = $request->all();
        $currentuser = $datas['currentuser'];
        $to_user_id = $datas['userId'];
//        print_r($currentuser);
        $getMessages = DB::table('users_messages')
            ->leftJoin('users','users.id', '=', 'users_messages.from_user')
            ->where([
                ['from_user', '=', $currentuser],
                ['to_user', '=', $to_user_id],
            ])
            ->orwhere([
                ['from_user', '=', $to_user_id],
                ['to_user', '=', $currentuser],
            ])
            ->orderBy('users_messages.created_at', 'ASC')
            ->get();
        $count_messages = count($getMessages);
        return response()->json(array('getMessages' => $getMessages, 'count_messages' => $count_messages));
    }
    public function add_user_admin(Request $request) {
        $datas = $request->all();
        $first_name = $datas['first_name'];
        $last_name = $datas['last_name'];
        $email = $datas['email'];
        $date = $datas['date'];
        $gender = $datas['gender'];
        $password = bcrypt($datas['password']);
        DB::table('users')->insert(
            array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'birthday' => $date,
                'gender' => $gender,
                'password' => $password,
            )
        );
    }

    public function adminlogout() {
        if (!(session()->has('admindata'))) {
            return redirect('admin');
        }
        $logout = DB::table('admin')
            ->where('id', session()->get('admindata'))
            ->update(['logged' => 0]);
        if ($logout) {
            session()->forget('admindata');
            return redirect('admin');
        }
    }
}
