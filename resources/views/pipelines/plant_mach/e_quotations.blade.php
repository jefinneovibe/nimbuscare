
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
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">{{$pipeline_details['workTypeId']['name']}}</h3>
        </div>
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible" role="alert" id="success_excel">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ session('msg') }}
            </div>
        @endif
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><a href="{{url('contractor-plant/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('contractor-plant/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            @if($pipeline_details['status']['status'] == 'E-quotation')
                                <li class="current"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                <li class="active_arrow"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="current"><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class="active_arrow"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class="active_arrow"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('contractor-plant/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><a href="{{url('contractor-plant/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                <li><em>Issuance</em></li>
                            @endif
                        </ol>
                    </nav>
                </section>
                @if(isset($pipeline_details['selected_insurers']))
                    <input type="hidden" id="selected_insurers" value="{{json_encode($id_insurer)}}">
                @else
                    <input type="hidden" id="selected_insurers" value="empty">
                @endif
                <form id="e_quat_form" name="e_quat_form" method="post" >
                    <input type="hidden" value="{{$pipeline_details->_id}}" id="pipeline_id" name="pipeline_id">
                    {{csrf_field()}}
                    <div class="data_table compare_sec">
                        <div id="admin">

                            <div class="material-table">
                                <div class="table-header">
                                    <span class="table-title">E-Quotation</span>
                                </div>

                                <div class="table_fixed height_fix">
                                    <div class="table_sep_fix">
                                        <div class="material-table table-responsive" style="border-bottom: none;overflow: hidden">
                                            <table class="table table-bordered"  style="border-bottom: none">
                                                <thead>
                                                <tr>
                                                    <th><div class="main_question">Questions</div></th>
                                                    <th><div class="main_answer" style="background-color: transparent">Customer Response</div></th>
                                                </tr>
                                                </thead>
                                                <tbody style="border-bottom: none" class="syncscroll"  name="myElements">
												<?php $insure_count=count(@$insures_details);?>
												<?php $sel_insure_count=count(@$insures_name);?> <!--Insurance Company List Active-->
                                                <?php $total_insure_count=$insure_count+$sel_insure_count;?> <!--Insurance Company List Active-->
                                                @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Authorised repair limit</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['authRepair']}}</div></td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Strike, riot and civil commotion and malicious damage</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['strikeRiot']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Overtime, night works , works on public holidays and express freight</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['overtime']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for extra charges for Airfreight</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['coverExtra']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for underground Machinery and equipment</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['coverUnder']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for water well drilling rigs and equipment</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['drillRigs']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Inland Transit including loading and unloading cover</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['inlandTransit']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['transitRoad']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['thirdParty']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) && isset($pipeline_details['formData']['coverHired']))
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover when items are hired out</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['coverHired']? "Yes" : "No"}}</div></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['autoSum']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including the risk of erection, resettling and dismantling</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['includRisk']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Tool of trade extension</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['tool']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">72 Hours clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['hoursClause']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster Clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['lossAdj']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance Clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['primaryClause']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on accounts clause-75%</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['paymentAccount']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">85% condition of average</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['avgCondition']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['autoAddition']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cancellation clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['cancelClause']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['derbis']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Repair investigation clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['repairClause']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['tempRepair']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Errors & omission clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['errorOmission']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Minimization of loss</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['minLoss']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                                isset($pipeline_details['formData']['crossLiability']))
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cross liability</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['crossLiability']? "Yes" : "No"}}</div></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including cover for loading/ unloading and delivery risks</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['coverInclude']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Towing charges</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['towCharge']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true &&
                                                isset($pipeline_details['formData']['lossPayee']))
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['lossPayee']? "Yes" : "No"}}</div></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Agency repair</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['agencyRepair']}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Indemnity to principal</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['indemnityPrincipal']}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['propDesign']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['specialAgree']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['declarationSum']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['salvage']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['totalLoss']? "Yes" : "No"}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Profit Sharing</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['profitShare']}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims procedure: Existing claim procedure attached and should form the framework for renewal period</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['claimPro']}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Waiver of subrogation against principal</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['waiver']}}</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate required (in %)</label></div></td>
                                                    <td class="main_answer"><div class="ans">@if(isset($pipeline_details['formData']['rate'])){{number_format($pipeline_details['formData']['rate'],2)}}@endif</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium Required (in %)</label></div></td>
                                                    <td class="main_answer"><div class="ans">@if(isset($pipeline_details['formData']['premium'])){{number_format($pipeline_details['formData']['premium'],2)}}@endif</div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment Terms</label></div></td>
                                                    <td class="main_answer"><div class="ans">@if(isset($pipeline_details['formData']['payTerm'])){{$pipeline_details['formData']['premium']}}@endif</div></td>
                                                </tr>
                                                @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')
                                                    <tr style="border-bottom: none">
														<?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td style="border-bottom: none;border-right: none"></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td style="border-bottom: none;border-right: none"></td>
                                                                @else
																	<?php $i_cont=$i-$insure_count; ?>
                                                                    <td style="border-bottom: none;border-right: none"></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="table_sep_pen">
                                        <div class="material-table table-responsive">
                                            <table class="table comparison table-bordered" style="table-layout: auto">
                                                <thead>
                                                <tr>
												<?php $insure_count=count(@$insures_details);?><!--Replied insures count -->
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <th><div class="ans"> {{$insures_name[$i]}}</div></th>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <th>
                                                                    @if(isset($insures_details[$i]['insurerDetails']['insurerName']))
                                                                        <div class="ans">
                                                                            <div class="custom_checkbox">
                                                                                <input type="checkbox" value="hide" name="insure_check[]" id="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="inp-cbx" style="display: none" onclick="color_change_table(this.id);">
                                                                                <label for="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="cbx">
