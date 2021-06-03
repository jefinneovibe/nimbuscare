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
    <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Lead adding failed.
    </div>
    <div class="alert alert-success alert-dismissible" role="alert" id="success_lead" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Lead Created Successfully.
    </div>
    <div class="data_table" style="margin-bottom: 0">
        <div class="tabbed clearfix">
            <ul>
                <li class="blue-bg"><a href="{{ url('pipelines') }}">Pipeline</a></li>
                <li class="grey-bg"><a href="{{ url('pending-issuance') }}">Pending Issuance</a></li>
                <li class="red-bg active"><a href="{{ url('pending-approvals') }}">Pending Approvals</a></li>
                <li class="grey-bg"><a href="{{ url('policies') }}">Policies</a></li>
            </ul>
        </div>
        <div id="admin">
            <div class="material-table table-responsive">
                <div class="table-header">
                    <span class="table-title">Pending Approvals</span>
                    <div class="actions">
                        <div class="sort">
                            <label>Sort :</label>
                            <div class="custom_select">
                                <select class="form_input" id="customSort" name="customSort">
                                    <option value="" data-display-text="">select</option>
                                    <option value="Customer Name">Customer Name</option>
                                    <option value="Agent Name">Agent Name</option>
                                    <option value="Work Type">Work Type</option>
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
                            <form method="post">
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a target="_blank" href="{{url('pending/export-pending-list')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <input type="hidden" id="ref_id">

                <form id="filterForm" name="filterForm" action="{{URL::to('pending-approvals')}}" method="get">
                <table id="datatable" style="text-overflow: ellipsis">
                    <thead>
                    <tr>
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
                        <th class="disabled_sort">Submitted for approval on</th>
                        <th class="disabled_sort">Submitted for approval from</th>
                        <th class="disabled_sort">Current owner of case</th>
                        <th class="disabled_sort">Discount</th>
                        <th class="disabled_sort">Total Premium Amount</th>
                        <th class="disabled_sort">Insurer Policy Number</th>
                        <th class="disabled_sort">IIB Policy Number</th>
                        <th class="disabled_sort">Insurer</th>
                        <th class="disabled_sort">Inception Date</th>
                        <th class="disabled_sort">Expiry Date</th>
                        <th class="disabled_sort">Currency</th>
                        <th class="disabled_sort">Invoice Date</th>
                        <th class="disabled_sort">Premium Invoice No</th>
                        <th class="disabled_sort">Commission Invoice No</th>
                        <th class="disabled_sort">Payment Mode</th>
                        <th class="disabled_sort">Payment Status</th>
                        <th class="disabled_sort">Date payment sent to Insurer</th>
                        <th class="disabled_sort">Delivery Mode</th>
                        <th class="disabled_sort">Name of the underwriter</th>
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
                </form>
            </div>
        </div>
    </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode(@$filter_data,TRUE)}}">
@endsection

