@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .filter_popup .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
        .tooltip {
            z-index: 999999999;
        }
        
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
        .bootstrap-select .dropdown-toggle:focus, .bootstrap-select .dropdown-toggle:hover {
            outline: none !important;
            border-color: #D4D9E2 !important;
        }
        a:visited, span.MsoHyperlinkFollowed{
        text-decoration: none !important
        }
        a:link, span.MsoHyperlink {
            text-decoration: none !important 
        }
        .open-email-container{
            max-width: 1435px !important;
        }
        
        .filter_popup{
            max-width: 90% !important;
            width: 100% !important
        }
        .filter_from_select .select2-container--default .select2-selection--single{
            border: 1px solid #e1e2e1 !important;
            border-radius: 0px !important;
            cursor: pointer;
            padding: 0 5px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            min-height: 36px !important;
        }
        .select_dropdown1 .select2-container{
            z-index: 99 !important           
        }
    </style>
    @php
        $role=session('role');
        $searchKey=session('ClosedSearchKey');
        if(!isset($seachKey))
        {
            $seachKey="";

        }
       
    @endphp 
        <input type="hidden" id="total_count" value="{{$countMails}}">
        <input type="hidden" id="after_load" value="">


    <div class="section_details">
        <div class="card_header card_header_flex  clearfix">
            <h3 class="title">Completed Queue</h3>
            <div class="right_section">
                <div class="search_sec">
                    <div class="media">
                         <label id="countMails" class="count_label">Count : <span class="count_num" id="spanCount"> {{$countMails}}</span> </label> 
                        <button class="btn pull-right custom_btn header_btn"  type="button" id="btn_reload" onclick="reloadPage()">
                            <i class="fa fa-refresh" aria-hidden="true"></i>  &nbsp;
                             Refresh
                        </button>
                        <div class="media-body" style="    margin-right: 10px;">
                        <form class="search_form" id="custom_search">
                                <input type="text" placeholder="Search.." id="search_key" name="search2" value="{{($searchKey)? $searchKey : ''}}">
                                {{-- {{csrf_field()}} --}}
                                <button type="submit"><i class="fa fa-search"></i></button>
                                <label id="search_key-error" class="error" for="search_key"></label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="sort">
                    <div class="custom_select">
                        <select class="form_input" id="customSort" name="customSort" onchange="switchMail()">
                            @foreach($mailBoxes as $mailBox)
                                @php
                                    if ($user==$mailBox->userID)
                                    {
                                        $currentMailBox=$mailBox->statusAvailable;
                                        $currentMailBucket=$mailBox;
                                    }
                                    $totalMail=count($data);
                                @endphp
                                <option value="{{$mailBox->_id}}" <?php echo(($user==$mailBox->userID)? "selected" : ""); ?> >{{$mailBox->userID}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter_sec">
                    <a href= "{{url('enquiry/emails-to-excel')}}/{{$currentMailBucket->userID}}/{{'0'}}" download="Document-List">
                        <button class="btn export_btn waves-effect excel_bt" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="Export To Excel">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        </button>
                    </a>
                    <input type="hidden" name="hidden_filter_value" id="hidden_filter_value" value='{{json_encode($currentMailBucket)}}'>
                    <button class="btn export_btn waves-effect" id="filter" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                    onclick="showFilter('{{$totalMail}}', 0, '{{$role}}')" data-original-title="Filter">
                        <i class="material-icons">filter_list</i>
                    </button>
                    <button class="btn export_btn toggle_btn waves-effect round_btn" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="window.location='{{url("enquiry/view-enquiries?index=".$currentMailBucket->_id)}}'" data-original-title="Active queue">
                        <span class="round_doc round_doc_green">a</span>
                    </button>
                </div>
            </div>
        </div> 
    {{-- load spinner --}}
    <div id="load_spinner" style="display:none;text-align:center;position:fixed;top: 49%;left: 46%;z-index:2;">
        <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;color:#9c27b0;"></i>
        <span class="sr-only">Loading...</span>
    </div>
    {{-- load spinner --}}    
    <div class="card_content">
        <div id="post-data">
        </div> 
    </div>
</div>
{{-- section_details ends --}}
    <!-- comment Popup -->
    <div id="comment"> 
        <div class="cd-popup comment_modal">
            <form method="post">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                            <div class="content_spacing">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <span><h1 id="success_message">Comments</h1></span>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chat_main comment_chat_main">
                                            <input type="hidden" id="hdnEmailId"/>
                                            <ul id="chat">
                                            </ul>
                                            <footer class="col-md-12">
                                                <div class="col-md-11">
                                                    <textarea id="new_comment" name="new_comment" placeholder="Type your comment..." ></textarea>
                                                    <span class="error pull-left" id="comment_error"></span>
                                                </div>
                                                <a id="add_comment" title="Send" class="send_btn col-md-1" onclick="submitComment()">
                                                    <i class="material-icons"> send </i>
                                                </a>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <a href="#0" class="cd-popup-close img-replace"></a>
                </div>
            </form>
        </div>
    </div> <!-- comment Popup ends -->

    <!-- open email Popup -->
    <div id="open_email">
        <div class="cd-popup" >
            <form id="showhow" style="" method="post">
                <div class="cd-popup-container open-email-container">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><h1 class="email_subj" id="mail_sub">Document management for iib</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mail_details">
                                            <span class="customer_email" id="mail_from" > </span>
                                            <span class="mail_date" id="mail-time"> </span>
                                        </p>
                                        {{--  <p class="mail_content">Dear All,</p>  --}}
                                        <p id="mail_body"></p>   
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal_footer">
                        {{--  <button class="btn btn-primary btn_action pull-right" type="button">Send</button>  --}}
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Close</button>
                    </div>
                    <a href="#0" class="cd-popup-close img-replace"></a>
                </div>
            </form>
        </div>
    </div> 

    <div id="document_mail_filter">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container filter_popup">
                    <div class="modal_content">
                        <div class="clearfix">
                            <h1 class="pull-left">Filter</h1>
                            <button class="reset" id="reset_button" onclick="resetFilter()" type="button">Reset</button>
                        </div>
                        <div class="content_spacing">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-md-4" id="filter_type_div">
                                    <h4 class="filter_head">Renewal Status</h4>
                                    <div class="filter_scroll">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" value="" id="status_all" class="inp-cbx mem_status_all mem_status_type reset_all" onclick="selectAll('status')" style="display: none">
                                            <label for="status_all" class="cbx">
                                                <span style="min-width: 18px;">
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>Select All</span>
                                            </label>
                                        </div>
                                        <div id="status_filter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="filter_head">New Status</h4>
                                    <div class="filter_scroll">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" value="" id="non_status_all" class="inp-cbx mem_status_all mem_status_type reset_all" onclick="selectAll('nonStatus')" style="display: none">
                                            <label for="non_status_all" class="cbx">
                                                <span style="min-width: 18px;">
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>Select All</span>
                                            </label>
                                        </div>
                                        <div id="non_status_filter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px !important;">From Date</h4>
                                            <input id="filterFromDate" class="note_textbox form_input date_font datetimepicker" name="filterFromDate" placeholder="From Date" type="text">
                                        </div>
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px !important;">To Date</h4>
                                            <input id="filterToDate" class="note_textbox form_input date_font datetimepicker" name="filterToDate" placeholder="To Date" type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="filter_head">Status</h4>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-2">
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="" id="nonrenewalCheck" class="inp-cbx platform_all platforms"  onclick="checkRenewal(this.id)" style="display: none">
                                                <label for="nonrenewalCheck" class="cbx">
                                                    <span style="min-width: 18px;">
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>New</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="" id="renewalCheck" class="inp-cbx platform_all platforms" onclick="checkRenewal(this.id)" style="display: none">
                                                <label for="renewalCheck" class="cbx">
                                                    <span style="min-width: 18px;">
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Renewal</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 30px;">
                                            <h4 class="filter_head">Insurer</h4>
                                            <div class="cus_select2 select_dropdown1">
                                                <select class="insurer-data-ajax" id="insurer_list" name="insurer_list[]" multiple>
                                                        @if(!empty(@$insurers))
                                                        @foreach(@$insurers as $insurers)
                                                            <option value="{{$insurers->_id}}" selected>{{$insurers->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="filter_head">Customer Name</h4>
                                            <div class="cus_select2 select_dropdown1 filter_from_select">
                                                <select class="customer-data-ajax" id="customer_list" name="customer_list[]" multiple>
                                                        @if(!empty(@$customers))
                                                        @foreach(@$customers as $customer)
                                                            <option value="{{$customer->_id}}" selected>{{$customer->fullName}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 30px;">
                                <div class="col-md-4" id="filter_type_div">
                                    <h4 class="filter_head">Group</h4>
                                    <div class="filter_scroll">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" value="" id="grp_all" class="inp-cbx platform_all platforms reset_all" onclick="selectAll('Group')" style="display: none">
                                            <label for="grp_all" class="cbx">
                                                <span style="min-width: 18px;">
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>Select All</span>
                                            </label>
                                        </div>
                                        <div id="group_filter">
                                        </div>
                                    </div>   
                                </div>
                                <div class="col-md-4">
                                    <h4 class="filter_head">Assigned To</h4>
                                    <div class="filter_scroll">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" value="" id="agent_all" class="inp-cbx platform_all platforms reset_all" onclick="selectAll('agent')" style="display: none">
                                        <label for="agent_all" class="cbx">
                                            <span style="min-width: 18px;">
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            <span>Select All</span>
                                        </label>
                                    </div>
                                    <div id="agent_filter">
                                        
                                    </div>  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="filter_head">Agent</h4>
                                    <div class="filter_scroll">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" value="" id="customer_agent_all" class="inp-cbx platform_all platforms reset_all" onclick="selectAll('customerAgent')" style="display: none">
                                            <label for="customer_agent_all" class="cbx">
                                                <span style="min-width: 18px;">
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>Select All</span>
                                            </label>
                                        </div>
                                        <div id="customer_agent_filter">
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn_action pull-right" onclick="filter('{{$role}}', 0)" type="button">OK</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <!-- filter Popup ends -->


    <!-- forward email Popup -->
    <div id="forward_email">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container">
                    {{-- <form id="forward_mail_form" action="#"> --}}
                        <div class="modal_content">
                            <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><h1 id="success_message">Forward Email</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form_group mail_tag">
                                            <label class="form_label">To <span>*</span></label> 
                                            <input type="hidden" name="forward_mail_id" id="forward_mail_id" value=""> 
                                                <input type="text" style="background-color: #9c27b0;border-radius: 4px;padding: 6px;" name="forward_to" data-role="tagsinput" id="forward_to"><label id="idError" class="error"></label>
                                                <div id="empty_mail"></div><div id="mail_id_error" class="error"></div><br>
                                            <label class="form_label" for="">Cc </label>
                                            <input type="text" style="background-color: #9c27b0;border-radius: 4px;padding: 6px;" name="forward_cc" data-role="tagsinput" id="forward_cc"><label id="idError" class="error"></label>
                                            <div id="cc_error" class="error"></div><br>
                                            <label class="form_label" for="">Comments </label>
                                            <textarea class="bootstrap-tagsinput" name="forward_body" id="forward_body" cols="30" rows="10" style="width:100%;"></textarea>
                                            <label id="idError" class="error"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn-primary btn_action pull-right" type="button" id="forward_btn" onclick="forwardMail()">Send</button>
                            <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                        </div>
                    {{-- </form> --}}
                    {{-- <a href="#0" class="cd-popup-close img-replace"></a> --}}
                </div>
            </form>
        </div>
    </div> <!-- forward email Popup ends -->   


    {{-- delete pop up --}}
    <div id="message_popup">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <form method="post" >
                <div class="modal_content">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 name="message" id="message">..............</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn_action" type="button" onclick="hideMessage()" id="message_remove">OK</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- delete pop up --}}

        <div class="ajax-load text-center" style="display:none">
             <p><img src="{{URL::asset('img/loader.gif')}}">Loading More Tasks</p>
        </div>

        <div id="delete_popup">
            <div class="cd-popup">
                <div class="cd-popup-container" style="max-width: 654px;">
                    <form method="post" name="confirmation_form" id="confirmation_form">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                        <div class="content_spacing">
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Are you sure you want delete this document?</h3>
                                                <input name="id" id="id" value="" type="hidden">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button type="button" class="btn btn-primary btn-link btn_cancel">Cancel</button>
                        <button class="btn btn-primary btn_action" type="button" id="submitDoc">Delete</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <style>
        .section_details{
            max-width: 100%;
        }
        .display_label{
            /* color: #264cd8;  */
            color: #cc3766;
            font-size: 12px;
            margin-left: 20px;
        }
        /* .select2-container {
            z-index: 999999999;
        }
        .select2.select2-container.select2-container--default {
            width: 100%!important;
        }
        */
        .form-control, .is-focused .form-control {
            background-image: none;
        }
        .bmd-form-group .form-control{
            color: #4b515e;
            font-size: 14px !important;
            margin-left: 2px;
        }
        .ml-auto {
            margin: 0 23px 0 0;
            padding: 0;
        }
        .sort .custom_select .dropdown {
            width: 260px;
            border: 1px solid #dddddd;
            padding: 7px 0 0 15px;
        } 

        .cus_select2 .select2:last-child{
            display: none;
       }
       .cus_select2 .select2-container{
            min-height: 42px;
       }
       .cus_select2  .select2-container--default .select2-results>.select2-results__options{
        max-height: 100px !important;
       }
       .cus_select2 .dropdown{
           display: none;
       }
       .select2-container {
            z-index: 99999 !important;
        }
        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999999 !important;
        }
        .bootstrap-datetimepicker-widget table td{
            padding: 0 !important;
            width: auto !important;
        }
    </style>
    @endsection


    @push('scripts')
    <script src="{{URL::asset('js/main/custom-select.js')}}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<style>
        html, body {
            /* overflow: auto;
            height: auto; */
            overflow: auto;
        height: auto;
        min-height: 100%;
        display: flex;
        }
        .layout_content{
            overflow: hidden;
        }
        .page_content{
            height: auto;
            overflow: hidden;
        }
        .ajax-load.text-center img{
            width: 40px;
        }
        .ajax-load.text-center{
            margin-bottom: 100px;
        }
        .show-menu{
            overflow: hidden !important;
            position: absolute;
        }
    
    </style>
<script>

var page = 0;
$(document).ready(function() {
    $('#filterFromDate') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#filterToDate') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#filterFromDate').on("dp.change", function (e) {
        $('#filterToDate').data("DateTimePicker").minDate(e.date);
    });
    $('#filterToDate').on("dp.change", function (e) {
        $('#filterFromDate').data("DateTimePicker").maxDate(e.date);
    });
    loadMoreData(0);
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) { 
            if($('#after_load').val()!='loading')
            {
                page+=20;
                if(page<$('#total_count').val())
                {
                    loadMoreData(page);
                }
            }
        }
    });
    
});
function loadMoreData(page){
    // debugger;

    $('.ajax-load').show();
    var mailSwitch=$('#customSort').val();
    var search=$('#search_key').val();
    $('#after_load').val('loading');
    $.ajax(
    {
        url: "{{url('enquiry/closed-enquiry')}}",
        type: "get",
        data:{
            page:page,
            search2:search,
            box:mailSwitch,
            oldUser:'{{$user}}'
        },
        success: function(data) {
            $('.ajax-load').hide();
            if(page==0)
            {
                $("#post-data").html('');
            }
            $("#post-data").append(data.documentOperation);
            $('#after_load').val('loadComplete');
            $("#total_count").val(data.countMails);
            $("#spanCount").html(data.countMails);
            $('[data-toggle="tooltip"]').tooltip();
            
        }
    })  
}

