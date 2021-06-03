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
    <style>
        .viewStatus{
            padding: 3px 2px 0px 2px;
            font-weight: 600;
            color: #ffffff;
        }
        .btnFont{
            font-size: 10.5px !important;
            padding: 1px 1px 3px 1px;
        }
        </style>
    <body>

        <div class="wrapper">

        @include('includes.worktype_nav')

        <!--new header-->
        <header>
            <div class="container-fluid">
                <!--<div class="container-fluid">
                    <div class="row justify-content-end">
                            @if (Request::is('excel-imported-list'))
                                <button type="button" class="close" aria-label="Close">
                                    <a href="{{url('equotation/'.@$workTypeDataId)}}" role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                                </button>
                            @else
                                <button type="button" class="close" aria-label="Close">
                                    <a href="{{url('pipelines')}}" role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                                </button>
                            @endif
                    </div>
                </div>-->
                <div class="row header">
                <button type="button" id="sidebarCollapse" class="btn hidesidebar">
                    <i class="ni ni-align-left-2"></i>
                </button>
                    <div class="headertitle">
                        <h6 style="font-size: 15px;" class="white">{{@$formValues->workTypeId['name']}} - {{@$formValues['refereneceNumber']}} - <span class="red"> {{@$title}}</span></h6>
                    </div>
                    <div class="headbutton">
                    <div class="justify-content-end"><!------>
                        <div class="btngroup ">

                            @if (Request::is('ecomparison/*'))
                                @if(isset($formValues['comparisonToken']))
                                    <label class="badge badge-secondary btnFont" for="viewStatus">{{@$formValues['comparisonToken']['viewStatus']}}</label>
                                @endif
                            @endif
                                <input type="hidden" value="{{@$steps1}}" id="save_and_submit_later">
                            <!-- SAVE AND SUBMIT LATER -->
                            @if (Request::is('equestionnaire/*') && (@$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'Worktype Created' || (@$formValues['status']['status'] == 'E-slip' && @$formValues['eQuestinareStatus'] == false)))
                                    <button type="button" class="btn btn-link btn-sm btnFont" id="save_and_submit_later" value="{{@$steps1}}" onclick="saveAndSubmitLater('{{@$steps1}}')" >SAVE AND SUBMIT LATER</button>&nbsp;
                            @endif
                            @if (Request::is('eslip/*') && (@$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-slip') )
                                    <button type="button" class="btn btn-link btn-sm btnFont" id="save_and_submit_later" value="{{@$steps1}}" onclick="saveAndSubmitLater('{{@$steps1}}')" >SAVE AND SUBMIT LATER</button>&nbsp;
                            @endif
                            @if (Request::is('equotation/*') && (@$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-slip' || @$formValues['status']['status'] == 'E-quotation'))
                                    <button  @if (empty(@$InsurerData))
                                    disabled
                                @endif  type="button" class="btn btn-link btn-sm btnFont" id="save_and_submit_later" value="{{@$steps1}}" onclick="saveAndSubmitLater('{{@$steps1}}')" >SAVE AND SUBMIT LATER</button>&nbsp;
                            @endif
                            @if (Request::is('approved-equote/*') && (@$formValues['status']['status'] == 'Approved E Quote') )
                                    <button type="button" class="btn btn-link btn-sm btnFont" id="save_and_submit_later" value="{{@$steps1}}" onclick="saveAndSubmitLater('{{@$steps1}}')" >SAVE AND SUBMIT LATER</button>&nbsp;
                            @endif
                            @if (Request::is('issuance/*') && (@$formValues['pipelineStatus'] == 'issuance') )
                                    <button type="button" class="btn btn-link btn-sm btnFont" id="save_and_submit_later" value="{{@$steps1}}" onclick="saveAndSubmitLater('{{@$steps1}}')" >SAVE AND SUBMIT LATER</button>&nbsp;
                            @endif
                            <!-- SAVE AND SUBMIT LATER -->

                                @if (Request::is('ecomparison/*'))
                                    <button type="button" class="btn btn-link btn-sm btnFont"><a target="_blank" href="{{url('ecomparison-pdf/'.@$workTypeDataId)}}">Download as pdf</a></button>
                                    <button type="button" class="btn btn-danger btn-sm btnFont" onclick="lostBusiness(this, '{{@$workTypeDataId}}')">Lost Business</button>
                                @endif
                                @if (Request::is('equestionnaire/*'))
                                    <button type="button" class="btn btn-dark btn-sm btnFont" id="btn-send" onclick="removeCCValue()"  data-toggle="modal" data-target="#questionnaire_popup">
                                        <a role="button" >SEND TO CUSTOMER</a>
                                    </button>
                                @endif
                                @if (Request::is('equotation/*'))
                                    <button @if (empty(@$InsurerData))
                                        style="display:none;" disabled
                                    @endif type="button" id="eqotationBtnSubmit" class="btn btn-primary btn-sm btnFont" onclick="submitEquotation(1)" >
                                        SAVE AND SUBMIT
                                    </button>
                                @endif
                                @if (Request::is('ecomparison/*'))
                                    <button type="button"
                                        class="btn btn-primary btn-sm btnFont" onclick="popupFunction()"
                                        @if(@$formValues['status']['status'] == 'Approved E Quote') style="display:none;"
                                        @endif id="send_customer">SEND TO CUSTOMER
                                    </button>

                                    @if(!empty($formValues['comparisonToken']['viewStatus']) && $formValues['comparisonToken']['viewStatus']!='Responded by customer' && $formValues['comparisonToken']['status'] == 'active')
                                        <button type="button"  id="eqotationBtnSubmit" class="btn btn-primary btn-sm btnFont" onclick="admin_formSubmit()" >
                                            SAVE AND SUBMIT
                                        </button>
                                    @endif

                                    @endif

                                @if (Request::is('quote-amendment/*')&& (@$formValues['status']['status'] != 'Approved E Quote') )
                                    <button type="button" class="btn btn-primary btn-sm btnFont" onclick="gotoEslip()">
                                        Go to E-slip
                                    </button>
                                    @if(isset($formValues['status']['status']) &&
                                    (@$formValues['status']['status']=='Quote Amendment' || @$formValues['status']['status']=='Quote Amendment-E-slip' ||
                                    @$formValues['status']['status']=='Quote Amendment-E-quotation' || @$formValues['status']['status']=='Quote Amendment-E-comparison'))

                                        <button type="button" class="btn btn-primary btn-sm btnFont" onclick="closeCase()">
                                            Close the case
                                        </button>
                                    @endif
                                @endif
                                @if (Request::is('excel-imported-list'))
                                    <button type="button" class="close" aria-label="Close">
                                        <a class="closestyle" href="{{url('equotation/'.@$workTypeDataId)}}" role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                                    </button>
                                @else
                                    <button type="button" class="close" aria-label="Close">
                                        <a class="closestyle" href="{{url('pipelines')}}" role="button" style="color:#ffffff;" target="_self"><span aria-hidden="true">&times;</span></a>
                                    </button>
                                @endif
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--new header ends-->

        <!--Full page Loader-->

        <div id="fullPageLoader">
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>



        <!--Full page Loader-->

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
                setTimeout(function(){
                    $('#show_success').fadeOut('slow');
                }, 3000);
                setTimeout(function(){
                    $('#show_fail').fadeOut('slow');
                }, 3000);
                $('#preLoader').fadeOut('slow');
            });
        });
        //for left collapsible window

        function submitEquotation(form_num) {
            if (form_num == 1) {
                $("#e_quat_form").submit();
            }
            console.log(form_num);
        }

    </script>
