@extends('layouts.app')
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="myProfilTable">
    <h3>{{ trans('translate.account_settings') }}</h3>
    <form  method="post" action="{{route('updatedata')}}">   
        {{ csrf_field() }}
        <table class="table table-hover">

            <tr>
                <td>{{ trans('translate.firstname') }}</td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="first_name" value="<?php echo Auth::user()->first_name; ?>">
                    </div>
                </td>
                <td>
                    <button type="submit" class="btn btn-link" name="update" >{{ trans('translate.update') }}</button>
                </td>
            </tr>
            <tr>
                <td>{{ trans('translate.lastname') }}</td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="last_name" value="<?php echo Auth::user()->last_name; ?>">
                    </div>
                </td>
                <td>
                    <button type="submit" class="btn btn-link" name="update" >{{ trans('translate.update') }}</button>
                </td>
            </tr>

            <tr>
                <td>{{ trans('translate.email') }}</td>
                <td>
                    <div class="col-xs-9">
                        <input type="email" class="form-control" name="email" value="<?php echo Auth::user()->email; ?>">
                    </div>
                </td>
                <td>
                    <button type="submit" class="btn btn-link" name="update" >{{ trans('translate.update') }}</button>
                </td>
            </tr>
            <tr>
                <td>{{ trans('translate.birthday') }}</td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control datepickerrrr" name="birthday" value="<?php echo Auth::user()->birthday; ?>">
                    </div>
                </td>
                <td>
                    <button type="submit" class="btn btn-link" name="update" >{{ trans('translate.update') }}</button>
                </td>
            </tr>  
        </table>
    </form><br>

    <h3>{{ trans('translate.change_password') }}</h3>
    <table class="table table-hover">
        <tr>
            <td>{{ trans('translate.password') }}</td>
            <td>
                <div class="col-xs-9">
                    <input type="password" class="form-control" name="password">
                </div>
            </td>
            <td>
                <button type="submit" class="btn btn-link" name="updatepass" >{{ trans('translate.update') }}</button>
            </td>
        </tr>
    </table><br>

    <span class="deleteAccount">
        {{ csrf_field() }}
        <button type="submit" name="deleteAccount" class="btn btn-default">{{ trans('translate.delete_account') }}</button>
    </span>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.datepickerrrr').datepicker({format: 'mm/dd/yyyy', });
    });
</script>
@endsection
