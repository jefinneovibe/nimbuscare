<div class="col-{{@$config['style']['col_width']?:3}}">

<div class="row">
<div class="{{@$config['label_class']?:'col-12'}}">
@if(@$config['label'])
<label class="titles" style="width:100%;">{{@$config['label']}}<span>*</span></label>
@else
<label class="titles" style="width:100%;">Emirate<span>*</span></label>
@endif
</div>
<div class="{{@$config['field_class']?:'col-12'}}">
<div class="form_group custom_dp" style="width:100% !important;" >
<input type="hidden" value="{{@$value}}" id="hidden_selected_state">
        <select class="selectpicker form-control" data-live-search="true" name="{{@$config['fieldName']?:'emirate'}}" id="{{@$config['id']?:'emirate'}}" @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif >
        <option value="">Select</option>
        @foreach(@$emirates as $emirate)
        <option @if($emirate->name == $value) selected @endif value="{{$emirate->name}}">{{$emirate->name}}</option>
        @endforeach
        @if(isset($config['outsideRequired']) && $config['outsideRequired'])
        <option @if($value =='Outside UAE') selected @endif value="Outside UAE">Outside UAE</option>
        @endif
        </select>
    </div>
</div>

</div>


</div>
