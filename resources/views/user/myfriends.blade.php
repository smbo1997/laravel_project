@extends('layouts.app')

@section('content')
 {{ csrf_field() }}
<?php
if (!empty($friendRequest)) {
    foreach ($friendRequest as $key => $value) {
        ?>
        <div class="profile"> 
            <p class="name" ><a href="<?php echo  url('/'.$language.'/user_profile/' . $value->from_user . ''); ?>"><?php echo $value->first_name . ' ' . $value->last_name; ?></a></p>
            <img  width="100px" height="100px" src="<?php echo (!empty($value->image)) ? url('/users_image/user_' . $value->from_user . '/general/' . $value->image) : url('/users_image/avatar.png'); ?>"><br>
            <br><br>
            <span>
                <button class="btn btn-default friend" value="<?php echo $value->table_id; ?>">Add</button>
                <button class="btn btn-default del-friend" value="<?php echo $value->table_id; ?>">Delete</button>
            </span>
        </div>

        <?php
    }
}
?>

<h1 class="Friends">{{ trans('translate.friends') }}</h1>
<hr>
<div id="frend-div">
    <table class="FriendTB"> 
        <tr>
            <?php
            if (!empty($user_friends)) {
                foreach ($user_friends as $key => $value) {
                    ?>
                    <td>
                        <img  width="100px" height="100px" src="<?php echo (!empty($value->image)) ?url('users_image/user_' . $value->id . '/general/' . $value->image)   : url('users_image/avatar.png'); ?>">
                        <p class="name">
                            <a href="<?php echo (Auth::user()->id == $value->to_user) ? url($language . '/user_profile/' . $value->from_user) : url($language . '/user_profile/' . $value->to_user); ?>">
                                <?php echo $value->first_name . ' ' . $value->last_name; ?>
                            </a>
                        </p>
                        <button type="button" class="btn btn-link chat-box <?php echo "user_";
                        echo(Auth::user()->id == $value->to_user) ? ($value->from_user) : ($value->to_user);
                                ?>"  user="0" value="<?php echo (Auth::user()->id == $value->to_user) ? ($value->from_user) : ($value->to_user); ?>" user-name="<?php echo $value->first_name . ' ' . $value->last_name; ?>" current_user="<?php echo Auth::user()->id; ?>">Send message</button>
                    </td>
                    <?php
                }
            }
            ?>
        </tr>
    </table>
</div>
@endsection