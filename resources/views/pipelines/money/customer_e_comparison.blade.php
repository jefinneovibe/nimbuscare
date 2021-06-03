
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
                            <h2>Proposal for Money</h2>
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
                                                          
                                                            @if($pipeline_details['formData']['coverLoss']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss or damage due to  Riots and Strikes</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['coverDishonest']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for dishonesty  of the employees if found out within 7 days</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['coverHoldup']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for hold up</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['lossDamage']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to cases / bags while being used for carriage of money</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['claimCost']==true)
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Claims Preparation cost</label></div></td>
                                                            </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['additionalPremium']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured  at pro-rata additional premium</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']==true && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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
                                                                    <td><div class="main_question"><label class="form_label bold">Automatic increase to 4 times the approved limits during week ends and public holidays for storage risks </label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['lossNotification']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Loss notification – ‘as soon as reasonably practicable'</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['cancellation']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached </label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['thirdParty']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Third party money's for which responsibility is assumed will be covered</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['carryVehicle']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Carry by own vehicle / hired vehicles and / or on foot personal money of owners</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['nominatedLoss']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['errorsClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Errors and Omissions clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['personalAssault']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for personal assault</label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if($pipeline_details['formData']['accountantFees']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Auditor’s fees/ accountant fee</label></div></td>
                                                                </tr>
                                                            @endif
                                                           
                                                            @if($pipeline_details['formData']['sustainedFees']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for damages sustained to safe</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['primartClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['accountClause']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['lossParkingAReas']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['worldwideCover']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['locationAddition']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition of location</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if(isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying']==true && ($pipeline_details['formData']['agencies']=='yes'))
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country</label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['parties']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed 
                                                                            Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties </label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['personalEffects']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to personal effect </label></div></td>
                                                                </tr>
                                                            @endif
                                                            @if($pipeline_details['formData']['holdUp']==true)
                                                                <tr>
                                                                    <td><div class="main_question"><label class="form_label bold">Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up </label></div></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rate (Money in Transit) (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Rate (Money in Safe) (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (Money in Transit) (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Premium (Money in Safe) (in %)</label></div></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
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
                                                           
                                                            @if($pipeline_details['formData']['coverLoss']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['coverLoss']))
                                                                               
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['coverLoss']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['coverDishonest']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['coverDishonest']))
                                                                                
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['coverDishonest']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['coverHoldup']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['coverHoldup']))
                                                                                
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['coverHoldup']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['lossDamage']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['lossDamage']['comment']))
                                                                                @if($insures_details[$i]['lossDamage']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['lossDamage']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossDamage']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='lossDamage_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['lossDamage']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['lossDamage']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['lossDamage']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['claimCost']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['claimCost']['comment']))
                                                                                @if($insures_details[$i]['claimCost']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['claimCost']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                             data-original-title="{{$insures_details[$i]['claimCost']['comment']}}"></i> --}}
                                                                                             {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='claimCost_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['claimCost']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['claimCost']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['claimCost']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['additionalPremium']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['additionalPremium']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['additionalPremium']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['storageRisk']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['storageRisk']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['lossNotification']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['lossNotification']['comment']))
                                                                                @if($insures_details[$i]['lossNotification']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['lossNotification']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['lossNotification']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['lossNotification']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['lossNotification']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['lossNotification']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['cancellation']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['cancellation']))
                                                                                
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['cancellation']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['thirdParty']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['thirdParty']['comment']))
                                                                                @if($insures_details[$i]['thirdParty']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['thirdParty']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['thirdParty']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['thirdParty']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
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
                                                            @endif
                
                                                            @if($pipeline_details['formData']['carryVehicle']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['carryVehicle']['comment']))
                                                                                @if($insures_details[$i]['carryVehicle']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['carryVehicle']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['carryVehicle']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='carryVehicle_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['carryVehicle']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['carryVehicle']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['carryVehicle']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['nominatedLoss']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['nominatedLoss']['comment']))
                                                                                @if($insures_details[$i]['nominatedLoss']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['nominatedLoss']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['nominatedLoss']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='nominatedLoss_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['nominatedLoss']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['nominatedLoss']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['nominatedLoss']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['errorsClause']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['errorsClause']))
                                                                                
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['errorsClause']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['personalAssault']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['personalAssault']['comment']))
                                                                                @if($insures_details[$i]['personalAssault']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['personalAssault']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['personalAssault']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='personalAssault_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['personalAssault']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['personalAssault']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['personalAssault']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['accountantFees']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['accountantFees']['comment']))
                                                                                @if($insures_details[$i]['accountantFees']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['accountantFees']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['accountantFees']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='accountantFees_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['accountantFees']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['accountantFees']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['accountantFees']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['sustainedFees']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['sustainedFees']['comment']))
                                                                                @if($insures_details[$i]['sustainedFees']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['sustainedFees']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['sustainedFees']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='sustainedFees_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['sustainedFees']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['sustainedFees']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['sustainedFees']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['primartClause']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['primartClause']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['primartClause']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['accountClause']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['accountClause']['comment']))
                                                                                @if($insures_details[$i]['accountClause']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['accountClause']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['accountClause']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='accountClause_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['accountClause']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['accountClause']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['accountClause']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['lossParkingAReas']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['lossParkingAReas']))
                                                                               
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['lossParkingAReas']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['worldwideCover']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['worldwideCover']['comment']))
                                                                                @if($insures_details[$i]['worldwideCover']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['worldwideCover']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['worldwideCover']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='worldwideCover_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['worldwideCover']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['worldwideCover']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['worldwideCover']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['locationAddition']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['locationAddition']['comment']))
                                                                                @if($insures_details[$i]['locationAddition']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['locationAddition']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['locationAddition']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='locationAddition_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['locationAddition']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['locationAddition']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['locationAddition']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if(isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying']==true && ($pipeline_details['formData']['agencies']=='yes'))
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['moneyCarrying']['comment']))
                                                                                @if($insures_details[$i]['moneyCarrying']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['moneyCarrying']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['moneyCarrying']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='moneyCarrying_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['moneyCarrying']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['moneyCarrying']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['moneyCarrying']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['parties']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['parties']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['parties']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['personalEffects']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['personalEffects']['comment']))
                                                                                @if($insures_details[$i]['personalEffects']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['personalEffects']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['personalEffects']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='personalEffects_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['personalEffects']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['personalEffects']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['personalEffects']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['holdUp']==true)
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['holdUp']['comment']))
                                                                                @if($insures_details[$i]['holdUp']['comment']!="")
                                                                                    <td class="tooltip_sec"><div class="ans">
                                                                                            <span>{{$insures_details[$i]['holdUp']['isAgree']}}</span>
                                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body"
                                                                                            data-original-title="{{$insures_details[$i]['holdUp']['comment']}}"></i> --}}
                                                                                            {{-- <div class="post_comments">
                                                                                                    <label class="form_label">Comments</label>
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <textarea placeholder="comments..." id='holdUp_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['holdUp']['comment']}}</textarea>
                                                                                                 
                                                                                                    </div>
                                                                                            </div> --}}
                                                                                            <div class="post_comments">
                                                                                                    <div class="post_comments_main clearfix">
                                                                                                        <div class="media">
                                                                                                            <div class="media-body">
                                                                                                                <span  class="comment_txt">{{$insures_details[$i]['holdUp']['comment']}}</span>        
                                                                                                            </div>
                                                                                                          
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                        </div>
                                                                                    </td>
                                                                                @else
                                                                                    <td><div class="ans">{{$insures_details[$i]['holdUp']['isAgree']}}</div></td>
                                                                                @endif
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['transitdRate'])
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['transitdRate']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['transitdRate']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['safeRate'])
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['safeRate']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['safeRate']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['premiumTransit'])
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['premiumTransit']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['premiumTransit']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['premiumSafe'])
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['premiumSafe']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['premiumSafe']}}</span>
                                                                                    </div>
                                                                                </td>
                                                                                
                                                                            @else
                                                                                <td><div class="ans">--</div></td>
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            @endif
                
                                                            @if($pipeline_details['formData']['brokerage'])
                                                                <tr>
                                                                    @for ($i = 0; $i < $insure_count; $i++)
                                                                        @if(in_array($insures_details[$i]['uniqueToken'],$selectedId))
                                                                            @if(isset($insures_details[$i]['brokerage']))
                                                                            
                                                                                <td class="tooltip_sec">
                                                                                    <div class="ans">
                                                                                        <span>{{$insures_details[$i]['brokerage']}}</span>
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
                                                                            <div  class="reason_show" id="select_reson_{{$insures_details[$i]['uniqueToken']}}" style="display:none">
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
