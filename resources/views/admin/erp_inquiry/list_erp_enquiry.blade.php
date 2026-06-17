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

       <div class="content-wrapper">


           <!-- Page Header -->
           <div class="page-header">
               <div class="row align-items-center">
                   <div class="col">
                       <h3 class="page-title">Enquiry</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Enquiry</li>
                       </ul>
                   </div>
                   @if (in_array('60', $edit_perm))
                       <div class="col-auto">
                           <a class="btn-submit me-2" href="{{ route('erp_enquiry.create') }}">
                               <i class="fas fa-plus-circle me-2"></i>Add Enquiry
                           </a>
                           <button type="button" class="btn-delete-multi" onclick="delete_city();">
                               <i class="fas fa-trash-alt me-2"></i>Delete
                           </button>
                           </button>
                       </div>
                   @endif
               </div>
           </div>

           <div class="custom-card">
               <div class="card-body">
                   <form id="form" action="{{ route('erp_enquiry.delete') }}" enctype="multipart/form-data">
                       <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                       @csrf
                       <div class="table-responsive">
                           <table class="table table-hover datatable" id="example">
                               <thead>
                                   <tr>
                                       <th style="width: 50px;">Select</th>
                                       <th>Enquiry No.</th>
                                       <th>Enquiry Date</th>
                                       <th>Client Details</th>
                                       @if (in_array('60', $edit_perm))
                                           <th class="text-center" style="width: 100px;">Actions</th>
                                       @endif
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($erp_enquiry_data as $data)
                                       <tr>
                                           <td>
                                               <input name="selected[]" value="{{ $data->id }}" type="checkbox"
                                                   class="form-check-input checkbox"
                                                   style="width: 18px; height: 18px; cursor: pointer;">
                                           </td>
                                           <td class="fw-bold text-primary">
                                               {{ $data->quote_no }}<br><strong
                                                   class="fw-bold strong">{{ Helper::servicename($data->service) }}</strong>
                                           </td>
                                           <td><i class="far fa-calendar-alt me-1"></i>
                                               {{ date('d M Y', strtotime($data->enquiry_date)) }}</td>
                                           <td>
                                               <div class="fw-bold">{{ $data->client_name }}</div>
                                               <div class="text-muted small"><i class="fa fa-phone me-1"></i>
                                                   {{ $data->client_mobile }}</div>
                                           </td>
                                           @if (in_array('60', $edit_perm))
                                               <td class="text-center">
                                                   <div class="dropdown action-dropdown">
                                                       <button class="btn-dots dropdown-toggle" type="button"
                                                           data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                                           aria-expanded="false">
                                                           <i class="fa fa-ellipsis-h"></i>
                                                       </button>
                                                       <ul class="dropdown-menu dropdown-menu-end">
                                                           <li>
                                                               <a class="dropdown-item" title="Edit Enquiry"
                                                                   href="{{ route('erp_enquiry.edit', $data->id) }}">
                                                                   <i class="far fa-edit"></i> Edit Enquiry
                                                               </a>

                                                           </li>
                                                       </ul>
                                                   </div>

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
       <script>
           function delete_city() {
               var selected = [];
               $('.checkbox:checked').each(function() {
                   selected.push($(this).val());
               });

               if (selected.length === 0) {
                   Swal.fire({
                       title: 'No Selection',
                       text: "Please select at least one enquiry to delete.",
                       icon: 'info',
                       confirmButtonColor: '#3b82f6',
                       background: '#ffffff',
                   });
                   return;
               }

               Swal.fire({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#ef4444',
                   cancelButtonColor: '#6b7280',
                   confirmButtonText: 'Yes, delete it!',
                   cancelButtonText: 'Cancel',
                   background: '#ffffff',
               }).then((result) => {
                   if (result.isConfirmed) {
                       const btn = $('.btn-delete-multi');
                       btn.prop('disabled', true);
                       btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Deleting...');
                       $('#form').submit();
                   }
               });
           }
       </script>
       <script>
           $(document).ready(function() {
               if ($.fn.DataTable.isDataTable('#example')) {
                   $('#example').DataTable().destroy();
               }

               $('#example').dataTable({
                   "searching": true
               });
           });
       </script>
   @stop
