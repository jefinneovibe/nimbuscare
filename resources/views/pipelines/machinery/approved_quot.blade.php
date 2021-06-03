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
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Machinery Breakdown </h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-questionnaire/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-slip/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-quotation/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/e-comparison/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="complete"><a href="{{url('Machinery-Breakdown/quot-amendment/'.$pipelineId)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li @if($pipeline_details['status']['status']!='Issuance') class="current" @else class="complete" @endif><a href="{{url('Machinery-Breakdown/approved-quot/'.$pipelineId)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            {{--<li @if($pipeline_details['status']['status'] =='Issuance') class="current" @endif> @if($pipeline_details['status']['status'] =='Issuance') <a href="{{url('issuance/'.$pipelineId)}}" style="color: #ffffff;"><em>Issuance</em></a> @else <em>Issuance</em> @endif</li>--}}
                        </ol>
                    </nav>
                </section>
                <form name="accounts" id="accounts" method="post">
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
                    <div class="data_table compare_sec">
                        <div id="admin">
                            <div class="material-table" style="margin-bottom: 20px">
                                <div class="table-header">
                                    <span class="table-title">Approved E Quotes</span>
                                    @if(isset($pipeline_details['insurerResponse']['response']) && @$pipeline_details['insurerResponse']['response']!='')
                                        <span class="pull-right" style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">{{$pipeline_details['insurerResponse']['response']}} by the Insurer</span>
                                    @endif
                                </div>
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
                                                    <td class="main_question"><label class="form_label bold">Insurer Policy Number</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="policy_no" id="policy_no" class="form_input" value="{{@$pipeline_details['accountsDetails']['insurerPolicyNumber']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Policy Number</label></td>
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
                                                    <td class="main_question"><label class="form_label bold">Premium Invoice</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="premium_invoice" id="premium_invoice" class="form_input" value="{{@$pipeline_details['accountsDetails']['premiumInvoice']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Premium Invoice Date</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin: 0">
                                                            <input type="text" name="premium_invoice_date" id="premium_invoice_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['premiumInvoiceDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission Invoice</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="commission_invoice" id="commission_invoice" class="form_input" value="{{@$pipeline_details['accountsDetails']['commissionInvoice']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission Invoice Date</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="commission_invoice_date" id="commission_invoice_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['commissionInvoiceDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Inception Date</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="inception_date" id="inception_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['inceptionDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Expiry Date</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="expiry_date" id="expiry_date" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['expiryDate']}}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Currency</label></td>
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
                                                    <td class="main_question"><label class="form_label bold">Premium (Excl VAT) </label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input class="form_input number" name="premium" id="premium" onkeyup="commission()" value="@if($pipeline_details['accountsDetails']['premium']!=''){{number_format(@$pipeline_details['accountsDetails']['premium'],2)}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">VAT % </label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" id="vat" name="vat" class="form_input" onkeyup="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                        value = "@if($pipeline_details['accountsDetails']['vatPercent']!=''){{$pipeline_details['accountsDetails']['vatPercent']}}@endif"
                                                               @else
                                                               value = "5"
                                                                @endif>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">VAT (Total)</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="vat_total" class="form_input number"  onkeyup="reverseCalculation()" name="vat_total" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['vatTotal']!=''){{number_format($pipeline_details['accountsDetails']['vatTotal'],2)}}@endif"
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
                                                    <td class="main_question"><label class="form_label bold">Commission %</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="number" name="commision" id="commision" class="form_input" onkeyup="commission()"  value="{{round(@$pipeline_details['accountsDetails']['commissionPercent'],2)}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Commission amount (Premium)</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="commission_premium_amount" class="form_input number"  onkeyup="commissionPercent()" name="commission_premium_amount" onblur="commission()"
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
                                                    <td class="main_question"><label class="form_label bold">Commission amount (VAT)</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="commission_vat_amount"  class="form_input number" onkeyup="commission()" name="commission_vat_amount" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['commissionVat']!=''){{number_format($pipeline_details['accountsDetails']['commissionVat'],2)}}@endif"
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
                                                        <input  name="insurer_discount" id="insurer_discount" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['insurerDiscount']!=''){{number_format(@$pipeline_details['accountsDetails']['insurerDiscount'],2)}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Discount</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_discount" id="iib_discount" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibDiscount']!=''){{number_format(@$pipeline_details['accountsDetails']['iibDiscount'],2)}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurer Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input name="insurer_fees" id="insurer_fees" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['insurerFees']!=''){{number_format(@$pipeline_details['accountsDetails']['insurerFees'],2)}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_fees" id="iib_fees" class="form_input number" onkeyup="commission()" value="@if(@$pipeline_details['accountsDetails']['iibFees']!=''){{number_format(@$pipeline_details['accountsDetails']['iibFees'],2)}}@endif">
                                                    </td>
                                                </tr>
                                                {{--<tr>--}}
                                                    {{--<td class="main_question"><label class="form_label bold">Agent Commission %</label></td>--}}
                                                    {{--<td class="main_answer"></td>--}}
                                                    {{--<td>--}}
                                                        <input type="hidden" name="agent_commission_percent" id="agent_commission_percent" class="form_input"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="{{round($pipeline_details['accountsDetails']['agentCommissionPecent'],2)}}"
                                                               @else
                                                               value="50"
                                                               @endif onkeyup="commission()">
                                                    {{--</td>--}}
                                                {{--</tr>--}}
                                                {{--<tr>--}}
                                                    {{--<td class="main_question"><label class="form_label bold">Agent Commission amount</label></td>--}}
                                                    {{--<td class="main_answer"></td>--}}
                                                    {{--<td>--}}
                                                        <input id="agent_commission" type="hidden" class="form_input" onkeyup="reverseCalculation()" name="agent_commission"  onblur="commission()"
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
                                                    {{--</td>--}}
                                                {{--</tr>--}}
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">NET Premium payable to Insurer</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_to_insurer"  class="form_input number" name="payable_to_insurer" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableToInsurer']!=''){{number_format($pipeline_details['accountsDetails']['payableToInsurer'],2)}}@endif"
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
                                                    <td class="main_question"><label class="form_label bold">NET Premium Payable by Client</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_by_client" class="form_input number" name="payable_by_client" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableByClient']!=''){{number_format($pipeline_details['accountsDetails']['payableByClient'],2)}}@endif"
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
                                                    <td class="main_question"><label class="form_label bold">Payment Mode</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="payment_mode" id="payment_mode" class="form_input" value="{{@$pipeline_details['accountsDetails']['paymentMode']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cheque No</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input type="text" name="cheque_no" id="cheque_no" class="form_input" value="{{@$pipeline_details['accountsDetails']['chequeNumber']}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Date Payment sent to Insurer</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <div class="form-group table_datepicker" style="margin-bottom: 0">
                                                            <input type="text" name="date_send" id="date_send" class="form_input datetimepicker" value="{{@$pipeline_details['accountsDetails']['datePaymentInsurer']}}">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Payment Status</label></td>
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
                            <button type="submit" class="btn btn-primary pull-right btn_action">Proceed</button>
                            <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveApproved()">Save as Draft</button>
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
                commision:{
                    min :0,
                    max:100
                },
//                agent_commission_percent:{
//                    min :0,
//                    max:100
//                },
                vat:{
                    min :0,
                    max:100
                },
                premium:{
                   number:true
                }
                , vat_total:{
                   number:true
                },
                commission_premium_amount:{
                   number:true
                },
                commission_vat_amount:{
                   number:true
                },
                insurer_discount:{
                   number:true
                },
                iib_discount:{
                   number:true
                },
                insurer_fees:{
                   number:true
                },
                iib_fees:{
                   number:true
                }
            },
            messages:{
                premium:"Please enter premium.",
                commision:"Please enter commission.",
//                agent_commission_percent:"Please enter agent commission",
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
                delivery_mode:"Please enter delivery mode."
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#accounts")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                //$("#eslip_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('Machinery-Breakdown/save-account')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result == 'success')
                        {
                            location.href = "{{url('pending-issuance')}}";
                        }
                    }
                });
            }
        });
        function saveApproved()
        {
            var form_data = new FormData($("#accounts")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $('#preLoader').show();
            //$("#eslip_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('Machinery-Breakdown/save-account')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
                    if(result == 'success')
                    {
                        $('#success_message').html('Approved E-Quot is saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('Approved E-Quot saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
    </script>
@endpush
