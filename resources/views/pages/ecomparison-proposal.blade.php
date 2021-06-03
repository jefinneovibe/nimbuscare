<!DOCTYPE html>
<html lang="en">
    <head>
    <title>{{$title}}</title>
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
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('widgetStyle/css/style.css?v1')}}">
    </head>
    <style>
        .flex_col {
            width: 50%;
            float: left;
        }
        .flex_col .title {
            padding: .65rem .75rem;
        }
        .flex_table{
            margin-top: 10px;
        }
        </style>
    <body>
<div class="wrapper">
    <div id="mailview">
            <br><br>
        <div class="mycontainer">
            <div class=mailviewheader>
                <div class="d-flex justify-content-between bg-white mb-3">
                <div class="p-2"><h5 class=" blue"><b>Quotation for @if ($basicDetails['name'] != '')
                    {{$basicDetails['name']}}
                @else
                    --
                @endif </b></h5></div>

                    <div class="p-2">
                            <img class="img-responsive"  src="{{URL::asset('img/main/interactive_logo.png')}}">
                    </div>
                </div>
            </div>
            <div class="mailsubheader">
                <table class="table">
                    <tbody>
                        <tr><td ><label class="title"><b class="red">Document ID : </b> @if ($basicDetails['refereneceNumber'] != '')
                            {{ $basicDetails['refereneceNumber']}}
                        @else
                            --
                        @endif</label></td>
                        <td><label class="title"><b class="red">Prepared by :</b> INTERACTIVE Insurance Brokers LLC</label></td>
                    </tr>
                    <tr>
                        <td><label class="title"><b class="red">Prepared for :</b> @if ($basicDetails['customer'] != '')
                            {{$basicDetails['customer']}}
                            @else
                                --
                            @endif</label></td>
                            <td><label class="title"><b class="red">Date :</b>@if ($basicDetails['date']!='')
                                {{$basicDetails['date']}}
                                @else
                                    --
                                @endif</label></td>
                    </tr>
                    <tr>

                        <td colspan="2"><label class="title"><b class="red">Customer ID	 :</b>  @if ($basicDetails['customer_id']!='')
                            {{$basicDetails['customer_id']}}
                            @else
                                --
                            @endif</label></td>
                    </tr>
                    </tbody>
                </table>
                @if ($eQuotationData)
                <?php $pdfView = 0;?>
                @foreach ($eQuotationData['review'] as $reviewData1)
                    @if (isset($reviewData1['pdfView']) && $reviewData1['pdfView'])
                        <?php $pdfView++;?>
                    @endif
                @endforeach
                @if ($pdfView != 0)
                    <div class="flex_table">
                        @foreach ($eQuotationData['review'] as $reviewData)
                            @if (isset($reviewData['pdfView']) && $reviewData['pdfView'])
                                <?php @eval("\$toString = \"{$reviewData['value']}\";");?>
                                @if ($reviewData['type'] != 'cover')
                                    @if ($reviewData['type'] == 'AnnualWages')
                                    <?php @eval("\$str = \"{$reviewData['value']}\";"); ?>
                                    <?php @eval("\$str2 = \"{$reviewData['nonAdminValue']}\";"); ?>
                                    <?php @eval("\$status = \"{$reviewData['valueStatus']}\";"); ?>
                                    <div class="flex_col">
                                        <label class="title">
                                            <b class="red">{{htmlentities(@$reviewData['label'])}} : </b>
                                            @if(@$status == 'admin')
                                                {{@$str}}
                                            @elseif(@$status == 'nonadmin')
                                                {{@$str2}}
                                            @elseif(@$status == 'both')
                                                {{@$str}}, {{@$str2}}
                                            @endif
                                        </label>
                                    </div>
                                    @else
                                        <div class="flex_col">
                                            <label class="title">
                                                <b class="red">{{htmlentities(@$reviewData['label'])}} : </b> {{htmlentities(@$toString)}}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                        @foreach ($eQuotationData['review'] as $reviewData1)
                            @if (isset($reviewData1['pdfView']) && $reviewData1['pdfView'])
                                <?php @eval("\$toString = \"{$reviewData1['value']}\";"); ?>
                                @if ($reviewData1['type'] == 'cover')
                                    <div class="flex_col">
                                        <label class="title">
                                            <b class="red">{{htmlentities(@$toString?:$reviewData1['label'])}} : </b> {{htmlentities(@$reviewData1['statement'])}}
                                        </label>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <br clear="all" />
                    </div>
                @endif
            @endif
            </div>
            <form id="approve_form">
                <div class="dataatable comparesec">
                    <div id="admins">
                        <div class="materialetable">
                            <div  class="tablefixed heightfix commonfix">
                                <div class="table_left_fix">
                                    <div class="materialetable table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><div class="mainsquestion"><b class="blue">Clauses/Extensions</b></div></th>
                                                </tr>
                                            </thead>
                                            <tbody class="syncscroll" name="myElements">
                                                @if($eQuotationData)
                                                <?php $quest_feildName = []; ?>
                                                    @foreach(@$eQuotationData['review'] as $review)
                                                        @if($review['type'] == 'checkbox')
                                                        <?php  $quest_feildName[] =$review['fieldName'];?>
                                                            <tr class="">
                                                                <td><div class="mainsquestion"><label class="titles">{{@$review['label']}}</label></div></td>
                                                                {{-- @if($review['type'] == 'checkbox')
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
                                                                @endif --}}
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @foreach(@$eQuotationData['forms'] as $forms)
                                                        @if(@$forms['fieldName'] != 'brokerage')
                                                        <?php  $quest_feildName[] =$forms['fieldName']; ?>
                                                        <tr class="">
                                                            <td><div class="mainsquestion"><label class="titles">{{@$forms['label']}}</label></div></td>
                                                            {{-- @if(is_array(@$forms['value']))
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
                                                                            --
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
                                                            @endif --}}
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Customer Decision</label></div></td>
                                                    {{-- <td class="main_answer"><div class="ans"></div></td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="table_right_pen">
                                    <div  id="scrollstyle" class="materialetable table-responsive">
                                        <table class="table comparison">
                                            <thead>
                                                <tr>
                                                    @if($Insurer)
                                                        @foreach(@$Insurer as $key =>$insuer)
                                                            <th>
                                                                <div class="ans">
                                                                    {{$insuer['insurerDetails']['insurerName']}}
                                                                </div>
                                                            </th>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                                @if($InsurerData)
                                                <?php unset($InsurerData['brokerage']);?>
                                                    @foreach (@$quest_feildName as $k =>$v)
                                                        <?php
                                                            $key=$v;
                                                            $insurer=@$InsurerData[$v];
                                                            $number=0;
                                                            $insurerCount=count($Insurer);
                                                        ?>
                                                        <tr class="">
                                                            @if(count(@$insurer)>0)
                                                                @foreach(@$insurer as $key1 =>$Insurerr)
                                                                    @if (@$formData[@$Insurerr['fieldName']]['fieldName'] != 'brokerage')
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
                                                                        <td class="color{{$key1}}">
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
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @for($i=0;$i<($insurerCount);$i++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                @if($Insurer)
                                                    <input type="hidden" id="count" value="{{count($Insurer)}}">
                                                    <tr class="">
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
                                                    </tr>
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
                <div class="row  disclaimer">
                    <div class="col-12">
                        <p class="red">Important: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is strictly confidential to its recipients. The document should not be copied,
                            distributed or reproduced in whole or in part, nor passed to any third party without the consent of its owner.</p>
                    </div>
                </div>
                <div class="row justify-content-end commonbutton">
                    <button type="button" onclick="formSubmit()" class="btn btn-primary btnload">
                        SAVE AND SUBMIT
                    </button>
                </div>
            </form>
        </div><!--mycontainer ends-->
    </div><!--mailview ends-->
</div><!--wrapper ends--->


    <!-- jQuery -->
    <script  src="{{ URL::asset('widgetStyle/js/main/jquery-2.2.4.min.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>
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


    <script>
        // PreLoader
        $('.removeTr').parent().parent().parent().remove();
        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
                $(document).ready(resizeHandler);
                $(window).resize(resizeHandler);
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

            $(".selectreason select").each(function () {
                $(this).val("");
            });
            $('.selectpicker').selectpicker('refresh');
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
            } else{
                $(".selectreason select").each(function () {
                    $(this).val("");
                });
                $('.selectpicker').selectpicker('refresh');
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
        function formSubmit()
        {
            if(flag === 1) {
                console.log("Submitting...", flag);
                console.log("Submitting");
                var form_data = new FormData($("#approve_form")[0]);
                form_data.append('_token',"{{csrf_token()}}");
                form_data.append('responder',"customer");
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('customer-decision')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success:function (data) {
                        location.href = "{{url('customer-notification')}}";
                        // if(data == 'success')
                        // {
                        //     location.href = "{{url('customer-notification')}}";
                        // }else {
                        //     location.reload;
                        // }
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
                    var form_data = new FormData($("#approve_form")[0]);
                    form_data.append('_token',"{{csrf_token()}}");
                form_data.append('responder',"customer");
                    $('#preLoader').fadeIn('slow');
                    $.ajax({
                        method: 'post',
                        url: '{{url('customer-decision')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success:function (data) {
                            location.href = "{{url('customer-notification')}}";
                            // if(data == 'success')
                            // {
                            //     location.href = "{{url('customer-notification')}}";
                            // }else {
                            //     location.reload;
                            // }
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
        // $('#approve_form').validate({
        //     ignore:[],
        //     rules:{},
        //     submitHandler: function (form,event) {
        //         console.log("Submitting");
        //         var form_data = new FormData($("#approve_form")[0]);
        //         form_data.append('_token',"{{csrf_token()}}");
        //         $('#preLoader').fadeIn('slow');
        //         $.ajax({
        //             method: 'post',
        //             url: '{{url('customer-decision')}}',
        //             data: form_data,
        //             cache : false,
        //             contentType: false,
        //             processData: false,
        //             success:function (data) {
        //                 location.href = "{{url('customer-notification')}}";
        //                 // if(data == 'success')
        //                 // {
        //                 //     location.href = "{{url('customer-notification')}}";
        //                 // }else {
        //                 //     location.reload;
        //                 // }
        //             }
        //         });
        //     }
        // });
    </script>

    <script src="{{URL::asset('widgetStyle/js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('widgetStyle/js/main/additional-methods.min.js')}}"></script>
    <script src="{{URL::asset('js/syncscroll.js')}}"></script>
    @stack('widgetScripts')
    </body>
</html>
