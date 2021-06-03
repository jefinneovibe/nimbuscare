@if (@$formValues['eQuestionnaire'][$config['valueField']])
<style>
#eslip_formMultiplierView td, #eslip_formMultiplierView th{
    border: .0625rem solid #D6D6D6 !important;
}
</style>
<br/>
<div>
    <h6 class="titles"><b>{{@$config['label']}}</b></h6>
</div>
    <table id="eslip_formMultiplierView" class="table formMultiView">
        <thead>
            @if (isset($formValues['eQuestionnaire'][$config['valueField']]))
                <tr>
                    @foreach ($config['childrenLabel'] as $key => $childrenLabelTr)
                        @if ((isset($childrenLabelTr['viewStatus']) && @$childrenLabelTr['viewStatus']))
                            @foreach ($childrenLabelTr as $tdChild)
                                @if ($loop->iteration == 1)
                                    <th>
                                        <label class="titile">
                                                {{@$tdChild}}
                                        </label>
                                    </th>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <th></th>
                </tr>
            @endif
        </thead>
        <tbody>
            @if (isset($formValues['eQuestionnaire'][$config['valueField']]))
                @foreach ($formValues['eQuestionnaire'][$config['valueField']] as $key => $multiForm)
                    <tr>
                        @if (isset($config['childrenLabel']))
                            @foreach ($config['childrenLabel'] as $childrenLabel)
                                @if ((isset($childrenLabel['viewStatus']) && @$childrenLabel['viewStatus']))
                                    @foreach ($childrenLabel as $childLabel => $childValue)
                                        @if ($loop->iteration == 1)
                                            <td>
                                                @if (isset($childrenLabel['isArray']) && $childrenLabel['isArray'] && isset($multiForm[$childLabel][$childrenLabel['arrayKey']]))
                                                     <span class="text"> {{$multiForm[$childLabel][$childrenLabel['arrayKey']]}}</span>
                                                @else
                                                    <span class="text">{{@$multiForm[$childLabel]}}</span>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <td>
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary btn-sm btnxsm"  data-toggle="modal" data-target="#eslipMultiForm_popup" onclick="showEslipSingleValue('{{@$key}}' , '{{@$config['valueField']}}')"  id="eslip_view_form_btn">view</button>
                                </div>
                            </td>
                        @endif
                        </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="modal fade" id="eslipMultiForm_popup" tabindex="-1" role="dialog" aria-labelledby="eslipMultiForm_popup" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered modal-md"  role="document">
          <div class="modal-content  ">
              <div class="modal-header">
               <h6 id="multiFormLabel"></h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <form id="quest_send_form" name="quest_send_form">
                  <div class="cd-popup">
                      <div class="cd-popup-container">
                          <div class="modal_content">
                              <div class="clearfix"></div>
                              <div id="multiForm_popup_content_spacing" class="multiForm_popup content_spacing">

                              </div>
                          </div>
                      </div>
                  </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    @push('widgetScripts')
        <script>
            function showEslipSingleValue(key, keyValue) {
                $.ajax({
                    type: "POST",
                    url: "{{url('show-location-form')}}",
                    data:{valueKey : key , arrVal:keyValue,  _token : '{{csrf_token()}}', workTypeId:'{{@$formValues->_id}}', eslip:1},
                    success: function(data){
                        $('#eslipMultiForm_popup #multiForm_popup_content_spacing').html(data);
                        $("#eslipMultiForm_popup #multiFormLabel").text("{{@$config['label']}}");
                    }
                });
            }
        </script>
    @endpush
@endif
