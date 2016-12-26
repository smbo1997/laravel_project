<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon"/>
        <link href="{{URL::asset('css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/chatDesign.css')}}" rel="stylesheet">
        <link  href="{{URL::asset('css/dataTables.bootstrap.min.css')}}"rel="stylesheet">
        <link href="{{URL::asset('css/bootstrap-social.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/bootstrap-datepicker.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{URL::asset('fancybox/jquery.fancybox.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/select2.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/bootstrap-theme.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/stayle_users.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/mail.css')}}" rel="stylesheet">
        <link href="{{URL::asset('css/small-chat.css')}}" rel="stylesheet">
    </head>

    <!-- Scripts -->
    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script>
window.Laravel = <?php
echo json_encode([
    'csrfToken' => csrf_token(),
]);
?>
    </script>
</head>
<body>
<?php
$action = explode("@", Route::currentRouteAction());
$current_action = $action[count($action)-1];

//kam senc

//$geturl = Request::path();
//$current_action = substr($geturl, 3);
 ?>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/' . $language) }}/home">
                        {{ trans('translate.laravel') }}
                    </a>
                    @if (!Auth::guest())
                    <a class="navbar-brand" href="{{ url('/' . $language) }}/myprofile">
                        {{ trans('translate.my_profile') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/' . $language) }}/myimages">
                        {{ trans('translate.my_images') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/' . $language) }}/myfriends">
                        {{ trans('translate.my_friends') }}
                    </a>
                    <a class="navbar-brand messageread" id="<?php echo Auth::user()->id; ?>" href="{{ url('/' . $language) }}/mymessages">
                        <i class="notread" ></i>
                        {{ trans('translate.my_messages') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/' . $language) }}/mymail">
                        {{ trans('translate.my_mail') }}
                    </a>
                        <ul class="nav navbar-nav">
                            &nbsp;<li>
                                <a href={{url("/en/$current_action")}}><img src="../image/en.gif" alt=""></a>
                            </li>
                            <li>
                                <a href={{url("/am/$current_action")}}><img src="../image/hy.gif" alt=""></a>
                            </li>
                            <li>
                                <a href={{url("/ru/$current_action")}}><img src="../image/ru.gif" alt=""></a>
                            </li>
                        </ul>

                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->

                    <!--  <div class="language"> 
                           <a href="/en/"><img src="/public/image/en.gif"></a>
                           <a href="/ru/"><img src="/public/image/ru.gif"></a>
                       </div>-->
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="<?php echo '/' . $language; ?>/login">Login</a></li>
                        <li><a href="<?php echo '/' . $language; ?>/register">Register</a></li>

                        @else

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo '/' . $language; ?>/settings">
                                        {{ trans('translate.settings') }}
                                    </a>
                                    <a href="<?php echo '/' . $language; ?>/logout"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        {{ trans('translate.logout') }}
                                    </a>




                                    <form id="logout-form" action="<?php echo '/' . $language; ?>/logout" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>


                        @endif
                    </ul>
                </div>

            </div>
        </nav>

        @yield('content')
        <div id="chat"></div>
    </div>

    <!-- js files -->
    <script src="{{URL::asset('js/scripts.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap-datepicker.js')}}"></script>
    <script src="{{URL::asset('js/dropdown.js')}}"></script>
    <script src="{{URL::asset('fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{URL::asset('fancybox/jquery.mousewheel-3.0.6.pack.js')}}"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/fancybox.js')}}"></script>
    <script src="{{URL::asset('js/ajax.js')}}"></script>
    <script src="{{URL::asset('js/datapicker.js')}}"></script>
    <script src="{{URL::asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('js/small-chat.js')}}"></script>
    <script src="{{URL::asset('js/messagenotread.js')}}"></script>
</body>
</html>
