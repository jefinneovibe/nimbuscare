<div>        
               
    @foreach($mailBoxes as $mailBox)
    @php
        if ($user==$mailBox->userID)
        {
            $currentMailBox=$mailBox->statusAvailable;
        }
    @endphp
    @endforeach
    @php
        $role= session('role'); 
        if($role== 'Agent' || $role== 'Coordinator') {
            $permission= 'disabled';
        } else {
            $permission="";
        }
        $mailCount=0;
        if(count($data)<=0)
        {
            echo "<h4> No document found</h4>";
        }

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
        <div class="panel panel-default document_panel" id="mail_{{$mail->_id}}">
            <div class="panel-heading clearfix" role="tab" id="headingOne">
                <div class="row">
                    <div class="col-md-10" id="mail_bar_{{$mail->_id}}">
                        <div class="panel_open">
                            <a id="panel_{{$mail->_id}}" class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#{{$mail->_id}}" aria-expanded="false" aria-controls="collapseOne" style="margin: 0 11px;">
                                @if ($mail->subject=="")
                                    <label class="form_label mail_subject">(No Subject)</label>
                                @else
                                    <label class="form_label mail_subject">
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
                                    <label class="display_label" id="customer_{{$mail->_id}}">
                                    <b>Customer : <span class="details_sec">{{((@$assaigned['customerName']=="")? "No customer selected":$assaigned['customerName'])}}</span></b> </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle" >
                                    <label class="display_label" id="customer_agent_{{$mail->_id}}">
                                    <b>Agent : <span class="details_sec">{{((@$assaigned['customerAgentName']=="")? "No agent found":$assaigned['customerAgentName'])}}</span></b> </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form_group custom_dropdown_toggle">
                                    <label class="display_label" id="agent_{{$mail->_id}}">
                                    <b>Assigned to : <span class="details_sec">{{((@$assaigned['agentName']=="")? "No assigned person selected" : $assaigned['agentName'])}}</span></b> </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle">
                                    <div class="custom_select">
                                        <label class="display_label" id="agent_{{$mail->_id}}">
                                        <b> Status: <span class="details_sec">{{((@$assaigned['assaignStatusName']=="")? "No status selected" : $assaigned['assaignStatusName'])}}</span></b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle" >
                                    <label class="display_label" id="customer_{{$mail->_id}}">
                                    <b>Closed at : <span class="details_sec">{{$mail->closedAt}}</span></b> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding-right:50px;">
                        {{-- <button class="btn pink_btn pull-right custom_btn" id="button_close_{{$mail->_id}}"
                        onclick="deleteTask('{{$mail->_id}}')" type="button" >Delete</button> --}}
                        @if(session('role') == 'Admin')
                            <button type="button"class="btn export_btn waves-effect auto_modal delete_icon_btn pull-right" style="margin-top:1em;"
                            data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  onclick="showConfirmation('{{$mail->_id}}')">
                                <i class="material-icons">delete_outline</i>
                            </button>
                        @endif
                        {{-- <button class="btn pink_btn pull-right custom_btn" id="button_save_{{$mailCount}}" type="button" onclick="saveMail('{{$mailCount}}','{{$mail->_id}}')">Save</button> --}}
                        {{-- @if($role=='Admin' || @$assaigned['agentId']==Auth::user()->_id)
                            <button class="btn blue_btn pull-right custom_btn" id="button_save_submit_{{$mailCount}}" type="button" onclick="saveAndSubmit('{{$mailCount}}','{{$mail->_id}}')">Save & Submit</button>
                        @endif --}}
                    </div>
                </div>
            </div>
                <div id="{{$mail->_id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        
                        @if ($mail->isAttach==1)
                            @php
                                $attachments=$mail->attachements;
                                $attachmentCount=0;
                            @endphp
                            @foreach ($attachments as $file)
                                @php
                                    // $name=explode('/',$file['attachPath']);
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
                                                <td width="100px" valign="top">
                                                <div class="action-icon" style="margin-right: 10px;">
                                                    <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment" 
                                                    onclick="viewAttachment('{{$path}}')">
                                                        <i class="fa fa-eye">
                                                        </i>
                                                    </button>
                                                    <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom"
                                                    data-container="body" data-original-title="Download" onclick="downloadAttachment('{{$path}}', '{{$add}}')">
                                                        <i class="fa fa-cloud-download">
                                                        </i>
                                                    </button>
                                                    {{-- <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom"  data-original-title="Post to Customer"> 
                                                        <i class="fa fa-pencil-square-o">
                                                        </i>
                                                    </button> --}}
                                                    {{-- onclick="showPostCustomer('{{$mail->_id}}','{{$id}}','{{$mailCount}}','{{$attachmentCount}}')" --}}
                                                </div>
                                                </td>
                                                <td width="500px" valign="top">
                                                    <div class="row" >
                                                        <div class="custom_checkbox">
                                                        <input type="checkbox" name="attachment_checkbox_{{$mail->_id}}[]" id="{{$id}}" value="{{$id}}" onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mail->_id}}')"
                                                        class="inp-cbx" style="display: none" {{$permission}}>
                                                            <label for="{{$id}}" class="cbx">
                                                                <span class="checkbox_margin">
                                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                    </svg>
                                                                </span>
                                                                <span class="attach_txt attachment_checkbox text_overflow" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="{{$fileName}}">{{$fileName}}</span>
                                                            </label>
                                                        </div>
                                                        <span id="indicator_{{$mail->_id.$attachmentCount}}">
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
                                                <span class="attach_txt attachment_checkbox">No Attachments</span>
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
                        @if($role!= 'Agent' && $role!= 'Coordinator')
                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button" onclick="setForwardTo('{{$mail->_id}}')">Forward Email</button>
                            <div id="button_show{{$mail->_id}}" style="display: none;">
                                <button class="btn pink_btn btn_action pull-right btn_download" id="bulk_download_{{$mail->_id}}" type="button" onclick="bulkDownload('{{$mail->_id}}')">Download</button> 
                            </div>
                        @endif
                    </div>
                </div>
            
        </div>
        @php
            $mailCount++;
        @endphp
    @endforeach
</div>
    
    
        
    <style>
        .section_details{
            max-width: 100%;
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
            
    </style> 
    
    
    {{-- <script src="{{URL::asset('js/main/custom-select.js')}}"></script> --}}
    
    <!-- Bootstrap Select -->
    {{-- <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script> --}}

</div>


<script>
{{-- $('.selectpicker').selectpicker(); --}}

// function closeTab(index)
// { 
//   $('#'+index).collapse('hide');
// }

</script>
