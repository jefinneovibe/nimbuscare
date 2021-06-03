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
</head>
<body>
<main class="login_sec">
    <div class="table_cell">
        <div class="login_main">
            <div class="login_logo">
                <img src="{{ URL::asset('img/main/interactive_logo.png')}}">
            </div>
            <h1 class="title">Please Login</h1>
            <form class="form-horizontal" method="POST" action="{{url('/login')}}" id="loginForm" name="loginForm">
                <div class="login_wrap">
                    <div class="form_group">
                        <label class="form_label">Enter Email Id <span>*</span></label>
                        <input class="form_input" name="email" placeholder="Email ID" type="text" id="email">
                    </div>
                    <div class="form_group">
                        <label class="form_label">Enter Password <span>*</span></label>
                        <input class="form_input" name="password" placeholder="*****************" type="password" id="password">
                    </div>
                    <a href="{{url('insurer/dashboard')}}" type="submit" class="btn-round submit_btn">Submit</a>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>