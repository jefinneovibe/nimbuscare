<div class="col-{{@$config['style']['col_width']?:6}}">
    <div class="row">
        <div class="{{@$config['label_class']?:'col-12'}}">
            <label class="titles">{{@$config['label']}} <span>*</span></label>
        </div>
        <div class="{{@$config['field_class']?:'col-12'}}">
            <div class="form_group" >
                <input id="businessTypeId{{@$config['id']}}" type="hidden" name="{{@$config['fieldName']}}[optionId]"
                    @if (@$value['optionId'])
                        value="{{@$value['optionId']}}"
                    @endif
                >
                <select class="selectpicker btype form-control" data-live-search="true" name="{{@$config['fieldName']}}[optionVal]" id="{{@$config['id']}}" >
                    <option value="">Select</option>
                    @foreach($options as $option)
                        <option data-user="{{$option['businessNumber']}}" @if($option['businessName'] == @$value['optionVal']) selected @endif value="{{$option['businessName']}}">{{ucwords($option['businessName'])}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@push('widgetScripts')
    <script>
        $(document).on('click','.btype',function(){
            businessNumber = $(this).find("option:selected").data('user');
            var inputHiddenId = $(this).parent().find("input:hidden").attr('id');
            $("#"+inputHiddenId).val(businessNumber);
            $("#businessType-error").hide();
        });
        $(window).load(function(){
            //Add validations to parent form
          var form = $('#basic_formbusinessDetails').closest('form');
          var settings = form.validate().settings;
          var oldRules = settings.rules;
          var newRules = {
                  '{{@$config['fieldName']}}[optionVal]':{
                      required: true
                  },
              }

              var totalRules = Object.assign(oldRules, newRules);
              var oldMsgs = settings.messages;
              var newMsgs = {
                  '{{@$config['fieldName']}}[optionVal]': "Please select a buisness.",
              }
          var totalMsgs = Object.assign(oldMsgs, newMsgs);
          settings.rules =totalRules;
          settings.messages =totalMsgs;

      });
    </script>
@endpush
