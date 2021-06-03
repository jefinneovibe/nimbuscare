
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
                            <h2>Proposal for Machinery Breakdown</h2>
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
                                                                @if($pipeline_details['formData']['localclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Local Jurisdiction Clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['express']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['airfreight']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Airfreight</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['addpremium']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['payAccount']==true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                            </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['primaryclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['premiumClaim']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['lossnotification']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['adjustmentPremium']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['temporaryclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Temporary repairs clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['automaticClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['capitalclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['debris']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['property']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if($pipeline_details['formData']['errorclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Errors and omission clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if(@$pipeline_details['formData']['aff_company']!='' && $pipeline_details['formData']['waiver']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Waiver of subrogation</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['claimclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['Innocent']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Innocent non-disclosure</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['Noninvalidation']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['brokerclaim']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the Noninvalidation</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Deductible for (Machinary Breakdown):  </label></div></td>
                                                               
                                                            </tr>
                                                        
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Rate required (Machinary Breakdown):</label></div></td>
                                                 
                                                            </tr>
                                  
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Premium required (Machinary Breakdown): </label></div></td>
                                                            
                                                            </tr>
                                                    
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Brokerage (Machinary Breakdown) :</label></div></td>
                                                           
                                                            </tr>
                                       
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Warranty (Machinary Breakdown):</label></div></td>
                                                      
                                                            </tr>
                                            
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Exclusion (Machinary Breakdown):</label></div></td>
                                                  
                                                            </tr>
                                         
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Special Condition (Machinary Breakdown):</label></div></td>
                                                            
                                                            </tr>
                          
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Deductible for (Business Interruption): </label></div></td>
                                                   
                                                            </tr>
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption):</label></div></td>
                                                            
                                                            </tr>
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">premium (Business Interruption):</label></div></td>
                                                              
                                                            </tr>
                                                       
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption):</label></div></td>
                                                            </tr>
                                              
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption):</label></div></td>
                                                             
                                                            </tr>
                                                       
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption):</label></div></td>
                                                             
                                                            </tr>
                                                      
                                                            <tr>   
                                                                <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption): </label></div></td>
                                                           
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
                                                           
                                                                @if($pipeline_details['formData']['localclause']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['localclause']['comment']))
                                                                                @if($insures_details[$i]['localclause']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['localclause']['isAgree']}}</span>
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
                
                                                            @if($pipeline_details['formData']['debris']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['debris']['comment']))
                                                                                @if($insures_details[$i]['debris']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['debris']['isAgree']}}</span>
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

        function messageCheck(obj1)
        {
           var  valueExist=obj1.value;
            if(valueExist == ''){
                $('#'+obj1.id+'-error').show();
            }else{
                $('#'+obj1.id+'-error').hide();
            }
        }
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
            $('#select_reson_'+obj.name).hide();
            $('.height_align').hide();
            $('#process_drop_'+obj.name).attr("required",false);
            $('.process').prop("required",false);
            flag = 1;
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
                    url: '{{url('Machinery-Breakdown/customer-save')}}',
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