function loadSerach()
{
    page=0;
    var mailSwitch=$('#customSort').val();
    var search=$('#search_key').val();
    $('.ajax-load').show();
    $('#after_load').val('loading');
    $.ajax(
    {
        url: "{{url('enquiry/closed-enquiry')}}",
        type: "get",
        data:{
            page:page,
            search2:search,
            filterMethod:'search',
            box:mailSwitch,
            oldUser:'{{$user}}'

        },
        success: function(data) {
            $('.ajax-load').hide();
            $("#post-data").html('');
            $("#post-data").append(data.documentOperation);
            $('#after_load').val('loadComplete');
            $("#total_count").val(data.countMails);
            $("#spanCount").html(data.countMails);
            $('[data-toggle="tooltip"]').tooltip();
            
        }
    })  
}
var forwardsetting=0;
var forwardCcSetting=0;
var wrongTags=[];
var wrongCcTages=[];
var emptyMail=0;

function initialFilterColor()
{
    var user=sessionStorage.getItem('previouisBox');
    var oldCache="{{session('closedOldCache')}}";
    if(oldCache!=user)
    {
        $('#filter').css('color','');
        sessionStorage.removeItem('closeEnq.statusFilter');
        sessionStorage.removeItem('closeEnq.nonstatusFilter');
        sessionStorage.removeItem("closeEnq.customersFilter");
        sessionStorage.removeItem("closeEnq.agentsFilter");
        sessionStorage.removeItem("closeEnq.customerAgentFilter");
        sessionStorage.removeItem("closeEnq.insurersFilter");
        sessionStorage.removeItem("closeEnq.fromDateFilter");
        sessionStorage.removeItem("closeEnq.toDateFilter");
        sessionStorage.removeItem("closeEnq.renewalCheckFilter");
        sessionStorage.removeItem("closeEnq.nonrenewalCheckFilter");
        sessionStorage.removeItem("closeEnq.grpFilter");
    }
    sessionStorage.setItem('previouisBox','{{$user}}');
}

