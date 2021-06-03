@if(!empty($config['rows']))
<form method="post" id="basic_form{{@$step}}">
    <input type="hidden" id="workTypeId" name="workTypeId" value="{{@$workTypeId}}">
    <input type="hidden" id="stage" name="stage" value="{{@$stage}}">
    <input type="hidden" id="step" name="step" value="{{@$step}}">
    <input type="hidden" id="workTypeDataId" name="workTypeDataId" value="{{@$workTypeDataId}}">
    <input type="hidden" id="reviewArr" name="reviewArr" value="{{@$reviewArr}}">

    <div class="container add_segment">
        @foreach(@$config['rows'] as $key => $row)
            <div class="row {{@$row['config']['class']}}">
                @foreach($row['fields'] as $field)
                    @if (isset($field['config']['isLocationRelated']) && $field['config']['isLocationRelated'])
                        <?php @eval("\$viewItm = \"{$field['config']['locationCheckValue']}\";"); ?>
                       @if (isset($field['config']['isGreaterThan']) && $viewItm>$field['config']['isGreaterThan'])
                         @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues,'value' => @$values[$field['config']['fieldName']]]) 
                       @elseif(isset($field['config']['locationMatchValue']) && $field['config']['locationMatchValue']) 
                          @if (in_array($viewItm, $field['config']['locationMatchValue']))
                              @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'] === True)
                                  @if (count($field['relatedBusiness']) > 0)
                                      @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                      @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues,'value' => @$values[$field['config']['fieldName']]])
                                      @endif
                                  @endif
                              @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                                  <?php @eval("\$toCheck = \"{$field['checkValue']}\";"); ?>
                                  @if (count($toCheck) > 0)
                                      @if (in_array (@$toCheck, $field['matchValue']))
                                          @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues, 'value' => @$values[$field['config']['fieldName']]])
                                      @endif
                                  @endif
                              @else
                                  @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues, 'value' => @$values[$field['config']['fieldName']]])
                              @endif
                          @endif
                       @endif   
                    @else
                        @if (isset($field['isBusinessRelated']) && $field['isBusinessRelated'] === True)
                            @if (count($field['relatedBusiness']) > 0)
                                @if (in_array (@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness']))
                                @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues,'value' => @$values[$field['config']['fieldName']]])
                                @endif
                            @endif
                        @elseif (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === True)
                            <?php @eval("\$toCheck = \"{$field['checkValue']}\";"); ?>
                            @if (count($toCheck) > 0)
                                @if (in_array (@$toCheck, $field['matchValue']))
                                    @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues, 'value' => @$values[$field['config']['fieldName']]])
                                @endif
                            @endif
                        @else
                            @widget($field['widgetType'], ['data' => $field['config'], 'formValues'=>@$formValues, 'value' => @$values[$field['config']['fieldName']]])
                        @endif

                    @endif
                    @if(@$field['config']['eQuotationVisibility'])
                        <?php $f = [];
                        $f = @$field;
                        $f['fieldName'] = $field['config']['fieldName'];
                        $f['label'] = $field['config']['label'];
                        if (isset($field['config']['eQuoteTextbox']) && $field['config']['eQuoteTextbox']) {
                            $f['eQuoteTextbox'] = @$field['config']['eQuoteTextbox']; // To show textbox instead of agree/disagree
                        }
                        if (isset($row['config']['class']) && @$row['config']['class'] == 'd-none') {
                            $f['quotationPdfViewStatus'] = false; // To show textbox instead of agree/disagree
                        } else {
                            $f['quotationPdfViewStatus'] = true;
                        }
                        if (isset($field['config']['eQuoteTextboxValue']) && $field['config']['eQuoteTextboxValue']) {
                          $f['eQuoteTextboxValue'] = @$field['config']['eQuoteTextboxValue']; // To show textbox instead of agree/disagree
                        }
                        if (isset($field['config']['isCustomerResponse']) && $field['config']['isCustomerResponse']) {
                          $f['isCustomerResponse'] = @$field['config']['isCustomerResponse']; // To show textbox instead of agree/disagree
                        }
                        if (isset($field['config']['eQuoteTextArea']) && $field['config']['eQuoteTextArea']) {
                          $f['eQuoteTextArea'] = @$field['config']['eQuoteTextArea']; // To show textbox instead of agree/disagree
                        }
                        if (isset($field['config']['preCustomerLabel']) && $field['config']['preCustomerLabel']) {
                          $f['preCustomerLabel'] = @$field['config']['preCustomerLabel']; // To show textbox instead of agree/disagree
                        }
                        if (isset($field['config']['pdfView']) && $field['config']['pdfView']) {
                          $f['pdfView'] = @$field['config']['pdfView']; // To show textbox instead of agree/disagree
                        }
                        if (isset($field['config']['eQuoteTextboxHidden']) && $field['config']['eQuoteTextboxHidden']) {
                          $f['eQuoteTextboxHidden'] = @$field['config']['eQuoteTextboxHidden']; // To hide text box and comments section
                        }
                        $f['type'] = $field['widgetType'];
                        $f['value'] = @$values[$field['config']['fieldName']];
                            $formArr[] = $f;
                        ?>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
    <?php $formArr = base64_encode(json_encode(@$formArr)); ?>
    <input type ="hidden" name="formArr" id="formArr" value="{{@$formArr}}">
    <div class="row justify-content-end commonbutton">
        <button id="eslipSaveBtn"type="submit" class="btn btn-primary btnload">SAVE AND SUBMIT</button>
    </div>
