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
                <input class="form_input" name="firstName" id="firstName" placeholder="First Name" type="text" @if(!empty($form_data)) value="{{@$form_data['firstName']}}" @else value="{{@$PipelineItems['customer']['firstName']}}" @endif>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Enter Middle Name <span style="visibility: hidden">*</span></label>
                <input class="form_input" name="middleName" id="middleName" placeholder="Middle Name" type="text" @if(!empty($form_data)) value="{{@$form_data['middleName']}}" @else  value="{{@$PipelineItems['customer']['middleName']}}" @endif>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form_group">
                <label class="form_label">Enter Last Name <span>*</span></label>
                <input class="form_input" name="lastName" id="lastName" placeholder="Last Name" type="text" @if(!empty($form_data)) value="{{@$form_data['lastName']}}" @else  value="{{@$PipelineItems['customer']['lastName']}}" @endif>
            </div>
        </div>
    </div>
@else
    <div class="row" id="corporate_type">
        <div class="col-md-12">
            <div class="form_group">
                <label class="form_label">Name of the Insured  <span>*</span></label>
                <input class="form_input" name="firstName" id="firstName" placeholder="First Name" type="text" @if(!empty($form_data)) value="{{@$form_data['firstName']}}" @else  value="{{@$PipelineItems['customer']['name']}}" @endif>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="form_group">
            <label class="form_label">If there is any subsidiary/affliated company  <span>*</span></label> 
            <input class="form_input" name="aff_company" id="aff_company" placeholder="If there is any subsidiary/affliated company" type="text" @if(!empty($form_data)) value="{{@$form_data['affCompany']}}"  @endif>
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
            <input class="form_input" name="addressLine1"  id="addressLine1" placeholder="Street Line 1" type="text"  @if(!empty($form_data)) value="{{ucwords(@$form_data['addressDetails']['addressLine1'])}}" @else value="{{ucwords(@$PipelineItems->getCustomer->addressLine1)}}" @endif>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form_group">
            <input class="form_input" name="addressLine2" id="addressLine2" placeholder="Street Line 2" type="text" @if(!empty($form_data)) value="{{ucwords(@$form_data['addressDetails']['addressLine2'])}}" @else value="{{ucwords(@$PipelineItems->getCustomer->addressLine2)}}" @endif>
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

<div class="row">
    <div class="col-md-12">
        <div class="form_group">
            <label class="form_label bold">Do you need the policy to be assigned to a bank<span>*</span></label>
            <div class="custom_select">
                <select class="form_input" id="policy_bank" name="policy_bank" onchange="validation(this.id)">
                    <option value="" selected>Select</option>            
                    <option value="yes"  @if(isset($form_data['policyBank']['policyBank']) && @$form_data['policyBank']['policyBank'] ==true) selected @endif>Yes</option>
                    <option value="no"  @if(isset($form_data['policyBank']['policyBank']) && @$form_data['policyBank']['policyBank'] ==false) selected @endif>No</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="policyBank_yes"  @if(@$form_data['policyBank']['policyBank'] ==true) style="display:block" @else style="display:none" @endif>
    <div class="row">
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Bank Name  <span>*</span></label>
                <input class="form_input" name="bankname" id="bankname" placeholder="Bank Name" 
                @if(@$form_data['policyBank']['bankname']!='')  value="{{@$form_data['policyBank']['bankname']}}" @endif>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Telephone Number  <span>*</span></label>
                <input class="form_input" name="telnumber" id="telnumber" placeholder="Telephone Number" 
                @if(@$form_data['policyBank']['telnumber']!='')  value="{{@$form_data['policyBank']['telnumber']}}" @endif>
            </div>
        </div>
        <div class="col-md-4">
                <div class="form_group">
                        <label class="form_label form_text">Fax Number <span>*</span></label>
                    <input class="form_input" name="fax" id="fax" placeholder="Fax Number"
                    @if(@$form_data['policyBank']['fax']!='') value="{{@$form_data['policyBank']['fax']}}" @endif>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">PO Box  <span>*</span></label>
                <input class="form_input " name="pobox" id="pobox" placeholder="PO Box" 
                    value="{{@$form_data['policyBank']['pobox']}}" >
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Location <span>*</span></label>
                <input class="form_input" name="location" id="location" placeholder="Location"
                @if(@$form_data['policyBank']['location']!='')  value="{{@$form_data['policyBank']['location']}}" @endif>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Contact Person <span>*</span></label>
                <input class="form_input " name="contact" id="contact" placeholder="Contact Person"
                @if(@$form_data['policyBank']['contact']!='')   value="{{@$form_data['policyBank']['contact']}}" @endif>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text" >Related Department Inside The Bank  <span>*</span></label>
                <input class="form_input" name="dept_bank" id="dept_bank" placeholder="Related Department Inside The Bank" 
                type="text" value="{{@$form_data['policyBank']['deptBank']}}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text" >Email  <span>*</span></label>
                <input class="form_input" name="email" id="email" placeholder="Email"
                    type="text" value="{{@$form_data['policyBank']['email']}}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Mobile Number <span>*</span></label>
                <input class="form_input" name="mobile" id="mobile"
                    placeholder="Mobile Number" 
                    type="text"   @if(isset($form_data['policyBank']['mobile']) && @$form_data['policyBank']['mobile']!='') value="{{@$form_data['policyBank']['mobile']}}" @endif>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="form_group">
                    <label class="form_label form_text">Amount to be assigned </label>
                <input class="form_input" name="amount" id="amount"
                    placeholder="Amount to be assigned "
                    type="text"   @if(isset($form_data['policyBank']['amount']) && @$form_data['policyBank']['amount']!='') value="{{number_format(trim(@$form_data['policyBank']['amount']),2)}}" @endif>
            </div>
        </div> --}}
    </div> 
