   @extends('admin.includes.Template')
   @section('content')
       <link rel="stylesheet" href="{{ asset('public/admin/assets/css/table.css') }}">
       @php
           $userId = Auth::id();

           $get_user_data = Helper::get_user_data($userId);

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
                       <h3 class="page-title">Survey</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                           </li>
                           <li class="breadcrumb-item active">Survey</li>
                       </ul>
                   </div>
                   @if (in_array('53', $edit_perm))
                       <div class="col-auto">
                           {{-- <a class="btn btn-primary me-1" href="{{ route('erp_enquiry.create') }}">
                               <i class="fas fa-plus"></i> Add Enquiry
                           </a>
                           <a class="btn btn-danger me-1" href="javascript:void('0');"
                               onclick="delete_city();return false;">
                               <i class="fas fa-trash"></i> Delete
                           </a> --}}

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
                           <form id="form" action="{{ route('erp_enquiry.delete') }}" enctype="multipart/form-data">
                               <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                               @csrf
                               <div class="table-responsive">
                                   <table class="table table-center table-hover datatable" id="example">
                                       <thead class="thead-light">
                                           <tr>
                                               <th>Select</th>
                                               <th>Survey ID</th>
                                               <th>Enquiry Date</th>
                                               <th>Client Details</th>
                                               <th>Actions</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($erp_enquiry_data as $data)
                                               <tr>
                                                   <td>
                                                       <input name="selected[]" id="selected" value="{{ $data->id }}"
                                                           type="checkbox" class="minimal-red"
                                                           style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                   </td>

                                                   <td class="fw-bold text-primary">{{ $data->survey_id }}
                                                       <br><strong
                                                           class="fw-bold strong">{{ Helper::servicename($data->service) }}</strong>
                                                   </td>

                                                   <td><i class="far fa-calendar-alt me-1"></i>
                                                       {{ date('d M Y', strtotime($data->enquiry_date)) }}</td>
                                                   <td>
                                                       <div class="fw-bold">{{ $data->client_name }}</div>
                                                       <div class="text-muted small"><i class="fa fa-phone me-1"></i>
                                                           {{ $data->client_mobile }}</div>
                                                   </td>

                                                   <td>

                                                       <div class="dropdown action-dropdown">
                                                           <button class="btn-dots dropdown-toggle" type="button"
                                                               data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                                               aria-expanded="false">
                                                               <i class="fa fa-ellipsis-h"></i>
                                                           </button>
                                                           <ul class="dropdown-menu dropdown-menu-end">
                                                               <li>
                                                                   <a class="dropdown-item" title="Edit Enquiry"
                                                                       href="{{ route('erp_survey.create') }}?enquiry_id={{ $data->id }}">
                                                                       <i class="fas fa-clipboard-check me-2"></i>Process
                                                                       Survey
                                                                   </a>

                                                               </li>
                                                           </ul>
                                                       </div>

                                                   </td>



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

       @if ($message = Session::get('success'))
           <script>
               $(document).ready(function() {
                   Swal.fire({
                       title: 'Success!',
                       text: "{{ $message }}",
                       icon: 'success',
                       timer: 3000,
                       showConfirmButton: false,
                       background: '#ffffff',
                       iconColor: '#10b981',
                       customClass: {
                           title: 'text-success font-weight-bold'
                       }
                   });
               });
           </script>
       @endif
       <!-- Delete Category Modal -->
       <div class="modal custom-modal fade" id="delete_city" role="dialog">
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
           // function delete_city()
           // {
           // 	 //alert('test');
           // 	var checked = $("#form input:checked").length > 0;
           // 	// alert(checked);
           //     if (!checked)
           // 		{
           //         alert("Please select at least one record to delete");
           //         return false;
           //     }
           // 	else
           // 	{
           // 		var conf = confirm("Do you really want to Delete?");
           // 		if(conf == true){
           // 			$('#form').submit(); 
           // 			return true;
           // 		}else{
           // 			return false;
           // 		}
           // 	}
           // }
       </script>
       <script>
           function delete_city() {
               // alert('test');
               var checked = $("#form input:checked").length > 0;
               if (!checked) {
                   $('#select_one_record').modal('show');
               } else {
                   $('#delete_city').modal('show');
               }
           }

           function form_sub() {
               $('#form').submit();
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
