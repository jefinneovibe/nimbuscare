@extends('layouts.insurer_layout_new')
@section('content')
    <div class="mycontainer ">
<!---------------------------------------------------------- insurtop -------------------------------------------------------------------------->

        @if(@$data['eSlipData']['review'])
            @if (@$formValues->workTypeId['name'])
                <div class="row">
                    <div class="col-3">
                        <label><b class="titles">Class of Business </b></label>
                    </div>
                    <div class="col-3">
                    <label class="title">: {{@$formValues->workTypeId['name']}}</label>
                    </div>
                    @if(isset($formValues->eSlip['forms']['lastDate']) && !empty($formValues->eSlip['forms']['lastDate']))
                    <div class="col-3">
                        <label><b class="titles">Last date for submitting the quotation</b></label>
                    </div>
                    <div class="col-3">
                    <label class="title">: {{@$formValues->eSlip['forms']['lastDate']}}</label>
                    </div>
                    @endif
                </div>
            @endif
            <?php $covers = []; $table = [];$multiDocumentArr = [];$claimHistoryView = []; ?>
            <div class="row">
                @foreach(@$data['eSlipData']['review'] as $field)
                    @if(strtolower($field['type']) == 'text')
                        <div class="col-3">
                            <label><b class="titles">{{$field['label']}}</b></label>
                        </div>
                        <?php @eval("\$str = \"{$field['value']}\";"); ?>
                        @if(isset($field['sum']) && $field['sum'] == true)
                    <!-- Incase of sum value -->
                    <?php
                        $finalArray=array_map(function ($value) {
                            return str_replace(',', '', $value);
                        }, explode('|', $str));
                        $sum = array_sum($finalArray);
                        $str = number_format($sum);

                    ?>
                @endif
                        <div class="col-3"><label class="title">:</label>
                        @if($str)
                            <label class="titles">{{@$str}}</label>
                        @else
                            <label class="titles"> NA</label>
                        @endif
                                                            
                            @if(!empty($field['statement']))
                                <div class="disclaimer red spacing">
                                    <p class="text-justify">{{$field['statement']}}</p>
                                </div>
                            @endif
                        </div>
                    @elseif(strtolower($field['type']) == 'table')
                        <?php $table[] =$field; ?>
                    @elseif (strtolower($field['type']) == 'cover')
                        <?php $covers[] = $field; ?>
                    @elseif (strtolower($field['type']) == 'claimhistorymultipleview')
                        <?php $claimHistoryView[] = $field;  ?>
                    @elseif (strtolower($field['type']) == 'eslipmultidocumentview')

                        @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'])
                            @if (count($field['relatedBusiness']) > 0)
                                @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                    <?php $multiDocumentArr[]=$field; ?>
                                @endif
                            @endif
                        @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                            <?php @eval("\$str123_field = \"{$field['checkValue']}\";");?>
                            @if (in_array (@$str123_field, $field['matchValue']))
                                <?php $multiDocumentArr[]=$field; ?>
                            @endif
                        @else
                            <?php $multiDocumentArr[]=$field; ?>
                        @endif
                    @elseif (strtolower($field['type']) == 'annualwages')
                        <div class="col-3">
                            <label><b class="titles">{{$field['label']}}</b></label>
                        </div>
                        <?php @eval("\$str = \"{$field['value']}\";"); ?>
                        <?php @eval("\$str2 = \"{$field['nonAdminValue']}\";"); ?>
                        <?php @eval("\$status = \"{$field['valueStatus']}\";"); ?>
                        <div class="col-3">
                            @if(@$status == 'admin')
                                <label class="title">: {{@$str}}</label>
                            @elseif(@$status == 'nonadmin')
                                <label class="title">: {{@$str2}}</label>
                            @elseif(@$status == 'both')
                                <label class="title">: {{@$str}},{{@$str2}} </label>
                            @endif
                        </div>
                    @endif
                @endforeach
                @if (!empty($table))
                <div class="col-12"></div>
                    @foreach ($table as $tableItem)
                        <div class="col-6">                        
                            @if (@$tableItem) 
                                <h6 style=" width: 62.83333333%;font-size: 12px;margin-top: 10px;font-weight: 600;" class="titles ">{{@$tableItem['label']}}</h6>
                            @endif                           
                            @if (isset($tableItem['table']) && !empty($tableItem['table']))
                                @foreach ($tableItem['table'] as $tableArray)
                                 @if (isset($tableArray['isWidgetRelated']) && $tableArray['isWidgetRelated'] === True)
                                    <?php @eval("\$str = \"{$tableArray['checkValue']}\";"); ?>                                       
                                    @if (in_array (@$str, $tableArray['matchValue']))                                             
                                        @if(isset($tableArray['value']) && !empty($tableArray['value']))
                                              <?php $columnValue = @$tableArray['value']; ?>
                                        @endif 
                                    @else  
                                     <?php $columnValue = "" ?>
                                    @endif 
                                @else
                                 <?php @eval("\$columnValue = \"{$tableArray['columnValue']}\";"); ?>
                                @endif 
                                
                                @if (@$columnValue)
                                      <div class="row child_space">
                                        <div class="col-6" style="max-width: 47%;">
                                            <label><b class="titles">{{@$tableArray['columnName']}}</b></label>
                                        </div>
                                        <div class="col-6">
                                            <label class="title">: {{@$columnValue}}</label>
                                        </div>
                                    </div>
                                @endif
                                
                                  
                                @endforeach
                            @endif
                            {{-- @widget('Table',['data'=> $tableItem,'formValues'=>$formValues]) --}}
                        </div>
                    @endforeach
                @endif
                @if (!empty($covers))
                        @foreach ($covers as $cover)
                        @if ($cover['label'] != '')
                            <div class="col-12">
                                <label><b class="titles">{{$cover['label']}}</b></label>
                            </div>
                        @endif
                        <?php @eval("\$str = \"{$cover['value']}\";"); ?>
                        <div class="col-6">
                            @if (@$str)
                                <label class="title">{{@$str}}</label>
                            @endif
                            @if(!empty($cover['statement']))
                                <div class="disclaimer red spacing">
                                    <p class="text-justify">{{$cover['statement']}}</p>
                                </div>
                            @endif
                        </div>
                        @endforeach
                @endif
            </div>
        @endif
