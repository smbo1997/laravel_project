<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Sign-Up/Login</title>
        <link href='{{URL::asset('css/fonts.css')}}' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="{{URL::asset('css/normalize.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker.css')}}">
        <link rel="stylesheet" href="{{URL::asset('css/bootstrap-datepicker.min.css')}}">
        <link  href="{{URL::asset('css/bootstrap.min.css')}}"rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">


    </head>

    <body>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form">

            <ul class="tab-group">
                <li class="tab active"><a href="#login">Log In</a></li>
                <li class="tab"><a href="#signup">Sign Up</a></li>
            </ul>
            <div class="tab-content">
                <div id="login">   
                    <h1>Welcome Back!</h1>

                    <form action="{{route('login')}}" method="post">

                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email"required autocomplete="off" name="email"/>
                        </div>

                        <div class="field-wrap">
                            <label>
                                Password<span class="req">*</span>
                            </label>
                            <input type="password"required autocomplete="off" name="password"/>
                        </div>
                        <p class="forgot"><a href="#forgotpassword">Forgot Password?</a></p>
                        <button class="button button-block"/>Log In</button>
                        {{ csrf_field() }}
                    </form>

                </div>

                <div id="signup">   
                    <h1>Sign Up for Free</h1>

                    <form action="{{route('adduser')}}" method="post">

                        <div class="top-row">
                            <div class="field-wrap">
                                <label>
                                    First Name<span class="req">*</span>
                                </label>
                                <input type="text" required autocomplete="off" name='first_name'/>
                            </div>

                            <div class="field-wrap">
                                <label>
                                    Last Name<span class="req">*</span>
                                </label>
                                <input type="text"required autocomplete="off" name='last_name'/>
                            </div>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email"required autocomplete="off" name='email'/>
                        </div>
                        <div class="field-wrap datepicker">
                            <input type="text"required autocomplete="off" name='birthday' placeholder="Birthday"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Set A Password<span class="req">*</span>
                            </label>
                            <input type="password"required autocomplete="off" name='password'/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Confirm Password<span class="req">*</span>
                            </label>
                            <input type="password"required autocomplete="off" name="password_confirmation"/>
                        </div>
                        <div class="field-wrap">
                            <select class="gender" name="gender">
                                <option id="Male" value="Male">Male</option>
                                <option id="FeMale" value="Female">Female</option>
                            </select>
                        </div>

                        <button type="submit" class="button button-block"/>Get Started</button>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    </form>
                </div>
            </div><!-- tab-content -->

        </div> <!-- /form -->
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datepicker.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
        <script src="{{URL::asset('js/index.js')}}"></script>
        <script src="{{URL::asset('js/datapicker.js')}}"></script>

    </body>
</html>
