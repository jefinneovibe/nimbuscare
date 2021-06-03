@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')

<style>
    .section_details{
        max-width: 100%;
        margin: 0;
        /* padding-bottom: 10px; */
    }
    .section_details .card_header{
        padding: 15px 19px;
    }
        .section_half{
            width: 100%;
            /* width: 50%; */
        }
        table {
        border-collapse: collapse;
        width: 100%;
        }
    th, tr {
        font-size: 11px;
        font-weight: 600;
        color: #707477;
        padding: 4px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    td{
        padding: 9px;
        font-size: 13px;
        text-align: left;
    }
    .section_details{
        max-width: 1300px;
        margin: 0 auto;
    }
    .select2-container {
        z-index: 999999999;
    }
    .select2.select2-container.select2-container--default {
        width: 50%!important;
    }
    .form-control, .is-focused .form-control {
        background-image: none;
    }
    .bmd-form-group .form-control{
        color: #4b515e;
        font-size: 14px !important;
        margin-left: 2px;
    }
    .ml-auto {
        margin: 0 23px 0 0;
        padding: 0;
    }
    .sort .custom_select .dropdown {
        min-width: 333px !important;
        /* width: 280px; */
        border: 1px solid #dddddd;
        padding: 7px 0 0 15px;
    }

    .add-file{
        border-radius:48%;
        background-color:dodgerblue;
        float:right;
        padding:20px;
        box-shadow:5px 5px 5px gray;
        margin-right:10px;
    }

    .panel-group {
        margin-bottom: 0px;
    }
    .empty{}
    .selectpicker_width .btn-group.bootstrap-select{
        width: 336px !important;
    }
    .selectpicker_width .bootstrap-select.btn-group .dropdown-menu{
        height: 300px;
    }
    .selectpicker_width .bootstrap-select .dropdown-toggle:hover, .bootstrap-select .dropdown-toggle:focus{
        outline: none !important;
        border-color: #D4D9E2 !important;
    }
    .form_input.valid{
        word-break: break-all;
    }
</style>

@php
    $role= session('role');
    if($role== 'Agent' || $role== 'Coordinator') {
        $permission= 'disabled';
    } else {
        $permission="";
    }
    $docs= count($docs)? $docs : "";
    $customerSession=session('customer_view');
    if(!isset($customerSession)) {
        $customerSession="";
    }
    if($docs) {
        $total=count($docs)-1;
    }
    else {
        $total=0;
    }
@endphp
<div class="section_details">
    <div class="card_header">
        <div class="media">
            <div class="media-body">
                <div class="selectpicker_width">
                    <label class="admin_panel_customer">Choose Customer</label>
                    <select id="chooseCustomer" name="customSort" onchange="chooseCustomer()">
                        @if(isset($customer->_id))
                            <option value="{{(string)$customer->_id}}" selected >{{$customer->fullName}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="media-right" style="margin-left: 10px;">
                <div class="search_form" id="custom_search" action="">
                    <input type="text" placeholder="Search.." id="search_doc" name="search2" value="">
                    <button type="button">
                        <i class="fa fa-search"></i>
                    </button>
                    <label id="search_key-error" class="error" for="search_key"></label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="">
        <div class="section_details">
            <div class="panel-group upload_scroll" id="result">
                <div class="table_bottom" id="tbl_docs">
                    <input type="hidden" id="hdn_count" value="{{$total}}">
                    <table>
                        <thead>
                            <th style="padding-left: 31px;">ATTACHMENT NAME</th>
                            <th style="padding-left: 31px;">UPLOADED DATE & TIME</th>
                            <th style="padding-left: 31px;"></th>
                        </thead>
                        <tbody id="add_result">
                            @if(! $docs)
                                @php
                                    $total=0;
                                @endphp
                                <tr class="empty" id="no_doc">
                                    <td>
                                        <h4 class="" style="margin-left:10px;">No documents found</h4>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @else
                                @foreach ($docs as $key => $item)
                                    @php
                                        $path=$item->filePath;
                                        $add="&name=".$item->updatedFullName;
                                    @endphp
                                    <tr id="attach_{{$key}}">
                                        <td style="padding-left:28px;">
                                            <div class="media">
                                                <span class="icon_bg">
                                                    <i class="fa fa-file-o icon_white" aria-hidden="true"></i>
                                                </span>
                                                <div class="media-body">
                                                    <span class="upload_file_name" style="word-break: break-all;">
                                                        {{$item->updatedFullName}}
                                                    </span>
                                                    <span id="{{$key}}">
                                                        @if (@$item->customerViewed!=1)
                                                            <span class="customer_status">
                                                                <span class="status_textsize">NEW</span>
                                                            </span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <td>{{$item->uploadedAt}}</td>
                                        <td>
                                            <div class="action_icon">
                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body"
                                                data-original-title="Download" onclick="downloadAttachment('{{$path}}', '{{$add}}')">
                                                    <i class="fa fa-cloud-download"></i>
                                                </button>
                                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                                onclick="view('{{$path}}')">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                @if ($permission != 'disabled')
                                                    <button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important" data-toggle="tooltip"
                                                    data-placement="bottom" data-container="body" data-original-title="Remove"
                                                    onclick="removeAttechConfirm('{{(string)$item->_id}}','{{(string)$customer->_id}}','{{$key}}')">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            @if($permission!= 'disabled')
                <div id="dv_file" class="upload_btn" onclick="showFileUpload()">
                    <a id=""  data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Upload">
                    <i class="fa fa-cloud-upload" style="color:white" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- load spinner --}}
