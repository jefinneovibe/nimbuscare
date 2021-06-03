{{-- @extends('layouts.customer') --}}
@extends('layouts.dispatch_layout')
@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_dispatch" style="display:none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    {{-- <div id="preLoader">
        <div class="loader">
            <svg>
                <defs><filter id="goo"><feGaussianBlur in="SourceGraphic" stdDeviation="2" result="blur" /><feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" /><feComposite in="SourceGraphic" in2="gooey" operator="atop"/></filter></defs>
            </svg>
        </div>
    </div> --}}
    <div class="alert alert-success alert-dismissible" role="alert" id="mail_success" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Report send to <span id="mail_send_id"></span>
    </div>
    <div class="data_table" style="display: none">
        <div class="tabbed clearfix">
            <ul>
                <li class="blue-bg"><a href="{{ url('dispatch/dispatch-list') }}">Leads</a></li>
                <li class="grey-bg active"><a href="{{ url('dispatch/receptionist-list') }}">Reception</a></li>
                <li class="red-bg"><a href="{{ url('dispatch/schedule-delivery') }}">Schedule for delivery/Collection</a></li>
                <li class="grey-bg"><a href="{{ url('dispatch/delivery') }}">Delivery/Collection</a></li>
                <li class="blue-bg"><a href="{{ url('dispatch/complete-list') }}">Completed</a></li>
            </ul>
        </div>
        <div id="admin">
            <div class="material-table table-responsive">
                <div class="table-header">
                    <span class="table-title">Reception</span>
                    <div class="actions">
                        <div class="sort">
                            <label>Sort :</label>
                            <div class="custom_select">
                                <select class="form_input" id="customer_sort" name="customer_sort">
                                    <option value="">Select</option>
                                    <option value="Customer Name">Customer Name</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Case Manager">Case Manager</option>
                                    <option value="Dispatch Type">Dispatch Type</option>
                                    <option value="Delivery Mode">Delivery Mode</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter_icon" style="display: none">
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

                        <div class="dropdown">
                            <button class="dropdown-toggle btn export_btn search-toggle waves-effect" data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <form method="post" action="/export-receptionist">
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  href="#" class="dropdown-item" onclick="view_email_popup()" id="btn-exel">Generate Report</a>

{{--                                    <a target="_blank" href="{{url('dispatch/export-receptionist')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <table id="datatable">
                    <thead>
                    <tr>
                        <th class="disabled_sort">Reference Number</th>
                        <th class="disabled_sort">Customer Name</th>
                        <th class="disabled_sort">Contact No</th>
                        <th class="disabled_sort">Recipient Name</th>
                        <th class="disabled_sort">Customer Code</th>
                        <th class="disabled_sort">Creation Date</th>
                        <th class="disabled_sort">Agent</th>
                        <th class="disabled_sort">Case Manager</th>
                        <th class="disabled_sort">Dispatch Type</th>
                        <th class="disabled_sort">Delivery Mode</th>
                        <th class="disabled_sort">Assigned To</th>
                        <th class="disabled_sort">Status</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{@$current_path}}" id="current_path">
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode([],TRUE)}}">
    <input type="hidden" id="hide_checkAll">
    <input type="hidden" id="taskTypeHidden">



    {{--view_lead_popup --}}
    <div id="view_lead_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>Dispatch / Collections Slip (Reception)</h1>
                    <hr>
                    <div class="clearfix"></div>
                    <form method="post" name="dispatch_slip_form" id="dispatch_slip_form">
                        {{csrf_field()}}
                        <input type="hidden" id="lead_id" name="lead_id">
                        <input type="hidden" id="save_method" name="save_method">
                        <input type="hidden" id="uniqIdArray" name="uniqIdArray">

                        <div class="content_spacing">

                            <div class="row">
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Customer Name </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input" readonly id="customerName" name="customerName"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Reference Number </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input" readonly id="ref_number" name="ref_number"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Customer ID </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text"class="form_input" readonly id="customerCode" name="customerCode"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Recipient Name </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"   id="recipientName" name="recipientName"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Task Type </label></td>
                                            <td>:</td>
                                            <td style="dispaly:none" id="select_task">
                                                <div class="">
                                                    <select class="selectpicker" name="taskType" id="taskType">
                                                        <option selected value="" data-display-text="">Select Task Type</option>
                                                        @if(!empty($dispatch_types))
                                                            @forelse($dispatch_types as $type)
                                                                <option value="{{$type->_id}}">{{@$type->type}}</option>
                                                            @empty
                                                                No types found.
                                                            @endforelse
                                                        @endif
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="display: none" id="text_task">
                                                <input id = "box_task" type="text" class="form_input" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Contact Number </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"  id="contactNum" name="contactNum"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Case Manager </label></td>
                                            <td>:</td>
                                            <td><input type="text"class="form_input" readonly id="caseManagerSave" name="caseManager"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Agent Name </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input" readonly id="agentName" name="agentName"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Email ID </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"  readonly id="emailId" name="emailId"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Delivery Mode </label></td>
                                            <td>:</td>
                                            <td style="display: none" id="select_mode">
                                                <div class="">
                                                    <select class="selectpicker" name="deliveryMode" id="deliveryMode">
                                                        <option selected value="" data-display-text="">Select Delivery Mode</option>
                                                        @if(!empty($delivery_mode))
                                                            @forelse($delivery_mode as $delivery)
                                                                <option value="{{$delivery->_id}}">{{@$delivery->deliveryMode}}</option>
                                                            @empty
                                                                No types found.
                                                            @endforelse
                                                        @endif
                                                    </select>
                                                </div>
                                            </td>
                                            <td style="display: none" id="text_mode">
                                                <input id="box_mode" class="form_input" readonly type="text">
                                            </td>
                                        </tr>
                                        <tr id="tr_way_bill" style="display:none">
                                            <td class="name"><label class="form_label">WayBill Number</label></td>
                                            <td>:</td>
                                            <td><input type="number" name="way_bill" id="way_bill" class="form_input"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Assigned To</label></td>
                                            <td>:</td>
                                            <td id="emp_txt" style="display:none">
                                                <input type="text" class="form_input" id="employee" name="employee" readonly>
                                            </td>
                                            <td id="emp_select" style="display: none;">
                                                <div class="custom_select assignDiv">
                                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="employee_list" id="employee_list" onchange="validate(this.id);">
                                                        <option selected value="" name="assign">Select</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="transfer_tr" style="display:none">
                                            <td class="name"><label class="form_label">Transfer To</label></td>
                                            <td>:</td>
                                            <td>
                                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="transfer_emp1" id="transfer_emp1" onchange="validate(this.id)">
                                                </select>
                                                <label class="error" id="transfer_emp1-error" style="display:none">Please select an employee.</label>
                                            </td>
                                        </tr>
                                        <tr id="view_transfer" style="display:none">
                                            <td class="name"><label class="form_label">Transfer To</label></td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form_input" readonly id="transfer_txt">
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div style="height: 30px;"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Address  <span>*</span></label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input"   id="address" name="address"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Land Mark <span>*</span></label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"   id="land_mark" name="land_mark"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Preferred Del / Coll Date & Time <span>*</span> </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input datetimepicker" id="date_time"   name="date_time"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6"></div>
                            </div>



                            <div class="card_separation" style="margin: 20px -20px 0;padding: 20px 20px 0;border-left: none;border-right: none;">

                                <table class="lead_block input_fields_wrap" id="document_div" width="100%">
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="form_group">
                                                    <label class="form_label">Select Type <span>*</span></label>
                                                    <div class="">
                                                        <select class="selectpicker" name="docName[]" id="docName" onchange="showAmount(this)">
                                                            <option selected value="" data-display-text="">Select Document Type</option>
                                                            @if(!empty($document_types))
                                                                @forelse($document_types as $type)
                                                                    <option value="{{$type->docNum}}">{{$type->documentType}}</option>
                                                                @empty
                                                                    No customer types found.
                                                                @endforelse
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="form_group">
                                                    <label class="form_label">Document Description <span>*</span></label>
                                                    <input class="form_input" name="docDesc[]" id="docDesc" placeholder="Document Description">
                                                </div>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="div">
                                                <div class="form_group">
                                                    <div class="table_div">
                                                        <div class="table_cell">
                                                            <label class="form_label">Select Type <span>*</span></label>
                                                            <div class="">
                                                                <select class="selectpicker" name="type[]" id="type" onchange="dropValidation(this)">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div >
                                                <div class="form_group">
                                                    <label class="form_label" id="amountlabel"  >Amount / No Of Cards<span>*</span></label>
                                                    <input class="form_input" name="doc_amount[]"  style="display:none" id="doc_amount" type="number" placeholder="Amount">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="collected_amount_div">
                                            <div >
                                                <div class="form_group">
                                                    <label class="form_label"  >Collected Amount<span>*</span></label>
                                                    <input class="form_input" name="doc_collected_amount[]"  style="display:none" id="doc_collected_amount" type="number" placeholder="Amount">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table_div">
                                                <div  data-toggle="tooltip" data-placement="bottom" title="Add" id="p" class="addField_btn add_field_button"><i class="fa fa-plus"></i></div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>


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



                            <div class="bottom_view clearfix" style="display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table width="100%" style="margin-bottom: 60px">
                                            <tr>
                                                <td><label class="form_label">Received By </label></td>
                                                <td width="20">:</td>
                                                <td><input type="text" id="receivedBy" name="receivedBy" class="form_input"></td>
                                            </tr>
                                        </table>
                                        <small>(signature with date)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <table width="100%" style="margin-bottom: 60px">
                                            <tr>
                                                <td><label class="form_label">Delivered By </label></td>
                                                <td width="20">:</td>
                                                <td><input type="text" id="deliveredBy" name="deliveredBy" class="form_input"></td>
                                            </tr>
                                        </table>
                                        <small>(signature with date)</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn_cancel" id="btn_cancel_save" type="button" onclick="setsaveDetails(this.id)">Close</button>
                            @if(isset(session('permissions')['reception']))

                                <button class="btn btn-primary btn_action" id="approve_popup_button"  type="button" onclick="showApprovePopup(this.id)">Approve</button>
                                {{--<button class="btn btn-primary btn_action" id="reject_popup_button"  type="button" onclick="showApprovePopup(this.id)">Reject</button>--}}
                                <button class="btn btn-primary btn_action" id="transfer_popup_button"  style="display: none;" type="button" onclick="showApprovePopup(this.id)">Transfer</button>
                                {{--<button class="btn btn-primary btn_action" id="transfer_to"  style="display: none;" type="button" onclick="transfer()">Transfer</button>--}}


                                <button class="btn btn-primary btn_action" id="approve_button"  type="button" {{--onclick="setsaveDetails(this.id)"--}}>Approve</button>
                                {{--<button class="btn btn-primary btn_action" id="reject_button"  type="button" onclick="setsaveDetails(this.id)">Reject</button>--}}
                                <button class="btn btn-primary btn_action" id="reject_button"  type="button" >Reject</button>
                                <button class="btn blue_btn btn_action" id="print_button" type="button" onclick="setsaveDetails(this.id)">Print</button>
                                <button class="btn btn-primary btn_action" id="print_without_button" type="button" onclick="setsaveDetails(this.id)">Print Without Comment</button>
                                <button class="btn btn-primary btn_action" id="popup_collected_button" type="button" onclick="showApprovePopup(this.id)">Mark As Completed</button>
                                <button class="btn btn-primary btn_action" id="delivered_button"  style="display: none;" type="button" onclick="setsaveDetails(this.id)">Mark As Completed</button>
                                <button class="btn btn-primary btn_action" id="collected_and_delivered_button"  style="display: none;" type="button" onclick="setsaveDetails(this.id)">Mark As Completed</button>
                                <button class="btn btn-primary btn_action" id="direct_delivered_button"  style="display: none;" type="button" onclick="setsaveDetails(this.id)">Delivered</button>
                                <button class="btn btn-primary btn_action" id="direct_collected_button"  style="display: none;" type="button" onclick="setsaveDetails(this.id)">Collected</button>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div id = "testmodal">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h3>Do you want to reject?</h3>
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form_input" id="txt_comment" name="message" required placeholder="Type Your Comment..."></textarea>
                                <span class="error" style="display: none" id="iderror">Please enter a comment.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    {{--<button class="btn btn-primary btn-link btn_action btn_cancel">Cancel</button>--}}
                    {{--<button class="btn btn-primary btn_action" type="button" id="send_btn" onclick="setsaveDetails(this.id)">Reject</button>--}}
                    <button type="button" class="btn btn-secondary" id="btn_cancel_save1" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary btn_action" id="reject_button"  type="button" onclick="setsaveDetails(this.id)">Reject</button>
                </div>
            </div>
        </div>
    </div>
    {{--<div id="view_reject_popup" class="md_popup">--}}
        {{--<div class="cd-popup">--}}
            {{--<form id="form_operations" name="form_operations">--}}
                {{--<input type="hidden" id="leadRejectId" name="leadRejectId">--}}
                {{--<div class="cd-popup-container">--}}
                    {{--<div class="modal_content">--}}
                        {{--<div class="clearfix"></div>--}}
                        {{--<div class="content_spacing">--}}
                            {{--<table class="lead_block input_fields_wrap" id="document_reject_div" width="100%"></table>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<label class="form_label">Comments<span>*</span></label>--}}
                            {{--<textarea  name="message" id="message" onchange="validate(this.id)">--}}
                        {{--</textarea>--}}
                            {{--<label class="error" id="message-error" style="display:none">Please enter your comments.</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="modal_footer">--}}
                        {{--<button type="button" class="btn btn-secondary" id="btn_operation"  onclick="closePopup(this.id)" data-dismiss="modal">Close</button>--}}
                        {{--<button class="btn btn-primary btn_action" id="reject_button"  type="button" onclick="saveOperation(this.id)">Reject</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</div>--}}
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
    {{--Comment popup--}}
    <div id="comment_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    {{--<h3>Do you want to reject?</h3>--}}
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form_input" id="action_comment" name="message" placeholder="Type Your Comment..."></textarea>
                                <span class="error" style="display: none" id="comment_error">Please enter a comment.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-secondary" id="comment_button_close" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary btn_action" id="comment_button"  type="button" onclick="setsaveDetails(this.id)">OK</button>
                </div>
            </div>
        </div>
    </div>
    {{--End Comment popup--}}
    <input type="hidden" id="leadId" name="leadId" value="{{session('leadId')}}">
    <a href="#" style="display: none;" id="trigger_view_lead_popup" class="auto_modal" data-modal="view_lead_popup" ></a>
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

    <script>
