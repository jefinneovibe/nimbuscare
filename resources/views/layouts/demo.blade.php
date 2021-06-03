<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}"><!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/normalize.css')}}"><!-- Normalize CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" /><!-- Material Icons CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"><!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="{{ URL::asset('css/main/material-kit.css?v=2.0.3')}}" /><!-- Material Kit CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}"><!-- Main CSS -->
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

    </div>
</div>

<!--//END Loader -->
<main class="layout_content">
    <!-- Header -->
    <!-- Main Content -->
    <div class="page_content">
        @yield('content')
    </div><!--//END Main Content -->
</main>
@include('includes.modals')
@include('includes.js-scripts')
</body>
</html>

