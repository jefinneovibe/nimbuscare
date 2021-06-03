@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Workmans Compensation</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table">
                            <div class="table-header">
                                <span class="table-title">Policy Details</span>
                            </div>
                            <div class="" style="margin-bottom: 20px">
                                <table class="comparison table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 100%" colspan="2">Selected Insurer : <b>{{$insures_details['insurerDetails']['insurerName']}}</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">Scale of Compensation /Limit of Indemnity</label></td>
                                        @if(isset($pipeline_details['formData']['scaleOfCompensation']))
                                            @if($pipeline_details['formData']['scaleOfCompensation']['asPerUAELaw']==true)
												<?php $scale='As per UAE Labour Law';?>
                                            @elseif($pipeline_details['formData']['scaleOfCompensation']['isPTD']==true)
												<?php $scale='Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more';?>
                                            @endif
                                        @endif
                                        {{--<td class="main_answer">{{$scale}}</td>--}}
                                        <td>{{$insures_details['scaleOfCompensation']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['extendedLiability']}}</td>--}}
                                        <td>{{$insures_details['extendedLiability']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">Medical Expense (In AED) </label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['medicalExpense']}}</td>--}}
                                        <td>@if(is_numeric($insures_details['medicalExpense'])==true) {{number_format($insures_details['medicalExpense'])}} @else {{$insures_details['medicalExpense']}}@endif{{$insures_details['medicalExpense']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person </label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['repatriationExpenses']}}</td>--}}
                                        <td>@if(is_numeric($insures_details['repatriationExpenses'])==true) {{number_format($insures_details['repatriationExpenses'])}} @else {{$insures_details['repatriationExpenses']}}@endif</td>
                                    </tr>
                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">COVER FOR HIRED WORKERS OR CASUAL LABOURS</label></div></td>
                                            @if(isset($insures_details['coverHiredWorkers']['comment']))
                                            @if($insures_details['coverHiredWorkers']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['coverHiredWorkers']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['coverHiredWorkers']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverHiredWorkers']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['coverHiredWorkers']['isAgree']}}</td>
                                            @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEES</label></div></td>
                                            @if(isset($insures_details['coverOffshore']['comment']))
                                            @if($insures_details['coverOffshore']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['coverOffshore']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['coverOffshore']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverOffshore']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['coverOffshore']['isAgree']}}</td>
                                            @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['HoursPAC']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">
                                                    24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law
                                                </label></td>
                                            @if(isset($pipeline_details['formData']['HoursPAC']))
                                                @if($pipeline_details['formData']['HoursPAC']==true)
													<?php $HoursPAC='Yes';?>
                                                @else
													<?php $HoursPAC='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$HoursPAC}}</td>--}}
                                            @if($HoursPAC=='Yes')
                                                @if(isset($insures_details['HoursPAC']['isAgree']))
                                                    @if($insures_details['HoursPAC']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['HoursPAC']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['HoursPAC']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['HoursPAC']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['HoursPAC']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['herniaCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work</label></td>
                                            @if(isset($pipeline_details['formData']['herniaCover']))
                                                @if($pipeline_details['formData']['herniaCover']==true)
													<?php $herniaCover='Yes';?>
                                                @else
													<?php $herniaCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$herniaCover}}</td>--}}
                                            @if($herniaCover=='Yes')
                                                @if(isset($insures_details['herniaCover']['comment']))
                                                    @if($insures_details['herniaCover']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['herniaCover']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['herniaCover']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['herniaCover']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['herniaCover']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label">
                                                    Emergency evacuation
                                                </label></td>
                                            @if(isset($pipeline_details['formData']['emergencyEvacuation']))
                                                @if($pipeline_details['formData']['emergencyEvacuation']==true)
													<?php $emergencyEvacuation='Yes';?>
                                                @else
													<?php $emergencyEvacuation='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$emergencyEvacuation}}</td>--}}
                                            @if($emergencyEvacuation=='Yes')
                                                @if(isset($insures_details['emergencyEvacuation']))
                                                    <td>{{$insures_details['emergencyEvacuation']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['legalCost']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Including Legal and Defence cost </label></td>
                                            @if(isset($pipeline_details['formData']['legalCost']))
                                                @if($pipeline_details['formData']['legalCost']==true)
													<?php $legalCost='Yes';?>
                                                @else
													<?php $legalCost='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$legalCost}}</td>--}}

                                            @if($legalCost=='Yes')
                                                @if(isset($insures_details['legalCost']))
                                                    <td>{{$insures_details['legalCost']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['empToEmpLiability']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Employee to employee liability </label></td>
                                            @if(isset($pipeline_details['formData']['empToEmpLiability']))
                                                @if($pipeline_details['formData']['empToEmpLiability']==true)
													<?php $empToEmpLiability='Yes';?>
                                                @else
													<?php $empToEmpLiability='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$empToEmpLiability}}</td>--}}
                                            @if($empToEmpLiability=='Yes')
                                                @if(isset($insures_details['empToEmpLiability']))
                                                    <td>{{$insures_details['empToEmpLiability']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['errorsOmissions']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">ERRORS & OMISSIONS</label></td>
                                            @if(isset($pipeline_details['formData']['errorsOmissions']))
                                                @if($pipeline_details['formData']['errorsOmissions']==true)
													<?php $errorsOmissions='Yes';?>
                                                @else
													<?php $errorsOmissions='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$errorsOmissions}}</td>--}}

                                            @if($errorsOmissions=='Yes')
                                                @if(isset($insures_details['errorsOmissions']))
                                                    <td>{{$insures_details['errorsOmissions']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif

                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['crossLiability']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">CROSS LIABILITY</label></td>
                                            @if(isset($pipeline_details['formData']['crossLiability']))
                                                @if($pipeline_details['formData']['crossLiability']==true)
													<?php $crossLiability='Yes';?>
                                                @else
													<?php $crossLiability='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$crossLiability}}</td>--}}

                                            @if($crossLiability=='Yes')
                                                @if(isset($insures_details['crossLiability']))
                                                    <td>{{$insures_details['crossLiability']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                    {{-- @if($pipeline_details['formData']['waiverOfSubrogation']==true) --}}
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></td>
                                            @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
													<?php $waiverOfSubrogation='Yes';?>
                                            @endif
                                            {{--<td class="main_answer">{{$waiverOfSubrogation}}</td>--}}
                                            @if($waiverOfSubrogation=='Yes')
                                                @if(isset($insures_details['waiverOfSubrogation']['isAgree']))
                                                    @if($insures_details['waiverOfSubrogation']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['waiverOfSubrogation']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['waiverOfSubrogation']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['waiverOfSubrogation']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['waiverOfSubrogation']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                        {{-- @endif --}}
                                    @endif
                                    @if($pipeline_details['formData']['automaticClause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></td>
                                            @if(isset($pipeline_details['formData']['automaticClause']))
                                                @if($pipeline_details['formData']['automaticClause']==true)
													<?php $automaticClause='Yes';?>
                                                @else
													<?php $automaticClause='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$automaticClause}}</td>--}}
                                            @if($automaticClause=='Yes')
                                                @if(isset($insures_details['automaticClause']['isAgree']))
                                                    @if($insures_details['automaticClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['automaticClause']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['automaticClause']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['automaticClause']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['flightCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">COVER FOR INSURED’S EMPLOYEES ON EMPLOYMENT VISAS WHILST ON INCOMING AND OUTGOING FLIGHTS TO/FROM UAE</label></td>
                                            @if(isset($pipeline_details['formData']['flightCover']))
                                                @if($pipeline_details['formData']['flightCover']==true)
													<?php $flightCover='Yes';?>
                                                @else
													<?php $flightCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$flightCover}}</td>--}}

                                            @if($flightCover=='Yes')
                                                @if(isset($insures_details['flightCover']))
                                                    <td>{{$insures_details['flightCover']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['diseaseCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">COVER FOR OCCUPATIONAL/ INDUSTRIAL DISEASE AS PER LABOUR LAW</label></td>
                                            @if(isset($pipeline_details['formData']['diseaseCover']))
                                                @if($pipeline_details['formData']['diseaseCover']==true)
													<?php $diseaseCover='Yes';?>
                                                @else
													<?php $diseaseCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$diseaseCover}}</td>--}}

                                            @if($diseaseCover=='Yes')
                                                @if(isset($insures_details['diseaseCover']))
                                                    <td>{{$insures_details['diseaseCover']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['cancellationClause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">CANCELLATION CLAUSE-30 DAYS BY EITHER SIDE ON PRO-RATA</label></td>
                                            @if(isset($pipeline_details['formData']['cancellationClause']))
                                                @if($pipeline_details['formData']['cancellationClause']==true)
													<?php $cancellationClause='Yes';?>
                                                @else
													<?php $cancellationClause='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$cancellationClause}}</td>--}}
                                            @if($cancellationClause=='Yes')
                                                @if(isset($insures_details['cancellationClause']))
                                                    <td>{{$insures_details['cancellationClause']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if(isset($pipeline_details['formData']['indemnityToPrincipal']))

                                        @if($pipeline_details['formData']['indemnityToPrincipal']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">INDEMNITY TO PRINCIPAL</label></td>
                                            @if(isset($pipeline_details['formData']['indemnityToPrincipal']))
                                                @if($pipeline_details['formData']['indemnityToPrincipal']==true)
													<?php $indemnityToPrincipal='Yes';?>
                                                @else
													<?php $indemnityToPrincipal='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$indemnityToPrincipal}}</td>--}}
                                            @if($indemnityToPrincipal=='Yes')
                                                @if(isset($insures_details['indemnityToPrincipal']))
                                                    <td>{{$insures_details['indemnityToPrincipal']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                            @endif
                                    @endif
                                    @if($pipeline_details['formData']['overtimeWorkCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">INCLUDING WORK RELATED ACCIDENTS AND BODILY INJURIES DURING OVERTIME WORK, NIGHT SHIFTS, WORK ON PUBLIC HOLIDAYS AND WEEK-ENDS.</label></td>
                                            @if(isset($pipeline_details['formData']['overtimeWorkCover']))
                                                @if($pipeline_details['formData']['overtimeWorkCover']==true)
													<?php $overtimeWorkCover='Yes';?>
                                                @else
													<?php $overtimeWorkCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$overtimeWorkCover}}</td>--}}

                                            @if($overtimeWorkCover=='Yes')
                                                @if(isset($insures_details['overtimeWorkCover']))
                                                    <td>{{$insures_details['overtimeWorkCover']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['lossNotification']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">LOSS NOTIFICATION – ‘AS SOON AS REASONABLY PRACTICABLE’</label></td>
                                            @if(isset($pipeline_details['formData']['lossNotification']))
                                                @if($pipeline_details['formData']['lossNotification']==true)
													<?php $lossNotification='Yes';?>
                                                @else
													<?php $lossNotification='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$lossNotification}}</td>--}}
                                            @if($lossNotification=='Yes')
                                                @if(isset($insures_details['lossNotification']['isAgree']))
                                                    @if($insures_details['lossNotification']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['lossNotification']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['lossNotification']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['lossNotification']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['lossNotification']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['primaryInsuranceClause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">PRIMARY INSURANCE CLAUSE</label></td>
                                            @if(isset($pipeline_details['formData']['primaryInsuranceClause']))
                                                @if($pipeline_details['formData']['primaryInsuranceClause']==true)
													<?php $primaryInsuranceClause='Yes';?>
                                                @else
													<?php $primaryInsuranceClause='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$primaryInsuranceClause}}</td>--}}

                                            @if($primaryInsuranceClause=='Yes')
                                                @if(isset($insures_details['primaryInsuranceClause']))
                                                    <td>{{$insures_details['primaryInsuranceClause']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['travelCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">TRAVELLING TO AND FROM WORKPLACE</label></td>
                                            @if(isset($pipeline_details['formData']['travelCover']))
                                                @if($pipeline_details['formData']['travelCover']==true)
													<?php $travelCover='Yes';?>
                                                @else
													<?php $travelCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$travelCover}}</td>--}}

                                            @if($travelCover=='Yes')
                                                @if(isset($insures_details['travelCover']))
                                                    <td>{{$insures_details['travelCover']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['riotCover']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">RIOT, STRIKES, CIVIL COMMOTION AND PASSIVE WAR RISK</label></td>
                                            @if(isset($pipeline_details['formData']['riotCover']))
                                                @if($pipeline_details['formData']['riotCover']==true)
													<?php $riotCover='Yes';?>
                                                @else
													<?php $riotCover='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                            @if($riotCover=='Yes')
                                                @if(isset($insures_details['riotCover']))
                                                    <td>{{$insures_details['riotCover']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['brokersClaimClause']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">BROKERS CLAIM HANDLING CLAUSE : A LOSS NOTIFICATION RECEIVED BY THE INSURANCE BROKER WILL BE DEEMED AS A LOSS NOTIFICATION TO INSURER. ALL COMMUNICATIONS FLOWING BETWEEN THE INSURER, INSURED AND THE APPOINTED LOSS SURVEYOR SHOULD BE CHANNELIZED THROUGH THE BROKER, UNLESS THERE IS ANY UNAVOIDABLE REASONS COMPELLING DIRECT COMMUNICATIONS BETWEEN THE PARTIES</label></td>
                                            @if(isset($pipeline_details['formData']['brokersClaimClause']))
                                                @if($pipeline_details['formData']['brokersClaimClause']==true)
													<?php $brokersClaimClause='Yes';?>
                                                @else
													<?php $brokersClaimClause='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$brokersClaimClause}}</td>--}}
                                            @if($brokersClaimClause=='Yes')
                                                @if(isset($insures_details['brokersClaimClause']['isAgree']))
                                                    @if($insures_details['brokersClaimClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['brokersClaimClause']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['brokersClaimClause']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['brokersClaimClause']['comment']}}"></i> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['brokersClaimClause']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">EMPLOYMENT CLAUSE</label></td>
                                            @if(isset($pipeline_details['formData']['hiredCheck']))
                                                @if($pipeline_details['formData']['hiredCheck']==true)
				                                    <?php $hiredCheck='Yes';?>
                                                @else
				                                    <?php $hiredCheck='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                            @if($hiredCheck=='Yes')
                                                @if(isset($insures_details['hiredCheck']))
                                                    <td>{{$insures_details['hiredCheck']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                        @endif
                                    @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEE</label></td>
                                            @if(isset($pipeline_details['formData']['offshoreCheck']))
                                                @if($pipeline_details['formData']['offshoreCheck']==true)
				                                    <?php $offshoreCheck='Yes';?>
                                                @else
				                                    <?php $offshoreCheck='No';?>
                                                @endif
                                            @endif
                                            {{--<td class="main_answer">{{$riotCover}}</td>--}}

                                            @if($offshoreCheck=='Yes')
                                                @if(isset($insures_details['offshoreCheck']))
                                                    <td>{{$insures_details['offshoreCheck']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif

                                        </tr>
                                        @endif
                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">RATE (ADMIN)</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredAdmin']}}</td>--}}
                                            @if(isset($insures_details['rateRequiredAdmin']))
                                                <td>{{$insures_details['rateRequiredAdmin']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">RATE (NON-ADMIN)</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredNonAdmin']}}</td>--}}
                                            @if(isset($insures_details['rateRequiredNonAdmin']))
                                                <td>{{$insures_details['rateRequiredNonAdmin']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">COMBINED RATE</label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['combinedRate']}}</td>--}}
                                        <td>{{$insures_details['combinedRate']}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">WARRANTY</label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['warranty']}}</td>--}}
                                        <td>{{$insures_details['warranty']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">EXCLUSION</label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['exclusion']}}</td>--}}
                                        <td>{{$insures_details['exclusion']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">SPECIAL CONDITION </label></td>
                                        {{--<td class="main_answer">{{$pipeline_details['formData']['specialCondition']}}</td>--}}
                                        <td>{{$insures_details['specialCondition']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="main_question"><label class="form_label bold">CUSTOMER DECISION </label></td>
                                        {{--<td class="main_answer"></td>--}}
                                        @if(@$insures_details['customerDecision'])
                                            @if(@$insures_details['amendComment'])
                                                <td>{{@$insures_details['customerDecision']}}<br>Comment : {{$insures_details['amendComment']}}</td>
                                            @else
                                                <td>
                                                    {{@$insures_details['customerDecision']['decision']}}
                                                    @if(@$insures_details['customerDecision']['comment'] != "")
                                                        <br>Comment : {{@$insures_details['customerDecision']['comment']}}
                                                    @endif
                                                </td>
                                            @endif
                                        @else
                                            <td>Customer doesn't reply yet.</td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 50px"></div>
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table">
                            <div class="table-header">
                                <span class="table-title">Policy Entries</span>
                            </div>
                            <div class="" style="margin-bottom: 20px">
                            <div class="row" style="margin: 0">
                                <div class="col-md-6" style="padding: 0">
                                    <div class="">
                                        <table class="comparison table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Insurer Policy Number</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['insurerPolicyNumber']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">IIB Policy Number</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['iibPolicyNumber']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Insurance Company</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$insures_details['insurerDetails']['insurerName']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Premium Invoice</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['premiumInvoice']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Premium Invoice Date</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['premiumInvoiceDate']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Commission Invoice</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['commissionInvoice']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Commission Invoice Date</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['commissionInvoiceDate']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Inception Date</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['inceptionDate']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Expiry Date</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['expiryDate']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Currency</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['currency']}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0">
                                    <div class="">
                                        <table class="comparison table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Premium (Excl VAT) </label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['premium']) && $pipeline_details['accountsDetails']['premium']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['premium']);
		                                                // if(strpos($pipeline_details['accountsDetails']['premium'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $pr_amount=number_format($pr_amount1).'.'.$s[1];
		                                                // }else{
			                                                $pr_amount = number_format($pipeline_details['accountsDetails']['premium'],2);
		                                               // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['premium'])){
		                                            //     $pr_amount=number_format($pipeline_details['accountsDetails']['premium']);
                                                    // } 
                                                    else{
		                                                $pr_amount='--';
                                                    }
                                                    ;?>
                                                    {{$pr_amount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">VAT % </label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['vatPercent']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">VAT (Total)</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['vatTotal']) && $pipeline_details['accountsDetails']['vatTotal']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['vatTotal']);
		                                                // if(strpos($pipeline_details['accountsDetails']['vatTotal'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $val_total=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                            //     $val_total = number_format($pipeline_details['accountsDetails']['vatTotal']);
                                                        // }
                                                        $val_total=number_format($pipeline_details['accountsDetails']['vatTotal'],2);
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['vatTotal'])){
		                                               
                                                    // } 
                                                    else{
		                                                $val_total='--';
                                                    }
                                                    ;?>
                                                    {{$val_total}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Commission %</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['commissionPercent']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Commission amount (Premium)</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['commissionPremium']) && $pipeline_details['accountsDetails']['commissionPremium']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['commissionPremium']);
		                                                // if(strpos($pipeline_details['accountsDetails']['commissionPremium'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $commission_amount=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                 $commission_amount = number_format($pipeline_details['accountsDetails']['commissionPremium'],2);
		                                                // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['commissionPremium'])){
		                                            //     $commission_amount=number_format($pipeline_details['accountsDetails']['commissionPremium']);
                                                    // }
                                                    else{
		                                                $commission_amount='--';
                                                    }
                                                    ;?>
                                                    {{$commission_amount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Commission amount (VAT)</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['commissionVat']) && $pipeline_details['accountsDetails']['commissionVat']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['commissionVat']);
		                                                // if(strpos($pipeline_details['accountsDetails']['commissionVat'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $commissionVat=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                $commissionVat = number_format($pipeline_details['accountsDetails']['commissionVat'],2);
		                                                //}
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['commissionVat'])){
		                                            //     $commissionVat=number_format($pipeline_details['accountsDetails']['commissionVat']);
                                                    // } 
                                                    else{
		                                                $commissionVat='--';
                                                    }
                                                    
                                                    ;?>
                                                    {{$commissionVat}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Insurer Discount</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['insurerDiscount']) && $pipeline_details['accountsDetails']['insurerDiscount']!='') {
		                                                //    $s= explode('.',$pipeline_details['accountsDetails']['insurerDiscount']);
		                                                // if(strpos($pipeline_details['accountsDetails']['insurerDiscount'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $insurerDiscount=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                               $insurerDiscount = $pipeline_details['accountsDetails']['insurerDiscount'];
		                                                // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['insurerDiscount'])){
		                                            //     $insurerDiscount=number_format($pipeline_details['accountsDetails']['insurerDiscount']);
	                                                // }
	                                                else{
		                                                $insurerDiscount='--';
                                                    }
                                                    ;?>
                                                    {{$insurerDiscount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">IIB Discount</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['iibDiscount']) && $pipeline_details['accountsDetails']['iibDiscount']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['iibDiscount']);
		                                                // if(strpos($pipeline_details['accountsDetails']['iibDiscount'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $iibDiscount=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                 $iibDiscount = $pipeline_details['accountsDetails']['iibDiscount'];
		                                                // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['iibDiscount'])){
		                                            //     $iibDiscount=number_format($pipeline_details['accountsDetails']['iibDiscount']);
	                                                // }
	                                                else{
		                                                $iibDiscount='--';
	                                                }
	                                                ;?>
                                                    {{$iibDiscount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Insurer Fees</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['insurerFees']) && $pipeline_details['accountsDetails']['insurerFees']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['insurerFees']);
		                                                // if(strpos($pipeline_details['accountsDetails']['insurerFees'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                               //  $insurerFees=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                 $insurerFees = $pipeline_details['accountsDetails']['insurerFees'];
		                                                // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['insurerFees'])){
		                                            //     $insurerFees=number_format($pipeline_details['accountsDetails']['insurerFees']);
	                                                // }
	                                                else{
		                                                $insurerFees='--';
	                                                }
	                                                ;?>
                                                    {{$insurerFees}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">IIB Fees</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['iibFees']) && $pipeline_details['accountsDetails']['iibFees']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['iibFees']);
		                                                // if(strpos($pipeline_details['accountsDetails']['iibFees'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $iibFees=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                 $iibFees = $pipeline_details['accountsDetails']['iibFees'];
		                                                // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['iibFees'])){
		                                            //     $iibFees=number_format($pipeline_details['accountsDetails']['iibFees']);
	                                                // }
	                                                else{
		                                                $iibFees='--';
	                                                };?>
                                                    {{$iibFees}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Agent Commission %</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{$pipeline_details['accountsDetails']['agentCommissionPecent']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Agent Commission amount</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['agentCommissionAmount']) && $pipeline_details['accountsDetails']['agentCommissionAmount']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['agentCommissionAmount']);
		                                                // if(strpos($pipeline_details['accountsDetails']['agentCommissionAmount'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $agentCommissionAmount=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                $agentCommissionAmount = number_format($pipeline_details['accountsDetails']['agentCommissionAmount'],2);
		                                               // }
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['agentCommissionAmount'])){
		                                            //     $agentCommissionAmount=number_format($pipeline_details['accountsDetails']['agentCommissionAmount']);
                                                    // }
                                                    else{
		                                                $agentCommissionAmount='--';
	                                                }
                                                    ;?>
                                                    {{$agentCommissionAmount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">NET Premium payable to Insurer</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['payableToInsurer']) && $pipeline_details['accountsDetails']['payableToInsurer']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['payableToInsurer']);
		                                                // if(strpos($pipeline_details['accountsDetails']['payableToInsurer'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $payableToInsurer=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                $payableToInsurer = number_format($pipeline_details['accountsDetails']['payableToInsurer'],2);
		                                                //}
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['payableToInsurer']) && $pipeline_details['accountsDetails']['payableToInsurer']!=''){
		                                            //     $payableToInsurer=number_format($pipeline_details['accountsDetails']['payableToInsurer']);
	                                                // }
	                                                else{
		                                                $payableToInsurer='--';
                                                    };?>
                                                    {{$payableToInsurer}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">NET Premium Payable by Client</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
	                                                <?php if(isset($pipeline_details['accountsDetails']['payableByClient']) && $pipeline_details['accountsDetails']['payableByClient']!='') {
		                                                // $s= explode('.',$pipeline_details['accountsDetails']['payableByClient']);
		                                                // if(strpos($pipeline_details['accountsDetails']['payableByClient'] , '.')){
			                                            //     $pr_amount1=$s[0];
			                                            //     $payableByClient=number_format($pr_amount1.'.'.$s[1]);
		                                                // }else{
			                                                $payableByClient = number_format($pipeline_details['accountsDetails']['payableByClient'],2);
		                                                //}
	                                                }
	                                                // else if(isset($pipeline_details['accountsDetails']['payableByClient']) &&$pipeline_details['accountsDetails']['payableByClient']!='' ){
		                                            //     $payableByClient=number_format($pipeline_details['accountsDetails']['payableByClient']);
	                                                // }
	                                                else{
		                                                $payableByClient='--';
	                                                };?>
                                                    {{$payableByClient}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div style="height: 50px"></div>
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table" style="margin-bottom: 20px">
                            <div class="table-header">
                                <span class="table-title">Payment Details</span>
                            </div>
                            <div class="row" style="margin: 0">
                                <div class="col-md-12" style="padding: 0">
                                    <div class="">
                                        <table class="comparison table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Payment Mode</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{@$pipeline_details['accountsDetails']['paymentMode']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cheque No</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{@$pipeline_details['accountsDetails']['chequeNumber']}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Date Payment sent to Insurer</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                       {{@$pipeline_details['accountsDetails']['datePaymentInsurer']}}
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Payment Status</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                <td>
                                                    {{@$pipeline_details['accountsDetails']['paymentStatus']}}
                                                </td>
                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 50px"></div>
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table" style="margin-bottom: 20px">
                            <div class="table-header">
                                <span class="table-title">Installment Details</span>
                            </div>
                            <div class="row" style="margin: 0">
                                <div class="col-md-12" style="padding: 0">
                                    <div class="">
                                        <table class="comparison table table-bordered">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">No of Installments</label></td>
                                                {{--<td class="main_answer"></td>--}}
                                                 <td>
                                                    {{@$pipeline_details['accountsDetails']['noOfInstallment']?:'0'}}
                                                </td>
                                            </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.chat')
@endsection