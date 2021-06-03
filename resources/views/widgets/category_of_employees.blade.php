

    <div class="col-2">
        <div class="form-group">
            <label><b class="titles">{{@$config['label']}} <span>*</span></b></label>
        </div>
    </div>
    <div style="padding-top: 1%;" class="col-10">
        <div class="row">
            <div class="col-2 radiobuttonstyle custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[adminStatus]" @if(@$value['adminStatus'] == 'admin') checked="checked" @endif value="admin" class="custom-control-input" id="admin" type="radio">
                <label class="custom-control-label" for="admin">Admin</label>
            </div>
            <div class="col-2 radiobuttonstyle custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[adminStatus]" value="nonadmin" class="custom-control-input" id="nonadmin" @if(@$value['adminStatus'] == 'nonadmin') checked="checked" @endif type="radio">
                <label class="custom-control-label" for="nonadmin">Non-Admin</label>
            </div>
            <div class="col-2 radiobuttonstyle custom-control custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[adminStatus]" value="both" class="custom-control-input" id="both" @if(@$value['adminStatus'] == 'both') checked="checked" @endif type="radio">
                <label class="custom-control-label" for="both">Both</label>
            </div>
        </div>
    </div>
    <div style="width: 94%;margin-left: 2%;margin-top: -1%;" id="categoryOfEmployeeDiv" class="row">
        <div class="col-3 form-group adminDiv bothDiv" style="display:none">
            <label class="titles">No: Of Admin Employees<span>*</span></label>
            <input name ="{{@$config['fieldName']}}[adminCount]" type="text" style="max-width: 50%;" value="{{@$value['adminCount']}}" class="form-control" id="adminCount" placeholder="Enter number">
            <input id="adminCountHidden" type="hidden" value="{{@$value['adminCount']}}">
        </div>
        <div class="col-3 form-group adminDiv bothDiv" style="display:none">
            <label class="titles">Estimated Annual Wages Of Admin <span>*</span></label>
                <div class="input-group">
                <div class="input-group-prepend">
                            <span class="input-group-text">AED</span>
                        </div>
                    <input type="text" name ="{{@$config['fieldName']}}[adminAnnualWages]" style="max-width: 50%;" value="{{@$value['adminAnnualWages']}}" class="form-control aed " id="adminAnnualWages" placeholder="Annual Wages">

                </div>

            <input id="adminAnnualWagesHidden" type="hidden" value="{{@$value['adminAnnualWages']}}">
        </div>
        <div class="col-3 form-group nonadminDiv bothDiv" style="display:none">
            <label class="titles">No: Of Non-Admin Employees<span>*</span></label>
            <input type="text" name ="{{@$config['fieldName']}}[nonAdminCount]" style="max-width: 50%;" value="{{@$value['nonAdminCount']}}" class="form-control" id="nonAdminCount" placeholder="Enter number">
            <input id="nonAdminCountHidden" type="hidden" value="{{@$value['nonAdminCount']}}">
        </div>
        <div class="col-3 form-group nonadminDiv bothDiv" style="display:none">
            <label class="titles">Estimated Annual Wages Of Non-Admin<span>*</span></label>
                <div class="input-group">
                <div class="input-group-prepend">
                            <span class="input-group-text">AED</span>
                        </div>
                        <input type="text" name ="{{@$config['fieldName']}}[nonAdminAnnualWages]" style="max-width: 50%;" value="{{@$value['nonAdminAnnualWages']}}" class="form-control aed " id="nonAdminAnnualWages" placeholder="Annual Wages">

                </div>

            <input id="nonAdminAnnualWagesHidden" type="hidden" value="{{@$value['nonAdminAnnualWages']}}">
        </div>
    </div>

@push('widgetScripts')
<script>
    $(document).ready(function(){
        var checked = '{{@$value['adminStatus']}}';
        $('.'+checked+'Div').show();

        //Add validations to parent form
        var form = $('#nonadmin').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['fieldName']}}[adminStatus]':{
                    required: true
                },
                '{{@$config['fieldName']}}[adminCount]': {
                     required: function () {
                        return ($("#admin").prop('checked') == true || $("#both").prop('checked') == true);
                      },
                      number: true
                    },
                '{{@$config['fieldName']}}[adminAnnualWages]': {
                    required: function () {
                        return ($("#admin").prop('checked') == true || $("#both").prop('checked') == true);
                      },
                      amount: true
                     },
                '{{@$config['fieldName']}}[nonAdminCount]': {
                    required: function () {
                        return ($("#nonadmin").prop('checked') == true || $("#both").prop('checked') == true);
                      },
                      number: true
                    },
                '{{@$config['fieldName']}}[nonAdminAnnualWages]': {
                    required: function () {
                        return ($("#nonadmin").prop('checked') == true || $("#both").prop('checked') == true);
                      },
                      amount: true
                     },
            }
            var totalRules = Object.assign(oldRules, newRules);
            var oldMsgs = settings.messages;
            var newMsgs = {
                '{{@$config['fieldName']}}[adminStatus]': "Please select category of employees",
                '{{@$config['fieldName']}}[adminCount]': {
                    required: "Please enter number of admins",
                    number: "Please enter a valid number"
                },
                '{{@$config['fieldName']}}[adminAnnualWages]': {
                    required: "Please enter admin wages",
                    amount: "Please enter a valid number"
                },
                '{{@$config['fieldName']}}[nonAdminCount]': {
                    required: "Please enter number of non Admins",
                    number: "Please enter a valid number"
                },
                '{{@$config['fieldName']}}[nonAdminAnnualWages]': {
                    required: "Please enter non admin wages",
                    amount: "Please enter a valid number"
                }
            }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;
    });


    $("#admin").click(function(){
        $("#nonAdminCount").val('');
        $("#nonAdminAnnualWages").val('');
        $("#adminCount").val($("#adminCountHidden").val());
        $("#adminAnnualWages").val($("#adminAnnualWagesHidden").val());
        $(".bothDiv").not("input:hidden").val('');
        $('#categoryOfEmployeeDiv input:not([type="hidden"]').each(function(){
            $(this).val("");
        });
    $('.adminDiv').show();
    $('.nonadminDiv').hide();
    });

    $("#nonadmin").click(function(){
        $("#AdminCount").val('');
        $("#aminAnnualWages").val('');
        $("#nonAdminCount").val($("#nonAdminCountHidden").val());
        $("#nonAdminAnnualWages").val($("#nonAdminAnnualWagesHidden").val());
        $('#categoryOfEmployeeDiv input:not([type="hidden"]').each(function(){
            $(this).val("");
        });
    $('.nonadminDiv').show();
    $('.adminDiv').hide();
    });

    $("#both").click(function(){
        $("#adminCount").val($("#adminCountHidden").val());
        $("#adminAnnualWages").val($("#adminAnnualWagesHidden").val());
        $("#nonAdminCount").val($("#nonAdminCountHidden").val());
        $("#nonAdminAnnualWages").val($("#nonAdminAnnualWagesHidden").val());
        $('#categoryOfEmployeeDiv input:not([type="hidden"]').each(function(){
            $(this).val("");
        });
    $('.bothDiv').show();
    });

    // var stepId = $("#step").val();
    // console.log(stepId);
    // var form = $('#admin').closest('form');
    // var settings = form.validate().settings;
    // console.log(settings);

</script>
@endpush
