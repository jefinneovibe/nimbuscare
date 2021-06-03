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
            <h3 class="title" style="margin-bottom: 8px;">Business Interruption - Issuance Approvals</h3>
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
                                <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
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
                                <td><div class="main_question"><label class="form_label bold">expense to reduce the laws</label></div></td>
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
                                    <td><div class="main_question"><label class="form_label bold">Demolition and increased cost of constructio</label></div></td>
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
                                    @if(isset($insures_details['deductible']))
                                    
                                        <td>{{number_format(trim($insures_details['deductible']),2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['ratep'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Rate/premium:</label></div></td>
                                    @if(isset($insures_details['ratep']))
                                    
                                        <td>{{number_format(trim($insures_details['ratep']),2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['brokerage'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                    @if(isset($insures_details['brokerage']))
                                    
                                        <td>{{number_format(trim($insures_details['brokerage']),2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['spec_condition'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Special Condition</label></div></td>
                                    @if(isset($insures_details['spec_condition']))
                                    
                                        <td>{{number_format(trim($insures_details['spec_condition']),2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif
                            @if($pipeline_details['formData']['exclusion'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Exclusion</label></div></td>
                                    @if(isset($insures_details['exclusion']))
                                    
                                        <td>{{number_format(trim($insures_details['exclusion']),2)}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['warranty'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Warranty</label></div></td>
                                    @if(isset($insures_details['warranty']))
                                    
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
                                            {{@$insures_details['customerDecision']['decision']}} @if(isset($insures_details['customerDecision']['rejctReason']) && $insures_details['customerDecision']['rejctReason']!='') 
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