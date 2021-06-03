@if(@$PipelineItems['customer']['type']=='Single')
    <div class="row" id="single_type">
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Salutation <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" name="salutation" id="salutation">
                        <option @if(@$PipelineItems['customer']['salutation'] =="Mr.") selected @endif>Mr. </option>
                        <option @if(@$PipelineItems['customer']['salutation'] =="Ms.") selected @endif>Ms. </option>
                        <option @if(@$PipelineItems['customer']['salutation'] =="Mrs.") selected @endif>Mrs. </option>
                        <option @if(@$PipelineItems['customer']['salutation'] =="Dr.") selected @endif>Dr. </option>
                        <option @if(@$PipelineItems['customer']['salutation'] =="Prof.") selected @endif>Prof. </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Enter First Name <span>*</span></label>
                <input class="form_input" name="firstName" id="firstName" placeholder="First Name" type="text" @if(!empty($form_data)) value="{{$form_data['firstName']}}" @else value="{{@$PipelineItems['customer']['firstName']}}" @endif>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Enter Middle Name <span style="visibility: hidden">*</span></label>
                <input class="form_input" name="middleName" id="middleName" placeholder="Middle Name" type="text" @if(!empty($form_data)) value="{{$form_data['middleName']}}" @else  value="{{@$PipelineItems['customer']['middleName']}}" @endif>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Enter Last Name <span>*</span></label>
                <input class="form_input" name="lastName" id="lastName" placeholder="Last Name" type="text" @if(!empty($form_data)) value="{{$form_data['lastName']}}" @else  value="{{@$PipelineItems['customer']['lastName']}}" @endif>
            </div>
        </div>
    </div>
@else
    <div class="row" id="corporate_type">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label">Enter First Name <span>*</span></label>
                <input class="form_input" name="firstName" id="firstName" placeholder="First Name" type="text" @if(!empty($form_data)) value="{{$form_data['firstName']}}" @else  value="{{@$PipelineItems['customer']['name']}}" @endif>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <label class="form_label">Address <span>*</span></label>
    </div>
    <div class="col-md-6">
        <div class="form_group">
            <?php $addressDetails = @$form_data['addressDetails'] ?>
            <input class="form_input" name="addressLine1"  id="addressLine1" placeholder="Street Line 1" type="text"  @if(!empty($form_data)) value="{{ucwords($form_data['addressDetails']['addressLine1'])}}" @else value="{{ucwords(@$PipelineItems->getCustomer->addressLine1)}}" @endif>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form_group">
            <input class="form_input" name="addressLine2" id="addressLine2" placeholder="Street Line 2" type="text" @if(!empty($form_data)) value="{{ucwords($form_data['addressDetails']['addressLine2'])}}" @else value="{{ucwords(@$PipelineItems->getCustomer->addressLine2)}}" @endif>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form_group">
            <label class="form_label">Country <span>*</span></label>
            <div class="custom_select countryDiv">
                <select  class="selectpicker" data-hide-disabled="true" data-live-search="true"   id="country1" name="country" onChange="getState('country1','state1');">
                    <option value="">Select Country</option>
                    @foreach($country_name as $country)
                        <option value="{{$country}}" @if(!empty($form_data)) @if(@$form_data['addressDetails']['country']== $country) selected @endif @else @if(@$customer_details['countryName']== $country) selected @endif @endif>{{$country}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form_group">
            <label class="form_label">Emirate <span>*</span></label>
            {{--<div class="custom_select" id="state_div">--}}
                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="state" id="state1" onchange="validation(this.id);">
                    <option disabled >Select Emirate</option>
                </select>
            {{--</div>--}}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form_group">
            <label class="form_label">City  <span>*</span></label>
            <input class="form_input" name="city" id="city" placeholder="City" type="text"   @if(!empty($form_data)) value="{{ucwords($form_data['addressDetails']['city'])}}" @else value="{{ucwords(@$PipelineItems->getCustomer->streetName)}}" @endif  >
        </div>
    </div>
    <div class="col-md-3">
        <div class="form_group">
            <label class="form_label">Pin/zip <span>*</span></label>
            <input class="form_input" name="zipCode" id="zipCode" placeholder="Pin/Zip" type="text" @if(!empty($form_data)) value="{{$form_data['addressDetails']['zipCode']}}" @else value="{{@$PipelineItems->getCustomer->zipCode}}" @endif>
        </div>
    </div>

</div>
    <div class="row">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label">Name of the Company  <span>*</span></label>
                <input class="form_input" name="company_name" id="company_name" placeholder="Name of the Company" type="text" @if(!empty($form_data)) value="{{$form_data['companyName']}}" @endif>
            </div>
        </div>
    </div>
    {{-- name of the company --}}
<div class="row">
    <div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <label class="form_label bold">No of locations <span>*</span></label>
        </div>
        <div class="col-md-6">
            <div class="form_group">
                <input class="form_input" placeholder="No of locations" name="no_of_locations" id="no_of_locations"   value="{{@$form_data['risk']['noLocations']}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form_group">
                <input class="form_input" placeholder="Locations of the Risk" name="locations_risk" id="locations_risk" 
                type="text" value="{{@$form_data['risk']['locationRisk']}}">
            </div>
        </div>
    </div>
</div>
</div>
{{-- No of locations --}}
<div class="card_separation">
<div class="row">
    <div class="col-md-4">
            <div class="card_sub_head">
                    <div class="clearfix">
                        <h3 class="card_sub_heading pull-left">Occupancy</h3>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label bold">Type of Occupancy <span>*</span></label>
                        <div class="custom_select">
                            <select class="form_input" id="occupancy" name="occupancy" onchange="validation(this.id)">
                                <option value="" selected>Select</option>            
                                    <option value="Warehouse" @if($form_data['occupancy']['type'] == "Warehouse") selected @endif >Warehouse</option>
                                    <option value="Factory" @if($form_data['occupancy']['type'] == "Factory") selected @endif >Factory </option>                   
                                    <option value="Building" @if($form_data['occupancy']['type'] == "Building") selected @endif >Building</option>
                                    <option value="Shop" @if($form_data['occupancy']['type'] == "Shop") selected @endif>Shop</option>
                                    <option value="Showroom" @if($form_data['occupancy']['type'] == "Showroom") selected @endif>Showroom</option>
                                    <option value="Residence" @if($form_data['occupancy']['type'] == "Residence") selected @endif>Residence</option>
                                    <option value="Labour Camp" @if($form_data['occupancy']['type'] == "Labour Camp") selected @endif>Labour Camp</option>
                                    <option value="Office" @if($form_data['occupancy']['type'] == "Office") selected @endif>Office</option>
                                    <option value="Others" @if($form_data['occupancy']['type'] == "Others") selected @endif>Others</option>
                            </select>
                        </div>
                    </div>
                </div>
           
    <div class="col-md-8" id="occupancy_other" @if((isset($form_data['occupancy']['type']) && $form_data['occupancy']['type'] == "Others")) style="display:block" @else style="display:none" @endif>
        <div class="row"  >
            <div class="col-md-12">
                <div class="form_group">
                    <label class="form_label bold">Others please specify <span>*</span></label>
                <input class="form_input" name="other_occupancy" onchange="validation(this.id)" value="{{@$form_data['occupancy']['Others']}}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4" id="warehouse_other" @if((isset($form_data['occupancy']['type']) && $form_data['occupancy']['type'] == "Warehouse")) style="display:block" @else style="display:none" @endif>
            <div class="row"  style="padding-top: 19px;">
                <div class="col-md-12">
                    <div class="form_group">  
                        <div class="cntr" style="margin-bottom: 5px">
                        <label for="multi_warehouse" class="radio" style="margin-bottom: 0">
                            <input type="radio" name="warehouse_type" value="Multi Shed" id="multi_warehouse" @if(@$form_data['occupancy']['warehouseType'] == 'Multi Shed') checked @endif class="hidden"/>
                            <span class="label"></span>
                            <span>Multi shed </span>
                        </label>
                        <label for="single_warehouse" class="radio" style="margin-bottom: 0">
                            <input type="radio" name="warehouse_type" value="Single warehouse" id="single_warehouse" @if(@$form_data['occupancy']['warehouseType'] == 'Single' || @$form_data['occupancy']['warehouseType'] == 'Single warehouse') checked @endif class="hidden"/>
                            <span class="label"></span>
                            <span>Single warehouse</span>
                        </label>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
{{-- Occupancy --}}

<div class="row">
        <div class="col-md-6">
            <div class="form_group">
                <label class="form_label">Age of the building  <span>*</span></label>
                <input class="form_input" name="age_building" id="age_building" placeholder="Age of the building" value={{@$form_data['ageBuilding']}}>
            </div>               
        </div>
        <div class="col-md-6">
            <div class="form_group">
                <div class="form_group">
                    <label class="form_label">No of floors  <span>*</span></label>
                    <input class="form_input" name="no_of_floors" id="no_of_floors" placeholder="No of floors"  value={{@$form_data['noOfFloors']}} >
                </div>
            </div>
        </div>     
</div>
{{-- Age of the building & No of floors --}}

<div class="card_separation" >
<div class="row">
    <div class="col-md-4">
        <div class="form_group">
            <label class="form_label bold">Existence about any hazardous material <span>*</span></label>
            <div class="custom_select">
                <select class="form_input" id="hazardous_material" name="hazardous_material" onchange="validation(this.id)">
                    <option value="" selected>Select</option>            
                    <option value="yes" @if(isset($form_data['hazardous']['hazardous']) && @$form_data['hazardous']['hazardous'] == true) selected @endif>Yes</option>
                    <option value="no" @if(isset($form_data['hazardous']['hazardous']) && @$form_data['hazardous']['hazardous'] == false) selected @endif>No</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-8"  id="hazardous_yes" @if(@$form_data['hazardous']['hazardous'] == true) style="display:block" @else style="display:none" @endif>
        <div class="row">
            <div class="col-md-12">
                <div class="form_group">
                    <label class="form_label bold">Specify<span>*</span></label>
                    <input class="form_input"  name="hazardous_reason" id="hazardous_reason" onchange="validation(this.id)" value="{{@$form_data['hazardous']['hazardous_reason']}}" >
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{-- Existence about any hazardous material --}}

<div class="card_separation" >
<div class="row">
        <div class="col-md-4">
                <div class="card_sub_head">
                        <div class="clearfix">
                            <h3 class="card_sub_heading pull-left">Construction</h3>
                        </div>
                </div>
            <div class="form_group">
                <label class="form_label bold">Type of Construction <span>*</span></label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                    <label class="form_label bold">Roof <span>*</span></label>
                    <div class="custom_select">
                            <select class="form_input" id="roof" name="roof" onchange="validation(this.id)">
                                <option value="" selected>Select</option>                                 
                                <option value="Rcc"@if(@$form_data['constuctionType']['roof'] == 'Rcc')selected @endif>Rcc</option>
                                <option value="Kirby" @if(@$form_data['constuctionType']['roof'] == 'Kirby')selected @endif>Kirby</option>
                            </select>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="form_group">
                        <label class="form_label bold">Walls <span>*</span></label>
                        <div class="custom_select">
                                <select class="form_input" id="construction_walls" name="construction_walls" onchange="validation(this.id)">
                                    <option value="" selected>Select</option>                                 
                                    <option value="Cement Wall" @if(@$form_data['constuctionType']['wallType'] == 'Cement Wall')selected @endif>Cement Wall</option>
                                    <option value="Brick Wall" @if(@$form_data['constuctionType']['wallType'] == 'Brick Wall')selected @endif>Brick Wall</option>
                                    <option value="Non Cladding" @if(@$form_data['constuctionType']['wallType'] == 'Non Cladding')selected @endif >Non Cladding</option>
                                    <option value="Cladding" @if(@$form_data['constuctionType']['wallType'] == 'Cladding')selected @endif>Cladding</option>
                                </select>
                            </div>
                    </div>
                </div>
    </div>
        {{-- Construction-Roof --}}
            {{-- <div class="row">
               
            </div> --}}

            
            <div  id="cladding_show"   @if(@$form_data['constuctionType']['wallType'] == 'Cladding') style="display:block" @else style="display:none"@endif>
                                <div class="row">
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text">Percentage of Cladding on the overall building exterior wall construction<span>*</span></label>
                                    {{-- <input class="form_input" name="percentage_cladding" id="percentage_cladding" placeholder="" value="{{@$form_data['constuctionType']['percentageCladding']}}"> --}}
                                    <div class="custom_select">
                                            <select class="form_input" id="percentage_cladding" name="percentage_cladding">
                                                <option value="" selected>Select</option>                                 
                                                <option value="10%" @if(@$form_data['constuctionType']['percentageCladding'] == '10%')selected @endif >10%</option>
                                                <option value="25%" @if(@$form_data['constuctionType']['percentageCladding'] == '25%')selected @endif >25%</option>
                                                <option value="50%" @if(@$form_data['constuctionType']['percentageCladding'] == '50%')selected @endif >50%</option>
                                                <option value="85%" @if(@$form_data['constuctionType']['percentageCladding'] == '85%')selected @endif >85%</option>
                                                <option value="100%" @if(@$form_data['constuctionType']['percentageCladding'] == '100%')selected @endif >100%</option>
                                                <option value="Others" @if(@$form_data['constuctionType']['percentageCladding'] == 'Others')selected @endif >Others</option>
                                            </select>
                                        </div>
                                </div>
        
                            </div>
                            <div class="col-md-4" id="cladding_other_div" @if(@$form_data['constuctionType']['percentageCladding'] == 'Others') style="display:block" @else style="display:none"@endif>
                                    <div class="form_group">
                                            <label class="form_label bold form_text" style="min-height: 40px">Specify<span>*</span></label>
                                            <input class="form_input" name="percentage_cladding_other" id="percentage_cladding_other" placeholder="Other" type="text"
                                         @if(!empty($form_data)) value="{{@$form_data['constuctionType']['percentageCladdingOther']}}" @endif>
                                    </div>
                                </div>
                    <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label bold form_text" style="min-height: 40px">Is cladding present vertically or horizontally or a mix of both<span>*</span></label>
                                <div class="custom_select">
                                        <select class="form_input" id="cladding_show2" name="cladding_presence" onchange="validation(this.id)">
                                            <option value="" selected>Select</option>                                 
                                            <option value="vertically" @if(@$form_data['constuctionType']['claddingPresence'] == 'vertically')selected @endif >Vertically</option>
                                            <option value="horizontally" @if(@$form_data['constuctionType']['claddingPresence'] == 'horizontally')selected @endif >Horizontally</option>
                                            <option value="both" @if(@$form_data['constuctionType']['claddingPresence'] == 'both')selected @endif >Both</option>
                                        </select>
                                    </div>
                            </div>
                        </div>
                      <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Whether continuous or intermittent breaks have been provided <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show3" name="cladding_type" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="yes" @if(isset($form_data['constuctionType']['claddingType']) && @$form_data['constuctionType']['claddingType'] == true)selected @endif>Yes</option>
                                                <option value="no" @if(isset($form_data['constuctionType']['claddingType']) && @$form_data['constuctionType']['claddingType'] == false)selected @endif>No</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Type of Cladding Materials (ACP / others & etc.) <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show4" name="cladding_mat_type" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="ACP" @if(@$form_data['constuctionType']['claddingMatType'] == 'ACP')selected @endif>ACP</option>
                                                <option value="Quadcore" @if(@$form_data['constuctionType']['claddingMatType'] == 'Quadcore')selected @endif>Quadcore</option>
                                                <option value="Poly Urethane" @if(@$form_data['constuctionType']['claddingMatType'] == 'Poly Urethane')selected @endif>Poly Urethane</option>
                                                <option value="PEFoam" @if(@$form_data['constuctionType']['claddingMatType'] == 'PEFoam')selected @endif>PE Foam</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Fire rating of the insulation material used in the Cladding  <span>*</span></label>
                                    <div class="custom_select"> 
                                            <select class="form_input" id="cladding_show5" name="cladding_fire_rate" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="Fire Rated"@if(@$form_data['constuctionType']['claddingFireRate'] == 'Fire Rated')selected @endif>Fire Rated</option>
                                                <option value="Non Fire Rated"@if(@$form_data['constuctionType']['claddingFireRate'] == 'Non Fire Rated')selected @endif>Non Fire Rated</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Technical specification of ACP’s especially on the core material involve <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show6" name="cladding_tech_spec" onchange="validation(this.id)">
                                                    <option value="" selected>Select</option>                                 
                                                    <option value="ACP"@if(@$form_data['constuctionType']['claddingTechSpec'] == 'ACP')selected @endif>ACP</option>
                                                    <option value="Quadcore"@if(@$form_data['constuctionType']['claddingTechSpec'] == 'Quadcore')selected @endif>Quadcore</option>
                                                    <option value="Poly Urethane"@if(@$form_data['constuctionType']['claddingTechSpec'] == 'Poly Urethane')selected @endif>Poly Urethane</option>
                                                    <option value="PE Foam"@if(@$form_data['constuctionType']['claddingTechSpec'] == 'PE Foam')selected @endif>PE Foam</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Material used for construction (Combustible or Non-combustible). <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show7" name="cladding_cons_mat" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="Combustible"@if(@$form_data['constuctionType']['claddingConsMat'] == 'Combustible')selected @endif>Combustible</option>
                                                <option value="Non Combustible"@if(@$form_data['constuctionType']['claddingConsMat'] == 'Non Combustible')selected @endif>Non Combustible</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Whether the insulation material or the ACP core is exposed open at any place <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show8" name="cladding_ins_mat" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="yes" @if(isset($form_data['constuctionType']['claddingInsMat']) && @$form_data['constuctionType']['claddingInsMat'] == true)selected @endif>Yes</option>
                                                <option value="no" @if( isset($form_data['constuctionType']['claddingInsMat']) && @$form_data['constuctionType']['claddingInsMat'] == false)selected @endif>No</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form_group">
                                    <label class="form_label bold form_text" style="min-height: 40px">Available fire fighting facilities <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="cladding_show9" name="cladding_facilities" onchange="validation(this.id)">
                                                <option value="" selected>Select</option>                                 
                                                <option value="Fire Extinguishers"@if(@$form_data['constuctionType']['claddingFacilities'] == 'Fire Extinguishers')selected @endif>Fire Extinguishers</option>
                                                <option value="Sprinklers"@if(@$form_data['constuctionType']['claddingFacilities'] == 'Sprinklers')selected @endif>Sprinklers</option>
                                                <option value="HoseReel"@if(@$form_data['constuctionType']['claddingFacilities'] == 'Hose Reel')selected @endif>Hose Reel</option>
                                                <option value="Smoke Detectors"@if(@$form_data['constuctionType']['claddingFacilities'] == 'Smoke Detectors')selected @endif>Smoke Detectors</option>
                                                <option value="Fire Alarm"@if(@$form_data['constuctionType']['claddingFacilities'] == 'Fire Alarm')selected @endif>Fire Alarm</option>
                                            </select>
                                        </div>
                                </div>
                        </div>
                </div>
                </div>
        {{-- Construction-Cladding --}}


        <div class="row">
                <div class="col-md-4">
                    <div class="form_group">
                        <label class="form_label bold">Floor <span>*</span></label>
                        <div class="custom_select">
                                <select class="form_input" id="floor" name="floor" onchange="validation(this.id)">
                                    <option value="" selected>Select</option> 
                                    <option value="Marble" @if(@$form_data['constuctionType']['floorType'] == 'Marble')selected @endif>Marble</option>                                
                                    <option value="Cement" @if(@$form_data['constuctionType']['floorType'] == 'Cement')selected @endif>Cement</option>
                                </select>
                            </div>
                    </div>
                </div>
          
         {{-- Construction-floor --}}

         <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Year of Construction<span>*</span></label>
                            <div class="custom_select">
                                    <select   class="selectpicker" data-hide-disabled="true" data-live-search="true" id="year_construction" name="year_construction" onchange="validation(this.id)">
                                        <?php 
                                            $earliest_year = 1950;
                                            ?>
                                             <option value="" selected>Select</option>    
                                             @foreach (range(date('Y'), $earliest_year) as $x) 
                                                 <option value="{{$x}}" @if(@$form_data['constuctionType']['yearConstruction'] == $x)selected @endif >{{$x}}</option>
                                             @endforeach
                                        
                                    </select>
                                </div>
                        </div>
            
            </div>
            <div class="col-md-4" style="display:none">
                    <div class="form_group">
                        <label class="form_label bold" >Number of stories <span>*</span></label>
                        <div class="custom_select">
                                    <select   class="selectpicker" data-hide-disabled="true" data-live-search="true" id="number_stories" name="number_stories" onchange="validation(this.id)">
                                            <?php 
                                                $earliest_year = 200;
                                                ?>
                                                 <option value="" selected>Select</option>    
                                                 @foreach (range(1, $earliest_year) as $x) 
                                                     <option value="{{$x}}" @if(@$form_data['constuctionType']['numberStories'] == $x)selected @endif>{{$x}}</option>
                                                 @endforeach
                                            
                                        </select>
                            </div>
                    </div>
                </div>
        </div>
