<style>
.add {
    width: 30px;
    height: 30px;
    padding: 0 0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 5px;
}
.tablefull td {
    border:none;
}
.edited_data {
    margin-top: 25px;
}
.field_default{
    width: 100%;
}
.row_flex{
    display: flex;
}
.add i {
    margin: 0 !important;
}
.table {
    width:100%;
    white-space: nowrap;
}
.nameCol {
    width:100%;
}
.table td {
    padding: 0 5px;
}
</style>

<?php
$output = [];
if (!empty($value)) {
    foreach ($value as $k => $valu) {
        foreach ($valu as $key => $val) {
            $output[$key][$k] = $val;
        }
    }
    $value = $output;
}

?>
<div class="col-{{@$config['data']['style']['col_width']?:6}}">
<div class="row">
    @if($config['data']['label'])
    <div class="{{@$config['data']['label_class']?:'col-12'}}">
        <label class="titles">{{$config['data']['label']}}</label>
    </div>
    @endif
    <div class="{{@$config['data']['field_class']?:'col-12'}}">


            <span id="{{@$config['fieldName']}}_max_length_reached" class="error" style="display:none">Maximum length reached</span>
        <table class="tablefull" id="{{@$config['data']['id']}}_table">
                <thead>
                    @foreach(@$config['data']['children'] as $key => $field)
                    <th width="{{@$field['config']['width']}}%"><span class="titles customheader" data-field-name="{{@$field['config']['fieldName']}}" data-field-class="{{@$field['config']['class']}}">{{@$field['config']['label']}} @if(@$field['config']['validation']['required'] == true)  <span>*</span> @endif</span></th>
                    @endforeach
            </thead>

            <tbody>
            @if(!empty($value))
            @foreach($value as $fieldKey => $valu)
                <tr @if($loop->iteration==2) id="second" @endif>
                    @foreach($valu as $valueKey => $val)
                    <?php $pieces = preg_split('/(?=[A-Z])/', $valueKey);
                     $placeHolder = implode(' ', $pieces);
                    ?>
                    <td>
                    <div class="input-group">
                        <input type="text" class="form-control" autocomplete="off" name="{{@$config['data']['fieldName']}}[{{$valueKey}}][]" id="{{@$config['data']['id']}}_{{$valueKey}}_{{$fieldKey}}" value="{{@$val}}" placeholder="{{$placeHolder}}">

                    </div>
                    </td>
                    @endforeach
                    <td>
                        @if($loop->iteration==1)
                            <button type="button" class="add btn btn-primary plus_button " data-max-length="{{@$config['maxLength']?:10}}" onclick="addMore(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
                        @else
                            <button class="add btn btn-primary minus_button remove_on" type="button" onclick="removeThis(this)" ><i class="fa fa-minus"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                @foreach(@$config['data']['children'] as $key => $field)
                <td>
                <div class="input-group">
                        <input type="text" class="form-control {{@$field['config']['class']}}" autocomplete="off" name="{{@$field['config']['fieldName']}}" id="{{@$field['config']['id']}}_{{$key}}" value="" placeholder="{{@$field['config']['placeHolder']}}">
                </div>
                </td>
                @endforeach
                <td>
                <button type="button" class="add btn btn-primary plus_button" data-max-length="{{@$config['maxLength']?:10}}"  onclick="addMore(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
                </td>
                </tr>
                @endif
            </tbody>


        </table>

    </div>

</div>
</div>
<div class="input-group-append" style="display: none">
                        <span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>

@push('widgetScripts')
<script>
    $(document).ready(function(){
        $('.customheader').each(function(index, elem) {
            var eleName = $(elem).data('field-name');
            var elemClass = $(elem).data('field-class');
            $('[name="'+eleName+'"]').addClass(elemClass);
        });
    var datepickIcon = $('<div />', {'class': 'input-group-append', 'html': '<span class="input-group-text red"><i class="ni ni-calendar-grid-58"></i></span>', 'onclick':"$(this).parent().find('input').trigger('focus')"});
    $('.tablefull').find('.add_datepicker').parent().append(datepickIcon);
    $('.tablefull').find('.add_datepicker').removeClass('hasDatepicker').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});
    });
    function addMore (element) {
        $("#spanError").remove();
        var tableId = $(element).parent().parent().parent().parent().attr('id');
        var inputError=0;
        $("#"+tableId).find('tr td span div input').each(function(){
            if ($(this).val().trim() == '') {
                inputError++;
                $(this).parent().parent().after('<span id="spanError" class="error">This field is required.</span>');
                setTimeout(function(){
                    $('#spanError').remove();
                }, 1500);
            }
        });
        if (inputError == 0) {
            var allowedLength = $(element).data('max-length');
            var currentLength = $(element).parent().parent().parent().parent().find(".minus_button").length+2;
            if(currentLength <= allowedLength) {
            var childrens = $(element).parent().parent().clone();
            childrens.find('label').remove();
            childrens.find('.edited_data').remove();
            childrens.find('input').val('');
            childrens.find('input').addClass('required');
            childrens.find('input').each(function(){
                var id = $(this).attr('id')+ Math.random();
                $(this).attr('id', id);
            });
            childrens.find('.add_datepicker').removeClass('hasDatepicker').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true});

            var removeButton = $('<button />', {'class': 'add btn btn-primary minus_button remove_on','type':'button', 'html': '<i class="fa fa-minus"></i>', 'onclick':"removeThis(this)"});
            childrens.find('button').replaceWith(removeButton);
            $(element).parent().parent().parent().find('tr:last').after(childrens);
            }else {
                $(element).parent().parent().parent().parent().parent().find("#{{@$config['fieldName']}}_max_length_reached").show();
                setTimeout(() => {
                    $(element).parent().parent().parent().parent().parent().find("#{{@$config['fieldName']}}_max_length_reached").hide();
                }, 1500);

            }
        }
     }


    function removeThis (element) {
        $("#{{@$config['fieldName']}}_max_length_reached").hide();
        $(element).parent().parent().remove();
    }
</script>
@endpush