<!----------------------------------------------------------------Multiple Document section--------------------------------------------------------->

        @if (!empty($multiDocumentArr))
            @foreach ($multiDocumentArr as $multiDocument)
                @widget('eslip_multi_document_view',['data'=> $multiDocument,'formValues'=>$formValues])
            @endforeach
        @endif


<!----------------------------------------------------------------Document section--------------------------------------------------------->

        @if (isset($uploadedFiles))
            <div class="file_upload">
                <h6 class="title" style="margin-bottom:10px">Documents</h6>
                <div class="row">
                    @foreach ($uploadedFiles as $file)
                        @if (isset($file['url']) && $file['url'] != '')
                            <div class="col-3 flex_label">
                                <label class="titles" style="word-break: break-all;" for="filename">{{$file['file_name']}}</label>
                                <a target="_blank" class="btn file_uploadBtn btn-sm btn-primary" href="{{$file['url']}}">view</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

<!----------------------------------------------------------------claim history section--------------------------------------------------------->
        @if(!empty(@$formData['claimsHistory']) && !isset($formData['claimsHistory']['type']))
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label><b class="titles">Claim History</b></label>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <table class="claimhistorydata">
                        <thead>
                            @if (isset($formData['claimsHistory']))
                                @foreach(@$formData['claimsHistory'] as $claimHistory1)
                                    @if($loop->iteration == 1)
                                        @foreach ($claimHistory1 as $key1 =>$val1)
                                            <th @if ($key1 == 'year')
                                                style="width:10%;"
                                            @else
                                            style="width:40%;"
                                            @endif ><label class="titles">{{ucfirst(str_replace('_', ' ',  @$key1))}}</label></th>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </thead>
                        <tbody>
                            @if (isset($formData['claimsHistory']))
                                @foreach($formData['claimsHistory'] as $claimHistory)
                                    @if ((strtolower(@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus'])== strtolower(preg_replace('/\s+/', '', @$claimHistory['type']))) || (strtolower(@$formValues['eQuestionnaire']['businessDetails']['employeeDetails']['adminStatus']) == 'both'))
                                        <tr>
                                            @foreach ($claimHistory as $key =>$val)
                                                @if ($key == 'year')
                                                    <td>
                                                        {{str_replace('year', '',  @$claimHistory[$key])?:'--'}}
                                                        @if (str_replace('year', '',  @$claimHistory[$key]) == 1)
                                                            (Most Recent)
                                                        @endif
                                                    </td>
                                                @else
                                                    <td><p>{{@$claimHistory[$key]?:'--'}}</p></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="wrper_div_ch" style="padding-left: 16px;">
                @if (!empty($claimHistoryView))
                    @foreach ($claimHistoryView as $claimHistoryitem)
                        @widget('claimHistoryMultipleView',['data'=> $claimHistoryitem,'formValues'=>$formValues])
                    @endforeach
                @endif
            </div>
        @endif

<!------------------------------------------------------------------------table section--------------------------------------------------------->
            <div class="dataatable comparesec">
                <div id="admins">
                    <div class="materialetable table-responsive">
                        <div id="scrollstyle"  class="insurheightfix "><!--  -->
                            <table  class="comparison_insur table ">
                                <thead>
                                    <tr>
                                        <th><div class="insurmainsquestion"><b class="blue">Questions</b></div></th>
                                        <th><div class="insurmainsquestion"><b>Customer Response</b></div></th>
                                        <th><div class="insurmainsquestion"><b>Your Response</b></div></th>
                                        <th><div class="insurmainsquestion"><b>Comments If Required</b></div></th>
                                    </tr>
                                </thead>
                                <tbody id="scrollstyle" class="syncscroll insurheightfix" name="myElements">
                                    <form id="insurer_response_form" method="post">
                                        <input type="hidden" name="workTypeDataId" value ="{{@$workTypeDataId}}">
                                        <input type="hidden" name="quoteActive" id="quoteActive" @if(@$insurerReply['quoteStatus']=='active') value="true" @else value="false" @endif>
                                        @if(@$token)
                                            <input type="hidden" name="hiddenToken" id="hiddenToken" value="{{$token}}">
                                        @endif
                                        @foreach(@$data['eSlipData']['review'] as $key => $field)
                                            @if($field['type'] == 'checkbox' && $field['eQuotationVisibility']==true)
                                                <tr class="">
                                                    <td>
                                                        <div class="insurmainsanswer question">
                                                            <label class="titles">
                                                                @if (isset($field['preCustomerLabel']) && @$field['preCustomerLabel'] != '')
                                                                    {{@$field['preCustomerLabel']}}
                                                                @else
                                                                    {{@$field['label']}}
                                                                @endif
                                                                <span>*</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <input type="hidden" name="{{$field['fieldName']}}[fieldName]" value="{{@$field['fieldName']}}">
                                                    <?php @eval("\$str = \"{$field['value']}\";"); ?>
                                                    <td>
                                                        <div class=" insurmainsanswer textcolor">Yes</div>
                                                    </td>
                                                    <td>
                                                        <div class="insurmainsanswer">
                                                            <div class=" container row radio">
                                                                <div class="col-6 custom-control custom-radio mb-3">
                                                                    <input name="{{$field['fieldName']}}[agreeStatus]" value="agreed" @if(@$insurerReply[$field['fieldName']]['agreeStatus'] != 'disagreed') checked="checked" @endif class="custom-control-input requiredValidation" id="{{$field['fieldName']}}_{{$key}}" type="radio">
                                                                    <label class="custom-control-label" for="{{$field['fieldName']}}_{{$key}}">Agree</label>
                                                                </div>
                                                                <div class="col-6 custom-control custom-radio mb-3">
                                                                    <input name="{{$field['fieldName']}}[agreeStatus]" value="disagreed" @if(@$insurerReply[$field['fieldName']]['agreeStatus'] == 'disagreed') checked="checked" @endif class="custom-control-input" id="{{$field['fieldName']}}_{{$key+1}}" type="radio">
                                                                    <label class="custom-control-label" for="{{$field['fieldName']}}_{{$key+1}}">Disagree</label>
                                                                </div>
                                                                <span class="error {{$field['fieldName']}}_error" style="display: none;">Please select response</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="insurmainsanswer form-group">
                                                            <input type="text"  value="{{@$insurerReply[$field['fieldName']]['comments']}}" name="{{$field['fieldName']}}[comments]" class="form-control"  placeholder="Comments">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach(@$data['eSlipData']['forms'] as $key => $field)
                                            @if(@$field)
                                                <tr class="">
                                                    <td>
                                                        <div class="question">
                                                            <label class="titles">
                                                                @if (isset($field['preCustomerLabel']) && @$field['preCustomerLabel'] != '')
                                                                    {{@$field['preCustomerLabel']}}
                                                                @else
                                                                    {{@$field['label']}}
                                                                @endif
                                                                <span>*</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <input type="hidden" name="{{$field['fieldName']}}[fieldName]" value="{{@$field['fieldName']}}">
                                                    <?php @eval("\$str = \"{$field['value']}\";");?>
                                                    @if(@$str == 'Array')
                                                        <?php $str = 'Yes'; ?>
                                                    @endif
                                                    <td>
                                                        @if (isset($field['eQuoteTextboxValue']) && $field['eQuoteTextboxValue'])
                                                            {{@$field['value']?:'--'}}
                                                        @elseif((isset($field['eQuoteTextbox']) && $field['eQuoteTextbox']) || (isset($field['eQuoteTextArea']) && @$field['eQuoteTextArea']))
                                                            @if (isset($field['isCustomerResponse']) && $field['isCustomerResponse'])
                                                                @if (gettype($field['value']) == 'array')
                                                                    <?php $stringDiv = ''; ?>
                                                                    @foreach ($field['value']  as $key_array => $array_val)
                                                                        <?php
                                                                            if ($array_val != '' && $key_array != 'seperateStatus'){
                                                                                $pieces = preg_split('/(?=[A-Z])/', $key_array); $label = implode(' ', $pieces);
                                                                                $stringDiv .= " ". ucwords(@$label) ." : " . $array_val.  " ";
                                                                            }
                                                                        ?>
                                                                    @endforeach
                                                                    <div class="textcolor">{{@$stringDiv?:'--'}}</div>
                                                                @else
                                                                    <div class="textcolor">{{@$field['value']?:'--'}}</div>
                                                                @endif
                                                            @else
                                                                    <div class="textcolor">--</div>
                                                            @endif
                                                        @else
                                                            <div class="textcolor">{{@$str?$str:'--'}}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($field['eQuoteTextbox']) && @$field['eQuoteTextbox'])
                                                            @if(!isset($field['eQuoteTextboxHidden']))
                                                                <div class="form-group">
                                                                    <input type="text" name="{{$field['fieldName']}}[agreeStatus]" {{@$field['config']['dataAttributes']}} id="{{$field['fieldName']}}_id" value="{{@$insurerReply[$field['fieldName']]['agreeStatus']}}"  class="form-control {{@$field['config']['iClass']}} textValidationRequired maxLength @if(isset($field['config']['aed']) && @$field['config']['aed']) aed @endif"  placeholder="Enter content">
                                                                    <span class="error {{$field['fieldName']}}_id_error" style="display: none;" >Please enter your content</span>
                                                                </div>
                                                            @endif
                                                        @elseif (isset($field['eQuoteTextArea']) && @$field['eQuoteTextArea'])
                                                            <div class="form-group">
                                                                <textarea name="{{$field['fieldName']}}[agreeStatus]" id="{{$field['fieldName']}}_id" cols="50" class="form-control textValidationRequired maxLength" placeholder="Enter content" rows="60">{{@$insurerReply[$field['fieldName']]['agreeStatus']}}</textarea>
                                                                {{-- <input type="text" name="{{$field['fieldName']}}[agreeStatus]" id="{{$field['fieldName']}}_id" value="{{@$insurerReply[$field['fieldName']]['agreeStatus']}}"  class="form-control textValidationRequired @if(isset($field['config']['aed']) && @$field['config']['aed']) aed @endif"  placeholder="Enter content"> --}}
                                                                <span class="error {{$field['fieldName']}}_id_error" style="display: none;" >Please enter your content</span>
                                                            </div>
                                                        @else
                                                            <div class="container row radio">
                                                            <div class="col-6 custom-control custom-radio mb-3">
                                                                <input name="{{$field['fieldName']}}[agreeStatus]" value="agreed" @if(@$insurerReply[$field['fieldName']]['agreeStatus'] != 'disagreed') checked="checked" @endif class="custom-control-input requiredValidation" id="{{$field['fieldName']}}_{{$key}}" type="radio">
                                                                <label class="custom-control-label" for="{{$field['fieldName']}}_{{$key}}">Agree</label>
                                                            </div>
                                                            <div class="col-6 custom-control custom-radio mb-3">
                                                                <input name="{{$field['fieldName']}}[agreeStatus]" value="disagreed" @if(@$insurerReply[$field['fieldName']]['agreeStatus'] == 'disagreed') checked="checked" @endif class="custom-control-input" id="{{$field['fieldName']}}_{{$key+1}}" type="radio">
                                                                <label class="custom-control-label" for="{{$field['fieldName']}}_{{$key+1}}">Disagree</label>
                                                            </div>
                                                            <span class="error {{$field['fieldName']}}_error" style="display: none;">Please select response</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if((isset($field['eQuoteTextbox']) && $field['eQuoteTextbox'])|| (isset($field['eQuoteTextArea']) && @$field['eQuoteTextArea']))
                                                        @else
                                                            <div class="form-group">
                                                                <input type="text"  value="{{@$insurerReply[$field['fieldName']]['comments']}}" name="{{$field['fieldName']}}[comments]" class="form-control required"  placeholder="Comments">
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-------------------------------------------------------------------------mycontainer ends------------------------------------------------------>
    @push('widgetScripts')
        <script>

            $('.aed').on('keyup', function(){
                var x=$(this).val();
                var res = x.replace(/[,]+/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                $(this).val(res);
            });


            validation = [];
            obj = [];
            $('.requiredValidation').each(function() {
                var currentElement = $(this);
                var id = currentElement.prop('name');
                var val = "'"+currentElement.prop('name')+"'"+':{required:true},';
                var value = "'"+currentElement.prop('name')+"'";
                var obj = {};
                obj[value] = {required:true};
                validation.push({[value]:{required:true}});
            });
            console.log(validation);
            $(document).ready(function () {
                //Create work type form validation
                $('#insurer_response_form').validate({
                    ignore: ".ignore, :hidden",
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == "customer"){
                            error.insertAfter(element.parent());
                        }
                        else {
                            error.insertAfter(element);
                        }
                    },
                    rules:validation,
                    messages:{
                    'emergencyEvacuation[agreeStatus]':{
                        required: "this is required"
                    }
                    
                    },
                    submitHandler: function (form,event) {
                    console.log('submitting...');
                    var form_data = new FormData($('#insurer_response_form')[0]);
                    console.log(form_data);
                    @if(!empty(@$insurerReply))
                    form_data.append('stage', 'amended');
                    @else
                    form_data.append('stage', 'given');
                    @endif
                    form_data.append('_token', '{{csrf_token()}}');
                    $("#basicForm_submit").attr( "disabled", "disabled" );
                    $('#preLoader').show();
                    $.ajax({
                        method: 'post',   
                        url: '{{url('save-insurer-response')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                                @if(!empty(@$insurerReply))
                                window.location.href = '{{url('insurer/equotes-given')}}';
                                @else
                                window.location.href = '{{url('insurer/e-quotes-provider')}}';
                                @endif
                            }
                        }
                    });
                    }
                });
            });
            function submitForm() {
                $("#ins_saveAndSub").attr( "disabled", "disabled" );
                var radioErr = [];
                var rules = $('#insurer_response_form').validate().settings.rules;
                $.each(rules, function (k, value) {
                $.each(value, function (id, val) {
                    //console.log($("input[name=" + id + "]:checked").prop('checked'));
                    if ($("input[name=" + id + "]:radio") && $("input[name=" + id + "]:checked").prop('checked') == undefined) {
                    var errid = id.replace("'", '');
                    errid = errid.replace("'", '');
                    errid = errid.replace("[agreeStatus]", '');
                    $(".error." + errid + '_error').show();
                    radioErr.push(errid);
                    }
                });
                });

                //Not empty text field || required validtion
                var textErr = [];
                $('.textValidationRequired').each(function() {
                    var alphaNumReg = /^[a-zA-Z0-9,&()/.':"*%+-\s]+$/;

                    if ($(this).val().trim() == '') {
                        var err_id = $(this).attr('id');
                        console.log(err_id);
                        $(".error." + err_id + '_error').html('Please Enter Your Content');
                        $(".error." + err_id + '_error').show();
                        textErr.push(err_id);
                    } 
                    //else if (alphaNumReg.test($(this).val().trim()) == false) {
                    //    var err_id = $(this).attr('id');
                    //    console.log(err_id);
                    //    $(".error." + err_id + '_error').html('Please Enter A Valid Content');
                    //    $(".error." + err_id + '_error').show();
                    //    textErr.push(err_id);
                   // }
                });

                //Number only can be entered
                var textNumberOnlyErr = [];
                $('.numberOnly').each(function() {
                    var numberReg = /^\d+$/;
                    if (numberReg.test($(this).val()) == false) {
                        var err_id = $(this).attr('id');
                        $(".error." + err_id + '_error').html('Only numbers allowed');
                        $(".error." + err_id + '_error').show();
                        //textNumberOnlyErr.push(err_id);
                        textErr.push(err_id);
                    }
                });

                //Value must be between the min and max data attributes
                var rangeValErr = [];
                $('.rangeValidation').each(function() {
                    var userVal = parseFloat($(this).val());
                    var numberReg = /^\d+$/;
                    var dataMin = parseFloat($(this).data('min'));
                    var dataMax = parseFloat($(this).data('max'));
                    gotMin = Math.min(dataMin, userVal);
                    gotMax = Math.max(dataMax, userVal);
                    if (gotMin < dataMin || dataMax < gotMax) {
                        var err_id = $(this).attr('id');
                        $(".error." + err_id + '_error').html('Value must be between '+ dataMin+' and '+ dataMax);
                        $(".error." + err_id + '_error').show();
                        //rangeValErr.push(err_id);
                        textErr.push(err_id);
                    }
                });

                //Validation for Maximum length that can be entered
                var maxLengthErr = [];
                $('.maxLength').each(function() {
                    var userValLength = parseInt($(this).val().length);
                    var maxLength = parseInt($(this).data('maxlength'));
                    if(isNaN(maxLength)) {
                       maxLength = 5000;
                    }
                    if (userValLength > maxLength) {
                        var err_id = $(this).attr('id');
                        $(".error." + err_id + '_error').html('Maximum length reached');
                        $(".error." + err_id + '_error').show();
                        maxLengthErr.push(err_id);
                    }
                });



                if (radioErr.length == 0 && textErr.length == 0 && rangeValErr.length == 0 && maxLengthErr.length == 0) {
                    $('#insurer_response_form').submit();
                } else {
                    $("#ins_saveAndSub").attr( "disabled", false);
                }
            }
            $("input[type=radio").click(function () {
                if ($(this).prop('checked') == true) {
                var id = $(this).prop('name');
                var errid = id.replace("'", '');
                errid = errid.replace("'", '');
                errid = errid.replace("[agreeStatus]", '');
                $(".error." + errid + '_error').hide();
                }
            });
            $("input[type=text").on('keyup', function () {
                if ($(this).val() != '') {
                var id = $(this).prop('name');
                var errid = id.replace("'", '');
                errid = errid.replace("'", '');
                errid = errid.replace("[agreeStatus]", '');
                $(".error." + errid + '_id_error').hide();
                }
            });
            $(".textValidationRequired").on('keyup', function () {
                if ($(this).val() != '') {
                var id = $(this).prop('name');
                var errid = id.replace("'", '');
                errid = errid.replace("'", '');
                errid = errid.replace("[agreeStatus]", '');
                $(".error." + errid + '_id_error').hide();
                }
            });

            function saveDraft() {
                $("#ins_saveAndSubLat").attr( "disabled", "disabled" );
                console.log('submitting...');
                var form_data = new FormData($('#insurer_response_form')[0]);
                @if(!empty(@$insurerReply))
                    form_data.append('stage', 'amended');
                @else
                    form_data.append('stage', 'given');
                @endif
                form_data.append('_token', '{{csrf_token()}}');
                $("#basicForm_submit").attr( "disabled", "disabled" );
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('insurer/save-draft-exit')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            location.reload();
                        }
                    }
                });
            }
        </script>
    @endpush
@endsection

