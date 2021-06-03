
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
            <h3 class="title" style="margin-bottom: 8px;">Money</h3>
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
                            <li class="current"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li><em>E-quotation</em></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='E-quotation')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="current"><a href="{{url('money/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='E-comparison')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('money/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="current"><a href="{{url('money/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='Approved E Quote')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('money/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="complete"><a href="{{url('money/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li class="current"><a href="{{url('money/approved-quot/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($PipelineItems['status']['status']=='Quote Amendment')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('money/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('money/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                            <li class="active_arrow"><em>E-Questionnaire</em></li>
                            <li class="complete"><a href="{{url('money/e-slip/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('money/e-quotation/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('money/quot-amendment/'.$eQuestionnaireid)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
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

                @include('pipelines.money.form_includes.e_questionnaire_form')
                
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


//         $("input.number").keyup(function(event){

//             // skip for arrow keys
//             if(event.which >= 37 && event.which <= 40){
//                 event.preventDefault();
//             }
//             var $this = $(this);
// //            console.log('this'+ $this);
//             var num = $this.val().replace(/,/gi, "");
//             var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
//             // the following line has been simplified. Revision history contains original.
//             $this.val(num2);
//         });
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
            transit_routes: {
                required: true
            },
            location: {
                required: true,
                
            },
            territorial_limits: {
                required: true
            },
            money1: {
                required: true,
                number:true
            },
            money2: {
                required: true,
                number:true
            },
            money3: {
                required: true,
                number:true
            },
            money4: {
                required: true,
                number:true
            },
            money5: {
                required: true,
                number:true
            },
            money6: {
                required: true,
                number:true
            },
            passport: {
                required: true
            },
            agencies: {
                required: true
            },
            // 'claim_amount[]': {
            //     number:true
            // },
          
            'safe_per_location[]': {
                required: true
            },
            civil_certificate: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            policyCopy: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            trade_list: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            vat_copy: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            others1: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },
            others2: {
                accept: "image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            },  
            policyTo: {
                greaterThan: "#policyFrom",
                required:true
            },
            policyFrom: {
                required: true
            },
            businessType: {
                required: true
            },

        },
        messages: {
            city: "Please enter the city.",
            agencies: "Please select is money being transited through a agencies.",
            businessType: "Please select bussiness type.",
            addressLine1: "Please enter address line 1.",
            country: "Please select the country.",
            state: "Please select the emirates.",
            salutation: "Please select salutation.",
            firstName: "Please enter first name.",
            zipCode: "Please enter valid pin/zip .",
            lastName: "Please enter last name.",
            transit_routes: "Please enter the transit route.",
            location: "Please enter locations.",
            territorial_limits: "Please enter the territorial limits.",
            civil_certificate: "Please upload valid certificate.(.png,.jpeg,.jpg,.pdf,.xls)",
            policyCopy: "Please upload valid copy.(.png,.jpeg,.jpg,.pdf,.xls)",
            trade_list: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            vat_copy: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others1: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others2: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            policyTo:{
                'required':"Please enter to date",
                'greaterThan' :'Please enter a date greater than from date'},
            policyFrom:"Please enter from date",
            money1:{
                'required':"Please enter limit of money in transit any one loss ",
                'number' :'Please enter number'
                },
            money2:{
                'required':"Please enter limit of money while in Locked/ Safe room ",
                'number' :'Please enter number'
            },
            money3:{
                'required':"Please enter limit of money while in office premises during working hours ",
                'number' :'Please enter number'
            },
            money4:{
                'required':"Please enter limit of money at private dwellings of employees / directors ",
                'number' :'Please enter number'
            },
            money5:{
                'required':"Please enter limit of money in premises during Business Hours ",
                'number' :'Please enter number'
            },
            money6:{
                'required':"Please enter estimated annual carrying ",
                'number' :'Please enter number'
            },
            passport:"Please select is the Pasport of the cash carrying employee(s) held at the custody of the Insured when they are not in vacation",
            // 'claim_amount[]':"Please enter number",
            'safe_per_location[]':"Please fill safe per location"

        
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "occupancy" || element.attr("name") == "hazardous_material" || element.attr("name") == "roof"  
            || element.attr("name") == "construction_walls" || element.attr("name") == "floor" || element.attr("name") == "year_construction"
             || element.attr("name") == "number_stories" || element.attr("name") == "safety_signs" || element.attr("name") == "civil_defence"
             || element.attr("name") == "time_day" || element.attr("name") == "security_guard" || element.attr("name") == "burglary_alarm"
             || element.attr("name") == "cctv"  || element.attr("name") == "electicity_usage" || element.attr("name") == "distance" || element.attr("name") == "water_storage"
             || element.attr("name") == "bank_mortage" ||  element.attr("name") == "business_interruption" ||  element.attr("name") == "claim_experience_details" ||  element.attr("name") == "cladding_presence"
             ||  element.attr("name") == "cladding_type" || element.attr("name") == "cladding_mat_type" ||  element.attr("name") == "cladding_fire_rate" ||  element.attr("name") == "cladding_tech_spec"
             ||  element.attr("name") == "cladding_cons_mat" ||  element.attr("name") == "cladding_ins_mat" ||  element.attr("name") == "cladding_facilities")
            {
                error.insertAfter(element.parent());
            }
            else if(element.attr("name") == "agencies" ||element.attr("name") == "passport" )
            {
                error.insertAfter(element.parent());
            }
            else if(element.attr("name") == "fire_facilities[]" )
            {
                error.insertAfter(element.parent().parent().parent().parent().parent());
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
                url: '{{url('money/equestionnaire-save')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('money/e-slip/'.$eQuestionnaireid)}}';
                    }
                }
            });
            console.log("validation succes");
        }
     });

    $(document).ready(function() {

        getState('country1','state1');
        // $('#safe_location').hide();
        });
