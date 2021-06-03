

   <div class="{{@$config['label_width']?:'col-2'}} top_space">
        <div class="form-group">
            <label><b class="titles">{{@$config['label']}} <span>*</span></b></label>  
        </div>
    </div>
    <div class="col-10 top_space">
        <div class="row {{@$config[style]['col_width']}}">
            <div class="col-2 custom-control radiobuttonstyle custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[hasHiredWorkers]" @if(@$value['hasHiredWorkers'] == 'yes') checked="checked" @endif value="yes" class="custom-control-input" id="hiredWorkersYes" type="radio">
                <label class="custom-control-label" for="hiredWorkersYes">Yes</label>
            </div>
            <div class="col-2 custom-control radiobuttonstyle custom-radio mb-3">
                <input name="{{@$config['fieldName']}}[hasHiredWorkers]" value="no" @if(@$value['hasHiredWorkers'] == 'no') checked="checked" @endif class="custom-control-input" id="hiredWorkersNo" type="radio">
                <label class="custom-control-label" for="hiredWorkersNo">No</label>
            </div>
            <div class="col-4 form-group hiredWorkersyesDiv" style="display:none">
                <div class="row">
                    <div class="col-12"> 
                        <label class="titles">How Many Labours<span>*</span></label>
                        <input type="text" name="{{@$config['fieldName']}}[noOfLabourers]" value="{{@$value['noOfLabourers']}}" class="form-control" id="labourCount" placeholder="How many labours">

                        <input id="labourCountHidden" type="hidden" value="{{@$value['noOfLabourers']}}">
                    </div>
                    
                </div>
               
               
            </div>
            <div class="col-4 form-group hiredWorkersyesDiv" style="display:none">
                <div class="row">
                    <div class="col-12"> 
                        <label class="titles">Estimated Annual Wages<span>*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">AED</span>
                                    </div>
                                <input type="text" name="{{@$config['fieldName']}}[annualWages]" value="{{@$value['annualWages']}}" class="form-control aed" id="labourannualwages" placeholder="Estimated annual wages">
                                
                            </div>
                        {{-- <input type="text" name="{{@$config['fieldName']}}[annualWages]" value="{{@$value['annualWages']}}" class="form-control" id="labourannualwages" placeholder="Estimated annual wages"> --}}
                        <input id="labourannualwagesHidden" type="hidden" value="{{@$value['annualWages']}}">
                    </div>
                    
                    </div>
                </div>
        </div>
    </div>

    @push('widgetScripts')
<script>
    $(document).ready(function() {
        var checked = '{{@$value['hasHiredWorkers']?:'no'}}';
        $('.hiredWorkers'+checked+'Div').show();

        //Add validations to parent form
        var form = $('#hiredWorkersYes').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                '{{@$config['fieldName']}}[hasHiredWorkers]':{
                    required: true
                },
                '{{@$config['fieldName']}}[noOfLabourers]': {
                     required: function () {
                        return ($("#hiredWorkersYes").prop('checked') == true);
                      },
                      number: true 
                    },
                '{{@$config['fieldName']}}[annualWages]': {
                    required: function () {
                        return ($("#hiredWorkersYes").prop('checked') == true);
                      },
                      amount: true
                     },
                }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['fieldName']}}[hasHiredWorkers]': "Please select employees hiring status.",
                '{{@$config['fieldName']}}[noOfLabourers]': {
                    required: "Please enter number of labours",
                    number: "Please enter a valid number"
                },
                '{{@$config['fieldName']}}[annualWages]': {
                    required: "Please enter annual wages",
                    amount: "Please enter a valid number"
                }
            }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;
    });


    $("#hiredWorkersYes").click(function(){
        $("#labourCount").val($("#labourCountHidden").val());
        $("#labourannualwages").val($("#labourannualwagesHidden").val());
        $(".hiredWorkersyesDiv").show();
    });
    $("#hiredWorkersNo").click(function(){
        $(".hiredWorkersyesDiv").hide();
        $("#labourCount").val('');
        $("#labourannualwages").val('');
    });


</script>
@endpush