</div>
{{-- Construction --}}


<div class="row">
    <div class="col-md-12">
        <div class="form_group">
            <label class="form_label">Business Activity <span>*</span></label>
            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="businessType" name="businessType" onchange="validation(this.id);">
                <option value="">Select business of the insured </option>
                <option value="Accounts/ Audit firms/ Professional Services/ Law Firms" @if($form_data['businessType'] == "Accounts/ Audit firms/ Professional Services/ Law Firms") selected @endif>Accounts/ Audit firms/ Professional Services/ Law Firms</option>
                <option value="Advertising / Public Relations" @if($form_data['businessType'] == "Advertising / Public Relations") selected @endif>Advertising / Public Relations</option>
                <option value="Agricultural services & Products" @if($form_data['businessType'] == "Agricultural services & Products") selected @endif>Agricultural services & Products</option>
                <option value="Aircraft & ship crew/ terminal operators" @if($form_data['businessType'] == "Aircraft & ship crew/ terminal operators") selected @endif>Aircraft & ship crew/ terminal operators</option>
                <option value="Airports & related infrastructure" @if($form_data['businessType'] == "Airports & related infrastructure") selected @endif>Airports & related infrastructure</option>
                <option value="Alternative energy" @if($form_data['businessType'] == "Alternative energy") selected @endif>Alternative energy</option>
                <option value="Architectural services/ Engineers" @if($form_data['businessType'] == "Architectural services/ Engineers") selected @endif>Architectural services/ Engineers</option>
                <option value="Armed Forces" @if($form_data['businessType'] == "Armed Forces") selected @endif>Armed Forces</option>
                <option value="Art galleries/ fine arts collection" @if($form_data['businessType'] == "Art galleries/ fine arts collection") selected @endif>Art galleries/ fine arts collection</option>
                <option value="Auto manufacturers" @if($form_data['businessType'] == "Auto manufacturers") selected @endif>Auto manufacturers</option>
                <option value="Automobile workshop/ showroom/ garage/ service station" @if($form_data['businessType'] == "Automobile workshop/ showroom/ garage/ service station") selected @endif>Automobile workshop/ showroom/ garage/ service station</option>
                <option value="Automotive spart parts dealer/ traders" @if($form_data['businessType'] == "Automotive spart parts dealer/ traders") selected @endif>Automotive spart parts dealer/ traders</option>
                <option value="Bank/ lenders/ financial institution/ currency exchange" @if($form_data['businessType'] == "Bank/ lenders/ financial institution/ currency exchange") selected @endif>Bank/ lenders/ financial institution/ currency exchange</option>
                <option value="Beverage manufacturing & bottling" @if($form_data['businessType'] == "Beverage manufacturing & bottling") selected @endif>Beverage manufacturing & bottling</option>
                <option value="Bridges & tunnels" @if($form_data['businessType'] == "Bridges & tunnels") selected @endif>Bridges & tunnels</option>
                <option value="Builders/ general contractors" @if($form_data['businessType'] == "Builders/ general contractors") selected @endif>Builders/ general contractors</option>
                <option value="Building materials manufacturers/ traders" @if($form_data['businessType'] == "Building materials manufacturers/ traders") selected @endif>Building materials manufacturers/ traders</option>
                <option value="Business process outsourcing / management services/ trade associations" @if($form_data['businessType'] == "Business process outsourcing / management services/ trade associations") selected @endif>Business process outsourcing / management services/ trade associations</option>
                <option value="Cafes & Restaurant" @if($form_data['businessType'] == "Cafes & Restaurant") selected @endif>Cafes & Restaurant</option>
                <option value="Carpentry workshop" @if($form_data['businessType'] == "Carpentry workshop") selected @endif>Carpentry workshop</option>
                <option value="Car dealer/ showroom" @if($form_data['businessType'] == "Car dealer/ showroom") selected @endif>Car dealer/ showroom</option>
                <option value="Cement plant/ precast/ block factories" @if($form_data['businessType'] == "Cement plant/ precast/ block factories") selected @endif>Cement plant/ precast/ block factories</option>
                <option value="Charcoal / briquette manufacturing" @if($form_data['businessType'] == "Charcoal / briquette manufacturing") selected @endif>Charcoal / briquette manufacturing</option>
                <option value="Chemical Plant" @if($form_data['businessType'] == "Chemical Plant") selected @endif>Chemical Plant</option>
                <option value="Cinema Hall auditoriums" @if($form_data['businessType'] == "Cinema Hall auditoriums") selected @endif>Cinema Hall auditoriums</option>
                <option value="Clothing manufacturing" @if($form_data['businessType'] == "Clothing manufacturing") selected @endif>Clothing manufacturing</option>
                <option value="Colleges/ Universities/ schools & educational institute" @if($form_data['businessType'] == "Colleges/ Universities/ schools & educational institute") selected @endif>Colleges/ Universities/ schools & educational institute</option>
                <option value="Computer hardware trading/ sales" @if($form_data['businessType'] == "Computer hardware trading/ sales") selected @endif>Computer hardware trading/ sales</option>
                <option value="Computer software production/ data centers" @if($form_data['businessType'] == "Computer software production/ data centers") selected @endif>Computer software production/ data centers</option>
                <option value="Confectionery/ dairy products processing" @if($form_data['businessType'] == "Confectionery/ dairy products processing") selected @endif>Confectionery/ dairy products processing</option>
                <option value="Construction company" @if($form_data['businessType'] == "Construction company") selected @endif>Construction company</option>
                <option value="Cotton ginning wool/ textile manufacturing" @if($form_data['businessType'] == "Cotton ginning wool/ textile manufacturing") selected @endif>Cotton ginning wool/ textile manufacturing</option>
                <option value="Dams/ reservoirs" @if($form_data['businessType'] == "Dams/ reservoirs") selected @endif>Dams/ reservoirs</option>
                <option value="Department stores/ shopping malls" @if($form_data['businessType'] == "Department stores/ shopping malls") selected @endif>Department stores/ shopping malls</option>
                <option value="Desalination/ water utilities/treatment plant" @if($form_data['businessType'] == "Desalination/ water utilities/treatment plant") selected @endif>Desalination/ water utilities/treatment plant</option>
                <option value="Doctors & other health professional" @if($form_data['businessType'] == "Doctors & other health professional") selected @endif>Doctors & other health professional</option>
                <option value="Electrical appliance/ electronic component manufacturing" @if($form_data['businessType'] == "Electrical appliance/ electronic component manufacturing") selected @endif>Electrical appliance/ electronic component manufacturing</option>
                <option value="Electronic trading/ sales" @if($form_data['businessType'] == "Electronic trading/ sales") selected @endif>Electronic trading/ sales</option>
                <option value="Entertainment venues" @if($form_data['businessType'] == "Entertainment venues") selected @endif>Entertainment venues</option>
                <option value="Explosives/ fireworks manufacturing/warehouses" @if($form_data['businessType'] == "Explosives/ fireworks manufacturing/warehouses") selected @endif>Explosives/ fireworks manufacturing/warehouses</option>
                <option value="Flax/ Breaking/ scratching"  @if($form_data['businessType'] == "Flax/ Breaking/ scratching") selected @endif>Flax/ Breaking/ scratching</option>
                <option value="Flour mills" @if($form_data['businessType'] == "Flour mills") selected @endif>Flour mills</option>
                <option value="Foam, plastic, rubber production/ processing/ storage" @if($form_data['businessType'] == "Foam, plastic, rubber production/ processing/ storage") selected @endif>Foam, plastic, rubber production/ processing/ storage</option>
                <option value="Food & beverage manufacturers" @if($form_data['businessType'] == "Food & beverage manufacturers") selected @endif>Food & beverage manufacturers</option>
                <option value="Freight forwarders" @if($form_data['businessType'] == "Freight forwarders") selected @endif>Freight forwarders</option>
                <option value="Fund managers, stocks and commodity broker" @if($form_data['businessType'] == "Fund managers, stocks and commodity broker") selected @endif>Fund managers, stocks and commodity broker</option>
                <option value="Furniture shops/ manufacturing units" @if($form_data['businessType'] == "Furniture shops/ manufacturing units") selected @endif>Furniture shops/ manufacturing units</option>
                <option value="Garbage collection/ waste management" @if($form_data['businessType'] == "Garbage collection/ waste management") selected @endif>Garbage collection/ waste management</option>
                <option value="Grain storage (silos) processing" @if($form_data['businessType'] == "Grain storage (silos) processing") selected @endif>Grain storage (silos) processing</option>
                <option value="Hospital/ clinics & nursing homes" @if($form_data['businessType'] == "Hospital/ clinics & nursing homes") selected @endif>Hospital/ clinics & nursing homes</option>
                <option value="Hotels/ boarding houses/ motels/ service apartments" @if($form_data['businessType'] == "Hotels/ boarding houses/ motels/ service apartments") selected @endif>Hotels/ boarding houses/ motels/ service apartments</option>
                <option value="Hotel multiple cover" @if($form_data['businessType'] == "Hotel multiple cover") selected @endif>Hotel multiple cover</option>
                <option value="Infrastructure" @if($form_data['businessType'] == "Infrastructure") selected @endif>Infrastructure</option>
                <option value="Insurance companies & brokers/ consultants" @if($form_data['businessType'] == "Insurance companies & brokers/ consultants") selected @endif>Insurance companies & brokers/ consultants</option>
                <option value="Jewelry manufacturing/ trade" @if($form_data['businessType'] == "Jewelry manufacturing/ trade") selected @endif>Jewelry manufacturing/ trade</option>
                <option value="Laboratories" @if($form_data['businessType'] == "Laboratories") selected @endif>Laboratories</option>
                <option value="Livestock" @if($form_data['businessType'] == "Livestock") selected @endif>Livestock</option>
                <option value="Machinery/ tool/ metal product manufacturers" @if($form_data['businessType'] == "Machinery/ tool/ metal product manufacturers") selected @endif>Machinery/ tool/ metal product manufacturers</option>
                <option value="Mega malls & commercial centers" @if($form_data['businessType'] == "Mega malls & commercial centers") selected @endif>Mega malls & commercial centers</option>
                <option value="Media companies" @if($form_data['businessType'] == "Media companies") selected @endif>Media companies</option>
                <option value="Metal industry" @if($form_data['businessType'] == "Metal industry") selected @endif>Metal industry</option>
                <option value="Mining/ quarrying/ excavating" @if($form_data['businessType'] == "Mining/ quarrying/ excavating") selected @endif>Mining/ quarrying/ excavating</option>
                <option value="Mobile shops" @if($form_data['businessType'] == "Mobile shops") selected @endif>Mobile shops</option>
                <option value="Movie theaters" @if($form_data['businessType'] == "Movie theaters") selected @endif>Movie theaters</option>
                <option value="Museum/ heritage sites" @if($form_data['businessType'] == "Museum/ heritage sites") selected @endif>Museum/ heritage sites</option>
                <option value="Newspaper, magazine & book printing/ publishing" @if($form_data['businessType'] == "Newspaper, magazine & book printing/ publishing") selected @endif>Newspaper, magazine & book printing/ publishing</option>
                <option value="Non profit, foundations & philanthropist" @if($form_data['businessType'] == "Non profit, foundations & philanthropist") selected @endif>Non profit, foundations & philanthropist</option>
                <option value="Offshore activities" @if($form_data['businessType'] == "Offshore activities") selected @endif>Offshore activities</option>
                <option value="Office buildings/ complexes" @if($form_data['businessType'] == "Office buildings/ complexes") selected @endif>Office buildings/ complexes</option>
                <option value="Oil & gas distribution & retail" @if($form_data['businessType'] == "Oil & gas distribution & retail") selected @endif>Oil & gas distribution & retail</option>
                <option value="Oil & gas storage" @if($form_data['businessType'] == "Oil & gas storage") selected @endif>Oil & gas storage</option>
                <option value="Oil & gas facilities" @if($form_data['businessType'] == "Oil & gas facilities") selected @endif>Oil & gas facilities</option>
                <option value="Paints factories & warehouses" @if($form_data['businessType'] == "Paints factories & warehouses") selected @endif>Paints factories & warehouses</option>
                <option value="Paper, pulp & packaging materials manufacturing" @if($form_data['businessType'] == "Paper, pulp & packaging materials manufacturing") selected @endif>Paper, pulp & packaging materials manufacturing</option>
                <option value="Petrol diesel & gas filling stations" @if($form_data['businessType'] == "Petrol diesel & gas filling stations") selected @endif>Petrol diesel & gas filling stations</option>
                <option value="Pharmaceutical manufacturing" @if($form_data['businessType'] == "Pharmaceutical manufacturing") selected @endif>Pharmaceutical manufacturing</option>
                <option value="Plastic production/ processing/ storage" @if($form_data['businessType'] == "Plastic production/ processing/ storage") selected @endif>Plastic production/ processing/ storage</option>
                <option value="Port & terminal operators/ owners" @if($form_data['businessType'] == "Port & terminal operators/ owners") selected @endif>Port & terminal operators/ owners</option>
                <option value="Portacabins / caravans" @if($form_data['businessType'] == "Portacabins / caravans") selected @endif>Portacabins / caravans</option>
                <option value="Power and desalination plants" @if($form_data['businessType'] == "Power and desalination plants") selected @endif>Power and desalination plants</option>
                <option value="Printing press" @if($form_data['businessType'] == "Printing press") selected @endif>Printing press</option>
                <option value="Public administration building" @if($form_data['businessType'] == "Public administration building") selected @endif>Public administration building</option>
                <option value="Radio/ TV stations/ media companies/ cable & satellite TV distribution" @if($form_data['businessType'] == "Radio/ TV stations/ media companies/ cable & satellite TV distribution") selected @endif>Radio/ TV stations/ media companies/ cable & satellite TV distribution</option>
                <option value="Rag factories" @if($form_data['businessType'] == "Rag factories") selected @endif>Rag factories</option>
                <option value="Rail roads & related infrastructure" @if($form_data['businessType'] == "Rail roads & related infrastructure") selected @endif>Rail roads & related infrastructure</option>
                <option value="Real estate/ property developers" @if($form_data['businessType'] == "Real estate/ property developers") selected @endif>Real estate/ property developers</option>
                <option value="Residential & office building" @if($form_data['businessType'] == "Residential & office building") selected @endif>Residential & office building</option>
                <option value="Recreational clubs/Theme & water parks" @if($form_data['businessType'] == "Recreational clubs/Theme & water parks") selected @endif>Recreational clubs/Theme & water parks</option>
                <option value="Refrigerated distribution" @if($form_data['businessType'] == "Refrigerated distribution") selected @endif>Refrigerated distribution</option>
                <option value="Religious centers" @if($form_data['businessType'] == "Religious centers") selected @endif>Religious centers</option>
                <option value="Residential property/ tower/ societies" @if($form_data['businessType'] == "Residential property/ tower/ societies") selected @endif>Residential property/ tower/ societies</option>
                <option value="Restaurant/ catering services" @if($form_data['businessType'] == "Restaurant/ catering services") selected @endif>Restaurant/ catering services</option>
                <option value="Salons/ grooming services" @if($form_data['businessType'] == "Salons/ grooming services") selected @endif>Salons/ grooming services</option>
                <option value="Scrap traders" @if($form_data['businessType'] == "Scrap traders") selected @endif>Scrap traders</option>
                <option value="Stadium/ sports facilities/ race track" @if($form_data['businessType'] == "Stadium/ sports facilities/ race track") selected @endif>Stadium/ sports facilities/ race track</option>
                <option value="Subaqueous work" @if($form_data['businessType'] == "Subaqueous work") selected @endif>Subaqueous work</option>
                <option value="Sugar factories/ refineries" @if($form_data['businessType'] == "Sugar factories/ refineries") selected @endif>Sugar factories/ refineries</option>
                <option value="Ship operators/ owners" @if($form_data['businessType'] == "Ship operators/ owners") selected @endif>Ship operators/ owners</option>
                <option value="Shipbuilding & repairing" @if($form_data['businessType'] == "Shipbuilding & repairing") selected @endif>Shipbuilding & repairing</option>
                <option value="Steel/ metal plants" @if($form_data['businessType'] == "Steel/ metal plants") selected @endif>Steel/ metal plants</option>
                <option value="Souk and similar markets" @if($form_data['businessType'] == "Souk and similar markets") selected @endif>Souk and similar markets</option>
                <option value="Supermarkets / hypermarket/ other retail shops" @if($form_data['businessType'] == "Supermarkets / hypermarket/ other retail shops") selected @endif>Supermarkets / hypermarket/ other retail shops</option>
                <option value="Tanning/ leather processing" @if($form_data['businessType'] == "Tanning/ leather processing") selected @endif>Tanning/ leather processing</option>
                <option value="Telecommunication companies" @if($form_data['businessType'] == "Telecommunication companies") selected @endif>Telecommunication companies</option>
                <option value="Textile mills/ traders/ sales" @if($form_data['businessType'] == "Textile mills/ traders/ sales") selected @endif>Textile mills/ traders/ sales</option>
                <option value="Tile/ ceramic manufacturers" @if($form_data['businessType'] == "Tile/ ceramic manufacturers") selected @endif>Tile/ ceramic manufacturers</option>
                <option value="Tobacco" @if($form_data['businessType'] == "Tobacco") selected @endif>Tobacco</option>
                <option value="Trucking/ land transport services" @if($form_data['businessType'] == "Trucking/ land transport services") selected @endif>Trucking/ land transport services</option>
                <option value="Undermining operations" @if($form_data['businessType'] == "Undermining operations") selected @endif>Undermining operations</option>
                <option value="Upholstery services" @if($form_data['businessType'] == "Upholstery services") selected @endif>Upholstery services</option>
                <option value="Vegetable oil refineries/ factories" @if($form_data['businessType'] == "Vegetable oil refineries/ factories") selected @endif>Vegetable oil refineries/ factories</option>
                <option value="Warehouse/ cold storage" @if($form_data['businessType'] == "Warehouse/ cold storage") selected @endif>Warehouse/ cold storage</option>
                <option value="Wool factories" @if($form_data['businessType'] == "Wool factories") selected @endif>Wool factories</option>
                <option value="Wood processing/ carpets/ furniture manufacture" @if($form_data['businessType'] == "Wood processing/ carpets/ furniture manufacture") selected @endif>Wood processing/ carpets/ furniture manufacture</option>
                <option value="General Trading / Trading (others)" @if($form_data['businessType'] == "General Trading / Trading (others)") selected @endif>General Trading / Trading (others)</option>
                <option value="General Manufacturing" @if($form_data['businessType'] == "General Manufacturing") selected @endif>General Manufacturing</option>
                <option value="IT" @if($form_data['businessType'] == "IT") selected @endif>IT</option>
            </select>
        </div>
    </div>
