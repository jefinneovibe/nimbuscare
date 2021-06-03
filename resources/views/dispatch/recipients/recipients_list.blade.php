@extends('layouts.dispatch_layout')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_recipient">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissible" role="alert" id="mail_success" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Report send to <span id="mail_send_id"></span>
    </div>
    <div class="data_table">

        <div id="admin">
            <div class="material-table table-responsive">
                <div class="table-header">
                    <span class="table-title">Recipients</span>
                    <div class="actions">
                   <div class="sort">
                    <label>Sort :</label>
                    <div class="custom_select">
                        <select class="form_input" id="customer_sort" name="customer_sort">
                            <option value="">Select</option>
                            <option value="Customer Name">Customer Name</option>
                            {{-- <option value="Agent">Agent</option> --}}
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
                            <form method="post" action="dispatch/export-recipients">
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  href="#" class="dropdown-item" onclick="view_email_popup()" id="btn-exel">Generate Report</a>

{{--                                    <a target="_blank" href="{{url('dispatch/export-recipients')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <table id="datatable">
                    <thead>
                    <tr>
                        <th class="disabled_sort">Name</th>
                        <th class="disabled_sort">Contact No</th>
                        <th class="disabled_sort">Email</th>
                        {{-- <th class="disabled_sort">Agent</th> --}}
                        <th class="disabled_sort">No of policies</th>
                        <th class="disabled_sort"></th>
                        <th class="disabled_sort"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">

    <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="{{url('dispatch/create-recipients')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Add Recipient" data-container="body">
                    <span><i class="material-icons">add</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->

    <div id="filter_popup">
        <div class="cd-popup">


            <div class="cd-popup-container">

                <form method="get" name="filter_customer" id="filter_customer">
                    <div class="modal_content">
                        <div class="clearfix">
                            <h1>Filter</h1>
                            <button type="button" class="btn btn_reset blue_btn" onclick="clearAll();">Clear All</button>
                        </div>

                        <div class="content_spacing clearfix">
                            <div class="md--half" style="display: none;">
                                <div class="custom_checkbox">
                                    <input checked type="checkbox" name="main_group" value="0" id="main_group" class="inp-cbx" style="display: none" onchange="mainGroupListing();">
                                    <label for="main_group" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                        <span>Main Group</span>
                                    </label>
                                </div>
                                <div class="custom_checkbox">
                                    <input checked type="checkbox" name="main_agent" value="0" id="main_agent" class="inp-cbx" style="display: none" onchange="agentListing();">
                                    <label for="main_agent" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                        <span>Agent</span>
                                    </label>
                                </div>
                                <div class="custom_checkbox">
                                    <input checked type="checkbox" name="agent_level" value="0" id="main_level" class="inp-cbx" style="display: none" onchange="levelListing();">
                                    <label for="main_level" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                        <span>Level</span>
                                    </label>
                                </div>
                            </div>
                            <div class="md--half" style="display: none;" id="mainGroupList">
                                <h5>Main Groups</h5>
                                <div class="pre-scrollable">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" name="mainGroupAll" value="mainGroupAll" id="mainGroupAll" class="inp-cbx" style="display: none" onchange="mainGroupDisable();">
                                        <label for="mainGroupAll" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>All</span>
                                        </label>
                                    </div>
                                    <div class="custom_checkbox">
                                        <input type="checkbox" name="mainGroup[]" value="Nil" id="Nil" class="inp-cbx" style="display: none">
                                        <label for="Nil" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>Nil</span>
                                        </label>
                                    </div>
                                    @if(!empty($mainGroups))
                                        @forelse($mainGroups as $mainGroup)
                                            <div class="custom_checkbox">

                                                @if($mainGroup)
                                                    <input type="checkbox" name="mainGroup[]" value="{{$mainGroup->_id}}" id="{{$mainGroup->_id}}" class="inp-cbx" style="display: none">
                                                    <label for="{{$mainGroup->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                        <span>{{ucwords($mainGroup->firstName)}}</span>
                                                    </label>
                                                @endif
                                            </div>
                                        @empty
                                            No main groups found.
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="md--half" style="display: none;" id="agentList">
                                <h5>Agents</h5>
                                <div class="pre-scrollable">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" name="agentAll" value="agentAll" id="agentAll" class="inp-cbx" style="display: none" onclick="agentDisable();">
                                        <label for="agentAll" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>All</span>
                                        </label>
                                    </div>
                                    @if(!empty($agents))
                                        @forelse($agents as $agent)
                                            <div class="custom_checkbox">
                                                <input type="checkbox" name="agent[]" value="{{$agent->_id}}" id="{{$agent->_id}}" class="inp-cbx" style="display: none">
                                                <label for="{{$agent->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                    <span>{{$agent->name}}</span>
                                                </label>
                                            </div>
                                        @empty
                                            No Agents found.
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="md--half" style="display: none;" id="levelList">
                                <h5>Levels</h5>
                                <div class="pre-scrollable">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" name="levelAll" value="levelAll" id="levelAll" class="inp-cbx" style="display: none" onclick="levelDisable();">
                                        <label for="levelAll" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>All</span>
                                        </label>
                                    </div>
                                    @if(!empty($customerLevels))
                                        @forelse($customerLevels as $customerLevel)
                                            <div class="custom_checkbox">
                                                <input type="checkbox" name="level[]" value="{{$customerLevel->_id}}" id="{{$customerLevel->_id}}" class="inp-cbx" style="display: none">
                                                <label for="{{$customerLevel->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                    <span>{{$customerLevel->name}}</span>
                                                </label>
                                            </div>
                                        @empty
                                            No Agents found.
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel" type="button" id="filter_cancel">Cancel</button>
                        <button class="btn btn-primary btn_action" type="submit">Apply Filter</button>
                    </div>
                </form>
            </div>

        </div>
    </div><!--//END Popup -->


    {{--Delete popup--}}
    <div id="delete_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" name="recipient_delete_form" id="recipient_delete_form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to delete recipient ?</h3>
                                            <input name="recipient_id" id="recipient_id" value="" type="hidden">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" id="delete_recipient">Delete</button>
                </div>
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
@endsection


@push('scripts')


    <script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
    <script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

    <script>
        $('#send_email_id').keypress(function(event){
            if(event.keyCode == 13){
                send_excel();
            }
        });
        $.validator.addMethod("customemail",
            function(value, element) {
                return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            },
            "Please enter a valid email id. "
        );
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
        function view_email_popup()
        {
            $("#view_email_popup .cd-popup").toggleClass('is-visible');
        }


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
                $("#send_lead_excel").attr( "disabled", false );
                $('#send_email_id').val('');
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/export-recipients')}}',
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
                    if(localStorage.getItem('receipentsSortField'))
                    {
                        sort(localStorage.getItem('receipentsSortField'));
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
                    $('#success_recipient').fadeOut('fast');
                }, 5000);

                var filter = $('#filter_data').val();
                var filterData = JSON.parse(filter);
                var sortField = "";
                var searchField = "";


                $("input[name='mainGroup[]']").on('change', function () {
                    $("#mainGroupAll").prop('checked',false);
                });
                $("input[name='level[]']").on('change', function () {
                    $("#levelAll").prop('checked',false);
                });
                $("input[name='agent[]']").on('change', function () {
                    $("#agentAll").prop('checked',false);
                });

                /*
                  * Make filter fields as checked*/
                if(filterData['levelAll']){
                    $("input[name='level[]']").prop('checked',true);
                    $('#levelAll').prop('checked',true);
                }

                if(filterData['agentAll']){
                    $("input[name='agent[]']").prop('checked',true);
                    $('#agentAll').prop('checked',true);
                }

                if(filterData['mainGroupAll']){
                    $("input[name='mainGroup[]']").prop('checked',true);
                    $('#mainGroupAll').prop('checked',true);
                }

                if(filterData['mainGroup'])
                    $('#main_group').prop('checked',true);
                if(filterData['level'])
                    $('#main_level').prop('checked',true);
                if(filterData['agent'])
                    $('#main_agent').prop('checked',true);

                if($('#main_group').is(":checked"))
                    $("#mainGroupList").show();
                else
                    $("#mainGroupList").hide();

                if($('#main_agent').is(":checked"))
                    $("#agentList").show();
                else
                    $("#agentList").hide();

                if($('#main_level').is(":checked"))
                    $("#levelList").show();
                else
                    $("#levelList").hide();

                jQuery.each(filterData['mainGroup'],function (index, value) {
                    document.getElementById(value).checked = true;
                });
                jQuery.each(filterData['agent'],function (index, value) {
                    document.getElementById(value).checked = true;
                });
                jQuery.each(filterData['level'],function (index, value) {
                    document.getElementById(value).checked = true;
                });



                if(localStorage)
                {
                    if(localStorage.getItem('receipentsSortField'))
                    {
                        sortField = localStorage.getItem('receipentsSortField');
                        $('.current').html(sortField);
                    }
                    if(localStorage.getItem('receipentsSearchField'))
                    {
                        searchField = localStorage.getItem('receipentsSearchField');
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
                        type:'post',
                        url:'{{\Illuminate\Support\Facades\URL::to('dispatch/recipients-data')}}',
                        data:{
                            'filter_data':filter,
                            'field':sortField,
                            'searchField':"",
                            '_token':"{{csrf_token()}}"
                        },

                    },
                    "columns": [
                        { "data": "fullName","searchable": true, "visible" : true ,'orderable' : false},
                        { "data": "contactNumber","searchable": true, "visible" : true,'orderable' : false},
                        { "data": "email" ,"searchable": true, "visible" : true,'orderable' : false},
                        // { "data": "agent" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "policies" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "action1", 'orderable' : false,"searchable": false },
                        { "data": "action2", 'orderable' : false,"searchable": false }
                    ]
                });
                /*
                 * Sorting the table by the Drop Down list on change event*/

                $('#customer_sort').on('change',function(){

                    localStorage.setItem('receipentsSortField',$('#customer_sort').val());
                    location.reload();
                });

                /*
                 * Searching in Data Table on key up event*/

                $('#search').on('keyup',function(){
                    localStorage.setItem('receipentsSearchField',$('#search').val());
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

        function delete_pop(recipient_id)
        {
            $('#recipient_id').val(recipient_id);
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
            $('#delete_recipient').on('click', function() {
                $('#preLoader').show();
                var recipient_id = $('#recipient_id').val();
                $.ajax({
                    url: '{{url('dispatch/delete-recipient')}}',
                    type: "post",
                    data:{'recipient_id':recipient_id,_token:'{{csrf_token()}}'},
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('dispatch/recipients')}}';
                        }
                    }
                });

            });
        });



        //filter MainGroup listing
        function mainGroupListing()
        {
            if($('#main_group').is(":checked"))
                $("#mainGroupList").show();
            else{
                $("input[name='mainGroup[]']").prop('checked',false);
                $("#mainGroupList").hide();
            }

        }

        //filter Agent listing
        function agentListing()
        {
            if($('#main_agent').is(":checked"))
                $("#agentList").show();
            else{
                $("input[name='agent[]']").prop('checked',false);
                $("#agentList").hide();
            }

        }

        //filter Level listing
        function levelListing()
        {
            if($('#main_level').is(":checked"))
                $("#levelList").show();
            else{
                $("input[name='level[]']").prop('checked',false);
                $("#levelList").hide();
            }


        }


        //onClick function for clear all in filter popup

        function clearAll()
        {
            $("input[name='mainGroup[]']").prop('checked',false);
            $("input[name='agent[]']").prop('checked',false);
            $("input[name='level[]']").prop('checked',false);
            $("input[name='mainGroupAll']").prop('checked',false);
            $("input[name='agentAll']").prop('checked',false);
            $("input[name='levelAll']").prop('checked',false);
            $("input[name='level[]']").prop('disabled',false);
            $("input[name='agent[]']").prop('disabled',false);
            $("input[name='mainGroup[]']").prop('disabled',false);
            // $('#filter_customer').submit();
        }

        function mainGroupDisable(){
            if($('#mainGroupAll').is(":checked")){
                $("input[name='mainGroup[]']").prop('checked',true);
                // $("input[name='mainGroup[]']").prop('disabled',true);
            }else{
                $("input[name='mainGroup[]']").prop('checked',false);
            }
        }


        function agentDisable(){
            if($('#agentAll').is(":checked")){
                $("input[name='agent[]']").prop('checked',true);
                // $("input[name='agent[]']").prop('disabled',true);
            }else{
                $("input[name='agent[]']").prop('checked',false);
            }
        }
        function levelDisable(){
            if($('#levelAll').is(":checked")){
                $("input[name='level[]']").prop('checked',true);
                // $("input[name='level[]']").prop('disabled',true);
            }else{
                $("input[name='level[]']").prop('checked',false);
            }
        }


    </script>
@endpush