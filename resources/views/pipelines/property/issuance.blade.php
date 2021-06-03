@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Property</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                {{--<section>--}}
                    {{--<nav>--}}
                        {{--<ol class="cd-breadcrumb triangle">--}}
                            {{--<li class="complete"><a href="{{url('e-questionnaire/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-slip/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-quotation/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-comparison/'.$pipelineId)}}" style="color: #ffffff;"><em>E-Comparision</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipelineId)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('approved-quot/'.$pipelineId)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                            {{--<li class="current"><em>Issuance</em></li>--}}
                        {{--</ol>--}}
                    {{--</nav>--}}
                {{--</section>--}}
                <form name="accounts" id="accounts" method="post">
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipelineId}}">
                    <input type="hidden" id="page" name="page" value="issuance">
                    <div class="data_table compare_sec">
                        <div id="admin">
                            <div class="material-table" style="margin-bottom: 20px">
                                <div class="table-header">
                                    <span class="table-title">Pending Issuance</span>
                                    @if(isset($pipeline_details['insurerResponse']['response']) && @$pipeline_details['insurerResponse']['response']!='')
                                        <span class="pull-right" style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">{{$pipeline_details['insurerResponse']['response']}} by the Insurer</span>
                                    @else
                                        <span class="pull-right" style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">Pending insurer response</span>
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

                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Adjoining building clause</label></td>
                                                
                                                    
                                                        <td>{{$insures_details['adjBusinessClause']}}</td>
                                                   
                                                
                                            </tr>
                                            @if(isset($pipeline_details['formData']['stock']) && $pipeline_details['formData']['stock']!='')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Stock Declaration clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['stockDeclaration']['isAgree']))
                                                                @if($insures_details['stockDeclaration']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['stockDeclaration']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['stockDeclaration']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['stockDeclaration']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['stockDeclaration']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['annualRent']) && $pipeline_details['formData']['annualRent']!='')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss of rent</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['lossRent']['isAgree']))
                                                                @if($insures_details['lossRent']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['lossRent']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['lossRent']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['lossRent']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['lossRent']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments" ||
                                                    $pipeline_details['formData']['businessType']=="Hotel multiple cover")
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for personal effects of staff / guests property / valuables</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['personalStaff']['isAgree']))
                                                                @if($insures_details['personalStaff']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['personalStaff']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['personalStaff']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['personalStaff']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['personalStaff']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                       
                                                    
                                                </tr>    
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover to include unregistered motorised vehicles (like passenger, luggage, laundry carts) used on or around the premises</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['coverInclude']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif  
                                            @if($pipeline_details['formData']['businessType']=="Cafes & Restaurant"
                                                || $pipeline_details['formData']['businessType']=="Clothing manufacturing"
                                                || $pipeline_details['formData']['businessType']=="Computer hardware trading/ sales"
                                                || $pipeline_details['formData']['businessType']=="Confectionery/ dairy products processing"
                                                || $pipeline_details['formData']['businessType']=="Cotton ginning wool/ textile manufacturing"
                                                || $pipeline_details['formData']['businessType']=="Department stores/ shopping malls"
                                                || $pipeline_details['formData']['businessType']=="Food & beverage manufacturers"
                                                || $pipeline_details['formData']['businessType']=="Hotels/ boarding houses/ motels/ service apartments"
                                                || $pipeline_details['formData']['businessType']=="Hotel multiple cover"
                                                || $pipeline_details['formData']['businessType']=="Livestock"
                                                || $pipeline_details['formData']['businessType']=="Mega malls & commercial centers"
                                                || $pipeline_details['formData']['businessType']=="Recreational clubs/Theme & water parks"
                                                || $pipeline_details['formData']['businessType']=="Restaurant/ catering services"
                                                || $pipeline_details['formData']['businessType']=="Souk and similar markets"
                                                || $pipeline_details['formData']['businessType']=="Supermarkets / hypermarket/ other retail shops"
                                                || $pipeline_details['formData']['businessType']=="Textile mills/ traders/ sales"
                                                || $pipeline_details['formData']['businessType']=="Warehouse/ cold storage"
                                                )
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Seasonal increase in stocks</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['seasonalIncrease']['isAgree']))
                                                                @if($insures_details['seasonalIncrease']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['seasonalIncrease']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['seasonalIncrease']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['seasonalIncrease']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['seasonalIncrease']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                                @endif
                                             
                                            @if($pipeline_details['formData']['occupancy']['type']=='Residence')
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternative accommodation</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['coverAlternative']['isAgree']))
                                                                @if($insures_details['coverAlternative']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['coverAlternative']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['coverAlternative']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverAlternative']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['coverAlternative']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                                @endif
                                                            
                                                        
                                                    
                                                </tr>
                                                @endif
                                             
                                            @if ($pipeline_details['formData']['businessType'] == "Cafes & Restaurant"
                                                || $pipeline_details['formData']['businessType'] == "Clothing manufacturing"
                                                || $pipeline_details['formData']['businessType'] == "Computer hardware trading/ sales"
                                                || $pipeline_details['formData']['businessType'] == "Confectionery/ dairy products processing"
                                                || $pipeline_details['formData']['businessType'] == "Cotton ginning wool/ textile manufacturing"
                                                || $pipeline_details['formData']['businessType'] == "Department stores/ shopping malls"
                                                || $pipeline_details['formData']['businessType'] == "Food & beverage manufacturers"
                                                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                                                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                                                || $pipeline_details['formData']['businessType'] == "Livestock"
                                                || $pipeline_details['formData']['businessType'] == "Mega malls & commercial centers"
                                                || $pipeline_details['formData']['businessType'] == "Recreational clubs/Theme & water parks"
                                                || $pipeline_details['formData']['businessType'] == "Restaurant/ catering services"
                                                || $pipeline_details['formData']['businessType'] == "Souk and similar markets"
                                                || $pipeline_details['formData']['businessType'] == "Supermarkets / hypermarket/ other retail shops"
                                                || $pipeline_details['formData']['businessType'] == "Textile mills/ traders/ sales"
                                                || $pipeline_details['formData']['businessType'] == "Warehouse/ cold storage"
                                                )  
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for exhibition risks</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['coverExihibition']}}</td>
                                                        
                                                    
                                                 </tr>

                                            @endif
                                            @if (@$pipeline_details['formData']['occupancy']['type'] == 'Warehouse'
                                                || @$pipeline_details['formData']['occupancy']['type'] == 'Factory'
                                                || @$pipeline_details['formData']['occupancy']['type'] == 'Others') 
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for property in the open</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['coverProperty']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['otherItems'] != '') 
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including property in the care, custody & control of the insured</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['propertyCare']['isAgree']))
                                                                @if($insures_details['propertyCare']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['propertyCare']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['propertyCare']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['propertyCare']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['propertyCare']['isAgree']}}</td>
                                                                @endif    
                                                                
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                </tr>
                                                @endif
                                             
                                            <tr>
                                                <td class="main_question"><label class="form_label bold">Cover for property in the open</label></td>
                                                
                                                    
                                                        <td>{{$insures_details['lossPayee']}}</td>
                                                
                                            </tr>
                                            @if ($pipeline_details['formData']['businessType'] == "Art galleries/ fine arts collection"
                                                || $pipeline_details['formData']['businessType'] == "Colleges/ Universities/ schools & educational institute"
                                                || $pipeline_details['formData']['businessType'] == "Hotels/ boarding houses/ motels/ service apartments"
                                                || $pipeline_details['formData']['businessType'] == "Hotel multiple cover"
                                                || $pipeline_details['formData']['businessType'] == "Museum/ heritage sites"
                                                ) 
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for curios and work of art</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['coverCurios']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['indemnityOwner'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Indemnity to owners and principals</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['indemnityOwner']}}</td>
                                                    
                                                </tr>
                                            @endif        
                                            @if ($pipeline_details['formData']['conductClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Conduct of business clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['conductClause']}}</td>
                                                    
                                                </tr>
                                            @endif        
                                            @if ($pipeline_details['formData']['saleClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sale of interest clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['saleClause']}}</td>
                                                    
                                                </tr>
                                            @endif        
                                            @if ($pipeline_details['formData']['fireBrigade'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Fire brigade and extinguishing clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['fireBrigade']['isAgree']))
                                                                @if($insures_details['fireBrigade']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['fireBrigade']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['fireBrigade']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['fireBrigade']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['fireBrigade']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['clauseWording'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">72 Hours clause-wording modified- the 72 hours will stretch beyond the expiration of the policy period provided the first earthquake/flood/storm occurred prior to the expiry time of the policy</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['clauseWording']}}</td>
                                                    
                                                </tr>
                                            @endif        
                                            @if ($pipeline_details['formData']['automaticReinstatement'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured at pro-rata additional premium</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['automaticReinstatement']}}</td>
                                                    
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['capitalClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Capital addition clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['capitalClause']['isAgree']))
                                                                @if($insures_details['capitalClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['capitalClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['capitalClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['capitalClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['capitalClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['mainClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Workmen’s Maintenance clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['mainClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif  
                                            @if ($pipeline_details['formData']['repairCost'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Repair investigation costs</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['repairCost']['isAgree']))
                                                                @if($insures_details['repairCost']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['repairCost']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['repairCost']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['repairCost']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['repairCost']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif     
                                            @if ($pipeline_details['formData']['debris'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['debris']['isAgree']))
                                                                @if($insures_details['debris']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['debris']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['debris']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['debris']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['debris']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif  
                                            @if($pipeline_details['formData']['reinstatementValClass'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Reinstatement Value  clause (85% condition of  average)</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['reinstatementValClass']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['waiver'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Waiver  of subrogation (against affiliates and subsidiaries)</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['waiver']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['publicClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public authorities clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['publicClause']['isAgree']))
                                                                @if($insures_details['publicClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['publicClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['publicClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['publicClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['publicClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif     
                                            @if ($pipeline_details['formData']['contentsClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">All other contents clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['contentsClause']['isAgree']))
                                                                @if($insures_details['contentsClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['contentsClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['contentsClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['contentsClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['contentsClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif  
                                            @if($pipeline_details['formData']['buildingInclude'] != '' && $pipeline_details['formData']['errorOmission'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Errors & Omissions</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['errorOmission']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['alterationClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Alteration and use  clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['alterationClause']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['tradeAccess'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Trace and Access</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['tradeAccess']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['tempRemoval'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Temporary repair clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['tempRemoval']}}</td>
                                                    
                                                </tr>
                                            @endif  
                                            @if ($pipeline_details['formData']['proFee'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Professional fees clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['proFee']['isAgree']))
                                                                @if($insures_details['proFee']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['proFee']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['proFee']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['proFee']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['proFee']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif  
                                            @if ($pipeline_details['formData']['expenseClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expediting expense clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['expenseClause']['isAgree']))
                                                                @if($insures_details['expenseClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['expenseClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['expenseClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['expenseClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['expenseClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif  
                                            @if ($pipeline_details['formData']['desigClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Designation of property clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['desigClause']['isAgree']))
                                                                @if($insures_details['desigClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['desigClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['desigClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['desigClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['desigClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['cancelThirtyClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cancellation clause-30 days either party subject to pro-rata refund of premium in either case unless a claim attached</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['cancelThirtyClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['primaryInsuranceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Primary insurance clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['primaryInsuranceClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['paymentAccountClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause (75%)</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['paymentAccountClause']['isAgree']))
                                                                @if($insures_details['paymentAccountClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['paymentAccountClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['paymentAccountClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['paymentAccountClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['paymentAccountClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['nonInvalidClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Non-invalidation clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['nonInvalidClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['warrantyConditionClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Breach of warranty or condition clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['warrantyConditionClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['escalationClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Escalation clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['escalationClause']['isAgree']))
                                                                @if($insures_details['escalationClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['escalationClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['escalationClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['escalationClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['escalationClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['addInterestClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Additional Interest Clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['addInterestClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['improvementClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Improvement and betterment clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['improvementClause']}}</td>
                                                        
                                                    
                                                </tr>
                                            @endif 
                                            @if ($pipeline_details['formData']['automaticClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic Addition deletion clause to be notified within 30 days period</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['automaticClause']['isAgree']))
                                                                @if($insures_details['automaticClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['automaticClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['automaticClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['automaticClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['automaticClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                        
                                                    
                                                </tr>
                                            @endif   
                                            @if ($pipeline_details['formData']['reduseLoseClause'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['reduseLoseClause']['isAgree']))
                                                                @if($insures_details['reduseLoseClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['reduseLoseClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['reduseLoseClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['reduseLoseClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['reduseLoseClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['buildingInclude']!='' && 
                                              $pipeline_details['formData']['demolitionClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Demolition clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['demolitionClause']['isAgree']))
                                                                @if($insures_details['demolitionClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['demolitionClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['demolitionClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['demolitionClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['demolitionClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['noControlClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">No control clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['noControlClause']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['preparationCostClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims preparation cost clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['preparationCostClause']['isAgree']))
                                                                @if($insures_details['preparationCostClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['preparationCostClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['preparationCostClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['preparationCostClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['preparationCostClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['coverPropertyCon'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for property lying in the premises in containers</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['coverPropertyCon']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['personalEffectsEmployee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Personal effects of employee including tools and bicycles</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['personalEffectsEmployee']['isAgree']))
                                                                @if($insures_details['personalEffectsEmployee']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['personalEffectsEmployee']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['personalEffectsEmployee']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['personalEffectsEmployee']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['personalEffectsEmployee']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['incidentLandTransit'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Incidental Land Transit</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['incidentLandTransit']['isAgree']))
                                                                @if($insures_details['incidentLandTransit']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['incidentLandTransit']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['incidentLandTransit']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['incidentLandTransit']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['incidentLandTransit']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['lossOrDamage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Including loss or damage due to subsidence, ground heave or landslip</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['lossOrDamage']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['nominatedLossAdjusterClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster clause-Insured can select the loss surveyor out of a panel – John Kidd LA, Cunningham Lindsey, & Miller International</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['nominatedLossAdjusterClause']['isAgree']))
                                                                @if($insures_details['nominatedLossAdjusterClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['nominatedLossAdjusterClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['nominatedLossAdjusterClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['nominatedLossAdjusterClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['nominatedLossAdjusterClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['sprinkerLeakage'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sprinkler leakage clause</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['sprinkerLeakage']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['minLossClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Minimization of loss clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['minLossClause']['isAgree']))
                                                                @if($insures_details['minLossClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['minLossClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['minLossClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['minLossClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['minLossClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['costConstruction'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Increased cost of construction</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['costConstruction']['isAgree']))
                                                                @if($insures_details['costConstruction']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['costConstruction']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['costConstruction']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['costConstruction']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['costConstruction']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['propertyValuationClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Property Valuation clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['propertyValuationClause']['isAgree']))
                                                                @if($insures_details['propertyValuationClause']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['propertyValuationClause']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['propertyValuationClause']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['propertyValuationClause']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['propertyValuationClause']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['accidentalDamage'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Including accidental damage to plate glass, interior and exterior signs</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['accidentalDamage']['isAgree']))
                                                                @if($insures_details['accidentalDamage']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['accidentalDamage']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['accidentalDamage']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accidentalDamage']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['accidentalDamage']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['auditorsFee'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditor’s fee</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['auditorsFee']['isAgree']))
                                                                @if($insures_details['auditorsFee']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['auditorsFee']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['auditorsFee']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['auditorsFee']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['auditorsFee']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['smokeSoot'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Smoke and Soot damage extension</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['smokeSoot']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['boilerExplosion'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Boiler explosion extension</label></td>
                                                    
                                                        
                                                            <td>{{$insures_details['boilerExplosion']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['strikeRiot'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Strike riot and civil commotion clause</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['strikeRiot']['isAgree']))
                                                                @if($insures_details['strikeRiot']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['strikeRiot']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['strikeRiot']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['strikeRiot']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['strikeRiot']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['chargeAirfreight'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra charges for airfreight</label></div></td>
                                                    
                                                        
                                                            @if(isset($insures_details['chargeAirfreight']['isAgree']))
                                                                @if($insures_details['chargeAirfreight']['comment']!="")
                                                                    <td class="tooltip_sec">
                                                                        <span>{{$insures_details['chargeAirfreight']['isAgree']}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details['chargeAirfreight']['comment']}}</span>        
                                                                                                </div>
                                                                                              
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['chargeAirfreight']['comment']}}"></i> --}}
                                                                        </span>
                                                                    </td>
                                                                @else
                                                                    <td>{{$insures_details['chargeAirfreight']['isAgree']}}</td>
                                                                @endif
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                    
                                                </tr>
                                            @endif
                                            @if ($pipeline_details['formData']['machinery'] != '') 
                                                @if($pipeline_details['formData']['maliciousDamage'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Malicious damage / mischief, vandalism</label></td>
                                                        
                                                            
                                                                <td>{{$insures_details['maliciousDamage']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['burglaryExtension'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Burglary Extension</label></td>
                                                        
                                                            
                                                                <td>{{$insures_details['burglaryExtension']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['burglaryFacilities'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Burglary Extension for diesel tank and similar storage facilities in the open</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['burglaryFacilities']['isAgree']))
                                                                        @if($insures_details['burglaryFacilities']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['burglaryFacilities']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['burglaryFacilities']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['burglaryFacilities']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['burglaryFacilities']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['tsunami'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Tsunami</label></td>
                                                        
                                                                <td>{{$insures_details['burglaryExtension']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['mobilePlant'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for mobile plant</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['mobilePlant']['isAgree']))
                                                                        @if($insures_details['mobilePlant']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['mobilePlant']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['mobilePlant']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['mobilePlant']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['mobilePlant']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['clearanceDrains'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Clearance of drains</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['clearanceDrains']['isAgree']))
                                                                        @if($insures_details['clearanceDrains']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['clearanceDrains']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['clearanceDrains']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['clearanceDrains']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['clearanceDrains']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['accidentalFire'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accidental discharge of fire protection</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['accidentalFire']['isAgree']))
                                                                        @if($insures_details['accidentalFire']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['accidentalFire']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['accidentalFire']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accidentalFire']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['accidentalFire']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['locationgSource'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Locating source of leak</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['locationgSource']['isAgree']))
                                                                        @if($insures_details['locationgSource']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['locationgSource']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['locationgSource']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['locationgSource']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['locationgSource']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['reWriting'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Re-writing of records</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['reWriting']['isAgree']))
                                                                        @if($insures_details['reWriting']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['reWriting']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['reWriting']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['reWriting']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['reWriting']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['landSlip'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Landslip full subsidence and ground heave</label></td>
                                                        
                                                                <td>{{$insures_details['landSlip']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['civilAuthority'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Civil authority clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['civilAuthority']['isAgree']))
                                                                        @if($insures_details['civilAuthority']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['civilAuthority']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['civilAuthority']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['civilAuthority']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['civilAuthority']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['documentsPlans'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Documents / plans / specification clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['documentsPlans']['isAgree']))
                                                                        @if($insures_details['documentsPlans']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['documentsPlans']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['documentsPlans']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['documentsPlans']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['documentsPlans']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['propertyConstruction'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Property held intrust for comission</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['propertyConstruction']['isAgree']))
                                                                        @if($insures_details['propertyConstruction']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['propertyConstruction']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['propertyConstruction']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['propertyConstruction']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['propertyConstruction']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['architecture'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Architecture or surveyor, consulting engineer & other professional fee</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['architecture']['isAgree']))
                                                                        @if($insures_details['architecture']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['architecture']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['architecture']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['architecture']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['architecture']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['automaticExtension'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic extension for one month</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['automaticExtension']['isAgree']))
                                                                        @if($insures_details['automaticExtension']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['automaticExtension']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['automaticExtension']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['automaticExtension']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['automaticExtension']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['mortguageClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Mortgage clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['mortguageClause']['isAgree']))
                                                                        @if($insures_details['mortguageClause']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['mortguageClause']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['mortguageClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['mortguageClause']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['mortguageClause']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['surveyCommittee'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Survey committee clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['surveyCommittee']['isAgree']))
                                                                        @if($insures_details['surveyCommittee']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['surveyCommittee']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['surveyCommittee']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['surveyCommittee']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['surveyCommittee']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['protectExpense'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Expense to protect preserve or reduce the loss</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['protectExpense']['isAgree']))
                                                                        @if($insures_details['protectExpense']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['protectExpense']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['protectExpense']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['protectExpense']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['protectExpense']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['tenatsClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Tenants Clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['tenatsClause']['isAgree']))
                                                                        @if($insures_details['tenatsClause']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['tenatsClause']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['tenatsClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['tenatsClause']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['tenatsClause']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['keysLockClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Keys and Lock replacement clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['keysLockClause']['isAgree']))
                                                                        @if($insures_details['keysLockClause']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['keysLockClause']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['keysLockClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['keysLockClause']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['keysLockClause']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['exploratoryCost'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Exploratory Cost</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['exploratoryCost']['isAgree']))
                                                                        @if($insures_details['exploratoryCost']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['exploratoryCost']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['exploratoryCost']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['exploratoryCost']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['exploratoryCost']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['coverStatus'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Cover for bursting,overflowing, discharging,or leaking of water tanks apparatus or pipes when premises are empty or disused</label></td>
                                                        
                                                                <td>{{$insures_details['coverStatus']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['propertyDetails'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Property in the open or open sided sheds other than building structure and machineries which are designed to exist and to operate in the open</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['propertyDetails']['isAgree']))
                                                                        @if($insures_details['propertyDetails']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['propertyDetails']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['propertyDetails']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['propertyDetails']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['propertyDetails']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['smokeSootDamage'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Smoke and soot damage extension</label></td>
                                                        
                                                                <td>{{$insures_details['smokeSootDamage']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['impactDamage'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Impact damage due to own vehicle and / or animals / third party vehicles</label></td>
                                                        
                                                                <td>{{$insures_details['impactDamage']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['curiousWorkArt'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Curious and work of art</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['curiousWorkArt']['isAgree']))
                                                                        @if($insures_details['curiousWorkArt']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['curiousWorkArt']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['curiousWorkArt']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['curiousWorkArt']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['curiousWorkArt']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                                
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['sprinklerInoperativeClause'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Sprinkler inoperative clause</label></td>
                                                        
                                                                <td>{{$insures_details['sprinklerInoperativeClause']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['sprinklerUpgradation'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Sprinkler upgradation</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['sprinklerUpgradation']['isAgree']))
                                                                        @if($insures_details['sprinklerUpgradation']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['sprinklerUpgradation']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['sprinklerUpgradation']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['sprinklerUpgradation']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['sprinklerUpgradation']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['fireProtection'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Fire protection system updating</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['fireProtection']['isAgree']))
                                                                        @if($insures_details['fireProtection']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['fireProtection']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['fireProtection']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['fireProtection']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['fireProtection']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['burglaryExtensionDiesel'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Burglary extension from diesel tank and similar storage facilities</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['burglaryExtensionDiesel']['isAgree']))
                                                                        @if($insures_details['burglaryExtensionDiesel']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['burglaryExtensionDiesel']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['burglaryExtensionDiesel']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['burglaryExtensionDiesel']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['burglaryExtensionDiesel']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['machineryBreakdown'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Machinery breakdown extension</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['machineryBreakdown']['isAgree']))
                                                                        @if($insures_details['machineryBreakdown']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['machineryBreakdown']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['machineryBreakdown']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['machineryBreakdown']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['machineryBreakdown']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['extraCover'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover of extra charges for overtime, nightwork, work on public holidays exprss freight, air freight</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['extraCover']['isAgree']))
                                                                        @if($insures_details['extraCover']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['extraCover']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['extraCover']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['extraCover']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['extraCover']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['dissappearanceDetails'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Dishonesty, Dissappearance, Distraction</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['dissappearanceDetails']['isAgree']))
                                                                        @if($insures_details['dissappearanceDetails']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['dissappearanceDetails']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['dissappearanceDetails']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['dissappearanceDetails']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['dissappearanceDetails']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['elaborationCoverage'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Elaboration of coverage</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['elaborationCoverage']['isAgree']))
                                                                        @if($insures_details['elaborationCoverage']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['elaborationCoverage']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['elaborationCoverage']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['elaborationCoverage']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['elaborationCoverage']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['permitClause'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Permit clause</label></td>
                                                        
                                                                <td>{{$insures_details['permitClause']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['repurchase'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Repurchase</label></td>
                                                        
                                                                <td>{{$insures_details['repurchase']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['bankruptcy'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Bankruptcy & insolvancy</label></td>
                                                        
                                                                <td>{{$insures_details['bankruptcy']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['aircraftDamage'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Aircraft damage</label></td>
                                                        
                                                                <td>{{$insures_details['aircraftDamage']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['appraisementClause'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Appraisement clause</label></td>
                                                        
                                                                <td>{{$insures_details['appraisementClause']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['assiatnceInsured'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Assiatnce and co-operation of the Insured</label></td>
                                                        
                                                                <td>{{$insures_details['assiatnceInsured']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['moneySafe'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Money in Safe</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['moneySafe']['isAgree']))
                                                                        @if($insures_details['moneySafe']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['moneySafe']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['moneySafe']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['moneySafe']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['moneySafe']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['moneyTransit'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Money in transit</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['moneyTransit']['isAgree']))
                                                                        @if($insures_details['moneyTransit']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['moneyTransit']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['moneyTransit']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['moneyTransit']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['moneyTransit']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['computersAllRisk'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Computers all risk including damages to computers, additional expenses and media reconstruction cost</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['computersAllRisk']['isAgree']))
                                                                        @if($insures_details['computersAllRisk']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['computersAllRisk']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['computersAllRisk']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['computersAllRisk']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['computersAllRisk']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['coverForDeterioration'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for deterioration due to change in temperature or humidity or failure / inadequate operation of an airconditioning cooling or heating system</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['coverForDeterioration']['isAgree']))
                                                                        @if($insures_details['coverForDeterioration']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['coverForDeterioration']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['coverForDeterioration']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverForDeterioration']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['coverForDeterioration']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['hailDamage'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Hail Damage</label></td>
                                                        
                                                                <td>{{$insures_details['hailDamage']}}</td>
                                                        
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['thunderboltLightening'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Thunderbolt and or lightening</label></td>
                                                        
                                                                <td>{{$insures_details['thunderboltLightening']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['waterRain'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Water / rain damage</label></td>
                                                                <td>{{$insures_details['waterRain']}}</td>
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['specifiedLocations'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Specified locations cover</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['specifiedLocations']['isAgree']))
                                                                        @if($insures_details['specifiedLocations']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['specifiedLocations']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['specifiedLocations']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['specifiedLocations']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['specifiedLocations']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['portableItems'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover to include portable items worldwide</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['portableItems']['isAgree']))
                                                                        @if($insures_details['portableItems']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['portableItems']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['portableItems']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['portableItems']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['portableItems']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['propertyAndAlteration'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">New property and alteration</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['propertyAndAlteration']['isAgree']))
                                                                        @if($insures_details['propertyAndAlteration']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['propertyAndAlteration']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['propertyAndAlteration']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['propertyAndAlteration']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['propertyAndAlteration']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['dismantleingExt'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Dismantleing and re-erection extension</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['dismantleingExt']['isAgree']))
                                                                        @if($insures_details['dismantleingExt']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['dismantleingExt']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['dismantleingExt']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['dismantleingExt']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['dismantleingExt']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['automaticPurchase'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Automatic cover for newly purchased items</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['automaticPurchase']['isAgree']))
                                                                        @if($insures_details['automaticPurchase']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['automaticPurchase']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['automaticPurchase']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['automaticPurchase']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['automaticPurchase']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['coverForTrees'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Cover for Trees, Shrubs, Plants, Lawns, Rockwork</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['coverForTrees']['isAgree']))
                                                                        @if($insures_details['coverForTrees']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['coverForTrees']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['coverForTrees']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverForTrees']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['coverForTrees']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['informReward'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Reward for Information</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['informReward']['isAgree']))
                                                                        @if($insures_details['informReward']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['informReward']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['informReward']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['informReward']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['informReward']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['coverLandscape'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Cover to include Landscaping, Fountains, Drive ways, pavement roads, minor arches and other similar items within the insured property</label></td>
                                                        
                                                                <td>{{$insures_details['coverLandscape']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['damageWalls'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Damage to walls, gates fences, neon, signs, flag poles, landscaping and other properties intented to exist or operate in the open</label></td>
                                                        
                                                                <td>{{$insures_details['damageWalls']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['occupancy']['type'] == "Building" && $pipeline_details['formData']['fitOutWorks'] == true)
                                                     <tr>
                                                        <td><div class="main_question"><label class="form_label bold">During fit out works, renovation works, or any alteration/repairs all losses above the limit of the PESP of CAR should be covered under the property</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['fitOutWorks']['isAgree']))
                                                                        @if($insures_details['fitOutWorks']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['fitOutWorks']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['fitOutWorks']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['fitOutWorks']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['fitOutWorks']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif
                                            @endif 
                                            @if($pipeline_details['formData']['coverMechanical'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for  mechanical, electrical and electronic breakdown  for fixed non-mobile plant and machinery</label></td>
                                                    
                                                            <td>{{$insures_details['coverMechanical']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['coverExtWork'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Cover for external works including sign boards,  landscaping  including trees in building/label</td>
                                                    
                                                            <td>{{$insures_details['coverExtWork']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['misdescriptionClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Misdescription Clause</td>
                                                    
                                                            <td>{{$insures_details['misdescriptionClause']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['tempRemovalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Temporary removal clause</td>
                                                    
                                                            <td>{{$insures_details['tempRemovalClause']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['otherInsuranceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Other insurance allowed clause</td>
                                                        <td>{{$insures_details['otherInsuranceClause']}}</td>
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['automaticAcqClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Automatic acquisition clause</td>
                                                    
                                                            <td>{{$insures_details['automaticAcqClause']}}</td>                                                    
                                                </tr>
                                            @endif   
                                            @if($pipeline_details['formData']['minorWorkExt'] == true)
                                                 <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Minor works extension</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['minorWorkExt']['isAgree']))
                                                                        @if($insures_details['minorWorkExt']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['minorWorkExt']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['minorWorkExt']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['minorWorkExt']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['minorWorkExt']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif                                                            
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['saleInterestClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sale of Interest Clause</td>
                                                    
                                                            <td>{{$insures_details['saleInterestClause']}}</td>
                                                    
                                                </tr>
                                            @endif    
                                            @if($pipeline_details['formData']['sueLabourClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sue and labour clause</td>
                                                    
                                                            <td>{{$insures_details['sueLabourClause']}}</td>
                                                    
                                                </tr>
                                            @endif    
                                            @if($pipeline_details['formData']['electricalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Electrical clause waiver- Loss or damage by fire to electrical or electronic appliances , installations and wiring insured by this policy arising from or occasioned by over running, overheating excessive current, short circuiting, arcing, self-heating or leakage of electricity from whatever cause (lightning included) is covered</td>
                                                    
                                                            <td>{{$insures_details['electricalClause']}}</td>
                                                    
                                                </tr>
                                            @endif    
                                            @if($pipeline_details['formData']['contractPriceClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Contract price clause</td>
                                                    
                                                            <td>{{$insures_details['contractPriceClause']}}</td>
                                                    
                                                </tr>
                                            @endif    
                                            @if($pipeline_details['formData']['sprinklerUpgradationClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Sprinkler upgradation clause</td>
                                                    
                                                            <td>{{$insures_details['sprinklerUpgradationClause']}}</td>
                                                    
                                                </tr>
                                            @endif   
                                             @if($pipeline_details['formData']['accidentalFixClass'] == true)
                                                 <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accidental damage to fixed glass, glass (other than fixed glass)</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['accidentalFixClass']['isAgree']))
                                                                        @if($insures_details['accidentalFixClass']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['accidentalFixClass']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['accidentalFixClass']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accidentalFixClass']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['accidentalFixClass']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                </tr>
                                            @endif 
                                             @if($pipeline_details['formData']['electronicInstallation'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Electronic installation, computers, data processing, equipment and other fragile or brittle object</td>
                                                    
                                                            <td>{{$insures_details['electronicInstallation']}}</td>
                                                    
                                                </tr>
                                            @endif  
                                             @if($pipeline_details['formData']['brandTrademark'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brand and trademark</td>
                                                    
                                                            <td>{{$insures_details['brandTrademark']}}</td>
                                                    
                                                </tr>
                                            @endif  
                                             @if($pipeline_details['formData']['lossNotification'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</td>
                                                    
                                                            <td>{{$insures_details['lossNotification']}}</td>
                                                    
                                                </tr>
                                            @endif  
                                             @if($pipeline_details['formData']['brockersClaimClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                    
                                                            <td>{{$insures_details['brockersClaimClause']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if (isset($pipeline_details['formData']['businessInterruption']) && $pipeline_details['formData']['businessInterruption']['business_interruption'] == true) 
                                                @if($pipeline_details['formData']['addCostWorking'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Additional increase in cost of working</td>
                                                        
                                                                <td>{{$insures_details['addCostWorking']}}</td>                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPreparationClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Claims preparation clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['claimPreparationClause']['isAgree']))
                                                                        @if($insures_details['claimPreparationClause']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['claimPreparationClause']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['claimPreparationClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['claimPreparationClause']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['claimPreparationClause']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif                                                            
                                                    </tr>
                                                @endif 
                                                @if($pipeline_details['formData']['suppliersExtension'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Suppliers extension/customer extension</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['suppliersExtension']['isAgree']))
                                                                        @if($insures_details['suppliersExtension']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['suppliersExtension']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['suppliersExtension']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['suppliersExtension']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['suppliersExtension']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif                                                            
                                                    </tr>
                                                @endif 
                                                @if($pipeline_details['formData']['accountantsClause'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Accountants clause</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['accountantsClause']['isAgree']))
                                                                        @if($insures_details['accountantsClause']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['accountantsClause']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['accountantsClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accountantsClause']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['accountantsClause']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                            
                                                    </tr>
                                                @endif 
                                                @if($pipeline_details['formData']['accountPayment'] == true)
                                                    <tr>
                                                        <td><div class="main_question"><label class="form_label bold">Payment on account</label></div></td>
                                                            
                                                                
                                                                    @if(isset($insures_details['accountPayment']['isAgree']))
                                                                        @if($insures_details['accountPayment']['comment']!="")
                                                                            <td class="tooltip_sec">
                                                                                <span>{{$insures_details['accountPayment']['isAgree']}}
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details['accountPayment']['comment']}}</span>        
                                                                                                        </div>
                                                                                                      
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accountPayment']['comment']}}"></i> --}}
                                                                                </span>
                                                                            </td>
                                                                        @else
                                                                            <td>{{$insures_details['accountPayment']['isAgree']}}</td>
                                                                        @endif
                                                                    @else
                                                                        <td>--</td>
                                                                    @endif
                                                    </tr>
                                                @endif 
                                                @if($pipeline_details['formData']['preventionDenialClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Prevention/denial of access</label></div></td>
                                                                @if(isset($insures_details['preventionDenialClause']['isAgree']))
                                                                    @if($insures_details['preventionDenialClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['preventionDenialClause']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['preventionDenialClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['preventionDenialClause']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['preventionDenialClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['premiumAdjClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Premium adjustment clause</label></div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['premiumAdjClause']['isAgree']))
                                                                    @if($insures_details['premiumAdjClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['premiumAdjClause']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['premiumAdjClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['premiumAdjClause']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['premiumAdjClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['publicUtilityClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Public utilities clause</label></div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['publicUtilityClause']['isAgree']))
                                                                    @if($insures_details['publicUtilityClause']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['publicUtilityClause']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['publicUtilityClause']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['publicUtilityClause']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['publicUtilityClause']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                            
                                                        
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['brockersClaimHandlingClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</td>
                                                    
                                                            <td>{{$insures_details['brockersClaimHandlingClause']}}</td>
                                                    
                                                </tr>
                                            @endif
                                             @if($pipeline_details['formData']['accountsRecievable'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Accounts recievable / Loss of booked debts/label</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['accountsRecievable']['isAgree']))
                                                                    @if($insures_details['accountsRecievable']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['accountsRecievable']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['accountsRecievable']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['accountsRecievable']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['accountsRecievable']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif 
                                            @if($pipeline_details['formData']['interDependency'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Interdependany clause</td>
                                                    
                                                            <td>{{$insures_details['interDependency']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['extraExpense'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Extra expense</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['extraExpense']['isAgree']))
                                                                    @if($insures_details['extraExpense']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['extraExpense']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['extraExpense']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['extraExpense']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['extraExpense']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['contaminatedWater'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Contaminated water</td>
                                                    
                                                            <td>{{$insures_details['contaminatedWater']}}</td>
                                                    
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['auditorsFeeCheck'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditors fees</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['auditorsFeeCheck']['isAgree']))
                                                                    @if($insures_details['auditorsFeeCheck']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['auditorsFeeCheck']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['auditorsFeeCheck']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['auditorsFeeCheck']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['auditorsFeeCheck']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['expenseReduceLoss'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Expense to reduce the loss</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['expenseReduceLoss']['isAgree']))
                                                                    @if($insures_details['expenseReduceLoss']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['expenseReduceLoss']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['expenseReduceLoss']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['expenseReduceLoss']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['expenseReduceLoss']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['nominatedLossAdjuster'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated loss adjuster</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['nominatedLossAdjuster']['isAgree']))
                                                                    @if($insures_details['nominatedLossAdjuster']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['nominatedLossAdjuster']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['nominatedLossAdjuster']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['nominatedLossAdjuster']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['nominatedLossAdjuster']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['outbreakDiscease'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Outbreak of discease</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['outbreakDiscease']['isAgree']))
                                                                    @if($insures_details['outbreakDiscease']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['outbreakDiscease']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['outbreakDiscease']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['outbreakDiscease']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['outbreakDiscease']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['nonPublicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of non public power supply</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['nonPublicFailure']['isAgree']))
                                                                    @if($insures_details['nonPublicFailure']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['nonPublicFailure']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['nonPublicFailure']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['nonPublicFailure']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['nonPublicFailure']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['premisesDetails'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Murder, Suicide or outbreak of discease on the premises</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['premisesDetails']['isAgree']))
                                                                    @if($insures_details['premisesDetails']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['premisesDetails']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['premisesDetails']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['premisesDetails']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['premisesDetails']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['bombscare'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Bombscare and unexploded devices on the premises</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['bombscare']['isAgree']))
                                                                    @if($insures_details['bombscare']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['bombscare']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['bombscare']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['bombscare']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['bombscare']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['bookDebits'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Book of Debts</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['bombscare']['isAgree']))
                                                                    @if($insures_details['bookDebits']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['bookDebits']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['bookDebits']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['bookDebits']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['bookDebits']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if($pipeline_details['formData']['publicFailure'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Failure of public utility</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['publicFailure']['isAgree']))
                                                                    @if($insures_details['publicFailure']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['publicFailure']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['publicFailure']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['publicFailure']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['publicFailure']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                            @endif
                                            @if (isset($pipeline_details['formData']['businessInterruption']['noLocations']) &&
                                               $pipeline_details['formData']['businessInterruption']['noLocations'] > 1) 
                                               @if($pipeline_details['formData']['departmentalClause'] == true)
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Departmental clause</td>
                                                    
                                                            <td>{{$insures_details['departmentalClause']}}</td>
                                                    
                                                </tr>
                                                @endif
                                                 @if($pipeline_details['formData']['rentLease'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Rent & Lease hold interest</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['rentLease']['isAgree']))
                                                                    @if($insures_details['rentLease']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['rentLease']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['rentLease']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['rentLease']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['rentLease']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                                @endif
                                            @endif
                                            @if(isset($pipeline_details['formData']['CoverAccomodation']) && $pipeline_details['formData']['CoverAccomodation']['coverAccomodation'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for alternate accomodation</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['coverAccomodation']['isAgree']))
                                                                    @if($insures_details['coverAccomodation']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['coverAccomodation']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['coverAccomodation']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['coverAccomodation']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['coverAccomodation']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                                @endif
                                            @if($pipeline_details['formData']['contingentBusiness'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Contingent business inetruption and contingent extra expense</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['contingentBusiness']['isAgree']))
                                                                    @if($insures_details['contingentBusiness']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['contingentBusiness']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['contingentBusiness']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['contingentBusiness']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['contingentBusiness']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                        
                                                </tr>
                                                @endif
                                            @if($pipeline_details['formData']['nonOwnedProperties'] == true)
                                                 <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Non Owned property in vicinity interuption</div></td>
                                                        
                                                            
                                                                @if(isset($insures_details['nonOwnedProperties']['isAgree']))
                                                                    @if($insures_details['nonOwnedProperties']['comment']!="")
                                                                        <td class="tooltip_sec">
                                                                            <span>{{$insures_details['nonOwnedProperties']['isAgree']}}
                                                                                    <div class="post_comments">
                                                                                            <div class="post_comments_main clearfix">
                                                                                                <div class="media">
                                                                                                    <div class="media-body">
                                                                                                        <span  class="comment_txt">{{$insures_details['nonOwnedProperties']['comment']}}</span>        
                                                                                                    </div>
                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details['nonOwnedProperties']['comment']}}"></i> --}}
                                                                            </span>
                                                                        </td>
                                                                    @else
                                                                        <td>{{$insures_details['nonOwnedProperties']['isAgree']}}</td>
                                                                    @endif
                                                                @else
                                                                    <td>--</td>
                                                                @endif
                                                </tr>
                                                @endif
                                                     @if($pipeline_details['formData']['royalties'] == true)
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Royalties</td>
                                                                <td>{{$insures_details['royalties']}}</td>
                                                        
                                                    </tr>
                                                    @endif
                                            @endif  
                                            @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                                $pipeline_details['formData']['cliamPremium'] == 'combined_data')
    
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Deductible for Property</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['deductableProperty'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['deductableBusiness'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Deductible for Business Interruption</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['deductableBusiness'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['rateCombined'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Rate (combined)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['rateCombined'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['premiumCombined'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Premium (combined)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['premiumCombined'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['brokerage'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Brokerage (combined)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['brokerage'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyProperty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['warrantyProperty']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['warrantyBusiness'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['warrantyBusiness']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionProperty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['exclusionProperty']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['exclusionBusiness'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['exclusionBusiness']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['specialProperty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['specialProperty']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['specialBusiness'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['specialBusiness']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                            @endif    
    
    
                                            @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                                $pipeline_details['formData']['cliamPremium'] == 'only_property')
    
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['deductableProperty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Deductible</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['deductableProperty'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertyRate'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Rate</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertyRate'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertyPremium'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Premium</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertyPremium'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertyBrockerage'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Brokerage</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertyBrockerage'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertyWarranty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Warranty </td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertyWarranty']}}</td>                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertyExclusion'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Exclusion</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertyExclusion']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySpecial'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Special Condition</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertySpecial']}}</td>                                                        
                                                    </tr>
                                                @endif
                                            @endif  
    
    
    
                                             @if (isset($pipeline_details['formData']['cliamPremium']) &&
                                                $pipeline_details['formData']['cliamPremium'] == 'separate_property')
    
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateDeductable'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Deductible for (Property)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateDeductable'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                               
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateRate'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Rate (Property)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateRate'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparatePremium'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Premium (Property)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparatePremium'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateBrokerage'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Brokerage (Property)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['propertySeparateBrokerage'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateWarranty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Warranty (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertySeparateWarranty']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateExclusion'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Exclusion (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertySeparateExclusion']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                               
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['propertySeparateSpecial'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Special Condition (Property)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['propertySeparateSpecial']}}</td>
                                                            
                                                        
                                                    </tr>
                                                @endif
    
    
    
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateDeductable'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Deductible for (Business Interruption)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateDeductable'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                               
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateRate'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Rate (Business Interruption)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateRate'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparatePremium'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Premium (Business Interruption)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparatePremium'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateBrokerage'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Brokerage (Business Interruption)</td>
                                                        
                                                                <td>{{number_format($insures_details['claimPremiyumDetails']['businessSeparateBrokerage'],2)}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateWarranty'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Warranty (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['businessSeparateWarranty']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                                
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateExclusion'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Exclusion (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['businessSeparateExclusion']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                               
                                                @if($pipeline_details['formData']['claimPremiyumDetails']['businessSeparateSpecial'])
                                                    <tr>
                                                        <td class="main_question"><label class="form_label bold">Special Condition (Business Interruption)</td>
                                                        
                                                                <td>{{$insures_details['claimPremiyumDetails']['businessSeparateSpecial']}}</td>
                                                        
                                                    </tr>
                                                @endif
                                               
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
                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{@$insures_details['customerDecision']['comment']}}"></i> --}}
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
                                                        <input class="form_input number" name="premium" id="premium" onkeyup="commission()" value="{{@$pr_amount}}">
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
                                                        <input id="vat_total" class="form_input number"  onkeyup="reverseCalculation()" name="vat_total" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['vatTotal']!=''){{$pipeline_details['accountsDetails']['vatTotal']}}@endif"
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
                                                        <input id="commission_premium_amount" class="form_input number"  onkeyup="commissionPercent()" name="commission_premium_amount" onblur="commission()"
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['commissionPremium']!=''){{$pipeline_details['accountsDetails']['commissionPremium']}}@endif"
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
                                                        <input id="commission_vat_amount" class="form_input number" onkeyup="commission()" name="commission_vat_amount" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value = "@if($pipeline_details['accountsDetails']['commissionVat']){{$pipeline_details['accountsDetails']['commissionVat']}}@endif"
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
                                                        <input  name="insurer_discount" id="insurer_discount" class="form_input number" onkeyup="commission()" value="@if(isset($pipeline_details['accountsDetails']['insurerDiscount']) && $pipeline_details['accountsDetails']['insurerDiscount']) {{@$pipeline_details['accountsDetails']['insurerDiscount']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Discount</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_discount" id="iib_discount" class="form_input number" onkeyup="commission()" value="@if(isset($pipeline_details['accountsDetails']['iibDiscount']) && @$pipeline_details['accountsDetails']['iibDiscount']){{@$pipeline_details['accountsDetails']['iibDiscount']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">Insurer Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input name="insurer_fees" id="insurer_fees" class="form_input number" onkeyup="commission()" value="@if(isset($pipeline_details['accountsDetails']['insurerFees']) && @$pipeline_details['accountsDetails']['insurerFees']){{@$pipeline_details['accountsDetails']['insurerFees']}}@endif">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">IIB Fees</label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input  name="iib_fees" id="iib_fees" class="form_input number" onkeyup="commission()" value="@if(isset($pipeline_details['accountsDetails']['iibFees']) &&@$pipeline_details['accountsDetails']['iibFees']){{@$pipeline_details['accountsDetails']['iibFees']}}@endif">
                                                    </td>
                                                </tr>
                                                {{-- <tr> --}}
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
                                                {{-- </tr> --}}
                                                <tr>
                                                    <td class="main_question"><label class="form_label bold">NET Premium payable to Insurer <span>*</span></label></td>
                                                    {{--<td class="main_answer"></td>--}}
                                                    <td>
                                                        <input id="payable_to_insurer"  class="form_input number" name="payable_to_insurer" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableToInsurer']!=''){{$pipeline_details['accountsDetails']['payableToInsurer']}}@endif"
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
                                                        <input id="payable_by_client"  class="form_input number" name="payable_by_client" readonly
                                                               @if(isset($pipeline_details['accountsDetails']))
                                                               value="@if($pipeline_details['accountsDetails']['payableByClient']!=''){{$pipeline_details['accountsDetails']['payableByClient']}}@endif"
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
                            <button type="submit" class="btn btn-primary pull-right btn_action" 
                            {{-- @if(!isset($pipeline_details['insurerResponse']['response']) || $pipeline_details['insurerResponse']['response']!='approved')
                            disabled data-toggle="tooltip" data-title="haii" @endif --}}
                            >Proceed</button>
                            <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveIssuance()">Save as Draft</button>
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
//            debugger;
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
                    required:true,
                    number:true
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
                vat_total:{
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
                    url: '{{url('save-account')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result == 'success')
                        {
                            location.href = "{{url('pending-approvals')}}";
                        }
                    }
                });
            }
        });
        function saveIssuance()
        {
            var form_data = new FormData($("#accounts")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('is_save','true');
            $('#preLoader').show();
            //$("#eslip_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('save-account')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    $('#preLoader').hide();
                    if(result == 'success')
                    {
                        $('#success_message').html('Details saved as draft.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $('#success_message').html('Details saving failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
    </script>
@endpush