<span>
<svg width="10px" height="8px" viewBox="0 0 12 10">
<polyline points="1.5 6 4.5 9 10.5 1"></polyline>
</svg>
</span>
																					<?php $length=strlen($insures_details[$i]['insurerDetails']['insurerName']);
																					if($length>32)
																					{
																						$dot="...";
																					}
																					else{
																						$dot=null;
																					}
																					?>
                                                                                    @if($dot!=null)
                                                                                        <span data-toggle="tooltip" data-placement="right" title="{{$insures_details[$i]['insurerDetails']['insurerName']}}" data-container="body">{{substr(ucfirst($insures_details[$i]['insurerDetails']['insurerName']), 0, 32).$dot}}</span>
                                                                                    @else
                                                                                        <span>{{$insures_details[$i]['insurerDetails']['insurerName']}}</span>
                                                                                    @endif
																					<?php if(isset($insures_details[$i]['repliedMethod']))
																					{
																					if($insures_details[$i]['repliedMethod']=='excel')
																					{
																					$method=$insures_details[$i]['repliedMethod'];
																					?>
                                                                                    <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                        <i style="color: #9c27b0;" class="fa fa-file-excel-o"></i>
                                                                                    </div>
																					<?php
																					}
																					else{
																					$method=$insures_details[$i]['repliedMethod'];
																					?>
                                                                                    <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                        <i style="color: #9c27b0;" class="fa fa-user"></i>
                                                                                    </div>
																					<?php
																					}
																					}
																					else{
																						$method='';
																					}
																					?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </th>
                                                            @else
																<?php $i_cont=$i-$insure_count; ?>
																<?php $lengthval=strlen($insures_name[$i_cont]);
																if($lengthval>32)
																{
																	$dot_value="...";
																}
																else{
																	$dot_value=null;
																}

																?>
                                                                <th>
                                                                    @if($dot_value!=null)
                                                                        <div class="ans" data-toggle="tooltip" data-placement="right" title="{{$insures_name[$i_cont]}}">{{substr(ucfirst($insures_name[$i_cont]), 0, 32).$dot_value}}</div>
                                                                    @else
                                                                        <div class="ans">{{substr(ucfirst($insures_name[$i_cont]), 0, 32)}}</div>
                                                                    @endif
                                                                </th>
                                                            @endif
                                                        @endfor
                                                    @endif

                                                </tr>

                                                </thead>
                                                <tbody  class="syncscroll" name="myElements">
                                                @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['authRepair']['isAgree']))
                                                                    @if(@$insures_details[$i]['authRepair']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_authRepair_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='authRepair_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['authRepair']['isAgree']}}'>
<label class='error' id='authRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['authRepair']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['authRepair']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_authRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='authRepair_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['authRepair']['comment']}}'>
<label class='error' id='authRepair_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_authRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='authRepair_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['authRepair']['isAgree']}}'>
<label class='error' id='authRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='authRepair' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['authRepair']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @endif
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['strikeRiot']['isAgree']))
                                                                    @if(@$insures_details[$i]['strikeRiot']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_strikeRiot_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='strikeRiot_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['strikeRiot']['isAgree']}}'>
<label class='error' id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['strikeRiot']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['strikeRiot']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_strikeRiot_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='strikeRiot_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['strikeRiot']['comment']}}'>
<label class='error' id='strikeRiot_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_strikeRiot_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['strikeRiot']['isAgree']}}'>
<label class='error' id='strikeRiot_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='strikeRiot' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['strikeRiot']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['overtime']['isAgree']))
                                                                    @if(@$insures_details[$i]['overtime']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_overtime_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='overtime_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['overtime']['isAgree']}}'>
<label class='error' id='overtime_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['overtime']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['overtime']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_overtime_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='overtime_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['overtime']['comment']}}'>
<label class='error' id='overtime_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_overtime_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='overtime_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['overtime']['isAgree']}}'>
<label class='error' id='overtime_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='overtime' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['overtime']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>

                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['coverExtra']['isAgree']))
                                                                    @if(@$insures_details[$i]['coverExtra']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_coverExtra_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='coverExtra_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverExtra']['isAgree']}}'>
