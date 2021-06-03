@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_customer">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissible" role="alert" id="mail_success" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Report send to <span id="mail_send_id"></span>
    </div>
    <div class="data_table">

        <div id="admin" class="filter_main_sec">
            <form id="filterForm" name="filterForm" action="{{URL::to("customers/$customerMode/show")}}" method="get">
                <div class="material-table table-responsive">
                    <div class="table-header">
                        <span class="table-title"> {{$customerMode?"Permanent":"Temporary"}} Customers</span>
                        <div class="actions">

                            <div class="sort">
                                <label>Sort :</label>
                                <div class="custom_select">
                                    <select class="form_input" id="customer_sort" name="customer_sort">
                                        <option value="">Select</option>
                                        <option value="Agent">Agent</option>
                                        <option value="Customer Code">Customer Code</option>
                                        <option value="Main Group">Main Group</option>
                                        <option value="Name">Name</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="filter_icon">--}}
                            {{--<button class="btn export_btn waves-effect auto_modal" data-toggle="tooltip" data-placement="bottom" title="Filter" data-container="body" data-modal="filter_popup">--}}
                            {{--<i class="material-icons">filter_list</i>--}}
                            {{--</button>--}}
                            {{--</div>--}}
                            <div class="form-inline ml-auto">
                                <div class="form-group page_no">
                                    <input type="text" class="form-control" placeholder="Search" name="search" id="search">
                                </div>
                                <button type="button" class="btn btn-white btn-raised btn-fab btn-round">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                {{--<form method="pos?t" action="/export-customers">--}}
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  href="#" class="dropdown-item" onclick='view_email_popup("{{$customerMode}}")' id="btn-exel">Generate Report</a>
{{--                                    <a target="_blank" href="{{url('/export-customers')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                </div>
                                {{--</form>--}}
                            </div>

                        </div>
                    </div>
                    <table id="datatable">
                        <thead>
                        <tr>
                            <th class="disabled_sort">Customer Code</th>
                            <th class="disabled_sort">Name</th>
                            <th class="disabled_sort">Contact No</th>
                            <th class="disabled_sort">Email</th>
                            <th class="disabled_sort @if(!empty(@$mainGroups)) filter_active @endif" style="min-width: 160px">
                                <span>Main Group</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="maingroup_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$agents)) filter_active @endif" >
                                <span>Agent</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="agent_layer2"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$customerLevels)) filter_active @endif" style="min-width: 130px;" >
                                <span>Level</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="level_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort">No of policies</th>
                            {{--<th class="disabled_sort">Department</th>--}}
                            <th class="disabled_sort"></th>
                            <th class="disabled_sort"></th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div id="maingroup_layer" class="po__layer list">
                    <p>Main Group</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='maingroup-data-ajax' id="maingroup-data-ajax" name="main_group[]" multiple="multiple">
                            @if(!empty(@$mainGroups))
                                @foreach(@$mainGroups as $main_grp)
                                    <option value="{{$main_grp->_id}}" selected>{{$main_grp->fullName}}</option>
                                @endforeach
                            @endif
                            @if (@$_GET['main_group'] && in_array('Nil', @$_GET['main_group']))
                                <option value="Nil" selected>Nil</option>
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button type="button" class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="agent_layer2" class="po__layer list">
                    <p>Agent</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='agent-data-ajax' id="agent-data-ajax" name="agent[]" multiple="multiple">
                            @if(!empty(@$agents))
                                @foreach(@$agents as $agent)
                                    <option value="{{$agent->_id}}" selected>{{$agent->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button class='popover_cancel' type="button">Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="level_layer" class="po__layer list">
                    <p>Level</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='level-data-ajax' id="level-data-ajax" name="level[]" multiple="multiple">
                            @if(!empty(@$customerLevels))
                                @foreach(@$customerLevels as $level)
                                    <option value="{{$level->_id}}" selected>{{$level->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button class='popover_cancel' type="button">Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">

    <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="{{url('customers/create')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Add Customer" data-container="body">
                    <span><i class="material-icons">add</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->

    {{--<div id="filter_popup">--}}
    {{--<div class="cd-popup">--}}


    {{--<div class="cd-popup-container">--}}

    {{--<form method="get" name="filter_customer" id="filter_customer">--}}
    {{--<div class="modal_content">--}}
    {{--<div class="clearfix">--}}
    {{--<h1>Filter</h1>--}}
    {{--<button type="button" class="btn btn_reset blue_btn" onclick="clearAll();">Clear All</button>--}}
    {{--</div>--}}

    {{--<div class="content_spacing clearfix">--}}
    {{--<div class="md--half" style="display: none;">--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input checked type="checkbox" name="main_group" value="0" id="main_group" class="inp-cbx" style="display: none" onchange="mainGroupListing();">--}}
    {{--<label for="main_group" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>Main Group</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input checked type="checkbox" name="main_agent" value="0" id="main_agent" class="inp-cbx" style="display: none" onchange="agentListing();">--}}
    {{--<label for="main_agent" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>Agent</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input checked type="checkbox" name="agent_level" value="0" id="main_level" class="inp-cbx" style="display: none" onchange="levelListing();">--}}
    {{--<label for="main_level" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>Level</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="md--half" style="display: none;" id="mainGroupList">--}}
    {{--<h5>Main Groups</h5>--}}
    {{--<div class="pre-scrollable">--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="mainGroupAll" value="mainGroupAll" id="mainGroupAll" class="inp-cbx" style="display: none" onchange="mainGroupDisable();">--}}
    {{--<label for="mainGroupAll" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>All</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="mainGroup[]" value="Nil" id="Nil" class="inp-cbx" style="display: none">--}}
    {{--<label for="Nil" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>Nil</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--@if(!empty($mainGroups))--}}
    {{--@forelse($mainGroups as $mainGroup)--}}
    {{--<div class="custom_checkbox">--}}

    {{--@if($mainGroup)--}}
    {{--<input type="checkbox" name="mainGroup[]" value="{{$mainGroup->_id}}" id="{{$mainGroup->_id}}" class="inp-cbx" style="display: none">--}}
    {{--<label for="{{$mainGroup->_id}}" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>{{ucwords($mainGroup->firstName)}}</span>--}}
    {{--</label>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--@empty--}}
    {{--No main groups found.--}}
    {{--@endforelse--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="md--half" style="display: none;" id="agentList">--}}
    {{--<h5>Agents</h5>--}}
    {{--<div class="pre-scrollable">--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="agentAll" value="agentAll" id="agentAll" class="inp-cbx" style="display: none" onclick="agentDisable();">--}}
    {{--<label for="agentAll" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>All</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--@if(!empty($agents))--}}
    {{--@forelse($agents as $agent)--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="agent[]" value="{{$agent->_id}}" id="{{$agent->_id}}" class="inp-cbx" style="display: none">--}}
    {{--<label for="{{$agent->_id}}" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>{{$agent->name}}</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--@empty--}}
    {{--No Agents found.--}}
    {{--@endforelse--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="md--half" style="display: none;" id="levelList">--}}
    {{--<h5>Levels</h5>--}}
    {{--<div class="pre-scrollable">--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="levelAll" value="levelAll" id="levelAll" class="inp-cbx" style="display: none" onclick="levelDisable();">--}}
    {{--<label for="levelAll" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>All</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--@if(!empty($customerLevels))--}}
    {{--@forelse($customerLevels as $customerLevel)--}}
    {{--<div class="custom_checkbox">--}}
    {{--<input type="checkbox" name="level[]" value="{{$customerLevel->_id}}" id="{{$customerLevel->_id}}" class="inp-cbx" style="display: none">--}}
    {{--<label for="{{$customerLevel->_id}}" class="cbx">--}}
    {{--<span>--}}
    {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
    {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
    {{--</svg>--}}
    {{--</span>--}}
    {{--<span>{{$customerLevel->name}}</span>--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--@empty--}}
    {{--No Agents found.--}}
    {{--@endforelse--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}

    {{--<div class="modal_footer">--}}
    {{--<button class="btn btn-primary btn-link btn_cancel" type="button" id="filter_cancel">Cancel</button>--}}
    {{--<button class="btn btn-primary btn_action" type="submit">Apply Filter</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--</div><!--//END Popup -->--}}


    {{--Delete popup--}}
    <div id="delete_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" name="customer_delete" id="customer_delete">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to delete customer ?</h3>
                                            <input class="customer_id" name="customer_id" id="customer_id" value="" type="hidden">
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="delete_customer">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{--send excel via email--}}
    <div id="view_email_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" name="send_excel_form" id="send_excel_form">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{--<h3>Send excel</h3>--}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label">Enter Email ID<span>*</span></label>
                                            <input class="form_input" name="send_email_id" id="send_email_id">
                                            <input type="hidden" name="customerMode" id="customerModeOnExcel">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" id="send_lead_excel" onclick="send_excel()">Send</button>
                </div>
            </div>
        </div>
    </div>

    {{--<select style='width: 200px' class='agent-data-ajax'></select>--}}
@endsection


@push('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{asset('js/main/popover.js')}}"></script>

<script>
    $("#send_excel_form").validate({
        ignore: [],
        rules: {
            send_email_id: {
                customemail: true,
                required: true
            }
        },
        messages: {
            send_email_id: "Please enter valid email id"
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });
    function view_email_popup(customerMode)
    {
        $("#view_email_popup  #customerModeOnExcel").val(customerMode);
        $("#view_email_popup .cd-popup").toggleClass('is-visible');
    }

    $('#send_email_id').keypress(function(event){
        if(event.keyCode == 13){
            send_excel();
        }
    });
    function send_excel()
    {
        var valid=  $("#send_excel_form").valid();
        if (valid == true) {

            var email= $('#send_email_id').val();
            var form_data = new FormData($("#send_excel_form")[0]);
            form_data.append('email',email);
            form_data.append('_token', '{{csrf_token()}}');
//                $('#preLoader').show();
            $("#send_lead_excel").attr( "disabled", "disabled" );
            $("#view_email_popup .cd-popup").removeClass('is-visible');
            $('#mail_send_id').html(email);
            $('#mail_success').show();
            setTimeout(function() {
                $('#mail_success').fadeOut('fast');
            }, 5000);
            $("#send_lead_excel").attr( "disabled",false );
            $('#send_email_id').val('');
            $.ajax({
                method: 'post',
                url: '{{url('export-customers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result=='success') {
                        console.log('');
                    }
                }
            });

        }
    }
    (function($) {
        $('.po__trigger--center').po({ alignment: 'center' });
    })(jQuery)

    $('.agent-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-agents')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
        placeholder: 'Search for a agent',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.maingroup-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-main-group')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
        placeholder: 'Search for a main group',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.level-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-level')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
        placeholder: 'Search for a level',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = repo.name;

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.name;
    }


</script>


<script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
<script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

<script>
    $.validator.addMethod("customemail",
        function(value, element) {
            return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        },
        "Please enter a valid email id. "
    );
    var selected_arrays={};
    var selected_arrays_parsed1="";
    var  filterData="";
    var  filterDataParse="";

    $('input:checkbox.datatabe-checkbox').on('click', function (e)  {
        var value_check =$(this).val();
        if (this.checked) {
            $('#'+value_check).prop('checked',true);
        }
        else{
            $('#'+value_check).prop('checked',false);
        }
    });

    function submitFilterForm(){
        $('#filterForm').submit();
//        $('#datatable').DataTable().ajax.reload();
    }

    //filter function///////////////////
    function submitForm() {
        $('input:checkbox.datatabe-checkbox').each(function () {
            if (this.checked) {
                var value = (this.checked ? $(this).val() : "");
                var testname = (this.checked ? $(this).attr('name') : "");
                if (value != '') {
                    if (selected_arrays.hasOwnProperty(testname)) {
                        if ($.inArray(value, selected_arrays[testname]) !== -1) {
                            selected_arrays[testname].splice($.inArray(value, selected_arrays[testname]), 1);
                            selected_arrays[testname].push(value);
                        }
                        else {
                            selected_arrays[testname].push(value);
                        }
                    } else {
                        selected_arrays[testname] = new Array();
                        selected_arrays[testname].push(value);
                    }
                }
            }
            if (!this.checked) {
                value = $(this).val();
                testname = $(this).attr('name');
                if ($.inArray(value, selected_arrays[testname]) !== -1) {
                    selected_arrays[testname].splice($.inArray(value, selected_arrays[testname]), 1);
                }
            }
        });
//        console.log(selected_arrays);
        if (Object.keys(selected_arrays).length != 0) {
            selected_arrays_parsed1 = JSON.stringify(selected_arrays);
            localStorage.setItem('filterField', selected_arrays_parsed1);
        }
        filterData = localStorage.getItem('filterField');
        $('#datatable').DataTable().ajax.reload();
    }

    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');


            /*For retrieve the web page status using local storage*/
            if(localStorage)
            {
                if(localStorage.getItem('searchElement')!=null)
                {
                    search(localStorage.getItem('searchElement'));
                }
                if(localStorage.getItem('customerSortField'))
                {
                    sort(localStorage.getItem('customerSortField'));
                }

            }

        });

        /*Function for search in data table*/

        function search(searchElement)
        {
            var dataTable = $('#datatable').DataTable();
            $('#search').val(searchElement);
            dataTable.search(searchElement).draw();
        }

        /*Function for Sorting Data Table*/

        function sort(sortField)
        {
            var table, row, switching, i, x, y, shouldSwitch;
            table = document.getElementById("datatable");
            switching = true;
            if(sortField == "code") {
                while (switching) {
                    switching = false;
                    row = table.getElementsByTagName("TR");
                    for (i = 1; i < (row.length - 1); i++) {
                        shouldSwitch = false;
                        x = row[i].getElementsByTagName("TD")[0];
                        y = row[i + 1].getElementsByTagName("TD")[0];
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        row[i].parentNode.insertBefore(row[i + 1], row[i]);
                        switching = true;
                    }
                }
            }
            else
            {
                while (switching) {
                    switching = false;
                    row = table.getElementsByTagName("TR");
                    for (i = 1; i < (row.length - 1); i++) {
                        shouldSwitch = false;
                        x = row[i].getElementsByTagName("TD")[1];
                        y = row[i + 1].getElementsByTagName("TD")[1];
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        row[i].parentNode.insertBefore(row[i + 1], row[i]);
                        switching = true;
                    }
                }
            }
        }

        (function(window, document, undefined) {

            var factory = function($, DataTable) {
                "use strict";

                /* Set the defaults for DataTables initialisation */
                $.extend(true, DataTable.defaults, {
                    dom: "<'hiddensearch'f'>" +
                    "tr" +
                    "<'table-footer'lip'>",
                    renderer: 'material'
                });

                /* Default class modification */
                $.extend(DataTable.ext.classes, {
                    sWrapper: "dataTables_wrapper",
                    sFilterInput: "form-control input-sm",
                    sLengthSelect: "form-control input-sm"
                });

                /* Bootstrap paging button renderer */
                DataTable.ext.renderer.pageButton.material = function(settings, host, idx, buttons, page, pages) {
                    var api = new DataTable.Api(settings);
                    var classes = settings.oClasses;
                    var lang = settings.oLanguage.oPaginate;
                    var btnDisplay, btnClass, counter = 0;

                    var attach = function(container, buttons) {
                        var i, ien, node, button;
                        var clickHandler = function(e) {
                            e.preventDefault();
                            if (!$(e.currentTarget).hasClass('disabled')) {
                                api.page(e.data.action).draw(false);
                            }
                        };

                        for (i = 0, ien = buttons.length; i < ien; i++) {
                            button = buttons[i];

                            if ($.isArray(button)) {
                                attach(container, button);
                            } else {
                                btnDisplay = '';
                                btnClass = '';

                                switch (button) {

                                    case 'first':
                                        btnDisplay = lang.sFirst;
                                        btnClass = button + (page > 0 ?
                                                '' : ' disabled');
                                        break;

                                    case 'previous':
                                        btnDisplay = '<i class="material-icons">chevron_left</i>';
                                        btnClass = button + (page > 0 ?
                                                '' : ' disabled');
                                        break;

                                    case 'next':
                                        btnDisplay = '<i class="material-icons">chevron_right</i>';
                                        btnClass = button + (page < pages - 1 ?
                                                '' : ' disabled');
                                        break;

                                    case 'last':
                                        btnDisplay = lang.sLast;
                                        btnClass = button + (page < pages - 1 ?
                                                '' : ' disabled');
                                        break;

                                }

                                if (btnDisplay) {
                                    node = $('<li>', {
                                        'class': classes.sPageButton + ' ' + btnClass,
                                        'id': idx === 0 && typeof button === 'string' ?
                                            settings.sTableId + '_' + button : null
                                    })
                                        .append($('<a>', {
                                                'href': '#',
                                                'aria-controls': settings.sTableId,
                                                'data-dt-idx': counter,
                                                'tabindex': settings.iTabIndex
                                            })
                                                .html(btnDisplay)
                                        )
                                        .appendTo(container);

                                    settings.oApi._fnBindAction(
                                        node, {
                                            action: button
                                        }, clickHandler
                                    );

                                    counter++;
                                }
                            }
                        }
                    };

                    // IE9 throws an 'unknown error' if document.activeElement is used
                    // inside an iframe or frame.
                    var activeEl;

                    try {
                        // Because this approach is destroying and recreating the paging
                        // elements, focus is lost on the select button which is bad for
                        // accessibility. So we want to restore focus once the draw has
                        // completed
                        activeEl = $(document.activeElement).data('dt-idx');
                    } catch (e) {}

                    attach(
                        $(host).empty().html('<ul class="material-pagination"/>').children('ul'),
                        buttons
                    );

                    if (activeEl) {
                        $(host).find('[data-dt-idx=' + activeEl + ']').focus();
                    }
                };

                /*
                 * TableTools Bootstrap compatibility
                 * Required TableTools 2.1+
                 */
                if (DataTable.TableTools) {
                    // Set the classes that TableTools uses to something suitable for Bootstrap
                    $.extend(true, DataTable.TableTools.classes, {
                        "container": "DTTT btn-group",
                        "buttons": {
                            "normal": "btn btn-default",
                            "disabled": "disabled"
                        },
                        "collection": {
                            "container": "DTTT_dropdown dropdown-menu",
                            "buttons": {
                                "normal": "",
                                "disabled": "disabled"
                            }
                        },
                        "print": {
                            "info": "DTTT_print_info"
                        },
                        "select": {
                            "row": "active"
                        }
                    });

                    // Have the collection use a material compatible drop down
                    $.extend(true, DataTable.TableTools.DEFAULTS.oTags, {
                        "collection": {
                            "container": "ul",
                            "button": "li",
                            "liner": "a"
                        }
                    });
                }

            }; // /factory

            // Define as an AMD module if possible
            if (typeof define === 'function' && define.amd) {
                define(['jquery', 'datatables'], factory);
            } else if (typeof exports === 'object') {
                // Node/CommonJS
                factory(require('jquery'), require('datatables'));
            } else if (jQuery) {
                // Otherwise simply initialise as normal, stopping multiple evaluation
                factory(jQuery, jQuery.fn.dataTable);
            }

        })(window, document);

        $(document).ready(function() {
            setTimeout(function() {
                $('#success_customer').fadeOut('fast');
            }, 5000);
            var sortField = "";
            var searchField = "";
            var filter = $('#filter_data').val();
            if(localStorage)
            {
                if(localStorage.getItem('customerSortField'))
                {
                    sortField = localStorage.getItem('customerSortField');
                    $('.current').html(sortField);
                }
                if(localStorage.getItem('customerSearchField'))
                {
                    searchField = localStorage.getItem('customerSearchField');
                    $('#search').val(searchField);
                }

            }
            //$('select[name^="sort"] option[value="name"]').attr("selected","selected");
            $('#datatable').dataTable({
                // "oLanguage": {
                //     "sStripClasses": "",
                //     "sSearch": "",
                //     "sSearchPlaceholder": "Enter Keywords Here",
                //     "sInfo": "_START_ -_END_ of _TOTAL_",
                //     "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                //     '<option value="10">10</option>' +
                //     '<option value="20">20</option>' +
                //     '<option value="30">30</option>' +
                //     '<option value="40">40</option>' +
                //     '<option value="50">50</option>' +
                //     '<option value="-1">All</option>' +
                //     '</select></div>'
                // },
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span> ',
                    "emptyTable": '<p class="col-md-12 col-md-2 col-md-push-6">No data available</p>',
                    "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                    '<option value="10">10</option>' +
                    '<option value="20">20</option>' +
                    '<option value="30">30</option>' +
                    '<option value="40">40</option>' +
                    '<option value="50">50</option>' +
//                    '<option value="-1">All</option>' +
                    '</select></div>',
                    "sStripClasses": "",
                    "sSearch": "",
                    "sSearchPlaceholder": "Enter Keywords Here",
                    "sInfo": "_START_ -_END_ of _TOTAL_"
                },


                bAutoWidth: false,
                processing: true,
                serverSide: true,
                {{--                    ajax: '{{URL::to('customers/customers-data')}}?filter_data='+filter,--}}
                ajax:{
                    type:'post',
                    url:'{{\Illuminate\Support\Facades\URL::to('customers/customers-data')}}',
                    data: function(d){
                        d.field=sortField;
                        d.searchField = "";
                        d.filterData = filter;
                        d.customerMode = "{{$customerMode}}";
//                        d.agent = $('#agent-data-ajax').val();
//                        d.main_group = $('#maingroup-data-ajax').val();
//                        d.level = $('#level-data-ajax').val();
                        d._token = "{{csrf_token()}}"
                    }


                },
                "preDrawCallback": function( settings ) {
                    filterData=filterData;
                },

                "columns": [
//                { "data": "id","searchable": true},
                    { "data": "Code","searchable": true, "visible" : true,'orderable' : false},
                    { "data": "fullName","searchable": true, "visible" : true ,'orderable' : false},
                    { "data": "contactNumber","searchable": true, "visible" : true,'orderable' : false},
                    { "data": "email" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "mainGroup" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "agent" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "level" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "policies" ,"searchable": true, "visible" : true,'orderable' : false},
//                        { "data": "department" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "action1", 'orderable' : false,"searchable": false },
                    { "data": "action2", 'orderable' : false,"searchable": false }
                ]
            });
            /*
             * Sorting the table by the Drop Down list on change event*/

            $('#customer_sort').on('change',function(){

                localStorage.setItem('customerSortField',$('#customer_sort').val());
                location.reload();
            });

            /*
             * Searching in Data Table on key up event*/

            $('#search').on('keyup',function(){
                localStorage.setItem('customerSearchField',$('#search').val());
                var table = $('#datatable').DataTable();
                table.search(this.value).draw();
            });
            if($('#search').val()!="")
            {
                var value = $('#search').val();
                var table = $('#datatable').DataTable();
                table.search(value).draw();
            }

        });


    });



    //Onclick function for deleting customer

    function delete_pop(customer_id)
    {
        $('#customer_id').val(customer_id);
        $("#delete_popup .cd-popup").toggleClass('is-visible');
    }


    // Passing customer_id to modal for deleting customer

    $(document).ready(function() {
        $('.auto_modal').click(function(){
            var customer_id = $(this).attr('dir');
            $('.customer_id').val(customer_id);
        });
    });

    // To delete a customer

    $(document).ready(function() {
        //function for filter popover
        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                    if (localStorage) {
                        filterData = localStorage.getItem('filterField');
                        if (filterData) {
                            parsedTest = JSON.parse(filterData); //an array [1,2]
                            $.each(parsedTest, function (key, value) {
                                if (key) {
                                    $.each(value, function (key1, value1) {
                                        if (key == $('#' + value1).attr('name')) {
                                            $('#' + value1).prop('checked', true);
                                        }
                                        if (key == 'agentAll') {
                                            $('#agent_all').prop('checked', true);
                                        }
                                        if (key == 'levelAll') {
                                            $('#levelAll').prop('checked', true);
                                        }
                                        if (key == 'maingroupId') {
                                            $('#main_all').prop('checked', true);
                                        }
                                    });
                                }
                            });
                        }

                    }
                }

                //steps for checking check boxes in filter///////////
                $("input[name='mainGroup.id']").on('change', function () {
                    $('#main_all').prop('checked', false);
                });
                $("input[name='agent.id']").on('change', function () {
                    $('#agent_all').prop('checked', false);
                });
                $("input[name='customerLevel.id']").on('change', function () {
                    $('#levelAll').prop('checked', false);
                });
                $('#main_all').on('change', function () {
                    if ($('#main_all').is(":checked")) {
                        $("input[name='mainGroup.id']").prop('checked', true);
                    }
                    else {
                        $("input[name='mainGroup.id']").prop('checked', false);
                    }
                });
                $('#levelAll').on('change', function () {
                    if ($('#levelAll').is(":checked")) {
                        $("input[name='customerLevel.id']").prop('checked', true);
                    }
                    else {
                        $("input[name='customerLevel.id']").prop('checked', false);
                    }
                });

                $('#agent_all').on('change', function () {
                    if ($('#agent_all').is(":checked")) {
                        $("input[name='agent.id']").prop('checked', true);
                    }
                    else {
                        $("input[name='agent.id']").prop('checked', false);
                    }
                });
                $('#btn-clear').on('click', function () {
                    $("input[name='workType[]']").prop('checked', false);
                    $("input[name='mainGroup[]']").prop('checked', false);
                    $("input[name='caseManager[]']").prop('checked', false);
                    $("input[name='agent[]']").prop('checked', false);
                    $("input[name='status[]']").prop('checked', false);
                    $("input[name='customer[]']").prop('checked', false);
                    $('#cat_all').prop('checked', false);
                    $('#main_all').prop('checked', false);
                    $('#case_all').prop('checked', false);
                    $('#status_all').prop('checked', false);
                    $('#agent_all').prop('checked', false);
                    $('#cust_all').prop('checked', false);
                    // $("#categoryList").hide();
                    // $("#mainGroupList").hide();
                    // $("#caseManagerList").hide();
                    // $("#agentList").hide();
                    // $('#statusList').hide();

                });
            });

        });
        $('#delete_customer').on('click', function() {
            $('#preLoader').show();
            var customer = $('#customer_id').val();
            $.ajax({
                url: '{{url('customers/delete/')}}/'+customer,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('customers')}}'+"/{{$customerMode}}/show";
                    }
                }
            });

        });
    });

    $(document).click(function () {
        // $('.popover_cancel').on('click', function (e) {
        //     $("body").trigger("click");
        // });
        setTimeout(function() {
            $('#success_lead').fadeOut('fast');
        }, 5000);
    });

    $(document).ready(function () {
        localStorage.setItem('filterField', '');
    });

    $( document ).ready(function() {

    })

</script>


@endpush
