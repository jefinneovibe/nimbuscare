@extends('layouts.dispatch_layout')
@section('content')

    <div class="section_details">
        <div class="alert alert-danger alert-dismissible" role="alert" id="empty_check" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span id="fail_message"></span>
        </div>
        <div class="alert alert-success alert-dismissible" role="alert" id="find_check" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span id="success_message"></span>
        </div>
        <div class="card_header clearfix">
            <h3 class="title">Location Report</h3>
            <ul class="nav nav-pills report_tab">
                <li class="active"><a id="map_view" class="active show">View Location Report</a></li>
                <li><a id="live_map_view">View Live Location</a></li>
            </ul>
        </div>
        <div class="card_content">
                <form id="map_form" name="map_form" method="post">
                    <input type="hidden" id="mapId">
                    <div class="row">
                        <div class="col-md-4" id="show_date">
                            <div class="form_group">
                                <label class="form_label">Select Date<span>*</span></label>
                                <input class="form_input datetimepicker" placeholder="Select" name="currentDate" required id="currentDate" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Select Name<span>*</span></label>
                                <div>
                                    <select  class="selectpicker" data-hide-disabled="true" data-live-search="true" name="agent" id="agent" onchange="dropDownValidation();">
                                        <option selected value="">Select Name</option>
                                        @if(!empty($users))
                                            @forelse($users as $user)
                                                <?php
                                                    if(isset($user->empID))
                                                        {
                                                            $empid= ' ('.$user->empID. ')';
                                                        }else{
                                                        $empid='';
                                                    }
            
                                                ?>
                                                <option value="{{$user->_id}}">{{@$user->name}} {{$empid}}</option>
                                            @empty
                                                No types found.
                                            @endforelse
                                        @endif
                                    </select>
                                    <label class="error" id="agent-error" style="display:none">Please select name.</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label" style="visibility: hidden">&nbsp;<span>*</span></label>
                                <button class="btn btn-primary btn_action" id="button_view"  type="submit">View</button>
                                <button style="display: none" class="btn btn-primary btn_action" id="button_live_view" onclick="LiveLocation(this.id)" type="button">View</button>
                            </div>
                        </div>
                    
                    </div>
                    
                </form>

            <div id="map"></div>
        </div>
    </div>

    <style>
        #map{
            margin: 0;
            padding: 0;
        }
        .btn-group.bootstrap-select,
        .form_group .btn-primary.btn_action,
        .datetimepicker{
            height: 40px;
            margin: 0;
        }
    </style>

@endsection

@push('scripts')
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/custom-select.js')}}"></script>
    <!-- Bootstrap Select -->
    <script src="{{URL::asset('js/main/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOLQOoVSzhAv7zLBHmbXyaXOJlC5q43e0&callback=initMap">
