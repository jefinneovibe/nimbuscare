@extends('layouts.widget_layout')

@section('content')


   <form id="admin_approve_form">
        <div class="dataatable comparesec">
            <div id="admins">
                <div class="materialetable">
                    <div  class="tablefixed heightfix">
                        <div class="table_left_fix">
                            <div class="materialetable table-responsive">
                                <table class="table customer_table">
                                    <thead>
                                        <tr>
                                            <th><div class="mainsquestion"><b class="blue">Questions</b></div></th>
                                            <th><div class="mainsanswer" style="background-color: transparent"><b class="blue">Customer Response</b></div></th>
                                        </tr>
                                    </thead>
                                    <tbody class="syncscroll" name="myElements">
                                        <!--Questions & customer response-->
                                        @if($eComparisonData)
                                        <?php $quest_feildName = []; ?>
                                            @foreach(@$eComparisonData['review'] as $review)
                                                @if($review['type'] == 'checkbox')
                                                <?php  $quest_feildName[] =$review['fieldName'];?>
                                                    <tr class="">
                                                        <td><div class="mainsquestion"><label class="titles">{{@$review['label']}}</label></div></td>
                                                            @if($review['type'] == 'checkbox')
                                                                <td class="mainsanswer"><div class="ans">Yes</div></td>
                                                            @else
                                                                <td class="mainsanswer">
                                                                    <div class="ans">
                                                                        @if (@$review['value'])
                                                                            {{@$review['value']}}
                                                                        @else
                                                                            --
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @foreach(@$eComparisonData['forms'] as $forms)
                                            <tr class="">
                                                <td><div class="mainsquestion">
                                                    <?php  $quest_feildName[] =$forms['fieldName']; ?>
                                                    <label class="titles">
                                                        {{@$forms['label']}}
                                                </label></div></td>
                                                @if(is_array(@$forms['value']))
                                                    @if(@$forms['fieldName'] == 'CombinedOrSeperatedRate')
                                                        <td class="mainsanswer">
                                                            <div class="ans">
                                                                @if(@$forms['value']['seperateStatus'] == 'seperate')
                                                                    Admin Rate : {{@$forms['value']['adminRate']}}
                                                                    Non-Admin Rate : {{@$forms['value']['nonAdminRate']}}
                                                                @else
                                                                    Combined Rate : {{@$forms['value']['combinedRate']}}
                                                                    @if (@$forms['value']['Premium'])
                                                                    <br>    Premium :  {{@$forms['value']['Premium']}}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="mainsanswer">
                                                            <div class="ans">
                                                                @if (isset($forms['value']['isChecked']) && @$forms['value']['isChecked'] == 'yes')
                                                                    Yes
                                                                @else
                                                                <?php
                                                                if (gettype(@$forms['value']) == 'array' && !empty(@$forms['value'])) {
                                                                    $indexArray =array_values($forms['value']);
                                                                    if (strtolower(@$indexArray[0]) == 'yes') {
                                                                        ?>
                                                                        yes
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        --
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                        --
                                                                    <?php
                                                                }
                                                            ?>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td class="mainsanswer">
                                                        <div class="ans">
                                                                @if (@$forms['value'])
                                                                    {{@$forms['value']}}
                                                                @else
                                                                --
                                                                @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @if (((@$formValues['comparisonToken']['viewStatus'] == 'Downloaded as Pdf') || (@$formValues['comparisonToken']['viewStatus'] == 'Sent to customer')  || (@$formValues['comparisonToken']['viewStatus'] == 'Viewed by customer')) && (@$formValues->comparisonToken['viewStatus'] != 'Responded by customer') && (@$formValues['status']['status'] != 'Approved E Quote'))
                                                <tr>
                                                        <td>Customer Decision</td>
                                                        <td>--</td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="table_right_pen">
                            <div  id="scrollstyle" class="materialetable table-responsive">
                                <table class="table comparison">
                                    <thead>
                                        <tr>
                                            @if(@$Insurer)
                                                @foreach(@$Insurer as $key =>$Insurer12)
                                                    <th><div class="ans">{{@$Insurer12['insurerDetails']['insurerName']}}</div></th>
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                        @if(@$InsurerData)
                                            @foreach(@$quest_feildName as $k =>$v)
                                                <?php
                                                    $key=$v;
                                                    $Insurer1=@$InsurerData[$v];
                                                    $number=0;
                                                    $insurerCount=count($Insurer);
                                                ?>
                                                <tr class="">
                                                    @if(count(@$Insurer1)>0)
                                                        @foreach(@$Insurer1 as $key1 =>$Insurerr)
                                                            @if($loop->first && $key1!=$number)
                                                                @for($i=$number;$i<($key1-$number);$i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @elseif(($key1-$number)>1)
                                                                @for($i=$number;$i<($key1-$number);$i++)
                                                                    <td><div class="ans"></div></td>
                                                                @endfor
                                                            @endif
                                                            <?php $number=$key1; ?>
                                                            <td>
                                                                <div class="ans">
                                                                    @if(@$formData[@$Insurerr['fieldName']]['fieldName'] == $key)
                                                                    @if(@$Insurerr['agreeStatus'] == 'agreed')
                                                                        Covered
                                                                    @elseif(@$Insurerr['agreeStatus'] == 'disagreed')
                                                                        Not covered
                                                                    @else
                                                                        {{@$Insurerr['agreeStatus']}}
                                                                    @endif
                                                                        <br>
                                                                        @if(isset($Insurerr['comments']) && @$Insurerr['comments'])
                                                                            <span style="color:black;">{{@$Insurerr['comments']}}</span>
                                                                        @endif

                                                                    @else
                                                                    <span class="removeTr" style="display:none"></span>
                                                                    @endif
                                                                    <?php
                                                                //   echo '<pre>'; print_r($Insurerr); echo 'abcd'; echo(@$formData[@$Insurerr['fieldName']]['fieldName']);  echo '</pre>';
                                                                        ?>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        @for($i=0;$i<($insurerCount);$i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @endif
                                                </tr>
                                            @endforeach
                                            @if (((@$formValues['comparisonToken']['viewStatus'] == 'Downloaded as Pdf') || (@$formValues['comparisonToken']['viewStatus'] == 'Sent to customer')  || (@$formValues['comparisonToken']['viewStatus'] == 'Viewed by customer')) && (@$formValues->comparisonToken['viewStatus'] != 'Responded by customer') && (@$formValues['status']['status'] != 'Approved E Quote'))
                                                <tr>
                                                    @if(@$Insurer)
                                                    <input type="hidden" id="count" value="{{count($Insurer)}}">
                                                        @foreach(@$Insurer as $key =>$insure)
                                                            <td>
                                                                <div class="ans">
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="insurer_id[]" value="{{$insure['uniqueToken']}}">
                                                                        <input @if (@$insure['customerDecision']['comment'])
                                                                            value="{{@$insure['customerDecision']['comment']}}"
                                                                        @endif type="text" name="comment_{{$insure['uniqueToken']}}" class="form-control  decision_{{$insure['uniqueToken']}}"  placeholder="Comments">
                                                                    </div>
                                                                    <div @if (@$insure['customerDecision']['decision'] != 'Rejected')
                                                                            style="display:none;"
                                                                        @endif  id="rejectBox_{{$insure['uniqueToken']}}" class="form-group selectreason">
                                                                        <select name="reason_{{$insure['uniqueToken']}}" onchange="messageCheck(this)" id="process_drop_{{$insure['uniqueToken']}}" class="form-control selectpicker" data-hide-disabled="true" data-live-search="true">
                                                                            <option @if (@$insure['customerDecision']['rejectReason'] == '')
                                                                            selected
                                                                        @endif  value="">Select reason</option>
                                                                            <option @if (@$insure['customerDecision']['rejectReason'] == 'Another insurance company required')
                                                                                selected
                                                                            @endif value="Another insurance company required">Another insurance company required </option>
                                                                            <option @if (@$insure['customerDecision']['rejectReason'] == 'Close the case')
                                                                            selected
                                                                        @endif  value="Close the case">Close the case </option>
                                                                        </select>
                                                                        <label id="process_drop_{{$insure['uniqueToken']}}-error" class="error" for="process_drop_{{$insure['uniqueToken']}}" style="display:none; color: red;">Please select this field</label>
                                                                    </div>
                                                                    <div class="container row radio">
                                                                        <div class="col-12 custom-control custom-radio mb-3">
                                                                            <input
                                                                            @if (@$insure['customerDecision']['decision'] == 'Approved')
                                                                                checked
                                                                            @endif
                                                                                name="customer-decision_{{$insure['uniqueToken']}}" onclick="checkApprove(this, '{{$insure['uniqueToken']}}')" value="Approved" class="custom-control-input decision_{{$insure['uniqueToken']}}" id="Approve_{{$insure['uniqueToken']}}" type="radio">
                                                                            <label class="custom-control-label" for="Approve_{{$insure['uniqueToken']}}">Approve</label>
                                                                        </div>
                                                                        <div class="col-12 custom-control custom-radio mb-3">
                                                                            <input name="customer-decision_{{$insure['uniqueToken']}}" onclick="notApprove(this, '{{$insure['uniqueToken']}}')"
                                                                            @if (@$insure['customerDecision']['decision'] == 'Rejected')
                                                                                checked
                                                                            @endif value="Rejected" class="custom-control-input  decision_{{$insure['uniqueToken']}}" id="Reject_{{$insure['uniqueToken']}}"  type="radio">
                                                                            <label class="custom-control-label" for="Reject_{{$insure['uniqueToken']}}">Reject</label>
                                                                        </div>
                                                                        <div class="col-12 custom-control custom-radio mb-3">
                                                                            <input
                                                                            @if (@$insure['customerDecision']['decision'] == 'Requested for amendment')
                                                                                checked
                                                                            @endif
                                                                            name="customer-decision_{{$insure['uniqueToken']}}" onclick="notApprove(this, '{{$insure['uniqueToken']}}')" value="Requested for amendment" class="custom-control-input  decision_{{$insure['uniqueToken']}}" id="Amend_{{$insure['uniqueToken']}}"  type="radio">
                                                                            <label class="custom-control-label" for="Amend_{{$insure['uniqueToken']}}">Approved with Amendement required</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endif
                                        @endif
                                        <input type="hidden" name="workTypeDataId" value="{{$formValues['_id']}}">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <label id="decision-error" class="error" style="display: none; color:red; width: 100%;margin: 8px 0;">Please select a decision.</label>
        </div>
    </form>

<!-- {{-- @include('popup.mail_attachment') --}} -->

<!------------------------------------------------modal-------------------------------->
<div class="modal fade" id="questionnaire_popup" tabindex="-1" role="dialog" aria-labelledby="questionnaire_popup" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
            <div class="modal-content  ">
                <form id="quest_send_form" name="quest_send_form">
                    <div class="modal-body">
                        <input type="hidden" id="workTypeDataId" name="workTypeDataId" value="{{@$workTypeDataId}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold">Enter To email address<span style="visibility:hidden">*</span></label>
                                    <input class="form-control" @if (@$formValues->getCustomer->email[0])
                                    value="{{@$formValues->getCustomer->email[0]}}"
                                @endif  onkeyup="addEmailValidation(this)"  placeholder="Enter To email address" type="email" name="to_email" id="to_email">
                                </div>
                            </div>
                            <label id="maximumLimitCC" class="titile error" style="display:none;">Maximum limit exceeded</label>
                            <div id="ccInputDiv_0" class="row">
                                <div class="col-md-10">
                                    <label class="form_label bold">Enter CC email address<span style="visibility:hidden">*</span></label>
                                    <input class="form-control"  onkeyup="addEmailValidation(this)"  placeholder="Enter CC email address" type="email" name="cc_email[]" id="cc_email_0">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="add btn btn-primary btnForCC plus_button" onclick="addMoreofThisCC(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="titles"><b>Enter any comments</b></label>
                                <textarea class="form-control" id="txt_comment" name= "txt_comment"rows="3" placeholder="Comments"></textarea>
                            </div>
                        </div>
                        <br>
                        @if(@$documents != null)
                            <div class="row">
                                <div class="col-12">
                                    <label class="titles"><b>Please select the files that need to be send</b></label>
                                </div>
                            </div>
                        @endif
                        <div class=" container row checkboxred"  id="attach_div">
                            @if(@$documents != null)
                                @foreach($documents as $data)
                                <div class="col-12 custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input"  type="checkbox" name="files[{{$data->filename}}]" value="{{$data->url}}"id="{{$data->url}}" style="display: none">
                                    <label class="custom-control-label"for="{{$data->url}}">{{$data->filename}}</label>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                <label class="titles"><b> No files available</b></label>
                                </div>
                            @endif

                        </div>

                    </div>
                    <div class="commonbutton modal-footer">
                        <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                        <button type="button" class="btn btn-primary btnload" onclick="submitCustomerForm(this)" id="send_btn"  >OK</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!------modal end-->
            <style>
                .modal-content .form-control{
                    color: #343434;
                }
            </style>
@endsection

@push('widgetScripts')

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


<script>

function lostBusiness(t, workTypeDataId) {
    $(t).attr("disabled", true)
    if (workTypeDataId) {
        $.ajax({
            method: 'post',
            url: '{{url('lost-business')}}',
            data: {
                'workTypeDataId': workTypeDataId,
                _token: '{{csrf_token()}}'
            },
            success:function (data) {
                if (data == 'Sucess') {
                    window.location =  '{{url('policies')}}';
                } else {
                    location.reload();
                }

            }
        });
    }
}

$(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
                $(document).ready(resizeHandler);
                $(window).resize(resizeHandler);
            });
        });
