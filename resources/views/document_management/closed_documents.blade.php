@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .select2-container {
            z-index: 999999999 !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #D4D9E2 !important;
            border-radius: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #4b515e !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            color: #000 !important;
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
            max-width: 1210px !important;
        }
        .search_sec {
            width: 660px;
            padding: 0;
            margin: 0 0px;
        }
        .select2-container {
            z-index: 99999 !important;
        }
        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999999 !important;
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
    </style>
    @php
        $role=session('role');
        $searchKey=session('closedSearchKey');
    @endphp 
    
    <div class="section_details">
        <div class="card_header card_header_flex  clearfix">
            <h3 class="title">Completed Queue</h3>
            <div class="right_section">
                <div class="search_sec">
                    <div class="media">
                        <input type="hidden" id="total_count" value="{{$countMails}}">
                        <input type="hidden" id="after_load" value="">
                        <label id="countMails" class="count_label">Count : <span class="count_num" id="spanCount"> {{$countMails}}</span> </label> 
                        <button class="btn pull-right custom_btn header_btn" type="button"
                        onclick="customerView()">
                        <i class="fa fa-eye" aria-hidden="true"></i> &nbsp;
                            Customer View
                        </button>
                        <button class="btn pull-right custom_btn header_btn"  type="button" id="btn_reload" onclick="reloadPage()">
                            <i class="fa fa-refresh" aria-hidden="true"></i>  &nbsp;
                             Refresh
                        </button>
                        <div class="media-body" style="    margin-right: 10px;">

                        <form class="search_form" id="custom_search" action="{{url('document/custom-search')}}" method="POST">
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
                    <a href= "{{url('document/emails-to-excel')}}/{{$currentMailBucket->userID}}/{{'0'}}">
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
                    onclick="window.location='{{url("document/view-emails?index=".$currentMailBucket->_id)}}'" data-original-title="Active queue">
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
 
