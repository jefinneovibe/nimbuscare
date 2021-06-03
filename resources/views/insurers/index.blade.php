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
            <form id="filterForm" name="filterForm" action="{{URL::to("insurers/show")}}" method="get">
                <div class="material-table table-responsive">
                    <div class="table-header">
                        <span class="table-title">  Insurers</span>
                        <div class="actions">

                            {{-- <div class="sort">
                                <label>Sort :</label>
                                <div class="custom_select">
                                    <select class="form_input" id="customer_sort" name="customer_sort">
                                        <option value="">Select</option>
                                        <option value="Name(A-Z)">Name(A-Z)</option>
                                        <option value="Name(Z-A)">Name(Z-A)</option>
                                        <option value="Email">Email</option>                                 
                                    </select>
                                </div>
                            </div> --}}

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
                                {{--  <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </button>  --}}
                                {{--<form method="pos?t" action="/export-customers">--}}
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  href="#" class="dropdown-item"  id="btn-exel">Generate Report</a>
{{--                                    <a target="_blank" href="{{url('/export-customers')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                </div>
                                {{--</form>--}}
                            </div>

                        </div>
                    </div>
                    <table id="datatable">
                        <thead>
                        <tr>                           
                            <th class="disabled_sort" >Name</th>                            
                            <th class="disabled_sort" >Email</th>
                            <th class="disabled_sort" >Login Created</th>
                            <th class="disabled_sort" ></th>
                            <th class="disabled_sort"></th>                           
                        </tr>
                        </thead>            
                    </table>
                </div>
                
               
            </form>
        </div>
    </div>
    {{--  <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">  --}}
  <!-- Floating Action -->
    <div class="floating_icon">
        <div class="fab edit">
            <a href="{{url('insurers/create')}}">
                <div class="trigger" data-toggle="tooltip" data-placement="left" title="Add Insurer" data-container="body">
                    <span><i class="material-icons">add</i></span>
                </div>
            </a>
        </div>
    </div><!--//END Floating Action -->
  



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
                                            <h3>Are you sure you want to delete Insurer ?</h3>
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
<script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
<script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

<script>
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

        //function submitFilterForm(){
               // $('#filterForm').submit();
        //        $('#datatable').DataTable().ajax.reload();
           // }

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
                   // sFilterInput: "form-control input-sm",
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
            //var filter = $('#filter_data').val();
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
               ajax:{
                  type:'post',
                   url:'{{\Illuminate\Support\Facades\URL::to('insurers/insurers-data')}}',
                   data: function(d){
                        d.field=sortField;
                        d.searchField = "";
                        //d.filterData = filter;                     
                        d._token = "{{csrf_token()}}";
                   }


                },
                "preDrawCallback": function( settings ) {
                    //filterData=filterData;
                },

                "columns": [
//         
                    { "data": "name","searchable": true, "visible" : true ,'orderable' : false},                  
                    { "data": "email" ,"searchable": true, "visible" : true,'orderable' : false}, 
                    { "data": "login_created" ,"searchable": true, "visible" : true,'orderable' : false}, 
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
                                    });
                                }
                            });
                        }

                    }
                }

                //steps for checking check boxes in filter///////////
                
                $('#btn-clear').on('click', function () {
              
                    $("input[name='customer[]']").prop('checked', false);
                    $('#cat_all').prop('checked', false);
                   
                    $('#status_all').prop('checked', false);
                 
                });
            });

        });
        $('#delete_customer').on('click', function() {
            $('#preLoader').show();
            var insurer = $('#customer_id').val();
            console.log(insurer);            
            $.ajax({
                url: '{{url('insurers/delete/')}}/'+insurer,
                type: "GET",
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('insurers')}}'+"/show";
                    }
                }
            });

        });
    });
</script>

@endpush