//        $('#direct_collected_button').on('click',function () {
//            var valid = $("#dispatch_slip_form").valid();
//
//            if(valid == true)
//            {
//                $('#comment_button').attr('id', $(this).attr("id"));
//                $('#txt_comment').attr('required',true);
//                $('#comment_popup .cd-popup').toggleClass('is-visible');
//            }
//            else{
//                $("#dispatch_slip_form").submit();
//                $('#txt_comment').attr('required',false);
//                $('#comment_popup .cd-popup').removeClass('is-visible');
//            }
////            location.reload();
//        });
        $('#comment_button_close').on('click',function () {
            $('#action_comment').val('');
            $("#comment_popup .cd-popup").removeClass('is-visible');
        });
        function view_email_popup()
        {
            $("#view_email_popup .cd-popup").toggleClass('is-visible');
        }
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
        function send_excel()
        {
            var valid=  $("#send_excel_form").valid();
            if (valid == true) {

                var email= $('#send_email_id').val();
                var form_data = new FormData($("#send_excel_form")[0]);
                form_data.append('email',email);
                form_data.append('_token', '{{csrf_token()}}');
//                $('#preLoader').show();
                $("#view_email_popup .cd-popup").removeClass('is-visible');
                $("#send_lead_excel").attr( "disabled", "disabled" );
                $('#mail_send_id').html(email);
                $('#mail_success').show();
                setTimeout(function() {
                    $('#mail_success').fadeOut('fast');
                }, 5000);
                $("#send_lead_excel").attr( "disabled", false );
                $('#send_email_id').val('');
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/export-receptionist')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result=='success') {
                            console.log("");
                        }
                    }
                });

            }
        }
        function closePopup()
        {
            $("#view_operation_popup .cd-popup").removeClass('is-visible');
            $("#view_transfer_popup .cd-popup").removeClass('is-visible');
            $("#view_completed_popup .cd-popup").removeClass('is-visible');

        }
        function saveOperation(id)
        {
            var address=$('#address').val();
            var date_time=$('#date_time').val();
            var valid=  $("#form_operations").valid();
            if (valid == true) {
//                if (id == "reject_button") {
//                    if ($('#txt_comment').val() == "") {
//                        $('#iderror').show();
//                        return false;
//                    }
//                }
                var leadReject=$('#leadRejectId').val();
                var message=$('#message').val();
                $('#save_method').val(id);

                if(id=='reject_button')
                {
                    if(message==''){
                        $('#message-error').show();
                        return false;
                    }
                    else{
                        return true;
                    }
                }

                var form_data = new FormData($("#form_operations")[0]);
                form_data.append('leadReject',leadReject);
                form_data.append('save_method','approve_button1');
                form_data.append('message',message);
                form_data.append('address',address);
                form_data.append('date_time',date_time);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#approve_button1").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/save-operations')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='approved') {
                            window.location.href = '{{url('dispatch/schedule-delivery')}}';
                        }
                        else  if (result.status=='rejected') {
                            window.location.href = '{{url('dispatch/dispatch-list')}}';
                        } else  if (result.status=='go_reception') {
                            location.reload();
                        }
                        else if(result.success=='pdf')
                        {
                            window.open(result.pdf,'_blank');
                            $('#preLoader').hide();
                        }
                    }
                });

            }
        }
        function saveCompletedOperation(id)
        {
            var valid=  $("#form_completed").valid();
            if (valid == true) {
//                if (id == "reject_button") {
//                    if ($('#txt_comment').val() == "") {
//                        $('#iderror').show();
//                        return false;
//                    }
//                }
                $('#save_method').val(id);
                var form_data = new FormData($("#form_completed")[0]);
                form_data.append('save_method','collected_button');
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#collected_button").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/save-operations')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='go_completed') {
                            window.location.href = '{{url('dispatch/complete-list')}}';
                        }
                    }
                });

            }
        }
        function showApprovePopup(id) {
            var valid=  $("#dispatch_slip_form").valid();
            if(id=='approve_popup_button' && valid==true)
            {
                $('#save_method').val(id);
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-approved-item')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='success') {
                            $('#preLoader').hide();
                            $('#document_operation_div').html(result.documentOperationSection);
                            $("#view_operation_popup .cd-popup").toggleClass('is-visible');
                        }
                    }
                });
            }
            else if(id=='reject_popup_button' && valid==true)
            {
                $('#save_method').val(id);
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-approved-item')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='success') {
                            $('#preLoader').hide();
                            $('#document_reject_div').html(result.documentOperationSection);
                            $("#view_reject_popup .cd-popup").toggleClass('is-visible');
                        }
                    }
                });
            }
            else if(id=='transfer_popup_button' && valid==true)
            {
                $('#save_method').val(id);
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-transfer-item')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='success') {
                            $('#preLoader').hide();
                            $('#document_transfer_operation').html(result.documentOperationSection);
                            $("#view_transfer_popup .cd-popup").toggleClass('is-visible');
                            $('#transfer_emp').selectpicker('destroy');
                            $('#transfer_emp').html(result.transfer);
                            $('#transfer_emp').selectpicker('setStyle');

                            {{--window.location.href = '{{url('dispatch/receptionist-list')}}';--}}
                        }
                    }
                });
            }
            else if(id=='popup_collected_button' && valid==true)
            {
                $('#save_method').val(id);
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-approved-item')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='success') {
                            $('#preLoader').hide();
                            $('#document_completed_operation').html(result.documentOperationSection);
                            $("#view_completed_popup .cd-popup").toggleClass('is-visible');
                        }
                    }
                });
            }
