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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"><!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="{{ URL::asset('css/main/material-kit.css?v=2.0.3')}}" /><!-- Material Kit CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/main.css?v3')}}"><!-- Main CSS -->
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
    <script>
            <?php date_default_timezone_set("Asia/Dubai"); $date = date('Y/m/d H:i:s') ?>
        var d = new Date("<?php echo $date ?>");
        function digitalClock() {
            d.setTime(d.getTime() + 1000);
            var hrs = d.getHours();
            var mins = d.getMinutes();
            var secs = d.getSeconds();
            mins = (mins < 10 ? "0" : "") + mins;
            secs = (secs < 10 ? "0" : "") + secs;
            var ctime = hrs + ":" + mins + ":" + secs + " ";
            document.getElementById("clock").firstChild.nodeValue = ctime;
        }
        window.onload = function() {
            digitalClock();
            setInterval('digitalClock()', 1000);
        }
    </script>
</head>
<body>

<!-- Loader -->
<div id="preLoader">
    <div class="loader">
        <svg>
            <defs><filter id="goo"><feGaussianBlur in="SourceGraphic" stdDeviation="2" result="blur" /><feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" /><feComposite in="SourceGraphic" in2="gooey" operator="atop"/></filter></defs>
        </svg>
    </div>
</div>

@section('sidebar')
    @include('includes.sidebar_dispatch')
@show
<!--//END Loader -->
<main class="layout_content">
    <!-- Header -->
    <header class="layout_header">
        <button class="drawer-button" id="open-button">
            <span class="nav_icon"></span>
        </button>

        <div class="header_row">
            <span class="layout_title">Interactive LLC</span>
            {{--<div class="layout_spacer" style="text-align: center"><span style="font-weight: bold">{{\Illuminate\Support\Facades\Auth::user()->Dispatcher['name']}}</span></div>--}}
            <div class="layout_spacer">
                <div class="timer">
                    <i class="fa fa-clock-o"></i>
                    <span style="float: right" id="clock">

                </span>
                </div>
            </div>
            <div class="right_action">
                <ul>
                    <li class="dropdown nav-item user_drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user_name">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                            <span class="user_ico">{{\Illuminate\Support\Facades\Auth::user()->name[0]}}</span>
                            <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item auto_modal" data-modal="change_password_popup"  onclick="clickChangePassword();">Change Password</a>
                            <a href="{{url('logout')}}" class="dropdown-item">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </header><!--//END Header -->

    {{--change password popup--}}
    <div id="change_password_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" name="change_password_form" id="change_password_form">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                        <div class="content_spacing">
                            <div class="alert alert-danger" role="alert" id="password_error" style="display: none">
                                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                                Incorrect Old Password
                            </div>
                            <div class="alert alert-success alert-dismissible" role="alert" id="password_success" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Password updated successfully.
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label">Old Password <span>*</span></label>
                                                <input class="form_input" name="old_password" id="old_password" placeholder="Old Password"  type="password">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label">New Password <span>*</span></label>
                                                <input class="form_input" name="new_password1" id="new_password1" placeholder="New Password" type="password">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label">Confirm Password <span>*</span></label>
                                                <input class="form_input" name="confirm_password1" id="confirm_password1" placeholder="Confirm Password" type="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel" type="button">Cancel</button>
                        <button class="btn btn-primary btn_action" id="change_password_button" type="submit" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end change password popup--}}

    <!-- Main Content -->
    <div class="page_content">
        @yield('content')
    </div><!--//END Main Content -->
</main>

<div class="overlay_filter"></div>
@include('includes.modals')
@include('includes.js-scripts')
<script>
    $('#password_error .close').click(function(){
    $('#password_error').hide();   
});
    //update password form validation//
    $("#change_password_form").validate({
        ignore: [],
        rules: {
            old_password: {
                required: true,
                minlength: 6
            },
            new_password1: {
                required: true,
                minlength: 6
            },
            confirm_password1: {
                required: true,
                minlength: 6,
                equalTo : "#new_password1"
            }
        },
        messages: {
            old_password:{
                required: "Please enter old password.",
                minlength: "Password must contain atleast 6 characters."
            },
            new_password1:{
                required: "Please enter new password.",
                minlength: "Password must contain atleast 6 characters."
            },
            confirm_password1:{
                required: "Please re-enter new password.",
                minlength: "Password must contain atleast 6 characters.",
                equalTo: "Confirm password must equal to new password."
            }
        },
        errorPlacement: function (error, element)
        {
            if(element.attr("name") == "role"){
                error.insertAfter(element.parent());
            }else{
                error.insertAfter(element);
            }
        },
        submitHandler: function (form,event) {
            var form_data = new FormData($("#change_password_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
//            $("#change_password_button").attr( "disabled", "true" );
            $.ajax({
                method: 'post',
                url: '{{url('dispatch/change-password')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
//                    $("#change_password_button").attr( "disabled", "false" );
                    if(result.success == true){
                        $('#password_error').hide();
                        $('#password_success').show();
                        $('#old_password').val('');
                        $('#new_password1').val('');
                        $('#confirm_password1').val('');
                        $('#old_password').val('');
                    }else{
                        $('#password_success').hide();
                        $('#password_error').show();
                    }
                }
            });
        }

    });
    //end//

    function clickChangePassword() {
        $('#password_success').hide();
        $('#password_error').hide();
    }

    $('.po__trigger--center').click(function (){
        $('.overlay_filter').addClass('active');
    });
    $('.popover_cancel').click(function (){
        $('.overlay_filter').removeClass('active');
        $('.po__layer.list').removeClass('is-active');
    });
    $('.overlay_filter').click(function (){
        $('.overlay_filter').removeClass('active');
        $('.po__layer.list').removeClass('is-active');
    });
</script>
<style type="text/css">
    a:hover {
        cursor:pointer;
    }
</style>
</body>
</html>

