@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_dispatch">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="data_table">

        <div id="admin">
            <div class="material-table table-responsive">
                <div class="table-header">
                    <span class="table-title">Users</span>
                    <div class="actions">

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

                        {{--<div class="dropdown">--}}
                            {{--<button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">--}}
                                {{--<i class="material-icons">more_vert</i>--}}
                            {{--</button>--}}
                            {{--<form method="post" action="/export-customers">--}}
                                {{--<div class="dropdown-menu dropdown-menu-right">--}}
                                    {{--<a target="_blank" href="{{url('/export-customers')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}

                    </div>
                </div>
                <table id="datatable">
                    <thead>
                    <tr>
                        <th class="disabled_sort">EMP ID</th>
                        <th class="disabled_sort">Name</th>
                        <th class="disabled_sort">Email</th>
                        <th class="disabled_sort">Role</th>
                        <th class="disabled_sort"></th>
                        <th class="disabled_sort"></th>
                        {{--<th class="disabled_sort"></th>--}}
                        {{--<th class="disabled_sort"></th>--}}
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
            <a href="{{url('user/create-user')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Add User" data-container="body">
                    <span><i class="material-icons">add</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->


    {{--Delete popup--}}
    <div id="delete_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" name="customer_delete" id="customer_delete">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to deactivate user ?</h3>
                                            <input class="" name="user_id" id="user_id" value="" type="hidden">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" id="delete_user">Deactivate</button>
                </div>
            </div>
        </div>
    </div>
    <div id="active_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" name="customer_act" id="customer_act">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Are you sure you want to activate user ?</h3>
                                            <input class="" name="user_idact" id="user_idact" value="" type="hidden">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" id="act_user">Activate</button>
                </div>
            </div>
        </div>
    </div>


    {{--Delete popup--}}
    <div id="update_password_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" name="edit_password_form" id="edit_password_form">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                        <div class="content_spacing">
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="edit_user_id" name="user_id" id="edit_user_id" value="" type="hidden">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <label class="form_label">New Password <span>*</span></label>
                                                <input class="form_input" name="new_password" id="new_password" placeholder="New Password" value="{{@$user->firstName}}" type="password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form_group">
                                                <label class="form_label">Confirm Password <span>*</span></label>
                                                <input class="form_input" name="confirm_password" id="confirm_password" placeholder="Confirm Password" value="{{@$user->lastName}}" type="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel" id="closeUpdate">Cancel</button>
                        <button class="btn btn-primary btn_action" id="update_password_button" type="submit" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')

<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
<script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

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


        //function for filter popover
        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
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
                                        $('#agentAll').prop('checked', true);
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
                $('#success_dispatch').fadeOut('fast');
            }, 5000);
            var sortField = "";
            var searchField = "";
            if(localStorage)
            {
                if(localStorage.getItem('customerSortField'))
                {
                    sortField = localStorage.getItem('customerSortField');
                    $('.current').html(sortField);
                }
                if(localStorage.getItem('userSearchField'))
                {
                    searchField = localStorage.getItem('userSearchField');
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
                    url:'{{\Illuminate\Support\Facades\URL::to('user/get-user')}}',
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

                "columns": [
//                { "data": "id","searchable": true},
                    { "data": "empID","searchable": true, "visible" : true ,'orderable' : false},
                    { "data": "fullName","searchable": true, "visible" : true ,'orderable' : false},
                    { "data": "email" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "role_name" ,"searchable": true, "visible" : true,'orderable' : false},
                    { "data": "edit_button" ,"searchable": false, "visible" : true,'orderable' : false},
                    { "data": "update_password" ,"searchable": false, "visible" : true,'orderable' : false},
                    { "data": "delete_button" ,"searchable": false, "visible" : true,'orderable' : false}

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
                localStorage.setItem('userSearchField',$('#search').val());
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

    function delete_pop(user_id)
    {
        $('#user_id').val(user_id);
        $("#delete_popup .cd-popup").toggleClass('is-visible');
    }

    //Onclick function for activate customer

    function active_pop(user_id)
    {
        $('#user_idact').val(user_id);
        $("#active_popup .cd-popup").toggleClass('is-visible');
    }

    //Onclick function for deleting customer

    function update_password_pop(user_id)
    {
        $('#edit_user_id').val(user_id);
        $("#update_password_popup .cd-popup").toggleClass('is-visible');
    }

    $('#closeUpdate').click(function(){
        $('#new_password').val('');
        $('#confirm_password').val('');
        $("#update_password_popup .cd-popup").removeClass('is-visible');
    });
    // Passing user_id to modal for deleting customer

    $(document).ready(function() {
        $('.auto_modal').click(function(){
            var user_id = $(this).attr('dir');
            $('.user_id').val(user_id);
            $('.edit_user_id').val(user_id);
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
        $('#delete_user').on('click', function() {
            $('#preLoader').show();
            var user = $('#user_id').val();
            $.ajax({
                url: '{{url('user/delete-user')}}/'+user,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('user/view-user')}}';
                    }
                }
            });

        });

        $('#act_user').on('click', function() {
            $('#preLoader').show();
            var user = $('#user_idact').val();
            $.ajax({
                url: '{{url('user/activate-user')}}/'+user,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('user/view-user')}}';
                    }
                }
            });

        });

        //update password form validation//
        $("#edit_password_form").validate({
            ignore: [],
            rules: {
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo : "#new_password"
                }
            },
            messages: {
                new_password:{
                    required: "Please enter password.",
                    minlength: "Password must contain atleast 6 characters."
                },
                confirm_password:{
                    required: "Please enter password.",
                    minlength: "Password must contain atleast 6 characters.",
                    equalTo: "Confirm password must equal to new password."
                }
            },
            errorPlacement: function (error, element)
            {
                if(element.attr("name") == "role"){
                    error.insertAfter(element.parent());
                }else{
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#edit_password_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#update_password_button").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('user/update-user-password')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result.success == true){
                            window.location.href = '{{url('user/view-user')}}';
                        }else{
                            location.reload();
                        }
                    }
                });
            }

        });
        //end//
    });

</script>
<style>
    .delete_icon_btn .activate i.material-icons{
    color: green;
}
    </style>
@endpush