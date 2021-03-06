@extends('layouts.customer')
@include('includes.loader')
@section('content')
    <main class="layout_content">
        <div class="page_content">
    <div class="section_details">
        <div class="card_header clearfix">
            <div class="customer_logo">
                {{-- <img src="{{URL::asset('img/main/interactive_logo.png')}}"> --}}
            </div>
            <h3 class="title" style="margin-bottom: 8px;">Money - Issuance Approvals</h3>
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
                           
                                @if($pipeline_details['formData']['coverLoss']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for loss or damage due to  Riots and Strikes</label></div></td>
                                    @if(isset($insures_details['coverLoss']))
                                       
                                        <td>{{$insures_details['coverLoss']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['coverDishonest']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for dishonesty  of the employees if found out within 7 days</label></div></td>
                                    @if(isset($insures_details['coverDishonest']))
                                       
                                        <td>{{$insures_details['coverDishonest']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['coverHoldup']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for hold up</label></div></td>
                                    @if(isset($insures_details['coverHoldup']))
                                       
                                        <td>{{$insures_details['coverHoldup']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['lossDamage']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to cases / bags while being used for carriage of money</label></div></td>
                                    @if(isset($insures_details['lossDamage']['comment']))
                                        @if($insures_details['lossDamage']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['lossDamage']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['lossDamage']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['lossDamage']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['lossDamage']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['claimCost']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Claims Preparation cost</label></div></td>
                                    @if(isset($insures_details['claimCost']['comment']))
                                        @if($insures_details['claimCost']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['claimCost']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['claimCost']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['claimCost']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['claimCost']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['additionalPremium']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured  at pro-rata additional premium</label></div></td>
                                    @if(isset($insures_details['additionalPremium']))
                                       
                                        <td>{{$insures_details['additionalPremium']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']==true &&  ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
                            || $pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                            || $pipeline_details['formData']['businessType']=="Car dealer/ showroom"
                            || $pipeline_details['formData']['businessType']=="Cinema Hall auditoriums"
                            || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                            || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                            || $pipeline_details['formData']['businessType']=="Electronic trading/ sales"
                            || $pipeline_details['formData']['businessType']=="Entertainment venues"
                            || $pipeline_details['formData']['businessType']=="Furniture shops/ manufacturing units"
                            || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                            || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                            || $pipeline_details['formData']['businessType']=="Jewelry manufacturing/ trade"
                            || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                            || $pipeline_details['formData']['businessType']=="Mobile shops"
                            || $pipeline_details['formData']['businessType']=="Movie theaters"
                            || $pipeline_details['formData']['businessType']=="Museum/ heritage sites"
                            || $pipeline_details['formData']['businessType']=="Petrol diesel & gas filling stations"
                            || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                            || $pipeline_details['formData']['businessType']=="Refrigerated distribution"
                            || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                            || $pipeline_details['formData']['businessType']=="Salons/ grooming services"
                            || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                            || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"))
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks</label></div></td>
                                    @if(isset($insures_details['storageRisk']))
                                       
                                        <td>{{$insures_details['storageRisk']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['lossNotification']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Loss notification ??? ???as soon as reasonably practicable???</label></div></td>
                                    @if(isset($insures_details['lossNotification']['comment']))
                                        @if($insures_details['lossNotification']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['lossNotification']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['lossNotification']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['lossNotification']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['lossNotification']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['cancellation']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cancellation ??? 30 days notice by either party; refund of premium at pro-rata unless a claim has attached </label></div></td>
                                    @if(isset($insures_details['cancellation']))
                                    
                                        <td>{{$insures_details['cancellation']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['thirdParty']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Third party money's for which responsibility is assumed will be covered</label></div></td>
                                    @if(isset($insures_details['thirdParty']['comment']))
                                        @if($insures_details['thirdParty']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['thirdParty']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['thirdParty']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" -
                                                 data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['thirdParty']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['thirdParty']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['carryVehicle']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Carry by own vehicle / hired vehicles and / or on foot personal money of owners</label></div></td>
                                    @if(isset($insures_details['carryVehicle']['comment']))
                                        @if($insures_details['carryVehicle']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['carryVehicle']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['carryVehicle']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom"  
                                                title="" data-container="body" data-original-title="{{$insures_details['carryVehicle']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['carryVehicle']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['nominatedLoss']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss adjuster ??? Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select</label></div></td>
                                    @if(isset($insures_details['nominatedLoss']['comment']))
                                        @if($insures_details['nominatedLoss']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['nominatedLoss']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['nominatedLoss']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                title="" data-container="body" data-original-title="{{$insures_details['nominatedLoss']['comment']}}"></i>  --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['nominatedLoss']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['errorsClause']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Errors and Omissions clause</label></div></td>
                                    @if(isset($insures_details['errorsClause']))
                                       
                                        <td>{{$insures_details['errorsClause']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['personalAssault']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for personal assault</label></div></td>
                                    @if(isset($insures_details['personalAssault']['comment']))
                                        @if($insures_details['personalAssault']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['personalAssault']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['personalAssault']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                title="" data-container="body" data-original-title="{{$insures_details['personalAssault']['comment']}}"></i>  --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['personalAssault']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['accountantFees']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Auditor???s fees/ accountant fees</label></div></td>
                                    @if(isset($insures_details['accountantFees']['comment']))
                                        @if($insures_details['accountantFees']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['accountantFees']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['accountantFees']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                 title="" data-container="body" data-original-title="{{$insures_details['accountantFees']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['accountantFees']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['sustainedFees']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for damages sustained to safe</label></div></td>
                                    @if(isset($insures_details['sustainedFees']['comment']))
                                        @if($insures_details['sustainedFees']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['sustainedFees']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['sustainedFees']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" 
                                                data-original-title="{{$insures_details['sustainedFees']['comment']}}"></i>  --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['sustainedFees']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['primartClause']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                    @if(isset($insures_details['primartClause']))
                                       
                                        <td>{{$insures_details['primartClause']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['accountClause']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                    @if(isset($insures_details['accountClause']['comment']))
                                        @if($insures_details['accountClause']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['accountClause']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['accountClause']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"  
                                                data-original-title="{{$insures_details['accountClause']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['accountClause']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['lossParkingAReas']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label></div></td>
                                    @if(isset($insures_details['lossParkingAReas']))
                                       
                                        <td>{{$insures_details['lossParkingAReas']}}</td>
                                      
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['worldwideCover']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)</label></div></td>
                                    @if(isset($insures_details['worldwideCover']['comment']))
                                        @if($insures_details['worldwideCover']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['worldwideCover']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['worldwideCover']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"  
                                                data-original-title="{{$insures_details['worldwideCover']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['worldwideCover']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['locationAddition']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Automatic addition of location</label></div></td>
                                    @if(isset($insures_details['locationAddition']['comment']))
                                        @if($insures_details['locationAddition']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['locationAddition']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['locationAddition']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"  
                                                data-original-title="{{$insures_details['locationAddition']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['locationAddition']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if(isset($pipeline_details['formData']['moneyCarrying']) &&$pipeline_details['formData']['moneyCarrying']==true && ($pipeline_details['formData']['agencies']=='yes'))
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country </label></div></td>
                                    @if(isset($insures_details['moneyCarrying']['comment']))
                                        @if($insures_details['moneyCarrying']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['moneyCarrying']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['moneyCarrying']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"  
                                                data-original-title="{{$insures_details['moneyCarrying']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['moneyCarrying']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['parties']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                    @if(isset($insures_details['parties']))
                                    
                                        <td>{{$insures_details['parties']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['personalEffects']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to personal effect</label></div></td>
                                    @if(isset($insures_details['personalEffects']['comment']))
                                        @if($insures_details['personalEffects']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['personalEffects']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['personalEffects']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"  
                                                data-original-title="{{$insures_details['personalEffects']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['personalEffects']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['holdUp']==true)
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up</label></div></td>
                                    @if(isset($insures_details['holdUp']['comment']))
                                        @if($insures_details['holdUp']['comment']!="")
                                            <td class="tooltip_sec">
                                                <span>{{$insures_details['holdUp']['isAgree']}}</span>
                                                <div class="post_comments">
                                                        <div class="post_comments_main clearfix">
                                                            <div class="media">
                                                                <div class="media-body">
                                                                    <span  class="comment_txt">{{$insures_details['holdUp']['comment']}}</span>        
                                                                </div>
                                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"   
                                                data-original-title="{{$insures_details['holdUp']['comment']}}"></i> --}}
                                            </td>
                                        @else
                                            <td>{{$insures_details['holdUp']['isAgree']}}</td>
                                        @endif
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['transitdRate'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Rate (Money in Transit) (in %)</label></div></td>
                                    @if(isset($insures_details['transitdRate']))
                                    
                                        <td>{{$insures_details['transitdRate']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['safeRate'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Rate (Money in Safe) (in %)</label></div></td>
                                    @if(isset($insures_details['safeRate']))
                                    
                                        <td>{{$insures_details['safeRate']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['premiumTransit'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Premium (Money in Transit) (in %)</label></div></td>
                                    @if(isset($insures_details['premiumTransit']))
                                    
                                        <td>{{$insures_details['premiumTransit']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['premiumSafe'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Premium (Money in Safe) (in %)</label></div></td>
                                    @if(isset($insures_details['premiumSafe']))
                                    
                                        <td>{{$insures_details['premiumSafe']}}</td>
                                    
                                    @else
                                        <td>--</td>
                                    @endif
                                </tr>
                            @endif

                            @if($pipeline_details['formData']['brokerage'])
                                <tr>
                                    <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                    @if(isset($insures_details['brokerage']))
                                    
                                        <td>{{$insures_details['brokerage']}}</td>
                                    
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