function filterColorChange()
{
    var cust=[];
    var agen=[];
    var stat=[];
    var nonstat=[];
    var custAgent=[];
    var insurer=[];
    var fromDate='';
    var toDate='';
    var renew='';
    var nonRenew='';
    var grop=[];

    stat=JSON.parse(sessionStorage.getItem("closeEnq.statusFilter"));
    if(stat==null)
    {
        var stat=[];
    }
    nonstat=JSON.parse(sessionStorage.getItem("closeEnq.nonstatusFilter"));
    if(nonstat==null)
    {
        var nonstat=[];
    }
    cust=JSON.parse(sessionStorage.getItem("closeEnq.customersFilter"));
    if(cust==null)
    {
        var cust=[];
    }
    agen=JSON.parse(sessionStorage.getItem("closeEnq.agentsFilter"));
    if(agen==null)
    {
        var agen=[];
    }
    custAgent=JSON.parse(sessionStorage.getItem("closeEnq.customerAgentFilter"));
    if(custAgent==null)
    {
        var custAgent=[];
    } 
    insurer=JSON.parse(sessionStorage.getItem("closeEnq.insurersFilter"));
    if(insurer==null)
    {
        var insurer=[];
    }  
    fromDate=sessionStorage.getItem("closeEnq.fromDateFilter");
    if(fromDate==null)
    {
        var fromDate='';
    } 
    toDate=sessionStorage.getItem("closeEnq.toDateFilter");
    if(toDate==null)
    {
        var toDate='';
    } 
    renew=sessionStorage.getItem("closeEnq.renewalCheckFilter");
    if(renew==null)
    {
        var renew='';
    } 
    nonRenew=sessionStorage.getItem("closeEnq.nonrenewalCheckFilter");
    if(nonRenew==null)
    {
        var nonRenew='';
    } 
    grop=JSON.parse(sessionStorage.getItem("closeEnq.grpFilter"));
    if(grop==null)
    {
        var grop=[];
    }
    if(cust.length || agen.length || grop.length || stat.length || custAgent.length || insurer.length || nonstat.length||
     fromDate!='' || toDate!='' || renew!='' || nonRenew!='')
    {
        $('#filter').css('color','red');
    }
    else
    {
        $('#filter').css('color','');
    }
    
}
function reloadPage() {
    $('#btn_reload').attr('disabled', true);
    location.reload();
    setTimeout(function(){
        $('#btn_reload').attr('disabled', false);
    }, 6000);
}
// var statusStore=sessionStorage.getItem("closeDoc.statusFilter");
//                 var customerStore=sessionStorage.getItem("closeDoc.customersFilter");
//                 var agentStore=sessionStorage.getItem("closeDoc.agentsFilter");

var openedWindow;
function viewAttachment(path)
{
    openedWindow= window.open(path,'_blank','width=700, height=800, top=70, left=100, resizable=1, menubar=yes', false);
    // console.log(openedWindow);
}


$(document).ready(function(){
    filterColorChange();
    initialFilterColor();

    $.validator.addMethod("alpha",function(value,element){
        return this.optional(element) || (/^[a-zA-Z -_.]*$/i).test(value);
    });

    $('#custom_search').validate({
        // rules:{
        //     search2:
        //     {
        //         alpha: true
        //     }
        // },
        // messages:
        // {
        //     search2:{
        //         alpha: "please search only on alphabets !"
        //     }
        // },
        submitHandler: function(form){
            var mailSwitch=$('#customSort').val();
            $('#load_spinner').show();
            var search=$('#search_key').val();
            $('#after_load').val('loading');
            $.ajax({
                url: "{{url('enquiry/closed-enquiry')}}",
                type: "get",
                data:{
                    page:page,
                    search2:search,
                    filterMethod:'search',
                    box:mailSwitch,
                    oldUser:'{{$user}}'

                },
                success: function(data) {
                    page=0;
                    $('#load_spinner').hide();
                    $("#post-data").html('');
                    $("#post-data").append(data.documentOperation);
                    $('#after_load').val('loadComplete');
                    $("#total_count").val(data.countMails);
                    $("#spanCount").html(data.countMails);
                    $('[data-toggle="tooltip"]').tooltip();
                    
                }
            });
        }
    });
});

function setForwardTo(index)
{
    forwardsetting=0;
    forwardCcSetting=0;
    wrongTags=[];
    wrongCcTages=[];
    emptyMail=0;
    $('#load_spinner').show();
    // wrongTags=[];
    // emptyMail=0;
    $('#empty_mail').html("");
    $('#mail_id_error').html("");
    $('#cc_error').html("");
    $('#forward_mail_id').val(index);
    $('#idError').text('');
    $('#idError').hide();
    $('#forward_cc').val("");
    $('#forward_to').val("");
    $('#forward_body').val("");
    $('#forward_cc').tagsinput('removeAll');
    $('#forward_to').tagsinput('removeAll');
    $('#load_spinner').hide();
    $('#forward_email .cd-popup').addClass('is-visible');
}

