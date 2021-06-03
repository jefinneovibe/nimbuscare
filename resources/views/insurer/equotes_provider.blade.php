
@extends('layouts.insurer_layout')


@section('content')
    @if (session('quotation'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_quot">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('quotation') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="error_quot">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('error') }}
        </div>
    @endif
        <div class="data_table">

            <div id="admin">
                <div class="material-table table-responsive">
                    <div class="table-header">
                        <span class="table-title">E-quotes to be Provided</span>
                        <div class="actions">

                            <div class="sort">
                                <label>Sort :</label>
                                <div class="custom_select">
                                    <select class="form_input" id="e-quot_sort" name="e-quot_sort">
                                        <option value="">Select</option>
                                        <option value="Category">Category</option>
                                        <option value="Main Group">Main Group</option>
                                        <option value="Customer Name">Customer Name</option>
                                        <option value="Case Manager">Case Manager</option>
                                        {{--<option value="Last Updated By">Last Updated By</option>--}}
                                        {{--<option value="Last Updated At">Last Updated At</option>--}}
                                        <option value="Status">Status</option>
                                        {{--<option value="Agent">Agent</option>--}}
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
                                    <input type="text" class="form-control" placeholder="Search" id="e_quot_search">
                                </div>
                                <button type="button" class="btn btn-white btn-raised btn-fab btn-round">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a target="_blank" href="{{url('insurer/export-eQuotesProvider')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                      <form id="filterForm" name="filterForm" action="{{URL::to('insurer/e-quotes-provider')}}" method="get">
                    <table id="datatable">
                        <thead>
                        <tr>
                            <th class="disabled_sort sorting_disabled">Category
                                <span class="th_sort" data-toggle="popover" data-placement="bottom" data-container="body"
                                      data-html="true"  data-content="<div class='md--half'>

                            <h5>WorkType</h5>
                            <div class='pre-scrollable'>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='workTypeAll' form ='filterForm' value='0' id='cat_all' class='inp-cbx datatabe-checkbox' style='display: none'>
                                    <label for='cat_all' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($workTypes))
                                @forelse($workTypes as $workType)
                                        <div class='custom_checkbox'>
                                            <input type='checkbox' name='workTypeId.id' form ='filterForm' value='{{$workType->_id}}' id='{{$workType->_id}}' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                            <label for='{{$workType->_id}}' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$workType->name}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No category Found.
@endforelse
                                @endif
                                        </div>
                                    </div>
                                    <div class='popover_foot'>
                                        <button class='popover_cancel'>Cancel</button>
                                        <button class='popover_apply' type='button'  onclick='submitForm()' id='btn-filterForm'>Apply</button>
                                    </div>">
                                <i class="material-icons">filter_list</i>
                            </span></th>
                            <th class="disabled_sort sorting_disabled">Main Group
                                <span class="th_sort" data-toggle="popover" data-placement="bottom" data-container="body"
                                      data-html="true"  data-content="<div class='md--half'>

                            <h5>Main Groups</h5>
                            <div class='pre-scrollable'>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='maingroupId' form ='filterForm' value='0' id='main_all' class='inp-cbx datatabe-checkbox' style='display: none'>
                                    <label for='main_all' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='customer.maingroupId' form ='filterForm' value='Nil' id='Nil' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                    <label for='Nil' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>Nil</span>
                                    </label>
                                </div>
                                @if(!empty($mainGroups))
                                @forelse($mainGroups as $mainGroup)
                                        <div class='custom_checkbox'>
                                            <input type='checkbox' name='customer.maingroupId' form ='filterForm' value='{{$mainGroup->_id}}' id='{{$mainGroup->_id}}' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                            <label for='{{$mainGroup->_id}}' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$mainGroup->firstName}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Main Group Found.
