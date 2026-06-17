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
                    <h3 class="page-title">Vendors</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Vendors</li>
                    </ul>
                </div>
                @if (in_array('8', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a>
                        <a class="btn btn-primary me-1" href="{{ route('vendors.create') }}">
                            <i class="fas fa-plus"></i> Add Vendors
                        </a>
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
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
        </div>
        <form method="POST" action="{{ url('excel_download_vendors') }}" id="excel_download_vendors">
            @csrf
           
        </form>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_vendors') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Vendor Id</th>
                                            {{-- <th>Role</th> --}}
                                            <th>Company Name</th>
                                            <th>Services</th>
                                            <th>Email for Login</th>
                                            <th>Parent Company Name</th>
                                            <th>city</th>
                                            <th>Mobile</th>
                                            <th>Wallet Amount</th>
                                            <th>Status</th>
                                            @if (in_array('8', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                            {{-- <th>Subscription</th> --}}
                                            <th>Vendor Login</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < count($vendors_data); $i++)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]"
                                                        value="{{ $vendors_data[$i]->id }}" type="checkbox"
                                                        class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                {{-- <td>
                                                    {!! Helper::user_role_name($vendors_data[$i]->role_id) !!}
                                                </td> --}}
                                                <td>
                                                    {{ $vendors_data[$i]->vendor_id }}
                                                </td>
                                                <td>
                                                    {{ $vendors_data[$i]->name }}
                                                </td>
                                                @php
                                                    $services = explode(',', $vendors_data[$i]->serviceList);
                                                @endphp
                                                <td>
                                                    @foreach ($services as $service)
                                                        {!! Helper::servicename($service) !!}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $vendors_data[$i]->email }}
                                                </td>
                                                <td>
                                                    @if ($vendors_data[$i]->parentcname != '')
                                                        {{ $vendors_data[$i]->parentcname }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                    $vendors_city = explode(',',$vendors_data[$i]->city);
                                                    $city_names = [];
                                                    foreach ($vendors_city as $city_id) {
                                                        // Assuming getCityNameById is your helper function
                                                        $city_names[] =  Helper::cityname(trim($city_id)); // trim to remove any extra whitespace
                                                    }
                                                    $city_names = implode(',',$city_names);
                                                    @endphp
                                                    {{ $city_names }}
                                                </td>
                                                <td>
                                                    @if ($vendors_data[$i]->mobile == 0)
                                                        {{ '-' }}
                                                    @else
                                                        {{ $vendors_data[$i]->mobile }}
                                                    @endif
                                                </td>
                                                <td>{{ $vendors_data[$i]->wallet_amount }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="toggle">
                                                            <input type="checkbox" id="is_active_toggle"
                                                                {{ $vendors_data[$i]->is_active == 0 ? 'checked' : '' }}
                                                                onchange="fun_status('{{ $vendors_data[$i]->id }}', this.checked ? 0 : 1); return false;">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                @if (in_array('8', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('vendors.edit', $vendors_data[$i]->id) }}"><i
                                                                class="far fa-edit"></i></a>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('vendors.subscription', $vendors_data[$i]->id) }}">Subscription</a>
                                                    </td>
                                                @endif

                                                <td>
                                                    <a class="btn btn-primary"
                                                    href="{{ route('vendor_login', $vendors_data[$i]->id) }}">
                                                    Vendor Login</a>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <span style="float: left;"> </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_category" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Category Modal -->
    <!-- Select one record Category Modal -->
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Please select at least one record to delete</h3>
                        <!-- <p>Are you sure want to delete?</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        function delete_category() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_category').modal('show');
            }
        }
        function form_sub() {
            $('#form').submit();
        }
    </script>
    <script>
        function fun_status(id, value) {
            // alert(value);
            $('#is_active_id').val(id);
            $('#is_active_val').val(value);
            $('#status_modell').modal('show');
        }
        function fun_review_status() {
            var id = $('#is_active_id').val();
            var value = $('#is_active_val').val();
            $.ajax({
                type: "post",
                url: "{{ url('change_status_vendors') }}",
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
        function excel_download() {
            $('#excel_download_vendors').submit();
        }
        
    </script>
@stop
