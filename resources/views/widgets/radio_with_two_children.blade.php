   <?php $field_id = str_replace('[', '_', @$config['data']['fieldName']);
   $field_id = str_replace(']', '', $field_id);
    ?>
<div class="col-{{@$config['data']['style']['col_width']?:12}}">
    <div class="row">
        <div class="{{@$config['data']['label_width']?:'col-12'}}">
            <label><b class="titles">{{@$config['data']['label']}} @if (!isset($config['data']['removeValidation'])) <span>*</span> @endif</b></label>
        </div>
        @foreach(@$config['data']['options'] as $key => $option)
        <div class="col-{{@$option['option_width']?:12}} custom-control three_rem_width custom-radio mb-3">
                <input name="{{@$config['data']['id']}}" @if(@$value)@if(@$value[@$config['data']['valueKey']] == @$option['option_value']) checked="checked" @endif @elseif(isset($option['default'])) checked="checked"@endif value="{{@$option['option_value']}}" class="custom-control-input {{@$field_id}}_optionsEach" id="{{@$option['option_id']}}" type="radio">
                <label class="custom-control-label optionsEach" for="{{@$option['option_id']}}">{{@$option['option_value']}}</label>
        </div>
        @endforeach  
        <div class="{{@$config['data']['field_width']?:'col-12'}}">
            <div class="row" id="{{@$field_id}}" style="display:none">
            @foreach(@$config['data']['children'] as $key => $field)
                @widget($field['widgetType'], ['data' => $field['config'],'step'=>@$step,'workTypeDataId'=>@$workTypeDataId,'formValues'=> @$formValues,'workTypeId'=> @$workTypeId, 'value' => @$value[$field['config']['valueKey']]?:@$value[$field['config']['valueArr']]])
            @endforeach
            </div>
        </div>
        @if (@$config['data']['idToShowChildrenNo'])
            <div class="{{@$config['data']['field_width']?:'col-12'}}">
                <div class="row" id="{{@$field_id}}1" style="display:none">
                    @foreach(@$config['data']['children1'] as $key => $field)
                        @widget($field['widgetType'], ['data' => $field['config'], 'workTypeId'=> @$workTypeId,'value' => @$value[$field['config']['valueKey']]?:@$value[$field['config']['valueArr']]])
                    @endforeach
                </div>
            </div>
        @endif
        
         
    </div>
</div>
    @push('widgetScripts')
    @if (!isset($config['data']['removeValidation']))
    <script>
    $(window).load(function(){
            //Add validations to parent form
            var form = $('#{{@$field_id}}').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['data']['id']}}':{
                    required: true
                 }
                }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['data']['id']}}': "Please select one"
                }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;

      });
      </script>
      @endif


<script>
    $(window).load(function(){
        if ($("#{{@$config['data']['idToShowChildren']}}").prop('checked')==true) {
            $("#{{@$field_id}}").show();
        } else {
            $("#{{@$field_id}}").hide();
        }
          if ($("#{{@$config['data']['idToShowChildrenNo']}}").prop('checked')==true) {
            $("#{{@$field_id}}1").show();
            
        } else {
            $("#{{@$field_id}}1").hide();
        }
     });

    $(".{{@$field_id}}_optionsEach").click(function(){
        if ($("#{{@$config['data']['idToShowChildren']}}").prop('checked')==true) {
            $("#{{@$field_id}}").removeClass('hiddenn').addClass('shownn').show(); 
            $("#{{@$field_id}}1").removeClass('shownn').addClass('hiddenn').hide();
               $("#{{@$field_id}}1 input[type='radio']").prop('checked', false);
            $("#{{@$field_id}}1 select").val('').trigger('change');           
            //AddRules("{{@$field_id}}");
        } else if ($("#{{@$config['data']['idToShowChildrenNo']}}").prop('checked')==true) {
            $("#{{@$field_id}}1").removeClass('hiddenn').addClass('shownn').show();  
            $("#{{@$field_id}}").removeClass('shownn').addClass('hiddenn').hide();
            // $("#{{@$field_id}} FormMultiplier,#{{@$field_id}} text").val('');
            $("#tpDetails").val('');
              $("#{{@$field_id}} input[type='radio']").prop('checked', false);
            $("#{{@$field_id}} select").val('').trigger('change');   
             $('#{{@$field_id}} .remove_on').parent().parent().remove();         
            //AddRules("{{@$field_id}}");
        }else {
            console.log()
            $("#{{@$field_id}}").removeClass('shownn').addClass('hiddenn').hide();
            $("#{{@$field_id}} input, #{{@$field_id}} textarea").val('');
            $("#{{@$field_id}} input[type='radio']").prop('checked', false);
            $("#{{@$field_id}} select").val('').trigger('change');
            //for multiplier
            $('#{{@$field_id}} .remove_on').parent().parent().remove();
            //removeRules("{{@$field_id}}");
            
        }

    });

        /**
    function to add validations
     */
    function AddRules(id) {
        if($("#"+id).hasClass('shownn')){
    @if(!empty($config['data']['validations']))
    @foreach($config['data']['validations'] as $field)
    @if(!empty($field['validation']))
    var fieldName = '{{@$field['field']}}';
    @foreach($field['validation'] as $validator => $value)
    var val = '{{$value}}';
    var validationValue = '';
    if(val.length < 3 && parseInt(val, 10) !='NaN'){
        val = parseInt(val, 10);
    }
    $("#"+fieldName).rules("add", {
        {{$validator}} : val
    });
    @endforeach
    @endif
    @if(!empty($field['messages']))
    @foreach($field['messages'] as $validator => $message)
    $("#"+fieldName).rules("add", {
        messages: {
            {{$validator}} : '{{$message}}'
        }
    });
    @endforeach
    @endif
    @endforeach
    @endif
        }

    }

      function removeRules(id) {
        @if(!empty($config['data']['validations']))
    @foreach($config['data']['validations'] as $field)
    @if(!empty($field['validation']))
    var fieldName = '{{@$field['field']}}';
    @foreach($field['validation'] as $validator => $value)
    var val = '{{$value}}';
    var validationValue = '';
    if(val.length < 3 && parseInt(val, 10) !='NaN'){
        val = parseInt(val, 10);
    }
    $("#"+fieldName).rules('remove');
    @endforeach
    @endif
    @if(!empty($field['messages']))
    @foreach($field['messages'] as $validator => $message)
    $("#"+fieldName).rules('remove');
    @endforeach
    @endif
    @endforeach
    @endif
      }

</script>
@endpush
