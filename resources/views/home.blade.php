@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h2 class="username"><?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name; ?></h2>
        <div class="form-group">
            <div class="col-sm-4">
                <input class="form-control searchUsers" placeholder="Search users" type="text" autocomplete="off" name="<?php echo $language;?>"   />
            </div>
            <div class="col-sm-4" style="clear:both">
                <div class = "search" style="display:none;">
                    <table class = "table table-condensed addusersintable">
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