</script>
    <script>
        function dropDownValidation() {
            var agent = $('#agent').val();
            if (agent == '')
            {
                  $('#agent-error').show();
                $('#agent-error').html('Please select name'); 
            }
            
            else
                $('#agent-error').hide();
        }
        $(function () {
            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
//            $('.datetimepicker').datetimepicker({
//                maxDate: new Date(currentYear, currentMonth, currentDate),
//                format: 'DD/MM/YYYY'
//            });

            //        initFormExtendedDatetimepickers1: function() {
            $('.datetimepicker').datetimepicker({
                //  format: 'DD/MM/YYYY / hh:mm',
                maxDate: new Date(currentYear, currentMonth, currentDate),
                format: 'DD/MM/YYYY',
                icons: {
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            });
//            materialKit.initFormExtendedDatetimepickers();

            $(window).load(function() {
                window.onbeforeunload = null;
                $('#preLoader').fadeOut('slow');
                // localStorage.clear();
            });

        });

        function LiveLocation(id) {
            var value;
            if($('#agent').val()=='')
            {
              value= false;
              $('#agent-error').show();
              $('#agent-error').html('Please select name');
            }
            if(value!=false)
            {
                if($('#agent').val()!='')
                {
                    $('#agent-error').hide();
                }
                     $('#mapId').val(id);
                     initMap();
            }
        }

        // form validation//
        $("#map_form").validate({
            ignore: [],
            rules: {
                agent: {
                    required: true
                },
                currentDate: {
                    required: true
                }
            },
            messages: {
                agent: "Please select name.",
                currentDate: "Please select date."
            },
            errorPlacement: function (error, element) {
                    error.insertAfter(element);
            },
            submitHandler: function (form,event) {
                $('#mapId').val('');
                initMap();
            }
        });
        //end//

        
        function initMap() {
            $('#preLoader').show();
            var userName=$('#agent').val();
            var mapId=$('#mapId').val();
            var dateValue=$('#currentDate').val();
            $.ajax({
                method: 'post',
                url: '{{url('maps/get-map')}}',
                data: {id:userName,date:dateValue,mapId:mapId, _token : '{{csrf_token()}}'},
                success: function (locations) {
                    $('#preLoader').hide();
                    if (locations.length>0) {
                        if (locations == 'empty' || locations == 0 ) {
                            var map1 = new google.maps.Map(document.getElementById('map'), {
                                zoom: 4,
                                center: new google.maps.LatLng(25.0750853,54.947563),
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });
                           if( locations != 0 )
                           {
                               if(mapId!='')
                               {
                                  
                                   $('#empty_check').show();
                                   $('#fail_message').html('No location found');
                                   setTimeout(function () {
                                       $('#empty_check').fadeOut('fast');
                                   }, 5000);
                               }
                               else{
                                   $('#empty_check').show(); 
                                  
                                    $('#fail_message').html('No delivery found');
                                   setTimeout(function () {
                                       $('#empty_check').fadeOut('fast');
                                   }, 5000);
                               }
                           }
                        }

                        else{
                            var myOptions = {
                                zoom: 4,
                                center: new google.maps.LatLng(0, 0),
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            }
                            var map = new google.maps.Map(
                                document.getElementById("map"),
                                myOptions);
                            setMarkers(map, locations);

                            function setMarkers(map, locations) {
//                               albhebets=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                                var mapId=$('#mapId').val();
                                var testLat=[];
                                for (var loc = 0; loc < locations.length; loc++) {
                                    if(locations[loc]!='empty')
                                    {
                                        testLat.push(new google.maps.LatLng(locations[loc][0],locations[loc][1]));
                                    }
                                }
                                var countArray=testLat.length;
                                if (locations != 'empty' && countArray!='0') {
                                    $('#find_check').show();
                                    if(mapId!='')
                                    {
                                        $('#success_message').html(countArray + ' Location found');
                                        setTimeout(function () {
                                            $('#find_check').fadeOut('fast');
                                        }, 5000);
                                    }
                                    else{
                                        
                                        $('#success_message').html(countArray + ' Delivery found');
                                        setTimeout(function () {
                                            $('#find_check').fadeOut('fast');
                                        }, 5000);
                                    }

                                }
                                else{
                                    if(mapId!='') {
                                        $('#empty_check').show(); 
                                         $('#fail_message').html('No location found');
                                        setTimeout(function () {
                                            $('#empty_check').fadeOut('fast');
//                                location.reload();
                                        }, 5000);
                                    }else{
                                        $('#empty_check').show();
                                        $('#fail_message').html('No delivery found');
                                        setTimeout(function () {
                                            $('#empty_check').fadeOut('fast');
                                        }, 5000);
                                    }
                                }
                                var userCoordinate = new google.maps.Polyline({
                                    path: testLat,
                                    strokeColor: "#FF0000",
                                    strokeOpacity: 1,
                                    strokeWeight: 2
                                });
                                function tConvert (time) {
                                    // Check correct time format and split into components
                                    time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                                    if (time.length > 1) { // If time format correct
                                        time = time.slice (1);  // Remove full string match value
                                        time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                                        time[0] = +time[0] % 12 || 12; // Adjust hours
                                    }
                                    return time.join (''); // return adjusted time or original string
                                }

                                userCoordinate.setMap(map);
                                var bounds = new google.maps.LatLngBounds();
                                var countval=1;
                                var infoWindow = new google.maps.InfoWindow();
                                for (var i = 0; i < locations.length; i++) {

                                    if(locations[i]!='empty')
                                    {
                                        var beach = locations[i];
                                        var myLatLng = new google.maps.LatLng(beach[0], beach[1]);
                                        var marker = new google.maps.Marker({
                                            position: myLatLng,
                                            map: map,
                                            label:countval+''
                                        });
                                        //Attach click event to the marker.
                                        (function (marker, beach) {
//                                            console.log(beach);
                                            google.maps.event.addListener(marker, "click", function (e) {
                                                //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
                                                if(mapId!='') {
                                                    infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + "" + beach[2] + " here..."+" <br>" + "Last updated time : " + tConvert(beach[3])+
                                                    "</div>");
                                                }else{
                                                    infoWindow.setContent("<div style = 'width:200px;min-height:40px'>" + beach[2] + " <br>" + "Customer Name : " + beach[3] + " <br>"+ "Delivery Time : " +tConvert(beach[4]) + " <br>"+ "Delivery Date : " +beach[5]  +
                                                        "</div>");
                                                }
                                                infoWindow.open(map, marker);
                                            });
                                        })(marker, beach);

                                        bounds.extend(myLatLng);
                                        countval++;
                                    }
                                }
                                map.fitBounds(bounds);
                            }
                        }
                    }
                    else {
                        var map1 = new google.maps.Map(document.getElementById('map'), {
                            zoom: 4,
                            center: new google.maps.LatLng(25.0750853, 54.947563),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });
                        var infowindow = new google.maps.InfoWindow({});

                        var marker1, j;

                        for (j = 0; j < locations.length; j++) {
                            if(locations[j]!='empty')
                            {
                            marker1 = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[j][0], locations[j][1]),
                                map: map1
                            });
                            google.maps.event.addListener(marker1, 'click', (function (marker1, j) {
                                return function () {
                                    infowindow.setContent(locations[j][2]);
                                    infowindow.open(map1, marker1);
                                }
                            })(marker1, j));
                        }

                    }
                    }
                }
                });

        }


        $('#live_map_view').click(function(){
            $('#show_date').hide();
            $('#currentDate').removeAttr('required');
            $('#map_view').removeClass('active show');
            $(this).addClass('active show');
            $('#button_live_view').show();
           
            $('#empty_check').hide();
            $('#find_check').hide();
            $('#button_view').hide();
            $('#agent-error').hide();

            if($('#agent').val()!='')
            {
                $('#agent-error').hide();
                LiveLocation('button_live_view'); 
            }
        });
        $('#map_view').click(function(){
            $('#show_date').show();
            $("#map_form").validate();
            $("#map_form").submit();
            $('#live_map_view').removeClass('active show');
            $(this).addClass('active show');
            $('#button_live_view').hide();
            $('#agent-error').hide();
            $('#empty_check').hide();
            $('#find_check').hide();
            $('#button_view').show();
        });
    </script>
@endpush