@endforelse
                                @endif
                                        </div>
                                    </div>
                                    <div class='popover_foot'>
                                        <button class='popover_cancel'>Cancel</button>
                                        <button class='popover_apply' type='button'  onclick='submitForm()'>Apply</button>
                                    </div>">
                                <i class="material-icons">filter_list</i>
                            </span></th>
                            <th class="disabled_sort sorting_disabled">Customer Name
                                <span class="th_sort" data-toggle="popover" data-placement="bottom" data-container="body"
                                      data-html="true"  data-content="<div class='md--half'>

                            <h5>Customers</h5>
                            <div class='pre-scrollable'>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='customer' form ='filterForm' value='0' id='cust_all' class='inp-cbx datatabe-checkbox' style='display: none'>
                                    <label for='cust_all' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($customers))
                                @forelse($customers as $customer)
                                        <div class='custom_checkbox'>
                                            <input type='checkbox' name='customer.id' form ='filterForm' value='{{$customer->_id}}' id='{{$customer->_id}}' class='inp-cbx datatabe-checkbox' style='display: none'>
                                            <label for='{{$customer->_id}}' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$customer->fullName}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Customers Found.
@endforelse
                                @endif
                                        </div>
                                    </div>
                                    <div class='popover_foot'>
                                        <button class='popover_cancel'>Cancel</button>
                                        <button class='popover_apply' type='button'  onclick='submitForm()'>Apply</button>
                                    </div>">
                                <i class="material-icons">filter_list</i>
                            </span>
                            </th>
                            <th class="disabled_sort sorting_disabled">Case Manager
                                <span class="th_sort" data-toggle="popover" data-placement="bottom" data-container="body"
                                      data-html="true"  data-content="<div class='md--half'>

                            <h5>Underwriter</h5>
                            <div class='pre-scrollable'>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='casemanager' form ='filterForm' value='0' id='casemanager_all' class='inp-cbx datatabe-checkbox' style='display: none'>
                                    <label for='casemanager_all' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($caseManagers))
                                @forelse($caseManagers as $case)
                                        <div class='custom_checkbox'>
                                            <input type='checkbox' name='caseManager.id' form ='filterForm' value='{{$case->id}}' id='{{$case->id}}' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                            <label for='{{$case->id}}' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$case->name}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Main Group Found.
@endforelse
                                @endif
                                        </div>
                                    </div>
                                    <div class='popover_foot'>
                                        <button class='popover_cancel'>Cancel</button>
                                        <button class='popover_apply' type='button'  onclick='submitForm()'>Apply</button>
                                    </div>">
                                <i class="material-icons">filter_list</i>
                            </span></th>
                            {{--<th class="disabled_sort sorting_disabled">Last updated by</th>--}}
                            {{--<th class="disabled_sort sorting_disabled">Last updated at</th>--}}
                            <th>Status
                                <span class="th_sort" data-toggle="popover" data-placement="bottom" data-container="body"
                                      data-html="true"  data-content="<div class='md--half'>

                            <h5>Status</h5>
                            <div class='pre-scrollable'>
                                <div class='custom_checkbox'>
                                    <input type='checkbox' name='status' form ='filterForm' value='0' id='status_all' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                    <label for='status_all' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($status))
                                @forelse($status as $status_detail)
                                        <div class='custom_checkbox'>
                                            <input type='checkbox' name='status.id' form ='filterForm' value='{{$status_detail->id}}' id='{{$status_detail->id}}' class='inp-cbx  datatabe-checkbox' style='display: none'>
                                            <label for='{{$status_detail->id}}' class='cbx'>
                                    <span>
                                        <svg width='10px' height='8px' viewBox='0 0 12 10'>
                                          <polyline points='1.5 6 4.5 9 10.5 1'></polyline>
                                        </svg>
                                    </span>
                                    @if(is_array(@$status_detail->status))
                                    <span>{{@$status_detail->status['status']}}</span>
                                    @else
                                    <span>{{@$status_detail->status}}</span>
                                    @endif
                                                
                                            </label>
                                        </div>
                                    @empty
                                        No Main Group Found.
@endforelse
                                @endif
                                        </div>
                                    </div>
                                    <div class='popover_foot'>
                                        <button class='popover_cancel'>Cancel</button>
                                        <button class='popover_apply' type='button'  onclick='submitForm()'>Apply</button>
                                    </div>">
                                <i class="material-icons">filter_list</i>
                            </span></th>
                            {{--<th>Agent</th>--}}
                            <th style="width: 120px" class="disabled_sort sorting_disabled"></th>
                        </tr>
                        </thead>
                        {{--<tbody>--}}
                        {{--<tr>--}}
                            {{--<td>Employers Liability</td>--}}
                            {{--<td>Neovibe</td>--}}
                            {{--<td>Rabeka</td>--}}
                            {{--<td>Anish</td>--}}
                            {{--<td>Admin</td>--}}
                            {{--<td>06-07-2018</td>--}}
                            {{--<td>Submitted</td>--}}
                            {{--<td>Azeem</td>--}}
                            {{--<td><button href="#" class="btn btn-sm btn-success" style="font-weight: 600" disabled="">View Details</button></td>--}}
                        {{--</tr>--}}
                        {{--</tbody>--}}
                    </table>
                    </form>
                </div>
            </div>
        </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">
        @endsection

