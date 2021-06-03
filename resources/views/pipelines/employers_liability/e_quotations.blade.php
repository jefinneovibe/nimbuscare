
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
            <h3 class="title" style="margin-bottom: 8px;">Employers Liability</h3>
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
                            <li class="complete"><a href="{{url('employer/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('employer/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            @if($pipeline_details['status']['status'] == 'E-quotation')
                                <li class="current"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li><em>E-Comparison</em></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                                @elseif($pipeline_details['status']['status'] == 'E-comparison')
                                <li class="active_arrow"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="current"><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class="active_arrow"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class="active_arrow"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="complete"><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class="current"><a href="{{url('employer/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class="active_arrow"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                                <li class="complete"><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class="current"><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class="current"><a href="{{url('employer/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
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
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></div></td>
                                                    <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['extendedLiability'],2)}}</div></td>

                                                </tr>



                                                @if(isset($pipeline_details['formData']['hiredWorkersDetails']))
                                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
		                                                <?php $hiredWorkersDetails='Yes';
                                                              $noOfLabourers=$pipeline_details['formData']['hiredWorkersDetails']['noOfLabourers'];
                                                              $annualWages=$pipeline_details['formData']['hiredWorkersDetails']['annualWages'];
		                                                ?>
                                                    @else
		                                                <?php $hiredWorkersDetails='No';?>
                                                    @endif
                                                @endif
                                                @if($hiredWorkersDetails=='Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">COVER FOR HIRED WORKERS OR CASUAL LABOURS</label></div></td>
                                                        <td class="main_answer"><div class="ans">No Of Labourers : {{@$noOfLabourers}}</div><br>
                                                                                <div class="ans">Estimated Annual wages : {{number_format(@$annualWages)}}</div>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if(isset($pipeline_details['formData']['offShoreEmployeeDetails']))
                                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
		                                                <?php $offShoreEmployeeDetails='Yes';
                                                              $noOfLabourersOffshore=$pipeline_details['formData']['offShoreEmployeeDetails']['noOfLabourers'];
                                                              $annualWagesOffshore=$pipeline_details['formData']['offShoreEmployeeDetails']['annualWages'];
		                                                ?>
                                                    @else
		                                                <?php $offShoreEmployeeDetails='No';?>
                                                    @endif
                                                @endif
                                                @if($offShoreEmployeeDetails=='Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEES</label></div></td>
                                                        <td class="main_answer"><div class="ans">No Of Labourers : {{@$noOfLabourersOffshore}}</div><br>
                                                                                <div class="ans">Estimated Annual wages : {{number_format(@$annualWagesOffshore)}}</div>
                                                        </td>
                                                    </tr>
                                                @endif


                                                @if(isset($pipeline_details['formData']['emergencyEvacuation']))
                                                    @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                                        <?php $emergencyEvacuation='Yes';?>
                                                    @else
                                                        <?php $emergencyEvacuation='No';?>
                                                    @endif
                                                @endif
                                                @if($emergencyEvacuation == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Emergency evacuation following work related accident</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$emergencyEvacuation}}</div></td>
                                                    </tr>
                                                @endif

                                                @if(isset($pipeline_details['formData']['empToEmpLiability']))
                                                    @if($pipeline_details['formData']['empToEmpLiability']==true)
                                                        <?php $empToEmpLiability='Yes';?>
                                                    @else
                                                        <?php $empToEmpLiability='No';?>
                                                    @endif
                                                @endif
                                                @if($empToEmpLiability == 'Yes')
                                                     <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Employee to employee liability</label></div></td>
                                                         <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$empToEmpLiability}}</div></td>
                                                    </tr>
                                                 @endif
                                                @if(isset($pipeline_details['formData']['errorsOmissions']))
                                                    @if($pipeline_details['formData']['errorsOmissions']==true)
                                                        <?php $errorsOmissions='Yes';?>
                                                    @else
                                                        <?php $errorsOmissions='No';?>
                                                    @endif
                                                @endif
                                                @if($errorsOmissions == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">ERRORS & OMISSIONS</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$errorsOmissions}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['crossLiability']))
                                                    @if($pipeline_details['formData']['crossLiability']==true)
                                                        <?php $crossLiability='Yes';?>
                                                    @else
                                                        <?php $crossLiability='No';?>
                                                    @endif
                                                @endif
                                                @if($crossLiability == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">CROSS LIABILITY</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$crossLiability}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                    @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                                        <?php $waiverOfSubrogation='Yes';?>
                                                    @else
                                                        <?php $waiverOfSubrogation='No';?>
                                                    @endif

                                                @if($waiverOfSubrogation == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$waiverOfSubrogation}}</div></td>
                                                    </tr>
                                                @endif
                                                    @else <?php $waiverOfSubrogation='null';?>
                                                @endif
                                                @if(isset($pipeline_details['formData']['automaticClause']))
                                                    @if($pipeline_details['formData']['automaticClause']==true)
                                                        <?php $automaticClause='Yes';?>
                                                    @else
                                                        <?php $automaticClause='No';?>
                                                    @endif
                                                @endif
                                                @if($automaticClause == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$automaticClause}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['flightCover']))
                                                    @if($pipeline_details['formData']['flightCover']==true)
                                                        <?php $flightCover='Yes';?>
                                                    @else
                                                        <?php $flightCover='No';?>
                                                    @endif
                                                @endif

                                                @if(isset($pipeline_details['formData']['cancellationClause']))
                                                    @if($pipeline_details['formData']['cancellationClause']==true)
                                                        <?php $cancellationClause='Yes';?>
                                                    @else
                                                        <?php $cancellationClause='No';?>
                                                    @endif
                                                @endif
                                                @if($cancellationClause == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">CANCELLATION CLAUSE-30 DAYS BY EITHER SIDE ON PRO-RATA</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$cancellationClause}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                    @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                                        <?php $indemnityToPrincipal='Yes';?>
                                                    @else
                                                        <?php $indemnityToPrincipal='No';?>
                                                    @endif

                                                @if($indemnityToPrincipal == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">INDEMNITY TO PRINCIPAL</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$indemnityToPrincipal}}</div></td>
                                                    </tr>
                                                @endif
                                                    @else
	                                                <?php $indemnityToPrincipal='null';?>
                                                @endif

                                                @if(isset($pipeline_details['formData']['lossNotification']))
                                                    @if($pipeline_details['formData']['lossNotification']==true)
                                                        <?php $lossNotification='Yes';?>
                                                    @else
                                                        <?php $lossNotification='No';?>
                                                    @endif
                                                @endif
                                                @if($lossNotification == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">LOSS NOTIFICATION – ‘AS SOON AS REASONABLY PRACTICABLE’</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$lossNotification}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['primaryInsuranceClause']))
                                                    @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                                        <?php $primaryInsuranceClause='Yes';?>
                                                    @else
                                                        <?php $primaryInsuranceClause='No';?>
                                                    @endif
                                                @endif
                                                @if($primaryInsuranceClause == 'Yes')
                                                  <tr>
                                                        <td><div class="main_question"><label class="form_label bold">PRIMARY INSURANCE CLAUSE</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$primaryInsuranceClause}}</div></td>
                                                  </tr>
                                              @endif
                                                @if(isset($pipeline_details['formData']['travelCover']))
                                                    @if($pipeline_details['formData']['travelCover']==true)
                                                        <?php $travelCover='Yes';?>
                                                    @else
                                                        <?php $travelCover='No';?>
                                                    @endif
                                                @endif
                                                @if($travelCover == 'Yes')
                                                  <tr>
                                                        <td><div class="main_question"><label class="form_label bold">TRAVELLING TO AND FROM WORKPLACE</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$travelCover}}</div></td>
                                                  </tr>
                                              @endif
                                                @if(isset($pipeline_details['formData']['riotCover']))
                                                    @if($pipeline_details['formData']['riotCover']==true)
                                                        <?php $riotCover='Yes';?>
                                                    @else
                                                        <?php $riotCover='No';?>
                                                    @endif
                                                @endif
                                                @if($riotCover == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">RIOT, STRIKES, CIVIL COMMOTION AND PASSIVE WAR RISK</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$riotCover}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['brokersClaimClause']))
                                                    @if($pipeline_details['formData']['brokersClaimClause']==true)
                                                        <?php $brokersClaimClause='Yes';?>
                                                    @else
                                                        <?php $brokersClaimClause='No';?>
                                                    @endif
                                                @endif
                                                @if($brokersClaimClause == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">BROKERS CLAIM HANDLING CLAUSE : A LOSS NOTIFICATION RECEIVED BY THE INSURANCE BROKER WILL BE DEEMED AS A LOSS NOTIFICATION TO INSURER. ALL COMMUNICATIONS FLOWING BETWEEN THE INSURER, INSURED AND THE APPOINTED LOSS SURVEYOR SHOULD BE CHANNELIZED THROUGH THE BROKER, UNLESS THERE IS ANY UNAVOIDABLE REASONS COMPELLING DIRECT COMMUNICATIONS BETWEEN THE PARTIES</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$brokersClaimClause}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['hiredCheck']))
                                                    @if($pipeline_details['formData']['hiredCheck']==true)
                                                        <?php $hiredCheck='Yes';?>
                                                    @else
                                                        <?php $hiredCheck='No';?>
                                                    @endif
                                                @endif
                                                @if($hiredWorkersDetails == 'Yes')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">EMPLOYMENT CLAUSE</label></div></td>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        <td class="main_answer"><div class="ans">{{@$hiredCheck}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true && isset($pipeline_details['formData']['rateRequiredAdmin']) && $pipeline_details['formData']['rateRequiredAdmin']!= '')
                                                    <tr>
                                                    <td><div class="main_question"><label class="form_label bold">RATE REQUIRED (ADMIN)</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['rateRequiredAdmin'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true && isset($pipeline_details['formData']['rateRequiredNonAdmin']) && $pipeline_details['formData']['rateRequiredNonAdmin']!= '')
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">RATE REQUIRED (NON-ADMIN)</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['rateRequiredNonAdmin'],2)}}</div></td>
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false && isset($pipeline_details['formData']['combinedRate']) && $pipeline_details['formData']['combinedRate']!= '')
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">COMBINED RATE</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['combinedRate'],2)}}</div></td>
                                                </tr>
                                                @endif
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">BROKERAGE</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['brokerage'],2)}}</div></td>
                                                </tr><tr>
                                                <td><div class="main_question"><label class="form_label bold">WARRANTY</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['warranty']?:'--'}}</div></td>
                                                </tr>
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">EXCLUSION</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['exclusion']?:'--'}}</div></td>
                                                </tr>
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">EXCESS</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['excess'],2)?:'--'}}</div></td>
                                                </tr>
                                                <tr>
                                                <td><div class="main_question"><label class="form_label bold">SPECIAL CONDITION</label></div></td>
                                                    <td class="main_answer"><div class="ans">{{$pipeline_details['formData']['specialCondition']?:'--'}}</div></td>
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

                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                    <div class="ans">
                                                                    <span id="div_extendedLiability_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                <input id='extendedLiability_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['extendedLiability']}}' required>
                                                                <label class='error' id='extendedLiability_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='extendedLiability' onclick='fun(this)'>Update</button>
                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='extendedLiability' onclick='cancel(this)'>
                                                                <i class='material-icons'>close</i></button>" data-container="body">{{number_format($insures_details[$i]['extendedLiability'],2)}}
                                                            </span>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                    <td>  <div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>

                                                @if($hiredWorkersDetails=='Yes')
                                                    <tr>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($hiredWorkersDetails=='No')
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['coverHiredWorkers']['isAgree']))
                                                                            @if(@$insures_details[$i]['coverHiredWorkers']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
            <span id="div_coverHiredWorkers_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
              data-content="<input id='coverHiredWorkers_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverHiredWorkers']['isAgree']}}'>
            <label class='error' id='coverHiredWorkers_{{$insures_details[$i]['uniqueToken']}}-error'></label>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='fun(this)'>Update</button>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
              data-container="body">{{@$insures_details[$i]['coverHiredWorkers']['isAgree']}}
            </span>
                                                                                 
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverHiredWorkers']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_coverHiredWorkers_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='coverHiredWorkers_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverHiredWorkers']['comment']}}'>
                                                                                                   <label class='error' id='coverHiredWorkers_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                   </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='commentEdit(this)'>Update</button>
                                                                                                   <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                        data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['coverHiredWorkers']['comment']}}"></i>
                                                                                </span> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_coverHiredWorkers_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                              title="Edit existing value" data-html="true" data-content="<input id='coverHiredWorkers_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverHiredWorkers']['isAgree']}}'>
            <label class='error' id='coverHiredWorkers_{{$insures_details[$i]['uniqueToken']}}-error'></label>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='fun(this)'>Update</button>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHiredWorkers' onclick='cancel(this)'>
            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['coverHiredWorkers']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($offShoreEmployeeDetails=='Yes')
                                                    <tr>
                                                        <?php $insure_count=count(@$insures_details);?>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                    <td>  <div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($offShoreEmployeeDetails=='No')
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['coverOffshore']['isAgree']))
                                                                            @if(@$insures_details[$i]['coverOffshore']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
            <span id="div_coverOffshore_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
              data-content="<input id='coverOffshore_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverOffshore']['isAgree']}}'>
            <label class='error' id='coverOffshore_{{$insures_details[$i]['uniqueToken']}}-error'></label>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='fun(this)'>Update</button>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
              data-container="body">{{@$insures_details[$i]['coverOffshore']['isAgree']}}
            </span>
                                                                                   
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverOffshore']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_coverOffshore_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                          data-content="<input id='coverOffshore_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverOffshore']['comment']}}'>
                                                                                     <label class='error' id='coverOffshore_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                     </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='commentEdit(this)'>Update</button>
                                                                                     <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                          data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['coverOffshore']['comment']}}"></i>
                                                                                </span> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_coverOffshore_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                              title="Edit existing value" data-html="true" data-content="<input id='coverOffshore_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['coverOffshore']['isAgree']}}'>
            <label class='error' id='coverOffshore_{{$insures_details[$i]['uniqueToken']}}-error'></label>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='fun(this)'>Update</button>
            <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverOffshore' onclick='cancel(this)'>
            <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['coverOffshore']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                        <td>  <div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($emergencyEvacuation == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($emergencyEvacuation=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['emergencyEvacuation']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans">
                                                                                <span id="div_emergencyEvacuation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='emergencyEvacuation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['emergencyEvacuation']}}' required><label class='error' id='emergencyEvacuation_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='emergencyEvacuation' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='emergencyEvacuation' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['emergencyEvacuation']}}</span>
                                                    </div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($empToEmpLiability == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($empToEmpLiability=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['empToEmpLiability']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                <div class="ans"><span id="div_empToEmpLiability_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='empToEmpLiability_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['empToEmpLiability']}}' required><label class='error' id='empToEmpLiability_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='empToEmpLiability' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='empToEmpLiability' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['empToEmpLiability']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($errorsOmissions == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($errorsOmissions=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['errorsOmissions']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">
                                                                                    <span id="div_errorsOmissions_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='errorsOmissions_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['errorsOmissions']}}' required><label class='error' id='errorsOmissions_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='errorsOmissions' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='errorsOmissions' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['errorsOmissions']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($crossLiability == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($crossLiability=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['crossLiability']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_crossLiability_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='crossLiability_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['crossLiability']}}' required><label class='error' id='crossLiability_{{$insures_details[$i]['uniqueToken']}}-error'></label><<button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='crossLiability' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['crossLiability']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($waiverOfSubrogation == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($waiverOfSubrogation=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['waiverOfSubrogation']['isAgree']))
                                                                            @if($insures_details[$i]['waiverOfSubrogation']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">
                                                                                    <span id="div_waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}'><label class='error' id='waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}
                                                                                    </span>
                                                                                   
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['waiverOfSubrogation']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                          data-content="<input id='waiverOfSubrogation_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['waiverOfSubrogation']['comment']}}'>
                                                                                     <label class='error' id='waiverOfSubrogation_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                     </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='commentEdit(this)'>Update</button>
                                                                                     <button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                          data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['waiverOfSubrogation']['comment']}}"></i>
                                                                                    </span>  --}}
                                                                                                                                                   </div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}'><label class='error' id='waiverOfSubrogation_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='waiverOfSubrogation' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($automaticClause == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($automaticClause=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['automaticClause']['isAgree']))
                                                                            @if($insures_details[$i]['automaticClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">
                                                                                    <span id="div_automaticClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='automaticClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['automaticClause']['isAgree']}}'><label class='error' id='automaticClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['automaticClause']['isAgree']}}
                                                                                    </span>
                                                                                 
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['automaticClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_automaticClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                          data-content="<input id='automaticClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['automaticClause']['comment']}}'>
                                                                                     <label class='error' id='automaticClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                     </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='commentEdit(this)'>Update</button>
                                                                                     <button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                          data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['automaticClause']['comment']}}"></i>
                                                                                    </span>                    --}}
                                                                                
                                                                                </div>                                                </td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_automaticClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='automaticClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['automaticClause']['isAgree']}}'><label class='error' id='automaticClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='automaticClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['automaticClause']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($cancellationClause == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($cancellationClause=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['cancellationClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_cancellationClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='cancellationClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['cancellationClause']}}' required><label class='error' id='cancellationClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='cancellationClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='cancellationClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['cancellationClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($indemnityToPrincipal == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($indemnityToPrincipal=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['indemnityToPrincipal']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_indemnityToPrincipal_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='indemnityToPrincipal_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['indemnityToPrincipal']}}' required><label class='error' id='indemnityToPrincipal_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='indemnityToPrincipal' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='indemnityToPrincipal' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['indemnityToPrincipal']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif

                                                @if($lossNotification == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($lossNotification=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['lossNotification']['isAgree']))
                                                                            @if($insures_details[$i]['lossNotification']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                                    <div class="ans">
                                                                                    <span id="div_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='lossNotification_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossNotification']['isAgree']}}'><label class='error' id='lossNotification_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['lossNotification']['isAgree']}}
                                                                                    </span>
                                                                                   
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['lossNotification']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                          data-content="<input id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossNotification']['comment']}}'>
                                                                                     <label class='error' id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                     </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentEdit(this)'>Update</button>
                                                                                     <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                          data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossNotification']['comment']}}"></i>
                                                                                </span> --}}
                                                                                    </div></td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='lossNotification_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossNotification']['isAgree']}}'><label class='error' id='lossNotification_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['lossNotification']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($primaryInsuranceClause == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($primaryInsuranceClause=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['primaryInsuranceClause']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['primaryInsuranceClause']}}' required><label class='error' id='primaryInsuranceClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryInsuranceClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='primaryInsuranceClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['primaryInsuranceClause']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($travelCover == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))

                                                                    @if($travelCover=='No')
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['travelCover']))
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_travelCover_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='travelCover_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['travelCover']}}' required><label class='error' id='travelCover_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='travelCover' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='travelCover' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['travelCover']}}</span></div></td>
                                                                        @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                        <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($riotCover == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($riotCover=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['riotCover']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_riotCover_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='riotCover_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['riotCover']}}' required><label class='error' id='riotCover_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='riotCover' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='riotCover' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['riotCover']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if($brokersClaimClause == 'Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($brokersClaimClause=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['brokersClaimClause']['isAgree']))
                                                                            @if($insures_details[$i]['brokersClaimClause']['comment']!="")
                                                                                <td class="tooltip_sec insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">
                                                                                    <span id="div_brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokersClaimClause']['isAgree']}}'><label class='error' id='brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['brokersClaimClause']['isAgree']}}</span>
                                                                                    
                                                                                          <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['brokersClaimClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                    <div class="media-right">
                                                                                                        <span id="cancel_brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='brokersClaimClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokersClaimClause']['comment']}}'>
                                                                                                   <label class='error' id='brokersClaimClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                   </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='commentEdit(this)'>Update</button>
                                                                                                   <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                        data-container="body">
                                                                                                            <button type="button">
                                                                                                                    <i class="material-icons">edit</i>
                                                                                                                </button>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['brokersClaimClause']['comment']}}"></i>
                                                                                    </span> --}}
                                                                                    </div>
                                                                                    </td>
                                                                            @else
                                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokersClaimClause']['isAgree']}}'><label class='error' id='brokersClaimClause_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokersClaimClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['brokersClaimClause']['isAgree']}}</span></div></td>
                                                                            @endif
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif

                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif


                                                @if($hiredWorkersDetails=='Yes')
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details))
                                                                    @if($hiredWorkersDetails=='No')
                                                                        <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                    @else
                                                                        @if(isset($insures_details[$i]['hiredCheck']))
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_hiredCheck_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='hiredCheck_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['hiredCheck']}}' required><label class='error' id='hiredCheck_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='hiredCheck' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='hiredCheck' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['hiredCheck']}}</span></div></td>
                                                                        @else
                                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                    @endif

                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                    <tr>
                                                        @if($insure_count==0)
                                                            @for ($i = 0; $i < $sel_insure_count; $i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < $total_insure_count; $i++)
                                                                @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['rateRequiredAdmin']))
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_rateRequiredAdmin_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='rateRequiredAdmin_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['rateRequiredAdmin']}}' required><label class='error' id='rateRequiredAdmin_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='rateRequiredAdmin' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='rateRequiredAdmin' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['rateRequiredAdmin']}}</span></div></td>
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['rateRequiredNonAdmin']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_rateRequiredNonAdmin_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='rateRequiredNonAdmin_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['rateRequiredNonAdmin']}}' required><label class='error' id='rateRequiredNonAdmin_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='rateRequiredNonAdmin' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='rateRequiredNonAdmin' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{number_format(@$insures_details[$i]['rateRequiredNonAdmin'],2)}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                @endif
                                                @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['combinedRate']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_combinedRate_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='combinedRate_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['combinedRate']}}' required><label class='error' id='combinedRate_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='combinedRate' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='combinedRate' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{number_format($insures_details[$i]['combinedRate'],2)}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif

                                                </tr>
                                                @endif
                                                 <tr>

                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_brokerage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='brokerage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokerage']}}' required><label class='error' id='brokerage_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{number_format($insures_details[$i]['brokerage'],2)}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr><tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['warranty']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_warranty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='warranty_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['warranty']}}' required><label class='error' id='warranty_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='warranty' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='warranty' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['warranty']}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['exclusion']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_exclusion_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='exclusion_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['exclusion']}}' required><label class='error' id='exclusion_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusion' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='exclusion' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['exclusion']}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['excess']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_excess_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='excess_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['excess']}}' required><label class='error' id='excess_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='excess' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='excess' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{number_format($insures_details[$i]['excess'],2)}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td><div class="ans">--</div></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details) && isset($insures_details[$i]['specialCondition']))
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}"><div class="ans"><span id="div_specialCondition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="<input id='specialCondition_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['specialCondition']}}' required><label class='error' id='specialCondition_{{$insures_details[$i]['uniqueToken']}}-error'></label><button name='{{$insures_details[$i]['uniqueToken']}}' value='specialCondition' onclick='fun(this)'>Update</button><button name='{{$insures_details[$i]['uniqueToken']}}' value='specialCondition' onclick='cancel(this)'><i class='material-icons'>close</i></button>" data-container="body">{{$insures_details[$i]['specialCondition']}}</span></div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
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
                            window.location.href = "{{url('employer/imported-list')}}";
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
                            window.location.href = '{{url('employer/e-comparison/'.$pipeline_details->_id)}}';
                        }
                    }
                });
            }
        });
        //end//

        function color_change_table(col_name)
        {

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
                $.each(values , function (index , value) {
                    var col_name ='insure_check_'+value;
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
            var token = obj.name;
            var field = obj.value;
            var new_quot = $('#'+field+'_'+token+'').val();
            var id = $('#pipeline_id').val();
            if(new_quot!="")
            {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('quot-amend')}}',
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
                    url: '{{url('quot-amend')}}',
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