{{-- <div class="card_content">
    <div class="">
        <div class="row">
            <div class="col-md-12" id="matter">
                <div class="panel-group" id="accordion" role="tablist">
                    @php
                        $mailCount=0;
                        if(count($data)<=0)
                        {
                            echo "<h4> No document found</h4>";
                        }
                        $role=session('role');
                    @endphp
                    @foreach ($data as $mail)
                        @php
                            if(isset($mail->assaignedTo))
                            {
                            $assaigned=$mail->assaignedTo;
                            }
                            else {
                                $assaigned=null;
                            }
                        @endphp
                        <div class="panel panel-default document_panel" id="mail_{{$mailCount}}">
                            <div class="panel-heading clearfix" role="tab" id="headingOne">
                                <div class="row">
                                    <div class="col-md-10" id="mail_bar_{{$mailCount}}">
                                        <div class="panel_open">
                                            <a id="panel_{{$mailCount}}" class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#{{$mailCount}}" aria-expanded="false" aria-controls="collapseOne" style="margin: 0 11px;">
                                                @if ($mail->subject=="")
                                                    <label class="form_label mail_subject">(No Subject)</label>
                                                @else
                                                    <label class="form_label mail_subject subject_overflow"
                                                    data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="{{$mail->subject}}">
                                                        {{$mail->subject}}
                                                    </label>
                                                @endif
                                                <p class="mail_details">
                                                    <span class="customer_email">&lt;{{$mail->from}}&gt; </span>
                                                    <span class="mail_date"> {{$mail->recieveTime}}</span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="row panelheading_margin">
                                            <div class="col-sm-3">
                                                <div class="form_group custom_dropdown_toggle" >
                                                    <label class="display_label" id="customer_{{$mailCount}}">
                                                    <b>Customer : <span class="details_sec">{{((@$assaigned['customerName']=="")? "No customer selected":$assaigned['customerName'])}}</span></b> </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form_group custom_dropdown_toggle" >
                                                    <label class="display_label" id="customer_{{$mailCount}}">
                                                    <b>Agent : <span class="details_sec">{{((@$assaigned['customerAgentName']=="")? "No agent found":$assaigned['customerAgentName'])}}</span></b> </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form_group custom_dropdown_toggle">
                                                    <label class="display_label" id="agent_{{$mailCount}}">
                                                    <b>Assigned to : <span class="details_sec">{{((@$assaigned['agentName']=="")? "Assigned person not selected" : $assaigned['agentName'])}}</span></b> </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form_group custom_dropdown_toggle">
                                                    <div class="custom_select">
                                                        
                                                            <label class="display_label" id="agent_{{$mailCount}}">
                                                            <b> Status:  <span class="details_sec">{{((@$assaigned['assaignStatusName']=="")? "No S selected" : $assaigned['assaignStatusName'])}}</span></b></label>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form_group custom_dropdown_toggle" >
                                                        <label class="display_label" id="customer_{{$mailCount}}">
                                                        <b>Closed at : <span class="details_sec">{{$mail->closedAt}}</b> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                </div>
                            </div>
                            <div id="{{$mailCount}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    
                                    @if ($mail->isAttach==1)
                                        @php
                                            $attachments=$mail->attachements;
                                            $attachmentCount=0;
                                        @endphp
                                        @foreach ($attachments as $file)
                                            @php
                                                $fileName=$file['attachName'];
                                                $id=$file['attachId'];
                                                $path=$file['attachPath'];
                                                $downloadName=explode('.',$fileName);
                                                $downloadName=$downloadName[0];
                                                $updatedName=@$file['updatedName'];
                                                $add="&name=".$fileName;
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form_group status_attachment_bottom">
                                                        <table style="width:100%;">
                                                            <tr>
                                                                <td  width="100px" valign="top">
                                                                    <div class="action-icon" style="margin-right: 10px;">
                                                                        <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment" 
                                                                        onclick="window.open('{{url($path)}}', 'Win 1','width=700, height=800, top=70, left=100, resizable=1, menubar=yes', true);">
                                                                            <i class="fa fa-eye">
                                                                            </i>
                                                                        </button>
                                                                        <a href="{{url('document/download?index='.$path.$add)}}" download="{{$downloadName}}">
                                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download" >
                                                                                <i class="fa fa-cloud-download">
                                                                                </i>
                                                                            </button>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td width="500px" valign="top">
                                                                    <div class="row" >
                                                                        <div class="custom_checkbox">
                                                                            <input type="checkbox" name="attachment_checkbox_{{$mailCount}}[]" id="{{$id}}" value="{{$id}}" onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mailCount}}')" class="inp-cbx" style="display: none">
                                                                            <label for="{{$id}}" class="cbx">
                                                                                <span class="checkbox_margin">
                                                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                    </svg>
                                                                                </span>
                                                                                <span class="attach_txt attachment_checkbox text_overflow" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="{{$fileName}}">{{$fileName}}</span>
                                                                            </label>
                                                                        </div>
                                                                        <span id="indicator_{{$mailCount.$attachmentCount}}">
                                                                            @if (@$file['isPostedToCustomer']==1)
                                                                                <span class="post_status">
                                                                                    <span class="status_textsize">Shared</span>
                                                                                </span>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $attachmentCount++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form_group attachement_bottom">
                                                    <div class="media">
                                                        <div class="media-left">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    
                                </div>
                                <div class="expand_action clearfix">
                                    <button class="btn pink_btn btn_action pull-right auto_modal"  id="button_open" type="button" onclick="showMail('{{$mail->_id}}')">Open Email</button> 
                                    <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="comment" id="button_post" type="button" onclick="viewComments('{{$mail->_id}}')">Comments</button> 
                                    <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button" onclick="setForwardTo('{{$mail->_id}}')">Forward Email</button>                                                 
                                    <div id="button_show{{$mail->_id}}" style="display: none;">
                                        <button class="btn pink_btn btn_action pull-right btn_download" id="bulk_download_{{$mailCount}}" type="button" onclick="bulkDownload('{{$mailCount}}', '{{$mail->_id}}')">Download</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $mailCount++;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div> 
</div>  --}}

