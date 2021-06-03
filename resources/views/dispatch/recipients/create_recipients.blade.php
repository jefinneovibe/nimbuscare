@extends('layouts.dispatch_layout')
@section('content')



    <div class="section_details">

        <div class="card_header clearfix">
			<?php  $route= Route::currentRouteAction();
			if($route=="App\Http\Controllers\DispatchController@editRecipient") {
				$title="Edit Recipient";
			}
			else{
				$title="Add Recipient";
			}?>
            <h3 class="title" style="margin-bottom: 8px;">{{$title}}</h3>
        </div>
        <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Recipient adding failed. There is a repetition in department.
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="post" name="recipient_form" id="recipient_form">
                    {{ csrf_field() }}
                    <input  type="hidden" id="recipient_id" name="recipient_id" value="{{@$recipientDetails->_id}}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form_group">
                                <label class="form_label">Select Type <span>*</span></label>
                                <div class="custom_select customer_dropdown">
                                    <select class="form_input" name="customerType" id="customerType">
                                        @if(!empty($customerTypes))
                                            @forelse($customerTypes as $customerType)
                                                <option value="{{$customerType->is_corporate}}" @if(@$recipientDetails->customerType== $customerType->_id) selected @endif>{{$customerType->name}}</option>
                                                {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}
                                            @empty
                                                No customer types found.
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 corporate">
                            <div class="form_group">
                                <label class="form_label">Corporate Name <span>*</span></label>
                                <input class="form_input" name="corFirstName" id="corFirstName" placeholder="Name" value="{{@$recipientDetails->firstName}}" type="text">
                            </div>
                        </div>

                        <div class="col-md-10 single" style="display: none">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <label class="form_label">Select Salutation <span>*</span></label>
                                        <div class="custom_select">
                                            <select class="form_input" name="salutation" id="salutation" onchange="dropDownValidation();">
                                                <option selected value="" data-display-text="">Select Salutation</option>
                                                <option @if(@$recipientDetails->salutation=="Mr.") selected @endif value="Mr.">Mr.</option>
                                                <option @if(@$recipientDetails->salutation=="Mrs.") selected @endif value="Mrs.">Mrs.</option>
                                                <option @if(@$recipientDetails->salutation=="Ms.") selected @endif value="Ms.">Ms.</option>
                                                <option @if(@$recipientDetails->salutation=="Dr.") selected @endif value="Dr.">Dr.</option>
                                                <option @if(@$recipientDetails->salutation=="Prof.") selected @endif value="Prof.">Prof.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <label class="form_label">Enter First Name <span>*</span></label>
                                        <input class="form_input" name="firstName"  id="firstName" placeholder="First Name" value="{{@$recipientDetails->firstName}}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <label class="form_label">Enter Middle Name <span style="visibility: hidden">*</span></label>
                                        <input class="form_input" name="middleName" id="middleName" value="{{@$recipientDetails->middleName}}" placeholder="Middle Name" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form_group">
                                        <label class="form_label">Enter Last Name <span>*</span></label>
                                        <input class="form_input" name="lastName" value="{{@$recipientDetails->lastName}}" id="lastName" placeholder="Last Name" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Select Agent <span style="visibility: hidden">*</span></label>
                                <div class="custom_select">
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent" onchange="dropDownValidation();">
                                        <option selected value="" data-display-text="">Select Agent</option>
                                        @if(!empty($agents))
                                            @forelse($agents as $agent)
                                                ?php if(isset($agent->empID))
                                                	{
                                                		$name=$agent->name .' ('.$agent->empID.')';
	                                                }
	                                                else{
		                                                $name=$agent->name;
	                                                }?>
                                                <option value="{{$agent->_id}}"@if(@$recipientDetails['agent.id']== $agent->_id) selected @endif>{{$name}}</option>
                                            @empty
                                                No agent available.
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6 add_contact">
                            @if(count(@$recipientDetails->contactNumber)>0)
								<?php $count = 1; ?>
                                @foreach(@$recipientDetails->contactNumber as $number =>$contact_number)
                                    <div class="form_group clearfix">
                                        @if($count==1)
                                            <label class="form_label">Enter Primary Contact Number<span style="visibility: hidden">*</span></label>
                                        @else
                                            <label class="form_label">Another Contact Number <span style="visibility: hidden">*</span></label>
                                        @endif
                                        <div class="table_div">
                                            <div class="table_cell">
                                                <input class="form_input"  name="contactNumber[]" id="contactNumber{{$count}}"  placeholder="Contact No" value="{{@$contact_number}}" type="text">
                                            </div>
                                            <div class="table_cell">
                                                @if($count!=1)
                                                    <div class="remove_btn rm-contact"><i class="fa fa-minus"></i></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if(count(@$recipientDetails->contactNumber)==$count)
                                        <div id="append_contact"></div>
                                        <button class="add_another contact" type="button" >Add Another Contact Number</button>
                                    @endif


									<?php $count++; ?>
                                @endforeach
                            @else
                                <div class="form_group clearfix">
                                    <label class="form_label">Enter Primary Contact Number<span style="visibility: hidden">*</span></label>
                                    <input class="form_input"  name="contactNumber[]" id="contactNumber"  placeholder="Contact No"  type="text">
                                    <div id="append_contact"></div>
                                    <button class="add_another contact" type="button" >Add Another Contact Number</button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 add_email">
                            @if(count(@$recipientDetails->email)>0)
								<?php $count =1; ?>
                                @foreach(@$recipientDetails->email as $email=>$email_id)
                                    <div class="form_group clearfix">
                                        @if($count==1)
                                            <label class="form_label">Enter Primary Email Id <span style="visibility: hidden">*</span></label>
                                        @else
                                            <label class="form_label">Another Email Id<span style="visibility: hidden">*</span></label>
                                        @endif

                                        <div class="table_div">
                                            <div class="table_cell">
                                                <input class="form_input"  name="email[]"  id="email{{$count}}" placeholder="Email Id" value="{{@$email_id}}" type="text">
                                            </div>
                                            <div class="table_cell">
                                                @if($count!=1)
                                                    <div class="remove_btn rm-email"><i class="fa fa-minus"></i></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if(count(@$recipientDetails->email)==$count)
                                        <div id="append_email"></div>
                                        <button class="add_another email" type="button" >Add Another Email ID</button>
                                    @endif
									<?php $count ++; ?>
                                @endforeach
                            @else
                                <div class="form_group clearfix">
                                    <label class="form_label">Enter Primary Email Id<span style="visibility: hidden">*</span></label>
                                    <input class="form_input"  name="email[]"  id="f" placeholder="Email Id" type="text">
                                    <div id="append_email"></div>
                                    <button class="add_another email" type="button" >Add Another Email ID</button>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="card_separation clearfix">
                        <div class="add_department">
                            @if(count(@$recipientDetails->departmentDetails)>0)
								<?php $count_num =1; ?>
                                @foreach(@$recipientDetails->departmentDetails as $dept)
                                    <div class="form_group clearfix ">
                                        {{--@if($count_num==1)--}}
                                        {{--<label class="form_label">Enter department <span>*</span></label>--}}
                                        {{--@endif--}}
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form_group">
                                                    <label class="form_label">Department Name <span style="visibility: hidden">*</span></label>
                                                    <div class="custom_select">
                                                        <select class="form_input seldept" name="department[]" id="department{{$count_num}}" onblur="departmentValidation(this.id,this.value);">
                                                            <option selected value="" data-display-text="">Select Department</option>
                                                            @if(!empty($departments))
                                                                @forelse($departments as $department)
                                                                    <option value="{{$department->_id}}" @if(@$dept['department']== $department->_id) selected @endif>{{$department->name}}</option>
                                                                    {{--<option {{ (old("mainGroup") == $mainGroup->_id? "selected":"") }} value="{{$mainGroup->_id}}" data-display-text="">{{$mainGroup->firstName}}</option>--}}
                                                                @empty
                                                                    No departments found.
                                                                @endforelse
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form_group">
                                                    <label class="form_label">Contact Person <span style="visibility: hidden">*</span></label>
                                                    <input class="form_input"  value="{{@$dept['depContactPerson']}}" name="depContactPerson[]" id="depContactPerson{{$count_num}}" placeholder="Contact Person Name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form_group">
                                                    <label class="form_label">Contact Person Email Id<span style="visibility: hidden">*</span></label>
                                                    <input class="form_input"   value="{{@$dept['depContactEmail']}}" name="depContactEmail[]" id="depContactEmail{{$count_num}}" placeholder="Contact Person Email Id" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form_group">
                                                    <label class="form_label">Contact Person Mobile No<span style="visibility: hidden">*</span></label>

                                                    <div class="table_div">
                                                        <div class="table_cell">
                                                            <input class="form_input"   value="{{@$dept['depContactMobile']}}"  name="depContactMobile[]"  id="depContactMobile{{$count_num}}" placeholder="Contact Person Mobile No" type="text">
                                                        </div>
                                                        @if($count_num!=1)
                                                            <div class="table_cell">
                                                                <div class="remove_btn department_rm"><i class="fa fa-minus"></i></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(count(@$recipientDetails->departmentDetails)==$count_num)
                                            <div id="append_department"></div>
                                            <button class="add_another add_dept" type="button" >Add Another Department</button>
                                        @endif
										<?php $count_num ++; ?>
                                    </div>

                                @endforeach
                            @else
                                {{--<div class="form_group clearfix">--}}
                                <div class="row ">
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label class="form_label">Department Name<span style="visibility: hidden">*</span></label>
                                            <div class="custom_select">
                                                <select class="form_input seldept" name="department[]" id="department"  onchange="departmentValidation(this.id,this.value);">
                                                    <option selected value="" data-display-text="">Select Department</option>
                                                    @if(!empty($departments))
                                                        @forelse($departments as $department)
                                                            <option value="{{$department->_id}}" @if(@$recipientDetails->department== $department->_id) selected @endif>{{$department->name}}</option>
                                                            {{--<option {{ (old("mainGroup") == $mainGroup->_id? "selected":"") }} value="{{$mainGroup->_id}}" data-display-text="">{{$mainGroup->firstName}}</option>--}}
                                                        @empty
                                                            No departments found.
                                                        @endforelse
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label class="form_label">Contact Person<span style="visibility: hidden">*</span></label>
                                            <input class="form_input"  name="depContactPerson[]" id="depContactPerson" placeholder="Contact Person Name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label class="form_label">Contact Person Email Id<span style="visibility: hidden">*</span></label>
                                            <input class="form_input"   name="depContactEmail[]" id="depContactEmail" placeholder="Contact Person Email Id" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label class="form_label">Contact Person Mobile No<span style="visibility: hidden">*</span></label>
                                            <input class="form_input"     name="depContactMobile[]"  id="depContactMobile" placeholder="Contact Person Mobile No" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div id="append_department"></div>
                                <button style="margin-top: -15px;position: relative;z-index: 9;" class="add_another add_dept" type="button">Add Another Department</button>
                                {{--</div>--}}
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Address Line 1<span style="visibility: hidden">*</span></label>
                                <input class="form_input"  value="{{@$recipientDetails->addressLine1}}" name="addressLine1" id="addressLine1" placeholder="Address Line 1" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Address Line 2<span style="visibility: hidden">*</span></label>
                                <input class="form_input" value="{{@$recipientDetails->addressLine2}}"  name="addressLine2" id="addressLine2" placeholder="Address Line 2" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label">Country<span style="visibility: hidden">*</span></label>
                                <div class="custom_select countryDiv">
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="countryName" id="countryName" onblur="dropDownValidation();" onChange="getState('countryName','cityName');">
                                        <option selected value="" data-display-text="">Select Country</option>
                                        @if(!empty($countries))
                                            {{--<option value="{{$country->_id}}" @if(@$recipientDetails->country== $country->_id) selected @endif>{{$country->name}}</option>--}}
                                            {{--                                                <option {{ (old("country") == $country->_id? "selected":"") }} value="{{$country->_id}}" data-display-text="">{{$country->name}}</option>--}}
                                            @foreach($countries as $country)
                                                <option value="{{$country}}"  @if(@$recipientDetails->countryName== $country) selected  @endif>{{$country}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label">Emirate<span style="visibility: hidden">*</span></label>
                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="cityName" id="cityName" onchange="dropDownValidation();">PlaceHolder
                                    <option disabled >Select Emirate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label">City <span style="visibility: hidden">*</span></label>
                                <input class="form_input valid" name="streetName" id="streetName" placeholder="City" type="text" value="{{@$recipientDetails->streetName}}" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form_group">
                                <label class="form_label">Pin/zip <span style="visibility: hidden">*</span></label>
                                <input class="form_input valid" name="zipCode" id="zipCode" placeholder="Pin/Zip" type="text" value="{{@$recipientDetails->zipCode}}" >
                            </div>
                        </div>
                    </div>
					<?php  $route= Route::currentRouteAction();
					if($route=="App\Http\Controllers\DispatchController@editRecipient") {
						$name="Update Recipient";
					}
					else{
						$name="Add Recipient";
					}?>
                    <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">{{$name}}</button>
                </form>
            </div>
        </div>
    </div>
    <div id="department_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Same department name</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link" id="cancel_button">No</button>
                    <button class="btn btn-primary btn_action" id="yes_button">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/custom-select.js')}}"></script>
    <!-- Bootstrap Select -->
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script>

        {{--$('#countryName').selectpicker();--}}
        {{--$(document).on('keyup', '.countryDiv .bs-searchbox input', function (e) {--}}
            {{--var searchData = $(this).val();--}}
            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('get-countries-name')}}",--}}
                {{--data:{searchData :searchData , _token : '{{csrf_token()}}'},--}}
                {{--success: function(data){--}}
                    {{--$('#countryName').html(data.response_country);--}}
                    {{--$('#countryName-error').hide();--}}
                {{--}--}}
            {{--});--}}

            {{--$('#countryName').selectpicker('refresh');--}}
        {{--});--}}

        {{--var currentRequest=null;--}}
        {{--//        $('#countryName').selectpicker();--}}
        {{--$(document).on('keyup', '.countryDiv .bs-searchbox input', function () {--}}
            {{--var searchData = $(this).val();--}}
            {{--currentRequest = jQuery.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('get-countries-name')}}",--}}
                {{--data:{searchData :searchData, _token : '{{csrf_token()}}'},--}}
                {{--beforeSend : function()    {--}}
                    {{--if(currentRequest != null) {--}}
                        {{--currentRequest.abort();--}}
                    {{--}--}}
                {{--},--}}
                {{--success: function(data) {--}}
                    {{--$('#countryName').html(data.response_country);--}}
                    {{--$('#countryName').selectpicker('refresh');--}}

                    {{--$('#countryName-error').hide();--}}
                {{--}--}}
            {{--});--}}

        {{--});--}}

        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
                // localStorage.clear();
            });
        });
        $('#customerType').on('change', function() {
            var customerType = $('#customerType').val();
            if (customerType == "1") {
                $('.corporate').show();
                $('.single').hide();

            }
            else {
                $('.corporate').hide();
                $('.single').show();
            }
        });
        var max_fields = 10; //maximum input boxes allowed
        var wrapper_contact = $(".add_contact"); //Fields wrapper
        var wrapper_email = $(".add_email"); //Fields wrapper
        var wrapper_department = $(".add_department"); //Fields wrapper
        var add_contact_button = $(".contact"); //Add button ID
        var add_email_button = $(".email"); //Add button ID
        var add_department_button = $(".add_dept"); //Add button ID
        var x = 1; //initlal text box count
        $(add_contact_button).click(function (e) { //on add another contact number
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $('#append_contact').append(
                    '<div class="form_group">'+
                    '<label class="form_label" style="visibility: hidden">Enter Contact Number <span style="visibility: hidden">*</span></label>' +
                    '<div class="table_div">' +
                    '<div class="table_cell">' +
                    '<input class="form_input"  name="contactNumber[]"  placeholder="Enter Another Contact No" id="contactNumber_'+x+'" type="text">' +
                    '</div>'+//add input box
                    '<div class="table_cell" >' +
                    '<div class="remove_btn rm-contact"><i class="fa fa-minus"></i></div>' +
                    '</div>'+
                    '</div>'+
                    '</div>');
            }
        });

        var row = 1;
        $(add_email_button).click(function (e) { //on add another email id
            e.preventDefault();
            if (row < max_fields) { //max input box allowed
                row++; //text box increment
                $('#append_email').append(
                    '<div class="form_group">'+
                    '<label class="form_label" style="visibility: hidden">Enter Email Id <span style="visibility: hidden">*</span></label>' +
                    '<div class="table_div">' +
                    '<div class="table_cell">' +
                    '<input class="form_input"  name="email[]"  id="email_'+row+'"  placeholder="Enter Another Email ID" type="text">' +
                    '</div>'+//add input box
                    '<div class="table_cell" >' +
                    '<div class="remove_btn rm-email"><i class="fa fa-minus"></i></div>' +
                    '</div>'+
                    '</div>'+
                    '</div>');
            }
        });

        var depart_row=1;
        var maximum_fields=10;
        $(add_department_button).click(function (e) { //on add another email id
//            create_custom_dropdowns();
            e.preventDefault();
            if (depart_row < maximum_fields) { //max input box allowed
                depart_row++; //text box increment
                $('#append_department').append(
                    '<div class="row">' +
                    '<div class="col-md-3">' +
                    '<div class="form_group">' +
                    '<label class="form_label">Department Name <span style="visibility: hidden">*</span></label>' +
                    '<div class="custom_select">' +
                    '<select class="form_input dept seldept" name="department[]" id="department_'+depart_row+'"  onchange="departmentValidation(this.id,this.value);">' +
                    '<option selected value="" data-display-text="">Select Department</option>' +
                    '@if(!empty($departments))' +
                    '@forelse($departments as $department)' +
                    '<option value="{{$department->_id}}" @if(@$recipientDetails->department== $department->_id) selected @endif>{{$department->name}}</option>' +
                    '@empty' +
                    'No departments found.' +
                    '@endforelse' +
                    '@endif' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form_group">' +
                    '<label class="form_label">Contact Person <span style="visibility: hidden">*</span></label>' +
                    '<input class="form_input" name="depContactPerson[]" id="depContactPerson_'+depart_row+'" placeholder="Contact Person Name" type="text">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form_group">' +
                    '<label class="form_label">Contact Person Email Id<span style="visibility: hidden">*</span></label>' +
                    '<input class="form_input"  name="depContactEmail[]" id="depContactEmail_'+depart_row+'" placeholder="Contact Person Email Id" type="text">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<div class="form_group">' +
                    '<label class="form_label">Contact Person Mobile No <span style="visibility: hidden">*</span></label>' +
                    '<div class="table_div">'+
                    '<div class="table_cell">'+
                    '<input class="form_input"  name="depContactMobile[]"  id="depContactMobile_'+depart_row+'" placeholder="Contact Person Mobile No" type="text">' +
                    '</div>'+
                    '<div class="table_cell">'+
                    '<div class="remove_btn department_rm"><i class="fa fa-minus"></i></div>'+
                    '</div>'+
                    '</div>'+
                    '</div>' +
                    '</div>' +
                    '</div>');
            }
            custom_dropdowns();
        });

        $(wrapper_department).on("click", ".department_rm", function (e) { //user click on remove contact
            e.preventDefault();
            $(this).parent().parent().parent().parent().parent().remove();
            depart_row--;
        });
        $(wrapper_contact).on("click", ".rm-contact", function (e) { //user click on remove contact
            e.preventDefault();
            $(this).parent().parent().parent('div').remove();
            x--;
        });
        $(wrapper_email).on("click", ".rm-email", function (e) { //user click on remove email
            e.preventDefault();
            $(this).parent().parent().parent('div').remove();
            row--;
        });
        $.validator.addMethod("customemail",
            function(value, element) {
                return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            },
            "Please enter a valid email id. "
        );
        function custom_dropdowns() {
            $('select.dept').each(function(i, select) {
                if (!$(this).next().hasClass('dropdown')) {
                    $(this).after('<div class="dropdown ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
                    var dropdown = $(this).next();
                    var options = $(select).find('option');
                    var selected = $(this).find('option:selected');
                    dropdown.find('.current').html(selected.data('display-text') || selected.text());
                    options.each(function(j, o) {
                        var display = $(o).data('display-text') || '';
                        dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
                    });
                }
            });
        }
        //add customer form validation//
        $("#recipient_form").validate({
            ignore: [],
            rules: {
                customerType: {
                    required: true
                },
                salutation: {
                    required:function () {
                        return ($("#customerType").val() == 0);
                    }
                },
                firstName: {
                    required:function () {
                        return ($("#customerType").val() == 0);
                    }
                },
                corFirstName: {
                    required:function () {
                        return ($("#customerType").val() == 1);
                    }
                },
                lastName: {
                    required:function () {
                        return ($("#customerType").val() ==0);
                    }
                },
//                mainGroup: {
//                    required: true
//                },
//                customerLevel: {
//                    required: true
//                } ,
//                agent: {
//                    required: true
//                },
//                addressLine1: {
//                    required: true
//                },
               'contactNumber[]': {
                   number:true,
                   maxlength:15,
                   minlength:10
                //    required:true

               },
               'email[]': {
                email: true
                //    required:true
               },
//                countryName: {
//                    required: true
//                },
//                cityName: {
//                    required: true
//                } ,
               'depContactMobile[]': {
                   number:true,
                   maxlength:15,
                   minlength:10
                //    required:true
               }, 'depContactEmail[]': {
                //    required: true,
                      email: true
               } ,
//                'depContactPerson[]': {
//                    required: true
//                },
//                'department[]': {
//                    required: true
//                } ,
//                zipCode: {
//                    required: true
//                },
//                streetName: {
//                    required: true
//                }
            },
            messages: {
                zipCode: "Please enter zip code.",
                streetName: "Please enter city.",
                'department[]': "Please select department.",
                'depContactPerson[]': "Please enter contact person name.",
                'depContactMobile[]': "Please enter contact person's mobile number.",
                'depContactEmail[]': "Please enter contact person's email id.",
                customerType: "Please select customer type.",
                salutation: "Please select salutation.",
                firstName: "Please enter first name.",
                corFirstName: "Please enter corporate name.",
                lastName: "Please enter last name.",
                mainGroup: "Please select main group.",
                customerLevel: "Please select customer level.",
                // agent: "Please select the agent.",
                addressLine1: "Please enter address line 1.",
                cityName: "Please select the emirates.",
                countryName: "Please select the country.",
                'contactNumber[]':"Please enter valid contact number",
                'email[]':"Please enter valid email id"
            },
            errorPlacement: function (error, element) {
                if(element.attr("name") == "salutation"
                    || element.attr("name") == "customerLevel" || element.attr("name") == "agent" ||
                    element.attr("name") == "countryName" || element.attr("name") == "cityName" )
                {
                    error.insertAfter(element.parent());
                }else if(element.attr("name") == "firstName" || element.attr("name") == "corFirstName"
                    || element.attr("name") == "lastName" || element.attr("name") == "addressLine1" ||  element.attr("name") == "customerCode"
                    || element.attr("name") == "streetName" || element.attr("name") == "contactNumber[]" || element.attr("name") == "email[]" ||
                    element.attr("name") == "depContactPerson[]" || element.attr("name") == "depContactMobile[]" || element.attr("name") == "depContactEmail[]"
                    || element.attr("name") == "zipCode")
                {
                    error.insertAfter(element);
                }
                else {
                    error.insertAfter(element.parent());
                }
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#recipient_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/save-recipients')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('dispatch/recipients')}}';
                        }
                        else if(result=="department_exist")
                        {
                            $('#preLoader').hide();
                            $("#button_submit").attr( "disabled", false );
                            $("#failed_customer").show();
                            setTimeout(function() {
                                $('#failed_customer').fadeOut('fast');
                            }, 5000);
                        }
                        else if (result == 'code_exist')
                        {
                            $('#preLoader').hide();
                            $("#button_submit").attr( "disabled", false );
                            $("#failed_customer").html('Customer adding failed. There is already a customer having same code');
                            $("#failed_customer").show();
                            $("#customerCode").focus();
                            setTimeout(function() {
                                $('#failed_customer').fadeOut('fast');
                            }, 5000);
                        }
                    }
                });
            }
        });
        //end//

        //function fr getting statewice city details//
        function getState(country_div_id,state_div_id, state) {
            $('#cityName').selectpicker('destroy');
            $('#'+state_div_id).html('<option >Loading ...</option>');
            $('#cityName').selectpicker('setStyle');
            // validation start
            var country = $("#countryName :selected").val();
            if(country == ''){
                $('#countryName-error').show();
            }else{
                $('#countryName-error').hide();
            }
            //end
            var country_id = $('#'+country_div_id).val();
            $.ajax({
                type: "POST",
                url: "{{url('get-emirates')}}",
                data:{country_name : country_id,recipient_id : '<?php echo @$recipientDetails->_id;?>' , _token : '{{csrf_token()}}'},
                success: function(data){
                    $('#cityName').selectpicker('destroy');
                    $('#'+state_div_id).html(data);
                    $('#cityName').selectpicker('setStyle');
                    $('#cityName-error').hide();
                }
            });
        }

        $(document).ready(function(){

            getState('countryName','cityName');
            var customerType = $('#customerType').val();
            if (customerType == 1) {
                $('.corporate').show();
                $('.single').hide();


            }
            else {
                $('.corporate').hide();
                $('.single').show();
            }
            //for hiding rows when editing//
			<?php  $route= Route::currentRouteAction();
				if($route=="App\Http\Controllers\CustomerController@edit") {
				?>
            if (customerType == 0) {
                $('#corFirstName').val('');
            }
            $('.customer_dropdown .dropdown').prop('disabled',true);<?php
			}
	       ?>
        });
        function departmentValidation(dept_id,dept_value) {
            if(dept_value=='')
            {
                $('#'+dept_id+'-error').show();
            }
            else{
                $('#'+dept_id+'-error').hide();
            }
            //end

        }

        /*
        * Custom dropDown validation*/

        function dropDownValidation(){
            var salutation = $("#salutation :selected").val();
            if(salutation == ''){
                $('#salutation-error').show();
            }else{
                $('#salutation-error').hide();
            }

            var mainGroup = $("#mainGroup :selected").val();
            if(mainGroup == ''){
                $('#mainGroup-error').show();
            }else{
                $('#mainGroup-error').hide();
            }

            var customerLevel = $("#customerLevel :selected").val();
            if(customerLevel == ''){
                $('#customerLevel-error').show();
            }else{
                $('#customerLevel-error').hide();
            }

            var agent = $("#agent :selected").val();
            if(agent == ''){
                $('#agent-error').show();
            }else{
                $('#agent-error').hide();
            }

            var country = $("#country :selected").val();
            if(country == ''){
                $('#country-error').show();
            }else{
                $('#country-error').hide();
            }
            var department = $("#department :selected").val();
            if(department == ''){
                $('#department-error').show();
            }else{
                $('#department-error').hide();
            }

            var city = $("#city :selected").val();
            if(city == ''){
                $('#city-error').show();
            }else{
                $('#city-error').hide();
            }
            var cityName = $("#cityName :selected").val();
            if(cityName == ''){
                $('#cityName-error').show();
            }else{
                $('#cityName-error').hide();
            }
        }

    </script>
@endpush