</div>
{{-- Business Activity --}}

<div class="card_separation">
<div class="row">
    <div class="col-md-4">
            <div class="card_sub_head">
                    <div class="clearfix">
                        <h3 class="card_sub_heading pull-left">Risk Protection Measures</h3>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label bold">Safety Signs  <span>*</span></label>
                        <div class="custom_select">
                                <select class="form_input" id="safety_signs" name="safety_signs" onchange="validation(this.id)">
                                    <option value=""  selected>Select</option>
                                        <option value="yes" @if(isset($form_data['safetySigns']) && @$form_data['safetySigns'] == true) selected @endif>Yes</option>
                                        <option value="no" @if(isset($form_data['safetySigns']) && @$form_data['safetySigns'] ==false) selected @endif>No</option>
                                </select>
                            </div>
                    </div>
                </div>
                {{-- Risk protection measures --}}   
    </div>
</div>
{{-- Safety Signs --}}

    <div class="card_separation">
            <div class="row">
                <div class="col-md-4">
                        <div class="card_sub_head">
                                <div class="clearfix">
                                    <h3 class="card_sub_heading pull-left">Available fire fighting facilities <span style="color:red">*</span></h3>
                                </div>
                        </div>
                    </div>
                </div>
    <div class="row">
            <div class="col-md-2">
                <div class="form_group">
                    <div class="flex_sec">
                        <div class="custom_checkbox">
                            <input type="checkbox"  name="fire_facilities[]" value="Fire Extinguishers" id="automaticClause" class="inp-cbx" style="display: none" 
                            @if (isset($form_data['fireFight']['fireFacilities']) &&(in_array('Fire Extinguishers',@$form_data['fireFight']['fireFacilities']))) checked @endif
                            >
                            <label for="automaticClause" class="cbx">
                            <span>
                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                            </span>
                            </label>
                        </div>
                        <label class="form_label bold">Fire Extinguishers</label>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form_group">
                    <div class="flex_sec">
                        <div class="custom_checkbox">
                            <input type="checkbox"  name="fire_facilities[]" value="Sprinklers" id="flightCover" class="inp-cbx" style="display: none"     
                            @if(isset($form_data['fireFight']['fireFacilities']) && (in_array('Sprinklers',@$form_data['fireFight']['fireFacilities']))) checked @endif>
                            <label for="flightCover" class="cbx">
                            <span>
                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                            </span>
                            </label>
                        </div>
                        <label class="form_label bold">Sprinklers </label>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                    <div class="form_group">
                        <div class="flex_sec">
                            <div class="custom_checkbox">
                                <input type="checkbox"  name="fire_facilities[]" value="Hose Reel" id="flightCover1" class="inp-cbx" style="display: none" 
                                @if(isset($form_data['fireFight']['fireFacilities']) &&(in_array('Hose Reel',@$form_data['fireFight']['fireFacilities'])) ) checked @endif>
                                <label for="flightCover1" class="cbx">
                                <span>
                                    <svg width="10px" height="8px" viewBox="0 0 12 10">
                                      <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span> 
                                </label>
                            </div>
                            <label class="form_label bold">Hose Reel </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox"  name="fire_facilities[]" value="Smoke Detectors" id="flightCover2" class="inp-cbx" style="display: none"
                                    @if(isset($form_data['fireFight']['fireFacilities']) &&(in_array('Smoke Detectors',@$form_data['fireFight']['fireFacilities']))) checked @endif >
                                    <label for="flightCover2" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Smoke Detectors </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                            <div class="form_group">
                                <div class="flex_sec">
                                    <div class="custom_checkbox">
                                        <input type="checkbox"  name="fire_facilities[]" value="Fire Alarm" id="flightCover3" class="inp-cbx" style="display: none" 
                                        @if(isset($form_data['fireFight']['fireFacilities']) &&(in_array('Fire Alarm',@$form_data['fireFight']['fireFacilities']))) checked @endif >
                                        <label for="flightCover3" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                              <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
                                        </label>
                                    </div>
                                    <label class="form_label bold">Fire Alarm </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                                <div class="form_group">
                                    <div class="flex_sec">
                                        <div class="custom_checkbox">
                                            <input type="checkbox"  name="fire_facilities[]" value="others" id="flightCover4" class="inp-cbx" style="display: none" 
                                            @if(isset($form_data['fireFight']['fireFacilities']) &&(in_array('others',@$form_data['fireFight']['fireFacilities']))) checked @endif >
                                            <label for="flightCover4" class="cbx">
                                            <span>
                                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                                  <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg>
                                            </span>
                                            </label>
                                        </div>
                                        <label class="form_label bold" id="fire">Others </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8" id="fire_fighting"      @if(isset($form_data['fireFight']['fireFacilities']) && (in_array('others',@$form_data['fireFight']['fireFacilities'])))  style="display:block" @else style="display:none" @endif>
                                    <div class="row"  >
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label bold">Others <span>*</span></label>
                                            <input class="form_input" name="fire_other" id="fire_other" value="{{@$form_data['fireFight']['other']}}">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                       
        </div>
    </div>
 {{-- Fighting facilities --}}     
 
 <div class="row">
    <div class="col-md-4">
        <div class="form_group">
            <label class="form_label bold">Direct connection to Civil Defence <span>*</span></label>
            <div class="custom_select">
                <select class="form_input" id="civil_defence" name="civil_defence" onchange="validation(this.id)">
                    <option value=""  selected>Select</option>
                        <option value="yes" @if(isset($form_data['civilDefence']) && @$form_data['civilDefence'] ==true) selected @endif >Yes</option>
                        <option value="no" @if(isset($form_data['civilDefence']) && @$form_data['civilDefence'] ==false) selected @endif >No</option>
                </select>
            </div>
        </div>
    </div>   
{{-- Direct connection to Civil Defence --}}

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <label class="form_label bold">Frequency of removing waste material <span>*</span></label>
                </div>
                <div class="col-md-12">
                    <div class="form_group">
                        <table class="number_align">
                            <tr>
                                <td>
                                    <div class="">
                                        <input class="form_input number text_upload" placeholder="" name="time_day" id="time_day" value="{{@$form_data['frequency']['time_day']}}"><span class="text_field_p">  time/s a day</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        <input class="form_input number text_upload" placeholder="" name="once_day" id="once_day"  value="{{@$form_data['frequency']['once_day']}}"><span class="text_field_p"> time/s a week</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                       
                       
                    </div>
                </div>
            </div>
        </div>
</div>
{{-- Frequency of removing waste material --}}

<div class="row">
        <div class="col-md-4">
            <div class="form_group">
                <label class="form_label bold">Security Guards available <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="security_guard" name="security_guard" onchange="validation(this.id)">
                        <option value=""  selected>Select</option>
                            <option value="No Security"  @if(@$form_data['securityGuard']['securityGuard'] =='No Security') selected @endif  >No Security</option>
                            <option value="24 Hours available"  @if(@$form_data['securityGuard']['securityGuard'] =='24 Hours available') selected @endif >24 Hours available</option>
                            <option value="Available only during office hours"  @if(@$form_data['securityGuard']['securityGuard'] =='Available only during office hours') selected @endif >Available only during office hours</option>
                            <option value="Others"  @if(@$form_data['securityGuard']['securityGuard']=='Others') selected @endif >Others</option>
                    </select>
                </div>
            </div>
        </div> 
        <div class="col-md-8" id="security_other" @if(@$form_data['securityGuard']['securityGuard']=='Others') style="display:block" @else style="display:none" @endif>
                <div class="row"  >
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label bold">Others <span>*</span></label>
                        <input class="form_input" name="security_other" onchange="validation(this.id)" value="{{@$form_data['securityGuard']['securityOther']}}">
                        </div>
                    </div>
                </div>
        </div> 
</div>
{{-- Security Guards available --}}

<div class="row">
        <div class="col-md-4">
            <div class="form_group">
                <label class="form_label bold">Burglary Alarm <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="burglary_alarm" name="burglary_alarm"onchange="validation(this.id)">
                        <option value=""  selected>Select</option>
                            <option value="Installed and working"@if(@$form_data['burglaryAlarm']=='Installed and working') selected @endif>Installed and working</option>
                            <option value="Installed but not working"@if(@$form_data['burglaryAlarm']=='Installed but not working') selected @endif>Installed but not working</option>
                            <option value="Not installed"@if(@$form_data['burglaryAlarm']=='Not installed') selected @endif>Not installed</option>
                    </select>
                </div>
            </div>
        </div> 
{{-- Burglary Alarm --}}

<div class="col-md-4">
    <div class="form_group">
        <label class="form_label bold">CCTV <span>*</span></label>
        <div class="custom_select">
            <select class="form_input" id="cctv" name="cctv" onchange="validation(this.id)">
                <option value=""  selected>Select</option>
                    <option value="Installed and working" @if(@$form_data['cctv']=='Installed and working') selected @endif>Installed and working</option>
                    <option value="Installed but not working" @if(@$form_data['cctv']=='Installed but not working') selected @endif>Installed but not working</option>
                    <option value="Not installed" @if(@$form_data['cctv']=='Not installed') selected @endif>Not installed</option>
            </select>
        </div>
    </div>
</div> 
{{-- CCTV --}}

        <div class="col-md-4">
            <div class="form_group">
                <label class="form_label bold">Electicity usage <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="electicity_usage" name="electicity_usage" onchange="validation(this.id)">
                        <option value=""  selected>Select</option>
                            <option value="24 hours" @if(@$form_data['electicity_usage']=='24 hours') selected @endif>24 hours</option>
                            <option value="Only office hours" @if(@$form_data['electicity_usage']=='Only office hours') selected @endif>Only office hours</option>
                    </select>
                </div>
            </div>
        </div> 
    </div>
{{-- Electicity usage --}}

