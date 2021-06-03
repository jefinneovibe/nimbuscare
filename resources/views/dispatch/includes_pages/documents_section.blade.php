
@if(count(@$document)>0)
	<?php $count_num =1; ?>
	<?php $count=0; $uniqval=[];
	?>

    <table class="lead_block" id="document_table" width="100%">
        @if($current_path=='dispatch/employee-view-list')
            <?php  $employee_id =(string)session('employee_id');
            if(session('employees_supervisor')) {
                $employee_id =session('employees_supervisor');
                $transferto= @$leadDetails->transferTo;
		        foreach ($transferto as $key => $value) {
                    $id=$value['id'];
                     $idObject=new MongoDB\BSON\ObjectId($id);
                    
                        if(($value['status']=='Transferred' || $value['status']=='Collected') && in_array($idObject,$employee_id)) {
                            $uniqval[] = $value['uniqval'];
                        }
                }
            } else{
                $transferto= @$leadDetails->transferTo;
                foreach ($transferto as $key => $value) {
                    if(($value['status']=='Transferred' || $value['status']=='Collected') && (string)$value['id']==$employee_id) { 
                         $uniqval[] = $value['uniqval'];
                    }
		        }
            }
		   
		    ?>
        @endif


        @foreach(@$document as $doc)
            @if((($doc['DocumentCurrentStatus'] =='11' || $doc['DocumentCurrentStatus'] =='3') &&  $current_path=='dispatch/delivery') ||
            (($doc['DocumentCurrentStatus'] =='13') &&  $current_path=='dispatch/schedule-delivery')
            ||
             (($doc['DocumentCurrentStatus'] !='3'&&  $doc['DocumentCurrentStatus'] !='13' && ($doc['DocumentCurrentStatus'] !='7')
             && ($doc['DocumentCurrentStatus'] !='16') && $doc['DocumentCurrentStatus'] !='10'
             && $doc['DocumentCurrentStatus'] !='11' && $doc['DocumentCurrentStatus'] !='9' && $doc['DocumentCurrentStatus'] !='14') &&  $current_path=='dispatch/receptionist-list')   ||
             (($doc['DocumentCurrentStatus'] =='1' || $doc['DocumentCurrentStatus'] =='10')
              &&  $current_path=='dispatch/dispatch-list') ||
              (($doc['DocumentCurrentStatus'] =='7' || $doc['DocumentCurrentStatus'] =='16') &&  $current_path=='dispatch/complete-list') ||
              (($doc['DocumentCurrentStatus'] =='9' || $doc['DocumentCurrentStatus'] =='14') &&  (in_array( $doc['uniqTransferId'],$uniqval)) &&
               $current_path=='dispatch/employee-view-list')
                || (($doc['DocumentCurrentStatus'] =='9' || $doc['DocumentCurrentStatus'] =='14') &&
               $current_path=='dispatch/transferred-list'))


                @if(($doc['DocumentCurrentStatus']=='1' && $current_path=='dispatch/dispatch-list') ||
                ($doc['DocumentCurrentStatus']=='10' && $current_path=='dispatch/dispatch-list') ||
                    ($doc['DocumentCurrentStatus']=='18' && $current_path=='dispatch/receptionist-list'))
					<?php $save_status='lead';?>
                @else
					<?php $save_status='not-lead';?>
                @endif
                <tr>
                    <input type="hidden" value="{{$doc['id']}}" name="docid[]">
                    @if($doc['DocumentCurrentStatus']==2 || $doc['DocumentCurrentStatus']==4 ||$doc['DocumentCurrentStatus']==5 || $doc['DocumentCurrentStatus']==8 || $doc['DocumentCurrentStatus']==6 ||
                    $doc['DocumentCurrentStatus']==17||$doc['DocumentCurrentStatus']==12||$doc['DocumentCurrentStatus']==15||$doc['DocumentCurrentStatus']==1 || ($doc['DocumentCurrentStatus']==1 && $doc['DocumentCurrentStatus']==2))
                        <td style="display: none">
                            <div>
                                <div class="form_group">
                                    <div class="custom_checkbox" style="margin-top: 0">
                                        <input type="checkbox" name="docSelect[]"  checked value="{{$doc['id']}}" id="docSelect_{{$count}}" class="inp-cbx permissions_cls checked_class" style="display: none" onclick="markcheck(this,'<?php echo $doc['DocumentCurrentStatus'];?>')">
                                        <label for="docSelect_{{$count}}" class="cbx">
                            <span><svg width="12px" height="10px" viewBox="0 0 12 10">
                                                              <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                           </svg>
                       </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endif

                    <td>
                        <div>
                            <div class="form_group">
                                <label class="form_label">Select Type @if($current_path=='dispatch/receptionist-list' || $current_path=='dispatch/dispatch-list' )<span>*</span>@endif</label>
                                @if($save_status=='lead')
                                    <div class="">
                                        <select class="selectpicker change_sec" name="docName[]" id="docName_{{$count_num}}" @if($save_status!='lead') disabled @endif onchange=showAmount(this)>
                                            <option value="">Select Document Type</option>
                                            @if(!empty($documentTypes))
                                                @forelse($documentTypes as $type)
                                                    <option value="{{$type->docNum}}" @if($doc['documentId']==$type->_id ) selected @endif>{{$type->documentType}}</option>
                                                @empty
                                                    No types found.
                                                @endforelse
                                            @endif
                                        </select>
                                    </div>
                                @else
                                    <input class="form_input" name="docName[]" id="docName_{{$count_num}}" @if($save_status!='lead') readonly  @endif  value="{{@$doc['documentName']}}">
                                    {{--<input class="form_input" name="docName[]" hidden  value="{{@$doc['documentId']}}">--}}
                                @endif

                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="form_group">
                                <label class="form_label">Document Description @if($current_path=='dispatch/receptionist-list' || $current_path=='dispatch/dispatch-list' )<span>*</span>@endif</label>
                                <input class="form_input" name="docDesc[]" id="docDesc_{{$count_num}}" @if($save_status!='lead') readonly @endif  value="{{@$doc['documentDescription']}}">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="div">
                            <div class="form_group">
                                <div class="table_div">
                                    <div class="table_cell">
                                        <label class="form_label">Select Type @if($current_path=='dispatch/receptionist-list' || $current_path=='dispatch/dispatch-list' )<span>*</span>@endif</label>
                                        @if($save_status=='lead')
                                            <div class="">
                                                <select class="selectpicker docType" name="type[]" id="type{{$count_num}}"  @if($save_status!='lead') disabled @endif onchange="dropValidation(this)">
                                                    <option value="" selected disabled>Select Type</option>
                                                    @if(!empty($DispatchType))
                                                        @forelse($DispatchType as $dtypes)
                                                            <option value="{{$dtypes->_id}}" @if($dtypes->_id==$doc['documentTypeId']) selected @endif>{{$dtypes->type}}</option>
                                                        @empty
                                                            No types found.
                                                        @endforelse
                                                    @endif
                                                </select>
                                            </div>
                                        @else
                                            <input class="form_input"  id="type{{$count_num}}" @if($save_status!='lead') readonly @endif  value="{{@$doc['documentType']}}"  >
                                            <input hidden="" name="type[]"   value="{{@$doc['documentTypeId']}}"  >
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div id="doc_amount_div{{$count_num}}" >
                            <div class="form_group">
                                <label id="amountlabel_{{$count_num}}" class="form_label">Amount / No Of Cards @if($current_path=='dispatch/receptionist-list' || $current_path=='dispatch/dispatch-list' )<span>*</span>@endif</label>
                                <input class="form_input" name="doc_amount[]" id="doc_amount_{{$count_num}}"
                                       @if($save_status!='lead' || (@$doc['amount']=='NA' || $save_status =='lead') && (@$doc['documentName'] !='Cash' && @$doc['documentName'] !='Cheque'&& @$doc['documentName'] !='Medical cards')) readonly  value="{{@$doc['amount']?:'NA'}}" @else type="number" value="{{@$doc['amount']}}" @endif  >
                            </div>
                        </div>
                    </td>
                    <td class="collected_amount_div" @if(@$doc['doc_collected_amount'] !="" || $current_path=='dispatch/delivery' || $current_path=='dispatch/transferred-list' ||
                    ($current_path!='dispatch/dispatch-list' && $leadDetails->dispatchType['dispatchType'] == 'Direct Collections' && ($doc['DocumentCurrentStatus']=='18' || $doc['DocumentCurrentStatus']=='2' || $doc['DocumentCurrentStatus']=='9'|| $doc['DocumentCurrentStatus']=='6' ||$doc['DocumentCurrentStatus']=='15' || $doc['DocumentCurrentStatus']=='7' || $doc['DocumentCurrentStatus']=='17'))) style="display: block" @else style="display: none" @endif>
                        <div id="doc_amount_div{{$count_num}}">
                            <div class="form_group">
                                <label id="labelCollectedAmount" class="form_label">Collected Amount @if($current_path=='dispatch/delivery' )<span>*</span>@endif</label>
                                <input class="form_input collected_amount_class" name="doc_collected_amount[]"  id="doc_collected_amount_{{$count_num}}"
                                       @if((@$doc['documentName'] =='Cash' || @$doc['documentName'] =='Cheque' || @$doc['documentName'] =='Medical cards') &&(($current_path =='dispatch/delivery')|| ($leadDetails->dispatchType['dispatchType'] == 'Direct Collections' && $doc['DocumentCurrentStatus']=='') || ($current_path!='dispatch/dispatch-list'  && $leadDetails->dispatchType['dispatchType'] == 'Direct Collections' && $doc['DocumentCurrentStatus']=='18')))
                                       required type="number" min="0"
                                       @else
                                       readonly
                                       @endif
                                value="{{@$doc['doc_collected_amount']?:'NA'}}" >
                            </div>
                        </div>
                    </td>
                    @if($current_path=='dispatch/delivery')
                        <td>
                            <div class="row_action" >
                                <button type="button" id="deliveryid_{{$count_num}}" value="{{@$doc['id']}}" data-toggle="tooltip" data-placement="bottom" title="Delivered" data-container="body" class="delivered" onclick="buttonclick(this)"><i class="fas fa-check-circle"></i></button>
                                <button type="button" id="notdelivertryid_{{$count_num}}" value="{{@$doc['id']}}" data-modal="notDeliveredPopup" data-toggle="tooltip" data-placement="bottom" title="Not Delivered" data-container="body" name="{{$doc['documentName']}}"  class="not_delivered auto_modal" onclick="buttonnotclick(this)"><i class="fas fa-times-circle"></i></button>
                                <button type="button" id="cancelid_{{$count_num}}" value="{{@$doc['id']}}" data-toggle="tooltip" data-placement="bottom" title="Cancel" data-container="body" class="cancel_row" onclick="cancelclick(this)"><i class="fas fa-ban"></i></button>
                                <label id="action-error" style="color: red;display: none;margin: 10px 20px 0;">Please type comment</label>
                                <input class="action" type="hidden" id="action_{{$count_num}}" name="action[]">
                                <input type="hidden" id="cust_{{$count_num}}" name="cust[]">
                                <input type="hidden" id="preferred_date_{{$count_num}}" name="preferred_date[]">
                                <input type="hidden" id="remarks_{{$count_num}}" name="remarks[]">
                            </div>
                        </td>
                    @endif

                        <td>
                            @if(isset($doc['signUpload'])&&$doc['signUpload']!='')
                                <a style="color:#15c0ff;text-decoration:none;text-transform:  uppercase;font-weight:  600;font-size: 14px;" href="{{$doc['signUpload']}}" target="_blank">View Sign
                                </a>
                                @else
                                <a style="display: none" href="#" target="_blank">View Sign
                                </a>
                            @endif
                        </td>
                    <td>
                            @if(isset($doc['fileUpload'])&&$doc['fileUpload']!='')
                                <a style="color:#15c0ff;text-decoration:none;text-transform:  uppercase;font-weight:  600;font-size: 14px;" href="{{$doc['fileUpload']}}" target="_blank">View File
                                </a>
                                @else
                                <a style="display: none" href="#" target="_blank">View Sign
                                </a>
                            @endif
                        </td>

                    @if(($doc['DocumentCurrentStatus'] == 18 &&  $current_path=='dispatch/receptionist-list') || ($doc['DocumentCurrentStatus'] ==1 && $current_path=='dispatch/dispatch-list') || ($doc['DocumentCurrentStatus'] ==10 && $current_path=='dispatch/dispatch-list'))
                        @if($save_status=='lead')
                            <td>
                                @if($count_num!=1)
                                    @if($save_status!='lead')
                                        <div class="table_div">
                                            <div  class="remove_btn remove_field"><i class="fa fa-minus"></i></div>
                                        </div>
                                    @endif
                                @else
                                    <div class="table_div">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Add" id="p"  class="addField_btn add_field_button" ><i class="fa fa-plus"></i></div>
                                    </div>
                                @endif
                            </td>
                        @endif
                    @endif
                    @if($doc['DocumentCurrentStatus']==2 &&  $current_path=='dispatch/receptionist-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Delivered" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==4 &&  $current_path=='dispatch/receptionist-list')
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Reschedule For Another Day" style="color: Red;cursor: default"><i class="material-icons">info</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==5 &&  $current_path=='dispatch/receptionist-list')
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Could Not Contact" style="color: Red;cursor: default"><i class="material-icons">info</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==8 &&  $current_path=='dispatch/receptionist-list')
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Cancel" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                            </div>
                        </td>
                    @endif
                    @if(($doc['DocumentCurrentStatus']==6 || $doc['DocumentCurrentStatus']==15)&&  ($current_path=='dispatch/receptionist-list' || $current_path=='dispatch/dispatch-list'))
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Transfer Accept" style="color: Green;cursor: default"><i class="material-icons">done</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==9 &&  $current_path=='dispatch/employee-view-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Delivered" style="color: Green;cursor: default"><i class="material-icons">info</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==14 &&  $current_path=='dispatch/employee-view-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Cancel" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==9 &&  $current_path=='dispatch/transferred-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Transferred" style="color: Green;cursor: default"><i class="material-icons">check_circle</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==14 && $current_path=='dispatch/transferred-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Transferred" style="color: green;cursor: default"><i class="material-icons">check_circle</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==17 &&  $current_path=='dispatch/receptionist-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Transfer Not Accept" style="color: Red;cursor: default"><i class="material-icons">not_interested</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($doc['DocumentCurrentStatus']==12 &&  $current_path=='dispatch/receptionist-list' )
                        <td>
                            <div>
                                <div data-toggle="tooltip" data-placement="bottom" title="Reject from schedule for delivery" style="color: Red;cursor: default"><i class="material-icons">cancel</i> </div>
                            </div>
                        </td>
                    @endif
                    @if($current_path=='dispatch/complete-list' || $current_path=='dispatch/schedule-delivery' || $current_path=='dispatch/dispatch-list' )
                        <td>
                            <div>
                                <div></div>
                            </div>
                        </td>
                    @endif



                </tr>


				<?php $count++;?>
				<?php  $count_num++;?>
            @endif
        @endforeach
    </table>
    <style>
        #view_lead_popup .modal_content .form_label {
            max-width: 180px !important;
        }
        .card_separation {
            /*overflow-x: auto;*/
        }
        .tooltip {
            /*z-index: 999999999;*/
        }
        .lead_block tr:first-child .form_label {
            display: block;
        }
    </style>
@endif



















