<div class="col-{{@$config['style']['col_width']?:6}}">
<div class="row">
<div class="{{@$config['label_class']?:'col-12'}}">
<label class="titles" >{{@$config['label']}}<span>*</span></label>
</div>

@foreach($config['options'] as $option)
    <div class="col-{{@$option['option_width']?:'col-3'}} custom-control three_rem_width custom-radio mb-3">
        <input name="{{@$config['fieldName']}}[location]" class="custom-control-input {{@$option['option_class']}}" value="{{@$option['option_id']}}" id="{{@$option['option_id']}}"  type="radio" @if($option['option_id'] == @$value['location']) checked="" @endif>
        <label class="custom-control-label" for="{{@$option['option_id']}}">{{$option['option_value']}}</label>
    </div>
    @endforeach
    <div class="{{@$config['field_class']?:'col-12'}}">
        @if (@$config['aed'])
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">AED</span>
                </div>
                <input type="text" class="form-control aed  {{@$config['textfieldClass']}}" name="{{$config['fieldName']}}[detail]" id="{{$config['textfieldId']}}" value="{{@$value['detail']}}" placeholder="{{$config['textBoxLabel']}}">

            </div>
        @else
            <input type="text" class="form-control  {{@$config['textfieldClass']}}" name="{{$config['fieldName']}}[detail]" id="{{$config['textfieldId']}}" value="{{@$value['detail']}}" placeholder="{{$config['textBoxLabel']}}">
        @endif
    </div>
</div>
</div>
@push('widgetScripts')
<script>
$(window).load(function() {

        //Add validations to parent form
        var form = $('.custom-radio').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['fieldName']}}':{
                    required: true
                 }
            }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['fieldName']}}': "Please select one"
                }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;
    });
    </script>
@endpush