<div class="card_separation">
        <div class="row">
            <div class="col-md-4">
                    <div class="card_sub_head">
                            <div class="clearfix">
                                <h3 class="card_sub_heading pull-left">Neighborhood</h3>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
               
                    <div class="col-md-3">
                            <div class="form_group">
                                    <label class="form_label bold">West <span>*</span></label>
                                    <div class="custom_select">
                                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="west" name="west" onchange="validation(this.id)">
                                                    <option value="">Select business of the insured </option>
                <option value="Accounts/ Audit firms/ Professional Services/ Law Firms" @if($form_data['neighborhood']['west'] == "Accounts/ Audit firms/ Professional Services/ Law Firms") selected @endif>Accounts/ Audit firms/ Professional Services/ Law Firms</option>
                <option value="Advertising / Public Relations" @if($form_data['neighborhood']['west'] == "Advertising / Public Relations") selected @endif>Advertising / Public Relations</option>
                <option value="Agricultural services & Products" @if($form_data['neighborhood']['west'] == "Agricultural services & Products") selected @endif>Agricultural services & Products</option>
                <option value="Aircraft & ship crew/ terminal operators" @if($form_data['neighborhood']['west'] == "Aircraft & ship crew/ terminal operators") selected @endif>Aircraft & ship crew/ terminal operators</option>
                <option value="Airports & related infrastructure" @if($form_data['neighborhood']['west'] == "Airports & related infrastructure") selected @endif>Airports & related infrastructure</option>
                <option value="Alternative energy" @if($form_data['neighborhood']['west'] == "Alternative energy") selected @endif>Alternative energy</option>
                <option value="Architectural services/ Engineers" @if($form_data['neighborhood']['west'] == "Architectural services/ Engineers") selected @endif>Architectural services/ Engineers</option>
                <option value="Armed Forces" @if($form_data['neighborhood']['west'] == "Armed Forces") selected @endif>Armed Forces</option>
                <option value="Art galleries/ fine arts collection" @if($form_data['neighborhood']['west'] == "Art galleries/ fine arts collection") selected @endif>Art galleries/ fine arts collection</option>
                <option value="Auto manufacturers" @if($form_data['neighborhood']['west'] == "Auto manufacturers") selected @endif>Auto manufacturers</option>
                <option value="Automobile workshop/ showroom/ garage/ service station" @if($form_data['neighborhood']['west'] == "Automobile workshop/ showroom/ garage/ service station") selected @endif>Automobile workshop/ showroom/ garage/ service station</option>
                <option value="Automotive spart parts dealer/ traders" @if($form_data['neighborhood']['west'] == "Automotive spart parts dealer/ traders") selected @endif>Automotive spart parts dealer/ traders</option>
                <option value="Bank/ lenders/ financial institution/ currency exchange" @if($form_data['neighborhood']['west'] == "Bank/ lenders/ financial institution/ currency exchange") selected @endif>Bank/ lenders/ financial institution/ currency exchange</option>
                <option value="Beverage manufacturing & bottling" @if($form_data['neighborhood']['west'] == "Beverage manufacturing & bottling") selected @endif>Beverage manufacturing & bottling</option>
                <option value="Bridges & tunnels" @if($form_data['neighborhood']['west'] == "Bridges & tunnels") selected @endif>Bridges & tunnels</option>
                <option value="Builders/ general contractors" @if($form_data['neighborhood']['west'] == "Builders/ general contractors") selected @endif>Builders/ general contractors</option>
                <option value="Building materials manufacturers/ traders" @if($form_data['neighborhood']['west'] == "Building materials manufacturers/ traders") selected @endif>Building materials manufacturers/ traders</option>
                <option value="Business process outsourcing / management services/ trade associations" @if($form_data['neighborhood']['west'] == "Business process outsourcing / management services/ trade associations") selected @endif>Business process outsourcing / management services/ trade associations</option>
                <option value="Cafes & Restaurant" @if($form_data['neighborhood']['west'] == "Cafes & Restaurant") selected @endif>Cafes & Restaurant</option>
                <option value="Carpentry workshop" @if($form_data['neighborhood']['west'] == "Carpentry workshop") selected @endif>Carpentry workshop</option>
                <option value="Car dealer/ showroom" @if($form_data['neighborhood']['west'] == "Car dealer/ showroom") selected @endif>Car dealer/ showroom</option>
                <option value="Cement plant/ precast/ block factories" @if($form_data['neighborhood']['west'] == "Cement plant/ precast/ block factories") selected @endif>Cement plant/ precast/ block factories</option>
                <option value="Charcoal / briquette manufacturing" @if($form_data['neighborhood']['west'] == "Charcoal / briquette manufacturing") selected @endif>Charcoal / briquette manufacturing</option>
                <option value="Chemical Plant" @if($form_data['neighborhood']['west'] == "Chemical Plant") selected @endif>Chemical Plant</option>
                <option value="Cinema Hall auditoriums" @if($form_data['neighborhood']['west'] == "Cinema Hall auditoriums") selected @endif>Cinema Hall auditoriums</option>
                <option value="Clothing manufacturing" @if($form_data['neighborhood']['west'] == "Clothing manufacturing") selected @endif>Clothing manufacturing</option>
                <option value="Colleges/ Universities/ schools & educational institute" @if($form_data['neighborhood']['west'] == "Colleges/ Universities/ schools & educational institute") selected @endif>Colleges/ Universities/ schools & educational institute</option>
                <option value="Computer hardware trading/ sales" @if($form_data['neighborhood']['west'] == "Computer hardware trading/ sales") selected @endif>Computer hardware trading/ sales</option>
                <option value="Computer software production/ data centers" @if($form_data['neighborhood']['west'] == "Computer software production/ data centers") selected @endif>Computer software production/ data centers</option>
                <option value="Confectionery/ dairy products processing" @if($form_data['neighborhood']['west'] == "Confectionery/ dairy products processing") selected @endif>Confectionery/ dairy products processing</option>
                <option value="Construction company" @if($form_data['neighborhood']['west'] == "Construction company") selected @endif>Construction company</option>
                <option value="Cotton ginning wool/ textile manufacturing" @if($form_data['neighborhood']['west'] == "Cotton ginning wool/ textile manufacturing") selected @endif>Cotton ginning wool/ textile manufacturing</option>
                <option value="Dams/ reservoirs" @if($form_data['neighborhood']['west'] == "Dams/ reservoirs") selected @endif>Dams/ reservoirs</option>
                <option value="Department stores/ shopping malls" @if($form_data['neighborhood']['west'] == "Department stores/ shopping malls") selected @endif>Department stores/ shopping malls</option>
                <option value="Desalination/ water utilities/treatment plant" @if($form_data['neighborhood']['west'] == "Desalination/ water utilities/treatment plant") selected @endif>Desalination/ water utilities/treatment plant</option>
                <option value="Doctors & other health professional" @if($form_data['neighborhood']['west'] == "Doctors & other health professional") selected @endif>Doctors & other health professional</option>
                <option value="Electrical appliance/ electronic component manufacturing" @if($form_data['neighborhood']['west'] == "Electrical appliance/ electronic component manufacturing") selected @endif>Electrical appliance/ electronic component manufacturing</option>
                <option value="Electronic trading/ sales" @if($form_data['neighborhood']['west'] == "Electronic trading/ sales") selected @endif>Electronic trading/ sales</option>
                <option value="Entertainment venues" @if($form_data['neighborhood']['west'] == "Entertainment venues") selected @endif>Entertainment venues</option>
                <option value="Explosives/ fireworks manufacturing/warehouses" @if($form_data['neighborhood']['west'] == "Explosives/ fireworks manufacturing/warehouses") selected @endif>Explosives/ fireworks manufacturing/warehouses</option>
                <option value="Flax/ Breaking/ scratching"  @if($form_data['neighborhood']['west'] == "Flax/ Breaking/ scratching") selected @endif>Flax/ Breaking/ scratching</option>
                <option value="Flour mills" @if($form_data['neighborhood']['west'] == "Flour mills") selected @endif>Flour mills</option>
                <option value="Foam, plastic, rubber production/ processing/ storage" @if($form_data['neighborhood']['west'] == "Foam, plastic, rubber production/ processing/ storage") selected @endif>Foam, plastic, rubber production/ processing/ storage</option>
                <option value="Food & beverage manufacturers" @if($form_data['neighborhood']['west'] == "Food & beverage manufacturers") selected @endif>Food & beverage manufacturers</option>
                <option value="Freight forwarders" @if($form_data['neighborhood']['west'] == "Freight forwarders") selected @endif>Freight forwarders</option>
                <option value="Fund managers, stocks and commodity broker" @if($form_data['neighborhood']['west'] == "Fund managers, stocks and commodity broker") selected @endif>Fund managers, stocks and commodity broker</option>
                <option value="Furniture shops/ manufacturing units" @if($form_data['neighborhood']['west'] == "Furniture shops/ manufacturing units") selected @endif>Furniture shops/ manufacturing units</option>
                <option value="Garbage collection/ waste management" @if($form_data['neighborhood']['west'] == "Garbage collection/ waste management") selected @endif>Garbage collection/ waste management</option>
                <option value="Grain storage (silos) processing" @if($form_data['neighborhood']['west'] == "Grain storage (silos) processing") selected @endif>Grain storage (silos) processing</option>
                <option value="Hospital/ clinics & nursing homes" @if($form_data['neighborhood']['west'] == "Hospital/ clinics & nursing homes") selected @endif>Hospital/ clinics & nursing homes</option>
                <option value="Hotels/ boarding houses/ motels/ service apartments" @if($form_data['neighborhood']['west'] == "Hotels/ boarding houses/ motels/ service apartments") selected @endif>Hotels/ boarding houses/ motels/ service apartments</option>
                <option value="Hotel multiple cover" @if($form_data['neighborhood']['west'] == "Hotel multiple cover") selected @endif>Hotel multiple cover</option>
                <option value="Infrastructure" @if($form_data['neighborhood']['west'] == "Infrastructure") selected @endif>Infrastructure</option>
                <option value="Insurance companies & brokers/ consultants" @if($form_data['neighborhood']['west'] == "Insurance companies & brokers/ consultants") selected @endif>Insurance companies & brokers/ consultants</option>
                <option value="Jewelry manufacturing/ trade" @if($form_data['neighborhood']['west'] == "Jewelry manufacturing/ trade") selected @endif>Jewelry manufacturing/ trade</option>
                <option value="Laboratories" @if($form_data['neighborhood']['west'] == "Laboratories") selected @endif>Laboratories</option>
                <option value="Livestock" @if($form_data['neighborhood']['west'] == "Livestock") selected @endif>Livestock</option>
                <option value="Machinery/ tool/ metal product manufacturers" @if($form_data['neighborhood']['west'] == "Machinery/ tool/ metal product manufacturers") selected @endif>Machinery/ tool/ metal product manufacturers</option>
                <option value="Mega malls & commercial centers" @if($form_data['neighborhood']['west'] == "Mega malls & commercial centers") selected @endif>Mega malls & commercial centers</option>
                <option value="Media companies" @if($form_data['neighborhood']['west'] == "Media companies") selected @endif>Media companies</option>
                <option value="Metal industry" @if($form_data['neighborhood']['west'] == "Metal industry") selected @endif>Metal industry</option>
                <option value="Mining/ quarrying/ excavating" @if($form_data['neighborhood']['west'] == "Mining/ quarrying/ excavating") selected @endif>Mining/ quarrying/ excavating</option>
                <option value="Mobile shops" @if($form_data['neighborhood']['west'] == "Mobile shops") selected @endif>Mobile shops</option>
                <option value="Movie theaters" @if($form_data['neighborhood']['west'] == "Movie theaters") selected @endif>Movie theaters</option>
                <option value="Museum/ heritage sites" @if($form_data['neighborhood']['west'] == "Museum/ heritage sites") selected @endif>Museum/ heritage sites</option>
                <option value="Newspaper, magazine & book printing/ publishing" @if($form_data['neighborhood']['west'] == "Newspaper, magazine & book printing/ publishing") selected @endif>Newspaper, magazine & book printing/ publishing</option>
                <option value="Non profit, foundations & philanthropist" @if($form_data['neighborhood']['west'] == "Non profit, foundations & philanthropist") selected @endif>Non profit, foundations & philanthropist</option>
                <option value="Offshore activities" @if($form_data['neighborhood']['west'] == "Offshore activities") selected @endif>Offshore activities</option>
                <option value="Office buildings/ complexes" @if($form_data['neighborhood']['west'] == "Office buildings/ complexes") selected @endif>Office buildings/ complexes</option>
                <option value="Oil & gas distribution & retail" @if($form_data['neighborhood']['west'] == "Oil & gas distribution & retail") selected @endif>Oil & gas distribution & retail</option>
                <option value="Oil & gas storage" @if($form_data['neighborhood']['west'] == "Oil & gas storage") selected @endif>Oil & gas storage</option>
                <option value="Oil & gas facilities" @if($form_data['neighborhood']['west'] == "Oil & gas facilities") selected @endif>Oil & gas facilities</option>
                <option value="Paints factories & warehouses" @if($form_data['neighborhood']['west'] == "Paints factories & warehouses") selected @endif>Paints factories & warehouses</option>
                <option value="Paper, pulp & packaging materials manufacturing" @if($form_data['neighborhood']['west'] == "Paper, pulp & packaging materials manufacturing") selected @endif>Paper, pulp & packaging materials manufacturing</option>
                <option value="Petrol diesel & gas filling stations" @if($form_data['neighborhood']['west'] == "Petrol diesel & gas filling stations") selected @endif>Petrol diesel & gas filling stations</option>
                <option value="Pharmaceutical manufacturing" @if($form_data['neighborhood']['west'] == "Pharmaceutical manufacturing") selected @endif>Pharmaceutical manufacturing</option>
                <option value="Plastic production/ processing/ storage" @if($form_data['neighborhood']['west'] == "Plastic production/ processing/ storage") selected @endif>Plastic production/ processing/ storage</option>
                <option value="Port & terminal operators/ owners" @if($form_data['neighborhood']['west'] == "Port & terminal operators/ owners") selected @endif>Port & terminal operators/ owners</option>
                <option value="Portacabins / caravans" @if($form_data['neighborhood']['west'] == "Portacabins / caravans") selected @endif>Portacabins / caravans</option>
                <option value="Power and desalination plants" @if($form_data['neighborhood']['west'] == "Power and desalination plants") selected @endif>Power and desalination plants</option>
                <option value="Printing press" @if($form_data['neighborhood']['west'] == "Printing press") selected @endif>Printing press</option>
                <option value="Public administration building" @if($form_data['neighborhood']['west'] == "Public administration building") selected @endif>Public administration building</option>
                <option value="Radio/ TV stations/ media companies/ cable & satellite TV distribution" @if($form_data['neighborhood']['west'] == "Radio/ TV stations/ media companies/ cable & satellite TV distribution") selected @endif>Radio/ TV stations/ media companies/ cable & satellite TV distribution</option>
                <option value="Rag factories" @if($form_data['neighborhood']['west'] == "Rag factories") selected @endif>Rag factories</option>
                <option value="Rail roads & related infrastructure" @if($form_data['neighborhood']['west'] == "Rail roads & related infrastructure") selected @endif>Rail roads & related infrastructure</option>
                <option value="Real estate/ property developers" @if($form_data['neighborhood']['west'] == "Real estate/ property developers") selected @endif>Real estate/ property developers</option>
                <option value="Residential & office building" @if($form_data['neighborhood']['west'] == "Residential & office building") selected @endif>Residential & office building</option>
                <option value="Recreational clubs/Theme & water parks" @if($form_data['neighborhood']['west'] == "Recreational clubs/Theme & water parks") selected @endif>Recreational clubs/Theme & water parks</option>
                <option value="Refrigerated distribution" @if($form_data['neighborhood']['west'] == "Refrigerated distribution") selected @endif>Refrigerated distribution</option>
                <option value="Religious centers" @if($form_data['neighborhood']['west'] == "Religious centers") selected @endif>Religious centers</option>
                <option value="Residential property/ tower/ societies" @if($form_data['neighborhood']['west'] == "Residential property/ tower/ societies") selected @endif>Residential property/ tower/ societies</option>
                <option value="Restaurant/ catering services" @if($form_data['neighborhood']['west'] == "Restaurant/ catering services") selected @endif>Restaurant/ catering services</option>
                <option value="Salons/ grooming services" @if($form_data['neighborhood']['west'] == "Salons/ grooming services") selected @endif>Salons/ grooming services</option>
                <option value="Scrap traders" @if($form_data['neighborhood']['west'] == "Scrap traders") selected @endif>Scrap traders</option>
                <option value="Stadium/ sports facilities/ race track" @if($form_data['neighborhood']['west'] == "Stadium/ sports facilities/ race track") selected @endif>Stadium/ sports facilities/ race track</option>
                <option value="Subaqueous work" @if($form_data['neighborhood']['west'] == "Subaqueous work") selected @endif>Subaqueous work</option>
                <option value="Sugar factories/ refineries" @if($form_data['neighborhood']['west'] == "Sugar factories/ refineries") selected @endif>Sugar factories/ refineries</option>
                <option value="Ship operators/ owners" @if($form_data['neighborhood']['west'] == "Ship operators/ owners") selected @endif>Ship operators/ owners</option>
                <option value="Shipbuilding & repairing" @if($form_data['neighborhood']['west'] == "Shipbuilding & repairing") selected @endif>Shipbuilding & repairing</option>
                <option value="Steel/ metal plants" @if($form_data['neighborhood']['west'] == "Steel/ metal plants") selected @endif>Steel/ metal plants</option>
                <option value="Souk and similar markets" @if($form_data['neighborhood']['west'] == "Souk and similar markets") selected @endif>Souk and similar markets</option>
                <option value="Supermarkets / hypermarket/ other retail shops" @if($form_data['neighborhood']['west'] == "Supermarkets / hypermarket/ other retail shops") selected @endif>Supermarkets / hypermarket/ other retail shops</option>
                <option value="Tanning/ leather processing" @if($form_data['neighborhood']['west'] == "Tanning/ leather processing") selected @endif>Tanning/ leather processing</option>
                <option value="Telecommunication companies" @if($form_data['neighborhood']['west'] == "Telecommunication companies") selected @endif>Telecommunication companies</option>
                <option value="Textile mills/ traders/ sales" @if($form_data['neighborhood']['west'] == "Textile mills/ traders/ sales") selected @endif>Textile mills/ traders/ sales</option>
                <option value="Tile/ ceramic manufacturers" @if($form_data['neighborhood']['west'] == "Tile/ ceramic manufacturers") selected @endif>Tile/ ceramic manufacturers</option>
                <option value="Tobacco" @if($form_data['neighborhood']['west'] == "Tobacco") selected @endif>Tobacco</option>
                <option value="Trucking/ land transport services" @if($form_data['neighborhood']['west'] == "Trucking/ land transport services") selected @endif>Trucking/ land transport services</option>
                <option value="Undermining operations" @if($form_data['neighborhood']['west'] == "Undermining operations") selected @endif>Undermining operations</option>
                <option value="Upholstery services" @if($form_data['neighborhood']['west'] == "Upholstery services") selected @endif>Upholstery services</option>
                <option value="Vegetable oil refineries/ factories" @if($form_data['neighborhood']['west'] == "Vegetable oil refineries/ factories") selected @endif>Vegetable oil refineries/ factories</option>
                <option value="Warehouse/ cold storage" @if($form_data['neighborhood']['west'] == "Warehouse/ cold storage") selected @endif>Warehouse/ cold storage</option>
                <option value="Wool factories" @if($form_data['neighborhood']['west'] == "Wool factories") selected @endif>Wool factories</option>
                <option value="Wood processing/ carpets/ furniture manufacture" @if($form_data['neighborhood']['west'] == "Wood processing/ carpets/ furniture manufacture") selected @endif>Wood processing/ carpets/ furniture manufacture</option>
                <option value="General Trading / Trading (others)" @if($form_data['neighborhood']['west'] == "General Trading / Trading (others)") selected @endif>General Trading / Trading (others)</option>
                <option value="General Manufacturing" @if($form_data['neighborhood']['west'] == "General Manufacturing") selected @endif>General Manufacturing</option>
                <option value="IT" @if($form_data['neighborhood']['west'] == "IT") selected @endif>IT</option>
                                                </select>
                                        </div>
                                </div>
                            </div>
                <div class="col-md-3">
                    <div class="form_group">
                            <label class="form_label bold">East <span>*</span></label>
                            <div class="custom_select">
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="east" name="east" onchange="validation(this.id)">
                                        <option value="">Select business of the insured </option>
                                        <option value="Accounts/ Audit firms/ Professional Services/ Law Firms" @if($form_data['neighborhood']['east'] == "Accounts/ Audit firms/ Professional Services/ Law Firms") selected @endif>Accounts/ Audit firms/ Professional Services/ Law Firms</option>
                                        <option value="Advertising / Public Relations" @if($form_data['neighborhood']['east'] == "Advertising / Public Relations") selected @endif>Advertising / Public Relations</option>
                                        <option value="Agricultural services & Products" @if($form_data['neighborhood']['east'] == "Agricultural services & Products") selected @endif>Agricultural services & Products</option>
                                        <option value="Aircraft & ship crew/ terminal operators" @if($form_data['neighborhood']['east'] == "Aircraft & ship crew/ terminal operators") selected @endif>Aircraft & ship crew/ terminal operators</option>
                                        <option value="Airports & related infrastructure" @if($form_data['neighborhood']['east'] == "Airports & related infrastructure") selected @endif>Airports & related infrastructure</option>
                                        <option value="Alternative energy" @if($form_data['neighborhood']['east'] == "Alternative energy") selected @endif>Alternative energy</option>
                                        <option value="Architectural services/ Engineers" @if($form_data['neighborhood']['east'] == "Architectural services/ Engineers") selected @endif>Architectural services/ Engineers</option>
                                        <option value="Armed Forces" @if($form_data['neighborhood']['east'] == "Armed Forces") selected @endif>Armed Forces</option>
                                        <option value="Art galleries/ fine arts collection" @if($form_data['neighborhood']['east'] == "Art galleries/ fine arts collection") selected @endif>Art galleries/ fine arts collection</option>
                                        <option value="Auto manufacturers" @if($form_data['neighborhood']['east'] == "Auto manufacturers") selected @endif>Auto manufacturers</option>
                                        <option value="Automobile workshop/ showroom/ garage/ service station" @if($form_data['neighborhood']['east'] == "Automobile workshop/ showroom/ garage/ service station") selected @endif>Automobile workshop/ showroom/ garage/ service station</option>
                                        <option value="Automotive spart parts dealer/ traders" @if($form_data['neighborhood']['east'] == "Automotive spart parts dealer/ traders") selected @endif>Automotive spart parts dealer/ traders</option>
                                        <option value="Bank/ lenders/ financial institution/ currency exchange" @if($form_data['neighborhood']['east'] == "Bank/ lenders/ financial institution/ currency exchange") selected @endif>Bank/ lenders/ financial institution/ currency exchange</option>
                                        <option value="Beverage manufacturing & bottling" @if($form_data['neighborhood']['east'] == "Beverage manufacturing & bottling") selected @endif>Beverage manufacturing & bottling</option>
                                        <option value="Bridges & tunnels" @if($form_data['neighborhood']['east'] == "Bridges & tunnels") selected @endif>Bridges & tunnels</option>
                                        <option value="Builders/ general contractors" @if($form_data['neighborhood']['east'] == "Builders/ general contractors") selected @endif>Builders/ general contractors</option>
                                        <option value="Building materials manufacturers/ traders" @if($form_data['neighborhood']['east'] == "Building materials manufacturers/ traders") selected @endif>Building materials manufacturers/ traders</option>
                                        <option value="Business process outsourcing / management services/ trade associations" @if($form_data['neighborhood']['east'] == "Business process outsourcing / management services/ trade associations") selected @endif>Business process outsourcing / management services/ trade associations</option>
                                        <option value="Cafes & Restaurant" @if($form_data['neighborhood']['east'] == "Cafes & Restaurant") selected @endif>Cafes & Restaurant</option>
                                        <option value="Carpentry workshop" @if($form_data['neighborhood']['east'] == "Carpentry workshop") selected @endif>Carpentry workshop</option>
                                        <option value="Car dealer/ showroom" @if($form_data['neighborhood']['east'] == "Car dealer/ showroom") selected @endif>Car dealer/ showroom</option>
                                        <option value="Cement plant/ precast/ block factories" @if($form_data['neighborhood']['east'] == "Cement plant/ precast/ block factories") selected @endif>Cement plant/ precast/ block factories</option>
                                        <option value="Charcoal / briquette manufacturing" @if($form_data['neighborhood']['east'] == "Charcoal / briquette manufacturing") selected @endif>Charcoal / briquette manufacturing</option>
                                        <option value="Chemical Plant" @if($form_data['neighborhood']['east'] == "Chemical Plant") selected @endif>Chemical Plant</option>
                                        <option value="Cinema Hall auditoriums" @if($form_data['neighborhood']['east'] == "Cinema Hall auditoriums") selected @endif>Cinema Hall auditoriums</option>
                                        <option value="Clothing manufacturing" @if($form_data['neighborhood']['east'] == "Clothing manufacturing") selected @endif>Clothing manufacturing</option>
                                        <option value="Colleges/ Universities/ schools & educational institute" @if($form_data['neighborhood']['east'] == "Colleges/ Universities/ schools & educational institute") selected @endif>Colleges/ Universities/ schools & educational institute</option>
                                        <option value="Computer hardware trading/ sales" @if($form_data['neighborhood']['east'] == "Computer hardware trading/ sales") selected @endif>Computer hardware trading/ sales</option>
                                        <option value="Computer software production/ data centers" @if($form_data['neighborhood']['east'] == "Computer software production/ data centers") selected @endif>Computer software production/ data centers</option>
                                        <option value="Confectionery/ dairy products processing" @if($form_data['neighborhood']['east'] == "Confectionery/ dairy products processing") selected @endif>Confectionery/ dairy products processing</option>
                                        <option value="Construction company" @if($form_data['neighborhood']['east'] == "Construction company") selected @endif>Construction company</option>
                                        <option value="Cotton ginning wool/ textile manufacturing" @if($form_data['neighborhood']['east'] == "Cotton ginning wool/ textile manufacturing") selected @endif>Cotton ginning wool/ textile manufacturing</option>
                                        <option value="Dams/ reservoirs" @if($form_data['neighborhood']['east'] == "Dams/ reservoirs") selected @endif>Dams/ reservoirs</option>
                                        <option value="Department stores/ shopping malls" @if($form_data['neighborhood']['east'] == "Department stores/ shopping malls") selected @endif>Department stores/ shopping malls</option>
                                        <option value="Desalination/ water utilities/treatment plant" @if($form_data['neighborhood']['east'] == "Desalination/ water utilities/treatment plant") selected @endif>Desalination/ water utilities/treatment plant</option>
                                        <option value="Doctors & other health professional" @if($form_data['neighborhood']['east'] == "Doctors & other health professional") selected @endif>Doctors & other health professional</option>
                                        <option value="Electrical appliance/ electronic component manufacturing" @if($form_data['neighborhood']['east'] == "Electrical appliance/ electronic component manufacturing") selected @endif>Electrical appliance/ electronic component manufacturing</option>
                                        <option value="Electronic trading/ sales" @if($form_data['neighborhood']['east'] == "Electronic trading/ sales") selected @endif>Electronic trading/ sales</option>
                                        <option value="Entertainment venues" @if($form_data['neighborhood']['east'] == "Entertainment venues") selected @endif>Entertainment venues</option>
                                        <option value="Explosives/ fireworks manufacturing/warehouses" @if($form_data['neighborhood']['east'] == "Explosives/ fireworks manufacturing/warehouses") selected @endif>Explosives/ fireworks manufacturing/warehouses</option>
                                        <option value="Flax/ Breaking/ scratching"  @if($form_data['neighborhood']['east'] == "Flax/ Breaking/ scratching") selected @endif>Flax/ Breaking/ scratching</option>
                                        <option value="Flour mills" @if($form_data['neighborhood']['east'] == "Flour mills") selected @endif>Flour mills</option>
                                        <option value="Foam, plastic, rubber production/ processing/ storage" @if($form_data['neighborhood']['east'] == "Foam, plastic, rubber production/ processing/ storage") selected @endif>Foam, plastic, rubber production/ processing/ storage</option>
                                        <option value="Food & beverage manufacturers" @if($form_data['neighborhood']['east'] == "Food & beverage manufacturers") selected @endif>Food & beverage manufacturers</option>
                                        <option value="Freight forwarders" @if($form_data['neighborhood']['east'] == "Freight forwarders") selected @endif>Freight forwarders</option>
                                        <option value="Fund managers, stocks and commodity broker" @if($form_data['neighborhood']['east'] == "Fund managers, stocks and commodity broker") selected @endif>Fund managers, stocks and commodity broker</option>
                                        <option value="Furniture shops/ manufacturing units" @if($form_data['neighborhood']['east'] == "Furniture shops/ manufacturing units") selected @endif>Furniture shops/ manufacturing units</option>
                                        <option value="Garbage collection/ waste management" @if($form_data['neighborhood']['east'] == "Garbage collection/ waste management") selected @endif>Garbage collection/ waste management</option>
                                        <option value="Grain storage (silos) processing" @if($form_data['neighborhood']['east'] == "Grain storage (silos) processing") selected @endif>Grain storage (silos) processing</option>
                                        <option value="Hospital/ clinics & nursing homes" @if($form_data['neighborhood']['east'] == "Hospital/ clinics & nursing homes") selected @endif>Hospital/ clinics & nursing homes</option>
                                        <option value="Hotels/ boarding houses/ motels/ service apartments" @if($form_data['neighborhood']['east'] == "Hotels/ boarding houses/ motels/ service apartments") selected @endif>Hotels/ boarding houses/ motels/ service apartments</option>
                                        <option value="Hotel multiple cover" @if($form_data['neighborhood']['east'] == "Hotel multiple cover") selected @endif>Hotel multiple cover</option>
                                        <option value="Infrastructure" @if($form_data['neighborhood']['east'] == "Infrastructure") selected @endif>Infrastructure</option>
                                        <option value="Insurance companies & brokers/ consultants" @if($form_data['neighborhood']['east'] == "Insurance companies & brokers/ consultants") selected @endif>Insurance companies & brokers/ consultants</option>
                                        <option value="Jewelry manufacturing/ trade" @if($form_data['neighborhood']['east'] == "Jewelry manufacturing/ trade") selected @endif>Jewelry manufacturing/ trade</option>
                                        <option value="Laboratories" @if($form_data['neighborhood']['east'] == "Laboratories") selected @endif>Laboratories</option>
                                        <option value="Livestock" @if($form_data['neighborhood']['east'] == "Livestock") selected @endif>Livestock</option>
                                        <option value="Machinery/ tool/ metal product manufacturers" @if($form_data['neighborhood']['east'] == "Machinery/ tool/ metal product manufacturers") selected @endif>Machinery/ tool/ metal product manufacturers</option>
                                        <option value="Mega malls & commercial centers" @if($form_data['neighborhood']['east'] == "Mega malls & commercial centers") selected @endif>Mega malls & commercial centers</option>
                                        <option value="Media companies" @if($form_data['neighborhood']['east'] == "Media companies") selected @endif>Media companies</option>
                                        <option value="Metal industry" @if($form_data['neighborhood']['east'] == "Metal industry") selected @endif>Metal industry</option>
                                        <option value="Mining/ quarrying/ excavating" @if($form_data['neighborhood']['east'] == "Mining/ quarrying/ excavating") selected @endif>Mining/ quarrying/ excavating</option>
                                        <option value="Mobile shops" @if($form_data['neighborhood']['east'] == "Mobile shops") selected @endif>Mobile shops</option>
                                        <option value="Movie theaters" @if($form_data['neighborhood']['east'] == "Movie theaters") selected @endif>Movie theaters</option>
                                        <option value="Museum/ heritage sites" @if($form_data['neighborhood']['east'] == "Museum/ heritage sites") selected @endif>Museum/ heritage sites</option>
                                        <option value="Newspaper, magazine & book printing/ publishing" @if($form_data['neighborhood']['east'] == "Newspaper, magazine & book printing/ publishing") selected @endif>Newspaper, magazine & book printing/ publishing</option>
                                        <option value="Non profit, foundations & philanthropist" @if($form_data['neighborhood']['east'] == "Non profit, foundations & philanthropist") selected @endif>Non profit, foundations & philanthropist</option>
                                        <option value="Offshore activities" @if($form_data['neighborhood']['east'] == "Offshore activities") selected @endif>Offshore activities</option>
                                        <option value="Office buildings/ complexes" @if($form_data['neighborhood']['east'] == "Office buildings/ complexes") selected @endif>Office buildings/ complexes</option>
                                        <option value="Oil & gas distribution & retail" @if($form_data['neighborhood']['east'] == "Oil & gas distribution & retail") selected @endif>Oil & gas distribution & retail</option>
                                        <option value="Oil & gas storage" @if($form_data['neighborhood']['east'] == "Oil & gas storage") selected @endif>Oil & gas storage</option>
                                        <option value="Oil & gas facilities" @if($form_data['neighborhood']['east'] == "Oil & gas facilities") selected @endif>Oil & gas facilities</option>
                                        <option value="Paints factories & warehouses" @if($form_data['neighborhood']['east'] == "Paints factories & warehouses") selected @endif>Paints factories & warehouses</option>
                                        <option value="Paper, pulp & packaging materials manufacturing" @if($form_data['neighborhood']['east'] == "Paper, pulp & packaging materials manufacturing") selected @endif>Paper, pulp & packaging materials manufacturing</option>
                                        <option value="Petrol diesel & gas filling stations" @if($form_data['neighborhood']['east'] == "Petrol diesel & gas filling stations") selected @endif>Petrol diesel & gas filling stations</option>
                                        <option value="Pharmaceutical manufacturing" @if($form_data['neighborhood']['east'] == "Pharmaceutical manufacturing") selected @endif>Pharmaceutical manufacturing</option>
                                        <option value="Plastic production/ processing/ storage" @if($form_data['neighborhood']['east'] == "Plastic production/ processing/ storage") selected @endif>Plastic production/ processing/ storage</option>
                                        <option value="Port & terminal operators/ owners" @if($form_data['neighborhood']['east'] == "Port & terminal operators/ owners") selected @endif>Port & terminal operators/ owners</option>
                                        <option value="Portacabins / caravans" @if($form_data['neighborhood']['east'] == "Portacabins / caravans") selected @endif>Portacabins / caravans</option>
                                        <option value="Power and desalination plants" @if($form_data['neighborhood']['east'] == "Power and desalination plants") selected @endif>Power and desalination plants</option>
                                        <option value="Printing press" @if($form_data['neighborhood']['east'] == "Printing press") selected @endif>Printing press</option>
                                        <option value="Public administration building" @if($form_data['neighborhood']['east'] == "Public administration building") selected @endif>Public administration building</option>
                                        <option value="Radio/ TV stations/ media companies/ cable & satellite TV distribution" @if($form_data['neighborhood']['east'] == "Radio/ TV stations/ media companies/ cable & satellite TV distribution") selected @endif>Radio/ TV stations/ media companies/ cable & satellite TV distribution</option>
                                        <option value="Rag factories" @if($form_data['neighborhood']['east'] == "Rag factories") selected @endif>Rag factories</option>
                                        <option value="Rail roads & related infrastructure" @if($form_data['neighborhood']['east'] == "Rail roads & related infrastructure") selected @endif>Rail roads & related infrastructure</option>
                                        <option value="Real estate/ property developers" @if($form_data['neighborhood']['east'] == "Real estate/ property developers") selected @endif>Real estate/ property developers</option>
                                        <option value="Residential & office building" @if($form_data['neighborhood']['east'] == "Residential & office building") selected @endif>Residential & office building</option>
                                        <option value="Recreational clubs/Theme & water parks" @if($form_data['neighborhood']['east'] == "Recreational clubs/Theme & water parks") selected @endif>Recreational clubs/Theme & water parks</option>
                                        <option value="Refrigerated distribution" @if($form_data['neighborhood']['east'] == "Refrigerated distribution") selected @endif>Refrigerated distribution</option>
                                        <option value="Religious centers" @if($form_data['neighborhood']['east'] == "Religious centers") selected @endif>Religious centers</option>
                                        <option value="Residential property/ tower/ societies" @if($form_data['neighborhood']['east'] == "Residential property/ tower/ societies") selected @endif>Residential property/ tower/ societies</option>
                                        <option value="Restaurant/ catering services" @if($form_data['neighborhood']['east'] == "Restaurant/ catering services") selected @endif>Restaurant/ catering services</option>
                                        <option value="Salons/ grooming services" @if($form_data['neighborhood']['east'] == "Salons/ grooming services") selected @endif>Salons/ grooming services</option>
                                        <option value="Scrap traders" @if($form_data['neighborhood']['east'] == "Scrap traders") selected @endif>Scrap traders</option>
                                        <option value="Stadium/ sports facilities/ race track" @if($form_data['neighborhood']['east'] == "Stadium/ sports facilities/ race track") selected @endif>Stadium/ sports facilities/ race track</option>
                                        <option value="Subaqueous work" @if($form_data['neighborhood']['east'] == "Subaqueous work") selected @endif>Subaqueous work</option>
                                        <option value="Sugar factories/ refineries" @if($form_data['neighborhood']['east'] == "Sugar factories/ refineries") selected @endif>Sugar factories/ refineries</option>
                                        <option value="Ship operators/ owners" @if($form_data['neighborhood']['east'] == "Ship operators/ owners") selected @endif>Ship operators/ owners</option>
                                        <option value="Shipbuilding & repairing" @if($form_data['neighborhood']['east'] == "Shipbuilding & repairing") selected @endif>Shipbuilding & repairing</option>
                                        <option value="Steel/ metal plants" @if($form_data['neighborhood']['east'] == "Steel/ metal plants") selected @endif>Steel/ metal plants</option>
                                        <option value="Souk and similar markets" @if($form_data['neighborhood']['east'] == "Souk and similar markets") selected @endif>Souk and similar markets</option>
                                        <option value="Supermarkets / hypermarket/ other retail shops" @if($form_data['neighborhood']['east'] == "Supermarkets / hypermarket/ other retail shops") selected @endif>Supermarkets / hypermarket/ other retail shops</option>
                                        <option value="Tanning/ leather processing" @if($form_data['neighborhood']['east'] == "Tanning/ leather processing") selected @endif>Tanning/ leather processing</option>
                                        <option value="Telecommunication companies" @if($form_data['neighborhood']['east'] == "Telecommunication companies") selected @endif>Telecommunication companies</option>
                                        <option value="Textile mills/ traders/ sales" @if($form_data['neighborhood']['east'] == "Textile mills/ traders/ sales") selected @endif>Textile mills/ traders/ sales</option>
                                        <option value="Tile/ ceramic manufacturers" @if($form_data['neighborhood']['east'] == "Tile/ ceramic manufacturers") selected @endif>Tile/ ceramic manufacturers</option>
                                        <option value="Tobacco" @if($form_data['neighborhood']['east'] == "Tobacco") selected @endif>Tobacco</option>
                                        <option value="Trucking/ land transport services" @if($form_data['neighborhood']['east'] == "Trucking/ land transport services") selected @endif>Trucking/ land transport services</option>
                                        <option value="Undermining operations" @if($form_data['neighborhood']['east'] == "Undermining operations") selected @endif>Undermining operations</option>
                                        <option value="Upholstery services" @if($form_data['neighborhood']['east'] == "Upholstery services") selected @endif>Upholstery services</option>
                                        <option value="Vegetable oil refineries/ factories" @if($form_data['neighborhood']['east'] == "Vegetable oil refineries/ factories") selected @endif>Vegetable oil refineries/ factories</option>
                                        <option value="Warehouse/ cold storage" @if($form_data['neighborhood']['east'] == "Warehouse/ cold storage") selected @endif>Warehouse/ cold storage</option>
                                        <option value="Wool factories" @if($form_data['neighborhood']['east'] == "Wool factories") selected @endif>Wool factories</option>
                                        <option value="Wood processing/ carpets/ furniture manufacture" @if($form_data['neighborhood']['east'] == "Wood processing/ carpets/ furniture manufacture") selected @endif>Wood processing/ carpets/ furniture manufacture</option>
                                        <option value="General Trading / Trading (others)" @if($form_data['neighborhood']['east'] == "General Trading / Trading (others)") selected @endif>General Trading / Trading (others)</option>
                                        <option value="General Manufacturing" @if($form_data['neighborhood']['east'] == "General Manufacturing") selected @endif>General Manufacturing</option>
                                        <option value="IT" @if($form_data['neighborhood']['east'] == "IT") selected @endif>IT</option>
                                        </select>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form_group">
                                    <label class="form_label bold">North <span>*</span></label>
                                    <div class="custom_select">
                                            <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="north" name="north" onchange="validation(this.id)">
                                                <option value="">Select business of the insured </option>
                                                <option value="Accounts/ Audit firms/ Professional Services/ Law Firms" @if($form_data['neighborhood']['north'] == "Accounts/ Audit firms/ Professional Services/ Law Firms") selected @endif>Accounts/ Audit firms/ Professional Services/ Law Firms</option>
                                                <option value="Advertising / Public Relations" @if($form_data['neighborhood']['north'] == "Advertising / Public Relations") selected @endif>Advertising / Public Relations</option>
                                                <option value="Agricultural services & Products" @if($form_data['neighborhood']['north'] == "Agricultural services & Products") selected @endif>Agricultural services & Products</option>
                                                <option value="Aircraft & ship crew/ terminal operators" @if($form_data['neighborhood']['north'] == "Aircraft & ship crew/ terminal operators") selected @endif>Aircraft & ship crew/ terminal operators</option>
                                                <option value="Airports & related infrastructure" @if($form_data['neighborhood']['north'] == "Airports & related infrastructure") selected @endif>Airports & related infrastructure</option>
                                                <option value="Alternative energy" @if($form_data['neighborhood']['north'] == "Alternative energy") selected @endif>Alternative energy</option>
                                                <option value="Architectural services/ Engineers" @if($form_data['neighborhood']['north'] == "Architectural services/ Engineers") selected @endif>Architectural services/ Engineers</option>
                                                <option value="Armed Forces" @if($form_data['neighborhood']['north'] == "Armed Forces") selected @endif>Armed Forces</option>
                                                <option value="Art galleries/ fine arts collection" @if($form_data['neighborhood']['north'] == "Art galleries/ fine arts collection") selected @endif>Art galleries/ fine arts collection</option>
                                                <option value="Auto manufacturers" @if($form_data['neighborhood']['north'] == "Auto manufacturers") selected @endif>Auto manufacturers</option>
                                                <option value="Automobile workshop/ showroom/ garage/ service station" @if($form_data['neighborhood']['north'] == "Automobile workshop/ showroom/ garage/ service station") selected @endif>Automobile workshop/ showroom/ garage/ service station</option>
                                                <option value="Automotive spart parts dealer/ traders" @if($form_data['neighborhood']['north'] == "Automotive spart parts dealer/ traders") selected @endif>Automotive spart parts dealer/ traders</option>
                                                <option value="Bank/ lenders/ financial institution/ currency exchange" @if($form_data['neighborhood']['north'] == "Bank/ lenders/ financial institution/ currency exchange") selected @endif>Bank/ lenders/ financial institution/ currency exchange</option>
                                                <option value="Beverage manufacturing & bottling" @if($form_data['neighborhood']['north'] == "Beverage manufacturing & bottling") selected @endif>Beverage manufacturing & bottling</option>
                                                <option value="Bridges & tunnels" @if($form_data['neighborhood']['north'] == "Bridges & tunnels") selected @endif>Bridges & tunnels</option>
                                                <option value="Builders/ general contractors" @if($form_data['neighborhood']['north'] == "Builders/ general contractors") selected @endif>Builders/ general contractors</option>
                                                <option value="Building materials manufacturers/ traders" @if($form_data['neighborhood']['north'] == "Building materials manufacturers/ traders") selected @endif>Building materials manufacturers/ traders</option>
                                                <option value="Business process outsourcing / management services/ trade associations" @if($form_data['neighborhood']['north'] == "Business process outsourcing / management services/ trade associations") selected @endif>Business process outsourcing / management services/ trade associations</option>
                                                <option value="Cafes & Restaurant" @if($form_data['neighborhood']['north'] == "Cafes & Restaurant") selected @endif>Cafes & Restaurant</option>
                                                <option value="Carpentry workshop" @if($form_data['neighborhood']['north'] == "Carpentry workshop") selected @endif>Carpentry workshop</option>
                                                <option value="Car dealer/ showroom" @if($form_data['neighborhood']['north'] == "Car dealer/ showroom") selected @endif>Car dealer/ showroom</option>
                                                <option value="Cement plant/ precast/ block factories" @if($form_data['neighborhood']['north'] == "Cement plant/ precast/ block factories") selected @endif>Cement plant/ precast/ block factories</option>
                                                <option value="Charcoal / briquette manufacturing" @if($form_data['neighborhood']['north'] == "Charcoal / briquette manufacturing") selected @endif>Charcoal / briquette manufacturing</option>
                                                <option value="Chemical Plant" @if($form_data['neighborhood']['north'] == "Chemical Plant") selected @endif>Chemical Plant</option>
                                                <option value="Cinema Hall auditoriums" @if($form_data['neighborhood']['north'] == "Cinema Hall auditoriums") selected @endif>Cinema Hall auditoriums</option>
                                                <option value="Clothing manufacturing" @if($form_data['neighborhood']['north'] == "Clothing manufacturing") selected @endif>Clothing manufacturing</option>
                                                <option value="Colleges/ Universities/ schools & educational institute" @if($form_data['neighborhood']['north'] == "Colleges/ Universities/ schools & educational institute") selected @endif>Colleges/ Universities/ schools & educational institute</option>
                                                <option value="Computer hardware trading/ sales" @if($form_data['neighborhood']['north'] == "Computer hardware trading/ sales") selected @endif>Computer hardware trading/ sales</option>
                                                <option value="Computer software production/ data centers" @if($form_data['neighborhood']['north'] == "Computer software production/ data centers") selected @endif>Computer software production/ data centers</option>
                                                <option value="Confectionery/ dairy products processing" @if($form_data['neighborhood']['north'] == "Confectionery/ dairy products processing") selected @endif>Confectionery/ dairy products processing</option>
                                                <option value="Construction company" @if($form_data['neighborhood']['north'] == "Construction company") selected @endif>Construction company</option>
                                                <option value="Cotton ginning wool/ textile manufacturing" @if($form_data['neighborhood']['north'] == "Cotton ginning wool/ textile manufacturing") selected @endif>Cotton ginning wool/ textile manufacturing</option>
                                                <option value="Dams/ reservoirs" @if($form_data['neighborhood']['north'] == "Dams/ reservoirs") selected @endif>Dams/ reservoirs</option>
                                                <option value="Department stores/ shopping malls" @if($form_data['neighborhood']['north'] == "Department stores/ shopping malls") selected @endif>Department stores/ shopping malls</option>
                                                <option value="Desalination/ water utilities/treatment plant" @if($form_data['neighborhood']['north'] == "Desalination/ water utilities/treatment plant") selected @endif>Desalination/ water utilities/treatment plant</option>
                                                <option value="Doctors & other health professional" @if($form_data['neighborhood']['north'] == "Doctors & other health professional") selected @endif>Doctors & other health professional</option>
                                                <option value="Electrical appliance/ electronic component manufacturing" @if($form_data['neighborhood']['north'] == "Electrical appliance/ electronic component manufacturing") selected @endif>Electrical appliance/ electronic component manufacturing</option>
                                                <option value="Electronic trading/ sales" @if($form_data['neighborhood']['north'] == "Electronic trading/ sales") selected @endif>Electronic trading/ sales</option>
                                                <option value="Entertainment venues" @if($form_data['neighborhood']['north'] == "Entertainment venues") selected @endif>Entertainment venues</option>
                                                <option value="Explosives/ fireworks manufacturing/warehouses" @if($form_data['neighborhood']['north'] == "Explosives/ fireworks manufacturing/warehouses") selected @endif>Explosives/ fireworks manufacturing/warehouses</option>
                                                <option value="Flax/ Breaking/ scratching"  @if($form_data['neighborhood']['north'] == "Flax/ Breaking/ scratching") selected @endif>Flax/ Breaking/ scratching</option>
                                                <option value="Flour mills" @if($form_data['neighborhood']['north'] == "Flour mills") selected @endif>Flour mills</option>
                                                <option value="Foam, plastic, rubber production/ processing/ storage" @if($form_data['neighborhood']['north'] == "Foam, plastic, rubber production/ processing/ storage") selected @endif>Foam, plastic, rubber production/ processing/ storage</option>
                                                <option value="Food & beverage manufacturers" @if($form_data['neighborhood']['north'] == "Food & beverage manufacturers") selected @endif>Food & beverage manufacturers</option>
                                                <option value="Freight forwarders" @if($form_data['neighborhood']['north'] == "Freight forwarders") selected @endif>Freight forwarders</option>
                                                <option value="Fund managers, stocks and commodity broker" @if($form_data['neighborhood']['north'] == "Fund managers, stocks and commodity broker") selected @endif>Fund managers, stocks and commodity broker</option>
                                                <option value="Furniture shops/ manufacturing units" @if($form_data['neighborhood']['north'] == "Furniture shops/ manufacturing units") selected @endif>Furniture shops/ manufacturing units</option>
                                                <option value="Garbage collection/ waste management" @if($form_data['neighborhood']['north'] == "Garbage collection/ waste management") selected @endif>Garbage collection/ waste management</option>
                                                <option value="Grain storage (silos) processing" @if($form_data['neighborhood']['north'] == "Grain storage (silos) processing") selected @endif>Grain storage (silos) processing</option>
                                                <option value="Hospital/ clinics & nursing homes" @if($form_data['neighborhood']['north'] == "Hospital/ clinics & nursing homes") selected @endif>Hospital/ clinics & nursing homes</option>
                                                <option value="Hotels/ boarding houses/ motels/ service apartments" @if($form_data['neighborhood']['north'] == "Hotels/ boarding houses/ motels/ service apartments") selected @endif>Hotels/ boarding houses/ motels/ service apartments</option>
                                                <option value="Hotel multiple cover" @if($form_data['neighborhood']['north'] == "Hotel multiple cover") selected @endif>Hotel multiple cover</option>
                                                <option value="Infrastructure" @if($form_data['neighborhood']['north'] == "Infrastructure") selected @endif>Infrastructure</option>
                                                <option value="Insurance companies & brokers/ consultants" @if($form_data['neighborhood']['north'] == "Insurance companies & brokers/ consultants") selected @endif>Insurance companies & brokers/ consultants</option>
                                                <option value="Jewelry manufacturing/ trade" @if($form_data['neighborhood']['north'] == "Jewelry manufacturing/ trade") selected @endif>Jewelry manufacturing/ trade</option>
                                                <option value="Laboratories" @if($form_data['neighborhood']['north'] == "Laboratories") selected @endif>Laboratories</option>
                                                <option value="Livestock" @if($form_data['neighborhood']['north'] == "Livestock") selected @endif>Livestock</option>
                                                <option value="Machinery/ tool/ metal product manufacturers" @if($form_data['neighborhood']['north'] == "Machinery/ tool/ metal product manufacturers") selected @endif>Machinery/ tool/ metal product manufacturers</option>
                                                <option value="Mega malls & commercial centers" @if($form_data['neighborhood']['north'] == "Mega malls & commercial centers") selected @endif>Mega malls & commercial centers</option>
                                                <option value="Media companies" @if($form_data['neighborhood']['north'] == "Media companies") selected @endif>Media companies</option>
                                                <option value="Metal industry" @if($form_data['neighborhood']['north'] == "Metal industry") selected @endif>Metal industry</option>
                                                <option value="Mining/ quarrying/ excavating" @if($form_data['neighborhood']['north'] == "Mining/ quarrying/ excavating") selected @endif>Mining/ quarrying/ excavating</option>
                                                <option value="Mobile shops" @if($form_data['neighborhood']['north'] == "Mobile shops") selected @endif>Mobile shops</option>
                                                <option value="Movie theaters" @if($form_data['neighborhood']['north'] == "Movie theaters") selected @endif>Movie theaters</option>
                                                <option value="Museum/ heritage sites" @if($form_data['neighborhood']['north'] == "Museum/ heritage sites") selected @endif>Museum/ heritage sites</option>
                                                <option value="Newspaper, magazine & book printing/ publishing" @if($form_data['neighborhood']['north'] == "Newspaper, magazine & book printing/ publishing") selected @endif>Newspaper, magazine & book printing/ publishing</option>
                                                <option value="Non profit, foundations & philanthropist" @if($form_data['neighborhood']['north'] == "Non profit, foundations & philanthropist") selected @endif>Non profit, foundations & philanthropist</option>
                                                <option value="Offshore activities" @if($form_data['neighborhood']['north'] == "Offshore activities") selected @endif>Offshore activities</option>
                                                <option value="Office buildings/ complexes" @if($form_data['neighborhood']['north'] == "Office buildings/ complexes") selected @endif>Office buildings/ complexes</option>
                                                <option value="Oil & gas distribution & retail" @if($form_data['neighborhood']['north'] == "Oil & gas distribution & retail") selected @endif>Oil & gas distribution & retail</option>
                                                <option value="Oil & gas storage" @if($form_data['neighborhood']['north'] == "Oil & gas storage") selected @endif>Oil & gas storage</option>
                                                <option value="Oil & gas facilities" @if($form_data['neighborhood']['north'] == "Oil & gas facilities") selected @endif>Oil & gas facilities</option>
                                                <option value="Paints factories & warehouses" @if($form_data['neighborhood']['north'] == "Paints factories & warehouses") selected @endif>Paints factories & warehouses</option>
                                                <option value="Paper, pulp & packaging materials manufacturing" @if($form_data['neighborhood']['north'] == "Paper, pulp & packaging materials manufacturing") selected @endif>Paper, pulp & packaging materials manufacturing</option>
                                                <option value="Petrol diesel & gas filling stations" @if($form_data['neighborhood']['north'] == "Petrol diesel & gas filling stations") selected @endif>Petrol diesel & gas filling stations</option>
                                                <option value="Pharmaceutical manufacturing" @if($form_data['neighborhood']['north'] == "Pharmaceutical manufacturing") selected @endif>Pharmaceutical manufacturing</option>
                                                <option value="Plastic production/ processing/ storage" @if($form_data['neighborhood']['north'] == "Plastic production/ processing/ storage") selected @endif>Plastic production/ processing/ storage</option>
                                                <option value="Port & terminal operators/ owners" @if($form_data['neighborhood']['north'] == "Port & terminal operators/ owners") selected @endif>Port & terminal operators/ owners</option>
                                                <option value="Portacabins / caravans" @if($form_data['neighborhood']['north'] == "Portacabins / caravans") selected @endif>Portacabins / caravans</option>
                                                <option value="Power and desalination plants" @if($form_data['neighborhood']['north'] == "Power and desalination plants") selected @endif>Power and desalination plants</option>
                                                <option value="Printing press" @if($form_data['neighborhood']['north'] == "Printing press") selected @endif>Printing press</option>
                                                <option value="Public administration building" @if($form_data['neighborhood']['north'] == "Public administration building") selected @endif>Public administration building</option>
                                                <option value="Radio/ TV stations/ media companies/ cable & satellite TV distribution" @if($form_data['neighborhood']['north'] == "Radio/ TV stations/ media companies/ cable & satellite TV distribution") selected @endif>Radio/ TV stations/ media companies/ cable & satellite TV distribution</option>
                                                <option value="Rag factories" @if($form_data['neighborhood']['north'] == "Rag factories") selected @endif>Rag factories</option>
                                                <option value="Rail roads & related infrastructure" @if($form_data['neighborhood']['north'] == "Rail roads & related infrastructure") selected @endif>Rail roads & related infrastructure</option>
                                                <option value="Real estate/ property developers" @if($form_data['neighborhood']['north'] == "Real estate/ property developers") selected @endif>Real estate/ property developers</option>
                                                <option value="Residential & office building" @if($form_data['neighborhood']['north'] == "Residential & office building") selected @endif>Residential & office building</option>
                                                <option value="Recreational clubs/Theme & water parks" @if($form_data['neighborhood']['north'] == "Recreational clubs/Theme & water parks") selected @endif>Recreational clubs/Theme & water parks</option>
                                                <option value="Refrigerated distribution" @if($form_data['neighborhood']['north'] == "Refrigerated distribution") selected @endif>Refrigerated distribution</option>
                                                <option value="Religious centers" @if($form_data['neighborhood']['north'] == "Religious centers") selected @endif>Religious centers</option>
                                                <option value="Residential property/ tower/ societies" @if($form_data['neighborhood']['north'] == "Residential property/ tower/ societies") selected @endif>Residential property/ tower/ societies</option>
                                                <option value="Restaurant/ catering services" @if($form_data['neighborhood']['north'] == "Restaurant/ catering services") selected @endif>Restaurant/ catering services</option>
                                                <option value="Salons/ grooming services" @if($form_data['neighborhood']['north'] == "Salons/ grooming services") selected @endif>Salons/ grooming services</option>
                                                <option value="Scrap traders" @if($form_data['neighborhood']['north'] == "Scrap traders") selected @endif>Scrap traders</option>
                                                <option value="Stadium/ sports facilities/ race track" @if($form_data['neighborhood']['north'] == "Stadium/ sports facilities/ race track") selected @endif>Stadium/ sports facilities/ race track</option>
                                                <option value="Subaqueous work" @if($form_data['neighborhood']['north'] == "Subaqueous work") selected @endif>Subaqueous work</option>
                                                <option value="Sugar factories/ refineries" @if($form_data['neighborhood']['north'] == "Sugar factories/ refineries") selected @endif>Sugar factories/ refineries</option>
                                                <option value="Ship operators/ owners" @if($form_data['neighborhood']['north'] == "Ship operators/ owners") selected @endif>Ship operators/ owners</option>
                                                <option value="Shipbuilding & repairing" @if($form_data['neighborhood']['north'] == "Shipbuilding & repairing") selected @endif>Shipbuilding & repairing</option>
                                                <option value="Steel/ metal plants" @if($form_data['neighborhood']['north'] == "Steel/ metal plants") selected @endif>Steel/ metal plants</option>
                                                <option value="Souk and similar markets" @if($form_data['neighborhood']['north'] == "Souk and similar markets") selected @endif>Souk and similar markets</option>
                                                <option value="Supermarkets / hypermarket/ other retail shops" @if($form_data['neighborhood']['north'] == "Supermarkets / hypermarket/ other retail shops") selected @endif>Supermarkets / hypermarket/ other retail shops</option>
                                                <option value="Tanning/ leather processing" @if($form_data['neighborhood']['north'] == "Tanning/ leather processing") selected @endif>Tanning/ leather processing</option>
                                                <option value="Telecommunication companies" @if($form_data['neighborhood']['north'] == "Telecommunication companies") selected @endif>Telecommunication companies</option>
                                                <option value="Textile mills/ traders/ sales" @if($form_data['neighborhood']['north'] == "Textile mills/ traders/ sales") selected @endif>Textile mills/ traders/ sales</option>
                                                <option value="Tile/ ceramic manufacturers" @if($form_data['neighborhood']['north'] == "Tile/ ceramic manufacturers") selected @endif>Tile/ ceramic manufacturers</option>
                                                <option value="Tobacco" @if($form_data['neighborhood']['north'] == "Tobacco") selected @endif>Tobacco</option>
                                                <option value="Trucking/ land transport services" @if($form_data['neighborhood']['north'] == "Trucking/ land transport services") selected @endif>Trucking/ land transport services</option>
                                                <option value="Undermining operations" @if($form_data['neighborhood']['north'] == "Undermining operations") selected @endif>Undermining operations</option>
                                                <option value="Upholstery services" @if($form_data['neighborhood']['north'] == "Upholstery services") selected @endif>Upholstery services</option>
                                                <option value="Vegetable oil refineries/ factories" @if($form_data['neighborhood']['north'] == "Vegetable oil refineries/ factories") selected @endif>Vegetable oil refineries/ factories</option>
                                                <option value="Warehouse/ cold storage" @if($form_data['neighborhood']['north'] == "Warehouse/ cold storage") selected @endif>Warehouse/ cold storage</option>
                                                <option value="Wool factories" @if($form_data['neighborhood']['north'] == "Wool factories") selected @endif>Wool factories</option>
                                                <option value="Wood processing/ carpets/ furniture manufacture" @if($form_data['neighborhood']['north'] == "Wood processing/ carpets/ furniture manufacture") selected @endif>Wood processing/ carpets/ furniture manufacture</option>
                                                <option value="General Trading / Trading (others)" @if($form_data['neighborhood']['north'] == "General Trading / Trading (others)") selected @endif>General Trading / Trading (others)</option>
                                                <option value="General Manufacturing" @if($form_data['neighborhood']['north'] == "General Manufacturing") selected @endif>General Manufacturing</option>
                                                <option value="IT" @if($form_data['neighborhood']['north'] == "IT") selected @endif>IT</option>
                    </select>
                                        </div>
                                </div>
                            </div>
            
                <div class="col-md-3">
                    <div class="form_group">
                            <label class="form_label bold">South <span>*</span></label>
                            <div class="custom_select">
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="south" name="south" onchange="validation(this.id)">
                                        <option value="">Select business of the insured </option>
                                        <option value="Accounts/ Audit firms/ Professional Services/ Law Firms" @if($form_data['neighborhood']['south'] == "Accounts/ Audit firms/ Professional Services/ Law Firms") selected @endif>Accounts/ Audit firms/ Professional Services/ Law Firms</option>
                                        <option value="Advertising / Public Relations" @if($form_data['neighborhood']['south'] == "Advertising / Public Relations") selected @endif>Advertising / Public Relations</option>
                                        <option value="Agricultural services & Products" @if($form_data['neighborhood']['south'] == "Agricultural services & Products") selected @endif>Agricultural services & Products</option>
                                        <option value="Aircraft & ship crew/ terminal operators" @if($form_data['neighborhood']['south'] == "Aircraft & ship crew/ terminal operators") selected @endif>Aircraft & ship crew/ terminal operators</option>
                                        <option value="Airports & related infrastructure" @if($form_data['neighborhood']['south'] == "Airports & related infrastructure") selected @endif>Airports & related infrastructure</option>
                                        <option value="Alternative energy" @if($form_data['neighborhood']['south'] == "Alternative energy") selected @endif>Alternative energy</option>
                                        <option value="Architectural services/ Engineers" @if($form_data['neighborhood']['south'] == "Architectural services/ Engineers") selected @endif>Architectural services/ Engineers</option>
                                        <option value="Armed Forces" @if($form_data['neighborhood']['south'] == "Armed Forces") selected @endif>Armed Forces</option>
                                        <option value="Art galleries/ fine arts collection" @if($form_data['neighborhood']['south'] == "Art galleries/ fine arts collection") selected @endif>Art galleries/ fine arts collection</option>
                                        <option value="Auto manufacturers" @if($form_data['neighborhood']['south'] == "Auto manufacturers") selected @endif>Auto manufacturers</option>
                                        <option value="Automobile workshop/ showroom/ garage/ service station" @if($form_data['neighborhood']['south'] == "Automobile workshop/ showroom/ garage/ service station") selected @endif>Automobile workshop/ showroom/ garage/ service station</option>
                                        <option value="Automotive spart parts dealer/ traders" @if($form_data['neighborhood']['south'] == "Automotive spart parts dealer/ traders") selected @endif>Automotive spart parts dealer/ traders</option>
                                        <option value="Bank/ lenders/ financial institution/ currency exchange" @if($form_data['neighborhood']['south'] == "Bank/ lenders/ financial institution/ currency exchange") selected @endif>Bank/ lenders/ financial institution/ currency exchange</option>
                                        <option value="Beverage manufacturing & bottling" @if($form_data['neighborhood']['south'] == "Beverage manufacturing & bottling") selected @endif>Beverage manufacturing & bottling</option>
                                        <option value="Bridges & tunnels" @if($form_data['neighborhood']['south'] == "Bridges & tunnels") selected @endif>Bridges & tunnels</option>
                                        <option value="Builders/ general contractors" @if($form_data['neighborhood']['south'] == "Builders/ general contractors") selected @endif>Builders/ general contractors</option>
                                        <option value="Building materials manufacturers/ traders" @if($form_data['neighborhood']['south'] == "Building materials manufacturers/ traders") selected @endif>Building materials manufacturers/ traders</option>
                                        <option value="Business process outsourcing / management services/ trade associations" @if($form_data['neighborhood']['south'] == "Business process outsourcing / management services/ trade associations") selected @endif>Business process outsourcing / management services/ trade associations</option>
                                        <option value="Cafes & Restaurant" @if($form_data['neighborhood']['south'] == "Cafes & Restaurant") selected @endif>Cafes & Restaurant</option>
                                        <option value="Carpentry workshop" @if($form_data['neighborhood']['south'] == "Carpentry workshop") selected @endif>Carpentry workshop</option>
                                        <option value="Car dealer/ showroom" @if($form_data['neighborhood']['south'] == "Car dealer/ showroom") selected @endif>Car dealer/ showroom</option>
                                        <option value="Cement plant/ precast/ block factories" @if($form_data['neighborhood']['south'] == "Cement plant/ precast/ block factories") selected @endif>Cement plant/ precast/ block factories</option>
                                        <option value="Charcoal / briquette manufacturing" @if($form_data['neighborhood']['south'] == "Charcoal / briquette manufacturing") selected @endif>Charcoal / briquette manufacturing</option>
                                        <option value="Chemical Plant" @if($form_data['neighborhood']['south'] == "Chemical Plant") selected @endif>Chemical Plant</option>
                                        <option value="Cinema Hall auditoriums" @if($form_data['neighborhood']['south'] == "Cinema Hall auditoriums") selected @endif>Cinema Hall auditoriums</option>
                                        <option value="Clothing manufacturing" @if($form_data['neighborhood']['south'] == "Clothing manufacturing") selected @endif>Clothing manufacturing</option>
                                        <option value="Colleges/ Universities/ schools & educational institute" @if($form_data['neighborhood']['south'] == "Colleges/ Universities/ schools & educational institute") selected @endif>Colleges/ Universities/ schools & educational institute</option>
                                        <option value="Computer hardware trading/ sales" @if($form_data['neighborhood']['south'] == "Computer hardware trading/ sales") selected @endif>Computer hardware trading/ sales</option>
                                        <option value="Computer software production/ data centers" @if($form_data['neighborhood']['south'] == "Computer software production/ data centers") selected @endif>Computer software production/ data centers</option>
                                        <option value="Confectionery/ dairy products processing" @if($form_data['neighborhood']['south'] == "Confectionery/ dairy products processing") selected @endif>Confectionery/ dairy products processing</option>
                                        <option value="Construction company" @if($form_data['neighborhood']['south'] == "Construction company") selected @endif>Construction company</option>
                                        <option value="Cotton ginning wool/ textile manufacturing" @if($form_data['neighborhood']['south'] == "Cotton ginning wool/ textile manufacturing") selected @endif>Cotton ginning wool/ textile manufacturing</option>
                                        <option value="Dams/ reservoirs" @if($form_data['neighborhood']['south'] == "Dams/ reservoirs") selected @endif>Dams/ reservoirs</option>
                                        <option value="Department stores/ shopping malls" @if($form_data['neighborhood']['south'] == "Department stores/ shopping malls") selected @endif>Department stores/ shopping malls</option>
                                        <option value="Desalination/ water utilities/treatment plant" @if($form_data['neighborhood']['south'] == "Desalination/ water utilities/treatment plant") selected @endif>Desalination/ water utilities/treatment plant</option>
                                        <option value="Doctors & other health professional" @if($form_data['neighborhood']['south'] == "Doctors & other health professional") selected @endif>Doctors & other health professional</option>
                                        <option value="Electrical appliance/ electronic component manufacturing" @if($form_data['neighborhood']['south'] == "Electrical appliance/ electronic component manufacturing") selected @endif>Electrical appliance/ electronic component manufacturing</option>
                                        <option value="Electronic trading/ sales" @if($form_data['neighborhood']['south'] == "Electronic trading/ sales") selected @endif>Electronic trading/ sales</option>
                                        <option value="Entertainment venues" @if($form_data['neighborhood']['south'] == "Entertainment venues") selected @endif>Entertainment venues</option>
                                        <option value="Explosives/ fireworks manufacturing/warehouses" @if($form_data['neighborhood']['south'] == "Explosives/ fireworks manufacturing/warehouses") selected @endif>Explosives/ fireworks manufacturing/warehouses</option>
                                        <option value="Flax/ Breaking/ scratching"  @if($form_data['neighborhood']['south'] == "Flax/ Breaking/ scratching") selected @endif>Flax/ Breaking/ scratching</option>
                                        <option value="Flour mills" @if($form_data['neighborhood']['south'] == "Flour mills") selected @endif>Flour mills</option>
                                        <option value="Foam, plastic, rubber production/ processing/ storage" @if($form_data['neighborhood']['south'] == "Foam, plastic, rubber production/ processing/ storage") selected @endif>Foam, plastic, rubber production/ processing/ storage</option>
                                        <option value="Food & beverage manufacturers" @if($form_data['neighborhood']['south'] == "Food & beverage manufacturers") selected @endif>Food & beverage manufacturers</option>
                                        <option value="Freight forwarders" @if($form_data['neighborhood']['south'] == "Freight forwarders") selected @endif>Freight forwarders</option>
                                        <option value="Fund managers, stocks and commodity broker" @if($form_data['neighborhood']['south'] == "Fund managers, stocks and commodity broker") selected @endif>Fund managers, stocks and commodity broker</option>
                                        <option value="Furniture shops/ manufacturing units" @if($form_data['neighborhood']['south'] == "Furniture shops/ manufacturing units") selected @endif>Furniture shops/ manufacturing units</option>
                                        <option value="Garbage collection/ waste management" @if($form_data['neighborhood']['south'] == "Garbage collection/ waste management") selected @endif>Garbage collection/ waste management</option>
                                        <option value="Grain storage (silos) processing" @if($form_data['neighborhood']['south'] == "Grain storage (silos) processing") selected @endif>Grain storage (silos) processing</option>
                                        <option value="Hospital/ clinics & nursing homes" @if($form_data['neighborhood']['south'] == "Hospital/ clinics & nursing homes") selected @endif>Hospital/ clinics & nursing homes</option>
                                        <option value="Hotels/ boarding houses/ motels/ service apartments" @if($form_data['neighborhood']['south'] == "Hotels/ boarding houses/ motels/ service apartments") selected @endif>Hotels/ boarding houses/ motels/ service apartments</option>
                                        <option value="Hotel multiple cover" @if($form_data['neighborhood']['south'] == "Hotel multiple cover") selected @endif>Hotel multiple cover</option>
                                        <option value="Infrastructure" @if($form_data['neighborhood']['south'] == "Infrastructure") selected @endif>Infrastructure</option>
                                        <option value="Insurance companies & brokers/ consultants" @if($form_data['neighborhood']['south'] == "Insurance companies & brokers/ consultants") selected @endif>Insurance companies & brokers/ consultants</option>
                                        <option value="Jewelry manufacturing/ trade" @if($form_data['neighborhood']['south'] == "Jewelry manufacturing/ trade") selected @endif>Jewelry manufacturing/ trade</option>
                                        <option value="Laboratories" @if($form_data['neighborhood']['south'] == "Laboratories") selected @endif>Laboratories</option>
                                        <option value="Livestock" @if($form_data['neighborhood']['south'] == "Livestock") selected @endif>Livestock</option>
                                        <option value="Machinery/ tool/ metal product manufacturers" @if($form_data['neighborhood']['south'] == "Machinery/ tool/ metal product manufacturers") selected @endif>Machinery/ tool/ metal product manufacturers</option>
                                        <option value="Mega malls & commercial centers" @if($form_data['neighborhood']['south'] == "Mega malls & commercial centers") selected @endif>Mega malls & commercial centers</option>
                                        <option value="Media companies" @if($form_data['neighborhood']['south'] == "Media companies") selected @endif>Media companies</option>
                                        <option value="Metal industry" @if($form_data['neighborhood']['south'] == "Metal industry") selected @endif>Metal industry</option>
                                        <option value="Mining/ quarrying/ excavating" @if($form_data['neighborhood']['south'] == "Mining/ quarrying/ excavating") selected @endif>Mining/ quarrying/ excavating</option>
                                        <option value="Mobile shops" @if($form_data['neighborhood']['south'] == "Mobile shops") selected @endif>Mobile shops</option>
                                        <option value="Movie theaters" @if($form_data['neighborhood']['south'] == "Movie theaters") selected @endif>Movie theaters</option>
                                        <option value="Museum/ heritage sites" @if($form_data['neighborhood']['south'] == "Museum/ heritage sites") selected @endif>Museum/ heritage sites</option>
                                        <option value="Newspaper, magazine & book printing/ publishing" @if($form_data['neighborhood']['south'] == "Newspaper, magazine & book printing/ publishing") selected @endif>Newspaper, magazine & book printing/ publishing</option>
                                        <option value="Non profit, foundations & philanthropist" @if($form_data['neighborhood']['south'] == "Non profit, foundations & philanthropist") selected @endif>Non profit, foundations & philanthropist</option>
                                        <option value="Offshore activities" @if($form_data['neighborhood']['south'] == "Offshore activities") selected @endif>Offshore activities</option>
                                        <option value="Office buildings/ complexes" @if($form_data['neighborhood']['south'] == "Office buildings/ complexes") selected @endif>Office buildings/ complexes</option>
                                        <option value="Oil & gas distribution & retail" @if($form_data['neighborhood']['south'] == "Oil & gas distribution & retail") selected @endif>Oil & gas distribution & retail</option>
                                        <option value="Oil & gas storage" @if($form_data['neighborhood']['south'] == "Oil & gas storage") selected @endif>Oil & gas storage</option>
                                        <option value="Oil & gas facilities" @if($form_data['neighborhood']['south'] == "Oil & gas facilities") selected @endif>Oil & gas facilities</option>
                                        <option value="Paints factories & warehouses" @if($form_data['neighborhood']['south'] == "Paints factories & warehouses") selected @endif>Paints factories & warehouses</option>
                                        <option value="Paper, pulp & packaging materials manufacturing" @if($form_data['neighborhood']['south'] == "Paper, pulp & packaging materials manufacturing") selected @endif>Paper, pulp & packaging materials manufacturing</option>
                                        <option value="Petrol diesel & gas filling stations" @if($form_data['neighborhood']['south'] == "Petrol diesel & gas filling stations") selected @endif>Petrol diesel & gas filling stations</option>
                                        <option value="Pharmaceutical manufacturing" @if($form_data['neighborhood']['south'] == "Pharmaceutical manufacturing") selected @endif>Pharmaceutical manufacturing</option>
                                        <option value="Plastic production/ processing/ storage" @if($form_data['neighborhood']['south'] == "Plastic production/ processing/ storage") selected @endif>Plastic production/ processing/ storage</option>
                                        <option value="Port & terminal operators/ owners" @if($form_data['neighborhood']['south'] == "Port & terminal operators/ owners") selected @endif>Port & terminal operators/ owners</option>
                                        <option value="Portacabins / caravans" @if($form_data['neighborhood']['south'] == "Portacabins / caravans") selected @endif>Portacabins / caravans</option>
                                        <option value="Power and desalination plants" @if($form_data['neighborhood']['south'] == "Power and desalination plants") selected @endif>Power and desalination plants</option>
                                        <option value="Printing press" @if($form_data['neighborhood']['south'] == "Printing press") selected @endif>Printing press</option>
                                        <option value="Public administration building" @if($form_data['neighborhood']['south'] == "Public administration building") selected @endif>Public administration building</option>
                                        <option value="Radio/ TV stations/ media companies/ cable & satellite TV distribution" @if($form_data['neighborhood']['south'] == "Radio/ TV stations/ media companies/ cable & satellite TV distribution") selected @endif>Radio/ TV stations/ media companies/ cable & satellite TV distribution</option>
                                        <option value="Rag factories" @if($form_data['neighborhood']['south'] == "Rag factories") selected @endif>Rag factories</option>
                                        <option value="Rail roads & related infrastructure" @if($form_data['neighborhood']['south'] == "Rail roads & related infrastructure") selected @endif>Rail roads & related infrastructure</option>
                                        <option value="Real estate/ property developers" @if($form_data['neighborhood']['south'] == "Real estate/ property developers") selected @endif>Real estate/ property developers</option>
                                        <option value="Residential & office building" @if($form_data['neighborhood']['south'] == "Residential & office building") selected @endif>Residential & office building</option>
                                        <option value="Recreational clubs/Theme & water parks" @if($form_data['neighborhood']['south'] == "Recreational clubs/Theme & water parks") selected @endif>Recreational clubs/Theme & water parks</option>
                                        <option value="Refrigerated distribution" @if($form_data['neighborhood']['south'] == "Refrigerated distribution") selected @endif>Refrigerated distribution</option>
                                        <option value="Religious centers" @if($form_data['neighborhood']['south'] == "Religious centers") selected @endif>Religious centers</option>
                                        <option value="Residential property/ tower/ societies" @if($form_data['neighborhood']['south'] == "Residential property/ tower/ societies") selected @endif>Residential property/ tower/ societies</option>
                                        <option value="Restaurant/ catering services" @if($form_data['neighborhood']['south'] == "Restaurant/ catering services") selected @endif>Restaurant/ catering services</option>
                                        <option value="Salons/ grooming services" @if($form_data['neighborhood']['south'] == "Salons/ grooming services") selected @endif>Salons/ grooming services</option>
                                        <option value="Scrap traders" @if($form_data['neighborhood']['south'] == "Scrap traders") selected @endif>Scrap traders</option>
                                        <option value="Stadium/ sports facilities/ race track" @if($form_data['neighborhood']['south'] == "Stadium/ sports facilities/ race track") selected @endif>Stadium/ sports facilities/ race track</option>
                                        <option value="Subaqueous work" @if($form_data['neighborhood']['south'] == "Subaqueous work") selected @endif>Subaqueous work</option>
                                        <option value="Sugar factories/ refineries" @if($form_data['neighborhood']['south'] == "Sugar factories/ refineries") selected @endif>Sugar factories/ refineries</option>
                                        <option value="Ship operators/ owners" @if($form_data['neighborhood']['south'] == "Ship operators/ owners") selected @endif>Ship operators/ owners</option>
                                        <option value="Shipbuilding & repairing" @if($form_data['neighborhood']['south'] == "Shipbuilding & repairing") selected @endif>Shipbuilding & repairing</option>
                                        <option value="Steel/ metal plants" @if($form_data['neighborhood']['south'] == "Steel/ metal plants") selected @endif>Steel/ metal plants</option>
                                        <option value="Souk and similar markets" @if($form_data['neighborhood']['south'] == "Souk and similar markets") selected @endif>Souk and similar markets</option>
                                        <option value="Supermarkets / hypermarket/ other retail shops" @if($form_data['neighborhood']['south'] == "Supermarkets / hypermarket/ other retail shops") selected @endif>Supermarkets / hypermarket/ other retail shops</option>
                                        <option value="Tanning/ leather processing" @if($form_data['neighborhood']['south'] == "Tanning/ leather processing") selected @endif>Tanning/ leather processing</option>
                                        <option value="Telecommunication companies" @if($form_data['neighborhood']['south'] == "Telecommunication companies") selected @endif>Telecommunication companies</option>
                                        <option value="Textile mills/ traders/ sales" @if($form_data['neighborhood']['south'] == "Textile mills/ traders/ sales") selected @endif>Textile mills/ traders/ sales</option>
                                        <option value="Tile/ ceramic manufacturers" @if($form_data['neighborhood']['south'] == "Tile/ ceramic manufacturers") selected @endif>Tile/ ceramic manufacturers</option>
                                        <option value="Tobacco" @if($form_data['neighborhood']['south'] == "Tobacco") selected @endif>Tobacco</option>
                                        <option value="Trucking/ land transport services" @if($form_data['neighborhood']['south'] == "Trucking/ land transport services") selected @endif>Trucking/ land transport services</option>
                                        <option value="Undermining operations" @if($form_data['neighborhood']['south'] == "Undermining operations") selected @endif>Undermining operations</option>
                                        <option value="Upholstery services" @if($form_data['neighborhood']['south'] == "Upholstery services") selected @endif>Upholstery services</option>
                                        <option value="Vegetable oil refineries/ factories" @if($form_data['neighborhood']['south'] == "Vegetable oil refineries/ factories") selected @endif>Vegetable oil refineries/ factories</option>
                                        <option value="Warehouse/ cold storage" @if($form_data['neighborhood']['south'] == "Warehouse/ cold storage") selected @endif>Warehouse/ cold storage</option>
                                        <option value="Wool factories" @if($form_data['neighborhood']['south'] == "Wool factories") selected @endif>Wool factories</option>
                                        <option value="Wood processing/ carpets/ furniture manufacture" @if($form_data['neighborhood']['south'] == "Wood processing/ carpets/ furniture manufacture") selected @endif>Wood processing/ carpets/ furniture manufacture</option>
                                        <option value="General Trading / Trading (others)" @if($form_data['neighborhood']['south'] == "General Trading / Trading (others)") selected @endif>General Trading / Trading (others)</option>
                                        <option value="General Manufacturing" @if($form_data['neighborhood']['south'] == "General Manufacturing") selected @endif>General Manufacturing</option>
                                        <option value="IT" @if($form_data['neighborhood']['south'] == "IT") selected @endif>IT</option>
                                        </select>
                                </div>
                        </div>
                    </div>
            </div>
        </div>

