
<div class="col-{{@$config['style']['col_width']?:6}}">
<div class="row">
<div class="{{@$config['label_class']?:'col-12'}}">
<label class="titles">{{@$config['label']}} <span>*</span></label>
</div>
<div class="{{@$config['field_class']?:'col-12'}}">
<div class="form_group" >
        <select class="selectpicker form-control @if(@$config['validation']['required'] == true) required @endif" @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif   data-live-search="true" name="{{@$config['fieldName']}}" id="{{@$config['id']}}" >
            @if(isset($config['hasSelect']) && @$config['hasSelect'])
                <option selected disabled value="">Select</option>
            @endif
            @foreach($config['options'] as $option)
                <option
                    @if (isset($config['optionValue']))
                        @if ($config['optionValue'] == 'value')
                            value="{{@$option['option_value']}}"
                            @if($option['option_value'] == $value || (empty($value) && $option['option_id'] == @$config['defaultValue'] )) selected @endif
                        @else
                            value="{{@$option['option_id']}}"
                            @if($option['option_id'] == $value || (empty($value) && $option['option_id'] == @$config['defaultValue'] )) selected @endif
                        @endif
                    @else
                        value="{{@$option['option_id']}}"
                        @if($option['option_id'] == $value || (empty($value) && $option['option_id'] == @$config['defaultValue'] )) selected @endif
                    @endif >
                        {{ucwords($option['option_value'])}}
                </option>
            @endforeach
        </select>
    </div>
</div>
</div>

</div>