<script>
    $(window).load(function(){
         getEmirates($("#country"));
        $('#country').selectpicker();
    });
    // onchange="getEmirates(this)"
     function getEmirates(test){
         $( '#emirate' ).prop('disabled', true);
         var countryVal = $(test).val();
         $.ajax({
             type: "POST",
             url: "{{url('get-country-emirates')}}",
             data:{country_name : countryVal , _token : '{{csrf_token()}}'},
             success: function(data){
                 if (data.status == 'success') {
                     $( '#emirate' ).prop('disabled', false);
                     change_emirates(data.state)
                 }
             }
         });
     }
     function change_emirates(state) {
         if (state) {
             optionsAsString = '<option value="">Select</option>';
             $.each( state, function( key, value ) {
                 optionsAsString += "<option value='" + value + "'>" + value + "</option>";
             });
             $( '#emirate' ).html( optionsAsString );
             $("#emirate").val($("#hidden_selected_state").val());
             $('#emirate').selectpicker('refresh');
         }
     }

    function addMoreofThisCC(t) {
        var NotNull = 0;
        $("input[name='cc_email[]']").each(function(){
            if ($(this).hasClass('error')) {
                NotNull++;
            }else {

                if ($(this).val() == '') {
                    NotNull++;
                    if ($("#"+$(this).attr("id")+"-error").length == 0) {
                        $(this).after('<label id="'+$(this).attr("id")+'-error" class="error" for="cc_email">Please enter this field.</label>');
                    }
                } else {
                    $("#"+$(this).attr("id")+"-error").remove();
                }
            }
        });
        if (NotNull == 0) {
            IndexNum = $("input[name='cc_email[]']").length;
            lastIdIndex = $("input[name='cc_email[]']:last").attr('id').split("_")[2];
            if (IndexNum < 5) {
                $("#maximumLimitCC").hide();
                var removeHtml = '<div id="ccInputDiv_'+parseInt(lastIdIndex + 1)+'" class="row childDiv">';
                removeHtml += '<div class="col-md-10">';
                removeHtml +='<label class="form_label bold">Enter CC email address<span style="visibility:hidden">*</span></label>';
                removeHtml +=' <input onkeyup="addEmailValidation(this)" class="form-control" placeholder="Enter CC email address" type="email" name="cc_email[]" id="cc_email_'+parseInt(lastIdIndex + 1)+'">';
                removeHtml += '</div><div class="col-md-2"><button class="add btnForCC btn btn-primary minus_button remove_on" type="button" onclick="removeThisCC(this)" ><i class="fa fa-minus"></i></button></div>';
                removeHtml +='</div>'
                $("#ccInputDiv_"+parseInt(lastIdIndex)).after(removeHtml);
            } else {
                $("#maximumLimitCC").show().delay(5000).fadeOut();;
            }
        }
    }
    function removeThisCC(t) {
        $(t).parent().parent().remove();
    }
    function removeCCValue() {
        $('.childDiv, #cc_email_0-error').remove();
        $("#quest_send_form").find("input[name='cc_email[]']").val('');
    }
</script>


    @stack('widgetScripts')
    </body>
</html>
