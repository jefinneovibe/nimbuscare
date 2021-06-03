

<div class="col-{{@$config['style']['col_width']?:3}}">
    <div class="form_group custom_dp" >
        <label class="titles">{{@$config['label']}} @if(@$config['validation']['required'] == true)<span>*ddd</span> @endif </label>
        <select class="selectpicker form-control" data-live-search="true" name="{{@$config['fieldName']}}" id="{{@$config['fieldName']}}" >
            <option selected value="" name="">Select  Insurer</option>
            @if(!empty(@$insurerArr))
                @foreach(@$insurerArr as $insurer)
                    <option @if($value == $insurer['name'] ) selected @endif value="{{$insurer['name']}}">{{$insurer['name']}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

@push('widgetScripts')
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>


@endpush