<div class="row">
        {{-- <div class="col-md-6">
            <div class="form_group">
                <label class="form_label bold">Neighborhood <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="neighborhood" name="neighborhood">
                        <option value=""  selected>Select</option>
                            <option value="north">North</option>
                            <option value="east">East</option>
                            <option value="west">West</option>
                            <option value="south">South</option>
                    </select>
                </div>
            </div>
        </div>  --}}
{{-- Neighborhood --}}
    
        <div class="col-md-12" id="distance">
            <div class="row">
                <div class="col-md-12">
                    <label class="form_label bold">Distance to nearest Fire station(kms)<span>*</span></label>
                </div>    
                <div class="col-md-12">
                    <div class="form_group">
                        <div>
                            <input class="form_input text_upload" type="text" placeholder="" name="distance" id="distance" value="{{@$form_data['distance']}}"><span class="text_field_p"> Kms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Distance to nearest Fire station --}}

    <div class="card_separation">
            <div class="row">
    
                <div class="col-md-4">
                    <div class="card_sub_head">
                        <div class="clearfix">
                            <h3 class="card_sub_heading pull-left">Water storage for fire fighting</h3>
                        </div>
                    </div>
                </div>
            <div class="col-md-8" id="water_yes" style="display:none">
                <div class="card_sub_head">
                    <div class="clearfix">
                        <h3 class="card_sub_heading pull-left">Storage capacity</h3>
                    </div>
                </div>
            </div>    
            </div>
                <div class="row">
                        <div class="col-md-4">
                            <div class="form_group">
                                    <label class="form_label bold">SELECT WATER STORAGE FOR FIRE FIGHTING<span>*</span></label>
                                    <div class="custom_select">
                                            <select class="form_input" id="water_storage" name="water_storage" onchange="validation(this.id)">
                                                   
                                                <option value="" selected>Select</option>            
                                                <option value="yes" @if(isset($form_data['waterSorage']['waterSorage']) && @$form_data['waterSorage']['waterSorage'] ==true) selected @endif>Yes</option>
                                                <option value="no" @if(isset($form_data['waterSorage']['waterSorage']) && @$form_data['waterSorage']['waterSorage'] == false) selected @endif>No</option>
                                            </select>
                                        </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4" id="gallons"  @if(@$form_data['waterSorage']['waterSorage'] ==true) style="display:block"@else  style="display:none" @endif>
                                  
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label bold">How much is the capacity<span>*</span></label>
                                            <input class="form_input" name="gallons_value"  value="{{@$form_data['waterSorage']['gallonsValue']}}">
                                            </div>
                                        </div>
                                    </div>
                            </div> 
                            <div class="col-md-4" id="lts" style="display:none" >
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form_group">
                                                <label class="form_label bold">Numberical value field for Lts <span>*</span></label>
                                                <input class="form_input" name="lts_value" value="{{@$form_data['waterSorage']['ltsValue']}}">
                                            </div>
                                        </div>
                                    </div>
                            </div>   
                </div> 
            </div>
    </div>
    {{-- Water storage for fire fighting --}}

    <div class="card_separation">
            <div class="row">
                    <div class="col-md-6">
                            <div class="card_sub_head">
                                <div class="clearfix">
                                    <h3 class="card_sub_heading pull-left">Sum Insured and Description</h3>
                                </div>
                            </div>
                        </div>
            </div>
    <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Building including compound walls, fencing  <span>*</span></label>
                    <input class="form_input number" name="building_include" id="building_include" placeholder="Building including compound walls, fencing "
                     @if(@$form_data['buildingInclude']!='') value="{{number_format(trim(@$form_data['buildingInclude']),2)}}"  @endif onkeyup="calculate()">
                </div>               
            </div>
            <div class="col-md-6">
                <div class="form_group">
                    <div class="form_group">
                        <label class="form_label">Stock in Trade  <span>*</span></label>
                        <input class="form_input number" name="stock" id="stock" placeholder="Stock in Trade" @if(@$form_data['stock']!='') value="{{number_format(trim(@$form_data['stock']),2)}}" @endif
                        onkeyup="calculate()" >
                    </div>
                </div>
            </div>     
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Finished and Semi-Finished Goods  <span>*</span></label>
                    <input class="form_input number" name="finished_goods" id="finished_goods" placeholder="Finished and Semi-Finished Goods" 
                    onkeyup="calculate()" @if(@$form_data['finishedGoods']!='') value="{{number_format(trim(@$form_data['finishedGoods']),2)}}" @endif >
                </div>               
            </div>
            <div class="col-md-6">
                <div class="form_group">
                    <div class="form_group">
                        <label class="form_label">Raw Materials  <span>*</span></label>
                        <input class="form_input number" name="raw_materials" id="raw_materials" placeholder="Raw Materials" 
                        @if(@$form_data['rawMaterials']!='') value="{{number_format(trim(@$form_data['rawMaterials']),2)}}"  @endif onkeyup="calculate()" >
                    </div>
                </div>
            </div>     
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Machinery, Equipments, Tools etc.  <span>*</span></label>
                    <input class="form_input number" name="machinery" id="machinery" placeholder="Machinery, Equipments, Tools etc." 
                    @if(@$form_data['machinery']!='') value="{{number_format(trim(@$form_data['machinery']),2)}}" @endif  onkeyup="calculate()" >
                </div>               
            </div>
            <div class="col-md-6">
                <div class="form_group">
                    <div class="form_group">
                        <label class="form_label">Sign Boards <span>*</span></label>
                        <input class="form_input number" name="sign_boards" id="sign_boards" placeholder="Sign Boards" 
                        @if(@$form_data['signBoards']!='') value="{{number_format(trim(@$form_data['signBoards']),2)}}" @endif onkeyup="calculate()" >
                    </div>
                </div>
            </div>     
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Furniture, Fixtures & Fittings & Decoration  <span>*</span></label>
                    <input class="form_input number" name="furniture" id="furniture" placeholder="Furniture, Fixtures & Fittings & Decoration"
                    @if(@$form_data['furniture']!='') value="{{number_format(trim(@$form_data['furniture']),2)}}" @endif onkeyup="calculate()"  >
                </div>               
            </div>
            <div class="col-md-6">
                <div class="form_group">
                    <div class="form_group">
                        <label class="form_label">Office Equipments including Computers, Fax, Photocopy etc <span>*</span></label>
                        <input class="form_input number" name="office_equipments" id="office_equipments" placeholder="Office Equipments including Computers,Fax, Photocopy etc" onkeyup="calculate()"  @if(@$form_data['officeEquipments']!='') value="{{number_format(trim(@$form_data['officeEquipments']),2)}}" @endif >
                    </div>
                </div>
            </div>     
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label">Annual Rent  <span>*</span></label>
                    <input class="form_input number" name="annual_rent" id="annual_rent" placeholder="Annual Rent"  
                    @if(@$form_data['annualRent']!='')  value="{{number_format(trim(@$form_data['annualRent']),2)}}" @endif onkeyup="calculate()">
                </div>               
            </div>
            <div class="col-md-6">
                    <div class="form_group">
                        <div class="form_group">
                            <label class="form_label">Total  <span>*</span></label>
                        <input class="form_input" name="total" id="total" placeholder="Total" readonly @if(@$form_data['total']!='') value="{{number_format(trim(@$form_data['total']),2)}}" @endif>
                        </div>
                    </div>
                </div> 
                
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form_group">
                <div class="form_group">
                    <label class="form_label">Any other items  <span>*</span></label>
                    <input class="form_input" name="other_items" id="other_items" placeholder="Any other items"
                    @if(@$form_data['otherItems']!='') value="{{@$form_data['otherItems']}}" @endif>
                </div>
            </div>
        </div>  
    </div>
