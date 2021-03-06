
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
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('Machinery-Breakdown/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('Machinery-Breakdown/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('Machinery-Breakdown/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>
                            @if($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('Machinery-Breakdown/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class = complete><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class = "complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class = "current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @else
                                <li class = current><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
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
                                                   
                                                    @if(isset($pipeline_details['formData']['localclause']) && $pipeline_details['formData']['localclause'] == true)
                                                        <tr>   
                                                            <td><div class="main_question"><label class="form_label bold">Local Jurisdiction Clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['express']) && $pipeline_details['formData']['express'] == true)
    
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['airfreight']) && $pipeline_details['formData']['airfreight'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Airfreight</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
    
                                                        </tr>
                                                    @endif
                                                    @if(isset($pipeline_details['formData']['addpremium']) && $pipeline_details['formData']['addpremium'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['payAccount']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['primaryclause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['premiumClaim'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Cancellation ??? 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['lossnotification'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Loss Notification ??? ???as soon as reasonably practicable???</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['adjustmentPremium'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['temporaryclause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Temporary repairs clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['automaticClause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Automatic addition clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['capitalclause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['debris'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['property'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if( $pipeline_details['formData']['errorclause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Errors and omission clause</label></div></td>
                                                        <td class="main_answer"><div class="ans">Yes</div></td>
                                                    </tr>
                                                    @endif
                                                    @if(@$pipeline_details['formData']['aff_company']!='' && $pipeline_details['formData']['waiver']==true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Waiver of subrogation</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['claimclause'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['Innocent'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Innocent non-disclosure</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['Noninvalidation'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['brokerclaim'] == true)
                                                        <tr>
                                                            <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the Noninvalidation</label></div></td>
                                                            <td class="main_answer"><div class="ans">Yes</div></td>
                                                        </tr>
                                                    @endif
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Deductible for (Machinary Breakdown):  </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Rate required (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                          
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Premium required (Machinary Breakdown): </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                            
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Brokerage (Machinary Breakdown) :</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                               
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Warranty (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                    
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Exclusion (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                 
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Special Condition (Machinary Breakdown):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                  
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Deductible for (Business Interruption): </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">premium (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                               
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                      
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                               
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption):</label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                              
                                                    <tr>   
                                                        <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption): </label></div></td>
                                                        <td class="main_answer"><div class="ans">--</div></td>
                                                    </tr>
                                                    {{-- @if(isset($pipeline_details['formData']['deductible']) && $pipeline_details['formData']['deductible'] != '')
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
                                                    @endif --}}
    
    
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
                                                        @if($pipeline_details['formData']['localclause']==true)
                                                        <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['localclause']['comment']))
                                                                        @if($insures_details[$i]['localclause']['comment']!="")
                                                                            <td class="tooltip_sec"><div class="ans">
                                                                                    <span>{{$insures_details[$i]['localclause']['isAgree']}}</span>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['express']['comment']}}"></i> --}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details[$i]['localclause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">{{$insures_details[$i]['localclause']['isAgree']}}</div></td>
                                                                        @endif
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
            
                                                        @if($pipeline_details['formData']['express']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['express']['comment']))
                                                                            @if($insures_details[$i]['express']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['express']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['express']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['express']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['express']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['airfreight']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['airfreight']['comment']))
                                                                            @if($insures_details[$i]['airfreight']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['airfreight']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['airfreight']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['airfreight']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['airfreight']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['addpremium']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['addpremium']['comment']))
                                                                            @if($insures_details[$i]['addpremium']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['addpremium']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['addpremium']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['addpremium']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['addpremium']['isAgree']}}</div></td>
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
                                                        @if($pipeline_details['formData']['primaryclause']==true)
                                                        <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['primaryclause']))
                                                                        
                                                                        <td class="tooltip_sec">
                                                                            <div class="ans">
                                                                                <span>{{$insures_details[$i]['primaryclause']}}</span>
                                                                            </div>
                                                                        </td>
                                                                        
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['premiumClaim']==true)
                                                    <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['premiumClaim']))
                                                                    
                                                                    <td class="tooltip_sec">
                                                                        <div class="ans">
                                                                            <span>{{$insures_details[$i]['premiumClaim']}}</span>
                                                                        </div>
                                                                    </td>
                                                                    
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                                        @if($pipeline_details['formData']['lossnotification']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['lossnotification']['comment']))
                                                                            @if($insures_details[$i]['lossnotification']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['lossnotification']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossnotification']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['lossnotification']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['lossnotification']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['adjustmentPremium']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['adjustmentPremium']['comment']))
                                                                            @if($insures_details[$i]['adjustmentPremium']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['adjustmentPremium']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['adjustmentPremium']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['adjustmentPremium']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['adjustmentPremium']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['temporaryclause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['temporaryclause']['comment']))
                                                                            @if($insures_details[$i]['temporaryclause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['temporaryclause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['temporaryclause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['temporaryclause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['temporaryclause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                       
            
                                                        @if($pipeline_details['formData']['automaticClause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['automaticClause']['comment']))
                                                                            @if($insures_details[$i]['automaticClause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['automaticClause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['automaticClause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['automaticClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['automaticClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                      
                                                        @if($pipeline_details['formData']['capitalclause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['capitalclause']['comment']))
                                                                            @if($insures_details[$i]['capitalclause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['capitalclause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['capitalclause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['capitalclause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['capitalclause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        {{-- @if($pipeline_details['formData']['water']==true)
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
             --}}
                                                        @if($pipeline_details['formData']['debris']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['debris']['comment']))
                                                                            @if($insures_details[$i]['debris']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['debris']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['debris']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['debris']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['debris']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['property']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['property']['comment']))
                                                                            @if($insures_details[$i]['property']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['property']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['property']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['property']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['property']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['errorclause']==true)
                                                        <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['errorclause']))
                                                                        
                                                                        <td class="tooltip_sec">
                                                                            <div class="ans">
                                                                                <span>{{$insures_details[$i]['errorclause']}}</span>
                                                                            </div>
                                                                        </td>
                                                                        
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                        @if(@$pipeline_details['formData']['aff_company']!='' && $pipeline_details['formData']['waiver']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['waiver']['comment']))
                                                                            @if($insures_details[$i]['waiver']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['waiver']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['waiver']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['waiver']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['waiver']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
            
                                                        @if($pipeline_details['formData']['claimclause']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['claimclause']['comment']))
                                                                            @if($insures_details[$i]['claimclause']['comment']!="")
                                                                                <td class="tooltip_sec"><div class="ans">
                                                                                        <span>{{$insures_details[$i]['claimclause']['isAgree']}}</span>
                                                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['claimclause']['comment']}}"></i> --}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['claimclause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['claimclause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                        @if($pipeline_details['formData']['Innocent']==true)
                                                        <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                    @if(isset($insures_details[$i]['Innocent']))
                                                                        
                                                                        <td class="tooltip_sec">
                                                                            <div class="ans">
                                                                                <span>{{$insures_details[$i]['Innocent']}}</span>
                                                                            </div>
                                                                        </td>
                                                                        
                                                                    @else
                                                                        <td><div class="ans">--</div></td>
                                                                    @endif
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endif
                                                    @if($pipeline_details['formData']['Noninvalidation']==true)
                                                    <tr>
                                                            @for ($i = 0; $i < $insure_count; $i++)
                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                @if(isset($insures_details[$i]['Noninvalidation']))
                                                                    
                                                                    <td class="tooltip_sec">
                                                                        <div class="ans">
                                                                            <span>{{$insures_details[$i]['Noninvalidation']}}</span>
                                                                        </div>
                                                                    </td>
                                                                    
                                                                @else
                                                                    <td><div class="ans">--</div></td>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                                        @if($pipeline_details['formData']['brokerclaim']==true)
                                                            <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['brokerclaim']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['brokerclaim']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                           {{-- @if($pipeline_details['formData']['deductible']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['deductm']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{number_format($insures_details[$i]['deductm'],2)}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}
                                           
                                            {{-- @if($pipeline_details['formData']['ratep']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['ratem']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{number_format($insures_details[$i]['ratem'],2)}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}
                                           
                                             {{-- @if($pipeline_details['formData']['premiumm']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['premiumm']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{number_format($insures_details[$i]['premiumm'],2)}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}

                                            {{-- @if($pipeline_details['formData']['warranty']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['brokeragem']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{number_format($insures_details[$i]['brokeragem'],2)}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}

                                            {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['warrantym']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{$insures_details[$i]['warrantym']}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}

                                            {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                                <tr>
                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                            @if(isset($insures_details[$i]['exclusionm']))
                                                            
                                                                <td class="tooltip_sec">
                                                                    <div class="ans">
                                                                        <span>{{$insures_details[$i]['exclusionm']}}</span>
                                                                    </div>
                                                                </td>
                                                                
                                                            @else
                                                                <td><div class="ans">--</div></td>
                                                            @endif
                                                        @endif
                                                    @endfor
                                                </tr>
                                            {{-- @endif --}}
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['specialm']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{$insures_details[$i]['specialm']}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['deductb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['deductb'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>

                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['rateb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['rateb'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['premiumb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['premiumb'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['warranty']) --}}
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['brokerageb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{number_format($insures_details[$i]['brokerageb'],2)}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['exclusion']) --}}
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['warrantyb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{$insures_details[$i]['warrantyb']}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}

                                        {{-- @if($pipeline_details['formData']['brokerage']) --}}
                                            <tr>
                                                @for ($i = 0; $i < $insure_count; $i++)
                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                        @if(isset($insures_details[$i]['exclusionb']))
                                                        
                                                            <td class="tooltip_sec">
                                                                <div class="ans">
                                                                    <span>{{$insures_details[$i]['exclusionb']}}</span>
                                                                </div>
                                                            </td>
                                                            
                                                        @else
                                                            <td><div class="ans">--</div></td>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </tr>
                                        {{-- @endif --}}
                                        <tr>
                                            @for ($i = 0; $i < $insure_count; $i++)
                                                @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                    @if(isset($insures_details[$i]['specialb']))
                                                    
                                                        <td class="tooltip_sec">
                                                            <div class="ans">
                                                                <span>{{$insures_details[$i]['specialb']}}</span>
                                                            </div>
                                                        </td>
                                                        
                                                    @else
                                                        <td><div class="ans">--</div></td>
                                                    @endif
                                                @endif
                                            @endfor
                                        </tr>
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
