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
                <label class="form_label">Name of the Insured  <span>*</span></label>
                <input class="form_input" name="firstName" id="firstName" placeholder="First Name" type="text" @if(!empty($form_data)) value="{{$form_data['firstName']}}" @else  value="{{@$PipelineItems['customer']['name']}}" @endif>
            </div>
        </div>
    </div>
@endif
<div class="row">
        <div class="col-md-12">
                <div class="form_group">
                    <label class="form_label">If there is any subsidiary/affliated company </label>
                    <input class="form_input" name="aff_company" id="aff_company" placeholder="If there is any subsidiary/affliated company" type="text" @if(!empty($form_data)) value="{{$form_data['aff_company']}}"  @endif>
                </div>
            </div>  
</div>
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
                <select  class="selectpicker" data-hide-disabled="true" data-live-search="true"   id="country1" name="country" onChange="getState('country1','state1');" >
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
            {{-- <div class="custom_select" id="state_div"> --}}
                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="state" id="state1" onchange="validation(this.id);">
                    <option disabled >Select Emirate</option>
                </select>
            {{-- </div> --}}
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
        <div class="col-md-3">
                <div class="form_group">
                    <label class="form_label">Tel No <span>*</span></label>
                    <input class="form_input" name="telno" id="telno" placeholder="Tel No" type="text"  maxlength="10"  @if(!empty($form_data)) value="{{$form_data['telno']}}" @endif >
                </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Fax No <span>*</span></label>
                <input class="form_input" name="faxno" id="faxno" placeholder="Fax No" type="text" @if(!empty($form_data)) value="{{$form_data['faxno']}}" @endif maxlength="12">
            </div>
        </div>
        <div class="col-md-3">
                <div class="form_group">
                        <label class="form_label">Email ID<span>*</span></label>
                        <input class="form_input" name="email" id="email" placeholder="Email ID" type="text" @if(!empty($form_data)) value="{{$form_data['email']}}" @endif>
                </div>
        </div>
</div>
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

<div class="row">
        <div class="col-md-6">
                <div class="form_group">
                        <label class="form_label">Name of Chief engineer or plant manager</label>
                        <input class="form_input" name="chief_eng" id="chief_eng" placeholder="Name of Chief engineer or plant manager" type="text" @if(!empty($form_data)) value="{{$form_data['chief_eng']}}" @endif>
                </div>
        </div>
</div>
<div class="row">
            <div class="col-md-12">
                <div class="form_group">
                    <label class="form_label bold">Has any of the machinary to be insured previously been covered by other companies ?<span>*</span></label>
                    <div class="custom_select">
                        <select class="form_input" id="previous_insures" name="previous_insures" onchange="validation(this.id)" >
                            <option value="" selected>Select</option>            
                            <option value="yes"  @if(isset($form_data['previousInsurer'])   && $form_data['previousInsurer'] == true ) selected @endif>Yes</option>
                            <option value="no"   @if(isset($form_data['previousInsurer'])   && $form_data['previousInsurer'] == false) selected @endif>No</option>
                        </select>
                    </div>
                </div>
            </div>
    
    {{-- Do you have a previous_insure --}}
</div>  
<?php $count=0;
$filecount=0;

?>
<div class="wrapper" @if(@$form_data['previousInsurer'] == true ) style="display:block" @else style="display:none" @endif>
{{-- <div class="wrapper"> --}}
@if($form_data=='' || empty($form_data['previousInsure']))
{{-- @if($form_data=='' || $form_data['previousInsure']['previous_insure'] =='') --}}
<div class="row locations" id="safe_location1">
   <div class="col-md-3">
    <div class="form-group">
        <label class="form_label">Equipment Name<span>*</span></label>
        <input class="form_input"  name="equipment[]"  id="equipment0"  type="text" placeholder="Equipment Name">
    </div>
