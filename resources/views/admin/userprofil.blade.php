<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{URL::asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/stayle_users.css')}}" rel="stylesheet">
</head>
<style>
    .msg-wrap{
        background-color: white;
        padding: 25px;
    }
</style>
<a href="http://laravel.am/en/usersadmin" class="btn">Admin</a>

<br>

<div class="container" style='width: 60%;' >
        <div style="float:left">
            <div class="profImage col-md-5">

                    <img src="{{ (!empty($user->image)) ? url('/users_image/user_' . $user->id . '/general/' . $user->image) : url('/users_image/avatar.png')}}" width="200px">

                <span class="usersName"> {{ $user->first_name . ' ' . $user->last_name }}</span>
            </div>
            <div style="clear: both; margin-left: 300px">
                <div class="actions">
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
            </div>
        </div>

</div>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="pg1">
            <div class="myProfilTable">
                <h3>Account Information</h3>
                <table class="table table-responsive Infotable">
                    <tr>
                        <td>Firstname</td>
                        <td>
                            <div class="col-xs-9">
                                <p><?php echo $user->first_name; ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Lastname</td>
                        <td>
                            <div class="col-xs-9">
                                <p><?php echo $user->last_name; ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Birthday</td>
                        <td>
                            <div class="col-xs-9">
                                <p><?php echo $user->birthday; ?></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pg2">
            <ul class="friendsImageulprofile">
                <?php
                if (!empty($user_images)) {
                foreach ($user_images as $key => $value) {
                ?>
                <li class="friendsImage">
                    <a class="fancybox imglink" data-fancybox-group="gallery" href="<?php echo url('users_image/user_' . $value->user_id . '/' . $value->image); ?>">

                        <img width='200px' height='200px' style="border: 3px solid #fff; border-radius: 2px;" src="<?php echo url('users_image/user_' . $value->user_id . '/' . $value->image); ?>">
                    </a>
                </li>
                <?php
                }
                } else {
                ?>
                <h3 class='result'>No Images</h3>;
                <?php }
                ?>
            </ul>
        </div>
    </div>
<div class="container"  style='width: 60%;'>
    {{--<div id="{{$from_id}}" style="float:left">--}}
        {{--@foreach($user_friends as $friends)--}}
            {{--<div class="form-control btn messages"   id="{{$friends->id}}">{{ $friends->first_name ." ". $friends->last_name}}</div>--}}
            {{--<br><br>--}}

        {{--@endforeach--}}
    {{--</div>--}}

    <div class="container">

        <div class="row">
            {{--<div class="user_name" userid="{{$from_id}}"--}}

                </div>
            <div class="conversation-wrap col-lg-3">

                <?php
                if (!empty($user_friends)) {
                foreach ($user_friends as $key => $value) {
                ?>
                <div class="media conversation friends">
                    <a class="pull-left" href="<{{($value->to_user) ? url($language . '/user_profile/' . $value->from_user) : url($language . '/user_profile/' . $value->to_user) }}">
                        <img  width="100px" height="100px" src="<?php echo (!empty($value->image)) ? url('/users_image/user_' . $value->from_user . '/general/' . $value->image) : url('/users_image/avatar.png'); ?>" style="width:50px; height: 50px">
                    </a>
                    <i id="online_user_<?php echo ($value->to_user) ? ($value->from_user) : ($value->to_user); ?>" class="online"></i>
                    <div class="media-body">
                        <h5 class="media-heading"> <?php echo $value->first_name . ' ' . $value->last_name; ?></h5>
                        <small> <button type="button" class="btn btn-link create_chat"
                                        id="user_{{($value->to_user == $from_id) ? ($value->from_user) : ($value->to_user)}}"
                                        value="{{($value->to_user  == $from_id) ? ($value->from_user) : ($value->to_user)}}"
                                        data_user="{{$from_id}}"
                                        useremail="{{$value->email}}">Send message</button>
                        </small>
                    </div>
                    <i id="usernotsee_<?php echo ( $value->to_user) ? ($value->from_user) : ($value->to_user); ?>" style="float:right; color:red; font-size: 16px"></i>
                </div>
                <?php
                }
                }
                ?>

            </div>


            <div class="message-wrap col-lg-8" id="content-messages" >
                <div class="msg-wrap">

                </div>

            </div>
        </div>

    </div>


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.messages').click(function () {
            var to_user = $(this).attr('id');
            alert(to_user)
//            var to_useremail = $(this).attr('useremail');
//            var useremail = $('.user_name').attr('currentuseremail');
//            var username = $('.user_name').attr('id');
//            var token = $("input[name=_token]").val();
//            $.ajax({
//                url: '/sendmessagestoemail',
//                type: 'POST',
//                data: {_token: token, to_user: userId, to_useremail: to_useremail, useremail: useremail, username: username},
//                success: function (data) {
//                    return true;
//
//                }
//            });

        });


        $('.create_chat').click(function () {
            $('.send-message').removeAttr('disabled');
            $('.fileinput').removeAttr('disabled');
            $('.mailbutton').removeAttr('disabled');
            $('.send-message').val('');
            $('.smiles').css('display', 'block');
            var useremail = $(this).attr('useremail');
            var currentuser = $(this).attr('data_user');
            var userId = $(this).val();
            $('.mailbutton').attr('userid', userId);
            $('.mailbutton').attr('useremail', useremail);
            $('.send-message').attr('senduser', userId);
            $('#usernotsee_' + userId).text('');
            var mydiv = $('.msg-wrap');
            var current_user = $('#content-messages').attr('data-current-user');
            var send_user = $('#content-messages').attr('data-send-user', userId);
            $.ajax({
                url: '/user_messagesadmin/',
                type: 'GET',
                data:{'currentuser':currentuser,'userId':userId},
                success: function (data) {

                    var html = '<div id="message_count" data-count=' + data.count_messages + '>Count Messages' + ' ' + data.count_messages + '</div>';
                    if (data.getMessages.length > 0) {
                        var images = '';
                        $.each(data.getMessages, function (key, value) {

                                if (value.images !== null) {
                                    images = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                                } else {
                                    images = '';
                                }

                                html += '<div class="media msg id_' + value.chat_id + ' ">' +
                                        '<div class="media-body">' +
                                        '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                        '<h5 class="to_user ">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                        '<small class="col-lg-10" id="msg_' + value.chat_id + '">' + value.content + '</small>' +
                                        '<small class="col-lg-10">' + images + '</small>' +
//                                        '<span class="glyphicon glyphicon-trash delete_msg btn" id =' + value.chat_id + ' ></span> &nbsp'+


                                        '</div>' +
                                        '</div>';
                            if (value.from_user == current_user) {
                                if (value.images !== null) {
                                    images = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                                } else {
                                    images = '';
                                    html += '<div class="media msg id_' + value.chat_id + ' ">' +
                                            '<div class="media-body">' +
                                            '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                            '<h5 class="media-heading">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                            '<small class="col-lg-10" id="msg_' + value.chat_id + '">' + value.content + '</small>' +
                                            '<small class="col-lg-10">' + images + '</small>' +
//                                            '<span class="glyphicon glyphicon-trash delete_msg btn" id =' + value.chat_id + ' ></span> &nbsp'+
//                                            '<span type="button"  class="glyphicon glyphicon-wrench update_msg update_msg btn" data-toggle="modal" id =' + value.chat_id + ' data-target="#myModal"></span>'+
                                            '</div>' +
                                            '</div>';
                                }


                            }
                        })
                    }
                    $('.msg-wrap').html(html);
                    mydiv.scrollTop(mydiv.prop('scrollHeight'));
                }

            });
        });

    });

</script>
