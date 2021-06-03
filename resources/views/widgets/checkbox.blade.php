
<div class="custom-control custom-checkbox radiobuttonstyle mb-3 col-{{@$config['style']['col_width']?:6}}">
<input type="hidden" name="{{@$config['fieldName']}}[isChecked]" id="{{@$config['id']}}_hidden" value="{{@$value['isChecked']}}">
    <input class="custom-control-input" id="{{@$config['id']}}" type="checkbox" value="yes" @if(@$value['isChecked'] == 'yes' || (empty($value) && @$config['isChecked']==true)) checked @endif >
    <label class="custom-control-label " for="{{@$config['id']}}">{{$config['label']}}</label>
@if(@$config['hasTextbox'])
<div id="{{@$config['id']}}_details" class="form-group" @if(@$value['isChecked']=='no' || !@$value['isChecked']) style="display:none" @endif>
@if(@$config['textBoxLabel'])
    <label class="titles bmd-label-static">{{$config['textBoxLabel']}} @if(@$config['textValueRequired']) <span>*</span> @endif </label>
    @endif
    <input class="form-control @if(@$config['textValueRequired']) required @endif" name="{{@$config['fieldName']}}[detail]" id="{{@$config['id']}}_detail" type="text" value="{{@$value['detail']}}" placeholder="{{@$config['textBoxPlaceholder']}}" >
</div>
@endif
</div>

@push('widgetScripts')
<script>
$(window).load(function(){
    if($("#{{@$config['id']}}").prop('checked')== true) {
    $("#{{@$config['id']}}_details").show();
} else {
    $("#{{@$config['id']}}_details").hide();
}
});

$("#{{@$config['id']}}").click(function() {
    if($("#{{@$config['id']}}").prop('checked')== true) {
        $("#{{@$config['id']}}_details").show();
        $("#{{@$config['id']}}_hidden").val('yes');
    } else {
        $("#{{@$config['id']}}_details").hide();
        $("#{{@$config['id']}}_hidden").val('no');
        $("#{{@$config['id']}}_detail").removeClass('required');
        $("#{{@$config['id']}}_detail").val('');
    }
});
</script>
@endpush