</form>






<!------------------------------------------------modal-------------------------------->

<div class="modal fade" id="insurance_popup" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
      <div class="modal-content  ">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Select Insurers</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body selectstyle">
          <form name="insurance_companies_form" method="post" id="insurance_companies_form">
            <input type="hidden" id="workTypeDataId" name="workTypeDataId" value="{{@$workTypeDataId}}">
            <input type="hidden" name="send_type" id="send_type">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label class="titles"><b>Please Select Insurance Companies<span>*</span></b></label>
                  <select onchange="$('#insurer_select_error').hide();" class="form-control" id="insurer_select" name="insurer_select" >
                    <option disabled selected>Select </option>
                    @foreach($insurer_list as $insurer)
                    <option onclick="$(this).prop('disabled', true);"  @if(!empty(@$company_id) && (in_array($insurer->_id, $company_id))) disabled @endif value="{{$insurer->_id}}" >{{$insurer->name}} </option>
                    @endforeach
                  </select>
                  <label style="display:none;" for="insurer_select" id="insurer_select_error" class="error"></label>
                </div>
              </div>
            </div>
            <br>
                <label id="listLabel" @if (empty(@$company_id)) style="display:none;" @endif class="titles"><b>List Of Selected Companies</b></label>
            <div class="container row">
              <div class="selectedcompany"  >
                @if($insurer_list)
                  @foreach($insurer_list as $insurer)
                    @if(!empty(@$company_id) && (in_array($insurer->_id, $company_id)))
                      <div class="alert alert-secondary alert-dismissible fade show" role="alert" id="{{$insurer->_id}}" name="{{$insurer->name}}">{{$insurer->name}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true" >&times;</span>
                        </button>
                      </div>
                    @endif
                  @endforeach
                @else
                  No insurer Found.
                @endif
              </div>
              <div class="selectedcompany" id="target"></div>
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <label class="titles"><b>Enter Any Comments</b></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Comments" name="insurer_comment"></textarea>
              </div>
            </div>
            @if(@$documents != null)
                <div class="row">
                <div class="col-12">
                    <label class="titles"><b>Please Select The Files That Need To Be Send</b></label>
                </div>
                </div>
            @endif
            <div class=" container row" id="attach_div">
              @if(@$documents != null)
                @foreach($documents as $data)
                  <div class="col-12 custom-control custom-checkbox mb-3">
                    <input class="custom-control-input"  type="checkbox" name="files[{{$data->filename}}]" value="{{$data->url}}"id="{{$data->url}}" style="display: none">
                    <label class="custom-control-label"for="{{$data->url}}">{{$data->filename}}</label>
                  </div>
                @endforeach
              @else
                <div class="col-12">
                  <label class="titles"><b> No files available</b></label>
                </div>
              @endif
            </div>
        </div>
        <div class="commonbutton modal-footer">
          <button onclick="cancelEslipModal()" type="button" class="btn btn-link  ml-auto closebutton">CANCEL</button>
          @if(count(@$formValues->insurerList) > 0)
              <button class="btn btn-primary btnload" value="send_all" id="send_all_button" type="button">Send To All Selected</button>
              <button class="btn btn-primary btnload" value="send_new" id="send_new_button" type="button">Send To Newly Selected</button>
          @else
              <button class="btn btn-primary btnload" id="insurer_list_button" type="button">Send For Quotation</button>
          @endif

        </div>
        </form>
      </div>
    </div>
</div>
<!------modal end-->









@push('widgetScripts')
    <script>

    $(document).ready(function () {
    //Create work type form validation
    $('#basic_form'+'{{@$step}}').validate({
            errorPlacement: function(error, element) {
              if(element.attr("name") == "customer"){
                    error.insertAfter(element.parent());
                } else if (element.attr('type')=='radio') {
                    error.insertAfter(element.parent().parent());
                }
                else if (element.hasClass('datetimepicker')) {
                    error.insertAfter(element.parent());
                }
                else if (element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                }
                else if(element.after().has(":hidden")) {
                    error.insertAfter(element);
                }
                else {
                  error.insertAfter(element.parent());
                }
            },
            ignore: ".ignore, :hidden",
            rules:{},
            messages:{},
            submitHandler: function (form,event) {
              console.log('submitting...');
              var form_data = new FormData($('#basic_form'+'{{@$step}}')[0]);
              form_data.append('_token', '{{csrf_token()}}');
              $("#eslipSaveBtn").attr( "disabled", "disabled" );
              $('#preLoader').show();
              $.ajax({
                  method: 'post',
                  url: '{{url('save-eslip')}}',
                  data: form_data,
                  cache : false,
                  contentType: false,
                  processData: false,
                  success: function (result) {
                    $("#eslipSaveBtn").attr( "disabled", false );
                      if (result== 'success') {
                        $("#insurer_select_error").hide();
                        $('#insurance_popup').not(':hidden').find('select').val("");
                        $('#insurance_popup').find("#target").empty();
                        $('#insurance_popup').modal();
                        // getInsurerList();
                      } else {
                          alert('please try again');
                          location.reload();
                      }
                  }
              });
            }
        });

        });

        function saveAndSubmitLater(steps){
                    var form_data = new FormData($('#basic_form'+'{{@$step}}')[0]);
                    form_data.append('_token', '{{csrf_token()}}');
                    form_data.append('type', 'draft');
                    $.ajax({
                        method: 'post',
                        url: '{{url('save-eslip')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                              location.reload();
                              // getInsurerList();
                            } else {
                                alert('please try again');
                                location.reload();
                            }
                        }
                    });
        }
