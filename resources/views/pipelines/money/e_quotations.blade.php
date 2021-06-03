
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
        <h3 class="title" style="margin-bottom: 8px;">Money</h3>
    </div>
    @if (session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert" id="success_excel">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ session('msg') }}
        </div>
    @endif
    <div class="card_content">
        <div class="edit_sec clearfix">
            <!-- Steps -->
            <section>
                <nav>
                    <ol class="cd-breadcrumb triangle">
                        <li class="complete"><a href="{{url('money/e-questionnaire/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Questionnaire</em></a></li>
                        <li class="complete"><a href="{{url('money/e-slip/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Slip</em></a></li>
                        @if($pipeline_details['status']['status'] == 'E-quotation')
                            <li class="current"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'E-comparison')
                            <li class="active_arrow"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="current"><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment')
                            <li class="active_arrow"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Approved E Quote')
                            <li class="active_arrow"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="complete"><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li class="current"><a href="{{url('money/approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>
                            {{--<li><em>Issuance</em></li>--}}
                        @elseif($pipeline_details['status']['status'] == 'Quote Amendment-E-comparison' || $pipeline_details['status']['status'] == 'Quote Amendment-E-quotation' || $pipeline_details['status']['status'] == 'Quote Amendment-E-slip')
                            <li class="active_arrow"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li class="complete"><a href="{{url('money/e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>
                            <li class="current"><a href="{{url('money/quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>
                            <li><em>Approved E Quote</em></li>
                            {{--@elseif($pipeline_details['status']['status'] == 'Issuance')--}}
                            {{--<li class="complete"><a href="{{url('e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('e-comparison/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Comparison</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('quot-amendment/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Quote Amendment</em></a></li>--}}
                            {{--<li class="complete"><a href="{{url('approved-quot/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Approved E Quote</em></a></li>--}}
                            {{--<li class="current"><a href="{{url('issuance/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>Issuance</em></a></li>--}}
                        @else
                            <li class="current"><a href="{{url('money/e-quotation/'.$pipeline_details->_id)}}" style="color: #ffffff;"><em>E-Quotation</em></a></li>
                            <li><em>E-Comparison</em></li>
                            <li><em>Quote Amendment</em></li>
                            <li><em>Approved E Quote</em></li>
                            <li><em>Issuance</em></li>
                        @endif
                    </ol>
                </nav>
            </section>
            @if(isset($pipeline_details['selected_insurers']))
                <input type="hidden" id="selected_insurers" value="{{json_encode($id_insurer)}}">
            @else
                <input type="hidden" id="selected_insurers" value="empty">
            @endif
            <form id="e_quat_form" name="e_quat_form" method="post" >
                <input type="hidden" value="{{$pipeline_details->_id}}" id="pipeline_id" name="pipeline_id">
                {{csrf_field()}}
                <div class="data_table compare_sec">
                    <div id="admin">

                        <div class="material-table">
                            <div class="table-header">
                                <span class="table-title">E-Quotation</span>
                            </div>

                            <div class="table_fixed height_fix">
                                <div class="table_sep_fix">
                                    <div class="material-table table-responsive" style="border-bottom: none;overflow: hidden">
                                        <table class="table table-bordered"  style="border-bottom: none">
                                            <thead>
                                            <tr>
                                                <th><div class="main_question">Questions</div></th>
                                                <th><div class="main_answer" style="background-color: transparent">Customer Response</div></th>
                                            </tr>
                                            </thead>
                                            <tbody style="border-bottom: none" class="syncscroll"  name="myElements">
                                            <?php $insure_count=count(@$insures_details);?>
                                            <?php $sel_insure_count=count(@$insures_name);?> <!--Insurance Company List Active-->
                                            <?php $total_insure_count=$insure_count+$sel_insure_count;?> <!--Insurance Company List Active-->
                                            
                                            @if(isset($pipeline_details['formData']['coverLoss']) && $pipeline_details['formData']['coverLoss'] == true)
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss or damage due to  Riots and Strikes</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['coverDishonest']) && $pipeline_details['formData']['coverDishonest'] == true)

                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for dishonesty  of the employees if found out within 7 days</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['coverHoldup']) && $pipeline_details['formData']['coverHoldup'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for hold up</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>

                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['lossDamage']) && $pipeline_details['formData']['lossDamage'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to cases / bags while being used for carriage of money</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['claimCost']) && $pipeline_details['formData']['claimCost'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Claims Preparation cost</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['additionalPremium']) && $pipeline_details['formData']['additionalPremium']== true) 
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic reinstatement of sum insured  at pro-rata additional premium</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']== true && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['lossNotification']) && $pipeline_details['formData']['lossNotification'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss notification – ‘as soon as reasonably practicable’</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['cancellation']) && $pipeline_details['formData']['cancellation'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cancellation – 30 days notice by either party; refund of premium at pro-rata unless a claim has attached </label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['thirdParty']) && $pipeline_details['formData']['thirdParty'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Third party money's for which responsibility is assumed will be covered</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['carryVehicle']) && $pipeline_details['formData']['carryVehicle'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Carry by own vehicle / hired vehicles and / or on foot personal money of owners</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['nominatedLoss']) && $pipeline_details['formData']['nominatedLoss'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Nominated Loss adjuster – Panel Crawford Intl, Cunningham Lindsey, Miller International, John Kidd LA, Insured can  select</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['errorsClause']) && $pipeline_details['formData']['errorsClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Errors and Omissions clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['personalAssault']) && $pipeline_details['formData']['personalAssault'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for personal assault</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['accountantFees']) && $pipeline_details['formData']['accountantFees'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Auditor’s fees/ accountant fees</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['sustainedFees']) && $pipeline_details['formData']['sustainedFees'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for damages sustained to safe</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['primartClause']) && $pipeline_details['formData']['primartClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Primary Insurance clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['accountClause']) && $pipeline_details['formData']['accountClause'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Payment on account clause</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['lossParkingAReas']) && $pipeline_details['formData']['lossParkingAReas'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss from unattended vehicle if it was left in locked condition at designated parking areas</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['worldwideCover']) && $pipeline_details['formData']['worldwideCover'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover for loss of money whilst in the personal possession of authorized employees (Worldwide cover)</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['locationAddition']) && $pipeline_details['formData']['locationAddition'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Automatic addition of location</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying'] == true && ($pipeline_details['formData']['agencies']=='yes'))
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Money carrying / pooling / storage by any group company employees / security agencies to be covered anywhere in the country </label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['parties']) && $pipeline_details['formData']['parties'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable reasons compelling direct communications between the parties</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['personalEffects']) && $pipeline_details['formData']['personalEffects'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Loss or damage to personal effect</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['holdUp']) && $pipeline_details['formData']['holdUp'] == true)
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Cover to include house breaking, theft and burglary from safe or strong room and hold up or attempt of hold up</label></div></td>
                                                    <td class="main_answer"><div class="ans">Yes</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['transitdRate']) && $pipeline_details['formData']['transitdRate'] != '')
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Rate required (Money in Transit) (in %)</label></div></td>
                                                <td class="main_answer"><div class="ans">{{number_format(trim($pipeline_details['formData']['transitdRate']),2)}}</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['safeRate']) && $pipeline_details['formData']['safeRate'] != '')
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Rate required (Money in Safe) (in %)</label></div></td>
                                                <td class="main_answer"><div class="ans">{{number_format(trim($pipeline_details['formData']['safeRate']),2)}}</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['premiumTransit']) && $pipeline_details['formData']['premiumTransit'] != '')
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Premium required(Money in Transit) (in %)</label></div></td>
                                                <td class="main_answer"><div class="ans">{{number_format(trim($pipeline_details['formData']['premiumTransit']),2)}}</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['premiumSafe']) && $pipeline_details['formData']['premiumSafe'] != '')
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Premium required(Money in Safe) (in %)</label></div></td>
                                                <td class="main_answer"><div class="ans">{{number_format(trim($pipeline_details['formData']['premiumSafe']),2)}}</div></td>
                                                </tr>
                                            @endif
                                            @if(isset($pipeline_details['formData']['brokerage']) && $pipeline_details['formData']['brokerage'] != '')
                                                <tr>   
                                                    <td><div class="main_question"><label class="form_label bold">Brokerage</label></div></td>
                                                <td class="main_answer"><div class="ans">{{number_format(trim($pipeline_details['formData']['brokerage']),2)}}</div></td>
                                                </tr>
                                            @endif


                                            @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')
                                                <tr style="border-bottom: none">
                                                    <?php $insure_count=count(@$insures_details);?>
                                                    @if($insure_count==0)
                                                        @for ($i = 0; $i < $sel_insure_count; $i++)
                                                            <td style="border-bottom: none;border-right: none"></td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < $total_insure_count; $i++)
                                                            @if(array_key_exists($i,$insures_details))
                                                                <td style="border-bottom: none;border-right: none"></td>
                                                            @else
                                                                <?php $i_cont=$i-$insure_count; ?>
                                                                <td style="border-bottom: none;border-right: none"></td>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </tr>
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="table_sep_pen">
                                    <div class="material-table table-responsive">
                                        <table class="table comparison table-bordered" style="table-layout: auto">
                                            <thead>
                                            <tr>
                                            <?php $insure_count=count(@$insures_details);?><!--Replied insures count -->
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <th><div class="ans"> {{$insures_name[$i]}}</div></th>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <th>
                                                                @if(isset($insures_details[$i]['insurerDetails']['insurerName']))
                                                                    <div class="ans">
                                                                        <div class="custom_checkbox">
                                                                            <input type="checkbox" value="hide" name="insure_check[]" id="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="inp-cbx" style="display: none" onclick="color_change_table(this.id);">
                                                                            <label for="insure_check_{{$insures_details[$i]['uniqueToken']}}" class="cbx">
                                                                                <span>
                                                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                                </svg>
                                                                                </span>
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
                                                                                    <span data-toggle="tooltip" data-placement="right" title="{{$insures_details[$i]['insurerDetails']['insurerName']}}" data-container="body">{{substr(ucfirst($insures_details[$i]['insurerDetails']['insurerName']), 0, 32).$dot}}</span>
                                                                                @else
                                                                                    <span>{{$insures_details[$i]['insurerDetails']['insurerName']}}</span>
                                                                                @endif
                                                                                <?php if(isset($insures_details[$i]['repliedMethod']))
                                                                                {
                                                                                if($insures_details[$i]['repliedMethod']=='excel')
                                                                                {
                                                                                $method=$insures_details[$i]['repliedMethod'];
                                                                                ?>
                                                                                <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                    <i style="color: #9c27b0;" class="fa fa-file-excel-o"></i>
                                                                                </div>
                                                                                <?php
                                                                                }
                                                                                else{
                                                                                $method=$insures_details[$i]['repliedMethod'];
                                                                                ?>

                                                                                <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="{{$method}}">
                                                                                    <i style="color: #9c27b0;" class="fa fa-user"></i>
                                                                                </div>
                                                                                <?php
                                                                                }
                                                                                }
                                                                                else{
                                                                                    $method='';
                                                                                }
                                                                                ?>

                                                                            </label>


                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </th>
                                                        @else
                                                            <?php $i_cont=$i-$insure_count; ?>
                                                            <?php $lengthval=strlen($insures_name[$i_cont]);
                                                            if($lengthval>32)
                                                            {
                                                                $dot_value="...";
                                                            }
                                                            else{
                                                                $dot_value=null;
                                                            }

                                                            ?>
                                                            <th>
                                                                @if($dot_value!=null)
                                                                    <div class="ans" data-toggle="tooltip" data-placement="right" title="{{$insures_name[$i_cont]}}">{{substr(ucfirst($insures_name[$i_cont]), 0, 32).$dot_value}}</div>
                                                                @else
                                                                    <div class="ans">{{substr(ucfirst($insures_name[$i_cont]), 0, 32)}}</div>
                                                                @endif
                                                            </th>
                                                        @endif
                                                    @endfor
                                                @endif

                                            </tr>

                                            </thead>
                                            <tbody  class="syncscroll" name="myElements">
                                        @if(isset($pipeline_details['formData']['coverLoss']) && $pipeline_details['formData']['coverLoss']== true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_coverLoss_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='coverLoss_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverLoss']?:'--'}}' required>
                                                                        <label class='error' id='coverLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverLoss' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverLoss' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['coverLoss']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['coverDishonest']) && $pipeline_details['formData']['coverDishonest']== true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_coverDishonest_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='coverDishonest_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverDishonest']?:'--'}}' required>
                                                                        <label class='error' id='coverDishonest_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverDishonest' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverDishonest' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['coverDishonest']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['coverHoldup']) && $pipeline_details['formData']['coverHoldup']== true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_coverHoldup_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='coverHoldup_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['coverHoldup']?:'--'}}' required>
                                                                        <label class='error' id='coverHoldup_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHoldup' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='coverHoldup' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['coverHoldup']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['lossDamage']) && $pipeline_details['formData']['lossDamage'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['lossDamage']['isAgree']))
                                                                @if(@$insures_details[$i]['lossDamage']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_lossDamage_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='lossDamage_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossDamage']['isAgree']}}'>
                                                                                <label class='error' id='lossDamage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['lossDamage']['isAgree']}}
                                                                            </span>
                                                                                <div class="post_comments">
                                                                                    <div class="post_comments_main clearfix">
                                                                                        <div class="media">
                                                                                            <div class="media-body">
                                                                                                <span  class="comment_txt">{{$insures_details[$i]['lossDamage']['comment']}}</span>        
                                                                                            </div>
                                                                                            <div class="media-right">
                                                                                                <span id="cancel_lossDamage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                    data-content="<input id='lossDamage_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossDamage']['comment']}}'>
                                                                                                    <label class='error' id='lossDamage_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='commentCancel(this)'><i class='material-icons'>close</i></button" data-container="body">                      
                                                                                                    <button type="button">
                                                                                                        <i class="material-icons">edit</i>
                                                                                                    </button>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_lossDamage_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='lossDamage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossDamage']['isAgree']}}'>
                                                                        <label class='error' id='lossDamage_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossDamage' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossDamage']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['claimCost']) && $pipeline_details['formData']['claimCost'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['claimCost']['isAgree']))
                                                                @if(@$insures_details[$i]['claimCost']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_claimCost_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='claimCost_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimCost']['isAgree']}}'>
                                                                                <label class='error' id='claimCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['claimCost']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_claimCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='claimCost_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimCost']['comment']}}'>
                                                                                <label class='error' id='claimCost_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['claimCost']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['claimCost']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_claimCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='claimCost_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['claimCost']['comment']}}'>
                                                                                                    <label class='error' id='claimCost_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"  data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_claimCost_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='claimCost_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['claimCost']['isAgree']}}'>
                                                                        <label class='error' id='claimCost_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='claimCost' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['claimCost']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['additionalPremium']) && $pipeline_details['formData']['additionalPremium']== true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_additionalPremium_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='additionalPremium_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['additionalPremium']?:'--'}}' required>
                                                                        <label class='error' id='additionalPremium_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='additionalPremium' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='additionalPremium' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['additionalPremium']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['storageRisk']) && $pipeline_details['formData']['storageRisk']== true && ($pipeline_details['formData']['businessType']=="Bank/ lenders/ financial institution/ currency exchange"
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
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_storageRisk_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='storageRisk_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['storageRisk']?:'--'}}' required>
                                                                        <label class='error' id='storageRisk_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='storageRisk' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='storageRisk' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['storageRisk']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['lossNotification']) && $pipeline_details['formData']['lossNotification'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['lossNotification']['isAgree']))
                                                                @if(@$insures_details[$i]['lossNotification']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_lossNotification_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='lossNotification_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossNotification']['isAgree']}}'>
                                                                                <label class='error' id='lossNotification_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['lossNotification']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossNotification']['comment']}}'>
                                                                                <label class='error' id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['lossNotification']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['lossNotification']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossNotification']['comment']}}'>
                                                                                <label class='error' id='lossNotification_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_lossNotification_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='lossNotification_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['lossNotification']['isAgree']}}'>
                                                                        <label class='error' id='lossNotification_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossNotification' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['lossNotification']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['cancellation']) && $pipeline_details['formData']['cancellation'] == true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_cancellation_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='cancellation_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['cancellation']?:'--'}}' required>
                                                                        <label class='error' id='cancellation_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='cancellation' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='cancellation' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['cancellation']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['thirdParty']) && $pipeline_details['formData']['thirdParty'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['thirdParty']['isAgree']))
                                                                @if(@$insures_details[$i]['thirdParty']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_thirdParty_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='thirdParty_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['thirdParty']['isAgree']}}'>
                                                                                <label class='error' id='thirdParty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['thirdParty']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_thirdParty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['thirdParty']['comment']}}'>
                                                                                <label class='error' id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['thirdParty']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['thirdParty']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_thirdParty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['thirdParty']['comment']}}'>
                                                                                                    <label class='error' id='thirdParty_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_thirdParty_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='thirdParty_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['thirdParty']['isAgree']}}'>
                                                                        <label class='error' id='thirdParty_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='thirdParty' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['thirdParty']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['carryVehicle']) && $pipeline_details['formData']['carryVehicle'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['carryVehicle']['isAgree']))
                                                                @if(@$insures_details[$i]['carryVehicle']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_carryVehicle_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='carryVehicle_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['carryVehicle']['isAgree']}}'>
                                                                                <label class='error' id='carryVehicle_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['carryVehicle']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_carryVehicle_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='carryVehicle_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['carryVehicle']['comment']}}'>
                                                                                <label class='error' id='carryVehicle_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['carryVehicle']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['carryVehicle']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_carryVehicle_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='carryVehicle_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['carryVehicle']['comment']}}'>
                                                                                                    <label class='error' id='carryVehicle_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_carryVehicle_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='carryVehicle_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['carryVehicle']['isAgree']}}'>
                                                                        <label class='error' id='carryVehicle_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='carryVehicle' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['carryVehicle']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['nominatedLoss']) && $pipeline_details['formData']['nominatedLoss'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['nominatedLoss']['isAgree']))
                                                                @if(@$insures_details[$i]['nominatedLoss']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_nominatedLoss_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='nominatedLoss_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['nominatedLoss']['isAgree']}}'>
                                                                                <label class='error' id='nominatedLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['nominatedLoss']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_nominatedLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='nominatedLoss_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nominatedLoss']['comment']}}'>
                                                                                <label class='error' id='nominatedLoss_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['nominatedLoss']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['nominatedLoss']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_nominatedLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='nominatedLoss_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['nominatedLoss']['comment']}}'>
                                                                                <label class='error' id='nominatedLoss_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_nominatedLoss_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='nominatedLoss_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['carryVehicle']['isAgree']}}'>
                                                                        <label class='error' id='nominatedLoss_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='nominatedLoss' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['nominatedLoss']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['errorsClause']) && $pipeline_details['formData']['errorsClause'] == true)    
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_errorsClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='errorsClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['errorsClause']?:'--'}}' required>
                                                                        <label class='error' id='errorsClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='errorsClause' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='errorsClause' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['errorsClause']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['personalAssault']) && $pipeline_details['formData']['personalAssault'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['personalAssault']['isAgree']))
                                                                @if(@$insures_details[$i]['personalAssault']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_personalAssault_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='personalAssault_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalAssault']['isAgree']}}'>
                                                                                <label class='error' id='personalAssault_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['personalAssault']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_personalAssault_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='personalAssault_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['personalAssault']['comment']}}'>
                                                                                <label class='error' id='personalAssault_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['personalAssault']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['personalAssault']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_personalAssault_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='personalAssault_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['personalAssault']['comment']}}'>
                                                                                                    <label class='error' id='personalAssault_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_personalAssault_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='personalAssault_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalAssault']['isAgree']}}'>
                                                                        <label class='error' id='personalAssault_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalAssault' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['personalAssault']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['accountantFees']) && $pipeline_details['formData']['accountantFees'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['accountantFees']['isAgree']))
                                                                @if(@$insures_details[$i]['accountantFees']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_accountantFees_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='accountantFees_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountantFees']['isAgree']}}'>
                                                                                <label class='error' id='accountantFees_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['accountantFees']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_accountantFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='accountantFees_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountantFees']['comment']}}'>
                                                                                <label class='error' id='accountantFees_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['accountantFees']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['accountantFees']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_accountantFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='accountantFees_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountantFees']['comment']}}'>
                                                                                                    <label class='error' id='accountantFees_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_accountantFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='accountantFees_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountantFees']['isAgree']}}'>
                                                                        <label class='error' id='accountantFees_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountantFees' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountantFees']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['sustainedFees']) && $pipeline_details['formData']['sustainedFees'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['sustainedFees']['isAgree']))
                                                                @if(@$insures_details[$i]['sustainedFees']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_sustainedFees_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='sustainedFees_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['sustainedFees']['isAgree']}}'>
                                                                                <label class='error' id='sustainedFees_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['sustainedFees']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_sustainedFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='sustainedFees_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['sustainedFees']['comment']}}'>
                                                                                <label class='error' id='sustainedFees_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['sustainedFees']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['sustainedFees']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_sustainedFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='sustainedFees_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['sustainedFees']['comment']}}'>
                                                                                <label class='error' id='sustainedFees_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_sustainedFees_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='sustainedFees_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['sustainedFees']['isAgree']}}'>
                                                                        <label class='error' id='sustainedFees_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='sustainedFees' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['sustainedFees']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['primartClause']) && $pipeline_details['formData']['primartClause'] == true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_primartClause_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='primartClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['primartClause']?:'--'}}' required>
                                                                        <label class='error' id='primartClause{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='primartClause' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='primartClause' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['primartClause']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['accountClause']) && $pipeline_details['formData']['accountClause'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['accountClause']['isAgree']))
                                                                @if(@$insures_details[$i]['accountClause']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_accountClause_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='accountClause_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountClause']['isAgree']}}'>
                                                                                <label class='error' id='accountClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['accountClause']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_accountClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='accountClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountClause']['comment']}}'>
                                                                                <label class='error' id='accountClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['accountClause']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['accountClause']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_accountClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='accountClause_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['accountClause']['comment']}}'>
                                                                                                    <label class='error' id='accountClause_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_accountClause_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='accountClause_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['accountClause']['isAgree']}}'>
                                                                        <label class='error' id='accountClause_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='accountClause' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['accountClause']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['lossParkingAReas']) && $pipeline_details['formData']['lossParkingAReas'] == true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_lossParkingAReas_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='lossParkingAReas_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['lossParkingAReas']?:'--'}}' required>
                                                                        <label class='error' id='lossParkingAReas{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossParkingAReas' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='lossParkingAReas' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['lossParkingAReas']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['worldwideCover']) && $pipeline_details['formData']['worldwideCover'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['worldwideCover']['isAgree']))
                                                                @if(@$insures_details[$i]['worldwideCover']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_worldwideCover_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='worldwideCover_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['worldwideCover']['isAgree']}}'>
                                                                                <label class='error' id='worldwideCover_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['worldwideCover']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_worldwideCover_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='worldwideCover_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['worldwideCover']['comment']}}'>
                                                                                <label class='error' id='worldwideCover_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['worldwideCover']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['worldwideCover']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_worldwideCover_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='worldwideCover_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['worldwideCover']['comment']}}'>
                                                                                                    <label class='error' id='worldwideCover_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>
                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_worldwideCover_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='worldwideCover_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['worldwideCover']['isAgree']}}'>
                                                                        <label class='error' id='worldwideCover_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='worldwideCover' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['worldwideCover']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>

                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['locationAddition']) && $pipeline_details['formData']['locationAddition'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['locationAddition']['isAgree']))
                                                                @if(@$insures_details[$i]['locationAddition']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_locationAddition_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='locationAddition_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['locationAddition']['isAgree']}}'>
                                                                                <label class='error' id='locationAddition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['locationAddition']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_locationAddition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='locationAddition_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['locationAddition']['comment']}}'>
                                                                                <label class='error' id='locationAddition_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['locationAddition']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['locationAddition']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_locationAddition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='locationAddition_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['locationAddition']['comment']}}'>
                                                                                                    <label class='error' id='locationAddition_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>

                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_locationAddition_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='locationAddition_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['locationAddition']['isAgree']}}'>
                                                                        <label class='error' id='locationAddition_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='locationAddition' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['locationAddition']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>

                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['moneyCarrying']) && $pipeline_details['formData']['moneyCarrying'] == true && ($pipeline_details['formData']['agencies']=='yes'))
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['moneyCarrying']['isAgree']))
                                                                @if(@$insures_details[$i]['moneyCarrying']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_moneyCarrying_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='moneyCarrying_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['moneyCarrying']['isAgree']}}'>
                                                                                <label class='error' id='moneyCarrying_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['moneyCarrying']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_moneyCarrying_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='moneyCarrying_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['moneyCarrying']['comment']}}'>
                                                                                <label class='error' id='moneyCarrying_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['moneyCarrying']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['moneyCarrying']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_moneyCarrying_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='moneyCarrying_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['moneyCarrying']['comment']}}'>
                                                                                <label class='error' id='moneyCarrying_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>

                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_moneyCarrying_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='moneyCarrying_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['moneyCarrying']['isAgree']}}'>
                                                                        <label class='error' id='moneyCarrying_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='moneyCarrying' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['moneyCarrying']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['parties']) && $pipeline_details['formData']['parties'] == true)     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_parties_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='parties_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['parties']?:'--'}}' required>
                                                                        <label class='error' id='parties{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='parties' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='parties' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['parties']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['personalEffects']) && $pipeline_details['formData']['personalEffects'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['personalEffects']['isAgree']))
                                                                @if(@$insures_details[$i]['personalEffects']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_personalEffects_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='personalEffects_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalEffects']['isAgree']}}'>
                                                                                <label class='error' id='personalEffects_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['personalEffects']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_personalEffects_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='personalEffects_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['personalEffects']['comment']}}'>
                                                                                <label class='error' id='personalEffects_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['personalEffects']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['personalEffects']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_personalEffects_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='personalEffects_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['personalEffects']['comment']}}'>
                                                                                <label class='error' id='personalEffects_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>

                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_personalEffects_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='personalEffects_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['personalEffects']['isAgree']}}'>
                                                                        <label class='error' id='personalEffects_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='personalEffects' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['personalEffects']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>

                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['holdUp']) && $pipeline_details['formData']['holdUp'] == true)
                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            @if(isset($insures_details[$i]['holdUp']['isAgree']))
                                                                @if(@$insures_details[$i]['holdUp']['comment']!="")
                                                                    <td class="tooltip_sec insure_check_{{@$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                            <span id="div_holdUp_{{@$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true"
                                                                                data-content="<input id='holdUp_{{@$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['holdUp']['isAgree']}}'>
                                                                                <label class='error' id='holdUp_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='fun(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='cancel(this)'><i class='material-icons'>close</i></button>"
                                                                                data-container="body">{{@$insures_details[$i]['holdUp']['isAgree']}}
                                                                            </span>
                                                                            {{-- <span id="cancel_holdUp_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                    data-content="<input id='holdUp_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['holdUp']['comment']}}'>
                                                                                <label class='error' id='holdUp_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='commentEdit(this)'>Update</button>
                                                                                <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                        data-container="body">
                                                                                <i class="fa fa-comments" data-toggle="tooltip" data-placement="bottom" title="" data-container="body" data-original-title="{{$insures_details[$i]['holdUp']['comment']}}"></i>
                                                                                </span> --}}
                                                                                <div class="post_comments">
                                                                                        <div class="post_comments_main clearfix">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                                                                                    <span  class="comment_txt">{{$insures_details[$i]['holdUp']['comment']}}</span>        
                                                                                                </div>
                                                                                                <div class="media-right">
                                                                                                        <span id="cancel_holdUp_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top" title="Edit existing comment" data-html="true"
                                                                                                        data-content="<input id='holdUp_comment_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['holdUp']['comment']}}'>
                                                                                                    <label class='error' id='holdUp_comment_{{$insures_details[$i]['uniqueToken']}}-error'>
                                                                                                    </label><button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='commentEdit(this)'>Update</button>
                                                                                                    <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='commentCancel(this)'><i class='material-icons'>close</i></button"
                                                                                                                                                                                            data-container="body">
                                                                                                        <button type="button">
                                                                                                                <i class="material-icons">edit</i>
                                                                                                            </button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                        </div>
                                                                    </td>

                                                            @else
                                                                    <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                        <div class="ans">
                                                                        <span id="div_holdUp_{{$insures_details[$i]['uniqueToken']}}" data-toggle="popover" data-placement="top"
                                                                            title="Edit existing value" data-html="true" data-content="<input id='holdUp_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{@$insures_details[$i]['holdUp']['isAgree']}}'>
                                                                        <label class='error' id='holdUp_{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='holdUp' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>" data-container="body">{{@$insures_details[$i]['holdUp']['isAgree']}}</span></div></td>
                                                            @endif
                                                            @else
                                                                <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">  <div class="ans">--</div></td>
                                                            @endif

                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['transitdRate'])!= '')     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_transitdRate_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='transitdRate_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['transitdRate']?:'--'}}' required>
                                                                        <label class='error' id='transitdRate{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='transitdRate' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='transitdRate' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['transitdRate']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['safeRate'])!= '')     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_safeRate_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='safeRate_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['safeRate']?:'--'}}' required>
                                                                        <label class='error' id='safeRate{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='safeRate' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='safeRate' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['safeRate']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['premiumTransit'])!= '')     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_premiumTransit_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='premiumTransit_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premiumTransit']?:'--'}}' required>
                                                                        <label class='error' id='premiumTransit{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumTransit' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumTransit' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['premiumTransit']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['premiumSafe'])!= '')     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_premiumSafe_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='premiumSafe_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['premiumSafe']?:'--'}}' required>
                                                                        <label class='error' id='premiumSafe{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumSafe' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='premiumSafe' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['premiumSafe']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if(isset($pipeline_details['formData']['brokerage'])!= '')     
                                            <tr>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td>  <div class="ans">--</div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td class="insure_check_{{$insures_details[$i]['uniqueToken']}}">
                                                                <div class="ans">
                                                                    <span id='div_brokerage_{{$insures_details[$i]['uniqueToken']}}'
                                                                        data-toggle="popover" data-placement="top" title="Edit existing value" data-html="true" data-content="
                                                                        <input id='brokerage_{{$insures_details[$i]['uniqueToken']}}' type='text' value='{{$insures_details[$i]['brokerage']?:'--'}}' required>
                                                                        <label class='error' id='brokerage{{$insures_details[$i]['uniqueToken']}}-error'></label>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='fun(this)'>Update</button>
                                                                        <button name='{{$insures_details[$i]['uniqueToken']}}' value='brokerage' onclick='cancel(this)'>
                                                                        <i class='material-icons'>close</i></button>"
                                                                        data-container="body">{{$insures_details[$i]['brokerage']?:'--'}}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                        @else
                                                            <td>  <div class="ans">--</div></td>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endif

                                        @if($pipeline_details['status']['status'] == 'E-slip' || $pipeline_details['status']['status']=='E-quotation' || $pipeline_details['status']['status']=='E-comparison' || $pipeline_details['status']['status']=='Quote Amendment'|| $pipeline_details['status']['status']=='Quote Amendment-E-quotation')

                                            <tr>
                                                <?php $insure_count=count(@$insures_details);?>
                                                @if($insure_count==0)
                                                    @for ($i = 0; $i < $sel_insure_count; $i++)
                                                        <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i]}}','{{$pipeline_details->_id}}')"><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < $total_insure_count; $i++)
                                                        @if(array_key_exists($i,$insures_details))
                                                            <td><div class="ans"></div></td>
                                                        @else
                                                            <?php $i_cont=$i-$insure_count; ?>
                                                            <td><div class="ans"><button class="btn pink_btn upload_excel auto_modal" data-modal="upload_excel" onclick="get_excel_id('{{$insures_id[$i_cont]}}','{{$pipeline_details->_id}}')" ><i class="material-icons">cloud_upload</i> Upload Excel</button></div></td>
                                                        @endif
                                                    @endfor
                                                @endif
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
                @if($insure_count!=0)
                    <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit" @if($pipeline_details['status']['status']=='Approved E Quote' || $pipeline_details['status']['status']=='Issuance') style="display: none" @endif>Proceed</button>
                    @if(@$pipeline_details['status']['status']!='Approved E Quote')
                        <button type = "button" class="btn blue_btn pull-right btn_action" onclick="saveQuotation()">Save as Draft</button>
                    @endif
                @endif
            </form>
            {{--@else--}}
            {{--No Data--}}
            {{--@endif--}}
        </div>
    </div>