{{-- section_details ends --}}


    <!-- comment Popup -->
    <div id="comment"> 
        <div class="cd-popup comment_modal">
            <form method="post">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        {{-- <div class="clearfix"> --}}
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
                        {{-- </div> --}}
                    </div>
                    <a class="cd-popup-close img-replace"></a>
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
    <!-- open email Popup ends -->   

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
                                        <select class="customer-data-ajax" id="mail_address" name="mail_address" multiple>
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
                        <button class="btn btn-primary btn_action pull-right" onclick="filter('{{$role}}', 0)" type="button">OK</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- filter Popup ends -->
    
    

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
    {{-- delete pop up --}}

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
                                        <h3 name="message" id="message" style="margin:0">Are you sure you want delete this document?</h3>
                                        <input type="hidden" id="hdn_mailId">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn_action" style="background-color:gray" onclick="hideMessage()" >Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="message_remove" onclick="deleteTask()">Delete</button>
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
        .filter_popup{
            max-width: 980px !important;
            width: 100% !important
        }
        .section_details{
            max-width: 100%;
        }
        .select2-container {
            z-index: 999999999;
        }
        .select2.select2-container.select2-container--default {
            width: 100%!important;
        }
        .display_label{
            /* color: #264cd8;  */
            color: #cc3766;
            font-size: 12px;
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
       .select_dropdown1 .select2-container{
            z-index: 99 !important           
        }
    </style>
@endsection


@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>

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

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<script>
    var paginationFactor="{{Config::get('documents.pagination_factor')}}";
    paginationFactor=Number(paginationFactor);
    var forwardsetting=0;
    var forwardCcSetting=0;
    var wrongTags=[];
    var wrongCcTages=[];
    var emptyMail=0;
    var fromDate;
    var toDate;

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
        var markup = repo.text;
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

    $('#mail_address').select2({
        ajax: {
            url: '{{URL::to('document/get-mail-from-filter')}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    key: params.term, // search term
                    page: params.page,
                    status: 0,
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
        placeholder: "Select mail id",
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
    var oldCache="{{session('closedOldCache')}}";
    if(oldCache!=user)
    {
        $('#filter').css('color','');
        sessionStorage.removeItem('closeDoc.statusFilter');
        sessionStorage.removeItem("closeDoc.customersFilter");
        sessionStorage.removeItem("closeDoc.agentsFilter");
        sessionStorage.removeItem("closeDoc.customerAgentsFilter");
        sessionStorage.removeItem("closeDoc.from");
        sessionStorage.removeItem('closeDoc.fromDate');
        sessionStorage.removeItem('closeDoc.toDate');
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
    var mailFrom= sessionStorage.getItem("closeDoc.from");
    var fromDate = sessionStorage.getItem('closeDoc.fromDate');
    var toDate = sessionStorage.getItem('closeDoc.toDate');
    mailFrom= mailFrom? JSON.parse(mailFrom) : null;
    fromDate= fromDate? JSON.parse(fromDate) : null;
    toDate= toDate? JSON.parse(toDate) : null;

    stat=JSON.parse(sessionStorage.getItem("closeDoc.statusFilter"));
    if(stat==null)
    {
        var stat=[];
    }
    cust=JSON.parse(sessionStorage.getItem("closeDoc.customersFilter"));
    if(cust==null)
    {
        var cust=[];
    }
    custAgent=JSON.parse(sessionStorage.getItem("closeDoc.customerAgentsFilter"));
    if(custAgent==null)
    {
        var custAgent=[];
    }
    agen=JSON.parse(sessionStorage.getItem("closeDoc.agentsFilter"));
    if(agen==null)
    {
        var agen=[];
    }
    // console.log(stat.lenth);
    if(cust.length || agen.length || stat.length || custAgent.length || mailFrom || fromDate || toDate)
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

var page = 0;
$(document).ready(function(){
    filterColorChange();
    initialFilterColor();

    $.validator.addMethod("alpha",function(value,element){
        return this.optional(element) || (/^[a-zA-Z -_.]*$/i).test(value);
    });

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
                    status: 0
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
                $('[data-toggle="tooltip"]').tooltip();
            }
        }
    }
});

function loadMoreData(page){
    $('.ajax-load').show();
    var mailSwitch=$('#customSort').val();
    var search=$('#search_key').val();
    $('#after_load').val('loading');
    $.ajax(
    {
        url: "{{url('document/closed-documents')}}",
        type: "get",
        data:{
            page:page,
            search2:search,
            box:mailSwitch
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
            $('[data-toggle="tooltip"]').tooltip('update');
        }
    })  
}

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
                            $('#message').text("Sorry! can't forwarded mail at the moment");                
                            $('#message_popup .cd-popup').addClass('is-visible');
                        }
                    }
                });
    

}