function forwardMail()
{
    $('#forward_email .cd-popup').removeClass('is-visible');
    $('#load_spinner').show();
    if(forwardsetting>0||$('#forward_to').val()=="" || forwardCcSetting>0)
    {
        if($('#forward_to').val()=="")
        {
            if(emptyMail==0)
            {
                $('#empty_mail').append(
                '<div><label class="error"> Please enter mail id </label></div>'
                );
            }
            emptyMail=1;
        }
        else{
            emptyMail=0;
            $('#empty_mail').html('')

        }
        $('#load_spinner').hide();
        $('#forward_email .cd-popup').addClass('is-visible');
        return;
    }

    var mailId=$('#forward_mail_id').val();
    var mailTo=$('#forward_to').val();
    var mailcc="";
    var cc=$('#forward_cc').val();
    if(cc)
    {
        mailcc=cc.split(',');
    }
    var idSet=mailTo.split(',');
    var extraBody=$('#forward_body').val();
    var maildIds=[];
                $.ajax({
                    type:'post',
                    url: "{{url('enquiry/forward-document')}}",
                    data:{
                        _token:'{{csrf_token()}}',
                        mailId: mailId,
                        forwardTo:idSet,
                        cc: mailcc,
                        body: extraBody
                    },
                    success: function(result){
                        if(result==1)
                        {

                            $('#idError').text('');
                            $('#idError').hide();
                            $('#load_spinner').hide();
                            // $('#forward_email .cd-popup').removeClass('is-visible');
                            $('#message').text("Message forwarded successfully");                
                            $('#message_popup .cd-popup').addClass('is-visible');
                        }
                        else
                        {
                            // console.log('something');
                            $('#load_spinner').hide();
                            $('#forward_email .cd-popup').removeClass('is-visible');
                            $('#message').text("Sorry! can't forward mail at the moment");                
                            $('#message_popup .cd-popup').addClass('is-visible');
                        }
                    }
                });
    

}


    $('#forward_to').on('beforeItemAdd',function(event){
        var tag=event.item;
        emptyMail=0;
        $('#empty_mail').html('');
        if(!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i).test(tag))
        {
            forwardsetting++;
            wrongTags.push(tag);
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            // console.log(id);
            $('#mail_id_error').append(
                '<div id="'+id+'" ><label class="error"> "'+tag+'" is not a valid mail id </label></div>'
            );
        }
    });
    $('#forward_to').on('itemRemoved',function(event){
        if(wrongTags.includes(event.item) && event.item!="")
        {
            var tag=event.item;
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#mail_id_error #'+id).fadeOut('slow',function(){
                forwardsetting--;
                $('#mail_id_error #'+id).remove();
                var index = wrongTags.indexOf(event.item);
                if (index > -1) {
                    wrongTags.splice(index, 1);
                }
            });
        }
    });
    $('#forward_cc').on('beforeItemAdd',function(event){
        var tag=event.item;
        emptyMail=0;
        // $('#empty_mail').html('');
        if(!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i).test(tag))
        {
            forwardCcSetting++;
            wrongCcTages.push(tag);
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#cc_error').append(
                '<div id="'+id+'" ><label class="error"> "'+tag+'" is not a valid mail id </label></div>'
            );
        }
    });
    $('#forward_cc').on('itemRemoved',function(event){
        if(wrongCcTages.includes(event.item) && event.item!="")
        {
            var tag=event.item;
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#cc_error #'+id).fadeOut('slow',function(){
                forwardCcSetting--;
                $('#cc_error #'+id).remove();
                    
                var index = wrongCcTages.indexOf(event.item);
                if (index > -1) {
                    wrongCcTages.splice(index, 1);
                }
            });
        }
    });



