@extends('layouts.customer')
@section('content')
    @include('includes.loader')

<main class="layout_content">

    <!-- Main Content -->
    <div class="page_content">
        <div class="section_details">
            <!-- Header -->
            <div class="card_header clearfix">
                <div class="center_logo">
                    <img src="{{ URL::asset('img/main/interactive_logo.png')}}">
                </div>
            </div><!--//END Header -->
            <div class="card_content">
                <form method="post" enctype="multipart/form-data" id="e_quest_form" name="e_quest_form">
                    {{csrf_field()}}
                    <input type="hidden" value="fill_customer" id="filler_type" name="filler_type">
                    <input type="hidden" value="{{$eQuestionnaireid}}" id="id" name="id">
                    <input type="hidden" id="file_url" name="output_url">
                    <input type="hidden" id="file_name" name="output_file">
                    <input type="hidden" @if($form_data) value="1" @else value="0" @endif  id="is_edit" name="is_edit">
                    <div class="edit_sec clearfix">
                        {{--including the form--}}
                        @include('pipelines.money.form_includes.e_questionnaire_form')

                        <?php
                        // if(@$PipelineItems['files']){
                        //     $other_documents = @$PipelineItems['files'];
                        //     $preview_divs = '';
                        //     foreach ($other_documents as $other_document) {
                        //         if($other_document['url']!='' && @$other_document['upload_type']=='e_questionnaire_fancy'){
                        //             $preview_divs .= '<tr class=""><td class="ff_fileupload_preview"><img class="ff_fileupload_preview_image ff_fileupload_preview_image_has_preview" type="button"aria-label="Preview" src='.$other_document['url'].'><span class="ff_fileupload_preview_text"></span></button><div class="ff_fileupload_actions_mobile"><button class="ff_fileupload_remove_file" type="button" aria-label="Remove from list" style="display: inline-block;"></button></div></td><td class="ff_fileupload_summary"><div class="ff_fileupload_filename">'.$other_document['file_name'].'</div><div class="ff_fileupload_fileinfo">Uploaded</div><div class="ff_fileupload_errors ff_fileupload_hidden"></div><div class="ff_fileupload_progress_background ff_fileupload_hidden"><div class="ff_fileupload_progress_bar" style="width: 100%;"></div></div></td><td class="ff_fileupload_actions"><button class="ff_fileupload_remove_file btnDelete" type="button" aria-label="Remove from list"></button><input class="saved_url" type="hidden" value="'.$other_document['url'].'" id="other_document_saved[]" name="other_document_saved[]"><input type="hidden" value="'.$other_document['file_name'].'" id="other_document_saved_name[]" name="other_document_saved_name[]"></td></tr>';
                        //         }
                        //     }
                        // }

                        ?>
                         <?php $count=0;
                            $filecount=0;
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Any Comments <span style="visibility: hidden">*</span></label>
                                    <textarea class="form_input" name="comments" placeholder="Comments..."></textarea>
                                </div>
                            </div>
                        </div>
                         <div class="clearfix">
                                <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Proceed</button>
                                <button class="btn btn-primary btn_action pull-right" name="button_upload" id="button_upload"  style="display:none;background-color: #4cae4c" type="button">Uploading ..</button>
                        </div>
        </div>
                </form>
            </div>
        </div>
    </div><!--//END Main Content -->

    {{-- <div id="active_upload_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>File Upload</h1>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>There is a file upload still in progress.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Ok</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div id="upload_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>File Upload</h1>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Upload or Remove the files from list before proceeding the application.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Ok</button>
                </div>
            </div>
        </div>
    </div> --}}
</main>
@endsection
@push('scripts')
<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>

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






//         //form validation
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
            businessType: {
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
 
        },
        messages: {
            city: "Please enter the city.",
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
            passport:"Please select is the Pasport of the cash carrying employee(s) held at the custody of the Insured when they are not in vacation",
            territorial_limits: "Please enter the territorial limits.",
            civil_certificate: "Please upload valid certificate.(.png,.jpeg,.jpg,.pdf,.xls)",
            policyCopy: "Please upload valid copy.(.png,.jpeg,.jpg,.pdf,.xls)",
            trade_list: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            vat_copy: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others1: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others2: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            agencies: "Please select is money being transited through a agencies.",
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

//        invalidHandler: function(form, validator) {
//            validator.errorList[0].element.focus();
//        },
        submitHandler: function (form,event) {
            /*
            * validation for fancy file upload(not uploaded files in list and uploading active files)
            * */
            // var queued = $('.ff_fileupload_queued');
            // var active = $('.ff_fileupload_uploading, .ff_fileupload_starting');
            // if (queued.length){
            //     $("#upload_popup .cd-popup").toggleClass('is-visible');
            //     return false;
            // }
            // if (active.length){
            //     $("#active_upload_popup .cd-popup").toggleClass('is-visible');
            //     return false;
            // }
            var form_data = new FormData($("#e_quest_form")[0]);
            // form_data.append('output_url',output_url);
            // form_data.append('output_file',output_file);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').fadeIn('slow');
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('customer-fill')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('customer-notification')}}';
                    }
                    else
                    {
                        window.location.href = '{{url('customer-notification')}}';
                    }
                }
            });
        }
    });
   
    $(document).ready(function() {

getState('country1','state1');
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
              
// validation error msg
function validation(id) {
       
       if($('#'+id).val()=='')
       {
           $('#'+id+'-error').show();
       }else{
        $('#'+id+'-error').hide();
       }
   }

//    var count=Number('{{$filecount}}')+1;
//         console.log(count);
//       $(".add_field_button").click(function (e) { //on add input button click
//         e.preventDefault();
//             $('.wrapper').append(
//                 '<div class="row">'+
//                 '<div class="col-md-6 ">'+
//                 '<div class="form_group">'+
//                 '<label class="form_label">Description of the safe per location<span>*</span></label>'+
//                 '<input class="form_input"  name="safe_per_location[]"  id="safe_per_location'+count+'"  type="text">'+
//                 '</div>'+
//                 '</div>'+
//                 '<div class="col-md-2">'+
//                 '<div class="action_btn margin_set" style="margin-top: 10px;">'+
//                 '<button type="button" title="Remove"  class="remove_field" >'+
//                 '<i class="material-icons">remove</i>'+
//                 '</button>'+
//                 '</div>'+
//                 '</div>'+
//                 '</div>');
//         count++;
//         // componentHandler.upgradeDom();
//     });

//     $('.wrapper').on("click",".remove_field", function(e){ //user click on remove text
//         e.preventDefault();
//         $(this).parent().parent().parent('div').remove();
//     });
//     //end
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


