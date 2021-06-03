@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Business Interruption</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                
                <form name="accounts" id="accounts" method="post">
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
                    <input type="hidden" id="page" name="page" value="pending">
                    <div class="data_table compare_sec">
                        <div id="admin">
                            <div class="material-table" style="margin-bottom: 20px">
                                <div class="table-header">
                                    <span class="table-title">Pending Approval</span>
                                </div>
                                <div class="table-responsive" style="margin-bottom: 20px">
                                    <table class="comparison table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 100%" colspan="2">Selected Insurer : <b>{{$insures_details['insurerDetails']['insurerName']}}</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                           
                                                @if($pipeline_details['formData']['costWork']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Additional increase in cost of working</label></div></td>
                                                    @if(isset($insures_details['costWork']))
                                                       
                                                        <td>{{$insures_details['costWork']}}</td>
                                                      
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['claimClause']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                @if(isset($insures_details['claimClause']['comment']))
                                                    @if($insures_details['claimClause']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['claimClause']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['claimClause']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['claimClause']['comment']}}"></i> --}}
                                                            {{-- <div class="post_comments">
                                                                    <label class="form_label">Comments</label>
                                                                    <div class="post_comments_main clearfix">
                                                                        <textarea placeholder="comments..." id='claimClause_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['claimClause']['comment']}}</textarea>
                                                                 
                                                                    </div>
                                                            </div> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['claimClause']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['custExtension']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                    @if(isset($insures_details['custExtension']['comment']))
                                                    @if($insures_details['custExtension']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['custExtension']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['custExtension']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['custExtension']['comment']}}"></i> --}}
                                                            {{-- <div class="post_comments">
                                                                    <label class="form_label">Comments</label>
                                                                    <div class="post_comments_main clearfix">
                                                                        <textarea placeholder="comments..." id='custExtension_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['custExtension']['comment']}}</textarea>
                                                                 
                                                                    </div>
                                                            </div> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['custExtension']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['accountants']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                    @if(isset($insures_details['accountants']['comment']))
                                                        @if($insures_details['accountants']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['accountants']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['accountants']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accountants']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='accountants_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['accountants']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['accountants']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['payAccount']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                    @if(isset($insures_details['payAccount']['comment']))
                                                        @if($insures_details['payAccount']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['payAccount']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['payAccount']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['payAccount']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='payAccount_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['payAccount']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['payAccount']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['denialAccess']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                    @if(isset($insures_details['denialAccess']['comment']))
                                                        @if($insures_details['denialAccess']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['denialAccess']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['denialAccess']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['denialAccess']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='denialAccess_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['denialAccess']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['denialAccess']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['premiumClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                    @if(isset($insures_details['premiumClause']['comment']))
                                                        @if($insures_details['premiumClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['premiumClause']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['premiumClause']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['premiumClause']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='premiumClause_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['premiumClause']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['premiumClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['utilityClause']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                    @if(isset($insures_details['utilityClause']['comment']))
                                                        @if($insures_details['utilityClause']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['utilityClause']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['utilityClause']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['utilityClause']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='utilityClause_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['utilityClause']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['utilityClause']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['brokerClaim']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the ContingentExpense</label></div></td>
                                                    @if(isset($insures_details['brokerClaim']))
                                                    
                                                        <td>{{$insures_details['brokerClaim']}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['bookedDebts']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts</label></div></td>
                                                    @if(isset($insures_details['bookedDebts']['comment']))
                                                        @if($insures_details['bookedDebts']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['bookedDebts']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['bookedDebts']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip"
                                                                 data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['bookedDebts']['comment']}}"></i> --}}
                                                                 {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='bookedDebts_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['bookedDebts']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                                </td>
                                                        @else
                                                            <td>{{$insures_details['bookedDebts']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['interdependanyClause']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Interdependany Clause</label></div></td>
                                                @if(isset($insures_details['interdependanyClause']))
                                                   
                                                    <td>{{$insures_details['interdependanyClause']}}</td>
                                                  
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['extraExpense']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</label></div></td>
                                                    @if(isset($insures_details['extraExpense']['comment']))
                                                        @if($insures_details['extraExpense']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['extraExpense']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['extraExpense']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                                title="" data-container="body" data-original-title="{{$insures_details['extraExpense']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='extraExpense_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['extraExpense']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['extraExpense']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['water']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contaminated water</label></div></td>
                                                    @if(isset($insures_details['water']))
                                                       
                                                        <td>{{$insures_details['water']}}</td>
                                                      
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['auditorFee']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditors fees</label></div></td>
                                                    @if(isset($insures_details['auditorFee']['comment']))
                                                        @if($insures_details['auditorFee']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['auditorFee']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['auditorFee']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                                title="" data-container="body" data-original-title="{{$insures_details['auditorFee']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='auditorFee_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['auditorFee']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['auditorFee']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['expenseLaws']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
                                                    @if(isset($insures_details['expenseLaws']['comment']))
                                                        @if($insures_details['expenseLaws']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['expenseLaws']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['expenseLaws']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom"
                                                                 title="" data-container="body" data-original-title="{{$insures_details['expenseLaws']['comment']}}"></i> --}}
                                                                 {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='expenseLaws_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['expenseLaws']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                                </td>
                                                        @else
                                                            <td>{{$insures_details['expenseLaws']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['lossAdjuster']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</label></div></td>
                                                    @if(isset($insures_details['lossAdjuster']['comment']))
                                                        @if($insures_details['lossAdjuster']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['lossAdjuster']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['lossAdjuster']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['lossAdjuster']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='lossAdjuster_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['lossAdjuster']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['lossAdjuster']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['discease']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Outbreak of discease</label></div></td>
                                                @if(isset($insures_details['discease']['comment']))
                                                    @if($insures_details['discease']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['discease']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['discease']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom"
                                                             title="" data-container="body" data-original-title="{{$insures_details['discease']['comment']}}"></i> --}}
                                                             {{-- <div class="post_comments">
                                                                    <label class="form_label">Comments</label>
                                                                    <div class="post_comments_main clearfix">
                                                                        <textarea placeholder="comments..." id='discease_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['discease']['comment']}}</textarea>
                                                                 
                                                                    </div>
                                                            </div> --}}
                                                            </td>
                                                    @else
                                                        <td>{{$insures_details['discease']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['powerSupply']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</label></div></td>
                                                    @if(isset($insures_details['powerSupply']['comment']))
                                                        @if($insures_details['powerSupply']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['powerSupply']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['powerSupply']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['powerSupply']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='powerSupply_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['powerSupply']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['powerSupply']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['condition1']==true)
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</label></div></td>
                                                @if(isset($insures_details['condition1']['comment']))
                                                    @if($insures_details['condition1']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['condition1']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['condition1']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                            data-original-title="{{$insures_details['condition1']['comment']}}"></i> --}}
                                                            {{-- <div class="post_comments">
                                                                    <label class="form_label">Comments</label>
                                                                    <div class="post_comments_main clearfix">
                                                                        <textarea placeholder="comments..." id='condition1_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['condition1']['comment']}}</textarea>
                                                                 
                                                                    </div>
                                                            </div> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['condition1']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['condition2']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</label></div></td>
                                                    @if(isset($insures_details['condition2']['comment']))
                                                        @if($insures_details['condition2']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['condition2']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['condition2']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['condition2']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='condition2_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['condition2']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['condition2']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['bookofDebts']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Book of Debts</label></div></td>
                                                    @if(isset($insures_details['bookofDebts']['comment']))
                                                        @if($insures_details['bookofDebts']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['bookofDebts']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['bookofDebts']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['bookofDebts']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='bookofDebts_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['bookofDebts']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['bookofDebts']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['risk']>1 && $pipeline_details['formData']['depclause']==true)
                                            <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Departmental clause</label></div></td>
                                                    @if(isset($insures_details['depclause']))
                                                       
                                                        <td>{{$insures_details['depclause']}}</td>
                                                  
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                            </tr>
                                        @endif
                                        @if($pipeline_details['formData']['rent']==true)
                                        <tr>
                                                <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</label></div></td>
                                                @if(isset($insures_details['rent']['comment']))
                                                    @if($insures_details['rent']['comment']!="")
                                                        <td class="tooltip_sec">
                                                            <span>{{$insures_details['rent']['isAgree']}}</span>
                                                            <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['rent']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                            data-original-title="{{$insures_details['rent']['comment']}}"></i> --}}
                                                            {{-- <div class="post_comments">
                                                                    <label class="form_label">Comments</label>
                                                                    <div class="post_comments_main clearfix">
                                                                        <textarea placeholder="comments..." id='rent_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['rent']['comment']}}</textarea>
                                                                 
                                                                    </div>
                                                            </div> --}}
                                                        </td>
                                                    @else
                                                        <td>{{$insures_details['rent']['isAgree']}}</td>
                                                    @endif
                                                @else
                                                    <td>--</td>
                                                @endif
                                        </tr>
                                    @endif
                                    @if($pipeline_details['formData']['hasaccomodation']=="yes")
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</label></div></td>
                                                    @if(isset($insures_details['hasaccomodation']['comment']))
                                                        @if($insures_details['hasaccomodation']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['hasaccomodation']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['hasaccomodation']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['hasaccomodation']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='hasaccomodation_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['hasaccomodation']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['hasaccomodation']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                        @endif
                                            @if($pipeline_details['formData']['costofConstruction']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of construction</label></div></td>
                                                    @if(isset($insures_details['costofConstruction']['comment']))
                                                        @if($insures_details['costofConstruction']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['costofConstruction']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['costofConstruction']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['costofConstruction']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='costofConstruction_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['costofConstruction']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['costofConstruction']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['ContingentExpense']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</label></div></td>
                                                    @if(isset($insures_details['ContingentExpense']['comment']))
                                                        @if($insures_details['ContingentExpense']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['ContingentExpense']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['ContingentExpense']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['ContingentExpense']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='ContingentExpense_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['ContingentExpense']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['ContingentExpense']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['interuption']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</label></div></td>
                                                    @if(isset($insures_details['interuption']['comment']))
                                                        @if($insures_details['interuption']['comment']!="")
                                                            <td class="tooltip_sec">
                                                                <span>{{$insures_details['interuption']['isAgree']}}</span>
                                                                <div class="post_comments">
                                                                    <div class="post_comments_main clearfix">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span  class="comment_txt">{{$insures_details['interuption']['comment']}}</span>        
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                                data-original-title="{{$insures_details['interuption']['comment']}}"></i> --}}
                                                                {{-- <div class="post_comments">
                                                                        <label class="form_label">Comments</label>
                                                                        <div class="post_comments_main clearfix">
                                                                            <textarea placeholder="comments..." id='interuption_comment_{{$insures_details['uniqueToken']}}' readonly>{{$insures_details['interuption']['comment']}}</textarea>
                                                                     
                                                                        </div>
                                                                </div> --}}
                                                            </td>
                                                        @else
                                                            <td>{{$insures_details['interuption']['isAgree']}}</td>
                                                        @endif
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['Royalties']==true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Royalties</label></div></td>
                                                    @if(isset($insures_details['Royalties']))
                                        
                                                    <td>{{$insures_details['Royalties']}}</td>
                                                
                                                @else
                                                    <td>--</td>
                                                @endif
                                                </tr>
                                            @endif
            
                                        @if($pipeline_details['formData']['deductible'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Deductible</label></div></td>
                                                    @if(isset($insures_details['deductible']) && $insures_details['deductible']!='')
                                                    
                                                        <td>{{number_format($insures_details['deductible'],2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['ratep'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rate/premium:</label></div></td>
                                                    @if(isset($insures_details['ratep']) && $insures_details['ratep']!='')
                                                    
                                                        <td>{{number_format(trim($insures_details['ratep']),2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['brokerage'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                                    @if(isset($insures_details['brokerage']) && $insures_details['brokerage']!='')
                                                    
                                                        <td>{{number_format(trim($insures_details['brokerage']),2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['spec_condition'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                                    @if(isset($insures_details['spec_condition']) && $insures_details['spec_condition']!='')
                                                    
                                                        <td>{{number_format(trim($insures_details['spec_condition']),2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['exclusion'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                                    @if(isset($insures_details['exclusion']) && $insures_details['exclusion']!='')
                                                    
                                                        <td>{{number_format(trim($insures_details['exclusion']),2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
                
                                            @if($pipeline_details['formData']['warranty'])
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                                    @if(isset($insures_details['warranty']) && $insures_details['warranty']!='')
                                                    
                                                        <td>{{number_format(trim($insures_details['warranty']),2)}}</td>
                                                    
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                </tr>
                                            @endif
            
                                        <tr>
                                            <td class="main_question"><label class="form_label bold">CUSTOMER DECISION </label></td>
                                            {{--<td class="main_answer"></td>--}}
                                            @if(@$insures_details['customerDecision'])
                                                @if(@$insures_details['amendComment'])
                                                    <td>{{@$insures_details['customerDecision']}}<br>Comment : {{$insures_details['amendComment']}}</td>
                                                @else
                                                    <td>
                                                        {{@$insures_details['customerDecision']['decision']}}
                                                        @if(isset($insures_details['customerDecision']['rejctReason']) && $insures_details['customerDecision']['rejctReason']!='') 
                                                        ( Reason:{{@$insures_details['customerDecision']['rejctReason']}})
                                                      @endif 
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
                                                        <input class="form_input number" type="number" name="premium" id="premium" onkeyup="commission()" value="{{$pr_amount}}">
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
                                                        <input id="vat_total" type="number" class="form_input number"  onkeyup="reverseCalculation()" name="vat_total" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']['vatTotal']))
                                                               value = "{{$pipeline_details['accountsDetails']['vatTotal']}}"
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
                                                        <input id="commission_premium_amount" type="number" class="form_input number"  onkeyup="commissionPercent()" name="commission_premium_amount" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="{{$pipeline_details['accountsDetails']['commissionPremium']}}"
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
                                                        <input id="commission_vat_amount" type="number" class="form_input number"  onkeyup="commission()" name="commission_vat_amount" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "{{$pipeline_details['accountsDetails']['commissionVat']}}"
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
                                                        <input type="number" name="insurer_discount" id="insurer_discount" class="form_input number" onkeyup="commission()" @if(isset($pipeline_details['accountsDetails']))
                                                        value="{{$pipeline_details['accountsDetails']['insurerDiscount']}}"
                                                        {{-- @else
                                                        value="--" --}}
                                                         @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Discount</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" name="iib_discount" id="iib_discount" class="form_input number" onkeyup="commission()" @if(isset($pipeline_details['accountsDetails']))
                                                        value="{{$pipeline_details['accountsDetails']['iibDiscount']}}"
                                                        {{-- @else
                                                        value="--" --}}
                                                         @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurer Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" name="insurer_fees" id="insurer_fees" class="form_input number" onkeyup="commission()" @if(isset($pipeline_details['accountsDetails']))
                                                        value="{{$pipeline_details['accountsDetails']['insurerFees']}}"
                                                        {{-- @else
                                                        value="--" --}}
                                                         @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" name="iib_fees" id="iib_fees" class="form_input number" onkeyup="commission()" @if(isset($pipeline_details['accountsDetails']))
                                                        value="{{$pipeline_details['accountsDetails']['iibFees']}}"
                                                        {{-- @else
                                                        value="--" --}}
                                                         @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                <td class="main_question"><label class="form_label bold">Agent Commission %</label></td>
                                                <td>
                                                <input type="number" name="agent_commission_percent" id="agent_commission_percent" class="form_input"
                                                       @if(isset($pipeline_details['accountsDetails']))
                                                       value="{{round($pipeline_details['accountsDetails']['agentCommissionPecent'],2)}}"
                                                       @else
                                                       value="50"
                                                       @endif onkeyup="commission()">
                                                </td>
                                                </tr>
                                                <tr>
                                                <td class="main_question"><label class="form_label bold">Agent Commission amount</label></td>
                                                <td>
                                                <input id="agent_commission" type="number" class="form_input" onkeyup="reverseCalculation()" name="agent_commission" on onblur="commission()"
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
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">NET Premium payable to Insurer <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_to_insurer" type="number" class="form_input number" name="payable_to_insurer" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="{{$pipeline_details['accountsDetails']['payableToInsurer']}}"
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
                                                        <input id="payable_by_client" type="number" class="form_input number" name="payable_by_client" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="{{$pipeline_details['accountsDetails']['payableByClient']}}"
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
                            <button type="submit" class="btn btn-primary pull-right btn_action">Approve</button>
                            {{--<button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveApproved()">Save as Draft</button>--}}
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
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var agent_commission = amountTest($('#agent_commission_percent').val());
            var agent_amount = (commissionAmount*agent_commission/100).toFixed(2);
            agent_amount=numberWithCommas(agent_amount);
            $('#agent_commission').val(agent_amount);
            $('#hidden_agent_commission').val(agent_amount);

        }
        function insurerPayable()
        {
            var premium = amountTest($('#premium').val());
            var vat_total = amountTest($('#vat_total').val());
            var insurer_discount = amountTest($('#insurer_discount').val());
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var commissionVat = amountTest($('#commission_vat_amount').val());
            var payable = ((premium+vat_total)-insurer_discount-commissionAmount-commissionVat).toFixed(2);
            payable=numberWithCommas(payable);
            $('#payable_to_insurer').val(payable);
            $('#hidden_payable_to_insurer').val(payable);
        }
        function customerPayable()
        {
            var vat = $('#vat').val();
            var vat_total = amountTest($('#vat_total').val());
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
            var commissionAmount = amountTest($('#commission_premium_amount').val());
            var premium = amountTest(($('#premium').val()));
            var iib_discount = amountTest($('#iib_discount').val());
            var commission = commissionAmount/(premium-iib_discount);
            commission = (commission*100).toFixed(2);
            $('#commision').val(commission);
        }
        function agentPercent()
        {

            var agentAmount = amountTest($('#agent_commission').val());
            var commissionAmount = amountTest($('#commission_premium_amount').val());
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
                    required:true
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
                    url: '{{url('business_interruption/save-account')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result == 'success')
                        {
                            location.href = "{{url('policies')}}";
                        }
                    }
                });
            }
        });
        {{--function saveIssuance()--}}
        {{--{--}}
            {{--var form_data = new FormData($("#accounts")[0]);--}}
            {{--form_data.append('_token', '{{csrf_token()}}');--}}
            {{--form_data.append('is_save','true');--}}
            {{--$('#preLoader').show();--}}
            {{--//$("#eslip_submit").attr( "disabled", "disabled" );--}}
            {{--$.ajax({--}}
                {{--method: 'post',--}}
                {{--url: '{{url('save-account')}}',--}}
                {{--data: form_data,--}}
                {{--cache : false,--}}
                {{--contentType: false,--}}
                {{--processData: false,--}}
                {{--success: function (result) {--}}
                    {{--$('#preLoader').hide();--}}
                    {{--if(result == 'success')--}}
                    {{--{--}}
                        {{--$('#success_message').html('Issuance is saved as draft.');--}}
                        {{--$('#success_popup .cd-popup').addClass('is-visible');--}}
                    {{--}--}}
                    {{--else--}}
                    {{--{--}}
                        {{--$('#success_message').html('Issuance saving failed.');--}}
                        {{--$('#success_popup .cd-popup').addClass('is-visible');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    </script>
@endpush