function closeTab(index)
{ 
  $('#'+index).collapse('hide');
}

    function showFilter(totalMail,mailStatus,role) {
        
        var mailBucket = $('#hidden_filter_value').val();
        $('#load_spinner').show();
        
        var customerId;
        var customerName;
        var agentId;
        var length;
        var agentName;
        var i=0;
        var count=0;
        var selection="nonStatus";
        var stock=[];
        // var groups=[];
        var mailBox=$('#customSort').find(':selected').text();
        mailBucket=JSON.parse(mailBucket);
        // var groups=mailBucket.groups;
        if(mailBucket.groups)
        {
            var groups=mailBucket.groups;
        }else{
            var groups=[];
        }
        if((mailBucket.nonRenewalStatus))
        {
            var nonrenewStatus=mailBucket.nonRenewalStatus;
        }else{
            var nonrenewStatus=[];
        }
        if((mailBucket.renewalStatus))
        {
            var renewStatus=mailBucket.renewalStatus;
        }else{
            var renewStatus=[];
        }
        // var nonrenewStatus=mailBucket.nonRenewalStatus;
        // var renewStatus=mailBucket.renewalStatus;
        var customerStore=sessionStorage.getItem("closeEnq.customersFilter");
        var insurerStore=sessionStorage.getItem("closeEnq.insurersFilter");
        customerStore=JSON.parse(customerStore);
        insurerStore=JSON.parse(insurerStore);
        var filterFromDate=sessionStorage.getItem("closeEnq.fromDateFilter");
        var filterToDate=sessionStorage.getItem("closeEnq.toDateFilter");
        var renewalCheck=sessionStorage.getItem("closeEnq.renewalCheckFilter");
        var nonrenewalCheck=sessionStorage.getItem("closeEnq.nonrenewalCheckFilter");
        $('#filterFromDate').data("DateTimePicker").date(filterFromDate);
        $('#filterToDate').data("DateTimePicker").date(filterToDate);
        $.ajax({
            type: 'post',
            url: "{{url('enquiry/filter-options')}}",
            data:
            {
                _token:'{{csrf_token()}}',
                mailbox: mailBox,
                status: mailStatus,
                role: role,
                customerStore: customerStore,
                insurerStore: insurerStore
            },
            success: function(result)
            {
                $('#group_filter').empty();
                $('#customer_list').html(result[2]);
                $('#insurer_list').html(result[3]);
                $('#status_filter').empty();
                $('#non_status_filter').empty();
                $('#customer_filter').empty();
                $('#customer_agent_filter').empty();
                $('#agent_filter').empty();
                $('#insurer_filter').empty();
                var check="";
                var customers=result[2];
                var agents=result[0];
                var customerAgents=result[1];
                var insurers=result[3];
                var statusStore=sessionStorage.getItem("closeEnq.statusFilter");
                var nonstatusStore=sessionStorage.getItem("closeEnq.nonstatusFilter");
                statusStore = JSON.parse(statusStore)? JSON.parse(statusStore): [];
                nonstatusStore = JSON.parse(nonstatusStore)? JSON.parse(nonstatusStore) : [];
                var customerStore=sessionStorage.getItem("closeEnq.customersFilter");
                var agentStore=sessionStorage.getItem("closeEnq.agentsFilter");
                var customerAgentStore=sessionStorage.getItem('closeEnq.customerAgentFilter');
                var insurerStore=sessionStorage.getItem('closeEnq.insurersFilter');
                var grpStore=sessionStorage.getItem('closeEnq.grpFilter');

                length=nonrenewStatus.length;
                if(renewalCheck=='renewalCheck')
                {
                    $("#renewalCheck").prop( "checked", true );
                }
                if(nonrenewalCheck=='nonrenewalCheck')
                {
                    $("#nonrenewalCheck").prop( "checked", true );
                }
                if(filterFromDate!='')
                {
                    $("#filterFromDate").val(filterFromDate);
                }
                if(filterToDate!='')
                {
                    $("#filterToDate").val(filterToDate);
                }
                subStatusStore = "";
                selected = "";
                for(i=0;i<length;i++)
                {
                    if(nonrenewStatus[i].closureProperty==1)
                    {
                        nonstatusStore.forEach(function(item) {
                            if (item.status == nonrenewStatus[i].statusName) {
                                check = "checked";
                                subStatusStore = item.subStatus? item.subStatus : [];
                                return;
                            }
                        });

                        // if(nonstatusStore)
                        // if(nonstatusStore.includes(nonrenewStatus[i].statusName))
                        // check="checked";
                        var substring='<div class="row">'+
                        '<div class="col-md-3">'+'<div class="custom_checkbox">'+
                            '<input type="checkbox" '+check+' value="'+nonrenewStatus[i].statusName+'" id="cbx_non_status_'+count+'" name="non_status_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                            '<label for="cbx_non_status_'+count+'" class="cbx">'+
                                '<span style="min-width: 18px;">'+
                                    '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                        '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                    '</svg>'+
                                '</span>'+
                                '<span id="sp_status_'+count+'" class="text-ellipsis"  data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="'+nonrenewStatus[i].statusName+'">'+nonrenewStatus[i].statusName+'</span>'+
                            '</label>'+
                        '</div>'+
                        '</div>';
                        
                        substring+='<div class="col-md-8">'+
                        '<div class="form_group substatus_dropdown>'+
                            '<label class="form_label"></label>'+
                            '<select class="selectpicker" id="subStatusList_'+count+'" name="subStatusList_[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" '+
                            'title="Sub Status"'+
                            (check=="checked"?"":"disabled")
                            +' multiple>';
                                // '<option value="">Select sub status</option>';
                                if(nonrenewStatus[i].subStatus && nonrenewStatus[i].subStatus.length) {
                                    nonrenewStatus[i].subStatus.forEach(function(item){
                                        if (subStatusStore.includes(item)) {
                                            selected= "selected";
                                        }
                                        substring+='<option value="'+item+'" '+selected+'>'+item+'</option>';
                                        selected = "";
                                    });
                                }
                        substring+='</select>'+
                                    '</div></div></div>';
                        $('#non_status_filter').append(substring);

                        // $('#non_status_filter').append(
                        //     '<div class="custom_checkbox">'+
                        //         '<input type="checkbox" '+check+' value="'+nonrenewStatus[i].statusName+'" id="cbx_non_status_'+count+'" name="non_status_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                        //         '<label for="cbx_non_status_'+count+'" class="cbx">'+
                        //             '<span style="min-width: 18px;">'+
                        //                 '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                        //                     '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                        //                 '</svg>'+
                        //             '</span>'+
                        //             '<span id="sp_status_'+count+'">'+nonrenewStatus[i].statusName+'</span>'+
                        //         '</label>'+
                        //     '</div>'
                        // );
                        count++;
                        check="";
                    }
                }
                selection="status";
                stock=[];
                count=0;
                subStatusStore = "";
                selected = "";
                length=renewStatus.length;
                for(i=0;i<length;i++)
                {
                    if(renewStatus[i].closureProperty==1)
                    {

                        statusStore.forEach(function(item) {
                            if (item.status == renewStatus[i].statusName) {
                                check = "checked";
                                subStatusStore = item.subStatus? item.subStatus : [];
                                return;
                            }
                        });

                        // if(statusStore)
                        // if(statusStore.includes(renewStatus[i].statusName))
                        // check="checked";

                        var substring='<div class="row">'+
                        '<div class="col-md-3">'+
                        '<div class="custom_checkbox">'+
                            '<input type="checkbox" '+check+' value="'+renewStatus[i].statusName+'" id="cbx_status_'+count+'" name="status_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                            '<label for="cbx_status_'+count+'" class="cbx">'+
                                '<span style="min-width: 18px;">'+
                                    '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                        '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                    '</svg>'+
                                '</span>'+
                                '<span id="sp_status_'+count+'" class="text-ellipsis"data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="'+renewStatus[i].statusName+'">'+renewStatus[i].statusName+'</span>'+
                            '</label>'+
                        '</div>'+
                        '</div>';
                        substring+='<div class="col-md-8">'+
                        '<div class="form_group substatus_dropdown>'+
                            '<label class="form_label"></label>'+
                            '<select class="selectpicker" id="subStatusListRenew_'+count+'" name="subStatusListRenew_'+count+'_[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" '+
                            'title="Sub Status"'+
                            (check=="checked"?"":"disabled")
                            +' multiple>';
                                if(renewStatus[i].subStatus && renewStatus[i].subStatus.length) {
                                    renewStatus[i].subStatus.forEach(function(item){
                                        if (subStatusStore.includes(item)) {
                                            selected= "selected";
                                        }
                                        substring+='<option value="'+item+'" '+selected+'>'+item+'</option>';
                                        selected = "";
                                    });
                                }
                        substring+='</select>'+
                                    '</div></div></div>';
                        $('#status_filter').append(substring);

                        // $('#status_filter').append(
                        //     '<div class="custom_checkbox">'+
                        //         '<input type="checkbox" '+check+' value="'+renewStatus[i].statusName+'" id="cbx_status_'+count+'" name="status_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                        //         '<label for="cbx_status_'+count+'" class="cbx">'+
                        //             '<span style="min-width: 18px;">'+
                        //                 '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                        //                     '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                        //                 '</svg>'+
                        //             '</span>'+
                        //             '<span id="sp_status_'+count+'">'+renewStatus[i].statusName+'</span>'+
                        //         '</label>'+
                        //     '</div>'
                        // );
                        count++;
                        check="";
                    }
                }   
                selection="Group";
            stock=[];
            count=0;
            length=groups.length;
            for(i=0;i<length;i++)
            {
                if(groups[i])
                {
                    if(grpStore)
                    if(grpStore.includes(groups[i]))
                    check="checked";
                    $('#group_filter').append(
                        '<div class="custom_checkbox">'+
                            '<input type="checkbox" '+check+' value="'+groups[i]+'" id="groupList_'+count+'" name="groupList[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                            '<label for="groupList_'+count+'" class="cbx">'+
                                '<span style="min-width: 18px;">'+
                                    '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                        '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                    '</svg>'+
                                '</span>'+
                                '<span id="sp_status_'+count+'">'+groups[i]+'</span>'+
                            '</label>'+
                        '</div>'
                    );
                    count++;
                    check="";
                }
            }             
                // count=0;
                // selection="customer";
                // length=customers.length;
                // for(i=0;i<length;i++)
                // {
                //     customerName=customers[i].assaignedTo.customerName;
                //     customerId= customers[i].assaignedTo.customerId.$oid;
                //     if(customerId!=null && customerId!="" && !stock.includes(customerId))
                //     {
                //         if(customerStore)
                //         if(customerStore.includes(customerId))
                //         check="checked";
                //         stock.push(customerId);
                //         $('#customer_filter').append(
                //             '<div class="custom_checkbox">'+
                //                 '<input type="checkbox" '+check+' value="'+customerId+'" id="cbx_customer_'+count+'" name="customer_list[]" onclick="checkSelection(\''+selection+'\')" class="inp-cbx platforms not_reset" style="display: none">'+
                //                 '<label for="cbx_customer_'+count+'" class="cbx">'+
                //                     '<span>'+
                //                         '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                //                             '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                //                         '</svg>'+
                //                     '</span>'+
                //                     '<span id="sp_customer_'+count+'">'+customerName+'</span>'+
                //                 '</label>'+
                //             '</div>'
                //         );
                //         count++;
                //         check="";
                //     }
                // }
                stock=[];
                count=0;
                selection="agent";
                length=agents.length;
                for(i=0;i<length;i++)
                {
                    agentId=agents[i].assaignedTo.agentId.$oid;
                    agentName=agents[i].assaignedTo.agentName;
                    if(agentId!=null && agentId!="" && !stock.includes(agentId))
                    {
                        if(agentStore)
                        if(agentStore.includes(agentId))
                        check="checked";
                        stock.push(agentId);
                        $('#agent_filter').append(
                            '<div class="custom_checkbox">'+
                                '<input type="checkbox" '+check+' value="'+agentId+'"  id="cbx_agent_'+count+'" name="agent_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx platform_all platforms reset_all" style="display: none">'+
                                '<label for="cbx_agent_'+count+'" class="cbx">'+
                                    '<span>'+
                                        '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                            '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                        '</svg>'+
                                    '</span>'+
                                    '<span id="sp_agent_'+count+'">'+agentName+'</span>'+
                                '</label>'+
                            '</div>'
                        );
                        count++;
                        check="";
                    }
                }
                stock=[];
                count=0;
                selection="customerAgent";
                length=customerAgents.length;
                for(i=0;i<length;i++)
                {
                    customerAgentId=customerAgents[i].assaignedTo.customerAgentId;
                    customerAgentName=customerAgents[i].assaignedTo.customerAgentName;
                    if(customerAgentId!=null && customerAgentId!="" && !stock.includes(customerAgentId))
                    {
                        if(customerAgentStore)
                        if(customerAgentStore.includes(customerAgentId))
                        check="checked";
                        stock.push(customerAgentId);
                        $('#customer_agent_filter').append(
                            '<div class="custom_checkbox">'+
                                '<input type="checkbox" '+check+' value="'+customerAgentId+'"  id="cbx_customer_agent_'+count+'" name="customer_agent_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx platform_all platforms reset_all" style="display: none">'+
                                '<label for="cbx_customer_agent_'+count+'" class="cbx">'+
                                    '<span>'+
                                        '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                            '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                        '</svg>'+
                                    '</span>'+
                                    '<span id="sp_agent_'+count+'">'+customerAgentName+'</span>'+
                                '</label>'+
                            '</div>'
                        );
                        count++;
                        check="";
                    }
                }
                // stock=[];
                // count=0;
                // selection="insurer";
                // length=insurers.length;
                // for(i=0;i<length;i++)
                // {
                //     insurerId=insurers[i].assaignedTo.insurerId;
                //     insurerName=insurers[i].assaignedTo.insurerName;
                //     if(insurerId!=null && insurerId!="" && !stock.includes(insurerId))
                //     {
                //         if(insurerStore)
                //         if(insurerStore.includes(insurerId))
                //         check="checked";
                //         stock.push(insurerId);
                //         $('#insurer_filter').append(
                //             '<div class="custom_checkbox">'+
                //                 '<input type="checkbox" '+check+' value="'+insurerId+'"  id="cbx_insurer_'+count+'" name="insurer_list[]" onclick="checkSelection(\''+selection+'\')" class="inp-cbx platform_all platforms reset_all" style="display: none">'+
                //                 '<label for="cbx_insurer_'+count+'" class="cbx">'+
                //                     '<span>'+
                //                         '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                //                             '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                //                         '</svg>'+
                //                     '</span>'+
                //                     '<span id="sp_agent_'+count+'">'+insurerName+'</span>'+
                //                 '</label>'+
                //             '</div>'
                //         );
                //         count++;
                //         check="";
                //     }
                // }
                // $('#filter').prop( "disabled", true );
                $('#load_spinner').hide();
                $('#status_filter select').selectpicker({
                    size: 5
                });
                $('#non_status_filter select').selectpicker({
                    size: 5
                });
                $('#document_mail_filter .cd-popup').addClass('is-visible');
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    function checkSelection(type, index)
    {
        var flag=0;
        if(type=='status') {
            if (! $('#cbx_status_'+index).is(':checked')) {
                $('#subStatusListRenew_'+index+'.selectpicker').selectpicker('deselectAll');
                $('#subStatusListRenew_'+index).prop('disabled', true);
                $('#status_all').prop('checked', false);
            } else if($('#cbx_status_'+index).is(':checked')) {
                $('#subStatusListRenew_'+index+'.selectpicker').selectpicker('deselectAll');
                $('#subStatusListRenew_'+index).prop('disabled', false);
                $('input[name="status_list[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#status_all').prop('checked', true);
                }
            }
            $('#subStatusListRenew_'+index+'.selectpicker').selectpicker('refresh');
        } else if (type=='nonStatus') {
            if (! $('#cbx_non_status_'+index).is(':checked')) {
                $('#subStatusList_'+index+'.selectpicker').selectpicker('deselectAll');
                $('#subStatusList_'+index).prop('disabled', true);
                $('#non_status_all').prop('checked', false);
            } else if($('#cbx_non_status_'+index).is(':checked')) {
                $('#subStatusList_'+index+'.selectpicker').selectpicker('deselectAll');
                $('#subStatusList_'+index).prop('disabled', false);
                $('input[name="non_status_list[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#non_status_all').prop('checked', true);
                }
            }
            $('#subStatusList_'+index+'.selectpicker').selectpicker('refresh');
        } else if (type=='agent') {
            if (! $('#cbx_agent_'+index).is(':checked')) {
                $('#agent_all').prop('checked', false);
            } else if($('#cbx_agent_'+index).is(':checked')) {
                $('input[name="agent_list[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#agent_all').prop('checked', true);
                }
            }
        } else if (type=='customerAgent') {
            if (! $('#cbx_customer_agent_'+index).is(':checked')) {
                $('#customer_agent_all').prop('checked', false);
            } else if($('#cbx_customer_agent_'+index).is(':checked')) {
                $('input[name="customer_agent_list[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#customer_agent_all').prop('checked', true);
                }
            }
        } else if (type=='Group') {
            if (! $('#groupList_'+index).is(':checked')) {
                $('#grp_all').prop('checked', false);
            } else if($('#groupList_'+index).is(':checked')) {
                $('input[name="groupList[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#grp_all').prop('checked', true);
                }
            }
        }
    }

    function resetFilter()
    {
        $('#status_all').attr('checked',false);
        $('#non_status_all').attr('checked',false);
        $('#customer_all').attr('checked',false);
        $('#agent_all').attr('checked',false);
        $('#customer_agent_all').attr('checked',false);
        $('#insurer_all').attr('checked',false);
        $('#insurer_filter input:checkbox').attr('checked',false);
        $('#customer_agent_filter input:checkbox').attr('checked',false);
        $('#status_filter input:checkbox').attr('checked',false);
        $('#non_status_filter input:checkbox').attr('checked',false);
        $('#agent_filter input:checkbox').attr('checked',false);
        $('#customer_filter input:checkbox').attr('checked',false);
        $("#insurer_list").val(null).trigger("change"); 
        $("#customer_list").val(null).trigger("change"); 
        $("#filterFromDate").val(''); 
        $("#filterToDate").val(''); 
        $('#renewalCheck').attr('checked',false);
        $('#renewalCheck').val('');
        $('#nonrenewalCheck').attr('checked',false);
        $('#nonrenewalCheck').val('');
        $("#filterFromDate").data("DateTimePicker").clear();
        $("#filterToDate").data("DateTimePicker").clear();
        $('#grp_all').attr('checked',false);     
        $('#group_filter input:checkbox').attr('checked',false);
        $('#status_filter select').selectpicker('deselectAll');
        $('#non_status_filter select').selectpicker('deselectAll');

    }

    function filter(role, mailStatus)
    {
        $('#document_mail_filter .cd-popup').removeClass('is-visible');
        $('#load_spinner').show();
        if($("#renewalCheck").prop('checked') == true && $("#nonrenewalCheck").prop('checked') == false)
            {
            $('#renewalCheck').val('renewalCheck');
            $('#nonrenewalCheck').val('');
        }
        if($("#nonrenewalCheck").prop('checked') == true  && $("#renewalCheck").prop('checked') == false)
        {
            $('#nonrenewalCheck').val('nonrenewalCheck');
            $('#renewalCheck').val('');
        } 
        if($("#nonrenewalCheck").prop('checked') == true && $("#renewalCheck").prop('checked') == true)
        {
            $('#nonrenewalCheck').val('nonrenewalCheck');
            $('#renewalCheck').val('renewalCheck');
        } 
        var statusDetails=[];
        var nonstatusDetails=[];
        var agentDetails=[];
        var customerAgentDetails=[];
        var groupDetails=[];
        var statusLength=$('input[name="status_list[]"]').length;
        var nonstatusLength=$('input[name="non_status_list[]"]').length;
        var groupListLength=$('input[name="groupList[]"]').length;
        var agentsLength=$('input[name="agent_list[]"]').length;
        var customerAgentsLength=$('input[name="customer_agent_list[]"]').length;
        var customerDetails=$('#customer_list').val();
        var insurerDetails=$('#insurer_list').val();
        var filterFromDate=$('#filterFromDate').val();
        var filterToDate=$('#filterToDate').val();
        var renewalCheck=$('#renewalCheck').val();
        var nonrenewalCheck=$('#nonrenewalCheck').val();
        for(i=0;i<statusLength;i++)
        {
            if($('#cbx_status_'+i).is(':checked')) {
                var sub = $('#subStatusListRenew_'+i).val()?$('#subStatusListRenew_'+i).val():[];
                var status = {
                    'status' : $('#cbx_status_'+i).val(),
                    'subStatus' : sub
                };
                statusDetails.push(status);
            }
            // statusDetails.push($('#cbx_status_'+i).val());
        }
        for(i=0;i<nonstatusLength;i++)
        {
            if($('#cbx_non_status_'+i).is(':checked')){
                var sub = $('#subStatusList_'+i).val()?$('#subStatusList_'+i).val():[];
                var nonstatus = {
                    'status' : $('#cbx_non_status_'+i).val(),
                    'subStatus' : sub
                };
                nonstatusDetails.push(nonstatus);
            }
            // nonstatusDetails.push($('#cbx_non_status_'+i).val());
        }
        // return;
        sessionStorage.setItem('closeEnq.statusFilter',JSON.stringify(statusDetails));
        sessionStorage.setItem('closeEnq.nonstatusFilter',JSON.stringify(nonstatusDetails));
        sessionStorage.setItem('closeEnq.customersFilter',JSON.stringify(customerDetails));
        sessionStorage.setItem('closeEnq.fromDateFilter',filterFromDate);
        sessionStorage.setItem('closeEnq.toDateFilter',filterToDate);
        sessionStorage.setItem('closeEnq.renewalCheckFilter',renewalCheck);
        sessionStorage.setItem('closeEnq.nonrenewalCheckFilter',nonrenewalCheck);
        console.log(statusDetails, nonstatusDetails);
        // return;
        for(i=0;i<agentsLength;i++)
        {
            if($('#cbx_agent_'+i).is(':checked'))
            agentDetails.push($('#cbx_agent_'+i).val());
        }
        sessionStorage.setItem('closeEnq.agentsFilter',JSON.stringify(agentDetails));
        for(i=0;i<customerAgentsLength;i++)
        {
            if($('#cbx_customer_agent_'+i).is(':checked'))
            customerAgentDetails.push($('#cbx_customer_agent_'+i).val());
        }
        sessionStorage.setItem('closeEnq.customerAgentFilter',JSON.stringify(customerAgentDetails));
        // for(i=0;i<insurerLength;i++)
        // {
        //     if($('#cbx_insurer_'+i).is(':checked'))
        //     insurerDetails.push($('#cbx_insurer_'+i).val());
        // }
        for(i=0;i<groupListLength;i++)
        {
            if($('#groupList_'+i).is(':checked'))
            groupDetails.push($('#groupList_'+i).val());
        }
        sessionStorage.setItem('closeEnq.grpFilter',JSON.stringify(groupDetails));

        sessionStorage.setItem('closeEnq.insurersFilter',JSON.stringify(insurerDetails));
        var mailSwitch=$('#customSort').val();
        $('#after_load').val('loading');
        $.ajax({
            type:'get',
            url: "{{url('enquiry/closed-enquiry')}}",
            data: 
            {
                statusDetails: statusDetails,
                nonstatusDetails: nonstatusDetails,
                customerDetails: customerDetails,
                agentDetails: agentDetails,
                customerAgentDetails: customerAgentDetails,
                insurerDetails: insurerDetails,
                status: mailStatus,
                user:'{{$user}}',
                role: role,
                filterMethod:'filter',
                box:mailSwitch,
                oldUser:'{{$user}}',
                filterFromDate: filterFromDate,
                filterToDate: filterToDate,
                renewalCheck: renewalCheck,
                nonrenewalCheck: nonrenewalCheck,
                groupDetails: groupDetails
            },
            success: function(result)
            {
                page=0;
                $('#load_spinner').hide();
                $('#post-data').html('');
                $('#post-data').append(result.documentOperation);
                $('#after_load').val('loadComplete');
                $('#spanCount').html(result.countMails);
                filterColorChange();
                $('[data-toggle="tooltip"]').tooltip();
                $("#total_count").val(result.countMails);
            }
        });
    }


    function selectAll(index)
    {
        var i=0;
        if(index=='status')
        {
            var statusLength=$('input[name="status_list[]"]').length;
            if($('#status_all').is(':checked'))
            {
                $('#status_filter select').prop('disabled', false);
                $('#status_filter input:checkbox').attr('checked',true);
                for(i=0;i<statusLength;i++)
                {
                    if(!$('#cbx_status_'+i).is(':checked'))
                    if($('#cbx_status_'+i).click())
                    {
                    // console.log("first");
                    }
                }
            }
            else
            {
                
                if($('#status_filter input:checkbox').attr('checked',false))
                {
                    $('#status_filter select').prop('disabled', true);
                    $('#status_all').attr('checked',false);
                    // console.log("no");
                }
            }
            $('#status_filter select').selectpicker('deselectAll');
            $('#status_filter select').selectpicker('refresh');
            
        }
        if(index=='nonStatus')
        {
            var nonstatusLength=$('input[name="non_status_list[]"]').length;
            if($('#non_status_all').is(':checked'))
            {
                $('#non_status_filter select').prop('disabled', false);
                $('#non_status_filter input:checkbox').attr('checked',true);
                for(i=0;i<nonstatusLength;i++)
                {
                    if(!$('#cbx_non_status_'+i).is(':checked'))
                    if($('#cbx_non_status_'+i).click())
                    {
                    }
                }
            }
            else
            {
                if($('#non_status_filter input:checkbox').attr('checked',false))
                {
                    $('#non_status_filter select').prop('disabled', true);
                    $('#non_status_all').attr('checked',false);
                }
            }
            $('#non_status_filter select').selectpicker('deselectAll');
            $('#non_status_filter select').selectpicker('refresh');
        }
        else if(index=='customer')
        {
            var customerLength=$('input[name="customer_list[]"]').length;
            if($('#customer_all').is(':checked'))
            {
                $('#customer_filter input:checkbox').attr('checked',true);
                for(i=0;i<customerLength;i++)
                {
                    if(!$('#cbx_customer_'+i).is(':checked'))
                    if($('#cbx_customer_'+i).click())
                    {
                    // console.log("first");
                    }
                }
            }
            else
            {
                $('#customer_filter input:checkbox').attr('checked',false);
                // console.log("no");
            }
        }
        else if(index=='agent')
        {
            var agentsLength=$('input[name="agent_list[]"]').length;
            if($('#agent_all').is(':checked'))
            {
                $('#agent_filter input:checkbox').attr('checked',true);
                for(i=0;i<agentsLength;i++)
                {
                    if(!$('#cbx_agent_'+i).is(':checked'))
                    if($('#cbx_agent_'+i).click())
                    {
                    // console.log("first");
                    }
                }
            }
            else
            {
                if($('#agent_filter input:checkbox').attr('checked',false)){}
                // console.log("no");
            }
            
        }
        else if(index=='customerAgent')
        {
            var customerAgentsLength=$('input[name="customer_agent_list[]"]').length;
            if($('#customer_agent_all').is(':checked'))
            {
                $('#customer_agent_filter input:checkbox').attr('checked',true);
                for(i=0;i<customerAgentsLength;i++)
                {
                    if(!$('#cbx_customer_agent_'+i).is(':checked'))
                    if($('#cbx_customer_agent_'+i).click())
                    {
                    // console.log("first");
                    }
                }
            }
            else
            {
                if($('#customer_agent_filter input:checkbox').attr('checked',false)){}
                // console.log("no");
            }
        }
        else if(index=='insurer')
        {
            var insurerLength=$('input[name="insurer_list[]"]').length;
            if($('#insurer_all').is(':checked'))
            {
                $('#insurer_filter input:checkbox').attr('checked',true);
                for(i=0;i<insurerLength;i++)
                {
                    if(!$('#cbx_insurer_'+i).is(':checked'))
                    if($('#cbx_insurer_'+i).click())
                    {
                    // console.log("first");
                    }
                }
            }
            else
            {
                if($('#insurer_filter input:checkbox').attr('checked',false)){}
                // console.log("no");
            }
        }
        else if(index=='Group')
        {
            var GroupLength=$('input[name="groupList[]"]').length;
            if($('#grp_all').is(':checked'))
            {
                $('#group_filter input:checkbox').attr('checked',true);
                for(i=0;i<GroupLength;i++)
                {
                    if(!$('#groupList_'+i).is(':checked'))
                    if($('#groupList_'+i).click())
                    {
                    }
                }
            }
            else
            {
                if($('#group_filter input:checkbox').attr('checked',false)){}
            }
        }
    }

    function downloadAttachment(path, add)
    {
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip('enable');
        window.location.href="{{url('document/download?index=')}}"+path+add;

    }


