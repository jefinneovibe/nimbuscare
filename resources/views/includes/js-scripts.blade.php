<!-- jQuery -->
<script  src="{{ URL::asset('js/main/jquery-2.2.4.min.js')}}"></script>
<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Material kit -->
<script src="{{ URL::asset('js/main/bootstrap-material-design.min.js')}}"></script>
<script src="{{ URL::asset('js/bootstrap-tagsinput.js')}}"></script>
<script src="{{ URL::asset('js/main/material-kit.js?v=2.0.3')}}"></script>
<script src="{{ URL::asset('js/main/moment.min.js')}}"></script>

<script src="{{ URL::asset('js/main/bootstrap-select.js')}}"></script>

<!-- Navigation -->
<script src="{{ URL::asset('js/main/snap.svg-min.js')}}"></script>
@if (!Request::is('*/customer-questionnaire/*'))
<script src="{{ URL::asset('js/main/navigation.js')}}"></script>
@endif

<!-- Modal -->
<script src="{{ URL::asset('js/main/modal.js')}}"></script>

<script>
    // PreLoader
    $(function () {
        $(window).load(function() {
            $('#preLoader').fadeOut('slow');
        });
    });
</script>

<script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
<script src="{{URL::asset('widgetStyle/js/main/additional-methods.min.js')}}"></script>
{{-- <script src="{{ URL::asset('widgetStyle/js/script.js?v1.5')}}"></script> --}}
@stack('scripts')
