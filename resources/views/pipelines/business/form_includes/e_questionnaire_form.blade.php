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
                <select  class="selectpicker" data-hide-disabled="true" data-live-search="true"   id="country1" name="country" onChange="getState('country1','state1');" required>
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
    <div class="col-md-12">
        <div class="form_group">
            <label class="form_label">Name of the Company  <span>*</span></label>
            <input class="form_input" name="company_name" id="company_name" placeholder="Name of the Company" type="text" @if(!empty($form_data)) value="{{$form_data['companyName']}}" @endif>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <label class="form_label bold">No of locations <span>*</span></label>
        </div>
        <div class="col-md-6">
            <div class="form_group">
                <input class="form_input" placeholder="No of locations" name="no_of_locations" id="no_of_locations" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="{{@$form_data['risk']}}">
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form_group">
                <input class="form_input" placeholder="Locations of the Risk" name="locations_risk" id="locations_risk" 
                type="text" value="{{@$form_data['risk']['locationRisk']}}">
            </div>
        </div> --}}
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
                <label class="form_label">Actual Annual Gross Profit for the previous year (AED)  <span>*</span></label>
            {{-- <input class="form_input number" name="actual_profit" id="business_yes1" placeholder="Actual Annual Gross Profit for the previous year (AED)"> --}}
            <input class="form_input number" name="actual_profit" id="business_yes1" placeholder="Actual Annual Gross Profit for the previous year (AED)" 
            @if(@$form_data['businessInterruption']['actualProfit']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['actualProfit']),2)}}" @endif>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form_group">
                <label class="form_label">Estimated Annual Gross Profit for the next year (AED)  <span>*</span></label>
            {{-- <input class="form_input number" name="estimated_profit" id="estimated_profit" placeholder="Estimated Annual Gross Profit for the next year (AED)"> --}}
            <input class="form_input number" name="estimated_profit" id="estimated_profit" placeholder="Estimated Annual Gross Profit for the next year (AED)" 
            @if(@$form_data['businessInterruption']['estimatedProfit']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['estimatedProfit']),2)}}" @endif>
        </div>
    </div>
    
</div>
<div class="row">
        <div class="col-md-6">
                <div class="form_group">
                        <label class="form_label" style="height:40px;width:615px;">Standing Charges  <span>*</span></label>
                        <input class="form_input number" name="stand_charge" id="stand_charge" placeholder="Standing Charges"
                        @if(@$form_data['businessInterruption']['standCharge']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['standCharge']),2)}}" @endif>
                </div>
        </div>
        <div class="col-md-6">
                <div class="form_group">
                        <label class="form_label">Period of indemnity (This should correspond to the expected period the business interruption will continue)  <span>*</span></label>
                    <input class="form_input number" name="indemnity_period" id="indemnity_period" placeholder="Period of indemnity (This should correspond to the expected period the business interruption will continue)" type="text" 
                    @if(@$form_data['businessInterruption']['indemnityPeriod']!='')  value="{{(@$form_data['businessInterruption']['indemnityPeriod'])}}" @endif>
                </div>
            </div>
</div>
<div class="row">
        <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label">Loss of Rent  <span>*</span></label>
                    <input class="form_input number" name="rent_loss" id="rent_loss" placeholder="Loss of Rent" 
                    @if(@$form_data['businessInterruption']['rentLoss']!='')  value="{{number_format(trim(@$form_data['businessInterruption']['rentLoss']),2)}}" @endif>
                </div>
            </div>
                <div class="col-md-4">
                    <div class="form_group">
                            <label class="form_label">Name of the main customers  <span>*</span></label>
                        <input class="form_input" name="main_cust_name" id="main_cust_name" placeholder="Name of the main customers" type="text" 
                        @if(!empty($form_data['businessInterruption']['mainCustName'])) value="{{$form_data['businessInterruption']['mainCustName']}}" @endif >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form_group">
                            <label class="form_label">Name of the main Suppliers  <span>*</span></label>
                        <input class="form_input" name="main_supp_name" id="business_yes8" placeholder="Name of the main Suppliers" type="text" 
                        @if(!empty($form_data['businessInterruption']['mainSuppName'])) value="{{$form_data['businessInterruption']['mainSuppName']}}" @endif>
                    </div>
                </div>
                
</div> 

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
                            <input class="form_input number" name="claim_amount[]" id="claim_amount1" @if(isset($form_data['claimsHistory'][0]['claim_amount'])&&(@$form_data['claimsHistory'][0]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][0]['claim_amount'],2)}}" @endif>
                            <label id="claim_amount1-error" class="error" for="claim_amount1" style="display: none">Please enter claim amount.</label>
                        </td>
                        <td><input class="form_input" name="description[]" id="description1"value="{{@$form_data['claimsHistory'][0]['description']}}">
                            <label id="description1-error" class="error" for="description1" style="display: none">Please enter description.</label>
                        </td>
                        
                    </tr>
                    
                    <tr>
                        <td>Year 2 <input type="hidden" value="Year 2" name="year[]" id="year2"></td>
                        <td><input class="form_input number" name="claim_amount[]" id="claim_amount2" @if(isset($form_data['claimsHistory'][1]['claim_amount'])&&(@$form_data['claimsHistory'][1]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][1]['claim_amount'],2)}}" @endif ></td>
                        <td><input class="form_input" name="description[]" type="text" id="description2" value="{{@$form_data['claimsHistory'][1]['description']}}"></td>
                        
                    </tr>
                    
                    <tr>
                        <td>Year 3<input type="hidden" value="Year 3" name="year[]" id="year3"></td>
                        <td><input class="form_input number" name="claim_amount[]" id="claim_amount3" @if(isset($form_data['claimsHistory'][2]['claim_amount'])&&(@$form_data['claimsHistory'][2]['claim_amount'])!="") value="{{number_format(@$form_data['claimsHistory'][2]['claim_amount'],2)}}" @endif></td>
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

{{-- @push('scripts') --}}
{{-- <script>
     var count=Number('{{$filecount}}')+1;
        console.log(count);
      $(".add_field_button").click(function (e) { //on add input button click
        e.preventDefault();
            $('.wrapper').append(
                '<div class="row">'+
                '<div class="col-md-6 ">'+
                '<div class="form_group">'+
                '<label class="form_label">Description of the safe per location<span>*</span></label>'+
                '<input class="form_input"  name="safe_per_location[]"  id="safe_per_location'+count+'"  type="text">'+
                '</div>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<div class="action_btn margin_set" style="margin-top: 10px;">'+
                '<button type="button" title="Remove"  class="remove_field" >'+
                '<i class="material-icons">remove</i>'+
                '</button>'+
                '</div>'+
                '</div>'+
                '</div>');
        count++;
        // componentHandler.upgradeDom();
    });

    $('.wrapper').on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
        $(this).parent().parent().parent('div').remove();
    });
</script>
@endpush --}}