</div>
<div class="col-md-3">
     <div class="form-group">
         <label class="form_label">Company Name<span>*</span></label>
         <input class="form_input"  name="companyname[]"  id="companyname0"  placeholder="Company Name" type="text">
     </div>
 </div>
 <div class="col-md-3">
         <div class="form-group table_datepicker" style="margin: 0">
             <label class="form_label">Expiry Date<span>*</span></label>
             <input class="form_input datetimepicker"  name="expirydate[]"  id="expirydate0" placeholder="Expiry Date" type="text">
         </div>
 </div>
   @if($count>0)
       <div class="col-md-2">
           <div class="action_btn" >
               <button type="button" class="remove_field" title="Remove" style=" margin-top: 27px">
                   <i class="material-icons" style="vertical-align:middle">remove</i>
               </button>
           
           </div>
       </div>
   @else
       <div class="col-md-2">
           <div class="action_btn">
               <button type="button" title="Add"  class="add_field_button" style=" margin-top: 27px">
                   <i class="material-icons" style="vertical-align:middle">add</i>
               </button>
               
           </div>
       </div>
   @endif
</div>
@else
@foreach($form_data['previousInsure'] as $data)

@if($data['equipment']=='' ||  $data['equipment'] || $data['expirydate']=='' || $data['companyname']=='' || $data['companyname'] || $data['expirydate'])
   <div class="row locations" id="safe_location1">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form_label">Equipment Names<span>*</span></label>
            <input class="form_input"  name="equipment[]"  id="equipment{{$count}}"  type="text" placeholder="Equipment Name" value="{{$data['equipment']}}">
        </div>
    </div>
    <div class="col-md-3">
         <div class="form-group">
             <label class="form_label">Company Name<span>*</span></label>
             <input class="form_input"  name="companyname[]"  id="companyname{{$count}}"  type="text" value="{{$data['companyname']}}">
         </div>
     </div>
     <div class="col-md-3">
             <div class="form-group table_datepicker" style="margin: 0">
                 <label class="form_label">Expiry Date<span>*</span></label>
                 <input class="form_input datetimepicker"  name="expirydate[]"  id="expirydate{{$count}}"  type="text" value="{{$data['expirydate']}}">
             </div>
     </div>
           @if($count>0)
               <div class="col-md-2">
                   <div class="action_btn" >
                       <button type="button" class="remove_field" title="Remove" style=" margin-top: 27px" >
                           <i class="material-icons" style="vertical-align:middle">remove</i>
                       </button>
                   
                   </div>
               </div>
           @else
               <div class="col-md-2">
                   <div class="action_btn">
                       <button type="button" title="Add"  class="add_field_button" style=" margin-top: 27px">
                           <i class="material-icons" style="vertical-align:middle">add</i>
                       </button>
                       
                   </div>
               </div>
           @endif
   </div>
   <?php $count++; ?>
@endif
@endforeach
@endif
</div>

<div class="row">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label bold">Do you wish to insure the foundation of the machinery?<span>*</span></label>
                <div class="custom_select" >
                    <select class="form_input" id="found_machinery" name="found_machinery" onchange="validation(this.id)" >
                        <option value="" selected>Select</option>            
                        <option value="yes"  @if(isset($form_data['found_machiners']['found_machinery']) && @$form_data['found_machiners']['found_machinery'] == true) selected @endif>Yes</option>
                        <option value="no"  @if(isset($form_data['found_machiners']['found_machinery']) && @$form_data['found_machiners']['found_machinery'] == false) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>

{{-- Do you have a found_machinery --}}

    </div>
        <div id="found_machinery_comment" 
         @if(isset($form_data['found_machiners']['found_machinery']) && @$form_data['found_machiners']['found_machinery'] == true) 
         style="width: 100%"
         @else style="display:none" 
         @endif>
            <div class="row">
                <div class="col-md-12">
                        <div class="form-group">
                            <label class="form_label">Mention relevant items of the specification <span>*</span></label>
                            <textarea class="form_input" id="machinery_comment" name="machinery_comment" placeholder="Mention relevant items of the specification">@if(!empty($form_data) && @$form_data['found_machiners']['comment']!=''){{@$form_data['found_machiners']['comment']}} @endif</textarea>
                        </div>
                </div>
            </div>
        </div>
  

