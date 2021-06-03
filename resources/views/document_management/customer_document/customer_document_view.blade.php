@extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content')

<style>
  .section_details{
    max-width: 1050px;
    margin: 0 auto;
      padding-bottom: 10px;
  }
  .section_details .card_header{
    padding: 15px 19px;
  }
    .section_half{
        width: 100%;
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
    .upload_scroll {
        overflow: auto;
        height: 371px;
    }
    .section_details .card_header{
        border-bottom: none !important;
    }
    .custom_row{
        border-bottom:none;
        padding: 0;
        margin: 0;
        line-height: 0; 
        color: #cc3766;
    }

</style>
@php
// page for customer only
$customer=session('customer.customer_id');
@endphp
<div class="">
    <div class="">
        <div class="section_details">
             <div class="card_header  clearfix">
                <div class="media">
                    <div class="media-body">
                        <p style="color: #9c27b0;font-weight: 600;">Customer Name : {{session('customer.name')}}</p>
                    </div>
                    <div class="media-right" style="margin-left: 10px;">
                        <div class="search_form" id="custom_search">
                            <input type="text" placeholder="Search.." id="search_doc" name="search2" value="" autocomplete="off">
                            <button type="button"><i class="fa fa-search"></i></button>
                            <label id="search_key-error" class="error" for="search_key"></label>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="table_bottom upload_scroll" id="search_result">
                <table>
                    <thead>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if (count($docs))
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
                                                    @if (@$item->customerViewed==0)
                                                        <span class="customer_status">
                                                            <span class="status_textsize">NEW</span>
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>    
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action_icon">
                                            <a href="{{url('customer-document/download?index='.$path.$add)}}">
                                                <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download"
                                                onclick="customerViewed('{{$key}}', '{{(string)$item->_id}}')">
                                                    <i class="fa fa-cloud-download"></i>
                                                </button>
                                            </a>
                                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                            onclick="view('{{$path}}', '{{$key}}', '{{(string)$item->_id}}')">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- @endif --}}
                        @else
                            <h4 class="card_header" style="margin-left:18px;">No documents found</h4>
                        @endif
                    </tbody>    
                </table>
                @if(!isset($docs))
                <h4 class="" style="margin-left:10px;">No documents found</h4>
                @endif
            </div>
        </div>
    </div>

    <div class="">
            {{-- <div class="section_details"> --}}
                    {{-- <div class="card_header card_header_flex  clearfix">
                       <h3 class="title table_head">Customer Document</h3>
                   </div>  --}}
                   
               {{-- </div> --}}
    </div> 
</div>

        
@endsection
@push('scripts')
<script>


function view(path, count, index)
{
    var newWindow=window.open(path, '_blank','width=700, height=800, top=70, left=500, resizable=1, menubar=yes', false);
    customerViewed(count, index);
    
    return;
}

function customerViewed(count,index)
{
    $.ajax({
        type: 'post',
        url: "{{url('customer-document/customer-viewed')}}",
        data:
        {
            _token:'{{csrf_token()}}',
            index: index
        },
        success: function(result)
        {
            if(result)
            {
                $('#'+count).html("");
            }
        }
    });
    return;
}

$(function(){
    $('#search_doc').on('keyup', function(){
        $('#load_spinner').show();
        var customer="{{session('customer.customer_id')}}";
        var key=$('#search_doc').val();
        if(! customer)
        {
            $('#load_spinner').hide();
            return;
        }
        $.ajax({
            type:"post",
            url: "{{url('customer-document/search-customer-document')}}",
            data:
            {
                _token: "{{csrf_token()}}",
                customer: customer,
                key: key

            },
            success: function(result)
            {
                $('#load_spinner').hide();
                $('#search_result').html("");
                $('#search_result').html(result);
                $('[data-toggle="tooltip"]').tooltip('update');
            }

        });
    });
});


</script>
@endpush

