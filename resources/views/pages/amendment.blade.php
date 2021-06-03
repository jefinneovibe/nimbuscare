@extends('layouts.widget_layout')

@section('content')


<form>
<input type="hidden" id="workTypeDataId" value="{{@$workTypeDataId}}">
                <div class="dataatable comparesec">
                    <div id="admins">

                        <div class="materialetable">


                            <div  class="tablefixed heightfix">
                                <div class="table_left_fix">
                                    <div class="materialetable table-responsive">
                                        <table class="table customer_table">
                                            <thead>
                                            <tr>
                                                <th><div class="mainsquestion"><b class=" blue">Questions</b></div></th>
                                                <th><div class="mainsanswer" style="background-color: transparent"><b class=" blue">Customer Response</b></div></th>
                                            </tr>
                                            </thead>
                                            <tbody class="syncscroll" name="myElements">
                                                    @if($eComparisonData)
                                                        <?php $quest_feildName = []; ?>
                                                        @foreach(@$eComparisonData['review'] as $review)
                                                            @if($review['type'] == 'checkbox')
                                                                <?php  $quest_feildName[] =$review['fieldName'];?>
                                                                <tr class="">
                                                                    <td><div class="mainsquestion"><label class="titles">{{@$review['label']}}</label></div></td>
                                                                        @if($review['type'] == 'checkbox')
                                                                            <td class="mainsanswer"><div class="ans">Yes</div></td>
                                                                        @else
                                                                            <td class="mainsanswer">
                                                                                <div class="ans">
                                                                                    @if (@$review['value'])
                                                                                        {{@$review['value']}}
                                                                                    @else
                                                                                        --
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach(@$eComparisonData['forms'] as $forms)
                                                        <tr class="">
                                                            <?php  $quest_feildName[] =$forms['fieldName']; ?>
                                                            <td><div class="mainsquestion"><label class="titles">{{@$forms['label']}}</label></div></td>
                                                            @if(is_array(@$forms['value']))
                                                                @if(@$forms['fieldName'] == 'CombinedOrSeperatedRate')
                                                                    <td class="mainsanswer">
                                                                        <div class="ans">
                                                                            @if(@$forms['value']['seperateStatus'] == 'seperate')
                                                                                Admin Rate : {{@$forms['value']['adminRate']}}
                                                                                Non-Admin Rate : {{@$forms['value']['nonAdminRate']}}
                                                                            @else
                                                                                Combined Rate : {{@$forms['value']['combinedRate']}}
                                                                                @if (@$forms['value']['Premium'])
                                                                                <br>    Premium :  {{@$forms['value']['Premium']}}
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                    <td class="mainsanswer">
                                                                        <div class="ans">
                                                                            @if (isset($forms['value']['isChecked']) && @$forms['value']['isChecked'] == 'yes')
                                                                                Yes
                                                                            @else
                                                                            <?php
                                                                if (gettype(@$forms['value']) == 'array' && !empty(@$forms['value'])) {
                                                                    $indexArray =array_values($forms['value']);
                                                                    if (strtolower(@$indexArray[0]) == 'yes') {
                                                                        ?>
                                                                        yes
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        --
                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                        --
                                                                    <?php
                                                                }
                                                            ?>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                            @else
                                                                <td class="mainsanswer">
                                                                    <div class="ans">
                                                                            @if (@$forms['value'])
                                                                                {{@$forms['value']}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                <tr>
                                                    <td><div class="main_question"><label class="form_label bold">Customer Decision</label></div></td>
                                                    <td class="main_answer"><div class="ans"></div></td>
                                                </tr>
                                            {{-- @endif --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="table_right_pen">
                                    <div  id="scrollstyle" class="materialetable table-responsive">
                                    <table class="table comparison">
                                <thead>
                                    <tr>
                                        @if(@$Insurer)
                                            @foreach(@$Insurer as $key =>$Insurer1)
                                                <th><div class="ans">{{@$Insurer1['insurerDetails']['insurerName']}}</div></th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                    @if(@$InsurerData)
                                        @foreach (@$quest_feildName as $k =>$v)
                                            <?php
                                                $key=$v;
                                                $Insurer1=@$InsurerData[$v];
                                                $number=0;
                                                $insurerCount=count($Insurer);
                                            ?>
                                            <tr class="">
                                                @if(count(@$Insurer1)>0)
                                                    @foreach(@$Insurer1 as $key1 =>$Insurerr)

                                                        @if($loop->first && $key1!=$number)
                                                            @for($i=$number;$i<($key1-$number);$i++)
                                                                <td><div class="ans">--</div></td>
                                                            @endfor
                                                        @elseif(($key1-$number)>1)
                                                            @for($i=$number;$i<($key1-$number);$i++)
                                                                <td><div class="ans"></div></td>
                                                            @endfor
                                                        @endif
                                                        <?php $number=$key1; ?>

                                                        <td>
                                                            <div class="ans">
                                                                @if(@$formData[@$Insurerr['fieldName']]['fieldName'] == $key)
                                                                @if(@$Insurerr['agreeStatus'] == 'agreed')
                                                                Covered
                                                                @elseif(@$Insurerr['agreeStatus'] == 'disagreed')
                                                                Not Covered
                                                                @else
                                                                {{@$Insurerr['agreeStatus']}}
                                                                @endif
                                                                    @if(isset($Insurerr['comments']) && $Insurerr['comments'])
                                                                    <br>
                                                                    <span style="color:black;">{{$Insurerr['comments']}}</span>
                                                                    @endif
                                                                @else
                                                                <span class="removeTr" style="display:none"></span>
                                                                @endif
                                                                <?php
                                                            //   echo '<pre>'; print_r($Insurerr); echo 'abcd'; echo(@$formData[@$Insurerr['fieldName']]['fieldName']);  echo '</pre>';
                                                                    ?>
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @else
                                                    @for($i=0;$i<($insurerCount);$i++)
                                                        <td><div class="ans">--</div></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                        @if(@$Insurer)
                                            @foreach(@$Insurer as $key =>$Insurer2)
                                            <td><div class="ans">
                                                @if(@$Insurer2['customerDecision'])
                                                {{@$Insurer2['customerDecision']['decision']}}
                                                @if (@$Insurer2['customerDecision']['decision'] == 'Rejected')
                                                    @if($Insurer2['customerDecision']['rejectReason'])
                                                        (Reason: {{@$Insurer2['customerDecision']['rejectReason']}} )
                                                    @endif
                                                @endif
                                                <br>
                                               @if($Insurer2['customerDecision']['comment'])Comment: {{@$Insurer2['customerDecision']['comment']}} @endif
                                               @endif
                                            </div></td>
                                            @endforeach
                                        @endif
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row justify-content-end commonbutton">
    <button type="button" class="btn btn-primary btnload" onclick="gotoEslip()">
            Go to E-slip
    </button>
    @if(isset($formValues['status']['status']) &&
    ($formValues['status']['status']=='Quote Amendment' || $formValues['status']['status']=='Quote Amendment-E-slip' ||
    $formValues['status']['status']=='Quote Amendment-E-quotation' || $formValues['status']['status']=='Quote Amendment-E-comparison'))

        <button type="button" class="btn btn-primary btnload" onclick="closeCase()">
            Close the case
        </button>
    @endif

    </div> --}}

</form>

@include('popup.mail_attachment')

@endsection

@push('widgetScripts')

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>


<script>
//---------------------------for form----------------------------------
$(document).ready(function() {
    $('.removeTr').parent().parent().parent().remove();
});
$(function () {
  let show = 'show';

  $('input').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});


$(function () {
  let show = 'show';

  $('textarea').on('checkval', function () {
    let label = $(this).next('label');
    if(this.value !== '') {
      label.addClass(show);
   } else {
      label.removeClass(show);
    }
  }).on('keyup', function () {
    $(this).trigger('checkval');
  });
});


    // -------------------------------------------for table e quotation------------------------------------------------------------
    function resizeHandler() {
            // Treat each container separately
            $(".heightfix").each(function(i, heightfix) {
                // Stores the highest rowheight for all tables in this container, per row
                var aRowHeights = [];
                // Loop through the tables
                $(heightfix).find("table").each(function(indx, table) {
                    // Loop through the rows of current table
                    $(table).find("tr").css("height", "").each(function(i, tr) {
                        // If there is already a row height defined
                        if (aRowHeights[i])
                        // Replace value with height of current row if current row is higher.
                            aRowHeights[i] = Math.max(aRowHeights[i], $(tr).height());
                        else
                        // Else set it to the height of the current row
                            aRowHeights[i] = $(tr).height();
                    });
                });
                // Loop through the tables in this container separately again
                $(heightfix).find("table").each(function(i, table) {
                    // Set the height of each row to the stored greatest height.
                    $(table).find("tr").each(function(i, tr) {
                        $(tr).css("height", aRowHeights[i]);
                    });
                });
            });
        }
        $(document).ready(resizeHandler);
        $(window).resize(resizeHandler);

        $(function(){
            var rows = $('.materialetable tbody tr');

            rows.hover(function(){
                var i = $(this).GetIndex() + 1;
                rows.filter(':nth-child(' + i + ')').addClass('hoverx');
            },function(){
                rows.removeClass('hoverx');
            });
        });

        jQuery.fn.GetIndex = function(){
            return $(this).parent().children().index($(this));
        }

        function gotoEslip() {
            var id = $('#workTypeDataId').val();
            location.href = "{{url('eslip')}}"+'/'+id;
        }


        function closeCase()
        {
                var id = $('#workTypeDataId').val();
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('close-pipeline')}}',
                    data: {
                        id:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.href = "{{url('closed-pipelines')}}";
                        }
                    }
                });
        }
</script>
<script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
