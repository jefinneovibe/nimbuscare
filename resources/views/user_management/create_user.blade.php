@extends('layouts.app')
@section('content')

{{--    @if (session('status'))--}}
        <div class="alert alert-danger alert-dismissible" role="alert" id="success_dispatch" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span id="success_message"></span>
        </div>
    {{--@endif--}}
    <div class="section_details">
        <div class="card_header clearfix">
            @if(Request::path()=='user/create-user')
                <h3 class="title" style="margin-bottom: 8px;">Create User</h3>
            @else
                <h3 class="title" style="margin-bottom: 8px;">Edit User</h3>
            @endif
        </div>
        {{--<div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">--}}
        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
        {{--Customer Adding failed.Department name duplicates--}}
        {{--</div>--}}
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="post" name="user_form" id="user_form">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{@$user->_id}}" name="user_id" id="userId">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label">Select Role <span>*</span></label>
                                <div class="custom_select">
                                    <select class="form_input" name="role" id="role" onchange="roleDetails(this);">
                                        <option selected value="" data-display-text="">Select Role</option>
                                        @foreach($roles as $role)
                                            @if($role->abbreviation != 'IN')
                                                <option value="{{$role->abbreviation}}" @if(@$user->role == $role->abbreviation)selected @endif>{{$role->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">First Name <span>*</span></label>
                                <input class="form_input" name="first_name" id="first_name" placeholder="First Name" value="{{@$user->firstName}}" type="text" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Last Name <span>*</span></label>
                                <input class="form_input" name="last_name" id="last_name" placeholder="Last Name" value="{{@$user->lastName}}" type="text" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                    </div>
                    @if(Request::path()=='user/create-user')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Email <span>*</span></label>
                                    <input class="form_input" name="email" id="email" placeholder="Email" type="text" value="{{@$user->email}}" onblur="dropDownValidation(this);">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Password <span>*</span></label>
                                    <input class="form_input" name="password" id="password" placeholder="Password"  type="password" onblur="dropDownValidation(this);">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Employee Id</label>
                                    <input class="form_input" name="employee_id" id="employee_id" placeholder="Employee Id" value="{{@$user->empID}}" type="text" onblur="dropDownValidation(this);">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Email <span>*</span></label>
                                    <input class="form_input" name="email" id="email" placeholder="Email" type="text" value="{{@$user->email}}" onblur="dropDownValidation(this);">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Employee Id</label>
                                    <input class="form_input" name="employee_id" id="employee_id" placeholder="Employee Id" value="{{@$user->empID}}" type="text" onblur="dropDownValidation(this);">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card_separation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card_sub_head">
                                        <div class="clearfix">
                                            <h3 class="card_sub_heading pull-left">Assign Permission <span style="color:red">*</span></h3>
                                        </div>
                                </div>
                            </div>
                        </div>
                       <div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"   name="permissionCheck[]" value="CRM" id="crm_check" class="inp-cbx roleAdmin" style="display: none"
                                            @if(isset($user['permission']['permissionCheck']) &&(in_array('CRM',$user['permission']['permissionCheck']))) checked @endif
                                            @if(@$user->role=='AD') disabled @endif>
                                            <label for="crm_check" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Broking Slip</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"   name="permissionCheck[]" value="Dispatch" id="dispatch_check" class="inp-cbx roleAdmin" style="display: none"
                                            @if(isset($user['permission']['permissionCheck']) &&(in_array('Dispatch',$user['permission']['permissionCheck']))) checked @endif @if(@$user->role=='AD') disabled @endif>
                                            <label for="dispatch_check" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Dispatch</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"   name="permissionCheck[]" value="User Management" id="user_check" class="inp-cbx roleAdmin" style="display: none"
                                            @if(isset($user['permission']['permissionCheck']) &&(in_array('User Management',$user['permission']['permissionCheck']))) checked @endif @if(@$user->role=='AD') disabled @endif>
                                            <label for="user_check" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">User Management</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"   name="permissionCheck[]" value="Document Management" id="document_check" class="inp-cbx roleAdmin" style="display: none"
                                            @if(isset($user['permission']['permissionCheck']) &&(in_array('Document Management',$user['permission']['permissionCheck']))) checked @endif @if(@$user->role=='AD') disabled @endif>
                                            <label for="document_check" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Document Management</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"   name="permissionCheck[]" value="Enquiry Management" id="enquiry_check" class="inp-cbx roleAdmin" style="display: none"
                                            @if(isset($user['permission']['permissionCheck']) &&(in_array('Enquiry Management',$user['permission']['permissionCheck']))) checked @endif @if(@$user->role=='AD') disabled @endif>
                                            <label for="enquiry_check" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold">Enquiry Management</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Department</label>
                                <input class="form_input" name="department" id="department" placeholder="Department" value="{{@$user->department}}" type="text" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Position</label>
                                <input class="form_input" name="position" id="position" placeholder="Position" value="{{@$user->position}}" type="text" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Name of Supervisor</label>
                                <input class="form_input" name="supervisor_name" id="supervisor_name" placeholder="Name of Supervisor" value="{{@$user->nameOfSupervisor}}" type="text" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Unique code</label>
                                <input class="form_input" name="unique_code" id="unique_code" placeholder="Unique code" value="{{@$user->uniqueCode}}" type="number" onblur="dropDownValidation(this);">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="agent_div" style="display: none">
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="form_group" style="margin-bottom: 10px">
                                    <label class="form_label">Select Agent<span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent" onchange="dropDownValidation(this)">
                                        <option value="" selected >Select Agent</option>
                                    @foreach($agents as $agent)
                                    <option value="{{$agent->_id}}" @if(@$user['assigned_agent']['id']== $agent->_id)selected @endif>{{$agent->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="employee_div" style="display: none">
                        <div class="col-md-12">
                            <div class="form_group">
                                <div class="form_group form_current" style="margin-bottom: 10px">
                                    <label class="form_label">Select Employees</label>
                                    @php
                                        $employeeList= (@$user->employees && $user->employees!= "")?$user->employees:[];
                                    @endphp
                                    <select name="employee_select[]" id="employee_select" onchange="dropDownValidation(this)" multiple>
                                        @isset($employeeList)
                                            @foreach($employeeList as $employee)
                                                <option value="{{$employee['id']}}" selected>{{$employee['empName']}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Request::path()=='user/create-user')
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Create</button>
                    @else
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Update</button>
                    @endif
                    <a class="btn btn-primary btn_action pull-right" href="{{ url('user/view-user') }}" >Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <style>
        .form_current{

        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #D4D9E2 !important;
            border-radius: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #4b515e !important;
        }
        .bootstrap-select .dropdown-toggle:focus, .bootstrap-select .dropdown-toggle:hover {
            outline: none !important;
            border-color: #D4D9E2 !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            color: #000 !important;
        }
        .open-email-container{
            max-width: 1210px !important;
        }
        .cus_select2 .select2-container {
            z-index: 9999999999 !important;
        }
        .select2.select2-container.select2-container--default {
             width: 100% !important;
        }
        .form_current .dropdown .current{
            display: none;
        }
        .form_current .dropdown .list{
            display: none;
        }
    </style>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
{{--<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>--}}
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<script>

    var userId= $('#userId').val();
    userId= userId? userId:"";

    $(function(){
        $('#employee_select').select2({
            ajax: {
                url: "{{URL::to('user/select-employees')}}",
                dataType: 'json',
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        edit: userId
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            allowClear: true,
            placeholder: 'Select Employees',
            // allowClear: true,
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            //        minimumInputLength: 1,
            templateResult: formatReporting
        });
    });

    function formatReporting (repo) {
        console.log(repo);
        if (repo.loading) {
            return repo.text;
        }
        var markup = repo.name;
        return markup;
    }

    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
            // localStorage.clear();
        });
    });
    $.validator.addMethod("customemail",
        function(value, element) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        },
        "Please enter a valid email id. "
    );

    //add leads form validation//
    $("#user_form").validate({
        ignore: [],
        rules: {
            role: {
                required:true
            },
            first_name: {
                required:true
            },
            last_name: {
                required:true
            },
            'permissionCheck[]': {
                required:true
            },
            agent: {
                required: function () {
                    return ($("#role").val() == 'CO');
                }
             },

            email: {
                customemail:true,
                required:true
            },
            password: {
                required: true,
                minlength: 6
            },
            unique_code: {
                minlength: 10,
                maxlength: 10,
                number:true
            }
        },
        messages: {
            role: "Please select role.",
            first_name: "Please enter first name.",
            last_name: "Please enter last name.",
            email: "Please enter valid email.",
            agent: "Please select the agent.",
            'permissionCheck[]': "Please select permission.",
            password:{
                required: "Please enter password.",
                minlength: "Password must contain atleast 6 characters."
            }
        },
        errorPlacement: function (error, element)
        {
            if(element.attr("name") == "role"){
                error.insertAfter(element.parent());
            } else if(element.attr("name") == "permissionCheck[]"){
                error.insertAfter(element.parent().parent().parent().parent().parent().parent());
            }else{
                error.insertAfter(element);
            }
        },
        submitHandler: function (form,event) {
            $('.roleAdmin').prop('disabled',false);
            var form_data = new FormData($("#user_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#button_submit").prop('disabled', true);
            $.ajax({
                method: 'post',
                url: '{{url('user/save-user')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result.success == true){
                        window.location.href = '{{url('user/view-user')}}';
                    }else{
                        $('#preLoader').hide();
                        $("#button_submit").prop('disabled', false);
                        $('#success_dispatch').show();
                        $('#success_message').html(result.message);
                        setTimeout(function() {
                            $('#success_dispatch').fadeOut('fast');
                        }, 5000);

                    }
                }
            });
        }

    });
    //end//

    /*
     * Custom dropDown validation*/

    function dropDownValidation(obj){
        var value = obj.value;
        if(value == '') {
            $('#' + obj.id + '-error').show()
        }
        else {
            $('#' + obj.id + '-error').hide()
        }
        $('#assign-error').hide();
    }

