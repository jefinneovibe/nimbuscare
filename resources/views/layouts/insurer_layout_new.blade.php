<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{env('APP_NAME')}}</title>
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
        <link rel="stylesheet" href="{{ URL::asset('widgetStyle/css/bootstrap-select.css')}}" />

        <!-- <link rel="stylesheet" href="{{ URL::asset('css/main/main.css')}}">Main CSS -->
        <!-- argonTheme CSS -->
        <link type="text/css" href="{{ URL::asset('widgetStyle/assets/css/argon.min.css')}}" rel="stylesheet">
        <!--custom css-->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('widgetStyle/css/style.css?v1')}}">
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <ul class="list-unstyled components">
                    <?php
                        $parsed =$_SERVER['REQUEST_URI'];
                        @$prev =explode('/', $parsed);
                    ?>
                    <li @if (array_search('e-quote-details', $prev) !== false) class="active" @endif>
                        <a href="{{ url('insurer/e-quotes-provider') }}" >E-quotes to be Provided</a>
                    </li>
                    <li @if ( array_search('amend-details', $prev) !== false) class="active" @endif>
                        <a href="{{url('insurer/equotes-given')}}" >E-quotes Given</a>
                    </li>
                </ul>
            </nav>
        <!--sidebar ends-->
        <!--new header-->
        <header>
            <div class="container-fluid">
                <div class="row header">
                        <button type="button" id="sidebarCollapse" class="btn hidesidebar">
                                <i class="ni ni-align-left-2"></i>
                            </button>
                    <div class="headertitle">
                        <h6 class="white">{{@$formValues->workTypeId['name']}} - {{@$formValues['refereneceNumber']}} - <span class="red"> {{@$title}}</span></h6>
                    </div>
                    <div class="headbutton">
                        <div class="justify-content-end">
                            <button type="button" class="close" aria-label="Close">
                                <a @if (array_search('e-quote-details', $prev) !== false)  href="{{url('insurer/e-quotes-provider')}}"  @elseif(array_search('amend-details', $prev) !== false) href="{{url('insurer/equotes-given')}}" @endif role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                                &nbsp;&nbsp;
                            </button>
                            <div class="btngroup">
                                &nbsp;
                                @if (Request::is('insurer/e-quote-details/*'))
                                    <button id="ins_saveAndSubLat" onclick="saveDraft()" type="button" class="btn btn-dark btn-sm">
                                        <a role="button" >SAVE AND SUBMIT LATER</a>
                                    </button>&nbsp;&nbsp;
                                @endif
                                @if (Request::is('insurer/e-quote-details/*') || Request::is('insurer/amend-details/*'))
                                    <button id="ins_saveAndSub" type="button" onclick="submitForm()" class="btn  btn-dark btn-sm">
                                            SAVE AND SUBMIT
                                    </button>&nbsp;&nbsp;
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--new header ends-->

        <!-- e questionnaire content-->
        <div id="content">
        <div id="response_wrp">
            <!---success alert-->
            @if (session('success'))
            <div id="show_success" class="row successalert" >
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        <strong>Success!</strong> {{session('success')}}
                    </div>
                </div>
            </div>
            @endif

            @if (session('failed'))
            <!---fail alert-->
            <div id="show_fail" class="row failalert">
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        <strong>Sorry!</strong> {{session('failed')}}
                    </div>
                </div>
            </div>
            @endif
        </div>
            <div class="mycontainer">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script  src="{{ URL::asset('widgetStyle/js/main/jquery-2.2.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- Material kit -->
    <script src="{{ URL::asset('widgetStyle/js/main/bootstrap-material-design.min.js')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/main/material-kit.js?v=2.0.3')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/main/moment.min.js')}}"></script>

    <script src="{{ URL::asset('widgetStyle/js/main/bootstrap-select.js')}}"></script>

    <!-- Navigation -->
    <script src="{{ URL::asset('widgetStyle/js/main/snap.svg-min.js')}}"></script>
    @if (!Request::is('*/customer-questionnaire/*'))
    <script src="{{ URL::asset('widgetStyle/js/main/navigation.js')}}"></script>
    @endif

    <!-- Modal -->
    <script src="{{ URL::asset('widgetStyle/js/main/modal.js')}}"></script>


    <script>
        // PreLoader
        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
            });
        });
    </script>

    <script src="{{URL::asset('widgetStyle/js/main/jquery.validate.js')}}"></script>
    <script>
  $('#sidebarCollapse').on('click', function () {
    $('#sidebar, #content').toggleClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
});
    </script>
    <script src="{{URL::asset('widgetStyle/js/main/additional-methods.min.js')}}"></script>
    {{-- <script src="{{ URL::asset('widgetStyle/js/script.js?v1.5')}}"></script> --}}
    @stack('widgetScripts')
    </body>
</html>
