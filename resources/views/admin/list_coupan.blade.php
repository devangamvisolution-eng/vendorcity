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
                    <h3 class="page-title">Coupon</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Coupon</li>
                    </ul>
                </div>
                @if (in_array('35', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary me-1" href="{{ route('coupan.create') }}">
                            <i class="fas fa-plus"></i> Add Coupon
                        </a>
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <!-- /Page Header -->
        <!-- @if ($message = Session::get('success'))
    <div class="alert alert-success">
                         <p>{{ $message }}</p>
                        </div>
    @endif -->
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
                        <form id="form" action="{{ route('delete-coupan') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Coupon Name</th>
                                            <th>Coupon Code</th>
                                            {{-- <th>Service</th>
                                            <th>Subservice</th> --}}
                                            <th>Discount</th>
                                            <th>Coupon Value</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            @if (in_array('35', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_coupan as $data)
                                            <tr>
                                                <td>
                                                    <input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>{{ $data->coupan_name }}</td>
                                                <td>{{ $data->coupan_code }}</td>
                                                {{-- <td>{{ $data->service_id }}</td>
                                                <td>{{ $data->subservice_id }}</td> --}}
                                                <td>{{ $data->discount }}</td>
                                                @php
                                                    if ($data->coupanvalue == 0) {
                                                        $coupanvalue = 'Percentage';
                                                    } elseif ($data->coupanvalue == 1) {
                                                        $coupanvalue = 'Price';
                                                    } else {
                                                        $coupanvalue = '-';
                                                    }
                                                @endphp
                                                <td>{{ $coupanvalue }}</td>
                                                <td>{{ $data->startdate }}</td>
                                                <td>{{ $data->enddate }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-select" name="is_active" id="is_active"
                                                            onchange="fun_status('{{ $data->id }}',this.value);return false;">
                                                            <option value="0"
                                                                {{ $data->is_active == 0 ? 'selecetd' : '' }}>Active
                                                            </option>
                                                            <option value="1"
                                                                {{ $data->is_active == 1 ? 'selected' : '' }}>Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </td>
                                                @if (in_array('35', $edit_perm))
                                                    <td class="text-right">
                                                         <a class="btn btn-primary"
                                                            href="{{ route('coupan.edit', $data->id) }}"><i
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
@stop
@section('footer_js')
<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="delete_model" role="dialog">
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
<!-- /Delete Modal -->
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
<!-- /Select one record Category Modal -->
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
            $('#delete_model').modal('show');
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
    function featured_product(id, value) {
        if (value.checked) {
            var t = confirm('Are you sure you want Add Set as home');
            var val_new = 1;
        } else {
            var t = confirm('Are you sure you want remove From Set as home');
            var val_new = 0;
        }
        if (t) {
            $.ajax({
                type: "POST",
                url: "{{ url('category_set_home') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "val": val_new
                },
                success: function(returnedData) {
                    // alert(returnedData);
                    if (returnedData == 1) {
                        //alert('yes');
                        $('#success_message').text("Set Home has been Updated successfully");
                        //$('.success_show').show();
                        $('.success_show').show().delay(0).fadeIn('show');
                        $('.success_show').show().delay(5000).fadeOut('show');
                    }
                }
            });
        } else {
            return false;
        }
    }
    function updateorder() {
        var id = $('#set_order_id').val();
        var val = $('#set_order_val').val();
        $.ajax({
            type: "POST",
            url: "{{ url('coupan_set_order') }}",
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
            url: "{{ url('change_status_coupan') }}",
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
@stop
