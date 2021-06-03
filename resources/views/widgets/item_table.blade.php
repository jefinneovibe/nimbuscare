
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
/*.customselect{
    height:38px !important;
}*/
.customselect{
    height:30px !important;
}
.itemTableClass td {
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
$replacementTotal = 0;
if (!empty($value)) {
    foreach ($value as $k => $valu) {
        if (gettype($valu) == 'array'){
            foreach ($valu as $key => $val) {
                if ($val) {
                    $output[$key][$k] = $val;
                }
            }
        }
    }
    $value = $output;
}
$classForTotal = 0;
?>

<div class="col-{{@$config['style']['col_width']}}" >
<span id="{{@$config['fieldName']}}_max_length_reached" class="error" style="display:none">Maximum length reached</span>
<h6>Specification of Machinary to be insured</h6>
<table class="itemTableClass" id="{{$config['id']}}_table">
<thead>
@foreach($config['columns'] as $thead)
    <th width="{{@$thead['width']}}%" @if (isset($thead['calculateTotal']) && @$thead['calculateTotal']) <?php $classForTotal = 1; ?>   class="classForTotal" @endif >
        <label class="titles">{{$thead['name']}}
        @if (isset($thead['required']) && $thead['required'])
            <span>*</span>
        @endif
        @if($thead['info'])
            <i data-toggle="tooltip" data-placement="top" title="{{@$thead['info']}}" data-container="body" class="fa fa-info red"></i>
        @endif
    </label>
    </th>
@endforeach
</thead>
<tbody>
@if(empty($value))
    <tr class="cloneable" @if(!empty($value)) style="display:none" @endif >
        <td>
            <div class="form-group">
                <input type="text" class="form-control numberOnly @if(empty($value)) required @endif" name="{{@$config['fieldName']}}[itemNumbers][]" id="{{@$config['id']}}_itemNumbers" value="" placeholder="Enter number">
            </div>
        </td>
        <td>
            <div class="form-group">
                <textarea class="form-control @if(empty($value)) required @endif"  name="{{$config['fieldName']}}[itemDescriptions][]" id="{{@$config['id']}}_itemDescriptions" rows="1" placeholder="Enter description"></textarea>
            </div>
        </td>
        <td>
            <div class="form-group">
                <select class=" form-control customselect fillYears @if(empty($value)) required @endif" data-live-search="true" name="{{$config['fieldName']}}[yearofMfg][]" id="{{@$config['id']}}_yearOfManufacture" >
                </select>
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="text" class="form-control @if(empty($value)) required @endif" name="{{@$config['fieldName']}}[remarks][]" id="{{@$config['id']}}_remarks" value="" placeholder="Enter remarks">
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="text" class="form-control floatAmount @if(empty($value)) required @endif" name="{{@$config['fieldName']}}[replacementValues][]" id="{{@$config['id']}}_replacementValue" value="" placeholder="Enter replacement value">
            </div>
        </td>
        <td>
            <button type="button" class="add btn btn-primary plus_button" onclick="addMoreofThis(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
        </td>
    </tr>
@endif
@if(!empty($value))
    @foreach($value as $fieldKey => $valu)
        <tr @if($loop->iteration==2) id="second" @endif>
            @foreach($valu as $valueKey => $val)
                <?php
                    $pieces = preg_split('/(?=[A-Z])/', $valueKey);
                    $placeHolder = implode(' ', $pieces);
                ?>
                @if($valueKey == 'yearofMfg')
                    <td>
                        <div class="form-group">
                            <select class=" form-control customselect fillYears required" data-value="{{$val}}" data-live-search="true" name="{{$config['fieldName']}}[yearofMfg][]" id="{{@$config['id']}}_yearOfManufacture_{{$valueKey}}_{{$fieldKey}}" >
                            </select>
                        </div>
                    </td>
                @elseif($valueKey == 'itemDescriptions')
                    <td>
                        <div class="form-group">
                            <textarea class="form-control required"  name="{{$config['fieldName']}}[itemDescriptions][]" id="{{@$config['id']}}_itemDescriptions_{{$valueKey}}_{{$fieldKey}}" rows="1" placeholder="Enter description">{{$val}}</textarea>
                        </div>
                    </td>
                @else
                    <td>
                        @if (@$valueKey == 'replacementValues') <?php  $replacementTotal = @$replacementTotal + @$val; ?> @endif
                        <div class="form-group">
                            <input type="text" class="form-control @if (@$valueKey == 'replacementValues') floatAmount @endif required" name="{{@$config['fieldName']}}[{{$valueKey}}][]" id="{{@$config['id']}}_{{$valueKey}}_{{$fieldKey}}" value="{{@$val}}" placeholder="{{$placeHolder}}">
                        </div>
                    </td>
                @endif
            @endforeach
            <td>
                @if($loop->iteration==1)
                    <button type="button" class="add btn btn-primary plus_button " onclick="addMoreofThis(this)" ><i class="fa fa-plus" aria-hidden="true"></i> </button>
                @else
                    <button class="add btn btn-primary minus_button remove_on" type="button" onclick="removeItemThis(this)" ><i class="fa fa-minus"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
@endif
    @if (@$classForTotal == 1)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:right"><label class="titles" >Total:</label></td>
            <td>
                <input placeholder="Total" value="{{@$replacementTotal}}" readonly class="form-control" type="text" name="{{@$config['fieldName']}}[replacementValuesTotal]" id="fieldTotal">
            </td>
        </tr>
    @endif
</tbody>
</table>

</div>

@push('widgetScripts')
<script>
$(window).load(function(){
    fillYears('{{@$config['fieldName']}}_yearOfManufacture');
    $('.fillYears').each(function(){
        var id = $(this).attr('id');
        var value = $(this).data('value');
        fillYears(id, value);
    });

    var thIndex = $(".classForTotal").index()+1;
    $(document).on('keyup', ".itemTableClass input",function () {
        if ((parseFloat($(this).parent().parent().index()) + 1) == thIndex) {
            var tableTotal = 0;
            $(".itemTableClass tbody tr td:nth-child("+ thIndex +") input").not(":hidden, #fieldTotal").each (function(){
                if ($(this).val() != '') {
                    tableTotal = parseFloat(tableTotal)  + parseFloat($(this).val());
                }
            });
            $("#fieldTotal").val(tableTotal);
        }
    });
});



function fillYears(id, value) {
    var end = 1950;
    var start = new Date().getFullYear();
    var options = "<option disabled selected>Select</option>";
    for(var year = start ; year >=end; year--){
        if(year === value) {
            options += "<option selected>"+ year +"</option>";
        } else {
            options += "<option>"+ year +"</option>";
        }
    }
    $("#"+id).append(options).trigger('change');

}


function addMoreofThis (element, hidden) {
    var allowedLength = "{{@$config['maxLength']?:10}}";
    var currentLength = $(".minus_button").length+2;
    if(currentLength <= allowedLength) {
        var childrens = $(element).parent().parent().clone();
        if(hidden == true) {
        var childrens = $(element).parents(".cloneable:hidden:first").clone();
        childrens.show();
        }
        childrens.find('label').remove();
        childrens.find('.edited_data').remove();
        childrens.find('input, textarea').val('');
        childrens.find('input, select, textarea').each(function(){
            $(this).addClass('required');
            var id = $(this).attr('id')+ Math.random();
            $(this).attr('id', id);
        });
        childrens.find('select').each(function(){
            $(this).val('Select').trigger('change');
         });
        childrens.find('.numberOnly').each(function(){
            var id = $(this).attr('id');
            $("#"+id).rules("add", {
                digits : true
            });
        });
        var removeButton = $('<button />', {'class': 'add btn btn-primary minus_button remove_on','type':'button', 'html': '<i class="fa fa-minus"></i>', 'onclick':"removeItemThis(this)"});
        childrens.find('button').replaceWith(removeButton);
        if ($('#fieldTotal').length != 0) {
            $('#fieldTotal').parent().parent().parent().before(childrens);
        } else {
            $('#{{$config['id']}}_table tr:last').after(childrens);
        }

    } else {
        $("#{{@$config['fieldName']}}_max_length_reached").show();
        setTimeout(() => {
            $("#{{@$config['fieldName']}}_max_length_reached").hide();
        }, 1500);

    }

}

function cloneParent(element) {
    var clonable = $(element).parent().parent().parent().find('.plus_button');
    addMoreofThis(clonable, true);

}
function removeItemThis (element) {
    $("#{{@$config['fieldName']}}_max_length_reached").hide();
        $(element).parent().parent().remove();
        var tableTotal = 0;var thIndex = $(".classForTotal").index()+1;
    $(".itemTableClass tbody tr td:nth-child("+ thIndex +") input").not(":hidden, #fieldTotal").each (function(){
        if ($(this).val() != '') {
            tableTotal = parseInt(tableTotal)  + parseInt($(this).val());
        }
    });
    $("#fieldTotal").val(tableTotal);
}
</script>
@endpush