@push('scripts')

    @include('pipelines.filter_data')

    <!-- DataTable -->
    <script src="{{URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

    <!-- Custom Select -->
    <script src="{{URL::asset('js/main/custom-select.js')}}"></script>
    <script src="{{URL::asset('js/context-menu.min.js')}}"></script>

    <script>

        var selected_arrays={};
        var selected_arrays_parsed1="";
        var  filterDataPending="";

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
            filterDataPending = localStorage.getItem('filterField');
            $('#datatable').DataTable().ajax.reload();

        }

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

        $(document).ready(function() {
            setTimeout(function() {
                $('#success_worktype').fadeOut('fast');
                $('#success_lead').fadeOut('fast');
            }, 5000);
            var sortFieldPending = "";
            var searchFieldPending = "";
            var filter = $('#filter_data').val();
            if(localStorage)
            {
                if(localStorage.getItem('sortFieldPending'))
                {
                    sortFieldPending = localStorage.getItem('sortFieldPending');
                    $('.current').html(sortFieldPending);
                }
                if(localStorage.getItem('searchFieldPending'))
                {
                    searchFieldPending = localStorage.getItem('searchFieldPending')
                    $('#search').val(searchFieldPending);
                }
            }

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
                    '<option value="-1">All</option>' +
                    '</select></div>',
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>'},

                bAutoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    type:'post',
                    url:'{{\Illuminate\Support\Facades\URL::to('pending/get-data')}}',
                    data: function(d){
                        d.field=sortFieldPending;
                        d.searchField="";
                        d.filterData=filter;
                        d._token="{{csrf_token()}}"
                    }

                },
                "preDrawCallback": function( settings ) {
                    filterDataPending=filterDataPending;
                },
                "columns":[
                    { "data": "referenceNumber","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "createdAt","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "createdBy","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "customerId","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "customerName","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "mainGroupID","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "mainGroup","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "department","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "category","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "agent","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "underWriter","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "submittedApprovalOn","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "submittedApprovalFrom","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "caseManager","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "discount","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "totalPremiumAmount","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "insurerPolicyNumber","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "IIBPolicyNumber","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "insurer","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "inceptionDate","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "expiryDate","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "currency","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "invoiceDate","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "premiumInvoiceNo","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "commissionInvoiceNo","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "paymentMode","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "paymentStatus","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "datepaymentsenttoInsurer","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "deliveryMode","searchable": true, "visible" : true, "orderable" : false},
                    { "data": "nameoftheunderwriter","searchable": true, "visible" : true, "orderable" : false},

                ]
//
            })  .on( 'order.dt',  function () { reinitialize_scripts() } )
                .on( 'search.dt', function () { reinitialize_scripts() } )
                .on( 'page.dt',   function () { reinitialize_scripts() } )
                .on( 'draw.dt',   function () {  trActive() } );
            function trActive()
            {
                $('tr').click(function(){
                    $('tr').not(this).removeClass("active");
                    $(this).toggleClass("active");
                    $(this).siblings(":first").text();
                });

                var $span=$("#datatable tr");
                $span.attr('id',function (index) {
                    $(this).attr("id", 'rowid_'+index);
                    $('#rowid_'+index).on('contextmenu', function(e) {
                        e.preventDefault();
                        superCm.createMenu(myMenu, e);
                        var rowId=  $('#rowid_'+index).find('td:nth-child(1)').text();
                        $('#ref_id').val(rowId);
                    });
                });
//        .find('td:nth-child(1)').text();
                var myMenu = [{
                    label: 'Create Lead',
                    action: function(option, contextMenuIndex, optionIndex) {},
                    submenu: [{
                        label: '<a class="right_btn" id="Delivery"  onclick="createLead(this.id);">Create Delivery</a>',
                        action: function(option, contextMenuIndex, optionIndex) {},
                        submenu: null,
                        disabled: false
                    },{
                        label: '<a class="right_btn" id="Collections"  onclick="createLead(this.id);">Create Collection</a>',
                        action: function(option, contextMenuIndex, optionIndex) {},
                        submenu: null,
                        disabled: false
                    },{
                        label: '<a class="right_btn" id="Delivery & Collections"  onclick="createLead(this.id);">Create Delivery & Collection</a>',
                        action: function(option, contextMenuIndex, optionIndex) {},
                        submenu: null,
                        disabled: false
                    },
//                        {
//                        label: '<a class="right_btn" id="Direct Delivery"  onclick="createLead(this.id);">Direct Delivery</a>',
//                        action: function(option, contextMenuIndex, optionIndex) {},
//                        submenu: null,
//                        disabled: false
//                    },
                        {
                            label: '<a class="right_btn" id="Direct Collections"  onclick="createLead(this.id);">Direct Collection</a>',
                            action: function(option, contextMenuIndex, optionIndex) {},
                            submenu: null,
                            disabled: false
                        }],
                    disabled: false
                }
                ];
            }

            function reinitialize_scripts()
            {
                $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();
            }
            /*
            * Reload for sorting*/

            $('#customSort').on('change',function(){

                localStorage.setItem('sortFieldPending',$('#customSort').val());
                location.reload();
            });
            /*
            * Keyup function for searching*/
            $('#search').on('keyup',function(){
                localStorage.setItem('searchFieldPending',$('#search').val());
                var table = $('#datatable').DataTable();
                table.search( this.value ).draw();
            });
            if($('#search').val()!="")
            {
                var value = $('#search').val();
                var table = $('#datatable').DataTable();
                table.search(value).draw();
            }

            /*
            * Filter implementation*/
            $('#btn-filterForm').on('click',function () {

                $('#filterForm').submit();
                //location.reload();
            });
            $('body').on('click', function (e) {
                $('[data-toggle="popover"]').each(function () {
                    //the 'is' for buttons that trigger popups
                    //the 'has' for icons within a button that triggers a popup
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                        $(this).popover('hide');
                        if(localStorage)
                        {
                            filterDataPending = localStorage.getItem('filterField');
                            if(filterDataPending)
                            {
                                parsedTest = JSON.parse(filterDataPending); //an array [1,2]
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



        function listCategory() {

            if($('#category').is(":checked")){
                $("#categoryList").show();
            }
            else{
                $("input[name='workType[]']").prop('checked',false);
                $("#categoryList").hide();
            }
        }

        function listMainGroup() {

            if($('#maingroup').is(":checked"))
                $("#mainGroupList").show();
            else{
                $("input[name='mainGroup[]']").prop('checked',false);
                $("#mainGroupList").hide();
            }
        }
        function caseManagerList()
        {
            if($('#caseManager').is(":checked"))
                $("#caseManagerList").show();
            else{
                $("input[name='caseManager[]']").prop('checked',false);
                $("#caseManagerList").hide();
            }
        }
        function agentList()
        {
            if($('#agent').is(":checked"))
                $("#agentList").show();
            else{
                $("input[name='agent[]']").prop('checked',false);
                $("#agentList").hide();
            }
        }
        function statusList()
        {
            if($('#status').is(":checked"))
                $('#statusList').show();
            else{
                $("input[name='status[]']").prop('checked',false);
                $('#statusList').hide();
            }
        }
        function createLead(dispatch_type) {
            var reference_number=$('#ref_id').val();
            var save_from='pending_approval';
            $('#preLoader').show();
            $('.context-menu').hide();
            $.ajax({
                type: "POST",
                url: "{{url('dispatch/create-lead-other')}}",
                data:{dispatch_type : dispatch_type, reference_number:reference_number,save_from:save_from,_token : '{{csrf_token()}}'},
                success: function(data){
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

    {{--<!-- Popup -->--}}
    {{--<div id="filter_popup">--}}
        {{--<div class="cd-popup">--}}
            {{--<form id="filterForm" name="filterForm" action="pending-approvals" method="get">--}}
                {{--<div class="cd-popup-container">--}}
                    {{--<div class="modal_content">--}}
                        {{--<div class="clearfix">--}}
                            {{--<h1>Filter</h1>--}}
                            {{--<button class="btn btn_reset blue_btn" id="btn-clear" type="button">Clear All</button>--}}
                        {{--</div>--}}


                        {{--<div class="content_spacing clearfix">--}}
                            {{--<div class="md--half" style="display: none">--}}
                                {{--<div class="custom_checkbox">--}}
                                    {{--<input type="checkbox" name="category" value="" id="category" class="inp-cbx" style="display: none" onchange="listCategory()" checked>--}}
                                    {{--<label for="category" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Work Type</span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="custom_checkbox">--}}
                                    {{--<input type="checkbox" name="maingroup" value="" id="maingroup" class="inp-cbx" style="display: none" onchange="listMainGroup()" checked>--}}
                                    {{--<label for="maingroup" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Main Group</span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="custom_checkbox">--}}
                                    {{--<input type="checkbox" name="caseManager" value="" id="caseManager" class="inp-cbx" style="display: none" onchange="caseManagerList()" checked>--}}
                                    {{--<label for="caseManager" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Case Manager</span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}

                                {{--<div class="custom_checkbox">--}}
                                    {{--<input type="checkbox" name="agent" value="" id="agent" class="inp-cbx" style="display: none" onchange="agentList()" checked>--}}
                                    {{--<label for="agent" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Agent</span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="md--half" style="display: none" id="categoryList">--}}
                                {{--<h5>Work Type</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="workTypeAll" value="cat_all" id="cat_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="cat_all" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                            {{--<span>All</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@if(!empty($workTypes))--}}
                                        {{--@forelse($workTypes as $workType)--}}
                                            {{--<div class="custom_checkbox">--}}
                                                {{--<input type="checkbox" name="workType[]" value="{{$workType->_id}}" id="{{$workType->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="{{$workType->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$workType->name}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Category Found.--}}
                                        {{--@endforelse--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="md--half" style="display: none" id="mainGroupList">--}}
                                {{--<h5>Main Groups</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="mainGroupAll" value="main_all" id="main_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="main_all" class="cbx">--}}
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
                                                {{--<input type="checkbox" name="mainGroup[]" value="{{$mainGroup->_id}}" id="{{$mainGroup->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="{{$mainGroup->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$mainGroup->firstName}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Main Group Found.--}}
                                        {{--@endforelse--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="md--half">--}}
                                {{--<h5>Customer Name</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="customerAll" value="cust_all" id="cust_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="cust_all" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                            {{--<span>All</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@if(!empty($customers))--}}
                                        {{--@forelse($customers as $customer)--}}
                                            {{--<div class="custom_checkbox">--}}
                                                {{--<input type="checkbox" name="customer[]" value="{{$customer->_id}}" id="c_{{$customer->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="c_{{$customer->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$customer->fullName}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Customers Found.--}}
                                        {{--@endforelse--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="md--half" style="display: none" id="caseManagerList">--}}
                                {{--<h5>Case Managers</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="caseManagerAll" value="case_all" id="case_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="case_all" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                            {{--<span>All</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@if(!empty($caseManagers))--}}
                                        {{--@forelse($caseManagers as $caseManager)--}}
                                            {{--<div class="custom_checkbox">--}}
                                                {{--<input type="checkbox" name="caseManager[]" value="{{$caseManager->_id}}" id="{{$caseManager->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="{{$caseManager->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$caseManager->name}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Case Manager Found.--}}
                                        {{--@endforelse--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="md--half" style="display: none" id="agentList">--}}
                                {{--<h5>Agents</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="agentAll" value="agent_all" id="agent_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="agent_all" class="cbx">--}}
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
                                            {{--No Case Manager Found.--}}
                                        {{--@endforelse--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}

                    {{--<div class="modal_footer">--}}
                        {{--<button class="btn btn-primary btn-link btn_cancel" id="btn-cancel" type="button">Cancel</button>--}}
                        {{--<button class="btn btn-primary btn_action" type="buttton" id="btn-filterForm">Apply Filter</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</div><!--//END Popup -->--}}

@endpush
