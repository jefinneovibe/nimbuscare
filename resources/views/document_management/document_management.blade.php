
@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
    </style>
    <div class="section_details">
        <div class="card_header card_header_flex  clearfix">
            <h3 class="title">Document Management</h3>
            <div class="right_section">
                <div class="search_sec">
                    <div class="media">
                        <div class="media-body">
                            <form class="search_form">
                                <input type="text" placeholder="Search.." name="search2">
                                <button type="buton"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="sort">
                    <div class="custom_select">
                        <select class="form_input" id="customSort" name="customSort">
                            <option value="" data-display-text="">select email id</option>
                            <option value="ai
                            Arun	02/11/2018	02/11/2018
                            Arun	03/11/2018	07/11/2018
                            Arun	13/11/2018	14/11/2018
                            Camille Perez	22/11/2018	13/02/2019
                            Iskandar Deeb	21/11/2018	21/11/2018
                            Iskandar Deeb	21/11/2018	21/11/2018
                            Jinu	15/11/2018	15/11/2018
                            Raseena Anwar Salman	21/11/2018	24/11/2018
                            Rows per page:
                            swarya@neovibe.in">aiswarya@neovibe.in</option>
                            <option value="archana@neovibe.in">archana@neovibe.in</option>
                            <option value="shijin@neovibe.in">shijin@neovibe.in</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="filter_sec">
                    <a class="po__trigger--center button" id ="filter" data-layer-id="customer_layer" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Filter" aria-describedby="tooltip978357"><i class="material-icons">filter_list</i></a>
                </div> --}}
                <div class="filter_sec">
                    <button class="btn export_btn waves-effect" id ="filter" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="Filter">
                        <i class="material-icons">filter_list</i>
                    </button>
                </div>
            </div>
        </div>   
        <div class="card_content">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist">
                            <div class="panel panel-default document_panel">
                                <div class="panel-heading clearfix" role="tab" id="headingOne">
                                        <div class="row">
                                            <div class="col-md-8">
                                           <div class="panel_open">
                                                <a class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapseOne">
                                                <label class="form_label mail_subject">Document Management for iib</label>
                                                <p class="mail_details">
                                                    {{-- <span class="customer_name"> Aiswarya</span>  --}}
                                                    <span class="customer_email">&lt;aiswarya@neovibe.in&gt; </span>
                                                    <span class="mail_date"> Mon, Mar 11, 2019 at 6:29 PM</span>
                                                </p>
                                                </a>
                                            </div>
                                                <div class="row header_dropdown">
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                <option value="">Select Customer Name and ID </option>
                                                                <option value="">Aiswarya(DM-10110) </option>
                                                                <option value="">Archana(DM-101111) </option>
                                                                <option value="">Karthika(DM-10112) </option>
                                                                <option value="">Shijin(DM-10113) </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            {{-- <label class="form_label">Assigned to <span>*</span></label>  --}}
                                                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                    <option value="">Assigned to </option>
                                                                    <option value="">Aiswarya </option>
                                                                    <option value="">Archana </option>
                                                                    <option value="">Karthika </option>
                                                                    <option value="">Shijin </option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            <div class="custom_select">
                                                                {{-- <select class="form_input_status form_input"> --}}
                                                                <select class="selectpicker">    
                                                                    <option value="">Select Status</option>
                                                                    <option value="1">Completed</option>
                                                                    <option value="2">Partially Processed</option>
                                                                    <option value="3">Incorrect Invoice</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn pink_btn pull-right custom_btn" id="button_close" type="button">Close</button>
                                                <button class="btn pink_btn pull-right custom_btn" id="button_save" type="button">Save</button>
                                                <button class="btn blue_btn pull-right custom_btn" id="button_save_submit" type="button">Save & Submit</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form_group attachement_bottom">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="custom_checkbox">
                                                                <input type="checkbox" name="" id="attachment1" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                    <label for="attachment1" class="cbx">
                                                                        <span class="checkbox_margin">
                                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="attach_txt attachment_checkbox">Attachment 1</span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="form_group">
                                                                <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="action-icon">
                                                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom"  data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                            {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form_group attachement_bottom">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="custom_checkbox">
                                                                <input type="checkbox" name="" id="attachment2" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                    <label for="attachment2" class="cbx">
                                                                        <span class="checkbox_margin">
                                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="attach_txt attachment_checkbox">Attachment 2</span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="form_group attachement_bottom">
                                                                <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="action-icon">
                                                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                            {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="expand_action clearfix">
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="open_email" id="button_open" type="button">Open Email</button> 
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button">Forward Email</button> 
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="comment" id="button_post" type="button">Comments</button> 
                                            <div id="button_show" style="display: none;">
                                                <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Download</button> 
                                                <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Post to Customer</button> 
                                            </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Confirmation mail for iib --}}

                            <div class="panel panel-default document_panel">
                                <div class="panel-heading clearfix" role="tab" id="headingTwo">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="panel_open">
                                                <a class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapseTwo">  
                                                <label class="form_label mail_subject">Confirmation mail for iib</label>
                                                <p class="mail_details">
                                                    {{-- <span class="customer_name"> Aiswarya</span>  --}}
                                                    <span class="customer_email">&lt;shijin@neovibe.in&gt; </span>
                                                    <span class="mail_date"> Tue, Mar 12, 2019 at 7:30 PM</span>
                                                </p>
                                                        </a>
                                                    </div>
                                                <div class="row header_dropdown">
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                <option value="">Select Customer Name and ID </option>
                                                                <option value="">Aiswarya(DM-10110) </option>
                                                                <option value="">Archana(DM-101111) </option>
                                                                <option value="">Karthika(DM-10112) </option>
                                                                <option value="">Shijin(DM-10113) </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            {{-- <label class="form_label">Assigned to <span>*</span></label>  --}}
                                                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                    <option value="">Assigned to </option>
                                                                    <option value="">Aiswarya </option>
                                                                    <option value="">Archana </option>
                                                                    <option value="">Karthika </option>
                                                                    <option value="">Shijin </option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form_group custom_dropdown_toggle">
                                                            <div class="custom_select">
                                                                {{-- <select class="form_input_status form_input"> --}}
                                                                <select class="selectpicker">     
                                                                    <option value="">Select Status</option>
                                                                    <option value="1">Completed</option>
                                                                    <option value="2">Partially Processed</option>
                                                                    <option value="3">Incorrect Invoice</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <button class="btn pink_btn pull-right custom_btn" id="button_close" type="button">Close</button>
                                                <button class="btn pink_btn pull-right custom_btn" id="button_save" type="button">Save</button>
                                                <button class="btn blue_btn pull-right custom_btn" id="button_save_submit" type="button">Save & Submit</button>
                                            </div>
                                        </div>
                                    </a>
                                </div>
    
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form_group attachement_bottom">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="custom_checkbox">
                                                                <input type="checkbox" name="" id="confirmation_attachment1" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                <label for="confirmation_attachment1" class="cbx">
                                                                    <span class="checkbox_margin">
                                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="attach_txt attachment_checkbox">Attachment 1</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="form_group">
                                                                <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="action-icon">
                                                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                            {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form_group attachement_bottom">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="custom_checkbox">
                                                                <input type="checkbox" name="" id="confirmation_attachment2" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                    <label for="confirmation_attachment2" class="cbx">
                                                                        <span class="checkbox_margin">
                                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="attach_txt attachment_checkbox">Attachment 2</span>
                                                                    </label>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="form_group attachement_bottom">
                                                                <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="action-icon">
                                                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                            <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                            {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="expand_action clearfix">
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="open_email" id="button_open" type="button">Open Email</button> 
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button">Forward Email</button> 
                                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="comment" id="button_post" type="button">Comments</button> 
                                            <div id="button_show" style="display: none;">
                                                <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Download</button> 
                                                <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Post to Customer</button> 
                                            </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Confirmation mail for iib --}}


                          {{-- Success mail for iib --}}

                            <div class="panel panel-default document_panel">
                                    <div class="panel-heading clearfix" role="tab" id="headingThree">
                                            <div class="row">
                                                <div class="col-md-8">
                                                <div class="panel_open">
                                                <a class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapseThree">
                                                    <label class="form_label mail_subject">Success mail for iib</label>
                                                    <p class="mail_details">
                                                        {{-- <span class="customer_name"> Aiswarya</span>  --}}
                                                        <span class="customer_email">&lt;archana@neovibe.in&gt; </span>
                                                        <span class="mail_date"> Wed, Mar 13, 2019 at 12:00 PM</span>
                                                    </p>
                                                </a>
                                                </div>
                                                    <div class="row header_dropdown">
                                                        <div class="col-sm-4">
                                                            <div class="form_group custom_dropdown_toggle">
                                                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                    <option value="">Select Customer Name and ID </option>
                                                                    <option value="">Aiswarya(DM-10110) </option>
                                                                    <option value="">Archana(DM-101111) </option>
                                                                    <option value="">Karthika(DM-10112) </option>
                                                                    <option value="">Shijin(DM-10113) </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form_group custom_dropdown_toggle">
                                                                {{-- <label class="form_label">Assigned to <span>*</span></label>  --}}
                                                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType">
                                                                        <option value="">Assigned to </option>
                                                                        <option value="">Aiswarya </option>
                                                                        <option value="">Archana </option>
                                                                        <option value="">Karthika </option>
                                                                        <option value="">Shijin </option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form_group custom_dropdown_toggle">
                                                                <div class="custom_select">
                                                                    {{-- <select class="form_input_status form_input"> --}}
                                                                <select class="selectpicker"> 
                                                                        <option value="">Select Status</option>
                                                                        <option value="1">Completed</option>
                                                                        <option value="2">Partially Processed</option>
                                                                        <option value="3">Incorrect Invoice</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn pink_btn pull-right custom_btn" id="button_close" type="button">Close</button>
                                                    <button class="btn pink_btn pull-right custom_btn" id="button_save" type="button">Save</button>
                                                    <button class="btn blue_btn pull-right custom_btn" id="button_save_submit" type="button">Save & Submit</button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
        
                                    <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form_group attachement_bottom">
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <div class="custom_checkbox">
                                                                    <input type="checkbox" name="" id="success_attachment1" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                    <label for="success_attachment1" class="cbx">
                                                                        <span class="checkbox_margin">
                                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="attach_txt attachment_checkbox">Attachment 1</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="form_group">
                                                                    <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="action-icon">
                                                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                                <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                                {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form_group attachement_bottom">
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <div class="custom_checkbox">
                                                                    <input type="checkbox" name="" id="success_attachment2" onclick="checkFunction()" class="inp-cbx" style="display: none">
                                                                        <label for="success_attachment2" class="cbx">
                                                                            <span class="checkbox_margin">
                                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                </svg>
                                                                            </span>
                                                                            <span class="attach_txt attachment_checkbox">Attachment 2</span>
                                                                        </label>
                                                                </div>
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="form_group attachement_bottom">
                                                                    <input class="attachment_textbox form_input" placeholder="Update the name" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="action-icon">
                                                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"><i class="fa fa-eye"></i></button>
                                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                                                <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Post to Customer"><i class="fa fa-pencil-square-o"></i></button>
                                                                {{-- <button class="btn attachment_post_btn custom_btn auto_modal" data-modal="post_customer" id="button_post" type="button">Post to Customer</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="expand_action clearfix">
                                            <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="open_email" id="button_open" type="button">Open Email</button> 
                                            <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button">Forward Email</button> 
                                            <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="comment" id="button_post" type="button">Comments</button> 
                                                <div id="button_show" style="display: none;">
                                                    <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Download</button> 
                                                    <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" >Post to Customer</button> 
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Success mail for iib --}}

                                
                        </div>
                    </div>
                </div>
                {{-- row ends --}}
            </div>
        </div> 
        {{-- card_content ends --}}
        
    </div>
    {{-- section_details ends --}}


    <!-- filter Popup -->
    <div id="document_mail_filter">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container">
                        <div class="modal_content">
                                <div class="clearfix">
                                    <h1 class="pull-left">Filter</h1>
                                    <button class="reset" id="reset_button" type="button">Reset</button>
                                </div>
                                <div class="content_spacing">
                                    <div class="filter__row clearfix">
                                        <div class="space__div" id="filter_type_div">
                                            <h4 class="filter_head">Status</h4>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="0" id="cbx1" class="inp-cbx mem_status_all mem_status_type reset_all" style="display: none">
                                                <label for="cbx1" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Completed</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="1" name="mem_status[]" id="cbx2" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx2" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Partially Processed</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="2" name="mem_status[]" id="cbx3" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx3" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Incorrect Invoice</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="3" checked="" name="mem_status[]" id="cbx4" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx4" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Completed</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="4" name="mem_status[]" id="cbx5" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx5" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Incorrect Invoice</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="5" name="mem_status[]" id="cbx6" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx6" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Partially Processed</span>
                                                </label>
                                            </div>
                                            <div class="custom_checkbox">
                                                <input type="checkbox" value="6" name="mem_status[]" id="cbx7" class="inp-cbx select_mem_status mem_status_type not_reset" style="display: none">
                                                <label for="cbx7" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span>Completed</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="space__div" id="filter_type_div">
                                            <h4 class="filter_head">Customer Name</h4>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="00" checked="" id="cm1" class="inp-cbx platform_all platforms reset_all" style="display: none">
                                                    <label for="cm1" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Aiswarya</span>
                                                    </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="01" id="cm2" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm2" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Archana</span>
                                                    </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="02" id="cm3" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm3" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Shijin</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="03" id="cm4" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm4" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Karthika</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="04" id="cm5" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm5" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Aneesh</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="05" id="cm6" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm6" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Teena</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="06" id="cm7" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="cm7" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Rebeka</span>
                                                        </label>
                                                </div>
                                            </div>
                                            <div class="space__div" id="filter_type_div">
                                                <h4 class="filter_head">Assigned To</h4>
                                              <div class="custom_checkbox">
                                                    <input type="checkbox" value="10"  id="as1" class="inp-cbx platform_all platforms reset_all" style="display: none">
                                                    <label for="as1" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Aiswarya</span>
                                                    </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="10" id="as2" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as2" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Archana</span>
                                                    </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="12" id="as3" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as3" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Shijin</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="13" checked="" id="as4" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as4" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Karthika</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="14" id="as5" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as5" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Aneesh</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="15" id="as6" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as6" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Teena</span>
                                                        </label>
                                                </div>
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" value="16" id="as7" class="inp-cbx platforms not_reset" name="platform[]" style="display: none">
                                                    <label for="as7" class="cbx">
                                                        <span>
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span>Rebeka</span>
                                                        </label>
                                                </div>  
                                            </div>
                                        </div>
                                </div>
                            </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn_action pull-right" type="button">OK</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                    </div>
                    {{-- <a href="#0" class="cd-popup-close img-replace"></a> --}}
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
                                        <span><h1 id="success_message">Post Customer</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form_group">
                                             <label class="form_label">To <span>*</span></label>  
                                            <select class="js-example-basic-multiple-post" id="select_name" name="state[]" multiple="multiple" >
                                                <option value="ai" selected>Aiswarya</option>
                                                <option value="ar">Archana</option>
                                                <option value="ka">Karthika</option>
                                                <option value="sh">Shijin</option>
                                            </select>
                                        </div>
                                        <div class="custom_checkbox">
                                            <input type="checkbox" checked name="" id="name1" class="inp-cbx" style="display: none">
                                                <label for="name1" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span class="attach_txt">Attachment 1</span>
                                                </label>
                                        </div>
                                        <div class="custom_checkbox">
                                            <input type="checkbox" checked name="" id="name2" class="inp-cbx" style="display: none">
                                                <label for="name2" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span class="attach_txt">Attachment 2</span>
                                                </label>
                                        </div>
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="" id="name3"  class="inp-cbx" style="display: none">
                                                <label for="name3" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span class="attach_txt">Attachment 3</span>
                                                </label>
                                        </div>
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="" id="name4"  class="inp-cbx" style="display: none">
                                                <label for="name4" class="cbx">
                                                    <span>
                                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                        </svg>
                                                    </span>
                                                    <span class="attach_txt">Attachment 4</span>
                                                </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn_action pull-right" type="button">Send</button>
                        <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                    </div>
                    <a href="#0" class="cd-popup-close img-replace"></a>
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
                                                {{-- <header>
                                                    <h3 class="card_sub_heading">Comments</h3>
                                                </header> --}}
                                                <ul id="chat">
                                                    <li class="you">
                                                        <div class="entete">
                                                                <h3 style="font-style: italic">  Admin - <span> 11/03/2019  - 14:20:21</span> - <b style="font-style: normal">sample msg</b></h3> 
                                                                {{-- <span id="comment"> No comments available.</span>  --}}
                                                        </div>
                                                    </li>
                                                    <li class="you">
                                                        <div class="entete">
                                                            <h3 style="font-style: italic">  Admin - <span> 11/03/2019  - 14:20:32</span> - <b style="font-style: normal">sample msg</b>
                                                            </h3>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <footer>
                                                    <textarea id="new_comment" name="new_comment" placeholder="Type your comment..." onkeyup="post()"></textarea>
                                                        <a  title="Send" class="send_btn" ><i class="material-icons"> send </i></a>
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
                                            <div class="form_group">
                                                 <label class="form_label">To <span>*</span></label>  
                                                <select class="js-example-basic-multiple" id="email_forward" name="email[]" multiple="multiple" >
                                                    <option value="ai">aiswarya@neovibe.in</option>
                                                    <option value="ar">archana@neovibe.in</option>
                                                    <option value="ka">karthika@neovibe.in</option>
                                                    <option value="sh">shijin@neovibe.in</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn-primary btn_action pull-right" type="button">Send</button>
                            <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                        </div>
                        <a href="#0" class="cd-popup-close img-replace"></a>
                    </div>
                </form>
            </div>
        </div> <!-- forward email Popup ends -->   
        

<!-- open email Popup -->
<div id="open_email">
        <div class="cd-popup">
            <form method="post">
                <div class="cd-popup-container">
                    <div class="modal_content">
                        <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><h1 id="success_message">Document management for iib</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mail_details">
                                            <span class="customer_email">&lt;aiswarya@neovibe.in&gt; </span>
                                            <span class="mail_date"> Mon, Mar 11, 2019 at 6:29 PM</span>
                                        </p>
                                        <p class="mail_content">Dear All,</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
                                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                                            ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                         <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>   
                                    </div>
                                </div>
                            </div>
                    </div>
                    <a href="#0" class="cd-popup-close img-replace"></a>
                </div>
            </form>
        </div>
    </div> <!-- open email Popup ends -->   



    <style>
        .section_details{
            max-width: 100%;
        }
        .select2-container {
            z-index: 999999999;
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
        .sort .custom_select .dropdown {
            width: 200px;
            border: 1px solid #dddddd;
            padding: 7px 0 0 15px;
        }
    </style>
    
@endsection


@push('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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


<script>
 $('#filter').on('click', function(){
        $('#document_mail_filter .cd-popup').addClass('is-visible');
    });   

// $('#button_post').on('click', function(){
//     $(".js-example-basic-multiple").select2();
//         $('#post_customer .cd-popup').addClass('is-visible');
       
        
//     });     
$('#accordion').on('collapsed', function () {
    $('#accordion .show').collapse('hide');
});

function checkFunction() {
    var checkBox = document.getElementById("attachment1");
    var text = document.getElementById("button_show");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
}


</script>
@endpush


