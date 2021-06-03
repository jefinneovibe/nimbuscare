@extends('layouts.document_management_layout')

@section('settings')

<style>
    .section_details {
        max-width: 780px;
    }
    .section_details .card_content {
        padding: 0px !important;
        margin-bottom: 10px; 
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
    font-size: 14px;
    padding: 5px 0 10px 21px;
    text-align: left;
}
</style>


<div class="section_details">
    <div class="card_header clearfix">
        <h3 class="title" style="margin-bottom: 8px;">Settings</h3>
    </div>
    <div class="card_content">
        <div class="email_sec clearfix">
                {{-- <div class="media email_bottom">
                    <div class="media-body">
                        <label class="email_tag">aiswarya@neovibe.in</label>
                    </div>
                    <div class="media-right">
                        <a href="{{url('document/document-edit-settings')}}">
                        <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit">
                            <i class="fa fa-pencil">
                            </i>
                        </button>
                        </a>
                    </div>
                </div> --}}
            <table>
                <thead></thead>
                <tbody>
                    @foreach ($credentials as $item)
                        <tr>
                            <td> {{$item['userID']}}</td>
                            <td><a href="{{url('document/document-edit-settings/'.$item['_id'])}}">
                                <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit Mail">
                                    <i class="fa fa-pencil">
                                    </i>
                                </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                     {{-- <tr>
                        <td> vipin@neovibe.in</td>
                        <td><a href="{{url('document/document-edit-settings')}}">
                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit">
                                <i class="fa fa-pencil">
                                </i>
                            </button>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td> archana@neovibe.in</td>
                        <td><a href="{{url('document/document-edit-settings')}}">
                            <button class="blue_btn attach_icons action-icon-view" data-toggle="tooltip" data-placement="bottom" data-container="body" data-original-title="Edit">
                                <i class="fa fa-pencil">
                                </i>
                            </button>
                            </a>
                        </td>
                    </tr> --}}
                </tbody>
            </table>        
                
                
                
        </div> 
    </div>
    <div class="email_btn clearfix">
        <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit" onclick="addCredential()">Add Email</button>
    </div>  
</div>


@push('scripts')
<script>

function addCredential()
{
    console.log("hi0");
    window.location.href="{{url('document/document-settings')}}";
}

</script>
@endpush
    
@endsection