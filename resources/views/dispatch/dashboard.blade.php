@extends('layouts.dispatch_layout')


@section('content')
@if((session('assigned_permissions')) && (in_array('Dispatch',session('assigned_permissions'))))
        <div class="row">
            <div class="dash_wrap">
                <div class="dash_list">
                    @if(isset(session('permissions')['lead']) || isset(session('permissions')['reception']) || session('role') == 'Agent')
                        <div class="dash_cell">
                            <div class="cell_header">
                                <h2>Temporary Customers</h2>
                                {{--<h1 class="value">{{$totalCustomer}}</h1>--}}
                            </div>
                            <div class="cell_footer">
                                <a href="{{ url('customers/0/show') }}" class="view_btn pink">
                                    <span>View Details</span>
                                    <span class="arrow">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                    <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                </svg>
                            </span>
                                </a>
                            </div>
                        </div>
                        <div class="dash_cell">
                            <div class="cell_header">
                                <h2>Permanent Customers</h2>
                                {{--<h1 class="value">{{$totalCustomer}}</h1>--}}
                            </div>
                            <div class="cell_footer">
                                <a href="{{ url('customers/1/show') }}" class="view_btn pink">
                                    <span>View Details</span>
                                    <span class="arrow">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                    <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                </svg>
                            </span>
                                </a>
                            </div>
                        </div>
                        <div class="dash_cell">
                            <div class="cell_header">
                                <h2>Recipients</h2>
                                {{--<h1 class="value">{{$totalCustomer}}</h1>--}}
                            </div>
                            <div class="cell_footer">
                                <a href="{{ url('dispatch/recipients') }}" class="view_btn pink">
                                    <span>View Details</span>
                                    <span class="arrow">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                    <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                </svg>
                            </span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="dash_cell">
                        <div class="cell_header">
                            <h2>Leads</h2>
                            {{--<h1 class="value">2305</h1>--}}
                        </div>
                        <div class="cell_footer">
                            <a href="{{ url('dispatch/dispatch-list') }}" class="view_btn green">
                                <span>View Details</span>
                                <span class="arrow">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                            </svg>
                        </span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="dash_list">

                    <div class="dash_cell">
                        <div class="cell_header">
                            <h2>ALL Leads</h2>
                        </div>
                        <div class="cell_footer">
                            <a href="{{ url('dispatch/all-leads') }}" class="view_btn green">
                                <span>View Details</span>
                                <span class="arrow">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                            <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                        </svg>
                    </span>
                            </a>
                        </div>
                    </div>

                @if(isset(session('permissions')['lead']) || isset(session('permissions')['reception']))
                    <div class="dash_cell">
                        <div class="cell_header">
                            <h2>Add Customers</h2>
                        </div>
                        <div class="cell_footer">
                            <a href="{{ url('customers/create') }}">
                                <div class="add_section violet">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 490.2 490.2"><path d="M418.5 418.5c95.6-95.6 95.6-251.2 0-346.8s-251.2-95.6-346.8 0-95.6 251.2 0 346.8 251.2 95.6 346.8 0zM89 89c86.1-86.1 226.1-86.1 312.2 0s86.1 226.1 0 312.2-226.1 86.1-312.2 0S3 175.1 89 89z"/><path d="M245.1 336.9c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7v-67.3h67.3c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7 0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2-6.8 0-12.3 5.5-12.2 12.2v67.3h-67.3c-6.8 0-12.3 5.5-12.2 12.2 0 6.8 5.5 12.3 12.2 12.2h67.3v67.3c-.3 6.9 5.2 12.4 12 12.4z"/></svg>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="dash_cell">
                        <div class="cell_header">
                            <h2>Add Recipients</h2>
                        </div>
                        <div class="cell_footer">
                            <a href="{{ url('dispatch/create-recipients') }}">
                                <div class="add_section violet">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 490.2 490.2"><path d="M418.5 418.5c95.6-95.6 95.6-251.2 0-346.8s-251.2-95.6-346.8 0-95.6 251.2 0 346.8 251.2 95.6 346.8 0zM89 89c86.1-86.1 226.1-86.1 312.2 0s86.1 226.1 0 312.2-226.1 86.1-312.2 0S3 175.1 89 89z"/><path d="M245.1 336.9c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7v-67.3h67.3c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7 0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2-6.8 0-12.3 5.5-12.2 12.2v67.3h-67.3c-6.8 0-12.3 5.5-12.2 12.2 0 6.8 5.5 12.3 12.2 12.2h67.3v67.3c-.3 6.9 5.2 12.4 12 12.4z"/></svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
                    </div>
                    <div class="dash_list">
                        @if(isset(session('permissions')['create_lead']))
                            <div class="dash_cell">
                                <div class="cell_header">
                                    <h2>Create Lead</h2>
                                </div>
                                <div class="cell_footer">
                                    <a href="{{ url('dispatch/create-lead')}}">
                                        <div class="add_section violet">
                                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 490.2 490.2"><path d="M418.5 418.5c95.6-95.6 95.6-251.2 0-346.8s-251.2-95.6-346.8 0-95.6 251.2 0 346.8 251.2 95.6 346.8 0zM89 89c86.1-86.1 226.1-86.1 312.2 0s86.1 226.1 0 312.2-226.1 86.1-312.2 0S3 175.1 89 89z"/><path d="M245.1 336.9c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7v-67.3h67.3c3.4 0 6.4-1.4 8.7-3.6 2.2-2.2 3.6-5.3 3.6-8.7 0-6.8-5.5-12.3-12.2-12.2h-67.3v-67.3c0-6.8-5.5-12.3-12.2-12.2-6.8 0-12.3 5.5-12.2 12.2v67.3h-67.3c-6.8 0-12.3 5.5-12.2 12.2 0 6.8 5.5 12.3 12.2 12.2h67.3v67.3c-.3 6.9 5.2 12.4 12 12.4z"/></svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif

                            <div class="dash_cell">
                                <div class="cell_header">
                                    <h2>Employee Login</h2>
                                    {{--<h1 class="value">{{$totalCustomer}}</h1>--}}
                                </div>
                                <div class="cell_footer">
                                    <a href="#" id="login_employee" class="view_btn pink">
                                        <span>View Details</span>
                                        <span class="arrow">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                        <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                    </svg>
                                </span>
                                    </a>
                                </div>
                            </div>
                        @if(session('role') == 'Admin')
                            <div class="dash_cell">
                                <div class="cell_header">
                                    <h2>Location Report</h2>
                                </div>
                                <div class="cell_footer">
                                    <a href="{{ url('maps/view-map') }}" class="view_btn pink">
                                        <span>View Details</span>
                                        <span class="arrow">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                    <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                                </svg>
                            </span>
                                    </a>
                                </div>
                            </div>
                            @endif

                    </div>
                </div>
            </div>
{{--Popup for employee login--}}
        <div id="login_popup">
            <div class="cd-popup">
                <form method="post" id="login_form" name="login_form">
                    <div class="cd-popup-container">
                        <div class="modal_content">
                            <div class="clearfix"></div>
                            <div class="content_spacing">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span><h1 id="success_message">Login</h1></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>Enter unique code : </span>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form_input" type="password" id="password" name="password">
                                        <br>
                                        <span class="error" id="password-error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal_footer">
                            <button class="btn btn-primary btn_action pull-right" type="submit">OK</button>
                            <button class="btn btn_cancel btn_action btn-cancel " type="button">Cancel</button>
                        </div>
                    </div>
                </form>
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
    $('#login_employee').on('click', function(){
        $('#login_popup .cd-popup').addClass('is-visible');
    });
    $("#login_form").validate({
        ignore: [],
        rules: {
            password: {
                required: true
            },
        },
        messages: {
            password: "Please enter unique code.",
        },
        errorPlacement: function (error, element) {
            if(element.attr("name") == "docName[]"
                || element.attr("name") == "type[]")
            {
                error.insertAfter(element.parent());
            }
            else{
                error.insertAfter(element);
            }

        },
        submitHandler: function (form,event) {
            var form_data = new FormData($("#login_form")[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#preLoader').show();
            $("#button_submit").attr( "disabled", "disabled" );
            $.ajax({
                method: 'post',
                url: '{{url('dispatch/employee-login')}}',
                data: form_data,
                cache : false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if(result == 'not_found')
                    {
                        $('#preLoader').hide();
                        $('#password-error').html('Unique code does not exist.')
                    }
                    else if(result == 'success')
                    {
                        location.href = '{{url('dispatch/employee-view-list')}}';
                    }
                }
            });
        }
    });
    //end//
</script>

@endpush