</div>
{{--  --}}


<div class="row">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label bold">Do you have a Bank mortgage<span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="bank_mortage" name="bank_mortage" onchange="validation(this.id)" >
                        <option value="" selected>Select</option>            
                        <option value="yes"  @if(isset($form_data['bankMortage']['bank_mortage']) && @$form_data['bankMortage']['bank_mortage'] ==true) selected @endif>Yes</option>
                        <option value="no"  @if(isset($form_data['bankMortage']['bank_mortage']) && @$form_data['bankMortage']['bank_mortage'] ==false) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>

{{-- Do you have a Bank mortgage --}}
</div>
<div id="bankMortage_yes"  @if(@$form_data['bankMortage']['bank_mortage'] =='true') style="display:block" @else style="display:none" @endif>
        <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Bank Name  <span>*</span></label>
                    <input class="form_input" name="bankname" id="bankname" placeholder="Bank Name" 
                    @if(@$form_data['bankMortage']['bankname']!='')  value="{{@$form_data['bankMortage']['bankname']}}" @endif>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Telephone Number  <span>*</span></label>
                    <input class="form_input" name="telnumber" id="telnumber" placeholder="Telephone Number" 
                    @if(@$form_data['bankMortage']['telnumber']!='')  value="{{@$form_data['bankMortage']['telnumber']}}" @endif>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="form_group">
                            <label class="form_label form_text">Fax Number <span>*</span></label>
                        <input class="form_input" name="fax" id="fax" placeholder="Fax Number"
                        @if(@$form_data['bankMortage']['fax']!='') value="{{@$form_data['bankMortage']['fax']}}" @endif>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">PO Box  <span>*</span></label>
                    <input class="form_input " name="pobox" id="pobox" placeholder="PO Box" 
                        value="{{@$form_data['bankMortage']['pobox']}}" >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Location <span>*</span></label>
                    <input class="form_input" name="location" id="location" placeholder="Location"
                    @if(@$form_data['bankMortage']['location']!='')  value="{{@$form_data['bankMortage']['location']}}" @endif>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Contact Person <span>*</span></label>
                    <input class="form_input " name="contact" id="contact" placeholder="Contact Person"
                    @if(@$form_data['bankMortage']['contact']!='')   value="{{@$form_data['bankMortage']['contact']}}" @endif>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text" >Related Department Inside The Bank  <span>*</span></label>
                    <input class="form_input" name="dept_bank" id="dept_bank" placeholder="Related Department Inside The Bank" 
                    type="text" value="{{@$form_data['bankMortage']['dept_bank']}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text" >Email  <span>*</span></label>
                    <input class="form_input" name="email" id="email" placeholder="Email"
                        type="text" value="{{@$form_data['bankMortage']['email']}}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Mobile Number <span>*</span></label>
                    <input class="form_input" name="mobile" id="mobile"
                        placeholder="Mobile Number" 
                        type="text"   @if(isset($form_data['bankMortage']['mobile']) && @$form_data['bankMortage']['mobile']!='') value="{{@$form_data['bankMortage']['mobile']}}" @endif>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Amount to be assigned to the bank</label>
                    <input class="form_input number" name="amount" id="amount"
                        placeholder="Amount to be assigned to the bank"
                        type="text"   @if(isset($form_data['bankMortage']['amount']) && @$form_data['bankMortage']['amount']!='') value="{{number_format(trim(@$form_data['bankMortage']['amount']),2)}}" @endif>
                </div>
            </div>
        </div> 
    </div>
{{-- Total --}}

