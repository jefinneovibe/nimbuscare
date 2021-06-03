@extends('layouts.app')
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Interactive Insurance Brokers LLC</title>

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/normalize.css')}}"><!-- Normalize CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" /><!-- Material Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"><!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/material-kit.css?v=2.0.3')}}" /><!-- Material Kit CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}"><!-- Main CSS -->
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">

</head>
<body>
<main class="login_sec">
    <div class="table_cell">
        <div class="login_main">
            <div class="login_logo">
                <img src="{{ URL::asset('img/main/interactive_logo.png')}}">
            </div>
            <?php $route_name=Route::currentRouteName();
          ?>
            <h1 class="title">Please Login</h1>
                @if(session('error'))
                    <span class="error">{{session('error')}}</span>
                @endif
            <form class="form-horizontal" method="POST" @if($route_name=='login') action="{{url('/login')}}" @else action="{{url('/dispatch/dispatch-login')}}" @endif id="loginForm" name="loginForm">
                {{ csrf_field() }}
                <div class="login_wrap">
                    <div class="form_group">
                        <label class="form_label">Enter Email Id <span>*</span></label>
                        <input class="form_input" name="email" placeholder="Email ID" type="text" id="email">
                        @if($errors->has('email'))
                            <span class="error">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form_group">
                        <label class="form_label">Enter Password <span>*</span></label>
                        <input class="form_input" name="password" placeholder="*****************" type="password" id="password">
                        @if($errors->has('password'))
                            <span class="error">{{$errors->first('password')}}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn-round submit_btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</main>
@push('scripts')

<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>

<script>
    /*
    * Function For validating the login Form*/
    $.validator.addMethod("customemail",
        function(value, element) {
            value= value.trim();
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        },
        "Please enter a valid email id. "
    );
    $('#loginForm').validate({

        ignore:[],
        rules:{
            email:{
                // depends: function(){
                //             $(this).val($.trim($(this).val()));
                //             return true;
                //         },
                required: true,
                customemail:true
            },
            password:{
                required: true,
                minlength: 6
            },
        },
        messages:{
            email:{
                required:"Please enter email.",
                customemail:"Please enter valid email."
            },
            password: {
                required:"Please enter password.",
                minlength:"Password must contain atleast 6 characters"
            }
        }

    });
    $(document).ready(function(){
        sessionStorage.clear();
    });

</script>
    @endpush
</body>
</html>