<label class='error' id='coverExtra_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['coverExtra']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['coverExtra']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_coverExtra_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='coverExtra_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverExtra']['comment']}}'>
<label class='error' id='coverExtra_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_coverExtra_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='coverExtra_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverExtra']['isAgree']}}'>
<label class='error' id='coverExtra_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverExtra' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['coverExtra']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_coverUnder_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='coverUnder_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverUnder']?:'--'}}' required>
<label class='error' id='coverUnder_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverUnder' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverUnder' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['coverUnder']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_drillRigs_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='drillRigs_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['drillRigs']?:'--'}}' required>
<label class='error' id='drillRigs_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='drillRigs' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='drillRigs' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['drillRigs']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @endif
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['inlandTransit']['isAgree']))
                                                                    @if(@$insures_details[$i]['inlandTransit']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_inlandTransit_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='inlandTransit_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['inlandTransit']['isAgree']}}'>
<label class='error' id='inlandTransit_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['inlandTransit']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['inlandTransit']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_inlandTransit_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='inlandTransit_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['inlandTransit']['comment']}}'>
<label class='error' id='inlandTransit_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_inlandTransit_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='inlandTransit_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['inlandTransit']['isAgree']}}'>
<label class='error' id='inlandTransit_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='inlandTransit' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['inlandTransit']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['transitRoad']['isAgree']))
                                                                    @if(@$insures_details[$i]['transitRoad']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_transitRoad_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='transitRoad_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['transitRoad']['isAgree']}}'>
<label class='error' id='transitRoad_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['transitRoad']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['transitRoad']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_transitRoad_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='transitRoad_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['transitRoad']['comment']}}'>
<label class='error' id='transitRoad_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_transitRoad_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='transitRoad_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['transitRoad']['isAgree']}}'>
<label class='error' id='transitRoad_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='transitRoad' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['transitRoad']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['thirdParty']['isAgree']))
                                                                    @if(@$insures_details[$i]['thirdParty']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_thirdParty_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='thirdParty_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['thirdParty']['isAgree']}}'>
<label class='error' id='thirdParty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['thirdParty']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['thirdParty']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_thirdParty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['thirdParty']['comment']}}'>
<label class='error' id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_thirdParty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='thirdParty_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['thirdParty']['isAgree']}}'>
<label class='error' id='thirdParty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['thirdParty']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) &&
                                                 isset($pipeline_details['formData']['coverHired']))
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
<span id='div_coverHired_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='coverHired_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverHired']?:'--'}}' required>
<label class='error' id='coverHired_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHired' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHired' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['coverHired']?:'--'}}
</span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['autoSum']['isAgree']))
                                                                    @if(@$insures_details[$i]['autoSum']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_autoSum_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='autoSum_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['autoSum']['isAgree']}}'>
<label class='error' id='autoSum_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['autoSum']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['autoSum']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_autoSum_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='autoSum_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['autoSum']['comment']}}'>
<label class='error' id='autoSum_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_autoSum_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='autoSum_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['autoSum']['isAgree']}}'>
<label class='error' id='autoSum_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoSum' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['autoSum']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_includRisk_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='includRisk_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['includRisk']?:'--'}}' required>
<label class='error' id='includRisk_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='includRisk' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='includRisk' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['includRisk']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['tool']['isAgree']))
                                                                    @if(@$insures_details[$i]['tool']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_tool_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='tool_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['tool']['isAgree']}}'>
<label class='error' id='tool_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['tool']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['tool']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_tool_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='tool_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['tool']['comment']}}'>
<label class='error' id='tool_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_tool_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='tool_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['tool']['isAgree']}}'>
<label class='error' id='tool_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tool' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['tool']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_hoursClause_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='hoursClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['hoursClause']?:'--'}}' required>
<label class='error' id='hoursClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='hoursClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='hoursClause' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['hoursClause']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['lossAdj']['isAgree']))
                                                                    @if(@$insures_details[$i]['lossAdj']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_lossAdj_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='lossAdj_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossAdj']['isAgree']}}'>
