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
                        @include('pipelines.fire_perils.form_includes.e_questionnaire_form')

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

function numberWithCommas(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1,$2");
            return x;
        }
        function amountTest(value){
//            debugger;
            var stringvalue=value.toString();
            return Number(stringvalue.replace(/\,/g, ''));
        }

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

});    $("input.number").keyup(function(event){

// skip for arrow keys
if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
}
var $this = $(this);
//            console.log('this'+ $this);
var num = $this.val().replace(/,/gi, "");
var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
// the following line has been simplified. Revision history contains original.
$this.val(num2);
});

//function for calculatiing total value
    function calculate()
    {

        var building_include=amountTest($('#building_include').val());
       var stock=amountTest(($('#stock').val()));
       var finished_goods=amountTest($('#finished_goods').val());
       var raw_materials=amountTest($('#raw_materials').val());
       var machinery=amountTest($('#machinery').val());
       var sign_boards=amountTest($('#sign_boards').val());
       var furniture=amountTest($('#furniture').val());
       var office_equipments=amountTest($('#office_equipments').val());
       var annual_rent=amountTest($('#annual_rent').val());
    //    var other_items=amountTest($('#other_items').val());
      
       var total_value=building_include+stock+finished_goods+raw_materials+machinery+sign_boards+furniture+office_equipments+annual_rent;
       
       total_value=numberWithCommas(total_value.toFixed(2));
       if(total_value!='')
       $('#total').val(total_value);
    }

$('#occupancy').change(function () {
            var occupancy = $('#occupancy').val();

                if(occupancy=='Others')
                {
                   $('#occupancy_other').show();
                }
                else{
                    $('#occupancy_other').hide();  
                }
        });
// occupancy-others (show and hide)
$('#occupancy').change(function () {
            var occupancy = $('#occupancy').val();

                if(occupancy=='Warehouse')
                {
                   $('#warehouse_other').show();
                }
                else{
                    $('#warehouse_other').hide();  
                }
        });
// occupancy-others (show and hide)

$('#occupancy').change(function () {
            var occupancy = $('#occupancy').val();

                if(occupancy=='Warehouse')
                {
                   $('#single_other').show();
                }
                else{
                    $('#single_other').hide();  
                }
        });
// occupancy-others (show and hide)

$('#hazardous_material').change(function () {
            var hazardous_material = $('#hazardous_material').val();
            
                if(hazardous_material=='yes')
                {
                   $('#hazardous_yes').show();
                }
                else{
                    $('#hazardous_yes').hide();  
                }
        });
// hazardous_material (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='roof')
                {
                   $('#roof').show();
                }
                else{
                    $('#roof').hide();  
                }
        });
// Roof Construction (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='walls')
                {
                   $('#walls').show();
                }
                else{
                    $('#walls').hide();  
                }
        });
// Walls Construction (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='floor')
                {
                   $('#floor').show();
                }
                else{
                    $('#floor').hide();  
                }
        });
// Floor Construction (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='Cladding')
                {
                   $('#cladding_show').show();
                }
                else{
                    $('#cladding_show').hide();  
                }
        });
$('#construction_walls').change(function () {
            var valueSelect = $('#construction_walls').val();
            
                if(valueSelect=='Cladding')
                {
                   
                   $('#cladding_show').show();
                }
                else{
                    $('#cladding_show').hide();  
                }
        });     
// cladding Construction (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='yearofconstruction')
                {
                   $('#yearofconstruction').show();
                }
                else{
                    $('#yearofconstruction').hide();  
                }
        });
// year of construction (show and hide)

$('#Construction').change(function () {
            var Construction = $('#Construction').val();
            
                if(Construction=='numberofstories')
                {
                   $('#numberofstories').show();
                }
                else{
                    $('#numberofstories').hide();  
                }
        });
// Number of stories (show and hide)

$('#fighting_facilities').change(function () {
            var fighting_facilities = $('#fighting_facilities').val();

                if(fighting_facilities=='Others')
                {
                   $('#fighting_other').show();
                }
                else{
                    $('#fighting_other').hide();  
                }
        });
// fighting_facilities (show and hide)

