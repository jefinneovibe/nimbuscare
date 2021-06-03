@extends('layouts.app')
@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <?php  $route= Route::currentRouteAction();
            if($route=="App\Http\Controllers\InsurersController@edit") {
                $title="Edit Insurer";
            }else
            if($route=="App\Http\Controllers\InsurersController@addLogin") {
                $title="Create Login";
            }
            else{
                $title="Add Insurer";
            }?>
            <h3 class="title" style="margin-bottom: 8px;">{{$title}}</h3>
        </div>
        <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Customer adding failed. There is a repetition in department.
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="post" name="customer_form" id="customer_form">
                    {{ csrf_field() }}
                    <input  type="hidden" id="insurer_id" name="insurer_id" value="{{@$insurerDetails->_id}}">
                    <div class="row">                     
                         <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Name<span>*</span></label>
                                    <div class="table_div">
                                        <div class="table_cell">                                                    
                                            <input class="form_input name"  name="name" id="name"  placeholder="Enter Insurer Name" value="{{@$insurerDetails->name}}"  type="text">
                                        </div>                                                
                                    </div>
                            </div>
                        </div>                       
                    @if (@$insurerDetails->login_created==true||$title=="Create Login"||$title=="Add Insurer")                                
                        <div class="col-md-4 add_email">                          
                                        <div class="form_group clearfix">                                         
                                            <label class="form_label">Email Id<span>*</span></label> 
                                            <div class="table_div">
                                                <div class="table_cell">
                                                    <input class="form_input"  name="email"  id="email" placeholder="Email Id" value="{{@$insurerDetails->email}}" type="text">
                                                </div>                                                
                                            </div>
                                        </div>                             
                        </div>
                    @else

                    @endif
                      
                      @if (@$insurerDetails)
                          @if (@$insurerDetails->login_created==false&&  $title=="Create Login")
                                <div class="col-md-4 add_contact">                           
                                                <div class="form_group clearfix">                                                                              
                                                    <label class="form_label">Password<span>*</span></label>                                            
                                                    <div class="table_div">
                                                        <div class="table_cell">                                                    
                                                            <input class="form_input Password"  name="Password" id="Password"  placeholder="Password" value=""  type="text">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                    </div> 
                            @endif

                      @else
                           <div class="col-md-4 add_contact">                           
                                        <div class="form_group clearfix">                                                                              
                                            <label class="form_label">Password<span>*</span></label>                                            
                                            <div class="table_div">
                                                <div class="table_cell">                                                    
                                                    <input class="form_input Password"  name="Password" id="Password"  placeholder="Password" value=""  type="text">
                                                </div>                                                
                                            </div>
                                        </div>
                            </div> 
                      @endif
                      
                                         
                       
                    </div>                          
                   
	                <?php  $route= Route::currentRouteAction();
	                if($route=="App\Http\Controllers\InsurersController@edit") {
                        $name="Update Insurer";
	                }else if($route=="App\Http\Controllers\InsurersController@addLogin") {
                        $name="Create Login";
                        ?>
                         <input   name="addlogin" id="addlogin" value="addlogin"  type="hidden">
                         <?php
	                }
	                else{
                        $name="Add Insurer";
                     }?>

                  <button class="btn btn-primary btn_action pull-right" id="button_submit" type="submit">{{$name}}</button>


                </form>
            </div>
        </div>
    </div>
   
@endsection

@push('scripts')
    <script src="{{URL::asset('js/main/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('js/main/custom-select.js')}}"></script>
    <!-- Bootstrap Select -->
    <script src="{{URL::asset('js/main/bootstrap-select.js')}}"></script>

    <script>

      $.validator.addMethod(
        "mobileValiWithHyphen",
        function(value, element) {
            regexp = "^[0-9]*$";
            value = value.replace(/-/g , '').trim();
            var re = new RegExp(regexp);
            if (value) {
                return re.test(value);
            } else {
                return true;
            }
        },
        "Please enter a valid digit."
        );
        $.validator.addMethod("customemail",
            function(value, element) {
                if (value) {
                    return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
                } else {
                    return true;
                }
            },
            "Please enter a valid email id. "
        );
        //add customer form validation//
        $("#customer_form").validate({
            ignore: [],
            rules: {               
                name: {
                  required: true
                },
                email: {
                    customemail:true,
                    required:true,
                    remote: {
                        url: '{{url('insurers/create/validate_email')}}',
                        type: "post",
                        data: {
                            route:'{{$route}}',
                        _token: function() {
                            return "{{csrf_token()}}"
                        }
                    }
                }
                }, 
                Password: {
                    required: true,
                    minlength:6
                },
                             
            },
            messages: {               
                name: "Please enter name of insurer",                
                //mobileNumber: "Please enter mobile number.",
                email: {
                    required:"Please enter  email id.",
                    remote:"Email already used",
                    customemail:"Please enter  email id."
                },
                //customerType: "Please enter customer type.",
                //dob: "Please enter date of birth",
                Password:{
                    required:"Please enter password",
                    minlength:"please enter atleast six characters"
                } 
                //Phone: "Please enter phone",
            },
            errorPlacement: function (error, element) {
                if(element.attr("name") == "name"
                    || element.attr("name") == "mobileNumber" || element.attr("name") == "email" ||
                    element.attr("name") == "customerType" || element.attr("name") == "dob"|| element.attr("name") == "Password"|| element.attr("name") == "Phone" )
                {
                    error.insertAfter(element);
                }
            },
             submitHandler: function (form,event) {
                var form_data = new FormData($("#customer_form")[0]);
                form_data.append('_token', '{{csrf_token()}}');
                $('#preLoader').show();
                $("#button_submit").attr( "disabled", "disabled" );
                $.ajax({
                    method: 'post',
                    url: '{{url('insurers-save')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {
                            var customerMode = $("#customerMode").val();
                            window.location.href = '{{url('insurers/show')}}';
                        }                        
                    }
                });
            }          
        });
        //end//
    </script>
@endpush