$(window).ready(function(){
    @if(!empty($config['validations']))
    @foreach($config['validations'] as $field)
    @if(!empty($field['validation']))
    var fieldName = '{{@$field['field']}}';
    @foreach($field['validation'] as $validator => $value)
    var val = '{{$value}}';
    var validationValue = '';
    if(val.length < 3 && parseInt(val, 10) !='NaN'){
      // id="insurance_button"
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
});


//insurance popup
function getInsurerList()
{
    $("#insurer_list_button").attr( "disabled", false );
    $('#insurance_popup').modal();
    // $('#preLoader').fadeOut('slow');
    // var workTypeDataId = $('#workTypeDataId').val();
    // $.ajax({
    //     method: 'get',
    //     data:{'workTypeDataId' : workTypeDataId},
    //     url: '{{url('get-insurer-eslip')}}',
    //     dataType: 'json',
    //     success:function (response) {
    //         // console.log(response.insurer_list);
    //         var option = '';
    //         for (var i=0;i<response.insurer_list.length;i++){
    //           option += '<option value="'+ response.insurer_list[i]['_id'] + '">' + response.insurer_list[i]['name'] + '</option>';
    //         }
    //         $('#insurer_select').append(option);
    //     }

    // });
}

//display div in select change
$("select#insurer_select").change(function(){
  var value = $(this).val();
  var text = $("#insurer_select option:selected").text();
  $("#insurer_select option:selected").prop('disabled', true);
  $("#insurance_companies_form #listLabel").show();
  $("div#target").append('<div class="alert alert-secondary alert-dismissible fade show targetCompDiv" role="alert" id="'+value+'" name="'+text+'">'+text+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" >&times;</span></button></div>');
});

function cancelEslipModal(){
  $("#target").find('.targetCompDiv').each(function(){
    var DivId = $(this).attr('id');
   $("#insurer_select option").each(function(){
      var SelectVal =  $(this).val();
      if (SelectVal == DivId) {
        $(this).prop('disabled', false);
        $(this).prop('selected', false);
      }
    });
    $("#insurer_select").find('option:eq(0)').prop('selected', true);
  });
  $('#insurance_popup').modal('hide');
}

$('#insurance_companies_form').validate({
  ignore: [],
        rules: {
        'insurance_companies[]': {
            required: true
        }
    },
    messages: {
            'insurance_companies[]': "Please select insurance companies."
    },
    errorPlacement: function (error, element) {

            error.insertAfter(element.parent().parent());
    },
  submitHandler: function (form,event) {
    var insurerArr = [];
    var items = document.getElementsByClassName('alert-dismissible');
    for (var i = 0; i < items.length; i++){
      var insurer_name = $('#'+items[i].id).attr("name");
      insurerArr.push({id: items[i].id, name: insurer_name, status:'active'});
    }
    console.log(insurerArr.length);
    if (insurerArr.length  > 0) {
      $("#insurer_select_error").hide();
      var form_data = new FormData($('#insurance_companies_form')[0]);
      form_data.append('_token', '{{csrf_token()}}');
      form_data.append('insurerArr', JSON.stringify(insurerArr));
      $("#insurer_list_button").attr( "disabled", true );
      $(".btn-primary").attr( "disabled", true );
      $.ajax({
          method: 'post',
          url: '{{url('save-insurer-list')}}',
          data: form_data,
          cache : false,
          contentType: false,
          processData: false,
          success: function (result) {
              if (result.success == 'success') {
                $('#insurance_popup').hide();

                location.href = "{{url('equotation/'.$workTypeDataId)}}";
                //location.reload();
              } else if (result.success == 'failed') {
                $('#insurance_popup').hide();
                location.href = "{{url('equotation/'.$workTypeDataId)}}";
                // location.reload();
              }else {
                $("#insurer_list_button").attr( "disabled",false );
                $('#insurance_popup').modal();
              }
          }
      });
    }else {
      $("#insurer_select_error").html("Please select any insurance company.").show();
    }
  }
});


$( "#send_all_button" ).click(function() {
        var valid=  $("#insurance_companies_form").valid();
        if(valid==true) {

                $('#send_type').val('send_all');
                $('#insurance_companies_form').submit();
            }
    });
    $( "#send_new_button" ).click(function() {
        var valid=  $("#insurance_companies_form").valid();
        if(valid==true) {

                $('#send_type').val('send_new');
                $('#insurance_companies_form').submit();
            }
    });
    $( "#insurer_list_button" ).click(function() {
        var valid=  $("#insurance_companies_form").valid();
        if(valid==true) {

                $('#send_type').val('0');
                $('#insurance_companies_form').submit();
            }
    });


    </script>
    @endpush

    @endif