function popupFunction() {
    removeCCValue();
    $('#questionnaire_popup').modal();
    $("#send_customer").attr( "disabled", false );
}
function addEmailValidation(t){
      if($(t).val().trim() != ''){
        $(t).rules( "add" , "customemail" );
      }else {
        $(t).rules( "remove" , "customemail" );
      }
  }


  function messageCheck(obj1)
        {
           var  valueExist=obj1.value;
            if(valueExist == ''){
                $('#'+obj1.id+'-error').show();
            }else{
                $('#'+obj1.id+'-error').hide();
            }
        }

        var flag = 0;
        function checkApprove(obj, id)
        {
            $(".selectreason").hide();
            jQuery("input, textarea")
                .not(".decision_"+id)
                .not(":hidden")
                .removeAttr("checked", "checked").attr("disabled", "disabled");
            $('#decision-error').hide();
            flag = 1;
            $('#rejectBox_'+id+ ' ,.select_reject').hide();
            $('.height_align').hide();
            $('#process_drop_'+id).attr("required",false);
            $('.process').prop("required",false);

        }
        function notApprove(obj, id) {
            $('input[type=radio]:checked').each(function(){
                    if ($(this).val() != 'Approved') {
                        flag = 0;
                    }
                });
            if(obj.value=='Rejected')
            {
                $('#rejectBox_'+id).show();
                $('.height_align').show();
                $('#process_drop_'+id).attr("required",true);
            }else{
                $('#rejectBox_'+id).hide();
                $('.height_align').hide();
                $('#process_drop_'+id).attr("required",false);
            }
            jQuery("input, textarea")
                .removeAttr("disabled", "disabled");
            var count = $('#count').val();
            if($('input[type=radio]:checked').length==count)
            {
                $('#decision-error').hide();
            }
            $(document).ready(resizeHandler);
            $(window).resize(resizeHandler);
        }
        function admin_formSubmit()
        {
            if(flag === 1) {
                console.log("Submitting...", flag);
                console.log("Submitting");
                var form_data = new FormData($("#admin_approve_form")[0]);
                form_data.append('_token',"{{csrf_token()}}");
                form_data.append('responder',"admin");
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('customer-decision')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success:function (data) {
                        location.reload();
                    }
                });
                // $('#approve_form').submit();
            } else {
                error = 0;
                $('input[type=radio]:checked').each(function(){
                    if ($(this).val() == 'Rejected') {
                        id = $(this).attr('id').split('_')[1];
                        if($('#process_drop_'+id).val() == '') {
                            error++;
                            $("#process_drop_"+id+'-error').show();
                        } else {
                            $("#process_drop_"+id+'-error').hide();
                        }
                    }
                });
               if (error == 0) {
                var count = $('#count').val();
                if($('input[type=radio]:checked').length==count)
                {
                    console.log("Submitting");
                    var form_data = new FormData($("#admin_approve_form")[0]);
                    form_data.append('_token',"{{csrf_token()}}");
                form_data.append('responder',"admin");
                    $('#preLoader').fadeIn('slow');
                    $.ajax({
                        method: 'post',
                        url: '{{url('customer-decision')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success:function (data) {
                            location.reload();
                        }
                    });
                }
                else
                {
                    $('#decision-error').show();
                }
               }
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
        $(elem).attr( "disabled", true );
        if(is_customer_form_submitted == false) {
            $('#quest_send_form').submit();
            is_customer_form_submitted = true;
        }
    }


