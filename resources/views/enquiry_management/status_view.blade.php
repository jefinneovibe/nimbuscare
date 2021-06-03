@if(count(@$status)>0&&!empty($status))
@php
   
    $statusTotal=count($status);

 @endphp
<?php $count = 1; ?>
    @foreach(@$status as $stat)
        <div class="form_group clearfix">
        <div class="media">
        <div class="media-body">
            @if($count==1)
                <label class="form_label">Enter status <span>*</span></label>
            @else
                <label class="form_label">Another status1 <span>*</span></label>
            @endif
                    <input type="hidden"  @if($stat['uniqueValue']) value="{{$stat['uniqueValue']}}" @else value="0" @endif id="StatusHidden{{$count}}" name="StatusHidden[]">
                    <input class="form_input"  name="Status[]" id="Status{{$count}}"  placeholder="Status" value='{{$stat["statusName"]}}' onchange="" type="text">
                </div>
                <div class="media-right">
                    <div class="closure_checkbox">
                        <input type="hidden"  @if($stat['closureProperty']==1) value="1" @else value="0" @endif id="checkHidden{{$count}}" name="checkHidden[]">
                        <input type="checkbox" name="closureCheck[]" value="{{$count}}" id="closureCheck{{$count}}" onclick="checkBoxSelect(this);" class="inp-cbx" style="display: none"
                        <?php echo ($stat['closureProperty']==1)? "checked" : ""; ?> >
                        <label for="closureCheck{{$count}}" class="cbx">
                            <span>
                                <svg width="10px" height="8px" viewBox="0 0 12 10">
                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                </svg>
                            </span>
                            <span>Closure Behaviour</span>
                        </label>
                    </div>
                </div>
                    @if($count!=1)
                        <div class="remove_btn rm-renewal" id="total_minus{{$count}}" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Status"><i class="fa fa-minus"></i></div>
                    @elseif($count==1)
                         <div class="remove_btn" style="visibility:hidden"><i class="fa fa-minus"></i></div>
                    @endif 
                    <button class="btn btn-primary btn_action pull-right substatus_btn" id="buttonSubmit{{$count}}" type="button" onclick="displayPopUp(this);">Sub Status</button>
            </div>
        </div>
        @if(count(@$status)==$count)
            <div id="append_status"></div>
            <button class="add_another renewal" type="button" >Add Another Status</button>
        @endif
        <?php $count++; ?>
    @endforeach
@else
        <div class="form_group clearfix">
        <div class="media">
        <div class="media-body">
        <label class="form_label">Enter Status<span>*</span></label>
        <input type="hidden" value="0" id="StatusHidden" name="StatusHidden[]">
        <input class="form_input"  name="Status[]" id="Status"  placeholder="Status" value='' onchange="" type="text">
        </div>
        <div class="media-right">
            <div class="closure_checkbox">
                <input type="hidden" value="0" id="checkHidden" name=checkHidden[]>
                <input type="checkbox" name="closureCheck[]" value="" id="closureCheck" class="inp-cbx" style="display: none" onclick="checkBoxSelect(this);">
                <label for="closureCheck" class="cbx">
                    <span>
                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                    </span>
                    <span>Closure Behaviour</span>
                </label>
            </div>
       </div>
       <div class="remove_btn"  style="visibility:hidden"><i class="fa fa-minus"></i></div>

        <button class="btn" disabled style="visibility:hidden">Substatus</button>
        </div>
        <div id="append_status"></div>
        <button class="add_another renewal" type="button" >Add Another Status</button>
        </div>
@endif
<script>
    var wrapper_status = $("#StatusDiv"); //Fields wrapper
    var add_status_button = $(".renewal"); //Add button ID
    var x = 1; //initlal text box count
    $(add_status_button).click(function (e) { //on add another contact number
        e.preventDefault();
            x++; //text box increment
            $('#append_status').append(
                '<div class="form_group">'+
                '<div class="media">'+
                    '<div class="media-body">'+
                        '<label class="form_label">Another Status <span>*</span></label>' +
                        '<input type="hidden" value="0" id="StatusHidden_'+x+'" name="StatusHidden[]">'+
                        '<input class="form_input"  name="Status[]"  placeholder="Status" id="Status_'+x+'" type="text">' +
                    '</div>'+//add input box
                    '<div class="media-right">'+
                    '<div class="closure_checkbox">'+
                    '<input type="hidden" value="0" id="checkHidden_'+x+'" name=checkHidden[]>'+
                        '<input type="checkbox" name="closureCheck[]" value="" id="closureCheck_'+x+'" class="inp-cbx" style="display: none" onclick="checkBoxSelect(this);">'+
                        '<label for="closureCheck_'+x+'" class="cbx">'+
                        '<span>'+
                            '<svg width="10px" height="8px" viewBox="0 0 12 10">'+
                                    '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
                                '</svg>'+
                            '</span>'+
                            '<span>Closure Behaviour</span>'+
                        '</label>'+
                    '</div>'+
                  '</div>'+
                '<div class="remove_btn rm-renewal" id="total_minus_'+x+'"   data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove Status"><i class="fa fa-minus"></i></div>' +
                '<button class="btn" style="visibility:hidden" disabled>Substatus</button>'+
                '</div>'+
                '</div>');
                $('[data-toggle="tooltip"]').tooltip();

    });
    $('[data-toggle="tooltip"]').tooltip();

$(wrapper_status).on("click", ".rm-renewal", function (e) { //user click on remove contact
e.preventDefault();
$(this).parent().parent().remove();
x--;
$('.tooltip').hide();

});

function checkBoxSelect(obj)
{
    var id=obj.id;
    if($("#"+obj.id).prop('checked') == true){
        var splited=id.split("_");
        if(splited.length==2){
            $('#checkHidden_'+splited[1]).val(1);
        } else if(splited.length==1){
            var check= id.slice(12);
            $('#checkHidden'+check).val(1);
        }
    }
    else if($("#"+obj.id).prop('checked') == false){
        var splited=id.split("_");
        if(splited.length==2) {
            $('#checkHidden_'+splited[1]).val(0);
        } else if(splited.length==1){
            var check= id.slice(12);
            $('#checkHidden'+check).val(0);
        }
    }
}

    </script>
    <style>
.remove_btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #f45394;
    color: #fff;
    border: none;
    box-shadow: 0px 0px 10px 1px rgba(202,48,110,0.5);
    text-align: center;
    /* padding: 0; */
    margin-right: 4px;
    cursor: pointer;
    font-size: 12px;
    line-height: 30px;
    margin-left: 10px;
    margin-top: 26px;
    /* padding: 9px 0; */
}
.substatus_btn{
    padding: 6px 22px !important;
    margin-top: 27px !important;
    margin-left: 12px !important;
    background-color: #264cd8 !important;
    border: 1px solid #264cd8 !important;
}

</style>
