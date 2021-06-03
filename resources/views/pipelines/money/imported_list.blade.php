
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Money</h3>
        </div>

            <div class="alert alert-danger alert-dismissible" role="alert" id="fail_excel" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               Excel Upload Failed.
            </div>

        <div class="card_content">
            <div class="edit_sec clearfix">
                <form id="import_list_form" name="import_list_form" method="post" >
                    <input type="hidden" value="{{@$pipeline_id}}" id="pipeline_id" name="pipeline_id">
                    <input type="hidden" value="{{@$insurer_id}}" id="insurer_id" name="insurer_id">
                    {{csrf_field()}}
                    <div class="data_table compare_sec">
                        <div id="admin">
                            <div class="material-table">
                                <div class="table-header">
                                    <span class="table-title">Please Review & Submit</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table comparison table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Questions</th>
                                            <th>Customer Response</th>
                                            <th>Insurer Response</th>
                                            <th>Insurer Comments</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 0;
                                        $data_count=count($data);
                                        $array_count=$data_count-1;
                                        ?>

                                        @foreach(@$data as $data_answers)
                                            {{--@if($count<$array_count)--}}
                                            <tr>
                                                <td class="main_question">
                                                    <input class="form_input" type="hidden" name="questions[]" id="questions{{$count}}"  value="{{$data_answers['questions']}}">
                                                    {{$data_answers['questions']}}</td>
                                                <td class="main_answer">
                                                    <input class="form_input" type="hidden" name="customer_response[]" id="customer_response{{$count}}"  value="{{$data_answers['customer_response']}}">
                                                    {{$data_answers['customer_response']}}
                                                </td>
                                                <td><textarea class="form_input min_height"  name="insurer_response[]" id="insurer_response{{$count}}">{{$data_answers['insurer_response']}}</textarea> </td>
                                                <?php if(isset($data_answers['comments']))
                                                	{
		                                                $comments=$data_answers['comments'];
                                                    }
                                                    else{
	                                                    $comments='--';
                                                    }
                                                ?>
                                                <td><input class="form_input" name="new_comments[]" id="new_comments_{{$count}}"  value="{{$comments}}"> </td>
                                            </tr>
                                                {{--@endif--}}
                                            <?php  $count++?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">Proceed</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .min_height {
            min-height: auto !important;
            padding: 10px 10px 0;
        }
    </style>

@endsection
@push('scripts')
    <!--jquery validate-->
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>

    <script>
        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });



        //import excel form validation//
        $("#import_list_form").validate({
            ignore: [],
            rules: {
                'insurer_response[]': {
                    required: true
                }
            },
            messages: {
                'insurer_response[]': "This Field Is Required."
            },
            errorPlacement: function (error, element) {
                error.insertBefore(element);
            },
            submitHandler: function (form,event) {
                var form_data = new FormData($("#import_list_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('money/save-imported-list')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        console.log(result);
                        if (result.success== 'success') {
                            window.location.href = '{{url('money/e-quotation/'.@$pipeline_id)}}';
                        }else if (result.success== 'failed') {
                            $('#preLoader').hide();
                            $('#fail_excel').show();
                            $("#button_submit").attr( "disabled", false );
                        }
                    }
                });
            }
        });
        //end//


        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize(){
            var el = this;
            setTimeout(function(){
                el.style.cssText = 'height:auto; padding:0';
                // for box-sizing other than "content-box" use:
                // el.style.cssText = '-moz-box-sizing:content-box';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
            },0);
        }
        $(document).ready(function () {
            setTimeout(function() {
                $('#fail_excel').fadeOut('fast');
            }, 5000);
        });
    </script>
@endpush
