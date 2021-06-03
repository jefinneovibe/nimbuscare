<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Create worktype</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ URL::asset('widgetStyle/css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->
    <!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ URL::asset('widgetStyle/assets/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('widgetStyle/assets/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- argonTheme CSS -->
    <link type="text/css" href="{{ URL::asset('widgetStyle/assets/css/argon.min.css')}}" rel="stylesheet">
    <!--custom css-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('widgetStyle/css/style.css?v1')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->

    <link rel="stylesheet" href="{{ URL::asset('widgetStyle/css/bootstrap-select.css')}}" />
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
    <script>
        <?php
            date_default_timezone_set("Asia/Dubai");
            $date = date('Y/m/d H:i:s');
        ?>
        var d = new Date("{{$date}}");
        function digitalClock() {
            d.setTime(d.getTime() + 1000);
            var hrs = d.getHours();
            var mins = d.getMinutes();
            var secs = d.getSeconds();
            mins = (mins < 10 ? "0" : "") + mins;
            secs = (secs < 10 ? "0" : "") + secs;
            var ctime = hrs + ":" + mins + ":" + secs + " ";
            document.getElementById("clock_worktype").firstChild.nodeValue = ctime;
        }
        window.onload = function() {
            digitalClock();
            setInterval('digitalClock()', 1000);
        }
    </script>
  </head>
  <body>
    <div class="wrapper">

       <!-- Sidebar  -->
            <nav id="sidebar">


          <ul class="list-unstyled components">

              <li {{ Request::is('dash') ? 'class=active' : '' }}>
                  <a href="{{ url('dash') }}">Main Dashboard</a>
              </li>
              @if((session('assigned_permissions')) && (in_array('CRM',session('assigned_permissions'))))
              <li {{ Request::is('crm-dashbord') ? 'class=active' : '' }}>
                  <a href="{{ url('crm-dashbord') }}">Broking Slip Dashboard</a>
              </li>
              <li {{ Route::current()->getName() == 'customer/1/show' ? 'class=active' : '' }}>
                  <a href="{{ url('customers/1/show') }}">Permanent Customers</a>
              </li>
              <li {{ Route::current()->getName() == 'customer/0/show' ? 'class=active' : '' }}>
                  <a href="{{ url('customers/0/show') }}">Temporary Customers</a>
              </li>
              <li {{ Route::current()->getName() == 'policies' ? 'class=active' : '' }}>
                  <a href="{{ url('policies') }}">Policies</a>
              </li>
              <li {{ Route::current()->getName() == 'pipeline' ? 'class=active' : '' }}>
                  <a href="{{ url('pipelines') }}">Pipeline</a>
              </li>
              <li {{ Route::current()->getName() == 'pending-issuance' ? 'class=active' : '' }}>
                  <a href="{{ url('pending-issuance') }}">Pending Issuance</a>
              </li>
              <li {{ Route::current()->getName() == 'pending-approvals' ? 'class=active' : '' }}>
                  <a href="{{ url('pending-approvals') }}">Pending Approvals</a>
              </li>
              <li {{ Route::current()->getName() == 'closed-pipelines' ? 'class=active' : '' }}>
                  <a href="{{ url('closed-pipelines') }}">Closed List</a>
              </li>
              <li {{ Request::is('customers/create') ? 'class=active' : '' }}>
                  <a href="{{ url('customers/create') }}">Add Customers</a>
              </li>
              <li {{ Request::is('work-types/create') ? 'class=active' : '' }}>
                  <a href="{{ url('work-types/create') }}">Create Work Type</a>
              </li>
              <li {{ Request::is('leave/leave-list') ? 'class=active' : '' }}>
                  <a href="{{ url('leave/leave-list') }}">Leave List</a>
              </li>
              @endif
          </ul>

      </nav>


      <!--sidebar ends-->




<!-------------------------------------------------------header ------------------------------------------>

<nav class="navbar navbar-expand-lg navbar-dark bg-white" style="z-index: 9999;">
  <div class="container-fluid header">
      <button type="button" id="sidebarCollapse" class="btn">
          <b><i class="ni ni-align-left-2"></i></b></button>
      <a class="navbar-brand" href="#"><h5><strong>INTERACTIVE LLC</strong></h5></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
          <span > <ul><li class="nav-item dropdown">
            <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="user_icon_collapse">A</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
        </li></ul></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-default">


          <ul class="navbar-nav ml-lg-auto">
              <!--<li class="nav-item time">
                  <a class="nav-link nav-link-icon" href="#">
                    <i class="fa fa-clock-o">&nbsp;&nbsp;</i>
                     <span style="float: right" id="clock_worktype">
                  </a>
              </li>-->
               <li class="nav-item time">
                            <a class="nav-link nav-link-icon" href="#">
                                <i style="padding-top:8px" class="fa fa-clock-o">&nbsp;&nbsp;</i>
                                <span style="float: right" id="clock_worktype">
                                <!-- <span class="badge hours">12</span>:<span class="badge min">35</span>:<span class="badge sec">58</span> -->
                            </a>
                        </li>

              <li class="nav-item dropdown">
                  <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="user_name align-middle">Admin</span>
                      <span class="user_icon align-middle">A</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" data-toggle="modal" style="cursor: pointer;" data-target="#change_password_popup_worktype" onclick="clickChangePassword();">Change Password</a>
                    <a href="{{url('/logout')}}" class="dropdown-item">Log Out</a>
                  </div>
              </li>
          </ul>

      </div>
  </div>
</nav>


<!-- Main Content -->
<div class="page_content">
    @yield('content')
</div>
<!--//END Main Content -->




</div><!--wrapper ends--->

{{-- modal change password--}}
    <div class="modal fade" id="change_password_popup_worktype" tabindex="-1" role="dialog" aria-labelledby="change_password_popup_worktype" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form method="post" name="change_password_form" id="change_password_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert" id="password_error" style="display: none">
                                    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                                    Incorrect Old Password
                                </div>
                                <div class="alert alert-success alert-dismissible" role="alert" id="password_success" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Password updated successfully.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="titles"><b>Old Password<span class="error">*</span></b></label>
                                    <input class="form-control" name="old_password" id="old_password" placeholder="Old Password"  type="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                <label class="titles"><b>New Password<span class="error">*</span></b></label>
                                <input class="form-control" name="new_password1" id="new_password1" placeholder="New Password" type="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="titles"><b>Confirm Password<span class="error">*</span></b></label>
                                    <input class="form-control" name="confirm_password1" id="confirm_password1" placeholder="Confirm Password" type="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="commonbutton modal-footer">
                        <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary btnload" id="change_password_button">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--modal password end--}}





@include('includes.widget-js')

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
 </script>

    </body>


</html>