function checkFunction(index,btn_index,count) {
    var checked=[];
    var isShow=0;
    $("input[name='attachment_checkbox_"+count+"[]']").each(function(){
        if($(this).is(':checked'))
        {
        checked.push($(this).val());
        isShow=1;
        }
        else
        {
            checked.push("");
        }
    });
    if(isShow==1)
    {
        $('#button_show'+btn_index).show();
        
    }
    else
    {
        $('#button_show'+btn_index).hide();
    }
}

function hideMessage()
{
    $('#message_popup .cd-popup').removeClass('is-visible');
    $('#message').text(""); 
    $('#message').html("");   
    loadMoreData(page);           
}

$('#accordion').on('collapsed', function () {
    $('#accordion .show').collapse('hide');
});



function showMail(index)
{
    $('#load_spinner').show();
    $.ajax({
            method: 'post',
            url: "{{url('enquiry/get-mail-content')}}",
            data: {
                index: index,
                _token: '{{csrf_token()}}'
                    },
            success: function (result) {

                $('#load_spinner').hide();
                if(result.subject=="")
                {
                    result.subject="(no subject)";
                }
                $('#open_email .cd-popup').addClass('is-visible');
                $('#mail_sub').text(result.subject);
                $('#mail_body').html(result.mailsContent);
                $('#mail_from').text("<"+result.from+">");
                $('#mail-time').text(result.recieveTime);
                $('#open_email .cd-popup').addClass('is-visible');

            }
        });
}

