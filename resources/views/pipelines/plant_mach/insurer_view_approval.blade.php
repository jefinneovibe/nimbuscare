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
            <h3 class="title" style="margin-bottom: 8px;">Contractor`s Plant and Machinery - Issuance Approvals</h3>
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
                                    @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                    <tr>
                                            <td><div class="main_question"><label class="form_label bold">Authorised repair limit</label></div></td>
                                            @if(isset($insures_details['authRepair']['comment']))
                                                @if($insures_details['authRepair']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['authRepair']['isAgree']}}</span>
                                                        <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['authRepair']['comment']}}</span>        
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                        title="" data-container="body" data-original-title="{{$insures_details['authRepair']['comment']}}"></i> --}}
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['authRepair']['isAgree']}}</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Strike, riot and civil commotion and malicious damage</label></div></td>
                                            @if(isset($insures_details['strikeRiot']['comment']))
                                                @if($insures_details['strikeRiot']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['strikeRiot']['isAgree']}}</span>
                                                        <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['strikeRiot']['comment']}}</span>        
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                        title="" data-container="body" data-original-title="{{$insures_details['strikeRiot']['comment']}}"></i> --}}
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['strikeRiot']['isAgree']}}</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Overtime, night works , works on public holidays and express freight</label></div></td>
                                            @if(isset($insures_details['overtime']['comment']))
                                            @if($insures_details['overtime']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['overtime']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['overtime']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['overtime']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['overtime']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Cover for extra charges for Airfreight</label></div></td>
                                            @if(isset($insures_details['coverExtra']['comment']))
                                            @if($insures_details['coverExtra']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['coverExtra']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['coverExtra']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['coverExtra']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['coverExtra']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Cover for underground Machinery and equipment</label></div></td>
                                            @if(isset($insures_details['coverUnder']))
                                            <td>{{$insures_details['coverUnder']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Cover for water well drilling rigs and equipment</label></div></td>
                                            @if(isset($insures_details['drillRigs']))
                                            <td>{{$insures_details['drillRigs']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Inland Transit including loading and unloading cover</label></div></td>
                                            @if(isset($insures_details['inlandTransit']['comment']))
                                            @if($insures_details['inlandTransit']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['inlandTransit']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['inlandTransit']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['inlandTransit']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['inlandTransit']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label></div></td>
                                            @if(isset($insures_details['transitRoad']['comment']))
                                            @if($insures_details['transitRoad']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['transitRoad']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['transitRoad']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['transitRoad']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['transitRoad']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales 
                                                promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label></div></td>
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
                                                        {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                        title="" data-container="body" data-original-title="{{$insures_details['thirdParty']['comment']}}"></i> --}}
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['thirdParty']['isAgree']}}</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) && isset($pipeline_details['formData']['coverHired']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cover when items are hired out</label></div></td>
                                                @if(isset($insures_details['coverHired']))
                                                <td>{{$insures_details['coverHired']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured</label></div></td>
                                            @if(isset($insures_details['autoSum']['comment']))
                                            @if($insures_details['autoSum']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['autoSum']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['autoSum']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['autoSum']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['autoSum']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Including the risk of erection, resettling and dismantling</label></div></td>
                                            @if(isset($insures_details['includRisk']))
                                            <td>{{$insures_details['includRisk']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Tool of trade extension</label></div></td>
                                            @if(isset($insures_details['tool']['comment']))
                                            @if($insures_details['tool']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['tool']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['tool']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['tool']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['tool']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">72 Hours clause</label></div></td>
                                            @if(isset($insures_details['hoursClause']))
                                            <td>{{$insures_details['hoursClause']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster Clause</label></div></td>
                                            @if(isset($insures_details['lossAdj']['comment']))
                                            @if($insures_details['lossAdj']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['lossAdj']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['lossAdj']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="lossAdjtip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['lossAdj']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['lossAdj']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Primary Insurance Clause</label></div></td>
                                            @if(isset($insures_details['primaryClause']))
                                            <td>{{$insures_details['primaryClause']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Payment on accounts clause-75%</label></div></td>
                                            @if(isset($insures_details['paymentAccount']['comment']))
                                            @if($insures_details['paymentAccount']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['paymentAccount']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['paymentAccount']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="paymentAccounttip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['paymentAccount']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['paymentAccount']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">85% condition of average</label></div></td>
                                            @if(isset($insures_details['avgCondition']))
                                            <td>{{$insures_details['avgCondition']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Automatic addition</label></div></td>
                                            @if(isset($insures_details['autoAddition']['comment']))
                                            @if($insures_details['autoAddition']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['autoAddition']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['autoAddition']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="autoAdditiontip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['autoAddition']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['autoAddition']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Cancellation clause</label></div></td>
                                            @if(isset($insures_details['cancelClause']['comment']))
                                            @if($insures_details['cancelClause']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['cancelClause']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['cancelClause']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="cancelClausetip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['cancelClause']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['cancelClause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                            @if(isset($insures_details['derbis']['comment']))
                                            @if($insures_details['derbis']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['derbis']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['derbis']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="derbistip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['derbis']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['derbis']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Repair investigation clause</label></div></td>
                                            @if(isset($insures_details['repairClause']['comment']))
                                            @if($insures_details['repairClause']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['repairClause']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['repairClause']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="repairClausetip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['repairClause']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['repairClause']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                            @if(isset($insures_details['tempRepair']['comment']))
                                            @if($insures_details['tempRepair']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['tempRepair']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['tempRepair']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="tempRepairtip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['tempRepair']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['tempRepair']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Errors & omission clause</label></div></td>
                                            @if(isset($insures_details['errorOmission']))
                                            <td>{{$insures_details['errorOmission']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Minimization of loss</label></div></td>
                                            @if(isset($insures_details['minLoss']['comment']))
                                            @if($insures_details['minLoss']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['minLoss']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['minLoss']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="minLosstip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['minLoss']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['minLoss']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                        isset($pipeline_details['formData']['crossLiability']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Cross liability</label></div></td>
                                                @if(isset($insures_details['crossLiability']['comment']))
                                                @if($insures_details['crossLiability']['comment']!="")
                                                    <td class="tooltip_sec">
                                                        <span>{{$insures_details['crossLiability']['isAgree']}}</span>
                                                        <div class="post_comments">
                                                                <div class="post_comments_main clearfix">
                                                                    <div class="media">
                                                                        <div class="media-body">
                                                                            <span  class="comment_txt">{{$insures_details['crossLiability']['comment']}}</span>        
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        {{-- <i class="fa fa-comments" data-toggle="crossLiabilitytip" data-placement="bottom" 
                                                        title="" data-container="body" data-original-title="{{$insures_details['crossLiability']['comment']}}"></i> --}}
                                                    </td>
                                                @else
                                                    <td>{{$insures_details['crossLiability']['isAgree']}}</td>
                                                @endif
                                            @else
                                                <td>--</td>
                                            @endif
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Including cover for loading/ unloading and delivery risks</label></div></td>
                                            @if(isset($insures_details['coverInclude']))
                                            <td>{{$insures_details['coverInclude']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Towing charges</label></div></td>
                                            @if(isset($insures_details['towCharge']['comment']))
                                            @if($insures_details['towCharge']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['towCharge']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['towCharge']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="towChargetip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['towCharge']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['towCharge']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true &&
                                        isset($pipeline_details['formData']['lossPayee']))
                                            <tr>
                                                <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                @if(isset($insures_details['lossPayee']))
                                                <td>{{$insures_details['lossPayee']}}</td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Agency repair</label></div></td>
                                            @if(isset($insures_details['agencyRepair']['comment']))
                                            @if($insures_details['agencyRepair']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['agencyRepair']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['agencyRepair']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="agencyRepairtip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['agencyRepair']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['agencyRepair']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Indemnity to principal</label></div></td>
                                            @if(isset($insures_details['indemnityPrincipal']))
                                            <td>{{$insures_details['indemnityPrincipal']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                            @if(isset($insures_details['propDesign']))
                                            <td>{{$insures_details['propDesign']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’</label></div></td>
                                            @if(isset($insures_details['specialAgree']))
                                            <td>{{$insures_details['specialAgree']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label></div></td>
                                            @if(isset($insures_details['declarationSum']['comment']))
                                            @if($insures_details['declarationSum']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['declarationSum']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['declarationSum']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="declarationSumtip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['declarationSum']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['declarationSum']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label></div></td>
                                            @if(isset($insures_details['salvage']['comment']))
                                            @if($insures_details['salvage']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['salvage']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['salvage']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="salvagetip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['salvage']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['salvage']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label></div></td>
                                            @if(isset($insures_details['totalLoss']['comment']))
                                            @if($insures_details['totalLoss']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['totalLoss']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['totalLoss']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="totalLosstip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['totalLoss']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['totalLoss']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Profit Sharing</label></div></td>
                                            @if(isset($insures_details['profitShare']['comment']))
                                            @if($insures_details['profitShare']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['profitShare']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['profitShare']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="profitSharetip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['profitShare']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['profitShare']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Claims procedure: Existing claim procedure attached and should form the framework for renewal period</label></div></td>
                                            @if(isset($insures_details['claimPro']['comment']))
                                            @if($insures_details['claimPro']['comment']!="")
                                                <td class="tooltip_sec">
                                                    <span>{{$insures_details['claimPro']['isAgree']}}</span>
                                                    <div class="post_comments">
                                                            <div class="post_comments_main clearfix">
                                                                <div class="media">
                                                                    <div class="media-body">
                                                                        <span  class="comment_txt">{{$insures_details['claimPro']['comment']}}</span>        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- <i class="fa fa-comments" data-toggle="claimProtip" data-placement="bottom" 
                                                    title="" data-container="body" data-original-title="{{$insures_details['claimPro']['comment']}}"></i> --}}
                                                </td>
                                            @else
                                                <td>{{$insures_details['claimPro']['isAgree']}}</td>
                                            @endif
                                        @else
                                            <td>--</td>
                                        @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Waiver of subrogation against principal</label></div></td>
                                            @if(isset($insures_details['waiver']))
                                            <td>{{$insures_details['waiver']}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Rate (in %)</label></div></td>
                                            @if(isset($insures_details['rate']))
                                            <td>{{number_format($insures_details['rate'],2)}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Premium (in %)</label></div></td>
                                            @if(isset($insures_details['premium']))
                                            <td>{{number_format($insures_details['premium'],2)}}</td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td><div class="main_question"><label class="form_label bold">Payment Terms</label></div></td>
                                            @if(isset($insures_details['payTerm']))
                                            <td>{{$insures_details['payTerm']}}</td>
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