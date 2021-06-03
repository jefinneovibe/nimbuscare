
@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style> 
        .tooltip {
            z-index: 999999999;
        }
        

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
            color: #cc3766;
            font-size: 12px;
            line-height: 0;
            margin-top: 10px;
            display: block;
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
       
        .bootstrap-select.btn-group .dropdown-menu {
            z-index: 9999999;
        }
       
        .date_font{
            font-size: 11px !important;
        }
        .filter_popup{
            max-width: 90% !important;
            width: 100% !important 
        }
        .section_details .card_content {
            padding: 10px 20px 10px 20px;
            margin-bottom: 300px;
        }
        .bootstrap-select .dropdown-toggle {
            padding: 6px 8px 6px;
            font-size: 12px;
        }
        .cd-popup .bootstrap-select .dropdown-toggle {
            padding: 6px 8px 6px;
            font-size: 14px;
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
        .bootstrap-select .dropdown-toggle .filter-option{
            text-transform: capitalize !important;
        }
        
    </style>
   
    @php
        $role=session('role');
        $sortOrder = session('enquiryFilter.order');
        $searchKey=session('ActiveSearchKey');
        if(!isset($seachKey))
        {
            $seachKey="";
        }
        $stat=json_encode(session('enquiryFilter.statusList'));
        $cust=json_encode(session('enquiryFilter.customerList'));
        $agen=json_encode(session('enquiryFilter.agentList'));
        $inc=json_encode(session('enquiryFilter.insurerList'));
        // dd($stat,$cust,$agen,$skey);
    @endphp
     @if (session('status'))
     <div class="alert alert-danger alert-dismissible" role="alert" id="failed_mail">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         We could not connect to the email server, please check the settings.
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
                        <button class="btn pull-right custom_btn header_btn" type="button" id="btn_reload" onclick="reloadPage()">
                            <i class="fa fa-refresh" aria-hidden="true"></i> &nbsp;
                             Refresh
                        </button>
                        <div class="media-body" style="    margin-right: 10px;">
                            <form class="search_form" id="custom_search">
                                <input type="text" placeholder="Search.." id="search_key" name="search2" value="{{$searchKey}}">
                                {{-- {{csrf_field()}} --}}
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
                    <a href= "{{url('enquiry/emails-to-excel')}}/{{@$currentMailBucket->userID}}/{{'1'}}" download="Document-List">
                        <button class="btn export_btn waves-effect excel_bt" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="Export To Excel" style="margin-top:6px !important;">
                            <i class="fa fa-file-excel-o"  aria-hidden="true"></i>
                        </button>
                    </a>
                    <input type="hidden" name="hidden_filter_value" id="hidden_filter_value" value='{{json_encode(@$currentMailBucket)}}'>
                    <button class="btn export_btn waves-effect" id ="filter" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="showFilter('{{$totalMail}}', 1, '{{$role}}')" data-original-title="Filter" style="margin-top:6px !important;">
                        <i class="material-icons">filter_list</i>
                    </button>
                    <button class="btn export_btn  waves-effect round_btn" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="window.location='{{url("enquiry/closed-enquiry?box=".@$currentMailBucket->_id)}}'" data-original-title="Completed queue">
                        <span class="round_doc">c</span>
                    </button>
                    {{-- <button class="btn export_btn  waves-effect round_btn" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                    onclick="window.location='{{url("enquiry/latest-comments?box=".@$currentMailBucket->_id)}}'" data-original-title="Latest Comments">
                        <span class="round_doc" style="background-color:#13b6f5 "><i class="fa fa-comment"></i></span>
                    </button> --}}
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
                            <div class="row" style="margin-bottom: 50px;">
                                <div class="col-md-3" id="filter_type_div">
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
                                <div class="col-md-3">
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
                                <!-- <div class="col-md-2" id="filter_type_div">
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
                                </div>-->
                                {{-- <div class="col-md-3" id="filter_type_div">
                                    <h4 class="filter_head">Sub status(Renewal)</h4>
                                    <div class="filter_scroll">
                                        <div class="custom_checkbox">
                                            <input type="checkbox" value="" id="sub_renewal_all" class="inp-cbx platform_all platforms reset_all" onclick="selectAll('sub_renewal')" style="display: none">
                                            <label for="sub_renewal_all" class="cbx">
                                                <span style="min-width: 18px;">
                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span>Select All</span>
                                            </label>
                                        </div>
                                        <div id="sub_renewal_all_filter">
                                        </div>
                                    </div>   
                                </div> --}} 
                                <div class="col-md-2" id="filter_type_div">
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

                                 <div class="col-md-2" id="filter_type_div">
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
                                <div class="col-md-2" id="filter_type_div">
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

                                <!-- <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px;">From Date</h4>
                                            <input id="filterFromDate" class="form_input  datetimepicker" name="filterFromDate" placeholder="From Date" type="text">
                                        </div>
                                        <div class="col-md-6"  style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px;">To Date</h4>
                                            <input id="filterToDate" class="form_input  datetimepicker" name="filterToDate" placeholder="To Date" type="text">
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
                                                <select  id="insurer_list" name="insurer_list[]" multiple>
                                                        @if(!empty(@$insurers))
                                                        @foreach(@$insurers as $insurer)
                                                            <option value="{{$insurer->_id}}" selected>{{$insurer->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 30px;">
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
                                </div>  -->
                            </div>
                            <div class="row" style="margin-bottom: 30px;">

                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <h4 class="filter_head" style="margin-bottom: 25px;">From Date</h4>
                                                <input id="filterFromDate" class="form_input  datetimepicker" name="filterFromDate" placeholder="From Date" type="text">
                                            </div>
                                            <div class="col-md-6"  style="margin-bottom: 20px;">
                                                <h4 class="filter_head" style="margin-bottom: 25px;">To Date</h4>
                                                <input id="filterToDate" class="form_input  datetimepicker" name="filterToDate" placeholder="To Date" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="filter_head">Status</h4>
                                            </div>
                                        </div>
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-md-6">
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
                                                <div class="col-md-6">
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
                                                <div class="col-md-6">
                                                    <div class="custom_checkbox">
                                                        <input type="checkbox" value="" id="commentsCheck" class="inp-cbx platform_all platforms" onclick="checkRenewal(this.id)" style="display: none">
                                                        <label for="commentsCheck" class="cbx">
                                                            <span style="min-width: 18px;">
                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                </svg>
                                                            </span>
                                                            <span>Latest Comments</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-bottom: 30px;">
                                                <h4 class="filter_head">Insurer</h4>
                                                <div class="cus_select2 select_dropdown1">
                                                    <select  id="insurer_list" name="insurer_list[]" multiple>
                                                            @if(!empty(@$insurers))
                                                            @foreach(@$insurers as $insurer)
                                                                <option value="{{$insurer->_id}}" selected>{{$insurer->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="col-md-3">

                                        <div class="row">
                                            <div class="col-md-12" style="margin-bottom: 30px;">
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
                                    {{-- <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <h4 class="filter_head" style="margin-bottom: 25px;">From Date</h4>
                                                <input id="filterFromDate" class="form_input  datetimepicker" name="filterFromDate" placeholder="From Date" type="text">
                                            </div>
                                            <div class="col-md-6"  style="margin-bottom: 20px;">
                                                <h4 class="filter_head" style="margin-bottom: 25px;">To Date</h4>
                                                <input id="filterToDate" class="form_input  datetimepicker" name="filterToDate" placeholder="To Date" type="text">
                                            </div>
                                        </div>
                                    </div> --}}


                                <!-- <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px;">From Date</h4>
                                            <input id="filterFromDate" class="form_input  datetimepicker" name="filterFromDate" placeholder="From Date" type="text">
                                        </div>
                                        <div class="col-md-6"  style="margin-bottom: 20px;">
                                            <h4 class="filter_head" style="margin-bottom: 25px;">To Date</h4>
                                            <input id="filterToDate" class="form_input  datetimepicker" name="filterToDate" placeholder="To Date" type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="filter_head">Status</h4>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
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
                                                <select  id="insurer_list" name="insurer_list[]" multiple>
                                                        @if(!empty(@$insurers))
                                                        @foreach(@$insurers as $insurer)
                                                            <option value="{{$insurer->_id}}" selected>{{$insurer->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom: 30px;">
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
                                </div> -->
                                
                               
                                
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn_action pull-right" onclick="filter('{{$role}}', 1)" type="button">OK</button>
                        <button class="btn  btn_action btn-cancel" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <!-- filter Popup ends -->

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
                                            <input type="hidden" id="hdnEmailId"/>
                                            <div class="chat_main comment_chat_main">
                                                <ul id="chat" style="overflow:auto">
                                                </ul>
                                                <footer>
                                                    <div class="col-md-11">
                                                        <textarea id="new_comment" name="new_comment" placeholder="Type your comment..." ></textarea>
                                                        <span class="error pull-left" id="comment_error"></span>
                                                    </div>
                                                    <a id="add_comment" title="Send" class="send_btn" onclick="submitComment()">
                                                        <i class="material-icons"> send </i>
                                                    </a>
                                               {{-- onkeyup="post()" --}}
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
                            <button class="btn btn_cancel btn_action btn-cancel" type="button">Cancel</button>
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
                                    <p id="mail_body"></p>   
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn_cancel btn_action btn-cancel" type="button">Close</button>
                </div>
                <a href="" class="cd-popup-close img-replace"></a>
            </div>
        </form>
    </div>
</div> <!-- open email Popup ends -->   

<div id="testing">
</div>

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

 {{--close popup--}}
 <div id="submit_popup">
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
                                        <h3>Are you sure want to complete this document?</h3>
                                        <input name="id" id="id" value="" type="hidden">
                                        <input name="mailCount" id="mailCount" value="" type="hidden">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <button type="button" class="btn btn-primary btn-link btn_cancel">Cancel</button>
                <button class="btn btn-primary btn_action" type="button" id="submitMail">Complete</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="ajax-load text-center" style="display:none">
    <p><img src="{{URL::asset('img/loader.gif')}}">Loading More Tasks</p>
</div>
    <style>
        .section_details{
            max-width: 100%;
        }
        .select2-container {
            /* z-index: 99999 !important; */
        }
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
        .bootstrap-datetimepicker-widget table td{
            padding: 0 !important;
            width: auto !important;
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
       .substatus_dropdown .dropdown-menu.inner{
            overflow-y: auto !important;
            /* height: 250px !important; */
        }
    </style>
@endsection

@push('scripts')
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
    .select2-container {
        z-index: 99999 !important;
    }
    span.select2-container.select2-container--default.select2-container--open {
        z-index: 999999999 !important;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>
<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

<script>

var page=0;
$(document).ready(function() {
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
                
            page=0;
            var mailSwitch=$('#customSort').val();
            var search=$('#search_key').val();
            $('#load_spinner').show();
            $('#after_load').val('loading');
            $.ajax({
                url: "{{url('enquiry/view-enquiries')}}",
                type: "get",
                data:{
                    page:page,
                    search2:search,
                    filterMethod:'search',
                    box:mailSwitch,
                    index:mailSwitch,
                    oldUser:'{{$user}}'
                },
                success: function(data) {
                    $('#load_spinner').hide();
                    $("#post-data").html('');
                    $("#post-data").append(data.documentOperation);
                    $('#after_load').val('loadComplete');
                    $('[data-toggle="tooltip"]').tooltip();
                    $("#total_count").val(data.countMails);
                    $("#spanCount").html(data.countMails);
                    
                }
            });
        }
    });
    page = 0;
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
    $('.ajax-load').show();
    var mailSwitch=$('#customSort').val();
    var search=$('#search_key').val();
    $('#after_load').val('loading');
    $.ajax(
    {
        url: "{{url('enquiry/view-enquiries')}}",
        type: "get",
        data:{
            page:page,
            search2:search,
            index:mailSwitch,
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
            $('[data-toggle="tooltip"]').tooltip(); 
            $("#total_count").val(data.countMails);
            $("#spanCount").html(data.countMails);
            
        }
    })  
}

    $('#filterFromDate') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#filterToDate') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false 
    });
    $('#filterFromDate').on('dp.change', function (e) {
            // $('#filterToDate').data('DateTimePicker').date(e.date);
            $('#filterToDate').data('DateTimePicker').minDate(e.date);
    });
    $("#filterToDate").on("dp.change", function (e) {
            $('#filterFromDate').data("DateTimePicker").maxDate(e.date);
    });
function initialFilterColor()
{
    var user=sessionStorage.getItem('previouisBox');
    var oldCache="{{session('oldCache')}}";
    if(oldCache!=user)
    {
        $('#filter').css('color','');
        sessionStorage.removeItem('enq.statusFilter');
        sessionStorage.removeItem('enq.nonstatusFilter');
        sessionStorage.removeItem("enq.customersFilter");
        sessionStorage.removeItem("enq.agentsFilter");
        sessionStorage.removeItem("enq.customerAgentFilter");
        sessionStorage.removeItem("enq.insurersFilter");
        sessionStorage.removeItem("enq.fromDateFilter");
        sessionStorage.removeItem("enq.toDateFilter");
        sessionStorage.removeItem("enq.renewalCheckFilter");
        sessionStorage.removeItem("enq.nonrenewalCheckFilter");
        sessionStorage.removeItem("enq.grpFilter");
  }
    sessionStorage.setItem('previouisBox','{{$user}}');

}


function filterColorChange()
{
    var cust=[];
    var agen=[];
    var grop=[];
    var stat=[];
    var nonstat=[];
    var custAgent=[];
    var insurer=[];
    var fromDate='';
    var toDate='';
    var renew='';
    var nonRenew='';

    stat=JSON.parse(sessionStorage.getItem("enq.statusFilter"));
    if(stat==null)
    {
        var stat=[];
    }
    nonstat=JSON.parse(sessionStorage.getItem("enq.nonstatusFilter"));
    if(nonstat==null)
    {
        var nonstat=[];
    }
    grop=JSON.parse(sessionStorage.getItem("enq.grpFilter"));
    if(grop==null)
    {
        var grop=[];
    }
    cust=JSON.parse(sessionStorage.getItem("enq.customersFilter"));
    if(cust==null)
    {
        var cust=[];
    }
    agen=JSON.parse(sessionStorage.getItem("enq.agentsFilter"));
    if(agen==null)
    {
        var agen=[];
    }
    custAgent=JSON.parse(sessionStorage.getItem("enq.customerAgentFilter"));
    if(custAgent==null)
    {
        var custAgent=[];
    } 
    insurer=JSON.parse(sessionStorage.getItem("enq.insurersFilter"));
    if(insurer==null)
    {
        var insurer=[];
    } 
    fromDate=sessionStorage.getItem("enq.fromDateFilter");
    if(fromDate==null)
    {
        var fromDate='';
    } 
    toDate=sessionStorage.getItem("enq.toDateFilter");
    if(toDate==null)
    {
        var toDate='';
    } 
    renew=sessionStorage.getItem("enq.renewalCheckFilter");
    if(renew==null)
    {
        var renew='';
    } 
    nonRenew=sessionStorage.getItem("enq.nonrenewalCheckFilter");
    if(nonRenew==null)
    {
        var nonRenew='';
    } 


    commentcheck=sessionStorage.getItem("enq.commentsCheckFilter");
    if(commentcheck==null)
    {
        var commentcheck='';
    } 
    noncommentcheck=sessionStorage.getItem("enq.noncommentsCheckrenewalCheckFilter");
    if(noncommentcheck==null)
    {
        var noncommentcheck='';
    } 

    if(cust.length || agen.length|| grop.length || stat.length || custAgent.length || 
    insurer.length || nonstat.length || fromDate!='' || toDate!='' || commentcheck!='' || noncommentcheck!='')
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


    var percentId=0;
    var percentValue=0;
    var commissionAmt=0;

function calculateCommission(id){
    var policy=Number($('#policy_'+id).val().split(',').join(''));

    var commissionPercentage=Number($('#commissionP_'+id).val().replace(",", ""));
    var commission=$('#commission_'+id);
    
    if(commissionPercentage<=100){
        percentId=id;
        percentValue=commissionPercentage;
     
        commissionAmt=policy*commissionPercentage/100;
        // console.log("pass",percentValue,percentId,id);
        commission.val(addCommas(commissionAmt.toFixed(2)));

    // console.log(id,policy,commissionPercentage,commissionAmt);
    } else if(commissionPercentage>100 && percentId==id) {
        // console.log("fail",percentValue,percentId,id,commissionAmt);
        $('#commissionP_'+id).val(percentValue);
        commission.val(addCommas(commissionAmt.toFixed(2)));
    }

}

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function changeOrder()
{
    $('#load_spinner').show();
    var order = $('#sort_order').val();
    var mailBox = $('#customSort').val();
    $.ajax({
        type: "post",
        url: "{{url('enquiry/dynamic-sort')}}",
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
            console.log(result);
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

var openedWindow;
function viewAttachment(path)
{
    openedWindow= window.open(path,'_blank','width=700, height=800, top=70, left=100, resizable=1, menubar=yes', false);
    // console.log(openedWindow);
}

$(document).ready(function(){
    filterColorChange();
    initialFilterColor();
    setTimeout(function() {
        $('#failed_mail').fadeOut('fast');
    }, 10000);
    $.validator.addMethod("alpha",function(value,element){
        return this.optional(element) || (/^[a-zA-Z -_.]*$/i).test(value);
    });
    $('#forward_to').tagsinput('item');
    $('#forward_cc').tagsinput('item');
});

function addNewCustomer()
{
   window.open("{{url('customers/create')}}", 'New Window','top=70,left=400,width=1300,height=800,menubar=yes');
}


function loadSerach()
{
    page=0;
    var search=$('#search_key').val();
    var mailSwitch=$('#customSort').val();
    $('.ajax-load').show();
    $('#after_load').val('loading');
    $.ajax(
    {
        url: "{{url('enquiry/view-enquiries')}}",
        type: "get",
        data:{
            page:page,
            search2:search,
            filterMethod:'search',
            index:mailSwitch,
            oldUser:'{{$user}}'

        },
        success: function(data) {
            $('.ajax-load').hide();
            $("#post-data").html('');
            $("#post-data").append(data.documentOperation);
            $('#after_load').val('loadComplete');
            $('[data-toggle="tooltip"]').tooltip(); 
            $("#total_count").val(data.countMails);
            $("#spanCount").html(data.countMails);
            
        }
    })  
}
function showAgent(index,mail)
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
        url: "{{url('enquiry/get-agent-details')}}",
        data: 
        {
            _token:'{{csrf_token()}}',
            customer: customer,
            // mail: mail
        },
        success: function(result)
        {
            // result=JSON.parse(result);
            // var name=result.agent.name;
            // var id=result.agent.id.$oid;
            // $('#agent_list').selectpicker('destroy');
            // $('#agent_list').html(result.emp_name);
            // $('#agent_list').selectpicker('setStyle');

            // console.log(result.agent.id.$oid);
            // $('#no_agent_details_'+index).selectpicker('destroy');
            $('#agent_detail_'+index).selectpicker('destroy');
            $('#agent_detail_'+index).html(result.response);
            $('#agent_detail_'+index).selectpicker('setStyle');
            // $('#cust_agnet_'+index).val(id);
            // console.log(x);
            checkClosure(index);

        }
    });
}
function closeTab(index)
{ 
  $('#'+index).collapse('hide');
}
function checkSelewction(index)
{

}
function dropClose() {
    $('.dropdown-menu').removeClass('show');
}
function showFilter(totalMail,mailStatus,role)
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
    var selection="nonStatus";
    var stock=[];
    var agents=[];
    var nonstatusStore = [];
    // var groups=[];
    var mailBox=$('#customSort').find(':selected').text();
    mailBucket=JSON.parse(mailBucket);
    if(mailBucket && (mailBucket.groups))
        {
            var groups=mailBucket.groups;
        }else{
            var groups=[];
        }
    if((mailBucket && mailBucket.nonRenewalStatus))
        {
            var nonrenewStatus=mailBucket.nonRenewalStatus;
        }else{
            var nonrenewStatus=[];
        }
    if(mailBucket && (mailBucket.renewalStatus))
        {
            var renewStatus=mailBucket.renewalStatus;
        }else{
            var renewStatus=[];
        }
    // var renewStatus=mailBucket.renewalStatus;
    // var groups=mailBucket.groups;
    var customerStore=sessionStorage.getItem("enq.customersFilter");
    var insurerStore=sessionStorage.getItem("enq.insurersFilter");
    customerStore=JSON.parse(customerStore);
    insurerStore=JSON.parse(insurerStore);
    var filterFromDate=sessionStorage.getItem("enq.fromDateFilter");
    var filterToDate=sessionStorage.getItem("enq.toDateFilter");
    $('#filterFromDate').data("DateTimePicker").date(filterFromDate);
    $('#filterToDate').data("DateTimePicker").date(filterToDate);
    var renewalCheck=sessionStorage.getItem("enq.renewalCheckFilter");
    var nonrenewalCheck=sessionStorage.getItem("enq.nonrenewalCheckFilter");

    var commentsCheck=sessionStorage.getItem("enq.commentsCheckFilter");
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
            $('#customer_list').html(result[2]);
            $('#insurer_list').html(result[3]);
            $('#status_filter').empty();
            $('#non_status_filter').empty();
            $('#customer_filter').empty();
            $('#customer_agent_filter').empty();
            $('#agent_filter').empty();
            $('#group_filter').empty();
            $('#insurer_filter').empty();
            var check="";
            var customers=result[2];
            var agents=result[0];
            var customerAgents=result[1];
            var insurers=result[3];
            // var groupList=result[4];
            var statusStore=sessionStorage.getItem("enq.statusFilter");
            nonstatusStore=sessionStorage.getItem("enq.nonstatusFilter");
            statusStore = JSON.parse(statusStore)? JSON.parse(statusStore) : [];
            nonstatusStore = JSON.parse(nonstatusStore)? JSON.parse(nonstatusStore): [];
            var customerStore=sessionStorage.getItem("enq.customersFilter");
            var agentStore=sessionStorage.getItem("enq.agentsFilter");
            var customerAgentStore=sessionStorage.getItem('enq.customerAgentFilter');
            var insurerStore=sessionStorage.getItem('enq.insurersFilter');
            var grpStore=sessionStorage.getItem('enq.grpFilter');
            customerStore=JSON.parse(customerStore);
            if(renewalCheck=='renewalCheck')
            {
                $("#renewalCheck").prop( "checked", true );
            }
            if(nonrenewalCheck=='nonrenewalCheck')
            {
                $("#nonrenewalCheck").prop( "checked", true );
            }


            if(commentsCheck=='commentsCheck')
            {
                $("#commentsCheck").prop( "checked", true );
            }


            if(filterFromDate!='')
            {
                $("#filterFromDate").val(filterFromDate);
            }
            if(filterToDate!='')
            {
                $("#filterToDate").val(filterToDate);
            }
            length=nonrenewStatus.length;
            subStatusStore = "";
            selected = "";
            for(i=0;i<length;i++)
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
                        '<div class="col-md-6">'+
                        '<div class="custom_checkbox">'+
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
                        
                        substring+='<div class="col-md-5">'+
                        '<div class="form_group substatus_dropdown">'+
                            '<label class="form_label"></label>'+
                            '<select class="selectpicker" id="subStatusList_'+count+'" name="subStatusList_[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" '+
                            'title="Sub Status"'+
                            (check=="checked"?"":"disabled")
                            +' multiple onchange="dropClose()">';
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
                    count++;
                    check="";
            }
            // $('.selectpicker').selectpicker();
            selection="status";
            stock=[];
            count=0;
            subStatusStore = "";
            selected = "";
            length=renewStatus.length;
            for(i=0;i<length;i++)
            {
                    statusStore.forEach(function(item) {
                        if (item.status == renewStatus[i].statusName) {
                            check = "checked";
                            subStatusStore = item.subStatus? item.subStatus : [];
                            return;
                        }
                    });
                    // if(statusStore[i]) {
                    //     var status = statusStore[i].status
                    //     console.log(status, length, renewStatus);
                    //     if(status == renewStatus[i].statusName) {
                    //         check="checked";
                    //     }
                    // }
                    
                    var substring='<div class="row">'+
                    '<div class="col-md-6">'+
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
                    substring+='<div class="col-md-5">'+
                    '<div class="form_group substatus_dropdown">'+
                        '<label class="form_label"></label>'+
                        '<select class="selectpicker" id="subStatusListRenew_'+count+'" name="subStatusListRenew_'+count+'_[]" onclick="checkSelection(\''+selection+'\',\''+count+'\')" '+
                        'title="Sub Status"'+
                        (check=="checked"?"":"disabled")
                        +' multiple onchange="dropClose()">';
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
                    count++;
                    check="";
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
            stock=[];
            count=0;
            selection="agent";
            length=agents.length;
            // console.log(length);
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
            // console.log(customerAgents);
            for(i=0;i<length;i++)
            {
                customerAgentId=customerAgents[i].assaignedTo.customerAgentId;
                customerAgentName=customerAgents[i].assaignedTo.customerAgentName;
                if(customerAgentId!=null && customerAgentId!="" && !stock.includes(customerAgentId))
                {
                    if(customerAgentStore)
                    {
                        if(customerAgentStore.includes(customerAgentId))
                        {
                                check="checked";  
                        }
                    }
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
            $('#status_filter select').selectpicker({
                size: 5
            });
            $('#non_status_filter select').selectpicker({
                size: 5
            });
            $('#load_spinner').hide();
            $('[data-toggle="tooltip"]').tooltip();
            $('#document_mail_filter .cd-popup').addClass('is-visible');
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
        $('#subStatusList_'+index+'.selectpicker').selectpicker('refresh');
        $('#subStatusListRenew_'+index+'.selectpicker').selectpicker('refresh');
    }
    
    function resetFilter()
    {
        $('#status_all').attr('checked',false);
        $('#non_status_all').attr('checked',false);
        $('#customer_all').attr('checked',false);
        $('#agent_all').attr('checked',false);
        $('#customer_agent_all').attr('checked',false);
        $('#grp_all').attr('checked',false);
        $('#insurer_all').attr('checked',false);
        $('#insurer_filter input:checkbox').attr('checked',false);
        $('#customer_agent_filter input:checkbox').attr('checked',false);
        $('#status_filter input:checkbox').attr('checked',false);
        $('#non_status_filter input:checkbox').attr('checked',false);
        $('#group_filter input:checkbox').attr('checked',false);
        $('#agent_filter input:checkbox').attr('checked',false);
        $('#customer_filter input:checkbox').attr('checked',false);
        $("#insurer_list").val('null').trigger("change"); 
        $("#customer_list").val(null).trigger("change"); 
        $("#filterFromDate").val(''); 
        $("#filterToDate").val(''); 
        $('#renewalCheck').attr('checked',false);
        $('#renewalCheck').val('');
        $('#nonrenewalCheck').attr('checked',false);
        $('#nonrenewalCheck').val('');
        $('#commentsCheck').attr('checked',false);
        $('#commentsCheck').val('');
        $("#filterFromDate").data("DateTimePicker").clear();
        $("#filterToDate").data("DateTimePicker").clear();
        $('#status_filter select').selectpicker('deselectAll');
        $('#status_filter select').prop('disabled', true);
        $('#non_status_filter select').selectpicker('deselectAll');
        $('#non_status_filter select').prop('disabled', true);
        $('#status_filter select').selectpicker('refresh');
        $('#non_status_filter select').selectpicker('refresh');

    }

    function filter(role, mailStatus)
    {
        if($("#renewalCheck").prop('checked') == true && $("#nonrenewalCheck").prop('checked') == false)
            {
            $('#renewalCheck').val('renewalCheck');
            $('#nonrenewalCheck').val('');
        } else {
            $('#renewalCheck').val('');
        }
        if($("#nonrenewalCheck").prop('checked') == true  && $("#renewalCheck").prop('checked') == false)
        {
            $('#nonrenewalCheck').val('nonrenewalCheck');
            $('#renewalCheck').val('');
        } else {
            $('#nonrenewalCheck').val('');
        }
        if($("#nonrenewalCheck").prop('checked') == true && $("#renewalCheck").prop('checked') == true)
        {
            $('#nonrenewalCheck').val('nonrenewalCheck');
            $('#renewalCheck').val('renewalCheck');
        } 


        if($("#commentsCheck").prop('checked') == true)
        {
            $('#commentsCheck').val('commentsCheck');
        } else {
            $('#commentsCheck').val('');
        }

        var mailSwitch=$('#customSort').val();
        $('#load_spinner').show();
        var statusDetails=[];
        var nonstatusDetails=[];
        var groupDetails=[];
        var agentDetails=[];
        var nonSubStatusDetails=[];
        var customerAgentDetails=[];
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
        var commentsCheck=$('#commentsCheck').val();
        var NonSubstatusLength=$('input[name="subStatusList_[]"]').length;
        console.log(renewalCheck,commentsCheck,NonSubstatusLength);
        $('#document_mail_filter .cd-popup').removeClass('is-visible');
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
        }
        for(i=0;i<nonstatusLength;i++)
        {
            if($('#cbx_non_status_'+i).is(':checked'))
            {
                var sub = $('#subStatusList_'+i).val()?$('#subStatusList_'+i).val():[];
                var nonstatus = {
                    'status' : $('#cbx_non_status_'+i).val(),
                    'subStatus' : sub
                };
                nonstatusDetails.push(nonstatus);
            }
        }
        for(i=0;i<groupListLength;i++)
        {
            if($('#groupList_'+i).is(':checked'))
            groupDetails.push($('#groupList_'+i).val());
        }
        sessionStorage.setItem('enq.statusFilter',JSON.stringify(statusDetails));
        sessionStorage.setItem('enq.nonstatusFilter',JSON.stringify(nonstatusDetails));
        // sessionStorage.setItem('enq.nonSubStatusFilter',JSON.stringify(nonSubStatusDetails));

        sessionStorage.setItem('enq.grpFilter',JSON.stringify(groupDetails));
        sessionStorage.setItem('enq.customersFilter',JSON.stringify(customerDetails));
        sessionStorage.setItem('enq.fromDateFilter',filterFromDate);
        sessionStorage.setItem('enq.toDateFilter',filterToDate);
        sessionStorage.setItem('enq.renewalCheckFilter',renewalCheck);
        sessionStorage.setItem('enq.nonrenewalCheckFilter',nonrenewalCheck);
        sessionStorage.setItem('enq.commentsCheckFilter',commentsCheck);

        for(i=0;i<agentsLength;i++)
        {
            if($('#cbx_agent_'+i).is(':checked'))
            agentDetails.push($('#cbx_agent_'+i).val());
        }
        sessionStorage.setItem('enq.agentsFilter',JSON.stringify(agentDetails));
        for(i=0;i<customerAgentsLength;i++)
        {
            if($('#cbx_customer_agent_'+i).is(':checked'))
            customerAgentDetails.push($('#cbx_customer_agent_'+i).val());
        }
        sessionStorage.setItem('enq.customerAgentFilter',JSON.stringify(customerAgentDetails));

        sessionStorage.setItem('enq.insurersFilter',JSON.stringify(insurerDetails));
        $('#after_load').val('loading');
        $.ajax({
            type:'get',
            // url: "{{url('enquiry/custom-filter')}}",
            url: "{{url('enquiry/view-enquiries')}}",
            data: 
            {
                page:0,
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
                index:mailSwitch,
                oldUser:'{{$user}}',
                filterFromDate: filterFromDate,
                filterToDate: filterToDate,
                renewalCheck: renewalCheck,
                nonrenewalCheck: nonrenewalCheck,
                commentsCheck: commentsCheck,
                groupDetails: groupDetails,
                // nonSubStatusDetails,nonSubStatusDetails

            },
            success: function(result)
            {
                page=0;
                $('#load_spinner').hide();
                $('#post-data').html('');
                $('#post-data').append(result.documentOperation);
                $('#spanCount').html(result.countMails);
                filterColorChange();
                $('[data-toggle="tooltip"]').tooltip();
                $('#after_load').val('loadComplete');
                $("#total_count").val(result.countMails);
            }
        });
    }
    function getSubStatus(vaCheck){
      console.log(vaCheck);
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
                    // getSubStatus($('#cbx_status_'+i).val());
                    if(!$('#cbx_status_'+i).is(':checked'))
                    if($('#cbx_status_'+i).click())
                    {
                    }
                }
            }
            else
            {
                if($('#status_filter input:checkbox').attr('checked',false))
                {
                    $('#status_filter select').prop('disabled', true);
                    $('#status_all').attr('checked',false);
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
                    }
                }
            }
            else
            {
                if($('#agent_filter input:checkbox').attr('checked',false)){}
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
                    }
                }
            }
            else
            {
                if($('#customer_agent_filter input:checkbox').attr('checked',false)){}
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
                    }
                }
            }
            else
            {
                if($('#insurer_filter input:checkbox').attr('checked',false)){}
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
                $('#message').text("Message forwarded successfully");                
                $('#message_popup .cd-popup').addClass('is-visible');
            }
            else
            {
                $('#load_spinner').hide();
                $('#forward_email .cd-popup').removeClass('is-visible');
                $('#message').text("Sorry! can't forward mail at the moment");                
                $('#message_popup .cd-popup').addClass('is-visible');
            }
        }
    });
}