</div>
<!-- Popup -->
<div id="upload_excel">
    <div class="cd-popup">
        <div class="cd-popup-container">
            <div class="modal_content">
                <div class="clearfix">
                    <h1>Upload Excel</h1>
                </div>
                <form id="upload_excel_form" name="upload_excel_form" method="post">
                    {{csrf_field()}}
                    <div class="upload_sec">
                        <input type="hidden" id="pipelinedetails_id" name="pipelinedetails_id">
                        <input type="hidden" id="insurer_id" name="insurer_id">
                        <div class="custom_upload">
                            <input type="file" name="import_excel_file" id="import_excel_file" >
                            <p>Drag your files or click here.</p>
                        </div>
                        <label style="float: left" class="error" id="error-label"></label>
                    </div>
                    <div class="modal_footer">
                        <button class="btn btn-primary btn-link btn_cancel" id="upload_excel_cancel" type="button">Cancel</button>
                        <button type="submit" id="upload_excel" class="btn btn-primary btn_action">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('includes.chat')
@include('includes.mail_popup')
@endsection

{{--<style>--}}
{{--.material-table{--}}
{{--position: relative;--}}
{{--}--}}
{{--.main_question,.main_answer{--}}
{{--position: absolute;--}}
{{--}--}}
{{--.main_answer{--}}
{{--left: 300px;--}}
{{--}--}}
{{--</style>--}}



