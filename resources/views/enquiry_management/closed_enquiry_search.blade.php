               
    @foreach($mailBoxes as $mailBox)
    @php
        if ($user==$mailBox->userID)
        {
            $currentMailBox=$mailBox->statusAvailable;
            $currentMailBucket=$mailBox;   
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
                                    <label class="form_label mail_subject">{{$mail->subject}}</label>
                                @endif
                                <p class="mail_details">
                                    <span class="customer_email">&lt;{{$mail->from}}&gt; </span>
                                    <span class="mail_date"> {{$mail->recieveTime}}</span>

                                </p>
                            </a>
                        </div>

                        <div class="row insurerdetail_margin">
                            <div class="col-md-3">
                                <label class="display_label" id="customer_{{$mail->_id}}">
                                    <b>Customer : <span class="details_sec"> {{((@$assaigned['customerName']=="")? "No customer selected":$assaigned['customerName'])}}</span> </b> 
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="display_label" id="customer_{{$mail->_id}}">
                                    <b>Agent : <span class="details_sec"> {{((@$assaigned['customerAgentName']=="")? "No agent found":$assaigned['customerAgentName'])}} </span></b> 
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="display_label" id="renewal_{{$mail->_id}}">
                                    <b>Policy Premium : <span class="details_sec"> {{((@$mail['policyAmount']=="")? "Policy amount not entered":number_format($mail['policyAmount'],2))}}</span> </b> 
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="display_label" id="renewal_{{$mail->_id}}">
                                    <b>Renewal Date : <span class="details_sec"> {{((@$mail['renewalDate']=="")? "Renewal date not selected":$mail['renewalDate'])}}</span> </b> 
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="display_label" id="reminder_{{$mail->_id}}">
                                    <b>Reminder Date : <span class="details_sec"> {{((@$mail['reminderDate']=="")? "Reminder date not selected":$mail['reminderDate'])}}</span> </b> 
                                 </label>
                            </div>
                        </div>

                        <div class="row insurerdetail_margin">
                            <div class="col-sm-3">
                                <div class="form_group custom_dropdown_toggle" >
                                        <label class="display_label" id="insurer_{{$mail->_id}}">
                                        <b>Insurer : <span class="details_sec"> {{((@$assaigned['insurerName']=="")? "No insurer selected":$assaigned['insurerName'])}}</span> </b> </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form_group custom_dropdown_toggle">
                                    <label class="display_label" id="agent_{{$mail->_id}}">
                                    <b>Assigned to : <span class="details_sec"> {{((@$assaigned['agentName']=="")? "Assigned person not selected" : $assaigned['agentName'])}}</span> </b> </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle">
                                    <div class="custom_select">
                                        <label class="display_label" id="agent_{{$mail->_id}}">
                                        <b> Renewed: <span class="details_sec"> {{((@$mail->renewal==0)? "No" : "Yes")}}</span> </b></label>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle" >
                                        <label class="display_label" id="group_{{$mail->_id}}">
                                        <b>Group : <span class="details_sec txt_capitalize"> {{((@$assaigned['groupName']=="")? "No group selected":$assaigned['groupName'])}}</span> </b> </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form_group custom_dropdown_toggle" >
                                        <label class="display_label" id="customer_{{$mail->_id}}">
                                        <b>Closed at : <span class="details_sec"> {{$mail->closedAt}}</span> </b> </label>
                                </div>
                            </div>
                        </div>
                        <div class="row insurerdetail_margin">
                            <div class="col-sm-3">
                                <div class="form_group custom_dropdown_toggle">  
                                    <div class="custom_select">
                                        <label class="display_label" id="agent_{{$mail->_id}}">
                                        <b> Status: <span class="details_sec"> {{((@$assaigned['assaignStatusName']=="")? "No Status selected" : $assaigned['assaignStatusName'])}}</span> </b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form_group custom_dropdown_toggle">  
                                    <div class="custom_select">
                                        <label class="display_label" id="subStatus{{$mail->_id}}">
                                        <b>Sub Status: <span class="details_sec"> {{((@$assaigned['assaignSubStatusName']=="")? "No Sub status selected" : $assaigned['assaignSubStatusName'])}}</span> </b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session('role') == 'Admin')
                        <div class="col-md-2">
                            <button type="button"class="btn export_btn waves-effect auto_modal delete_icon_btn" style="margin-top: 4em" data-toggle="tooltip" data-placement="bottom" title="Delete" data-container="body"  onclick="showConfirmation('{{$mail->_id}}')">
                                <i class="material-icons">delete_outline</i>
                            </button>
                        </div>
                    @endif
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
                                                    </div>
                                                </td>
                                                <td width="400px" valign="top">
                                                    <div class="row" >
                                                        <div class="custom_checkbox">
                                                            <input type="checkbox" name="attachment_checkbox_{{$mail->_id}}[]" id="{{$id}}" value="{{$id}}"onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mail->_id}}')"
                                                            class="inp-cbx" style="display: none" {{$permission}}>
                                                            <label for="{{$id}}" class="cbx">
                                                                <span class="checkbox_margin">
                                                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                    </svg>
                                                                </span>
                                                                <span class="attach_txt attachment_checkbox text_overflow" data-toggle="tooltip" 
                                                                data-placement="bottom" data-container="body"
                                                                    data-original-title="{{$fileName}}">{{$fileName}}</span>
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
    @endforeach
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
</div>
<script>
$('.selectpicker').selectpicker();


</script>
