@extends('layouts.app')
@section('content')
<div class="container" style='width: 1049px;'>
    <div class="row">
        <div class="profImage col-md-5">
            <a class="ddd" href="<?php echo (!empty(Auth::user()->image)) ? url('/users_image/user_' . Auth::user()->id . '/general/' . Auth::user()->image) : url('/users_image/avatar.png'); ?>">
                <img src="<?php echo (!empty(Auth::user()->image)) ? url('/users_image/user_' . Auth::user()->id . '/general/' . Auth::user()->image) : url('/users_image/avatar.png'); ?>" width="200px">
            </a>
            <span class="usersName"><?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name ?></span>
        </div>
        <div>
            <form method="post" action="{{route('generalimageupload')}}" enctype="multipart/form-data" class="gnimage">
                {{ csrf_field() }}
                <div class="form-group">
                    <p class ="gntext"> {{ trans('translate.general_image_uploader') }}</p>
                    <span class="btn btn-default btn-file gnfile ">
                        <img src="/image/add.png" title="General image"><input  class="form-control" type="file" name="userfile" title=" add General image"/>
                    </span>
                    <button type="submit"  class="btn btn-success btngnimage">{{ trans('translate.upload') }}</button>
                </div>
            </form>
        </div>
        <div style="clear: both; margin-left: 300px">
            <div class="actions">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#pg1" data-toggle="tab" >{{ trans('translate.information') }}</a></li>
                    <li><a href="#pg2" data-toggle="tab">{{ trans('translate.images') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="tab-pane fade in active" id="pg1"> 
        <div class="myProfilTable">
            <h3>{{ trans('translate.account_information') }}</h3>
            <table class="table table-responsive Infotable">
                <tr>
                    <td>Firstname</td>
                    <td>
                        <div class="col-xs-9">
                            <p><?php echo Auth::user()->first_name; ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Lastname</td>
                    <td>
                        <div class="col-xs-9">
                            <p><?php echo Auth::user()->last_name; ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td>
                        <div class="col-xs-9">
                            <p><?php echo Auth::user()->birthday; ?></p>
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
