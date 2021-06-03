
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
                            <h2>Proposal for Business Interruption</h2>
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
                                                          
                                                            @if($pipeline_details['formData']['costWork']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['claimClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['custExtension']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['accountants']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['payAccount']==true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                            </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['denialAccess']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of accessm</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['premiumClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['utilityClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['brokerClaim']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['bookedDebts']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts </label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['interdependanyClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Interdependany clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['extraExpense']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['water']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['auditorFee']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Auditors feest</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if($pipeline_details['formData']['expenseLaws']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['lossAdjuster']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['discease']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['powerSupply']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['condition1']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['condition2']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['bookofDebts']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            {{-- @if($pipeline_details['formData']['parties']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed 
                                                                            Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties </label></div></td>
                                                                </tr>
                                                            @endif --}}
                                                            @if($pipeline_details['formData']['rent']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['hasaccomodation']=="yes")
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation </label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['costofConstruction']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['ContingentExpense']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['interuption']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['Royalties']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rate/premium</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">YOUR DECISION  <span>*</span></label> <div class="height_align" style="display: none"></div></div></td>
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
                    
                                                                @if($pipeline_details['formData']['depclause']==true)
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
                    
                                                                {{-- @if($pipeline_details['formData']['parties']==true)
                                                                    <tr>
                                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                                @if(isset($insures_details[$i]['parties']))
                                                                                
                                                                                    <td class="tooltip_sec">
                                                                                        <div class="ans">
                                                                                            <span>{{$insures_details[$i]['parties']}}</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    
                                                                                @else
                                                                                    <td><div class="ans">--</div></td>
                                                                                @endif
                                                                            @endif
                                                                        @endfor
                                                                    </tr>
                                                                @endif --}}
                    
                                                                @if($pipeline_details['formData']['rent']==true)
                                                                    <tr>
                                                                        @for ($i = 0; $i < $insure_count; $i++)
                                                                            @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                                @if(isset($insures_details[$i]['rent']['comment']))
                                                                                    @if($insures_details[$i]['rent']['comment']!="")
                                                                                        <td class="tooltip_sec"><div class="ans">
                                                                                                <span>{{$insures_details[$i]['rent']['isAgree']}}</span>
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
                                                                                                <div class="post_comments">
                                                                                                        <div class="post_comments_main clearfix">
                                                                                                            <div class="media">
                                                                                                                <div class="media-body">
                                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['costofConstruction']['comment']}}</span>        
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
                                                                                        <span>{{number_format($insures_details[$i]['deductible'],2)}}</span>
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
                                                                                        <span>{{number_format($insures_details[$i]['ratep'],2)}}</span>
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
                                                                                        <span>{{number_format($insures_details[$i]['brokerage'],2)}}</span>
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
                                                                                        <span>{{number_format($insures_details[$i]['spec_condition'],2)}}</span>
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
                                                                                        <span>{{number_format($insures_details[$i]['warranty'],2)}}</span>
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
                                                                                        <span>{{number_format($insures_details[$i]['exclusion'],2)}}</span>
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
                                                                            <div class="reason_show" id="select_reson_{{$insures_details[$i]['uniqueToken']}}" style="display: none">
                                                                                <label class="form_label">Select reason <span>*</span></label>
                                                                                <div class="custom_select">
                                                                                        <select class="form_input process" name="reason_{{$insures_details[$i]['uniqueToken']}}" id="process_drop_{{$insures_details[$i]['uniqueToken']}}" onchange="messageCheck(this)">
                                                                                            <option value="">Select reason</option>
                                                                                            <option value="Another insurance company required">Another insurance company required </option>
                                                                                            <option value="Close the case">Close the case </option>                                                                                      
                                                                                        </select>
                                                                                </div>
                                                                            <label id="process_drop_{{$insures_details[$i]['uniqueToken']}}-error" class="error" style="display:none" for="process_drop_{{$insures_details[$i]['uniqueToken']}}">Please select reason</label>
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
                    url: '{{url('business_interruption/customer-save')}}',
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
