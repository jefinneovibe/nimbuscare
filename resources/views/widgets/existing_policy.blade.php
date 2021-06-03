

   <div class="col-2">
        <div class="form-group">
            <label><b class="titles">{{@$config['label']}} <span>*</span></b></label>
        </div>
    </div>
    <div class="col-10">
        <div class="container row">
            <div class="col-1 custom-control custom-radio mb-3" style="margin-top: 5px;">
                <input name="{{@$config['fieldName']}}[hasExistingPolicy]" @if(@$value['hasExistingPolicy'] == 'yes') checked="checked" @endif value="yes" class="custom-control-input" id="hasExistingPolicyYes" type="radio">
                <label class="custom-control-label" for="hasExistingPolicyYes">Yes</label>
            </div>
            <div class="col-1 custom-control custom-radio mb-3" style="margin-top: 5px;">
                <input name="{{@$config['fieldName']}}[hasExistingPolicy]" value="no" @if(@$value['hasExistingPolicy'] == 'no') checked="checked" @endif class="custom-control-input" id="hasExistingPolicyNo" type="radio">
                <label class="custom-control-label" for="hasExistingPolicyNo">No</label>
            </div>
            <div class="col-10 form-group" id="hasExistingPolicyyesDiv" style="display:none">
                <div class="row">
                    <div class="col-4">
                        <label class="titles">Enter Existing Rate </label>
                        <input style="max-width: 90px;" type="text" name="{{@$config['fieldName']}}[existingRate]" value="{{@$value['existingRate']}}" class="form-control" id="existingRate" placeholder="Enter existing rate">
                        <input id="existingRateHidden" type="hidden" value="{{@$value['existingRate']}}">
                    </div>
                    <div class="col-8">
                        @widget('InsuranceCompanies', ['fieldName' => @$config['fieldName'].'[currentInsurer]', 'value' => @$value['currentInsurer'], 'label' => 'Current Insurer', 'style' =>['col_width' => 12] ])
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('widgetScripts')
<script>
    $(document).ready(function() {
        var checked = '{{@$value['hasExistingPolicy']?:'no'}}';
        $('#hasExistingPolicy'+checked+'Div').show();

        //Add validations to parent form
        var form = $('#hasExistingPolicyYes').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['fieldName']}}[hasExistingPolicy]':{
                    required: true
                },
                '{{@$config['fieldName']}}[existingRate]': {
                     required: function () {
                        return false; //($("#hasExistingPolicyYes").prop('checked') == true);
                      },
                      number: true
                    },
                '{{@$config['fieldName']}}[currentInsurer]': {
                    required: function () {
                        return false; //($("#hasExistingPolicyYes").prop('checked') == true);
                      },
                     },
                }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['fieldName']}}[hasExistingPolicy]': "Please select existing policy status.",
                '{{@$config['fieldName']}}[existingRate]': {
                    required: "Please enter existing rate",
                    number: "Please enter a valid number"
                },
                '{{@$config['fieldName']}}[currentInsurer]': {
                    required: "Please enter current insurer",
                }
            }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;
    });


    $("#hasExistingPolicyYes").click(function(){
        $("#existingRate").val($("#existingRateHidden").val());
        $("#currentInsurer").val($("#currentInsurerHidden").val()).trigger('change');
        $("#hasExistingPolicyyesDiv").show();
    });
    $("#hasExistingPolicyNo").click(function(){
        $("#hasExistingPolicyyesDiv").hide();
        $("#existingRate").val('');
        $("#currentInsurer").val('').trigger('change');
    });


</script>
@endpush
