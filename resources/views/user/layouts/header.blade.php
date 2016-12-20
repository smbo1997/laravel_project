<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>My Social Site</title>
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon"/>
        <link href="{{URL::asset('css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/round-about.css')}}" rel="stylesheet">
        <link  href="{{URL::asset('css/dataTables.bootstrap.min.css')}}"rel="stylesheet">
        <link href="{{URL::asset('css/bootstrap-social.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{URL::asset('fancybox/jquery.fancybox.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/select2.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/bootstrap-theme.min.css')}}" rel="stylesheet">
          <link href="{{URL::asset('css/stayle_users.css')}}" rel="stylesheet">
        <!-- js files -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/scripts.js')}}"></script>
        <script src="{{URL::asset('js/dropdown.js')}}"></script>
        <script src="{{URL::asset('fancybox/jquery.fancybox.js')}}"></script>
        <script src="{{URL::asset('fancybox/jquery.mousewheel-3.0.6.pack.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/fancybox.js')}}"></script>
        <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>

    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="fe">My Social Site</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="lang-div">
                        <ul>
                            <li><a href="sf"><img src="{{URL::asset('/image/en.gif')}}"></a></li>
                            <li><a href="df"><img src="{{URL::asset('/image/ru.gif')}}"></a></li>
                            <li><a href="fd"><img src="{{URL::asset('/image/hy.gif')}}"></a></li>
                        </ul>
                    </div>

                    <?php
                    echo "<ul class='nav navbar-nav'>";
                    echo "<li><a class='top-class' href='/welcome/login'>My page</a></li>";
                    echo "</ul>";
                    ?>        
                </div>
            </div>
        </nav>