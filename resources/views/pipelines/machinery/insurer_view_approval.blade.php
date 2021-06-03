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
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown - Issuance Approvals</h3>
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