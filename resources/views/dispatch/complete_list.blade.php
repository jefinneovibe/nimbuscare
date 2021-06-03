@extends('layouts.dispatch_layout')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_dispatch">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif

    <div class="alert alert-danger alert-dismissible" role="alert" id="fail_check" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        No complete leads to select
    </div>
    <div class="alert alert-success alert-dismissible" role="alert" id="mail_success" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Report send to <span id="mail_send_id"></span>
    </div>
    <div class="data_table">
        <div class="tabbed clearfix">
            <ul>
                <li class="blue-bg"><a href="{{ url('dispatch/dispatch-list') }}">Leads</a></li>
                <li class="grey-bg"><a href="{{ url('dispatch/receptionist-list') }}">Reception</a></li>
                <li class="red-bg"><a href="{{ url('dispatch/schedule-delivery') }}">Schedule for delivery/Collection</a></li>
                <li class="grey-bg"><a href="{{ url('dispatch/delivery') }}">Delivery/Collection</a></li>
                <li class="red-bg"><a href="{{ url('dispatch/transferred-list') }}">Transferred Documents</a></li>
                <li class="blue-bg active"><a href="{{ url('dispatch/complete-list') }}">Completed</a></li>
            </ul>
        </div>
        <div id="admin" class="filter_main_sec">
            <form id="filterForm" name="filterForm" action="{{URL::to('dispatch/complete-list')}}" method="get">
                <div class="material-table table-responsive">
                    <div class="table-header">
                        <span class="table-title">completed</span>
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
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  href="#" class="dropdown-item" onclick="view_email_popup()" id="btn-exel">Generate Report</a>
{{--                                    <a target="_blank" href="{{url('dispatch/export-completed-list')}}" class="dropdown-item" id="btn-exel">Export As Excel</a>--}}
                                </div>
                            </div>

                        </div>
                    </div>
                    <table id="datatable">
                        <thead>
                        <tr>
                            {{--<th class="disabled_sort">--}}{{--<input type="checkbox" class="check_all" id="checkAllBox">--}}
                            {{--<div class="custom_checkbox">--}}
                            {{--<input type="checkbox" name="check" value="" id="checkAllBox" class="inp-cbx" style="display: none">--}}
                            {{--<label for="checkAllBox" class="cbx">--}}
                            {{--<span>--}}
                            {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                            {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                            {{--</svg>--}}
                            {{--</span>--}}
                            {{--<span>Select All</span>--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</th>--}}
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
                            <th class="disabled_sort @if(!empty(@$Allstatus)) filter_active @endif" style="min-width: 162px;">
                                <span>Status</span>
                                <a class="po__trigger--center button" href="javascript:;" data-layer-id="status_layer"><i class="material-icons">filter_list</i></a>
                            </th>
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
                <div id="status_layer" class="po__layer list">
                    <p>Status</p>
                    <div class="filter_tr">
                        <select style='width: 200px' class='status-data-ajax' id="status-data-ajax" name="status[]" multiple="multiple">
                            @if(!empty(@$Allstatus))
                                @foreach(@$Allstatus as $status)
                                    <option value="{{$status->status}}" selected>{{$status->status}}</option>
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
    <input  type="hidden" id="current_path" name="current_path" value="{{$current_path}}">
    <input  type="hidden" id="filter_data" name="filter_data[]" value="{{json_encode($filter_data,TRUE)}}">
    <!-- Popup -->
    {{--<div id="filter_popup">--}}
        {{--<div class="cd-popup">--}}
            {{--<form id="filterForm" name="filterForm" action="complete-list" method="get">--}}
                {{--<div class="cd-popup-container">--}}
                    {{--<div class="modal_content">--}}
                        {{--<div class="clearfix">--}}
                            {{--<h1>Filter</h1>--}}
                            {{--<button class="btn btn_reset blue_btn" id="btn-clear" type="button">Clear All</button>--}}
                        {{--</div>--}}


                        {{--<div class="content_spacing clearfix">--}}
                            {{--<div class="md--half" style="display: none">--}}
                                {{--<div class="custom_checkbox">--}}
                                    {{--<input type="checkbox" name="dispatchTypes" value="" id="dispatchTypes" class="inp-cbx" style="display: none" onchange="listCategory()" checked>--}}
                                    {{--<label for="dispatchTypes" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Dispatch Type</span>--}}
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
                                    {{--<input type="checkbox" name="dispatchModes" value="" id="dispatchModes" class="inp-cbx" style="display: none" onchange="dispatchModeList()" checked>--}}
                                    {{--<label for="dispatchModes" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                        {{--<span>Delivery Mode</span>--}}
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
                            {{--<div class="md--half" style="display: none" id="dispatchTypeList">--}}
                                {{--<h5>Dispatch Type</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="dispatchTypeAll" value="disp_all" id="disp_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="disp_all" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                            {{--<span>All</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@if(!empty($dispatch_types))--}}
                                        {{--@forelse($dispatch_types as $dispatch)--}}
                                            {{--<div class="custom_checkbox">--}}
                                                {{--<input type="checkbox" name="dispathTypeCheck[]" value="{{$dispatch->_id}}" id="{{$dispatch->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="{{$dispatch->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$dispatch->type}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Type Found.--}}
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
                                    {{--@if(!empty($case_managers))--}}
                                        {{--@forelse($case_managers as $caseManager)--}}
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
                            {{--<div class="md--half" style="display: none" id="dispatchModeList">--}}
                                {{--<h5>Dispatch Mode</h5>--}}
                                {{--<div class="pre-scrollable">--}}
                                    {{--<div class="custom_checkbox">--}}
                                        {{--<input type="checkbox" name="dispatchModeAll" value="dispatch_mode_all" id="dispatch_mode_all" class="inp-cbx" style="display: none">--}}
                                        {{--<label for="dispatch_mode_all" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                            {{--<span>All</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@if(!empty($delivery_mode))--}}
                                        {{--@forelse($delivery_mode as $deliverymode)--}}
                                            {{--<div class="custom_checkbox">--}}
                                                {{--<input type="checkbox" name="deliveryModeFil[]" value="{{$deliverymode->_id}}" id="{{$deliverymode->_id}}" class="inp-cbx" style="display: none">--}}
                                                {{--<label for="{{$deliverymode->_id}}" class="cbx">--}}
                                    {{--<span>--}}
                                        {{--<svg width="10px" height="8px" viewBox="0 0 12 10">--}}
                                          {{--<polyline points="1.5 6 4.5 9 10.5 1"></polyline>--}}
                                        {{--</svg>--}}
                                    {{--</span>--}}
                                                    {{--<span>{{$deliverymode->deliveryMode}}</span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--@empty--}}
                                            {{--No Status Found.--}}
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
                        {{--<button class="btn btn-primary btn_action" type="button" id="btn-filterForm">Apply Filter</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</form>--}}
        {{--</div>--}}
    {{--</div><!--//END Popup -->--}}

    {{--view_lead_popup --}}
    <div id="view_lead_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <h1>Dispatch / Collections Slip (completed)</h1>
                    <hr>
                    <div class="clearfix"></div>
                    <form method="post" name="dispatch_slip_form" id="dispatch_slip_form">
                        {{csrf_field()}}
                        <input type="hidden" id="lead_id" name="lead_id">
                        <input type="hidden" id="save_method" name="save_method">
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
                                            <td><input type="text" class="form_input" readonly  id="recipientName" name="recipientName"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Task Type </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" readonly  id="taskType" name="taskType">

                                                {{--<div class="">--}}
                                                {{--<select class="selectpicker" name="taskType" id="taskType">--}}
                                                {{--<option selected value="" data-display-text="">Select Task Type</option>--}}
                                                {{--@if(!empty($dispatch_types))--}}
                                                {{--@forelse($dispatch_types as $type)--}}
                                                {{--<option value="{{$type->_id}}">{{@$type->type}}</option>--}}
                                                {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}
                                                {{--@empty--}}
                                                {{--No types found.--}}
                                                {{--@endforelse--}}
                                                {{--@endif--}}
                                                {{--</select>--}}
                                                {{--</div>--}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Contact Number </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"  readonly id="contactNum" name="contactNum"></td>
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
                                        {{--<tr>--}}
                                        {{--<td class="name"><label class="form_label">Delivery Mode </label></td>--}}
                                        {{--<td>:</td>--}}
                                        {{--<td><input type="text" class="form_input" id="deliveryMode" name="deliveryMode"></td>--}}
                                        {{--</tr>--}}
                                        <tr>
                                            <td class="name"><label class="form_label">Email ID </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"  readonly id="emailId" name="emailId"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Delivery Mode </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input"  readonly id="deliveryMode" name="deliveryMode">
                                                {{--<div class="">--}}
                                                {{--<select class="selectpicker" name="deliveryMode" id="deliveryMode">--}}
                                                {{--<option selected value="" data-display-text="">Select Delivery Mode</option>--}}
                                                {{--@if(!empty($delivery_mode))--}}
                                                {{--@forelse($delivery_mode as $delivery)--}}
                                                {{--<option value="{{$delivery->_id}}">{{@$delivery->deliveryMode}}</option>--}}
                                                {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}
                                                {{--@empty--}}
                                                {{--No types found.--}}
                                                {{--@endforelse--}}
                                                {{--@endif--}}
                                                {{--</select>--}}
                                                {{--</div>--}}
                                            </td>
                                        </tr>
                                        <tr id="tr_way_bill" style="display:none">
                                            <td class="name"><label class="form_label">WayBill Number</label></td>
                                            <td>:</td>
                                            <td><input type="number" name="way_bill" id="way_bill" class="form_input" readonly></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Assigned To </label></td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form_input" id="employee" name="employee" readonly>
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
                                            <td class="name"><label class="form_label">Address </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input"  readonly id="address" name="address"></td>
                                        </tr>
                                        <tr>
                                            <td class="name"><label class="form_label">Land Mark </label></td>
                                            <td>:</td>
                                            <td><input type="text" class="form_input" readonly  id="land_mark" name="land_mark"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table style="width: 100%">
                                        <tr>
                                            <td class="name"><label class="form_label">Preferred Del / Coll Date & Time: </label></td>
                                            <td width="20">:</td>
                                            <td><input type="text" class="form_input datetimepicker" id="date_time" readonly  name="date_time"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div id="uploadSignDiv"></div>
                                </div>
                            </div>



                            <div class="card_separation" style="margin: 20px -20px 0;padding: 20px 20px 0;border-left: none;border-right: none;">

                                <div class="input_fields_wrap" id="document_div">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <label class="form_label">Select Type <span>*</span></label>
                                                <div class="custom_select">
                                                    <select class="form_input" name="docName[]" id="docName">
                                                        <option value="">Select Document Type</option>
                                                        @if(!empty($document_types))
                                                            @forelse($document_types as $type)
                                                                <option value="{{$type->_id}}">{{$type->documentType}}</option>
                                                                {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}
                                                            @empty
                                                                No customer types found.
                                                            @endforelse
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            {{--<div class="form_group">--}}
                                            {{--<label class="form_label">Document Name <span>*</span></label>--}}
                                            {{--<input class="form_input" name="docName[]" id="docName" placeholder="Document Name"  type="text">--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <label class="form_label">Document Description <span>*</span></label>
                                                <input class="form_input" name="docDesc[]" id="docDesc" placeholder="Document Description">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <div class="table_div">
                                                    <div class="table_cell">
                                                        <label class="form_label">Select Type <span>*</span></label>
                                                        <div class="custom_select">
                                                            <select class="form_input" name="type[]" id="type">
                                                                <option value="">Select Type</option>
                                                                @if(!empty($dispatch_types))
                                                                    @forelse($dispatch_types as $types)
                                                                        <option value="{{$types->_id}}">{{$types->type}}</option>
                                                                        {{--<option {{ ($customerDetails->mainGroup == $customerType->_id? "selected":"") }} value="{{$customerType->_id}}" data-display-text="">{{$customerType->name}}</option>--}}
                                                                    @empty
                                                                        No customer types found.
                                                                    @endforelse
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="table_cell">
                                                        <div class="addField_btn add_field_button"><i class="fa fa-plus"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{----}}
                                            {{--<div class="form_group">--}}
                                            {{--<label class="form_label">Type <span>*</span></label>--}}
                                            {{--<div class="table_div">--}}
                                            {{--<div class="table_cell">--}}
                                            {{--<input class="form_input" name="type[]" id="type" placeholder="Type"  type="text">--}}
                                            {{--</div>--}}
                                            {{--<div class="table_cell">--}}
                                            {{--<div class="addField_btn add_field_button"><i class="fa fa-plus"></i></div>--}}
                                            {{--</div>--}}

                                            {{--</div>--}}

                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="mapdiv"></div>
                            <div class="chat_main">
                                <header>
                                    <h3 class="card_sub_heading">Comments</h3>
                                </header>
                                <ul id="chat">
                                    <div id="load"> <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span></div>
                                </ul>
                            </div>


                            <div class="bottom_view clearfix" id="div_date" style="display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table width="100%" style="margin-bottom: 60px">
                                            <tr>
                                                <td><label class="form_label">Preferred Date</label></td>
                                                <td width="20">:</td>
                                                <td><input type="text" id="preferred_date" name="preferred_date" class="form_input datetimepicker"></td>
                                            </tr>
                                        </table>
                                        <label id="preferred_date-error" style="color: red;display: none">Please select preferred date</label>

                                    </div>
                                </div>
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
                            <button class="btn btn-primary" id="btn_cancel_save" type="button">Close</button>
                            {{--<button class="btn btn-primary btn_action" id="delivered_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Delivered</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="collected_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Collected</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="delivered_and_collected_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Delivered And Collected</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="delivered_not_collected_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Delivered but not collected</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="collected_not_delivered_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Collected but not delivered</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="neither_button" style="display:none;" type="button" onclick="setsaveDetails(this.id)">Neither collected nor delivered</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="same_button"  type="button" onclick="setsaveDetails(this.id)">Reschedule for delivery same day</button>--}}
                            {{--<button class="btn btn-primary btn_action" id="another_button"  type="button" onclick="setsaveDetails(this.id)">Reschedule for delivery another day</button>--}}
                            {{--<button class="btn blue_btn btn_action" id="not_button" type="button" onclick="setsaveDetails(this.id)">Could't contact</button>--}}
                        </div>
                    </form>
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
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{ URL::asset('js/main/custom-select.js')}}"></script>
    <script src="{{ URL::asset('js/main/jquery.dataTables.min.js')}}"></script>
    <!-- Bootstrap Select -->
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

    @include('dispatch.filter_data')

    <script defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOLQOoVSzhAv7zLBHmbXyaXOJlC5q43e0&callback=initMap">
    </script>
    <script>
        function initMap(locations) {
            if (locations) {

                var myOptions = {
                    zoom: 7,
                    center: new google.maps.LatLng(0, 0),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(
                    document.getElementById("map"),
                    myOptions);
                setMarkers(map, locations);

                function setMarkers(map, locations) {
                    var testLat=[];
                    for (var loc = 0; loc < locations.length; loc++) {
                        testLat.push(new google.maps.LatLng(locations[loc][0],locations[loc][1]));
                    }

                    var userCoordinate = new google.maps.Polyline({
                        path: testLat,
                        strokeColor: "#FF0000",
                        strokeOpacity: 1,
                        strokeWeight: 2
                    });
                    function tConvert (time) {
                        // Check correct time format and split into components
                        time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                        if (time.length > 1) { // If time format correct
                            time = time.slice (1);  // Remove full string match value
                            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                            time[0] = +time[0] % 12 || 12; // Adjust hours
                        }
                        return time.join (''); // return adjusted time or original string
                    }
                    var infoWindow = new google.maps.InfoWindow();
                    userCoordinate.setMap(map);
                    var bounds = new google.maps.LatLngBounds();
                    var countval=1;
                    for (var i = 0; i < locations.length; i++) {
                        var beach = locations[i];
                        var myLatLng = new google.maps.LatLng(beach[0], beach[1]);
                        var marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            label:countval+''
                        });
                        //Attach click event to the marker.
                        (function (marker, beach) {
                            google.maps.event.addListener(marker, "click", function (e) {
                                //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                                infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + beach[2] + " <br>" +"Customer Name : " + beach[3]  +" <br>"+ "Delivery Time : " +tConvert(beach[4]) + " <br>"+ "Delivery Date : " +beach[5]  +
                                    "</div>");
                                infoWindow.open(map, marker);
                            });
                        })(marker, beach);
                        bounds.extend(myLatLng);
                        countval++;
                    }
                    map.fitBounds(bounds);
                }
            }
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
                $("#send_lead_excel").attr( "disabled",false );
                $('#send_email_id').val('');
                $.ajax({
                    method: 'post',
                    url: '{{url('dispatch/export-completed-list')}}',
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
        function view_lead_popup(lead_id)
        {
            $('#lead_id').val(lead_id);
            var current_path=$('#current_path').val();
            $('#preLoader').show();
            $.ajax({
                method: "POST",
                url: "{{url('dispatch/get-reception-details')}}",
                data:{lead_id : lead_id,current_path:current_path, _token : '{{csrf_token()}}'},
                success: function (result) {
                    if (result.success== true) {
                        if(result.uploadSign)
                        {
                            $('#uploadSignDiv').html(result.uploadSign);

                        }
                        if(result.mapSection!='')
                        {
                            $('#mapdiv').show();
                            $('#mapdiv').html(result.mapSection);
                            initMap(result.testArray);
                        }
                        else{
                            $('#mapdiv').hide();
                        }
                        $('#ref_number').val(result.leadDetails.referenceNumber);

                        if(result.leadDetails.deliveryMode.wayBill)
                        {
                            $('#way_bill').val(result.leadDetails.deliveryMode.wayBill);
                            $('#tr_way_bill').show();
                        }
                        $('#employee').val(result.emp_name);
                        $('#customerName').val(result.leadDetails.customer.name);
                        if(result.leadDetails.saveType=='recipient')
                        {
                            $('#customerCode').val('--');
                        }else {
                            $('#customerCode').val(result.leadDetails.customer.customerCode);
                        }
                        $('#recipientName').val(result.leadDetails.customer.recipientName);
                        $('#caseManagerSave').val(result.leadDetails.caseManager.name);
                        $('#agentName').val(result.ag_name);
                        $('#contactNum').val(result.leadDetails.contactNumber);
                        $('#emailId').val(result.leadDetails.contactEmail);
                        $('#address').val(result.leadDetails.dispatchDetails.address);
                        $('#land_mark').val(result.leadDetails.dispatchDetails.land_mark);
                        $('#date_time').val(result.leadDetails.dispatchDetails.date_time);
                        $('#taskType').val(result.leadDetails.dispatchType.dispatchType);
                        $('#deliveryMode').val(result.leadDetails.deliveryMode.deliveryMode);
                        $('#document_div').html(result.documentSection);
                        loadPreviousComments();
                        $('#preLoader').hide();
                        $("#view_lead_popup .cd-popup").toggleClass('is-visible');
                    }
                }
            });
        }
        $('#btn_cancel_save').on('click',function () {
            $("#view_lead_popup .cd-popup").removeClass('is-visible');
            location.reload();
        });
        /*
        * Filter implementation*/
        $('#btn-filterForm').on('click',function () {

            $('#filterForm').submit();
            //location.reload();
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
        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');


                /*For retrieve the web page status using local storage*/
                if(localStorage)
                {
                    if(localStorage.getItem('complete_list')!=null)
                    {
                        search(localStorage.getItem('complete_list'));
                    }
                    if(localStorage.getItem('customerSortField_completed'))
                    {
                        sort(localStorage.getItem('customerSortField_completed'));
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
//                if(filterData['caseManager'] && filterData['caseManager'].length >0) {
//                    jQuery.each(filterData['caseManager'], function (index, value) {
//                        document.getElementById(value).checked = true;
//                    });
//                }
//                if(filterData['deliveryModeFil'] && filterData['deliveryModeFil'].length > 0) {
//                    jQuery.each(filterData['deliveryModeFil'], function (index, value) {
//                        document.getElementById(value).checked = true;
//                    });
//                }
//                if(filterData['agent'] && filterData['agent'].length > 0) {
//                    jQuery.each(filterData['agent'], function (index, value) {
//                        document.getElementById(value).checked = true;
//                    });
//                }
//                if(filterData['customer'] && filterData['customer'].length > 0) {
//                    jQuery.each(filterData['customer'], function (index, value) {
//                        document.getElementById('c_'+value).checked = true;
//                    });
//                }
//                if(filterData['dispathTypeCheck'] && filterData['dispathTypeCheck'].length > 0) {
//                    jQuery.each(filterData['dispathTypeCheck'], function (index, value) {
//                        document.getElementById(value).checked = true;
//                    });
//                }



                if(localStorage)
                {
                    if(localStorage.getItem('customerSortField_completed'))
                    {
                        sortField = localStorage.getItem('customerSortField_completed');
                        $('.current').html(sortField);
                    }
                    if(localStorage.getItem('complete_list'))
                    {
                        searchField = localStorage.getItem('complete_list');
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
//                            '<option value="-1">All</option>' +
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
                        url:'{{\Illuminate\Support\Facades\URL::to('dispatch/complete-data')}}',
                        data: function(d){
                            d.field=sortField;
                            d.searchField="";
                            d.filterData=filter;
//                            d.customer = $('#customer-data-ajax').val();
//                            d.agent = $('#agent-data-ajax').val();
//                            d.case_manager = $('#case_manager-data-ajax').val();
//                            d.dispatch_type = $('#dispatch-data-ajax').val();
//                            d.delivery_mode = $('#delivery-data-ajax').val();
//                            d.assigned_to = $('#assigned-data-ajax').val();
                            d._token="{{csrf_token()}}"
                        }

                    },
                    "columns": [
//                { "data": "id","searchable": true},
//                         { "data": "checkall","searchable": true, "visible" : true,'orderable' : false},
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
                // }).on('draw.dt', function(){
                //     $("input[name='marked_list[]']").each(function(){
                //         var id = $(this).attr("id");
                //         console.log(selected_array);
                //         if(selected_array.indexOf(id)>=0)
                //         {
                //             $('#'+id).prop('checked',true);
                //         }
                //     });
                });
                /*
                 * Sorting the table by the Drop Down list on change event*/

                $('#customer_sort').on('change',function(){

                    localStorage.setItem('customerSortField_completed',$('#customer_sort').val());
                    location.reload();
                });

                /*
                 * Searching in Data Table on key up event*/

                $('#search').on('keyup',function(){
                    localStorage.setItem('complete_list',$('#search').val());
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
        $('#send_email_id').keypress(function(event){
            if(event.keyCode == 13){
                send_excel();
            }
        });
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
        $(document).ready(function(){
            setTimeout(function() {
                $('#success_dispatch').fadeOut('fast');
            }, 5000);
        });

    </script>
@endpush