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

<!-- Loader -->
<div id="preLoader">
    <div class="loader">
        <svg>
            <defs><filter id="goo"><feGaussianBlur in="SourceGraphic" stdDeviation="2" result="blur" /><feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" /><feComposite in="SourceGraphic" in2="gooey" operator="atop"/></filter></defs>
        </svg>
    </div>
</div>
<!--//END Loader -->

<!-- Sidebar Nav -->
<div class="menu-wrap">
    <div class="sidebar_logo">
        <img src="{{URL::asset('img/main/interactive_logo.png')}}">
    </div>

    <nav class="menu">
        <div class="menu-list">
            <a href="{{ url('insurer/dashboard') }}" {{ Request::is('insurer/dashboard') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Dashboard</span>
            </a>

            <ul class="sub_nav">
                <li><a href="{{ url('insurer/e-quotes-provider') }}" {{ Route::current()->getName() == 'equoteprovided' ? 'class=active' : '' }}>E-quotes to be Provided</a></li>
                <li><a href="{{url('insurer/equotes-given')}}" {{ Route::current()->getName() == 'equotesgiven' ? 'class=active' : '' }}>E-quotes Given</a></li>
            </ul>
        </div>
    </nav>
</div><!--/END Sidebar Nav -->

<main class="layout_content">
    <!-- Header -->
    <header class="layout_header">
        <button class="drawer-button" id="open-button">
            <span class="nav_icon"></span>
        </button>

        <div class="header_row">
            <span class="layout_title">Interactive LLC</span>
            <div class="layout_spacer" style="text-align: center"><span style="font-weight: bold">{{\Illuminate\Support\Facades\Auth::user()->insurer['name']}}</span></div>
            <div class="right_action">
                <ul>
                    <li class="dropdown nav-item user_drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user_name">{{\Illuminate\Support\Facades\Auth::user()->insurer['name']}}</span>
                            {{-- <span class="user_name">{{\Illuminate\Support\Facades\Auth::user()->name}}</span> --}}
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
                url: '{{url('insurer/change-password')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    console.log(result);
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
</script>
<style type="text/css">
    a:hover {
        cursor:pointer;
    }
</style>
</body>
</html>

