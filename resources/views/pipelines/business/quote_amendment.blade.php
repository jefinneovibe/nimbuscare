
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
            <h3 class="title" style="margin-bottom: 8px;">business_interruption</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('business_interruption/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('business_interruption/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('business_interruption/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            <li class="complete"><a href="{{url('business_interruption/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>
                            @if($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('business_interruption/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('business_interruption/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class = complete><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class = "complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class = "current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class = current><a href="{{url('business_interruption/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @endif
                        </ol>
                    </nav>
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">
                </section>
                <div class="data_table compare_sec">
                    <div id="admin">
                        <div class="material-table table-responsive">
                            <div class="table-header">
                                <span class="table-title">Quote Amendments</span>
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
                                                   
                                                    @if(isset($pipeline_details['formData']['costWork']) && $pipeline_details['formData']['costWork'] == true)
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['claimClause']) && $pipeline_details['formData']['claimClause'] == true)
    
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['custExtension']) && $pipeline_details['formData']['custExtension'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
    
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['accountants']) && $pipeline_details['formData']['accountants'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['payAccount']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['denialAccess'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['premiumClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['utilityClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['brokerClaim'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['bookedDebts'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['interdependanyClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['extraExpense'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Extra expense </label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['water'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['auditorFee'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['expenseLaws'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['lossAdjuster'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['discease'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['powerSupply'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['condition1']!='' && $pipeline_details['formData']['condition1'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                   
                                                    @if($pipeline_details['formData']['condition2'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['bookofDebts'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                   
                                                    @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    
                                                    @if($pipeline_details['formData']['rent'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['hasaccomodation'] == "yes")
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['costofConstruction'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['ContingentExpense'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['interuption'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['Royalties'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    
                                                    @if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['deductible'],2)}}</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['ratep']) && $pipeline_details['formData']['ratep'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Rate/premium</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['ratep'],2)}}</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Brokerage)</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['brokerage'],2)}}</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['spec_condition']) && $pipeline_details['formData']['spec_condition'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['spec_condition'],2)}}</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['warranty']) && $pipeline_details['formData']['warranty'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                                        <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['warranty'],2)}}</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['exclusion']) && $pipeline_details['formData']['exclusion'] != '')
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                                            <td class="main_answer"><div class="ans">{{number_format($pipeline_details['formData']['exclusion'],2)}}</div></td>
                                                        </tr>
                                                    @endif
    
    
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">CUSTOMER DECISION</label></div></td>
                                                        <td class="main_answer"><div class="ans"></div></td>
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
                                                        @if($pipeline_details['formData']['costWork']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['costWork']))
                                                                           
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['costWork']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['claimClause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['claimClause']['comment']))
                                                                            @if($insures_details[$i]['claimClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['claimClause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['claimClause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['claimClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['claimClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['custExtension']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['custExtension']['comment']))
                                                                            @if($insures_details[$i]['custExtension']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['custExtension']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['custExtension']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['custExtension']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['custExtension']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['accountants']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['accountants']['comment']))
                                                                            @if($insures_details[$i]['accountants']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['accountants']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['accountants']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['accountants']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['accountants']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['payAccount']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['payAccount']['comment']))
                                                                            @if($insures_details[$i]['payAccount']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['payAccount']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['payAccount']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['payAccount']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['payAccount']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['denialAccess']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['denialAccess']['comment']))
                                                                            @if($insures_details[$i]['denialAccess']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['denialAccess']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['denialAccess']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['denialAccess']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['denialAccess']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['premiumClause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['premiumClause']['comment']))
                                                                            @if($insures_details[$i]['premiumClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['premiumClause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['premiumClause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['premiumClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['premiumClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['utilityClause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['utilityClause']['comment']))
                                                                            @if($insures_details[$i]['utilityClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['utilityClause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['utilityClause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['utilityClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['utilityClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['brokerClaim']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['brokerClaim']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['brokerClaim']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['bookedDebts']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['bookedDebts']['comment']))
                                                                            @if($insures_details[$i]['bookedDebts']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['bookedDebts']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['bookedDebts']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['bookedDebts']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['bookedDebts']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['interdependanyClause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['interdependanyClause']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['interdependanyClause']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['extraExpense']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['extraExpense']['comment']))
                                                                            @if($insures_details[$i]['extraExpense']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['extraExpense']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['extraExpense']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['extraExpense']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['extraExpense']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['water']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['water']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['water']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['auditorFee']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['auditorFee']['comment']))
                                                                            @if($insures_details[$i]['auditorFee']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['auditorFee']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['auditorFee']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['auditorFee']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['auditorFee']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['expenseLaws']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['expenseLaws']['comment']))
                                                                            @if($insures_details[$i]['expenseLaws']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['expenseLaws']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['expenseLaws']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['expenseLaws']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['expenseLaws']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['lossAdjuster']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['lossAdjuster']['comment']))
                                                                            @if($insures_details[$i]['lossAdjuster']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['lossAdjuster']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossAdjuster']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['lossAdjuster']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['lossAdjuster']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['discease']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['discease']['comment']))
                                                                            @if($insures_details[$i]['discease']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['discease']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['discease']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['discease']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['discease']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['powerSupply']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['powerSupply']['comment']))
                                                                            @if($insures_details[$i]['powerSupply']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['powerSupply']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['powerSupply']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['powerSupply']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['powerSupply']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['condition1']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['condition1']['comment']))
                                                                            @if($insures_details[$i]['condition1']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['condition1']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['condition1']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['condition1']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['condition1']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['condition2']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['condition2']['comment']))
                                                                            @if($insures_details[$i]['condition2']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['condition2']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['condition2']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['condition2']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['condition2']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['bookofDebts']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['bookofDebts']['comment']))
                                                                            @if($insures_details[$i]['bookofDebts']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['bookofDebts']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['bookofDebts']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['bookofDebts']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['bookofDebts']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        
                                                        @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['depclause']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['depclause']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        
                                                        
                                                        @if($pipeline_details['formData']['rent']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['rent']['comment']))
                                                                            @if($insures_details[$i]['rent']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['rent']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['rent']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['rent']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['rent']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['hasaccomodation']=="yes")
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['hasaccomodation']['comment']))
                                                                            @if($insures_details[$i]['hasaccomodation']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['hasaccomodation']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['hasaccomodation']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['hasaccomodation']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['hasaccomodation']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['costofConstruction']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['costofConstruction']['comment']))
                                                                            @if($insures_details[$i]['costofConstruction']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['costofConstruction']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['costofConstruction']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['costofConstruction']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['costofConstruction']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['ContingentExpense']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['ContingentExpense']['comment']))
                                                                            @if($insures_details[$i]['ContingentExpense']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['ContingentExpense']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['ContingentExpense']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['ContingentExpense']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['ContingentExpense']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['interuption']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['interuption']['comment']))
                                                                            @if($insures_details[$i]['interuption']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['interuption']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['interuption']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['interuption']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['interuption']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['Royalties']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['Royalties']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['Royalties']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['deductible'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['deductible']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['deductible']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['ratep'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['ratep']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['ratep']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['brokerage'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['brokerage']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['brokerage']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['spec_condition'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['spec_condition']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['spec_condition']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['warranty'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['warranty']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['warranty']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['exclusion'])
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['exclusion']))
                                                                        
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['exclusion']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
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
                                                                    @if(isset($insures_details[$i]['customerDecision']))
                                                                        <td><div class="ans">
                                                                                {{@$insures_details[$i]['customerDecision']['decision']}}
                                                                                 @if(isset($insures_details[$i]['customerDecision']['rejctReason']) && $insures_details[$i]['customerDecision']['rejctReason']!='') 
                                                                                   ( Reason:{{@$insures_details[$i]['customerDecision']['rejctReason']}})
                                                                                 @endif 
                                                                                @if(@$insures_details[$i]['customerDecision']['comment'] != "")
                                                                                    <br> Comment : {{@$insures_details[$i]['customerDecision']['comment']}} 
                                                                                @endif
                                                                            </div> </td>
                                                                    @else
                                                                        <td><div class="ans">NA</div></td>
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
                        @if(isset($pipeline_details['status']['status']) && 
                        ($pipeline_details['status']['status']=='Quote Amendment' || $pipeline_details['status']['status']=='Quote Amendment-E-slip' ||
                        $pipeline_details['status']['status']=='Quote Amendment-E-quotation' || $pipeline_details['status']['status']=='Quote Amendment-E-comparison'))
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" onclick="closeCase()" type="button">Close the case</button>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .section_details{
            max-width: 100%;
        }

        .height_fix tbody {
            height: calc(100vh - 400px);
        }
    </style>
    @include('includes.chat')
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('#success_div').fadeOut('fast');
            }, 5000);
        });
    </script>
    <script>
         function closeCase()
        {
                var id = $('#pipeline_id').val();
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('close-pipeline')}}',
                    data: {
                        id:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.href = "{{url('closed-pipelines')}}"; 
                        }
                    }
                });
        }
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