<label class='error' id='lossAdj_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['lossAdj']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['lossAdj']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_lossAdj_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='lossAdj_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossAdj']['comment']}}'>
<label class='error' id='lossAdj_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_lossAdj_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='lossAdj_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossAdj']['isAgree']}}'>
<label class='error' id='lossAdj_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossAdj' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossAdj']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_primaryClause_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='primaryClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['primaryClause']?:'--'}}' required>
<label class='error' id='primaryClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryClause' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['primaryClause']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['paymentAccount']['isAgree']))
                                                                    @if(@$insures_details[$i]['paymentAccount']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_paymentAccount_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='paymentAccount_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['paymentAccount']['isAgree']}}'>
<label class='error' id='paymentAccount_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['paymentAccount']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['paymentAccount']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_paymentAccount_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='paymentAccount_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['paymentAccount']['comment']}}'>
<label class='error' id='paymentAccount_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_paymentAccount_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='paymentAccount_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['paymentAccount']['isAgree']}}'>
<label class='error' id='paymentAccount_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='paymentAccount' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['paymentAccount']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_avgCondition_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='avgCondition_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['avgCondition']?:'--'}}' required>
<label class='error' id='avgCondition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='avgCondition' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='avgCondition' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['avgCondition']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['autoAddition']['isAgree']))
                                                                    @if(@$insures_details[$i]['autoAddition']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_autoAddition_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='autoAddition_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['autoAddition']['isAgree']}}'>
<label class='error' id='autoAddition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['autoAddition']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['autoAddition']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_autoAddition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='autoAddition_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['autoAddition']['comment']}}'>
<label class='error' id='autoAddition_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_autoAddition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='autoAddition_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['autoAddition']['isAgree']}}'>
<label class='error' id='autoAddition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='autoAddition' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['autoAddition']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['cancelClause']['isAgree']))
                                                                    @if(@$insures_details[$i]['cancelClause']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_cancelClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='cancelClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['cancelClause']['isAgree']}}'>
<label class='error' id='cancelClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['cancelClause']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['cancelClause']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_cancelClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='cancelClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['cancelClause']['comment']}}'>
<label class='error' id='cancelClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_cancelClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='cancelClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['cancelClause']['isAgree']}}'>
<label class='error' id='cancelClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='cancelClause' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['cancelClause']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['derbis']['isAgree']))
                                                                    @if(@$insures_details[$i]['derbis']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_derbis_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='derbis_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['derbis']['isAgree']}}'>
<label class='error' id='derbis_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['derbis']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['derbis']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_derbis_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='derbis_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['derbis']['comment']}}'>
<label class='error' id='derbis_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_derbis_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='derbis_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['derbis']['isAgree']}}'>
<label class='error' id='derbis_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='derbis' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['derbis']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['repairClause']['isAgree']))
                                                                    @if(@$insures_details[$i]['repairClause']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_repairClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='repairClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['repairClause']['isAgree']}}'>
<label class='error' id='repairClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['repairClause']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['repairClause']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_repairClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='repairClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['repairClause']['comment']}}'>
<label class='error' id='repairClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_repairClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='repairClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['repairClause']['isAgree']}}'>
<label class='error' id='repairClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='repairClause' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['repairClause']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['tempRepair']['isAgree']))
                                                                    @if(@$insures_details[$i]['tempRepair']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_tempRepair_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='tempRepair_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['tempRepair']['isAgree']}}'>
<label class='error' id='tempRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['tempRepair']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['tempRepair']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_tempRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='tempRepair_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['tempRepair']['comment']}}'>
<label class='error' id='tempRepair_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_tempRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='tempRepair_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['tempRepair']['isAgree']}}'>
<label class='error' id='tempRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='tempRepair' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['tempRepair']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_errorOmission_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='errorOmission_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['errorOmission']?:'--'}}' required>
<label class='error' id='errorOmission_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='errorOmission' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='errorOmission' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['errorOmission']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['minLoss']['isAgree']))
                                                                    @if(@$insures_details[$i]['minLoss']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_minLoss_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='minLoss_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minLoss']['isAgree']}}'>
