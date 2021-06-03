
@if(count(@$document)>0)
    <?php $count_num =1; ?>
    <?php $count=0;?>

    @foreach(@$document as $doc)
        @if(((($requestMethod=='approve')&& ($doc['DocumentCurrentStatus']=='4' ||$doc['DocumentCurrentStatus']=='5')) ||
        ($requestMethod=='transfer' && ($doc['DocumentCurrentStatus']=='2' || $doc['DocumentCurrentStatus']=='8' ||
        $doc['DocumentCurrentStatus']=='17' ||$doc['DocumentCurrentStatus']=='6' || $doc['DocumentCurrentStatus']=='15')) ||
        ($requestMethod=='completed' &&($doc['DocumentCurrentStatus']=='6'||$doc['DocumentCurrentStatus']=='15'))) ||(@$dispatchType=='Direct Collections' && $requestMethod=='completed' &&($doc['DocumentCurrentStatus']=='2' || $doc['DocumentCurrentStatus']=='17')) )
    <tr>
        <input type="hidden" class="transfer_class" value="{{$doc['id']}}" name="docDetid[]">
            <td>
                <div>
                    <div class="form_group">
                        <label class="form_label">Select Type<span style="visibility: hidden">*</span></label>
                            <input class="form_input" name="docName[]" id="docNamePop1_{{$count_num}}"  readonly   value="{{@$doc['documentName']}}">
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <div class="form_group">
                        <label class="form_label">Document Description <span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="docDesc[]" id="docDescPop1_{{$count_num}}" readonly value="{{@$doc['documentDescription']}}">
                    </div>
                </div>
            </td>
            <td>
                <div class="div">
                    <div class="form_group">
                        <div class="table_div">
                            <div class="table_cell">
                                <label class="form_label">Select Type <span style="visibility: hidden">*</span></label>
                                    <input class="form_input" name="type[]" id="typePop1{{$count_num}}" readonly value="{{@$doc['documentType']}}">
                            </div>

                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div   id="doc_amount_div{{$count_num}}">
                    <div class="form_group">
                        <label id="labelamount" class="form_label">Amount / No of Cards<span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="doc_amount[]"  id="doc_amountPop1_{{$count_num}}" readonly  value="{{$doc['amount']?:'NA'}}">
                    </div>
                </div>
            </td>

            <td class="collected_amount_div">
                <div  id="doc_amount_div{{$count_num}}">
                    <div class="form_group">
                        <label id="labelCollectedAmount" class="form_label">Collected Amount<span style="visibility: hidden">*</span></label>
                        <input class="form_input" name="doc_collected_amount[]"  id="doc_collected_amountPop1_{{$count_num}}"  readonly
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



















