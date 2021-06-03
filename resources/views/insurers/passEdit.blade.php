@extends('layouts.app')
@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <?php  $route= Route::currentRouteAction();
                  $title="Reset Password";
            ?>
            <h3 class="title" style="margin-bottom: 8px;">{{$title}}</h3>
        </div>
        <div class="alert alert-danger alert-dismissible" role="alert" id="failed_customer" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Incorrect Old Password
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                <form method="post" name="customer_form" id="customer_form">
                    {{ csrf_field() }}
                    <input  type="hidden" id="insurer_id" name="insurer_id" value="{{@$insurerDetails->_id}}">
                    <div class="row">                     
                         {{-- <div class="col-md-4">
                            <div class="form_group">
                                <label class="form_label">Old Password<span>*</span></label>
                                    <div class="table_div">
                                        <div class="table_cell">                                                    
                                            <input class="form_input name"  name="oldPassword" id="oldPassword"  placeholder="Old Password" value=""  type="text">
                                        </div>                                                
                                    </div>
                            </div>
                        </div>                        --}}
                   
                        <div class="col-md-4 add_email">                          
                                        <div class="form_group clearfix">                                         
                                            <label class="form_label">New Password<span>*</span></label> 
                                            <div class="table_div">
                                                <div class="table_cell">
                                                    <input class="form_input"  name="newPassword"  id="newPassword" placeholder="New Password" value="" type="text">
                                                </div>                                                
                                            </div>
                                        </div>                             
                        </div>              
                                     
                       
                    </div>                          
                   
	                <?php  $route= Route::currentRouteAction();
	                 $name="Update Password";
                     ?>
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
     
        //add customer form validation//
        $("#customer_form").validate({
            ignore: [],
            rules: {               
               // oldPassword: {
               //   required: true
                  
               // },
               
               
                newPassword: {
                    required: true,
                    minlength:6                    
                },
                             
            },
            messages: {               
               // oldPassword: "Please enter your current password",                
                //newPassword: "Please enter new password", 
                 newPassword:{
                    required:"Please enter password",
                    minlength:"please enter atleast six characters"
                } 
                //
            },
            errorPlacement: function (error, element) {
                if(element.attr("name") == "oldPassword"
                    || element.attr("name") == "newPassword")
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
                    url: '{{url('insurers-psave')}}',
                    data: form_data,
                    cache : false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result== 'success') {                           
                            window.location.href = '{{url('insurers/show')}}';
                        }
                        else if(result=="wrong_password")
                        {
                          //window.location.href = window.location;
                        
                            $('#preLoader').hide();
                            $("#button_submit").attr( "disabled", false );
                            $("#failed_customer").show();
                            setTimeout(function() {
                                $('#failed_customer').fadeOut('fast');
                            }, 5000);
                                               
                        }                      
                    }
                });
            }          
        });
        //end//
    </script>
@endpush