$('#quest_send_form').validate({
    ignore: [],
    rules: {},
    messages: {},
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    submitHandler: function (form,event) {
        $("#send_btn").attr( "disabled", true );
        var id = $('#workTypeDataId').val();
        var form_data = new FormData($('#quest_send_form')[0]);
        form_data.append('_token', '{{csrf_token()}}');
        form_data.append('id', id);
        // $("#send_btn").attr( "disabled", true );
        $.ajax({
            method: 'post',
            url: '{{url('send-comparison')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
                location.reload();
            }
        });
    }
});


























//---------------------------for form----------------------------------
$(document).ready(function() {
    $('.removeTr').parent().parent().parent().remove();
});
$(function () {
  let show = 'show';

  $('input').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});


$(function () {
  let show = 'show';

  $('textarea').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});


    // -------------------------------------------for table e quotation------------------------------------------------------------
    function resizeHandler() {
            // Treat each container separately
            $(".heightfix").each(function(i, heightfix) {
                // Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
                // Loop through the tables
                $(heightfix).find("table").each(function(indx, table) {
                    // Loop through the rows of current table
                    $(table).find("tr").css("height", "").each(function(i, tr) {
                        // If there is already a row height defined
                        if (aRowHeights[i])
                        // Replace value with height of current row if current row is higher.
                            aRowHeights[i] = Math.max(aRowHeights[i], $(tr).height());
                        else
                        // Else set it to the height of the current row
                            aRowHeights[i] = $(tr).height();
                    });
                });
                // Loop through the tables in this container separately again
                $(heightfix).find("table").each(function(i, table) {
                    // Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.materialetable tbody tr');

            rows.hover(function(){
                var i = $(this).GetIndex() + 1;
                rows.filter(':nth-child(' + i + ')').addClass('hoverx');
            },function(){
                rows.removeClass('hoverx');
            });
        });

        jQuery.fn.GetIndex = function(){
            return $(this).parent().children().index($(this));
        }
</script>
<script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
