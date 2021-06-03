@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_worktype">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissible" role="alert" id="success_lead" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
    </div>
    <div class="data_table" style="margin-bottom: 0">
        <div class="tabbed clearfix">
            <ul>
                {{-- <li class="blue-bg active"><a href="{{ url('pipelines') }}">Pipeline</a></li>
                <li class="grey-bg"><a href="{{ url('pending-issuance') }}">Pending Issuance</a></li>
                <li class="red-bg"><a href="{{ url('pending-approvals') }}">Pending Approvals</a></li> --}}
                <li style="width:100%" class="grey-bg"><a href="{{ url('closed-pipelines') }}">Closed List</a></li>
            </ul>
        </div>
        <div id="admin">
            <div class="material-table table-responsive">
                <div class="table-header">
                    <span class="table-title">Closed Pipeline List</span>
                    <div class="actions">
                        <div class="sort">
                            <label>Sort :</label>
                            <div class="custom_select">
                                <select class="form_input" id="customSort" name="customSort">
                                    <option value="" data-display-text="">select</option>
                                    <option value="Customer Name">Customer Name</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Worktype">Worktype</option>
                                    <option value="Status">Status</option>
                                    <option value="Last Updated At">Last Updated At</option>
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
                                <input type="text" class="form-control" placeholder="Search" id="search" name="search">
                            </div>
                            <button type="button" class="btn btn-white btn-raised btn-fab btn-round">
                                <i class="material-icons">search</i>
                            </button>
                        </div>

                        <div class="dropdown">
                            <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <form method="post" action="export-closed">
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a target="_blank" href="{{url('export-closed')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <input type="hidden" id="ref_id">

                <form id="filterForm" name="filterForm" action="{{URL::to('closed-pipelines')}}" method="get">
                <table id="datatable" style="text-overflow: ellipsis">
                    <thead>
                    <tr>

                        {{--<th class="disabled_sort">Main Group</th>--}}
                        <th class="disabled_sort">Reference Number</th>
                        <th class="disabled_sort">Date Created</th>
                        <th class="disabled_sort">Created By</th>
                        <th class="disabled_sort">Customer ID</th>
                        <th class="disabled_sort @if(!empty(@$customers)) filter_active @endif" style="min-width: 185px;">
                            <span>Customer Name</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="customer_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$mainGroups)) filter_active @endif" style="min-width: 174px;" >
                            <span>Main Group Id</span>

                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="maingroupid_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$mainGroupCodes)) filter_active @endif" style="min-width: 196px;" >
                            <span>Main Group Name</span>

                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="maingroup_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$departments)) filter_active @endif" style="min-width: 162px;">
                            <span>Department</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="dept_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$workTypes)) filter_active @endif" style="min-width: 156px;">
                            <span>Work Type</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="work_type_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$agents)) filter_active @endif" style="min-width: 160px;">
                            <span>Agent Name</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="agent_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$caseManagers)) filter_active @endif" style="min-width: 170px;">
                            <span>Underwriter</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="case_manager_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort @if(!empty(@$status)) filter_active @endif" style="min-width: 186px;">
                            <span>Current Status</span>
                            <a class="po__trigger--center button" href="javascript:;" data-layer-id="current_status_layer"><i class="material-icons">filter_list</i></a>
                        </th>
                        <th class="disabled_sort">Current Status Updated By</th>
                        <th class="disabled_sort">Last Status Change Date</th>
                        <th class="disabled_sort">Current Owner</th>
                        <th class="disabled_sort">Number of days since last touched</th>
                        <th class="disabled_sort">Number of Amendments</th>
                        <th class="disabled_sort"></th>


                    </tr>
                    </thead>
                </table>
                    <div id="customer_layer" class="po__layer list" style="top: 98px !important;">
                        <p>Customer</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='customer-data-ajax' id="customer-data-ajax" name="customer[]" multiple="multiple">
                                @if(!empty(@$customers))
                                    @foreach(@$customers as $customer)
                                        <option value="{{$customer->_id}}" selected>{{$customer->fullName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>
                    <div id="maingroupid_layer" class="po__layer list">
                        <p>Main Group Id</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='maingroup-id-data-ajax' id="maingroup-id-data-ajax" name="main_group_id[]" multiple="multiple">
                                @if(!empty(@$mainGroups))
                                    @foreach(@$mainGroups as $main_grp)
                                        <option value="{{$main_grp}}" selected>{{$main_grp}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>
                    <div id="maingroup_layer" class="po__layer list">
                        <p>Main Group Name</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='maingroup-data-ajax' id="maingroup-data-ajax" name="main_group[]" multiple="multiple">
                                @if(!empty(@$mainGroupCodes))
                                    @foreach(@$mainGroupCodes as $main_code)
                                        <option value="{{$main_code->_id}}" selected>{{$main_code->fullName}}</option>
                                    @endforeach
                                @endif
                                @if (@$_GET['main_group'] && in_array('Nil', @$_GET['main_group']))
                                    <option value="Nil" selected>Nil</option>
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>

                    <div id="dept_layer" class="po__layer list">
                        <p>Department</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='dept-data-ajax' id="dept-data-ajax" name="department[]" multiple="multiple">
                                @if(!empty(@$departments))
                                    @foreach(@$departments as $department)
                                        <option value="{{$department->_id}}" selected>{{$department->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>

                    <div id="work_type_layer" class="po__layer list">
                        <p>Work Type</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='worktype-data-ajax' id="worktype-data-ajax" name="work_type[]" multiple="multiple">
                                @if(!empty(@$workTypes))
                                    @foreach(@$workTypes as $work)
                                        <option value="{{$work->_id}}" selected>{{$work->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>

                    <div id="agent_layer" class="po__layer list">
                        <p>Agent Name</p>
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

                    <div id="case_manager_layer" class="po__layer list">
                        <p>Underwriter</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='case_manager-data-ajax' id="case_manager-data-ajax" name="case_manager[]" multiple="multiple">
                                @if(!empty(@$caseManagers))
                                    @foreach(@$caseManagers as $case)
                                        <option value="{{$case->_id}}" selected>{{$case->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="filter_tr_action">
                            <button class='popover_cancel' type="button">Cancel</button>
                            <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                        </div>
                    </div>

                    <div id="current_status_layer" class="po__layer list">
                        <p>Current Status</p>
                        <div class="filter_tr">
                            <select style='width: 200px' class='current_status-data-ajax' id="current_status-data-ajax" name="current_status[]" multiple="multiple">
                                @if(!empty(@$status))
                                    @foreach(@$status as $status_data)
                                        <option value="{{$status_data->_id}}" selected>{{$status_data->status}}</option>
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
    </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">
    <div id="reinstate_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" name="reinstate_form" id="reinstate_form">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to reinstate ?</h3>
                                            <input class="" name="id" id="id" value="" type="hidden">
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="reinstate_button">Yes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@include('pipelines.filter_data')

<!-- DataTable -->
<script src="{{URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>
<script src="{{URL::asset('js/context-menu.min.js')}}"></script>

<script>

    //Onclick function for reinstate

    function reinstate_popup(id)
    {
        $('#id').val(id);
        $("#reinstate_popup .cd-popup").toggleClass('is-visible');
    }
    $('#reinstate_button').on('click', function() {
            $('#preLoader').show();
            var id = $('#id').val();
            $.ajax({
                url: 'reinstate-item/'+id,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        // window.location.href = '{{url('pipelines')}}';
                        location.reload();
                    }
                }
            });

        });
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


    // Data Table
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
                                }) //$('select[name^="customSort"] option[value="'+sortField+'"]').prop("selected",true);
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

    //filter function///////////////////
    function submitForm()
    {
        $('input:checkbox.datatabe-checkbox').each(function () {
            if(this.checked){
                var value = (this.checked ? $(this).val() : "");
                var testname = (this.checked ? $(this).attr('name'): "");
                if(value!='')
                {
                    if(selected_arrays.hasOwnProperty(testname)){
                        if($.inArray(value,selected_arrays[testname])!== -1)
                        {
                            selected_arrays[testname].splice( $.inArray(value, selected_arrays[testname]), 1 );
                            selected_arrays[testname].push(value);
                        }
                        else{
                            selected_arrays[testname].push(value);
                        }
                    }else{
                        selected_arrays[testname]=new Array();
                        selected_arrays[testname].push(value);
                    }
                }
            }
            if(!this.checked){
                value = $(this).val();
                 testname = $(this).attr('name');
                if($.inArray(value,selected_arrays[testname])!== -1)
                {
                    selected_arrays[testname].splice( $.inArray(value, selected_arrays[testname]), 1 );
                }
            }
        });
//        console.log(selected_arrays);
        if(Object.keys(selected_arrays).length!=0)
        {
              selected_arrays_parsed1= JSON.stringify(selected_arrays);
              localStorage.setItem('filterField',selected_arrays_parsed1);
        }
           filterData = localStorage.getItem('filterField');
        $('#datatable').DataTable().ajax.reload();

    }

    $(document).ready(function() {

        setTimeout(function() {
            $('#success_worktype').fadeOut('fast');
        }, 5000);
        var sortField = "";
        var searchField = "";
        var filter = $('#filter_data').val();

//
//        if(filterData['workType'])
//            $('#category').prop('checked',true);
//        if(filterData['mainGroup'])
//            $('#maingroup').prop('checked',true);
//        if(filterData['caseManager'])
//            $('#caseManager').prop('checked',true);
//        if(filterData['status'])
//            $('#status').prop('checked',true);
//        if(filterData['agent'])
//            $('#agent').prop('checked',true);
//
//        if(filterData['workTypeAll']){
//            $('#cat_all').prop('checked',true);
//            $("input[name='workType[]']").prop('checked',true);
//        }
//        if(filterData['mainGroupAll']){
//            $('#main_all').prop('checked',true);
//            $("input[name='mainGroup[]']").prop('checked',true);
//        }
//        if(filterData['caseManagerAll']){
//            $('#case_all').prop('checked',true);
//            $("input[name='caseManager[]']").prop('checked',true);
//        }
//        if(filterData['statusAll']){
//            $('#status_all').prop('checked',true);
//            $("input[name='status[]']").prop('checked',true);
//        }
//        if(filterData['agentAll']){
//            $('#agent_all').prop('checked',true);
//            $("input[name='agent[]']").prop('checked',true);
//        }
//        if(filterData['customerAll']){
//            $('#cust_all').prop('checked',true);
//            $("input[name='customer[]']").prop('checked',true);
//        }
//
//
//
//        if(filterData['workType'] && filterData['workType'].length > 0) {
//            jQuery.each(filterData['workType'], function (index, value) {
//
//                document.getElementById(value).checked = true;
//            });
//        }
////        if(filterData['mainGroup'] && filterData['mainGroup'].length > 0) {
////            jQuery.each(filterData['mainGroup'], function (index, value) {
////                document.getElementById(value).checked = true;
////            });
////        }
//         if(filterData['caseManager'] && filterData['caseManager'].length >0) {
//             jQuery.each(filterData['caseManager'], function (index, value) {
//                 document.getElementById(value).checked = true;
//             });
//         }
//         if(filterData['status'] && filterData['status'].length > 0) {
//             jQuery.each(filterData['status'], function (index, value) {
//                 document.getElementById(value).checked = true;
//             });
//         }
//         if(filterData['agent'] && filterData['agent'].length > 0) {
//             jQuery.each(filterData['agent'], function (index, value) {
//                 document.getElementById(value).checked = true;
//             });
//         }
//        if(filterData['customer'] && filterData['customer'].length > 0) {
//            jQuery.each(filterData['customer'], function (index, value) {
//                document.getElementById('c_'+value).checked = true;
//            });
//        }
        if(localStorage)
        {
            if(localStorage.getItem('sortField'))
            {
                sortField = localStorage.getItem('sortField');
                $('.current').html(sortField);
            }
            if(localStorage.getItem('searchField'))
            {
                searchField = localStorage.getItem('searchField');
                $('#search').val(searchField);
            }

        }


        $('#datatable').dataTable({
            scrollX:        true,
            scrollCollapse: true,
            autoWidth:         true,
            paging:         true,
            "language": {
                "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '</select></div>',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>'},

            bAutoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                type:'post',
                url:'{{\Illuminate\Support\Facades\URL::to('close-data')}}',
                data: function(d){
                    d.field=sortField;
                    d.searchField="";
                    d.filterData=filter;
                    d._token="{{csrf_token()}}"
                }

            },
            "preDrawCallback": function( settings ) {
                filterData=filterData;
            },
            "columns":[
                // { "data": "mainGroup","searchable": true, "visible" : true, "orderable" : false},
                { "data": "referenceNumber","searchable": true, "visible" : true, "orderable" : false},
                { "data": "created_at"     ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "created_by"     ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "customerId"     ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "customerName"   ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "maingroup_id"   ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "mainGroup"      ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "department"     ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "category"       ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "agent"          ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "underwriter"    ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "status"         ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "current_update" ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "status_date"    ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "caseManager"    ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "diff"           ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "amendments"     ,"searchable": true, "visible" : true, "orderable" : false},
                { "data": "action1"     ,"searchable": true, "visible" : true, "orderable" : false}
            ],

            "createdRow": function(row, data, dataIndex){
                $('[data-toggle="tooltip"]', row).tooltip();

            }


        })  .on( 'order.dt',  function () { reinitialize_scripts()} )
            .on( 'search.dt', function () { reinitialize_scripts() } )
            .on( 'page.dt',   function () { reinitialize_scripts() } )
            .on( 'draw.dt',   function () {  trActive() });
        //right click function for creating lead
        function trActive()
        {
            $('tr').click(function(){
                $('tr').not(this).removeClass("active");
                $(this).toggleClass("active");
                $(this).siblings(":first").text();
            });

            // var $span=$("#datatable tr");
            // $span.attr('id',function (index) {
            //     $(this).attr("id", 'rowid_'+index);
            //     $('#rowid_'+index).on('contextmenu', function(e) {
            //         e.preventDefault();
            //         superCm.createMenu(myMenu, e);
            //         var rowId=  $('#rowid_'+index).find('td:nth-child(1)').text();
            //         $('#ref_id').val(rowId);
            //     });
            // });
//             var myMenu = [{
//                 label: 'Create Lead',
//                 action: function(option, contextMenuIndex, optionIndex) {},
//                 submenu: [{
//                     label: '<a class="right_btn" id="Delivery"  onclick="createLead(this.id);">Create Delivery</a>',
//                     action: function(option, contextMenuIndex, optionIndex) {},
//                     submenu: null,
//                     disabled: false
//                 },{
//                     label: '<a class="right_btn" id="Collections"  onclick="createLead(this.id);">Create Collection</a>',
//                     action: function(option, contextMenuIndex, optionIndex) {},
//                     submenu: null,
//                     disabled: false
//                 },{
//                     label: '<a class="right_btn" id="Delivery & Collections"  onclick="createLead(this.id);">Create Delivery & Collection</a>',
//                     action: function(option, contextMenuIndex, optionIndex) {},
//                     submenu: null,
//                     disabled: false
//                 },
// //                        {
// //                        label: '<a class="right_btn" id="Direct Delivery"  onclick="createLead(this.id);">Direct Delivery</a>',
// //                        action: function(option, contextMenuIndex, optionIndex) {},
// //                        submenu: null,
// //                        disabled: false
// //                    },
//                     {
//                         label: '<a class="right_btn" id="Direct Collections"  onclick="createLead(this.id);">Direct Collection</a>',
//                         action: function(option, contextMenuIndex, optionIndex) {},
//                         submenu: null,
//                         disabled: false
//                     }],
//                 disabled: false
//             }
            // ];
        }

        function reinitialize_scripts()
        {
            $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();
        }

        /*
        * Reload for sorting*/

        $('#customSort').on('change',function(){

            localStorage.setItem('sortField',$('#customSort').val());
            location.reload();
        });
        /*
        * Keyup function for searching*/
        $('#search').on('keyup',function(){
            localStorage.setItem('searchField',$('#search').val());
            var table = $('#datatable').DataTable();
            table.search( this.value ).draw();
        });
        if($('#search').val()!="")
        {
            var value = $('#search').val();
            var table = $('#datatable').DataTable();
            table.search(value).draw();
        }
        //function for filter popover
        $('body').on('click', function (e) {console.log(this.id);
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                    if(localStorage)
                    {
                        filterData = localStorage.getItem('filterField');
                        if(filterData)
                        {
                            parsedTest = JSON.parse(filterData); //an array [1,2]
                            $.each(parsedTest, function( key, value ) {
                                if(key)
                                {
                                    console.log(key);
                                    $.each(value, function(key1,value1) {
                                        if(key==$('#' + value1).attr('name'))
                                        {
                                            $('#' + value1).prop('checked', true);
                                        }
                                        if(key=='customer')
                                        {
                                            $('#cust_all').prop('checked', true);
                                        }
                                        if(key=='maingroupId')
                                        {
                                            $('#main_all').prop('checked', true);
                                        }
                                        if(key=='maingroupCode')
                                        {
                                            $('#maingrp_all').prop('checked', true);
                                        }
                                        if(key=='department')
                                        {
                                            $('#department_all').prop('checked', true);
                                        }
                                        if(key=='workTypeAll')
                                        {
                                            $('#cat_all').prop('checked', true);
                                        }
                                        if(key=='agentAll')
                                        {
                                            $('#agent_all').prop('checked', true);
                                        }
                                        if(key=='casemanager')
                                        {
                                            $('#casemanager_all').prop('checked', true);
                                        }
                                        if(key=='status')
                                        {
                                            $('#status_all').prop('checked', true);
                                        }
                                    });
                                }
                            });
                        }

                    }
                }

                //steps for checking check boxes in filter///////////
                $("input[name='workTypeId.department']").on('change', function () {
                    $('#department_all').prop('checked',false);
                });
                $("input[name='status.id']").on('change', function () {
                    $('#status_all').prop('checked',false);
                });
                $("input[name='caseManager.id']").on('change', function () {
                    $('#casemanager_all').prop('checked',false);
                });
                $("input[name='workTypeId.id']").on('change', function () {
                    $('#cat_all').prop('checked',false);
                });
                $("input[name='customer.maingroupCode']").on('change', function () {
                    $('#maingrp_all').prop('checked',false);
                });
                $("input[name='customer.maingroupId']").on('change', function () {
                    $('#main_all').prop('checked',false);
                });
                $("input[name='status[]']").on('change', function () {
                    $('#status_all').prop('checked',false);
                });
                $("input[name='agent.id']").on('change', function () {
                    $('#agent_all').prop('checked',false);
                });
                $("input[name='customer.id']").on('change', function(){
                    $('#cust_all').prop('checked',false);
                });
                $('#maingrp_all').on('change', function () {
                    if($('#maingrp_all').is(":checked")) {
                        $("input[name='customer.maingroupCode']").prop('checked',true);
                    }
                    else{
                        $("input[name='customer.maingroupCode']").prop('checked',false);
                    }
                });
                $('#status_all').on('change', function () {
                    if($('#status_all').is(":checked")) {
                        $("input[name='status.id']").prop('checked',true);
                    }
                    else{
                        $("input[name='status.id']").prop('checked',false);
                    }
                });
                $('#casemanager_all').on('change', function () {
                    if($('#casemanager_all').is(":checked")) {
                        $("input[name='caseManager.id']").prop('checked',true);
                    }
                    else{
                        $("input[name='caseManager.id']").prop('checked',false);
                    }
                });
                $('#department_all').on('change', function () {
                    if($('#department_all').is(":checked")) {
                        $("input[name='workTypeId.department']").prop('checked',true);
                    }
                    else{
                        $("input[name='workTypeId.department']").prop('checked',false);
                    }
                });
                $('#cat_all').on('change', function () {
                    if($('#cat_all').is(":checked")) {
                        $("input[name='workTypeId.id']").prop('checked',true);
                    }
                    else{
                        $("input[name='workTypeId.id']").prop('checked',false);
                    }
                });
                $('#main_all').on('change', function () {
                    if($('#main_all').is(":checked")) {
                        $("input[name='customer.maingroupId']").prop('checked',true);
                    }
                    else{
                        $("input[name='customer.maingroupId']").prop('checked',false);
                    }
                });

                $('#agent_all').on('change', function () {
                    if($('#agent_all').is(":checked")) {
                        $("input[name='agent.id']").prop('checked',true);
                    }
                    else{
                        $("input[name='agent.id']").prop('checked',false);
                    }
                });
                $('#cust_all').on('change',function(){
                    if($('#cust_all').is(":checked")){
                        $("input[name='customer.id']").prop('checked',true);
                        $("input[name='customer']").prop('checked',true);
                    }
                    else{
                        $("input[name='customer']").prop('checked',false);
                        $("input[name='customer.id']").prop('checked',false);
                    }
                });
                $('#btn-clear').on('click', function () {
                    $("input[name='workType[]']").prop('checked',false);
                    $("input[name='mainGroup[]']").prop('checked',false);
                    $("input[name='caseManager[]']").prop('checked',false);
                    $("input[name='agent[]']").prop('checked',false);
                    $("input[name='status[]']").prop('checked',false);
                    $("input[name='customer[]']").prop('checked',false);
                    $('#cat_all').prop('checked',false);
                    $('#main_all').prop('checked',false);
                    $('#case_all').prop('checked',false);
                    $('#status_all').prop('checked',false);
                    $('#agent_all').prop('checked',false);
                    $('#cust_all').prop('checked',false);
                    // $("#categoryList").hide();
                    // $("#mainGroupList").hide();
                    // $("#caseManagerList").hide();
                    // $("#agentList").hide();
                    // $('#statusList').hide();

                });
         });

        });

    });
    $(document).click(function () {
        $('.popover_cancel').on('click', function (e) {
            $("body").trigger("click");
        });
        setTimeout(function() {
            $('#success_lead').fadeOut('fast');
        }, 5000);
    });

    $(document).ready(function () {
        localStorage.setItem('filterField', '');
    });

    //create lead function
    function createLead(dispatch_type) {
        var reference_number = $('#ref_id').val();
        var save_from = 'pipeline';
        $('#preLoader').show();
        $('.context-menu').hide();
        $.ajax({
            type: "POST",
            url: "{{url('dispatch/create-lead-other')}}",
            data: {
                dispatch_type: dispatch_type,
                reference_number: reference_number,
                save_from: save_from,
                _token: '{{csrf_token()}}'
            },
            success: function (data) {
                if (data) {
                    if (data.success==true) {
                        $('#preLoader').hide();
                        $('#success_lead').show();
                    } else if (data.success==false) {
                            $('#preLoader').hide();
                            $("#failed_customer").html('Sorry!You have already 20 leads in transferred list.Please close then you can create another lead.');
                            $("#failed_customer").show();
                            setTimeout(function() {
                                $('#failed_customer').fadeOut('fast');
                            }, 10000);
                            // $("#button_submit").attr( "disabled", false );
                    }
                }
            }
        });
    }
</script>
@endpush
