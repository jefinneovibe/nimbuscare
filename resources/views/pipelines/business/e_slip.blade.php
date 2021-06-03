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
                <h3 class="title" style="margin-bottom: 8px;">business interruption</h3>
            </div>
            <div class="card_content">
                <div class="edit_sec clearfix">

                    <!-- Steps -->
                    <section>
                        <nav>
                            <ol class="cd-breadcrumb triangle">
                                @if($pipeline_details['status']['status'] == 'E-slip')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><em>E-Slip</em></li>
                                    <li><em>E-Quotation</em></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-quotation')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="current"><a href="{{url('business_interruption/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li><em>E-Comparison</em></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class="current"><a href="{{url('business_interruption/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li><em>Quote Amendment</em></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('business_interruption/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('business_interruption/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li><em>Approved E Quote</em></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('business_interruption/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = complete><a href="{{url('business_interruption/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                    <li class = "current"><a href="{{url('business_interruption/approved-quot/'.$worktype_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                    {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="active_arrow"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                                    <li class="complete"><a href="{{url('business_interruption/e-quotation/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                    <li class = complete><a href="{{url('business_interruption/e-comparison/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                    <li class = current><a href="{{url('business_interruption/quot-amendment/'.$worktype_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
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
                                    <li class="complete"><a href="{{ url('business_interruption/e-questionnaire/'.$worktype_id) }}"><em>E-Questionnaire</em></a></li>
                                    <li class="current"><a href="{{url('business_interruption/e-slip/'.$worktype_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
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
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">Insured</label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['firstName']}}</p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">No.of Locations </label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['risk']}}</p>
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
                                        <label class="form_label">Estimated Annual Gross Profit</label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['businessInterruption']['estimatedProfit']),2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Standing Charges</label>
                                        <div class="enter_data">
                                            <p>{{number_format(trim(@$pipeline_details['formData']['businessInterruption']['standCharge']),2)}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Indemnity period</label>
                                        <div class="enter_data">
                                            <p>{{@$pipeline_details['formData']['businessInterruption']['indemnityPeriod']}}</p>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                        <label class="form_label">Policy period</label>
                                        <div class="enter_data">
                                            <p>12 months </p>
                                        </div>
                                    </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['costWork']) @if(@$pipeline_details['formData']['costWork'] != false) checked @endif @else checked @endif  name="costWork" value="true" id="costWork" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Additional increase in cost of working</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['claimClause']) @if(@$pipeline_details['formData']['claimClause'] != false) checked @endif @else checked @endif  name="claimClause" value="true" id="claimClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Claims preparation clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['custExtension']) @if(@$pipeline_details['formData']['custExtension'] != false) checked @endif @else checked @endif  name="custExtension" value="true" id="custExtension" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Suppliers extension/customer extension</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['accountants'] ) @if(@$pipeline_details['formData']['accountants'] != false) checked @endif @else checked @endif  name="accountants" value="true" id="accountants" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Accountants clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['payAccount']) @if(@$pipeline_details['formData']['payAccount'] != false) checked @endif @else checked @endif  name="payAccount" value="true" id="payAccount" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Payment on account</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['denialAccess']) @if(@$pipeline_details['formData']['denialAccess'] != false) checked @endif @else checked @endif  name="denialAccess" value="true" id="denialAccess" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Prevention/denial of access</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['premiumClause']) @if(@$pipeline_details['formData']['premiumClause'] != false) checked @endif @else checked @endif  name="premiumClause" value="true" id="premiumClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Premium adjustment clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['utilityClause']) @if(@$pipeline_details['formData']['utilityClause'] != false) checked @endif @else checked @endif  name="utilityClause" value="true" id="utilityClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Public utilities clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['brokerClaim']) @if(@$pipeline_details['formData']['brokerClaim'] != false) checked @endif @else checked @endif  name="brokerClaim" value="true" id="brokerClaim" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['bookedDebts']) @if(@$pipeline_details['formData']['bookedDebts'] != false) checked @endif @else checked @endif  name="bookedDebts" value="true" id="bookedDebts" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Accounts recievable / Loss of booked debts </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['interdependanyClause']) @if(@$pipeline_details['formData']['interdependanyClause'] != false) checked @endif @else checked @endif  name="interdependanyClause" value="true" id="interdependanyClause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Interdependany clause</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['extraExpense']) @if(@$pipeline_details['formData']['extraExpense'] != false) checked @endif @else checked @endif  name="extraExpense" value="true" id="extraExpense" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Extra expense </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['water']) @if(@$pipeline_details['formData']['water'] != false) checked @endif @else checked @endif  name="water" value="true" id="water" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Contaminated water</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['auditorFee']) @if(@$pipeline_details['formData']['auditorFee'] != false) checked @endif @else checked @endif  name="auditorFee" value="true" id="auditorFee" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Auditors fees</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['expenseLaws']) @if(@$pipeline_details['formData']['expenseLaws'] != false) checked @endif @else checked @endif  name="expenseLaws" value="true" id="expenseLaws" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">expense to reduce the laws</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['lossAdjuster']) @if(@$pipeline_details['formData']['lossAdjuster'] != false) checked @endif @else checked @endif  name="lossAdjuster" value="true" id="lossAdjuster" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Nominated loss adjuster</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['discease']) @if(@$pipeline_details['formData']['discease'] != false) checked @endif @else checked @endif  name="discease" value="true" id="discease" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Outbreak of discease</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['powerSupply']) @if(@$pipeline_details['formData']['powerSupply'] != false) checked @endif @else checked @endif  name="powerSupply" value="true" id="powerSupply" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Failure of non public power supply</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['condition1']) @if(@$pipeline_details['formData']['condition1'] != false) checked @endif @else checked @endif  name="condition1" value="true" id="condition1" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['condition2']) @if(@$pipeline_details['formData']['condition2'] != false) checked @endif @else checked @endif  name="condition2" value="true" id="condition2" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Bombscare and unexploded devices on the premises</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['bookofDebts']) @if(@$pipeline_details['formData']['bookofDebts'] != false) checked @endif @else checked @endif  name="bookofDebts" value="true" id="bookofDebts" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Book of Debts</label>
                                </div>
                            </div>
                        </div>
                        @if(@$pipeline_details['formData']['risk']>1)
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['depclause']) @if(@$pipeline_details['formData']['depclause'] != false) checked @endif @else checked @endif  name="depclause" value="true" id="depclause" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Departmental clause</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(@$pipeline_details['formData']['risk']>0)
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['rent']) @if(@$pipeline_details['formData']['rent'] != false) checked @endif @else checked @endif  name="rent" value="true" id="rent" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Rent & Lease hold interest</label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                           
                                <div class="form_group">
                                    <label class="form_label bold">Cover for alternate accomodation <span>*</span></label>
                                    <div class="custom_select">
                                        <select class="form_input" id="option_select1" name="hasaccomodation" onchange="validation(this.id);">
                                            <option value="">Select</option>
                                            @if(!empty(@$pipeline_details))
                                                <option value="yes" @if(@$pipeline_details['formData']['hasaccomodation'] == "yes") selected @endif>Yes</option>
                                                <option value="no" @if(@$pipeline_details['formData']['hasaccomodation'] == "no") selected @endif>No</option>
                                            @else
                                                
                                                <option value="yes" >Yes</option>
                                                <option value="no" >No</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['costofConstruction']) @if(@$pipeline_details['formData']['costofConstruction'] != false) checked @endif @else checked @endif  name="costofConstruction" value="true" id="costofConstruction" class="inp-cbx" style="display: none"onclick="return false">
                                        <label for="automaticClause" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Demolition and increased cost of construction</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  @if(@$pipeline_details['formData']['ContingentExpense'] != false) checked @endif   name="ContingentExpense" value="true" id="ContingentExpense" class="inp-cbx" style="display: none">
                                        <label for="ContingentExpense" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Contingent business inetruption and contingent extra expense</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  @if(@$pipeline_details['formData']['interuption'] != false) checked @endif   name="interuption" value="true" id="interuption" class="inp-cbx" style="display: none">
                                        <label for="interuption" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Non Owned property in vicinity interuption</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox" @if(@$pipeline_details['formData']['Royalties'] != false) checked @endif   name="Royalties" value="true" id="Royalties" class="inp-cbx" style="display: none">
                                        <label for="Royalties" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Royalties</label>
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
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'],2)}}@endif">@else -- @endif</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][0]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][0]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][0]['description']}} @endif @else -- @endif</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Year 2</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'],2)}}@endif">@else -- @endif</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][1]['description'])<textarea class="form_input" name="name" readonly> @if(@$pipeline_details['formData']['claimsHistory'][1]['description']!=''){{@$pipeline_details['formData']['claimsHistory'][1]['description']}} @endif @else -- @endif</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Year 3</td>
                                        <td>@if(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'])<input class="form_input" name="name" readonly value="@if(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount']!=''){{number_format(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'],2)}}@endif">@else -- @endif</td>
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
                                <label class="form_label bold">Deductible:<span>*</span></label>
                                <input class="form_input number" id="deductible" name="deductible" type="text" value="@if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible'] != ''){{number_format(@$pipeline_details['formData']['deductible'],2)}}@endif" >
                               
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Rate/premium required: <span>*</span></label>
                                <input class="form_input number" id="ratep" name="ratep" type="text" value="@if(isset($pipeline_details['formData']['ratep']) && $pipeline_details['formData']['ratep'] != ''){{number_format(@$pipeline_details['formData']['ratep'],2)}}@endif" >
                                
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Brokerage:<span>*</span></label>
                                <input class="form_input number" id="brokerage" name="brokerage" type="text" value="@if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage'] != ''){{number_format(@$pipeline_details['formData']['brokerage'],2)}}@endif" >
                                
    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Special Condition:<span>*</span></label>
                                <input class="form_input number" id="spec_condition" name="spec_condition" type="text" value="@if(isset($pipeline_details['formData']['spec_condition']) && $pipeline_details['formData']['spec_condition'] != ''){{number_format(@$pipeline_details['formData']['spec_condition'],2)}}@endif" >
                                
    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Warranty:<span>*</span></label>
                                <input class="form_input number" id="warranty" name="warranty" type="text"  value="@if(isset($pipeline_details['formData']['warranty']) && $pipeline_details['formData']['warranty'] != ''){{number_format(@$pipeline_details['formData']['warranty'],2)}}@endif" >
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold">Exclusion<span>*</span></label>
                                <input class="form_input number" id="exclusion" name="exclusion" type="text" value="@if(isset($pipeline_details['formData']['exclusion']) && $pipeline_details['formData']['exclusion'] != ''){{number_format(@$pipeline_details['formData']['exclusion'],2)}}@endif">
                                
    
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
                                        hasaccomodation:{
                                            required:true
                                        },
                                        deductible:{
                                            required:true,
                                            number:true
                                        },
                                        spec_condition:{
                                            required:true,
                                            number:true
                                        },
                                        exclusion:{
                                            required:true,
                                            number:true
                                        },
                                        warranty:{
                                            required:true,
                                            number:true
                                        },
                                        ratep:{
                                            required:true,
                                            number:true
                                        },
                                        brokerage:{
                                            required:true,
                                            number:true
                                        },
                                        

                             },
                             messages: {
                                hasaccomodation:"Please choose cover for alternate accomodation",
                                deductible: "Please enter deductible.",
                                spec_condition: "Please enter special condition.",
                                warranty: "Please enter warranty.",
                                exclusion: "Please enter exclusion.",
                                brokerage: "Please enter brokerage.",
                                ratep: "Please enter Rate/premium.",
                                 
                               },
                             errorPlacement: function (error, element) {
                                
                                  if(element.attr("name") == "hasaccomodation")
                                 {
                                     error.insertAfter(element.parent());
                                     // scrolltop();
                                 }
                                 else if(element.attr("name") == "deductible" ||
                                  element.attr("name") == "spec_condition" ||
                                  element.attr("name") == "warranty" ||
                                  element.attr("name") == "exclusion" ||
                                  element.attr("name") == "brokerage" ||
                                  element.attr("name") == "ratep")
                                {
                                    error.insertAfter(element);
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
                                    url: '{{url('business_interruption/eslip-save')}}',
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
                                    url: '{{url('business_interruption/insurance-company-save')}}',
                                    data: form_data,
                                    processData: false,
                                    contentType: false,
                                    success: function (result) {
                                        if (result.success== 'success') {
                                            $("#send_btn").attr( "disabled", false );
                                            window.location.href = '{{url('business_interruption/e-quotation')}}'+'/'+result.id;
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
                                    url: '{{url('business_interruption/eslip-save')}}',
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

      
    // function validate(x,type) {
    //                             // debugger;
    //     var parts = x.split(".");
    //     if (typeof parts[1] == "string" && (parts[1].length == 0 || parts[1].length > 2))
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
        
    //     var n = parseFloat(x);
    //      if (isNaN(n))
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
    //     else if (n < 0 || n > 100)
    //     {
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //     }
    //     else{
    //         if(type=='deductible')
    //         {
    //             $("#deductible-error").show();
    //         }else if(type=='ratep')
    //         {
    //             $("#ratep-error").show();
    //         }else if(type=='brokerage')
    //         {
    //             $("#brokerage-error").show();
    //         }else if(type=='spec_conditions')
    //         {
    //             $("#spec_conditions-error").show();
    //         }else if(type=='warranty')
    //         {
    //             $("#warranty-error").show();
    //         }
    //         else if(type=='exclusion')
    //         {
    //             $("#exclusion-error").show();
    //         }
    //      }
    // }
                    </script>
    @endpush


