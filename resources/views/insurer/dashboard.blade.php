@extends('layouts.insurer_layout')


@section('content')
        <div class="row">

            <div class="dash_wrap">

                <div class="dash_list">
                    <div class="dash_cell half">
                        <div class="cell_header">
                            <h2>E-quotes to be Provided</h2>
                            <h1 class="value">{{$total_quots}}</h1>
                        </div>
                        <div class="cell_footer">
                            <a href="{{ url('insurer/e-quotes-provider') }}" class="view_btn pink">
                                <span>View Details</span>
                                <span class="arrow">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 31.49 31.49">
                                <path d="M21.205 5.007a1.112 1.112 0 0 0-1.587 0 1.12 1.12 0 0 0 0 1.571l8.047 8.047H1.111A1.106 1.106 0 0 0 0 15.737c0 .619.492 1.127 1.111 1.127h26.554l-8.047 8.032c-.429.444-.429 1.159 0 1.587a1.112 1.112 0 0 0 1.587 0l9.952-9.952a1.093 1.093 0 0 0 0-1.571l-9.952-9.953z" fill="#1e201d"/>
                            </svg>
                        </span>
                            </a>
                        </div>
                    </div>
                    <div class="dash_cell half">
                        <div class="cell_header">
                            <h2>E-quotes Given</h2>
                            <h1 class="value">{{$total_given}}</h1>
                        </div>
                        <div class="cell_footer">
                            <a href="{{url('insurer/equotes-given')}}" class="view_btn green">
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

            </div>

        </div>
@endsection
@push('scripts')
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