//            else if(id=='print_button')
//            {
//                var newComment=$('#new_comment').val();
//                var commentclass= $('.entete').length;
//                if( commentclass>0 || newComment!='' )
//                {
//                    valid=true;
//                }
//                // else{
//                //     $('#new_comment-error').show();
//                //     valid=false;
//                // }valid
//            }
//            $("select[name='docName[]']").each(function(){
//                var value = $(this).val();
//                var id = $(this).attr("id");
//                var ret = id.split("_");
//                if(value==3 || value==4 || value==5)
//                {
////                    if(ret.length==1)
////                    {
////                        $("#doc_amount").prop('required',true);
////
////                    }
////                    else{
//                    $("#doc_amount_"+ ret[1]).prop('required',true);
//                    if($("#doc_amount_"+ ret[1]).val() == '')
//                    {
//                        valid = false;
//                    }
////                    }
//
//                }
//                else{
//                    if(ret.length==1)
////                    {
////                        $("#doc_amount").removeAttr('required');
////                    }
////                    else{
//                        $("#doc_amount_"+ ret[1]).removeAttr('required');
////                    }
//                    valid=true;
//                }
//            });
//            if(id!='collected_button' || id!='delivered_button'|| id!='collected_and_delivered_button') {
//                if (valid == true) {
//                    if (id == "reject_button") {
//                        if ($('#txt_comment').val() == "") {
//                            $('#iderror').show();
//                            return false;
//                        }
//                    }
//                    $('#save_method').val(id);
//                    $('#dispatch_slip_form').submit();
//                }
//            }


        }
        var checked_array = [];
        /*
        * Filter implementation*/
        $('#btn-filterForm').on('click',function () {

            $('#filterForm').submit();
            //location.reload();
        });

        $('#btn_cancel_save').on('click',function () {
            $("#view_lead_popup .cd-popup").removeClass('is-visible');
            location.reload();
        });

        var filter = $('#filter_data').val();
        var filterData = JSON.parse(filter);

        function listCategory() {

            if($('#dispatchTypes').is(":checked")){
                $("#dispatchTypeList").show();
            }
            else{
                $("input[name='dispathTypeCheck[]']").prop('checked',false);
                $("#dispatchTypeList").hide();
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
        function dispatchModeList()
        {
            if($('#dispatchModes').is(":checked"))
                $('#dispatchModeList').show();
            else{
                $("input[name='deliveryModeFil[]']").prop('checked',false);
                $('#dispatchModeList').hide();
            }
        }

        $('#approve_button').on('click',function () {
            var valid = $("#dispatch_slip_form").valid();
            $("select[name='docName[]']").each(function(){
                var value = $(this).val();
                var id = $(this).attr("id");
                var ret = id.split("_");
                if(value==3 || value==4 || value==5)
                {
                    $("#doc_amount_"+ ret[1]).prop('required',true);
                    if($("#doc_amount_"+ ret[1]).val() == '')
                    {
                        valid = false;
                    }
                }
//                else{
//                    $("#doc_amount_"+ ret[1]).removeAttr('required');
//                    valid=true;
//                }
            });
            if(valid == true)
            {
                $('#comment_button').attr('id', $(this).attr("id"));
                $('#txt_comment').attr('required',true);
                $('#comment_popup .cd-popup').toggleClass('is-visible');
            }
            else{
                $("#dispatch_slip_form").submit();
                $('#txt_comment').attr('required',false);
                $('#comment_popup .cd-popup').removeClass('is-visible');
            }
//            location.reload();
        });
        function setsaveDetails(id) {
//        || id=='direct_collected_button'
            if(id=='approve_button' ){
                if($('#action_comment').val() == ''){
                    $('#comment_error').show();
                    return false;
                }
            }

            var valid=  $("#dispatch_slip_form").valid();
            if(id=='collected_button' || id=='delivered_button'|| id=='collected_and_delivered_button' || id=='btn_cancel_save')
            {
                $('#save_method').val(id);
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/save-receptionist-reply')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='go_reception') {
                            window.location.href = '{{url('dispatch/receptionist-list')}}';
                        }
                    }
                });
            }
            else if(id=='print_button')
            {
                var newComment=$('#new_comment').val();
                var commentclass= $('.entete').length;
                if( commentclass>0 || newComment!='' )
                {
                    valid=true;
                }
            }
            $("select[name='docName[]']").each(function(){
                var value = $(this).val();
                var id = $(this).attr("id");
                var ret = id.split("_");
                if(value==3 || value==4 || value==5)
                {
//                    if(ret.length==1)
//                    {
//                        $("#doc_amount").prop('required',true);
//
//                    }
//                    else{
                    $("#doc_amount_"+ ret[1]).prop('required',true);
                    if($("#doc_amount_"+ ret[1]).val() == '')
                    {
                        valid = false;
                    }
//                    }

                }
                else{
                    if(ret.length==1)
//                    {
//                        $("#doc_amount").removeAttr('required');
//                    }
//                    else{
                        $("#doc_amount_"+ ret[1]).removeAttr('required');
//                    }
                    valid=true;
                }
            });
            if(id!='collected_button' || id!='delivered_button'|| id!='collected_and_delivered_button') {
                if (valid == true) {
                    if (id == "reject_button") {
                        if ($('#txt_comment').val() == "") {
                            $('#iderror').show();
                            return false;
                        }
                    }
                    $('#save_method').val(id);
                    $('#dispatch_slip_form').submit();
                }
            }


        }
        //        initFormExtendedDatetimepickers1: function() {
        $('.datetimepicker').datetimepicker({
            //  format: 'DD/MM/YYYY / hh:mm',
            format: 'DD/MM/YYYY / hh:mm a',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });
        //        },

        function GetDateTime()
        {
            var param1 = new Date();
            var param2 = param1.getDate() + '/' + (param1.getMonth()+1) + '/' + param1.getFullYear() + ' ' + param1.getHours() + ':' + param1.getMinutes() + ':' + param1.getSeconds();
            document.getElementById('lbltxt').innerHTML = param2;
        }

        //        materialKit.initFormExtendedDatetimepickers1();

        var chatContainer = document.querySelector('#chat');


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
                    if(localStorage.getItem('searchElement_reception')!=null)
                    {
                        search(localStorage.getItem('searchElement_reception'));
                    }
                    if(localStorage.getItem('customerSortField_reception'))
                    {
                        sort(localStorage.getItem('customerSortField_reception'));
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

                /**
                 * clear all button function*/
                $("input[name='dispathTypeCheck[]']").on('change', function () {
                    $('#disp_all').prop('checked',false);
                });
                $("input[name='caseManager[]']").on('change', function () {
                    $('#case_all').prop('checked',false);
                });
                $("input[name='deliveryModeFil[]']").on('change', function () {
                    $('#dispatch_mode_all').prop('checked',false);
                });
                $("input[name='agent[]']").on('change', function () {
                    $('#agent_all').prop('checked',false);
                });
                $("input[name='customer[]']").on('change', function(){
                    $('#cust_all').prop('checked',false);
                });
                $('#disp_all').on('change', function () {
                    if($('#disp_all').is(":checked")) {
                        $("input[name='dispathTypeCheck[]']").prop('checked',true);
                    }
                    else{
                        $("input[name='dispathTypeCheck[]']").prop('checked',false);
                    }
                });

                $('#case_all').on('change', function () {
                    if($('#case_all').is(":checked")) {
                        $("input[name='caseManager[]']").prop('checked',true);
                    }
                    else{
                        $("input[name='caseManager[]']").prop('checked',false);
                    }
                });
                $('#dispatch_mode_all').on('change', function () {
                    if($('#dispatch_mode_all').is(":checked")) {
                        $("input[name='deliveryModeFil[]']").prop('checked',true);
                    }
                    else{
                        $("input[name='deliveryModeFil[]']").prop('checked',false);
                    }
                });
                $('#agent_all').on('change', function () {
                    if($('#agent_all').is(":checked")) {
                        $("input[name='agent[]']").prop('checked',true);
                    }
                    else{
                        $("input[name='agent[]']").prop('checked',false);
                    }
                });
                $('#cust_all').on('change',function(){
                    if($('#cust_all').is(":checked")){
                        $("input[name='customer[]']").prop('checked',true);
                    }
                    else{
                        $("input[name='customer[]']").prop('checked',false);
                    }
                });

                $('#btn-clear').on('click', function () {
                    $("input[name='dispathTypeCheck[]']").prop('checked',false);
                    $("input[name='mainGroup[]']").prop('checked',false);
                    $("input[name='caseManager[]']").prop('checked',false);
                    $("input[name='agent[]']").prop('checked',false);
                    $("input[name='deliveryModeFil[]']").prop('checked',false);
                    $("input[name='customer[]']").prop('checked',false);
                    $('#disp_all').prop('checked',false);
                    $('#main_all').prop('checked',false);
                    $('#case_all').prop('checked',false);
                    $('#dispatch_mode_all').prop('checked',false);
                    $('#agent_all').prop('checked',false);
                    $('#cust_all').prop('checked',false);
                    // $("#categoryList").hide();
                    // $("#mainGroupList").hide();
                    // $("#caseManagerList").hide();
                    // $("#agentList").hide();
                    // $('#statusList').hide();

                });
                /*
                * Make filter fields as checked*/

                var sortField = "";
                var searchField = "";
                var filter = $('#filter_data').val();
                var filterData = JSON.parse(filter);
                if(filterData['workType'])
                    $('#category').prop('checked',true);
                if(filterData['caseManager'])
                    $('#caseManager').prop('checked',true);
                if(filterData['dispatchModeAll'])
                    $('#dispatchModes').prop('checked',true);
                if(filterData['dispatchTypeAll'])
                    $('#dispatchTypes').prop('checked',true);
                if(filterData['agent'])
                    $('#agent').prop('checked',true);



                if(filterData['caseManagerAll']){
                    $('#case_all').prop('checked',true);
                    $("input[name='caseManager[]']").prop('checked',true);
                }
                if(filterData['dispatchModeAll']){
                    $('#dispatch_mode_all').prop('checked',true);
                    $("input[name='deliveryModeFil[]']").prop('checked',true);
                }
                if(filterData['agentAll']){
                    $('#agent_all').prop('checked',true);
                    $("input[name='agent[]']").prop('checked',true);
                }
                if(filterData['customerAll']){
                    $('#cust_all').prop('checked',true);
                    $("input[name='customer[]']").prop('checked',true);
                }
                if(filterData['dispatchTypeAll']){
                    $('#disp_all').prop('checked',true);
                    $("input[name='dispathTypeCheck[]']").prop('checked',true);
                }




                if($('#dispatchTypes').is(":checked"))
                    $("#dispatchTypeList").show();
                else
                    $("#dispatchTypeList").hide();

                if($('#caseManager').is(":checked"))
                    $("#caseManagerList").show();
                else
                    $("#caseManagerList").hide();
                if($('#agent').is(":checked"))
                    $("#agentList").show();
                else
                    $("#agentList").hide();
                if($('#dispatchModes').is(":checked"))
                    $('#dispatchModeList').show();
                else
                    $('#dispatchModeList').hide();
                if(filterData['caseManager'] && filterData['caseManager'].length >0) {
                    jQuery.each(filterData['caseManager'], function (index, value) {
                        document.getElementById(value).checked = true;
                    });
                }
                if(filterData['deliveryModeFil'] && filterData['deliveryModeFil'].length > 0) {
                    jQuery.each(filterData['deliveryModeFil'], function (index, value) {
                        document.getElementById(value).checked = true;
                    });
                }
                if(filterData['agent'] && filterData['agent'].length > 0) {
                    jQuery.each(filterData['agent'], function (index, value) {
                        document.getElementById(value).checked = true;
                    });
                }
                if(filterData['customer'] && filterData['customer'].length > 0) {
                    jQuery.each(filterData['customer'], function (index, value) {
                        document.getElementById('c_'+value).checked = true;
                    });
                }
                if(filterData['dispathTypeCheck'] && filterData['dispathTypeCheck'].length > 0) {
                    jQuery.each(filterData['dispathTypeCheck'], function (index, value) {
                        document.getElementById(value).checked = true;
                    });
                }



                if(localStorage)
                {
                    if(localStorage.getItem('customerSortField_reception'))
                    {
                        sortField = localStorage.getItem('customerSortField_reception');
                        $('.current').html(sortField);
                    }
                    if(localStorage.getItem('customerSearchField_reception'))
                    {
                        searchField = localStorage.getItem('customerSearchField_reception');
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
                        url:'{{\Illuminate\Support\Facades\URL::to('dispatch/receptionist-data')}}',
                        data:{
                            'filterData':filter,
                            'field':sortField,
                            'searchField':""
                        },

                    },
                    "columns": [
//                { "data": "id","searchable": true},
                        { "data": "checkall","searchable": false, "visible" : true,'orderable' : false},
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
                        { "data": "assigned" ,"searchable": true, "visible" : true,'orderable' : false},
                        { "data": "status" ,"searchable": true, "visible" : true,'orderable' : false},
//                        { "data": "action1", 'orderable' : false,"searchable": false }
                    ]
                }) .on('draw.dt', function(){
                    if($('#checkAllBox').is(":checked")) {
                        $("input[name='marked_list[]']").each(function(){
                            var id = $(this).attr("id");
                            if(checked_array.indexOf(id)>=0)
                            {
                                $('#'+id).prop('checked',true);
                            }
                        });
                    }else{
                        var checkVal=$('#hide_checkAll').val();
                        if( checkVal=='checked') {
                            $("input[name='marked_list[]']").each(function(){
                                var id = $(this).attr("id");
                                if(checked_array.indexOf(id)>=0)
                                {
                                    $('#'+id).prop('checked',true);
                                }
                            });
                        }else{
                            $("input[name='marked_list[]']").each(function(){
                                var id = $(this).attr("id");
                                if(checked_array.indexOf(id)>=0)
                                {
                                    $('#'+id).prop('checked',true);
                                }
                            });
//                            $("input[name='marked_list[]']").prop('checked',false);
                        }
                    }
                    $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();
                });
                /*
                 * Sorting the table by the Drop Down list on change event*/

                $('#customer_sort').on('change',function(){

                    localStorage.setItem('customerSortField_reception',$('#customer_sort').val());
                    location.reload();
                });

                /*
                 * Searching in Data Table on key up event*/

                $('#search').on('keyup',function(){
                    localStorage.setItem('customerSearchField_reception',$('#search').val());
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
                {{--$('#btn-exel').on('click',function(){--}}
                {{--$.ajax({--}}

                {{--url:'{{\Illuminate\Support\Facades\URL::to('export-customers')}}',--}}
                {{--method:'get',--}}
                {{--data:{--}}
                {{--'filter_data':filter,--}}
                {{--'sortField':sortField,--}}
                {{--'searchField':searchField--}}
                {{--},--}}
                {{--success:function (data) {--}}
                {{--alert(data);--}}

                {{--}--}}
                {{--})--}}

                {{--});--}}



            });


        });

        //save dispatch form validation//
        $("#dispatch_slip_form").validate({
            ignore: [],
            rules: {
                customerCode: {
                    required: true
                },
                customerName: {
                    required: true
                },
                recipientName: {
                    required:true
                },
                caseManager: {
                    required:true
                },
                taskType: {
                    required:true
                },
                agentName: {
                    required: true
                },
                deliveryMode: {
                    required: true
                },
                address: {
                    required: true
                },
                land_mark: {
                    required: true
                },
                date_time: {
                    required: true
                },
                contactNum: {
                    maxlength:25,
//                    minlength:10,
                    required:true
                },
                emailId: {
                    customemail:true,
                    required:true
                },
                'docName[]': {
                    required: true
                },
                'docDesc[]': {
                    required: true
                },
//                'doc_amount[]': {
//                    required: true
//                },
                'type[]': {
                    required: true
                },
                employee_list: {
                    required: true
                },
                way_bill: {
                    required: function(){
                        return $('#tr_way_bill').is(':visible');
                    }
                }
            },
            messages: {
                customerCode: "Please enter customer code.",
                customerName: "Please enter name.",
                recipientName: "Please enter recipient name.",
                caseManager: "Please enter case manager.",
                agentName: "Please enter the agent.",
                taskType: "Please enter dispatch type.",
                deliveryMode: "Please enter delivery mode.",
                contactNum:"Please enter valid contact number",
                emailId:"Please enter valid email id",
                date_time:"Please enter valid date",
                address:"Please enter address",
                land_mark:"Please enter land mark",
                'docName[]':"Please enter document name",
                'doc_amount[]':"Please enter amount / no of cards",
                'doc_collected_amount[]':"Please enter amount / no of cards",
                'docDesc[]':"Please enter document description",
                'type[]':"Please enter document type.",
                way_bill:"Please enter a waybill number."
            },
            errorPlacement: function (error, element) {
                if(element.attr("name") == "docName[]"
                    || element.attr("name") == "type[]")
                {
                    error.insertAfter(element.parent());
                }
                else{
                    error.insertAfter(element);
                }

            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#dispatch_slip_form")[0]);
                var message=$('#txt_comment').val();
                form_data.append('action_comment', $('#action_comment').val());

                form_data.append('message',message);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/save-reception-form')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.status=='approved') {
                            window.location.href = '{{url('dispatch/schedule-delivery')}}';
                        }
                        else  if (result.status=='rejected') {
                            window.location.href = '{{url('dispatch/dispatch-list')}}';
                        } else  if (result.status=='go_reception') {
                            location.reload();
                        }
                        else if(result.success=='pdf')
                        {
                            $('input:hidden[name=uniqIdArray]').val(result.uniqIdArray);
                            window.open(result.pdf,'_blank');
                            $('#preLoader').hide();
                        }
                    }
                });
            }
        });
        //end//


        //Onclick function for view lead popup
        var docs_count=0;
        var x = 1; //initlal text box count
        function view_lead_popup(lead_id)
        {
            $('#recipientName').removeAttr('readonly', true);
            $('#address').removeAttr('readonly', true);
            $('#land_mark').removeAttr('readonly', true);
            $('#date_time').removeAttr('readonly', true);
            $('#contactNum').removeAttr('readonly', true);
            $('#lead_id').val(lead_id);
            $('#leadId').val(lead_id);
            var current_path=$('#current_path').val();
            $('#preLoader').show();
            $.ajax({
                method: "POST",
                url: "{{url('dispatch/get-reception-details')}}",
                data:{lead_id : lead_id, current_path : current_path,_token : '{{csrf_token()}}'},
                success: function (result) {
                    if (result.success== true) {
                        $('#taskTypeHidden').val(result.leadDetails.dispatchType.dispatchType);
                        $('#ref_number').val(result.leadDetails.referenceNumber);
                        $('#delivered_button').hide();
                        $('#approve_button').hide();
                        $('#approve_popup_button').hide();
                        $('#transfer_popup_button').hide();
                        $('#reject_button').hide();
                        $('#collected_and_delivered_button').hide();
                        $('#direct_delivered_button').hide();
                        $('#direct_collected_button').hide();
                        $('#popup_collected_button').hide();
                        if(result.approve_again_button!=1 &&  result.transfer_button!=1
                            && result.approve_and_reject_button!=1 && result.collected_button!=1&&
                            result.mark_completed_button==1)
                        {
                            $('#address').attr('readonly', true);
                            $('#date_time').attr('readonly', true);
                        }
                        else{
                            $('#address').removeAttr('readonly', true);
                            $('#date_time').removeAttr('readonly', true);
                        }
                        if(result.approve_again_button==1)
                        {
                            $('#approve_popup_button').show();
//                            $('#reject_popup_button').show();
                        }
                        else{
                            $('#approve_popup_button').hide();
//                            $('#reject_popup_button').hide();
                        }

                        if(result.approve_and_reject_button==1 && result.approve_again_button!=1)
                        {
                            $('#approve_button').show();
                            $('#reject_button').show();

                        }
                        else{
                            $('#approve_button').hide();
                            $('#reject_button').hide();
                        }

                        if(result.transfer_button==1)
                        {
                            $('#transfer_popup_button').show();
                        }
                        else{
                            $('#transfer_popup_button').hide();
                        }
                        if(result.mark_completed_button==1)
                        {
                            $('#popup_collected_button').show();
                        }
                        else{
                            $('#popup_collected_button').hide();
                        }
                        if(result.collected_button==1)
                        {
                            $('#direct_collected_button').show();
                        }
                        else{
                            $('#direct_collected_button').hide();
                        }
                        if(result.leadDetails.deliveryMode) {

                            if (result.leadDetails.deliveryMode.deliveryMode==='Courier') {
                                $('#tr_way_bill').show();
                            }
                            if (result.leadDetails.deliveryMode.wayBill) {
                                $('#way_bill').val(result.leadDetails.deliveryMode.wayBill);
                                $('#way_bill').removeAttr('readonly');
                                $('#tr_way_bill').show();
                                $("#way_bill").removeClass("textcss");

                            }
                            else{
                                $("#way_bill").addClass("textcss");
                            }
//                            }
                        }
                        $('#customerName').val(result.leadDetails.customer.name);
                        if(result.leadDetails.saveType=='recipient')
                        {
                            $('#customerCode').val('--');
                        }else{
                            $('#customerCode').val(result.leadDetails.customer.customerCode);
                        }
                        $('#recipientName').val(result.leadDetails.customer.recipientName);
                        $('#caseManagerSave').val(result.leadDetails.caseManager.name);
                        $('#agentName').val(result.ag_name);
                        $('#contactNum').val(result.leadDetails.contactNumber);
                        $('#emailId').val(result.leadDetails.contactEmail);
                        if(result.documentSection!='') //direct delivery or direct collection
                        {
                            $('#address').val(result.leadDetails.dispatchDetails.address); //view details from dispatch object
                            $('#land_mark').val(result.leadDetails.dispatchDetails.land_mark);//view details from dispatch object
                            $('#date_time').val(result.leadDetails.dispatchDetails.date_time);//view details from dispatch object
                            $('#document_div').html(result.documentSection);
                            if(result.leadDetails.dispatchDetails.address==null)
                            {
                                $("#address").addClass("textcss");
                            }
                            else{
                                $("#address").removeClass("textcss");
                            }
                            if(result.leadDetails.dispatchDetails.land_mark==null)
                            {
                                $("#land_mark").addClass("textcss");
                            }
                            else{
                                $("#land_mark").removeClass("textcss");
                            }
                            if(result.leadDetails.dispatchDetails.date_time==null)
                            {
                                $("#date_time").addClass("textcss");
                            }
                            else{
                                $("#date_time").removeClass("textcss");
                            }
                            if($('#document_div').val()==null)
                            {
                                $("#document_div").addClass("textcss");
                            }
                            else{
                                $("#document_div").removeClass("textcss");
                            }
                            var document=result.document;
                            var document_count=document.length;
                            docs_count=document_count;
                            if(docs_count!=0)
                            {
                                x= docs_count+x;
                            }
                        }
                        else{
                            $('#type').selectpicker('destroy');
                            $('#type').html(result.doctype);
                            $('#type').selectpicker('setStyle');
                            $('#address').val(result.address); //address from customer table
                            $('#land_mark').val(result.landmark);//landmark from customer table
                            if(result.leadDetails.dispatchType.dispatchType=='Direct Collections') //dispatch type direct
                            {
                                $('#direct_collected_button').show();
                                $('.collected_amount_div').show();
//                                $('#collected_button').hide();
                                $('#delivered_button').hide();
                                $('#approve_button').hide();
                                $('#reject_button').hide();
                            }
                            else if(result.leadDetails.dispatchType.dispatchType=='Direct Delivery'){//dispatch type direct
                                $('#direct_delivered_button').show();
//                                $('#collected_button').hide();
                                $('#delivered_button').hide();
                                $('#approve_button').hide();
                                $('#reject_button').hide();
                                $('.collected_amount_div').hide();
                            }else{
                                $('.collected_amount_div').hide();
                            }
                            if(result.address==null)
                            {
                                $("#address").addClass("textcss");
                            }
                            else{
                                $("#address").removeClass("textcss");
                            }
                            if(result.landmark==null)
                            {
                                $("#land_mark").addClass("textcss");
                            }
                            else{
                                $("#land_mark").removeClass("textcss");
                            }
                        }
                        loadPreviousComments();
                        $('#preLoader').hide();
                        $("#view_lead_popup .cd-popup").toggleClass('is-visible');
                        $('select.change_sec').selectpicker('refresh');
                        $('select.docType').selectpicker('refresh');
                        if(result.emp_option=='text')
                        {
                            $('#employee').val(result.emp_name);
                            $('#emp_txt').show();
                            $('#emp_select').hide();
                            $('#box_mode').val(result.string_version);
                            $('#box_task').val(result.dis_type);
                            $('#select_mode').hide();
                            $('#text_mode').show();
                            $('#select_task').hide();
                            $('#text_task').show();

                        }
                        else if(result.emp_option=='select')
                        {
                            $('#employee_list').selectpicker('destroy');
                            $('#employee_list').html(result.emp_name);
                            $('#employee_list').selectpicker('setStyle');
                            $('#deliveryMode').selectpicker('destroy');
                            $('#deliveryMode').html(result.string_version);
                            $('#deliveryMode').selectpicker('setStyle');
                            $('#taskType').selectpicker('destroy');
                            $('#taskType').html(result.dis_type);
                            $('#taskType').selectpicker('setStyle');
                            $('#type').selectpicker('destroy');
                            $('#type').html(result.doctype);
                            $('#type').selectpicker('setStyle');
                            $('#emp_txt').hide();
                            $('#emp_select').show();
                            $('#select_mode').show();
                            $('#text_mode').hide();
                            $('#select_task').show();
                            $('#text_task').hide();
                        }
                    }
                    @if(!isset(session('permissions')['reception']))
                        $("#dispatch_slip_form :input").prop("disabled", true);
                        $("#btn_cancel_save").prop("disabled", false);
                    @endif
                    $('#new_comment').prop("disabled", false);
                }
            });
//            $("#doc_amount").keypress(function (e) {
//                //if the letter is not digit then display error and don't type anything
//                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//                    // //display error message
//                    // $("#errmsg").html("Digits Only").show().fadeOut("slow");
//                    return false;
//                }
//            });
        }
        // Passing customer_id to modal for deleting customer

        $(document).ready(function() {
            $('.auto_modal').click(function(){
                var customer_id = $(this).attr('dir');
                $('.customer_id').val(customer_id);
            });
            setTimeout(function() {
                $('#success_dispatch').fadeOut('fast');
            }, 5000);

        });

        // To delete a customer

        $(document).ready(function() {
            $('#delete_customer').on('click', function() {
                $('#preLoader').show();
                var customer = $('#customer_id').val();
                $.ajax({
                    url: '{{url('customers/delete/')}}/'+customer,
                    type: "GET",
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('customers')}}'+"/1/show";
                        }
                    }
                });

            });
        });

        //filter customer listing
        $('#cust_all').on('change',function(){
            if($('#cust_all').is(":checked")){
                $("input[name='customer[]']").prop('checked',true);
            }
            else{
                $("input[name='customer[]']").prop('checked',false);
            }
        });

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
        $('#docName').on('change',function(){
            var docId=this.value;
            if(docId==3 ||docId==4 ||docId==5 )
            {
                $('#doc_amount').show();
                $('#doc_collected_amount').show();
                $('#doc_collected_amount').attr('readonly', false);
                $('#doc_amount').attr('required', true);
//                $('#doc_collected_amount').attr('required', true);
//                $("#amountlabel").css('visibility', 'visible');
                if(docId==5)
                {
                    $("#doc_amount").attr("placeholder", "Amount/No .of cards");
                }
                else{
                    $("#doc_amount").attr("placeholder", "Amount");
                }
            }else{
                $('#doc_amount').hide();
                $('#doc_collected_amount').hide();
                $('#doc_amount').attr('required', false);
                $('#doc_collected_amount').attr('required', false);
//                $("#amountlabel").css('visibility', 'hidden');
            }
        });
        $('#send_email_id').keypress(function(event){
            if(event.keyCode == 13){
                send_excel();
            }
        });
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        $(document).on('click','.add_field_button',function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $('.input_fields_wrap').append('' +
                            '<tr>' +
                    '<td>' +
                    ' <div class="">' +
                    ' <div class="form_group">' +
                    ' <label class="form_label">Select Type <span>*</span></label>'+
                    '<div class="">' +

                    '                                            <select class="change_sec" name="docName[]" id="docName_' + x + '" onchange=showAmount(this)>' +
                    '                                                        <option selected value="" data-display-text="">Select Document Type</option>' +
                    '                                                @if(!empty($document_types))' +
                    '                                                    @forelse($document_types as $type)' +
                    '                                                        <option value="{{$type->docNum}}">{{$type->documentType}}</option>' +
                    '                                                        {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}' +
                    '                                                    @empty' +
                    '                                                        No customer types found.' +
                    '                                                    @endforelse' +
                    '                                                @endif' +
                    '                                            </select>' +
                    '                                        </div>'+
                    '                                        </div>'+
                    '                                        </div>'+
                    '</td>'+
                    '<td>' +
                    '                                    <div class="">' +
                    '                                        <div class="form_group">' +
                    '                                            <input class="form_input" name="docDesc[]" id="docDesc_' + x + '" placeholder="Document Description">' +
                    '                                        </div>' +
                    '                                    </div>' +
                    '</td>'+
                    '<td>' +
                    '                                    <div class="">' +
                    ' <div class="">' +

                    ' <label class="form_label">Select Type <span>*</span></label>'+
                    '<div class="">' +

                    '                                            <select class="selectpicker docType" name="type[]" id="type' + x + '" onchange="validate(this.id)">' +
                    '                                            </select>' +

                    '                                        </div>'+
                    '                                        </div>'+
                    '                                        </div>'+
                    '</td>'+
                    '<td>' +
                    ' <div >' +
                    ' <div class="form_group">' +
                    '                                            <label style="visibility:hidden" id="amountlabel_"  class="form_label">Amount / No Of Cards<span>*</span></label>' +
                    '                                            <input class="form_input" name="doc_amount[]" style="display: none" id="doc_amount_' + x + '" type="number" placeholder="Amount">' +
                    '                                        </div>' +
                    '                                    </div>'+
                    '</td>'+
                    '<td>' +
                    ' <div >' +
                    ' <div class="form_group collected_amount_div">' +
                    '                                            <label style="visibility:hidden" id="amountlabel_"  class="form_label">Amount / No Of Cards<span>*</span></label>' +
                    '                                            <input class="form_input" name="doc_collected_amount[]" style="display: none" id="doc_collected_amount_' + x + '" type="number" placeholder="Amount">' +
                    '                                        </div>' +
                    '                                    </div>'+
                    '</td>'+
                    '<td>' +
                    '<div class="table_div">' +
                    '<div data-toggle="tooltip" data-placement="bottom" title="Remove" class="remove_btn remove_field"><i class="fa fa-minus"></i></div>' +
                    '                                                </div>' +
                    '                                        </div>'+
                    '</td>'+
                    '</tr>'); //add input box

            }
            $('select.change_sec').selectpicker('refresh');
            $('select.docType').selectpicker('refresh');
            var lead_id=$('#lead_id').val();
            var taskType = $('#taskType').val();
            $('#p').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "{{url('dispatch/get-doc-type')}}",
                data:{lead_id : lead_id, taskType:taskType,_token : '{{csrf_token()}}'},
                success: function(data){
                    if(data.success==true)
                    {
                        $('#taskTypeHidden').val(data.dispatchTypeSelected);
                        if(data.dispatchTypeSelected != 'Direct Collections'){
                            $('.collected_amount_div').hide();
                        }
                        $('#type'+x).selectpicker('destroy');
                        $('#type'+x).html(data.doctype);
                        $('#type'+x).selectpicker('setStyle');
                        $('#p').prop('disabled', false);
                    }
                }
            });
        });
        {{--$('#employee_list').selectpicker();--}}
        {{--$(document).on('keyup', '.assignDiv .bs-searchbox input', function (e) {--}}
            {{--var delMode=$('#deliveryMode').val();--}}
            {{--var searchData = $(this).val();--}}
            {{--var agent = '';--}}
            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('dispatch/get-assigned-name')}}",--}}
                {{--data:{delMode : delMode,searchData :searchData,agent :agent , _token : '{{csrf_token()}}'},--}}
                {{--success: function(data){--}}
                    {{--$('#employee_list').html(data.response_assign);--}}
                    {{--$('#employee_list').hide();--}}
                {{--}--}}
            {{--});--}}

            {{--$('#employee_list').selectpicker('refresh');--}}
        {{--});--}}

        $('#taskType').on('change', function(){
            $('#direct_collected_button').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span> ');
            $('#direct_collected_button').attr('disabled', true);
            $('#approve_button').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span> ');
            $('#approve_button').attr('disabled', true);
            $('#reject_button').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span> ');
            $('#reject_button').attr('disabled', true);
            var lead_id=$('#lead_id').val();
            var taskType = $('#taskType').val();
            $.ajax({
                type: "POST",
                url: "{{url('dispatch/get-doc-type')}}",
                data:{lead_id : lead_id,taskType:taskType, _token : '{{csrf_token()}}'},
                success: function(data){
                    if(data.success==true)
                    {
                        $('#taskTypeHidden').val(data.dispatchTypeSelected);
                        $("select[name='type[]']").each(function(){
                            var id = $(this).attr("id");
                            console.log(id);
                            $('#'+id).selectpicker('destroy');
                            $('#'+id).html(data.doctype);
                            $('#'+id).selectpicker('setStyle');
                        });
                        var docName = $('#docName').val();
                        if (docName == 3 || docName == 4 || docName == 5)
                        {
                            if(data.dispatchTypeSelected=='Direct Collections') {
                                $("#doc_collected_amount").removeAttr('readonly');
                                $("#doc_collected_amount").show();
                                $("#doc_collected_amount").attr('required', true);
                                $("#doc_collected_amount").prop('type', 'number');
                            }else {
                                $("#doc_collected_amount").attr('required', false);
                                $("#doc_collected_amount-error").hide();
                                $("#doc_collected_amount").attr('readonly', true);
                           }
                        }
                        else{
                            $("#doc_collected_amount").attr('required', false);
                            $("#doc_collected_amount-error").hide();
                            $("#doc_collected_amount").attr('readonly', true);
                        }
                        $("select[name='docName[]']").each(function(){
                            var id_type = $(this).attr("id");
                            var value_type = $('#'+id_type).val();
                            var ret = id_type.split("_");
                            if (value_type == 3 || value_type == 4 || value_type == 5)
                            {
                                $("#doc_amount_" + ret[1]).show();
                                $("#doc_amount_" + ret[1]).attr('required', true);
                                $("#doc_amount_" + ret[1]).removeAttr('readonly');
                                $("#doc_amount_" + ret[1]).prop('type', 'number');
                                if(data.dispatchTypeSelected=='Direct Collections')
                                {
                                    $("#doc_collected_amount_" + ret[1]).removeAttr('readonly');
                                    $("#doc_collected_amount_" + ret[1]).show();
                                    $("#doc_collected_amount_" + ret[1]).attr('required', true);
                                    $("#doc_collected_amount_" + ret[1]).prop('type', 'number');
                                }
                                else{
                                    $("#doc_collected_amount_" + ret[1]).attr('required', false);
                                    $("#doc_collected_amount_"+ ret[1]+"-error").hide();
                                    $("#doc_collected_amount_" + ret[1]).attr('readonly', true);
                                }
                            }else{
                                $("#doc_amount_" + ret[1]).attr('required', false);
                                $("#doc_collected_amount_" + ret[1]).attr('required', false);
                                $("#doc_collected_amount_"+ ret[1]+"-error").hide();
                                $("#doc_collected_amount_" + ret[1]).attr('readonly', true);

                            }
                        });
                        if(data.dispatchTypeSelected=="Direct Collections")
                        {
                            $('#direct_collected_button').html('COLLECTED');
                            $('#direct_collected_button').removeAttr('disabled');
                            $('#direct_collected_button').show();
                            $('#approve_button').hide();
                            $('#reject_button').hide();
                            $('.collected_amount_div').show();
                            $('.collected_amount_class').attr('required',true);
                            $('#date_time').attr('required',false);
//                            $('.collected_amount_class').attr('readonly',false);

                        }
                        else{
                            $('#date_time').attr('required',true);
                            $('#direct_collected_button').hide();
                            $('#approve_button').html('APPROVE');
                            $('#approve_button').removeAttr('disabled');
                            $('#approve_button').show();
                            $('#reject_button').removeAttr('disabled');
                            $('#reject_button').html('REJECT');
                            $('#reject_button').show();
                            $('.collected_amount_div').hide();
//                            $('.collected_amount_class').removeAttr('required',false);
//                            $('.collected_amount_class').attr('readonly',true);

                        }
                    }
                }
            });
        });

        $('.input_fields_wrap').on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent().parent().parent().remove();x--;
        });


        function showAmount(obj) {
            var field_id = obj.id;
            var ret = field_id.split("_");
            var taskType = $('#taskTypeHidden').val();

            console.log(taskType);
            var docName = $('#docName').val();
            if(obj.id=='docName') {
                if (docName == 3 || docName == 4 || docName == 5) {
                    if (taskType == 'Direct Collections') {
                        $("#doc_collected_amount").removeAttr('readonly');
                        $("#doc_collected_amount").show();
                        $("#doc_collected_amount").attr('required', true);
                        $("#doc_collected_amount").prop('type', 'number');
                    } else {
                        $("#doc_collected_amount").attr('required', false);
                        $("#doc_collected_amount-error").hide();
                        $("#doc_collected_amount").attr('readonly', true);
                    }
                }
                else {
                    $("#doc_collected_amount").attr('required', false);
                    $("#doc_collected_amount-error").hide();
                    $("#doc_collected_amount").attr('readonly', true);
                }
            }else{
                if (obj.value == 3 || obj.value == 4 || obj.value == 5)
                {
                    $("#doc_amount_"+ret[1]).attr('value', '');
                    $("#doc_amount_" + ret[1]).show();
                    $("#doc_amount_" + ret[1]).attr('required', true);
                    $("#doc_amount_" + ret[1]).removeAttr('readonly');
                    $("#doc_amount_" + ret[1]).prop('type', 'number');
                    if(taskType=='Direct Collections')
                    {
                        $('.collected_amount_div').show();
                        $("#doc_collected_amount_" + ret[1]).removeAttr('readonly');
                        $("#doc_collected_amount_" + ret[1]).show();
                        $("#doc_collected_amount_" + ret[1]).attr('required', true);
                        $("#doc_collected_amount_" + ret[1]).prop('type', 'number');


                    }
                    else{
                        $("#doc_collected_amount_" + ret[1]).attr('required', false);
                        $("#doc_collected_amount_"+ ret[1]+"-error").hide();
                        $("#doc_collected_amount_" + ret[1]).attr('readonly', true);
                    }


                    if( obj.value == 5)
                    {
                        $('#table_div').show();
                        $("#doc_amount_"+ret[1]).attr("placeholder", "Amount/No .of cards");
                    }
                    else{
                        $("#doc_amount_"+ret[1]).attr("placeholder", "Amount");
                    }
                }else{
//                $('.collected_amount_div').hide();
                    $("#doc_amount_" + ret[1]).attr('required', false);
                    $("#doc_amount_" + ret[1]).hide();
                    $("#doc_amount_" + ret[1]+"-error").hide();
                    $("#doc_collected_amount_" + ret[1]).attr('required', false);
                    $("#doc_collected_amount_" + ret[1]).attr('readonly', true);
                    $("#doc_collected_amount_" + ret[1]).hide();
                    $("#doc_collected_amount_"+ ret[1]+"-error").hide();

//                $("#amountlabel_" + ret[1]).css('visibility', 'hidden');

                }
            }

//            $("#doc_amount_"+ret[1]).keypress(function (e) {
//                //if the letter is not digit then display error and don't type anything
//                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
//                    //display error message
//                    return false;
//                }
//            });
            $('#docName-error').hide();
            $('#'+obj.id+'-error').hide();

        }


