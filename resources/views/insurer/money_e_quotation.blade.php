
@extends('layouts.insurer_layout')


@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Money</h3>
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
    
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Cover <span  style="visibility:hidden">*</span></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="note">
                                            <label>
                                                Money includes cash, bank and currency notes, cheques, warrants, money orders, postal orders (crossed or open), bills of exchange, securities for money, credit card, debit card and the like,  sales vouchers, credit coupons and other negotiable financial instruments, current postage stamps and insurance stamps belonging to the insured or where the insured deem responsible
                                            </label>
                                            </span>
                                        </div>
    
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
                                        <label class="form_label">Estimated Annual Carryings</label>
                                        <div class="enter_data">
                                            <p>{{@$formData['annualCarrying']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Location</label>
                                        <div class="enter_data">
                                            <p>{{@$formData['location']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Transit Routes</label>
                                        <div class="enter_data">
                                            <p>{{@$formData['transitRoutes']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Territorial Limits</label>
                                        <div class="enter_data">
                                            <p>{{@$formData['territorialLimits']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Period of Insurance</label>
                                        <div class="enter_data border_none">
                                            <table class="fill_data">
                                                <tr>
                                                    <td valign="top" class="name">From : <span>{{@$formData['policyPeriod']['policyFrom'] ?:' -- '}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" class="name">To : <span>{{@$formData['policyPeriod']['policyTo'] ?:' -- '}}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money in transit any one loss</label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$formData['limit_of_money_object']['transitAnyOneLoss']),2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money while in Locked/ Safe room</label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$formData['limit_of_money_object']['lockSafeRoom']),2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money while in office premises during working hours</label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$formData['limit_of_money_object']['officePremise']),2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money at private dwellings of employees / directors</label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$formData['limit_of_money_object']['dwellingEmployees']),2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of money in premises during Business Hours</label>
                                    <div class="enter_data">
                                        <p>{{number_format(trim(@$formData['limit_of_money_object']['bussinessPremise']),2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                  
                    @if(isset($formData['coverLoss']) && $formData['coverLoss']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Cover for loss or damage due to  Riots and Strikes <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="coverLoss_1" class="radio">
                                        <input type="radio" name="coverLoss" value="Agree" id="coverLoss_1" class="hidden" @if(@$insurerReply['coverLoss'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="coverLoss_2" class="radio">
                                        <input type="radio" name="coverLoss" value="Not Agree" id="coverLoss_2" class="hidden" @if(@$insurerReply['coverLoss'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['coverDishonest']) && $formData['coverDishonest']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Cover for dishonesty  of the employees if found out within 7 days <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="coverDishonest_1" class="radio">
                                        <input type="radio" name="coverDishonest" value="Agree" id="coverDishonest_1" class="hidden" @if(@$insurerReply['coverDishonest'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="coverDishonest_2" class="radio">
                                        <input type="radio" name="coverDishonest" value="Not Agree" id="coverDishonest_2" class="hidden" @if(@$insurerReply['coverDishonest'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['coverHoldup']) && $formData['coverHoldup']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Cover for hold up<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="coverHoldup_1" class="radio">
                                        <input type="radio" name="coverHoldup" value="Agree" id="coverHoldup_1" class="hidden" @if(@$insurerReply['coverHoldup'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="coverHoldup_2" class="radio">
                                        <input type="radio" name="coverHoldup" value="Not Agree" id="coverHoldup_2" class="hidden" @if(@$insurerReply['coverHoldup'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['lossDamage']) && $formData['lossDamage']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Loss or damage to cases / bags while being used for carriage of money<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="lossDamage_1" class="radio">
                                        <input type="radio" name="lossDamage" value="Agree" id="lossDamage_1" class="hidden" @if(@$insurerReply['lossDamage']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="lossDamage_2" class="radio">
                                        <input type="radio" name="lossDamage" value="Not Agree" id="lossDamage_2" class="hidden" @if(@$insurerReply['lossDamage']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="lossDamage_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossDamage']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['claimCost']) && $formData['claimCost']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Claims Preparation cost<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="claimCost_1" class="radio">
                                        <input type="radio" name="claimCost" value="Agree" id="claimCost_1" class="hidden" @if(@$insurerReply['claimCost']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="claimCost_2" class="radio">
                                        <input type="radio" name="claimCost" value="Not Agree" id="claimCost_2" class="hidden" @if(@$insurerReply['claimCost']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="claimCost_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['claimCost']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['additionalPremium']) && $formData['additionalPremium']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Automatic reinstatement of sum insured  at pro-rata additional premium <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="additionalPremium_1" class="radio">
                                        <input type="radio" name="additionalPremium" value="Agree" id="additionalPremium_1" class="hidden" @if(@$insurerReply['additionalPremium'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="additionalPremium_2" class="radio">
                                        <input type="radio" name="additionalPremium" value="Not Agree" id="additionalPremium_2" class="hidden" @if(@$insurerReply['additionalPremium'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['storageRisk']) && $formData['storageRisk']== true &&  ($formData['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
                    || $formData['businessType']=="Cafes & Restaurant"
                    || $formData['businessType']=="Car dealer/ showroom"
                    || $formData['businessType']=="Cinema Hall auditoriums"
                    || $formData['businessType']=="Confectionery/ dairy products processing"
                    || $formData['businessType']=="Department stores/ shopping malls"
                    || $formData['businessType']=="Electronic trading/ sales"
                    || $formData['businessType']=="Entertainment venues"
                    || $formData['businessType']=="Furniture shops/ manufacturing units"
                    || $formData['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                    || $formData['businessType']=="Hotel multiple cover"
                    || $formData['businessType']=="Jewelry manufacturing/ trade"
                    || $formData['businessType']=="Mega malls & commercial centers"
                    || $formData['businessType']=="Mobile shops"
                    || $formData['businessType']=="Movie theaters"
                    || $formData['businessType']=="Museum/ heritage sites"
                    || $formData['businessType']=="Petrol diesel & gas filling stations"
                    || $formData['businessType']=="Recreational clubs/Theme & water parks"
                    || $formData['businessType']=="Refrigerated distribution"
                    || $formData['businessType']=="Restaurant/ catering services"
                    || $formData['businessType']=="Salons/ grooming services"
                    || $formData['businessType']=="Souk and similar markets"
                    || $formData['businessType']=="Supermarkets / hypermarket/ other retail shops"))     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="storageRisk_1" class="radio">
                                        <input type="radio" name="storageRisk" value="Agree" id="storageRisk_1" class="hidden" @if(@$insurerReply['storageRisk'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="storageRisk_2" class="radio">
                                        <input type="radio" name="storageRisk" value="Not Agree" id="storageRisk_2" class="hidden" @if(@$insurerReply['storageRisk'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['lossNotification']) && $formData['lossNotification']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Loss notification – ‘as soon as reasonably practicable’<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="lossNotification_1" class="radio">
                                        <input type="radio" name="lossNotification" value="Agree" id="lossNotification_1" class="hidden" @if(@$insurerReply['lossNotification']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="lossNotification_2" class="radio">
                                        <input type="radio" name="lossNotification" value="Not Agree" id="lossNotification_2" class="hidden" @if(@$insurerReply['lossNotification']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="lossNotification_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossNotification']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['cancellation']) && $formData['cancellation']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> 
                                    Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached 
                                     <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="cancellation_1" class="radio">
                                        <input type="radio" name="cancellation" value="Agree" id="cancellation_1" class="hidden" @if(@$insurerReply['cancellation'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="cancellation_2" class="radio">
                                        <input type="radio" name="cancellation" value="Not Agree" id="cancellation_2" class="hidden" @if(@$insurerReply['cancellation'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['thirdParty']) && $formData['thirdParty']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Third party money's for which responsibility is assumed will be covered<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="thirdParty_1" class="radio">
                                        <input type="radio" name="thirdParty" value="Agree" id="thirdParty_1" class="hidden" @if(@$insurerReply['thirdParty']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="thirdParty_2" class="radio">
                                        <input type="radio" name="thirdParty" value="Not Agree" id="thirdParty_2" class="hidden" @if(@$insurerReply['thirdParty']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="thirdParty_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['thirdParty']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['carryVehicle']) && $formData['carryVehicle']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Carry by own vehicle / hired vehicles and / or on foot personal money of owners<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="carryVehicle_1" class="radio">
                                        <input type="radio" name="carryVehicle" value="Agree" id="carryVehicle_1" class="hidden" @if(@$insurerReply['carryVehicle']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="carryVehicle_2" class="radio">
                                        <input type="radio" name="carryVehicle" value="Not Agree" id="carryVehicle_2" class="hidden" @if(@$insurerReply['carryVehicle']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="carryVehicle_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['carryVehicle']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['nominatedLoss']) && $formData['nominatedLoss']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="nominatedLoss_1" class="radio">
                                        <input type="radio" name="nominatedLoss" value="Agree" id="nominatedLoss_1" class="hidden" @if(@$insurerReply['nominatedLoss']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="nominatedLoss_2" class="radio">
                                        <input type="radio" name="nominatedLoss" value="Not Agree" id="nominatedLoss_2" class="hidden" @if(@$insurerReply['nominatedLoss']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="nominatedLoss_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['nominatedLoss']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['errorsClause']) && $formData['errorsClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> 
                                    Errors and Omissions clause
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="errorsClause_1" class="radio">
                                        <input type="radio" name="errorsClause" value="Agree" id="errorsClause_1" class="hidden" @if(@$insurerReply['errorsClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="errorsClause_2" class="radio">
                                        <input type="radio" name="errorsClause" value="Not Agree" id="errorsClause_2" class="hidden" @if(@$insurerReply['errorsClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['personalAssault']) && $formData['personalAssault']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Cover for personal assault<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="personalAssault_1" class="radio">
                                        <input type="radio" name="personalAssault" value="Agree" id="personalAssault_1" class="hidden" @if(@$insurerReply['personalAssault']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="personalAssault_2" class="radio">
                                        <input type="radio" name="personalAssault" value="Not Agree" id="personalAssault_2" class="hidden" @if(@$insurerReply['personalAssault']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="personalAssault_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['personalAssault']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['accountantFees']) && $formData['accountantFees']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Auditor’s fees/ accountant fees<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="accountantFees_1" class="radio">
                                        <input type="radio" name="accountantFees" value="Agree" id="accountantFees_1" class="hidden" @if(@$insurerReply['accountantFees']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accountantFees_2" class="radio">
                                        <input type="radio" name="accountantFees" value="Not Agree" id="accountantFees_2" class="hidden" @if(@$insurerReply['accountantFees']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accountantFees_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountantFees']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['sustainedFees']) && $formData['sustainedFees']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Cover for damages sustained to safe<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="sustainedFees_1" class="radio">
                                        <input type="radio" name="sustainedFees" value="Agree" id="sustainedFees_1" class="hidden" @if(@$insurerReply['sustainedFees']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="sustainedFees_2" class="radio">
                                        <input type="radio" name="sustainedFees" value="Not Agree" id="sustainedFees_2" class="hidden" @if(@$insurerReply['sustainedFees']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="sustainedFees_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['sustainedFees']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['primartClause']) && $formData['primartClause']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> Primary Insurance clause <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="primartClause_1" class="radio">
                                        <input type="radio" name="primartClause" value="Agree" id="primartClause_1" class="hidden" @if(@$insurerReply['primartClause'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="primartClause_2" class="radio">
                                        <input type="radio" name="primartClause" value="Not Agree" id="primartClause_2" class="hidden" @if(@$insurerReply['primartClause'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['accountClause']) && $formData['accountClause']== true)     
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
                                    <label for="accountClause_1" class="radio">
                                        <input type="radio" name="accountClause" value="Agree" id="accountClause_1" class="hidden" @if(@$insurerReply['accountClause']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="accountClause_2" class="radio">
                                        <input type="radio" name="accountClause" value="Not Agree" id="accountClause_2" class="hidden" @if(@$insurerReply['accountClause']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="accountClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['accountClause']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['lossParkingAReas']) && $formData['lossParkingAReas']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i> 
                                    Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas
                                    <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="lossParkingAReas_1" class="radio">
                                        <input type="radio" name="lossParkingAReas" value="Agree" id="lossParkingAReas_1" class="hidden" @if(@$insurerReply['lossParkingAReas'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="lossParkingAReas_2" class="radio">
                                        <input type="radio" name="lossParkingAReas" value="Not Agree" id="lossParkingAReas_2" class="hidden" @if(@$insurerReply['lossParkingAReas'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['worldwideCover']) && $formData['worldwideCover']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="worldwideCover_1" class="radio">
                                        <input type="radio" name="worldwideCover" value="Agree" id="worldwideCover_1" class="hidden" @if(@$insurerReply['worldwideCover']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="worldwideCover_2" class="radio">
                                        <input type="radio" name="worldwideCover" value="Not Agree" id="worldwideCover_2" class="hidden" @if(@$insurerReply['worldwideCover']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="worldwideCover_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['worldwideCover']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['locationAddition']) && $formData['locationAddition']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Automatic addition of location<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="locationAddition_1" class="radio">
                                        <input type="radio" name="locationAddition" value="Agree" id="locationAddition_1" class="hidden" @if(@$insurerReply['locationAddition']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="locationAddition_2" class="radio">
                                        <input type="radio" name="locationAddition" value="Not Agree" id="locationAddition_2" class="hidden" @if(@$insurerReply['locationAddition']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="locationAddition_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['locationAddition']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['moneyCarrying']) && $formData['moneyCarrying']== true && ($formData['agencies']=='yes'))     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country <span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="moneyCarrying_1" class="radio">
                                        <input type="radio" name="moneyCarrying" value="Agree" id="moneyCarrying_1" class="hidden" @if(@$insurerReply['moneyCarrying']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="moneyCarrying_2" class="radio">
                                        <input type="radio" name="moneyCarrying" value="Not Agree" id="moneyCarrying_2" class="hidden" @if(@$insurerReply['moneyCarrying']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="moneyCarrying_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['moneyCarrying']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['parties']) && $formData['parties']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>
                                    Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss 
                                    notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor
                                     should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications
                                      between the parties
                                     <span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="parties_1" class="radio">
                                        <input type="radio" name="parties" value="Agree" id="parties_1" class="hidden" @if(@$insurerReply['parties'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="parties_2" class="radio">
                                        <input type="radio" name="parties" value="Not Agree" id="parties_2" class="hidden" @if(@$insurerReply['parties'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['personalEffects']) && $formData['personalEffects']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Loss or damage to personal effect<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="personalEffects_1" class="radio">
                                        <input type="radio" name="personalEffects" value="Agree" id="personalEffects_1" class="hidden" @if(@$insurerReply['personalEffects']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="personalEffects_2" class="radio">
                                        <input type="radio" name="personalEffects" value="Not Agree" id="personalEffects_2" class="hidden" @if(@$insurerReply['personalEffects']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="personalEffects_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['personalEffects']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['holdUp']) && $formData['holdUp']== true)     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <label class="form_label bold">
                                            <i class="fa fa-circle"></i>
                                            Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up<span>*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="holdUp_1" class="radio">
                                        <input type="radio" name="holdUp" value="Agree" id="holdUp_1" class="hidden" @if(@$insurerReply['holdUp']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="holdUp_2" class="radio">
                                        <input type="radio" name="holdUp" value="Not Agree" id="holdUp_2" class="hidden" @if(@$insurerReply['holdUp']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <textarea name="holdUp_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['holdUp']['comment']}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif

                     <div class="row">
                        <div class="col-md-12">
                            <div class="form_group">
                                <label class="form_label bold">Claims History </label>
                                <table class="table table-bordered custom_table">
                                    <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Claim Amount</th>
                                        <th>Description</th>
                                        
                                    </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <tr>
                                            <td>Year 1</td>
                                            <td>@if(@$formData['claimsHistory'][0]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$formData['claimsHistory'][0]['claim_amount']!=''){{number_format(@$formData['claimsHistory'][0]['claim_amount'],2)}}@endif">@else -- @endif</td>
                                            <td>@if(@$formData['claimsHistory'][0]['description'])<input class="form_input" name="name" readonly  value="@if(@$formData['claimsHistory'][0]['description']!=''){{@$formData['claimsHistory'][0]['description']}}@endif">@else -- @endif</td>
                                        </tr>
                                        <tr>
                                            <td>Year 2</td>
                                            <td>@if(@$formData['claimsHistory'][1]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$formData['claimsHistory'][1]['claim_amount']!=''){{number_format(@$formData['claimsHistory'][1]['claim_amount'],2)}}@endif">@else -- @endif</td>
                                            <td>@if(@$formData['claimsHistory'][1]['description'])<input class="form_input" name="name" readonly  value="@if(@$formData['claimsHistory'][1]['description']!=''){{@$formData['claimsHistory'][1]['description']}}@endif">@else -- @endif</td>
                                        </tr>
                                        <tr>
                                            <td>Year 3</td>
                                            <td>@if(@$formData['claimsHistory'][2]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$formData['claimsHistory'][2]['claim_amount']!=''){{number_format(@$formData['claimsHistory'][2]['claim_amount'],2)}}@endif"@else -- @endif</td>
                                            <td>@if(@$formData['claimsHistory'][2]['description'])<input class="form_input" name="name" readonly  value="@if(@$formData['claimsHistory'][2]['description']!=''){{@$formData['claimsHistory'][2]['description']}}@endif">@else -- @endif</td>
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                  
                    
                    @if(isset($formData['transitdRate']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Money in Transit) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['transitdRate'] != ''){{number_format(@$formData['transitdRate'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="transitdRate" type="text" value="@if(isset($insurerReply['transitdRate']) && $insurerReply['transitdRate'] != ''){{number_format(@$insurerReply['transitdRate'],2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['safeRate']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Money in Safe) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['safeRate'] != ''){{number_format(@$formData['safeRate'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="safeRate" type="text" value="@if(isset($insurerReply['safeRate']) && $insurerReply['safeRate'] != ''){{number_format(@$insurerReply['safeRate'],2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['premiumTransit']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Premium required (Money in Transit) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['premiumTransit'] != ''){{number_format(@$formData['premiumTransit'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="premiumTransit" type="text" value="@if(isset($insurerReply['premiumTransit']) && $insurerReply['premiumTransit'] != ''){{number_format(@$insurerReply['premiumTransit'],2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['premiumSafe']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Premium required (Money in safe) (IN %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['premiumSafe'] != ''){{number_format(@$formData['premiumSafe'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="premiumSafe" type="text" value="@if(isset($insurerReply['premiumSafe']) && $insurerReply['premiumSafe'] != ''){{number_format(@$insurerReply['premiumSafe'],2)}}@endif">
                            </div>
                        </div>
                    @endif

                    @if(isset($formData['brokerage']))     
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage (IN %)<span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['brokerage'] != ''){{number_format(@$formData['brokerage'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="brokerage" type="text" value="@if(isset($insurerReply['brokerage']) && $insurerReply['brokerage'] != ''){{number_format(@$insurerReply['brokerage'],2)}}@endif">
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
                coverLoss:{
                    required:true
                },
                coverDishonest:{
                    required:true
                },
                coverHoldup:{
                    required:true
                },
                lossDamage:{
                    required:true
                },
                claimCost:{
                    required:true
                },
                additionalPremium:{
                    required:true
                },
                storageRisk:{
                    required:true
                },
                lossNotification:{
                    required:true
                },
                cancellation:{
                    required:true
                },
                thirdParty:{
                    required:true
                },
                carryVehicle:{
                    required:true
                },
                nominatedLoss:{
                    required:true
                },
                errorsClause:{
                    required:true
                },
                personalAssault:{
                    required:true
                },
                accountantFees:{
                    required:true
                },
                sustainedFees:{
                    required:true
                },
                primartClause:{
                    required:true
                },
                accountClause:{
                    required:true
                },
                lossParkingAReas:{
                    required:true
                },
                worldwideCover:{
                    required:true
                },
                locationAddition:{
                    required:true
                },
                moneyCarrying:{
                    required:true
                },
                parties:{
                    required:true
                },
                personalEffects:{
                    required:true
                },
                holdUp:{
                    required:true
                },
                transitdRate:{
                    required:true,
                    number:true,
                    max: 100
                },
                safeRate:{
                    required:true,
                    number:true,
                    max: 100
                },
                premiumTransit:{
                    required:true,
                    number:true,
                    max: 100
                },
                premiumSafe:{
                    required:true,
                    number:true,
                    max: 100
                },
                brokerage:{
                    required:true,
                    number:true,
                    max: 100
                },
                warranty:{}
              
        },
            messages:{
                coverLoss: "Please select agree or not agree.",
                coverDishonest: "Please select agree or not agree.",
                coverHoldup: "Please select agree or not agree.",
                lossDamage: "Please select agree or not agree.",
                claimCost: "Please select agree or not agree.",
                additionalPremium: "Please select agree or not agree.",
                storageRisk: "Please select agree or not agree.",
                lossNotification: "Please select agree or not agree.",
                cancellation: "Please select agree or not agree.",
                thirdParty: "Please select agree or not agree.",
                carryVehicle: "Please select agree or not agree.",
                nominatedLoss: "Please select agree or not agree.",
                errorsClause: "Please select agree or not agree.",
                personalAssault: "Please select agree or not agree.",
                accountantFees: "Please select agree or not agree.",
                sustainedFees: "Please select agree or not agree.",
                primartClause: "Please select agree or not agree.",
                accountClause: "Please select agree or not agree.",
                lossParkingAReas: "Please select agree or not agree.",
                worldwideCover: "Please select agree or not agree.",
                locationAddition: "Please select agree or not agree.",
                moneyCarrying: "Please select agree or not agree.",
                parties: "Please select agree or not agree.",
                personalEffects: "Please select agree or not agree.",
                holdUp: "Please select agree or not agree.",
                transitdRate:{
                    required:"Please enter rate required (Money in Transit)",
                    number:"Please enter rate in %",
                    max:"Please enter rate in %"
                },
                safeRate:{
                    required:"Please enter rate required (Money in Safe)",
                    number:"Please enter rate in %",
                    max:"Please enter rate in %"
                },
                premiumTransit:{
                    required:"Please enter  premium required (Money in Transit)",
                    number:"Please enter premium in %",
                    max:"Please enter premium in %"
                },
                premiumSafe:{
                    required:"Please enter premium required (Money in Safe)",
                    number:"Please enter premium in %",
                    max:"Please enter premium in %"
                },
                brokerage:{
                    required:"Please enter brokerage",
                    number:"Please enter rate in %",
                    max:"Please enter brokerage in %"
                },
                
                
            },
            errorPlacement: function (error, element)
            {
                if(element.attr('name')=='scale'){
                    error.insertAfter(element.parent().parent().parent().parent());
                    scrolltop();
                }
                else if(element.attr('name')=='transitdRate' || element.attr('name')=='safeRate' || element.attr('name')=='brokerage' || element.attr('name')=='brokerage'|| element.attr('name')=='excess' || element.attr('name')=='warranty' || element.attr('name')=='exclusion' || element.attr('name')=='special_condition'
                    || element.attr('name')=='premiumTransit' || element.attr('name')=='premiumSafe'  || element.attr('name')=='other_repatriation_expenses') {
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
                    url: '{{url('insurer/money-save')}}',
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


