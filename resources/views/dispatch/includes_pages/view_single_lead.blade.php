<div class="content_spacing">
<input type="hidden" value="{{$leadDetails->_id}}" id="lead_id">
    <div class="row">
        <div class="col-md-6">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Customer Name </label></td>
                    <td width="20">:</td>
                    <td><input type="text" class="form_input" readonly id="customerName" name="customerName" value="{{@$leadDetails['customer']['name']}}"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Reference Number </label></td>
                    <td width="20">:</td>
                    <td><input type="text" class="form_input" readonly id="ref_number" name="ref_number" value="{{$leadDetails['referenceNumber']}}"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Customer ID </label></td>
                    <td width="20">:</td>
                    <td><input type="text"class="form_input" readonly id="customerCode" name="customerCode" value="{{@$leadDetails['customer']['customerCode']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Recipient Name </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="recipientName" name="recipientName" value="{{@$leadDetails['customer']['recipientName']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Task Type </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="dispatch_type" name="dispatch_type" value="{{@$leadDetails['dispatchType']['dispatchType']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Contact Number </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="contactNum" name="contactNum" value="{{@$leadDetails['contactNumber']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Case Manager </label></td>
                    <td>:</td>
                    <td><input type="text"class="form_input" readonly id="caseManagerSave" name="caseManager" value="{{@$leadDetails['caseManager']['name']}}"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Agent Name </label></td>
                    <td width="20">:</td>
                    <td><input type="text" class="form_input" readonly id="agentName" name="agentName" value="{{@$leadDetails['agent']['name']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Email ID </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="emailId" name="emailId" value="{{@$leadDetails['contactEmail']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Delivery Mode </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="deliveryMode" name="deliveryMode" value="{{@$leadDetails['deliveryMode']['deliveryMode']}}"></td>
                </tr>
                @if(@$leadDetails['deliveryMode']['deliveryMode']=='Courier')
                <tr>
                    <td class="name"><label class="form_label">WayBill Number</label></td>
                    <td>:</td>
                    <td><input  name="way_bill" id="way_bill" class="form_input" value="{{@$leadDetails['deliveryMode']['wayBill']}}"></td>
                </tr>
                @endif
                <tr>
                    <td class="name"><label class="form_label">Assigned To </label></td>
                    <td>:</td>
                    <td><input  name="assign" id="assign" class="form_input" value="{{@$leadDetails['employee']['name']}}"></td>
                </tr>

            </table>
        </div>
    </div>
    <div style="height: 30px;"></div>
    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Address <span>*</span> </label></td>
                    <td width="20">:</td>
                    <td><input type="text" class="form_input" id="address" name="address" value="{{@$leadDetails['dispatchDetails']['address']}}"></td>
                </tr>
                <tr>
                    <td class="name"><label class="form_label">Land Mark<span>*</span> </label></td>
                    <td>:</td>
                    <td><input type="text" class="form_input" id="land_mark" name="land_mark" value="{{@$leadDetails['dispatchDetails']['land_mark']}}"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <table style="width: 100%">
                <tr>
                    <td class="name"><label class="form_label">Preferred Del / Coll Date & Time <span>*</span> </label></td>
                    <td width="20">:</td>
                    <td><input type="text" class="form_input datetimepicker" id="date_time" name="date_time" value="{{@$leadDetails['dispatchDetails']['date_time']}}"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6"></div>
    </div>
    @if(isset($leadDetails['dispatchDetails']['documentDetails']))
    <div class="card_separation" style="margin: 20px -20px 0;padding: 10px 20px;">
        <table class="lead_block input_fields_wrap">
            <tr>
                <th>
                    <label class="form_label">Document Name </label>
                </th>
                <th>
                    <label class="form_label">Document Description </label>
                </th>
                <th>
                    <label class="form_label">Type </label>
                </th>
                <th>
                    <label class="form_label"  id="amountlabel">Amount /No of Cards </label>
                </th>
                <th>
                    <label class="form_label">Collected Amount </label>
                </th>
                <th>
                    <label class="form_label">Status</label>
                </th>
            </tr>
            <?php $dispatch_status=''?>
		    <?php $i=0?>
            @foreach($leadDetails['dispatchDetails']['documentDetails'] as $doc)
                    <tr>
                        <td>
                            <input class="form_input" style="margin-bottom: 0" name="docName[]" id="docName" placeholder="Document Name"  value="{{$doc['documentName']?:'--'}}" type="text">
                        </td>
                        <td>
                            <input class="form_input" value="{{$doc['documentDescription']?:'--'}}">
                        </td>
                        <td>
                            <input class="form_input" style="margin-bottom: 0" name="type[]" id="type" placeholder="Type"  value="{{$doc['documentType']?:'--'}}" type="text">
                        </td>
                            <td id="amount" >
                                <input class="form_input" style="margin-bottom: 0" name="doc_amount[]" id="doc_amount" placeholder="Cheque / Cash amount" value="{{$doc['amount']?:'--'}}">
                            </td>
                            <td>
                                    <input class="form_input" style="margin-bottom: 0" name="doc_collected_amount[]" id="doc_collected_amount" value="{{$doc['doc_collected_amount']?:'--'}}">
                            </td>

                        @if($doc['DocumentCurrentStatus']==2)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Delivered" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==1)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Lead" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==18)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Reception" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==13)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Schedule for delivery" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==11)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Delivery" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==12)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Rejected from schedule for delivery" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==7  )
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Completed" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==16  )
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Completed" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==4)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Reschedule For Another Day" style="color: Red;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==3)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Reschedule For Same Day" style="color: Red;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==5)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Could Not Contact" style="color: Red;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==8)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Cancel" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==10)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Rejected from reception" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==6 )
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Transfer Accepted" style="color: Green;cursor: default"><i class="material-icons">done</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==15)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Transfer Accepted" style="color: Green;cursor: default"><i class="material-icons">done</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==14  )
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Transferred" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif
                        @if($doc['DocumentCurrentStatus']==9  )
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Transferred" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                                </div>
                            </td>
                        @endif

                        @if($doc['DocumentCurrentStatus']==17)
                            <td>
                                <div>
                                    <div data-toggle="tooltip" data-placement="bottom" title="Transfer Not Accept" style="color: Red;cursor: default"><i class="material-icons">not_interested</i> </div>
                                </div>
                            </td>
                        @endif
                    </tr>
				    <?php $i++;?>
            @endforeach
        </table>
    </div>
    @endif
</div>