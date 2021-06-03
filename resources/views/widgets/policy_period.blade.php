    <style>
    .five_padding {
        padding-top:5px !important;
    }
    </style>
    <div class="{{@$config['label_width']?:'col-2'}} ">
        <div class="form-group">
            <label><b class="titles">{{@$config['label']}}</b></label>
        </div>
    </div>
    <div class="{{@$config['field_width']?:'col-10'}}">
        <div class="row">
            <div class="col-5 form-group">
            <div class="row">
            <div class="col-4">
            <label class="titles five_padding" style="margin-top:6px">Start Date</label>
            </div>
            <div class="col-6">
            <div class="input-group">
                    <input name="{{@$config['fieldName']}}[policyFrom]" autocomplete="off" id="{{@$config['id']}}FromDate" value="{{@$value['policyFrom']}}" class="form-control date" autocomplete="off" placeholder="Start date" type="text">
                    <div class="input-group-append">
                        <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div class="col-5 form-group">
            <div class="row">
            <div class="col-4">
            <label class="titles five_padding" style="margin-top:6px">End Date</label>
            </div>
            <div class="col-6">
            <div class="input-group">
                    <input name="{{@$config['fieldName']}}[policyTo]" autocomplete="off" id="{{@$config['id']}}ToDate" value="{{@$value['policyTo']}}"  class="form-control date" autocomplete="off" placeholder="End date" type="text">
                    <div class="input-group-append">
                        <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                </div>
            </div>
            </div>

            </div>
        </div>
    </div>

    @push('widgetScripts')
    <!-- Date Picker -->

    <script>

    $(document).ready(function(){
        var initialDate;
        var newDay,newMonth,newYear;
        var currentDate = new Date();
        var day = parseInt(currentDate.getDate());
        var month = parseInt(currentDate.getMonth() +1);
        var year = parseInt(currentDate.getFullYear());
        if(day == 31)
        {
            newDay = 30;
        }
        else
        {
            newDay = day;
        }
        if(month!=12 && month!=1)
        {
            newMonth = month + 1;
            newYear = year - 1;

        }
        if(month == 12)
        {
            newMonth = 1;
            newYear = year;
        }
        if(month == 1)
        {
            if(day==29 || day==30 || day==31)
            {
                newMonth = month+1;
                newYear = year-1;
            }
            else
            {
                newMonth = month + 1;
                newYear = year - 1;
            }

        }
        if(newDay<10)
            newDay = '0'+newDay;
        if(newMonth<10)
            newMonth = '0'+newMonth;
        initialDate = String(newDay+'/'+newMonth+'/'+newYear);
        $('#{{@$config['id']}}FromDate').datepicker({format: 'DD/MM/YYYY'});
        // $('#policyFromDate').on('dp.show', function(e) {
        //     $(this).data('DateTimePicker').date(initialDate);
        // });

        //Add validations to parent form
        var form = $('#{{@$config['id']}}FromDate').closest('form');
        var settings = form.validate().settings;
        var oldRules = settings.rules;
        var newRules = {
                date: {
                        required: false
                    },
                '{{@$config['fieldName']}}[policyFrom]': {
                     required: false
                    },
                '{{@$config['fieldName']}}[policyTo]': {
                    required: false,
                     },
                }
        var totalRules = Object.assign(oldRules, newRules);
        var oldMsgs = settings.messages;
        var newMsgs = {
                '{{@$config['fieldName']}}[policyFrom]': {
                    required: "Please enter from date",
                },
                '{{@$config['fieldName']}}[policyTo]': {
                    required: "Please enter to date",
                }
            }
        var totalMsgs = Object.assign(oldMsgs, newMsgs);
        settings.rules =totalRules;
        settings.messages =totalMsgs;

    });

    $.validator.addMethod('date',
            function(value, element) {

                if (this.optional(element)) {
                return true;
                }

                var ok = true;
                try {
                $.datepicker.parseDate('dd/mm/yy', value);
                } catch (err) {
                ok = false;
                }
                console.log(ok)
                return ok;
            });
    /*
        * To set end date one year greater from start date (policy)
        * */
        $('#{{@$config['id']}}FromDate').change( function () {
            var str = $('#{{@$config['id']}}FromDate').val();
            ///^\d{2}\/\d{2}\/\d{4}$/i.test( str )
            if(str) {
                var parts = str.split("/");
                var day = parts[0] && parseInt( parts[0], 10 );
                var month = parts[1] && parseInt( parts[1], 10 );
                var year = parts[2] && parseInt( parts[2], 10 );
                var duration = 1;
                if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {
                    var expiryDate = new Date( year, month - 1, day );
                    expiryDate.setFullYear( expiryDate.getFullYear() + duration );
                    var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                    var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                    var year = expiryDate.getFullYear();
                    if (day>1)
                    {
                        day = day-1;
                        day = ('0' + day ).slice( -2 );
                    }
                    else
                    {
                        month = month-1;
                        if(month == 1 ||month == 3 ||month==5||month==7||month==8||month==10||month==12)
                        {
                            day = 31;
                        }
                        else
                        {
                            day = 30;
                        }
                        month = ( '0' + month ).slice( -2 );
                    }
                    $('#{{@$config['id']}}ToDate').val( day + "/" + month + "/" + year );
                    $('#{{@$config['id']}}ToDate-error').hide();
                    // $("#policyToDate").datetimepicker({format: 'DD/MM/YYYY'});

                }
            }
        });

    </script>
    @endpush
