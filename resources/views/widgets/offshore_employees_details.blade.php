

   <div class="col-2">
        <div class="form-group">
            <label><b class="titles">{{@$config['label']}} <span>*</span></b></label>
        </div>
    </div>
    <div class="col-10">
        <div class="row">
            <div class="col-2 radiobuttonstyle custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[hasOffShoreEmployees]" @if(@$value['hasOffShoreEmployees'] == 'yes') checked="checked" @endif value="yes" class="custom-control-input" id="hasOffShoreEmployeesYes" type="radio">
                <label class="custom-control-label" for="hasOffShoreEmployeesYes">Yes</label>
            </div>
            <div class="col-2 radiobuttonstyle custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[hasOffShoreEmployees]" value="no" @if(@$value['hasOffShoreEmployees'] == 'no') checked="checked" @endif class="custom-control-input" id="hasOffShoreEmployeesNo" type="radio">
                <label class="custom-control-label" for="hasOffShoreEmployeesNo">No</label>
            </div>
            <div class="col-4 form-group hasOffShoreEmployeesyesDiv" style="display:none">
                <div class="row">
                    <div class="col-12">
                    <label class="titles">Enter Number Of Employees <span>*</span></label>
                    <input type="text" name="{{@$config['fieldName']}}[noOfLabourers]" value="{{@$value['noOfLabourers']}}" class="form-control" id="offshoreNoOfLabourers" placeholder="How many labours">
                    <input id="offshoreNoOfLabourersHidden" type="hidden" value="{{@$value['noOfLabourers']}}">
                    </div>

                </div>
            </div>
            <div class="col-4 form-group hasOffShoreEmployeesyesDiv" style="display:none">
            <div class="row">
                    <div class="col-12">
                    <label class="titles">Estimated Annual Wages<span>*</span></label>
                    <div class="input-group">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                        <input type="text" name="{{@$config['fieldName']}}[annualWages]" value="{{@$value['annualWages']}}" class="form-control aed" id="offshoreAnnualWages" placeholder="Enter annual wages">

                    </div>
                    <input id="offshoreAnnualWagesHidden" type="hidden" value="{{@$value['annualWages']}}">
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('widgetScripts')
<script>
    $(document).ready(function() {
        var checked = '{{@$value['hasOffShoreEmployees']?:'no'}}';
        $('.hasOffShoreEmployees'+checked+'Div').show();

        //Add validations to parent form
        var form = $('#hasOffShoreEmployeesYes').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['fieldName']}}[hasOffShoreEmployees]':{
                    required: true
                },
                '{{@$config['fieldName']}}[noOfLabourers]': {
                     required: function () {
                        return ($("#hasOffShoreEmployeesYes").prop('checked') == true);
                      },
                      number: true
                    },
                '{{@$config['fieldName']}}[annualWages]': {
                    required: function () {
                        return ($("#hasOffShoreEmployeesYes").prop('checked') == true);
                      },
                      amount: true
                     },
                }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['fieldName']}}[hasOffShoreEmployees]': "Please select the offshore employees status.",
                '{{@$config['fieldName']}}[noOfLabourers]': {
                     required: "Please select number of labours",
                      number: "please enter valid number"
                    },
                '{{@$config['fieldName']}}[annualWages]': {
                    required: "Please enter annual wages",
                    amount: "please enter valid number"
                     },
                }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;
    });


    $("#hasOffShoreEmployeesYes").click(function(){
        $("#offshoreNoOfLabourers").val($("#offshoreNoOfLabourersHidden").val());
        $("#offshoreAnnualWages").val($("#offshoreAnnualWagesHidden").val());
        $(".hasOffShoreEmployeesyesDiv").show();
    });
    $("#hasOffShoreEmployeesNo").click(function(){
        $(".hasOffShoreEmployeesyesDiv").hide();
        $("#offshoreNoOfLabourers").val('');
        $("#offshoreAnnualWages").val('');
    });
</script>
@endpush
