
@extends('layouts.insurer_layout')


@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">business interruption</h3>
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
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Insured <span style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$formData['firstName']}}</p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">No.of Locations<span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                            <p>{{@$formData['risk']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Business Activity</label>
                                        <div class="enter_data">
                                            <p>{{@$formData['businessType']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Estimated Annual Gross profit</label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$formData['businessInterruption']['estimatedProfit']),2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Standing Charges</label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$formData['businessInterruption']['standCharge']),2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Indemnity period</label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$formData['businessInterruption']['indemnityPeriod']),2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Policy period</label>
                                        <div class="enter_data">
                                                <p>12 months</p>
                                        </div>
                                    </div>
                            </div>
                            
                    </div>
                  
                    @if(isset($formData['costWork']) && $formData['costWork']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Additional increase in cost of working <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="costWork_1" class="radio">
                                        <input type="radio" name="costWork" value="Agree" id="costWork_1" class="hidden" @if(@$insurerReply['costWork'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="costWork_2" class="radio">
                                        <input type="radio" name="costWork" value="Not Agree" id="costWork_2" class="hidden" @if(@$insurerReply['costWork'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif
  
                    @if(isset($formData['claimClause']) && $formData['claimClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Claims preparation clause <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="claimClause_1" class="radio">
                                        <input type="radio" name="claimClause" value="Agree" id="claimClause_1" class="hidden" @if(@$insurerReply['claimClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="claimClause_2" class="radio">
                                        <input type="radio" name="claimClause" value="Not Agree" id="claimClause_2" class="hidden" @if(@$insurerReply['claimClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="claimClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['claimClause']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['custExtension']) && $formData['custExtension']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Suppliers extension/customer extension<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="custExtension_1" class="radio">
                                        <input type="radio" name="custExtension" value="Agree" id="custExtension_1" class="hidden" @if(@$insurerReply['custExtension']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="custExtension_2" class="radio">
                                        <input type="radio" name="custExtension" value="Not Agree" id="custExtension_2" class="hidden" @if(@$insurerReply['custExtension']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="custExtension_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['custExtension']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['accountants']) && $formData['accountants']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Accountants clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="accountants_1" class="radio">
                                        <input type="radio" name="accountants" value="Agree" id="accountants_1" class="hidden" @if(@$insurerReply['accountants']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accountants_2" class="radio">
                                        <input type="radio" name="accountants" value="Not Agree" id="accountants_2" class="hidden" @if(@$insurerReply['accountants']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accountants_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountants']['comment']}}</textarea>
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
                                            Payment on account<span>*</span>
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

                    @if(isset($formData['denialAccess']) && $formData['denialAccess']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Prevention/denial of access <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="denialAccess_1" class="radio">
                                        <input type="radio" name="denialAccess" value="Agree" id="denialAccess_1" class="hidden" @if(@$insurerReply['denialAccess']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="denialAccess_2" class="radio">
                                        <input type="radio" name="denialAccess" value="Not Agree" id="denialAccess_2" class="hidden" @if(@$insurerReply['denialAccess']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="denialAccess_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['denialAccess']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['premiumClause']) && $formData['premiumClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Premium adjustment clause<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="premiumClause_1" class="radio">
                                        <input type="radio" name="premiumClause" value="Agree" id="premiumClause_1" class="hidden" @if(@$insurerReply['premiumClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="premiumClause_2" class="radio">
                                        <input type="radio" name="premiumClause" value="Not Agree" id="premiumClause_2" class="hidden" @if(@$insurerReply['premiumClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="premiumClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['premiumClause']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['utilityClause']) && $formData['utilityClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Public utilities clause<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="utilityClause_1" class="radio">
                                        <input type="radio" name="utilityClause" value="Agree" id="utilityClause_1" class="hidden" @if(@$insurerReply['utilityClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="utilityClause_2" class="radio">
                                        <input type="radio" name="utilityClause" value="Not Agree" id="utilityClause_2" class="hidden" @if(@$insurerReply['utilityClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="utilityClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['utilityClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['brokerClaim']) && $formData['brokerClaim']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="brokerClaim_1" class="radio">
                                        <input type="radio" name="brokerClaim" value="Agree" id="brokerClaim_1" class="hidden" @if(@$insurerReply['brokerClaim'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="brokerClaim_2" class="radio">
                                        <input type="radio" name="brokerClaim" value="Not Agree" id="brokerClaim_2" class="hidden" @if(@$insurerReply['brokerClaim'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>   
                    @endif

                    @if(isset($formData['bookedDebts']) && $formData['bookedDebts']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Accounts recievable / Loss of booked debts<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="bookedDebts_1" class="radio">
                                        <input type="radio" name="bookedDebts" value="Agree" id="bookedDebts_1" class="hidden" @if(@$insurerReply['bookedDebts']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="bookedDebts_2" class="radio">
                                        <input type="radio" name="bookedDebts" value="Not Agree" id="bookedDebts_2" class="hidden" @if(@$insurerReply['bookedDebts']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="bookedDebts_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['bookedDebts']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['interdependanyClause']) && $formData['interdependanyClause']== true)     
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i> Interdependany Clause <span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="interdependanyClause_1" class="radio">
                                            <input type="radio" name="interdependanyClause" value="Agree" id="interdependanyClause_1" class="hidden" @if(@$insurerReply['interdependanyClause'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="interdependanyClause_2" class="radio">
                                            <input type="radio" name="interdependanyClause" value="Not Agree" id="interdependanyClause_2" class="hidden" @if(@$insurerReply['interdependanyClause'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                        </div>
                    @endif

                    @if(isset($formData['extraExpense']) && $formData['extraExpense']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Extra expense<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="extraExpense_1" class="radio">
                                        <input type="radio" name="extraExpense" value="Agree" id="extraExpense_1" class="hidden" @if(@$insurerReply['extraExpense']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="extraExpense_2" class="radio">
                                        <input type="radio" name="extraExpense" value="Not Agree" id="extraExpense_2" class="hidden" @if(@$insurerReply['extraExpense']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="extraExpense_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['extraExpense']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['water']) && $formData['water']== true)     
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i> Contaminated Water <span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="water_1" class="radio">
                                            <input type="radio" name="water" value="Agree" id="water_1" class="hidden" @if(@$insurerReply['water'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="water_2" class="radio">
                                            <input type="radio" name="water" value="Not Agree" id="water_2" class="hidden" @if(@$insurerReply['water'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    @endif

                    @if(isset($formData['auditorFee']) && $formData['auditorFee']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Auditors fees<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="auditorFee_1" class="radio">
                                        <input type="radio" name="auditorFee" value="Agree" id="auditorFee_1" class="hidden" @if(@$insurerReply['auditorFee']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="auditorFee_2" class="radio">
                                        <input type="radio" name="auditorFee" value="Not Agree" id="auditorFee_2" class="hidden" @if(@$insurerReply['auditorFee']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="auditorFee_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['auditorFee']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['expenseLaws']) && $formData['expenseLaws']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Expense to reduce the laws<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="expenseLaws_1" class="radio">
                                        <input type="radio" name="expenseLaws" value="Agree" id="expenseLaws_1" class="hidden" @if(@$insurerReply['expenseLaws']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="expenseLaws_2" class="radio">
                                        <input type="radio" name="expenseLaws" value="Not Agree" id="expenseLaws_2" class="hidden" @if(@$insurerReply['expenseLaws']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="expenseLaws_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['expenseLaws']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['lossAdjuster']) && $formData['lossAdjuster']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Nominated loss adjuster<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="lossAdjuster_1" class="radio">
                                        <input type="radio" name="lossAdjuster" value="Agree" id="lossAdjuster_1" class="hidden" @if(@$insurerReply['lossAdjuster']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="lossAdjuster_2" class="radio">
                                        <input type="radio" name="lossAdjuster" value="Not Agree" id="lossAdjuster_2" class="hidden" @if(@$insurerReply['lossAdjuster']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="lossAdjuster_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossAdjuster']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['discease']) && $formData['discease']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Outbreak of discease <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="discease_1" class="radio">
                                        <input type="radio" name="discease" value="Agree" id="discease_1" class="hidden" @if(@$insurerReply['discease']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="discease_2" class="radio">
                                        <input type="radio" name="discease" value="Not Agree" id="discease_2" class="hidden" @if(@$insurerReply['discease']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="discease_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['discease']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['powerSupply']) && $formData['powerSupply']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Failure of non public power supply<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="powerSupply_1" class="radio">
                                        <input type="radio" name="powerSupply" value="Agree" id="powerSupply_1" class="hidden" @if(@$insurerReply['powerSupply']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="powerSupply_2" class="radio">
                                        <input type="radio" name="powerSupply" value="Not Agree" id="powerSupply_2" class="hidden" @if(@$insurerReply['powerSupply']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="powerSupply_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['powerSupply']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['condition1']) && $formData['condition1']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> 
                                    Murder, Suicide or outbreak of discease on the premises
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="condition1_1" class="radio">
                                        <input type="radio" name="condition1" value="Agree" id="condition1_1" class="hidden" @if(@$insurerReply['condition1']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="condition1_2" class="radio">
                                        <input type="radio" name="condition1" value="Not Agree" id="condition1_2" class="hidden" @if(@$insurerReply['condition1']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="condition1_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['condition1']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['condition2']) && $formData['condition2']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Bombscare and unexploded devices on the premises<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="condition2_1" class="radio">
                                        <input type="radio" name="condition2" value="Agree" id="condition2_1" class="hidden" @if(@$insurerReply['condition2']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="condition2_2" class="radio">
                                        <input type="radio" name="condition2" value="Not Agree" id="condition2_2" class="hidden" @if(@$insurerReply['condition2']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="condition2_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['condition2']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['bookofDebts']) && $formData['bookofDebts']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Book of Debts<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="bookofDebts_1" class="radio">
                                        <input type="radio" name="bookofDebts" value="Agree" id="bookofDebts_1" class="hidden" @if(@$insurerReply['bookofDebts']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="bookofDebts_2" class="radio">
                                        <input type="radio" name="bookofDebts" value="Not Agree" id="bookofDebts_2" class="hidden" @if(@$insurerReply['bookofDebts']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="bookofDebts_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['bookofDebts']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($formData['risk']>1 && isset($formData['depclause']) && $formData['depclause']== true)     
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i> Department Clause <span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="depclause_1" class="radio">
                                            <input type="radio" name="depclause" value="Agree" id="depclause_1" class="hidden" @if(@$insurerReply['depclause'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="depclause_2" class="radio">
                                            <input type="radio" name="depclause" value="Not Agree" id="depclause_2" class="hidden" @if(@$insurerReply['depclause'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    @endif

                    @if(isset($formData['rent']) && $formData['rent']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>
                                    Rent & Lease hold interest<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="rent_1" class="radio">
                                        <input type="radio" name="rent" value="Agree" id="rent_1" class="hidden" @if(@$insurerReply['rent']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="rent_2" class="radio">
                                        <input type="radio" name="rent" value="Not Agree" id="rent_2" class="hidden" @if(@$insurerReply['rent']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="rent_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['rent']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['hasaccomodation']) && $formData['hasaccomodation']== "yes")     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Cover for alternate accomodation<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="hasaccomodation_1" class="radio">
                                        <input type="radio" name="hasaccomodation" value="Agree" id="hasaccomodation_1" class="hidden" @if(@$insurerReply['hasaccomodation']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="hasaccomodation_2" class="radio">
                                        <input type="radio" name="hasaccomodation" value="Not Agree" id="hasaccomodation_2" class="hidden" @if(@$insurerReply['hasaccomodation']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="hasaccomodation_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['hasaccomodation']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['costofConstruction']) && $formData['costofConstruction']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Demolition and increased cost of construction<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="costofConstruction_1" class="radio">
                                        <input type="radio" name="costofConstruction" value="Agree" id="costofConstruction_1" class="hidden" @if(@$insurerReply['costofConstruction']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="costofConstruction_2" class="radio">
                                        <input type="radio" name="costofConstruction" value="Not Agree" id="costofConstruction_2" class="hidden" @if(@$insurerReply['costofConstruction']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="costofConstruction_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['costofConstruction']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['ContingentExpense']) && $formData['ContingentExpense']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Contingent business inetruption and contingent extra expense<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="ContingentExpense_1" class="radio">
                                        <input type="radio" name="ContingentExpense" value="Agree" id="ContingentExpense_1" class="hidden" @if(@$insurerReply['ContingentExpense']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="ContingentExpense_2" class="radio">
                                        <input type="radio" name="ContingentExpense" value="Not Agree" id="ContingentExpense_2" class="hidden" @if(@$insurerReply['ContingentExpense']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="ContingentExpense_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['ContingentExpense']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['interuption']) && $formData['interuption']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Non Owned property in vicinity interuption<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="interuption_1" class="radio">
                                        <input type="radio" name="interuption" value="Agree" id="interuption_1" class="hidden" @if(@$insurerReply['interuption']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="interuption_2" class="radio">
                                        <input type="radio" name="interuption" value="Not Agree" id="interuption_2" class="hidden" @if(@$insurerReply['interuption']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="interuption_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['interuption']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['Royalties']) && $formData['Royalties']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Royalties<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                            <label for="Royalties_1" class="radio">
                                                <input type="radio" name="Royalties" value="Agree" id="Royalties_1" class="hidden" @if(@$insurerReply['Royalties'] == 'Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Agree</span>
                                            </label>
                                            <label for="Royalties_2" class="radio">
                                                <input type="radio" name="Royalties" value="Not Agree" id="Royalties_2" class="hidden" @if(@$insurerReply['Royalties'] == 'Not Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Not Agree</span>
                                            </label>
                                    </div>
                            </div>
                            
                        </div>
                    @endif

                    @if(isset($formData['deductible']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Deductible <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['deductible'] != '') {{number_format(@$formData['deductible'],2)}} @endif</p>
                                </div>
                                <input class="form_input number" name="deductible"  value="@if(isset($insurerReply['deductible']) && $insurerReply['deductible'] != ''){{number_format(trim(@$insurerReply['deductible']),2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['ratep']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Rate/premium required <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['ratep'] != ''){{number_format(@$formData['ratep'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="ratep" type="text" value="@if(isset($insurerReply['ratep']) && $insurerReply['ratep'] != ''){{number_format(trim(@$insurerReply['ratep']),2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['brokerage']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['brokerage'] != ''){{number_format(@$formData['brokerage'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="brokerage" type="text" value="@if(isset($insurerReply['brokerage']) && $insurerReply['brokerage'] != ''){{number_format(trim(@$insurerReply['brokerage']),2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['spec_condition']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Special Condition <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['spec_condition'] != ''){{number_format(@$formData['spec_condition'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="spec_condition" type="text" value="@if(isset($insurerReply['spec_condition']) && $insurerReply['spec_condition'] != ''){{number_format(trim(@$insurerReply['spec_condition']),2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['warranty']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Warranty <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['warranty'] != ''){{number_format(@$formData['warranty'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="warranty" type="text" value="@if(isset($insurerReply['warranty']) && $insurerReply['warranty'] != ''){{number_format(trim(@$insurerReply['warranty']),2)}}@endif">
                            </div>
                        </div>
                    @endif
                    @if(isset($formData['exclusion']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Exclusion <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['exclusion'] != ''){{number_format(@$formData['exclusion'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="exclusion" type="text" value="@if(isset($insurerReply['exclusion']) && $insurerReply['exclusion'] != ''){{number_format(trim(@$insurerReply['exclusion']),2)}}@endif">
                            </div>
                        </div>
                    @endif
                  
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
                costWork:{
                    required:true
                },
                claimClause:{
                    required:true
                },
                custExtension:{
                    required:true
                },
                accountants:{
                    required:true
                },
                payAccount:{
                    required:true
                },
                denialAccess:{
                    required:true
                },
                premiumClause:{
                    required:true
                },
                utilityClause:{
                    required:true
                },
                brokerClaim:{
                    required:true
                },
                bookedDebts:{
                    required:true
                },
                interdependanyClause:{
                    required:true
                },
                extraExpense:{
                    required:true
                },
                water:{
                    required:true
                },
                auditorFee:{
                    required:true
                },
                expenseLaws:{
                    required:true
                },
                lossAdjuster:{
                    required:true
                },
                discease:{
                    required:true
                },
                powerSupply:{
                    required:true
                },
                condition1:{
                    required:true
                },
                condition2:{
                    required:true
                },
                bookofDebts:{
                    required:true
                },
                depclause:{
                    required:true
                },
                rent:{
                    required:true
                },
                hasaccomodation:{
                    required:true
                },
                costofConstruction:{
                    required:true
                },
                ContingentExpense:{
                    required:true
                },
                interuption:{
                    required:true
                },
                Royalties:{
                    required:true
                },
                deductible:{
                    required:true,
                    number:true
                   
                },
                ratep:{
                    required:true,
                    number:true,
                    
                },
                brokerage:{
                    required:true,
                    number:true,
                   
                },
                spec_condition:{
                    required:true,
                    number:true,
                  
                },
                warranty:{
                    required:true,
                    number:true,
                    
                },
                exclusion:{
                    required:true,
                    number:true,
                   
                },
              
        },
            messages:{
                costWork: "Please select agree or not agree.",
                claimClause: "Please select agree or not agree.",
                custExtension: "Please select agree or not agree.",
                accountants: "Please select agree or not agree.",
                payAccount: "Please select agree or not agree.",
                denialAccess: "Please select agree or not agree.",
                premiumClause: "Please select agree or not agree.",
                utilityClause: "Please select agree or not agree.",
                brokerClaim: "Please select agree or not agree.",
                bookedDebts: "Please select agree or not agree.",
                interdependanyClause: "Please select agree or not agree.",
                extraExpense: "Please select agree or not agree.",
                water: "Please select agree or not agree.",
                auditorFee: "Please select agree or not agree.",
                expenseLaws: "Please select agree or not agree.",
                lossAdjuster: "Please select agree or not agree.",
                discease: "Please select agree or not agree.",
                powerSupply: "Please select agree or not agree.",
                condition1: "Please select agree or not agree.",
                condition2: "Please select agree or not agree.",
                bookofDebts: "Please select agree or not agree.",
                depclause: "Please select agree or not agree.",
                rent: "Please select agree or not agree.",
                hasaccomodation: "Please select agree or not agree.",
                costofConstruction: "Please select agree or not agree.",
                ContingentExpense: "Please select agree or not agree.",
                interuption: "Please select agree or not agree.",
                Royalties: "Please select agree or not agree.",
                deductible:"Please enter deductible.",
                ratep:"Please enter Rate/premium required.",
                brokerage:"Please enter  brokerage.",
                spec_condition:"Please enter special condition.",
                warranty:"Please enter warranty.",
                exclusion:"Please enter exclusion."
                
                
            },
            errorPlacement: function (error, element)
            {
                if(element.attr('name')=='scale'){
                    error.insertAfter(element.parent().parent().parent().parent());
                    scrolltop();
                }
                else if(element.attr('name')=='deductible' || element.attr('name')=='ratep' || element.attr('name')=='brokerage' || element.attr('name')=='spec_condition'
                    || element.attr('name')=='warranty' || element.attr('name')=='exclusion') {
                    error.insertAfter(element);
                    scrolltop();
                }
                else if(element.attr('name')=='select_liability' || element.attr('name')=='medical_expense' || element.attr('name')=='repatriation_expenses')
                {
                    error.insertAfter(element.parent().parent().parent().parent());
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
                    url: '{{url('insurer/business-save')}}',
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


