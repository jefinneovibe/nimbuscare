
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
            <h3 class="title" style="margin-bottom: 8px;">{{$pipeline_details['workTypeId']['name']}}</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <!-- Steps -->
                <section>
                    <nav>
                        <ol class="cd-breadcrumb triangle">
                            <li class="complete"><em><a href="{{ url('contractor-plant/e-questionnaire/'.$pipeline_details->_id) }}">E-Questionnaire</a></em></li>
                            <li class="complete"><em><a href="{{ url('contractor-plant/e-slip/'.$pipeline_details->_id) }}">E-Slip</a></em></li>
                            <li class="complete"><em><a href="{{ url('contractor-plant/e-quotation/'.$pipeline_details->_id) }}">E-Quotation</a></em></li>
                            @if($pipeline_details['status']['status'] == 'Quote Amendment')
                                <li class = active_arrow><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                                {{--<li><em>Issuance</em></li>--}}
                            @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                                <li class = active_arrow><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = complete><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li class = "current"><a href="{{url('contractor-plant/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                                <li class = active_arrow><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                                <li class = current><a href="{{url('contractor-plant/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                                <li><em>Approved E Quote</em></li>
                            @else
                                <li class = current><a href="{{url('contractor-plant/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
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
                                    <a target="_blank" href="{{url('contractor-plant/comparison-pdf/'.$pipeline_details->_id)}}" class="btn pink_btn">Download as pdf</a>
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
                url: '{{url('send-comparison')}}',
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