<div class="row">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label bold">Does the specification include all the machinery coverable under a machinery policy?<span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="machinery_policy" name="machinery_policy" onchange="validation(this.id)" >
                        <option value="" selected>Select</option>            
                        <option value="yes"  @if(isset($form_data['machinery_policy']['machinery_policy']) && @$form_data['machinery_policy']['machinery_policy'] ==true) selected @endif>Yes</option>
                        <option value="no"  @if(isset($form_data['machinery_policy']['machinery_policy']) && @$form_data['machinery_policy']['machinery_policy'] ==false) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>

{{-- Do you have a found_machinery --}}
</div>
<div id="machinery_policy_comment"@if(isset($form_data['machinery_policy']['machinery_policy']) && @$form_data['machinery_policy']['machinery_policy'] == false ) style="display:block" @else style="display:none" @endif>
    <div class="row">
            <div class="col-md-12">
                    <div class="form-group">
                        <label class="form_label">Mention all machinery coverable in one plant section  <span>*</span></label>
                        <textarea class="form_input" id="policy_comment" name="policy_comment" placeholder="Mention all machinery coverable in one plant section ">@if(!empty($form_data) && @$form_data['machinery_policy']['comment']!=''){{@$form_data['machinery_policy']['comment']}} @endif</textarea>
                    </div>
            </div>
    </div>
</div>
<div class="card_separation">
        <div class="row">
            <div class="col-md-6">
                <div class="card_sub_head">
                    <div class="clearfix">
                        <h3 class="card_sub_heading pull-left">Do you wish the cover to include extra charges(incase of loss) for:</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Air Freight <span>*</span></label>
                            <div class="custom_select">
                                <select class="form_input" id="freight" name="freight" onchange="validation(this.id)" >
                                    <option value="" selected>Select</option>            
                                    <option value="yes"  @if(isset($form_data['freight']['freight']) && @$form_data['freight']['freight'] ==true) selected @endif>Yes</option>
                                    <option value="no"  @if(isset($form_data['freight']['freight']) && @$form_data['freight']['freight'] ==false) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-md-6" id="freight_comment" @if(@$form_data['freight']['freight'] == true ) style="display:block" @else style="display:none" @endif>
                       
                                <div class="form-group">
                                    <label class="form_label">Limit of indemnity for Air freight  <span>*</span></label>
                                    <textarea class="form_input" id="air_freight" name="air_freight" placeholder="Limit of indemnity for Air freight ">@if(!empty($form_data) && @$form_data['freight']['freight'] ==true) {{$form_data['freight']['comment']}} @endif</textarea>
                                </div>
                       
                </div>
                <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Overtime <span>*</span></label>
                            <div class="custom_select">
                                <select class="form_input" id="overtime" name="overtime" onchange="validation(this.id)" >
                                    <option value="" selected>Select</option>            
                                    <option value="yes"  @if(isset($form_data['overtime']['overtime']) && @$form_data['overtime']['overtime'] ==true) selected @endif>Yes</option>
                                    <option value="no"  @if(isset($form_data['overtime']['overtime']) && @$form_data['overtime']['overtime'] ==false) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Night work & work on public holidays <span>*</span></label>
                            <div class="custom_select">
                                <select class="form_input" id="holiday" name="holiday" onchange="validation(this.id)" >
                                    <option value="" selected>Select</option>            
                                    <option value="yes"  @if(isset($form_data['holiday']['holiday']) && @$form_data['holiday']['holiday'] ==true) selected @endif>Yes</option>
                                    <option value="no"  @if(isset($form_data['holiday']['holiday']) && @$form_data['holiday']['holiday'] ==false) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                </div>
        </div>
    </div>


<div class="row">
        <div class="col-md-12">
                <div class="form-group">
                    <label class="form_label">Give details of any special extension of cover required <span style="visibility:hidden">*</span></label>
                <textarea class="form_input" id="spec_extension" name="spec_extension" placeholder="Give details of any special extension of cover required ">@if(isset($form_data['spec_extension']) && ($form_data['spec_extension']!='')) {{$form_data['spec_extension']}}@endif</textarea>
                </div>
        </div>
