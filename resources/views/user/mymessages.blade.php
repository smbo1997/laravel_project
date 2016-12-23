@extends('layouts.app')

@section('content')
{{ csrf_field() }}
<div class="container">

    <div class="row">
        <div class="user_name" userid="<?php echo Auth::user()->id; ?>" currentuseremail="<?php echo Auth::user()->email; ?>" id="<?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name; ?>"><?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name; ?></div>
        <div class="conversation-wrap col-lg-3">

            <?php
            if (!empty($user_friends)) {
                foreach ($user_friends as $key => $value) {
                    ?>
                    <div class="media conversation friends">
                        <a class="pull-left" href="<?php echo ($userId == $value->to_user) ? url($language . '/user_profile/' . $value->from_user) : url($language . '/user_profile/' . $value->to_user); ?>">
                            <img  width="100px" height="100px" src="<?php echo (!empty($value->image)) ? url('/users_image/user_' . $value->from_user . '/general/' . $value->image) : url('/users_image/avatar.png'); ?>" style="width:50px; height: 50px">
                        </a>
                        <i id="online_user_<?php echo ($userId == $value->to_user) ? ($value->from_user) : ($value->to_user); ?>" class="online"></i>
                        <div class="media-body">
                            <h5 class="media-heading"> <?php echo $value->first_name . ' ' . $value->last_name; ?></h5>
                            <small> <button type="button" class="btn btn-link create_chat"
                                            id="user_<?php echo ($userId == $value->to_user) ? ($value->from_user) : ($value->to_user); ?>"
                                            value="<?php echo ($userId == $value->to_user) ? ($value->from_user) : ($value->to_user); ?>"
                                            useremail="<?php echo $value->email;?>">Send message</button>
                            </small>
                        </div>
                        <i id="usernotsee_<?php echo ($userId == $value->to_user) ? ($value->from_user) : ($value->to_user); ?>" style="float:right; color:red; font-size: 16px"></i>
                    </div>
                    <?php
                }
            }
            ?>

        </div>


        <div class="message-wrap col-lg-8" id="content-messages" data-current-user="<?php echo Auth::user()->id; ?>">
            <div class="msg-wrap">

            </div>
            <div class="send-wrap ">
                <div class="smiles" style="display:none" ></div>
                <textarea class="form-control send-message"   rows="3" placeholder="Write a Reply..." disabled="disabled">
                </textarea>
                <div class="smile_box" style="display:none">
                    <table>
                        <tr>
                            <td><img  src="/smile/1.gif" class="button" smile=":H"></td>
                            <td><img  src="/smile/4.gif" class="button" smile=":C"></td>
                            <td><img  src="/smile/3.gif" class="button" smile=":)"></td>
                            <td><img  src="/smile/2.gif" class="button" smile=":A"></td>
                        </tr>
                        <tr>
                            <td><img  src="/smile/7.gif" class="button" smile=":D"></td>
                            <td><img  src="/smile/6.gif" class="button" smile=":("></td>
                            <td><img  src="/smile/5.gif" class="button" smile=":X"></td>
                            <td><img  src="/smile/8.gif" class="button" smile=":J"></td>
                        </tr>
                        <tr>
                            <td> <img  src="/smile/12.gif" class="button" smile=":Q"></td>
                            <td><img  src="/smile/11.gif" class="button" smile=":B"></td>
                            <td><img  src="/smile/9.gif"  class="button" smile=":L"></td>
                            <td><img  src="/smile/20.gif" class="button" smile=":o"></td>
                        </tr>
                        <tr>
                            <td><img  src="/smile/18.gif" class="button" smile=":E"></td>
                            <td> <img  src="/smile/13.gif" class="button" smile=":R"></td>
                            <td><img  src="/smile/15.gif" class="button" smile=":W"></td>
                            <td><img  src="/smile/14.gif" class="button" smile=":K"></td>
                        </tr>
                        <tr>
                            <td><img  src="/smile/10.gif" class="button" smile=":G"></td>
                            <td><img  src="/smile/17.gif"  class="button" smile=":F"></td>
                            <td> <img  src="/smile/19.gif" class="button" smile=":P"></td>
                            <td><img  src="/smile/16.gif" class="button" smile=":Z"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="btn-panel" style="padding: 7px;">
                <button type="button" class="btn btn-success mailbutton" style="float:right; right: 10px;" disabled="disabled">Send all messages to Email</button>
                <form>
                    {{ csrf_field() }}
                    <span class="btn btn-default btn-file gnfile" style="width:90px;">
                        <img src="/image/add.png" title="image" style="margin: 0 auto;"><input class="form-control fileinput" type="file" name="userfile" id="image" title="add new image" disabled="disabled">
                    </span>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Msg</h4>
                </div>
                <p class="modal-body" contenteditable>

                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_my_msg" data-dismiss="modal">Update Msg</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('js/my_message.js')}}"></script>
@endsection