<label class='error' id='minLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['minLoss']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['minLoss']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_minLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='minLoss_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['minLoss']['comment']}}'>
<label class='error' id='minLoss_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_minLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='minLoss_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['minLoss']['isAgree']}}'>
<label class='error' id='minLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='minLoss' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['minLoss']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                                isset($pipeline_details['formData']['crossLiability']))
                                                    <tr>
														<?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if(isset($insures_details[$i]['crossLiability']['isAgree']))
                                                                        @if(@$insures_details[$i]['crossLiability']['comment']!="")
                                                                            <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
<span id="div_crossLiability_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='crossLiability_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['crossLiability']['isAgree']}}'>
<label class='error' id='crossLiability_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['crossLiability']['isAgree']}}</span>

                                                                                    <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['crossLiability']['comment']}}</span>
                                                                                                </div>
                                                                                                <div class="media-right">
<span id="cancel_crossLiability_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='crossLiability_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['crossLiability']['comment']}}'>
<label class='error' id='crossLiability_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
<span id="div_crossLiability_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='crossLiability_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['crossLiability']['isAgree']}}'>
<label class='error' id='crossLiability_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['crossLiability']['isAgree']}}</span></div></td>
                                                                        @endif
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                    @endif

                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_coverInclude_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='coverInclude_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverInclude']?:'--'}}' required>
<label class='error' id='coverInclude_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverInclude' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='coverInclude' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['coverInclude']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['towCharge']['isAgree']))
                                                                    @if(@$insures_details[$i]['towCharge']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_towCharge_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='towCharge_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['towCharge']['isAgree']}}'>
<label class='error' id='towCharge_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['towCharge']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['towCharge']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_towCharge_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='towCharge_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['towCharge']['comment']}}'>
<label class='error' id='towCharge_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_towCharge_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='towCharge_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['towCharge']['isAgree']}}'>
<label class='error' id='towCharge_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='towCharge' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['towCharge']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee']))
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
<span id='div_lossPayee_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='lossPayee_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossPayee']?:'--'}}' required>
<label class='error' id='lossPayee_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossPayee' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='lossPayee' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['lossPayee']?:'--'}}
</span>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['agencyRepair']['isAgree']))
                                                                    @if(@$insures_details[$i]['agencyRepair']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_agencyRepair_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='agencyRepair_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['agencyRepair']['isAgree']}}'>
<label class='error' id='agencyRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['agencyRepair']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['agencyRepair']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_agencyRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='agencyRepair_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['agencyRepair']['comment']}}'>
<label class='error' id='agencyRepair_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_agencyRepair_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='agencyRepair_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['agencyRepair']['isAgree']}}'>
<label class='error' id='agencyRepair_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='agencyRepair' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['agencyRepair']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_indemnityPrincipal_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='indemnityPrincipal_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['indemnityPrincipal']?:'--'}}' required>
<label class='error' id='indemnityPrincipal_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='indemnityPrincipal' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='indemnityPrincipal' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['indemnityPrincipal']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_propDesign_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='propDesign_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['propDesign']?:'--'}}' required>
<label class='error' id='propDesign_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='propDesign' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='propDesign' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['propDesign']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_specialAgree_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='specialAgree_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['specialAgree']?:'--'}}' required>
<label class='error' id='specialAgree_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='specialAgree' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='specialAgree' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['specialAgree']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['declarationSum']['isAgree']))
                                                                    @if(@$insures_details[$i]['declarationSum']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_declarationSum_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='declarationSum_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['declarationSum']['isAgree']}}'>
<label class='error' id='declarationSum_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['declarationSum']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['declarationSum']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_declarationSum_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='declarationSum_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['declarationSum']['comment']}}'>
<label class='error' id='declarationSum_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_declarationSum_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='declarationSum_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['declarationSum']['isAgree']}}'>
<label class='error' id='declarationSum_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='declarationSum' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['declarationSum']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['salvage']['isAgree']))
                                                                    @if(@$insures_details[$i]['salvage']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_salvage_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='salvage_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['salvage']['isAgree']}}'>
<label class='error' id='salvage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['salvage']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['salvage']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_salvage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='salvage_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['salvage']['comment']}}'>
<label class='error' id='salvage_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_salvage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='salvage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['salvage']['isAgree']}}'>
<label class='error' id='salvage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='salvage' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['salvage']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['totalLoss']['isAgree']))
                                                                    @if(@$insures_details[$i]['totalLoss']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_totalLoss_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='totalLoss_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['totalLoss']['isAgree']}}'>
<label class='error' id='totalLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['totalLoss']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['totalLoss']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_totalLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='totalLoss_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['totalLoss']['comment']}}'>
<label class='error' id='totalLoss_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_totalLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='totalLoss_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['totalLoss']['isAgree']}}'>
<label class='error' id='totalLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='totalLoss' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['totalLoss']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>

                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['profitShare']['isAgree']))
                                                                    @if(@$insures_details[$i]['profitShare']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_profitShare_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='profitShare_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['profitShare']['isAgree']}}'>
<label class='error' id='profitShare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['profitShare']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['profitShare']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_profitShare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='profitShare_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['profitShare']['comment']}}'>
<label class='error' id='profitShare_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_profitShare_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='profitShare_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['profitShare']['isAgree']}}'>
<label class='error' id='profitShare_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='profitShare' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['profitShare']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
													<?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                @if(isset($insures_details[$i]['claimPro']['isAgree']))
                                                                    @if(@$insures_details[$i]['claimPro']['comment']!="")
                                                                        <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_claimPro_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
      data-content="<input id='claimPro_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimPro']['isAgree']}}'>
