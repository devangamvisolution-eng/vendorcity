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
    {{-- <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style> --}}
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Garden and Mouse Enquiry Detail</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Garden and Mouse Enquiry Detail</li>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{-- route('delete_price') --}}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover">
                                    @if ($garden_enquiry_data != '')
                                        @php
                                            $i = 0;
                                        @endphp
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Inquiry No</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $garden_enquiry_data->inquiry_id }}</td>
                                            </tr>
                                        </tbody>
                                  

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::servicename(strval($garden_enquiry_data->service)) !!}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sub Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::subservicename(strval($garden_enquiry_data->subservice)) !!}</td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Service Type</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                @if($garden_enquiry_data->service_type != "")
                                                    {{ $garden_enquiry_data->service_type }}
                                                @else
                                                    -
                                                @endif
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Type of Home</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $garden_enquiry_data->type_of_home }}</td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Size of Home</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @if($garden_enquiry_data->size_of_home != "" && $garden_enquiry_data->size_of_home != null)
                                                    {{ $garden_enquiry_data->size_of_home }}
                                                @else
                                                    -
                                                @endif
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                        <th>City</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::city_name_for_garden($garden_enquiry_data->city) !!}</td>
                                            </tr>
                                        </tbody>
                                        
                                        <thead class="thead-light">
                                            <tr>
                                            <th>Address</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $garden_enquiry_data->address}}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Service Date</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $garden_enquiry_data->service_date }}</td>
                                            </tr>
                                        </tbody>
                                        
                                        @if($garden_enquiry_data->describe_your_requirements !="")
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Describe Garden Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $garden_enquiry_data->describe_your_requirements ?? "" }}</td>
                                            </tr>
                                        </tbody>
                                        @endif
                                        
                                    @else
                                    <tbody>
                                        <tr>
                                            <td>no data found</td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            <div class="col-auto" style="float: inline-end;">
            
                                <a class="btn btn-primary me-1" href="{{ route('garden_accpet_form', [$garden_enquiry_data->inquiry_id,$userId]) }}">Accept</a>
                    
                    
                                <a class="btn btn-danger" href="javascript:void('0');"
                                    onclick="Enquiry('{{ $garden_enquiry_data->inquiry_id }}','{{ $userId }}');">Reject
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="modal custom-modal fade" id="reject_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">


                    <div class="modal-text ">

                        <!-- <h3>Delete Expense Category</h3> -->


                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="invoice-table table table-bordered">

                                        <tbody>
                                            <form id="reject_form" method="post"
                                                action="{{ route('garden_reason_reject_form') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">

                                                        <label for="name">Reason</label><br><br><br>
                                                        <input type="hidden" name="inquiry_id" id="inquiry_id"
                                                            value="">
                                                        <input type="hidden" name="vendor_id" id="vendor_id"
                                                            value="">

                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason1" value="I do not serve this city"><span> I do not
                                                            serve this city</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason2" value="I do not provide this service"><span> I do
                                                            not provide this
                                                            service</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason3"
                                                            value="I do not have availailty on this date"><span> I do not have
                                                            availailty on this date</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason4"
                                                            value="Request includes goods that require special handling"><span>
                                                            Request
                                                            includes goods that require special handling </span><br>

                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reject_reason" value="Other"><span> Other</span><br>

                                                        <textarea name="reject_reason_text" id="reject_reason_textarea" cols="30" rows="10" class="form-control"
                                                            style="display: none;"></textarea>

                                                    </div>

                                                </div>
                                                <p class="form-error-text" id="reject_error"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                                <button class="btn btn-primary" style="float: inline-end;" type="button"
                                                    onclick="javascript:reject_validation()">Add</button>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- /Delete Modal -->


    
    <form id="form_new" action="{{ route('garden_accept_vendor_inquiry') }}" enctype="multipart/form-data">
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
    function reject_validation() {

        if ($('input[name="reject_reason"]:checked').length === 0) {

            jQuery('#reject_error').html("Please Select Reason");
            jQuery('#reject_error').show().delay(0).fadeIn('show');
            jQuery('#reject_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#reject_reason_textarea').offset().top - 150
            }, 1000);
            return false;
        }

        if ($('#reject_reason').is(':checked') && $('#reject_reason').val() === 'Other') {

            var textareaField = $('#reject_reason_textarea').val();
            if (textareaField == "") {
                jQuery('#reject_error').html("Please Enter Reason");
                jQuery('#reject_error').show().delay(0).fadeIn('show');
                jQuery('#reject_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#reject_reason_textarea').offset().top - 150
                }, 1000);
                return false;
            }

        }

        $('#reject_form').submit();


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
      <script>
        $(document).ready(function() {
            // Add change event listener to the radio button
            $('.reject_reason').change(function() {
                // alert(this);
                // Check if the "Other" option is selected
                if ($(this).is(':checked') && $(this).val() === 'Other') {
                    // Show the textarea
                    $('#reject_reason_textarea').show();
                } else {
                    // Hide the textarea
                    $('#reject_reason_textarea').hide();
                }


            });
        });
    </script>

@stop
