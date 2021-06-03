@extends('layouts.insurer_layout')
@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form id="e-quotation-form" method="post" name="e-quotation-form">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$pipeLineId}}" name="id" id="id">
                    <input type="hidden" name="quoteActive" id="quoteActive" @if(@$insurerReply['quoteStatus']=='active') value="true" @else value="false" @endif>
                    @if(@$token)
                        <input type="hidden" name="hiddenToken" id="hiddenToken" value="{{$token}}">
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">Name of the Insured</label>
                                <div class="enter_data">
                                    <p>{{@$formData['firstName']}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label">If there is any subsidiary/affliated company </label>
                                <div class="enter_data">
                                    <p>{{@$formData['aff_company']?:'--'}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Address Line 1</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['addressDetails']['addressLine1']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Address Line 2</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['addressDetails']['addressLine2']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Telephone Number</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['telno']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Fax Number</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['faxno']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Email ID</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['email']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Nature of Business</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['businessType']}}</p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Name of Chief engineer or plant manager</label>
                                    <div class="enter_data">
                                        <p>{{@$formData['chief_eng']?:'--'}}</p>
                                    </div>
                                </div>
                        </div>
                       
                </div>
                <div class="card_separation">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    {{-- <label class="form_label">Publications- Journal</label> --}}
                                    <table class="table table-bordered custom_table">
                                            <thead>
                                            <tr>
                                                <th style="position: absolute; top: 0; border: none;">Item No</th>
                                                <th>Description of items Please give full and exact description of all machines, including name of
                                                manufacturer , type, output, capacity, speed, load, voltage, amperage, Cycles, fuel,pressure, temperature etc.</th>
                                                <th style="position: absolute; top: 0; border: none;">Year of Manufacture</th>
                                                <th>Remarks Give particulars of any part of the machinery to be insured which has had a
                                                breakdown of failure during the last three years, which shows any signs of repair, or which is exposed to any special risk.</th>
                                                <th>Replacement value Please state current cost of replacing the machinery of the same kind and capacity (including oil in the case of transformers & switches) plus freight charges,
                                                 customs duties, costs of erection and also value of foundations, if the latter are to be insured.</th>
                                            </tr>
                                            </thead>
                                            <tbody class="optionBox">
                                                <tr class="block">
                                                        <td style="width: 80px;">
                                                            <textarea class="form_input" name="itemno" type="text" placeholder="Item No" readonly>@if(@$formData['equipment_details']['itemno']!=''){{@$formData['equipment_details']['itemno']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="itemno" type="text" placeholder="Item No" value="@if(@$form_data['equipment_details']['itemno']!=''){{@$form_data['equipment_details']['itemno']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea class="form_input" name="item_description" type="text" placeholder="Description of items" readonly>@if(@$formData['equipment_details']['description']!=''){{@$formData['equipment_details']['description']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="item_description" type="text" placeholder="Description of items " value="@if(@$form_data['equipment_details']['description']!=''){{@$form_data['equipment_details']['description']}}@endif" readonly> --}}
                                                        </td>
                                                        <td style="width: 155px;">
                                                            <textarea class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture" readonly>@if(@$formData['equipment_details']['manufac_year']!=''){{@$formData['equipment_details']['manufac_year']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture" value="@if(@$form_data['equipment_details']['manufac_year']!=''){{@$form_data['equipment_details']['manufac_year']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea  class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured" readonly>@if(@$formData['equipment_details']['remarks']!=''){{@$formData['equipment_details']['remarks']}}@endif</textarea>
                                                            {{-- <input class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured" value="@if(@$form_data['equipment_details']['remarks']!=''){{@$form_data['equipment_details']['remarks']}}@endif" readonly> --}}
                                                        </td>
                                                        <td>
                                                            <textarea class="form_input number" name="revalue" type="text" placeholder="Replacement value Please state current cost of replacing the machinery" readonly>@if(@$formData['equipment_details']['revalue']!=''){{number_format(@$formData['equipment_details']['revalue'],2)}}@endif</textarea>
                                                            {{-- <input class="form_input number" name="revalue" type="text" placeholder="Replacement value Please state current cost of replacing the machinery" value="@if(@$form_data['equipment_details']['revalue']!=''){{@$form_data['equipment_details']['revalue']}}@endif" readonly> --}}
                                                        </td>
                                                        
                                                    </tr>
                                            </tbody>
                                        </table>
                
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="card_separation" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label bold" id="claim_label">Claims experience <span style="visibility:hidden">*</span></label>
                                    <table class="table table-bordered custom_table">
                                        <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th>Claim amount</th>
                                            <th>Description</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <input type="hidden" value="Year 1" name="year[]" id="year1">
                                            <td>Year 1 </td>
                                            <td>
                                                <input class="form_input" name="claim_amount[]" id="claim_amount1"  value="@if(isset($formData['claimsHistory'][0]['claim_amount']) && (@$formData['claimsHistory'][0]['claim_amount'])!=""){{number_format(@$formData['claimsHistory'][0]['claim_amount'],2)}}@else--@endif" readonly>
                                                <label id="claim_amount1-error" class="error" for="claim_amount1" style="display: none">Please enter claim amount.</label>
                                            </td>
                                            <td><textarea class="form_input" name="description[]" id="description1"readonly>{{@$formData['claimsHistory'][0]['description']?:'--'}}</textarea>
                                                <label id="description1-error" class="error" for="description1" style="display: none">Please enter description.</label>
                                            </td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td>Year 2 <input type="hidden" value="Year 2" name="year[]" id="year2"></td>
                                            <td><input class="form_input" name="claim_amount[]" id="claim_amount2"  value="@if(isset($formData['claimsHistory'][1]['claim_amount']) && (@$formData['claimsHistory'][1]['claim_amount'])!=""){{number_format(@$formData['claimsHistory'][1]['claim_amount'],2)}}@else--@endif" readonly></td>
                                            <td><textarea class="form_input" name="description[]" id="description2"readonly>{{@$formData['claimsHistory'][1]['description']?:'--'}}</textarea></td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td>Year 3<input type="hidden" value="Year 3" name="year[]" id="year3"></td>
                                            <td><input class="form_input" name="claim_amount[]" id="claim_amount3"  value="@if(isset($formData['claimsHistory'][2]['claim_amount']) && (@$formData['claimsHistory'][2]['claim_amount'])!=""){{number_format(@$formData['claimsHistory'][2]['claim_amount'],2)}}@else--@endif" readonly></td>
                                            <td><textarea class="form_input" name="description[]" id="description3"readonly>{{@$formData['claimsHistory'][2]['description']?:'--'}}</textarea></td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($formData['localclause']) && $formData['localclause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Local Jurisdiction Clause <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="localclause_1" class="radio">
                                        <input type="radio" name="localclause" value="Agree" id="localclause_1" class="hidden" @if(@$insurerReply['localclause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="localclause_2" class="radio">
                                        <input type="radio" name="localclause" value="Not Agree" id="localclause_2" class="hidden" @if(@$insurerReply['localclause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="localclause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['localclause']['comment']}}</textarea>
                                </div>
                        </div>
                        </div>
                    @endif
  
                    @if(isset($formData['express']) && $formData['express']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Overtime, night works and express freight <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="express_1" class="radio">
                                        <input type="radio" name="express" value="Agree" id="express_1" class="hidden" @if(@$insurerReply['express']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="express_2" class="radio">
                                        <input type="radio" name="express" value="Not Agree" id="express_2" class="hidden" @if(@$insurerReply['express']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="express_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['express']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['airfreight']) && $formData['airfreight']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Airfreight<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="airfreight_1" class="radio">
                                        <input type="radio" name="airfreight" value="Agree" id="airfreight_1" class="hidden" @if(@$insurerReply['airfreight']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="airfreight_2" class="radio">
                                        <input type="radio" name="airfreight" value="Not Agree" id="airfreight_2" class="hidden" @if(@$insurerReply['airfreight']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="airfreight_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['airfreight']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['addpremium']) && $formData['addpremium']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Automatic Reinstatement of sum insured at pro rata additional premium<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="addpremium_1" class="radio">
                                        <input type="radio" name="addpremium" value="Agree" id="addpremium_1" class="hidden" @if(@$insurerReply['addpremium']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="addpremium_2" class="radio">
                                        <input type="radio" name="addpremium" value="Not Agree" id="addpremium_2" class="hidden" @if(@$insurerReply['addpremium']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="addpremium_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['addpremium']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['payAccount']) && $formData['payAccount']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Payment on account clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="payAccount_1" class="radio">
                                        <input type="radio" name="payAccount" value="Agree" id="payAccount_1" class="hidden" @if(@$insurerReply['payAccount']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="payAccount_2" class="radio">
                                        <input type="radio" name="payAccount" value="Not Agree" id="payAccount_2" class="hidden" @if(@$insurerReply['payAccount']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="payAccount_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['payAccount']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['primaryclause']) && $formData['primaryclause']== true)     
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form_label bold"><i class="fa fa-circle"></i>Primary Insurance clause<span>*</span></label>
                        </div>
                        <div class="form_group" style="padding-left: 15px;">
                            <div class="cntr">
                                <label for="primaryclause_1" class="radio">
                                    <input type="radio" name="primaryclause" value="Agree" id="primaryclause_1" class="hidden" @if(@$insurerReply['primaryclause'] == 'Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Agree</span>
                                </label>
                                <label for="primaryclause_2" class="radio">
                                    <input type="radio" name="primaryclause" value="Not Agree" id="primaryclause_2" class="hidden" @if(@$insurerReply['primaryclause'] == 'Not Agree') checked @endif/>
                                    <span class="label"></span>
                                    <span>Not Agree</span>
                                </label>
                            </div>
                        </div>
                    </div>   
                @endif
                @if(isset($formData['premiumClaim']) && $formData['premiumClaim']== true)     
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold"><i class="fa fa-circle"></i>Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached <span>*</span></label>
                    </div>
                    <div class="form_group" style="padding-left: 15px;">
                        <div class="cntr">
                            <label for="premiumClaim_1" class="radio">
                                <input type="radio" name="premiumClaim" value="Agree" id="premiumClaim_1" class="hidden" @if(@$insurerReply['premiumClaim'] == 'Agree') checked @endif/>
                                <span class="label"></span>
                                <span>Agree</span>
                            </label>
                            <label for="premiumClaim_2" class="radio">
                                <input type="radio" name="premiumClaim" value="Not Agree" id="premiumClaim_2" class="hidden" @if(@$insurerReply['premiumClaim'] == 'Not Agree') checked @endif/>
                                <span class="label"></span>
                                <span>Not Agree</span>
                            </label>
                        </div>
                    </div>
                </div>   
            @endif
                    @if(isset($formData['lossnotification']) && $formData['lossnotification']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Loss Notification – ‘as soon as reasonably practicable’ <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="lossnotification_1" class="radio">
                                        <input type="radio" name="lossnotification" value="Agree" id="lossnotification_1" class="hidden" @if(@$insurerReply['lossnotification']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="lossnotification_2" class="radio">
                                        <input type="radio" name="lossnotification" value="Not Agree" id="lossnotification_2" class="hidden" @if(@$insurerReply['lossnotification']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="lossnotification_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossnotification']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['adjustmentPremium']) && $formData['adjustmentPremium']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Adjustment of sum insured and premium (Mre-410)<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="adjustmentPremium_1" class="radio">
                                        <input type="radio" name="adjustmentPremium" value="Agree" id="adjustmentPremium_1" class="hidden" @if(@$insurerReply['adjustmentPremium']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="adjustmentPremium_2" class="radio">
                                        <input type="radio" name="adjustmentPremium" value="Not Agree" id="adjustmentPremium_2" class="hidden" @if(@$insurerReply['adjustmentPremium']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="adjustmentPremium_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['adjustmentPremium']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['temporaryclause']) && $formData['temporaryclause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Temporary repairs clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="temporaryclause_1" class="radio">
                                        <input type="radio" name="temporaryclause" value="Agree" id="temporaryclause_1" class="hidden" @if(@$insurerReply['temporaryclause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="temporaryclause_2" class="radio">
                                        <input type="radio" name="temporaryclause" value="Not Agree" id="temporaryclause_2" class="hidden" @if(@$insurerReply['temporaryclause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="temporaryclause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['temporaryclause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                   

                    @if(isset($formData['automaticClause']) && $formData['automaticClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Automatic addition clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="automaticClause_1" class="radio">
                                        <input type="radio" name="automaticClause" value="Agree" id="automaticClause_1" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="automaticClause_2" class="radio">
                                        <input type="radio" name="automaticClause" value="Not Agree" id="automaticClause_2" class="hidden" @if(@$insurerReply['automaticClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="automaticClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['automaticClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                   

                    @if(isset($formData['capitalclause']) && $formData['capitalclause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Capital addition clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="capitalclause_1" class="radio">
                                        <input type="radio" name="capitalclause" value="Agree" id="capitalclause_1" class="hidden" @if(@$insurerReply['capitalclause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="capitalclause_2" class="radio">
                                        <input type="radio" name="capitalclause" value="Not Agree" id="capitalclause_2" class="hidden" @if(@$insurerReply['capitalclause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="capitalclause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['capitalclause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['debris']) && $formData['debris']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Removal of debris<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="debris_1" class="radio">
                                        <input type="radio" name="debris" value="Agree" id="debris_1" class="hidden" @if(@$insurerReply['debris']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="debris_2" class="radio">
                                        <input type="radio" name="debris" value="Not Agree" id="debris_2" class="hidden" @if(@$insurerReply['debris']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="debris_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['debris']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['property']) && $formData['property']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Designation of property<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="property_1" class="radio">
                                        <input type="radio" name="property" value="Agree" id="property_1" class="hidden" @if(@$insurerReply['property']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="property_2" class="radio">
                                        <input type="radio" name="property" value="Not Agree" id="property_2" class="hidden" @if(@$insurerReply['property']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="property_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['property']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['errorclause']) && $formData['errorclause']== true)     
                    <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Errors and omission clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="errorclause_1" class="radio">
                                        <input type="radio" name="errorclause" value="Agree" id="errorclause_1" class="hidden" @if(@$insurerReply['errorclause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="errorclause_2" class="radio">
                                        <input type="radio" name="errorclause" value="Not Agree" id="errorclause_2" class="hidden" @if(@$insurerReply['errorclause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                    </div>
                @endif
                    @if(@$formData['aff_company']!='' && isset($formData['waiver']) && $formData['waiver']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Waiver of subrogation<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="waiver_1" class="radio">
                                        <input type="radio" name="waiver" value="Agree" id="waiver_1" class="hidden" @if(@$insurerReply['waiver']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="waiver_2" class="radio">
                                        <input type="radio" name="waiver" value="Not Agree" id="waiver_2" class="hidden" @if(@$insurerReply['waiver']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="waiver_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['waiver']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['claimclause']) && $formData['claimclause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Claims preparation clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="claimclause_1" class="radio">
                                        <input type="radio" name="claimclause" value="Agree" id="claimclause_1" class="hidden" @if(@$insurerReply['claimclause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="claimclause_2" class="radio">
                                        <input type="radio" name="claimclause" value="Not Agree" id="claimclause_2" class="hidden" @if(@$insurerReply['claimclause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="claimclause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['claimclause']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['Innocent']) && $formData['Innocent']== true)     
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i> Innocent non-disclosure <span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="Innocent_1" class="radio">
                                            <input type="radio" name="Innocent" value="Agree" id="Innocent_1" class="hidden" @if(@$insurerReply['Innocent'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="Innocent_2" class="radio">
                                            <input type="radio" name="Innocent" value="Not Agree" id="Innocent_2" class="hidden" @if(@$insurerReply['Innocent'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    @endif
                    @if(isset($formData['Noninvalidation']) && $formData['Noninvalidation']== true)     
                        <div class="row">
                            <div class="col-md-12">
                               
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Non-invalidation clause<span>*</span>
                                        </label>
                                   
                                </div>
                           
                            <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                            <label for="Noninvalidation_1" class="radio">
                                                <input type="radio" name="Noninvalidation" value="Agree" id="Noninvalidation_1" class="hidden" @if(@$insurerReply['Noninvalidation'] == 'Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Agree</span>
                                            </label>
                                            <label for="Noninvalidation_2" class="radio">
                                                <input type="radio" name="Noninvalidation" value="Not Agree" id="Noninvalidation_2" class="hidden" @if(@$insurerReply['Noninvalidation'] == 'Not Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Not Agree</span>
                                            </label>
                                    </div>
                            </div>
                            
                        </div>
                    @endif
                    @if(isset($formData['brokerclaim']) && $formData['brokerclaim']== true)     
                    <div class="row">
                        <div class="col-md-12">
                           
                                    <label class="form_label bold">
                                        <i class="fa fa-circle"></i>
                                        Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties<span>*</span>
                                    </label>
                               
                            </div>
                        <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                        <label for="brokerclaim_1" class="radio">
                                            <input type="radio" name="brokerclaim" value="Agree" id="brokerclaim_1" class="hidden" @if(@$insurerReply['brokerclaim'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="brokerclaim_2" class="radio">
                                            <input type="radio" name="brokerclaim" value="Not Agree" id="brokerclaim_2" class="hidden" @if(@$insurerReply['brokerclaim'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                </div>
                        </div>
                        
                    </div>
                @endif

                    {{-- @if(isset($formData['deductible']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Deductible for (Machinary Breakdown): <span>*</span></label>
                                <input class="form_input number" name="deductm"  value="@if(isset($insurerReply['deductm']) && $insurerReply['deductm'] != ''){{number_format(trim(@$insurerReply['deductm']),2)}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}

                    {{-- @if(isset($formData['ratep']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Machinary Breakdown):<span>*</span></label>
                                <input class="form_input number" name="ratem" type="text" value="@if(isset($insurerReply['ratem']) && $insurerReply['ratem'] != ''){{number_format(trim(@$insurerReply['ratem']),2)}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}

                    {{-- @if(isset($formData['brokerage']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Premium required (Machinary Breakdown):  <span>*</span></label>
                                <input class="form_input number" name="premiumm" type="text" value="@if(isset($insurerReply['premiumm']) && $insurerReply['premiumm'] != ''){{number_format(trim(@$insurerReply['premiumm']),2)}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}

                    {{-- @if(isset($formData['spec_condition']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage (Machinary Breakdown) <span>*</span></label>
                               <input class="form_input number" name="brokeragem" type="text" value="@if(isset($insurerReply['brokeragem']) && $insurerReply['brokeragem'] != ''){{number_format(trim(@$insurerReply['brokeragem']),2)}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}

                    {{-- @if(isset($formData['warranty']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Warranty (Machinary Breakdown)<span>*</span></label>
                                <input class="form_input " name="warrantym" type="text" value="@if(isset($insurerReply['warrantym']) && $insurerReply['warrantym'] != ''){{@$insurerReply['warrantym']}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}
                    {{-- @if(isset($formData['exclusion']))      --}}
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Exclusion (Machinary Breakdown) <span>*</span></label>
                               <input class="form_input" name="exclusionm" type="text" value="@if(isset($insurerReply['exclusionm']) && $insurerReply['exclusionm'] != ''){{@$insurerReply['exclusionm']}}@endif">
                            </div>
                        </div>
                    {{-- @endif --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Special Condition (Machinary Breakdown)<span>*</span></label>
                           <input class="form_input" name="specialm" type="text" value="@if(isset($insurerReply['specialm']) && $insurerReply['specialm'] != ''){{@$insurerReply['specialm']}}@endif">
                        </div>
                    </div>
                    {{-- @if(isset($formData['deductible']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Deductible for (Business Interruption): <span>*</span></label>
                            <input class="form_input number" name="deductb"  value="@if(isset($insurerReply['deductb']) && $insurerReply['deductb'] != ''){{number_format(trim(@$insurerReply['deductb']),2)}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}

                {{-- @if(isset($formData['ratep']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Rate required (Business Interruption):<span>*</span></label>
                            <input class="form_input number" name="rateb" type="text" value="@if(isset($insurerReply['rateb']) && $insurerReply['rateb'] != ''){{number_format(trim(@$insurerReply['rateb']),2)}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}

                {{-- @if(isset($formData['brokerage']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Premium required (Business Interruption):  <span>*</span></label>
                            <input class="form_input number" name="premiumb" type="text" value="@if(isset($insurerReply['premiumb']) && $insurerReply['premiumb'] != ''){{number_format(trim(@$insurerReply['premiumb']),2)}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}

                {{-- @if(isset($formData['spec_condition']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Brokerage (Business Interruption) <span>*</span></label>
                           <input class="form_input number" name="brokerageb" type="text" value="@if(isset($insurerReply['brokerageb']) && $insurerReply['brokerageb'] != ''){{number_format(trim(@$insurerReply['brokerageb']),2)}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}

                {{-- @if(isset($formData['warranty']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Warranty (Business Interruption)<span>*</span></label>
                            <input class="form_input " name="warrantyb" type="text" value="@if(isset($insurerReply['warrantyb']) && $insurerReply['warrantyb'] != ''){{@$insurerReply['warrantyb']}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}
                {{-- @if(isset($formData['exclusion']))      --}}
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Exclusion (Business Interruption) <span>*</span></label>
                           <input class="form_input" name="exclusionb" type="text" value="@if(isset($insurerReply['exclusionb']) && $insurerReply['exclusionb'] != ''){{@$insurerReply['exclusionb']}}@endif">
                        </div>
                    </div>
                {{-- @endif --}}
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Special Condition (Business Interruption)<span>*</span></label>
                       <input class="form_input" name="specialb" type="text" value="@if(isset($insurerReply['specialb']) && $insurerReply['specialb'] != ''){{@$insurerReply['specialb']}}@endif">
                    </div>
                </div>
                <button class="btn btn-primary btn_action pull-right" type="submit" id="quot_submit" @if($pipelineStatus=='Approved E Quote' || $pipelineStatus=='Issuance') style="display: none" @endif> @if(@$insurerReply['quoteStatus']=='active') Update @else Proceed @endif</button>
                    <button class="btn blue_btn btn_action pull-right" type="button" @if(@$insurerReply['quoteStatus']=='active') style="display: none" @endif onclick="saveDraft()">SAVE AS DRAFT</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>

    <!-- Custom Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/custom-select.js')}}"></script>

    <!-- Bootstrap Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script>
       

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
        jQuery.validator.addMethod("dropdown_required", function(value, element) {
            // console.log($(element).closest( ".row" ).is(":hidden"));
            if(value!='' || $(element).closest( ".row" ).is(":hidden")) {
                return true;
            } else {
                return false;
            }
            // allow any non-whitespace characters as the host part
//        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
        }, 'Please select this field.');
        function validateFunction(name)
        {
            element = document.getElementsByName(name);
            if($(element).closest( ".row" ).is(":hidden")){
                return false
            }
            else
            {
                return true;
            }
        }
        //Form valodation
        $('#e-quotation-form').validate({
            ignore:[],
            rules:{
                localclause:{
                    required:true
                },
                express:{
                    required:true
                },
                airfreight:{
                    required:true
                },
                addpremium:{
                    required:true
                },
                payAccount:{
                    required:true
                },
                lossnotification:{
                    required:true
                },
                adjustmentPremium:{
                    required:true
                },
                temporaryclause:{
                    required:true
                },
                primaryclause:{
                    required:true
                },
                premiumClaim:{
                    required:true
                },
                automaticClause:{
                    required:true
                },
                errorclause:{
                    required:true
                },
                capitalclause:{
                    required:true
                },
                debris:{
                    required:true
                },
                property:{
                    required:true
                },
                waiver:{
                    required:true
                },
                claimclause:{
                    required:true
                },
                Innocent:{
                    required:true
                },
                brokerclaim:{
                    required:true
                },
                Noninvalidation:{
                    required:true
                },
                deductm:{
                    required:true,
                    number:true
                   
                },
                ratem:{
                    required:true,
                    number:true,
                    
                },
                brokeragem:{
                    required:true,
                    number:true,
                   
                },
                specialm:{
                    required:true
                  
                },
                warrantym:{
                    required:true,
                
                },
                premiumm:{
                    required:true,
                    number:true,
                    
                },
                exclusionm:{
                    required:true
                   
                },
                deductb:{
                    required:true,
                    number:true
                   
                },
                rateb:{
                    required:true,
                    number:true,
                    
                },
                brokerageb:{
                    required:true,
                    number:true,
                   
                },
                specialb:{
                    required:true
                  
                },
                warrantyb:{
                    required:true,
                   
                    
                },
                premiumb:{
                    required:true,
                    number:true,
                    
                },
                exclusionb:{
                    required:true
                   
                }
              
        },
            messages:{
                localclause: "Please select agree or not agree.",
                express: "Please select agree or not agree.",
                airfreight: "Please select agree or not agree.",
                addpremium: "Please select agree or not agree.",
                payAccount: "Please select agree or not agree.",
                lossnotification: "Please select agree or not agree.",
                adjustmentPremium: "Please select agree or not agree.",
                temporaryclause: "Please select agree or not agree.",
                premiumClaim: "Please select agree or not agree.",
                primaryclause: "Please select agree or not agree.",
                automaticClause: "Please select agree or not agree.",
                errorclause: "Please select agree or not agree.",
                capitalclause: "Please select agree or not agree.",
                debris: "Please select agree or not agree.",
                property: "Please select agree or not agree.",
                errorclause: "Please select agree or not agree.",
                waiver: "Please select agree or not agree.",
                claimclause: "Please select agree or not agree.",
                Innocent: "Please select agree or not agree.",
                brokerclaim: "Please select agree or not agree.",
                Noninvalidation: "Please select agree or not agree.",
                deductm:"Please enter Deductible for (Machinary Breakdown).",
                premiumm:"Please enter Premium required (Machinary Breakdown).",
                ratem:"Please enter Rate required (Machinary Breakdown).",
                brokeragem:"Please enter  Brokerage (Machinary Breakdown).",
                specialm:"Please enter Special Condition (Machinary Breakdown).",
                warrantym:"Please enter Warranty (Machinary Breakdown).",
                exclusionm:"Please enter Exclusion (Machinary Breakdown).",
                deductb:"Please enter Deductible for (Business Interruption.",
                premiumb:"Please enter Premium required (Business Interruption).",
                rateb:"Please enter Rate required (Business Interruption).",
                brokerageb:"Please enter  Brokerage (Business Interruption).",
                specialb:"Please enter Special Condition (Business Interruption).",
                warrantyb:"Please enter Warranty (Business Interruption).",
                exclusionb:"Please enter Exclusion (Business Interruption)."
                
                
            },
            errorPlacement: function (error, element)
            {
                if(element.attr('name')=='scale'){
                    error.insertAfter(element.parent().parent().parent().parent());
                    scrolltop();
                }
                else if(element.attr('name')=='deductm' || element.attr('name')=='ratem' || element.attr('name')=='brokeragem' || element.attr('name')=='specialm'
                    || element.attr('name')=='warrantym' || element.attr('name')=='exclusionm' || element.attr('name')=='premiumm' || element.attr('name')=='deductb' || element.attr('name')=='rateb' || element.attr('name')=='brokerageb' || element.attr('name')=='specialb'
                    || element.attr('name')=='warrantyb' || element.attr('name')=='exclusionb' || element.attr('name')=='premiumb') {
                    error.insertAfter(element);
                    scrolltop();
                }
                else{
                    error.insertAfter(element.parent().parent());
                }
            },
//            invalidHandler: function(form, validator) {
//                validator.errorList[0].element.focus();
//            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e-quotation-form")[0]);
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('insurer/Machinery-Save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                        else if(result=='amended')
                        {
                            window.location.href = '{{url('insurer/equotes-given')}}';
                        }
                        else
                        {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                    }
                });
            }
        });
        function scrolltop()
        {
            $('html,body').animate({
                scrollTop: 150
            }, 0);
        }

        function dropdownValidation(obj)
        {
            var value = obj.value;

            if(value == '')
                $('#'+obj.id+'-error').show();
            else
                $('#'+obj.id+'-error').hide();
        }
        function saveDraft()
        {
            var form_data = new FormData($("#e-quotation-form")[0]);
            form_data.append('_token',"{{csrf_token()}}");
            $('#preLoader').fadeIn('slow');
            $.ajax({
                method: 'post',
                url: '{{url('insurer/save-exit')}}',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success:function (data) {
                    if(data)
                    {
                        location.href="{{url('insurer/e-quotes-provider')}}";
                    }
                }
            });
        }
    </script>
@endpush