<div id="load_spinner" style="display:none;text-align:center;position:fixed;top: 49%;left: 46%;z-index:2;">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;color:#9c27b0;"></i>
    <span class="sr-only">Loading...</span>
</div>
{{-- load spinner --}}


{{-- file upload --}}
<div id="file_upload">
    <div class="cd-popup">
        <div class="cd-popup-container">
        <form id="add_files" method="POST" enctype="multipart/form-data">
            <div class="modal_content">
                <div class="clearfix"></div>
                <div class="content_spacing">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"  {{--onblur="fileuploadValidation();"--}}>
                                        <label class="form_label">Upload File <span style="visibility: hidden">*</span></label>
                                        <div class="file-loading ">
                                            <input id="documents" type="file" name="documents" multiple >
                                        </div>
                                    </div>
                                    {{csrf_field()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <button type="button" class="btn btn-primary btn_action" style="background-color:gray" onclick="hideMessage()" >Cancel</button>
                <button class="btn btn-primary btn_action" type="submit" id="btn_file_sbmit">Upload</button>
            </div>
            </form>
            <div>
                <a href="#0" class="cd-popup-close img-replace"></a>
            </div>
        </div>
    </div>
</div>
{{-- file upload --}}

{{-- confirmation --}}
<div id="mdl_confirm">
    <div class="cd-popup">
        <div class="cd-popup-container">
        {{-- <form id="add_files" method="POST" enctype="multipart/form-data"> --}}
            <div class="">
                <div class="clearfix"></div>
                <div class="content_spacing">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 name="message" id="message" style="margin:0">Are you sure want to remove the file ?</h3>
                                    <input type="hidden" id="hdn_addCount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <button type="button" class="btn btn-primary btn_action" style="background-color:gray" onclick="hideMessage()" >Cancel</button>
                <button class="btn btn-primary btn_action" type="button" id="message_remove" onclick="removeDocAdditional()">Confirm</button>
            </div>
            {{-- </form> --}}
            <div>
            {{-- <a href="#0" class="cd-popup-close img-replace"></a> --}}
            </div>
        </div>
    </div>
</div>
{{-- confirmation --}}

{{-- confirmation --}}
<div id="attach_dlt_confirm">
        <div class="cd-popup">
            <div class="cd-popup-container">
            {{-- <form id="add_files" method="POST" enctype="multipart/form-data"> --}}
                <div class="">
                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- mailIndex, attachIndex, mailId --}}
                                        <input type="hidden" id="hdn_docIndex">
                                        <input type="hidden" id="hdn_rowCount">
                                       {{-- <input type="hidden" id="hdn_mailId"> --}}

                                        <h3 name="message" id="message" style="margin:0">Are you sure want to remove the file ?</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button type="button" class="btn btn-primary btn_action" style="background-color:gray" onclick="hideMessage()" >Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="" onclick="removeDoc()">Confirm</button>
                </div>
                {{-- </form> --}}
                <div>
                {{-- <a href="" class="cd-popup-close img-replace"></a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- confirmation --}}
</div>

@endsection
@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
        $(".js-example-basic-multiple").select2();
</script>
<script>
    $(".js-example-basic-multiple-post").select2();
</script>
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>
<!-- Fancy FileUpload -->
<script src="{{URL::asset('js/file-uploader/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('js/file-uploader/jquery.fancy-fileupload.js')}}"></script>

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<!-- Bootstrap Select -->
<script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>


