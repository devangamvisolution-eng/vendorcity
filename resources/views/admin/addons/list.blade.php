@extends('admin.includes.Template')
@section('content')
    <style>
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
                    <h3 class="page-title">Add Ons </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Add Ons </li>
                    </ul>
                </div>
                @if (in_array('12', $edit_perm))
                    <div class="col-auto">

                        {{-- <a class="btn btn-primary me-1" href="{{ asset('public/upload/city_upload.xlsx') }}">
                            Download Bulk Upload City Format
                        </a>

                        <a class="btn btn-primary me-1" href="{{ route('bulk_upload_city') }}">
                            <i class="fas fa-plus"></i> Bulk Upload City

                        </a> --}}

                        <a class="btn btn-primary me-1" href="{{ route('addons.create') }}">
                            <i class="fas fa-plus"></i> Add Ons
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
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">

            <strong>Success! </strong><span id="success_message"></span>

            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->

        </div>




        <div class="row">
            <div class="col-sm-12">

                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('addons.delete') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>

                                            <th>Name</th>
                                            <th>Image</th>
                                            {{--  --}}
                                            <!-- <th>Page Url</th> -->
                                            @if (in_array('12', $edit_perm))
                                                <th>Show Addons</th>
                                                <th>Set Order</th>
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alldata as $data)
                                            <tr>
                                                <td>
                                                    <input name="selected[]" id="selected" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>

                                                <td>{!! Helper::servicename($data->serviceid) !!}</td>

                                                <td>
                                                    {!! Helper::subservicename_multiple($data->subserviceid) !!}
                                                </td>



                                                <td>{{ $data->name }}</td>
                                                <td><img src="{{ url('public/upload/addons/' . $data->image) }}"
                                                        width="50px" height="50px">
                                                </td>
                                                {{--  --}}


                                                @if (in_array('12', $edit_perm))
                                                    <td>
                                                        <div class="form-group">
                                                            <label class="toggle">
                                                                <input type="checkbox" id="is_active_toggle"
                                                                    {{ $data->is_active == 0 ? 'checked' : '' }}
                                                                    onchange="fun_status('{{ $data->id }}', this.checked ? 0 : 1); return false;">
                                                                <span class="slider"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="left">
                                                        <input type="text" value="{{ $data->set_order }}"
                                                            onchange="updateorder_popup(this.value, '{{ $data->id }}');"
                                                            class="form-control" />
                                                    </td>
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('addons.edit', $data->id) }}"><i
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
    <!-- set order Modal -->

    <div class="modal custom-modal fade" id="set_order_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3>Are you sure you want to Set order of addons</h3>

                        <input type="hidden" name="set_order_val" id="set_order_val" value="">

                        <input type="hidden" name="set_order_id" id="set_order_id" value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal custom-modal fade" id="status_modell" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3>Are you sure you want to change the Show Service </h3>

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

        function updateorder_popup(val, id) {

            $('#set_order_val').val(val);

            $('#set_order_id').val(id);

            $('#set_order_model').modal('show');

        }

        function updateorder() {

            var id = $('#set_order_id').val();

            var val = $('#set_order_val').val();

            $.ajax({

                type: "POST",

                url: "{{ route('addons.set_order') }}",

                data: {

                    "_token": "{{ csrf_token() }}",

                    "id": id,

                    "val": val

                },

                success: function(returnedData) {

                    // alert(returnedData);

                    if (returnedData == 1) {

                        //alert('yes');

                        $('#success_message').text("Set Order has been Updated successfully");

                        //$('.success_show').show();

                        $('.success_show').show().delay(0).fadeIn('show');

                        $('.success_show').show().delay(5000).fadeOut('show');



                        $('#set_order_model').modal('hide');

                    }

                }

            });



        }

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

                url: "{{ route('addons.change_status') }}",

                data: {

                    "_token": "{{ csrf_token() }}",

                    "id": id,

                    "value": value,

                },

                success: function(returndata) {

                    if (returndata == 1)

                        $('#success_message').text('Show Service has been Updated successfully');

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
