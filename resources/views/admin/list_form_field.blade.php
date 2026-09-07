   @extends('admin.includes.Template')
   @section('content')

       @php

           $userId = Auth::id();

           $get_user_data = Helper::get_user_data($userId);

        //    $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        //    $edit_perm = [];

        //    if ($get_permission_data->editperm != '') {
        //        $edit_perm = $get_permission_data->editperm;

        //        $edit_perm = explode(',', $edit_perm);
        //    }

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
                       <h3 class="page-title">Form Field</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                           </li>
                           <li class="breadcrumb-item active">Form Field</li>
                       </ul>
                   </div>
                   @if (in_array('18', $edit_perm))
                       <div class="col-auto">

                           <a class="btn btn-primary me-1" href="{{ route('form_field.create') }}">
                               <i class="fas fa-plus"></i> Add Form Field
                           </a>
                           {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                           <i class="fas fa-filter"></i> Filter
                       </a> --}}
                           <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_form_field();">
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
           @php
               if (($lable_name != '' && isset($lable_name)) || $type != '') {
                   $displayCard = 'display:block';
               } else {
                   $displayCard = 'display:none';
               }
           @endphp
           <!-- Search Filter -->
           <div id="filter_inputs" class="card filter-card" style="@php echo $displayCard; @endphp">
               <div class="card-body pb-0">
                   <form action="{{-- route('form_field.filter') --}}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <div class="row">
                           <div class="col-sm-6 col-md-3">
                               <div class="form-group">
                                   <label>Label Name</label>
                                   <input type="text" class="form-control" name="lable_name"
                                       value="@if (isset($lable_name)) {{ $lable_name }} @endif">
                               </div>
                           </div>
                           <div class="col-sm-6 col-md-3">
                               <div class="form-group">
                                   <label>Type</label>


                                   <select id="type" name="type" class="select form-control">
                                       <option value="">Select Type</option>
                                       <option value="1" @if ($type == 1) {{ 'selected' }} @endif>
                                           Input</option>
                                       <option value="2" @if ($type == 2) {{ 'selected' }} @endif>
                                           Dropdown</option>
                                       <option value="3" @if ($type == 3) {{ 'selected' }} @endif>
                                           Radio</option>
                                       <option value="4" @if ($type == 4) {{ 'selected' }} @endif>
                                           Checkbox</option>
                                       <option value="5" @if ($type == 5) {{ 'selected' }} @endif>
                                           Text area</option>
                                       <option value="6" @if ($type == 6) {{ 'selected' }} @endif>
                                           Date</option>
                                   </select>
                               </div>
                           </div>
                           <div class="col-sm-6 col-md-3">
                               <input class="btn btn-primary me-1 " type="submit" value="Search" style="margin-top: 22px;">
                               <a href="{{ route('form_field.index') }}" class="btn btn-primary"
                                   style="margin-top: 22px;">Reset</a>
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
                           <form id="form" action="{{ route('delete_form_field') }}" enctype="multipart/form-data">
                               <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                               @csrf
                               <div class="table-responsive">
                                   <table class="table table-center table-hover datatable" id="example">
                                       <thead class="thead-light">
                                           <tr>
                                               <th>Select</th>
                                               <th>Lable Name</th>
                                               <th>Type</th>
                                               <th>Set Order</th>
                                               <th>Required Field</th>
                                               <th>Sending Mail</th>
                                               @if (in_array('18', $edit_perm))
                                                   <th class="text-right">Actions</th>
                                               @endif
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @if (count($form_data) > 0)
                                               @foreach ($form_data as $data)
                                                   <tr>
                                                       <td>
                                                           <input name="selected[]" id="selected[]"
                                                               value="{{ $data->id }}" type="checkbox"
                                                               class="minimal-red"
                                                               style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                       </td>

                                                       <td>
                                                           {{ $data->lable_name }}
                                                       </td>

                                                       <td>
                                                           @if ($data->type == '1')
                                                               {{ 'Input' }}
                                                           @elseif($data->type == '2')
                                                               {{ 'Dropdown' }}
                                                           @elseif($data->type == '3')
                                                               {{ 'Radio' }}
                                                           @elseif($data->type == '4')
                                                               {{ 'Checkbox' }}
                                                           @elseif($data->type == '5')
                                                               {{ 'Text area' }}
                                                           @elseif($data->type == '6')
                                                               {{ 'Date' }}
                                                           @elseif($data->type == '7')
                                                               {{ 'Multiple Dropdown' }}
                                                           @elseif($data->type == '8')
                                                               {{ 'Upload Image' }}
                                                           @elseif($data->type == '9')
                                                               {{ 'Time' }}
                                                           @endif
                                                       </td>
                                                       <td class="left"><input type="text"
                                                               value="{{ $data->set_order }}"
                                                               onchange="updateorder_popup(this.value, '{{ $data->id }}');"
                                                               class="form-control" />
                                                       </td>
                                                       <td>
                                                           <div class="form-group">
                                                               <label class="toggle">
                                                                   <input type="checkbox" id="is_active_toggle"
                                                                       {{ $data->is_active == 1 ? 'checked' : '' }}
                                                                       onchange="fun_status('{{ $data->id }}', this.checked ? 1 : 0); return false;">
                                                                   <span class="slider"></span>
                                                               </label>
                                                           </div>
                                                       </td>
                                                       <td>
                                                           <div class="form-group">
                                                               <label class="toggle">
                                                                   <input type="checkbox" id=""
                                                                       {{ $data->mail_send == 1 ? 'checked' : '' }}
                                                                       onchange="fun_send_mail('{{ $data->id }}', this.checked ? 1 : 0); return false;">
                                                                   <span class="slider"></span>
                                                               </label>
                                                           </div>
                                                       </td>

                                                       @if (in_array('18', $edit_perm))
                                                           <td class="text-right">
                                                               <a class="btn btn-primary"
                                                                   href="{{ route('form_field.edit', $data->id) }}"><i
                                                                       class="far fa-edit"></i></a>
                                                           </td>
                                                       @endif
                                                   </tr>
                                               @endforeach
                                           @else
                                               <tr>
                                                   <td colspan="6" class="text-center">{{ 'No Form Fields Found' }}
                                                   </td>
                                               </tr>
                                           @endif
                                       </tbody>
                                   </table>
                                   {{-- <span style="float: right;" class="mt-3"> {!! $form_data->appends(Request::except('page'))->links() !!} </span> --}}
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

       <div class="modal custom-modal fade" id="set_order_model" role="dialog">

           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">

                   <div class="modal-body">

                       <div class="modal-text text-center">

                           <h3>Are you sure you want to Set order of Form Fields</h3>

                           <input type="hidden" name="set_order_val" id="set_order_val" value="">

                           <input type="hidden" name="set_order_id" id="set_order_id" value="">

                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                           <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>

                       </div>

                   </div>

               </div>

           </div>

       </div>

       <!-- /set orderModal -->

       <!-- set order Modal -->

       <div class="modal custom-modal fade" id="status_modell" role="dialog">

           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">

                   <div class="modal-body">

                       <div class="modal-text text-center">

                           <h3>Are you sure you want to change the Required Form Field</h3>

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

       <!-- set order Modal -->

       <div class="modal custom-modal fade" id="send_mail_modell" role="dialog">

           <div class="modal-dialog modal-dialog-centered">

               <div class="modal-content">

                   <div class="modal-body">

                       <div class="modal-text text-center">

                           <h3>Are you sure you want to Send in the Mail</h3>

                           <input type="hidden" name="send_mail_id" id="send_mail_id" value="">

                           <input type="hidden" name="send_mail_val" id="send_mail_val" value="">

                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                           <button type="button" class="btn btn-primary" onclick="fun_mail_send();">Yes</button>

                       </div>

                   </div>

               </div>

           </div>

       </div>

       <!-- /set orderModal -->

       <script>
           function fun_send_mail(id, value) {

               // alert(value);

               $('#send_mail_id').val(id);

               $('#send_mail_val').val(value);

               $('#send_mail_modell').modal('show');

           }

           function fun_mail_send() {

               var id = $('#send_mail_id').val();

               var value = $('#send_mail_val').val();

               $.ajax({

                   type: "post",

                   url: "{{ url('mail_send') }}",

                   data: {

                       "_token": "{{ csrf_token() }}",

                       "id": id,

                       "value": value,

                   },

                   success: function(returndata) {

                       if (returndata == 1)

                           $('#success_message').text('Mail Form Field has been Updated successfully');

                       $('.success_show').show().delay(0).fadeIn('show');

                       $('.success_show').show().delay(5000).fadeOut('show');

                       $('#send_mail_modell').modal('hide');

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

                   url: "{{ url('validate_form_field') }}",

                   data: {

                       "_token": "{{ csrf_token() }}",

                       "id": id,

                       "value": value,

                   },

                   success: function(returndata) {

                       if (returndata == 1)

                           $('#success_message').text('Required Form Field has been Updated successfully');

                       $('.success_show').show().delay(0).fadeIn('show');

                       $('.success_show').show().delay(5000).fadeOut('show');

                       $('#status_modell').modal('hide');

                   }

               });

           }
       </script>


       <script>
           function delete_form_field() {

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

           function updateorder() {

               var id = $('#set_order_id').val();

               var val = $('#set_order_val').val();

               $.ajax({

                   type: "POST",

                   url: "{{ url('set_order_form_fields') }}",

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