</div>
<div class="card_separation">
        <div class="row">
            <div class="col-md-12">
                <div class="form_group">
                    {{-- <label class="form_label">Publications- Journal</label> --}}
                    <table class="table table-bordered custom_table">
                            <thead>
                            <tr>
                                <th style="position: absolute; top: 0; border: none;">Item No  <span style="color:red">*</span></th>
                                <th>Description of items Please give full and exact description of all machines, including name of
                                manufacturer , type, output, capacity, speed, load, voltage, amperage, Cycles, fuel,pressure, temperature etc.  <span  style="color:red">*</span></th>
                                <th style="position: absolute; top: 0; border: none;">Year of Manufacture  <span  style="color:red">*</span></th>
                                <th>Remarks Give particulars of any part of the machinery to be insured which has had a
                                breakdown of failure during the last three years, which shows any signs of repair, or which is exposed to any special risk. <span  style="color:red">*</span></th>
                                <th>Replacement value Please state current cost of replacing the machinery of the same kind and capacity (including oil in the case of transformers & switches) plus freight charges,
                                 customs duties, costs of erection and also value of foundations, if the latter are to be insured. <span  style="color:red">*</span></th>
                            </tr> 
                            </thead>
                            <tbody class="optionBox">
                            <tr class="block">
                                <td style="width: 170px;" valign="top">
                                    <textarea class="form_input" name="itemno" type="text" placeholder="Item No">@if(@$form_data['equipment_details']['itemno']!=''){{@$form_data['equipment_details']['itemno']}}@endif</textarea>
                                    {{-- <input class="form_input" name="itemno" type="text" placeholder="Item No" value="@if(@$form_data['equipment_details']['itemno']!=''){{@$form_data['equipment_details']['itemno']}}@endif"> --}}
                                </td>
                                <td valign="top"> 
                                    <textarea class="form_input" name="item_description" type="text" placeholder="Description of items">@if(@$form_data['equipment_details']['description']!=''){{@$form_data['equipment_details']['description']}}@endif</textarea>
                                    {{-- <input class="form_input" name="item_description" type="text" placeholder="Description of items " value="@if(@$form_data['equipment_details']['description']!=''){{@$form_data['equipment_details']['description']}}@endif"> --}}
                                </td>
                                <td style="width: 225px;" valign="top"> 
                                    <div class="custom_select">
                                        <select   class="selectpicker" data-hide-disabled="true" data-live-search="true" id="manufac_year" name="manufac_year" onchange="validation(this.id)">
                                            <?php 
                                                $earliest_year = 1950;
                                                ?>
                                                 <option value="" selected>Select Year</option>    
                                                 @foreach (range(date('Y'), $earliest_year) as $x) 
                                                     <option value="{{$x}}" @if(@$form_data['equipment_details']['manufac_year'] == $x)selected @endif >{{$x}}</option>
                                                 @endforeach
                                            
                                        </select>
                                    </div>
                                    {{-- <textarea class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture">@if(@$form_data['equipment_details']['manufac_year']!=''){{@$form_data['equipment_details']['manufac_year']}}@endif</textarea> --}}
                                    {{-- <input class="form_input" name="manufac_year" type="text" placeholder="Year of Manufacture" value="@if(@$form_data['equipment_details']['manufac_year']!=''){{@$form_data['equipment_details']['manufac_year']}}@endif"> --}}
                                </td>
                                <td valign="top">
                                    <textarea class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured">@if(@$form_data['equipment_details']['remarks']!=''){{@$form_data['equipment_details']['remarks']}}@endif</textarea>
                                    {{-- <input class="form_input" name="remarks" type="text" placeholder="Remarks Give particulars of any part of the machinery to be insured" value="@if(@$form_data['equipment_details']['remarks']!=''){{@$form_data['equipment_details']['remarks']}}@endif"> --}}
                                </td>
                                <td valign="top">
                                    <textarea class="form_input number" name="revalue" type="text" placeholder="Replacement value Please state current cost of replacing the machinery">@if(@$form_data['equipment_details']['revalue']!=''){{number_format(@$form_data['equipment_details']['revalue'],2)}}@endif</textarea>
                                </td>
                                
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
</div>
        <div class="card_separation">
                {{-- <div class="row">
                    <div class="col-md-6">
                        <div class="card_sub_head">
                            <div class="clearfix">
                                <h3 class="card_sub_heading pull-left">Do you wish the cover to include extra charges(incase of loss) for:</h3>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                        <div class="col-md-6">
                                <div class="form_group">
                                    <label class="form_label bold">Business Interruption cover Required<span>*</span></label>
                                    <div class="custom_select">
                                        <select class="form_input" id="bus_inter" name="bus_inter" onchange="validation(this.id)" >
                                            <option value="" selected>Select</option>            
                                            <option value="yes"  @if(isset($form_data['machineryInterruption']['bus_inter']) && @$form_data['machineryInterruption']['bus_inter'] ==true) selected @endif>Yes</option>
                                            <option value="no"  @if(isset($form_data['machineryInterruption']['bus_inter']) && @$form_data['machineryInterruption']['bus_inter'] ==false) selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                </div>
                <div id="business" @if(@$form_data['machineryInterruption']['bus_inter'] == true ) style="display:block" @else style="display:none" @endif>
                        <div class="row">
                                <div class="col-md-6">
                                        <div class="form_group">
                                        
                                                <label class="form_label">Actual Annual Gross Profit for the previous year (AED)<span>*</span></label>
                                                <input class="form_input number"  name="actual_profit"  id="actual_profit"  type="text" value="@if(isset($form_data['machineryInterruption']['actualProfit']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['actualProfit'],2)}}@endif">
                                        
                                        </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form_group">
                                        
                                                <label class="form_label">Estimated Annual Gross Profit for the next year (AED)<span>*</span></label>
                                                <input class="form_input number"  name="estimated_profit"  id="estimated_profit"  type="text" value="@if(isset($form_data['machineryInterruption']['estimatedProfit']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['estimatedProfit'],2)}}@endif">
                                        
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                        <div class="form_group">
                                        
                                                <label class="form_label">Standing Charges<span>*</span></label>
                                                <input class="form_input number"  name="standing_charge"  id="standing_charge"  type="text" value="@if(isset($form_data['machineryInterruption']['standCharge']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['standCharge'],2)}}@endif">
                                        
                                        </div>
                                </div>
                        
                       
                            <div class="col-md-6">
                                    <div class="form_group">
                                    
                                            <label class="form_label">No of locations<span>*</span></label>
                                            <input class="form_input number"  name="no_location"  id="no_location"  type="text" value="@if(isset($form_data['machineryInterruption']['no_location']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['no_location'],2)}}@endif">
                                    
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form_group">
                                    
                                            <label class="form_label">Increase cost of working<span>*</span></label>
                                            <input class="form_input number"  name="cost_work"  id="cost_work"  type="text" value="@if(isset($form_data['machineryInterruption']['costwork']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['costwork'],2)}}@endif">
                                    
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form_group">
                                    
                                            <label class="form_label">Period of indemnity<span>*</span></label>
                                            <input class="form_input number"  name="indemnity_period"  id="indemnity_period"  type="text" value="@if(isset($form_data['machineryInterruption']['indemnityPeriod']) && @$form_data['machineryInterruption']['bus_inter'] ==true){{number_format($form_data['machineryInterruption']['indemnityPeriod'],2)}}@endif">
                                    
                                    </div>
                            </div>
                        
                        </div>
                </div>
            </div>
                {{-- <div class="row">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form_label">Amount<span>*</span></label>
                                    <textarea class="form_input" id="amount" name="amount" placeholder="Amount">@if(!empty($form_data)) {{$form_data['amount']}} @endif</textarea>
                                </div>
                        </div>
                </div>     --}}
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
                                                <input class="form_input number" name="claim_amount[]" id="claim_amount1" @if(isset($form_data['claimsHistory'][0]['claim_amount'])&&(@$form_data['claimsHistory'][0]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][0]['claim_amount'],2)}}" @else -- @endif>
                                                <label id="claim_amount1-error" class="error" for="claim_amount1" style="display: none">Please enter claim amount.</label>
                                            </td>
                                            <td><input class="form_input" name="description[]" id="description1"value="{{@$form_data['claimsHistory'][0]['description']}}">
                                                <label id="description1-error" class="error" for="description1" style="display: none">Please enter description.</label>
                                            </td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td>Year 2 <input type="hidden" value="Year 2" name="year[]" id="year2"></td>
                                            <td><input class="form_input number" name="claim_amount[]" id="claim_amount2" @if(isset($form_data['claimsHistory'][1]['claim_amount'])&&(@$form_data['claimsHistory'][1]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][1]['claim_amount'],2)}}" @else -- @endif ></td>
                                            <td><input class="form_input" name="description[]" type="text" id="description2" value="{{@$form_data['claimsHistory'][1]['description']}}"></td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td>Year 3<input type="hidden" value="Year 3" name="year[]" id="year3"></td>
                                            <td><input class="form_input number" name="claim_amount[]" id="claim_amount3" @if(isset($form_data['claimsHistory'][2]['claim_amount'])&&(@$form_data['claimsHistory'][2]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][2]['claim_amount'],2)}}" @else -- @endif></td>
                                            <td><input class="form_input" name="description[]" type="text" id="description3" value="{{@$form_data['claimsHistory'][2]['description']}}"></td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="disclaimer">
                            Disclaimer : It is your duty to disclose all material facts to underwriters. A material fact is one that is likely to influence an underwriter’s judgement and acceptance of your proposal. 
                            If your proposal is a renewal, it should also include any change in facts previously advised to underwriters. If you are in any doubt about facts considered materials, disclose them.
                             FAILURE TO DISCLOSE could prejudice your rights to recover in the event of a claim or allow underwriters to void the Policy.
                    </p>
         
