@extends('layouts.app')

@section('content')
{{ csrf_field() }}

<div class="container">
    <div class="mail-box">
        <aside class="sm-side">
            <div class="user-head">
                <a class="inbox-avatar" href="javascript:;">
                    <img  width="64" hieght="60" src="<?php echo (!empty(Auth::user()->image)) ? url('users_image/user_' . Auth::user()->id . '/general/' . Auth::user()->image) : url('users_image/avatar.png'); ?>">
                </a>
                <div class="user-name">
                    <h5 class="fromname" id="<?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name ?>" firstname="<?php echo Auth::user()->first_name; ?>" lastname="<?php echo Auth::user()->last_name; ?>"><a href="#"><?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name ?></a></h5>
                    <span class="fromEmail" id="<?php echo Auth::user()->email; ?>"><a href="#" class="maildata" mail="<?php echo Auth::user()->email; ?>"><?php echo Auth::user()->email; ?></a></span>
                </div>
                <a class="mail-dropdown pull-right" href="javascript:;">
                    <i class="fa fa-chevron-down"></i>
                </a>
            </div>

        </aside>              
        <aside class="lg-side">
            <div class="inbox-body">
                <div class="modal-body">
                    <div>
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3" class="control-label">To:</label>
                                <div class="col-md-9">
                                    <select class="js-example-basic-multiple" multiple="multiple" style="width:100%">
                                        <?php
                                        if (!empty($user_friends)) {
                                            
                                           // echo '<pre>';
                                                //print_r($user_friends);die;
                                            foreach ($user_friends as $key => $value) {
                                                ?>
                                                <option title="<?php echo $value->email; ?>"><?php echo $value->first_name;?></option>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3" class="control-label">Subject:</label>
                                <div class="col-md-9">
                                    <input class="typeahead form-control subject" type="text" placeholder="Subject" data-provide="typeahead"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3" class="control-label">Mail content:</label>
                                <div class="col-md-9">
                                    <div class="">
                                        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                                            <div class="btn-group">
                                                <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                                                <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                                                <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                                                <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                                            </div>

                                            <div class="btn-group">
                                                <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                                                <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                                            </div>

                                            <!--<div class="btn-group">
                                                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary addtemplate"><span class="glyphicon glyphicon-plus"></span>Add template</button>
                                                <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                  
                                                </ul>
                                            </div>-->
                                        </div>

                                        <div id="editor" class="content mailcontent">--<br/>
                                            <?php echo Auth::user()->first_name . ' ' . Auth::user()->last_name ?>
                                        </div>
                                        <div style="display:none;" class="cssstyles"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sendemail">Send</button>
                </div>
            </div>
        </aside>
    </div>
</div>



<script src="{{URL::asset('js/select2.min.js')}}"></script>
<script src="{{URL::asset('js/sendEmail.js')}}"></script>
<script src="{{URL::asset('js/hotkeys.js')}}"></script>
<script src="{{URL::asset('js/mail.js')}}"></script>
<script src="{{URL::asset('js/mindmup.js')}}"></script>
<script type="text/javascript">
$(".js-example-basic-multiple").select2({});
</script>

@endsection