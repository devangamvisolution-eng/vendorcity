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
                       <h3 class="page-title">Quotation</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                           </li>
                           <li class="breadcrumb-item active">Quotation</li>
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



           <div class="row">
               <div class="col-sm-12">

                   <div class="card card-table">
                       <div class="card-body">
                           <form id="form" action="" enctype="multipart/form-data">
                               <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                               @csrf
                               <div class="table-responsive">
                                   <table class="table table-center table-hover datatable" id="example">
                                       <thead class="thead-light">
                                           <tr>
                                               <th>Select</th>
                                               <th>Quote ID</th>
                                               <th>Enquiry Date</th>
                                               <th>Client Details</th>

                                               <th>Status</th>
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

                                                   <td class="fw-bold text-primary">
                                                       {{ $data->quote_id }} <br><strong
                                                           class="fw-bold strong">{{ Helper::servicename($data->service) }}</strong><br>
                                                       @if ($data->revise_quotation_count !== 0)
                                                           <p class="text-primary">
                                                               {{ 'Rev ' . $data->revise_quotation_count ?? '' }}</p>
                                                       @endif
                                                   </td>

                                                   <td><i class="far fa-calendar-alt me-1"></i>
                                                       {{ date('d M Y', strtotime($data->enquiry_date)) }}</td>
                                                   <td>
                                                       <div class="fw-bold">{{ $data->client_name }}</div>
                                                       <div class="text-muted small"><i class="fa fa-phone me-1"></i>
                                                           {{ $data->client_mobile }}</div>
                                                   </td>



                                                   <td>
                                                       <select name="admin_accept_quote" class="status-select"
                                                           onchange="acceptQuotationByAdmin(this.value, '{{ $data->id }}')">
                                                           <option value="">Select Status</option>
                                                           <option value="1">Accept Quotation</option>
                                                           <option value="2">Rejected Quotation</option>
                                                       </select>
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
                                                                   <a class="dropdown-item"
                                                                       href="{{ route('erp_quote.create') }}?enquiry_id={{ $data->id }}">
                                                                       <i class="fas fa-file-invoice"></i> Add Quote
                                                                   </a>
                                                               </li>
                                                               @if ($data->mail_to_customer == 1)
                                                                   <li>
                                                                       <a class="dropdown-item"
                                                                           href="{{ route('erp_quote.mail', $data->id) }}">
                                                                           <i class="fas fa-envelope"></i> Email Customer
                                                                       </a>
                                                                   </li>
                                                               @endif
                                                               <li>
                                                                   <a class="dropdown-item"
                                                                       href="{{ route('erp_quote.revisequote') }}?enquiry_id={{ $data->id }}">
                                                                       <i class="fas fa-edit"></i> Revise Quote
                                                                   </a>
                                                               </li>
                                                               <li>
                                                                   <a class="dropdown-item" href="javascript:void(0)"
                                                                       onclick="viewdocument('{{ $data->id }}')">
                                                                       <i class="fas fa-eye"></i> View Documents
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


       <!-- Reject  Modal -->
       <div class="modal custom-modal fade" id="quatation_reject_model" role="dialog">
           <div class="modal-dialog modal-dialog-centered folloup-modal">
               <div class="modal-content">
                   <form id="quatation_reject_form" action="{{ route('erp_quote.quatation_reject_form') }}" method="POST"
                       enctype="multipart/form-data">
                       @csrf
                       <input type="hidden" name="quatation_reject_inquiry_id" id="quatation_reject_inquiry_id">
                       <div class="modal-body">
                           <div class="modal-text text-center">
                               <!-- <h3>Delete Expense Category</h3> -->
                           </div>
                           <div class="modal-text text-center" id="dropdownreplace">


                               <div class="form-group">
                                   <label for="name">Remarks</label>
                                   <textarea id="quatation_reject_remark" name="quatation_reject_remark" class="form-control" cols="30"
                                       rows="2" placeholder="Enter Remark"></textarea>
                                   <p class="form-error-text" id="quatation_reject_remark_error" style="color: red;"></p>
                               </div>
                           </div>


                       </div>
                       <div class="modal-footer text-center">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                           <button type="button" class="btn btn-primary"
                               onclick="quatation_reject_validation();">Submit</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
       <div class="modal custom-modal fade" id="document_model" role="dialog">
           <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="modal-icon text-center mb-3">
                           Document Details
                       </div>
                       <div class="modal-text text-center" id="document_model_body">

                       </div>
                   </div>
                   <div class="modal-footer text-center">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

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


           function acceptQuotationByAdmin(element, enquiry_id) {
               if (element == 2) {
                   $('#quatation_reject_inquiry_id').val(enquiry_id);
                   $('#quatation_reject_model').modal('show');
               } else if (element == 1) {
                   Swal.fire({
                       title: 'Accept Quotation?',
                       text: "Are you sure you want to accept this quotation?",
                       icon: 'question',
                       showCancelButton: true,
                       confirmButtonColor: '#3b82f6',
                       cancelButtonColor: '#6b7280',
                       confirmButtonText: 'Yes, Accept It!',
                       background: '#ffffff',
                   }).then((result) => {
                       if (result.isConfirmed) {
                           Swal.fire({
                               title: 'Processing...',
                               text: 'Please wait, accepting quotation.',
                               allowOutsideClick: false,
                               didOpen: () => {
                                   Swal.showLoading()
                               }
                           });

                           var url = '{{ route('erp_quote.accept_quotation_admin') }}';
                           $.ajax({
                               url: url,
                               type: 'post',
                               data: {
                                   "_token": "{{ csrf_token() }}",
                                   "status_id": element,
                                   "enquiry_id": enquiry_id
                               },
                               success: function(response) {
                                   if (response.status == "SUCCESS") {
                                       Swal.fire({
                                           title: 'Success!',
                                           text: "Quotation Accepted Successfully",
                                           icon: 'success',
                                           timer: 2000,
                                           showConfirmButton: false
                                       }).then(() => {
                                           window.location.href =
                                               "{{ route('erp_acceptedquote.lists') }}";
                                       });
                                   } else {
                                       Swal.fire('Error', response.message || 'Something went wrong',
                                           'error');
                                   }
                               },
                               error: function() {
                                   Swal.fire('Error', 'Connection error. Please try again.', 'error');
                               }
                           });
                       } else {
                           // Reset select if cancelled
                           location.reload();
                       }
                   });
               }
           }

           function quatation_reject_validation() {
               var quatation_reject_remark = jQuery("#quatation_reject_remark").val();
               if (quatation_reject_remark == '') {
                   jQuery('#quatation_reject_remark_error').html("Please provide rejection reason").show();
                   setTimeout(() => jQuery('#quatation_reject_remark_error').fadeOut(), 3000);
                   return false;
               }

               Swal.fire({
                   title: 'Reject Quotation?',
                   text: "Are you sure you want to reject this quotation?",
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#ef4444',
                   cancelButtonColor: '#6b7280',
                   confirmButtonText: 'Yes, Reject It!',
                   background: '#ffffff',
               }).then((result) => {
                   if (result.isConfirmed) {
                       $('#quatation_reject_form').submit();
                   }
               });
           }


           function viewdocument(id) {
               $('#document_model').modal('show');
               $('#document_model_body').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Loading documents...</p>
                </div>
            `);

               $.ajax({
                   url: "{{ route('erp_quote.getSurveydocument', ':id') }}".replace(':id', id),
                   type: "GET",
                   success: function(response) {
                       if (response.success && response.data.length > 0) {
                           let html = '<div class="list-group list-group-flush">';
                           response.data.forEach(function(doc) {
                               let fileUrl = "{{ asset('public/upload/erp_vendor_surveydocuments') }}/" +
                                   doc.document;
                               html += `
                                <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-bottom py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger fa-lg me-3"></i>
                                        <span class="fw-medium text-dark">${doc.document}</span>
                                    </div>
                                    <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-external-link-alt me-1"></i> View
                                    </a>
                                </div>
                            `;
                           });
                           html += '</div>';
                           $('#document_model_body').html(html);
                       } else {
                           $('#document_model_body').html(`
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open text-muted fa-3x mb-3"></i>
                                <p class="text-muted fw-medium">No documents found for this quotation.</p>
                            </div>
                        `);
                       }
                   },
                   error: function() {
                       $('#document_model_body').html(
                           '<div class="alert alert-danger">Error loading data. Please try again.</div>');
                   }
               });
           }

           @if ($message = Session::get('success'))
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
           @endif
       </script>

   @stop