@push('scripts')
<script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>
<style>
        /*.section_details{*/
        /*max-width: 100%;*/
        /*}*/
        .bootstrap-datetimepicker-widget table td{
            padding: 0 !important;
            width: auto !important;
        }

    </style>
    
<script>
   $(document).ready(function(){
            setTimeout(function() {
                $('#success_div').fadeOut('fast');
            }, 5000);
            materialKit.initFormExtendedDatetimepickers();

        });
     var count=Number('{{$filecount}}')+1;
        // console.log(count);
      $(".add_field_button").click(function (e) { 
          //on add input button click
        e.preventDefault();
            $('.wrapper').append(
                '<div class="row">'+
                '<div class="col-md-3 ">'+
                '<div class="form_group">'+
                '<label class="form_label">Equipment Name<span>*</span></label>'+
                '<input class="form_input"  name="equipment[]" placeholder="Equipment Name" id="equipment'+count+'"  type="text">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-3 ">'+
                '<div class="form_group">'+
                '<label class="form_label">Company Name<span>*</span></label>'+
                '<input class="form_input"  name="companyname[]" placeholder="Company Name" id="companyname'+count+'"  type="text">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-3 ">'+
                '<div class="form_group table_datepicker" style="margin: 0">'+
                '<label class="form_label">Expiry Date<span>*</span></label>'+
                '<input class="form_input datetimepicker"  name="expirydate[]" placeholder="Expiry Date"  id="expirydate'+count+'"  type="text">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<div class="action_btn margin_set" style="margin-top: 10px;">'+
                '<button type="button" title="Remove"  class="remove_field" style=" margin-top: 27px">'+
                '<i class="material-icons" style="vertical-align:middle">remove</i>'+
                '</button>'+
                '</div>'+
                '</div>'+
                '</div>');
        count++;
        materialKit.initFormExtendedDatetimepickers();

        // componentHandler.upgradeDom();
    });

    $('.wrapper').on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
        $(this).parent().parent().parent('div').remove();
    });
</script>
@endpush