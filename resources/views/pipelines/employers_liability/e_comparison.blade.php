
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
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_div">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Employers Liability</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('employer/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('employer/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('employer/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            @if($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class = active_arrow><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = complete><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('employer/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class = complete><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class = complete><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class = "complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class = "current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class = active_arrow><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('employer/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                            @else
                                <li class = current><a href="{{url('employer/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @endif
                        </ol>
                    </nav>
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">
                </section>
                <div class="data_table compare_sec">
                    <div id="admin">

                        <div class="material-table">
                            <div class="table-header">
                                <span class="table-title">E-Comparison</span>
                                <div class="table_header_action">
                                    @if(isset($pipeline_details['comparisonToken']))
                                        <label style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">{{$pipeline_details['comparisonToken']['viewStatus']}}</label>
                                    @endif
                                    <button type="button"class="btn btn-primary" onclick="popupFunction()" @if($pipeline_details['status']['status'] == 'Approved E Quote') style="display:none;" @endif>Send to Customer</button>
                                    <a target="_blank" href="{{url('employer/comparison-pdf/'.$pipeline_details->_id)}}" class="btn pink_btn">Download as pdf</a>
                                </div>
                            </div>


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
                                                <td><div class="main_question"><label class="form_label bold">Employer???s extended liability under Common Law/Shariah Law</label></div></td>
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
                                            @if($pipeline_details['formData']['emergencyEvacuation']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Emergency evacuation following work related accident</label></div></td>
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
                                            @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">WAIVER OF SUBROGATION</label></div></td>
                                                </tr>
                                            @endif
                                            @endif
                                            @if($pipeline_details['formData']['automaticClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">AUTOMATIC ADDITION & DELETION CLAUSE</label></div></td>
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
                                            @if($pipeline_details['formData']['lossNotification']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">LOSS NOTIFICATION ??? ???AS SOON AS REASONABLY PRACTICABLE???</label></div></td>
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
                                                <td><div class="main_question"><label class="form_label bold">EXCESS</label></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">SPECIAL CONDITION</label></div></td>
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
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        <td><div class="ans">{{number_format($insures_details[$i]['extendedLiability'],2)}}</div></td>
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
                                            @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                                <tr>
                                                    @if(isset($pipeline_details['formData']['waiverOfSubrogation']))
                                                        @if($pipeline_details['formData']['waiverOfSubrogation']==true)
                                                            <?php $waiverOfSubrogation='Yes';?>
                                                        @else
                                                            <?php $waiverOfSubrogation='No';?>
                                                        @endif
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
                                                @endif
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
                                            @if(($pipeline_details['formData']['hiredWorkersDetails']['hasHiredWorkers']==true))
                                                <tr>
                                                    @if(isset($pipeline_details['formData']['hiredCheck']))
                                                        @if($pipeline_details['formData']['hiredCheck']==true)
				                                            <?php $hiredCheck='Yes';?>
                                                        @else
				                                            <?php $hiredCheck='No';?>
                                                        @endif
                                                    @else
		                                                <?php $hiredCheck='No';?>
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
                                                        @elseif($hiredCheck=='No')
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
                                                            @if(isset($insures_details[$i]['rateRequiredAdmin']) && $insures_details[$i]['rateRequiredAdmin']!='')
                                                                <td><div class="ans">{{number_format($insures_details[$i]['rateRequiredAdmin'],2)}}</div></td>
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['sepOrCom']) &&$pipeline_details['formData']['sepOrCom']==true)
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['rateRequiredNonAdmin']) && $insures_details[$i]['rateRequiredNonAdmin']!='')
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
                                                        @if(isset($insures_details[$i]['combinedRate']) && $insures_details[$i]['combinedRate']!='')
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
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId) && $insures_details[$i]['warranty']!='')
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
                                                        @if(isset($insures_details[$i]['exclusion']) && $insures_details[$i]['exclusion']!='')
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
                                                        @if(isset($insures_details[$i]['excess']) && $insures_details[$i]['excess']!='')
                                                            <td><div class="ans">{{number_format($insures_details[$i]['excess'],2)}}</div></td>
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['specialCondition']) && $insures_details[$i]['specialCondition']!='')
                                                            <td><div class="ans">{{$insures_details[$i]['specialCondition']}}</div></td>
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
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

    <style>
        .section_details{
            max-width: 100%;
        }
    </style>
    @include('includes.mail_popup')
    @include('includes.chat')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function() {
            $('#success_div').fadeOut('fast');
            }, 5000);
        });
        function sendQuestion() {
            var form_data = new FormData($("#quest_send_form")[0]);
            var id = $('#pipeline_id').val();
            form_data.append('id',id);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#send_btn").attr( "disabled", true );
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('send-comparison')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result!= 'failed') {
                        $("#send_btn").attr( "disabled", false );
                        $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                        $('#preLoader').hide();
                        $('#success_message').html(result);
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $("#send_btn").attr( "disabled", false );
                        $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                        $('#preLoader').hide();
                        $('#success_message').html('Comparison sending failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
        function popupFunction() {
            $('#questionnaire_popup .cd-popup').addClass('is-visible');
            $("#send_btn").attr( "disabled", false );
            var id = $('#pipeline_id').val();
            $.ajax({
                method: 'get',
                url: '{{url('email-file')}}',
                data: {'id': id},
                success: function (result) {
                    if (result != 'failed') {
                        $('#attach_div').html(result);
                    }
                    else {
                        $('#attach_div').html('Files loading failed');
                    }
                }
            });
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
    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
