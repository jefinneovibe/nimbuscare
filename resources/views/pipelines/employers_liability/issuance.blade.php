@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Employers Liability</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                {{--<section>--}}
                    {{--<nav>--}}
                        {{--<ol class="cd-breadcrumb triangle">--}}
                            {{--<li class="complete"><a href="{{url('e-questionnaire/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-slip/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-quotation/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-comparison/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipelineId)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('approved-quot/'.$pipelineId)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                            {{--<li class="current"><em>Issuance</em></li>--}}
                        {{--</ol>--}}
                    {{--</nav>--}}
                {{--</section>--}}
                <form name="accounts" id="accounts" method="post">
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
                    <input type="hidden" id="page" name="page" value="issuance">
                    <div class="data_table compare_sec">
                        <div id="admin">
                            <div class="material-table" style="margin-bottom: 20px">
                                <div class="table-header">
                                    <span class="table-title">Pending Issuance</span>
                                    @if(isset($pipeline_details['insurerResponse']['response']) && @$pipeline_details['insurerResponse']['response']!='')
                                        <span class="pull-right" style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">{{$pipeline_details['insurerResponse']['response']}} by the Insurer</span>
                                    @else
                                        <span class="pull-right" style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">Pending insurer response</span>
                                    @endif
                                </div>
                                <div class="table-responsive" style="margin-bottom: 20px">
                                    <table class="comparison table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 100%" colspan="2">Selected Insurer : <b>{{$insures_details['insurerDetails']['insurerName']}}</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td class="main_question"><label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['extendedLiability']}}</td>--}}
                                            <td>{{number_format($insures_details['extendedLiability'],2)}}</td>
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

                                        @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label">
                                                        Emergency evacuation following work related accident
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
                                            @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></td>
                                                @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                    @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                                        <?php $waiverOfSubrogation='Yes';?>
                                                    @else
                                                        <?php $waiverOfSubrogation='No';?>
                                                    @endif
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
                                                @endif
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

                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RATE (ADMIN)</label></td>
                                                {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredAdmin']}}</td>--}}
                                                @if(isset($insures_details['rateRequiredAdmin']) && $insures_details['rateRequiredAdmin']!='')
                                                    <td>{{number_format($insures_details['rateRequiredAdmin'],2)}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">RATE (NON-ADMIN)</label></td>
                                                {{--<td class="main_answer">{{$pipeline_details['formData']['rateRequiredNonAdmin']}}</td>--}}
                                                @if(isset($insures_details['rateRequiredNonAdmin']) &&  $insures_details['rateRequiredNonAdmin']!='')
                                                    <td>{{number_format($insures_details['rateRequiredNonAdmin'],2)}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==false)
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">COMBINED RATE</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['combinedRate']}}</td>--}}
                                            @if(isset($insures_details['combinedRate']) && $insures_details['combinedRate']!='')
                                            <td>{{number_format($insures_details['combinedRate'],2)}}</td>
                                            @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">WARRANTY</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['warranty']}}</td>--}}
                                            @if(isset($insures_details['warranty']) && $insures_details['warranty']!='')
                                            <td>{{$insures_details['warranty']}}</td>
                                            @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">EXCLUSION</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['exclusion']}}</td>--}}
                                            @if(isset($insures_details['exclusion']) && $insures_details['exclusion']!='')
                                            <td>{{$insures_details['exclusion']}}</td>
                                            @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">EXCESS</label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['exclusion']}}</td>--}}
                                            @if(isset($insures_details['excess']) && $insures_details['excess']!='')
                                            <td>{{number_format($insures_details['excess'],2)}}</td>
                                            @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">SPECIAL CONDITION </label></td>
                                            {{--<td class="main_answer">{{$pipeline_details['formData']['specialCondition']}}</td>--}}
                                            @if(isset($insures_details['specialCondition']) && $insures_details['specialCondition']!='')
                                            <td>{{$insures_details['specialCondition']}}</td>
                                            @else
                                            <td>--</td>
                                        @endif
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
                            <div class="material-table" style="margin-bottom: 20px">
                                <div class="table-header">
                                    <span class="table-title">Policy Entries</span>
                                </div>
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
                                                    <td class="main_question"><label class="form_label bold">Insurer Policy Number <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="policy_no" id="policy_no" class="form_input" value="{{@$pipeline_details['accountsDetails']['insurerPolicyNumber']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Policy Number <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="iib_policy_no" id="iib_policy_no" class="form_input" value="{{@$pipeline_details['accountsDetails']['iibPolicyNumber']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurance Company</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        {{$insures_details['insurerDetails']['insurerName']}}
                                                        <input type="hidden" name="insurer_name" value="{{$insures_details['insurerDetails']['insurerName']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium Invoice <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="premium_invoice" id="premium_invoice" class="form_input" value="{{@$pipeline_details['accountsDetails']['premiumInvoice']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium Invoice Date <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin: 0">
                                                            <input type="text" name="premium_invoice_date" id="premium_invoice_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['premiumInvoiceDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission Invoice <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="commission_invoice" id="commission_invoice" class="form_input" value="{{@$pipeline_details['accountsDetails']['commissionInvoice']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission Invoice Date <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="commission_invoice_date" id="commission_invoice_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['commissionInvoiceDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Inception Date <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="inception_date" id="inception_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['inceptionDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Expiry Date <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="expiry_date" id="expiry_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['expiryDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Currency <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="currency" id="currency" class="form_input" value="{{@$pipeline_details['accountsDetails']['currency']}}">
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
                                                {{--<tr>--}}
                                                {{--<td class="main_question"><label class="form_label bold">Provision to Update Installments</label></td>--}}
                                                {{--<td class="main_answer"></td>--}}
                                                {{--<td>--}}
                                                {{--<input type="text" name="update_provision" id="update_provision" class="form_input" value="{{@$pipeline_details['accountsDetails']['updateProvision']}}">--}}
                                                {{--</td>--}}
                                                {{--</tr>--}}


                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium (Excl VAT) <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <?php if(isset($pipeline_details['accountsDetails']['premium']) && is_numeric($pipeline_details['accountsDetails']['premium'])) {
		                                                    $s= explode('.',$pipeline_details['accountsDetails']['premium']);
		                                                    if(strpos($pipeline_details['accountsDetails']['premium'] , '.')){
                                                                $pr_amount1=$s[0];
                                                                $pr_amount=$pr_amount1.'.'.$s[1];
                                                            }else{
                                                                $pr_amount = $pipeline_details['accountsDetails']['premium'];
                                                            }
	                                                    }
	                                                    else if(isset($pipeline_details['accountsDetails']['premium'])){
                                                        	$pr_amount=$pipeline_details['accountsDetails']['premium'];
	                                                    } ;?>
                                                        <input class="form_input number" name="premium" id="premium" onkeyup="commission()" value="{{@$pr_amount}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">VAT % <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" id="vat" name="vat" class="form_input" value="5" onkeyup="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "{{$pipeline_details['accountsDetails']['vatPercent']}}"
                                                               @else
                                                               value = "5"
                                                                @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">VAT (Total) <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="vat_total" class="form_input number"  onkeyup="reverseCalculation()" name="vat_total" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['vatTotal']!=''){{$pipeline_details['accountsDetails']['vatTotal']}}@endif"
                                                               {{-- @else
                                                               value = "0" --}}
                                                                @endif>
                                                        {{--<input type="hidden" name="vat_total" id="hidden_vat_total"--}}
                                                        {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                        {{--value="{{$pipeline_details['accountsDetails']['vatTotal']}}"--}}
                                                        {{--@else--}}
                                                        {{--value="0"--}}
                                                        {{--@endif>--}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission % <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" name="commision" id="commision" class="form_input" onkeyup="commission()"  value="{{round(@$pipeline_details['accountsDetails']['commissionPercent'],2)}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission amount (Premium) <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="commission_premium_amount" class="form_input number"  onkeyup="commissionPercent()" name="commission_premium_amount" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['commissionPremium']!=''){{$pipeline_details['accountsDetails']['commissionPremium']}}@endif"
                                                               {{-- @else
                                                               value="0" --}}
                                                                @endif>
                                                        {{--<input type="hidden" name="commission_premium_amount" id="hidden_commission_premium_amount"--}}
                                                        {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                        {{--value="{{$pipeline_details['accountsDetails']['commissionPremium']}}"--}}
                                                        {{--@else--}}
                                                        {{--value="0"--}}
                                                        {{--@endif>--}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission amount (VAT) <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="commission_vat_amount" class="form_input number" onkeyup="commission()" name="commission_vat_amount" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['commissionVat']){{$pipeline_details['accountsDetails']['commissionVat']}}@endif"
                                                               {{-- @else
                                                               value="0" --}}
                                                                @endif>
                                                        {{--<input type="hidden" name="commission_vat_amount" id="hidden_commission_vat_amount"--}}
                                                        {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                        {{--value="{{$pipeline_details['accountsDetails']['commissionVat']}}"--}}
                                                        {{--@else--}}
                                                        {{--value="0"--}}
                                                        {{--@endif>--}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurer Discount</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                    <input  name="insurer_discount" id="insurer_discount" class="form_input number" onkeyup="commission()" value="@if($pipeline_details['accountsDetails']['insurerDiscount']){{@$pipeline_details['accountsDetails']['insurerDiscount']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Discount</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_discount" id="iib_discount" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibDiscount']){{@$pipeline_details['accountsDetails']['iibDiscount']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurer Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input name="insurer_fees" id="insurer_fees" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['insurerFees']){{@$pipeline_details['accountsDetails']['insurerFees']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_fees" id="iib_fees" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibFees']){{@$pipeline_details['accountsDetails']['iibFees']}}@endif">
                                                    </td>
                                                </tr>
                                                {{--<tr>--}}
                                                {{--<td class="main_question"><label class="form_label bold">Agent Commission %</label></td>--}}
                                                {{--<td class="main_answer"></td>--}}
                                                {{--<td>--}}
                                                <input type="hidden" name="agent_commission_percent" id="agent_commission_percent" class="form_input"
                                                       @if(isset($pipeline_details['accountsDetails']))
                                                       value="{{round($pipeline_details['accountsDetails']['agentCommissionPecent'],2)}}"
                                                       @else
                                                       value="50"
                                                       @endif onkeyup="commission()">
                                                {{--</td>--}}
                                                {{--</tr>--}}
                                                {{--<tr>--}}
                                                {{--<td class="main_question"><label class="form_label bold">Agent Commission amount</label></td>--}}
                                                {{--<td class="main_answer"></td>--}}
                                                {{--<td>--}}
                                                <input id="agent_commission" type="hidden" class="form_input" onkeyup="reverseCalculation()" name="agent_commission"  onblur="commission()"
                                                       @if(isset($pipeline_details['accountsDetails']))
                                                       value="{{$pipeline_details['accountsDetails']['agentCommissionAmount']}}"
                                                       {{-- @else
                                                       value="0" --}}
                                                        @endif>
                                                {{--<input type="hidden" name="agent_commission" id="hidden_agent_commission" value="0"--}}
                                                {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                {{--value="{{$pipeline_details['accountsDetails']['agentCommissionAmount']}}"--}}
                                                {{--@else--}}
                                                {{--value="0"--}}
                                                {{--@endif>--}}
                                                {{--</td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">NET Premium payable to Insurer <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_to_insurer"  class="form_input number" name="payable_to_insurer" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableToInsurer']!=''){{$pipeline_details['accountsDetails']['payableToInsurer']}}@endif"
                                                               {{-- @else
                                                               value="0" --}}
                                                                @endif>
                                                        {{--<input type="hidden" name="payable_to_insurer" id="hidden_payable_to_insurer" onkeyup="commission()"--}}
                                                        {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                        {{--value="{{$pipeline_details['accountsDetails']['payableToInsurer']}}"--}}
                                                        {{--@else--}}
                                                        {{--value="0"--}}
                                                        {{--@endif>--}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">NET Premium Payable by Client <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_by_client"  class="form_input number" name="payable_by_client" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableByClient']!=''){{$pipeline_details['accountsDetails']['payableByClient']}}@endif"
                                                               {{-- @else
                                                               value="0" --}}
                                                                @endif>
                                                        {{--<input type="hidden" name="payable_by_client" id="hidden_payable_by_client" onkeyup="commission()"--}}
                                                        {{--@if(isset($pipeline_details['accountsDetails']))--}}
                                                        {{--value="{{$pipeline_details['accountsDetails']['payableByClient']}}"--}}
                                                        {{--@else--}}
                                                        {{--value="0"--}}
                                                        {{--@endif>--}}
                                                    </td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<button type="submit" class="btn btn-primary pull-right btn_action">Proceed</button>--}}
                            {{--<button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveApproved()">Save as Draft</button>--}}
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
                                                    <td class="main_question"><label class="form_label bold">Payment Mode <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="payment_mode" id="payment_mode" class="form_input" value="{{@$pipeline_details['accountsDetails']['paymentMode']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cheque No <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="cheque_no" id="cheque_no" class="form_input" value="{{@$pipeline_details['accountsDetails']['chequeNumber']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Date Payment sent to Insurer <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="date_send" id="date_send" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['datePaymentInsurer']}}">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Payment Status <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="payment_status" id="payment_status" class="form_input" value="{{@$pipeline_details['accountsDetails']['paymentStatus']}}">
                                                    </td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<button type="submit" class="btn btn-primary pull-right btn_action">Proceed</button>--}}
                            {{--<button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveApproved()">Save as Draft</button>--}}
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
                                                        <input type="text" name="no_of_installments" id="No of Installments"  class="form_input" value="{{@$pipeline_details['accountsDetails']['noOfInstallment']}}">
                                                    </td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right btn_action"
                             {{-- @if(!isset($pipeline_details['insurerResponse']['response']) || $pipeline_details['insurerResponse']['response']!='approved')
                            disabled data-toggle="tooltip" data-title="haii" @endif --}}
                            >Proceed</button>
                            <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveIssuance()">Save as Draft</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        /*.section_details{*/
        /*max-width: 100%;*/
        /*}*/
        .bootstrap-datetimepicker-widget table td{
            padding: 0 !important;
            width: auto !important;
        }

    </style>
    @include('includes.mail_popup')
    @include('includes.chat')
@endsection
@push('scripts')
    <!-- Date Picker -->
    <script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>
    <script>

        function numberWithCommas(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1,$2");
            return x;
        }
        function amountTest(value){
//            debugger;
            var stringvalue=value.toString();
            return Number(stringvalue.replace(/\,/g, ''));
        }

//         $("input.number").keyup(function(event){

//             // skip for arrow keys
//             if(event.which >= 37 && event.which <= 40){
//                 event.preventDefault();
//             }
//             var $this = $(this);
// //            console.log('this'+ $this);
//             var num = $this.val().replace(/,/gi, "");
//             var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
//             // the following line has been simplified. Revision history contains original.
//             $this.val(num2);
//         });
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
        $(document).ready(function(){
            setTimeout(function() {
                $('#success_div').fadeOut('fast');
            }, 5000);
            materialKit.initFormExtendedDatetimepickers();

//            $('#expiry_date').datetimepicker();
            $("#inception_date").blur( function () {
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
            var commissionAmount = amountTest(parseFloat($('#commission_premium_amount').val()));
            var agent_commission = amountTest($('#agent_commission_percent').val());
            var agent_amount = (commissionAmount*agent_commission/100).toFixed(2);
            agent_amount=numberWithCommas(agent_amount);
            $('#agent_commission').val(agent_amount);
            $('#hidden_agent_commission').val(agent_amount);


        }
        function insurerPayable()
        {
            var premium = amountTest(parseFloat($('#premium').val()));
            var vat_total = amountTest(parseFloat($('#vat_total').val()));
            var insurer_discount = amountTest($('#insurer_discount').val());
            var commissionAmount = amountTest(parseFloat($('#commission_premium_amount').val()));
            var commissionVat = amountTest(parseFloat($('#commission_vat_amount').val()));
            var payable = ((premium+vat_total)-insurer_discount-commissionAmount-commissionVat).toFixed(2);
            payable=numberWithCommas(payable);
            $('#payable_to_insurer').val(payable);
            $('#hidden_payable_to_insurer').val(payable);
        }
        function customerPayable()
        {
            var vat = $('#vat').val();
            var vat_total = amountTest(parseFloat($('#vat_total').val()));
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
            var commissionAmount = amountTest(parseFloat($('#commission_premium_amount').val()));
            var premium = amountTest(($('#premium').val()));
            var iib_discount = amountTest($('#iib_discount').val());
            var commission = commissionAmount/(premium-iib_discount);
            commission = (commission*100).toFixed(2);
            $('#commision').val(commission);
        }
        function agentPercent()
        {

            var agentAmount = amountTest($('#agent_commission').val());
            var commissionAmount = amountTest(parseFloat($('#commission_premium_amount').val()));
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
        $('#accounts').validate({
            ignore: [],
            rules:{
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
                iib_policy_no:{
                    required:true
                },
                premium_invoice:{
                    required:true
                },
                premium_invoice_date:{
                    required:true
                },
                commission_invoice:{
                    required:true
                },
                commission_invoice_date:{
                    required:true
                },
                inception_date:{
                    required:true
                },
                expiry_date:{
                    required:true
                },
                currency:{
                    required:true
                },
                payment_mode:{
                    required:true
                },
                cheque_no:{
                    required:true
                },
                date_send:{
                    required:true
                },
                payment_status:{
                    required:true
                },
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
                    number:true
                },
                iib_discount:{
                    number:true
                },
                insurer_fees:{
                    number:true
                },
                iib_fees:{
                    number:true
                }
            },
            messages:{
                premium:"Please enter premium.",
                commision:"Please enter commission.",
                agent_commission_percent:"Please enter agent commission",
                policy_no:"Please enter insurer policy number.",
                iib_policy_no:"Please enter iib policy number.",
                premium_invoice:"Please enter premium invoice.",
                premium_invoice_date:"Please select premium invoice date.",
                commission_invoice:"Please enter commission invoice.",
                commission_invoice_date:"Please select commission invoice date.",
                inception_date:"Please select inception date.",
                expiry_date:"Please select an expiry date.",
                currency:"Please enter currency.",
                payment_mode:"Please enter payment mode.",
                cheque_no:"Please enter cheque number",
                date_send:"Please select date.",
                payment_status:"Please enter payment status.",
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#accounts")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                //$("#eslip_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('save-account')}}',
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
        function saveIssuance()
        {
            var form_data = new FormData($("#accounts")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $('#preLoader').show();
            //$("#eslip_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('save-account')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
                    if(result == 'success')
                    {
                        $('#success_message').html('Details saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('Details saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
    </script>
@endpush
