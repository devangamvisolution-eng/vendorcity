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

    <style type="text/css">
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .toggle {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle input[type="checkbox"] {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #8B0000;
            transition: 0.4s;
            border-radius: 17px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input[type="checkbox"]:checked+.slider {
            background-color: #008000;
        }

        input[type="checkbox"]:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>





    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Admin Wallet</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Admin Wallet</li>
                    </ul>
                </div>
                @if (in_array('14', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary me-1" href="{{ route('adminwallet.create') }}">
                            <i class="fas fa-plus"></i> Add Admin Wallet
                        </a>
                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>

                        <a class="btn btn-primary me-2" href="javascript:void('0');" onclick="excel_download();">
                            Excel Download
                        </a>
    

                    </div>
                @endif
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <div class="alert alert-danger alert-dismissible fade show failed_show" style="display: none;">
            <strong>Failed! </strong><span id="failed_message" style="color: red;"></span>
        </div>

        <form method="GET" action="{{ url('filter_data_adminwallet') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_vendor_name_fil" id="filter_vendor_name_fil" value="{{ $filter_vendor_name ?: '' }}">
            
        </form>

        @php
        if(!empty($startdate) || !empty($enddate) || !empty($filter_vendor_name)){
            $css = "display:block;";
        }else{
            $css = "display:none;";
        }
        @endphp

        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card" style="{{ $css }}">

            <div class="card-body pb-0">
             <form id="filter_form" action="{{ route('admin_wallet_filter') }}" method="POST">
                 @csrf
                 <input type="hidden" name="action" value="filter">

                <div class="row">

                 <div class="col-sm-6 col-md-8">
                     <div class="row">

                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Start Date</label>
                                 <input type="date" class="form-control" name="s_date" id="s_date" placeholder="Enter Start Date"
                                     value="{{ $startdate ?: '' }}">
                             </div>
                         </div>
     
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>End Date</label>
                                 <input type="date" class="form-control" name="e_date" id="e_date" placeholder="Enter End Date"
                                     value="{{ $enddate ?: '' }}">
                             </div>
                         </div>
                         <div class="col-lg-4">
                            <label>Vendor</label>
                             <select class="select select2-hidden-accessible" id="vendor_id" name="vendor_id">
                                 <option value ="">Select Vendor</option>
                                 @if(!empty($all_vendor))
                                     @foreach($all_vendor as $all_vendor_data)
                                         <option value="{{ $all_vendor_data->id }}" @if($filter_vendor_name == $all_vendor_data->id ) {{ 'selected' }} @endif>{{ $all_vendor_data->name }}</option>
                                     @endforeach
                                 @endif
                             </select>
                         </div>

                    </div>
                    <div class="col-sm-6 col-md-3">
                         <div class="form-group">
                             <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="
                             margin-top: 22px;
                         " onclick="filter_validation()">
                                Submit
                             </a>
                             <a class="btn btn-primary filter-btn" href="{{ route('adminwallet.index') }}" style="
                             margin-top: 22px;">Reset</a>
                         </div>
                    </div>
                </div>
                </div>
             </form>
            </div>

        </div>
        <!-- /Search Filter -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{-- route('delete_wallet') --}}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Transaction Id</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Payment Type</th>
                                            <th>Add/Deduct</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $i = 1;
                                        @endphp

                                        @foreach ($wallet_data as $data)
                                            <tr>
                                                <td>

                                                    {{ $i }}

                                                </td>

                                                <td>{{ $data->transaction_id }}</td>

                                                <td>{!! Helper::vendorsname($data->vendors_id) !!}</td>


                                                <td>{{ $data->price }}</td>

                                                <td>
                                                    @if ($data->payment === 0)
                                                        {{ 'Cash' }}
                                                    @elseif ($data->payment === 1)
                                                        {{ 'Online' }}
                                                    @elseif ($data->payment === 2)
                                                        {{ 'Cheque' }}
                                                    @elseif ($data->payment === 3)
                                                        {{ 'Refund' }}
                                                    @elseif ($data->payment === 4)
                                                        {{ 'Deduct' }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                @if ($data->add_deduct === 0 && $data->payment !== 4)
                                                {{ 'Add' }}
                                                @elseif ($data->add_deduct === 1 || ($data->add_deduct === 0 && $data->payment === 4))
                                                    {{ 'Deduct' }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                                
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        @if ($data->add_deduct == 0)
                                                        @if ($data->status == 0)
                                                            <label class="toggle">
                                                                <input type="checkbox" id="is_active_toggle"
                                                                    {{ $data->status == 1 ? 'checked' : '' }}
                                                                    onchange="fun_status('{{ $data->id }}','{{ $data->vendors_id }}', this.checked ? 1 : 0); return false;">
                                                                <span class="slider"></span>
                                                            </label>
                                                            @else
                                                            <span class="badge badge-pill bg-success-light">
                                                                {{ 'Approved' }}</span>
                                                            @endif
                                                        @else
                                                            {{ '-' }}
                                                        
                                                        @endif
                                                       
                                                    </div>
                                                </td>
                                                <td>
                                                    {{-- {{ $data->created_at->toDateString() }} --}}
                                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}
                                                    {{-- {{ $data->created_at->format('d-m-Y') }} --}}
                                                </td>

                                            </tr>
                                            @php

                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_js')


    <!-- set order Modal -->

    <div class="modal custom-modal fade" id="status_modell" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3>Are you sure you want to change the status </h3>

                        <input type="hidden" name="is_active_id" id="is_active_id" value="">

                        <input type="hidden" name="is_active_vendorid" id="is_active_vendorid" value="">

                        <input type="hidden" name="is_active_val" id="is_active_val" value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="fun_review_status();" id="modal_yes_button">Yes</button>

                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button" style="display: none;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /set orderModal -->

    <script>
         function excel_download() {
            $('#filter_data').submit();
        }

        function filter_validation(){
                
                $('#filter_form').submit();
            }

        function fun_status(id, vendor_id, value) {

            $('#is_active_id').val(id);
            $('#is_active_vendorid').val(vendor_id);

            $('#is_active_val').val(value);

            $('#status_modell').modal('show');

        }

    function fun_review_status() {
    // Hide "Yes" button and show the spinner
    $('#modal_yes_button').hide(); 
    $('#spinner_button').show();

    var id = $('#is_active_id').val();
    var vendorid = $('#is_active_vendorid').val();
    var value = $('#is_active_val').val();

    $.ajax({
        type: "post",
        url: "{{ url('change_status_wallet') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            "id": id,
            "vendorid": vendorid,
            "value": value,
        },
        success: function(returndata) {
            if(returndata == 2){
                $('#failed_message').text('The deducted amount is greater than the vendor wallet balance.');
                $('.failed_show').show().delay(0).fadeIn('show');
                $('.failed_show').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#failed_message').offset().top - 150
                }, 1000);
                // $('#is_active_toggle').prop('checked', false);
            }
            if (returndata == 1) {
                $('#success_message').text('Status has been Updated successfully');
                $('.success_show').show().delay(0).fadeIn('show');
                $('.success_show').show().delay(5000).fadeOut('show');
                
                // $('#is_active_toggle').prop('disabled', true);
            }
            
            // Hide the spinner and modal after request completion
            $('#spinner_button').hide();
            $('#modal_yes_button').show(); // Optional: If you want to show the "Yes" button again.
            $('#status_modell').modal('hide');
        },
        error: function() {
            // Hide the spinner and show the "Yes" button again on error
            $('#spinner_button').hide();
            $('#modal_yes_button').show();
        }
    });
}
    </script>

    <script>
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        $(document).ready(function() {
            $('#example').dataTable({
                "searching": true
            });
        })
    </script>
@stop
