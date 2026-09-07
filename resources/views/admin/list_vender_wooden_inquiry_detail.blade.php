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
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Wooden Floor Polishing Enquiry Detail</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Wooden Floor Polishing Enquiry Detail</li>
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
        @php
            $userId = Auth::id();
        @endphp
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{-- route('delete_price') --}}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover">
                                    @if ($wooden_enquiry_data != '')
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
                                                <td>{{ $wooden_enquiry_data->inquiry_id }}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Type of Property</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->property_type }}</td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Area Of Floor</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->area_of_floor ? $wooden_enquiry_data->area_of_floor : '-' }}</td>

                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Condition Of Floor</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->condition_of_floor }}</td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Required Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->service_required }}</td>
                                            </tr>
                                        </tbody>

                                        <thead class="thead-light">
                                            <tr>
                                                <th>Scheduling Site Survey</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @if($wooden_enquiry_data->schedule_site_survey === 'yes')
                                                        Yes Surveyor will visit the site
                                                        @else
                                                        Floor Video Uploaded
                                                        @endif
                                                    </td>
                                            </tr>
                                        </tbody>
                                       
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::servicename(strval($wooden_enquiry_data->service_id)) !!}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Sub Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::subservicename(strval($wooden_enquiry_data->subservice_id)) !!}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Address</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->city.', '.$wooden_enquiry_data->area.', '.$wooden_enquiry_data->building_street_no.', ' }}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->enquiry_month.' '.$wooden_enquiry_data->enquiry_date.', '.$wooden_enquiry_data->enquiry_year }}</td>
                                            </tr>
                                        </tbody>
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Time</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Helper::timeslotname(strval($wooden_enquiry_data->time_slot)) !!}</td>
                                            </tr>
                                        </tbody>
                                        @if($wooden_enquiry_data->describe_your_requirements !="")
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Describe Wooden Floor Polishing Service</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $wooden_enquiry_data->describe_your_requirements ? $wooden_enquiry_data->describe_your_requirements : '-' }}</td>
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
                                                action="{{ route('reason_reject_form') }}">
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
        function reject_validation() {
            if ($('input[name="reject_reason"]:checked').length === 0) {
                jQuery('#reject_error').html("Please Enter Reason");
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
