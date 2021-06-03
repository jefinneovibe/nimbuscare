
@extends('layouts.dispatch_layout')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_dispatch">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div> 
    @endif
    <div class="data_table" id="data">
        <div id="admin" class="filter_main_sec">
            <form id="filterForm" name="filterForm" action="{{URL::to('dispatch/all-leads')}}" method="get">
                <div class="material-table table-responsive">
                    <div class="table-header">
                        <span class="table-title">All Leads</span>
                        <div class="actions">
                            <div class="sort">
                                <label>Sort :</label>
                                <div class="custom_select">
                                    <select class="form_input" id="customer_sort" name="customer_sort">
                                        <option value="">Select</option>
                                        <option value="Agent">Agent</option>
                                        <option value="Case Manager">Case Manager</option>
                                        <option value="Customer Name">Customer Name</option>
                                        <option value="Delivery Mode">Delivery Mode</option>
                                        <option value="Dispatch Type">Dispatch Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter_icon" style="display: none;">
                                <button class="btn export_btn waves-effect auto_modal" data-toggle="tooltip" data-placement="bottom" title="Filter" data-container="body" data-modal="filter_popup">
                                    <i class="material-icons">filter_list</i>
                                </button>
                            </div>
                            <div class="form-inline ml-auto">
                                <div class="form-group page_no">
                                    <input type="text" class="form-control" placeholder="Search" name="search" id="search">
                                </div>
                                <button type="button" class="btn btn-white btn-raised btn-fab btn-round">
                                    <i class="material-icons">search</i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="datatable">
                        <thead>
                        <tr>
                            <th class="disabled_sort">Reference Number</th>
                            <th class="disabled_sort @if(!empty(@$customers)) filter_active @endif" style="min-width: 184px;">
                                <span>Customer Name</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="customer_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort">Contact No</th>
                            <th class="disabled_sort">Recipient Name</th>
                            <th class="disabled_sort">Customer Code</th>
                            <th class="disabled_sort">Creation Date</th>
                            <th class="disabled_sort @if(!empty(@$agents)) filter_active @endif" style="min-width: 184px;" >
                                <span>Agent</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="agent_layer2"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$case_managers)) filter_active @endif" style="min-width: 172px;">
                                <span>Case Manager</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="case_manager_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$dispatch_type_check)) filter_active @endif" style="min-width: 172px;">
                                <span>Dispatch Type</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="dispatch_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$delivery_mode_check)) filter_active @endif" style="min-width: 174px;">
                                <span>Delivery Mode</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="delivery_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort @if(!empty(@$assigned_to)) filter_active @endif" style="min-width: 162px;">
                                <span>Assigned To</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="assigned_layer"><i class="material-icons">filter_list</i></a>
                            </th>
                            <th class="disabled_sort">Status</th>
                            <th class="disabled_sort"></th>
                            {{--<th class="disabled_sort"></th>--}}
                        </tr>
                        </thead>
                    </table>
                </div>

                <div id="customer_layer" class="po__layer list">
                    <p>Customer Name</p>
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
                        <button type='button' class='popover_cancel'>Cancel</button>
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
                        <button type='button' class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="case_manager_layer" class="po__layer list">
                    <p>Case Manager</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='case_manager-data-ajax' id="case_manager-data-ajax" name="case_manager[]" multiple="multiple">
                            @if(!empty(@$case_managers))
                                @foreach(@$case_managers as $case)
                                    <option value="{{$case->_id}}" selected>{{$case->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button type='button' class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="dispatch_layer" class="po__layer list">
                    <p>Dispatch Type</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='dispatch-data-ajax' id="dispatch-data-ajax" name="dispatch[]" multiple="multiple">
                            @if(!empty(@$dispatch_type_check))
                                @foreach(@$dispatch_type_check as $dispatch)
                                    <option value="{{$dispatch->_id}}" selected>{{$dispatch->type}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button type='button' class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="delivery_layer" class="po__layer list">
                    <p>Delivery Mode</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='delivery-data-ajax' id="delivery-data-ajax" name="delivery[]" multiple="multiple">
                            @if(!empty(@$delivery_mode_check))
                                @foreach(@$delivery_mode_check as $delivery)
                                    <option value="{{$delivery->_id}}" selected>{{$delivery->deliveryMode}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button type='button' class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
                <div id="assigned_layer" class="po__layer list">
                    <p>Assigned To</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='assigned-data-ajax' id="assigned-data-ajax" name="assigned[]" multiple="multiple">
                            @if(!empty(@$assigned_to))
                                @foreach(@$assigned_to as $assigned)
                                    <option value="{{$assigned->_id}}" selected>{{$assigned->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="filter_tr_action">
                        <button type='button' class='popover_cancel'>Cancel</button>
                        <button class='popover_apply' type='button'  onclick='submitFilterForm()'>Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">
    <input  type="hidden" id="current_path" name="current_path" value="{{$current_path}}">
    {{--view_lead_popup --}}
    <div id="view_lead" class="full_width">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>Dispatch / Collections Slip (Leads List)</h1>
                    <hr>
                    <div class="clearfix"></div>

                    {{csrf_field()}}
                    <input type="hidden" id="lead_id" name="lead_id">
                    <input type="hidden" id="save_method" name="save_method">
                    <input type="hidden" id="uniqIdArray" name="uniqIdArray">
                    <div id="append_page"></div>
                    <div class="chat_main">
                        <header>
                            <h3 class="card_sub_heading">Comments</h3>
                        </header>
                        <ul id="chat">
                            <div id="load"> <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>
                        </ul>
                        <footer>
                            <textarea id="new_comment" name="new_comment" placeholder="Type your comment..." onkeyup="post()"></textarea>
                            <a href="#" id="send_comment_button" class="send_btn" title="Send" onclick="sendComment();"><i class="material-icons"> send </i></a>
                        </footer>
                        <label id="new_comment-error" style="color: red;display: none;margin: 10px 20px 0;">Please type comment</label>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn_cancel" id="btn_cancel_save" type="button">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--Delete popup--}}
    <div id="delete_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" name="lead_delete" id="lead_delete">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to delete lead ?</h3>
                                            <input class="leads_id" name="leads_id" id="leads_id" value="" type="hidden">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" id="delete_user">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{--End Comment popup--}}

    <input type="hidden" id="leadId" name="leadId" value="{{session('leadId')}}">
    <style>
        td.name{
            opacity: 1 !important;
        }
    </style>

@endsection
@push('scripts')
    <!-- Date Picker -->
    <script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
    <script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>
    <!-- Bootstrap Select -->
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

    @include('dispatch.filter_data')
    <script>
        var sortField = "";
        var searchField = "";
        /*
        * Filter implementation*/
        $('#btn-filterForm').on('click',function () {

            $('#filterForm').submit();
        });
        var filter = $('#filter_data').val();
        $('.datetimepicker').datetimepicker({
            format: 'DD/MM/YYYY / hh:mm a',
            icons: {
                time: "fa fa-clock-o",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });


        var chatContainer = document.querySelector('#chat');

        //function to send comment
        function sendComment ()
        {
            var new_comment= $('#new_comment').val();
            if(new_comment=='')
            {
                $('#new_comment-error').show();
                return false;
            }
            else{
                $('#new_comment-error').hide();
            }
            $('#new_comment').val('');
            var lead_id= $('#lead_id').val();
            $('#chat').append([
                '<div id="loader"><i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>'
            ]);

            $.ajax({
                method: 'post',
                url: '{{url('dispatch/save-dispatch-comment')}}',
                data: {'new_comment':new_comment,'lead_id':lead_id, _token : '{{csrf_token()}}'},
                success: function (result) {
                    if (result.success==true) {
                        $('#comment').remove();
                        $('#loader').remove();
                        $('#new_comment').val('');
                        chatContainer.scrollTop = chatContainer.scrollHeight;

                        $('#chat').append(['<li class="you">'+
                        '<div class="entete">'+
                        '<h3 style="font-style: italic">'+' '+result.commentBy+' - <span>'+result.date+''+' - '+result.time+' '+'</span> - <b style="font-style: normal">'+new_comment+'</b></h3>'+
                        '</div>'+

                        '</li>']);
                        $(function () {
                            var wtf = $('#chat');
                            var height = wtf[0].scrollHeight;
                            wtf.scrollTop(height);
                        });
                    }
                }

            });
        }

        //load previous comments when page load
        function loadPreviousComments()
        {
            var i;
            var comment;
            var lead_id= $('#lead_id').val();
            $('#chat').html('');
            $('#chat').html(  '<div id="loader"><i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>'
            );
            $.ajax({
                method: 'post',
                url: '{{url('dispatch/load-dispatch-comment')}}',
                data: {'lead_id':lead_id, _token : '{{csrf_token()}}'},
                dataType:'json',
                success: function (data) {
                    $('#load').remove();
                    $('#loader').remove();
                    if (data!='') {
                        for(i = 0; i<data.length; i++) {
                            comment = data[i];
                            if(comment['docId']){
                                if(comment['docId'] !=""){
                                    var remark='<span style="color:red">'+ comment['comment']+'</span>';
                                }
                            }else{
                                var remark=comment['comment'];
                            }
                            if(comment['commentBy']!='') {
                                $('#chat').append(['<li class="you">' +
                                '<div class="entete">' +
                                '<h3 style="font-style: italic">' + '  ' + comment['commentBy'] +' - <span> ' + comment['date'] + ' '+' - '+ comment['commentTime'] +''+'</span> - <b style="font-style: normal">'+remark+'</b></h3>' +
                                '</div>' +
                                '</li>']);
                            }
                        }
                    }
                    else{
                        $('#chat').append(['<li class="you">' +
                        '<div class="entete">' +
                        '<h3 style="font-style: italic"> <span id="comment"> No comments available.</span> </h3>' +
                        '</div>' +
                        '</li>']);
                        $('#loader').hide();
                    }
                    $(function () {
                        var wtf = $('#chat');
                        var height = wtf[0].scrollHeight;
                        wtf.scrollTop(height);
                    });
                }
            });
            $('#chat').scrollTop = $('#chat').scrollHeight;

        }

        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
                /*For retrieve the web page status using local storage*/
                if(localStorage)
                {
                    if(localStorage.getItem('searchAll')!=null)
                    {
                        search(localStorage.getItem('searchAll'));
                    }
                    if(localStorage.getItem('sortLead'))
                    {
                        sort(localStorage.getItem('sortLead'));
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
                $('#view_lead').on('shown', function() {
                });

                if(localStorage)
                {
                    if(localStorage.getItem('sortLead'))
                    {
                        sortField = localStorage.getItem('sortLead');
                        $('.current').html(sortField);
                    }
                    if(localStorage.getItem('searchLead'))
                    {
                        searchField = localStorage.getItem('searchLead');
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
//                        '<option value="-1">All</option>' +
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

                        url:'{{\Illuminate\Support\Facades\URL::to('dispatch/get-all-leads')}}',
                        data: function(d){
                            d.field=sortField;
                            d.searchField="";
                            d.filterData=filter;
                            d._token="{{csrf_token()}}"
                        }
                    },
                    "columns": [
                        { "data": "referenceNumber","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "customerName","searchable": true, "visible" : true ,'orderable' : false},
                        { "data": "contactNo","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "recipientName","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "customerCode","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "created","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "agent" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "caseManager" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "dispatchType" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "deliveryMode" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "assign" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "status" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "delete_button" ,"searchable": false, "visible" : true,'orderable' : false}
                    ]


                }) .on('draw.dt', function(){
                    $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();
                });
                /*
                * Sorting the table by the Drop Down list on change event*/

                $('#customer_sort').on('change',function(){

                    localStorage.setItem('sortLead',$('#customer_sort').val());
                    location.reload();
                });

                /*
                * Searching in Data Table on key up event*/

                $('#search').on('keyup',function(){
                    localStorage.setItem('searchLead',$('#search').val());
                    var table = $('#datatable').DataTable();
                    table.search(this.value).draw();
                });
                if($('#search').val()!="")
                {
                    var value = $('#search').val();
                    var table = $('#datatable').DataTable();
                    table.search(value).draw();
                }
                $.validator.addMethod("customemail",
                    function(value, element) {
                        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
                    },
                    "Please enter a valid email id. "
                );
            });


        });


        //function to close comment error
        function post(){
            $('#new_comment-error').hide();
        }
        //Onclick function for view lead popup
        function view_lead(lead_id)
        {
            $('#lead_id').val(lead_id);
            var current_path=$('#current_path').val();
            $('#leadIdCompleted').val(lead_id);
            $('#preLoader').show();
            $.ajax({
                method: "POST",
                url: "{{url('dispatch/view-single-lead')}}",
                data:{lead_id : lead_id, current_path : current_path,_token : '{{csrf_token()}}'},
                success: function (result) {
                    $('#preLoader').hide();
                    loadPreviousComments();
                    $('#append_page').html(result.documentSection);
                    $('#view_lead .cd-popup').toggleClass('is-visible');
                }
            });

        }

        $(document).ready(function() {

            $('.auto_modal').click(function(){
                var customer_id = $(this).attr('dir');
                $('.customer_id').val(customer_id);
            });
            setTimeout(function() {
                $('#success_dispatch').fadeOut('fast');
            }, 5000);

        });

        //for showing delete popup
        function delete_pop(obj){
            var value=$(obj).attr('dir');
            $('#leads_id').val(value);
            $("#delete_popup .cd-popup").toggleClass('is-visible');
        }
        //function for delete a lead
        $('#delete_user').on('click', function() {
            $('#preLoader').show();
            var lead = $('#leads_id').val();
            $.ajax({
                url: '{{url('dispatch/delete-lead')}}/'+lead,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('dispatch/all-leads')}}';
                    }
                }
            });

        });
    </script>

    <style>
        .input_fields_wrap .row .form_label{
            display: none;
        }
        .input_fields_wrap .row:first-child .form_label{
            display: block !important;
        }
        .textcss {
            border-bottom-color:lightgray !important;
        }
    </style>

@endpush