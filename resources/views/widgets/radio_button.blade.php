<div class="col-{{@$config['style']['col_width']?:6}}">
    <div class="row">
    <div class="col-{{@$config['label_width']?:12}}">
    <label class="titles" >{{@$config['label']}}
        @if(@$config['validation']['required'] == true)
            <span>*</span>
        @endif
    </label>
    </div>
    @foreach($config['options'] as $option)
    <div class="col-{{@$option['option_width']?:12}} custom-control custom-radio three_rem_width mb-3">
        <input name="{{@$config['fieldName']}}" class="custom-control-input" value="{{@$option['option_id']}}" id="{{@$option['option_id']}}"  type="radio" @if(@$value) @if($option['option_id'] == @$value ) checked="" @endif @elseif(isset($option['default'])) checked="" @endif>
        <label class="custom-control-label" for="{{@$option['option_id']}}">{{$option['option_value']}}</label>
    </div>
    @endforeach
    </div>
</div>   
@if(isset($config['validation']) && !empty($config['validation']))
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
@endif
