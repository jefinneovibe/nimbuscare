
@extends('layouts.insurer_layout')


@section('content')
    <div class="section_details"> 
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Contractor`s Plant and Machinery</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form id="e-quotation-form" method="post" name="e-quotation-form">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$pipeLineId}}" name="id" id="id">
                    <input type="hidden" name="quoteActive" id="quoteActive" @if(@$insurerReply['quoteStatus']=='active') value="true" @else value="false" @endif>
                    @if(@$token)
                        <input type="hidden" name="hiddenToken" id="hiddenToken" value="{{$token}}">
                    @endif
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">NAME <span style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['firstName']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">If there is any subsidiary/affliated company <span  style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['affCompany']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form_group">
                                    <label class="form_label">Address<span style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                    <p>{{@$pipeline_details['formData']['addressDetails']['addressLine1']}},{{$pipeline_details['formData']['addressDetails']['city']}},
                                        {{$pipeline_details['formData']['addressDetails']['state']}},{{$pipeline_details['formData']['addressDetails']['country']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label">BUSINESS OF THE  INSURED<span style="visibility:hidden">*</span></label>
                                    <div class="enter_data">
                                        <p>{{@$pipeline_details['formData']['businessType']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label bold">Geographical Area <span style="visibility:hidden">*</span></label>
                                    <div class="enter_data border_none">
                                        @if(@$pipeline_details['formData']['placeOfEmployment']['withinUAE'] == 1)
                                            <?php $geo_area=@$pipeline_details['formData']['placeOfEmployment']['emirateName'].' ,UAE';?>
                                        @elseif(@$pipeline_details['formData']['placeOfEmployment']['withinUAE'] == 0)
                                            <?php $geo_area=@$pipeline_details['formData']['placeOfEmployment']['countryName'];?>
                                        @endif
                                        <p>{{$geo_area}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="card_separation">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form_group">
                                        <label class="form_label bold">CLAIM EXPERIENCE <span style="visibility: hidden">*</span></label>
                                        <table class="table table-bordered custom_table">
                                            <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Claim amount</th>
                                                <th>Description</th>
    
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Year 1 </td>
                                                <td>
                                                    @if(isset($pipeline_details['formData']['claimsHistory'][0]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][0]['claim_amount']),2)}} @else {{ ' -- '}} @endif</td>
                                                <td>{{@$pipeline_details['formData']['claimsHistory'][0]['description']?:' -- '}}</td>
                                            </tr>
    
                                            <tr>
                                                <td>Year 2</td>
                                                <td>
                                                    @if(isset($pipeline_details['formData']['claimsHistory'][1]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][1]['claim_amount']),2)}} @else {{ ' -- '}}@endif</td>
                                                <td>{{@$pipeline_details['formData']['claimsHistory'][1]['description']?:' -- '}}</td>
    
                                            </tr>
    
                                            <tr>
                                                <td>Year 3</td>
                                                <td>
                                                    @if(isset($pipeline_details['formData']['claimsHistory'][2]['claim_amount'])&&(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount'])!="")
                                                        {{number_format(trim(@$pipeline_details['formData']['claimsHistory'][2]['claim_amount']),2)}} @else {{ ' -- '}} @endif</td>
                                                <td>{{@$pipeline_details['formData']['claimsHistory'][2]['description']?:' -- '}}</td>
                                            </tr>
    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($pipeline_details['formData']['authRepair']&& $pipeline_details['formData']['authRepair']!='')
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Authorised repair limit<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="authRepair_1" class="radio">
                                        <input type="radio" name="authRepair" value="Agree" id="authRepair_1" class="hidden" @if(@$insurerReply['authRepair']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="authRepair_2" class="radio">
                                        <input type="radio" name="authRepair" value="Not Agree" id="authRepair_2" class="hidden" @if(@$insurerReply['authRepair']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="authRepair_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['authRepair']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Strike, riot and civil commotion and malicious damage<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="strikeRiot_1" class="radio">
                                        <input type="radio" name="strikeRiot" value="Agree" id="strikeRiot_1" class="hidden" @if(@$insurerReply['strikeRiot']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="strikeRiot_2" class="radio">
                                        <input type="radio" name="strikeRiot" value="Not Agree" id="strikeRiot_2" class="hidden" @if(@$insurerReply['strikeRiot']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="strikeRiot_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['strikeRiot']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Overtime, night works , works on public holidays and express freight<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="overtime_1" class="radio">
                                        <input type="radio" name="overtime" value="Agree" id="overtime_1" class="hidden" @if(@$insurerReply['overtime']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="overtime_2" class="radio">
                                        <input type="radio" name="overtime" value="Not Agree" id="overtime_2" class="hidden" @if(@$insurerReply['overtime']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="overtime_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['overtime']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for extra charges for Airfreight<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="coverExtra_1" class="radio">
                                        <input type="radio" name="coverExtra" value="Agree" id="coverExtra_1" class="hidden" @if(@$insurerReply['coverExtra']['isAgree'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="coverExtra_2" class="radio">
                                        <input type="radio" name="coverExtra" value="Not Agree" id="coverExtra_2" class="hidden" @if(@$insurerReply['coverExtra']['isAgree'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form_group">
                                        <textarea name="coverExtra_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['coverExtra']['comment']}}</textarea>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for underground Machinery and equipment<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="coverUnder_1" class="radio">
                                        <input type="radio" name="coverUnder" value="Agree" id="coverUnder_1" class="hidden" @if(@$insurerReply['coverUnder'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="coverUnder_2" class="radio">
                                        <input type="radio" name="coverUnder" value="Not Agree" id="coverUnder_2" class="hidden" @if(@$insurerReply['coverUnder'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (isset($pipeline_details['formData']['drillRigs'])&& $pipeline_details['formData']['drillRigs']==true) 
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form_label bold"><i class="fa fa-circle"></i>Cover for water well drilling rigs and equipment<span>*</span></label>
                            </div>
                            <div class="form_group" style="padding-left: 15px;">
                                <div class="cntr">
                                    <label for="drillRigs_1" class="radio">
                                        <input type="radio" name="drillRigs" value="Agree" id="drillRigs_1" class="hidden" @if(@$insurerReply['drillRigs'] == 'Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Agree</span>
                                    </label>
                                    <label for="drillRigs_2" class="radio">
                                        <input type="radio" name="drillRigs" value="Not Agree" id="drillRigs_2" class="hidden" @if(@$insurerReply['drillRigs'] == 'Not Agree') checked @endif/>
                                        <span class="label"></span>
                                        <span>Not Agree</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Inland Transit including loading and unloading cover<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="inlandTransit_1" class="radio">
                                            <input type="radio" name="inlandTransit" value="Agree" id="inlandTransit_1" class="hidden" @if(@$insurerReply['inlandTransit']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="inlandTransit_2" class="radio">
                                            <input type="radio" name="inlandTransit" value="Not Agree" id="inlandTransit_2" class="hidden" @if(@$insurerReply['inlandTransit']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form_group">
                                            <textarea name="inlandTransit_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['inlandTransit']['comment']}}</textarea>
                                        </div>
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Transit and Road risks whilst the insured items are travelling/transporting on own power on public roads<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="transitRoad_1" class="radio">
                                            <input type="radio" name="transitRoad" value="Agree" id="transitRoad_1" class="hidden" @if(@$insurerReply['transitRoad']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="transitRoad_2" class="radio">
                                            <input type="radio" name="transitRoad" value="Not Agree" id="transitRoad_2" class="hidden" @if(@$insurerReply['transitRoad']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form_group">
                                            <textarea name="transitRoad_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['transitRoad']['comment']}}</textarea>
                                        </div>
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <label class="form_label bold"><i class="fa fa-circle"></i>Third Party Liability- whilst on site, owned and/or hired parking yard, during participation in any sales promotions, sports, social events, display at various sites within GCC either contract of hire or otherwise<span>*</span></label>
                                </div>
                                <div class="form_group" style="padding-left: 15px;">
                                    <div class="cntr">
                                        <label for="thirdParty_1" class="radio">
                                            <input type="radio" name="thirdParty" value="Agree" id="thirdParty_1" class="hidden" @if(@$insurerReply['thirdParty']['isAgree'] == 'Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Agree</span>
                                        </label>
                                        <label for="thirdParty_2" class="radio">
                                            <input type="radio" name="thirdParty" value="Not Agree" id="thirdParty_2" class="hidden" @if(@$insurerReply['thirdParty']['isAgree'] == 'Not Agree') checked @endif/>
                                            <span class="label"></span>
                                            <span>Not Agree</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <div class="form_group">
                                            <textarea name="thirdParty_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['thirdParty']['comment']}}</textarea>
                                        </div>
                                </div>
                            </div>
                            @if(isset($pipeline_details['formData']['machEquip']['machEquip']) && ($pipeline_details['formData']['machEquip']['machEquip'] == true) &&
                            isset($pipeline_details['formData']['coverHired']))
                                <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label bold"><i class="fa fa-circle"></i>Cover when items are hired out<span>*</span></label>
                                        </div>
                                        <div class="form_group" style="padding-left: 15px;">
                                            <div class="cntr">
                                                <label for="coverHired_1" class="radio">
                                                    <input type="radio" name="coverHired" value="Agree" id="coverHired_1" class="hidden" @if(@$insurerReply['coverHired'] == 'Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Agree</span>
                                                </label>
                                                <label for="coverHired_2" class="radio">
                                                    <input type="radio" name="coverHired" value="Not Agree" id="coverHired_2" class="hidden" @if(@$insurerReply['coverHired'] == 'Not Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Not Agree</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                            <div class="row">
                                    <div class="col-md-12">
                                        <label class="form_label bold"><i class="fa fa-circle"></i>Automatic Reinstatement of sum insured<span>*</span></label>
                                    </div>
                                    <div class="form_group" style="padding-left: 15px;">
                                        <div class="cntr">
                                            <label for="autoSum_1" class="radio">
                                                <input type="radio" name="autoSum" value="Agree" id="autoSum_1" class="hidden" @if(@$insurerReply['autoSum']['isAgree'] == 'Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Agree</span>
                                            </label>
                                            <label for="autoSum_2" class="radio">
                                                <input type="radio" name="autoSum" value="Not Agree" id="autoSum_2" class="hidden" @if(@$insurerReply['autoSum']['isAgree'] == 'Not Agree') checked @endif/>
                                                <span class="label"></span>
                                                <span>Not Agree</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="form_group">
                                                <textarea name="autoSum_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['autoSum']['comment']}}</textarea>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label bold"><i class="fa fa-circle"></i>Including the risk of erection, resettling and dismantling<span>*</span></label>
                                        </div>
                                        <div class="form_group" style="padding-left: 15px;">
                                            <div class="cntr">
                                                <label for="includRisk_1" class="radio">
                                                    <input type="radio" name="includRisk" value="Agree" id="includRisk_1" class="hidden" @if(@$insurerReply['includRisk'] == 'Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Agree</span>
                                                </label>
                                                <label for="includRisk_2" class="radio">
                                                    <input type="radio" name="includRisk" value="Not Agree" id="includRisk_2" class="hidden" @if(@$insurerReply['includRisk'] == 'Not Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Not Agree</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label bold"><i class="fa fa-circle"></i>Tool of trade extension<span>*</span></label>
                                        </div>
                                        <div class="form_group" style="padding-left: 15px;">
                                            <div class="cntr">
                                                <label for="tool_1" class="radio">
                                                    <input type="radio" name="tool" value="Agree" id="tool_1" class="hidden" @if(@$insurerReply['tool']['isAgree'] == 'Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Agree</span>
                                                </label>
                                                <label for="tool_2" class="radio">
                                                    <input type="radio" name="tool" value="Not Agree" id="tool_2" class="hidden" @if(@$insurerReply['tool']['isAgree'] == 'Not Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Not Agree</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form_group">
                                                    <textarea name="tool_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['tool']['comment']}}</textarea>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label class="form_label bold"><i class="fa fa-circle"></i>72 Hours clause<span>*</span></label>
                                            </div>
                                            <div class="form_group" style="padding-left: 15px;">
                                                <div class="cntr">
                                                    <label for="hoursClause_1" class="radio">
                                                        <input type="radio" name="hoursClause" value="Agree" id="hoursClause_1" class="hidden" @if(@$insurerReply['hoursClause'] == 'Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Agree</span>
                                                    </label>
                                                    <label for="hoursClause_2" class="radio">
                                                        <input type="radio" name="hoursClause" value="Not Agree" id="hoursClause_2" class="hidden" @if(@$insurerReply['hoursClause'] == 'Not Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Not Agree</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label bold"><i class="fa fa-circle"></i>Nominated Loss Adjuster Clause<span>*</span></label>
                                        </div>
                                        <div class="form_group" style="padding-left: 15px;">
                                            <div class="cntr">
                                                <label for="lossAdj_1" class="radio">
                                                    <input type="radio" name="lossAdj" value="Agree" id="lossAdj_1" class="hidden" @if(@$insurerReply['lossAdj']['isAgree'] == 'Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Agree</span>
                                                </label>
                                                <label for="lossAdj_2" class="radio">
                                                    <input type="radio" name="lossAdj" value="Not Agree" id="lossAdj_2" class="hidden" @if(@$insurerReply['lossAdj']['isAgree'] == 'Not Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Not Agree</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="form_group">
                                                    <textarea name="lossAdj_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['lossAdj']['comment']}}</textarea>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form_label bold"><i class="fa fa-circle"></i>Primary Insurance Clause<span>*</span></label>
                                        </div>
                                        <div class="form_group" style="padding-left: 15px;">
                                            <div class="cntr">
                                                <label for="primaryClause_1" class="radio">
                                                    <input type="radio" name="primaryClause" value="Agree" id="primaryClause_1" class="hidden" @if(@$insurerReply['primaryClause'] == 'Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Agree</span>
                                                </label>
                                                <label for="primaryClause_2" class="radio">
                                                    <input type="radio" name="primaryClause" value="Not Agree" id="primaryClause_2" class="hidden" @if(@$insurerReply['primaryClause'] == 'Not Agree') checked @endif/>
                                                    <span class="label"></span>
                                                    <span>Not Agree</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label class="form_label bold"><i class="fa fa-circle"></i>Payment on accounts clause-75%<span>*</span></label>
                                            </div>
                                            <div class="form_group" style="padding-left: 15px;">
                                                <div class="cntr">
                                                    <label for="paymentAccount_1" class="radio">
                                                        <input type="radio" name="paymentAccount" value="Agree" id="paymentAccount_1" class="hidden" @if(@$insurerReply['paymentAccount']['isAgree'] == 'Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Agree</span>
                                                    </label>
                                                    <label for="paymentAccount_2" class="radio">
                                                        <input type="radio" name="paymentAccount" value="Not Agree" id="paymentAccount_2" class="hidden" @if(@$insurerReply['paymentAccount']['isAgree'] == 'Not Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Not Agree</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                    <div class="form_group">
                                                        <textarea name="paymentAccount_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['paymentAccount']['comment']}}</textarea>
                                                    </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label class="form_label bold"><i class="fa fa-circle"></i>85% condition of average<span>*</span></label>
                                            </div>
                                            <div class="form_group" style="padding-left: 15px;">
                                                <div class="cntr">
                                                    <label for="avgCondition_1" class="radio">
                                                        <input type="radio" name="avgCondition" value="Agree" id="avgCondition_1" class="hidden" @if(@$insurerReply['avgCondition'] == 'Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Agree</span>
                                                    </label>
                                                    <label for="avgCondition_2" class="radio">
                                                        <input type="radio" name="avgCondition" value="Not Agree" id="avgCondition_2" class="hidden" @if(@$insurerReply['avgCondition'] == 'Not Agree') checked @endif/>
                                                        <span class="label"></span>
                                                        <span>Not Agree</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Automatic addition<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="autoAddition_1" class="radio">
                                                            <input type="radio" name="autoAddition" value="Agree" id="autoAddition_1" class="hidden" @if(@$insurerReply['autoAddition']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="autoAddition_2" class="radio">
                                                            <input type="radio" name="autoAddition" value="Not Agree" id="autoAddition_2" class="hidden" @if(@$insurerReply['autoAddition']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="autoAddition_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['autoAddition']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Cancellation clause<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="cancelClause_1" class="radio">
                                                            <input type="radio" name="cancelClause" value="Agree" id="cancelClause_1" class="hidden" @if(@$insurerReply['cancelClause']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="cancelClause_2" class="radio">
                                                            <input type="radio" name="cancelClause" value="Not Agree" id="cancelClause_2" class="hidden" @if(@$insurerReply['cancelClause']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="cancelClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['cancelClause']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Removal of debris<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="derbis_1" class="radio">
                                                            <input type="radio" name="derbis" value="Agree" id="derbis_1" class="hidden" @if(@$insurerReply['derbis']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="derbis_2" class="radio">
                                                            <input type="radio" name="derbis" value="Not Agree" id="derbis_2" class="hidden" @if(@$insurerReply['derbis']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="derbis_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['derbis']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Repair investigation clause<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="repairClause_1" class="radio">
                                                            <input type="radio" name="repairClause" value="Agree" id="repairClause_1" class="hidden" @if(@$insurerReply['repairClause']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="repairClause_2" class="radio">
                                                            <input type="radio" name="repairClause" value="Not Agree" id="repairClause_2" class="hidden" @if(@$insurerReply['repairClause']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="repairClause_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['repairClause']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Temporary repair clause<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="tempRepair_1" class="radio">
                                                            <input type="radio" name="tempRepair" value="Agree" id="tempRepair_1" class="hidden" @if(@$insurerReply['tempRepair']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="tempRepair_2" class="radio">
                                                            <input type="radio" name="tempRepair" value="Not Agree" id="tempRepair_2" class="hidden" @if(@$insurerReply['tempRepair']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="tempRepair_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['tempRepair']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Errors & omission clause<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="errorOmission_1" class="radio">
                                                            <input type="radio" name="errorOmission" value="Agree" id="errorOmission_1" class="hidden" @if(@$insurerReply['errorOmission'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="errorOmission_2" class="radio">
                                                            <input type="radio" name="errorOmission" value="Not Agree" id="errorOmission_2" class="hidden" @if(@$insurerReply['errorOmission'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Minimization of loss<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="minLoss_1" class="radio">
                                                            <input type="radio" name="minLoss" value="Agree" id="minLoss_1" class="hidden" @if(@$insurerReply['minLoss']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="minLoss_2" class="radio">
                                                            <input type="radio" name="minLoss" value="Not Agree" id="minLoss_2" class="hidden" @if(@$insurerReply['minLoss']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="minLoss_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['minLoss']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                              @if(isset($pipeline_details['formData']['affCompany']) && $pipeline_details['formData']['affCompany'] !='' &&
                                            isset($pipeline_details['formData']['crossLiability']))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Cross liability<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="crossLiability_1" class="radio">
                                                            <input type="radio" name="crossLiability" value="Agree" id="crossLiability_1" class="hidden" @if(@$insurerReply['crossLiability']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="crossLiability_2" class="radio">
                                                            <input type="radio" name="crossLiability" value="Not Agree" id="crossLiability_2" class="hidden" @if(@$insurerReply['crossLiability']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="crossLiability_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['crossLiability']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Including cover for loading/ unloading and delivery risks<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="coverInclude_1" class="radio">
                                                            <input type="radio" name="coverInclude" value="Agree" id="coverInclude_1" class="hidden" @if(@$insurerReply['coverInclude'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="coverInclude_2" class="radio">
                                                            <input type="radio" name="coverInclude" value="Not Agree" id="coverInclude_2" class="hidden" @if(@$insurerReply['coverInclude'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Towing charges<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="towCharge_1" class="radio">
                                                            <input type="radio" name="towCharge" value="Agree" id="towCharge_1" class="hidden" @if(@$insurerReply['towCharge']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="towCharge_2" class="radio">
                                                            <input type="radio" name="towCharge" value="Not Agree" id="towCharge_2" class="hidden" @if(@$insurerReply['towCharge']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="towCharge_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['towCharge']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div>  
                                            @if(isset($pipeline_details['formData']['policyBank']['policyBank']) && $pipeline_details['formData']['policyBank']['policyBank'] ==true && isset($pipeline_details['formData']['lossPayee']))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Loss payee clause<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="lossPayee_1" class="radio">
                                                            <input type="radio" name="lossPayee" value="Agree" id="lossPayee_1" class="hidden" @if(@$insurerReply['lossPayee'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="lossPayee_2" class="radio">
                                                            <input type="radio" name="lossPayee" value="Not Agree" id="lossPayee_2" class="hidden" @if(@$insurerReply['lossPayee'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> 
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Agency repair<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="agencyRepair_1" class="radio">
                                                            <input type="radio" name="agencyRepair" value="Agree" id="agencyRepair_1" class="hidden" @if(@$insurerReply['agencyRepair']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="agencyRepair_2" class="radio">
                                                            <input type="radio" name="agencyRepair" value="Not Agree" id="agencyRepair_2" class="hidden" @if(@$insurerReply['agencyRepair']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="agencyRepair_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['agencyRepair']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Indemnity to principal<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="indemnityPrincipal_1" class="radio">
                                                            <input type="radio" name="indemnityPrincipal" value="Agree" id="indemnityPrincipal_1" class="hidden" @if(@$insurerReply['indemnityPrincipal'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="indemnityPrincipal_2" class="radio">
                                                            <input type="radio" name="indemnityPrincipal" value="Not Agree" id="indemnityPrincipal_2" class="hidden" @if(@$insurerReply['indemnityPrincipal'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Designation of property<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="propDesign_1" class="radio">
                                                            <input type="radio" name="propDesign" value="Agree" id="propDesign_1" class="hidden" @if(@$insurerReply['propDesign'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="propDesign_2" class="radio">
                                                            <input type="radio" name="propDesign" value="Not Agree" id="propDesign_2" class="hidden" @if(@$insurerReply['propDesign'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Special condition :It is understood and agreed that exclusion ‘C’ will not apply to accidental losses’<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="specialAgree_1" class="radio">
                                                            <input type="radio" name="specialAgree" value="Agree" id="specialAgree_1" class="hidden" @if(@$insurerReply['specialAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="specialAgree_2" class="radio">
                                                            <input type="radio" name="specialAgree" value="Not Agree" id="specialAgree_2" class="hidden" @if(@$insurerReply['specialAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Declaration of sum insured and basis of settlement: Total loss claims will be settled on the current market value of the vehicle on the day of accident and insured should submit 3 valuation report for consideration of loss surveyor<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="declarationSum_1" class="radio">
                                                            <input type="radio" name="declarationSum" value="Agree" id="declarationSum_1" class="hidden" @if(@$insurerReply['declarationSum']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="declarationSum_2" class="radio">
                                                            <input type="radio" name="declarationSum" value="Not Agree" id="declarationSum_2" class="hidden" @if(@$insurerReply['declarationSum']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="declarationSum_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['declarationSum']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Salvage: In case of total loss Insurer will give the option to the Insured to purchase the salvage based on the amount of the highest bid obtained by the Insurer<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="salvage_1" class="radio">
                                                            <input type="radio" name="salvage" value="Agree" id="salvage_1" class="hidden" @if(@$insurerReply['salvage']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="salvage_2" class="radio">
                                                            <input type="radio" name="salvage" value="Not Agree" id="salvage_2" class="hidden" @if(@$insurerReply['salvage']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="salvage_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['salvage']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Total Loss:An equipment will be considered as total loss (destroyed) in case the repair cost is 50% or more than the NRV of the equipment (considered as constructive total loss)<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="totalLoss_1" class="radio">
                                                            <input type="radio" name="totalLoss" value="Agree" id="totalLoss_1" class="hidden" @if(@$insurerReply['totalLoss']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="totalLoss_2" class="radio">
                                                            <input type="radio" name="totalLoss" value="Not Agree" id="totalLoss_2" class="hidden" @if(@$insurerReply['totalLoss']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="totalLoss_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['totalLoss']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Profit Sharing<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="profitShare_1" class="radio">
                                                            <input type="radio" name="profitShare" value="Agree" id="profitShare_1" class="hidden" @if(@$insurerReply['profitShare']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="profitShare_2" class="radio">
                                                            <input type="radio" name="profitShare" value="Not Agree" id="profitShare_2" class="hidden" @if(@$insurerReply['profitShare']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="profitShare_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['profitShare']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Claims procedure: Existing claim procedure attached and should form the framework for renewal period<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="claimPro_1" class="radio">
                                                            <input type="radio" name="claimPro" value="Agree" id="claimPro_1" class="hidden" @if(@$insurerReply['claimPro']['isAgree'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="claimPro_2" class="radio">
                                                            <input type="radio" name="claimPro" value="Not Agree" id="claimPro_2" class="hidden" @if(@$insurerReply['claimPro']['isAgree'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form_group">
                                                            <textarea name="claimPro_comment" class="form_input sm_textarea" placeholder="Comments...">{{@$insurerReply['claimPro']['comment']}}</textarea>
                                                        </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form_label bold"><i class="fa fa-circle"></i>Waiver of subrogation against principal<span>*</span></label>
                                                </div>
                                                <div class="form_group" style="padding-left: 15px;">
                                                    <div class="cntr">
                                                        <label for="waiver_1" class="radio">
                                                            <input type="radio" name="waiver" value="Agree" id="waiver_1" class="hidden" @if(@$insurerReply['waiver'] == 'Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Agree</span>
                                                        </label>
                                                        <label for="waiver_2" class="radio">
                                                            <input type="radio" name="waiver" value="Not Agree" id="waiver_2" class="hidden" @if(@$insurerReply['waiver'] == 'Not Agree') checked @endif/>
                                                            <span class="label"></span>
                                                            <span>Not Agree</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> 
               <div class="row">
                   
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Rate required (in %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['rate'] != ''){{number_format(@$formData['rate'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="rate" type="text" value="@if(isset($insurerReply['rate']) && $insurerReply['rate'] != ''){{number_format(trim(@$insurerReply['rate']),2)}}@endif">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Premium required (in %) <span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['premium'] != ''){{number_format(@$formData['premium'],2)}}@endif</p>
                                </div>
                                <input class="form_input number" name="premium" type="text" value="@if(isset($insurerReply['premium']) && $insurerReply['premium'] != ''){{number_format(trim(@$insurerReply['premium']),2)}}@endif">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <label class="form_label bold">Payment Terms<span>*</span></label>
                                <div class="enter_data border_none">
                                    <p style="margin-bottom: 10px;">Expected : @if($formData['payTerm'] != ''){{@$formData['payTerm']}}@endif</p>
                                </div>
                                <input class="form_input" name="payTerm" type="text" value="@if(isset($insurerReply['payTerm']) && $insurerReply['payTerm'] != ''){{@$insurerReply['payTerm']}}@endif">
                            </div>
                        </div>
               </div>
 <button class="btn btn-primary btn_action pull-right" type="submit" id="quot_submit" @if($pipelineStatus=='Approved E Quote' || $pipelineStatus=='Issuance') style="display: none" @endif> @if(@$insurerReply['quoteStatus']=='active') Update @else Proceed @endif</button>
                    <button class="btn blue_btn btn_action pull-right" type="button" @if(@$insurerReply['quoteStatus']=='active') style="display: none" @endif onclick="saveDraft()">SAVE AS DRAFT</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/jquery.validate.js')}}"></script>

    <!-- Custom Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/custom-select.js')}}"></script>

    <!-- Bootstrap Select -->
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script>
       $(document).ready(function(){
        $.validator.messages.required = 'Please select agree or not agree';

        $("input[type='radio']").addClass('required');
        // $("table input[type='text']").addClass('required');
        });
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
        jQuery.validator.addMethod("dropdown_required", function(value, element) {
            // console.log($(element).closest( ".row" ).is(":hidden"));
            if(value!='' || $(element).closest( ".row" ).is(":hidden")) {
                return true;
            } else {
                return false;
            }
            // allow any non-whitespace characters as the host part
//        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
        }, 'Please select this field.');
        function validateFunction(name)
        {
            element = document.getElementsByName(name);
            if($(element).closest( ".row" ).is(":hidden")){
                return false
            }
            else
            {
                return true;
            }
        }
        //Form valodation
        $('#e-quotation-form').validate({
            ignore:[],
            rules:{
                rate:{
                    required:true,
                    number:true,
                    max:100
                },
                premium:{
                    required:true,
                    number:true,
                    max:100
                },
                payTerm:{
                    required:true
                }
        },
            messages:{
                rate: "Please enter rate in %.",
                premium: "Please enter premium in %.",
                payTerm: "Please enter payment terms.",
            },
            errorPlacement: function (error, element)
            {
                
                if(element.attr('name')=='premium' || element.attr('name')=='payTerm' || element.attr('name')=='rate') {
                    error.insertAfter(element);
                    scrolltop();
                }
                // else if(element.attr('name')=='select_liability' || element.attr('name')=='medical_expense' || element.attr('name')=='repatriation_expenses')
                // {
                //     error.insertAfter(element.parent().parent().parent().parent());
                // }
                else{
                    error.insertAfter(element.parent().parent());
                }
            },
//            invalidHandler: function(form, validator) {
//                validator.errorList[0].element.focus();
//            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#e-quotation-form")[0]);
                $('#preLoader').fadeIn('slow');
                $.ajax({
                    method: 'post',
                    url: '{{url('insurer/plant-save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                        else if(result=='amended')
                        {
                            window.location.href = '{{url('insurer/equotes-given')}}';
                        }
                        else
                        {
                            window.location.href = '{{url('insurer/e-quotes-provider')}}';
                        }
                    }
                });
            }
        });
        function scrolltop()
        {
            $('html,body').animate({
                scrollTop: 150
            }, 0);
        }

        function dropdownValidation(obj)
        {
            var value = obj.value;

            if(value == '')
                $('#'+obj.id+'-error').show();
            else
                $('#'+obj.id+'-error').hide();
        }
        function saveDraft()
        {
            var form_data = new FormData($("#e-quotation-form")[0]);
            form_data.append('_token',"{{csrf_token()}}");
            form_data.append('saveDraft', 'true');
            $('#preLoader').fadeIn('slow');
            $.ajax({
                method: 'post',
                url: '{{url('insurer/plant-save')}}',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success:function (data) {
                    if(data)
                    {
                        location.href="{{url('insurer/e-quotes-provider')}}";
                    }
                }
            });
        }
    </script>
@endpush


