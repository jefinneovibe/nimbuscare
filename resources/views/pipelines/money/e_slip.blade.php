
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <style>
        .cd-breadcrumb.triangle li.active_arrow > * {
            /* selected step */
            color: #ffffff;
            background-color: #FFA500;
            border-color: #FFA500;
        }
    </style>
    <div class="section_details">
        <form id="e-slip-form" name="e-slip-form"  method="post"> 
            {{csrf_field()}}
            <input type="hidden" value="{{@$worktype_id}}" name="eslip_id" id="eslip_id">
            <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$worktype_id}}">
            <div class="card_header clearfix">
                <h3 class="title" style="margin-bottom: 8px;">Money</h3>
            </div>
            <div class="card_content">
                <div class="edit_sec clearfix">

                    <!-- Steps -->
                    <section>
                        <nav>
                            <ol class="cd-breadcrumb triangle">
                                @if($pipeline_details['status']['status'] == 'E-slip')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><em>E-Slip</em></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-quotation')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="current"><a href="{{url('money/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('money/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class="current"><a href="{{url('money/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('money/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('money/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('money/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('money/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('money/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = complete><a href="{{url('money/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li class = "current"><a href="{{url('money/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('money/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('money/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('money/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                    {{--<li class="complete"><a href="{{ url('e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>--}}
                                    {{--<li class="complete"><a href="{{url('e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                                    {{--<li class="complete"><a href="{{url('e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                    {{--<li class = complete><a href="{{url('e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                    {{--<li class = complete><a href="{{url('quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                    {{--<li class = "complete"><a href="{{url('approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                    {{--<li class = "current"><a href="{{url('issuance/'.$worktype_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                                @else
                                    <li class="complete"><a href="{{ url('money/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><a href="{{url('money/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @endif
                            </ol>
                        </nav>
                    </section>
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Insured <span style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['firstName']}}</p>
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
                                            <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Estimated Annual Carryings</label>
                                        <div class="enter_data">
                                            <p>{{number_format(@$pipeline_details['formData']['annualCarrying'],2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Location</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['location']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Transit Routes</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['transitRoutes']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Territorial Limits</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['territorialLimits']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Period of Insurance</label>
                                        <div class="enter_data border_none">
                                            <table class="fill_data">
                                                <tr>
                                                    <td valign="top" class="name">From : <span>{{@$pipeline_details['formData']['policyPeriod']['policyFrom'] ?:' -- '}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" class="name">To : <span>{{@$pipeline_details['formData']['policyPeriod']['policyTo'] ?:' -- '}}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money in transit any one loss</label>
                                    <div class="enter_data">
                                        <p>{{number_format(@$pipeline_details['formData']['limit_of_money_object']['transitAnyOneLoss'],2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money while in Locked/ Safe room</label>
                                    <div class="enter_data">
                                        <p>{{number_format(@$pipeline_details['formData']['limit_of_money_object']['lockSafeRoom'],2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money while in office premises during working hours</label>
                                    <div class="enter_data">
                                        <p>{{number_format(@$pipeline_details['formData']['limit_of_money_object']['officePremise'],2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of Money at private dwellings of employees / directors</label>
                                    <div class="enter_data">
                                        <p>{{number_format(@$pipeline_details['formData']['limit_of_money_object']['dwellingEmployees'],2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Limit of money in premises during Business Hours</label>
                                    <div class="enter_data">
                                        <p>{{number_format(@$pipeline_details['formData']['limit_of_money_object']['bussinessPremise'],2)}} AED</p>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['coverLoss']) @if(@$pipeline_details['formData']['coverLoss'] != false) checked @endif @else checked @endif  name="coverLoss" value="true" id="coverLoss" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for loss or damage due to  Riots and Strikes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['coverDishonest']) @if(@$pipeline_details['formData']['coverDishonest'] != false) checked @endif @else checked @endif  name="coverDishonest" value="true" id="coverDishonest" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="coverDishonest" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for dishonesty  of the employees if found out within 7 days</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['coverHoldup']) @if(@$pipeline_details['formData']['coverHoldup'] != false) checked @endif @else checked @endif  name="coverHoldup" value="true" id="coverHoldup" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="coverHoldup" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for hold up</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['lossDamage'] ) @if(@$pipeline_details['formData']['lossDamage'] != false) checked @endif @else checked @endif  name="lossDamage" value="true" id="lossDamage" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="lossDamage" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss or damage to cases / bags while being used for carriage of money</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['claimCost']) @if(@$pipeline_details['formData']['claimCost'] != false) checked @endif @else checked @endif  name="claimCost" value="true" id="claimCost" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="claimCost" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Claims Preparation cost</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['additionalPremium']) @if(@$pipeline_details['formData']['additionalPremium'] != false) checked @endif @else checked @endif  name="additionalPremium" value="true" id="additionalPremium" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="additionalPremium" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic reinstatement of sum insured  at pro-rata additional premium</label>
                                </div>
                            </div>
                        </div>
                        @if($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
                            || $pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                            || $pipeline_details['formData']['businessType']=="Car dealer/ showroom"
                            || $pipeline_details['formData']['businessType']=="Cinema Hall auditoriums"
                            || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                            || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                            || $pipeline_details['formData']['businessType']=="Electronic trading/ sales"
                            || $pipeline_details['formData']['businessType']=="Entertainment venues"
                            || $pipeline_details['formData']['businessType']=="Furniture shops/ manufacturing units"
                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                            || $pipeline_details['formData']['businessType']=="Jewelry manufacturing/ trade"
                            || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                            || $pipeline_details['formData']['businessType']=="Mobile shops"
                            || $pipeline_details['formData']['businessType']=="Movie theaters"
                            || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                            || $pipeline_details['formData']['businessType']=="Petrol diesel & gas filling stations"
                            || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                            || $pipeline_details['formData']['businessType']=="Refrigerated distribution"
                            || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                            || $pipeline_details['formData']['businessType']=="Salons/ grooming services"
                            || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                            || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"
                            )
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="storageRisk" value="true" id="storageRisk" checked class="inp-cbx" style="display: none" onclick="return false">
                                        <label for="storageRisk" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['lossNotification']) @if(@$pipeline_details['formData']['lossNotification'] != false) checked @endif @else checked @endif  name="lossNotification" value="true" id="lossNotification" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="lossNotification" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss notification – ‘as soon as reasonably practicable'</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['cancellation']) @if(@$pipeline_details['formData']['cancellation'] != false) checked @endif @else checked @endif  name="cancellation" value="true" id="cancellation" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="cancellation" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['thirdParty']) @if(@$pipeline_details['formData']['thirdParty'] != false) checked @endif @else checked @endif  name="thirdParty" value="true" id="thirdParty" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="thirdParty" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Third party money's for which responsibility is assumed will be covered </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['carryVehicle']) @if(@$pipeline_details['formData']['carryVehicle'] != false) checked @endif @else checked @endif  name="carryVehicle" value="true" id="carryVehicle" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="carryVehicle" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Carry by own vehicle / hired vehicles and / or on foot personal money of owners </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['nominatedLoss']) @if(@$pipeline_details['formData']['nominatedLoss'] != false) checked @endif @else checked @endif  name="nominatedLoss" value="true" id="nominatedLoss" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="nominatedLoss" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['errorsClause']) @if(@$pipeline_details['formData']['errorsClause'] != false) checked @endif @else checked @endif  name="errorsClause" value="true" id="errorsClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="errorsClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Errors and Omissions clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['personalAssault']) @if(@$pipeline_details['formData']['personalAssault'] != false) checked @endif @else checked @endif  name="personalAssault" value="true" id="personalAssault" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="personalAssault" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for personal assault</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['accountantFees']) @if(@$pipeline_details['formData']['accountantFees'] != false) checked @endif @else checked @endif  name="accountantFees" value="true" id="accountantFees" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="accountantFees" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Auditor’s fees/ accountant fees</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['sustainedFees']) @if(@$pipeline_details['formData']['sustainedFees'] != false) checked @endif @else checked @endif  name="sustainedFees" value="true" id="sustainedFees" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="sustainedFees" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for damages sustained to safe</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['primartClause']) @if(@$pipeline_details['formData']['primartClause'] != false) checked @endif @else checked @endif  name="primartClause" value="true" id="primartClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="primartClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Primary Insurance clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['accountClause']) @if(@$pipeline_details['formData']['accountClause'] != false) checked @endif @else checked @endif  name="accountClause" value="true" id="accountClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="accountClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Payment on account clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['lossParkingAReas']) @if(@$pipeline_details['formData']['lossParkingAReas'] != false) checked @endif @else checked @endif  name="lossParkingAReas" value="true" id="lossParkingAReas" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="lossParkingAReas" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['worldwideCover']) @if(@$pipeline_details['formData']['worldwideCover'] != false) checked @endif @else checked @endif  name="worldwideCover" value="true" id="worldwideCover" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="worldwideCover" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['locationAddition']) @if(@$pipeline_details['formData']['locationAddition'] != false) checked @endif @else checked @endif  name="locationAddition" value="true" id="locationAddition" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="locationAddition" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Automatic addition of location</label>
                                </div>
                            </div>
                        </div>
                        @if($pipeline_details['formData']['agencies']=='yes')
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="moneyCarrying" value="true" id="moneyCarrying"  checked class="inp-cbx" style="display: none" onclick="return false">
                                        <label for="moneyCarrying" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['parties']) @if(@$pipeline_details['formData']['parties'] != false) checked @endif @else checked @endif  name="parties" value="true" id="parties" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="parties" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed 
                                        Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties </label>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['personalEffects']) @if(@$pipeline_details['formData']['personalEffects'] != false) checked @endif @else checked @endif  name="personalEffects" value="true" id="personalEffects" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="personalEffects" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Loss or damage to personal effect </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['holdUp']) @if(@$pipeline_details['formData']['holdUp'] != false) checked @endif @else checked @endif  name="holdUp" value="true" id="holdUp" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="holdUp" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up </label>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'],2)}}  @endif"> @else -- @endif</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][0]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][0]['description']}} @endif @else -- @endif</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Year 2</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'],2)}}@endif"> @else -- @endif</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][1]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][1]['description']}} @endif @else -- @endif</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Year 3</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'],2)}}@endif">@else --@endif</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][2]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][2]['description']}} @endif @else -- @endif</textarea></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Money in Transit) (in %)<span>*</span></label>
                                <input class="form_input number" name="transitdRate"  value="@if(isset($pipeline_details['formData']['transitdRate']) && $pipeline_details['formData']['transitdRate'] != ''){{@$pipeline_details['formData']['transitdRate']}}@endif">
                                <label class="error" id="TransitRate-error" style="display: none">Please enter rate in %</label>
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (Money in Safe) (in %)<span>*</span></label>
                                <input class="form_input number" name="safeRate"  value="@if(isset($pipeline_details['formData']['safeRate']) && $pipeline_details['formData']['safeRate'] != ''){{@$pipeline_details['formData']['safeRate']}}@endif">
                                <label class="error" id="SafeRate-error" style="display: none">Please enter rate in %</label>
    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Premium required(Money in Transit) (in %)<span>*</span></label>
                                <input class="form_input number" name="premiumTransit" type="text"  value="@if(isset($pipeline_details['formData']['premiumTransit']) && $pipeline_details['formData']['premiumTransit'] != ''){{@$pipeline_details['formData']['premiumTransit']}}@endif" >
                                <label class="error" id="PremiumTransit-error" style="display: none">Please enter rate in %</label>
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Premium required(Money in Safe) (in %)<span>*</span></label>
                                <input class="form_input number" name="premiumSafe" type="text" value="@if(isset($pipeline_details['formData']['premiumSafe']) && $pipeline_details['formData']['premiumSafe'] != ''){{@$pipeline_details['formData']['premiumSafe']}}@endif" >
                                <label class="error" id="premiumSafe-error" style="display: none">Please enter rate in %</label>
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage (IN %)<span>*</span></label>
                                <input class="form_input number" name="brokerage" type="text"  value="@if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage'] != ''){{number_format(@$pipeline_details['formData']['brokerage'],2)}}@endif">
                                <label class="error" id="brokerage-error" style="display: none">Please enter rate in %</label>
    
                            </div>
                        </div>
                    </div>


                  
                </div>
                    <div class="clearfix">
                    <button type="submit"  id="eslip_submit" name="eslip_submit"  class="btn btn-primary btn_action pull-right" @if($pipeline_details['status']['status']=='Approved E Quote' || $pipeline_details['status']['status']=='Issuance') style="display: none" @endif>Proceed</button>
                    @if($pipeline_details['status']['status']=='E-slip')
                        <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveEslip()">Save as Draft</button>
                    @endif
                    </div>
            </div>
        </form>
    </div>
               
            <!-- Popup -->
                <div id="insurance_popup">
                    <form name="insurance_companies_form" method="post" id="insurance_companies_form">

                    <input type="hidden" name="pipeline_id" value="{{@$worktype_id}}">
                        <input type="hidden" name="send_type" id="send_type">
                        <div class="cd-popup">
                            <div class="cd-popup-container">
                                <div class="modal_content">
                                    <h1>Insurance Companies List</h1>

                                    <div class="clearfix"> </div> <span class="error" id="no_new_company" style="display: none">No New Insurance Company Selected</span>
                                    <div class="content_spacing">
                                        <div class="row">
                                            <div class="col-md-12" id="insurer_list">
                                                <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="modal_footer">
                                    <button class="btn btn-primary btn-link btn_cancel" type="button" onclick="">Cancel</button>
                                    @if(count(@$pipeline_details['insuraceCompanyList'])!=0)
                                    <button class="btn btn-primary btn_action" value="send_all" id="send_all_button" type="button">Send To All Selected</button>
                                    <button class="btn btn-primary btn_action" value="send_new" id="send_new_button" type="button">Send To Newly Selected</button>
                                    @else  
                                    <button class="btn btn-primary btn_action" id="insurance_button" type="button">Send</button>
                                        @endif

                                </div>
                            </div>
                        </div>
                    </form>
                </div><!--//END Popup -->
             @include('includes.mail_popup')
            @include('includes.chat') 
            @endsection

            @push('scripts')
      <!--jquery validate-->
 <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
 <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
 {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> --}}
<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Date Picker -->
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>


{{-- <!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script> --}}


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
function upload_file(obj)
{
   var id=obj.id;
    var fullPath =  obj.value;
    if(id=='')
            {
                $('#'+'id'+'-error').show();
            }
            else{
                $('#'+'id'+'-error').hide();
            }
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            // $('.remove_file_upload').show();
            if(id=='civil_certificate')
            {
                        $('#civil_p').text(filename);
            }
            else if(id=='policyCopy')
            {
                        $('#policy_p').text(filename);
            }
            else if(id=='trade_list')
            {
                        $('#trade_list_p').text(filename);
            }
            else if(id=='vat_copy')
            {
                        $('#vat_copy_p').text(filename);
            }
            else if(id=='others1')
            {
                        $('#others1_p').text(filename);
            }
            else if(id=='others2')
            {
                        $('#others2_p').text(filename);
            }
            }
                         function validation(id) {
                            if($('#'+id).val()=='')
                            {
                                $('#'+id+'-error').show();
                            }else{
                                $('#'+id+'-error').hide();
                            }
                        }
                        $('#claim_experience_details').change(function(){

                            var claim_value =$('#claim_experience_details').val();
                            console.log(claim_value);
                            if(claim_value=='combined_data')
                            {
                                $('#table1').show();
                                $('#table2').hide();
                                $('#table3').hide();
                            }else if(claim_value=='only_property')
                            {
                                claim_data='Only Property';
                                $('#table2').show();
                                $('#table1').hide();
                                $('#table3').hide();

                            }else if(claim_value=='separate_property')
                            {
                                $('#table3').show();
                                $('#table1').hide();
                                $('#table2').hide();
                            }
                            else if(claim_value=='')
                            {
                                $('#table3').hide();
                                $('#table1').hide();
                                $('#table2').hide();
                            }
                        });
                      
                        // Business Interruption cover Required

                        $('#cover_accomodation').change(function () {
                            var cover_accomodation = $('#cover_accomodation').val();

                            if(cover_accomodation=='yes')
                            {
                                $('#accomodation_yes').show();
                            }
                            else{
                                $('#accomodation_yes').hide();
                            }
                        });
                      

                        $( "#send_all_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('send_all');
                                    $('#insurance_companies_form').submit();
                                }
                        });
                        $( "#send_new_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('send_new');
                                    $('#insurance_companies_form').submit();
                                }
                        });
                        $( "#insurance_button" ).click(function() {
                            var valid=  $("#insurance_companies_form").valid();
                            if(valid==true) {

                                    $('#send_type').val('0');
                                    $('#insurance_companies_form').submit();
                                }
                        });



                   

            
            $('#e-slip-form').validate({
                             ignore: [],
                                     rules: {
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
                                        

                             },
                             messages: {
                                transitdRate: {
                                    required:"Please enter rate required(money in transit).",
                                    number:"Please enter rate in %",
                                    max:"Please enter rate in %"

                                },
                                safeRate:{
                                    required:"Please enter rate required(money in safe).",
                                    number:"Please enter rate in %",
                                    max:"Please enter rate in %"
                                   
                                },
                                premiumTransit: {
                                    required:"Please enter premium required(money in transit).",
                                    number:"Please enter premium in %",
                                    max:"Please enter premium in %"
                                },
                                premiumSafe: {
                                    required:"Please enter premium required(money in safe).",
                                    number:"Please enter premium in %",
                                    max:"Please enter premium in %"
                                },
                                brokerage: {
                                    required:"Please enter brokerage.",
                                    number:"Please enter number",
                                    max:"Please enter brokerage in %"
                                },
                                 
                               },
                             errorPlacement: function (error, element) {
                                
                                  if(element.attr("name") == "cover_accomodation" ||
                                  element.attr("name") == "civil_certificate" ||
                                  element.attr("name") == "policyCopy" ||
                                  element.attr("name") == "trade_list" ||
                                  element.attr("name") == "vat_copy" ||
                                  element.attr("name") == "others1" ||
                                  element.attr("name") == "others2"
                                   )
                                 {
                                     error.insertAfter(element.parent());
                                     // scrolltop();
                                 }
                                 else {
                                     error.insertAfter(element);
                                     // scrolltop();
                                 }
                             },
                            submitHandler: function (form,event) {

                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $('#preLoader').show();
//$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('money/eslip-save')}}',
                                    data: form_data,
                                     cache : false,
                                     contentType: false,
                                     processData: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            getInsurerList();
                                        }
                                    }
                                });
                            }
                        });
                        //     function scrolltop()
                        //     {
                        //         $('html,body').animate({
                        //             scrollTop: 150
                        //         }, 0);
                        //     }

                        //form validation
                            $('#insurance_companies_form').validate({
                            ignore: [],
                                rules: {
                                
                            },
                            messages: {
                                 
                            },
                            errorPlacement: function (error, element) {

                                    error.insertAfter(element.parent().parent());
                            },
                            submitHandler: function (form,event) {
                                var form_data = new FormData($("#insurance_companies_form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $("#insurance_button").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('email-file-eslip')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success != 'failed') {
                                            $("#insurance_popup .cd-popup").removeClass('is-visible');
                                            $('#questionnaire_popup .cd-popup').addClass('is-visible');
                                            $("#send_btn").attr( "disabled", false );
                                            $('#attach_div').html(result.documentSection);
                                        }
                                        else {
                                            $("#insurance_button").attr( "disabled",false );
                                            $('#insurance_popup').show();
                                            $('#no_new_company').show();
                                            $('#attach_div').html('Files loading failed');
                                        }
                                    }
                                });
                            }
                            });

                            function getInsurerList()
                            {
                                $("#insurance_button").attr( "disabled", false );
                                $("#insurance_popup .cd-popup").toggleClass('is-visible');
                                $('#preLoader').fadeOut('slow');
                                var eslip_id = $('#eslip_id').val();
                                $.ajax({
                                    method: 'get',
                                    data:{'eslip_id' : eslip_id},
                                    url: '{{url('get-insurer')}}',
                                    success:function (data) {
                                        $('#insurer_list').html('');
                                        $('#insurer_list').append(data);
                                    }

                                });
                            }
                            function popupHide()
                            {
                                $('#insurer_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
                                $("#insurance_popup .cd-popup").toggleClass('is-visible');
                                $("#eslip_submit").attr( "disabled", false );
                            }
                            function sendQuestion() {
                                $("#questionnaire_popup .cd-popup").removeClass('is-visible');
                                $('#quest_send_form :input').not(':submit').clone().hide().appendTo('#insurance_companies_form');
                                var form_data = new FormData($("#insurance_companies_form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                $('#preLoader').show();
                                $("#insurance_button").attr( "disabled", "disabled" );
                                $("#send_btn").attr( "disabled", true );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('money/insurance-company-save')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            $("#send_btn").attr( "disabled", false );
                                            window.location.href = '{{url('money/e-quotation')}}'+'/'+result.id;
                                            // $("#insurance_popup .cd-popup").removeClass('is-visible');
                                            $('#insurance_popup').show();
                                            $('#insurer_list').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>');
                                        }
                                        else{
                                            $("#send_btn").attr( "disabled", false );
                                            $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                                            $('#preLoader').hide();
                                            $('#insurance_popup').show();
                                            $('#no_new_company').show();
                                        }
                                    }
                                });
                            }
                            function saveEslip()
                            {
                                var form_data = new FormData($("#e-slip-form")[0]);
                                form_data.append('_token', '{{csrf_token()}}');
                                form_data.append('is_save','true');
                                $('#preLoader').show();
                                //$("#eslip_submit").attr( "disabled", "disabled" );
                                $.ajax({
                                    method: 'post',
                                    url: '{{url('money/eslip-save')}}',
                                    data: form_data,
                                    cache : false,
                                    contentType: false,
                                    processData: false,
                                    success: function (result) {
                                        $('#preLoader').hide();
                                        if (result.success== 'success') {
                                            $('#success_message').html('E-Slip is saved as draft.');
                                            $('#success_popup .cd-popup').addClass('is-visible');
                                        }
                                        else
                                        {
                                            $('#success_message').html('E-Slip saving failed.');
                                            $('#success_popup .cd-popup').addClass('is-visible');
                                        }
                                    }
                                });
                            }

                            function validate(x,type) {
                                // debugger;
        var parts = x.split(".");
        if (typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
        {
            // debugger;
            if(type=='transit_rate')
            {
                $("#TransitRate-error").show();
            }else if(type=='safe_rate')
            {
                $("#SafeRate-error").show();
            }else if(type=='premium_transit')
            {
                $("#PremiumTransit-error").show();
            }else if(type=='premium_safe')
            {
                $("#premiumSafe-error").show();
            }else if(type=='brokerage')
            {
                $("#brokerage-error").show();
            }
        }
        
        var n = parseFloat(x);
         if (isNaN(n))
        {
            if(type=='transit_rate')
            {
                $("#TransitRate-error").show();
            }else if(type=='safe_rate')
            {
                $("#SafeRate-error").show();
            }else if(type=='premium_transit')
            {
                $("#PremiumTransit-error").show();
            }else if(type=='premium_safe')
            {
                $("#premiumSafe-error").show();
            }else if(type=='brokerage')
            {
                $("#brokerage-error").show();
            }
        }
        else if (n < 0 || n > 100)
        {
            if(type=='transit_rate')
            {
                $("#TransitRate-error").show();
            }else if(type=='safe_rate')
            {
                $("#SafeRate-error").show();
            }else if(type=='premium_transit')
            {
                $("#PremiumTransit-error").show();
            }else if(type=='premium_safe')
            {
                $("#premiumSafe-error").show();
            }else if(type=='brokerage')
            {
                $("#brokerage-error").show();
            }
        }
        else{
             if(type=='transit_rate')
             {
                $("#TransitRate-error").hide();
             }else if(type=='safe_rate')
             {
                 $("#SafeRate-error").hide();
             }else if(type=='premium_transit')
             {
                 $("#PremiumTransit-error").hide();
             }else if(type=='premium_safe')
             {
                 $("#premiumSafe-error").hide();
             }else if(type=='brokerage')
            {
                $("#brokerage-error").hide();
            }
         }
    }
                    </script>
    @endpush


