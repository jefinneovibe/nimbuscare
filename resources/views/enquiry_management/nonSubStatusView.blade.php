@if(count(@$nonenewStatus)>0&&!empty($nonenewStatus))
<?php $count = 1; ?>
    @foreach(@$nonenewStatus as $status)
        <div class="form_group clearfix">
            @if($count==1)
                <label class="form_label">Enter sub status(Non Renewal) <span>*</span></label>
            @else
                <label class="form_label">Another sub status(Non Renewal) <span>*</span></label>
            @endif
            <div class="table_div">
                <div class="table_cell">
                    <input class="form_input"  name="subStatusNon[]" id="subStatusNon{{$count}}"  placeholder="Sub Status(Non Renewal)" value='{{$status}}' onchange="" type="text">
                </div>
                <div class="table_cell">
                    @if($count!=1)
                        <div class="remove_btn rm-nonStatus" id="subStatusNonTool{{$count}}"  data-toggle="tooltip" data-placement="right" data-original-title="Remove non renewal sub status"><i class="fa fa-minus"></i></div>
                    @endif
                </div>
            </div>
        </div>
        @if(count(@$nonenewStatus)==$count)
            <div id="append_nonRenewal"></div>
            <button class="add_another nonRenewal" type="button" >Add Another Sub Status</button>
        @endif
        <?php $count++; ?>
    @endforeach
    @else
    <div class="form_group clearfix">
    <label class="form_label">Enter sub status(Non Renewal) <span>*</span></label>
    <input class="form_input"  name="subStatusNon[]" id="subStatusNon"  placeholder="Sub Status(Non Renewal)" value='' onchange="" type="text">
    <div id="append_nonRenewal"></div>
    <button class="add_another nonRenewal" type="button" >Add Another Sub Status</button>
    </div>
@endif
<script>
var add_nonRenewal_button = $(".nonRenewal"); //Add button ID
var wrapper_nonRenewal = $("#substatusDiv"); //Fields wrapper
var row = 1;
$(add_nonRenewal_button).click(function (e) { //on add another email id
    e.preventDefault();
        row++; //text box increment
        $('#append_nonRenewal').append(
            '<div class="form_group">'+
            '<label class="form_label">Another sub status(Non Renewal) <span>*</span></label>' +
            '<div class="table_div">' +
            '<div class="table_cell">' +
            '<input class="form_input"  name="subStatusNon[]"  id="subStatusNon_'+row+'"  placeholder="Sub Status(Non Renewal)" type="text">' +
            '</div>'+//add input box
            '<div class="table_cell" >' +
            '<div class="remove_btn rm-nonStatus"  data-toggle="tooltip" data-placement="right" data-original-title="Remove renewal sub status"><i class="fa fa-minus"></i></div>' +
            '</div>'+
            '</div>'+
            '</div>');
            $('[data-toggle="tooltip"]').tooltip();

});

$('[data-toggle="tooltip"]').tooltip();
$(wrapper_nonRenewal).on("click", ".rm-nonStatus", function (e) { //user click on remove contact
    e.preventDefault();
    $(this).parent().parent().parent('div').remove();
    row--;
    $('.tooltip').hide();

});

    </script>