//        
function upload_file(obj)
{
    var id=obj.id;
    var fullPath =  obj.value;
    if(fullPath=='')
            {
                $('#'+'id'+'-error').show();
            }
            else{
                $('#'+'id'+'-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.remove_file_upload').show();
if(id=='civil_certificate')
{
            $('#civil_p').text(filename);
}
else if(id=='policyCopy')
{
            $('#policy_p').text(filename);
}
else if(id=='trade_list')
{
            $('#trade_list_p').text(filename);
}
else if(id=='vat_copy')
{
            $('#vat_copy_p').text(filename);
}
else if(id=='others1')
{
            $('#others1_p').text(filename);
}
else if(id=='others2')
{
            $('#others2_p').text(filename);
}
}

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
            url: '{{url('money/send-questionnaire')}}',
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
            url: '{{url('money/equestionnaire-save')}}',
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

    jQuery.validator.addMethod("greaterThan",
        function(value, element, params) {
            var from = $(params).val().split("/");
            var fromDate = new Date(from[2], from[1] - 1, from[0]);
            var to = $('#policyTo').val().split("/");
            var toDate = new Date(to[2], to[1] - 1, to[0])
            if( toDate>fromDate)
            {
                return toDate>fromDate;
            }
        },'Must be greater than policy from date.');
    jQuery.validator.addMethod("cuttentOrFuture",
        function(value, element, params) {
            var from = $(params).val().split("/");
            var fromDate = new Date(from[2], from[1] - 1, from[0]);
            var d = new Date();
            var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
            var current = strDate.split("/");
            var currentDate = new Date(current[2], current[1] - 1, current[0]);
            if(fromDate>=currentDate)
            {
                return fromDate>=currentDate;
            }
        },'Must be greater than policy from date.');

        $(document).ready(function(){
            materialKit.initFormExtendedDatetimepickers();
                        /*
            * To set end date one year greater from start date (policy)
            * */
            $("#policyFrom").blur( function () {
                var str = $("#policyFrom").val();
                if( /^\d{2}\/\d{2}\/\d{4}$/i.test( str ) ) {
                    var parts = str.split("/");
                    var day = parts[0] && parseInt( parts[0], 10 );
                    var month = parts[1] && parseInt( parts[1], 10 );
                    var year = parts[2] && parseInt( parts[2], 10 );
                    var duration = 1;
                    if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {
                        var expiryDate = new Date( year, month - 1, day );
                        expiryDate.setFullYear( expiryDate.getFullYear() + duration );
                        var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                        var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                        var year = expiryDate.getFullYear();
                        if (day>1)
                        {
                            day = day-1;
                            day = ('0' + day ).slice( -2 );
                        }
                        else
                        {
                            month = month-1;
                            if(month == 1 ||month == 3 ||month==5||month==7||month==8||month==10||month==12)
                            {
                                day = 31;
                            }
                            else
                            {
                                day = 30;
                            }
                            month = ( '0' + month ).slice( -2 );
                        }
                        $("#policyTo").val( day + "/" + month + "/" + year );
                        $("#policyTo-error").hide();

                    }
                }
            });

            var newDay,newMonth,newYear;
            var currentDate = new Date();
            var day = parseInt(currentDate.getDate());
            var month = parseInt(currentDate.getMonth() +1);
            var year = parseInt(currentDate.getFullYear());
            if(day == 31)
            {
                newDay = 30;
            }
            else
            {
                newDay = day;
            }
            if(month!=12 && month!=1)
            {
                newMonth = month + 1;
                newYear = year - 1;

            }
            if(month == 12)
            {
                newMonth = 1;
                newYear = year;
            }
            if(month == 1)
            {
                if(day==29 || day==30 || day==31)
                {
                    newMonth = month+1;
                    newYear = year-1;
                }
                else
                {
                    newMonth = month + 1;
                    newYear = year - 1;
                }

            }
            if(newDay<10)
                newDay = '0'+newDay;
            if(newMonth<10)
                newMonth = '0'+newMonth;
            initialDate = String(newDay+'/'+newMonth+'/'+newYear);
            $('#policyFrom').datetimepicker();
            $('#policyFrom').on('dp.show', function(e) {
                $(this).data('DateTimePicker').date(initialDate);
            });
    })
    $('#businessType').change(function(){
        if($(this).val() != '') {
           $('#businessType-error').hide();
        } else{
            $('#businessType-error').show();
        }
    })

</script>

<style>
    .disable_a{
        display: none !important;
    }
    textarea.form_input.txtsafe{
        min-height: 66px !important;
    }        
</style>
@endpush