function hideMessage()
{
    $('#message_popup .cd-popup').removeClass('is-visible');
    $('#message').text(""); 
    $('#message').html("");               
}


function cancelPostCustomer()
{
    $('#post_to').val("");
    $('#load_spinner').hide();
    $('#post_to').tagsinput('destroy');
}
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
    window.location.href='{{url("enquiry/view-enquiries?index=")}}'+mailSwitch+'&oldUser={{$user}}&page='+page;
}
function downloadAttachment(path, add)
{
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip('enable');
    window.location.href="{{url('document/download?index=')}}"+path+add;
}
// function switchMail()
// {
//     var mailSwitch=$('#customSort').val();
//     var page=0;
//     $('#load_spinner').show();
//     $.ajax(
//     {
//         url: "{{url('enquiry/view-enquiries')}}",
//         type: "get",
//         data:{
//             index:mailSwitch,
//             oldUser:'{{$user}}',
//             page:page
//         },
//         success: function(data) {
//             $('[data-toggle="tooltip"]').tooltip();
//             if(data.status=='error'){
//                 $('#load_spinner').hide();
//                 $('#failed_mail').show();
//                 setTimeout(function() {
//                 $('#failed_mail').fadeOut('fast');
//                 location.reload();
//             }, 10000);
//             } else{
//                 $('#load_spinner').hide();
//                 $("#post-data").html('');
//                 $("#post-data").append(data.documentOperation);
//                 $("#total_count").val(data.countMails);
//                 $("#spanCount").html(data.countMails); 
//             }
          
