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
                        @include('pipelines.business.form_includes.e_questionnaire_form')

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

// validation error msg
function validation(id) {
       
       if($('#'+id).val()=='')
       {
           $('#'+id+'-error').show();
       }else{
        $('#'+id+'-error').hide();
       }
   }




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
            company_name:"Please enter company name.",
            no_of_locations:"Please enter number of locations.",
            zipCode: "Please enter valid pin/zip .",
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
            if(element.attr("name") == "city" || element.attr("name") == "addressLine1" ||  element.attr("name") == "salutation" || element.attr("name") == "firstName"
             || element.attr("name") == "zipCode" || element.attr("name") == "actual_profit" || element.attr("name") == "estimated_profit"
             || element.attr("name") == "stand_charge" || element.attr("name") == "no_locations" || element.attr("name") == "cost_work"
             || element.attr("name") == "rent_loss"  || element.attr("name") == "main_cust_name" || element.attr("name") == "main_supp_name" || element.attr("name") == "indemnity_period"
             || element.attr("name") == "lastName")
            {
                error.insertAfter(element);
            }
            else if(element.attr("name") == "businessType")
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

    //end
</script>
<style>
        .disable_a{
            display: none !important;
        }
    </style>
@endpush


