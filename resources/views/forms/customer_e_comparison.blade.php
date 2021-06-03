
@extends('layouts.customer')
@include('includes.loader')
@section('content')
    <main class="layout_content">

        <!-- Main Content -->
        <div class="page_content">
            <div class="section_details">
                <div class="card_content">
                    <div class="edit_sec clearfix">

                        <div class="customer_header clearfix">
                            <div class="customer_logo">
                                <img src="{{URL::asset('img/main/interactive_logo.png')}}">
                            </div>
                            <h2>Proposal for Workman’s Compensation</h2>
                            <table class="customer_info table table-bordered" style="border: black solid">
                                <tr>
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Prepared for : <b>{{$pipeline_details['customer']['name']}}</b></p></td>
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Customer ID : <b>{{$pipeline_details['customer']['customerCode']}}</b></p></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Prepared by : <b>INTERACTIVE Insurance Brokers LLC</b></p></td>
                                    @if(isset($pipeline_details['comparisonToken']['date']))
                                        <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Date : <b>{{$pipeline_details['comparisonToken']['date']}}</b></p></td>
                                    @else
                                        <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Date : <b>{{date('d/m/Y')}}</b></p></td>
                                    @endif
                                    <td height="20" style="border-right: 1px solid #ddd"><p style="font-size: 15px">Document ID : <b>{{$pipeline_details['refereneceNumber']}} –
                                                @if(isset($pipeline_details['documentNo']))
                                                    R{{$pipeline_details['documentNo']}}
                                                @else
                                                    R0
                                                @endif
                                            </b></p></td>
                                </tr>
                            </table>
                        </div>
                        <div style="height: 50px"></div>
                        <input type="hidden" id="count" value="{{count($selectedId)}}">

                        <div class="data_table compare_sec">
                            <div id="admin">
                                <form id="approve_form" name="approve_form" method="post">
                                    {{csrf_field()}}
                                    <input class="not_hidden" type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">

                                <div class="material-table">


                                    <div class="table_fixed height_fix common_fix">
                                        <div class="table_sep_fix">
                                            <div class="material-table table-responsive" style="border-bottom: none;overflow: hidden">
                                                <table class="table table-bordered"  style="border-bottom: none">
                                                    <thead>
                                                    <tr>
                                                        <th><div class="main_question">Questions</div></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="border-bottom: none" class="syncscroll"  name="myElements">
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Scale of Compensation /Limit of Indemnity</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Medical Expense (In AED)</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person</label></div></td>
                                                    </tr>
                                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">COVER FOR HIRED WORKERS OR CASUAL LABOURS</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEES</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['HoursPAC']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['herniaCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for hernia, heat/sun stroke, muscle spasm, lumbago related to work</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Emergency evacuation</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['legalCost']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Including Legal and Defence cost</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['empToEmpLiability']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Employee to employee liability </label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['errorsOmissions']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">ERRORS & OMISSIONS</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['crossLiability']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">CROSS LIABILITY</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                    {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></div></td>
                                                        </tr>
                                                    {{-- @endif --}}
                                                    @endif
                                                    @if($pipeline_details['formData']['automaticClause']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['flightCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">COVER FOR INSURED’S EMPLOYEES ON EMPLOYMENT VISAS WHILST ON INCOMING AND OUTGOING FLIGHTS TO/FROM UAE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['diseaseCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">COVER FOR OCCUPATIONAL/ INDUSTRIAL DISEASE AS PER LABOUR LAW</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['cancellationClause']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">CANCELLATION CLAUSE-30 DAYS BY EITHER SIDE ON PRO-RATA</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                    @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">INDEMNITY TO PRINCIPAL</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @endif
                                                    @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">INCLUDING WORK RELATED ACCIDENTS AND BODILY INJURIES DURING OVERTIME WORK, NIGHT SHIFTS, WORK ON PUBLIC HOLIDAYS AND WEEK-ENDS.</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['lossNotification']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">LOSS NOTIFICATION – ‘AS SOON AS REASONABLY PRACTICABLE’</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">PRIMARY INSURANCE CLAUSE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['travelCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">TRAVELLING TO AND FROM WORKPLACE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['riotCover']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">RIOT, STRIKES, CIVIL COMMOTION AND PASSIVE WAR RISK</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['brokersClaimClause']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">BROKERS CLAIM HANDLING CLAUSE : A LOSS NOTIFICATION RECEIVED BY THE INSURANCE BROKER WILL BE DEEMED AS A LOSS NOTIFICATION TO INSURER. ALL COMMUNICATIONS FLOWING BETWEEN THE INSURER, INSURED AND THE APPOINTED LOSS SURVEYOR SHOULD BE CHANNELIZED THROUGH THE BROKER, UNLESS THERE IS ANY UNAVOIDABLE REASONS COMPELLING DIRECT COMMUNICATIONS BETWEEN THE PARTIES</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">EMPLOYMENT CLAUSE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEE</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">RATE (ADMIN)</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">RATE (NON-ADMIN)</label></div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">COMBINED RATE</label></div></td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">WARRANTY</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">EXCLUSION</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">SPECIAL CONDITION</label></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">YOUR DECISION  <span>*</span></label><div class="height_align" style="display: none"></div></div></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="table_sep_pen">
                                            <div class="material-table table-responsive">
                                                <table class="table comparison table-bordered" style="table-layout: auto">
                                                    <thead>
                                                    <tr>

	                                                    <?php $selected_insures_count=count(@$selectedId);?>
	                                                    <?php $insure_count=count(@$insures_details);?>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))  <th>


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
                                                                            <div class="ans">  <span data-toggle="tooltip" data-placement="right" title="{{$insures_details[$i]['insurerDetails']['insurerName']}}" data-container="body">{{substr(ucfirst($insures_details[$i]['insurerDetails']['insurerName']), 0, 32).$dot}}</span></div>
                                                                    @else
                                                                                    <div class="ans">   <span>{{$insures_details[$i]['insurerDetails']['insurerName']}}</span></div>
                                                                    @endif

                                                                </th> @endif
                                                        @endfor
                                                    </tr>
                                                    </thead>
                                                    <tbody class="syncscroll"  name="myElements">
                                                    <tr>
                                                        @if(isset($pipeline_details['formData']['scaleOfCompensation']))
                                                            @if($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw']==true)
			                                                    <?php $scale='As per UAE Labour Law';?>
                                                            @elseif($pipeline_details['formData']['scaleOfCompensation']['isPTD']==true)
			                                                    <?php $scale='Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';?>
                                                            @endif
                                                        @endif
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    <td><div class="ans">{{$insures_details[$i]['scaleOfCompensation']}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">{{number_format($insures_details[$i]['extendedLiability'],2)}}</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">@if(is_numeric($insures_details[$i]['medicalExpense'])==true){{number_format($insures_details[$i]['medicalExpense'])}} @else {{$insures_details[$i]['medicalExpense']}} @endif</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">@if(is_numeric($insures_details[$i]['repatriationExpenses'])==true){{number_format($insures_details[$i]['repatriationExpenses'])}} @else {{$insures_details[$i]['repatriationExpenses']}}@endif</div></td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                                        <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['coverHiredWorkers']['comment']))
                                                                        @if($insures_details[$i]['coverHiredWorkers']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverHiredWorkers']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverHiredWorkers']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['coverHiredWorkers']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['coverHiredWorkers']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                                        <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['coverOffshore']['comment']))
                                                                        @if($insures_details[$i]['coverOffshore']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverOffshore']['isAgree']}}</span>
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['coverOffshore']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['coverOffshore']['comment']}}"></i> --}}
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['coverOffshore']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['HoursPAC']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['HoursPAC']))
                                                                @if($pipeline_details['formData']['HoursPAC']==true)
                                                                    <?php $HoursPAC='Yes';?>
                                                                @else
                                                                    <?php $HoursPAC='No';?>
                                                                @endif
                                                            @endif
                                                            @if($HoursPAC=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['HoursPAC']['comment']))
                                                                            @if($insures_details[$i]['HoursPAC']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['HoursPAC']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['HoursPAC']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['HoursPAC']['comment']}}"></i> --}}
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['HoursPAC']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['herniaCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['herniaCover']))
                                                                @if($pipeline_details['formData']['herniaCover']==true)
                                                                    <?php $herniaCover='Yes';?>
                                                                @else
                                                                    <?php $herniaCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($herniaCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['herniaCover']['comment']))
                                                                            @if($insures_details[$i]['herniaCover']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['herniaCover']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['herniaCover']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['herniaCover']['comment']}}"></i> --}}
                                                                                    </div>  </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['herniaCover']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif

                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['emergencyEvacuation']))
                                                                @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                                                    <?php $emergencyEvacuation='Yes';?>
                                                                @else
                                                                    <?php $emergencyEvacuation='No';?>
                                                                @endif
                                                            @endif
                                                            @if($emergencyEvacuation=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['emergencyEvacuation']))
                                                                            <td><div class="ans">{{$insures_details[$i]['emergencyEvacuation']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['legalCost']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['legalCost']))
                                                                @if($pipeline_details['formData']['legalCost']==true)
                                                                    <?php $legalCost='Yes';?>
                                                                @else
                                                                    <?php $legalCost='No';?>
                                                                @endif
                                                            @endif
                                                            @if($legalCost=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['legalCost']))
                                                                            <td><div class="ans">{{$insures_details[$i]['legalCost']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['empToEmpLiability']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['empToEmpLiability']))
                                                                @if($pipeline_details['formData']['empToEmpLiability']==true)
                                                                    <?php $empToEmpLiability='Yes';?>
                                                                @else
                                                                    <?php $empToEmpLiability='No';?>
                                                                @endif
                                                            @endif
                                                            {{--<td class="main_answer">{{$empToEmpLiability}}</td>--}}
                                                            @if($empToEmpLiability=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['empToEmpLiability']))
                                                                            <td><div class="ans">{{$insures_details[$i]['empToEmpLiability']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['errorsOmissions']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['errorsOmissions']))
                                                                @if($pipeline_details['formData']['errorsOmissions']==true)
                                                                    <?php $errorsOmissions='Yes';?>
                                                                @else
                                                                    <?php $errorsOmissions='No';?>
                                                                @endif
                                                            @endif
                                                            @if($errorsOmissions=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['errorsOmissions']))
                                                                            <td><div class="ans">{{$insures_details[$i]['errorsOmissions']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['crossLiability']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['crossLiability']))
                                                                @if($pipeline_details['formData']['crossLiability']==true)
                                                                    <?php $crossLiability='Yes';?>
                                                                @else
                                                                    <?php $crossLiability='No';?>
                                                                @endif
                                                            @endif
                                                            @if($crossLiability=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['crossLiability']))
                                                                            <td><div class="ans">{{$insures_details[$i]['crossLiability']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                    {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                                {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                                                    <?php $waiverOfSubrogation='Yes';?>
                                                                {{-- @else
                                                                @endif --}}
                                                            @endif
                                                            {{--<td class="main_answer">{{$waiverOfSubrogation}}</td>--}}
                                                            @if($waiverOfSubrogation=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['waiverOfSubrogation']))

                                                                            @if($insures_details[$i]['waiverOfSubrogation']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['waiverOfSubrogation']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['waiverOfSubrogation']['comment']}}"></i> --}}
                                                                                    </div></td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['waiverOfSubrogation']['isAgree']}}</div></td>
                                                                            @endif

                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    {{-- @endif --}}
                                                    @endif
                                                    @if($pipeline_details['formData']['automaticClause']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['automaticClause']))
                                                                @if($pipeline_details['formData']['automaticClause']==true)
                                                                    <?php $automaticClause='Yes';?>
                                                                @else
                                                                    <?php $automaticClause='No';?>
                                                                @endif
                                                            @endif
                                                            {{--<td class="main_answer">{{$automaticClause}}</td>--}}
                                                            @if($automaticClause=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['automaticClause']['comment']))

                                                                            @if($insures_details[$i]['automaticClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['automaticClause']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['automaticClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['automaticClause']['comment']}}"></i> --}}
                                                                                    </div> </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['automaticClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['flightCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['flightCover']))
                                                                @if($pipeline_details['formData']['flightCover']==true)
                                                                    <?php $flightCover='Yes';?>
                                                                @else
                                                                    <?php $flightCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($flightCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['flightCover']))
                                                                            <td><div class="ans">{{$insures_details[$i]['flightCover']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['diseaseCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['diseaseCover']))
                                                                @if($pipeline_details['formData']['diseaseCover']==true)
                                                                    <?php $diseaseCover='Yes';?>
                                                                @else
                                                                    <?php $diseaseCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($diseaseCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['diseaseCover']))
                                                                            <td><div class="ans">{{$insures_details[$i]['diseaseCover']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['cancellationClause']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['cancellationClause']))
                                                                @if($pipeline_details['formData']['cancellationClause']==true)
                                                                    <?php $cancellationClause='Yes';?>
                                                                @else
                                                                    <?php $cancellationClause='No';?>
                                                                @endif
                                                            @endif
                                                            @if($cancellationClause=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['cancellationClause']))
                                                                            <td><div class="ans">{{$insures_details[$i]['cancellationClause']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                    @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                                @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                                                    <?php $indemnityToPrincipal='Yes';?>
                                                                @else
                                                                    <?php $indemnityToPrincipal='No';?>
                                                                @endif
                                                            @endif
                                                            @if($indemnityToPrincipal=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['indemnityToPrincipal']))
                                                                            <td><div class="ans">{{$insures_details[$i]['indemnityToPrincipal']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @endif
                                                    @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['overtimeWorkCover']))
                                                                @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                                                    <?php $overtimeWorkCover='Yes';?>
                                                                @else
                                                                    <?php $overtimeWorkCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($overtimeWorkCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['overtimeWorkCover']))
                                                                            <td><div class="ans">{{$insures_details[$i]['overtimeWorkCover']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['lossNotification']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['lossNotification']))
                                                                @if($pipeline_details['formData']['lossNotification']==true)
                                                                    <?php $lossNotification='Yes';?>
                                                                @else
                                                                    <?php $lossNotification='No';?>
                                                                @endif
                                                            @endif
                                                            @if($lossNotification=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['lossNotification']))

                                                                            @if($insures_details[$i]['lossNotification']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['lossNotification']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['lossNotification']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossNotification']['comment']}}"></i> --}}
                                                                                    </div></td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['lossNotification']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['primaryInsuranceClause']))
                                                                @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                                                    <?php $primaryInsuranceClause='Yes';?>
                                                                @else
                                                                    <?php $primaryInsuranceClause='No';?>
                                                                @endif
                                                            @endif
                                                            @if($primaryInsuranceClause=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['primaryInsuranceClause']))
                                                                            <td><div class="ans">{{$insures_details[$i]['primaryInsuranceClause']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['travelCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['travelCover']))
                                                                @if($pipeline_details['formData']['travelCover']==true)
                                                                    <?php $travelCover='Yes';?>
                                                                @else
                                                                    <?php $travelCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($travelCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['travelCover']))
                                                                            <td><div class="ans">{{$insures_details[$i]['travelCover']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['riotCover']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['riotCover']))
                                                                @if($pipeline_details['formData']['riotCover']==true)
                                                                    <?php $riotCover='Yes';?>
                                                                @else
                                                                    <?php $riotCover='No';?>
                                                                @endif
                                                            @endif
                                                            @if($riotCover=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['riotCover']))
                                                                            <td><div class="ans">{{$insures_details[$i]['riotCover']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['brokersClaimClause']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['brokersClaimClause']))
                                                                @if($pipeline_details['formData']['brokersClaimClause']==true)
                                                                    <?php $brokersClaimClause='Yes';?>
                                                                @else
                                                                    <?php $brokersClaimClause='No';?>
                                                                @endif
                                                            @endif
                                                            @if($brokersClaimClause=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['brokersClaimClause']))
                                                                            @if($insures_details[$i]['brokersClaimClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['brokersClaimClause']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['brokersClaimClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['brokersClaimClause']['comment']}}"></i> --}}
                                                                                    </div></td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['brokersClaimClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['hiredCheck']))
                                                                @if($pipeline_details['formData']['hiredCheck']==true)
				                                                    <?php $hiredCheck='Yes';?>
                                                                @else
				                                                    <?php $hiredCheck='No';?>
                                                                @endif
                                                            @endif
                                                            @if($hiredCheck=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['hiredCheck']))
                                                                            <td><div class="ans">{{$insures_details[$i]['hiredCheck']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        @endif
                                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                                        <tr>
                                                            @if(isset($pipeline_details['formData']['offshoreCheck']))
                                                                @if($pipeline_details['formData']['offshoreCheck']==true)
				                                                    <?php $offshoreCheck='Yes';?>
                                                                @else
				                                                    <?php $offshoreCheck='No';?>
                                                                @endif
                                                            @endif
                                                            @if($offshoreCheck=='Yes')
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['offshoreCheck']))
                                                                            <td><div class="ans">{{$insures_details[$i]['offshoreCheck']}}</div></td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            @else
                                                                @for($j=0;$j<$selected_insures_count;$j++)
                                                                    <td><div class="ans">--</div></td>
                                                                @endfor
                                                            @endif
                                                        </tr>
                                                        @endif
                                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                        <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['rateRequiredAdmin']))
                                                                        <td><div class="ans">{{number_format($insures_details[$i]['rateRequiredAdmin'],2)}}</div></td>
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['sepOrCom']) && $pipeline_details['formData']['sepOrCom']==true)
                                                        <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['rateRequiredNonAdmin']))
                                                                        <td><div class="ans">{{number_format($insures_details[$i]['rateRequiredNonAdmin'],2)}}</div></td>
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                                    <tr>
	                                                    <?php $insure_count=count(@$insures_details);?>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['combinedRate']))
                                                                        <td><div class="ans">{{number_format($insures_details[$i]['combinedRate'],2)}}</div></td>
                                                                @else
                                                                        <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['warranty']))
                                                                    <td><div class="ans">{{$insures_details[$i]['warranty']}}</div></td>
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['exclusion']))
                                                                    <td><div class="ans">{{$insures_details[$i]['exclusion']}}</div></td>
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['specialCondition']))
                                                                    <td><div class="ans">{{$insures_details[$i]['specialCondition']}}</div></td>
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                <td><div class="ans">
                                                                    <textarea class="form_input {{$insures_details[$i]['uniqueToken']}}" name="text_{{$insures_details[$i]['uniqueToken']}}" placeholder="Comments..." id="{{$insures_details[$i]['uniqueToken']}}"></textarea>
                                                                    <div class="form_group">
                                                                        <div class="cntr">
                                                                            <label for="approve_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Approved" id="approve_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="checkApprove(this)">
                                                                                <span class="label"></span>
                                                                                <span>Approve</span>
                                                                            </label>
                                                                            <label for="reject_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Rejected" id="reject_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="notApprove(this)">
                                                                                <span class="label"></span>
                                                                                <span>Reject</span>
                                                                            </label>
                                                                            <label for="amend_{{$insures_details[$i]['uniqueToken']}}" class="radio {{$insures_details[$i]['uniqueToken']}}">
                                                                                <input type="radio" name="{{$insures_details[$i]['uniqueToken']}}" value="Requested for amendment" id="amend_{{$insures_details[$i]['uniqueToken']}}" class="hidden {{$insures_details[$i]['uniqueToken']}}" onchange="notApprove(this)">
                                                                                <span class="label"></span>
                                                                                <span>Amend</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reason_show" id="select_reson_{{$insures_details[$i]['uniqueToken']}}" style="display:none">
                                                                            <label class="form_label">Select reason <span>*</span></label>
                                                                            <div class="custom_select">
                                                                                    <select class="form_input process" name="reason_{{$insures_details[$i]['uniqueToken']}}" id="process_drop_{{$insures_details[$i]['uniqueToken']}}" onchange="messageCheck(this)">
                                                                                        <option value="">Select reason</option>
                                                                                        <option value="Another insurance company required">Another insurance company required </option>
                                                                                        <option value="Close the case">Close the case </option>                                                                                      
                                                                                    </select>
                                                                            </div>
                                                                            <label id="process_drop_{{$insures_details[$i]['uniqueToken']}}-error" class="error" for="process_drop_{{$insures_details[$i]['uniqueToken']}}" style="display:none">Please select this field</label>
                                                                     </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                    <label id="decision-error" class="error pull-right" style="display: none;width: 100%;margin: 8px 0;">Please select a decision.</label>
                                    <div class="clearfix" style="margin-top: 20px;">

                                        <button class="btn btn-primary pull-right" type="button" onclick="formSubmit()">Proceed</button>

                                        <p style="float: left;width: 80%;font-size: 13px;font-weight: 500;line-height: 17px;font-style: italic;margin: 4px 0;">IMPORTANT: This document is the property of INTERACTIVE Insurance Brokers LLC, Dubai and is
                                            strictly confidential to its recipients. The document should not be copied, distributed or
                                            reproduced in whole or in part, nor passed to any third party without the consent of its owner.
                                        </p>
                                    </div>
                                </form>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .section_details{
            max-width: 100%;
        }
        .material-table table.comparison th{
            width: 310px;
        }
        .page_content {
            top: 0px;
            height: 100%;
        }
        .radio .label {
            width: 17px;
            height: 17px;
            margin-top: 2px;
        }
        .radio .label:after {
            width: 7px;
            height: 7px;
        }
        .cntr span:last-child{
            font-size: 12px;
        }
        .section_details .card_content {
            padding: 20px;
            margin-bottom: 0;
        }
        .height_fix tbody {
            height: calc(100vh - 362px);
        }
    </style>

