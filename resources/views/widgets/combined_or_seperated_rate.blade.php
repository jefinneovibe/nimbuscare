<div class="col-12">
    <div class="form-group bmd-form-group">
        <label class="titles">
            @if (isset($config['preCustomerLabel']) && @$config['preCustomerLabel'] != '' && Request::is('eslip/*'))
                {{@$config['preCustomerLabel']}}
            @else
                {{$config['label']}}
            @endif @if (!isset($config['removeValidation'])) <span>*</span> @endif </label>
    </div>
</div>
<div class="col-12">
        <div class="container row">
            <div class="col-6 custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[seperateStatus]" @if(@$value['seperateStatus'] == 'seperate') checked="checked" @endif value="seperate" class="custom-control-input" id="seperate" type="radio">
                <label class="custom-control-label" for="seperate">Seperate Rate</label>
            </div>
            <div class="col-6 custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[seperateStatus]" value="combined" class="custom-control-input" id="combined" @if(@$value['seperateStatus'] == 'combined') checked="checked" @endif type="radio">
                <label class="custom-control-label" for="combined">Combined Rate</label>
            </div>
        </div>
        <div class="row child_space">
            <div class="col-12 form-group seperateDiv bothDiv" style="display:none">
                <label class="titles">Target Rate (Admin) (in %) @if (!isset($config['subFieldNotRequired']) && !$config['subFieldNotRequired'])
                    <span>*</span>
                @endif </label>
                <input name ="{{@$config['fieldName']}}[adminRate]" type="text" value="{{@$value['adminRate']}}" class="form-control" id="adminRate" placeholder="Admin Rate (%)">
            </div>
            <div class="col-12 form-group seperateDiv bothDiv" style="display:none">
                <label class="titles">Target Rate (Non-Admin) (in %) @if (!isset($config['subFieldNotRequired']) && !$config['subFieldNotRequired'])
                    <span>*</span>
                @endif</label>
                <input type="text" name ="{{@$config['fieldName']}}[nonAdminRate]" value="{{@$value['nonAdminRate']}}" class="form-control" id="nonAdminRate" placeholder="Non-Admin Rate (%)">
            </div>
            <div class="col-12 form-group combinedDiv bothDiv" style="display:none">
                <label class="titles">Target Combined Rate (in %) @if (!isset($config['subFieldNotRequired']) && !$config['subFieldNotRequired'])
                    <span>*</span>
                @endif</label>
                <input type="text" name ="{{@$config['fieldName']}}[combinedRate]" value="{{@$value['combinedRate']}}" class="form-control" id="combinedRate" placeholder="Combined Rate (%)">
            </div>
        </div>
    </div>

    @push('widgetScripts')
    @if (!isset($config['removeValidation']))
<script>
            $(window).load(function(){

              //Add validations to parent form
            var form = $('#combined').closest('form');
            var settings = form.validate().settings;
            var oldRules = settings.rules;
            var newRules = {
                    '{{@$config['fieldName']}}[seperateStatus]':{
                        required: true
                    },
                    '{{@$config['fieldName']}}[adminRate]': {
                        required: function () {
                            return $("#seperate").prop('checked') == true;
                        },
                        number: true,
                        range:[0,100]
                        },
                    '{{@$config['fieldName']}}[nonAdminRate]': {
                        required: function () {
                            return $("#seperate").prop('checked') == true;
                        },
                        number: true,
                        range:[0,100]
                        },
                    '{{@$config['fieldName']}}[combinedRate]': {
                        required: function () {
                            return $("#combined").prop('checked') == true;
                        },
                        number: true,
                        range:[0,100]
                        },
                    '{{@$config['fieldName']}}[Premium]': {
                        required: function () {
                            return $("#combined").prop('checked') == true;
                        },
                        amount: true,
                        }
                }

                var totalRules = Object.assign(oldRules, newRules);
                var oldMsgs = settings.messages;
                var newMsgs = {
                    '{{@$config['fieldName']}}[seperateStatus]': "Please select category of rate.",
                    '{{@$config['fieldName']}}[adminRate]': {
                        required: "Please enter rate of admin.",
                        number: "Please enter a valid number.",
                        range:"Please enter a value in between 0 and 100."
                    },
                    '{{@$config['fieldName']}}[nonAdminRate]': {
                        required: "Please enter rate of non-admin.",
                        number: "Please enter a valid number",
                        range:"Please enter a value in between 0 and 100."
                    },
                    '{{@$config['fieldName']}}[combinedRate]': {
                        required: "Please enter the combined rate.",
                        number: "Please enter a valid number",
                        range:"Please enter a value in between 0 and 100."
                    },
                    '{{@$config['fieldName']}}[Premium]': {
                        required: "Please enter the Premium.",
                        amount: "Please enter a valid number"
                    }
                }
            var totalMsgs = Object.assign(oldMsgs, newMsgs);
            settings.rules =totalRules;
            settings.messages =totalMsgs;

        });
    </script>
        @endif
    <script>
            var checked = '{{@$value['seperateStatus']}}';
            $('.'+checked+'Div').show();


        $("#seperate").click(function(){
            $("#combinedRate, #combinedPremium").val('');
            $('.seperateDiv').show();
            $('.combinedDiv').hide();
        });
        $("#combined").click(function(){
            $("#adminRate, #nonAdminRate").val('');
            $('.seperateDiv').hide();
            $('.combinedDiv').show();
        });

    </script>
    @endpush