<script>
    var output_file_name = [];
    var output_url_file = [];
    var output_url = [];
    var output_file = [];
    var totalFile=0;
    var file_length=0;
        $('#chooseCustomer').select2({
            ajax: {
                url: '{{URL::to('document/get-customers-list')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
                placeholder: "Select customer name",
                language: {
                    noResults: function() {
                        return 'No customers found';
                    },
                },
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo (repo) {
            $('.select2-search__field').attr('placeholder', 'Search your customer name');
            if (repo.loading) {
                return repo.text;
            }
            if(repo.customerCode!='')
            {
                var markup = repo.fullName+' ('+repo.customerCode+')';
            }
            else{
                var markup = repo.fullName;
            }
            return markup;
        }
        function formatRepoSelection (repo) {
            if(repo.fullName && repo.customerCode)
            {
                return repo.fullName +' ('+repo.customerCode +')';

            }else{
                return repo.text;

            }
        }

    function checkCustomer()
    {
        var customer= $('#chooseCustomer').find(':selected').val();
        customer= customer? customer : "";
        if(customer=="")
        {
            $('#dv_file').hide();
        }
        else
        {
            $('#dv_file').show();
        }

    }

    $(document).ready(function(){
        checkCustomer();
        $('#hdn_count').val({{$total}});

    });


    $('#btn_file_sbmit').click(function(){
        output_url = [];
        output_file = [];
        var valid=$('#add_files').valid();
        if(valid==true)
        {
            $('#btn_file_sbmit').prop('disabled','true');
            var queued=$('.ff_fileupload_queued').length;
            $('.ff_fileupload_remove_file').hide();
            // var queued = $('.file_upload_demo').find('.ff_fileupload_queued').length;
            //     $('.file_upload_demo').find('.ff_fileupload_remove_file').hide();
            var arraylen=queued;
            if(arraylen!=0)
            {
                file_length=arraylen;
                $('.ff_fileupload_actions button.ff_fileupload_start_upload').click();return false;
            }
            else
            {
                $('#add_files').submit();
            }
        }
    });

    $(function() {
        $('#documents').FancyFileUpload({
            params : {
                action : 'fileuploader'
            },
            url: '{{url('worktype-fileupload')}}',
            method: 'post',
            uploadcompleted: function (e, data) {
                output_url.push(data.result.file_url);
                output_file.push(data.result.file_name);
                data.ff_info.RemoveFile();
                file_length--;
                totalFile++;
                if (file_length == 0) {
                    $('#add_files').submit();
                }
            }
        });
    });

    function test()
    {
        $.ajax({
        type: "post",
        url: "{{url('customer-document/test')}}",
        data:
        {
            _token:'{{csrf_token()}}',

        },
        success: function(result)
        {
        }
        });
    }



    $('#add_files').validate({
        rules:
        {
            documents: {
                required: true,
                accept:"image/jpg,image/jpeg,image/png,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            }
        },
        messages:
        {
           documents:"Please upload file.",
           accept: "Please upload valid file(.png,.jpeg,.jpg,.pdf,.xls)"

        },
        submitHandler: function(form)
        {
            $('#file_upload .cd-popup').removeClass('is-visible');
            if(totalFile==0)
            {
                $("#btn_file_sbmit").removeAttr('disabled');
                $('#load_spinner').hide();
                return;
            }
            var form_data=new FormData($(form)[0]);
            form_data.append('output_url',output_url);
            form_data.append('output_file',output_file);
            $("#btn_file_sbmit").removeAttr('disabled');
            var customer=$('#chooseCustomer').find(':selected').val();
            form_data.append('customer',customer);
            var count=$('#hdn_count').val();
            $.ajax({
                type: form.method,
                url: "{{url('document/add-files')}}",
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,
                data:form_data,
                success: function(result)
                {
                    results=JSON.parse(result);
                    var file=$('#documents');
                    file.replaceWith(file.val('').clone(true));
                    var length=results.length;
                    $('.empty').remove();
                    results.forEach(function(result){
                        var down=result.fileName.split('.');
                        down=down[0];
                        count++;

                        $('#no_doc').fadeOut('slow',function()
                        {
                            $('#no_doc').remove();
                        });

                        $('#add_result').prepend(
                            '<tr id="attach_'+count+'">'+
                                '<td style="padding-left:28px;">'+
                                    '<div class="media">'+
                                        '<span class="icon_bg">'+
                                            '<i class="fa fa-file-o icon_white" aria-hidden="true"></i>'+
                                        '</span>'+
                                        ' <div class="media-body">'+
                                            '<span class="class="upload_file_name" style="word-break: break-all;"> '+result.fileName+'</span>'+
                                            '<span class="customer_status">'+
                                                '<span class="status_textsize">NEW</span>'+
                                            '</span>'+
                                        ' </div>'+
                                    '</div>'+
                                '</td>'+
                                '<td>'+result.uploadedAt+'</td>'+
                                '<td>'+
                                    '<div class="action_icon">'+
                                        '<a href="{{url('document/download?index=')}}'+result.filePath+'&name='+result.fileName+'">'+
                                            '<button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download">'+
                                                '<i class="fa fa-cloud-download"></i>'+
                                            '</button>'+
                                        '</a>'+
                                        '<button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"'+
                                        'onclick="view(\''+result.filePath+'\')">'+
                                            '<i class="fa fa-eye"></i>'+
                                        '</button>'+
                                        '<button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important"  data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove"'+
                                        'onclick="removeAttechConfirm(\''+result._id+'\',\''+result.customerId+'\',\''+count+'\')">'+
                                            '<i class="fa fa-trash" aria-hidden="true"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>'
                        );
                    });
                    $('#load_spinner').hide();
                    $('#hdn_count').val(count);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        }
    });

    function removeAttechConfirm(file, customerId, count)
    {
        $('#hdn_docIndex').val(file);
        $('#hdn_rowCount').val(count);
        $('#attach_dlt_confirm .cd-popup').addClass('is-visible');
    }

    function removeDoc()
    {
        var docIndex=$('#hdn_docIndex').val();
        var customer=$('#chooseCustomer').find(':selected').val();
        var count=$('#hdn_rowCount').val();


        $('#attach_dlt_confirm .cd-popup').removeClass('is-visible');
        $('#load_spinner').show();
        $.ajax({
            type: "post",
            url: "{{url('document/admin-remove-cust-doc')}}",
            data:
            {
                _token: '{{csrf_token()}}',
                docIndex: docIndex,
                customerIndex: customer
            },
            success: function(result)
            {
                $('#load_spinner').hide();
                if(result==1)
                {
                    $('#attach_'+count).fadeOut('slow',function()
                    {
                        $('#attach_'+count).hide();
                    });
                }
                else if(result==0)
                {
                    console.log("no");
                }
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }


    function view(path)
    {
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip('enable');
        window.open(path, '_blank','width=700, height=800, top=70, left=500, resizable=1, menubar=yes', false);

        return;
    }

    function hideMessage()
    {
        $('.cd-popup').removeClass('is-visible');
        $('.ff_fileupload_queued').remove();
        var file=$('#add_file');
        file.replaceWith(file.val('').clone(true));
        $('[data-toggle="tooltip"]').tooltip();

    }

    function showFileUpload()
    {
        if($('#chooseCustomer').find(':selected').val()=="")
        {
            return;
        }
        var file=$('#add_file');
        file.replaceWith(file.val('').clone(true));
        $('.ff_fileupload_queued').remove();
        $('#file_upload .cd-popup').addClass('is-visible');
        $('[data-toggle="tooltip"]').tooltip();

    }

    function loadFile()
    {
        var x=document.getElementById('add_file');
        if($('#add_file').val()!=null)
        {
            $('#uploading').html(x.files[0].name)
        }
    }

    function chooseCustomer()
    {
        $('#load_spinner').show();
        var selectedCustomer=$('#chooseCustomer').find(':selected').val();
        $.ajax({
            type:"post",
            url: "{{url('document/choose-customer')}}",
            data:
            {
                _token: '{{csrf_token()}}',
                customerId: selectedCustomer
            },
            success: function(result)
            {
                checkCustomer();
                $('#load_spinner').hide();
                $('#result').html("");
                $('#result').html(result);
                $('#search_doc').val("");
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="tooltip"]').tooltip('update');
            }
        });
    }

    $(function(){
        $('#search_doc').on('keyup', function(){
            var customer=$('#chooseCustomer').find(':selected').val();
            var key=$('#search_doc').val();
            if(! customer)
            {
                return;
            }
            $('#load_spinner').show();
            $.ajax({
                type:"post",
                url: "{{url('document/search-document')}}",
                data:
                {
                    _token: "{{csrf_token()}}",
                    customer: customer,
                    key: key
                },
                success: function(result)
                {
                    $('#load_spinner').hide();
                    $('#result').html("");
                    $('#result').html(result);
                    $('[data-toggle="tooltip"]').tooltip();
                }

            });
        });
    });

    function downloadAttachment(path, add)
    {
        $('[data-toggle="tooltip"]').tooltip('dispose');
        $('[data-toggle="tooltip"]').tooltip('enable');
        window.location.href="{{url('document/download?index=')}}"+path+add;
    }

</script>
@endpush