<div class="row">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label bold">Business Interruption cover Required<span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="business_interruption" name="business_interruption" onchange="validation(this.id)">
                        <option value="" selected>Select</option>            
                        <option value="yes"  @if(isset($form_data['businessInterruption']['business_interruption']) && @$form_data['businessInterruption']['business_interruption'] ==true) selected @endif>Yes</option>
                        <option value="no"  @if(isset($form_data['businessInterruption']['business_interruption']) && @$form_data['businessInterruption']['business_interruption'] ==false) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>
</div>     

            <div id="business_yes"  @if(@$form_data['businessInterruption']['business_interruption'] =='true') style="display:block" @else style="display:none" @endif>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">Actual Annual Gross Profit for the previous year (AED)  <span>*</span></label>
                            <input class="form_input number" name="actual_profit" id="business_yes1" placeholder="Actual Annual Gross Profit for the previous year (AED)" 
                            @if(@$form_data['businessInterruption']['actualProfit']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['actualProfit']),2)}}" @endif>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">Estimated Annual Gross Profit for the next year (AED)  <span>*</span></label>
                            <input class="form_input number" name="estimated_profit" id="estimated_profit" placeholder="Estimated Annual Gross Profit for the next year (AED)" 
                            @if(@$form_data['businessInterruption']['estimatedProfit']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['estimatedProfit']),2)}}" @endif>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form_group">
                                    <label class="form_label form_text">Standing Charges  <span>*</span></label>
                                <input class="form_input number" name="stand_charge" id="stand_charge" placeholder="Standing Charges"
                                @if(@$form_data['businessInterruption']['standCharge']!='') value="{{number_format(trim(@$form_data['businessInterruption']['standCharge']),2)}}" @endif>
                            </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">No of locations  <span>*</span></label>
                            <input class="form_input " name="no_locations" id="business_yes4" placeholder="No of locations" 
                                value="{{@$form_data['businessInterruption']['noLocations']}}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">Increase cost of working  <span>*</span></label>
                            <input class="form_input number" name="cost_work" id="business_yes5" placeholder="Increase cost of working"
                            @if(@$form_data['businessInterruption']['costWork']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['costWork']),2)}}" @endif>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">Loss of Rent  <span>*</span></label>
                            <input class="form_input number" name="rent_loss" id="business_yes6" placeholder="Loss of Rent"
                            @if(@$form_data['businessInterruption']['rentLoss']!='')   value="{{number_format(trim(@$form_data['businessInterruption']['rentLoss']),2)}}" @endif>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text" style="min-height: 40px">Name of the main customers  <span>*</span></label>
                            <input class="form_input" name="main_cust_name" id="business_yes7" placeholder="Name of the main customers" 
                            type="text" value="{{@$form_data['businessInterruption']['mainCustName']}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text" style="min-height: 40px">Name of the main Suppliers  <span>*</span></label>
                            <input class="form_input" name="main_supp_name" id="business_yes8" placeholder="Name of the main Suppliers"
                                type="text" value="{{@$form_data['businessInterruption']['mainSuppName']}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                                <label class="form_label form_text">Period of indemnity (This should correspond to the expected period the business interruption will continue)  <span>*</span></label>
                            <input class="form_input number" name="indemnity_period" id="business_yes9"
                                placeholder="Period of indemnity (This should correspond to the expected period the business interruption will continue)"
                                type="text"   @if(isset($form_data['businessInterruption']['indemnityPeriod']) && @$form_data['businessInterruption']['indemnityPeriod']!='') value="{{number_format(trim(@$form_data['businessInterruption']['indemnityPeriod']),2)}}" @endif>
                        </div>
                    </div>
                </div> 
            </div>
            
                   
           

