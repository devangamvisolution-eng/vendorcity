@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $edit_perm = [];

        // if ($get_permission_data->editperm != '') {
        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);
        // }

          $roleIds = explode(',', $get_user_data->role_id);

			$edit_perm = [];

			foreach ($roleIds as $roleId) {
				$roleId = trim($roleId); // Clean any spaces
				
				$get_permission_data = Helper::get_permission_data($roleId);

				if (
					is_object($get_permission_data) &&
					property_exists($get_permission_data, 'editperm') &&
					$get_permission_data->editperm != ''
				) {
					$perms = explode(',', $get_permission_data->editperm);
					$edit_perm = array_merge($edit_perm, $perms); // Combine permissions
				}
			}

			// Optional: remove duplicates and reset array keys
			$edit_perm = array_values(array_unique($edit_perm));

    @endphp

    <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
     
        .hidden {
            display: none;
        }

        .radio-group {
        display: flex;
        flex-direction: row; /* Display buttons in a row */
        gap: 10px; /* Gap between buttons */
    }
    
    /* Hide default radio button */
    .radio-group input[type="radio"] {
        display: none;
    }
    
    /* Style label as button */
    .radio-group label {
        display: inline-block;
        padding: 10px 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        text-align: center; /* Center text inside button */
    }
    
    /* Style label when checked */
    .radio-group input[type="radio"]:checked + label {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
    
    /* Optional: Adjust label styles for better appearance */
    .radio-group label {
        font-size: 16px;
        font-weight: bold;
    }
    
    </style>


    <div class="content container-fluid">

        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Garden and Mouse Accept Lead Form</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Garden and Mouse Accept Lead Form</li>

                    </ul>

                </div>


            </div>


        </div>

        <!-- /Page Header -->


        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <strong>Success!</strong> {{ $message }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $userId = Auth::id();
        @endphp

        <div class="row">

            <div class="col-sm-12">

                <div class="card">

                    <div class="card-body">

                        <form id="accept_form" action="{{ route('garden_accept_lead_form') }}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            <input type="hidden" name="inquiry_id" value="{{$packages_enquiry_data->id}}">
                            <input type="hidden" name="vendor_id" id="vendor_id" value="{{ $userId }}">

                            @csrf

                            <div class="table-responsive">

                                <table class="table table-center table-hover">
                                   
                                <tbody> 

                                    <div class="form-group">
                                        <div class="radio-group">
                                            <input type="radio" id="enter_quote" name="accept_lead" value="Enter Qoute" onclick="lead_change(this.value);">
                                            <label for="enter_quote">Enter Your Quote</label><br>
                                            
                                            <input type="radio" id="request_survey" name="accept_lead" value="Request Survey" onclick="lead_change(this.value);">
                                            <label for="request_survey">Request Survey</label><br>
                                        </div>
                                        <p class="form-error-text" id="accept_lead_error" style="color: red; margin-top: 10px;"></p>
                                    </div>

                                    <div class="form-group hidden" id="quoteInput">
                                        <label for="name">Enter Quote (Include 5% VAT)</label>
                                        <input id="qoute" name="qoute" type="number" class="form-control remove_val"
                                            placeholder="Please Enter Quote" value="" />
                                      <p class="form-error-text" id="qoute_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </tbody>  
                                
                              


                                </table>


                            </div>
                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('garden-inquiry.index') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:accept_leads()">Submit</button>

                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Delete  Modal -->

    <div class="modal custom-modal fade" id="delete_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">


                    <div class="modal-text text-center">

                        <h3>Are you sure want to Accept</h3>

                        <p></p>

                    </div>

                </div>

                <div class="modal-footer text-center">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                    <button type="button" class="btn btn-primary" onclick="form_sub();">Yes</button>

                </div>

            </div>

        </div>

    </div>

  

    <!-- /Delete Modal -->

@stop

@section('footer_js')




    <script>
        function delete_category(id, vendor_id) {

            $('#inquiry1_id').val(id);

            $('#vendor1_id').val(vendor_id);

            $('#delete_model').modal('show');
        }

        function form_sub() {

            $('#form_new').submit();

        }
    </script>

    <script>
        function Enquiry(id, userId) {


            $('#inquiry_id').val(id);

            $('#vendor_id').val(userId);

            $('#reject_model').modal('show');


        }
    </script>

    <script>
        function accept_leads() {

        // var accept_lead = jQuery("#accept_lead").val();
        // if (accept_lead == '') {
        //     jQuery('#accept_lead_error').html("Please Select Accept Lead");
        //     jQuery('#accept_lead_error').show().delay(0).fadeIn('show');
        //     jQuery('#accept_lead_error').show().delay(2000).fadeOut('show');
        //     $('html, body').animate({
        //         scrollTop: $('#accept_lead').offset().top - 150
        //     }, 1000);
        //     return false;
        // }

        let radios = document.getElementsByName('accept_lead');
        let selectedValue = null;

        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
            selectedValue = radios[i].value;
            break;
            }
        }

        //alert(selectedValue);

        if (selectedValue !== null) {

            if(selectedValue == "Enter Qoute"){

                // alert('here');

                var qoute = jQuery("#qoute").val();
                if (qoute == '') {
                    jQuery('#qoute_error').html("Please Enter Quote");
                    jQuery('#qoute_error').show().delay(0).fadeIn('show');
                    jQuery('#qoute_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#qoute').offset().top - 150
                    }, 1000);
                    return false;
                }

            }
            
            
            
        }else{
            jQuery('#accept_lead_error').html("Please Select Accept Lead");
            jQuery('#accept_lead_error').show().delay(0).fadeIn('show');
            jQuery('#accept_lead_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#accept_lead').offset().top - 150
            }, 1000);
            return false;
        }




        $('#spinner_button').show();

        $('#submit_button').hide();

         $('#accept_form').submit();


        }
    </script>

    <script>
      
        function lead_change(value) {

            // alert(value);

            var quoteInput = document.getElementById('quoteInput');
            var quoteInputStyle = quoteInput.style;

            if (value === 'Enter Qoute') {
                quoteInputStyle.display = 'block';  // Show the quoteInput
            } else {
                quoteInputStyle.display = 'none';   // Hide the quoteInput

                var input_val = document.querySelector('.remove_val');
                input_val.value = '';
              
            }
        }
    
    </script>

@stop
