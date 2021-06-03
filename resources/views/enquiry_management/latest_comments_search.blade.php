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


        if(isset($mail->comments))
        {   $latestComment='';
            foreach($mail->comments as $comment){
                if($loop->first){
                    $latestComment=$comment["commentBody"];
                    $latestCommentDate=$comment["commentDate"]->toDateTime()->format('d-m-yy');
                } else {
                   if($latestComment < $comment["commentDate"]){
                    $latestComment=$comment["commentBody"];
                    $latestCommentDate=$comment["commentDate"]->toDateTime()->format('d-m-yy');

                   }
                //    dump($comment["commentDate"]);
                }
                // dump($latestComment);
                
            }
            // $assaigned->latestComment=$latestComment;
        }
    @endphp
    <div class="panel panel-default document_panel" id="mail_{{$mail->_id}}">
        <div class="panel-heading clearfix" role="tab" id="headingOne">
            <div class="row">
                <div class="col-md-12" id="mail_bar_{{$mail->_id}}">
                    <div class="row">
                        <div style="padding:0px 15px" id="panel_{{$mail->_id}}" class=" col-sm-10 collapsed clearfix" data-toggle="collapse" data-parent="#accordion" href="#{{$mail->_id}}" aria-expanded="false" aria-controls="collapseOne" style="margin: 0 11px;">
                            @if ($mail->subject=="")
                                <label style="margin-left: 30px;" class="form_label mail_subject">(No Subject)</label>
                            @else
                                <label style="margin-left: 30px;" class="form_label mail_subject">{{$mail->subject}}</label>
                            @endif
                            <p class="mail_details">
                                <span class="customer_email">&lt;{{$mail->from}}&gt; </span>
                                <span class="mail_date"> {{$mail->recieveTime}}</span>

                            </p>
                        </div>
                        <div class="col-sm-2" style="text-align: right;">
                            <div class="form_group custom_dropdown_toggle">  
                                <div class="custom_select">
                                    <label class="display_label" id="subStatus{{$mail->_id}}">
                                        <button style="font-size: 10.25px;" class="btn pink_btn btn_action pull-right auto_modal" data-modal="comment" id="button_post" type="button" onclick="viewComments('{{$mail->_id}}')"> View All Comments</button>
                                </div>
                            </div>
                        </div>
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
                                <b>Policy Premium : <span class="details_sec"> {{((@$mail['policyAmount']=="")? "NA":number_format($mail['policyAmount'],2))}}</span> </b> 
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="display_label" id="renewal_{{$mail->_id}}">
                                <b>Renewal Date : <span class="details_sec"> {{((@$mail['renewalDate']=="")? "Renewal date not selected":$mail['renewalDate'])}}</span> </b> 
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="display_label" id="reminder_{{$mail->_id}}">
                                <b>Reminder Date : <span class="details_sec"> {{((@$mail['reminderDate']=="")? "NA":$mail['reminderDate'])}}</span> </b> 
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
                        <div class="col-sm-2">
                            <div class="form_group custom_dropdown_toggle">  
                                <div class="custom_select">
                                    <label class="display_label" id="subStatus{{$mail->_id}}">
                                    <b>Comment Date: <span class="details_sec"> {{@$latestCommentDate}}</span> </b></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form_group custom_dropdown_toggle">  
                                <div class="custom_select">
                                    <label class="display_label" id="subStatus{{$mail->_id}}">
                                    <b>Latest Comment: <span class="details_sec"> {{@$latestComment}}</span> </b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        
    .panel_open > a.collapsed:before {
        float: left !important;
        content: " ";
    }

    .panel_open> a:before {
        content: " ";
        margin: 0 9px 0px 0px;
    }

    .panel_open > a.collapsed:before {
        content :""
    }

    </style> 
</div>
<script>
$('.selectpicker').selectpicker();


</script>
