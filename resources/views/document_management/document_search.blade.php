<div>
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
        $mailCount=0;
        if(count($data)<=0)
        {
            echo "<h4>No documents found</h4>";
        }
    @endphp
    @foreach ($data as $mail)
        @php
            if(isset($mail->assaignedTo)) {
                $assaigned=$mail->assaignedTo;
            }
            else {
                $assaigned=null;
            }
            if(isset($mail->notes)) {
                $notes=$mail->notes;
            } else {
                $notes=null;
            }
        @endphp
        <div class="panel panel-default document_panel" id="mail_{{$mail->_id}}">
            <div class="panel-heading clearfix" role="tab" id="headingOne">
                <div class="col-md-12" id="mail_bar_{{$mail->_id}}">
                    <div class="media">
                        <div class="media-body">
                            <div class="panel_open">
                                <?php 
                                    $Display='';
                                    $assignSeenID=[];
                                    $seen = $mail->newNotification?:'';
                                    $assignSeenID = $mail->assignSeenID?:[];
                                    if ($seen) {
                                        if (($seen==Auth::id()) || ((session('role')=='Employee' || session('role')=='Supervisor') && $seen=='999' && !in_array(Auth::id(), $assignSeenID))) { 
                                            $Display='new';
                                        }
                                        if((session('role')=='Employee' || session('role')=='Supervisor') && $assignSeenID && $seen=='999' && !in_array(Auth::id(), $assignSeenID)) {
                                            $Display='new';
                                        }
                                    } 
                                ?>
                                <a id="panel_{{$mail->_id}}" class="collapsed clearfix" data-toggle="collapse" @if($Display!='') onclick="upadateNewNotification('{{$mail->_id}}')" @endif data-parent="#accordion" href="#{{$mail->_id}}" aria-expanded="false" aria-controls="collapseOne">
                               
                                @if(@$Display!='') 
                                    @if ($mail->subject=="")
                                        <label class="form_label mail_subject">(No Subject) <i id="comment_id_{{$mail->_id}}" style="margin: 0 0 0 10px; font-size: 18px; color: #cd4277;" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="New document" class="fa fa-envelope"></i></label> 
                                    @else
                                        <label class="form_label mail_subject">{{$mail->subject}}<i id="comment_id_{{$mail->_id}}" style="margin: 0 0 0 10px; font-size: 18px; color: #cd4277;" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="New document" class="fa fa-envelope"></i></label> 
                                    @endif
                                @else
                                    @if ($mail->subject=="")
                                    <label class="form_label mail_subject">(No Subject)</label> 
                                    @else
                                        <label class="form_label mail_subject">{{$mail->subject}}</label> 
                                    @endif
                                @endif
                                    <p class="mail_details">
                                        <span class="customer_email">&lt;{{$mail->from}}&gt; </span>
                                        <span class="mail_date"> {{$mail->recieveTime}}</span>
                                        <label for="" class="display_label"> 
                                            <b>Agent : 
                                                <span id="agent_detail_{{$mail->_id}}">
                                                    @php
                                                        if(isset($assaigned['customerAgentName']))
                                                        {
                                                            echo $assaigned['customerAgentName'];
                                                        }
                                                    @endphp
                                                </span>
                                                <span id="no_agent_details_{{$mail->_id}}">
                                                </span>
                                            </b>
                                        </label>
                                    </p>
                                </a>
                            </div>
                        </div>
                        @if ($permission!='disabled')
                            <div class="media-right">
                                <button class="btn blue_btn pull-right custom_btn" id="button_save_{{$mail->_id}}" type="button" onclick="saveMail('{{$mail->_id}}')">Save</button>
                                <button class="btn blue_btn pull-right custom_btn" id="button_save_submit_{{$mail->_id}}" style="display:none;" type="button" onclick="needConfirmation('{{$mail->_id}}','{{$mail->_id}}')">Save & Submit</button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row header_dropdown">
                    <div class="col-sm-3">
                        {{-- <div class="col-sm-2 customer_name_width"></div> --}}
                        <div class="media">
                            <div class="">
                                <div class="media-body custom_flex">
                                    <div class="btn_padding" style="margin-left: 14px;">
                                        @if (isset($assaigned['customerId']) && $assaigned['customerId']!="")
                                            <button id="add_customer_{{$mail->_id}}" class="blue_btn add_btn_icon" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Add Customer" style="display: none;"
                                            onclick="addNewCustomer()" {{$permission}}>
                                            <i class="fa fa-plus"></i>
                                            </button>
                                            <button id="edit_customer_{{$mail->_id}}" class="blue_btn add_btn_icon edit_icon_bg" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit Customer"
                                            onclick="editCustomer('{{$mail->_id}}')" {{$permission}}>
                                            <i class="fa fa-pencil"></i>
                                            </button>
                                        @else
                                            <button id="add_customer_{{$mail->_id}}" class="blue_btn add_btn_icon" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Add Customer"
                                            onclick="addNewCustomer()" {{$permission}}>
                                            <i class="fa fa-plus"></i>
                                            </button>
                                            <button id="edit_customer_{{$mail->_id}}" class="blue_btn add_btn_icon edit_icon_bg`" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit Customer" style="display: none;"
                                            onclick="editCustomer('{{$mail->_id}}')" {{$permission}}>
                                            <i class="fa fa-pencil"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="media-body">
                                    <div class="form_group custom_dropdown_toggle" >
                                        <div class="custom_select_dropdown">
                                                {{-- <div class="custom_select_dropdown dropdown_custom_width"> </div>--}}
                                            <select data-hide-disabled="true" id="customer_{{$mail->_id}}" name="customer" onchange="showAgent('{{$mail->_id}}')" {{$permission}}>
                                                @if(isset($assaigned))
                                                    @if(isset($assaigned['customerId'])) 
                                                        <option value="{{$assaigned['customerId']}}" selected>{{$assaigned['customerName']}}</option>
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-sm-2">
                        {{-- <div class="col-md-12"> --}}
                            <div class="form_group custom_dropdown_toggle">
                                <div class="custom_select_dropdown">
                                <select class="forSelect" data-hide-disabled="true" data-live-search="true" id="agent_{{$mail->_id}}" name="agent" {{$permission}} onchange="checkClosure('{{$mail->_id}}')">
                                        @if(isset($assaigned))
                                        @if(isset($assaigned['agentId'])) 
                                    <option value="{{$assaigned['agentId']}}" selected>{{$assaigned['agentName']}}</option>
                                    @endif
                                    @endif
                                </select>
                                </div>
                            </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-sm-2">
                        <div class="form_group custom_dropdown_toggle">
                            <div class="custom_select status-sec">
                                <select class="selectpicker txt_capitalize" id="status_{{$mail->_id}}" onchange="checkClosure('{{$mail->_id}}')" {{$permission}}> 
                                    <option value="">Select Status</option>
                                    @foreach ($currentMailBox as $statusSet)
                                        <option value="{{$statusSet['closureProperty']}}" 
                                        <?php echo((@$assaigned['assaignStatusName']==$statusSet['statusName'])? "selected" : "");?> 
                                        >{{$statusSet['statusName']}}</option>
                                    @endforeach   
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form_group">
                            <input id="note_1_{{$mail->_id}}" class="note_textbox  form_input" name="" placeholder="Note1" type="text" value="{{$notes['note1']}}"  {{$permission}}>
                        </div>
                    </div>
                    <div class="col-sm-2 document_note_width">
                        <div class="form_group">
                            <input id="note_2_{{$mail->_id}}" class="note_textbox form_input" name="" placeholder="Note2" type="text" value="{{$notes['note2']}}" {{$permission}}>
                        </div>    
                    </div>
                    <div class="col-sm-2 document_note_width">
                        <div class="form_group">
                            <input id="note_3_{{$mail->_id}}" class="note_textbox form_input" name="" placeholder="Note3" type="text" value="{{$notes['note3']}}" {{$permission}}>
                        </div>    
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
                                            <td width="130px" valign="top">
                                            <div class="action-icon" style="margin-right: 10px;">
                                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View Attachment" 
                                                onclick="viewAttachment('{{$path}}')">
                                                    <i class="fa fa-eye">
                                                    </i>
                                                </button>
                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"
                                                onclick="downloadAttachment('{{$path}}', '{{$add}}')">
                                                    <i class="fa fa-cloud-download">
                                                    </i>
                                                </button>
                                                <button class="blue_btn attach_icons action-icon-post auto_modal" data-modal="post_customer" id="button_post" data-toggle="tooltip" data-placement="bottom"  data-original-title="Post to Customer" 
                                                onclick="showPostCustomer('{{$mail->_id}}','{{$id}}','{{$mail->_id}}','{{$attachmentCount}}')" {{$permission}}>
                                                    <i class="fa fa-pencil-square-o">
                                                    </i>
                                                </button>
                                            </div>
                                            </td>
                                                <td width="500px" valign="top"> 
                                                    <div class="row">
                                                    <div class="custom_checkbox">
                                                        <input type="checkbox" name="attachment_checkbox_{{$mail->_id}}[]" id="{{$id}}" value="{{$id}}" onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mail->_id}}')" class="inp-cbx" style="display: none" {{$permission}}>
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
                                                            <span class="post_status" style="left: -10px;">
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

                                            {{-- <div class="media-left">
                                                <div class="custom_checkbox">
                                                <input type="checkbox" name="attachment_checkbox_{{$mail->_id}}[]" id="{{$id}}" value="{{$id}}" onclick="checkFunction('{{$id}}','{{$mail->_id}}','{{$mail->_id}}')" class="inp-cbx" style="display: none">
                                                    <label for="{{$id}}" class="cbx">
                                                        <span class="checkbox_margin">
                                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="attach_txt attachment_checkbox">{{$fileName}}</span>
                                                    </label>
                                                </div>
                                            </div>  --}}
                                            {{-- <div class="media-body">
                                                <div class="form_group">
                                                <input class="attachment_textbox form_input" name="attachment_{{$mail->_id}}[]"  placeholder="Update the name" type="text" value="{{$updatedName}}">
                                                    <label id="update_name_error_{{$mail->_id}}_{{$attachmentCount}}" class="error"></label>
                                            </div>
                                            </div> --}}

                                        
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
                    @if ($permission!='disabled')
                        <button class="btn pink_btn btn_action pull-right auto_modal" data-modal="forward_email"  id="button_forward" type="button" onclick="setForwardTo('{{$mail->_id}}')">Forward Email</button> 
                    
                        <div id="button_show{{$mail->_id}}" style="display: none;">
                            <button class="btn pink_btn btn_action pull-right btn_download" id="bulk_download_{{$mail->_id}}" type="button" onclick="bulkDownload('{{$mail->_id}}')">Download</button> 
                            <button class="btn pink_btn btn_action pull-right btn_download" id="" type="button" onclick="showPostSelected('{{$mail->_id}}','{{$mail->_id}}')">Post to Customer</button> 
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

    {{-- <div>


        <h1>something</h1>
    </div> --}}

