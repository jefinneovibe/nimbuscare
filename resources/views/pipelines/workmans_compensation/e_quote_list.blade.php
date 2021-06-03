@extends('layouts.app')

@section('sidebar')
@parent
@endsection

@section('content')
<div class="data_table">
    <div id="admin">
        <div class="material-table table-responsive">
            <div class="table-header">
                <span class="table-title">e-quote list</span>
                <div class="actions">

                    <div class="sort">
                        <label>Sort :</label>
                        <div class="custom_select">
                            <select class="form_input">
                                <option selected value="" data-display-text="">Select</option>
                                <option>Name</option>
                                <option>Agent</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter_icon">
                        <button class="btn export_btn waves-effect auto_modal" data-toggle="tooltip" data-placement="bottom" title="Filter" data-container="body" data-modal="filter_popup">
                            <i class="material-icons">filter_list</i>
                        </button>
                    </div>
                    <form class="form-inline ml-auto">
                        <div class="form-group page_no">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-white btn-raised btn-fab btn-round">
                            <i class="material-icons">search</i>
                        </button>
                    </form>

                    <div class="dropdown">
                        <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                            <i class="material-icons">more_vert</i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item">Export As Excel</a>
                        </div>
                    </div>

                </div>
            </div>
            <table id="datatable">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Customer Name</th>
                    <th>Case Manager</th>
                    <th>Agent Name</th>
                    <th>E-slip received at</th>
                    <th style="width: 120px" class="disabled_sort"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>
                <tr>
                    <td>Workmans</td>
                    <td>Shijin</td>
                    <td>CaseM1</td>
                    <td>Anish</td>
                    <td>11/01/18</td>
                    <td>
                        <a href="{{ url('e-quote-details') }}" class="btn btn-sm btn-success" style="font-weight: 600">Give Quote</a>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<!-- DataTable -->
<script src="{{URL::asset('js/main/jquery.dataTables.min.js')}}"></script>

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<script>
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
        $('#datatable').dataTable({
            "oLanguage": {
                "sStripClasses": "",
                "sSearch": "",
                "sSearchPlaceholder": "Enter Keywords Here",
                "sInfo": "_START_ -_END_ of _TOTAL_",
                "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                '<option value="10">10</option>' +
                '<option value="20">20</option>' +
                '<option value="30">30</option>' +
                '<option value="40">40</option>' +
                '<option value="50">50</option>' +
                '<option value="-1">All</option>' +
                '</select></div>'
            },
            bAutoWidth: false
        });

    });

</script>

@endpush
