
@if(count(@$document)>0)
    <?php $count_num =1; ?>
    <?php $count=0;?>
    <?php  
    if(session('employees_supervisor')) {
        $employee_id =session('employees_supervisor');
        $uniqvalCollected=[];
        $uniqvalTransfer=[];
        $transferto= @$leadDetails->transferTo;
        foreach ($transferto as $key => $value) {
            if($leadDetails->dispatchType['dispatchType']=='Collections' || $leadDetails->dispatchType['dispatchType']=='Direct Collections'
                || $leadDetails->dispatchType['dispatchType']=='Delivery & Collections')
                {
                    if($value['status']=='Transferred' && in_array($value['id'],$employee_id)) {
                        $uniqvalTransfer[] = $value['uniqval'];
                    }
                    if($value['status']=='Collected' && in_array($value['id'],$employee_id)) {
                        $uniqvalCollected[] = $value['uniqval'];
                    }
                }
                else if($leadDetails->dispatchType['dispatchType']!='Collections' || $leadDetails->dispatchType['dispatchType']!='Direct Collections' || $leadDetails->dispatchType['dispatchType']!='Delivery & Collections')
                    {
                        if($value['status']=='Transferred' && in_array($value['id'],$employee_id)) {
                            $uniqvalCollected[] = $value['uniqval'];
                        }
                    }
        }
    } else{
        $employee_id =(string)session('employee_id');
        $uniqvalCollected=[];
        $uniqvalTransfer=[];
        $transferto= @$leadDetails->transferTo;
        foreach ($transferto as $key => $value) {
    	    if($leadDetails->dispatchType['dispatchType']=='Collections' || $leadDetails->dispatchType['dispatchType']=='Direct Collections'
            || $leadDetails->dispatchType['dispatchType']=='Delivery & Collections')
    		{
			    if($value['status']=='Transferred' && (string)$value['id']==$employee_id) {
				    $uniqvalTransfer[] = $value['uniqval'];
			    }
			    if($value['status']=='Collected' && $value['id']==$employee_id) {
				    $uniqvalCollected[] = $value['uniqval'];
			    }
            }
            else if($leadDetails->dispatchType['dispatchType']!='Collections' || $leadDetails->dispatchType['dispatchType']!='Direct Collections' || $leadDetails->dispatchType['dispatchType']!='Delivery & Collections')
            	{
		            if($value['status']=='Transferred' && (string)$value['id']==$employee_id) {
			            $uniqvalCollected[] = $value['uniqval'];
		            }
                }
        }
    }
   
    ?>
    @foreach(@$document as $doc)
        @if($doc['DocumentCurrentStatus']=='9' || $doc['DocumentCurrentStatus']=='14')
        @if((($requestMethod=='transfer_popup_button'|| $requestMethod=='delivered_button'|| $requestMethod=='reject_button1') && in_array( $doc['uniqTransferId'],$uniqvalCollected)) ||
         ($requestMethod=='collected_button' && in_array( $doc['uniqTransferId'],$uniqvalTransfer))  || ($requestMethod=='reject_collection_button' && in_array( $doc['uniqTransferId'],$uniqvalTransfer))
         || ($requestMethod=='delivered_button' && in_array( $doc['uniqTransferId'],$uniqvalTransfer))
         )
    <tr> 
        <input type="hidden" class="transfer_class" value="{{$doc['id']}}" name="docDetid[]">
            <td>
                <div>
                    <div class="form_group">
                        <label class="form_label">Select Type<span style="visibility: hidden">*</span></label>
                            <input class="form_input" name="docName[]" id="docNamePop_{{$count_num}}"  readonly   value="{{@$doc['documentName']}}">
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div class="form_group">
                        <label class="form_label">Document Description <span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="docDesc[]" id="docDescPop_{{$count_num}}" readonly value="{{@$doc['documentDescription']}}">
                    </div>
                </div>
            </td>
            <td>
                <div class="div">
                    <div class="form_group">
                        <div class="table_div">
                            <div class="table_cell">
                                <label class="form_label">Select Type <span style="visibility: hidden">*</span></label>
                                    <input class="form_input" name="type[]" id="typePop{{$count_num}}" readonly value="{{@$doc['documentType']}}">
                            </div>

                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div   id="doc_amount_div{{$count_num}}">
                    <div class="form_group">
                        <label id="labelamount" class="form_label">Amount / No of Cards<span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="doc_amount[]"  id="doc_amountPop_{{$count_num}}" readonly  value="{{$doc['amount']?:'NA'}}">
                    </div>
                </div>
            </td>

            <td class="collected_amount_div">
                <div  id="doc_amount_div{{$count_num}}">
                    <div class="form_group">
                        <label id="labelCollectedAmount" class="form_label">Collected Amount<span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="doc_collected_amount[]"  id="doc_collected_amountPop_{{$count_num}}"  readonly
                               {{--@if(isset($doc['doc_collected_amount']))--}}
                                   {{--@if($doc['doc_collected_amount']=='' ||$doc['doc_collected_amount']=='NA' ||$doc['doc_collected_amount']=='null' )--}}
                                       {{--<?php $val='NA';?>--}}
                                   {{--@else--}}
                                       {{--<?php $val=$doc['doc_collected_amount'];?>--}}
                                   {{--@endif--}}
                               {{--@else--}}
                                   {{--<?php $val='NA';?>--}}
                               {{--@endif--}}
                               value="{{@$doc['doc_collected_amount']?:'NA'}}">
                    </div>
                </div>
            </td>

    </tr>
        @endif
	        <?php $count++;?>
	        <?php  $count_num++;?>
        @endif
    @endforeach


<style>
    .md_popup .cd-popup-container{
        max-width: 1170px;
    }
    .lead_block tr .form_label {
        min-width: 160px;
    }
</style>

@endif



















