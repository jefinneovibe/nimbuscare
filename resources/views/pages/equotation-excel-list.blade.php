@extends('layouts.widget_layout')


@section('content')
<style>
#content{
    width: 100% !important;
}
.error{
  color: red;
}
</style>
@if(empty($data_excel))
    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">Error!!!</h4>
        <p>
            please upload a valid excel.
        </p>
    </div>
@endif
    <form id="excel_save_form">
        <div class="dataatable comparesec">
            <div id="admins">
                <div class="materialetable">
                    <div  class="tablefixed heightfix commonfix">
                        <div class="table_left_fix">
                            <div class="materialetable table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><div class="mainsquestion"><b class="blue">Questions</b></div></th>
                                        </tr>
                                    </thead>
                                    <tbody class="syncscroll" name="myElements">
                                        @if($data_excel)
                                            @foreach(@$data_excel as $review)
                                                <tr class="">
                                                    <td><div class="mainsquestion"><label class="titles">{{@$review['questions']}}</label></div></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="table_right_pen">
                            <div  id="scrollstyle" class="materialetable table-responsive">
                                <input type="hidden" name="workTypeDataId" id="workTypeDataId" value="{{@$workTypeDataId}}">
                                <input type="hidden" name="insurer_id" id="insurer_id" value="{{@$insurer_id}}">
                                <table class="table comparison">
                                    <thead>
                                        <tr>
                                            @if($data_excel)
                                            <th><div class="mainsquestion"><b>Customer Response</b></div></th>
                                            <th><div class="mainsquestion"><b>Your Response</b></div></th>
                                            <th><div class="mainsquestion"><b>Comments If Required</b></div></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                        @if($data_excel)
                                            @foreach(@$data_excel as $key  => $review)

                                                <tr class="">
                                                    <td><div class="mainsquestion">
                                                            <input type="hidden" name="{{@$formData[$key]}}[fieldName]" value="{{@$formData[$key]}}">
                                                        <label class="titles">{{@$review['customer_response']}}</label></div></td>
                                                    <td>
                                                        <div class="mainsquestion">
                                                            <div class="form-group row">
                                                                <div class="col-12 input-group">
                                                                    <input onchange="checkInput(this)" name="{{$formData[$key]}}[agreeStatus]" @if (@$review['insurer_response'])value="{{@$review['insurer_response']}}"@endif class="form-control requiredValidation" id="insurer_response_{{$key}}" type="text">
                                                                </div>
                                                                <span class="error {{@$formData[$key]}}_error" id="insurer_response_{{$key}}_error" style="display: none;">Please enter your response</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mainsquestion">
                                                            <div class="form-group row">
                                                                <div class="col-12 input-group">
                                                                    <input onkeyup="onchange(this)" name="{{@$formData[$key]}}[comments]" @if (@$review['comments'])value="{{@$review['comments']}}"@endif class="form-control requiredValidation" id="comments_{{$key}}" type="text">
                                                                </div>
                                                                <span class="error {{@$formData[$key]}}_error" id="comments_{{$key}}_error" style="display: none;">Please enter your response</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="row justify-content-end commonbutton">
            <button id="excelFormSubmit_btn" type="button" onclick="excelFormSubmit()" class="btn btn-primary btnload">
                SAVE AND SUBMIT
            </button>
        </div>
    </form>
@endsection