@push('scripts')
    @include('pipelines.filter_data');


<!-- DataTable -->
<script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

<!-- Custom Select -->
<script src="{{ URL::asset('js/main/custom-select.js')}}"></script>

<!-- Modal -->


<script>


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

    $(window).load(function() {
        $('#preLoader').fadeOut(500);
    });

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

        var sortField = "";
        var searchField = "";
        //function for filter popover
        $('body').on('click', function (e) {
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
                                    // console.log(key);
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
                                            $('#agentAll').prop('checked', true);
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
        if(localStorage)
        {
            if(localStorage.getItem('searchField'))
            {
                searchField = localStorage.getItem('searchField')
                $('#e_quot_search').val(searchField);
            }
            if(localStorage.getItem('sortField'))
            {
                sortField = localStorage.getItem('sortField');
                $('.current').html(sortField); 
            }
        }
        $('#datatable').dataTable({
        //     "oLanguage": {
        //         "sStripClasses": "",
        //         "sSearch": "",
        //         "sSearchPlaceholder": "Enter Keywords Here",
        //         "sInfo": "_START_ -_END_ of _TOTAL_",
        //         "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
        //         '<option value="10">10</option>' +
        //         '<option value="20">20</option>' +
        //         '<option value="30">30</option>' +
        //         '<option value="40">40</option>' +
        //         '<option value="50">50</option>' +
        //         '<option value="-1">All</option>' +
        //         '</select></div>'
        //     },
            "language": {
                "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">All</option>' +
                '</select></div>',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>'},

            bAutoWidth: false,
            processing: true,
            serverSide: true,
            ajax: { 
                type:'post',
                url:'{{\Illuminate\Support\Facades\URL::to('insurer/get-e-quotes')}}',
                data: function(d){
                    d.field=sortField;
                    d.searchField="";
                    d.filterData=filterData;
                    d._token="{{csrf_token()}}"
                }

            },
            "preDrawCallback": function( settings ) {
                filterData=filterData;
            },
            "columns":[
                { "data": "category","searchable": true, "visible" : true, "orderable" : false},
                { "data": "maingroup","searchable": true, "visible" : true, "orderable" : false},
                { "data": "customer_name","searchable": true, "visible" : true, "orderable" : false},
                { "data": "case_manager","searchable": true, "visible" : true, "orderable" : false},
                // { "data": "updated_by","searchable": true, "visible" : true, "orderable" : false},
                // { "data": "updatedAt","searchable": true, "visible" : true, "orderable" : false},
                { "data": "status","searchable": true, "visible" : true, "orderable" : false},
                // { "data": "agent","searchable": true, "visible" : true, "orderable" : false},
                { "data": "action","searchable": false, "visible" : true, "orderable" : false}

            ]
        });
        if($('#e_quot_search').val()!="")
        {
            var value = $('#e_quot_search').val();
            var table = $('#datatable').DataTable();
            table.search(value).draw();
        }
        setTimeout(function() {
            $('#success_quot').fadeOut('fast');
        }, 5000);
        setTimeout(function() {
            $('#error_quot').fadeOut('fast');
        }, 5000);

        // Key up function for searching
        $('#e_quot_search').on('keyup', function(){
            localStorage.setItem('searchField',$('#e_quot_search').val());
            var table = $('#datatable').DataTable();
            table.search( this.value ).draw();
        });

        // Reload function for sorting
        $('#e-quot_sort').on('change', function () {
            // alert("in");
            localStorage.setItem('sortField', $('#e-quot_sort').val());
            location.reload();
        });
        $('#btn-filterForm').on('click', function () {
            $('#filterForm').submit();
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


</script>


@endpush