@endsection
@push('scripts')
    {{--JQUERY VALIDATOR--}}
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/custom-select.js')}}"></script>

    <script>
        var flag = 0;
        $(document).ready(function(){
            $('#btn_reject').on('click', function(){
                $('#preLoader').show();
            });
        });
        
        function checkApprove(obj)
        {
            jQuery("input, textarea")
                .not("."+obj.name)
                .not(".not_hidden")
                .removeAttr("checked", "checked").attr("disabled", "disabled");
            $('#decision-error').hide();
            flag = 1;
            $('#select_reson_'+obj.name).hide();
            $('.height_align').hide();
            $('#process_drop_'+obj.name).attr("required",false);
            $('.process').prop("required",false);
        }
        function messageCheck(obj1)
        {
           var  valueExist=obj1.value;
            if(valueExist == ''){
                $('#'+obj1.id+'-error').show();
            }else{
                $('#'+obj1.id+'-error').hide();
            }
        }
        function notApprove(obj) {
            if(obj.value=='Rejected')
            {
                $('#select_reson_'+obj.name).show();
                $('.height_align').show();
                $('#process_drop_'+obj.name).attr("required",true);   
            }else{
                $('#select_reson_'+obj.name).hide();
                $('.height_align').hide();
                $('#process_drop_'+obj.name).attr("required",false);
            }
            jQuery("input, textarea")
                .removeAttr("disabled", "disabled");
            var count = $('#count').val();
            if($('input[type=radio]:checked').length==count)
            {
                $('#decision-error').hide();
            }
        }
        $('#approve_form').validate({
            ignore:[],
            rules:{},
            submitHandler: function (form,event) {
                var form_data = new FormData($("#approve_form")[0]);
                form_data.append('_token',"{{csrf_token()}}");
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('customer-save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success:function (data) {
                        if(data == 'success')
                        {
                            location.href = "{{url('customer-notification')}}";
                        }
                    }
                });
            }
        });
        function formSubmit()
        {
            if(flag == 0)
            {
                var count = $('#count').val();
                if($('input[type=radio]:checked').length==count)
                {
                    $('#approve_form').submit();
                }
                else
                {
                    $('#decision-error').show();
                }
            }
            else if(flag == 1)
            {
                $('#approve_form').submit();
            }
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
        $.validator.messages.required = "Please select the reason";

    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
