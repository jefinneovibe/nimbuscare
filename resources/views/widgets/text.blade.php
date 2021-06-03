<div class="col-{{@$config['style']['col_width']?:6}}">
    <div class="row">
        @if($config['label'])
            <div class="{{@$config['label_class']?:'col-12'}}">
                <label class="titles">
                    @if (isset($config['preCustomerLabel']) && @$config['preCustomerLabel'] != '' && Request::is('eslip/*'))
                        {{@$config['preCustomerLabel']}}
                    @else
                        {{$config['label']}}
                    @endif
                    @if(@$config['validation']['required'] == true)
                        <span>*</span>
                    @endif
                </label>
            </div>
        @endif
        <div class="{{@$config['field_class']?:'col-12'}}">
            <div class="form-group">
                @if (@$config['aed'] || @$config['datepicker'])
                    <div  @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif class="input-group">
                        @if(isset($config['aed']))
                            <div class="input-group-prepend">
                                <span class="input-group-text">AED</span>
                            </div>
                        @elseif(isset($config['datepicker']))
                            <div class="input-group-append" >
                                <span onclick="$('#{{@$config[id]}}').trigger('focus')" class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                        @endif
                        @if(is_array($value))
                            @foreach($value as $val)
                                <input
                                type="text"
                                @if (@$config['class'])
                                    class=" @foreach ($config['class'] as $Classkey1 => $className) {{ $className }} @endforeach  @if(isset($config['aed'])) aed @endif form-control"
                                @else
                                    class=" @if(isset($config['aed'])) aed @endif  form-control"
                                @endif
                                name="{{$config['fieldName']}}" id="{{$config['id']}}"
                                @if (isset($val) && $val != '')
                                    value="{{@$val}}"
                                @elseif(isset($config['value']))
                                    <?php @eval("\$str = \"{$config['value']}\";"); ?>
                                    value="{{@$str}}"
                                @elseif(isset($config['defaultValue']) && $config['defaultValue'] != '')
                                    value="{{@$config['defaultValue']}}"
                                @endif
                                @if (@$config['events'])
                                    @foreach ($config['events'] as $key => $event)
                                        @foreach ($event as $eventKey => $eventItem)
                                            {{@$eventKey}} {{"="}} {{@$eventItem}}
                                        @endforeach
                                    @endforeach
                                @endif
                                placeholder="{{$config['placeHolder']}}">
                            @endforeach
                        @else
                            <input
                                @if (@$config['class'])
                                    class=" @foreach ($config['class'] as $Classkey1 => $className) {{ $className }} @endforeach @if(isset($config['aed'])) aed @endif  form-control"
                                @else
                                    class=" @if(isset($config['aed'])) aed @endif  form-control"
                                @endif
                            type="text"   name="{{$config['fieldName']}}" id="{{$config['id']}}"
                                @if (@$config['events'])
                                    @foreach ($config['events'] as $key => $event)
                                        @foreach ($event as $eventKey => $eventItem)
                                            {{@$eventKey}} {{"="}} {{@$eventItem}}
                                        @endforeach
                                    @endforeach
                                @endif
                            @if (isset($value) && $value != '' && !isset($config['value']))
                                value="{{@$value}}"
                            @elseif(isset($config['value']))
                                <?php  @eval("\$str = \"{$config['value']}\";"); ?>
                                value="{{@$str}}"
                            @elseif(isset($config['defaultValue']) && $config['defaultValue'] != '')
                                value="{{@$config['defaultValue']}}"
                            @endif
                            placeholder="{{$config['placeHolder']}}">
                        @endif
                    </div>
                @else
                    @if(is_array($value))
                        @foreach($value as $val)
                                <input
                                @if (@$config['events'])
                                    @foreach ($config['events'] as $key => $event)
                                        @foreach ($event as $eventKey => $eventItem)
                                            {{@$eventKey}} {{"="}} {{@$eventItem}}
                                        @endforeach
                                    @endforeach
                                @endif
                            type="text"
                            @if (@$config['class'])
                                class=" @foreach ($config['class'] as $Classkey1 => $className) {{ $className }} @endforeach form-control"
                            @else
                                class="form-control"
                            @endif
                            @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif
                            name="{{$config['fieldName']}}" id="{{$config['id']}}"
                            @if (isset($val) && $val != '')
                                value="{{@$val}}"
                            @elseif(isset($config['value']))
                                <?php @eval("\$str = \"{$config['value']}\";"); ?>
                                value="{{@$str}}"
                            @elseif(isset($config['defaultValue']) && $config['defaultValue'] != '')
                                value="{{@$config['defaultValue']}}"
                            @endif placeholder="{{$config['placeHolder']}}">
                        @endforeach
                    @else
                        <input
                        type="text"
                        @if (@$config['class'])
                            class=" @foreach ($config['class'] as $Classkey1 => $className) {{ $className }} @endforeach form-control"
                        @else
                            class="form-control"
                        @endif
                        @if (@$config['events'])
                            @foreach ($config['events'] as $key => $event)
                                @foreach ($event as $eventKey => $eventItem)
                                    {{@$eventKey}} {{"="}} {{@$eventItem}}
                                @endforeach
                            @endforeach
                        @endif
                        name="{{$config['fieldName']}}" @if(@$config['elem_width']) style="max-width: {{@$config['elem_width']}}" @endif id="{{$config['id']}}"
                        @if (isset($value) && $value != '')
                            value="{{@$value}}"
                        @elseif(isset($config['value']))
                            <?php @eval("\$str = \"{$config['value']}\";"); ?>
                            value="{{@$str}}"
                        @elseif(isset($config['defaultValue']) && $config['defaultValue'] != '')
                            value="{{@$config['defaultValue']}}"
                        @elseif (isset($value) && $value == 0)
                            value="{{@$value}}"
                        @endif
                        placeholder="{{$config['placeHolder']}}">
                    @endif
                @endif

            </div>
        </div>
    </div>

</div>

@push('scripts')

@endpush