function switchMail()
{
    page=0;
    var mailSwitch=$('#customSort').val();
    $('#after_load').val('loadComplete');
    window.location.href='{{url("enquiry/closed-enquiry?box=")}}'+mailSwitch+'&oldUser={{$user}}&page='+page;
}

// function switchMail()
// {
//     var mailSwitch=$('#customSort').val();
//     var page=0;
//     $('#load_spinner').show();
//     $.ajax(
//     {
//         url: "{{url('enquiry/closed-enquiry')}}",
//         type: "get",
//         data:{
//             box:mailSwitch,
//             oldUser:'{{$user}}',
//             page:page
//         },
//         success: function(data) {
//             $('[data-toggle="tooltip"]').tooltip();
//             $('#load_spinner').hide();
//             $("#post-data").html('');
//             $("#post-data").append(data.documentOperation);
//             $("#total_count").val(data.countMails);
//             $("#spanCount").html(data.countMails);
            
//         }
//     })  
// }


function viewComments(index)
{
    $('#load_spinner').show();
    $('#hdnEmailId').val(index);

    $.ajax({
        type:'post',
        url: "{{url('enquiry/view-comments')}}",
        data: {
            _token: "{{csrf_token()}}",
            index: index
        },
        success: function(result){
            $('#chat').html("");
            $('#load_spinner').hide();
            if(result!=0)
            {
                result.forEach(function(element){
                    $('#chat').append(
                    '<li class="you">'+
                        '<div class="entete">'+
                            '<h3 style="font-style: italic">'+  element.commentBy +' - <span>'+ 
                            element.commentDate.toString() +'</span> - <b style="font-style: normal">'+element.commentBody+'</b></h3>'+ 
                        '</div>'+
                    '</li>');
                });
                $('#chat').animate({
                    scrollTop: $('#chat li').last().offset().top
                }, 'slow');
            }
            else
            {
                $('#chat').html("<h3 id='nothing_show' style='margin-left:20px;'>(No comments yet)<h3>");
            }
            $('#comment .cd-popup').addClass('is-visible');
            
        }
    });
}

