<!DOCTYPE html>
<html lang="en">
    <head>
        <title>E-Questionnaire</title>
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
        <link rel="stylesheet" href="{{ URL::asset('css/main/fancy_fileupload.css')}}" /><!-- Fancy FileUpload CSS -->
    </head>
    <style>
    .center_logo img{
        height: 100px;
        padding: 10px;
    }
    </style>
    <body>
        <div class="wrapper">

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
        <div id="">
            <br><br>
            <div class="mycontainer">
            <!-- Header -->
            <div class="card_header clearfix">
                <div class="center_logo commonbutton">
                    <img src="{{ URL::asset('img/main/interactive_logo.png')}}">

                {{-- <div class="row justify-content-end commonbutton"> --}}
                    {{-- @if (@$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'Worktype Created' || (@$formValues['status']['status'] == 'E-slip' && @$formValues['eQuestinareStatus'] == false))
                      <button style="margin-top:40px;" type="button" value="{{@$steps1}}" id="save_and_submit_later" onclick="saveAndSubmitLater('{{@$steps1}}')" class="btn btn-primary btnload">
                        <a href="#"  role="button">SAVE AND SUBMIT LATER</a>
                      </button>
                    @else
                    <input type="hidden" value="{{@$steps1}}" id="save_and_submit_later">
                    @endif
                    </div> --}}
                  {{-- </div> --}}
            </div><!--//END Header -->

            <div  class="contentbodytwo">
           <!---collapsible pannels-->
           <div class="wrap center-block">
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <!-- Form1 -->
                <input type="hidden" id="work_type_data_id" name="work_type_data_id" value="{{$workTypeDataId}}">
                <input type="hidden" id="email_equestionare" name="email_equestionare" value="email">
                @foreach($data['steps'] as $step => $data)
                <?php $hidden = @$data['hidden']?:false;?>
                @if(@$hidden != 2)
                <?php
                        $steps[] = @$step;
                        $steps1 = json_encode($steps);
                ?>
                    <div class="panel panel-default">
                     <div class="panel-heading active" role="tab" id="key{{$step}}">
                       <h4 class="panel-title">
                         <a >
                            @if(!empty(@$values[$step])) <i class="fa fa-check " aria-hidden="true"> @endif </i>&nbsp;{{$data['name']}}&nbsp;
                            @if(!empty(@$values[$step]))
                                <?php $next = $loop->iteration+1 ?>
                                <span style="cursor: pointer;" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$step}}" aria-expanded="true" aria-controls="{{$step}}" class="editpanel">
                                <i class="fa fa-pencil justify-content-end" aria-hidden="true"></i>&nbsp;Edit
                                </span>
                            @endif
                            @if($step == 'businessDetails' && (@$formValues['status']['status'] == 'Worktype Created' || @$formValues['status']['status'] == 'E-questionnaire'))
                            <span style="cursor: pointer;" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$step}}" aria-expanded="true" aria-controls="{{$step}}" class="editpanel">
                            <i class="fa fa-pencil justify-content-end" aria-hidden="true"></i>&nbsp;Edit
                            </span>
                            @endif
                         </a>
                       </h4>
                     </div>
                     <div id="{{$step}}" class="panel-collapse collapse in @if(@$formValues['status']['status'] == 'E-questionnaire' && $step == 'basicDetails') show @elseif((($loop->first && empty(@$values[$step]) ) || $loop->iteration == @$next) && @$formValues['status']['status'] != 'E-questionnaire')  show @endif" role="tabpanel" aria-labelledby="{{$step}}">
                       <div class="panel-body">
                               @widget("BasicDetails",['data' => @$data, 'step' => @$step, 'workTypeId' => @$workTypeId, 'stage' =>@$stage, 'values' => @$values, 'workTypeDataId'=>@$workTypeDataId, 'proceedToNextStage' => $loop->last, 'filler_type' =>'fill_customer'])

                       </div>
                     </div>
                   </div>
                   @else
                       <?php $next++; ?>
               <!-- end of form 1 -->
               @endif