@push('scripts')

<!--jquery validate-->
<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>
{{--    <script src="{{URL::asset('js/jquery.CongelarFilaColumna.?js')}}"></script>--}}
<!-- table fix -->
{{--    <link rel="stylesheet" href="{{ URL::asset('css/ScrollTabla.css')}}" />--}}
{{--<script type="text/javascript">--}}
{{--$(document).ready(function(){--}}
{{--$("#pruebatabla").CongelarFilaColumna({lboHoverTr:true});--}}
{{--});--}}
{{--</script>--}}
<script>

    function get_excel_id(insurer_id,pipeline_id)
    {
        $('#pipelinedetails_id').val(pipeline_id);
        $('#insurer_id').val(insurer_id);
    }

    $("#upload_excel_form").validate({
        ignore: [],
        rules: {
            import_excel_file: {
                required: true,
                accept: "application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            }
        },
        messages: {
            import_excel_file: "Please upload a valid excel file."
        },
        errorPlacement: function(error, element){
            if(element.attr("name") == "import_excel_file" ){
                error.insertAfter(element.parent());
            }
        },
        submitHandler: function (form, event) {
            var form_data = new FormData($("#upload_excel_form")[0]);
            var excel = $('#import_excel_file').prop('files')[0];
            $('#preLoader').show();
            $("#upload_excel").attr( "disabled", true );
            form_data.append('file', excel);
            form_data.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: '{{url('save-temporary')}}',
                data: form_data,
                method: 'post',
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result == 1) {
                        window.location.href = "{{url('money/imported-list')}}";
                    }
                    else if(result.length> 1){
                        $("#upload_excel").attr( "disabled", false );

                        $('#preLoader').hide();
                        $('#error-label').html('The file you uploaded is not a Quotation');
                        $('#error-label').show();
                    }
                    else if(result == 0)
                    {
                        $("#upload_excel").attr( "disabled", false );
                        $('#preLoader').hide();
                        $('#error-label').html('The file you uploaded is not a Quotation');
                        $('#error-label').show();
                    }
                    {{--else {--}}
                    {{--alert('something went wrong');--}}
                    {{--}--}}
                }
            });
        }
    });

    //add customer form validation//
    $("#e_quat_form").validate({

        ignore: [],
        rules: {
            'insure_check[]': {
                required: true
            }
        },
        messages: {
            'insure_check[]': "Please select one of insurer."
        },

        errorPlacement: function (error, element) {
            console.log('sdfsdfdf');
            error.insertBefore(element.parent().parent().parent().parent());
        },
        submitHandler: function (form,event) {
            var form_data = new FormData($("#e_quat_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('money/save-selected-insurers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result== 'success') {
                        window.location.href = '{{url('money/e-comparison/'.$pipeline_details->_id)}}';
                    }
                }
            });
        }
    });
    //end//

    function color_change_table(col_name)
    {

        var result = col_name.split('_');
        var checkbox_val=document.getElementById(col_name).value;
        if(checkbox_val=="hide")
        {
            var all_col=document.getElementsByClassName(col_name);
            for(var i=0;i<all_col.length;i++)
            {
                all_col[i].style.background="#C8CDE3";
            }
            document.getElementById(col_name).value=result[2];
//                document.getElementById(col_name+"_head").style.background="#F00";

        }

        else
        {
            var all_col=document.getElementsByClassName(col_name);
            for(var i=0;i<all_col.length;i++)
            {
                all_col[i].style.background="#fff";
            }
            document.getElementById(col_name).value="hide";
//                document.getElementById(col_name+"_head").style.background="#fff";

        }
    }
