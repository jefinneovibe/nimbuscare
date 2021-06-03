@extends('layouts.customer')
@include('includes.loader')
@section('content')
    <main class="layout_content">
        <div class="page_content">
    <div class="section_details">
        <div class="card_header clearfix">
            <div class="customer_logo">
                <img src="{{URL::asset('img/main/interactive_logo.png')}}">
            </div>
            <h3 class="title" style="margin-bottom: 8px;">Employers Liability - Issuance Approvals</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
    <form name="insurer_form" id="insurer_form" method="post" action="{{url('insurer-decision')}}">
        {{csrf_field()}}
        <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
        <div class="data_table compare_sec">
            <div id="admin">
                <div class="material-table" style="margin-bottom: 20px">
                    {{--<div class="table-header">--}}
                        {{--<span class="table-title">Issuance</span>--}}
                    {{--</div>--}}
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
                                <td>{{$insures_details['extendedLiability']}}</td>
                            </tr>
                            @if($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true && isset($insures_details['coverHiredWorkers']['comment']))
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">COVER FOR HIRED WORKERS OR CASUAL LABOURS</label></div></td>
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
                                </tr>
                            @endif
                            @if($pipeline_details['formData']['offShoreEmployeeDetails']['hasOffShoreEmployees']==true && isset($insures_details['coverOffshore']))
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">COVER FOR OFFSHORE EMPLOYEES</label></div></td>
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
                                @if($pipeline_details['formData']['crossLiability']==true)
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
                            @if(isset($pipeline_details['formData']['hiredCheck']))
                            @if($pipeline_details['formData']['hiredCheck']==true)
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
                                <td class="main_question"><label class="form_label bold">EXCESS</label></td>
                                {{--<td class="main_answer">{{$pipeline_details['formData']['exclusion']}}</td>--}}
                                <td>{{$insures_details['excess']}}</td>
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
                    <input type="hidden" id="insurer_decision" name="insurer_decision">
                    <button class="btn btn-primary btn_action pull-right" type="button" onclick="approve()">Approve</button>
                    <button class="btn blue_btn btn_action pull-right" type="button" onclick="reject()">Reject</button>
                </div>
            </div>
        </div>
    </form>
            </div>
        </div>
    </div>
        </div>
    </main>
@endsection
@push('scripts')
<script>
    function approve()
    {
        $('#insurer_decision').val('approved');
        $('#insurer_form').submit();
    }
    function reject()
    {
        $('#insurer_decision').val('rejected');
        $('#insurer_form').submit();
    }
</script>
@endpush