$(function(){
    $('#new_comment').on('input',function(){
        if($(this).val()=="")
        {
            $('#comment_error').text("please enter comment.");

        }
        else
        {
            $('#comment_error').text("");
        }
    });
});

function submitComment(index)
{
    var newComment=$('#new_comment').val();
    if($('#new_comment').val()=="")
    {
        $('#comment_error').text("please enter comment.");
    }
    $('#new_comment').val("");
    if(newComment!="" && !(/^[ ]*$/i).test(newComment))
    {
        $('#comment_error').text("");
        $('#load_spinner').show();
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: "{{url('enquiry/submit-comments')}}",
            data:{
                index: $('#hdnEmailId').val(),
                comment: newComment,
                _token: '{{csrf_token()}}'
            },
            success: function(result){
                $('#load_spinner').hide();
                $('#new_comment').val("");
                $('#nothing_show').text("");
                $('#chat').append(
                '<li class="you">'+
                    '<div class="entete">'+
                        '<h3 style="font-style: italic">'+  result.by +' - <span>'+ 
                                result.date.toString() +'</span> - <b style="font-style: normal">'+result.body+'</b></h3>'+ 
                    '</div>'+
                '</li>');
                $("#chat").animate({scrollTop :$("#chat").get(0).scrollHeight},1000);
            }
        });
    }
}


// function bulkDownload(count, attachments)
// {
//     var attachmentList=JSON.parse(attachments);
//     var checked=[];
//     var attachCount=0;
//     $.each($("input[name='attachment_checkbox_"+count+"[]']"),function(item){
//         if($(this).is(':checked'))
//         {
//             checked.push($(this).val());
//         }
//         else
//         {
//             checked.push("");
//         }
//     });
//     var downloadCarrier=document.createElement('a');
//     downloadCarrier.setAttribute('id','dynamicDownload');
//     var fileName="";
//     var path="";
//     attachmentList.forEach(function(item){
//         if(checked[attachCount]==item.attachId)
//         {
//             fileName=item.attachName;
//             // fileName=fileName[fileName.length-1];
//             fileName=fileName.split(".");
//             fileName=fileName[0];
//             path="{{url('document/download?index=')}}"+item.attachPath+"&name="+item.attachName;
//             downloadCarrier.href=path;
//             downloadCarrier.download=fileName;
//             downloadCarrier.click();
//         }
//         attachCount++;
        
//     });
//    $('#dynamicDownload').remove();
// }

    function bulkDownload(id)
    {
       
        var checked=[];
        var attachCount=0;
        $.each($("input[name='attachment_checkbox_"+id+"[]']"),function(item){
            if($(this).is(':checked'))
            {
                checked.push($(this).val());
            }
            else
            {
                checked.push("");
            }
        });
        $.ajax({
            type: "post",
            url: "{{url('enquiry/find-attachments')}}",
            data:
            {
                index: id,
                _token: "{{csrf_token()}}"
            },
            success: function(attachmentList)
            {
                var downloadCarrier=document.createElement('a');
                downloadCarrier.setAttribute('id','dynamicDownload');
                var fileName="";
                var path="";
                attachmentList.forEach(function(item){
                    if(checked[attachCount]==item.attachId)
                    {
                        fileName=item.attachName;
                        fileName=fileName.split(".");
                        fileName=fileName[0];
                        path="{{url('document/download?index=')}}"+item.attachPath+"&name="+item.attachName;
                        downloadCarrier.download=fileName;

                        downloadCarrier.href=path;
                        downloadCarrier.click();
                    
                    }
                    attachCount++;
                    
                });
            }
        });
        $('#dynamicDownload').remove();
    }



$(document).ready(function() {
    var mailBox=$('#customSort').find(':selected').text();
    var mailStatus=0;
    $('.customer-data-ajax').select2({
        ajax: {
            url: '{{URL::to('enquiry/get-customer-management')}}'+'/'+mailBox+'/'+mailStatus,
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a customer name',
        language: {
            noResults: function() {
                return 'No customers found';
            },
        },
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        //        minimumInputLength: 1,
        templateResult: formatRepo
        });
        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }
            var markup = repo.name;
            return markup;
        }

        var mailBox1=$('#customSort').find(':selected').text();
        var mailStatus1=0;
   $('#insurer_list').select2({
        ajax: {
            url: '{{URL::to('enquiry/get-insurer-management')}}'+'/'+mailBox1+'/'+mailStatus1,
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {

                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a insurer name',
        language: {
            noResults: function() {
                return 'No insurers found';
            },
        },
        allowClear: true,
        escapeMarkup: function (markup) { 
            return markup;
        }, // let our custom formatter work
        templateResult: formatRepo1
        });
            
            function formatRepo1 (repo) {
            if (repo.loading) {
                return repo.text;
            }
            var markup = repo.name;
            return markup;
        }
});

function delete_pop(index)
{
    $('#load_spinner').show();
    $.ajax({
        type: 'post',
        url: "{{url('enquiry/delete-enquiry')}}",
        data:{
            index: index,
            _token: '{{csrf_token()}}'
        },
        success: function(result){
            if(result.status=='success')
            {
                $('#load_spinner').hide();
                $('#message').text("Document deletd successfully");                
                $('#message_popup .cd-popup').addClass('is-visible');
                // loadMoreData(page)
            }
        }
        });
}
function showConfirmation(id)
{
    $('#id').val(id);
    $("#delete_popup .cd-popup").toggleClass('is-visible');
}
$('#submitDoc').on('click', function() {
    $('#load_spinner').show();
    $("#delete_popup .cd-popup").removeClass('is-visible');
    var id = $('#id').val();
    delete_pop(id)

});
function checkRenewal(id)
{
    if($("#renewalCheck").prop('checked') == false )
    {
      $('#renewalCheck').val('');
    }
    if($("#nonrenewalCheck").prop('checked') == false )
    {
        $('#nonrenewalCheck').val('');
    } 
}
</script>
@endpush