<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
$this->get('{locale}/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('{locale}/login', 'Auth\LoginController@login');
$this->post('{locale}/logout', 'Auth\LoginController@logout')->name('logout');
$this->get('{locale}/register', 'Auth\RegisterController@showRegistrationForm');
$this->post('{locale}/register', 'Auth\RegisterController@register');
$this->get('{locale}/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('{locale}/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');
//facebook-Login
Route::get('{locale}/redirect', 'SocialiteController@redirect');
Route::get('{locale}/callback', 'SocialiteController@callback');
//google-Login
Route::get('{locale}/google_redirect', 'GoogleLoginController@redirect');
Route::get('{locale}/googleCallback', 'GoogleLoginController@callback');


Route::get('{locale}/home', 'UserController@home');
Route::get('{locale}/myprofile', 'UserController@myprofile');
Route::get('{locale}/myimages', 'UserController@myimages');
Route::post('generalimageupload', 'UserController@addGeneralimage')->name('generalimageupload');
Route::post('addimages', 'UserController@addimages')->name('addimages');
Route::get('{locale}/settings', 'UserController@accountsettings');
Route::get('{locale}/deleteUserimage/{image_id}', 'UserController@deleteUserimage');
Route::get('{locale}/downloaUserImage/{image_id}', 'UserController@downloaUserImage');
Route::post('updatedata', 'UserController@updatedata')->name('updatedata');
//Route::post('/deleteaccount', 'UserController@deleteUser');
Route::post('searchusers', 'UserController@searchUsers');
Route::post('deleteFriendFromSearch', 'UserController@deleteFriendFromSearch');
Route::get('{locale}/myfriends', 'UserController@myfriends');
Route::get('{locale}/user_profile/{id}', 'UserController@userProfile');
Route::post('addFriendFromSearch', 'UserController@addFriendFromSearch');
Route::post('AddUserRequestFromFriendsPage', 'UserController@AddUserRequestFromFriendsPage');
Route::post('DeleteUserFromFriendsPage', 'UserController@DeleteUserFromFriendsPage');
//messages
Route::get('{locale}/mymessages', 'UserController@mymessages');
Route::get('/user_messages/{id}', 'UserController@getMessages');
Route::post('/send_message', 'UserController@send_message');
Route::post('/receiveUserMessages', 'UserController@receiveUserMessages');
Route::post('/getnotreadmessages', 'UserController@getnotreadmessages');
Route::post('/getnotreadusersmessages', 'UserController@getnotreadusersmessages');
Route::post('/seemessages', 'UserController@seemessages');
Route::post('/sendmessagestoemail', 'UserController@sendmessagestoemail');
//checkOnline
Route::post('checkOnline', 'UserController@checkOnline');

//email
Route::get('{locale}/mymail', 'UserController@mymail');
Route::post('/sendEmailMessage', 'UserController@sendEmailMessage');
//smallChat
Route::post('/getSmallChatMessages', 'UserController@getSmallChatMessages');
Route::post('/sendSmallChatmessage', 'UserController@sendSmallChatmessage');
Route::post('/receiveSmallchatMessages', 'UserController@receiveSmallchatMessages');


//calendar
Route::get('/calendar', 'UserController@calendar');
Route::get('/calendardata', 'UserController@calendardata');
