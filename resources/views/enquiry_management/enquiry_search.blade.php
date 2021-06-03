
<style>
.select2.select2-container.select2-container--default {
    z-index: 9 !important;
}
</style>
@foreach($mailBoxes as $mailBox)
@php
    if ($user==$mailBox->userID) {
        $currentMailBucket=$mailBox;
        $mailBoxId=$mailBox->_id;
            }
@endphp
@endforeach
@php
if(count($data)<=0) {
    echo "<h4>No documents found</h4>";
}
@endphp

@foreach ($data as $mail)
@php
$role= session('role');
if($role== 'Agent' || $role== 'Coordinator') {
    $permission= 'disabled';
} else {
    $permission="";
}
if(isset($mail->assaignedTo)) {
$assaigned=$mail->assaignedTo;
}
else {
    $assaigned=null;
}
if(isset($mail->dates)) {
    $dates=$mail->dates;
}
else {
    $dates=null;
}
@endphp
<style>
.dropdown-item{
    font-size: 0.7125rem !important;
}
.select2-results__option{
    font-size: 10px !important;

}
.label_new {
    font-size: 12px;
}

.filter-option.pull-left{
    white-space: nowrap;
    text-overflow: ellipsis;
}


</style>
<div class="panel panel-default document_panel" id="mail_{{$mail->_id}}">
    <input type="hidden" id="currentMailBucket" value="{{$mailBoxId}}">
    <div class="panel-heading clearfix" role="tab" id="headingOne">
        <div class="col-md-12">
            <div class="media">
                <div class="media-body" id="mail_bar_{{$mail->_id}}">
                    <div class="panel_open">
                        <a id="panel_{{$mail->_id}}" class="collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#{{$mail->_id}}" aria-expanded="false" aria-controls="collapseOne">
                            <?php $commentDisplay='';
                            $seen = $mail->commentSeen;
                            if (isset($seen)) {
                                if (!in_array(Auth::id(), $seen)) {
                                    $comments = $mail->comments;
                                    if ($comments) {
                                        $newComment = end($comments);
                                        $commentDisplay = $newComment['commentBy'].':'.$newComment['commentBody'];
                                    }
                                }
                            }
                            ?>
                            @if(@$commentDisplay!='')
                                @if ($mail->subject=="")
                                    <label class="form_label mail_subject">(No Subject) <i id="comment_id_{{$mail->_id}}" style="margin: 0 0 0 10px; font-size: 18px; color: #cd4277;" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$commentDisplay}}" class="fa fa-comments hideshow"></i></label>
                                @else
                                    <label class="form_label mail_subject">{{$mail->subject}}<i id="comment_id_{{$mail->_id}}" style="margin: 0 0 0 10px; font-size: 18px; color: #cd4277;" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$commentDisplay}}" class="fa fa-comments hideshow"></i></label>
                                @endif
                            @else
                                @if ($mail->subject=="")
                                <label class="form_label mail_subject">(No Subject)</label>
                                @else
                                    <label class="form_label mail_subject">{{$mail->subject}}</label>
                                @endif
                            @endif
                            <p class="mail_details" style="margin-bottom: 11px;">
                                <span class="customer_email">&lt;{{$mail->from}}&gt; </span>
                                <span class="mail_date"> {{$mail->recieveTime}}</span>
                            </p>
                        </a>

                    </div>
                </div>
                    @if($permission!='disabled')
                        @php
                        // dd($mail->assaignedTo['assaignSubStatusName']);
                            $style = 'none';
                            if(@$mail->assaignedTo['assaignStatus'] == 1 && @$mail->assaignedTo['assaignSubStatusName'] &&
                                @$mail->assaignedTo['agentId'] && @$mail->assaignedTo['agentId']!='999' &&
                                @$mail->assaignedTo['customerId'] && @$mail->assaignedTo['customerAgentId'])
                            {
                                $style = 'inherit';
                            }
                        @endphp
                        <div class="media-right">
                            <button class="btn blue_btn pull-right custom_btn enquiry_custom_btn" id="button_save_submit_{{$mail->_id}}" style="display:{{$style}};" onclick="showConfirmation('{{$mail->_id}}')" type="button">Save & Submit</button>
                            <button class="btn blue_btn pull-right custom_btn enquiry_custom_btn" id="button_save_{{$mail->_id}}" type="button" onclick="saveMail('{{$mail->_id}}', 'save')">Save</button>
                            <div class="renewl_checkbox" style="float: right;margin: 8px;">
                                <input type="checkbox" name="cbx_closure[]" value="1" id="cbx_renew_{{$mail->_id}}" class="inp-cbx" style="display: none"
                                    {{($mail->renewal==1)? "checked" : "" }}
                                        onclick="renewalCheck('{{$mail->_id}}')" {{$permission}}>
                                    <label for="cbx_renew_{{$mail->_id}}" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        <span style="font-size: 12px;">Renewal</span>
                                    </label>
                            </div>
                        </div>
                    @endif
            </div>
        </div>

        <div class="row form-group-btm" >
            <div class="col-md-3">
                <div class="media" style="margin-bottom: 3px;">
                    <div class="">
                        <label class="label_new" style="margin-left: 47px;">Customer</label>
                    </div>
                    <div class="media-right">
                        <div class="btn_padding" style="margin: 0px 0px 0px 7px;">
                                @if (isset($assaigned['customerId']) && $assaigned['customerId']!="")
                                    <button id="add_customer_{{$mail->_id}}" class="blue_btn add_btn_icon" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Add Customer" style="display: none;"
                                    onclick="addNewCustomer()" {{$permission}}>
                                            <i class="fa fa-plus"></i>
                                    </button>
                                    <button id="edit_customer_{{$mail->_id}}" class="blue_btn add_btn_icon edit_icon_bg" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Edit Customer"
                                    onclick="editCustomer('{{$mail->_id}}')" {{$permission}}>
                                            <i class="fa fa-pencil"></i>
                                    </button>
                                @else
                                    <button id="add_customer_{{$mail->_id}}" class="blue_btn add_btn_icon" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Add Customer"
                                    onclick="addNewCustomer()" {{$permission}}>
                                            <i class="fa fa-plus"></i>
                                    </button>
                                    <button id="edit_customer_{{$mail->_id}}" class="blue_btn add_btn_icon edit_icon_bg" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Edit Customer" style="display: none;"
                                    onclick="editCustomer('{{$mail->_id}}')" {{$permission}}>
                                            <i class="fa fa-pencil"></i>
                                    </button>
                                @endif
                        </div>
                    </div>
                </div>

                        {{-- <div class="form_group">
                            <div class="custom_select_dropdown enquiry_managmnt_dropdown" style="margin-left: 46px;">
                                <select data-hide-disabled="true" data-live-search="true" id="customer_{{$mail->_id}}" name="customer" onchange="showAgent('{{$mail->_id}}','{{$mail->_id}}')" {{$permission}}>
                                    @if(isset($assaigned))
                                        @if(isset($assaigned['customerId']))
                                            <option value="{{$assaigned['customerId']}}" selected>{{$assaigned['customerName']}}</option>
                                        @endif
                                    @endif
                                </select>
                                <div>
                                    <input type="hidden" id="cust_agnet_{{$mail->_id}}" value="{{$assaigned['customerAgentId']}}">
                                </div>
                            </div>
                        </div> --}}


                        <div class="form_group" style="margin-left: 48px;">
                            <div class="custom_select_dropdown enquiry_managmnt_dropdown">
                                <select data-hide-disabled="true" data-live-search="true" id="customer_{{$mail->_id}}" name="customer" onchange="showAgent('{{$mail->_id}}','{{$mail->_id}}')" {{$permission}}>
                                    @if(isset($assaigned))
                                        @if(isset($assaigned['customerId']))
                                            <option value="{{$assaigned['customerId']}}" selected>{{$assaigned['customerName']}}</option>
                                        @endif
                                    @endif
                                </select>
                                <div>
                                    <input type="hidden" id="cust_agnet_{{$mail->_id}}" value="{{$assaigned['customerAgentId']}}">
                                </div>
                            </div>
                        </div>



            </div>
            <div class="col-md-2">
                <label class="label_new">Agent</label>
                    <div class="media">
                        {{-- <div class="media-left">
                            <label style="margin: 6px 10px 0 0;" class="date_label">Agent : </label>
                        </div> --}}
                        <div class="media-body">
                            <div class="form_group">
                                <div class="custom_select_dropdown agent_dropdown">
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="" id="agent_detail_{{$mail->_id}}" onchange="checkClosure('{{$mail->_id}}')" {{$permission}}>
                                        <option selected value="" name="assign">Select Agent</option>
                                        @if(!empty($agents))
                                            @forelse($agents as $agent)
                                            @php
                                                if(isset($assaigned['customerAgentId'])) {
                                                    $agentid=$assaigned['customerAgentId'];
                                                } else {
                                                    $agentid='';
                                                }
                                            @endphp
                                                <option value="{{$agent->_id}}" @if($agentid== $agent->_id) selected @endif>{{$agent->name}}</option>
                                            @empty
                                                No agent available.
                                            @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new">Policy Pre</label>
                <div class="form_group textbox_opacity">
                    <div class="media">
                        <div class="media-body">
                            {{-- <label class="date_label"> --}}
                                {{-- Policy Premium --}}
                                {{-- <span style="color:red;">*</span> --}}
                            {{-- </label> --}}
                            <input id="policy_{{$mail->_id}}" class="note_textbox form_input number" name="" placeholder="Policy premium" oninput="checkClosure('{{$mail->id}}')"
                            @if(isset($mail->policyAmount) && ($mail->policyAmount!=''))
                            value="{{number_format($mail->policyAmount,2)}}" @endif {{$permission}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new">Comm %</label>
                <div class="form_group textbox_opacity">
                    <div class="media">
                        <div class="media-body">
                            {{-- <label class="date_label"> --}}
                                {{-- Policy Premium --}}
                                {{-- <span style="color:red;">*</span> --}}
                            {{-- </label> --}}
                            <input id="commissionP_{{$mail->_id}}" class="note_textbox form_input number" name="" placeholder="Commission %" oninput="checkClosure('{{$mail->id}}')"
                            @if(isset($mail->policyAmount) && ($mail->policyAmount!=''))
                            value="{{number_format($mail->commissionPercentage,2)}}" @endif {{$permission}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new"> Total Comm</label>
                <div class="form_group textbox_opacity">
                    <div class="media">
                        <div class="media-body">
                            {{-- <label class="date_label"> --}}
                                {{-- Policy Premium --}}
                                {{-- <span style="color:red;">*</span> --}}
                            {{-- </label> --}}
                            <input id="commission_{{$mail->_id}}" disabled='disabled' class="note_textbox form_input number" name="" placeholder="Commission"
                            @if(isset($mail->policyAmount) && ($mail->policyAmount!=''))
                            value="{{number_format($mail->commissionAmount,2)}}" @endif {{$permission}}>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($mail->subject) && $mail->subject){
                $subject=$mail->subject;
                $subjectArray=explode('*',$subject);
                if(count($subjectArray)>2){
                    $stringDate=trim($subjectArray[count($subjectArray)-1]);
                }
            }
            ?>
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new">Renewal Date</label>
                <div class="form_group textbox_opacity">
                    <div class="media">
                        <div class="media-body">
                            {{-- <label class="date_label">Renewal Date : </label> --}}
                            <input id="renewal_date_{{$mail->_id}}" name class="note_textbox form_input date_font datetimepicker dateclass"  name=""
                            placeholder="Renewal Date" type="text" value=" {{$mail['renewalDate']}}" {{$permission}}>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-2 custom_col-md-2">
                    <label class="label_new">From Date</label>
                    <div class="form_group textbox_opacity">
                        <input id="date_1_{{$mail->_id}}" class="note_textbox form_input date_font datetimepicker" name="" placeholder="From Date" type="text" value="" {{$permission}}>
                    </div>
                </div>
                <div class="col-sm-2 custom_col-md-2">
                    <label class="label_new">Expiry Date</label>
                    <div class="form_group textbox_opacity">
                        <input id="date_2_{{$mail->_id}}" class="note_textbox form_input date_font datetimepicker" name="" placeholder="Expiry Date" type="text" value="{{$mail['expiryDate']}}" {{$permission}}>
                    </div>
                </div>
                <?php unset($stringDate) ?>



        </div>
        <div class="row form-group-btm"style="margin-left:33px">
            {{-- <div class="col-sm-3">
                <label class="label_new">Insurer:</label>
                <div class="form_group custom_dropdown_toggle">
                    <div class="custom_select_dropdown">
                        <select data-hide-disabled="true" data-live-search="true" id="insurer_{{$mail->_id}}" {{$permission}}>
                            @if(isset($assaigned))
                                @if(isset($assaigned['insurerId']))
                                    <option value="{{$assaigned['insurerId']}}" selected>{{$assaigned['insurerName']}}</option>
                                @endif
                            @endif
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new">Reminder Date</label>
                <div class="form_group textbox_opacity">
                    <div class="media">
                        <div class="media-body">
                            {{-- <label class="date_label">Reminder Date : </label>  --}}
                            <input id="reminder_date_{{$mail->_id}}" name class="note_textbox form_input date_font datetimepicker dateclass"  name=""
                            placeholder="Reminder Date" type="text" value="{{$mail['reminderDate']}}" {{$permission}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 custom_col-md-2">
                <label class="label_new">Note</label>
                <div class="form_group textbox_opacity">
                    <input id="note_{{$mail->_id}}" class="note_textbox form_input" name="" placeholder="Note" type="text" value="{{$mail->note}}" {{$permission}}>
                </div>
            </div>
            <div class="col-md-2 custom_col-md-3" >
                <label class="label_new">Insurer</label>
                    <div class="form_group custom_dropdown_toggle">
                        <div class="custom_select_dropdown custom_new_width">
                            <select data-hide-disabled="true" data-live-search="true" id="insurer_{{$mail->_id}}" {{$permission}}>
                                @if(isset($assaigned))
                                    @if(isset($assaigned['insurerId']))
                                        <option value="{{$assaigned['insurerId']}}" selected>{{$assaigned['insurerName']}}</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
            </div>
            <div class="col-md-2 custom_col-md-3">
                <label class="label_new">Assignee</label>
                    <div class="form_group custom_dropdown_toggle calender_index">
                        <div class="custom_select_dropdown">
                            <select data-hide-disabled="true" data-live-search="true" id="agent_{{$mail->_id}}" name="agent" onchange="checkClosure('{{$mail->_id}}')" {{$permission}}>
                                @if(isset($assaigned))
                                    @if(isset($assaigned['agentId']))
                                        <option value="{{$assaigned['agentId']}}" selected>{{$assaigned['agentName']}}</option>
                                    @endif
                                 @endif
                            </select>
                        </div>
                    </div>
            </div>
            <div class="col-md-2 custom_col-md-3">
                <label class="label_new">Status</label>
                <div class="form_group custom_dropdown_toggle status_dropdown_toggle">
                    <div class="">
                        <select class="selectpicker txt_capitalize" id="status_{{$mail->_id}}" onchange="checkClosure('{{$mail->_id}}')" style="z-index: 999999;" {{$permission}}>
                            <option value="">Select Status</option>
                            @if ($mail->renewal==0)
                                @foreach ($currentMailBucket->nonRenewalStatus as $statusSet)
                                    <option value="{{$statusSet['closureProperty']}}" <?php echo((@$assaigned['assaignStatusName']==$statusSet['statusName'])? "selected" : "");?> >{{$statusSet['statusName']}}</option>
                                @endforeach
                            @elseif($mail->renewal==1)
                                @foreach ($currentMailBucket->renewalStatus as $statusSet)
                                    <option value="{{$statusSet['closureProperty']}}" <?php echo((@$assaigned['assaignStatusName']==$statusSet['statusName'])? "selected" : "");?> >{{$statusSet['statusName']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2 custom_col-md-2">
                <label class="label_new">Sub Status</label>
                <div class="form_group custom_dropdown_toggle status_dropdown_toggle">
                    <div class="">
                        <select class="selectpicker txt_capitalize" id="sub_status_{{$mail->_id}}"  style="z-index: 999999;"  onchange="checkClosure('{{$mail->_id}}')"  {{$permission}}>
                            <option value="">Select Sub Status</option>
                            @if ($mail->renewal==0)
                                @foreach ($currentMailBucket->nonRenewalStatus as $statusSet)
                                    @if (isset($assaigned['assaignStatusName']) && @$assaigned['assaignStatusName'] != "" && @$assaigned['assaignStatusName'] == $statusSet['statusName'])
                                        @if(isset($statusSet['subStatus']) && $statusSet['subStatus'])
                                            @foreach ($statusSet['subStatus'] as $substatusSet)
                                                <option value="{{$statusSet['closureProperty']}}" <?php echo((@$assaigned['assaignSubStatusName']==$substatusSet)? "selected" : "");?> >{{$substatusSet}}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @elseif($mail->renewal==1)
                                @foreach ($currentMailBucket->renewalStatus as $statusSet)
                                    @if (isset($assaigned['assaignStatusName']) && @$assaigned['assaignStatusName'] != "" && @$assaigned['assaignStatusName'] == $statusSet['statusName'])
                                        @if(isset($statusSet['subStatus']) && $statusSet['subStatus'])
                                            @foreach ($statusSet['subStatus'] as $substatusSet)
                                                <option value="{{$statusSet['closureProperty']}}" <?php echo((@$assaigned['assaignSubStatusName']==$substatusSet)? "selected" : "");?> >{{$substatusSet}}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2 custom_col-md-3">
                <label class="label_new">Group</label>
                <div class="form_group custom_dropdown_toggle status_dropdown_toggle">
                    <div class="custom_select_dropdown">
                        <select data-hide-disabled="true" data-live-search="true" id="group_{{$mail->_id}}" name="group_name_{{$mail->_id}}" style="z-index: 999999;" {{$permission}}>
                        <option value="">Select Group</option>
                            @if(isset($currentMailBucket->groups))
                                @foreach (@$currentMailBucket->groups as $grp  =>$groupData)
                                    <option value="{{$groupData}}" @if(@$assaigned['groupName']== $groupData) selected  @endif >{{$groupData}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

        </div>
        {{-- <div class="row" style="margin-left:33px">

            <div class="col-md-2">
                <label class="label_new">Assignee</label>
                    <div class="form_group custom_dropdown_toggle calender_index">
                        <div class="custom_select_dropdown">
                            <select data-hide-disabled="true" data-live-search="true" id="agent_{{$mail->_id}}" name="agent" onchange="checkClosure('{{$mail->_id}}')" {{$permission}}>
                                @if(isset($assaigned))
                                    @if(isset($assaigned['agentId']))
                                        <option value="{{$assaigned['agentId']}}" selected>{{$assaigned['agentName']}}</option>
                                    @endif
                                 @endif
                            </select>
                        </div>
                    </div>
            </div>
        </div> --}}
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
                            <div class="form_group attachement_bottom">
                                <table style="width:100%;">
                                    <tr>
                                        <td width="100px" valign="top">
                                            <div class="action-icon" style="margin-right:10px;">
                                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment"
                                                onclick="viewAttachment('{{$path}}')">
                                                    <i class="fa fa-eye">
                                                    </i>
                                                </button>
                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body"
                                                data-original-title="Download" onclick="downloadAttachment('{{$path}}', '{{$add}}')">
                                                    <i class="fa fa-cloud-download">
                                                    </i>
                                                </button>
                                            </div>
                                        </td>
                                        <td width="400px" valign="top">
                                        <div class="row" id="attach_name_{{$mail->_id.$attachmentCount}}">
                                                <div class="custom_checkbox">
                                                    <input type="checkbox" name="attachment_checkbox_{{$mail->_id}}[]" id="{{$id}}" value="{{$id}}"
                                                    onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mail->_id}}')" class="inp-cbx" style="display: none" {{$permission}}>
                                                    <label for="{{$id}}" class="cbx">
                                                        <span class="checkbox_margin">
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="attach_txt attachment_checkbox text_overflow" data-toggle="tooltip"
                                                        data-placement="bottom" data-container="body" data-original-title="{{$fileName}}">
                                                            {{$fileName}}
                                                        </span>
                                                    </label>
                                                </div>
                                                <span id="indicator_{{$mail->_id.$attachmentCount}}">
                                                    @if (@$file['isPostedToCustomer']==1)
                                                        <span class="post_status" style="left: -18px;">
                                                            <span class="status_textsize">Shared</span>
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form_group">
                                                <input class="attachment_textbox form_input" name="attachment_{{$mail->_id}}[]"  placeholder="Update the name" type="text" value="{{$updatedName}}" {{$permission}}>
                                                <label id="update_name_error_{{$mail->_id}}_{{$attachmentCount}}" class="error"></label>
                                            </div>
                                        </td>
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
            @if($permission!='disabled')
                <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button" onclick="setForwardTo('{{$mail->_id}}')">Forward Email</button>
                <div id="button_show{{$mail->_id}}" style="display: none;">
                        <button class="btn pink_btn btn_action pull-right btn_download" id="bulk_download_{{$mail->_id}}" type="button" onclick="bulkDownload('{{$mail->_id}}')">Download</button>
                    {{-- <button class="btn pink_btn btn_action pull-right btn_download" id="bulk_download_{{$mail->_id}}" type="button" onclick="bulkDownload('{{$mail->_id}}','{{json_encode($mail->attachements)}}')">Download</button>  --}}
                    {{-- <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" onclick="showPostSelected('{{$mail->_id}}','{{$mail->_id}}')">Post to Customer</button>  --}}
                </div>
            @endif
        </div>
    </div>
</div>


@endforeach




<script>






 @foreach ($data as $mail)

    //    console.log('{{$mail->dates['date1']}}');
    //    console.log('{{$mail->dates['date2']}}');
    $('.dateclass') .datetimepicker({
        format: 'DD/MM/YYYY'
    });
    $('#date_1_{{$mail->_id}}') .datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false
    });
    $('#date_2_{{$mail->_id}}') .datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
    });

    $('#date_1_{{$mail->_id}}').on("dp.change", function (e) {
        var strr=new Date(e.date.add(1,'d'));
        $('#date_2_{{$mail->_id}}').data("DateTimePicker").minDate(strr);
     $('#date_2_{{$mail->_id}}').data("DateTimePicker").date(e.date.add(1,'y').subtract(2,'d'));
    });
    $("#date_2_{{$mail->_id}}").on("dp.change", function (e) {
         var strr=new Date(e.date.subtract(1,'d'));
        $('#date_1_{{$mail->_id}}').data("DateTimePicker").maxDate(strr);
    });
    $('#date_1_{{$mail->_id}}').data("DateTimePicker").date("{{$mail->dates['date1']}}");
    $('#date_2_{{$mail->_id}}').data("DateTimePicker").date("{{$mail->dates['date2']}}");

    $("#status_{{$mail->_id}}").on("change", function (e) {
        var status= $("#status_{{$mail->_id}}").find(':selected').text();
        var renewal= $("#cbx_renew_{{$mail->_id}}").is(':checked');
        var mailId=$("#currentMailBucket").val();
        $.ajax({
        type: "POST",
        url: "{{url('enquiry/get-substatus-list')}}",
        data: {
            status: status,
            renewal: renewal,
            mailId: mailId,
            _token: '{{csrf_token()}}'
        },
        success: function(data) {
            if (data.success == true) {
                $('#sub_status_{{$mail->_id}}').selectpicker('destroy');
                $('#sub_status_{{$mail->_id}}').html(data.response);
                $('#sub_status_{{$mail->_id}}').selectpicker('setStyle');
                $('#sub_status_{{$mail->_id}}-error').hide();
                $('#button_submit').removeAttr('disabled');
            }
        }
    });

    });
    $('#insurer_{{$mail->_id}}').select2({
        ajax: {
            url: "{{URL::to('enquiry/get-insurer')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
            placeholder: "Select Insurer Name",
            language: {
                noResults: function() {
                    return 'No insurers found';
                },
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatingRepo,
        templateSelection: formatingRepoSelection
    });

    $('#group_{{$mail->_id}}').select2({
        placeholder: "Select group",
            language: {
                noResults: function() {
                    return 'No group found';
                },
            },
    });

    $('#group_{{$mail->_id}}').on('select2:opening', function( event ) {
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search group...');
    });

    function formatingRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        if(repo.text!='')
        {
            var markup = repo.text;
        }
        else{
            var markup = "unknown";
        }
        return markup;
    }
    function formatingRepoSelection (repo) {
        if(repo.text)
        {
            return repo.text;

        }else{
            return repo.text;

        }
    }
        $('#customer_{{$mail->_id}}').select2({
        ajax: {
            url: '{{URL::to("document/get-customers")}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
            placeholder: "Select Customer Name",
            language: {
                noResults: function() {
                    return 'No customers found';
                },
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });




    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }
        if(repo.customerCD!='')
        {
            var markup = repo.fullName+' ('+repo.customerCD+')';
        }
        else{
            var markup = repo.fullName;
        }
        return markup;
    }
    function formatRepoSelection (repo) {
        if(repo.fullName && repo.customerCD)
        {
            return repo.fullName +' ('+repo.customerCD +')';

        }else{
            return repo.text;

        }
    }

    $('#agent_{{$mail->_id}}').select2({
        ajax: {
            url: '{{URL::to("enquiry/get-agent")}}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
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
            placeholder: "Assigned To",
            language: {
                noResults: function() {
                    return 'No assignees found';
                },
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatReport,
        templateSelection: formatReportSelection
    });




    function formatReport (report) {
        if (report.loading) {
            return report.text;
        }
        if(report.employeeID!='')
        {
            var markup = report.name+' ('+report.employeeID+')';
        }
        else{
            var markup = report.name;
        }
        return markup;
    }
    function formatReportSelection (report) {
        if(report.name && report.employeeID)
        {
            return report.name +' ('+report.employeeID +')';

        }else{
            return report.text;

        }
    }
    $('#insurer_{{$mail->_id}}').on('select2:opening', function( event ) {
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search insurer...');
    });
    $('#agent_{{$mail->_id}}').on('select2:opening', function( event ) {
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search assignee...');
    });
    $('#customer_{{$mail->_id}}').on('select2:opening', function( event ) {
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search customer...');
    });
@endforeach

$(document).ready(function() {
$('.selectpicker').selectpicker('refresh');
});
var new_num;
    $("input.number").keyup(function(event){

        //   debugger;
        var $this = $(this);
        var num =  $this.val();
        var num_parts = num.toString().split(".");

        if(num_parts[1]){

                if(num_parts[1].length >2){
                    num2 = new_num;

                } else{
                    num_parts[0] = num_parts[0].replace(/,/gi, "");
                    num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
                    var num2 = num_parts.join(".");
                    new_num = num2;

                }


        } else{
            num_parts[0] = num_parts[0].replace(/,/gi, "");
            num_parts[0] = num_parts[0].split(/(?=(?:\d{3})+$)/).join(",");
            var num2 = num_parts.join(".");
            new_num = num2;

        }
        $this.val(num2);

    });

</script>
{{-- @endpush --}}