@push('widgetScripts')

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script>

        $(document).ready(function() {
            $('.removeTr').parent().parent().parent().remove();
        });

        // ---------------------for table e quotation----------------------- //

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

        function checkInput(t) {
            attrName = $(t).attr('name');
            attrVal = $(t).val().trim();
            if (attrVal != '') {
                $("#"+$(t).attr('id')+'_error').hide();
            } else {
                $("#"+$(t).attr('id')+'_error').html('Please enter your response').show();
            }
            if (attrName == 'repatriationExpenses[agreeStatus]') {
                if (isNaN(attrVal)) {
                    $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                } else {
                    $("#"+$(t).attr('id')+'_error').hide();
                }
            }
            if (attrName == 'medicalExpense[agreeStatus]') {
                if (isNaN(attrVal)) {
                    $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                } else {
                    $("#"+$(t).attr('id')+'_error').hide();
                }
            }
            if (attrName == 'brokerage[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        if (attrVal > 100) {
                            $("#"+$(t).attr('id')+'_error').html('Please enter a percentage below 100').show();
                        } else {
                            $("#"+$(t).attr('id')+'_error').hide();
                        }
                    } else {
                        $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                    }
                } else {
                    $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                }
            }
            if (attrName == 'warranty[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        $("#"+$(t).attr('id')+'_error').hide();
                    } else {
                        $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                    }
                } else {
                    $("#"+$(t).attr('id')+'_error').html('Please enter a digit').show();
                }
            }
        }

        function excelFormSubmit() {
            $("#excelFormSubmit_btn").attr( "disabled", true );
            var fail = 0;
            $("#excel_save_form").find('input').each(function() {
                attrId = $(this).attr('id');
                attrVal = $(this).val().trim();
                attrName = $(this).attr('name');
                if (attrVal == '' && attrId.startsWith('insurer_response')) {
                    fail++;
                    $("#"+attrId+'_error').show().html('This feild is required.');
                }
                else{
                    $("#"+attrId+'_error').hide();
                }
                if (attrName == 'repatriationExpenses[agreeStatus]') {
                if (isNaN(attrVal)) {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                } else {
                    $("#"+attrId+'_error').hide();
                }
            }
            if (attrName == 'medicalExpense[agreeStatus]') {
                if (isNaN(attrVal)) {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                } else {
                    $("#"+attrId+'_error').hide();
                }
            }
            if (attrName == 'brokerage[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        if (attrVal > 100) {
                            fail++;
                            $("#"+attrId+'_error').html('Please enter a percentage below 100').show();
                        } else {
                            $("#"+attrId+'_error').hide();
                        }
                    } else {
                        fail++;
                        $("#"+attrId+'_error').html('Please enter a digit').show();
                    }
                } else {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                }
            }
            if (attrName == 'warranty[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        $("#"+attrId+'_error').hide();
                    } else {
                        fail++;
                        $("#"+attrId+'_error').html('Please enter a digit').show();
                    }
                } else {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                }
            }
            if (attrName == 'exclusion[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        $("#"+attrId+'_error').hide();
                    } else {
                        fail++;
                        $("#"+attrId+'_error').html('Please enter a digit').show();
                    }
                } else {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                }
            }
            if (attrName == 'specialCondition[agreeStatus]') {
                if (attrVal != '') {
                    if (!isNaN(attrVal)){
                        $("#"+attrId+'_error').hide();
                    } else {
                        fail++;
                        $("#"+attrId+'_error').html('Please enter a digit').show();
                    }
                } else {
                    fail++;
                    $("#"+attrId+'_error').html('Please enter a digit').show();
                }
            }
            });
            $(document).ready(resizeHandler);
            $(window).resize(resizeHandler);
            if (fail == 0) {
                $("#excel_save_form").submit();
            }else{
                $("#excelFormSubmit_btn").attr( "disabled", false );
            }
        }

        $("#excel_save_form").validate({
            ignore: [],
            rules: {
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                error.insertBefore(element);
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#excel_save_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#excelFormSubmit_btn").attr( "disabled", true );
                $.ajax({
                    method: 'post',
                    url: '{{url('save-excel-imported-list')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        console.log(result);

                        if (result == 'success') {
                            window.location.href = '{{url("equotation/".@$workTypeDataId)}}';
                        }else {
                            $('#preLoader').hide();
                            $('#fail_excel').show();
                            $("#excelFormSubmit_btn").attr( "disabled", false );
                        }
                    }
                });
            }
        });

    </script>
    <script src="{{URL::asset('js/syncscroll.js')}}"></script>

@endpush