</script>
<style>
    label.error {
        float:right;
    }
    #demodocs-error {
            float:left;
        }
    #import_excel_file-error{
        display: block;
        float: left;
        margin: 6px 0;
    }
    .section_details{
        max-width: 100%;
    }

    thead label.error {
        position: fixed;
        z-index: 9;
        background: #e01c1c;
        margin: -34px 0 0;
        color: #ffffff;
        padding: 8px 15px;
    }
    thead label.error:after {
        top: 100%;
        left: 0;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(136, 183, 213, 0);
        border-top-color: #e01c1c;
        border-width: 6px;
        margin-left: 5px;
    }

</style>
<script>
    $(document).ready(function () {

        $('thead .error').addClass('sdfsdfsdf');

        var selected = $('#selected_insurers').val();
        if(selected != 'empty')
        {
            var values = JSON.parse(selected);
            $.each(values , function (index , value) {
                var col_name ='insure_check_'+value;
                color_change_table(col_name);
                $('#'+col_name).prop('checked',true);
            })
        }
        setTimeout(function() {
            $('#success_excel').fadeOut('fast');
        }, 5000);
        $('form input').change(function () {
            var fullPath = $('#import_excel_file').val();
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
//            console.log(filename);
            $('.custom_upload p').text(filename);
        });


    });
    function fun(obj) {
        var token = obj.name;
        var field = obj.value;
        var new_quot = $('#'+field+'_'+token+'').val();
        var id = $('#pipeline_id').val();
        if(new_quot!="")
        {
            $('#preLoader').show();
            $.ajax({
                method: 'post',
                url: '{{url('money/quot-amend')}}',
                data: {
                    token:token,
                    field:field,
                    new_quot:new_quot,
                    id:id,
                    _token: '{{csrf_token()}}'
                },
                success:function(data){
                    if(data == 'success')
                    {
// $('#div_'+field+'_'+token+'').popover('hide');
// $('#div_'+field+'_'+token+'').html(new_quot);
                        location.reload();
                    }
                }
            });
        }
        else{
            $('#'+field+'_'+token+'-error').html('Please enter a valid data');
        }
    }
    function cancel(obj) {
        var token = obj.name;
        var field = obj.value;
        $('#div_'+field+'_'+token+'').popover('hide');

    }
    function commentEdit(obj)
    {
        var token = obj.name;
        var field = obj.value;
        var new_quot = $('#'+field+'_comment_'+token+'').val();
        console.log(token);
        console.log(field);
        console.log(new_quot);
        console.log($('#'+field+'_comment_'+token+''));
        var id = $('#pipeline_id').val();
        if(new_quot!="")
        {
            $('#preLoader').show();
            $.ajax({
                method: 'post',
                url: '{{url('money/quot-amend')}}',
                data: {
                    token:token,
                    field:field,
                    new_quot:new_quot,
                    id:id,
                    comment:"comment",
                    _token: '{{csrf_token()}}'
                },
                success:function(data){
                    if(data == 'success')
                    {
                        location.reload();
                    }
                }
            });
        }
        else{
            $('#'+field+'_comment_'+token+'-error').html('Please enter a valid data');
        }
    }
    function commentCancel(obj)
    {
        var token = obj.name;
        var field = obj.value;
        $('#cancel_'+field+'_'+token+'').popover('hide');
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
    $( "#upload_excel_cancel" ).click(function() {
        $('#error-label').hide();
        $('#import_excel_file').val('');
        $('#import_excel_file-error').hide();
        $('.custom_upload p').text('Drag your files or click here.');
    });
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
    function saveQuotation()
    {
        $('#preLoader').show();
        var form_data = new FormData($("#e_quat_form")[0]);
        form_data.append('_token', '{{csrf_token()}}');
        form_data.append('is_save','true');
        $.ajax({
            method: 'post',
            url: '{{url('money/save-selected-insurers')}}',
            data: form_data,
            cache : false,
            contentType: false,
            processData: false,
            success: function (result) {
                $('#preLoader').hide();
                if (result== 'success') {
                    $('#success_message').html('E-Quotation is saved as draft.');
                    $('#success_popup .cd-popup').addClass('is-visible');
                }
                else
                {
                    $('#success_message').html('E-Quotation saving failed.');
                    $('#success_popup .cd-popup').addClass('is-visible');
                }
            }
        });
    }
</script>

<script src="{{URL::asset('js/syncscroll.js')}}"></script>
@endpush
