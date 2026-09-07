@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        $get_user_data = Helper::get_user_data($userId);

        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        $edit_perm = [];

        if ($get_permission_data->editperm != '') {
            $edit_perm = $get_permission_data->editperm;

            $edit_perm = explode(',', $edit_perm);
        }

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

                    <h3 class="page-title">Accept Lead Form</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Accept Lead Form</li>

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

                        <form id="accept_form" action="{{ route('accept_lead_form_new') }}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            <input type="hidden" name="inquiry_id" value="{{$packages_enquiry_data->id}}">
                            <input type="hidden" name="vendor_id" id="vendor_id" value="">

                            @csrf

                            <div class="table-responsive">

                                <table class="table table-center table-hover">
                                   
                                <tbody> 
                                        {{-- <div class="form-group">
                                            <label for="accept_lead">Select Accept Lead</label>
                                            <select class="form-control" id="accept_lead" name="accept_lead"
                                                onchange="lead_change(this.value);">
                                                <option value="">Select Accept lead</option>
                                            <option value="Enter Qoute">Enter Your Quote</option>
                                            <option value="Request Survey">Request Survey</option>
                                            </select>
                                            <p class="form-error-text" id="accept_lead_error" style="color: red; margin-top: 10px;"></p>
                                        </div> --}}

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
                                    <div class="hidden" id="quoteInput_below_div">
                                    <div class="form-group">
                                        <h4>Quote Includes :</h4>
                                    </div>

                                    @php
                                    $i=0;
                                    @endphp

                                    @if(($service_data)!='')
                                    @foreach($service_data as $data)
                                    <input type="hidden" name="qoute_includes_id[]" value="{{$data->id}}">
                                    <input type="hidden" name="qoute_includes_name[]" value="{{$data->name}}">
                                   
                                    <div class="form-group">
                                        <label for="qoute_includes">{{$data->name}}</label>
                                        <select class="form-control dropdown-to-clear" name="qoute_include_value[]" id="quote_include_value{{$i}}">
                                            
                                            @if($data->name == 'Rate')
                                            <option value="">Select {{$data->name}}</option>
                                            <option value="anually">Anually</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="weekly">weekly</option>
                                            <option value="daily">Daily</option>
                                            @else
                                            <option value="">Select {{$data->name}}</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            @endif
                                        </select>
                                        <p class="form-error-text" id="quote_include_value_error{{$i}}" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                    @endforeach
                                    @endif
                                </div>
                                </tbody>  
                                
                              


                                </table>


                            </div>
                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('vendorinquiry.index') }}"> Cancel</a>



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

    <form id="form_new" action="{{ route('accept_vendor_inquiry') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="inquiry_id" id="inquiry1_id" value="">
        <input type="hidden" name="vendor_id" id="vendor1_id" value="">
    </form>
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

        @php
        $i=0;
        @endphp
        @foreach($service_data as $data)
            var quote_include_value = $("#quote_include_value{{$i}}").val();

            // alert(quote_include_value);
            if (quote_include_value === '') {
                // alert("Empty");
                $("#quote_include_value_error{{$i}}" ).show().delay(0).fadeIn('show');
                $("#quote_include_value_error{{$i}}").show().delay(2000).fadeOut('show');
                $("#quote_include_value_error{{$i}}").html("Please Select {{ $data->name }}");
                $('html, body').animate({
                    scrollTop: $("#quote_include_value{{$i}}").offset().top - 150
                }, 1000);
                return false;
            }
            @php
            $i++;
            @endphp
        @endforeach
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

        // var acceptLead = jQuery("#accept_lead").val();
        // if (acceptLead === "Enter Qoute") {
        //     var qoute = jQuery("#qoute").val();
        //     if (qoute == '') {
        //         jQuery('#qoute_error').html("Please Enter Quote");
        //         jQuery('#qoute_error').show().delay(0).fadeIn('show');
        //         jQuery('#qoute_error').show().delay(2000).fadeOut('show');
        //         $('html, body').animate({
        //             scrollTop: $('#qoute').offset().top - 150
        //         }, 1000);
        //         return false;
        //     }
        // }
   

        // @php
        // $i=0;
        // @endphp
        // @foreach($service_data as $data)
        //         var quote_include_value = $("#quote_include_value{{$i}}").val();

        //         // alert(quote_include_value);
        //         if (quote_include_value === '') {
        //             // alert("Empty");
        //             $("#quote_include_value_error{{$i}}" ).show().delay(0).fadeIn('show');
        //             $("#quote_include_value_error{{$i}}").show().delay(2000).fadeOut('show');
        //             $("#quote_include_value_error{{$i}}").html("Please Select {{$data->name}}");
        //             $('html, body').animate({
        //                 scrollTop: $("#quote_include_value{{$i}}").offset().top - 150
        //             }, 1000);
        //             return false;
        //         }
        //     @php
        //     $i++;
        //     @endphp
        // @endforeach



        $('#spinner_button').show();

        $('#submit_button').hide();

         $('#accept_form').submit();


        }
    </script>

    <script>
      
        function lead_change(value) {

            //alert(value);
            // var quoteInput = document.getElementById('quoteInput');
            // if (value === 'Enter Qoute') {
            //     quoteInput.classList.remove('hidden');
            // } else {
            //     quoteInput.classList.add('hidden');
            // }

            var quoteInput = document.getElementById('quoteInput');
            var quoteInputStyle = quoteInput.style;

            var quoteInput_below_div = document.getElementById('quoteInput_below_div');
            var quoteInputStyle_below_div = quoteInput_below_div.style;

            

            if (value === 'Enter Qoute') {
                quoteInputStyle.display = 'block';  // Show the quoteInput
                quoteInputStyle_below_div.display = 'block';  // Show the quoteInput
            } else {
                quoteInputStyle.display = 'none';   // Hide the quoteInput
                quoteInputStyle_below_div.display = 'none';   // Hide the quoteInput

                var input_val = document.querySelector('.remove_val');
                input_val.value = '';

                var dropdowns = document.querySelectorAll('.dropdown-to-clear');
                dropdowns.forEach(function(dropdown) {
                    dropdown.selectedIndex = 0; // Set selectedIndex to 0 to select the first option (or -1 to clear selection)
                });
            }
        }
    
    </script>

@stop
