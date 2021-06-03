
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
    @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_div">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('status') }}
        </div>
    @endif
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Money</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('money/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('money/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('money/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            @if($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class = active_arrow><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = complete><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('money/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                                {{--<li><em>Issuance</em></li>--}}
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                                {{--<li class = complete><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                                {{--<li class = complete><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                                {{--<li class = "complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                                {{--<li class = "current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class = active_arrow><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                            @else
                                <li class = current><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li><em>Quote Amendment</em></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @endif
                        </ol>
                    </nav>
                    <input type="hidden" id="pipeline_id" name="pipeline_id" value="{{$pipeline_details->_id}}">
                </section>
                <div class="data_table compare_sec">
                    <div id="admin">

                        <div class="material-table">
                            <div class="table-header">
                                <span class="table-title">E-Comparison</span>
                                <div class="table_header_action">
                                    @if(isset($pipeline_details['comparisonToken']))
                                        <label style="font-size:10px;margin: 0 14px;font-weight: 600;background: #27a2b0;color: #fff;padding: 4px 18px;text-transform: uppercase;border-radius: 47px;">{{$pipeline_details['comparisonToken']['viewStatus']}}</label>
                                    @endif
                                    <button type="button"class="btn btn-primary" onclick="popupFunction()" @if($pipeline_details['status']['status'] == 'Approved E Quote') style="display:none;" @endif>Send to Customer</button>
                                    <a target="_blank" href="{{url('money/comparison-pdf/'.$pipeline_details->_id)}}" class="btn pink_btn">Download as pdf</a>
                                </div>
                            </div>


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
                                            @if(isset($pipeline_details['formData']['storageRisk']) &&  $pipeline_details['formData']['storageRisk']==true  && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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
                                                                    <td class="tooltip_sec">
                                                                        <div class="ans">
                                                                            <span>{{$insures_details[$i]['lossDamage']['isAgree']}}</span>
                                                                            <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['lossDamage']['comment']}}</span>        
                                                                                            </div>
                                                                                          
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            {{-- <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossDamage']['comment']}}"></i> --}}
                                                                            {{-- <div class="post_comments">
                                                                                    <label class="form_label">Comments</label>
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <textarea placeholder="comments..." id='lossDamage_comment_{{$insures_details[$i]['uniqueToken']}}' readonly>{{$insures_details[$i]['lossDamage']['comment']}}</textarea>
                                                                                 
                                                                                    </div>
                                                                            </div> --}}
                                                                                
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

                                            @if(isset($pipeline_details['formData']['storageRisk']) &&  $pipeline_details['formData']['storageRisk']==true  && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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

    <style>
        .section_details{
            max-width: 100%;
        }
    </style>
    @include('includes.mail_popup')
    @include('includes.chat')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            setTimeout(function() {
            $('#success_div').fadeOut('fast');
            }, 5000);
        });
        function sendQuestion() {
            var form_data = new FormData($("#quest_send_form")[0]);
            var id = $('#pipeline_id').val();
            form_data.append('id',id);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#send_btn").attr( "disabled", true );
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('money/send-comparison')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result!= 'failed') {
                        $("#send_btn").attr( "disabled", false );
                        $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                        $('#preLoader').hide();
                        $('#success_message').html(result);
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                    else
                    {
                        $("#send_btn").attr( "disabled", false );
                        $('#questionnaire_popup .cd-popup').removeClass('is-visible');
                        $('#preLoader').hide();
                        $('#success_message').html('Comparison sending failed.');
                        $('#success_popup .cd-popup').addClass('is-visible');
                    }
                }
            });
        }
        function popupFunction() {
            $('#questionnaire_popup .cd-popup').addClass('is-visible');
            $("#send_btn").attr( "disabled", false );
            var id = $('#pipeline_id').val();
            $.ajax({
                method: 'get',
                url: '{{url('email-file')}}',
                data: {'id': id},
                success: function (result) {
                    if (result != 'failed') {
                        $('#attach_div').html(result);
                    }
                    else {
                        $('#attach_div').html('Files loading failed');
                    }
                }
            });
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
    </script>

    <script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