$('#security_guard').change(function () {
            var security_guard = $('#security_guard').val();

                if(security_guard=='Others')
                {
                   $('#security_other').show();
                }
                else{
                    $('#security_other').hide();  
                }
        });
// Security Guards available (show and hide)


// $('#water_storage').change(function () {
//             var water_storage = $('#water_storage').val();

//                 if(water_storage=='yes')
//                 {
//                    $('#water_yes').show();
//                 }
//                 else{
//                     $('#water_yes').hide();  
//                 }
//         });

        // $('#water_storage').change(function () {
        //     var water_storage = $('#water_storage').val();

        //         if(water_storage=='yes')
        //         {
        //            $('#lts').show();
        //         }
        //         else{
        //             $('#lts').hide();  
        //         }
        // });

        $('#water_storage').change(function () {
            var water_storage = $('#water_storage').val();

                if(water_storage=='yes')
                {
                    $('#water_yes').show();
                   $('#gallons').show();
                }
                else{
                    $('#water_yes').hide(); 
                    $('#gallons').hide();  
                }
        });
// Water storage for fire fighting (show and hide)

$('#business_interruption').change(function () {
            // debugger;
            var business_interruption = $('#business_interruption').val();
            $('#claim_experience_details').selectpicker('refresh');
            if(business_interruption=='no')
            {
                $('#business_yes').hide();
                $("#claim_experience_details option[value='separate_fire']").addClass('disable_val');
                $("#claim_experience_details option[value='combined_data']").addClass('disable_val');
                $("#claim_experience_details option[value='only_fire']").removeClass('disable_val');
                $('#fire_perils').hide();
                // if($('#is_edit').val()==1)
                // {
                    $('#claim_experience_details').val('');
                // }
                $('#claim_experience_details').selectpicker('refresh');
                

            }
            else if(business_interruption=='yes'){
                $("#claim_experience_details option[value='only_fire']").addClass('disable_val');

                $("#claim_experience_details option[value='separate_fire']").removeClass('disable_val');
                $("#claim_experience_details option[value='combined_data']").removeClass('disable_val');
                // if($('#is_edit').val()==1)
                // {
                    $('#claim_experience_details').val('');
                // }
                $('#business_yes').show();  
                $('#claim_experience_details').selectpicker('refresh');
            }else{
                $('#business_yes').hide(); 
            }
            var claim_data;
            var claim_value =$('#claim_experience_details').val();
            if(claim_value=='combined_data')
           {
            claim_data='Combined data for Fire & Perils and Business interruption coverages';
            $('#fire_perils').hide();
           }else if(claim_value=='only_fire')
           {
            claim_data='Only Fire and Perils';
            $('#fire_perils').hide();

           }else if(claim_value=='separate_fire')
           {
            claim_data='Fire and Perils';
            $('#fire_perils').show();
           }
           else{
            claim_data='Claim Experience';
           }
           $('#claim_label').html(claim_data);
        });    
// Business Interruption cover Required (show and hide)

$('#percentage_cladding').change(function () {
            var cladding_presence = $('#percentage_cladding').val();
            
                if(cladding_presence=='Others') 
                {
                   $('#cladding_other_div').show();
                }
                else{
                    $('#cladding_other_div').hide();  
                }
        });
       function validation(id) {
        if(id=='business_interruption')
         {
             $('.disable_val').closest('a').addClass('disable_a'); 
         }
           if($('#'+id).val()=='')
           {
               $('#'+id+'-error').show();
           }else{
            $('#'+id+'-error').hide();
           }
       }
// claim_experience(show and hide)