<script>
$('.selectpicker').selectpicker();

</script>

@foreach ($data as $mail)
    <script>
    
        $('#customer_{{$mail->_id}}').select2({
            width: 'resolve',
            ajax: {
                url: '{{URL::to('document/get-customers')}}',
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
                placeholder: "Select customer name",
                language: {
                    noResults: function() {
                        return 'No Customers found';
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
            if(repo.customerCode!='')
            {
                var markup = repo.fullName+' ('+repo.customerCode+')';
            }
            else{
                var markup = repo.fullName;
            }
            return markup;
        }
        function formatRepoSelection (repo) {
            if(repo.fullName && repo.customerCode)
            {
                return repo.fullName +' ('+repo.customerCode +')';

            }else{
                return repo.text;

            }
        }

        $('#agent_{{$mail->_id}}').select2({
            ajax: {
                url: '{{URL::to('document/get-agent')}}',
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
                        return 'No Assignees found';
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
       $('#agent_{{$mail->_id}}').on('select2:opening', function( event ) {
           $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search assignee...');
       });
       $('#customer_{{$mail->_id}}').on('select2:opening', function( event ) {
           $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search customer...');
       });
       function upadateNewNotification(id)
       {
        $("#comment_id_"+id).hide();
        $.ajax({
            type:"GET",
            url:"{{url('document/update-notification')}}",
            data:{'id':id},
            success:function(data){
            
            }
        });
       }
    </script>
@endforeach
