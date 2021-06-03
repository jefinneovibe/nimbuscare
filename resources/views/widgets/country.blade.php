


<div class="col-{{@$config['style']['col_width']?:3}}">
   <div class="row">
   <div class="{{@$config['label_class']?:'col-12'}}">
   <label class="titles" style="width:100%;">Country<span>*</span></label>
   </div>
   <div class="{{@$config['field_class']?:'col-12'}}">
   <div class="form_group custom_dp" style="width:100% !important; @if(@$config['elem_width']) max-width: {{@$config['elem_width']}}@endif" >
        <select  class="selectpicker form-control" onchange="getEmirates(this)" data-live-search="true" name="country" id="country" >
        <option value="">Select</option>
        @foreach(@$country_name as $country)
        <option @if($country == $value) selected @endif value="{{$country}}">{{$country}}</option>
        @endforeach
        </select>
    </div>
   </div>
   </div>
</div>

