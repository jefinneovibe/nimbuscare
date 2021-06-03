@extends('layouts.new_layout')

@section('content')

@if(isset($pipeline_details['insurerResponse']['response']) && @$pipeline_details['insurerResponse']['response']!='')
<label class="badge badge-info right">{{$pipeline_details['insurerResponse']['response']}} by the Insurer</label>
    @else
    <label class="badge badge-info right">Pending insurer response</label>
    @endif
<br><br>
<form name="accounts" id="accounts" method="post">
<input type="hidden" id="workTypeDataId" name="workTypeDataId" value="{{@$workTypeDataId}}">
<input type="hidden" id="page" name="page" value="issuance">
    <div class="dataatable comparesec">
        <div id="admins">
            <div class="materialetable">
                <div  class="tablefixed heightfix commonfix">
                    <div class="table_left_fix">
                        <div class="materialetable table-responsive">
                            <table class="table customer_table">
                                <thead>
                                    <tr>
                                        <th><div class="mainsquestion"><b class="blue">SELECTED INSURER: {{@$Insurer[0]['insurerDetails']['insurerName']}}</b></div></th>
                                        <th><div class="mainsanswer" style="background-color: transparent"><b class=" blue">Customer Response</b></div></th>
                                    </tr>
                                </thead>
                                <tbody class="syncscroll" name="myElements">
                                        @if($eComparisonData)
                                        <?php $quest_feildName = []; ?>
                                            @foreach(@$eComparisonData['review'] as $review)
                                                @if($review['type'] == 'checkbox')
                                                <?php  $quest_feildName[] =$review['fieldName'];?>
                                                    <tr class="">
                                                        <td><div class="mainsquestion"><label class="titles">{{@$review['label']}}</label></div></td>
                                                            @if($review['type'] == 'checkbox')
                                                                <td class="mainsanswer"><div class="ans">Yes</div></td>
                                                            @else
                                                                <td class="mainsanswer">
                                                                    <div class="ans">
                                                                        @if (@$review['value'])
                                                                            {{@$review['value']}}
                                                                        @else
                                                                            --
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @foreach(@$eComparisonData['forms'] as $forms)
                                            <tr class="">
                                                    <?php  $quest_feildName[] =$forms['fieldName']; ?>
                                                <td><div class="mainsquestion"><label class="titles">{{@$forms['label']}}</label></div></td>
                                                @if(is_array(@$forms['value']))
                                                    @if(@$forms['fieldName'] == 'CombinedOrSeperatedRate')
                                                        <td class="mainsanswer">
                                                            <div class="ans">
                                                                @if(@$forms['value']['seperateStatus'] == 'seperate')
                                                                    Admin Rate : {{@$forms['value']['adminRate']}}
                                                                    Non-Admin Rate : {{@$forms['value']['nonAdminRate']}}
                                                                @else
                                                                    Combined Rate : {{@$forms['value']['combinedRate']}}
                                                                    @if (@$forms['value']['Premium'])
                                                                    <br>    Premium :  {{@$forms['value']['Premium']}}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="mainsanswer">
                                                            <div class="ans">
                                                                @if (isset($forms['value']['isChecked']) && @$forms['value']['isChecked'] == 'yes')
                                                                    Yes
                                                                @else
                                                                <?php
                                                                if (gettype(@$forms['value']) == 'array' && !empty(@$forms['value'])) {
                                                                    $indexArray =array_values($forms['value']);
                                                                    if (strtolower(@$indexArray[0]) == 'yes') {
                                                                        ?>
                                                                        yes
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        --
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                        --
                                                                    <?php
                                                                }
                                                            ?>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td class="mainsanswer">
                                                        <div class="ans">
                                                                @if (@$forms['value'])
                                                                    {{@$forms['value']}}
                                                                @else
                                                                --
                                                                @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        @endif
                                    <tr>
                                        <td><div class="main_question"><label class="form_label bold">Customer Decision</label></div></td>
                                        <td class="main_answer"><div class="ans"></div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="table_right_pen">
                        <div  id="scrollstyle" class="materialetable table-responsive">
                            <table class="table comparison">
                                <thead>
                                    <tr>
                                        @if(@$Insurer)
                                            @foreach(@$Insurer as $key =>$Insurer1)
                                                <th><div class="ans"> </div></th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                    @if(@$InsurerData)
                                        @foreach (@$quest_feildName as $k =>$v)
                                            <?php
                                                $key=$v;
                                                $Insurer1=@$InsurerData[$v];
                                                $number=0;
                                                $insurerCount=count($Insurer);
                                            ?>
                                            <tr class="">
                                                @if(count(@$Insurer1)>0)
                                                    @foreach(@$Insurer1 as $key1 =>$Insurerr)
                                                        @if($loop->first && $key1!=$number)
                                                            @for($i=$number;$i<($key1-$number);$i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @elseif(($key1-$number)>1)
                                                            @for($i=$number;$i<($key1-$number);$i++)
                                                                <td><div class="ans"></div></td>
                                                            @endfor
                                                        @endif
                                                        <?php $number=$key1; ?>
                                                        <td>
                                                            <div class="ans">
                                                                @if(@$formData[@$Insurerr['fieldName']]['fieldName'] == $key)
                                                                @if(@$Insurerr['agreeStatus'] == 'agreed')
                                                                Covered
                                                                @elseif(@$Insurerr['agreeStatus'] == 'disagreed')
                                                                Not Covered
                                                                @else
                                                                {{@$Insurerr['agreeStatus']}}
                                                                @endif<br>
                                                                    @if(isset($Insurerr['comments']) && $Insurerr['comments'])
                                                                        <span style="color:black;">{{$Insurerr['comments']}}</span>
                                                                    @endif

                                                                @else
                                                                <span class="removeTr" style="display:none"></span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @else
                                                    @for($i=0;$i<($insurerCount);$i++)
                                                        <td><div class="ans">--</div></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @if(@$Insurer)
                                                    @foreach(@$Insurer as $key =>$Insurer2)
                                                    <td><div class="ans">
                                                    @if(@$Insurer2['customerDecision']['decision'])
                                                            {{@$Insurer2['customerDecision']['decision']}}<br>
                                                    @endif
                                                    </div></td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <label class="blue"><b>Policy Entries</b></label>
    <br><br>
    <div class="contentbodytwo backgroundwhite">

        <div class="row">
            <div class="col-12">
                @if(@$Insurer)
                        @foreach(@$Insurer as $key =>$Insurer2)
                        <td><div class="ans">
                        <label><b>Insurance Company : {{@$Insurer2['insurerDetails']['insurerName']}}</b></label>
                        <input type="hidden" name="insurer_name" value="{{@$Insurer2['insurerDetails']['insurerName']}}">
                        </div></td>
                    @endforeach
                @endif

            </div>
        </div>
        <hr>



        <div class="row">
            <div class="col-6 border_line">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Insurer Policy Number<span>*</span></label>
                            <input type="text" class="form-control"  name="policy_no" id="policy_no" placeholder="Enter Insurer Policy Number" value="{{@$pipeline_details['accountsDetails']['insurerPolicyNumber']}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">IIB Policy Number
                            {{--  <span>*</span>  --}}
                            </label>
                            <input type="text" class="form-control" name="iib_policy_no" id="iib_policy_no" placeholder="Enter IIB Policy Number" value="{{@$pipeline_details['accountsDetails']['iibPolicyNumber']}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Premium Invoice 
                            {{--  <span>*</span>  --}}
                            </label>
                            <input type="text" class="form-control" name="premium_invoice" id="premium_invoice" placeholder="Enter Premium Invoice" value="{{@$pipeline_details['accountsDetails']['premiumInvoice']}}">
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div class="form-group">
                            <label class="titles">Premium Invoice Date
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                                <input class="form-control date" autocomplete="off" placeholder="Enter Premium Invoice Date" type="text"   name="premium_invoice_date" id="premium_invoice_date" value="{{@$pipeline_details['accountsDetails']['premiumInvoiceDate']}}">
                                <div onclick="$('#premium_invoice_date').trigger('focus');" class="input-group-append">
                                    <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Commission Invoice 
                            {{--  <span>*</span>  --}}
                            </label>

                            <input type="text" class="form-control"name="commission_invoice" id="commission_invoice"  placeholder="Enter Commission Invoice" value="{{@$pipeline_details['accountsDetails']['commissionInvoice']}}">
                        </div>
                    </div>
                    <div class="col-6 form-group">
                        <label class="titles">Enter Commission Invoice Date 
                        {{--  <span>*</span>  --}}
                        </label>
                        <div class="input-group">
                            <input class="form-control date" autocomplete="off" placeholder="Enter Commission Invoice Date"  name="commission_invoice_date" id="commission_invoice_date" type="text" value="{{@$pipeline_details['accountsDetails']['commissionInvoiceDate']}}">
                            <div onclick="$('#commission_invoice_date').trigger('focus');" class="input-group-append">
                                <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label class="titles">Inception Date 
                        {{--  <span>*</span>  --}}
                        </label>
                            <div class="input-group">
                                <input class="form-control date" autocomplete="off" placeholder="Enter Inception Date" type="text"  value="{{@$pipeline_details['accountsDetails']['inceptionDate']}}" name="inception_date" id="inception_date">
                                <div onclick="$('#inception_date').trigger('focus');"  class="input-group-append">
                                    <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                </div>
                        </div>
                        <div class="col-6 form-group">
                            <label class="titles">Expiry Date 
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                                <input class="form-control date" autocomplete="off" placeholder="Enter Expiry Date" type="text" name="expiry_date" id="expiry_date" value="{{@$pipeline_details['accountsDetails']['expiryDate']}}">
                                <div onclick="$('#expiry_date').trigger('focus');" class="input-group-append">
                                    <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-6">
                            <div class="form-group">
                                <label class="titles">Currency 
                                {{--  <span>*</span>  --}}
                                </label>
                                <select class="selectpicker form-control" name="currency" id="currency">
                                    <option selected value="AED" name="AED" >AED</option>
                                </select>
                            </div>
                    </div>
                </div>

            </div>
            <!--left column end--->

            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Premium (Excl VAT) <span>*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control aed number" name="premium" id="premium" placeholder="Enter Premium (Excl VAT) " onkeyup="commission()" value="@if($pipeline_details['accountsDetails']['premium']!=''){{trim(number_format(@$pipeline_details['accountsDetails']['premium']))}}@elseif(@$pipeline_details['insurer_premium']!=""){{trim(number_format(@$pipeline_details['insurer_premium']))}}@endif">

                        </div>
                            {{-- <input type="text" class="form-control number" name="premium" id="premium" placeholder="Enter Premium (Excl VAT) " onkeyup="commission()" value="@if($pipeline_details['accountsDetails']['premium']!=''){{number_format(@$pipeline_details['accountsDetails']['premium'])}}@endif"> --}}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">VAT % <span>*</span></label>
                            <input type="number" id="vat" name="vat" class="form-control" onkeyup="commission()"
                                @if(isset($pipeline_details['accountsDetails']))
                                    value = "@if($pipeline_details['accountsDetails']['vatPercent']!=''){{number_format($pipeline_details['accountsDetails']['vatPercent'])}}@endif"
                                @else
                                    value = "5"
                                @endif placeholder="Enter VAT %">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">VAT (Total) <span>*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control aed number" id="vat_total" onkeyup="reverseCalculation()" name="vat_total" onblur="commission()"
                                @if(isset($pipeline_details['accountsDetails']))
                                    value = "@if($pipeline_details['accountsDetails']['vatTotal']!=''){{number_format($pipeline_details['accountsDetails']['vatTotal'])}}@endif"
                                {{-- @else
                                    value = "0" --}}
                                @endif placeholder="Enter VAT (Total)">

                        </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Commission % <span>*</span></label>
                            <input type="number" name="commision" id="commision" class="form-control"onkeyup="commission()"  
                            value="@if(@$pipeline_details['accountsDetails']['commissionPercent']!=''||@$pipeline_details['accountsDetails']['commissionPercent']!=null){{round(@$pipeline_details['accountsDetails']['commissionPercent'],2)}}@elseif(@$pipeline_details['insurer_brokerage']!=''){{round(@$pipeline_details['insurer_brokerage'],2)}}@endif"" placeholder="Enter Commission %">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Commission Amount (Premium) </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control aed  number" id="commission_premium_amount" onkeyup="commissionPercent()" name="commission_premium_amount" onblur="commission()"
                                @if(isset($pipeline_details['accountsDetails']))
                                    value="{{$pipeline_details['accountsDetails']['commissionPremium']}}"
                                {{-- @else
                                    value="0" --}}
                                @endif  placeholder="Enter Commission amount (Premium)">

                        </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Commission Amount (VAT) </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input id="commission_vat_amount"  class="form-control aed  number" onkeyup="commission()" name="commission_vat_amount" readonly
                                @if(isset($pipeline_details['accountsDetails']))
                                    value = "{{$pipeline_details['accountsDetails']['commissionVat']?:0}}"
                                {{-- @else
                                    value="0" --}}
                                @endif>
                        </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Insurer Discount
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control aed  number"  name="insurer_discount" id="insurer_discount" placeholder="Enter Insurer Discount" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['insurerDiscount']!=''){{number_format(@$pipeline_details['accountsDetails']['insurerDiscount'])}}@endif">

                        </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">IIB Discount
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control  aed number" name="iib_discount" id="iib_discount"  placeholder="Enter IIB Discount" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibDiscount']!=''){{number_format(@$pipeline_details['accountsDetails']['iibDiscount'])}}@endif">

                        </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">Insurer Fees
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control aed  number" name="insurer_fees" id="insurer_fees" placeholder="Enter Insurer Fees" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['insurerFees']!=''){{number_format(@$pipeline_details['accountsDetails']['insurerFees'])}}@endif">

                        </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">IIB Fees
                            {{--  <span>*</span>  --}}
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" class="form-control  aed number" name="iib_fees" id="iib_fees" placeholder="Enter IIB Fees" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibFees']!=''){{number_format(@$pipeline_details['accountsDetails']['iibFees'])}}@endif">

                        </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">NET Premium Payable To Insurer </label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input id="payable_to_insurer"  class="form-control  aed number" name="payable_to_insurer" readonly
                                @if(isset($pipeline_details['accountsDetails']))
                                    value="@if($pipeline_details['accountsDetails']['payableToInsurer']!=''){{number_format($pipeline_details['accountsDetails']['payableToInsurer'])}}@endif"
                                {{-- @else
                                    value="0" --}}
                                @endif  >
                        </div>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="titles">NET Premium Payable By Client </label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input id="payable_by_client" class="form-control  aed number" name="payable_by_client" readonly
                                @if(isset($pipeline_details['accountsDetails']))
                                value="@if($pipeline_details['accountsDetails']['payableByClient']!=''){{number_format($pipeline_details['accountsDetails']['payableByClient'])}}@endif"
                                {{-- @else
                                value="0" --}}
                                @endif   >
                        </div>

                        </div>
                    </div>
                    <input type="hidden" name="agent_commission_percent" id="agent_commission_percent" class="form_input"
                        @if(isset($pipeline_details['accountsDetails']))
                            value="{{round($pipeline_details['accountsDetails']['agentCommissionPecent'],2)}}"
                        @else
                            value="50"
                        @endif onkeyup="commission()">
                    <input id="agent_commission" type="hidden" class="form_input" onkeyup="reverseCalculation()" name="agent_commission_amount"  onblur="commission()"
                        @if(isset($pipeline_details['accountsDetails']))
                        value="{{$pipeline_details['accountsDetails']['agentCommissionAmount']}}"
                        {{-- @else
                        value="0" --}}
                        @endif>
                </div>
            </div>
            <!--right column end-->
        </div>

        </div>
        <br>

    <label class="blue"><b>Payment Details</b></label>
    <br><br>
    <div class="contentbodytwo backgroundwhite">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label class="titles">Payment Mode <span>*</span></label>
                    <select onchange="showChequeDiv(this)" class="selectpicker form-control" name="payment_mode" id="payment_mode">
                        <option @if(@$pipeline_details['accountsDetails']['paymentMode'] == 'cash') selected @endif value="Cash" name="Cash" >Cash</option>
                        <option @if(@$pipeline_details['accountsDetails']['paymentMode'] == 'Cheque') selected @endif value="Cheque" name="Cheque" >Cheque</option>
                        <option @if(@$pipeline_details['accountsDetails']['paymentMode'] == 'Bank_transfer') selected @endif value="Bank_transfer" name="Bank_transfer" >Bank Transfer</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="payment_mode" name="payment_mode" placeholder="Enter Payment Mode" value="{{@$pipeline_details['accountsDetails']['paymentMode']}}"> -->
                </div>
            </div>
            <div id="ChequeuDiv" @if(@$pipeline_details['accountsDetails']['paymentMode'] == 'Cheque')  style="display:block;" @else  style="display:none;" @endif    class="col-3">
                <div class="form-group">
                    <label class="titles">Cheque No<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Enter Cheque No"  value="{{@$pipeline_details['accountsDetails']['chequeNumber']}}">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="titles">Date Payment Sent To Insurer 
                    {{--  <span>*</span>  --}}
                    </label>
                    <div class="input-group">
                        <input class="form-control date" autocomplete="off" placeholder="Enter Payment Date sent to Insurer" type="text" name="date_send" id="date_send" value="{{@$pipeline_details['accountsDetails']['datePaymentInsurer']}}">
                        <div onclick="$('#date_send').trigger('focus');" class="input-group-append">
                            <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="titles">Payment Status 
                    {{--  <span>*</span>  --}}
                    </label>
                    <input type="text" class="form-control"  name="payment_status" id="payment_status" placeholder="Enter Payment Status" value="{{@$pipeline_details['accountsDetails']['paymentStatus']}}">
                </div>
            </div>
        </div>
    </div>

    <br>

    <label class="blue"><b>Installment Details</b></label>
    <br><br>
    <div class="contentbodytwo backgroundwhite">
        <div class="row">
            <div class="col-3">
                <label class="titles">Number Of Installments :</label>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="no_of_installments" id="No of Installments" placeholder="Enter Number of Installments" value="{{@$pipeline_details['accountsDetails']['noOfInstallment']}}">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-end commonbutton">
        <button type="submit" class="btn btn-primary btnload"
          {{-- @if(!isset($pipeline_details['insurerResponse']['response']) || $pipeline_details['insurerResponse']['response']!='approved')
                            disabled data-toggle="tooltip" data-titles="haii" @endif --}}
        >SAVE AND SUBMIT</button>
    </div>
 
</form>



@endsection

@push('widgetScripts')

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>



    <script>


        $(document).ready(function(){
            setTimeout(function() {
                $('#success_div').fadeOut('fast');
            }, 5000);
            materialKit.initFormExtendedDatetimepickers();

            // $('#expiry_date').datetimepicker();
            $("#inception_date").change( function () {
                var str = $("#inception_date").val();
                if( /^\d{2}\/\d{2}\/\d{4}$/i.test( str ) ) {
                    var parts = str.split("/");
                    var day = parts[0] && parseInt( parts[0], 10 );
                    var month = parts[1] && parseInt( parts[1], 10 );
                    var year = parts[2] && parseInt( parts[2], 10 );
                    var duration = 1;
                    if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {
                        var expiryDate = new Date( year, month - 1, day );
                        expiryDate.setFullYear( expiryDate.getFullYear() + duration );
                        var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                        var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                        var year = expiryDate.getFullYear();
                        if (day>1)
                        {
                            day = day-1;
                            day = ( '0' + day ).slice( -2 );
                        }
                        else
                        {
                            month = month-1;
                            if(month == 1 ||month == 3 ||month==5||month==7||month==8||month==10||month==12)
                            {
                                day = 31;
                            }
                            else
                            {
                                day = 30;
                            }
                            month = ( '0' + month ).slice( -2 );
                        }
                        $("#expiry_date").val( day + "/" + month + "/" + year );
                    }
                }
            });
            var premium= $('#premium').val(); 
            var commision= $('#commision').val();
            if(premium!=""||commision!=""){
                    vatTotal();
                    commissionAmount();
                    commissionVat();
                    agentCommission();
                    insurerPayable();
                    customerPayable();
            } 
        });
        function vatTotal()
        {
            var vat = $('#vat').val();
            var amount = amountTest($('#premium').val());
            var total = (amount*vat/100).toFixed(2);
            total=numberWithCommas(total);
            $('#vat_total').val(total);
            $('#hidden_vat_total').val(total);
        }
        function reverseCalculation()
        {
            commissionPercent();
            agentPercent();
            vatPercent();
            // commission();
        }
        function numberWithCommas(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1,$2");
            return x;
        }
        function amountTest(value){
            var stringvalue=value.toString();
            return Number(stringvalue.replace(/\,/g, ''));
        }
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
        function commission()
        {
            vatTotal();
            commissionAmount();
            commissionVat();
            agentCommission();
            insurerPayable();
            customerPayable();
            // commissionPercent();
        }

        function showChequeDiv(t) {
            $("#cheque_no-error").remove();
            if ($(t).val() == 'Cheque') {
                $("#cheque_no").rules("add", {
                    required : true
                });
                $("#ChequeuDiv").show();
            } else {
                $("#cheque_no").rules("remove", 'required');
                $("#ChequeuDiv").hide();
            }
        }
        function commissionAmount()
        {
            var premium = amountTest($('#premium').val());
            var insurer_discount = amountTest($('#insurer_discount').val());
            var commission =$('#commision').val();
            var total_commission = ((premium-insurer_discount)*commission/100).toFixed(2);
            total_commission=numberWithCommas(total_commission);
            $('#commission_premium_amount').val(total_commission);
            $('#hidden_commission_premium_amount').val(total_commission);
        }
        function commissionVat()
        {
            var vat = $('#vat').val();
            var premium = amountTest($('#premium').val());
            var insurer_discount = amountTest($('#insurer_discount').val());
            var commission = $('#commision').val();
            var total_commission = (((premium-insurer_discount)*vat/100)*commission/100).toFixed(2);
            total_commission=numberWithCommas(total_commission);
            $('#commission_vat_amount').val(total_commission);
            $('#hidden_commission_vat_amount').val(total_commission);

        }
        function agentCommission()
        {
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var agent_commission = amountTest($('#agent_commission_percent').val());
            var agent_amount = (commissionAmount*agent_commission/100).toFixed(2);
            agent_amount=numberWithCommas(agent_amount);
            $('#agent_commission').val(agent_amount);
            $('#hidden_agent_commission').val(agent_amount);

        }
        function insurerPayable()
        {
            var premium = amountTest($('#premium').val());
            var vat_total = amountTest($('#vat_total').val());
            var insurer_discount = amountTest($('#insurer_discount').val());
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var commissionVat = amountTest($('#commission_vat_amount').val());
            var payable = ((premium+vat_total)-insurer_discount-commissionAmount-commissionVat).toFixed(2);
            payable=numberWithCommas(payable);
            $('#payable_to_insurer').val(payable);
            $('#hidden_payable_to_insurer').val(payable);
        }
        function customerPayable()
        {
            var vat = $('#vat').val();
            var vat_total = amountTest($('#vat_total').val());
            var premium = (amountTest($('#premium').val()));
            if (premium=="")
            {
                premium = 0;
            }
            else
            {
                premium = parseFloat(premium);
            }
            var insurer_discount = amountTest($('#insurer_discount').val());
            if(insurer_discount == "")
                insurer_discount=0;
            else
                insurer_discount=parseFloat(insurer_discount);
            var iib_discount = amountTest($('#iib_discount').val());
            if(iib_discount == "")
                iib_discount = 0;
            else
                iib_discount = parseFloat(iib_discount);
            var insurer_fees = amountTest($('#insurer_fees').val());
            if (insurer_fees == "")
                insurer_fees = 0;
            else
                insurer_fees = parseFloat(insurer_fees);
            var iib_fees = amountTest($('#iib_fees').val());
            if(iib_fees == "")
                iib_fees=0;
            else
                iib_fees = parseFloat(iib_fees);
            if(insurer_discount>0)
            {
                var first = premium-insurer_discount-iib_discount;
                var second = insurer_fees*vat/100;
                var third = first+second+iib_fees;
                var fourth = (premium-insurer_discount)*vat/100;
                var amount = (third+fourth).toFixed(2);
            }
            else
            {
                var amount = (premium+vat_total-iib_discount).toFixed(2);
            }
            amount=numberWithCommas(amount);
            $('#payable_by_client').val(amount);
            $('#hidden_payable_by_client').val(amount);
        }
        function commissionPercent()
        {
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var premium = amountTest(($('#premium').val()));
            var iib_discount = amountTest($('#iib_discount').val());
            var commission = commissionAmount/(premium-iib_discount);
            commission = (commission*100).toFixed(2);
            $('#commision').val(commission);
        }
        function agentPercent()
        {
            var agentAmount = amountTest($('#agent_commission').val());
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var agentPercent = ((agentAmount/commissionAmount)*100).toFixed(2);
            agentPercent=numberWithCommas(agentPercent);
            $('#agent_commission_percent').val(agentPercent);
        }
        function vatPercent()
        {
            var premium = amountTest(($('#premium').val()));
            var vat_total = amountTest($('#vat_total').val());
            var vat = ((vat_total*100)/premium).toFixed(2);

            $('#vat').val(vat);
        }
        $.validator.addMethod('lessThanEqual', function(value, element, param) {
            //debugger;
            if (this.optional(element)) return true;
            var i = parseInt(value);
            var j = parseInt($(param).val());
            return i <= j;
        });
        $('#accounts').validate({
            ignore: ".ignore, :hidden",
            rules:{
               // date: {
               //     required: true
              //  },
                premium:{
                    required:true,
                    number:true
                },
                commision:{
                    required: true,
                    min :0,
                    max:100
                },
                agent_commission_percent:{
                    min :0,
                    max:100
                },
                policy_no:{
                    required:true
                },
               // iib_policy_no:{
                //    required:true
              //  },
                //premium_invoice:{
               //     required:true
               // },
              //  premium_invoice_date:{
               //     required:true
               // },
               // commission_invoice:{
               //     required:true
               // },
                //commission_invoice_date:{
               //     required:true
               // },
               // inception_date:{
               //     required:true
               // },
               // expiry_date:{
              //      required:true
               // },
               // currency:{
               //     required:true
               // },
                payment_mode:{
                    required:true
                },
               // date_send:{
               //     required:true
               // },
                //payment_status:{
                //    required:true
               // },
                vat:{
                    required:true,
                    min:0,
                    max:100
                },
                vat_total:{
                    number:true
                },
                commission_premium_amount:{
                    number:true
                },
                commission_vat_amount:{
                    number:true
                },
                insurer_discount:{
               //     required:true,
                    number:true,
                   //lessThanEqual: "#premium"
                },
                iib_discount:{
              //      required:true,
                    number:true,
                   //lessThanEqual: "#premium"
                },
                insurer_fees:{
               //     required:true,
                    number:true
                },
                iib_fees:{
               //     required:true,
                    number:true
                },
                payable_by_client:{
                    number:true,
                //    min:0
                },
                payable_to_insurer:{
                    number:true,
                //    min:0
                }
            },
            messages:{
                premium:"Please enter premium.",
                commision:"Please enter commission.",
                vat_total:"Please enter vat(total).",
                agent_commission_percent:"Please enter agent commission",
                policy_no:"Please enter insurer policy number.",
              //  iib_policy_no:"Please enter iib policy number.",
              //  premium_invoice:"Please enter premium invoice.",
              //  premium_invoice_date:"Please select premium invoice date.",
              //  commission_invoice:"Please enter commission invoice.",
              //  commission_invoice_date:"Please select commission invoice date.",
              //  inception_date:"Please select inception date.",
              //  expiry_date:"Please select an expiry date.",
              //  currency:"Please enter currency.",
                payment_mode:"Please enter payment mode.",
                cheque_no:"Please enter cheque number",
                //date_send:"Please select date.",
                //payment_status:"Please enter payment status.",
                iib_discount:{
                     number:"Please enter digits",
                    lessThanEqual:"iib discount should be less than premium"
                },
                insurer_discount:{
                     number:"Please enter digits",
                    lessThanEqual:"insurer discount should be less than or equal to premium"
                },
                //delivery_mode:"Please enter delivery mode.",
                //payable_to_insurer:"value should be greater than or equal to zero",
                //payable_by_client:"value should be greater than or equal to zero"
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('datetimepicker')) {
                    error.insertAfter(element.parent());
                } else if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#accounts")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                //$("#eslip_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('save-approved-equote')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result == 'success')
                        {
                            location.href = "{{url('pending-approvals')}}";
                        }
                    }
                });
            }
        });



        $.validator.addMethod('date',
            function(value, element) {

                if (this.optional(element)) {
                return true;
                }

                var ok = true;
                try {
                $.datepicker.parseDate('dd/mm/yy', value);
                } catch (err) {
                ok = false;
                }
                console.log(ok)
                return ok;
            });


            function saveAndSubmitLater(type)
        {
            var form_data = new FormData($("#accounts")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('type', 'draft');
            $('#preLoader').show();
            //$("#eslip_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('save-approved-equote')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
                    location.reload();
                    if(result == 'success')
                    {
                        $('#success_message').html('Approved E-Quot is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('Approved E-Quot saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
























//---------------------------for form----------------------------------
        $(document).ready(function() {
            $('.removeTr').parent().parent().parent().remove();
        });
        $(function () {
            let show = 'show';

            $('input').on('checkval', function () {
                let label = $(this).next('label');
                if(this.value !== '') {
                label.addClass(show);
            } else {
                label.removeClass(show);
                }
            }).on('keyup', function () {
                $(this).trigger('checkval');
            });
        });
        $(function () {
            let show = 'show';

            $('textarea').on('checkval', function () {
                let label = $(this).next('label');
                if(this.value !== '') {
                label.addClass(show);
            } else {
                label.removeClass(show);
                }
            }).on('keyup', function () {
                $(this).trigger('checkval');
            });
        });


    // -------------------------------------------for table e quotation------------------------------------------------------------
        function resizeHandler() {
            // Treat each container separately
            $(".heightfix").each(function(i, heightfix) {
                // Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
                // Loop through the tables
                $(heightfix).find("table").each(function(indx, table) {
                    // Loop through the rows of current table
                    $(table).find("tr").css("height", "").each(function(i, tr) {
                        // If there is already a row height defined
                        if (aRowHeights[i])
                        // Replace value with height of current row if current row is higher.
                            aRowHeights[i] = Math.max(aRowHeights[i], $(tr).height());
                        else
                        // Else set it to the height of the current row
                            aRowHeights[i] = $(tr).height();
                    });
                });
                // Loop through the tables in this container separately again
                $(heightfix).find("table").each(function(i, table) {
                    // Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.materialetable tbody tr');

            rows.hover(function(){
                var i = $(this).GetIndex() + 1;
                rows.filter(':nth-child(' + i + ')').addClass('hoverx');
            },function(){
                rows.removeClass('hoverx');
            });
        });

        jQuery.fn.GetIndex = function(){
            return $(this).parent().children().index($(this));
        }
</script>
<script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
