<div class="col-{{@$config['style']['col_width']?:6}}">
<div class="row">
<div class="{{@$config['label_class']?:'col-12'}}">
    <label class="titles">{{$config['label']}}
        @if(@$config['validation']['required'] == true)
            <span>*</span>
        @endif
    </label>
</div>
<div class="{{@$config['field_class']?:'col-12'}}">
<div class="form-group">
<textarea @if (@$config['class']) class="@foreach ($config['class'] as $Classkey1 => $className){{$className}} @endforeach form-control" @else class="form-control" @endif class="form-control" @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif  name="{{$config['fieldName']}}" id="{{$config['fieldName']}}" rows="{{@$config['style']['rows']?:3}}" placeholder="{{$config['label']}}">{{@$value}}</textarea>
</div>
</div>
</div>
</div>

