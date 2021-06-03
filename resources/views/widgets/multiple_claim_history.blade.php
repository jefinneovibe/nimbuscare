
<?php $field_id = str_replace('[', '_', @$config['fieldName']);
$field_id = str_replace(']', '', $field_id);
 ?>
<div class="col-{{@$config['style']['col_width']?:12}}">
    <div class="row">
        <div class="{{@$config['label_class']?:'col-12'}}">
        <label class="titles">{{$config['label']}} @if(@$config['validation']['required'] == true)  <span>*</span> @endif</label>
    </div>
        <div class="{{@$config['select_class']?:'col-12'}}">
                <div class="form_group" >
                    <select class="selectpicker form-control @if(@$config['validation']['required'] == true) required @endif "  data-live-search="true" name="{{@$config['id']}}" id="{{@$field_id}}" >
                    <option value="" disabled @if(empty($value)) selected @endif>Select</option>
                    @foreach($config['options'] as $option)
                    <option value="{{$option['option_id']}}" data-field-id="{{@$field_id}}" data-child-id="{{@$option['option_child']}}" @if(@$value['type'] == @$option['option_id']) selected="selected" @endif>{{$option['option_value']}}</option>
                    @endforeach
                    </select>
                </div>
        </div>
        <div id="{{@$field_id}}_children" class="{{@$config['field_class']?:'col-12'}}" style="display: none;">
                @foreach(@$config['children'] as $key => $field)
                <div class="row {{$field['config']['id']}} {{$field['config']['class']}}">
                    @widget($field['widgetType'], ['data' => $field['config'], 'workTypeId'=> @$workTypeId, 'value' => @$value])
                </div>
                @endforeach


        </div>
    </div>
</div>

@push('widgetScripts')
<script>
prevLabelrandomize = $('.label_claimsHistory_combinedBoth').html();
$(window).load(function(){
    var optionSelected =  $("option:selected", $("#{{@$field_id}}"));
    manageSelectedCH(optionSelected);

});


$("#{{@$field_id}}").on('change', function() {
    var optionSelected = $("option:selected", this);
    manageSelectedCH(optionSelected);
});

function manageSelectedCH(option) {
    var selectdVal = option.val();
    if(selectdVal == 'seperateData') {
        $('.label_claimsHistory_combinedBoth').html('Business interruption coverages');
    } else {
        $('.label_claimsHistory_combinedBoth').html(prevLabelrandomize);
    }
    var idToshowChild = option.data('child-id');
    var fieldId = option.data('field-id');
    if (idToshowChild) {
        $("."+idToshowChild).show();
        console.log(idToshowChild);
        $("#"+fieldId+"_children").show();
        $("#"+fieldId+"_children").find('.row').addClass('hided').hide().find('.'+idToshowChild).show();
        $("#"+fieldId+"_children").find('.'+idToshowChild).removeClass('hided').show();
        $("."+idToshowChild).find('.row').removeClass('hided').show();
        $("#"+fieldId+"_children").find('.hided').find('select').val('').trigger('change');
        $("#"+fieldId+"_children").find('.hided').find('input, checkbox').removeAttr('checked');
        $("#"+fieldId+"_children").find('.hided').find('input, radio').removeAttr('checked');
        $("#"+fieldId+"_children").find('.hided').find('input, text').val('');
        $("#"+fieldId+"_children").find('label.error').hide();
    } else {
        $("#"+fieldId+"_children").hide();
        $("#"+fieldId+"_children").find('select').val('').trigger('change');
        $("#"+fieldId+"_children").find('input, checkbox').removeAttr('checked');
        $("#"+fieldId+"_children").find('input, radio').removeAttr('checked');
        $("#"+fieldId+"_children").find('.hided').find('input, text').val('');
        $("#"+fieldId+"_children").find('label.error').hide();
    }

}
</script>
@endpush
