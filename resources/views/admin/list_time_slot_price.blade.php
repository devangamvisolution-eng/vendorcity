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

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Time Slot</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Time Slot</li>
                    </ul>
                </div>
                @if (in_array('29', $edit_perm))
                    <div class="col-auto">

                        {{-- <a class="btn btn-primary me-1" href="{{ asset('public/upload/city_upload.xlsx') }}">
                            Download Bulk Upload City Format
                        </a>

                        <a class="btn btn-primary me-1" href="{{ route('bulk_upload_city') }}">
                            <i class="fas fa-plus"></i> Bulk Upload City

                        </a> --}}

                        <a class="btn btn-primary me-1" href="{{ route('time_slot_price.create') }}">
                            <i class="fas fa-plus"></i> Add Time Slot
                        </a>
                        <a class="btn btn-danger me-1" href="javascript:void('0');"
                            onclick="delete_packagecategory();return false;">
                            <i class="fas fa-trash"></i> Delete
                        </a>

                    </div>
                @endif
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
                        <form id="form" action="{{ route('delete_timeslot') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            {{-- <th>Service</th> --}}
                                            <th>Sub Service</th>
                                            {{-- <th>Package Category</th> --}}
                                            <!-- <th>Page Url</th> -->
                                            @if (in_array('11', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($time_data as $data)
                                            <tr>
                                                <td>
                                                    <input name="selected[]" id="selected" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
{{-- 
                                                <td>{!! Helper::servicename($data->service_id) !!}</td> --}}

                                                <td>{!! Helper::subservicename($data->subservice_id) !!}</td>

                                                {{-- <td>{{ $data->name }}</td> --}}


                                                @if (in_array('11', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('time_slot_price.edit', $data->id) }}"><i
                                                                class="far fa-edit"></i></a>
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

    <!-- /Page Wrapper -->
@stop
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_packagecategory" role="dialog">
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



    <script>
        function delete_packagecategory() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_packagecategory').modal('show');
            }
        }

        function form_sub() {
            $('#form').submit();
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
