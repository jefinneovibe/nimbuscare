@extends('layouts.widget_layout')


@section('content')

<style>
.reqed::after{  
    content: "*";
    color:red;
}
 .req .titles::after{  
    content: "*";
    color:red;
}
</style>
<div  class="contentbodytwo">

           <!---collapsible pannels-->
           <div class="wrap center-block">
              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<!-- Form1 -->
                <input type="hidden" id="work_type_data_id" name="work_type_data_id" value="{{$workTypeDataId}}">
                <?php $count = 0;  ?>
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
                                        @if($step == 'businessDetails' && @$formValues['status']['status'] == 'Worktype Created')
                                            <span style="cursor: pointer;" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$step}}" aria-expanded="true" aria-controls="{{$step}}" class="editpanel">
                                                <i class="fa fa-pencil justify-content-end" aria-hidden="true"></i>&nbsp;Edit
                                            </span>
                                            <?php $steps[] = $step; ?>
                                            <?php $steps1 = json_encode($steps); ?>
                                        @endif
                                    </a>
                                </h4>
                            </div>
                            <div id="{{$step}}" class="panel-collapse collapse in @if(@$formValues['status']['status'] == 'Worktype Created' && $step == 'basicDetails') show @elseif((($loop->first && empty(@$values[$step]) ) || $loop->iteration == @$next) && @$formValues['status']['status'] != 'Worktype Created')  show @endif" role="tabpanel" aria-labelledby="{{$step}}">
                                <div class="panel-body">
                                    @widget("BasicDetails",['data' => @$data,'formValues'=>@$formValues, 'step' => @$step, 'workTypeId' => @$workTypeId, 'stage' =>@$stage, 'values' => @$values, 'workTypeDataId'=>@$workTypeDataId, 'proceedToNextStage' => $loop->last, 'filler_type' =>'fill_underwriter'])
                                </div>
                            </div>
                        </div>
                        @else
                            <?php $next++; ?>
                    <!-- end of form 1 -->
                    @endif
                @endforeach
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
</div>




 <!------------------------------------------------modal-------------------------------->


