@extends('layouts.app')
@section('content')
<div class = "search">
     {{ csrf_field() }}
    <table class = "table table-condensed">
        <?php
        if (!empty($users)) {
            foreach ($users as $key => $value) {
                        ?>
                <tr> 
                    <td>
                        <h5>               
                            <a href="<?php echo url('/' . $language . '/user_profile/' . $value->id); ?>">
                                <img  width="100px" height="100px" src="<?php echo (!empty($value->image)) ? url('/users_image/user_' . $value->from_user . '/general/' . $value->image) : url('/users_image/avatar.png'); ?>">
                                <?php echo $value->first_name . ' ' . $value->last_name; ?>
                            </a>
                        </h5>
                    </td>
                    <td>
                        <?php if (($value->from_user == Auth::user()->id && $value->status == 0) || ($value->to_user == Auth::user()->id && $value->status == 0 )) { ?>
                        <button class="btn btn-primary" style="margin-top: 43px;"  value="<?php echo $value->id; ?>" id="primary_<?php echo $value->id; ?>" disabled="disabled">Request is done</button>
                            <?php
                        } else
                        if (($value->from_user == Auth::user()->id && $value->status == 1) || ($value->to_user == Auth::user()->id && $value->status == 1 )) {
                            ?> <button class="btn btn-success search-del-friend" style="margin-top: 43px;" value="<?php echo $value->table_id; ?>" id="search-del-friend_<?php echo $value->table_id; ?>">Remove From Friend List</button>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-default add_friend" style="margin-top: 43px;" value="<?php echo $value->id; ?>" id="addFriend_<?php echo $value->id; ?>">Add friend</button>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            echo '</table>';
            echo '</div>';
        } else {
            ?>
            <div class="result">No Results</div>
            <?php
        }
        ?>
        @endsection