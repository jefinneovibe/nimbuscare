<div class="col-{{@$config['style']['col_width']?:12}}">
<div class="row">
@if($config['label'])
<div class="{{@$config['label_class']?:'col-12'}}">
<label class="titles" >{{@$config['label']}}@if(@$config['validation']['required'] == true)  <span>*</span> @endif</label>
</div>
@endif
<div class="{{@$config['field_class']?:'col-12'}}">
    <div class="row">
    @foreach($config['children'] as $field)
    @widget($field['widgetType'], ['data' => $field['config'], 'workTypeId'=>@$workTypeId, 'value' => @$value[$field['config']['valueKey']]?:@$value[$field['config']['valueArr']]])
    @endforeach
    </div>
</div>
</div>
</div>
