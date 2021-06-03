@if(count(@$renewStatus)>0&&!empty($renewStatus))
<?php $countSub = 1; ?>
    @foreach(@$renewStatus as $status)
        <div class="form_group clearfix">
            @if($countSub==1)
                <label class="form_label">Enter sub status(Renewal) <span>*</span></label>
            @else
                <label class="form_label">Another sub status(Renewal) <span>*</span></label>
            @endif
            <div class="table_div">
                <div class="table_cell">
                    <input class="form_input"  name="subStatus[]" id="subStatus{{$countSub}}"  placeholder="Sub Status(Renewal)" value='{{$status}}' onchange="" type="text">
                </div>
                <div class="table_cell">
                    @if($countSub!=1)
                        <div class="remove_btn rm-renewalSub" id="subStatusTools{{$countSub}}" data-toggle="tooltip" data-placement="right" data-original-title="Remove renewal sub status"><i class="fa fa-minus"></i></div>
                    @endif
                </div>
            </div>
        </div>
        @if(count(@$renewStatus)==$countSub)
            <div id="append_renewal"></div>
            <button class="add_another  statusClass" type="button" >Add Another Sub Status</button>
        @endif
        <?php $countSub++; ?>
    @endforeach
@else
        <div class="form_group clearfix">
        <label class="form_label">Enter sub status(Renewal) <span>*</span></label>
        <input class="form_input"  name="subStatus[]" id="subStatus"  placeholder="Sub Status(Renewal)" value='' onchange="" type="text">
        <div id="append_renewal"></div>
        <button class="add_another statusClass" type="button" >Add Another Sub Status</button>
        </div>
@endif
<script>
    var wrapper_renewal = $("#substatusDiv"); //Fields wrapper
    var add_renewal_button = $(".statusClass"); //Add button ID
    var subRow = 1; //initlal text box count
    $(add_renewal_button).click(function (e) { //on add another contact number
        e.preventDefault();
            subRow++; //text box increment
            $('#append_renewal').append(
                '<div class="form_group">'+
                '<label class="form_label">Another sub status(Renewal) <span>*</span></label>' +
                '<div class="table_div">' +
                '<div class="table_cell">' +
                '<input class="form_input"  name="subStatus[]"  placeholder="Sub Status(Renewal)" id="subStatus_'+subRow+'" type="text">' +
                '</div>'+//add input box
                '<div class="table_cell" >' +
                '<div class="remove_btn rm-renewalSub" id="subStatusTool_'+subRow+'" data-toggle="tooltip" data-placement="right"  data-original-title="Remove renewal sub status"><i class="fa fa-minus"></i></div>' +
                '</div>'+
                '</div>'+
                '</div>');
                $('[data-toggle="tooltip"]').tooltip();

    });
    $('[data-toggle="tooltip"]').tooltip();
$(wrapper_renewal).on("click", ".rm-renewalSub", function (e) { //user click on remove contact
e.preventDefault();
$(this).parent().parent().parent('div').remove();
subRow--;
$('.tooltip').hide();

});

    </script>
