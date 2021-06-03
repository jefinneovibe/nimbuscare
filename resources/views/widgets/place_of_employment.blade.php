        <div class="col-2">
          <div class="form-group">
            <label><b class="titles">{{@$config['label']}} <span>*</span></b></label>
          </div>
        </div>
        <div class="col-10">
          <div class="row ">
          <input id="{{@$config['fieldName']}}_hidden" class="fieldName_hidden" value="{{@$config['fieldName']}}" type="hidden">
            <div class="col-2 custom-control radiobuttonstyle custom-radio mb-3">
                <input value="Within UAE" name="{{@$config['fieldName']}}[withinUAE]" class="custom-control-input required" @if(@$value['withinUAE']=='Within UAE') checked="checked"  @elseif($value == '') checked="checked" @endif id="{{@$config['fieldName']}}withinUAE" type="radio">
                <label class="custom-control-label" for="{{@$config['fieldName']}}withinUAE">Within UAE</label>
            </div>
            <div class="col-2 custom-control radiobuttonstyle custom-radio mb-3">
                <input value="Outside UAE" name="{{@$config['fieldName']}}[withinUAE]" class="custom-control-input required" @if(@$value['withinUAE'] == 'Outside UAE') checked="checked" @endif id="{{@$config['fieldName']}}outsideUAE" type="radio">
                <label class="custom-control-label" for="{{@$config['fieldName']}}outsideUAE">Outside UAE</label>
            </div>
            <div class="col-8">
            <div id="{{@$config['fieldName']}}emirateNameDiv" style="display:none" class="form-group">
                {{-- @if(@$value['withinUAE'] == 'no')  style="display:none" @endif  --}}
                <select data-hide-disabled="true" data-live-search="true" class="form-control selectpicker" name="{{@$config['fieldName']}}[emirateName]" id="{{@$config['fieldName']}}emirateName">
                    <option value="">Select Emirate</option>
                    @foreach(@$emirates as $emirate)
                    <option @if($emirate->name == @$value['emirateName']) selected @endif value="{{$emirate->name}}">{{$emirate->name}}</option>
                    @endforeach
                </select>
              <input id="{{@$config['fieldName']}}emirateNameHidden" type="hidden" value="{{@$value['emirateName']}}">
            </div>
            <div  id="{{@$config['fieldName']}}countryNameDiv" @if(@$value['withinUAE'] == 'Within UAE' || @$value == '') style="display:none" @endif  class="form-group">
                <select data-hide-disabled="true" data-live-search="true" class="form-control selectpicker {{@$config['select_class']}}" name="{{@$config['fieldName']}}[countryName]" id="{{@$config['fieldName']}}countryName">
                    <option value="" selected>Select Country</option>
                    <option @if('GCC Countries' == @$value['countryName']) selected @endif value="GCC Countries">GCC Countries</option>
                    @foreach(@$country_name as $country)
                    <option @if($country == @$value['countryName']) selected @endif value="{{$country}}">{{$country}}</option>
                    @endforeach
                </select>
                <input id="{{@$config['fieldName']}}countryNameHidden" type="hidden" value="{{@$value['countryName']}}">
            </div>
          </div>
          </div>

        </div>



@push('widgetScripts')

<script>
    // $(window).load(function(){

    // //Add validations to parent form
    // var form = $('#{{@$config['fieldName']}}_hidden').closest('form');
    // var settings = form.validate().settings;
    // var oldRules = settings.rules;
    // var newRules = {
    //             '{{@$config['fieldName']}}[withinUAE]':{
    //                 required: true
    //             },
    //             '{{@$config['fieldName']}}[emirateName]': {
    //                  required: function () {
    //                     return ($("#withinUAE").prop('checked') == true);
    //                   },
    //                 },
    //             '{{@$config['fieldName']}}[countryName]': {
    //                 required: function () {
    //                     return ($("#outsideUAE").prop('checked') == true);
    //                   },
    //                  },
    //             }
    //     var totalRules = Object.assign(oldRules, newRules);
    //     var oldMsgs = settings.messages;
    //     var newMsgs = {
    //             '{{@$config['fieldName']}}[withinUAE]': "Please select one",
    //             '{{@$config['fieldName']}}[emirateName]': {
    //                 required: "Please select emirate",
    //             },
    //             '{{@$config['fieldName']}}[countryName]': {
    //                 required: "Please select country",
    //             }
    //         }
    //     var totalMsgs = Object.assign(oldMsgs, newMsgs);
    //     settings.rules =totalRules;
    //     settings.messages =totalMsgs;

    // });

</script>

    @endpush
