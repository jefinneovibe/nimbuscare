
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- argon Theme JS -->
<script src="{{ URL::asset('widgetStyle/assets/js/argon.min.js')}}"></script>
 <!--custom script-->
 <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
 <script src="{{URL::asset('js/main/additional-methods.min.js')}}"></script>


 <script src="{{URL::asset('widgetStyle/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
 <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script src="{{ URL::asset('widgetStyle/js/script.js?v1.5')}}"></script>
 <script src="{{ URL::asset('widgetStyle/js/formElementScripts.js')}}"></script>

 <!-- Modal -->
<script src="{{ URL::asset('js/main/modal.js')}}"></script>

@stack('widget-scripts')
