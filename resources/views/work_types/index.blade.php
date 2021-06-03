
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')

@endsection

@push('scripts')
    <script src="../js/main/fileinput.min.js"></script>
    <script>
        $("#file-1").fileinput({
            theme: 'en',
            uploadUrl: '#', // you must set a valid URL here else you will get an error
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize: 1000,
            maxFilesNum: 10,
            //allowedFileTypes: ['image', 'video', 'flash'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });


        $(function () {
            $(window).load(function() {
                $('#preLoader').fadeOut('slow');
            });
        });

    </script>
@endpush


