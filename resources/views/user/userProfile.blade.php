@extends('layouts.app')
@section('content')
<div class="container" style='width: 1049px;'>
    <div class="row">
        <div class="profImage col-md-5">
            <a class="ddd" href="<?php echo (!empty($user->image)) ? url('/users_image/user_' . $user->id . '/general/' . $user->image) : url('/users_image/avatar.png'); ?>">
                <img src="<?php echo (!empty($user->image)) ? url('/users_image/user_' . $user->id . '/general/' . $user->image) : url('/users_image/avatar.png'); ?>" width="200px">
            </a>
            <span class="usersName"><?php echo $user->first_name . ' ' . $user->last_name ?></span>
        </div>
        <div style="clear: both; margin-left: 300px">
            <div class="actions">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#pg1" data-toggle="tab" >Information</a></li>
                    <li><a href="#pg2" data-toggle="tab">Images</a></li>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.ddd').fancybox();
    });
</script>
@endsection
