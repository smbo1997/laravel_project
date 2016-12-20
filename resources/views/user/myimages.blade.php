@extends('layouts.app')
@section('content')
<form method="post" action="{{route('addimages')}}" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <div class="formgroup">
        <span class="btn btn-default btn-file gnfile">
            <img src="/image/add.png" title="image"><input class="form-control" type="file" name="userfile" title="add new image"/>
        </span>
        <button type="submit" name="upload" class="btn btn-success btngnimageup">{{ trans('translate.upload') }}</button>
    </div>
</form>
<div>
    <ul class="friendsImageulprofile">
        <?php
        if (empty(!$userimages)) {
            foreach ($userimages as $key => $value) {
                ?>
                <li class="friendsImage">
                    <a class="fancybox imglink" data-fancybox-group="gallery" href="<?php echo url('/users_image/user_' . $value->user_id . '/' . $value->image); ?>">
                        <img width='205px' height='205px' src="<?php echo url('/users_image/user_' . $value->user_id . '/' . $value->image); ?>" >
                    </a>
                    <a href='<?php echo url($language.'/deleteUserimage/' . $value->id); ?>'>{{ trans('translate.delete') }}</a> |
                    <a href = '<?php echo url($language.'/downloaUserImage/' . $value->id); ?>' >{{ trans('translate.download') }}</a>
                </li>
                <?php
            }
        } else {
            echo "<h3 class='result'>No Images</h3>";
        }
        ?>
    </ul>
</div>
@endsection('content')