//         }
//     })  
// }
function viewComments(index)
{
    $('#chat').html("");
    $('#load_spinner').show();
    $('#hdnEmailId').val(index);
    // $(".hideshow").css("display", "none");
    $("#comment_id_"+index).hide();
    // console.log($("#comment_id_"+index));
    $.ajax({
        type:'post',
        url: "{{url('enquiry/view-comments')}}",
        data: {
            _token: "{{csrf_token()}}",
            index: index
        },
        success: function(result){
           
            $('#chat').html("");
            if(result!=0)
            {   
                result.forEach(element => {
                    var test= new Date(element.commentDate);
                    console.log(element.commentDate.toString(),test);
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
            //    $('#chat li').last().parent().css("color", "red");
                $("#chat").animate({scrollTop :$("#chat").get(0).scrollHeight},1000);
                $('#add_comment').bind('click');
            }
        });
    }
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
//             fileName=fileName.split(".");
//             fileName=fileName[0];
//             path="{{url('document/download?index=')}}"+item.attachPath+"&name="+item.attachName;
//             downloadCarrier.download=fileName;

//             downloadCarrier.href=path;
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
function test(index)
{
    var x=$('#insurer_'+index).find(':selected').text();
    // console.log(x);
}
$(document).ready(function() {

    var mailBox=$('#customSort').find(':selected').text();
    var mailStatus=1;
    $('.customer-data-ajax').select2({
        ajax: {
            url: '{{URL::to("enquiry/get-customer-management")}}/'+mailBox+'/'+mailStatus ,
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
        var mailStatus1=1;
   $('#insurer_list').select2({
        ajax: {
            url: '{{URL::to("enquiry/get-insurer-management")}}/'+mailBox1+'/'+mailStatus1,
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data1, params) {
               
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data1.items,
                    pagination: {
                        more: (params.page * 10) < data1.total_count
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

function checkRenewal(id)
{
    if($("#commentsCheck").prop('checked') == false )
    {
      $('#commentsCheck').val('');
    }
}

$('.btn-cancel').click(function(){
    $('#document_mail_filter .cd-popup').removeClass('is-visible');
});

function checkClosure(index)
{
    calculateCommission(index);

    var closureValue= $('#status_'+index).find(':selected').val();
    var agent = $('#agent_'+index).find(':selected').val();
    var customer = $('#customer_'+index).find(':selected').val();
    if (closureValue==1 && customer){
        if (customer && $('#policy_'+index).val() && ($('#commissionP_'+index).val() != '' || $('#commissionP_'+index).val() != null) && $('#agent_detail_'+index).val() && $('#sub_status_'+index).val() && agent && agent != "999")
        {
                $('#button_save_submit_'+index).show();
                // $('#button_save_'+index).hide();
        }
        else{
                $('#button_save_submit_'+index).hide();
                $('#button_save_'+index).show();
        }
    } else if (closureValue==0) {
        $('#button_save_submit_'+index).hide();
        // $('#button_save_'+index).show();
    }
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
function showConfirmation(index)
{
    $('#id').val(index);
    $('#mailCount').val(index);
    var cust=$('#customer_'+index).find(':selected').val();
    var policy=$('#policy_'+index).val();
    var custAgentId=$('#agent_detail_'+index).val();
    var custAgentName=$('#agent_detail_'+index).text();
    var agent=$('#agent_'+index).find(':selected').val();
    if ($('#status_'+index).find(':selected').val()==1)
    {
        if(! cust) {
            $('#message').text("Please select customer");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! policy) {
            $('#message').text("Please enter policy premium");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! agent || agent == "999") {
            $('#message').text("Please select assignee");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! custAgentId) {
            $('#message').text("Please select agent");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        }
    }
    $("#submit_popup .cd-popup").toggleClass('is-visible');
}
$('#submitMail').on('click', function() {
    $('#load_spinner').show();
    $("#submit_popup .cd-popup").removeClass('is-visible');
    // var id = $('#id').val();
    var index = $('#mailCount').val();
    saveMail(index, "submit")

});

function saveMail(index, type)
{
    $('#load_spinner').show();
    var cust=$('#customer_'+index).find(':selected').val();
    var policy=$('#policy_'+index).val();
    var custAgentId=$('#agent_detail_'+index).val();
    var custAgentName=$('#agent_detail_'+index).text();
    var agent=$('#agent_'+index).find(':selected').val();
    var substatus=$('#sub_status_'+index).val();
    var commissionPercentage=$('#commissionP_'+index).val();
    var commissionAmount=$('#commission_'+index).val();
    var substatusText=$('#sub_status_'+index).find(':selected').text();
    if (substatusText=="Select Sub Status")
    {
        substatusText="";
    }
    if ($('#status_'+index).find(':selected').val()==1 && type == "submit")
    {
        if(! cust) {
            $('#message').text("Please select customer");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! policy) {
            $('#message').text("Please enter policy premium");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! agent || agent == "999") {
            $('#message').text("Please select assignee");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! custAgentId) {
            $('#message').text("Please select agent");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } else if (! substatus) {
            $('#message').text("Please select substatus");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        }
    }
    var status=$('#status_'+index).val();
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
    var insurerName=$('#insurer_'+index).find(':selected').text();
    var insurerId=$('#insurer_'+index).find(':selected').val();
    var date1=$('#date_1_'+index).val();
    var date2=$('#date_2_'+index).val();
    var note=$('#note_'+index).val();
    var customer=$('#customer_'+index).find(':selected').val();
    var renewal_date=$('#renewal_date_'+index).val();
    var reminder_date=$('#reminder_date_'+index).val();
    var group=$('#group_'+index).val();
    if(policy!='')
    {
        policyAmnt=policy.replace(/,/g, '');
        if(isNaN(policyAmnt)){
            $('#message').text("Please enter valid policy premium amount");                
            $('#message_popup .cd-popup').addClass('is-visible');
            $('#load_spinner').hide();
            return;
        } 
    }

    var renew;
    if($('#cbx_renew_'+index).is(':checked')) {
        renew=1;
    } else {
        renew=0;
    }
    var updateNameNotPosible=0;
    var updateNames=[];
    
    $("input[name='attachment_"+index+"[]']").each(function(){
        updateNames.push($(this).val());
    });
    $.ajax({
        type: "post",
        url: "{{url('enquiry/assign-document')}}",
        data:{
            updateAttachName: updateNames,
            mailId: index,
            customer: customer,
            agent: agent,
            status: status,
            statusText: statusText,
            customerAgentId: custAgentId,
            customerAgentName: custAgentName,
            renewal: renew,
            date1:date1,
            date2:date2,
            note:note,
            insurerName:insurerName,
            commissionPercentage:commissionPercentage,
            commissionAmount:commissionAmount,
            insurerId:insurerId,
            renewal_date:renewal_date,
            reminder_date:reminder_date,
            policy:policy,
            group:group,
            substatus:substatus,
            substatusText:substatusText,
            type: type,
            _token: '{{csrf_token()}}'
        },
        success: function(result)
        {
            console.log(result);
            $('#load_spinner').hide();
            if(status==0 || type == "save")
            {
                if(result==1)
                {
                    $('#message').text("Document details saved successfully!");                        
                    $('#message_popup .cd-popup').addClass('is-visible');
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
            else if(status == 1 && type == "submit")
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

function renewalCheck(index, current)
{
    var credential = $('#hidden_filter_value').val();
    credential=JSON.parse(credential);
    $('#status_'+index).empty();
    $('#sub_status_'+index).empty();
    var option=$('<option></option>').attr('value',"").prop('selected',true).text("Select Status");
    var optionSub=$('<option></option>').attr('value',"").prop('selected',true).text("Select Sub Status");
    $('#status_'+index).append(option);
    $('#sub_status_'+index).append(optionSub);
    if($('#cbx_renew_'+index).is(':checked'))
    {
        var renewalStatus=credential.renewalStatus;
        renewalStatus.forEach(function(item)
        {
            var option=$('<option></option>').attr('value',item['closureProperty']).text(item['statusName']);
            $('#status_'+index).append(option);
        });
        // if(current)
        // {
        //     $('#status_'+index+' option:contains('+current+')').prop('selected',true);
        // }
        $('#status_'+index).selectpicker('refresh');
        $('#sub_status_'+index).selectpicker('refresh');
    }
    else
    {
        var nonRenewalStatus=credential.nonRenewalStatus;
        nonRenewalStatus.forEach(function(item)
        {
            var option=$('<option></option>').attr('value',item['closureProperty']).text(item['statusName']);
            $('#status_'+index).append(option);
        });
        // if(current)
        // {
        //     $('#status_'+index+' option:contains('+current+')').prop('selected',true);
        // }
        $('#status_'+index).selectpicker('refresh');
        $('#sub_status_'+index).selectpicker('refresh');
    }
    checkClosure(index);
    return;
}
</script>
@endpush


 

 