<label class='error' id='claimPro_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
      data-container="body">{{@$insures_details[$i]['claimPro']['isAgree']}}</span>

                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['claimPro']['comment']}}</span>
                                                                                            </div>
                                                                                            <div class="media-right">
<span id="cancel_claimPro_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
      data-content="<input id='claimPro_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimPro']['comment']}}'>
<label class='error' id='claimPro_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
</label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='commentEdit(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
      data-container="body">
<button type="button">
<i class="material-icons">edit</i>
</button>
</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                            <div class="ans">
<span id="div_claimPro_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
      title="Edit existing value" data-html="true" data-content="<input id='claimPro_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimPro']['isAgree']}}'>
<label class='error' id='claimPro_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='claimPro' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['claimPro']['isAgree']}}</span></div></td>
                                                                    @endif
                                                                @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                @endif

                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_waiver_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='waiver_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['waiver']?:'--'}}' required>
<label class='error' id='waiver_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='waiver' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['waiver']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_rate_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='rate_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{number_format($insures_details[$i]['rate'],2)?:'--'}}' required>
<label class='error' id='rate_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='rate' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='rate' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{number_format($insures_details[$i]['rate'],2)?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_premium_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='premium_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{number_format($insures_details[$i]['premium'],2)?:'--'}}' required>
<label class='error' id='premium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='premium' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='premium' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{number_format($insures_details[$i]['premium'],2)?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td>  <div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
<span id='div_payTerm_{{$insures_details[$i]['uniqueToken']}}'
      data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
<input id='payTerm_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['payTerm']?:'--'}}' required>
<label class='error' id='payTerm_{{$insures_details[$i]['uniqueToken']}}-error'></label>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='payTerm' onclick='fun(this)'>Update</button>
<button name='{{$insures_details[$i]['uniqueToken']}}' value='payTerm' onclick='cancel(this)'>
<i class='material-icons'>close</i></button>"
      data-container="body">{{$insures_details[$i]['payTerm']?:'--'}}
