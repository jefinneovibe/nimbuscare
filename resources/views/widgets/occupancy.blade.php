


<div class="col-{{@$config['style']['col_width']?:12}}">
    <div class="row">
        <div class="{{@$config['label_width']?:'col-12'}}">
        <label class="titles">{{$config['label']}} @if(@$config['validation']['required'] == true)  <span>*</span> @endif</label>
    </div>
        <div class="{{@$config['field_width']?:'col-12'}}">
            <div class="row">
                <div class="{{@$config['select_width']?:'col-6'}}" >
                <div class="form_group" >
                    <select class="selectpicker form-control @if(@$config['validation']['required'] == true) required @endif " @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif  data-live-search="true" name="{{@$config['fieldName']}}[where]" id="{{@$config['id']}}_where" >
                    <option value="">Select</option>
                    <option value="Warehouse" @if(@$value['where'] == 'Warehouse') selected @endif>Warehouse</option>
                    <option value="Factory" @if(@$value['where'] == 'Factory') selected @endif>Factory</option>
                    <option value="Building" @if(@$value['where'] == 'Building') selected @endif>Building</option>
                    <option value="Shop" @if(@$value['where'] == 'Shop') selected @endif>Shop</option>
                    <option value="Showroom" @if(@$value['where'] == 'Showroom') selected @endif>Showroom</option>
                    <option value="Residence" @if(@$value['where'] == 'Residence') selected @endif>Residence</option>
                    <option value="Labour Camp" @if(@$value['where'] == 'Labour Camp') selected @endif>Labour Camp</option>
                    <option value="Office" @if(@$value['where'] == 'Office') selected @endif>Office</option>
                    <option value="Others" @if(@$value['where'] == 'Others') selected @endif>Others</option>
                    </select>
                </div>
                </div>
            <div id="{{@$config['fieldName']}}_children" class="{{@$config['child_width']?:'col-6'}}">
                <div class="form_group" >
                <div id="{{@$config['id']}}_warehouseType_div" style="display:none">
                <select class="selectpicker form-control required "  data-live-search="true" name="{{@$config['fieldName']}}[warehouseType]" id="{{@$config['id']}}_warehouseType" >
                    <option value="">Select warehouse type</option>
                    <option value="Multi shed" @if(@$value['warehouseType'] == "Multi shed") selected @endif>Multi shed</option>
                    <option value="Single warehouse" @if(@$value['warehouseType'] == 'Single warehouse') selected @endif>Single warehouse</option>
                    </select>
                </div>

                <div id="{{$config['id']}}_otherDetails_div" style="display:none">
                <input type="text" class="form-control required" name="{{$config['fieldName']}}[otherDetails]" id="{{$config['id']}}_otherDetails" value="{{@$value['otherDetails']}}" placeholder="Please Specify">

                </div>
                </div>
            </div>
        </div>
        </div>
        </div>


</div>

@push('widgetScripts')
<script>

$(window).load(function(){
    var val =  $("#{{@$config['id']}}_where").val();
    manageOccupancySelect(val);
});


$("#{{@$config['id']}}_where").on('change', function() {
    manageOccupancySelect(this.value);
});

function manageOccupancySelect(value) {
    if(value == 'Warehouse') {
      $("#{{@$config['fieldName']}}_children").show();
      $("#{{$config['id']}}_otherDetails_div").hide();
      $("#{{@$config['id']}}_warehouseType_div").show();
      $("#{{$config['id']}}_otherDetails").val('');
  } else if(value == 'Others') {
    $("#{{@$config['fieldName']}}_children").show();
    $("#{{@$config['id']}}_warehouseType_div").hide();
    $("#{{$config['id']}}_otherDetails_div").show();
    $("#{{@$config['id']}}_warehouseType").val('').trigger('change');
  } else {
    $("#{{@$config['fieldName']}}_children").hide();
    $("#{{@$config['id']}}_warehouseType_div").hide();
    $("#{{$config['id']}}_otherDetails_div").hide();
    $("#{{@$config['id']}}_warehouseType").val('').trigger('change');
    $("#{{$config['id']}}_otherDetails").val('');
  }
}
</script>
@endpush
