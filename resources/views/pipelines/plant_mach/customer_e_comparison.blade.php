
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
                <h2>Proposal for Contractor`s Plant and Machinery</h2>
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
                                                            @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Authorised repair limit</label></div></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Strike, riot and civil commotion and malicious damage</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Overtime, night works , works on public holidays and express freight</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Cover for extra charges for Airfreight</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Cover for underground Machinery and equipment</label></div></td>
                                                            </tr>
                                                            @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Cover for water well drilling rigs and equipment</label></div></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Inland Transit including loading and unloading cover</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise</label></div></td>
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) && isset($pipeline_details['formData']['coverHired']))
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover when items are hired out</label></div></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Automatic Reinstatement of sum insured</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Including the risk of erection, resettling and dismantling</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Tool of trade extension</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">72 Hours clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Nominated Loss Adjuster Clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Primary Insurance Clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Payment on accounts clause-75%</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">85% condition of average</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Automatic addition</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Cancellation clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Removal of debris</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Repair investigation clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Temporary repair clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Errors & omission clause</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Minimization of loss</label></div></td>
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                                            isset($pipeline_details['formData']['crossLiability']))
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cross liability</label></div></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Including cover for loading/ unloading and delivery risks</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Towing charges</label></div></td>
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true &&
                                                            isset($pipeline_details['formData']['lossPayee']))
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Loss payee clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Agency repair</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Indemnity to principal</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Designation of property</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Profit Sharing</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Claims procedure: Existing claim procedure attached and should form the framework for renewal period</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Waiver of subrogation against principal</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rate (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Payment Terms</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">YOUR DECISION  <span>*</span></label><div class="height_align" style="display: none"></div></div></td>
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
                                                            @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['authRepair']['comment']))
                                                                            @if($insures_details[$i]['authRepair']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['authRepair']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['authRepair']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['authRepair']['isAgree']}}</div></td>
                                                                            @endif
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
                                                                        @if(isset($insures_details[$i]['strikeRiot']['comment']))
                                                                            @if($insures_details[$i]['strikeRiot']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['strikeRiot']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['strikeRiot']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['strikeRiot']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['overtime']['comment']))
                                                                            @if($insures_details[$i]['overtime']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['overtime']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['overtime']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['overtime']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['coverExtra']['comment']))
                                                                            @if($insures_details[$i]['coverExtra']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['coverExtra']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['coverExtra']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['coverExtra']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['coverUnder']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverUnder']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['drillRigs']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['drillRigs']}}</span>
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
                                                                        @if(isset($insures_details[$i]['inlandTransit']['comment']))
                                                                            @if($insures_details[$i]['inlandTransit']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['inlandTransit']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['inlandTransit']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['inlandTransit']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['transitRoad']['comment']))
                                                                            @if($insures_details[$i]['transitRoad']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['transitRoad']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['transitRoad']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['transitRoad']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['thirdParty']['comment']))
                                                                            @if($insures_details[$i]['thirdParty']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['thirdParty']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['thirdParty']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['thirdParty']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) &&
                                                            isset($pipeline_details['formData']['coverHired']))
                                                                <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['coverHired']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverHired']}}</span>
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
                                                                        @if(isset($insures_details[$i]['autoSum']['comment']))
                                                                            @if($insures_details[$i]['autoSum']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['autoSum']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['autoSum']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['autoSum']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['includRisk']))
                                                                            
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['includRisk']}}</span>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['tool']['comment']))
                                                                            @if($insures_details[$i]['tool']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['tool']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['tool']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['tool']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['hoursClause']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['hoursClause']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['lossAdj']['comment']))
                                                                            @if($insures_details[$i]['lossAdj']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['lossAdj']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['lossAdj']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['lossAdj']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['primaryClause']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['primaryClause']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['paymentAccount']['comment']))
                                                                            @if($insures_details[$i]['paymentAccount']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['paymentAccount']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['paymentAccount']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['paymentAccount']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['avgCondition']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['avgCondition']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['autoAddition']['comment']))
                                                                            @if($insures_details[$i]['autoAddition']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['autoAddition']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['autoAddition']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['autoAddition']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['cancelClause']['comment']))
                                                                            @if($insures_details[$i]['cancelClause']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['cancelClause']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['cancelClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['cancelClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['derbis']['comment']))
                                                                            @if($insures_details[$i]['derbis']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['derbis']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['derbis']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['derbis']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['repairClause']['comment']))
                                                                            @if($insures_details[$i]['repairClause']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['repairClause']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['repairClause']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['repairClause']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['tempRepair']['comment']))
                                                                            @if($insures_details[$i]['tempRepair']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['tempRepair']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['tempRepair']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['tempRepair']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['errorOmission']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['errorOmission']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['minLoss']['comment']))
                                                                            @if($insures_details[$i]['minLoss']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['minLoss']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['minLoss']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['minLoss']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                                            isset($pipeline_details['formData']['crossLiability']))
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['crossLiability']['comment']))
                                                                                @if($insures_details[$i]['crossLiability']['comment']!="")
                                                                                    <td class="tooltip_sec">
                                                                                        <div class="ans">
                                                                                            <span>{{$insures_details[$i]['crossLiability']['isAgree']}}</span>
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['crossLiability']['comment']}}</span>        
                                                                                                            </div>
                                                                                                            
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['crossLiability']['isAgree']}}</div></td>
                                                                                @endif
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
                                                                        @if(isset($insures_details[$i]['coverInclude']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['coverInclude']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['towCharge']['comment']))
                                                                            @if($insures_details[$i]['towCharge']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['towCharge']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['towCharge']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['towCharge']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee']))
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['lossPayee']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['lossPayee']}}</span>
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
                                                                        @if(isset($insures_details[$i]['agencyRepair']['comment']))
                                                                            @if($insures_details[$i]['agencyRepair']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['agencyRepair']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['agencyRepair']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['agencyRepair']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['indemnityPrincipal']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['indemnityPrincipal']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['propDesign']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['propDesign']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['specialAgree']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['specialAgree']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['declarationSum']['comment']))
                                                                            @if($insures_details[$i]['declarationSum']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['declarationSum']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['declarationSum']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['declarationSum']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['salvage']['comment']))
                                                                            @if($insures_details[$i]['salvage']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['salvage']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['salvage']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['salvage']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['totalLoss']['comment']))
                                                                            @if($insures_details[$i]['totalLoss']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['totalLoss']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['totalLoss']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['totalLoss']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['profitShare']['comment']))
                                                                            @if($insures_details[$i]['profitShare']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['profitShare']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['profitShare']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['profitShare']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['claimPro']['comment']))
                                                                            @if($insures_details[$i]['claimPro']['comment']!="")
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['claimPro']['isAgree']}}</span>
                                                                                        <div class="post_comments">
                                                                                                <div class="post_comments_main clearfix">
                                                                                                    <div class="media">
                                                                                                        <div class="media-body">
                                                                                                            <span  class="comment_txt">{{$insures_details[$i]['claimPro']['comment']}}</span>        
                                                                                                        </div>
                                                                                                        
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                </td>
                                                                            @else
                                                                                <td><div class="ans">{{$insures_details[$i]['claimPro']['isAgree']}}</div></td>
                                                                            @endif
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['waiver']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['waiver']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['rate']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{number_format($insures_details[$i]['rate'],2)}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['premium']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{number_format($insures_details[$i]['premium'],2)}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
                                                            <tr>
                                                                @for ($i = 0; $i < $insure_count; $i++)
                                                                    @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                        @if(isset($insures_details[$i]['payTerm']))
                                                                            <td class="tooltip_sec">
                                                                                <div class="ans">
                                                                                    <span>{{$insures_details[$i]['payTerm']}}</span>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td><div class="ans">--</div></td>
                                                                        @endif
                                                                    @endif
                                                                @endfor
                                                            </tr>
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
                                                                            <div class="reason_show" id="select_reson_{{$insures_details[$i]['uniqueToken']}}" style="display:none">
                                                                                    <label class="form_label">Select reason <span>*</span></label>
                                                                                    <div class="custom_select">
                                                                                            <select class="form_input process" name="reason_{{$insures_details[$i]['uniqueToken']}}" id="process_drop_{{$insures_details[$i]['uniqueToken']}}" onchange="messageCheck(this)">
                                                                                                <option value="">Select reason</option>
                                                                                                <option value="Another insurance company required">Another insurance company required </option>
                                                                                                <option value="Close the case">Close the case </option>                                                                                      
                                                                                            </select>
                                                                                    </div>
                                                                                    <label id="process_drop_{{$insures_details[$i]['uniqueToken']}}-error" class="error" for="process_drop_{{$insures_details[$i]['uniqueToken']}}" style="display:none">Please select this field</label>
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

var flag = 0;
$(document).ready(function(){
$('#btn_reject').on('click', function(){
    $('#preLoader').show();
});
});
function messageCheck(obj1)
{
var  valueExist=obj1.value;
if(valueExist == ''){
    $('#'+obj1.id+'-error').show();
}else{
    $('#'+obj1.id+'-error').hide();
}
}
function checkApprove(obj)
{
jQuery("input, textarea")
    .not("."+obj.name)
    .not(".not_hidden")
    .removeAttr("checked", "checked").attr("disabled", "disabled");
$('#decision-error').hide();
flag = 1;
$('#select_reson_'+obj.name).hide();
$('.height_align').hide();
$('#process_drop_'+obj.name).attr("required",false);
$('.process').prop("required",false);
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
        url: '{{url('customer-save')}}',
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
