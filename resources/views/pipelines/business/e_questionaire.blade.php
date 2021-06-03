
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
    </style>
      <?php $pipeline_details = $PipelineItems ?>
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">business interruption</h3>
        </div>
        <div class="card_content">
            <form id="e_quest_form" name="e_quest_form" method="post" enctype="multipart/form-data">
                
                {{csrf_field()}}
               <?php $url=URL::previous();
	            $set_value=0;
	            if (strpos($url, 'e-slip') !== false) {
		            $set_value=1;
	            }
	            else{
		            $set_value=0;
                }
                ?>
                 <input type="hidden" value="{{$eQuestionnaireid}}" id="id" name="id">
                  <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$eQuestionnaireid}}">
                    <input type="hidden" value="fill_underwriter" id="filler_type" name="filler_type">
                <input type="hidden" @if($form_data) value="1" @else value="0" @endif  id="is_edit" name="is_edit">
                @if(session('message'))
                    <input type="hidden" value="success" id="success">
                @else
                    <input type="hidden" value="failed" id="success">
                @endif
            <div class="edit_sec clearfix">

                <!-- Steps -->
                <section>
                    <nav> <ol class="cd-breadcrumb triangle">
                            @if(($PipelineItems['status']['status']=='E-questionnaire')|| ($PipelineItems['status']['status']=='Worktype Created'))
                            <li class="current"><em>E-Questionnaire</em></li>
                            <li><em>E-Slip</em></li>
                            <li><em>E-quotation</em></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='E-slip')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="current"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li><em>E-quotation</em></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='E-quotation')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="current"><a href="{{url('business_interruption/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='E-comparison')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="current"><a href="{{url('business_interruption/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='Approved E Quote')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li class="current"><a href="{{url('business_interruption/approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='Quote Amendment')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('business_interruption/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('business_interruption/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                        {{--@elseif($PipelineItems['status']['status']=='Issuance')--}}
                            {{--<li class="complete"><em>E-Questionnaire</em></li>--}}
                            {{--<li class="complete"><a href="{{url('e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                            {{--<li class="current"><a href="{{url('issuance/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                        @else
                            <li class="current"><em>E-Questionnaire</em></li>
                            <li><em>E-Slip </em></li>
                            <li><em>E-quotation</em></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}

                        @endif
                        </ol>
                    </nav>
                </section>

                @include('pipelines.business.form_includes.e_questionnaire_form')
                
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="form_group">--}}
                            {{--<label class="form_label">Any Comments <span style="visibility: hidden">*</span></label>--}}
                            {{--<textarea class="form_input" name="comments" placeholder="Comments..."></textarea>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
<div class="clearfix">
                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Proceed</button>
                {{-- <button class="btn btn-primary btn_action pull-right" name="button_upload" id="button_upload"  style="display:none;background-color: #4cae4c" type="button">Uploading ..</button> --}}
                @if(@$PipelineItems['status']['status']!="Approved E Quote")
                <button type="button" data-modal="questionnaire_popup" class="btn blue_btn btn_action pull-right" id="btn-send">Send to Customer</button>
                @endif
                <button type = "button" class="btn blue_btn pull-right btn_action" id="qs_save">Save as Draft</button>
</div>
            </div>
            </form>
        </div>
    </div>

    @include('includes.mail_popup')
    @include('includes.chat')
@endsection

@push('scripts')
    <!--jquery validate-->
 <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
 <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>


<!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>


<style>
.sdfdsf{
    display: none !important;
}
</style>
<script>


var new_num;
$("input.number").keyup(function(event){

    //   debugger;
    var $this = $(this);
    var num =  $this.val();
    var num_parts = num.toString().split(".");
    
    if(num_parts[1]){
     
            if(num_parts[1].length >2){
                num2 = new_num;
               
            } else{
                num_parts[0] = num_parts[0].replace(/,/gi, "");
                num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                var num2 = num_parts.join(".");
                new_num = num2;
                
            }
      
        
    } else{
        num_parts[0] = num_parts[0].replace(/,/gi, "");
        num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
        var num2 = num_parts.join(".");
        new_num = num2;
    
    }
    $this.val(num2);

});

          
// validation error msg
       function validation(id) {
       
           if($('#'+id).val()=='')
           {
               $('#'+id+'-error').show();
           }else{
            $('#'+id+'-error').hide();
           }
       }
//form validation
    $('#e_quest_form').validate({
        ignore: [],
        rules: { 
            salutation: {
                required: true
            },
            firstName: {
                required: true
            },
            lastName: {
                required: true
            },
            addressLine1: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            zipCode: {
                required: true
            },
            company_name: {
                required: true
            },
            no_of_locations: {
                required: true,
                
            },
            businessType: {
                required: true
            },
            actual_profit: {
                number:true,
                required: true
            },
            estimated_profit: {
                number:true,
                required:true
            },
          
            stand_charge: {
                required: true,
                number:true
            },
            indemnity_period: {
                required: true,
                number:true
            },
            rent_loss:{
                required: true,
                number:true
            },
            main_cust_name: {
                required: true,
            },
            main_supp_name: {
                required: true,
            },
            // 'claim_amount[]': {
            //     number:true
            // },
            businessType: {
                required: true
            },

        },
        messages: {
            city: "Please enter the city.",
            addressLine1: "Please enter address line 1.",
            country: "Please select the country.",
            state: "Please select the emirates.",
            salutation: "Please select salutation.",
            firstName: "Please enter first name.",
            zipCode: "Please enter valid pin/zip .",
            company_name:"Please enter company name.",
            no_of_locations:"Please enter number of locations.",
            actual_profit: "Please enter actual annual gross profit for the previous year.",
            estimated_profit: "Please enter estimated annual gross profit for the next year.",
            stand_charge: "Please enter standing charges.",
            no_locations: "Please enter no of locations.",
            cost_work: "Please enter increase cost of working.",
            rent_loss: "Please enter loss of rent.",
            main_cust_name: "Please enter main customer name.",
            main_supp_name: "Please enter main suppliers name.",
            indemnity_period: "Please enter period of indemnity.",
            lastName: "Please enter last name.",
            // 'claim_amount[]':"Please enter number",
            businessType: "Please select business activity.",
       

        
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "city" || element.attr("name") == "addressLine1" || element.attr("name") == "salutation" || element.attr("name") == "firstName"
             || element.attr("name") == "zipCode" || element.attr("name") == "actual_profit" || element.attr("name") == "estimated_profit"
             || element.attr("name") == "stand_charge" || element.attr("name") == "no_locations" || element.attr("name") == "cost_work"
             || element.attr("name") == "rent_loss"  || element.attr("name") == "main_cust_name" || element.attr("name") == "main_supp_name" || element.attr("name") == "indemnity_period"
             || element.attr("name") == "lastName")
            {
                error.insertAfter(element);
            }
            else if(element.attr("name") == "businessType"  )
            {
                error.insertAfter(element.parent());
            }
            // else if(element.attr("name") == "claim_amount[]" )
            // {
            //     error.insertAfter(element.parent().parent().parent().parent().parent());
            // }
          
            else {
                error.insertAfter(element);
            }
        },

        submitHandler: function (form,event) {
            var form_data = new FormData($("#e_quest_form")[0]);
            // form_data.append('output_url',output_url);
            // form_data.append('output_file',output_file);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('business_interruption/equestionnaire-save')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('business_interruption/e-slip/'.$eQuestionnaireid)}}';
                    }
                }
            });
            console.log("validation succes");
        }
     });

    $(document).ready(function() {

        getState('country1','state1');
        $('#safe_location').hide();
        });
//        
// function upload_file(obj)
// {
//     var id=obj.id;
//     var fullPath =  obj.value;
//     if(fullPath=='')
//             {
//                 $('#'+'id'+'-error').show();
//             }
//             else{
//                 $('#'+'id'+'-error').hide();
//             }
//             var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
//             var filename = fullPath.substring(startIndex);
//             if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
//                 filename = filename.substring(1);
//             }
// //            console.log(filename);
//             $('.remove_file_upload').show();
// if(id=='civil_certificate')
// {
//             $('#civil_p').text(filename);
// }
// else if(id=='policyCopy')
// {
//             $('#policy_p').text(filename);
// }
// else if(id=='trade_list')
// {
//             $('#trade_list_p').text(filename);
// }
// else if(id=='vat_copy')
// {
//             $('#vat_copy_p').text(filename);
// }
// else if(id=='others1')
// {
//             $('#others1_p').text(filename);
// }
// else if(id=='others2')
// {
//             $('#others2_p').text(filename);
// }
// }

    function getState(country_div_id,state_div_id, state) {

        // validation start
        var country = $("#country1 :selected").val();
        if(country == ''){
            $('#country1-error').show();
        }else{
            $('#country1-error').hide();
        }
        //end
        var country_id = $('#'+country_div_id).val();
        $.ajax({
            type: "POST",
            url: "{{url('get-states')}}",
            data:{country_name : country_id,pipeline_id :'<?php echo $eQuestionnaireid;?>'  , _token : '{{csrf_token()}}'},
            success: function(data){
                $('#state1').selectpicker('destroy');
                $('#'+state_div_id).html(data);
                $('#state1').selectpicker('setStyle');
            }
        });
    }
    
    $('#btn-send').on('click', function () {
            $("#send_btn").attr( "disabled", false );
            $('#questionnaire_popup .cd-popup').addClass('is-visible');
            var id = $('#pipeline_id').val();
            $.ajax({
                method: 'get',
                url: '{{url('email-file')}}',
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
        function sendQuestion() {
        var form_data = new FormData($("#quest_send_form")[0]);
        var id = $('#pipeline_id').val();
        form_data.append('id',id);
        form_data.append('_token', '{{csrf_token()}}');
        $('#preLoader').show();
        $("#send_btn").attr( "disabled", true );
        // $("#button_submit").attr( "disabled", "disabled" );
        $.ajax({
            method: 'post',
            url: '{{url('business_interruption/send-questionnaire')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result!= 'failed') {
                    $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                    $('#preLoader').hide();
                    $('#success_message').html(result);
                    $('#success_popup .cd-popup').addClass('is-visible');
                    $("#send_btn").attr( "disabled", false );
                }
                else
                {
                  
                    $("#send_btn").attr( "disabled", false );
                    $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                    $('#preLoader').hide();
                    $('#success_message').html('E-questionnaire already filled.');
                    $('#success_popup .cd-popup').addClass('is-visible');
                }
            }
        });
    }
    $( "#qs_save" ).click(function() {
        $( "#button_submit" ).attr('disabled',true);
        $( "#btn-send" ).attr('disabled',true);
        $( "#qs_save" ).attr('disabled',true);
         $('#btn-send').hide();
          saveQuestionnaire();
            

    });
    function saveQuestionnaire()
    {
        var form_data = new FormData($("#e_quest_form")[0]);
        form_data.append('is_save','true');
        form_data.append('_token', '{{csrf_token()}}');
        $('#preLoader').show();
        $.ajax({
            method: 'post',
            url: '{{url('business_interruption/equestionnaire-save')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
            
                $('#btn-send').show();
                    $('#preLoader').hide();
                    if(result == 'success')
                    {
                        $( "#button_submit" ).removeAttr('disabled');
                        $( "#btn-send" ).removeAttr('disabled');
                        $( "#qs_save" ).removeAttr('disabled');
                        $('#success_message').html('E-Questionnaire is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $( "#button_submit" ).removeAttr('disabled');
                        $( "#btn-send" ).removeAttr('disabled');
                        $( "#qs_save" ).removeAttr('disabled');
                        $('#success_message').html('E-Questionnaire saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
        });
    }
</script>

<style>
    .disable_a{
        display: none !important;
    }
</style>
@endpush