/*
     * Custom dropDown validation*/

    function dropValidation(obj){
        var value = obj.value;
        if(value == '') {
            $('#' + obj.id + '-error').show()
        }
        else {
            $('#' + obj.id + '-error').hide()
        }
        $('#assign-error').hide();
    }

    function roleDetails(obj){
        if(obj.value=='CO')
        {
            $('#employee_div').hide();
            $('#agent_div').show();
        } else if(obj.value=='SV') {
            $('#agent_div').hide();
            $('#employee_div').show();
        } else {
            $('#employee_div').hide();
            $('#agent_div').hide();
        }
        if(obj.value=='AD')
        {
            $(".roleAdmin").prop("checked", true);
            $('.roleAdmin').prop('disabled',true);
        }else{

            $('.roleAdmin').prop('disabled',false);
            $(".roleAdmin").prop("checked", false);
        }
        var value = obj.value;
        if(value == '') {
            $('#' + obj.id + '-error').show()
        }
        else {
            $('#' + obj.id + '-error').hide()
        }
        $('#assign-error').hide();
    }

    $(document).ready(function() {
        var role=$('#role').val();
        if(role=='CO') {
            $('#agent_div').show();
        } else if (role=='SV') {
            $('#employee_div').show();
        } else {
            $('#employee_div').hide();
            $('#agent_div').hide();
        }
        // var selEmp={{json_encode($employeeList)}};
        // selEmp= JSON.parse(selEmp);
        // console.log(selEmp);
        // $('employee_select').trigger('change');
        // $('employee_select').append(
        //     '<option value="'
        // );

        // if(role!='')
        // {
        // if(role=='AD')
        // {
        //     $(".roleAdmin").prop("checked", true);
        //     $('.roleAdmin').prop('disabled',true);
        // }else{
        //     $(".roleAdmin").prop("checked", false);
        //     $('.roleAdmin').prop('disabled',false);
        // }
        // }

        setTimeout(function () {
            $('#success_dispatch').fadeOut('fast');
        }, 5000);
    });

</script>
@endpush