{{-- Business Interruption cover Required --}}

<div class="row">
        <div class="col-md-6">
            <div class="form_group">
                <label class="form_label bold">Claims experience details for<span>*</span></label>
                <div class="">
                    <select class="selectpicker" id="claim_experience_details" name="claim_experience_details" onchange="validation(this.id)">
                        <option value="" selected>Select</option>            
                        <option value="combined_data" @if($form_data['claimExperienceDetails'] =='combined_data') selected @endif>Combined data for Property and Business interruption coverages</option>
                        <option value="only_property" @if($form_data['claimExperienceDetails'] =='only_property') selected @endif>Only Property</option>
                        <option value="separate_property" @if($form_data['claimExperienceDetails'] =='separate_property') selected @endif>Separate data for Property </option>
                    </select>
                </div>
            </div>
        </div>
</div>    
{{--Claims experience details for --}}

<div class="card_separation">
        <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        <label class="form_label bold" id="claim_label">Claims experience <span style="visibility:hidden">*</span></label>
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
                                <input type="hidden" value="Year 1" name="year[]" id="year1">
                                <td>Year 1 </td>
                                <td>
                                    <input class="form_input number" name="claim_amount[]" id="claim_amount1" @if(isset($form_data['claimsHistory'][0]['claim_amount'])&&(@$form_data['claimsHistory'][0]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory'][0]['claim_amount']),2)}}" @endif>
                                    <label id="claim_amount1-error" class="error" for="claim_amount1" style="display: none">Please enter claim amount.</label>
                                </td>
                                <td><input class="form_input" name="description[]" id="description1"value="{{@$form_data['claimsHistory'][0]['description']}}">
                                    <label id="description1-error" class="error" for="description1" style="display: none">Please enter description.</label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <td>Year 2 <input type="hidden" value="Year 2" name="year[]" id="year2"></td>
                                <td><input class="form_input number" name="claim_amount[]" id="claim_amount2" @if(isset($form_data['claimsHistory'][1]['claim_amount'])&&(@$form_data['claimsHistory'][1]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory'][1]['claim_amount']),2)}}" @endif ></td>
                                <td><input class="form_input" name="description[]" type="text" id="description2" value="{{@$form_data['claimsHistory'][1]['description']}}"></td>
                                
                            </tr>
                            
                            <tr>
                                <td>Year 3<input type="hidden" value="Year 3" name="year[]" id="year3"></td>
                                <td><input class="form_input number" name="claim_amount[]" id="claim_amount3" @if(isset($form_data['claimsHistory'][2]['claim_amount'])&&(@$form_data['claimsHistory'][2]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory'][2]['claim_amount']),2)}}" @endif></td>
                                <td><input class="form_input" name="description[]" type="text" id="description3" value="{{@$form_data['claimsHistory'][2]['description']}}"></td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
{{--Claims experience --}}

<div class="card_separation" id="fire_perils" @if($form_data['claimExperienceDetails'] =='separate_property') style="display:block" @else style="display:none" @endif>
        <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        <label class="form_label bold" >Fire & Perils <span style="visibility:hidden">*</span></label>
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
                                <input type="hidden" value="Year 1" name="year_sep[]" id="year_sep1">
                                <td>Year 1 </td>
                                <td>
                                    <input class="form_input number" name="claim_amount_sep[]" id="claim_amount_sep1" @if(isset($form_data['claimsHistory_sep'][0]['claim_amount'])&&(@$form_data['claimsHistory_sep'][0]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory_sep'][0]['claim_amount']),2)}}" @endif>
                                    <label id="claim_amount_sep1-error" class="error" for="claim_amount_sep1" style="display: none">Please enter claim amount.</label>
                                </td>
                                <td><input class="form_input" name="description_sep[]" id="description_sep1"value="{{@$form_data['claimsHistory_sep'][0]['description']}}">
                                    <label id="description_sep1-error" class="error" for="description_sep1" style="display: none">Please enter description.</label>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <td>Year 2 <input type="hidden" value="Year 2" name="year_sep[]" id="year_sep2"></td>
                                <td><input class="form_input number" name="claim_amount_sep[]" id="claim_amount_sep2" @if(isset($form_data['claimsHistory_sep'][1]['claim_amount'])&&(@$form_data['claimsHistory_sep'][1]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory_sep'][1]['claim_amount']),2)}}" @endif ></td>
                                <td><input class="form_input" name="description_sep[]" type="text" id="description_sep2" value="{{@$form_data['claimsHistory_sep'][1]['description']}}"></td>
                                
                            </tr>
                            
                            <tr>
                                <td>Year 3<input type="hidden" value="Year 3" name="year_sep[]" id="year_sep3"></td>
                                <td><input class="form_input number" name="claim_amount_sep[]" id="claim_amount_sep3" @if(isset($form_data['claimsHistory_sep'][2]['claim_amount'])&&(@$form_data['claimsHistory_sep'][2]['claim_amount'])!="") value="{{number_format(trim(@$form_data['claimsHistory_sep'][2]['claim_amount']),2)}}" @endif></td>
                                <td><input class="form_input" name="description_sep[]" type="text" id="description_sep3" value="{{@$form_data['claimsHistory_sep'][2]['description']}}"></td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
{{--Claims experience --}}


{{-- file upload --}}
<div class="row">
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('CIVIL DEFENSE COMPLIANCE CERTIFICATE',$file_name))
                    <?php $key = array_search('CIVIL DEFENSE COMPLIANCE CERTIFICATE', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="civil_url" name="civil_url">
                        <span class="pull-right" id="saved_civil_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                <label class="form_label">Copy of Civil Defense compliance certificate <span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="civil_certificate" id="civil_certificate" onchange="upload_file(this)">
                    <p id="civil_p">Drag your files or click here.</p>
                </div>
            </div>
    
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('COPY OF THE POLICY',$file_name))
                    <?php $key = array_search('COPY OF THE POLICY', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="policy_url" name="policy_url">
                        <span class="pull-right" id="saved_policy_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                    <label class="form_label">Copy of the policy if possible (upload)<span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="policyCopy" id="policyCopy" onchange="upload_file(this)">
                    <p id="policy_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('TRADE LICENSE',$file_name))
                    <?php $key = array_search('TRADE LICENSE', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="trade_url" name="trade_url">
                        <span class="pull-right" id="saved_trade_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                    <label class="form_label">Copy of trade license <span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="trade_list" id="trade_list" onchange="upload_file(this)">
                    <p id="trade_list_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('VAT CERTIFICATE/TRN',$file_name))
                    <?php $key = array_search('VAT CERTIFICATE/TRN', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="vat_url" name="vat_url">
                        <span class="pull-right" id="saved_vat_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                            <label class="form_label">Copy of VAT Certificate/TRN <span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="vat_copy" id="vat_copy" onchange="upload_file(this)">
                    <p id="vat_copy_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('OTHERS 1',$file_name))
                    <?php $key = array_search('OTHERS 1', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="other1_url" name="other1_url">
                        <span class="pull-right" id="saved_other1_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                            <label class="form_label">Others 1 <span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="others1" id="others1" onchange="upload_file(this)">
                    <p id="others1_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('OTHERS 2',$file_name))
                    <?php $key = array_search('OTHERS 2', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="other2_url" name="other2_url">
                        <span class="pull-right" id="saved_other2_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                            <label class="form_label">Others 2 <span style="visibility:hidden">*</span></label>
                <div class="custom_upload">
                    <input type="file" name="others2" id="others2" onchange="upload_file(this)">
                    <p id="others2_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
    </div>
{{-- file upload --}}
<p class="disclaimer">
        Disclaimer : It is your duty to disclose all material facts to underwriters. A material fact is one that is likely to influence an underwriter’s judgement and acceptance of your proposal. 
        If your proposal is a renewal, it should also include any change in facts previously advised to underwriters. If you are in any doubt about facts considered materials, disclose them.
         FAILURE TO DISCLOSE could prejudice your rights to recover in the event of a claim or allow underwriters to void the Policy.
</p>