<div class="modal fade" id="questionnaire_popup" tabindex="-1" role="dialog" aria-labelledby="questionnaire_popup" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
      <div class="modal-content  ">
          <div class="modal-header">
           <h3>Add comments and files</h3>
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
                          <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form_label bold">Enter To email address<span style="visibility:hidden">*</span></label>
                                        <input onkeyup="addEmailValidation(this)" class="form-control" @if (@$formValues->getCustomer->email[0])
                                            value="{{@$formValues->getCustomer->email[0]}}"
                                        @endif placeholder="Enter To email address" type="email" name="to_email" id="to_email">
                                    </div>
                                </div>
                                <label id="maximumLimitCC" class="titile error" style="display:none;">Maximum limit exceeded</label>
                                <div id="ccInputDiv_0" class="row">
                                    <div class="col-md-10">
                                        <label class="form_label bold">Enter CC email address<span style="visibility:hidden">*</span></label>
                                        <input  onkeyup="addEmailValidation(this)" class="form-control" placeholder="Enter CC email address" type="email" name="cc_email[]" id="cc_email_0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="add btn btn-primary btnForCC plus_button" onclick="addMoreofThisCC(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 14px;">
                                    <div class="col-md-12">
                                        <label class="form_label bold">Enter your comment<span style="visibility:hidden">*</span></label>
                                        <textarea class="form-control" style="border: 1px solid #D4D9E2;padding: 10px 12px !important;" id="txt_comment" name="txt_comment" placeholder="Comment..."></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div id="attach_div">
                                            <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" onclick="makeEverythingBack()" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                        <button type="button" class="btn btn-primary btnload" onclick="submitCustomerForm(this)" id="send_btn">OK</button>
                    </div>
                  </div>
              </div>
            </form>
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
              <div class="cd-popup">
                  <div class="cd-popup-container">
                      <div class="modal_content">
                          <div class="clearfix"></div>
                          <div id="multiForm_popup_content_spacing" class="multiForm_popup content_spacing">

                          </div>
                      </div>
                  </div>
              </div>
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
                <button type="button" onclick="deleteMultipleForm()" class="btn btn-primary btnload">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-----------------------------------------------alert-modal-------------------------------->


<div class="modal fade" id="success_popup" tabindex="-1" role="dialog" aria-labelledby="modal-success_popup" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
        <div class="modal-content  ">
            <div class="modal-body">
                <!---success alert-->
                <div class="row successalert">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            <strong>Success!</strong> <p id="success_message"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="commonbutton modal-footer">
                <button type="button" onclick="makeEverythingBack()" class="btn btn-link  ml-auto closebutton btnload" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<!-----alert-modal end-->
<!-----------------------------------------------alert-modal-------------------------------->


<div class="modal fade" id="danger_popup" tabindex="-1" role="dialog" aria-labelledby="modal-danger_popup" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
        <div class="modal-content  ">
            <div class="modal-body">
                <!---danger alert-->
                <div class="row failalert">
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <strong>Failed!</strong> <p id="failed_message"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="commonbutton modal-footer">
                <button type="button" onclick="makeEverythingBack()" class="btn btn-link  ml-auto closebutton btnload" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<!-----alert-modal end-->

            <!------modal end-->

            <style>
                .modal_content .form-control{
                    color: #343434;
                }
            </style>

@endsection

@push('widgetScripts')


<script>

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

  /* To get all the uploaded files in e-questinare */

  $('#btn-send').on('click', function () {
    var id = $('#work_type_data_id').val();
      $.ajax({
          method: 'get',
          url: '{{url('equestionnaire-email-file')}}',
          data: {'id':id},
          success: function (result) {
              if (result!= 'failed') {
                  $('#attach_div').html(result);
              }
              else
              {
                  $('#attach_div').html('Files loading failed');
              }
          }
      });
  });
  function addEmailValidation(t){
    if ($("#"+$(t).attr("id")+"-error").length != 0) {
        $("#"+$(t).attr("id")+"-error").remove();
    }
      if($(t).val().trim() != ''){
        $(t).rules( "add" , "customemail" );
      }else {
        $(t).rules( "remove" , "customemail" );
      }
  }

  /* To send email e-questinare */
    $.validator.addMethod("customemail",
        function(value, element) {
            if (value.trim() != '') {
                return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            } else {
                return true;
            }
        },
        "Please enter a valid email id. "
    );
    is_customer_form_submitted = false;
    function submitCustomerForm(elem)
    {
        if(is_customer_form_submitted == false) {
            $(elem).attr( "disabled", true );
            $('#quest_send_form').submit();
            is_customer_form_submitted = true;
        }
    }
    function makeEverythingBack() {
        is_customer_form_submitted = false;
        $("#send_btn").attr( "disabled", false );
    }
    // function sendQuestion() {
        $("#quest_send_form").validate({
            ignore: [],
            rules: {
                to_email: {
                    // customemail: function(){
                    //     return this.value != '';
                    // },
                }
            },
            messages: {
                to_email: "Please enter valid email id"
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function(form, event) {
                $("#send_btn").attr( "disabled", true );
                var form_data = new FormData($("#quest_send_form")[0]);
                var id = $('#work_type_data_id').val();
                form_data.append('id',id);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                // $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('send-questionnaire-email')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result!= 'failed') {
                            $('#questionnaire_popup').modal('hide');
                            $('#preLoader').hide();
                            $('#success_message').html(result);
                            $('#success_popup').modal('show');
                            $("#send_btn").attr( "disabled", false );
                        } else if (result == 'failed') {
                            $("#send_btn").attr( "disabled", false );
                            $('#questionnaire_popup').modal('hide');
                            $('#preLoader').hide();
                            $('#failed_message').html('Email ID not provided for this customer.');
                            $('#danger_popup').modal('show');
                        } else {
                            $("#send_btn").attr( "disabled", false );
                            $('#questionnaire_popup').modal('hide');
                            $('#preLoader').hide();
                            $('#success_message').html('E-questionnaire already filled.');
                            $('#success_popup').modal('show');
                        }
                    }
                });
            }
        });
    // }
</script>
@endpush
