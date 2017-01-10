<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Routing\ResponseFactor;
use Illuminate\HttpResponse;
use Response;
use File;
use DB;
use App;
use App\Http\Requests;
use Auth;
use App\User;
use App\Images;
use App\UserFriends;
use App\UsersMessages;
use Lang;
use Mail;
use App\Mail\MyMail;
use App\Languages;

class UserController extends Controller {

    private $language;
    private $current_page_url = '';
    private $data = array();

    public function __construct(Request $request) {
        $this->middleware('auth');
        $lang = new Languages();
        $this->data['language'] =$lang->language;

    }

    function current_page_url(Request $request, $n) {
        $url = '';
        $i = 2;
        while (!empty($request->segment($i)) && $i <= $n) {
            $url.='/' . $request->segment($i);
            $i++;
        }
        return $url;
    }

    public function myprofile() {
        $userId = Auth::user()->id;
        $user_images = DB::table('images')
                ->select('id', 'user_id', 'image')
                ->where('user_id', $userId)
                ->get();
        $this->data['user_images'] = $user_images;
        return view('user/myprofile')->with($this->data);
    }

    public function home() {
        return view('home')->with($this->data);
    }

    public function addGeneralimage(Request $request) {
        $userId = Auth::user()->id;
        $folder = public_path() . '/users_image/user_' . $userId;
        $generalFolder = public_path() . '/users_image/user_' . $userId . '/general';
        $file = Input::file('userfile');
        if (!empty($file)) {
            if (!File::exists($folder) && !File::isDirectory($folder)) {
                File::makeDirectory($folder, 0777, true);
            }
            if (!File::exists($generalFolder) && !File::isDirectory($generalFolder)) {
                File::makeDirectory($generalFolder, 0777, true);
            }
            $file->move($generalFolder, $file->getClientOriginalName());
            User::where('id', $userId)
                    ->update(array(
                        'image' => $file->getClientOriginalName()
            ));
        }
        return redirect('/' . $this->language . 'myprofile');
    }

    public function myimages() {
        $userId = Auth::user()->id;
        $userimages = DB::table('images')
                ->where('user_id', $userId)
                ->get();
        $this->data['userimages'] = $userimages;
        return view('user/myimages')->with($this->data);
    }

    public function addimages() {
        $userId = Auth::user()->id;
        $folder = public_path() . '/users_image/user_' . $userId;
        $file = Input::file('userfile');
        if (!empty($file)) {
            $images = new Images;
            if (!File::exists($folder) && !File::isDirectory($folder)) {
                File::makeDirectory($folder, 0777, true);
            }
            $file->move($folder, $file->getClientOriginalName());
            $images->user_id = $userId;
            $images->image = $file->getClientOriginalName();
            $images->save();
        }
        return back();
    }

    public function deleteUserimage(Request $request, $language, $image_id) {
        Images::where('id', $image_id)->delete();
        return back();
    }

    public function downloaUserImage(Request $request, $language, $image_id) {
        $userId = Auth::user()->id;
        $userimages = DB::table('images')
                ->where('id', $image_id)
                ->first();
        $filepath = public_path() . '/users_image/user_' . $userId . '/' . $userimages->image;
        return Response::download($filepath);
        return back();
    }

    public function accountsettings() {
        return view('user/accountSettings', $this->data);
    }

