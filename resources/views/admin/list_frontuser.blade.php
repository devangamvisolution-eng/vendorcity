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

                    <h3 class="page-title">Customer User</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Customer User</li>

                    </ul>

                </div>

                @if (in_array('16', $edit_perm))
                    <div class="col-auto">

                         <a class="btn btn-primary me-1" href="{{ route('frontuser.create') }}">
                            <i class="fas fa-plus"></i> Add Customer User
                        </a>

                        <a class="btn btn-primary me-1" href="{{ route('export-excel') }}">

                            <i class="fas fa-plus"></i> Download Excel File

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


        <!-- Search Filter -->

        <div id="filter_inputs" class="card filter-card">

            <div class="card-body pb-0">

                <div class="row">

                    <div class="col-sm-6 col-md-3">

                        <div class="form-group">

                            <label>Name</label>

                            <input type="text" class="form-control">

                        </div>

                    </div>

                    <div class="col-sm-6 col-md-3">

                        <div class="form-group">

                            <label>Email</label>

                            <input type="text" class="form-control">

                        </div>

                    </div>

                    <div class="col-sm-6 col-md-3">

                        <div class="form-group">

                            <label>Phone</label>

                            <input type="text" class="form-control">

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /Search Filter -->

        <div class="row">

            <div class="col-sm-12">

                <div class="card card-table">

                    <div class="card-body">

                        <form id="form" action="{{-- route('delete_country') --}}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                            @csrf

                            <div class="table-responsive">

                                <table class="table table-center table-hover datatable" id="example">

                                    <thead class="thead-light">

                                        <tr>


                                            <th>No.</th>
                                            <th>Customer Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Added Date</th>
                                             @if (in_array('16', $edit_perm))
                                            <th>Actions</th>
                                             @endif
                                        </tr>

                                    </thead>

                                    <tbody>
                                        @php
                                            $i = 1;
                                            // echo '<pre>';
                                            // print_r($frontuser_data);
                                            // echo '</pre>';
                                            // exit();
                                        @endphp
                                        @foreach ($frontuser_data as $data)
                                            <tr>

                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data->customer_id }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                 <td>
												
												@if(isset($data->country_code))
													+{{ $data->country_code }} 
												@endif
												
												{{ $data->mobile }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        {{-- @if ($data->add_deduct == 0) --}}
                                                        <label class="toggle">
                                                            <input type="checkbox" id="is_active_toggle"
                                                                {{ $data->status == 1 ? 'checked' : '' }}
                                                                onchange="fun_status('{{ $data->id }}', this.checked ? 1 : 0); return false;">
                                                            <span class="slider"></span>
                                                        </label>
                                                        {{-- @else
                                                            {{ '-' }}
                                                        @endif --}}
                                                    </div>
                                                </td>

                                                <td>
                                                    @if ($data->created_at != '' && $data->created_at != '0000-00-00 00:00:00')
                                                        {{ Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif

                                                </td>
                                                    @if (in_array('16', $edit_perm))
                                                <td class="text-right">
                                                    <a href="{{ route('frontuser.edit', $data->id) }}"
                                                        class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip"
                                                        title="Edit"><i class="fas fa-edit"></i></a>

                                                    {{-- <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                                        onclick="fun_delete('{{ $data->id }}');" data-bs-toggle="tooltip"
                                                        title="Delete"><i class="fas fa-trash-alt"></i></a> --}}
                                                </td>
                                                    @endif

                                            </tr>
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


                        <input type="hidden" name="is_active_val" id="is_active_val" value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="fun_review_status();">Yes</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /set orderModal -->






    <script>
        function fun_status(id, value) {

            $('#is_active_id').val(id);


            $('#is_active_val').val(value);

            $('#status_modell').modal('show');

        }

        function fun_review_status() {

            var id = $('#is_active_id').val();

            var value = $('#is_active_val').val();

            $.ajax({

                type: "post",

                url: "{{ url('change_status_frontuser') }}",

                data: {

                    "_token": "{{ csrf_token() }}",

                    "id": id,

                    "value": value,

                },

                success: function(returndata) {

                    if (returndata == 1)

                        $('#success_message').text('Status has been Updated successfully');

                    $('.success_show').show().delay(0).fadeIn('show');

                    $('.success_show').show().delay(5000).fadeOut('show');

                    $('#status_modell').modal('hide');

                }

            });

        }
    </script>

    <script>
        $(document).ready(function() {
            // Check if the DataTable instance already exists
            if ($.fn.DataTable.isDataTable('#example')) {
                // Destroy the existing DataTable before reinitializing
                $('#example').DataTable().destroy();
            }

            // Initialize DataTable with the new options
            $('#example').dataTable({
                "searching": true
            });
        });
    </script>
@stop
