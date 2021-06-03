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
                                                    {{@$insures_details['customerDecision']['decision']}}@if(isset($insures_details['customerDecision']['rejctReason']) && $insures_details['customerDecision']['rejctReason']!='') 
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