<!-- end of form 1 -->
@endforeach

                </div>
            </div>
        </div>
        <br>
          <div class="container-fluid disclaimer">
            <div class="row">
              <div class="col-12">
                <p class="red">Disclaimer : It is your duty to disclose all material facts to underwriters. A material
                  fact is one that is likely to influence an underwriter’s
                  judgement and acceptance of your proposal. If your proposal is a renewal, it should also include any
                  change in facts previously advised to underwriters.
                  If you are in any doubt about facts considered materials, disclose them. FAILURE TO
                  DISCLOSE could prejudice your rights to recover in the event of a claim or allow underwriters to void
                  the Policy.</p>
              </div>
            </div>
          </div>

          <div class="row justify-content-end commonbutton">
              @if (@$formValues['status']['status'] == 'E-questionnaire' || @$formValues['status']['status'] == 'Worktype Created' || (@$formValues['status']['status'] == 'E-slip' && @$formValues['eQuestinareStatus'] == false))
                <button style="margin-top:40px;" type="button" value="{{@$steps1}}" id="save_and_submit_later" onclick="saveAndSubmitLater('{{@$steps1}}')" class="btn btn-primary btnload">
                  <a href="#"  role="button">SAVE AND SUBMIT LATER</a>
                </button>
              @else
              <input type="hidden" value="{{@$steps1}}" id="save_and_submit_later">
              @endif
              </div>
             </div>


            </div>
        </div>
    </div>


    <div class="modal fade" id="multiForm_popup" tabindex="-1" role="dialog" aria-labelledby="multiForm_popup" aria-hidden="true">
        <div class="modal-dialog modal-xxl modal-dialog-centered modal-xxl"  role="document">
            <div class="modal-content  ">
                <div class="modal-header">
                 <h6 id="multiFormLabel"></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form id="quest_send_form" name="quest_send_form">
                    <div class="cd-popup">
                        <div class="cd-popup-container">
                            <div class="modal_content">
                                <div class="clearfix"></div>
                                <div id="multiForm_popup_content_spacing" class="multiForm_popup content_spacing">

                                </div>
                            </div>
                        </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
      </div>

      <div class="modal fade" id="delete_popup" tabindex="-1" role="dialog" aria-labelledby="modal-delete_popup" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
              <div class="modal-content  ">
                  <div class="modal-body">
                      <!---success alert-->
                      <div class="row failalert">
                          <div class="col-12">
                              <div class="alert alert-danger" role="alert">
                                  <strong>Delete !</strong> <p>Are you sure you want to delete this ?</p>
                                  <form id="deleteMultipleForm" method="post">
                                      <input type="hidden" name="keyValue" id="keyValue" value="">
                                      <input type="hidden" name="keyName" id="keyName" value="">
                                      <input type="hidden" name="worktypeData" id="worktypeData" value="">
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="commonbutton modal-footer">
                      <button type="button" class="btn btn-link  ml-auto closebutton btnload" data-dismiss="modal">Cancel</button>
                      <button type="button" onclick="deleteMultipleForm()" class="btn btn-primary btnload">Proceed</button>
                  </div>
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

    <!-- Modal -->
    <script src="{{ URL::asset('widgetStyle/js/main/modal.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/js/main/additional-methods.min.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ URL::asset('widgetStyle/js/script.js?v1.5')}}"></script>
    <script src="{{ URL::asset('widgetStyle/js/formElementScripts.js')}}"></script>
    <!-- Fancy FileUpload -->
    <script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>


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

            $(window).load(function(){
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1);
                if(hashes == 1) {
                    $("#businessDetails").addClass('show');
                    // $("#hiddenScrolltoMl").scrollTo
                    $('html, body').animate({
                        scrollTop: $('#hiddenScrolltoMl').offset().top
                    }, 'slow');
                }
            });
        function deleteMultipleForm() {
            var form_data = new FormData($("#deleteMultipleForm")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $.ajax({
                method: 'post',
                url: '{{url('deleteMultiple-form-list')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                var currentURL=window.location.href.split('?')[0];
                window.location.href = currentURL+"?"+1;
                }
            });
        }
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
