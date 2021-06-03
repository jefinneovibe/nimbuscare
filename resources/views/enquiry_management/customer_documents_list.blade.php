{{-- @extends('layouts.document_management_layout')

@section('sidebar')
    @parent
@endsection

@section('content') --}}

<style>
  .section_details{
      max-width: 100%;
      margin: 0;
      padding-bottom: 10px;
  }
  .section_details .card_header{
    padding: 15px 19px;
  }
    .section_half{
        width: 50%;
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

</style>
@php
// page for admin to view customer window
@endphp
@php
    $role=session('role');
    $customerSession=session('customer_view');
    if(!isset($customerSession))
    {
        $customerSession="";
    }
@endphp
{{-- <div class="section_flex">
    <div class="section_half">
        <div class="section_details">
             <div class="card_header card_header_flex  clearfix">
                <h3 class="title table_head">Customer Document</h3>
            </div>  --}}
            @if($docs=="" && $additional=="")
            <h4 class="" style="margin-left:10px;">No documents fount</h4>
            @else
            <div class="table_bottom" id="tbl_docs">
                    <table>
                       <thead>
                           <th>ATTACHMENT NAME</th>
                           <th>UPLOADED DATE & TIME</th>
                           <th></th>
                       </thead>
                       <tbody id="add_result">
                            @if (session('role')=="Admin")
                                @php
                                    $mailCount=0;
                                @endphp
                                @foreach ($docs as $file)
                                    @php
                                        $attachCount=0;
                                    @endphp
                                    @foreach ($file->attachements as $item)
                                        @php
                                        if((@$item['postedToCustomerIndex']))
                                        {
                                            $sessions=(String)$item['postedToCustomerIndex'];
                                        }
                                        else {
                                            $sessions="";
                                        }
                                        @endphp
                                        @if ($sessions==$customerSession)
                                            @php
                                                $path=$item['attachPath'];
                                                $ext=explode('.',$path);
                                                $ext=end($ext);
                                                $name;
                                                if(isset($item['suffix']))
                                                {
                                                    $suffix=$item['suffix'];
                                                }
                                                else {
                                                    $suffix="";
                                                }
                                                if(isset($item['updatedName']))
                                                {
                                                    $name=$item['updatedName'].".".$ext;
                                                }
                                                else
                                                {
                                                    // $name=explode('/',$path);
                                                    // $name=end($name);
                                                    $name=$item['attachName'];
                                                }
                                                $downloadName=explode('.',$name);
                                                $downloadName=$downloadName[0];
                                                $name=$downloadName.(($suffix!="")? "-".$suffix.".".$ext : ".".$ext);
                                                $downloadName=explode('.',$name);
                                                $downloadName=$downloadName[0];
                                                $add="&name=".$name;
                                                
                                            @endphp
                                            <tr id="attach_{{$mailCount.$attachCount}}">
                                                <td>
                                                    <div class="media">
                                                        <span class="icon_bg">
                                                            <i class="fa fa-file-pdf-o icon_white" aria-hidden="true"></i> 
                                                        </span>
                                                        <div class="media-body">
                                                            <span class="upload_file_name" style="word-break: break-all;">
                                                                {{$name}}
                                                            </span>
                                                            <span id="mail_{{$mailCount.$attachCount}}">
                                                                @if (@$item['customerViewed']!=1)
                                                                    <span class="customer_status">
                                                                        <span class="status_textsize">NEW</span>
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        </div>    
                                                    </div>
                                                </td>
                                                <td>{{$item['lastUpdate']}}</td>
                                                <td>
                                                    <div class="action_icon">
                                                        <a href="{{url('document/download?index='.$path.$add)}}" download="{{$downloadName}}">
                                                            <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download">
                                                                <i class="fa fa-cloud-download"></i>
                                                            </button>
                                                        </a>
                                                        <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                                        onclick="view('{{url($path)}}')">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove"
                                                            onclick="removeAttechConfirm('{{$mailCount}}','{{$attachCount}}','{{$file->_id}}')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        @php
                                            $attachCount++;
                                        @endphp
                                    @endforeach
                                    @php
                                        $mailCount++;
                                    @endphp
                                    @endforeach
                                @endif
            @endif
            @if($additional!="")
                @php
                    $addCount=0;
                @endphp
                @foreach ($additional as $item)
                    @if (@$item['status']==1)
                        
                        @php
                            $download=explode('.',$item['fileName']);
                            $download=$download[0];
                        @endphp
                            
                        <tr id="add_{{$addCount}}">
                            <td>
                                <div class="media">
                                    <span class="icon_bg">
                                        <i class="fa fa-file-pdf-o icon_white" aria-hidden="true"></i> 
                                    </span>
                                    <div class="media-body">
                                        <span class="upload_file_name" style="word-break: break-all;">
                                            {{$item['fileName']}}
                                        </span>
                                        <span id="add_{{$addCount}}">
                                            @if (@$item['customerViewed']!=1)
                                                <span class="customer_status">
                                                    <span class="status_textsize">NEW</span>
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                            </div>
                            </td>
                            <td>{{$item['uploadedAt']}}</td>
                            <td>
                                <div class="action_icon">
                                    <a href="{{url('document/download?index='.$item['url'])}}" download="{{$download}}">
                                        <button class="blue_btn attach_icons action-icon-download" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Download">
                                            <i class="fa fa-cloud-download"></i>
                                        </button>
                                    </a>
                                    <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="View"
                                    onclick="view('{{$item['url']}}')">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="blue_btn attach_icons action-icon-view" style="background-color: #ea5449 !important" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Remove"
                                                        onclick="removeDocConfirm('{{$addCount}}','{{session('customer_view')}}')">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                </div>
                            </td>
                        </tr>
                        @php
                            $addCount++;
                        @endphp
                    @endif
                @endforeach
            @endif


            </tbody>    
        </table>
                
    </div>
        
<script>
// function view(path)
// {
//     window.open(path, 'Win 1','width=700, height=800, top=70, left=500, resizable=1, menubar=yes', true);
//     // customerViewed(mail,attachCount,mailCount);
//     return;
// }


// function removeDocAdditional(count,customer)
// {
//     // return;
//     // console.log(mailIndex, attachIndex, mailId);
//     $.ajax({
//         type: "post",
//         url: "{{url('document/admin-remove-additional')}}",
//         data:
//         {
//             _token: '{{csrf_token()}}',
//             attachIndex: count,
//             customerId: customer
//         },
//         success: function(result)
//         {
//             // console.log(result);
//             if(result==1)
//             {
//                 $('#add_'+count).fadeOut('slow',function()
//                 {
//                     $('#add_'+count).remove();
//                 });
//             }
//             else if(result==0)
//             {
//                 console.log("no");
//             }
//         }
//     });
// }

// function removeDoc(mailIndex, attachIndex, mailId)
// {
//     // console.log(mailIndex, attachIndex, mailId);
//     $.ajax({
//         type: "post",
//         url: "{{url('document/admin-remove-cust-doc')}}",
//         data:
//         {
//             _token: '{{csrf_token()}}',
//             attachIndex: attachIndex,
//             mailId: mailId
//         },
//         success: function(result)
//         {
//             // console.log(result);
//             if(result==1)
//             {
//                 $('#mail_'+mailIndex+attachIndex).fadeOut('slow',function()
//                 {
//                     $('#mail_'+mailIndex+attachIndex).remove();
//                 });
//             }
//             else if(result==0)
//             {
//                 console.log("no");
//             }
//         }
//     });
// }


</script>