function downloadAttachment(path, add)
{
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('[data-toggle="tooltip"]').tooltip('enable');
    window.location.href="{{url('document/download?index=')}}"+path+add;
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

function showFilter(totalMail,mailStatus,role){
    
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
    var customerStore=sessionStorage.getItem("closeDoc.customersFilter");
    customerStore=JSON.parse(customerStore);
    var fromStore=null;
    var fromDate="";
    var toDate="";
    fromStore = sessionStorage.getItem("closeDoc.from");
    fromStore = fromStore?JSON.parse(fromStore):null;
    fromDate = sessionStorage.getItem('closeDoc.fromDate');
    fromDate = fromDate?JSON.parse(fromDate):null;
    toDate = sessionStorage.getItem('closeDoc.toDate');
    toDate = toDate?JSON.parse(toDate):null;
    $.ajax({
        type: 'post',
        url: "{{url('document/filter-options')}}",
        data:
        {
            _token:'{{csrf_token()}}',
            mailbox: mailBox,
            status: mailStatus,
            customers: customerStore,
            role: role
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
            var statusStore=sessionStorage.getItem("closeDoc.statusFilter");
            statusStore= JSON.parse(statusStore);
            var agentStore=sessionStorage.getItem("closeDoc.agentsFilter");
            agentStore= JSON.parse(agentStore);
            var customerAgentStore=sessionStorage.getItem("closeDoc.customerAgentsFilter");
            customerAgentStore= JSON.parse(customerAgentStore);
            for(i=0;i<length;i++)
            {
                if(statusList[i].closureProperty==1)
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
            $('#customer_list').html("");
            $('#customer_list').val("").trigger('change');
            if(customers)
            {
                customers.forEach(function(item){
                    $('#customer_list').append(
                        '<option value="'+item._id+'" selected>'+item.fullName+'</option>'
                    );
                });
                $('#customer_list').trigger('change');
            }
            if(fromStore) {
                $('#mail_address').html("");
                $('#mail_address').val(null).trigger('change');
                fromStore.forEach(function(item) {
                    var selected= new Option(item,item,true,true);
                    $('#mail_address').append(selected);

                });
                $('#mail_address').trigger('change');
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
    $('#mail_address').val(null).trigger('change');
    $('#from_date').data("DateTimePicker").clear();
    $('#to_date').data("DateTimePicker").clear();
}



function filter(role, mailStatus)
{
    $('#document_mail_filter .cd-popup').removeClass('is-visible');
    $('#load_spinner').show();
    var statusDetails=[];
    var customerDetails=[];
    var agentDetails=[];
    var customerAgentDetails=[];
    var statusLength=$('input[name="status_list[]"]').length;
    var customerLength=$('input[name="customer_list[]"]').length;
    var agentsLength=$('input[name="agent_list[]"]').length;
    var customerAgentsLength=$('input[name="customer_agent_list[]"]').length;
    
    var mailFrom = $('#mail_address').val();
    var fromDate = $('#from_date').val();
    var toDate = $('#to_date').val();
    console.log(fromDate, toDate, JSON.stringify(fromDate), JSON.stringify(toDate));
    sessionStorage.removeItem('doc');
    sessionStorage.setItem('closeDoc.from',JSON.stringify(mailFrom));
    sessionStorage.setItem('closeDoc.fromDate', JSON.stringify(fromDate));
    sessionStorage.setItem('closeDoc.toDate', JSON.stringify(toDate));
    // console.log(mailFrom, fromDate, toDate);
    // return;
    
    for(i=0;i<statusLength;i++)
    {
        if($('#cbx_status_'+i).is(':checked'))
        statusDetails.push($('#cbx_status_'+i).val());
    }
    sessionStorage.setItem('closeDoc.statusFilter',JSON.stringify(statusDetails));
    // for(i=0;i<customerLength;i++)
    // {
    //     if($('#cbx_customer_'+i).is(':checked'))
    //     customerDetails.push($('#cbx_customer_'+i).val());
    // }
    customerDetails=$('#customer_list').val();
    console.log(customerDetails);
    sessionStorage.setItem('closeDoc.customersFilter',JSON.stringify(customerDetails));
    for(i=0;i<agentsLength;i++)
    {
        if($('#cbx_agent_'+i).is(':checked'))
        agentDetails.push($('#cbx_agent_'+i).val());
    }
    sessionStorage.setItem('closeDoc.agentsFilter',JSON.stringify(agentDetails));
    for(i=0;i<customerAgentsLength;i++)
    {
        if($('#cbx_customer_agent_'+i).is(':checked'))
        customerAgentDetails.push($('#cbx_customer_agent_'+i).val());
    }
    sessionStorage.setItem('closeDoc.customerAgentsFilter',JSON.stringify(customerAgentDetails));
    $('#after_load').val('loading');
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
            filterColorChange();
            $("#post-data").html("");
            $("#post-data").append(result.documentOperation);
            $('#after_load').val('loadComplete');
            page=0;
            $("#total_count").val(result.countMails);
            $("#spanCount").html(result.countMails);
            // $('#matter').html(result);
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
    $('.cd-popup').removeClass('is-visible');
    $('#message').text(""); 
    $('#message').html("");               
}

$('#accordion').on('collapsed', function () {
    $('#accordion .show').collapse('hide');
});

function showMail(index)
{
    $('#load_spinner').show();
    $.ajax({
            method: 'post',
            url: '{{url('document/get-mail-content')}}',
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
    $('#load_spinner').show();
    var mailSwitch=$('#customSort').val();
    $('#after_load').val('loadComplete');
    window.location.href='{{url("document/closed-documents?box=")}}'+mailSwitch+'&oldUser={{$user}}';
}


function viewComments(index)
{
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
               
                $("#chat").animate({scrollTop :$("#chat").get(0).scrollHeight},1000);
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

            }
        });
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
                    // fileName=fileName[fileName.length-1];
                    fileName=fileName.split(".");
                    fileName=fileName[0];
                    path="{{url('document/download?index=')}}"+item.attachPath+"&name="+item.attachName;
                    downloadCarrier.href=path;
                    downloadCarrier.download=fileName;
                    downloadCarrier.click();

                }
                attachCount++;
                
            });
        }
    });
   $('#dynamicDownload').remove();
}

function customerView()
{
    window.open("{{url('document/admin-customer-view')}}","New window","top=70,left=400,height=800,width=1400");

}

function showConfirmation(index)
{
    $('#hdn_mailId').val(index);
    $('#mdl_confirm .cd-popup').addClass('is-visible');
}

function deleteTask()
{
    var index= $('#hdn_mailId').val();
    $.ajax({
        type: "post",
        url: "{{url('document/delete-task')}}",
        data:
        {
            _token: "{{csrf_token()}}",
            index: index
        },
        success: function(response)
        {
            if(response)
            {
                hideMessage();
                $('#message').text("Document deleted successfully!");                
                $('#message_popup .cd-popup').addClass('is-visible');
                $('#mail_'+index).fadeOut('slow',function(){
                    $('#mail_'+index).remove();
                });
            } else {
                $('#message').text("Document deletion failed!");                
                $('#message_popup .cd-popup').addClass('is-visible');
            }
        }
    });
}




</script>
@endpush