    public function updatedata(Request $request) {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'birthday' => 'required|',
        ]);
        $userId = Auth::user()->id;
        User::where('id', $userId)
                ->update(array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'birthday' => $request->birthday,
        ));
        return back();
    }
    public function searchUsers(Request $request) {
        $userId = Auth::user()->id;
        $name = $request->user_name;
        if (!empty($name)) {
            $users = DB::select(
                            'SELECT `users`.`id`,`users`.`first_name`,`users`.`image`,`users`.`last_name`,`user_friends`.`from_user`,`user_friends`.`to_user`,`user_friends`.`status`,`user_friends`.`table_id`
                                FROM `users`
                                LEFT JOIN `user_friends`
                                 ON  (`users`.`id`=`user_friends`.`from_user`
                                    AND (`user_friends`.`to_user` = "' . $userId . '" 
                                 OR `user_friends`.`to_user` ="NULL")) 
                                     OR (`users`.`id`=`user_friends`.`to_user` 
                                    AND (`user_friends`.`from_user` = "' . $userId . '" 
                                 OR `user_friends`.`from_user` = "NULL"))
                                WHERE `users`.`ID` <> "' . $userId . '"
                                AND  `users`.`first_name` LIKE "' . $name . '%" ESCAPE "!"'
            );
            return json_encode(array('users' => $users, 'currentuser' => $userId));
        }
    }

    public function myfriends() {
        $userId = Auth::user()->id;
        $friendRequest = DB::table('user_friends')
                ->select('user_friends.table_id', 'user_friends.from_user', 'users.first_name', 'users.last_name', 'users.image')
                ->where('to_user', $userId)
                ->where('status', 0)
                ->leftJoin('users', 'users.id', '=', 'user_friends.from_user')
                ->get();
        $user_friends = DB::table('users')
            ->leftJoin('user_friends', function($join) {
                $userId = Auth::id();
                $join->on('users.id', '=', 'user_friends.from_user')
                        ->where('user_friends.to_user', '=', $userId)
                    ->orOn('users.id', '=', 'user_friends.to_user')
                        ->Where('user_friends.from_user', '=', $userId);
            })
            ->where('user_friends.status', '1')
            ->get();
        if (!empty($friendRequest)) {
            $this->data['friendRequest'] = $friendRequest;
        }
        if (!empty($user_friends)) {
            $this->data['user_friends'] = $user_friends;
        }
        return view('user/myfriends')->with($this->data);
    }

    public function userProfile($language, $id) {
        $user = DB::table('users')
                ->where('id', $id)
                ->select('id', 'first_name', 'last_name', 'birthday', 'image')
                ->first();

        $user_images = DB::table('images')
                ->where('user_id', $id)
                ->select('id', 'user_id', 'image')
                ->get();
        $this->data['user'] = $user;
        $this->data['user_images'] = $user_images;
        return view('user/userProfile')->with($this->data);
    }

    public function addFriendFromSearch(Request $request) {
        $userId = $request->userId;
        $current_user = Auth::user()->id;
        $users = UserFriends::create([
                    'from_user' => $current_user,
                    'to_user' => $userId,
                    'status' => 0
        ]);
        if ($users) {
            return response()->json([
                        'data' => 'success'
            ]);
        }
    }

    public function deleteFriendFromSearch(Request $request) {
        $userId = $request->userId;
        $users = DB::table('user_friends')
                ->where('table_id', $userId)
                ->delete();
        if ($users) {
            return response()->json([
                        'data' => 'success'
            ]);
        }
    }

    public function AddUserRequestFromFriendsPage(Request $request) {
        $id = $request->id;
        $adduser = DB::table('user_friends')
                ->where('table_id', $id)
                ->update([ 'status' => 1]);
        if ($adduser) {
            return 1;
        }
    }

    public function DeleteUserFromFriendsPage(Request $request) {
        $id = $request->id;
        $deleteuser = DB::table('user_friends')
                ->where('id', $id)
                ->delete();
        if ($deleteuser) {
            return 1;
        }
    }

    public function mymessages(Request $request) {
        $userId = Auth::user()->id;

/////////////////////????????????
        $user_friends = DB::table('user_friends')
            ->leftJoin('users', function($join) {
                $userId = Auth::id();
                $join->on('users.id', '=', 'user_friends.from_user')
                    ->where('user_friends.to_user', '=', $userId)
                    ->orOn('users.id', '=', 'user_friends.to_user')
                    ->Where('user_friends.to_user', '=', $userId);
            })
            ->where('user_friends.status', '1')
            ->get();
//////////////////////////????????????
        $user_friends = DB::select(
            'SELECT `users`.`id`,`users`.`email`,`users`.`first_name`,`users`.`last_name`,`users`.`image`,`user_friends`.`from_user`,`user_friends`.`to_user`
                         FROM `user_friends`
                         LEFT JOIN `users`
                          ON `users`.`id` = `user_friends`.`from_user`
                          OR `users`.`id`=`user_friends`.`to_user`
                       WHERE  (`user_friends`.`from_user` = "' . $userId . '"   
                            OR `user_friends`.`to_user`= "' . $userId . '") 
                            AND  `users`.`id` <> "' . $userId . '" 
                            AND `user_friends`.`status` = "1"'
        );
        $this->data['userId'] = $userId;
        if (!empty($user_friends)) {
            $this->data['user_friends'] = $user_friends;
        }
        return view('user/mymessages')->with($this->data);
    }

    public function getMessages(Request $request, $to_user_id) {
        $currentuser = Auth::user()->id;
        DB::table('users_messages')
                ->where('from_user', $to_user_id)
                ->where('to_user', $currentuser)
                ->where('delivered', 0)
                ->update([ 'delivered' => 1]);
        $getMessages = DB::table('users_messages')
            ->leftJoin('users','users.id', '=', 'users_messages.from_user')
                ->where([
                    ['from_user', '=', $currentuser],
                    ['to_user', '=', $to_user_id],
                    ['delete_msg', '!=', $currentuser]
                ])
                ->orwhere([
                    ['from_user', '=', $to_user_id],
                    ['to_user', '=', $currentuser],
                    ['delete_msg', '!=', $currentuser]
                ])
                ->orderBy('users_messages.created_at', 'ASC')
            ->get();
        $count_messages = count($getMessages);
        return response()->json(array('getMessages' => $getMessages, 'count_messages' => $count_messages));
    }

    public function getnotreadmessages(Request $request) {
        $userId = $request->userId;
        $getnotreadmessages = DB::table('users_messages')
            ->select('*')
            ->where('to_user', $userId)
            ->where('delivered', 0)
        ->get();
        return json_encode(array('getnotreadmessages' => count($getnotreadmessages)));
    }

    public function getnotreadusersmessages(Request $request) {
        $userId = $request->userId;
        $getnotreadmessages = DB::table('users_messages')
            ->select('users_messages.from_user', 'users_messages.delivered')
            ->where('to_user', $userId)
            ->where('delivered', 0)
        ->get();
        $data = array();
        if (!empty($getnotreadmessages)) {
            foreach ($getnotreadmessages as $value) {
                $data[$value->from_user] = 0;
            }
            foreach ($getnotreadmessages as $value) {
                $data[$value->from_user] = $data[$value->from_user] + 1;
            }
        }
        return json_encode(array('getnotreadmessages' => $data));
    }

    public function send_message(Request $request) {
        $file = $request->file('image');
        $fromUserId = Auth::user()->id;
        $messageContent = $request->text;
        $userId = $request->userId;
        $folder = public_path() . '/users_image/imagesinmessage';
        if ($file !== null) {
            if (!File::exists($folder) && !File::isDirectory($folder)) {
                File::makeDirectory($folder, 0777, true);
            }
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $filename);
            $send = UsersMessages::create([
                'from_user' => $fromUserId,
                'to_user' => $userId,
                'content' => $messageContent,
                'images' => $filename,
                'delivered' => 0
            ]);
            return json_encode(array('image' => $filename));
        }
        else {
            $send = UsersMessages::create([
                'from_user' => $fromUserId,
                'to_user' => $userId,
                'content' => $messageContent,
                'delivered' => 0
            ]);
            $result_content = DB::table('users_messages')->select('*')->where('content',$messageContent)->where('to_user',$userId)->where('from_user',$fromUserId)->first();
            return json_encode(array('result_msg' => $result_content));
        }
    }

    public function seemessages(Request $request) {
        $currentuser = Auth::user()->id;
        $to_user_id = $request->to_user;
        DB::table('users_messages')
                ->where('from_user', $to_user_id)
                ->where('to_user', $currentuser)
                ->update([ 'delivered' => 1]);
    }

    public function receiveUserMessages(Request $request) {
        $currentuser = Auth::id();
        $messageCount = $request->message_count;
        $userId = $request->userId;
        $getMessages = DB::table('users_messages')
            ->leftJoin('users','users.id', '=', 'users_messages.from_user')
            ->where([
                ['from_user', '=', $currentuser],
                ['to_user', '=', $userId],
                ['delete_msg', '!=', $currentuser]
            ])
            ->orwhere([
                ['from_user', '=', $userId],
                ['to_user', '=', $currentuser],
                ['delete_msg', '!=', $currentuser]
            ])
            ->orderBy('users_messages.created_at', 'ASC')
        ->get();
        if (count($getMessages) > $messageCount) {
            $differentce_messages = count($getMessages) - $messageCount;
            $updatedMessages = DB::table('users_messages')
                ->select('users.first_name', 'users.last_name', 'users_messages.from_user','users_messages.chat_id',  'users_messages.images', 'users_messages.to_user', 'users_messages.content', 'users_messages.created_at')
                ->leftJoin('users', 'users.id', '=', 'users_messages.from_user')
                ->where('users_messages.to_user', $currentuser)
                ->where('users_messages.from_user', $userId)
                ->orderBy('users_messages.created_at', 'desc')
                ->limit($differentce_messages)
            ->get();
            return response()->json(array('updatedMessages' => $updatedMessages, 'count_messages' => count($getMessages)));
        }
    }

    public function mymail(Request $request) {
        $userId = Auth::user()->id;
        $user_friends = DB::table('user_friends')
            ->leftJoin('users','users.id', '=', 'from_user')
            ->where([
                ['from_user', '=', $userId]
            ])
            ->orwhere([
                ['to_user', '=', $userId]
            ])
            ->where('users.id', '<>',$userId)
            ->where('user_friends.status', 1)
            ->get();
        $this->data['user_friends'] = $user_friends;
        return view('user/mymail')->with($this->data);
    }

    public function sendEmailMessage(Request $request) {
        $fromMail = $request->fromMail;
        $to_mail = $request->toMail;
        $from_name = $request->fromName;
        $subject = $request->subject;
        if (!empty($to_mail)) {
            foreach ($to_mail as $key => $value) {
                Mail::raw('Текст письма', function ($message) use($fromMail, $from_name, $to_mail, $subject) {
                    $message->from($fromMail, $from_name);
                    $message->to($to_mail)->subject($subject);
                });
            }
        }
    }

    public function getSmallChatMessages(Request $request) {
        $currentuser = Auth::user()->id;
        $userId = $request->userId;
        $getMessages = DB::table('users_messages')
            ->leftJoin('users','users.id', '=', 'users_messages.from_user')
            ->where([
                ['from_user', '=', $currentuser],
                ['to_user', '=', $userId],
            ])
            ->orwhere([
                ['from_user', '=', $userId],
                ['to_user', '=', $currentuser],
            ])
            ->orderBy('users_messages.created_at', 'ASC')
            ->get();
        $count_messages = count($getMessages);
        return response()->json(array('getMessages' => $getMessages, 'count_messages' => $count_messages));
    }

    public function sendSmallChatmessage(Request $request) {
        $fromUserId = Auth::user()->id;
        $messageContent = $request->text;
        $userId = $request->userId;
        $send = UsersMessages::create([
            'from_user' => $fromUserId,
            'to_user' => $userId,
            'content' => $messageContent
        ]);
        if ($send) {
            return response()->json(['data' => 'true']);
        }
    }

    public function receiveSmallchatMessages(Request $request) {
        $current_user = Auth::user()->id;
        $users = $request->users;
        if (!empty($users)) {
            foreach ($users as $key => $value) {
                $ids[$key] = $users[$key]['id'];
                $message_count[$users[$key]['id']] = $users[$key]['count'];
            }
            $chat = array();
            if (!empty($ids)) {
                foreach ($ids as $key => $id) {
                    $getMessages = DB::table('users_messages')
                        ->where([
                            ['from_user', '=', $current_user],
                            ['to_user', '=', $id]
                        ])
                        ->orwhere([
                            ['from_user', '=', $id],
                            ['to_user', '=', $current_user]
                        ])
                        ->orderBy('users_messages.created_at', 'ASC')
                        ->get();
                    if (!empty($messages)) {
                        $chat[$ids[$key]] = $messages;
                    } else {
                        $chat[$key] = array();
                    }
                }
            };
            $updatedMessages = array();
            $count_messages = array();
            if (!empty($chat)) {
                foreach ($chat as $key => $value) {
                    if (count($value) > $message_count[$key]) {
                        $differentce_messages = count($value) - $message_count[$key];
                        $updatedMessages[$key] = DB::table('users_messages')
                            ->select('*')
                            ->where('users_messages.to_user', $current_user)
                            ->where('users_messages.from_user', $key)
                            ->orderBy('users_messages.created_at', 'desc')
                            ->limit($differentce_messages)
                        ->get();
                        $count_messages[$key] = count($value);
                    }
                }
                return response()->json(array('receiveMessages' => $updatedMessages, 'count_messages' => $count_messages));
            }
        }
    }

    public function calendar() {
        return view('user/calendar');
    }

    public function calendardata() {
        $userdata = DB::table('users')
                ->select('users.first_name', 'users.last_name', 'users.birthday')
                ->get();
        return json_encode(array('userdata' => $userdata));
    }

    public function sendmessagestoemail(Request $request) {
        $currentuser = Auth::user()->id;
        $to_user_id = $request->to_user;
        $fromMail = $request->useremail;
        $from_name = $request->username;
        $to_useremail = $request->to_useremail;
        $getMessages = DB::table('users_messages')
            ->leftJoin('users','users.id', '=', 'users_messages.from_user')
            ->where([
                ['from_user', '=', $currentuser],
                ['to_user', '=', $to_user_id]
            ])
            ->orwhere([
                ['from_user', '=', $to_user_id],
                ['to_user', '=', $currentuser]
            ])
            ->orderBy('users_messages.created_at', 'ASC')
            ->get();
        $this->data['getMessages'] = $getMessages;
        $this->data['currentuser'] = $currentuser;
        $this->data['to_user_id'] = $to_user_id;
        view('user\mail')->with($this->data);
        Mail::raw('user\mail', function ($message) use($fromMail, $from_name, $to_useremail) {
            $message->from($fromMail, $from_name);
            $message->to($to_useremail)->subject('Chat Messages');
        });
    }

    public function checkOnline(Request $request) {
        $friendsid = $request->myfriendsId;
        $onlinefriends = DB::table('users')
            ->select('id')
            ->whereIn('id', $friendsid)
            ->where('online', 1)
        ->get('*');
        return json_encode(array('onlineUsers' => $onlinefriends));
    }

    public function update_msg(Request $request){
        $request_all = $request->all();
        $msg_id = $request_all['msg_id'];
        $update_content = $request_all['new_msg'];
        $userdata = DB::table('users_messages')
            ->where('chat_id', $msg_id)
            ->update(['content' => $update_content, 'update_msg' =>1]);
        return 1;
    }

    public function delete_msg(Request $request){
        $auth_id = Auth::id();
        $request_all = $request->all();
        $chat_id = $request_all['msg_id'];
        $delete_msg = DB::table('users_messages')->select('delete_msg')->where('chat_id',$chat_id)->first();
        $delete = $delete_msg->delete_msg;
        if($delete_msg->delete_msg == 0){
            DB::table('users_messages')
            ->where('chat_id', $chat_id)
            ->update(['delete_msg' => $auth_id]);
        }
        else{
            DB::table('users_messages')->where('chat_id', '=', $chat_id)->delete();
        }
        return 1;
    }

    public function setUpdatemsg(){
        $auth_id = Auth::id();
        $updatemsg = DB::table('users_messages')
            ->select('*')
            ->where('update_msg',1)
            ->get();
        DB::table('users_messages')->where('update_msg', 1)->where('from_user','<>',$auth_id)->update(array('update_msg' => 0));
        return json_encode($updatemsg);
    }
}
