@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown</h3>
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

                                        @if($pipeline_details['formData']['localclause']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Local Jurisdiction Clause</label></div></td>
                                        @if(isset($insures_details['localclause']['comment']))
                                            @if($insures_details['localclause']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['localclause']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['localclause']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['express']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['localclause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['express']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Overtime, night works and express freight</label></div></td>
                                        @if(isset($insures_details['express']['comment']))
                                            @if($insures_details['express']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['express']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['express']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['express']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['express']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['airfreight']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Airfreight</label></div></td>
                                        @if(isset($insures_details['airfreight']['comment']))
                                            @if($insures_details['airfreight']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['airfreight']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['airfreight']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['airfreight']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['airfreight']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['addpremium']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured at pro rata additional premium</label></div></td>
                                        @if(isset($insures_details['addpremium']['comment']))
                                            @if($insures_details['addpremium']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['addpremium']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['addpremium']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['addpremium']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['addpremium']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['payAccount']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
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
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['payAccount']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['payAccount']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif
                            @if($pipeline_details['formData']['primaryclause']==true)
                            <tr>
                                <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                            
                                
                                        @if(isset($insures_details['primaryclause']))
                                            
                                            <td>{{$insures_details['primaryclause']}}</td>
                                        
                                        @else
                                            <td>--</td>
                                        @endif
                                    
                            </tr>
                        @endif
                        @if($pipeline_details['formData']['premiumClaim']==true)
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Cancellation – 60 days notice by either party subject to pro-rata refund of premium unless a claim has attached</label></div></td>
                        
                            
                                    @if(isset($insures_details['premiumClaim']))
                                        
                                        <td>{{$insures_details['premiumClaim']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                
                        </tr>
                    @endif
                            @if($pipeline_details['formData']['lossnotification']==true)
                                    <tr>
                                            <td><div class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label></div></td>
                                            @if(isset($insures_details['lossnotification']['comment']))
                                                @if($insures_details['lossnotification']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['lossnotification']['isAgree']}}</span>
                                                        <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['lossnotification']['comment']}}</span>        
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                        title="" data-container="body" data-original-title="{{$insures_details['lossnotification']['comment']}}"></i> --}}
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['lossnotification']['isAgree']}}</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                    </tr>
                            @endif

                            @if($pipeline_details['formData']['adjustmentPremium']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Adjustment of sum insured and premium (Mre-410)</label></div></td>
                                        @if(isset($insures_details['adjustmentPremium']['comment']))
                                            @if($insures_details['adjustmentPremium']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['adjustmentPremium']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['adjustmentPremium']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['adjustmentPremium']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['adjustmentPremium']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['temporaryclause']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Temporary repairs clause</label></div></td>
                                        @if(isset($insures_details['temporaryclause']['comment']))
                                            @if($insures_details['temporaryclause']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['temporaryclause']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['temporaryclause']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['temporaryclause']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['temporaryclause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            

                            @if($pipeline_details['formData']['automaticClause']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Automatic addition clause</label></div></td>
                                        @if(isset($insures_details['automaticClause']['comment']))
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
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['automaticClause']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif
                        

                            @if($pipeline_details['formData']['capitalclause']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                        @if(isset($insures_details['capitalclause']['comment']))
                                            @if($insures_details['capitalclause']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['capitalclause']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['capitalclause']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['capitalclause']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['capitalclause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['debris']==true)
                                <tr>
                                        <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                        @if(isset($insures_details['debris']['comment']))
                                            @if($insures_details['debris']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['debris']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['debris']['comment']}}</span>        
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['debris']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['debris']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['property']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                   
                                    @if(isset($insures_details['property']['comment']))
                                        @if($insures_details['property']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['property']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['property']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                title="" data-container="body" data-original-title="{{$insures_details['property']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['property']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif
                            @if($pipeline_details['formData']['errorclause']==true)
                            <tr>
                                <td><div class="main_question"><label class="form_label bold">Errors and omission clause</label></div></td>
                            
                                
                                        @if(isset($insures_details['errorclause']))
                                            
                                            <td>{{$insures_details['errorclause']}}</td>
                                        
                                        @else
                                            <td>--</td>
                                        @endif
                                    
                            </tr>
                        @endif
                            @if(@$pipeline_details['formData']['aff_company']!='' && $pipeline_details['formData']['waiver']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Waiver of subrogation</label></div></td>
                                   
                                    @if(isset($insures_details['waiver']['comment']))
                                        @if($insures_details['waiver']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['waiver']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['waiver']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                title="" data-container="body" data-original-title="{{$insures_details['waiver']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['waiver']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['claimclause']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                    
                                    @if(isset($insures_details['claimclause']['comment']))
                                        @if($insures_details['claimclause']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['claimclause']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['claimclause']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                title="" data-container="body" data-original-title="{{$insures_details['claimclause']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['claimclause']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if( $pipeline_details['formData']['Innocent']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Innocent non-disclosure</label></div></td>
                                
                                    
                                        @if(isset($insures_details['Innocent']))
                                                
                                        <td>{{$insures_details['Innocent']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                
                                
                                </tr>
                            @endif
                            @if($pipeline_details['formData']['Noninvalidation']==true)
                                    <tr>
                                        <td><div class="main_question"><label class="form_label bold">Non-invalidation clause</label></div></td>
                                    
                                        
                                            @if(isset($insures_details['Noninvalidation']))
                                                                
                                            <td>{{$insures_details['Noninvalidation']}}</td>
                                        
                                        @else
                                            <td>--</td>
                                        @endif
                                        
                                    </tr>
                            @endif
                            @if($pipeline_details['formData']['brokerclaim']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                
                                    
                                            @if(isset($insures_details['brokerclaim']))
                                                
                                                <td>{{$insures_details['brokerclaim']}}</td>
                                            
                                            @else
                                                <td>--</td>
                                            @endif
                                        
                                </tr>
                            @endif

                           {{-- @if($pipeline_details['formData']['deductm'])  --}}
                           <tr>
                            <td><div class="main_question"><label class="form_label bold">Deductible for (Machinary Breakdown): </label></div></td>
                        
                            
                                    @if(isset($insures_details['deductm']) && $insures_details['deductm']!='')
                                        
                                        <td>{{number_format($insures_details['deductm'],2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        
                        </tr>
                    {{-- @endif --}}

                    {{-- @if($pipeline_details['formData']['ratep']) --}}
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Rate required (Machinary Breakdown):</label></div></td>
                        
                            
                                    @if(isset($insures_details['ratem']) && $insures_details['ratem']!='')
                                        
                                        <td>{{number_format($insures_details['ratem'],2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        
                        </tr>
                    {{-- @endif --}}

                    {{-- @if($pipeline_details['formData']['brokerage']) --}}
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Premium required (Machinary Breakdown): </label></div></td>
                        
                            
                                    @if(isset($insures_details['premiumm']) && $insures_details['premiumm']!='')
                                        
                                        <td>{{number_format($insures_details['premiumm'],2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        
                        </tr>
                    {{-- @endif --}}

                    {{-- @if($pipeline_details['formData']['brokeragem']) --}}
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Brokerage (Machinary Breakdown)</label></div></td>
                        
                            
                                    @if(isset($insures_details['brokeragem']) && $insures_details['brokeragem']!='')
                                        
                                        <td>{{number_format($insures_details['brokeragem'],2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        
                        </tr>
                    {{-- @endif --}}

                    {{-- @if($pipeline_details['formData']['warranty']) --}}
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Warranty (Machinary Breakdown)</label></div></td>
                        
                            
                                    @if(isset($insures_details['warrantym']) && $insures_details['warrantym']!='')
                                        
                                        <td>{{$insures_details['warrantym']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        
                        </tr>
                    {{-- @endif --}}
                    {{-- @if($pipeline_details['formData']['exclusion']) --}}
                        <tr>
                            <td><div class="main_question"><label class="form_label bold">Exclusion (Machinary Breakdown)</label></div></td>
                        
                            
                                    @if(isset($insures_details['exclusionm']) && $insures_details['exclusionm']!='')
                                        
                                        <td>{{$insures_details['exclusionm']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                            
                        </tr>
                    {{-- @endif --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Special Condition (Machinary Breakdown)</label></div></td>
                    
                        
                                @if(isset($insures_details['specialm']) && $insures_details['specialm']!='')
                                    
                                    <td>{{$insures_details['specialm']}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    </tr>
                     {{-- @if($pipeline_details['formData']['deductm'])  --}}
                     <tr>
                        <td><div class="main_question"><label class="form_label bold">Deductible for (Business Interruption):  </label></div></td>
                    
                        
                                @if(isset($insures_details['deductb']) && $insures_details['deductb']!='')
                                    
                                    <td>{{number_format($insures_details['deductb'],2)}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    
                    </tr>
                {{-- @endif --}}

                {{-- @if($pipeline_details['formData']['ratep']) --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Rate required (Business Interruption): </label></div></td>
                    
                        
                                @if(isset($insures_details['rateb']) && $insures_details['rateb']!='')
                                    
                                    <td>{{number_format($insures_details['rateb'],2)}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    
                    </tr>
                {{-- @endif --}}

                {{-- @if($pipeline_details['formData']['brokerage']) --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Premium required (Business Interruption):  </label></div></td>
                    
                        
                                @if(isset($insures_details['premiumb']) && $insures_details['premiumb']!='')
                                    
                                    <td>{{number_format($insures_details['premiumb'],2)}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    
                    </tr>
                {{-- @endif --}}

                {{-- @if($pipeline_details['formData']['brokeragem']) --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Brokerage (Business Interruption):</label></div></td>
                    
                        
                                @if(isset($insures_details['brokerageb']) && $insures_details['brokerageb']!='')
                                    
                                    <td>{{number_format($insures_details['brokerageb'],2)}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    
                    </tr>
                {{-- @endif --}}

                {{-- @if($pipeline_details['formData']['warranty']) --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Warranty (Business Interruption):</label></div></td>
                    
                        
                                @if(isset($insures_details['warrantyb']) && $insures_details['warrantyb']!='')
                                    
                                    <td>{{$insures_details['warrantyb']}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    
                    </tr>
                {{-- @endif --}}
                {{-- @if($pipeline_details['formData']['exclusion']) --}}
                    <tr>
                        <td><div class="main_question"><label class="form_label bold">Exclusion (Business Interruption):</label></div></td>
                    
                        
                                @if(isset($insures_details['exclusionb']) && $insures_details['exclusionb']!='')
                                    
                                    <td>{{$insures_details['exclusionb']}}</td>
                                
                                @else
                                    <td>--</td>
                                @endif
                        
                    </tr>
                {{-- @endif --}}
                <tr>
                    <td><div class="main_question"><label class="form_label bold">Special Condition (Business Interruption):</label></div></td>
                
                    
                            @if(isset($insures_details['specialb']) && $insures_details['specialb']!='')
                                
                                <td>{{$insures_details['specialb']}}</td>
                            
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
                                                                    $insurerDiscount='0';
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
                                                                    $iibDiscount='0';
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
                                                                    $insurerFees='0';
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
                                                                    $iibFees='0';
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
                                                                    $agentCommissionAmount='0';
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
                                                                    $payableToInsurer='0';
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
                                                                    $payableByClient='0';
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