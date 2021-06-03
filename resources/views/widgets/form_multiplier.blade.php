
<div class="col-{{@$config['style']['col_width']?:12}}">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#multiForm_popup" onclick="getMultiForm('{{@$config['valueKey']}}', '{{@$workTypeId}}')"  id="clone_form_btn" >add location</button>
    <div class="row child_space">
        <div class="{{@$config['field_class']?:'col-12'}} top_space  clonable_div">
            @widget("FormMultiplierView",['value' => @$value, 'data'=>@$config, 'workTypeId'=>@$workTypeId])
        </div>
    </div>
</div>

<?php
$saveDraft = 0;
if (isset($formValues['eQuestionnaire']["$step"]) && !empty(@$formValues['eQuestionnaire']["$step"])) {
    $saveDraft = 1;
}

?>
@push('widgetScripts')
<script>

     function getMultiForm(arrayKey, workTypeId){
        step="{{@$step}}";
        saveDraftbg = "{{@$saveDraft}}";
       //if (saveDraftbg == 0) {
        var form_data = new FormData($('#basic_form'+step)[0]);
        form_data.append('_token', '{{csrf_token()}}');
        form_data.append('type', 'draft');
        $.ajax({
                method: 'post',
                async:false,
                url: '{{url('save-equestionnaire')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false
            });
       //}
        $.ajax({
            type: "POST",
            url: "{{url('location-form')}}",
            data:{ _token : '{{csrf_token()}}', arrayKey:arrayKey, workTypeId:workTypeId},
            success: function(data){
            $('#multiForm_popup_content_spacing').html(data);
            $("#multiForm_popup #multiFormLabel").html("{{@$config['label']}}");
            // $( '#clone_form_btn' ).prop('disabled', false);
            }
        });
     }

     function showSingleValue(key, arrVal, workTypeId){
        // $( '#clone_form_btn' ).prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "{{url('show-location-form')}}",
            data:{valueKey : key , arrVal:arrVal,  _token : '{{csrf_token()}}', workTypeId:workTypeId},
            success: function(data){
                $('#multiForm_popup_content_spacing').html(data);
                $("#multiForm_popup #multiFormLabel").html("{{@$config['label']}}");
                // $( '#clone_form_btn' ).prop('disabled', false);
            }
        });
     }
     function deleteSingleValue(key, arrVal, workTypeId) {
        $("#deleteMultipleForm #keyValue").val(key);
        $("#deleteMultipleForm #keyName").val(arrVal);
        $("#deleteMultipleForm #worktypeData").val(workTypeId);
     }
</script>
@endpush