</span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>

                                                @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')

                                                    <tr>
														<?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i]}}','{{$pipeline_details->_id}}')"><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    <td><div class="ans"></div></td>
                                                                @else
																	<?php $i_cont=$i-$insure_count; ?>
                                                                    <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i_cont]}}','{{$pipeline_details->_id}}')" ><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                                @endif
                                                            @endfor
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
                    @if($insure_count!=0)
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit" @if($pipeline_details['status']['status']=='Approved E Quote' || $pipeline_details['status']['status']=='Issuance') style="display: none" @endif>Proceed</button>
                        @if(@$pipeline_details['status']['status']!='Approved E Quote')
                            <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveQuotation()">Save as Draft</button>
                        @endif
                    @endif
                </form>
                {{--@else--}}
                {{--No Data--}}
                {{--@endif--}}
            </div>
        </div>

    </div>
    <!-- Popup -->
    <div id="upload_excel">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix">
                        <h1>Upload Excel</h1>
                    </div>
                    <form id="upload_excel_form" name="upload_excel_form" method="post">
                        {{csrf_field()}}
                        <div class="upload_sec">
                            <input type="hidden" id="pipelinedetails_id" name="pipelinedetails_id">
                            <input type="hidden" id="insurer_id" name="insurer_id">
                            <div class="custom_upload">
                                <input type="file" name="import_excel_file" id="import_excel_file" >
                                <p>Drag your files or click here.</p>
                            </div>
                            <label style="float: left" class="error" id="error-label"></label>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn-primary btn-link btn_cancel" id="upload_excel_cancel" type="button">Cancel</button>
                            <button type="submit" id="upload_excel" class="btn btn-primary btn_action">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('includes.chat')
    @include('includes.mail_popup')
@endsection

{{--<style>--}}
{{--.material-table{--}}
{{--position: relative;--}}
{{--}--}}
{{--.main_question,.main_answer{--}}
{{--position: absolute;--}}
{{--}--}}
{{--.main_answer{--}}
{{--left: 300px;--}}
{{--}--}}
{{--</style>--}}



