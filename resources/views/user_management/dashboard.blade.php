@extends('layouts.app')
@section('content')
@if((session('assigned_permissions')) && (in_array('User Management',session('assigned_permissions'))))
        <div class="row">
            <div class="dash_wrap">
                <div class="dash_list">
                   {{-- @if(session('role') == 'Admin') --}}
                        <div class="dash_cell">
                            <div class="cell_header">
                                <h2>Create User</h2>
                            </div>
                            <div class="cell_footer">
                                <a href="{{ url('user/create-user')}}">
                                    <div class="add_section violet">
                                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 490.2 490.2"><path d="M418.5 418.5c95.6-95.6 95.6-251.2 0-346.8s-251.2-95.6-346.8 0-95.6 251.2 0 346.8 251.2 95.6 346.8 0zM89 89c86.1-86.1 226.1-86.1 312.2 0s86.1 226.1 0 312.2-226.1 86.1-312.2 0S3 175.1 89 89z"/><path d="M245.1 336.9c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7v-67.3h67.3c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7 0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2-6.8 0-12.3 5.5-12.2 12.2v67.3h-67.3c-6.8 0-12.3 5.5-12.2 12.2 0 6.8 5.5 12.3 12.2 12.2h67.3v67.3c-.3 6.9 5.2 12.4 12 12.4z"/></svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="dash_cell">
                            <div class="cell_header">
                                <h2>View Users</h2>
                            </div>
                            <div class="cell_footer">
                                <a href="{{ url('user/view-user') }}" class="view_btn pink">
                                    <span>View Details</span>
                                    <span class="arrow">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                    <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                </svg>
                            </span>
                                </a>
                            </div>
                        </div>
                            {{-- @endif --}}
                    </div>        
                </div>
            </div>     
            @endif  
@endsection
@push('scripts')
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script>
    // PreLoader
    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
            localStorage.clear();
        });
    });
</script>

@endpush