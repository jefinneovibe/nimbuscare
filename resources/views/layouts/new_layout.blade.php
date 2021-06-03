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
        <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">

    </head>
    <body>
        <div class="wrapper">

        <!--new header-->
        <header>
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="row justify-content-end">
                        <button type="button" class="close" aria-label="Close">
                            <a href="{{url($onclose)}}" role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                        </button>
                    </div>
                </div>
                <div class="row header">
                <!--<div class="col-1">
                <button type="button" id="sidebarCollapse" class="btn">
                    <i class="ni ni-align-left-2"></i>
                </button>
                </div>-->
                    <div class="col-8 headertitle">
                        <h6 class="white"><span class="red">   {{@$pipeline_details['workTypeId']['name']}}- {{@$formValues['refereneceNumber']}} -{{@$title}}</span></h6>
                    </div>
                    <div class="col-4 headbutton">
                        <div class="btngroup">
                            @if (Request::is('issuance/*'))
                                <button type="button" class="btn btn-link btn-sm" onclick="saveAndSubmitLater('{{@$steps1}}')" ><a>SAVE AND SUBMIT LATER</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif
                            @if (Request::is('view-policy-details/*') && @$pipeline_details['pipelineStatus'] == "lost business")
                                <button type="button" class="btn btn-danger btn-sm" >Lost business</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--new header ends-->

        <!-- e questionnaire content-->
        <div id="content-pending">
            <br><br>
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

     <!----------------------------------floating chat------------------------------------------->
    @include('includes.float_chat')
    <!---------------------------------mdal chat end-------------------------------------------->

     <!----------------------------------floating upload------------------------------------------->
    @include('includes.float_upload')
    <!----------------------------------floating upload end------------------------------------------>


    </div>
<style>
    #image_preview {
        height: 100%;
        width: auto;
        position: inherit;
    }
    #img_prview_area {
        position: absolute;
        /* width: auto; */
        height: 100%;
    }
</style>
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
    <script src="{{URL::asset('widgetStyle/js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/js/main/additional-methods.min.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ URL::asset('widgetStyle/js/script.js?v1.5')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/formElementScripts.js')}}"></script>


    <script>
        // PreLoader
        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
            });
        });
    </script>

    @stack('widgetScripts')
    </body>
</html>