</div>

<?php $placeOfEmployment = @$form_data['placeOfEmployment'] ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form_group">
                    <label class="form_label bold">Geographical Area <span>*</span></label>

                    <div class="custom_select">
                        <select class="form_input" name="withinUAE" id="option_select3">
                            <option value="" selected>Select place</option>
                            @if(!empty($placeOfEmployment))
                                <option value="WithinUAE" @if(isset($placeOfEmployment['withinUAE'])&& $placeOfEmployment['withinUAE']== true) selected @endif>Within UAE</option>
                                <option value="OutsideUAE" @if(isset($placeOfEmployment['withinUAE']) &&$placeOfEmployment['withinUAE']== false) selected @endif>Outside UAE</option>
                            @else
                                <option value="WithinUAE">Within UAE</option>
                                <option value="OutsideUAE">Outside UAE</option>
                            @endif
                        </select>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row" id="WithinUAE" style="display: none">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label bold">Select Emirate <span>*</span></label>
                            <div class="custom_select">
                                <select name="emirateName" class="selectpicker" data-hide-disabled="true" data-live-search="true" onchange="placeValidation(this)">
                                    <option value="">Select emirate</option>
                                    @foreach($all_emirates as $emirates)
                                        <option value="{{$emirates->name}}" @if(@$placeOfEmployment['emirateName']==$emirates->name) selected @endif>{{$emirates->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="OutsideUAE" style="display: none">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label bold">Select Country <span>*</span></label>
                            <div class="custom_select placeCountry">
                                <select class="selectpicker" data-hide-disabled="true" data-live-search="true" id="countryName" name="countryName" onchange="placeValidation(this)">
                                    <option value="">Select country</option>
                                    @foreach(@$country_name as $country)
                                        <option value="{{$country}}" @if(@$placeOfEmployment['countryName']==$country) selected @endif>{{$country}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="row">
        <div class="col-md-4">
            <div class="form_group">
                <label class="form_label bold">Is there any Machinary or equipmentis being hired <span>*</span></label>
                <div class="custom_select">
                    <select class="form_input" id="option_select4" name="mach_equip">
                        <option selected value="">Select Category</option>
                        <option value="yes" @if(isset($form_data['machEquip']['machEquip']) && ($form_data['machEquip']['machEquip'] == true)) selected @endif>Yes</option>
                        <option value="no" @if(isset($form_data['machEquip']['machEquip']) && ($form_data['machEquip']['machEquip'] == false)) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="machEquip_yes" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        <label class="form_label bold">Give the details<span>*</span></label>
                        <div class="custom_select">
                            <input class="form_input" name="details" @if(!empty($form_data['machEquip'])) value="{{@$form_data['machEquip']['details']}}" @endif>
                        </div>
                    </div>
                </div>
            </div>
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
<label class="form_label" style="color:  #434C5E;text-transform:  none;font-size: 16px;margin: 0 0 24px 0px;font-weight: 600;">Please attach the following mandatory documents</label>

{{-- file upload --}}
<div class="row">
    <div class="col-md-4">
        <div class="form_group">
                @if(in_array('TAX REGISTRATION DOCUMENT',$file_name))
                <?php $key = array_search('TAX REGISTRATION DOCUMENT', $file_name) ?>
                @if($file_url[$key]!='')
                    <input type="hidden" value="{{$file_url[$key]}}" id="tax_url" name="tax_url">
                    <span class="pull-right" id="saved_tax_url">
                    <a target="_blank" href="{{$file_url[$key]}}">
                        <i class="fa fa-file"></i>
                    </a>
                </span>
                @endif
                </span>
                @endif
            <label class="form_label">Tax registration document <span>*</span></label>
            <div class="custom_upload">
                <input type="file" name="tax_certificate" id="tax_certificate" onchange="upload_file(this)">
                <p id="tax_p">Drag your files or click here.</p>
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
                <label class="form_label">Copy of trade license <span>*</span></label>
            <div class="custom_upload">
                <input type="file" name="trade_list" id="trade_list" onchange="upload_file(this)">
                <p id="trade_list_p">Drag your files or click here.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form_group">
                @if(in_array('LIST OF EMPLOYEES',$file_name))
                <?php $key = array_search('LIST OF EMPLOYEES', $file_name) ?>
                @if($file_url[$key]!='')
                    <input type="hidden" value="{{$file_url[$key]}}" id="emp_url" name="emp_url">
                    <span class="pull-right" id="saved_emp_list">
                    <a target="_blank" href="{{$file_url[$key]}}">
                        <i class="fa fa-file"></i>
                    </a>
                </span>
                @endif
                </span>
                @endif
                        <label class="form_label">List of employees <span>*</span></label>
            <div class="custom_upload">
                <input type="file" name="employee_upload" id="employee_upload" onchange="upload_file(this)">
                <p id="employee_upload_p">Drag your files or click here.</p>
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
                        <label class="form_label">Others 1 <span>*</span></label>
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
                        <label class="form_label">Others 2 <span>*</span></label>
            <div class="custom_upload">
                <input type="file" name="others2" id="others2" onchange="upload_file(this)">
                <p id="others2_p">Drag your files or click here.</p>
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
                <label class="form_label">Copy of the policy if possible<span style="visibility:hidden">*</span></label>
            <div class="custom_upload">
                <input type="file" name="policyCopy" id="policyCopy" onchange="upload_file(this)">
                <p id="policy_p">Drag your files or click here.</p>
            </div>
        </div>
    </div>
</div>
{{-- file upload --}}
<div class="row">
    <div class="col-md-4">
        <div class="form_group">
            <label class="form_label bold">Download Excel<span>*</span></label>
            <div>
                    <a target="_blank" href="{{url('contractor-plant/download-excel')}}"><i class="material-icons">cloud_download</i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
            <div class="form_group">
                    @if(in_array('EXCEL',$file_name))
                    <?php $key = array_search('EXCEL', $file_name) ?>
                    @if($file_url[$key]!='')
                        <input type="hidden" value="{{$file_url[$key]}}" id="excel_url" name="excel_url">
                        <span class="pull-right" id="saved_excel_list">
                        <a target="_blank" href="{{$file_url[$key]}}">
                            <i class="fa fa-file"></i>
                        </a>
                    </span>
                    @endif
                    </span>
                    @endif
                    <label class="form_label">Upload Excel<span>*</span></label>
                <div class="custom_upload">
                    <input type="file" name="excelCopy" id="excelCopy" onchange="upload_file(this)">
                    <p id="excelCopy_p">Drag your files or click here.</p>
                </div>
            </div>
        </div>
</div>

<p class="disclaimer">
    Disclaimer : It is your duty to disclose all material facts to underwriters. A material fact is one that is likely to influence an underwriter’s judgement and acceptance of your proposal. 
    If your proposal is a renewal, it should also include any change in facts previously advised to underwriters. If you are in any doubt about facts considered materials, disclose them.
    FAILURE TO DISCLOSE could prejudice your rights to recover in the event of a claim or allow underwriters to void the Policy.
</p>