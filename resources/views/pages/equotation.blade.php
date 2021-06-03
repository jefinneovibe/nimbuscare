@extends('layouts.widget_layout')
@section('content')
<form id="e_quat_form" name="e_quat_form" method="post" >
    <input type="hidden" value="{{$workTypeDataId}}" id="workTypeDataId" name="workTypeDataId">
    {{csrf_field()}}
    <div class="dataatable comparesec">
        <div id="admins">
            <div class="materialetable">
                <div  class="tablefixed heightfix">
                    <div class="table_left_fix">
                        <div class="materialetable table-responsive"><!-- -->
                            <table id="quest_Table" class="table customer_table">
                                <thead>
                                <tr>
                                    <th><div class="mainsquestion"><b class=" blue">Questions</b></div></th>
                                    <th><div class="mainsanswer" style="background-color: transparent"><b class=" blue">Customer Response</b></div></th>
                                </tr>
                                </thead>
                                <tbody class="syncscroll" id="top" name="myElements">
                                <!--Questions & customer response-->
                                <?php $quest_count = 0; $quest_feildName =[];?>
                                    @if($eQuotationData)
                                    @foreach(@$eQuotationData['review'] as $review)
                                        @if($review['type'] == 'checkbox')
                                        <?php $quest_count++; $quest_feildName[] =$review['fieldName'];?>
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
                                    @foreach(@$eQuotationData['forms'] as $forms)
                                    <?php $quest_count++;  $quest_feildName[] =$forms['fieldName']; ?>
                                    <tr class="">
                                        <td>
                                            <div class="mainsquestion">
                                                <label class="titles">
                                                    @if (isset($forms['preCustomerLabel']) && @$forms['preCustomerLabel'] != '')
                                                        {{@$forms['preCustomerLabel']}}
                                                    @else
                                                        {{@$forms['label']}}
                                                    @endif
                                                </label>
                                            </div>
                                        </td>
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
                                                            <br>Premium :  {{@$forms['value']['Premium']}}
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table_right_pen">
                        <div  id="scrollstyle" class="materialetable table-responsive">
                            <!--Insurance company responses-->
                            <table id="answer_Table" class="table comparison">
                                <thead>
                                    <tr>
                                        @if($insures_details)
                                            @foreach(@$insures_details as $key =>$Insurer)
                                                <th>
                                                    <div class="ans">
                                                        <div class ="row">
                                                            <div class="col-11">
                                                                <div class="custom-control custom-checkbox mb-3 ">
                                                                    <input @if ($selectedIds)
                                                                    @if (array_search(@$Insurer['uniqueToken'], $selectedIds) !== false)
                                                                    checked
                                                                @endif
                                                                    @endif class="custom-control-input check" id="customCheck{{$key}}" type="checkbox" headid="{{@$Insurer['uniqueToken']}}" value="{{@$Insurer['uniqueToken']}}" name="insure_check[]">
                                                                    <label class="custom-control-label" for="customCheck{{$key}}"> {{$Insurer['insurerDetails']['insurerName']}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="upload excel file">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            @endforeach
                                        @endif
                                        @if ($insures_name)
                                            @foreach ($insures_name as $key => $insurName)
                                                <th>
                                                    <div class="ans">
                                                        <div class ="row">
                                                            <div class="col-11 row">
                                                                <div class="col-11">
                                                                    {{$insurName}}
                                                                </div>
                                                                <div class="col-1">
                                                                    <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="Quotation for Insurer">
                                                                        <button onclick="get_insurer_quotation(this,'{{$insures_id[$key]}}','{{$workTypeDataId}}')" type="button" class="uploadbutton blue">
                                                                            <i class="fa fa-download" aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="pointer" data-toggle="tooltip" data-placement="right" data-container="body" data-original-title="upload excel file">
                                                                    <button onclick="get_excel_id('{{$insures_id[$key]}}','{{$workTypeDataId}}')" type="button" class="uploadbutton red"  data-toggle="modal" data-target="#modal-inusrer-excel">
                                                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="scrollstyle" class="syncscroll" name="myElements">
                                    @if($InsurerData)
                                        @foreach(@$quest_feildName as $k =>$v)
                                            <?php
                                                $key=$v;
                                                $Insurer=@$InsurerData[$v];
                                                $tdArray=[];
                                                $number=0;
                                                $insurerCount=count($insures_details);
                                            ?>
                                            <tr class="">
                                                @if(count(@$Insurer)>0)
                                                    @foreach(@$Insurer as $key1 =>$Insurerr)
                                                        <?php
                                                            $insuereId = '';
                                                            if(count($InsurerData['uniqueToken']) > $key1) {
                                                                if(isset($InsurerData['uniqueToken'][$key1])){
                                                                    $insuereId = @$InsurerData['uniqueToken'][$key1];
                                                                    if ($selectedIds) {
                                                                        if (array_search(@$InsurerData['uniqueToken'][$key1], $selectedIds) !== false) {
                                                                            $class = "insurer_select";
                                                                        }else{
                                                                            $class = "";
                                                                        }
                                                                    } else{
                                                                        $class = "";
                                                                    }
                                                                }
                                                            }
                                                        ?>
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
                                                        <td class="color{{@$insuereId}} {{$class}}" >
                                                            <div class="ans">
                                                                @if(@$formData[@$Insurerr['fieldName']]['fieldName'] == $key)
                                                                    <input type="text" class="inputstyle" style="display:none;" id="{{@$Insurerr['fieldName']}}_agreeStatus_{{@$insuereId}}">
                                                                    @if (@$Insurerr['agreeStatus'] != "agreed" && @$Insurerr['agreeStatus'] != "disagreed")
                                                                        <span onclick="viewInput(this)" class="edit-on-click">{{ucfirst(@$Insurerr['agreeStatus'])}}</span>
                                                                        <div  onclick="updateAgreeStatus(this, '{{@$insuereId}}', '{{@$Insurerr['fieldName']}}')" class="controls-update"> <a>update</a></div>
                                                                    @else
                                                                        @if (@$Insurerr['agreeStatus'] == "agreed" )
                                                                            <span onclick="viewInput(this)" class="edit-on-click">{{'Covered'}}</span>
                                                                            <div  onclick="updateAgreeStatus(this, '{{@$insuereId}}', '{{@$Insurerr['fieldName']}}')" class="controls-update"> <a>update</a></div>
                                                                        @else
                                                                            <span onclick="viewInput(this)" class="edit-on-click">{{'Not covered'}}</span>
                                                                            <div  onclick="updateAgreeStatus(this, '{{@$insuereId}}', '{{@$Insurerr['fieldName']}}')" class="controls-update"> <a>update</a></div>
                                                                        @endif
                                                                    @endif
                                                                    @if(isset($Insurerr['comments']) && @$Insurerr['comments'])
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <input class="form-control" id="{{@$Insurerr['fieldName']}}_comment_{{@$insuereId}}" placeholder="Comments" type="text" value="{{@$Insurerr['comments']}}" disabled style="background-color: white;">
                                                                                <div class="input-group-append">
                                                                                    <span onclick="changeUpdateSatatus('{{@$insuereId}}', '{{@$Insurerr['fieldName']}}')"  id="show-button_{{@$insuereId}}{{@$Insurerr['fieldName']}}" class="input-group-text red editbutton">
                                                                                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                                                        &nbsp;Edit
                                                                                    </span>
                                                                                    <span  onclick="updateComment('{{@$insuereId}}', '{{@$Insurerr['fieldName']}}')" id="hide-button_{{@$insuereId}}{{@$Insurerr['fieldName']}}" style="display:none;" class="input-group-text blue updatebutton">
                                                                                        &nbsp;Update
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <span id="{{@$Insurerr['fieldName']}}_error_{{@$insuereId}}" for="{{@$Insurerr['fieldName']}}_error_{{@$insuereId}}" class="error"></span>
                                                                        </div>
                                                                    @endif
                                                                @else
                                                                <span class="removeTr" style="display:none"></span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        {{-- @if($loop->last && $number!=$insurerCount && $loop->last != $loop->first)
                                                            @for($i=$number;$i<$insurerCount;$i++)
                                                                <td><div class="ans"></div></td>
                                                            @endfor
                                                        @endif --}}
                                                        <?php //$number=$key1; ?>
                                                    @endforeach
                                                    @foreach(@$insures_name as $key1 =>$insuresName)
                                                        <td class="color{{@$insures_id[$key1]}}">
                                                            <div class="ans">
                                                                --
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @else
                                                    @for($i=0;$i<($insurerCount + count($insures_name) );$i++)
                                                        <td><div class="ans">--</div></td>
                                                    @endfor
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        @if ($insures_name)
                                            @if($eQuotationData)
                                                @foreach(@$eQuotationData['review'] as $review)
                                                    @if($review['type'] == 'checkbox')
                                                        <tr>
                                                            @foreach(@$insures_name as $key1 =>$insuresName)
                                                                <td class="color{{@$insures_id[$key1]}}">
                                                                    <div class="ans">
                                                                        --
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                @foreach(@$eQuotationData['forms'] as $forms)
                                                    <tr>
                                                        @foreach(@$insures_name as $key1 =>$insuresName)
                                                            <td class="color{{@$insures_id[$key1]}}">
                                                                <div class="ans">
                                                                    --
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!------------------------------------------------modal-------------------------------------------->
    <div class="modal fade" id="modal-inusrer-excel" tabindex="-1" role="dialog" aria-labelledby="modal-inusrer-excel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
            <div class="modal-content  ">
                <form enctype="multipart/form-data" id="upload_excelFile" name="upload_excelFile" method="POST">
                        <input type="hidden" id="pipelinedetails_id" name="pipelinedetails_id">
                        <input type="hidden" id="insurer_id" name="insurer_id">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b class="titles">Upload File <span>*</span></b></label>
                                </div>
                            </div>
                            <div class="col-md-7 inputDnD">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="uploadExcelFile" name="uploadExcelFile" accept=".csv,.xlsx, .xls" onchange="readUrl(this)" data-title=" + Upload">
                                    <label class="custom-file-label" id="label_uploadExcelFile" for="uploadExcelFile">+ Upload your file</label>
                                    <span style="float: left" class="error" id="error-label"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="commonbutton modal-footer">
                        <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                        <button type="submit" id="upload_excel_btn" class="btn btn-primary btnload">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-----------------------------------------------modal end------------------------------------------>
@endsection
@push('widgetScripts')
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script>
        $(window).ready(function(){
            $("#answer_Table th").each(function() {
                thWidth     =   $(this).width();
                ownerIndex  =   $(this).index();
                $('#answer_Table tr td:nth-child('+ownerIndex+')').width(thWidth);
                $(this).find('input').each(function() {
                    if ($(this).prop('checked') === true) {
                        $('#answer_Table tr td').each(function(){
                            if (ownerIndex == $(this).index()) {
                                $(this).addClass('insurer_select');
                            }
                        });
                    }
                });
            });
        });
        function viewInput(t){
            var $text = $(t),
            $input =$($text).prev("input").attr('id');    // $('<input type="text" class="inputstyle" />')
            $text.hide().find("#"+$input).show();
            $(t).next('.controls-update').show();
            $("#"+$input).val($text.html()).show();
        }
        function updateAgreeStatus(t, insuereId, name) {
            var new_quot = $("#"+name+"_agreeStatus_"+insuereId).val().trim();
            var id = $('#workTypeDataId').val();
            if (new_quot != '') {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('eqoutation-edit')}}',
                    data: {
                        insuereId:insuereId,
                        field:name,
                        new_quot:new_quot,
                        workTypeDataId:id,
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                          location.reload();
                        }
                    }
                });
            } else {
                $(t).prev("input").show();
                $('#'+name+'_error_'+insuereId).html('Please enter a valid data');
            }
        }
        function changeUpdateSatatus(insuereId, name){
            $('#hide-button_'+insuereId+name).show();
            $('#show-button_'+insuereId+name).hide();
            $('#'+name+'_comment_'+insuereId).attr('disabled', false);
        }
        function updateComment(insuereId, name){
            var new_quot = $("#"+name+"_comment_"+insuereId).val().trim();
            var id = $('#workTypeDataId').val();
            if (new_quot != '') {
                $('#preLoader').show();
                $.ajax({
                    method: 'post',
                    url: '{{url('eqoutation-edit')}}',
                    data: {
                        insuereId:insuereId,
                        field:name,
                        new_quot:new_quot,
                        workTypeDataId:id,
                        comment:"comment",
                        _token: '{{csrf_token()}}'
                    },
                    success:function(data){
                        if(data == 'success')
                        {
                            location.reload();
                        }
                    }
                });
            } else {
                $(document).ready(resizeHandler);
                $(window).resize(resizeHandler);
                $('#'+name+'_error_'+insuereId).html('Please enter a valid data');
            }
        }
        $('.edit-on-click').click(function(){
            $(document).ready(resizeHandler);
        });
        //for file upload
        function readUrl(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                let imgData = e.target.result;
                let imgName = input.files[0].name;
                input.setAttribute("data-title", imgName);
                console.log(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        function get_insurer_quotation(elem,insurer_id,pipeline_id) {
            $(elem).attr("disabled", "disabled" );
            $.ajax({
                method: 'POST',
                url: '{{url('generate-insurer-pdf')}}',
                data: {_token:"{{csrf_token()}}", insurer_id:insurer_id,pipeline_id:pipeline_id},
                success: function (result) {
                    if (result.status== 'success') {
                        $(elem).removeAttr("disabled");
                        window.open(result.pdf_file, '_blank');
                    }
                }
            });
        }
        function get_excel_id(insurer_id,pipeline_id)
        {
            $('#uploadExcelFile').val('');
            $('#label_uploadExcelFile').text('+ Upload your file');
            $("#error-label, #uploadExcelFile-error").hide();
            $('#upload_excelFile').find("#uploadExcelFile").attr('data-title',' + Upload');
            $('#upload_excelFile').find('#pipelinedetails_id').val(pipeline_id);
            $('#upload_excelFile').find('#insurer_id').val(insurer_id);
        }
        //---------------------------for form----------------------------------
        $(document).ready(function() {
            $('.removeTr').parent().parent().parent().remove();
            /* Form submit for selected insurers in e-quotation */
            $("#e_quat_form").validate({

                ignore: [],
                rules: {
                    'insure_check[]': {
                        required: true
                    }
                },
                messages: {
                    'insure_check[]': "Please select one of insurer."
                },

                errorPlacement: function (error, element) {
                    error.insertBefore(element.parent().parent().parent().parent());
                    $(document).ready(resizeHandler);
                    $(window).resize(resizeHandler);
                },
                submitHandler: function (form,event) {
                    var form_data = new FormData($("#e_quat_form")[0]);
                    form_data.append('_token', '{{csrf_token()}}');
                    $('#preLoader').show();
                    $("#eqotationBtnSubmit").attr( "disabled", "disabled" );
                    $.ajax({
                        method: 'post',
                        url: '{{url('equotation-selected-insurers')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result== 'success') {
                                window.location.href = '{{url('ecomparison/'.$workTypeDataId)}}';
                            }
                        }
                    });
                }
            });
            $("#upload_excelFile").validate({

                ignore: [],
                rules: {
                    uploadExcelFile: {
                        required: true,
                        accept: "application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    }
                },
                messages: {
                    uploadExcelFile: "Please upload a valid excel sheet."
                },

                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form,event) {
                    var form_data = new FormData($("#upload_excelFile")[0]);
                    var excel = $('#uploadExcelFile').prop('files')[0];
                    form_data.append('file', excel);
                    form_data.append('_token', '{{csrf_token()}}');
                    $('#preLoader').show();
                    $("#upload_excel_btn").attr( "disabled", "disabled" );
                    $.ajax({
                        method: 'post',
                        url: '{{url('save-excel-temporary')}}',
                        data: form_data,
                        cache : false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result == 1) {
                                window.location.href = "{{url('excel-imported-list')}}";
                            } else if(result.length > 1) {
                                $("#upload_excel_btn").attr( "disabled", false );
                                $('#preLoader').hide();
                                $('#error-label').html('The file you uploaded is not a Quotation.');
                                $('#error-label').show();
                            } else if (result == 3) {
                                $("#upload_excel_btn").attr( "disabled", false );
                                $('#preLoader').hide();
                                $('#error-label').html('Please upload a file after editing the excel.');
                                $('#error-label').show();
                            } else {
                                $("#upload_excel_btn").attr( "disabled", false );
                                $('#preLoader').hide();
                                $('#error-label').html('The file you uploaded is not a Quotation.');
                                $('#error-label').show();
                            }
                        }
                    });
                }
            });
        });
        function saveAndSubmitLater(steps){
            var form_data = new FormData($("#e_quat_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                form_data.append('type', 'draft');
                $.ajax({
                method: 'post',
                url: '{{url('equotation-selected-insurers')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    location.reload();
                    if (result== 'success') {
                        window.location.reload();
                    }
                }
            });
        }
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
        // -------------------------------------------for table e quotation------
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
        // insurer select script
        $('.check').click(function(){
            headid = $(this).attr('headid');
            ownerIndex = $(this).parents().parents().parents().parents().parents().index();
            if(this.checked){
                $('.color'+headid).addClass('insurer_select');
                $('#answer_Table tr td').each(function(){
                    if (ownerIndex == $(this).index()) {
                        $(this).addClass('insurer_select');
                    }
                });
            }else{
                $('.color'+headid).removeClass('insurer_select');
                $('#answer_Table tr td').each(function(){
                    if (ownerIndex == $(this).index()) {
                        $(this).removeClass('insurer_select');
                    }
                });
            }
        });
    </script>
    <script src="{{URL::asset('js/syncscroll.js')}}"></script>
@endpush