@push('scripts')

    <!--jquery validate-->
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
    {{--    <script src="{{URL::asset('js/jquery.CongelarFilaColumna.?js')}}"></script>--}}
    <!-- table fix -->
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/ScrollTabla.css')}}" />--}}
    {{--<script type="text/javascript">--}}
    {{--$(document).ready(function(){--}}
    {{--$("#pruebatabla").CongelarFilaColumna({lboHoverTr:true});--}}
    {{--});--}}
    {{--</script>--}}
    <script>

        function get_excel_id(insurer_id,pipeline_id)
        {
            $('#pipelinedetails_id').val(pipeline_id);
            $('#insurer_id').val(insurer_id);
        }

        $("#upload_excel_form").validate({
            ignore: [],
            rules: {
                import_excel_file: {
                    required: true,
                    accept: "application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                }
            },
            messages: {
                import_excel_file: "Please upload a valid excel file."
            },
            errorPlacement: function(error, element){
                if(element.attr("name") == "import_excel_file" ){
                    error.insertAfter(element.parent());
                }
            },
            submitHandler: function (form, event) {
                var form_data = new FormData($("#upload_excel_form")[0]);
                var excel = $('#import_excel_file').prop('files')[0];
                $('#preLoader').show();
                $("#upload_excel").attr( "disabled", true );
                form_data.append('file', excel);
                form_data.append('_token', '{{csrf_token()}}');
                $.ajax({
                    url: '{{url('save-temporary')}}',
                    data: form_data,
                    method: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result == 1) {
                            window.location.href = "{{url('contractor-plant/imported-list')}}";
                        }
                        else if(result.length> 1){
                            $("#upload_excel").attr( "disabled", false );

                            $('#preLoader').hide();
                            $('#error-label').html('The file you uploaded is not a Quotation');
                            $('#error-label').show();
                        }
                        else if(result == 0)
                        {
                            $("#upload_excel").attr( "disabled", false );
                            $('#preLoader').hide();
                            $('#error-label').html('The file you uploaded is not a Quotation');
                            $('#error-label').show();
                        }
                        {{--else {--}}
                        {{--alert('something went wrong');--}}
                        {{--}--}}
                    }
                });
            }
        });

        //add customer form validation//
        $("#e_quat_form").validate({

            ignore: [],
            rules: {
                'insure_check[]': {
                    required: true
                }
            },
            messages: {
                'insure_check[]': "Please select one of insurer."
            },

            errorPlacement: function (error, element) {
                console.log('sdfsdfdf');
                error.insertBefore(element.parent().parent().parent().parent());
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e_quat_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('save-selected-insurers')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}';
                        }
                    }
                });
            }
        });
        //end//

        function color_change_table(col_name)
        {
            // debugger;
            // insure_check_15569559076139
            // console.log(col_name);
            var result = col_name.split('_');
            var checkbox_val=document.getElementById(col_name).value;
            if(checkbox_val=="hide")
            {
                var all_col=document.getElementsByClassName(col_name);
                for(var i=0;i<all_col.length;i++)
                {
                    all_col[i].style.background="#C8CDE3";
                }
                document.getElementById(col_name).value=result[2];
//                document.getElementById(col_name+"_head").style.background="#F00";

            }

            else
            {
                var all_col=document.getElementsByClassName(col_name);
                for(var i=0;i<all_col.length;i++)
                {
                    all_col[i].style.background="#fff";
                }
                document.getElementById(col_name).value="hide";
//                document.getElementById(col_name+"_head").style.background="#fff";

            }
        }
    </script>
    <style>
        label.error {
            float:right;
        }
        #demodocs-error {
            float:left;
        }
        #import_excel_file-error{
            display: block;
            float: left;
            margin: 6px 0;
        }
        .section_details{
            max-width: 100%;
        }

        thead label.error {
            position: fixed;
            z-index: 9;
            background: #e01c1c;
            margin: -34px 0 0;
            color: #ffffff;
            padding: 8px 15px;
        }
        thead label.error:after {
            top: 100%;
            left: 0;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-color: rgba(136, 183, 213, 0);
            border-top-color: #e01c1c;
            border-width: 6px;
            margin-left: 5px;
        }

    </style>
    <script>
        $(document).ready(function () {

            $('thead .error').addClass('sdfsdfsdf');

            var selected = $('#selected_insurers').val();
            if(selected != 'empty')
            {
                var values = JSON.parse(selected);
                // console.log(values)
                $.each(values , function (index , value) {
                    console.log(index);
                    console.log(value);
                    var col_name ='insure_check_'+value;
                    console.log(col_name);
                    color_change_table(col_name);
                    $('#'+col_name).prop('checked',true);
                })
            }
            setTimeout(function() {
                $('#success_excel').fadeOut('fast');
            }, 5000);
            $('form input').change(function () {
                var fullPath = $('#import_excel_file').val();
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }
//            console.log(filename);
                $('.custom_upload p').text(filename);
            });


        });
        function fun(obj) {
// debugger;
            var token = obj.name;
            var field = obj.value;
            var new_quot = $('#'+field+'_'+token+'').val();
            var id = $('#pipeline_id').val();
            if(new_quot!="")
            {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('contractor-plant/quot-amend')}}',
                    data: {
                        token:token,
                        field:field,
                        new_quot:new_quot,
                        id:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.reload();
                        }else{
                            $('#preLoader').hide();
                            $('#'+field+'_'+token+'-error').html('Please enter numerical value');
                        }
                    }
                });
            }
            else{
                $('#'+field+'_'+token+'-error').html('Please enter a valid data');
            }
        }
        function cancel(obj) {
            var token = obj.name;
            var field = obj.value;
            $('#div_'+field+'_'+token+'').popover('hide');

        }
        function commentEdit(obj)
        {
            var token = obj.name;
            var field = obj.value;
            var new_quot = $('#'+field+'_comment_'+token+'').val();
            var id = $('#pipeline_id').val();
            if(new_quot!="")
            {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('contractor-plant/quot-amend')}}',
                    data: {
                        token:token,
                        field:field,
                        new_quot:new_quot,
                        id:id,
                        comment:"comment",
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
// $('#div_'+field+'_'+token+'').popover('hide');
// $('#div_'+field+'_'+token+'').html(new_quot);
                            location.reload();
                        }
                    }
                });
            }
            else{
                $('#'+field+'_'+token+'-error').html('Please enter a valid data');
            }
        }
        function commentCancel(obj)
        {
            var token = obj.name;
            var field = obj.value;
            $('#cancel_'+field+'_'+token+'').popover('hide');
        }
    </script>

    <script>
        function resizeHandler() {
// Treat each container separately
            $(".height_fix").each(function(i, height_fix) {
// Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
// Loop through the tables
                $(height_fix).find("table").each(function(indx, table) {
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
                $(height_fix).find("table").each(function(i, table) {
// Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $( "#upload_excel_cancel" ).click(function() {
            $('#error-label').hide();
            $('#import_excel_file').val('');
            $('#import_excel_file-error').hide();
            $('.custom_upload p').text('Drag your files or click here.');
        });
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.material-table tbody tr');

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
        function saveQuotation()
        {
            var form_data = new FormData($("#e_quat_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $.ajax({
                method: 'post',
                url: '{{url('save-selected-insurers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        $('#success_message').html('E-Quotation is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('E-Quotation saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>
@endpush
