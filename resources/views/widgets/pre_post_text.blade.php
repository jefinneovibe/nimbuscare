<div class="col-{{@$config['style']['col_width']?:6}}">
    <div class="row">
        @if($config['label'])
            <div class="{{@$config['label_class']?:'col-12'}}">
                <label class="titles">{{$config['label']}} @if(@$config['validation']['required'] == true)  <span>*</span> @endif</label>
            </div>
        @endif
        <div class="{{@$config['field_class']?:'col-12'}}">
            <div class="form-group">
                @if(isset($config['preText']))
                    <label class="titles  @if (@$config['pre_label_class']){{$config['pre_label_class']}}@endif" style="margin-right:10px ;display: inline-block;">{{@$config['preText']}}</label>
                @endif
                    <input type="text" style="display: inline-block;" data-field-label="prePostLabel"
                    @if (@$config['class'])
                        class="@foreach ($config['class'] as $Classkey1 => $className){{$className}} @endforeach form-control col-{{@$config['style']['elem_width']?:6}}"
                    @else
                        class="form-control col-{{@$config['style']['elem_width']?:6}}"
                    @endif
                        name="{{$config['fieldName']}}" id="{{$config['id']}}" value="{{@$value}}" placeholder="{{$config['placeHolder']}}">
                @if(isset($config['postText']))
                    <label class="titles  @if (@$config['post_label_class']){{$config['post_label_class']}}@endif" style="margin-left:10px ;display: inline-block;">{{@$config['postText']}}</label>
                @endif
            </div>
        </div>
    </div>
</div>