//        function showAmount(obj) {
//            var field_id = obj.id;
//            var ret = field_id.split("_");
//            if (obj.value == 3 || obj.value == 4 || obj.value == 5)
//            {
//                $("#doc_amount_" + ret[1]).show();
//                $("#doc_amount_" + ret[1]).attr('required', true);
//                $("#doc_amount_" + ret[1]).removeAttr('readonly');
//                $("#doc_amount_" + ret[1]).prop('type', 'number');
//                $("#doc_collected_amount_" + ret[1]).removeAttr('readonly');
//                $("#doc_collected_amount_" + ret[1]).show();
//                $("#doc_collected_amount_" + ret[1]).attr('required', true);
////                $("#amountlabel_" + ret[1]).css('visibility', 'visible');
//                if( obj.value == 5)
//                {
//                    $('#table_div').show();
////                    $("#amountlabel_" + ret[1]).html("Amount/No .of cards");
//                    $("#doc_amount_"+ret[1]).attr("placeholder", "Amount/No .of cards");
//                }
//                else{
//                    $("#doc_amount_"+ret[1]).attr("placeholder", "Amount");
//                }
//            }else{
//                $("#doc_amount_" + ret[1]).attr('required', false);
//                $("#doc_amount_" + ret[1]).hide();
//                $("#doc_collected_amount_" + ret[1]).attr('required', false);
//                $("#doc_collected_amount_" + ret[1]).attr('readonly', true);
//                $("#doc_collected_amount_" + ret[1]+"-error").hide();
//                $("#doc_collected_amount_" + ret[1]).hide();
////                $("#amountlabel_" + ret[1]).css('visibility', 'hidden');
//
//            }
//            $('#docName-error').hide();
//            $('#'+obj.id+'-error').hide();
//
//        }
        $('#deliveryMode').on('change', function(){
            var mode = $('#deliveryMode').val();
            if(mode=='5b8f6d9b3607291437b56547')
            {
                $('#tr_way_bill').show();
            }
            else
            {
                $('#tr_way_bill').hide();
                $('#way_bill').val('');
            }
            $.ajax({
                type: "POST",
                url: "{{url('dispatch/get-employees')}}",
                data:{mode : mode, _token : '{{csrf_token()}}'},
                success: function(data){
                    if(data.success==true)
                    {
                        $('#employee_list').selectpicker('destroy');
                        $('#employee_list').html('');
                        $('#employee_list').html(data.response);
                        $('#employee_list').selectpicker('setStyle');
                    }
                }
            });
        });
        //        $('#taskType').on('change', function(){
        //            var type = $('#taskType').val();
        //            if(type == '5b8f6c21ebae6914373922c8')
        //            {
        //                $('#direct_collected_button').show();
        //                $('#approve_button').hide();
        //                $('#reject_button').hide();
        //
        ////                $('#collected_button').hide();
        //                $('#delivered_button').hide();
        //                $('#direct_delivered_button').hide();
        //
        //            }
        //            else if(type == '_test_')
        //            {
        //                $('#direct_collected_button').hide();
        //                $('#approve_button').hide();
        //                $('#reject_button').hide();
        //
        ////                $('#collected_button').hide();
        //                $('#delivered_button').hide();
        //                $('#direct_delivered_button').show();
        //            }
        //            else
        //            {
        //                $('#direct_collected_button').hide();
        //                $('#approve_button').show();
        //                $('#reject_button').show();
        //
        ////                $('#collected_button').hide();
        //                $('#delivered_button').hide();
        //                $('#direct_delivered_button').hide();
        //            }
        //        });
        function transfer()
        {
            docDetid=[];
            $(".transfer_class").each(function(){
                checkedDocArrayVal=$(this).attr('value');
                docDetid.push(checkedDocArrayVal);
            });
            var value = $('#transfer_emp').val();
            if(value==''){
                $('#transfer_emp-error').show();
                $('#transfer_tr').focus();
            }
            else
            {
                $('#preLoader').show();
                var leade_id = $('#lead_id').val();
                $.ajax({
                    type:"post",
                    url: "{{url('dispatch/transfer-to')}}",
                    data:{
                        lead_id:leade_id,
                        docDetid:docDetid,
                        employee:value,
                        _token:"{{csrf_token()}}"
                    },
                    success:function (data) {
                        if(data == 'success')
                        {
                            location.reload();
                        }
                    }
                });
            }
        }
        function validate(id)
        {
            if($('#'+id).val == "")
            {
                $('#'+id+'-error').show();
            }
            else
            {
                $('#'+id+'-error').hide();
            }
        }
    </script>

    <style>
        .input_fields_wrap .row .form_label{
            display: none;
        }
        .input_fields_wrap .row:first-child .form_label{
            display: block !important;
        }
        .modal {
            text-align:center;
            padding: 0 !important;
        }
        .modal-dialog {
            position: relative;
            margin: 0 auto;
            top: 25%;
        }
    </style>
    <script>
        $('#reject_button').on('click',function(){
            var valid=  $("#dispatch_slip_form").valid();
            if(valid==true)
            {
                $('#txt_comment').attr('required',true);
                $('#testmodal .cd-popup').toggleClass('is-visible');
            }
            else{
                $('#txt_comment').attr('required',false);
                $('#testmodal .cd-popup').removeClass('is-visible');
            }
        });
        $('#btn_cancel_save1').on('click',function () {
            $('#txt_comment').removeAttr('required');
            $("#testmodal .cd-popup").removeClass('is-visible');
        });
        $('#txt_comment').on('keyup',function(){
            $('#iderror').hide();
        });
        function post(){
            $('#new_comment-error').hide();
        }
        $( document ).ready(function() {
            $('#datatable').hide();
                    @if(Session::has('leadId'))
            var leadid=$('#leadId').val();
            view_lead_popup(leadid);
			<?php
			session()->forget('leadId');
			?>
            @else
            $('#datatable').show();
            @endif


        });
        function markcheck(obj,current_status) {

            var id = obj.value;
            var id1=obj.id;
            var lead_id = $('#lead_id').val();
            var rett = id1.split("_");
            var newret=rett[1];
//                if(current_status!='2')
//                {
//                    if($('#allready_checked').val()=='1')
//                    {
//                        $("#docSelect_"+rett[1]).prop('disabled',true);
//                    }
//                    $('#allready_checked').val('0');
//
//                }
//                else{
            if(!$("#docSelect_"+rett[1]).is(':checked'))
            {
                var checked='not_checked';
            }
            else{
//                        if(current_status=='2')
//                        {
//                            $('#allready_checked').val('1');
//                        }
                var checked='checked';
            }
//                }
            if (checked=='checked') {
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-status')}}',
                    data: {lead_id: lead_id, id: id, newret: newret, _token: '{{csrf_token()}}'},
                    success: function (data) {
                        if (data.status == 'go_status1') {

//                                $('#transfer_to').show();
//                                $('#transfer_tr').show();
//                                $('#collected_button').hide();
                            $('#delivered_button').hide();
                            $('#recipientName').attr('readonly', true);
                            $('#address').attr('readonly', true);
                            $('#land_mark').attr('readonly', true);
                            $('#date_time').attr('readonly', true);
                            $('#contactNum').attr('readonly', true);
                            $('#approve_button').hide();
//                                $('#approve_button1').hide();
                            $('#reject_button').hide();


                        }
                        if (data.status == 'go_status2') {
//                                $('#transfer_to').hide();
                            $('#transfer_tr').hide();
//                                $('#collected_button').hide();
                            $('#delivered_button').hide();
                            $('#recipientName').attr('readonly', true);
                            $('#address').attr('readonly', true);
                            $('#land_mark').attr('readonly', true);
                            $('#date_time').attr('readonly', true);
                            $('#contactNum').attr('readonly', true);
                            $('#approve_button').hide();
//                                $('#approve_button1').show();
                            $('#reject_button').show();

                        }
                        if (data.status == 'go_status3') {
//                                $('#transfer_to').hide();
                            $('#transfer_tr').hide();
//                                $('#collected_button').hide();
                            $('#delivered_button').show();
                            $('#recipientName').attr('readonly', true);
                            $('#address').attr('readonly', true);
                            $('#land_mark').attr('readonly', true);
                            $('#date_time').attr('readonly', true);
                            $('#contactNum').attr('readonly', true);
                            $('#approve_button').hide();
//                                $('#approve_button1').hide();
                            $('#reject_button').hide();
                        }

                    }
                });

            }else if (checked=='not_checked') {
                $("#docSelect_"+rett[1]).prop('checked',false);
//                    $('#transfer_to').hide();
//                    $('#transfer_tr').hide();
//                    $('#collected_button').hide();
                $('#delivered_button').hide();
                $('#recipientName').attr('readonly', true);
                $('#address').attr('readonly', true);
                $('#land_mark').attr('readonly', true);
                $('#date_time').attr('readonly', true);
                $('#contactNum').attr('readonly', true);
                $('#approve_button').hide();
//                    $('#approve_button1').hide();
                $('#reject_button').hide();

            }

        }
        $('#checkAllBox').on('change', function(){
            if($('#checkAllBox').is(":checked")) {
                checked_array=[];
                var datatable='receptionist';
                $('#hide_checkAll').val('checked');
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/get-select-all')}}',
                    data: {'datatable': datatable, _token: '{{csrf_token()}}'},
                    success: function (result) {
                        if (result!='') {
                            for (var i = 0; i < result.length; i++) {
                                checked_array.push(result[i]);
                            }

                            $("input[name='marked_list[]']").each(function(){
                                var id = $(this).attr("id");
                                if(checked_array.indexOf(id)>=0)
                                {
                                    $('#'+id).prop('checked',true);
                                }
                            });
                        }
                        else{
                            $('#fail_check').show();
                            $('#submit_all').hide();
                            $("input[name='check']").prop('checked',false);
                            setTimeout(function() {
                                $('#fail_check').fadeOut('fast');
                            }, 5000);
                        }
                    }
                });
            }
            else{
                $('#hide_checkAll').val('');
                $("input[name='marked_list[]']").prop('checked',false);
                checked_array=[];
            }
        });
        function markedCheck(id)
        {
            if(!$('#'+id).is(':checked'))
            {
                $('#checkAllBox').prop('checked',false);
                checked_array.splice( $.inArray(id, checked_array), 1 );
            }
            else
            {
                checked_array.push(id);
            }
        }
        $('#create_label').on('click', function(){
            var array_len=checked_array.length;
            if(array_len==0)
            {
                $('#empty_check').show();
                setTimeout(function() {
                    $('#empty_check').fadeOut('fast');
                }, 5000);
                return false;
            }
            else {
                $('#preLoader').show();
                var jsonString = JSON.stringify(checked_array);
                $.ajax({
                    type: "POST",
                    url: "{{url('dispatch/create-label')}}",
                    data:{checked_array : jsonString, _token : '{{csrf_token()}}'},
                    success: function(data){
                        if(data.success==true)
                        {
                            window.open(data.pdf,'_blank');
                            $('#preLoader').hide();
                        }
                    }
                });
            }
        });
        function dropValidation(obj){
            $('#'+obj.id+'-error').hide();
        }

    </script>

    <script>
        $('.cd-popup').on('click', function(event){
            if( $(event.target).is('.cd-popup') ) {
                // event.preventDefault();
                $(this).removeClass('is-visible');
                location.reload();
                // $('body').removeClass('fixed')
            }
        });
    </script>

@endpush
