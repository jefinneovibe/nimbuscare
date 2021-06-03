
@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        /* .select2-container {
            z-index: 999999999 !important;
        } */
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #D4D9E2 !important;
            border-radius: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #4b515e !important;
        }
        .bootstrap-select .dropdown-toggle:focus, .bootstrap-select .dropdown-toggle:hover {
            outline: none !important;
            border-color: #D4D9E2 !important;
        }
        .reset:focus, .reset:hover {
            background-color: #5086f4;
            box-shadow: 0px 0px 10px 1px rgba(50,101,208,0.5);
            /* border-color: #b82050; */
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            color: #000 !important;
        }
        .display_label {
            /* color: #264cd8; */
            color: #cc3766;
            font-size: 12px;
            margin-left: 20px;
        }
        a:visited, span.MsoHyperlinkFollowed{
            text-decoration: none !important
        }
        a:link, span.MsoHyperlink {
            text-decoration: none !important 
        }
        .open-email-container{
            max-width: 1210px !important;
        }
        /* .cus_select2 .select2-container {
            z-index: 9999999999 !important;
        } */
        .select_dropdown1 .select2-container{
            z-index: 99 !important           
        }
        .search_sec {
            width: 660px;
            padding: 0;
            margin: 0 0px;
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
        .bootstrap-select .dropdown-toggle .filter-option{
            text-transform: capitalize !important;
        }
    </style>
    
    @php
        $role=session('role');
        $sortOrder = session('documentFilter.order');
        $searchKey=session('activeSearchKey');
        if(!isset($seachKey))
        {
            $seachKey="";

        }
       
    @endphp
    @if (session('status'))
        <div class="alert alert-danger alert-dismissible" role="alert" id="error_session">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif

    <input type="hidden" id="total_count" value="{{$countMails}}">
    <input type="hidden" id="after_load" value="">
    <div class="section_details">
        <div class="card_header card_header_flex  clearfix">
            <h3 class="title">Active Queue</h3>
            <div class="right_section">
                <div class="search_sec">
                    <div class="media">
                        <label id="countMails" class="count_label">Count : <span class="count_num" id="spanCount"> {{$countMails}}</span> </label>
                        <button class="btn pull-right custom_btn header_btn" type="button"
                        onclick="customerView()">
                        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;
                            Customer View
                        </button>
                        <button class="btn pull-right custom_btn header_btn" type="button" id="btn_reload" onclick="reloadPage()">
                            <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp;
                             Refresh
                        </button>
                        <div class="media-body" style="    margin-right: 10px;">
                            <form class="search_form" id="custom_search" action="{{url('document/custom-search')}}" method="POST">
                                <input type="text" placeholder="Search.." id="search_key" name="search2" value="{{$searchKey}}">
                                <button type="submit"><i class="fa fa-search"></i></button>
                                <label id="search_key-error" class="error" for="search_key"></label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="sort">
                    <label for="" style="text-transform: capitalize !important;font-size:12px">Sort By:</label>
                    <div class="custom_select header_status" style="margin-right:10px;">
                        <select class="form_input" name="sort_order" id="sort_order" onchange="changeOrder()">
                            <option value="">Select</option>
                            <option value="earliest" {{$sortOrder=='earliest'?'selected':''}}>Earliest Document</option>
                            <option value="latest" {{$sortOrder=='latest'?'selected':''}}>Latest Document</option>
                        </select>
                    </div>
                    <div class="custom_select">
                        
                        <select class="form_input" id="customSort" name="customSort" onchange="switchMail()">
                            @foreach($mailBoxes as $mailBox)
                                @php
                                    $rulerName=session('user_name');
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
                <a href= "{{url('document/emails-to-excel')}}/{{$currentMailBucket->userID}}/{{'1'}}">
                    <button class="btn export_btn waves-effect excel_bt" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="Export To Excel" style="margin-top:6px !important;">
                        <i class="fa fa-file-excel-o"  aria-hidden="true"></i>
                    </button>
                </a>
                <input type="hidden" name="hidden_filter_value" id="hidden_filter_value" value='{{json_encode($currentMailBucket)}}'>
                    <button class="btn export_btn waves-effect" id ="filter" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="showFilter('{{$totalMail}}', 1, '{{$role}}')" data-original-title="Filter" style="margin-top:6px !important;">
                        <i class="material-icons">filter_list</i>
                    </button>
                    <button class="btn export_btn  waves-effect round_btn" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="window.location='{{url("document/closed-documents?box=".$currentMailBucket->_id)}}'" data-original-title="Completed queue">
                        <span class="round_doc">c</span>
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



    


    <!-- filter Popup -->
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
                            <div class="filter__row clearfix">
                                <div class="space__div" id="filter_type_div">
                                    <h4 class="filter_head">Status</h4>
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
                                <div class="space__div" id="filter_type_div">
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
                                <div class="space__div" id="filter_type_div">
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
                            </div>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-6">
                                    <h4 class="filter_head">Customer Name</h4>
                                    <div class="cus_select2 select_dropdown1">
                                        <select class="customer-data-ajax" id="customer_list" name="customer_list[]" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="filter_head">From</h4>
                                    <div class="select_dropdown1 filter_from_select">
                                        <select class="" id="mail_from" name="mail_from" multiple>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-3">
                                    <h4 class="filter_head">From date</h4>
                                    <div class="">
                                        <input id="from_date" class="note_textbox form_input date_font datetimepicker dateclass" name="" placeholder="From date" type="text" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="filter_head">To date</h4>
                                    <div class="">
                                        <input id="to_date" class="note_textbox form_input date_font datetimepicker dateclass" name="" placeholder="To date" type="text" value="" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn_action pull-right" onclick="filter('{{$role}}', 1)" type="button">OK</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- filter Popup ends -->



    <!-- post customer Popup -->
    <div id="post_customer">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><h1 id="success_message">Post To Customer</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form_group mail_tag">
                                                <label class="form_label">To <span>*</span></label> 
                                                <input type="text" style="border-radius: 4px;padding: 6px;width:100%;" name="post_to" id="post_to">
                                                <div class="error" id="blank_mail_id"></div>

                                                <div id="post_id_error">
                                                    
                                                </div>
                                        </div>
                                        <input type="hidden" id="hdn_post_customer">
                                        <input type="hidden" id="hdn_attachment_count">
                                        <input type="hidden" id="hdn_attachment_id">
                                        <input type="hidden" id="hdn_customer_id">
                                        <input type="hidden" id="hdn_mailCount">
                                        <input type="hidden" id="hdn_selection">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form_group mail_tag">
                                            <label class="form_label">Cc <span></span></label> 
                                            <input type="text" style="border-radius: 4px;padding: 6px;width:100%;" name="post_cc" id="post_cc">
                                            <div id="post_cc_error">
                                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="post_customer_attachments" >         
                                </div>
                                <div id="post_selected_to_customer">
                                </div>

                            </div>
                    </div>
                    <div class="modal_footer">
                        <button id="btn_post_customer" class="btn btn-primary btn_action pull-right" type="button" onclick="postCustomer()">Send</button>
                        <button id="btn_post_selected_to_customer" class="btn btn-primary btn_action pull-right" type="button" onclick="postSelectedToCustomer()">Send</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button" onclick="cancelPostCustomer()" >Cancel</button>
                    </div>
                    <a class="cd-popup-close img-replace" onclick="cancelPostCustomer()"></a>
                </div>
            </form>
        </div>
    </div> <!-- post customer Popup ends -->



    <!-- comment Popup -->
    <div id="comment"> 
        <div class="cd-popup comment_modal">
            <form method="post">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        <div class="clearfix">
                        </div>
                        <div class="content_spacing">
                            <div class="row">
                                <div class="col-md-12">
                                    <span><h1 id="success_message">Comments</h1></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="hdnEmailId"/>
                                    <div class="chat_main comment_chat_main">
                                        <ul id="chat" style="overflow:auto">
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
                    <a class="cd-popup-close img-replace"></a>
                </div>
            </form>
        </div>
    </div> <!-- comment Popup ends -->


    <!-- forward email Popup -->
    <div id="forward_email">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container">
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
                </div>
            </form>
        </div>
    </div> <!-- forward email Popup ends -->   
            

    <!-- open email Popup -->
    <div id="open_email">
        <div class="cd-popup" >
            <form id="showhow" style="z-index: -1;" method="post">
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
                                        <p class="mail_details mail_details_bottom">
                                            <span class="customer_email" id="mail_from" ></span>
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
                    <a class="cd-popup-close img-replace"></a>
                </div>
            </form>
        </div>
    </div> <!-- open email Popup ends -->   

    <div id="testing">

    </div>

    {{-- message_popup pop up --}}
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
                                        {{-- <input class="customer_id" name="customer_id" id="customer_id" value="5c92006b6e3a9229c55b00d3" type="hidden"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    {{-- <button type="button" class="btn btn-primary btn-link btn_cancel">Cancel</button> --}}
                    <button class="btn btn-primary btn_action" type="button" onclick="hideMessage()" id="message_remove">OK</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- message_popup pop up --}}

    {{-- confirmation --}}
    <div id="mdl_confirm">
        <div class="cd-popup">
            <div class="cd-popup-container" style="max-width: 654px;">
            {{-- <form id="add_files" method="POST" enctype="multipart/form-data"> --}}
                <div class="">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 name="message" id="message" style="margin:0">Are you sure want to complete this document ?</h3>
                                        <input type="hidden" id="hdn_mailCount">
                                        <input type="hidden" id="hdn_mailId">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn_action" style="background-color:gray" onclick="hideMessage()" >Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="message_remove" onclick="closeConfirmed()">Complete</button>
                </div>
                {{-- </form> --}}
                <div>
                    {{-- <a href="#0" class="cd-popup-close img-replace"></a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- confirmation --}}

    {{-- ajax loader for delayed loading --}}
    <div class="ajax-load text-center" style="display:none">
        <p><img src="{{URL::asset('img/loader.gif')}}">Loading More Tasks</p>
    </div>
    {{-- ajax loader for delayed loading --}}


    <style>
        
        .section_details{
            max-width: 100%;
        }
        /* .select2-container {
            z-index: 999999999;
        } */
        .select2.select2-container.select2-container--default {
            width: 100%!important;
        }
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
        .header_status .dropdown {
            width: 140px !important;
        }
        .sort .custom_select .dropdown {
            /* width: 168px; */
            width: 246px;
            border: 1px solid #dddddd;
            padding: 7px 0 0 15px;
        }
        .filter_popup{
            max-width: 980px !important;
            width: 100% !important
        }
        .cus_select2 .select2:last-child{
            display: none;
        }
        .select2-container {
            z-index: 99999 !important;
        }
        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999999 !important;
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
        .forSelect {
            /*dummy*/
        }
    </style>

@endsection


@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<style>
    html, body {
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
    $(".js-example-basic-multiple").select2();
</script>
<script>
    $(".js-example-basic-multiple-post").select2();
</script>

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

<script>

    var paginationFactor='{{Config::get('documents.pagination_factor')}}';
    paginationFactor=Number(paginationFactor);
    var fromDate;
    var toDate;
    {{-- fromDate = sessionStorage.getItem('doc.fromDate'); --}}
    {{-- toDate = sessionStorage.getItem('doc.toDate');  --}}
    $(function(){
        var mailBox=$('#customSort').find(':selected').text();
        var mailStatus=1;
        $('#customer_list').select2({
            ajax: {
                url: '{{URL::to('document/get-customer-management')}}'+'/'+mailBox+'/'+mailStatus,
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
                    return 'No Customers found';
                },
            },
            // allowClear: true,
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            //        minimumInputLength: 1,
            templateResult: formatReporting
        });
        // function formatReporting (repo) {
        //     if (repo.loading) {
        //         return repo.text;
        //     }
        //     var markup = repo.name;
        //     return markup;
        // }
    });

    function formatReporting (repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup = repo.name;
        return markup;
    }

    $('#from_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
    });
    $('#to_date').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false
    });
    $('#from_date').on('dp.change',function(e){
        $('#to_date').data('DateTimePicker').minDate(e.date);
    });
    $('#to_date').on('dp.change',function(e){
        $('#from_date').data('DateTimePicker').maxDate(e.date);
    });

    $('#mail_from').select2({
        ajax: {
            url: '{{URL::to('document/get-mail-from-filter')}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    key: params.term, // search term
                    page: params.page,
                    status: 1,
                    mailBox: $('#customSort').val()
                };
            },
            processResults: function (data, params) {
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
        placeholder: "Search mail id",
        language: {
            noResults: function() {
                return 'No mail ids found';
            },
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatFrom,
        templateSelection: formatFromSelection
    });

    function formatFrom (repo) {
        if (repo.loading) {
            return repo.text;
        }
        if(repo.text!='')
        {
            var markup = repo.text;
        }
        else{
            var markup = repo.text;
        }
        return markup;
    }
    function formatFromSelection (repo) {
        if(repo.id && repo.text)
        {
            return repo.text;

        }else{
            return repo.text;

        }
    }

    function initialFilterColor()
    {
        var user=sessionStorage.getItem('previouisBox');
        var oldCache="{{session('oldCache')}}";
        if(oldCache!=user)
        {
            $('#filter').css('color','');
            sessionStorage.removeItem('doc.statusFilter');
            sessionStorage.removeItem("doc.customersFilter");
            sessionStorage.removeItem("doc.agentsFilter");
            sessionStorage.removeItem("doc.customerAgentsFilter");
            sessionStorage.removeItem("doc.from");
            sessionStorage.removeItem('doc.fromDate');
            sessionStorage.removeItem('doc.toDate');
        }
        sessionStorage.setItem('previouisBox','{{$user}}');
    }

    function filterColorChange()
    {
        var cust=[];
        var agen=[];
        var stat=[];
        var custAgent=[];

        var mailFrom= "";
        var mailFrom= sessionStorage.getItem("doc.from");
        var fromDate = sessionStorage.getItem('doc.fromDate');
        var toDate = sessionStorage.getItem('doc.toDate');
        mailFrom= mailFrom? JSON.parse(mailFrom) : null;
        fromDate= fromDate? JSON.parse(fromDate) : null;
        toDate= toDate? JSON.parse(toDate) : null;

        stat=JSON.parse(sessionStorage.getItem("doc.statusFilter"));
        if(stat==null)
        {
            var stat=[];
        }
        cust=JSON.parse(sessionStorage.getItem("doc.customersFilter"));
        if(cust==null)
        {
            var cust=[];
        }
        custAgent=JSON.parse(sessionStorage.getItem("doc.customerAgentsFilter"));
        if(custAgent==null)
        {
            var custAgent=[];
        }
        agen=JSON.parse(sessionStorage.getItem("doc.agentsFilter"));
        if(agen==null)
        {
            var agen=[];
        }
        if(cust.length || agen.length || stat.length || custAgent.length || mailFrom || fromDate || toDate)
        {
            $('#filter').css('color','red');
        }
        else
        {
            $('#filter').css('color','');
        }
        
    }

    /**@comment
    to change the sort order.
    */
    function changeOrder()
    {
        $('#load_spinner').show();
        var order = $('#sort_order').val();
        var mailBox = $('#customSort').val();
        $.ajax({
            type: "post",
            url: "{{url('document/dynamic-sort')}}",
            data:
            {
                order: order,
                mailBox: mailBox,
                status: 1,
                _token: "{{csrf_token()}}"
            },
            success: function(result)
            {
                $('#load_spinner').hide();
                console.log("success");
                $("#post-data").html("");
                $('#countMails').val(result.countMails);
                $("#total_count").val(result.countMails);
                $("#post-data").append(result.documentOperation);
                $('#after_load').val('loadComplete');
                page=0;
                $('[data-toggle="tooltip"]').tooltip();
            },
            error: function(response)
            {
                $('#load_spinner').hide();
                console.log("failed");
                // console.log(response);
            }
        });
    }

    function reloadPage() {
        $('#btn_reload').attr('disabled', true);
        location.reload();
        setTimeout(function(){
            $('#btn_reload').attr('disabled', false);
        }, 6000);
    }
    var page = 0;
    $(document).ready(function(){
        filterColorChange();
        initialFilterColor();
        setTimeout(function(){
            $('#error_session').fadeOut('slow', function(){
                $('#error_session').hide();
            });
        },10000);
        
        $('#custom_search').validate({
            submitHandler: function(form){
                $('#load_spinner').show();
                $('#after_load').val('loading');
                $.ajax({
                    type: form.method,
                    url: form.action,
                    data: 
                    {
                        _token: '{{csrf_token()}}',
                        key: $('#search_key').val(),
                        credential: $('#customSort').val(),
                        status: 1
                    },
                    success: function(result)
                    {
                        $('#load_spinner').hide();
                        $("#post-data").html("");
                        $("#post-data").append(result.documentOperation);
                        $('#after_load').val('loadComplete');
                        $("#total_count").val(result.countMails);
                        $("#spanCount").html(result.countMails);
                        page=0;
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });
            }
        });
        $('#forward_to').tagsinput('item');
        $('#forward_cc').tagsinput('item');

        
        loadMoreData(0);
        
    });

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            if($('#after_load').val()!='loading')
            {
                page+=paginationFactor;
                if(page<$('#total_count').val())
                {
                    loadMoreData(page);
                }
            }
        }
    });

    function loadMoreData(page)
    {
        $('.ajax-load').show();
        var mailSwitch=$('#customSort').val();
        var search=$('#search_key').val();
        $('#after_load').val('loading');
        $.ajax(
        {
            url: "{{url('document/view-emails')}}",
            type: "get",
            data:{
                page:page,
                search2:search,
                index: mailSwitch
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
    
    var openedWindow;

    function viewAttachment(path)
    {
        openedWindow= window.open(path,'_blank','width=700, height=800, top=70, left=100, resizable=1, menubar=yes', false);
        // console.log(openedWindow);
    }

    function downloadAttachment(path, add)
    {
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip('enable');
        window.location.href="{{url('document/download?index=')}}"+path+add;
    }
    function addNewCustomer()
    {
        window.open("{{url('customers/create')}}", 'New Window','top=70,left=400,width=1300,height=800,menubar=yes');
    }

    function editCustomer(index)
    {
        var customer=$('#customer_'+index).find(':selected').val();
        if(customer!="")
        {
            var url="{{url('customers/')}}/"+customer+"/edit";
            window.open(url, 'New Window','top=70,left=400,width=1300,height=800,menubar=yes');
        }
    }

    function showAgent(index)
    {
        var customer=$('#customer_'+index).find(':selected').val();
        if(customer!="")
        {
            $('#edit_customer_'+index).show();
            $('#add_customer_'+index).hide();
        }
        else
        {
            $('#edit_customer_'+index).hide();
            $('#add_customer_'+index).show();
        }
        $.ajax({
            type:"post",
            url: "{{url('document/get-agent-details')}}",
            data: 
            {
                _token:'{{csrf_token()}}',
                customer: customer,
            },
            success: function(result)
            {
                result=JSON.parse(result);
                var name=result.agent.name;
                var id=result.agent.id.$oid;
                $('#no_agent_details_'+index).text("");
                $('#agent_detail_'+index).html(name);
                $('#cust_agnet_'+index).val(id);
                checkClosure(index);
            }
        });
        
    }


    function customerView()
    {
        window.open("{{url('document/admin-customer-view')}}","New window","top=70,left=400,height=800,width=1400");
    }

    function closeTab(index)
    { 
        $('#'+index).collapse('hide');
    }

    function showFilter(totalMail, mailStatus, role)
    {   
        var mailBucket = $('#hidden_filter_value').val();
        $('#load_spinner').show();
        var customerId;
        var customerName;
        var agentId;
        var length;
        var agentName;
        var i=0;
        var count=0;
        var selection="status";
        var stock=[];
        var mailBox=$('#customSort').find(':selected').text();
        mailBucket=JSON.parse(mailBucket);
        var statusList=mailBucket.statusAvailable;
        var length=statusList.length;
        var customerStore=sessionStorage.getItem("doc.customersFilter");
        var fromStore=null;
        var fromDate="";
        var toDate="";
        fromStore = sessionStorage.getItem("doc.from");
        fromStore = fromStore?JSON.parse(fromStore):null;
        fromDate = sessionStorage.getItem('doc.fromDate');
        fromDate = fromDate?JSON.parse(fromDate):null;
        toDate = sessionStorage.getItem('doc.toDate');
        toDate = toDate?JSON.parse(toDate):null;
        customerStore=JSON.parse(customerStore);
        $.ajax({
            type: 'post',
            url: "{{url('document/filter-options')}}",
            data:
            {
                _token:'{{csrf_token()}}',
                mailbox: mailBox,
                status: mailStatus,
                role: role,
                customers: customerStore
            },
            success: function(result)
            {
                $('#status_filter').empty();
                $('#customer_filter').empty();
                $('#agent_filter').empty();
                $('#customer_agent_filter').empty();
                var check="";
                var customers=result[0];
                var agents=result[1];
                var customerAgents=result[2];
                var statusStore=sessionStorage.getItem("doc.statusFilter");
                statusStore=JSON.parse(statusStore);
                var agentStore=sessionStorage.getItem("doc.agentsFilter");
                agentStore=JSON.parse(agentStore);
                var customerAgentStore=sessionStorage.getItem("doc.customerAgentsFilter");
                customerAgentStore=JSON.parse(customerAgentStore);
                for(i=0;i<length;i++)
                {
                    if(statusList[i].closureProperty==0)
                    {
                        if(statusStore)
                        if(statusStore.includes(statusList[i].statusName))
                        check="checked";
                        $('#status_filter').append(
                            '<div class="custom_checkbox">'+
                                '<input type="checkbox" '+check+' value="'+statusList[i].statusName+'" id="cbx_status_'+count+'" name="status_list[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">'+
                                '<label for="cbx_status_'+count+'" class="cbx">'+
                                    '<span style="min-width: 18px;">'+
                                        '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                            '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                        '</svg>'+
                                    '</span>'+
                                    '<span id="sp_status_'+count+'">'+statusList[i].statusName+'</span>'+
                                '</label>'+
                            '</div>'
                        );
                        count++;
                        check="";
                    }
                }
                
                stock=[];
                count=0;
                selection="agent";
                length=agents.length;
                for(i=0;i<length;i++)
                {
                    agentId=agents[i].assaignedTo.agentId.$oid;
                    if(! agentId)
                    {
                        agentId=(agents[i].assaignedTo.agentId)? agents[i].assaignedTo.agentId: null;
                    }
                    
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
                                    '<span style="min-width: 18px;">'+
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
                                    '<span style="min-width: 18px;">'+
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
                stock=[];
                count=0;
                if(customers)
                {
                    $('#customer_list').html("");
                    $('#customer_list').val("").trigger('change');
                    customers.forEach(function(item){
                        $('#customer_list').append(
                            '<option value="'+item._id+'" selected>'+item.fullName+'</option>'
                        );
                    });
                    $('#customer_list').trigger('change');
                }
                if(fromStore) {
                    $('#mail_from').html("");
                    $('#mail_from').val(null).trigger('change');
                    fromStore.forEach(function(item) {
                        var selected= new Option(item,item,true,true);
                        $('#mail_from').append(selected);

                    });
                    $('#mail_from').trigger('change');
                }
                $('#from_date').data("DateTimePicker").date(fromDate);
                $('#to_date').data("DateTimePicker").date(toDate);

                $('#load_spinner').hide();
                $('#document_mail_filter .cd-popup').addClass('is-visible');
            }
        });
    }

    function checkSelection(type, index)
    {
        var flag=0;
        if(type=='status') {
            if (! $('#cbx_status_'+index).is(':checked')) {
                $('#status_all').prop('checked', false);
            } else if($('#cbx_status_'+index).is(':checked')) {
                $('input[name="status_list[]"]').each(function(item) {
                    if (! $(this).is(':checked')) {
                        flag++;
                    }
                });
                if (! flag) {
                    $('#status_all').prop('checked', true);
                }
            }
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
        }

    }

    function resetFilter()
    {
        $('#status_all').attr('checked',false);
        $('#customer_all').attr('checked',false);
        $('#agent_all').attr('checked',false);
        $('#customer_agent_all').attr('checked',false);
        $('#customer_agent_filter input:checkbox').attr('checked',false);
        $('#status_filter input:checkbox').attr('checked',false);
        $('#agent_filter input:checkbox').attr('checked',false);
        $('#customer_filter input:checkbox').attr('checked',false);
        $('#customer_list').val("").trigger('change');
        $('#mail_from').val(null).trigger('change');
        $('#from_date').data("DateTimePicker").clear();
        $('#to_date').data("DateTimePicker").clear();

    }

    function filter(role, mailStatus)
    {
        $('#document_mail_filter .cd-popup').removeClass('is-visible');
        $('#load_spinner').show();
        $('#after_load').val('loading');
        var statusDetails=[];
        var customerDetails=[];
        var agentDetails=[];
        var customerAgentDetails=[];
        var statusLength=$('input[name="status_list[]"]').length;
        var agentsLength=$('input[name="agent_list[]"]').length;
        var customerAgentsLength=$('input[name="customer_agent_list[]"]').length;
        
        var mailFrom = $('#mail_from').val();
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        {{-- console.log(fromDate, toDate, JSON.stringify(fromDate), JSON.stringify(toDate)); --}}
        sessionStorage.removeItem('doc');
        sessionStorage.setItem('doc.from',JSON.stringify(mailFrom));
        sessionStorage.setItem('doc.fromDate', JSON.stringify(fromDate));
        sessionStorage.setItem('doc.toDate', JSON.stringify(toDate));
        for(i=0;i<statusLength;i++)
        {
            if($('#cbx_status_'+i).is(':checked'))
            statusDetails.push($('#cbx_status_'+i).val());
        }
        sessionStorage.setItem('doc.statusFilter',JSON.stringify(statusDetails));
        customerDetails=$('#customer_list').val();
        sessionStorage.setItem('doc.customersFilter',JSON.stringify(customerDetails));

        for(i=0;i<agentsLength;i++)
        {
            if($('#cbx_agent_'+i).is(':checked'))
            agentDetails.push($('#cbx_agent_'+i).val());
        }
        sessionStorage.setItem('doc.agentsFilter',JSON.stringify(agentDetails));
        for(i=0;i<customerAgentsLength;i++)
        {
            if($('#cbx_customer_agent_'+i).is(':checked'))
            customerAgentDetails.push($('#cbx_customer_agent_'+i).val());
        }
        sessionStorage.setItem('doc.customerAgentsFilter',JSON.stringify(customerAgentDetails));
        $.ajax({
            type:'post',
            url: "{{url('document/custom-filter')}}",
            data: 
            {
                _token:'{{csrf_token()}}',
                statusDetails: statusDetails,
                customerDetails: customerDetails,
                agentDetails: agentDetails,
                customerAgentDetails: customerAgentDetails,
                status: mailStatus,
                user:'{{$user}}',
                role: role,
                
                mailFrom: mailFrom,
                fromDate: fromDate,
                toDate: toDate
            },
            success: function(result)
            {
                $('#load_spinner').hide();
                $('#matter').empty();
                $("#post-data").html("");
                $("#post-data").append(result.documentOperation);
                $('#after_load').val('loadComplete');
                // $('#matter').html(result);
                page=0;
                $("#total_count").val(result.countMails);
                $("#spanCount").html(result.countMails);
                filterColorChange();
                $('[data-toggle="tooltip"]').tooltip();
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
                $('#status_all').attr('checked',false);
                // console.log("no");
                }
            }
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
            }
        }
        else if(index=='agent')
        {
            var agentsLength=$('input[name="agent_list[]"]').length;
            if($('#agent_all').is(':checked'))
            {
                {{-- $('#agent_filter input:checkbox').attr('checked',true);
                for(i=0;i<agentsLength;i++)
                {
                    if(!$('#cbx_agent_'+i).is(':checked'))
                    if($('#cbx_agent_'+i).click())
                    {
                    // console.log("first");
                    }
                } --}}
                $('input[name="agent_list[]"]').prop('checked',true);
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
                {{-- $('#customer_agent_filter input:checkbox').attr('checked',true);
                for(i=0;i<customerAgentsLength;i++)
                {
                    if(!$('#cbx_customer_agent_'+i).is(':checked'))
                    if($('#cbx_customer_agent_'+i).click())
                    {
                    // console.log("first");
                    }
                } --}}
                $('input[name="customer_agent_list[]"]').prop('checked',true);

            }
            else
            {
                if($('#customer_agent_filter input:checkbox').attr('checked',false)){}
                // console.log("no");
            }
        }
    }

    
        
    var forwardsetting=0;
    var forwardCcSetting=0;
    var wrongTags=[];
    var wrongCcTages=[];
    var emptyMail=0;

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
    $('#post_to').on('beforeItemAdd',function(event){
        var tag=event.item;
        if(!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i).test(tag))
        {
            forwardsetting++;
            wrongTags.push(tag);
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#post_id_error').append(
                '<div id="'+id+'" ><label class="error"> "'+tag+'" is not a valid mail id </label></div>'
            );
        }
    });
    $('#post_to').on('itemRemoved',function(event){
        if(wrongTags.includes(event.item) && event.item!="")
        {
            var tag=event.item;
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#post_id_error #'+id).fadeOut('slow',function(){
                forwardsetting--;
                $('#post_id_error #'+id).remove();
                var index = wrongTags.indexOf(event.item);
                if (index > -1) {
                    wrongTags.splice(index, 1);
                }
            });
        }
    });
    $('#post_cc').on('beforeItemAdd',function(event){
        var tag=event.item;
        if(!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i).test(tag))
        {
            forwardCcSetting++;
            wrongCcTages.push(tag);
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#post_cc_error').append(
                '<div id="'+id+'" ><label class="error"> "'+tag+'" is not a valid mail id </label></div>'
            );
        }
    });
    $('#post_cc').on('itemRemoved',function(event){
        if(wrongCcTages.includes(event.item) && event.item!="")
        {
            var tag=event.item;
            var rpldid=tag.replace(/[^\w\s]/gi,"_");
            var id=rpldid.replace(/[ ]/gi,"_");
            $('#post_cc_error #'+id).fadeOut('slow',function(){
                forwardCcSetting--;
                $('#post_cc_error #'+id).remove();
                    
                var index = wrongTags.indexOf(event.item);
                if (index > -1) {
                    wrongCcTages.splice(index, 1);
                }
            });
        }
    });
    $('#post_to').on('itemAdded', function(event) {
        $('#blank_mail_id').html("");
    });

    function setForwardTo(index)
    {
        forwardsetting=0;
        forwardCcSetting=0;
        wrongTags=[];
        wrongCcTages=[];
        emptyMail=0;
        $('#load_spinner').show();
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
        $('#forward_btn').attr('disabled', true);
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
            $('#forward_btn').attr('disabled', false);
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
            url: "{{url('document/forward-document')}}",
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
                    $('#message').text("Sorry! Failed to forward mail at the moment");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
            $('#forward_btn').attr('disabled', false);
            }
        });
    }

    function hideMessage()
    {
        $('#message_popup .cd-popup').removeClass('is-visible');
        $('#mdl_confirm .cd-popup').removeClass('is-visible');
        $('#message').text(""); 
        $('#message').html("");               
    }

    function postCustomer()
    {
        $('#btn_post_customer').attr('disabled', true);
        $('#post_customer .cd-popup').removeClass('is-visible');
        $('#load_spinner').show();
        var index=$('#hdn_post_customer').val();
        var attachment=$('#hdn_attachment_count').val();
        var mailCount=$('#hdn_mailCount').val();
        var customer=$('#hdn_customer_id').val();
        if($('#post_to').val()!="")
        {
            var mailTo=$('#post_to').val().split(',');
        }
        else{
            $('#blank_mail_id').html('<label class="error">please enter email id </label>');
            $('#load_spinner').hide();
            $('#post_customer .cd-popup').addClass('is-visible');
            $('#btn_post_customer').attr('disabled', false);
            return;

        }
        if($('#post_cc').val()!="")
        {
            var mailCc=$('#post_cc').val().split(',');
        }
        else
        {
            var mailCc="";
        }
        // if(forwardsetting>0 || forwardCcSetting>0)
        // {
        //     $('#load_spinner').hide();
        //     return;
        // }
        var attachmentId=$('#hdn_attachment_id').val();
        var checked=[];
            $.ajax({
                type: 'post',
                url: "{{url('document/post-customer')}}",
                data: 
                {
                    _token: '{{csrf_token()}}',
                    mailIndex: index,
                    attachmentIndex: attachment,
                    customerIndex: customer,
                    mailTo: mailTo,
                    mailCc: mailCc,
                    attachmentId:attachmentId
                },
                success: function(result)
                {
                    $('#load_spinner').hide();
                    if(result==1)
                    {
                        // $('#attach_name_'+mailCount+attachment).html("");
                        $('#indicator_'+mailCount+attachment).html("");
                        $('#indicator_'+mailCount+attachment).append(
                            // '<span id="indicator_'+attachment+'">'+
                                    '<span class="post_status">'+
                                        '<span class="status_textsize">SHARED</span>'+
                                    '</span>'
                            // '</span>'
                        );
                        
                        $('#message').text("Documents posted successfully");
                        $('#message_popup .cd-popup').addClass('is-visible');
                        $('#btn_post_customer').attr('disabled', false);
                    }
                }
            });
    }

    function cancelPostCustomer()
    {
        $('#post_to').val("");
        $('#load_spinner').hide();
        // $('#post_to').tagsinput('removeAll');
        $('#post_to').tagsinput('destroy');
    }

    function showPostCustomer(index, attachmentId,mailCount,count)
    {
        forwardsetting=0;
        forwardCcSetting=0;
        wrongTags=[];
        wrongCcTages=[];
        emptyMail=0;
        // wrongTags=[];
        $('#btn_post_customer').attr('disabled', false);
        $('#post_to').tagsinput('removeAll');
        $('#post_to').tagsinput('destroy');
        $('#post_cc').tagsinput('removeAll');
        $('#post_cc').tagsinput('destroy');
        $('#blank_mail_id').html("");
        $('#post_id_error').html("");
        $('#btn_post_selected_to_customer').hide();
        $('#btn_post_customer').show();
        var customerId=$('#customer_'+mailCount).find(':selected').val();
        if(! customerId || customerId==undefined)
        {
            $('#message').text("Please select customer name");                
            $('#message_popup .cd-popup').addClass('is-visible');
            return;
        }
        $('#load_spinner').show();    
        $('#hdn_post_customer').val(index);
        $('#hdn_attachment_count').val(count);
        $('#hdn_mailCount').val(mailCount);
        $('#hdn_attachment_id').val(attachmentId);
        $('#hdn_customer_id').val(customerId);
        $.ajax({
            type: 'post',
            url: "{{url('document/show-post-costomer')}}",
            data:
            {
                _token: "{{csrf_token()}}",
                index:index,
                customerIndex: customerId
            },
            success: function(result)
            {
                if(result==0)
                {
                    $('#message').text("The selected customer does not exist !");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                    $('#load_spinner').hide();
                    return;
                }
                if(result=="")
                {
                    $('#post_to').val("");
                }
                else if(result!="")
                {
                    if(result[0]!=null)
                    {
                        $('#post_to').val(result[0].toString());
                    }
                    $('#post_customer_attachments').html("");
                    $('#post_selected_to_customer').html("");
                    if(result[2]!="")
                    {
                        $('#post_cc').val(result[2].toString());
                    }
                }
                
                $('#load_spinner').hide();
                $('#post_to').tagsinput('item');
                $('#post_cc').tagsinput('item');

                var attachCount=0;
                result[1].forEach(function(attach){
                    var check=(attachmentId==attach.attachId)? "checked" : "";
                    if(attach.updatedName==null)
                    {
                        attach.updatedName="no name updated";
                    }
                    var fileName=attach.attachName;
                    if(attach.attachId==attachmentId)
                    {

                    $('#post_customer_attachments').append(
                        '<div class="custom_checkbox">'+
                            '<i class="fa fa-check-square" style="font-size:20px;color:#264cd8;cursor: pointer;"></i> '+
                            '<span class="attach_txt"> '+fileName+'    ----updated name: '+attach.updatedName+'</span>'+
                        '</div>'
                    );
                    }
                    attachCount++;
                });
                // $('#post_to').tagsinput('item');
                $('#post_customer .cd-popup').addClass('is-visible');
            }
        });
    }

    function showPostSelected(mailCount, mailId)
    {
        forwardsetting=0;
        forwardCcSetting=0;
        wrongTags=[];
        wrongCcTages=[];
        emptyMail=0;
        $('#load_spinner').show();
        // wrongTags=[];
        var selection=[];
        $('#btn_post_selected_to_customer').attr('disabled', false);
        $('#post_to').tagsinput('removeAll');
        $('#post_to').tagsinput('destroy');
        $('#post_cc').tagsinput('removeAll');
        $('#post_cc').tagsinput('destroy');
        $('#blank_mail_id').html("");
        $('#post_id_error').html("");
        $('#post_selected_to_customer').html("");
        $('#post_customer_attachments').html("");
        $('#btn_post_customer').hide();
        $('#btn_post_selected_to_customer').show();
        var customerId=$('#customer_'+mailCount).find(':selected').val();
        if(! customerId || customerId==undefined)
        {
            $('#message').text("Please select customer");
            $('#load_spinner').hide();
            $('#message_popup .cd-popup').addClass('is-visible');
            return;
        }
        $('#hdn_post_customer').val(mailId);
        $('#hdn_customer_id').val(customerId);
        $('#hdn_mailCount').val(mailCount);
        $("input[name='attachment_checkbox_"+mailCount+"[]']").each(function(){
            if($(this).is(':checked'))
            {
                selection.push($(this).val());
            }
            else
            {
                selection.push("");
            }
        });
        $('#hdn_selection').val(selection);
        $.ajax({
            type:"post",
            url: "{{url('document/show-post-costomer')}}",
            data:
            {
                _token: '{{csrf_token()}}',
                index: mailId,
                customerIndex: customerId
            },
            success: function(result)
            {
                if(result==0)
                {
                    $('#message').text("The selected customer does not exist !");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                    $('#load_spinner').hide();
                    return;
                }
                if(result=="")
                {
                    $('#post_to').val("");
                }
                else if(result!="")
                {
                    if(result[0]!=null)
                    {
                        $('#post_to').val(result[0].toString());
                    }
                    $('#post_customer_attachments').html("");
                    $('#post_selected_to_customer').html("");
                }
                if(result[2]!="")
                {
                    $('#post_cc').val(result[2].toString());
                }
                // $('#load_spinner').hide();
                $('#post_to').tagsinput('item');
                $('#post_cc').tagsinput('item');
                var attachCount=0;
                result[1].forEach(function(attach){
                    if(selection.includes(attach.attachId))
                    {
                        if(attach.updatedName==null)
                        {
                            attach.updatedName="no name updated";
                        }
                        var fileName=attach.attachName;
                        // fileName=fileName[fileName.length-1];

                        $('#post_customer_attachments').append(
                            '<div class="custom_checkbox">'+
                                '<i class="fa fa-check-square" style="font-size:20px;color:#264cd8;cursor: pointer;"></i> '+
                                '<span class="attach_txt"> '+fileName+'    ----updated name: '+attach.updatedName+'</span>'+
                            '</div>'
                        );
                    }
                    attachCount++;
                });
                $('#load_spinner').hide();    
                $('#post_customer .cd-popup').addClass('is-visible');
            }
        });
    }

    function postSelectedToCustomer()
    {
        $('#btn_post_selected_to_customer').attr('disabled', true);
        $('#post_customer .cd-popup').removeClass('is-visible');
        var customerId=$('#hdn_customer_id').val();
        var id=$('#hdn_post_customer').val();
        var count=$('#hdn_mailCount').val();
        if(customerId=="")
        {
            $('#message').text("Please select customer"); 
            $('#btn_post_selected_to_customer').attr('disabled', false);
            $('#message_popup .cd-popup').addClass('is-visible');
            return;
        }

        var index=$('#hdn_post_customer').val();
        var attachment=$('#hdn_attachment_count').val();
        if($('#post_to').val()!="")
        {
            var mailTo=$('#post_to').val().split(',');
        }
        else{
            $('#blank_mail_id').html('<label class="error">please enter email id </label>');
            $('#btn_post_selected_to_customer').attr('disabled', false);
            $('#post_customer .cd-popup').addClass('is-visible');
            return;

        }
        if($('#post_cc').val()!="")
        {
            var mailCc=$('#post_cc').val().split(',');
        }
        else
        {
            var mailCc="";
        }

        if(forwardsetting>0 || forwardCcSetting>0)
        {
            $('#btn_post_customer').attr('disabled', false);
            return;
        }
        $('#load_spinner').show();
        var selection=[];
        $("input[name='attachment_checkbox_"+count+"[]']").each(function(){
            if($(this).is(':checked'))
            {
                selection.push($(this).val());
            }
            else
            {
                selection.push("");
            }
        });
        $.ajax({
            type: 'post',
            url: "{{url('document/post-selected-to-customer')}}",
            data: 
            {
                _token: "{{csrf_token()}}",
                selects: selection,
                index: id,
                customer: customerId,
                mailTo: mailTo,
                mailCc:mailCc
            },
            success: function(result)
            {
                // console.log(result);
                $('#load_spinner').hide();
                if(result[0]==1)
                {
                    result[1].forEach(function(item){
                        // $('#attach_name_'+count+item).html("");
                        $('#indicator_'+count+item).html("");
                        $('#indicator_'+count+item).append(
                            // '<span id="indicator_'+item+'">'+
                                    '<span class="post_status">'+
                                        '<span class="status_textsize">SHARED</span>'+
                                    '</span>'
                            // '</span>'
                        );
                    });
                    
                    $('#message').text("Documents posted successfully");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
                else
                {
                    $('#message').text("Failed post");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                }
                $('#btn_post_selected_to_customer').attr('disabled', false);
            }
        });
    }

    function showMail(index)
    {
        $('#load_spinner').show();
        $.ajax({
                method: 'post',
                url: "{{url('document/get-mail-content')}}",
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
        var mailSwitch=$('#customSort').val();
        $('#after_load').val('loadComplete');
        window.location.href='{{url("document/view-emails?index=")}}'+mailSwitch+'&oldUser={{$user}}';
    }

    function needConfirmation(index, id)
    {
        $('#hdn_mailCount').val(index);
        $('#hdn_mailId').val(id);
        $('#mdl_confirm .cd-popup').addClass('is-visible');

    }

    function closeConfirmed()
    {
        $('#mdl_confirm .cd-popup').removeClass('is-visible');
        var index= $('#hdn_mailCount').val();
        var id= $('#hdn_mailId').val();
        saveMail(index, id);
    }

    function saveMail(index)
    {
        $('#load_spinner').show();
        var cust=$('#customer_'+index).find(':selected').val();
        var status=$('#status_'+index).find(':selected').val();
        var agent=$('#agent_'+index).find(':selected').val();
        if(status== 1)
        {
            if(! cust) {
                $('#message').text("Please select customer");                
                $('#message_popup .cd-popup').addClass('is-visible');
                $('#load_spinner').hide();
                return;
            } else if(! agent || agent== "999") {
                $('#message').text("Please select assignee");                
                $('#message_popup .cd-popup').addClass('is-visible');
                $('#load_spinner').hide();
                return;
            }
        }
        var statusText=$('#status_'+index).find(':selected').text();
        if (statusText=="Select Status")
        {
            statusText="";
        }
        if(status==0)
        {
            $('#load_spinner').show();
        }
        $('.error').text("");
        var custAgentId=$('#cust_agnet_'+index).val();
        var custAgentName=$('#agent_detail_'+index).text();
        var note1=$('#note_1_'+index).val();
        var note2=$('#note_2_'+index).val();
        var note3=$('#note_3_'+index).val();
        var customer=$('#customer_'+index).find(':selected').val();
        // var agent=$('#agent_'+index).find(':selected').val();
        var updateNameNotPosible=0;
        var updateNames=[];
        
        $("input[name='attachment_"+index+"[]']").each(function(){
            updateNames.push($(this).val());
        });
        $.ajax({
            type: "post",
            url: "{{url('document/asign-document')}}",
            data:{
                updateAttachName: updateNames,
                mailId: index,
                customer: customer,
                agent: agent,
                status: status,
                statusText: statusText,
                customerAgentId: custAgentId,
                customerAgentName: custAgentName,
                note1:note1,
                note2:note2,
                note3:note3,
                _token: '{{csrf_token()}}'
            },
            success: function(result)
            {
                $('#load_spinner').hide();
                // console.log(result);
                if(result=="noCustomer") {
                    $('#message').text("The selected customer does not exist !");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                    return;
                }
                if(result=="noAgent") {
                    $('#message').text("The selected assigned person does not exist !");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                    return;
                }

                if(status==0)
                {
                    if(result==1)
                    {
                        $('#message').text("Document details saved successfully!");                
                        $('#message_popup .cd-popup').addClass('is-visible');
                        $("#comment_id_"+index).hide();
                    }
                    else if (result==0)
                    {
                        $('#message').text("Failed to save task details");                
                        $('#message_popup .cd-popup').addClass('is-visible');
                    }
                    else if (result=="nothing")
                    {
                        $('#message').text("No details to save");                
                        $('#message_popup .cd-popup').addClass('is-visible');
                    }
                }
                else if(status==1)
                {
                    $('#message').text("Document completed successfully!");                
                    $('#message_popup .cd-popup').addClass('is-visible');
                    $('#mail_'+index).fadeOut('slow',function(){
                        $('#mail_'+index).remove();
                    });
                }
                $('#update_name_error').text("");
            }
        });
    }

    function checkClosure(index)
    {
        var closureValue= $('#status_'+index).find(':selected').val();
        var customer= $('#customer_'+index).find(':selected').val();
        var agent= $('#agent_'+index).find(':selected').val();
        if(customer && agent!="999" && agent && closureValue==1) {
            $('#button_save_submit_'+index).show();
            $('#button_save_'+index).hide();
        } else{
            $('#button_save_submit_'+index).hide();
            $('#button_save_'+index).show();
        }
    }

    function viewComments(index)
    {
        $('#chat').html("");
        $('#load_spinner').show();
        $('#hdnEmailId').val(index);

        $.ajax({
            type:'post',
            url: "{{url('document/view-comments')}}",
            data: {
                _token: "{{csrf_token()}}",
                index: index
            },
            success: function(result){
            
                $('#chat').html("");
                if(result!=0)
                {
                    result.forEach(element => {
                        $('#chat').append(
                        '<li class="you">'+
                            '<div class="entete">'+
                                '<h3 style="font-style: italic">'+  element.commentBy +' - <span>'+ 
                                element.commentDate.toString() +'</span> - <b style="font-style: normal">'+element.commentBody+'</b></h3>'+ 
                            '</div>'+
                        '</li>');
                    });
                }
                else
                {
                    $('#chat').html("<h3 id='nothing_show' style='margin-left:20px;'>(No comments yet)<h3>");
                }
                $('#load_spinner').hide();
                $('#comment .cd-popup').addClass('is-visible');
                $("#chat").animate({scrollTop :$("#chat").get(0).scrollHeight},1000);
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
                url: "{{url('document/submit-comments')}}",
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
                    $('#add_comment').bind('click');
                }
            });
        }
    }

    function checkFunction(index,btn_index,count)
    {
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
            url: "{{url('document/find-attachments')}}",
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

    function buildExcel(mailBox)
    {
        var status=1;
        $.ajax({
            type: "post",
            url: "{{url('document/emails-to-excel')}}",
            data:
            {
                _token: '{{csrf_token()}}',
                mailBox: mailBox,
                status:status
            },
            success: function(result)
            {
               
            }
        });
    }

</script>
@endpush