$(function () {
        $("#flightCover4").click(function () {
            if ($(this).is(":checked")) {
                $("#fire_fighting").show();
                
            } else {
                $("#fire_fighting").hide();
               
            }
        });
    });

    $('#claim_experience_details').change(function(){
           var claim_data;
           var claim_value =$('#claim_experience_details').val();
           if(claim_value=='combined_data')
           {
            claim_data='Combined data for Fire & Perils and Business interruption coverages';
            $('#fire_perils').hide();
           }else if(claim_value=='only_fire')
           {
            claim_data='Only Fire & Perils';
            $('#fire_perils').hide();

           }else if(claim_value=='separate_fire')
           {
            claim_data='Fire & Perils';
            $('#fire_perils').show();
           }
           $('#claim_label').html(claim_data);
       });
       $('#bank_policy').change(function () {
            var bank_policy = $('#bank_policy').val();
            if(bank_policy=='yes')
            {
                $('#bank_yes').show();
            }
            else{
                $('#bank_yes').hide();  
            }
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
            company_name: {
                required: true
            },
            no_of_locations: {
                required: true,
                number:true
            },
            locations_risk: {
                required: true
            },
            occupancy: {
                required: true
            },
            other_occupancy: {
                required: function () {
                    return ($("#occupancy").val() == 'Others');
                },
            },
            warehouse_type: {
                required: function () {
                    return ($("#occupancy").val() == 'Warehouse');
                },
            },
            age_building: {
                required: true,
                number:true
            },
            no_of_floors: {
                required: true,
                number:true
            },
            hazardous_material: {
                required: true
            },
            hazardous_reason: {
                required: function () {
                    return ($("#hazardous_material").val() == 'yes');
                },
            },
            roof: {
                required: true
            },
            construction_walls: {
                required: true
            },
            percentage_cladding_other: {
                required: function () {
                    return ($("#percentage_cladding").val() == 'Others');
                }
            },
            percentage_cladding: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                }
            },
            cladding_presence: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_type: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_mat_type: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_fire_rate: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_tech_spec: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_cons_mat: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_ins_mat: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            cladding_facilities: {
                required: function () {
                    return ($("#construction_walls").val() == 'Cladding');
                },
            },
            year_construction: {
               required: true
           },
            floor: {
                required: true
            },
            // number_stories: {
            //     required: true
            // },
            businessType: {
                required: true
            },
            safety_signs: {
                required: true
            },
            'fire_facilities[]': {
                required: true
            },
            civil_defence: {
                required: true
            },
            time_day: {
                required: true,
                number:true
            },
            once_day: {
                required: true,
                number:true
            },
            security_guard: {
                required: true
            },
            burglary_alarm: {
                required: true
            },
            electicity_usage: {
                required: true
            },
            cctv: {
                required: true
            },
            distance: {
                required: true,
                number:true
            },
            water_storage: {
                required: true,
            },
            building_include: {
                required: true,
                number:true

            },
            stock: {
                required: true,
                number:true

            },
            finished_goods: {
                required: true,
                number:true

            },
            raw_materials: {
                required: true,
                number:true

            },
            machinery: {
                required: true,
                number:true

            },
            furniture: {
                required: true,
                number:true

            },
            annual_rent: {
                number:true,
                required: true
            },
            other_items: {
                required: true
            },
            bank_policy: {
                required: true
            },
            business_interruption: {
                required: true
            },
            office_equipments: {
                required: true,
                number:true

            },
            sign_boards: {
                required: true,
                number:true

            },
            claim_experience_details: {
                required: true
            },
            gallons_value: {
                required: function () {
                    return ($("#water_storage").val() == 'yes');
                },
                number:true
            },
            // lts_value: {
            //     required: function () {
            //         return ($("#water_storage").val() == 'yes');
            //     },
            //     number:true
            // },
            fire_other: {
                required: function () {
                    return ($("#flightCover4").is(":checked"));
                },
            },
            security_other: {
                required: function () {
                    return ($("#security_guard").val() == 'Others');
                },
            },
            actual_profit: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true

            },
            estimated_profit: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true

            },
            stand_charge: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true

            },
            no_locations: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true
            },
            cost_work: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true

            },
            rent_loss: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true

            },
            main_cust_name: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
            },
            main_supp_name: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
            },
            indemnity_period: {
                required: function () {
                    return ($("#business_interruption").val() == 'yes');
                },
                number:true
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
            bank_name: {
                required: function () {
                    return ($("#bank_policy").val() == 'yes');
                },
            },
            bank_location: {
                required: function () {
                    return ($("#bank_policy").val() == 'yes');
                },
            },
            bank_po: {
                required: function () {
                    return ($("#bank_policy").val() == 'yes');
                },
            },
            bank_amount: {
                required: function () {
                    return ($("#bank_policy").val() == 'yes');
                },
                number:true
            },
            west: {
                required: true
            },
            south: {
                required: true
            },
            north: {
                required: true
            },
            east: {
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
            lastName: "Please enter last name.",
            company_name: "Please enter the company name.",
            no_of_locations: "Please enter no of locations.",
            locations_risk: "Please enter the locations of the risk.",
            occupancy: "Please select occupancy.",
            other_occupancy: "Please enter other occupancy details .",
            warehouse_type: "Please select warehouse type.",
            age_building: "Please enter age of building.",
            no_of_floors: "Please select no of floors.",
            hazardous_material: "Please select the existence about hazardous material.",
            hazardous_reason: "Please enter the reason.",
            roof: "Please select roof type.",
            construction_walls: "Please select wall type.",
            percentage_cladding_other: "Please enter percentage of cladding details.",
            percentage_cladding: "Please enter percentage of cladding.",
            cladding_presence: "Please select presence of cladding.",
            cladding_type: "Please select cladding type.",
            cladding_mat_type: "Please select cladding material type.",
            cladding_fire_rate: "Please select fire rating of the insulation material used in the cladding.",
            cladding_tech_spec: "Please select technical specification of ACP’s especially on the core material involve.",
            cladding_cons_mat: "Please select material used for construction.",
            cladding_ins_mat: "Please select whether the insulation material or the ACP core is exposed open at any place .",
            cladding_facilities: "Please select available fire fighting facilities .",
            year_construction: "Please select year of construction.",
            floor: "Please select floor type.",
            // number_stories: "Please select number of stories.",
            businessType: "Please select business activity.",
            safety_signs: "Please select safety signs.",
            'fire_facilities[]': "Please select fire fighting facilities.",
            civil_defence: "Please select direct connection to civil defence.",
            time_day: "Please enter number of time/s a day.",
            once_day: "Please enter number of time/s a week.",
            security_guard: "Please select security detals.",
            burglary_alarm: "Please select alarm details.",
            electicity_usage: "Please select electricity details.",
            cctv: "Please select cctv details.",
            distance: "Please enter distance.",
            water_storage: "Please select water storage details.",
            building_include: "Please enter building including compound walls,fencing.",
            stock: "Please enter stock in trade.",
            finished_goods: "Please enter finished and semi-finished goods.",
            raw_materials: "Please enter raw materials.",
            machinery: "Please enter machinery, equipments, tools etc..",
            furniture: "Please enter furniture, fixtures & fittings & decoration.",
            annual_rent: "Please enter annual rent.",
            other_items: "Please enter details of any other item.",
            bank_policy: "Please select  policy to a bank.",
            business_interruption: "Please select business interruption.",
            office_equipments: "Please enter office equipments including computers, fax, photocopy etc.",
            sign_boards: "Please enter sign boards.",
            claim_experience_details: "Please select claim experience details.",
            gallons_value: "Please enter capacity details.",
            // lts_value: "Please enter LTS.",
            fire_other: "Please enter other details.",
            security_other: "Please enter other details.",
            actual_profit: "Please enter actual annual gross profit for the previous year.",
            estimated_profit: "Please enter estimated annual gross profit for the next year.",
            stand_charge: "Please enter standing charges.",
            no_locations: "Please enter no of locations.",
            cost_work: "Please enter increase cost of working.",
            rent_loss: "Please enter loss of rent.",
            main_cust_name: "Please enter main customer name.",
            main_supp_name: "Please enter main suppliers name.",
            indemnity_period: "Please enter period of indemnity.",
            civil_certificate: "Please upload valid certificate.(.png,.jpeg,.jpg,.pdf,.xls)",
            policyCopy: "Please upload valid copy.(.png,.jpeg,.jpg,.pdf,.xls)",
            trade_list: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            vat_copy: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others1: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            others2: "Please upload valid file.(.png,.jpeg,.jpg,.pdf,.xls)",
            bank_name: "Please enter bank  name",
            bank_location: "Please enter bank  location",
            bank_po: "Please enter bank post box",
            bank_amount: {
                required:"Please enter amount",
                number:"Please enter amount"
            },
            west: "Please select west",
            east: "Please select east",
            south: "Please select south",
            north: "Please select north",
        
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "occupancy" ||  element.attr("name") =="once_day" || element.attr("name") == "hazardous_material" || element.attr("name") == "roof" || element.attr("name") == "percentage_cladding"  
            || element.attr("name") == "construction_walls" || element.attr("name") == "floor" || element.attr("name") == "year_construction"
             || element.attr("name") == "safety_signs" || element.attr("name") == "civil_defence"
             || element.attr("name") == "time_day" || element.attr("name") == "security_guard" || element.attr("name") == "burglary_alarm"
             || element.attr("name") == "cctv"  || element.attr("name") == "electicity_usage" || element.attr("name") == "distance" || element.attr("name") == "water_storage"
             || element.attr("name") == "bank_mortage" ||  element.attr("name") == "business_interruption" ||  element.attr("name") == "claim_experience_details" ||  element.attr("name") == "cladding_presence"
             ||  element.attr("name") == "cladding_type" || element.attr("name") == "cladding_mat_type" ||  element.attr("name") == "cladding_fire_rate" ||  element.attr("name") == "cladding_tech_spec"
             ||  element.attr("name") == "cladding_cons_mat" ||  element.attr("name") == "bank_policy" ||  element.attr("name") == "cladding_ins_mat" ||  element.attr("name") == "cladding_facilities")  
            {
                error.insertAfter(element.parent());
            }
            else if(element.attr("name") == "warehouse_type" ||  element.attr("name") == "fire_facilities[]")
            {
                error.insertAfter(element.parent().parent());
            }
            // else if(element.attr("name") == "fire_facilities[]" )
            // {
            //     error.insertAfter(element.parent().parent().parent().parent().parent());
            // }
          
            else {
                error.insertAfter(element);
            }
        },
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
   
    $(document).ready(function(){
        var business_interruption = $('#business_interruption').val();
           var claim_value =$('#claim_experience_details').val();
         
          
            // $('#claim_experience_details').selectpicker('refresh');
            if(business_interruption=='no')
            {
                $('#business_yes').hide();

                $("#claim_experience_details option[value='separate_fire']").addClass('disable_val');
                $("#claim_experience_details option[value='combined_data']").addClass('disable_val');
                $("#claim_experience_details option[value='only_fire']").removeClass('disable_val');
                $('#fire_perils').hide();
                // if($('#is_edit').val()==1)
                // {
                    $('#claim_experience_details').val('');
                // }
                $('#claim_experience_details').selectpicker('refresh');
                $('select[name=claim_experience_details]').val(claim_value);
                $('#claim_experience_details').selectpicker('refresh');
                

            }
            else if(business_interruption=='no'){
                $("#claim_experience_details option[value='only_fire']").addClass('disable_val');

                $("#claim_experience_details option[value='separate_fire']").removeClass('disable_val');
                $("#claim_experience_details option[value='combined_data']").removeClass('disable_val');
                // if($('#is_edit').val()==1)
                // {
                    $('#claim_experience_details').val('');
                // }
                $('#business_yes').show();  
                $('#claim_experience_details').selectpicker('refresh');

                $('select[name=claim_experience_details]').val(claim_value);
                $('#claim_experience_details').selectpicker('refresh');

            }else{
                $('#business_yes').hide(); 
            }
            $('.disable_val').closest('a').addClass('disable_a'); 
            var claim_data;
            
            if(claim_value=='combined_data')
           {
            claim_data='Combined data for Fire & Perils and Business interruption coverages';
            $('#fire_perils').hide();
           }else if(claim_value=='only_fire')
           {
            claim_data='Only Fire and Perils';
            $('#fire_perils').hide();

           }else if(claim_value=='separate_fire')
           {
            claim_data='Fire and Perils';
            $('#fire_perils').show();
           }
           $('#claim_label').html(claim_data);
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
    //end
</script>
<style>
        .disable_a{
            display: none !important;
        }
        /* #time_day-error{
        padding-left: 44px;
    } */
    </style>
@endpush


