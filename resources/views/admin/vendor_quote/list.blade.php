   @extends('admin.includes.Template')
   <style>
        #survey_model .modal-dialog {
            max-width: 56%;
        }
    </style>
   @section('content')

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

           @if ($message = Session::get('success'))
               <div class="alert alert-success alert-dismissible fade show">
                   <strong>Success!</strong> {{ $message }}
                   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
               </div>
           @endif


            <div id="validate" class="alert alert-success alert-dismissible fade show" style="display: none;">
                <span id="success-message-list"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>


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
                                               <th>Client Name</th>
                                               <th>Survey Detail</th>
                                               <th>Upload Document</th>
                                               {{-- <th>Client Mobile</th> --}}
                                                
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

                                                   <td>
                                                        {{ $data->quote_id}} <br>
                                                        @if($data->revise_quotation_count !== 0)
                                                            <p class="text-primary">{{ 'Rev '.$data->revise_quotation_count ?? "" }}</p>
                                                        @endif
                                                    </td>

                                                   <td>{{ $data->enquiry_date}}</td>

                                                   <td>{{ $data->client_name}}</td>
                                                   <td>
                                                    <a class="btn btn-primary" href="javascript:void(0)" onclick="viewdata('{{$data->id}}')">
                                                    View
                                                    </a>
                                                   </td>
                                                   <td>
                                                    <a class="btn btn-primary" href="{{route('vendorquote.uploaddocument',$data->id)}}" >
                                                    Upload Document
                                                    </a>
                                                   </td>

                                                   {{-- <td>{{ $data->client_mobile}}</td> --}}

                                                    
                                                  
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
                                <textarea id="quatation_reject_remark" name="quatation_reject_remark" class="form-control" cols="30" rows="2"
                                    placeholder="Enter Remark"></textarea>
                                <p class="form-error-text" id="quatation_reject_remark_error" style="color: red;"></p>
                            </div>
                        </div>
                        
                         
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="quatation_reject_validation();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal custom-modal fade" id="survey_model" role="dialog">
           <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                   <div class="modal-body">
                       <div class="modal-icon text-center mb-3">
                           Survey Details
                       </div>
                       <div class="modal-text text-center" id="survey_model_body">
                           
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


            if(element == 2){

                $('#quatation_reject_inquiry_id').val(enquiry_id);
                $('#quatation_reject_model').modal('show');
            }else if(element == 1){
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
                        // alert(response.status);
                        if (response.status == "SUCCESS") {

                            $('#success-message-list').html("Quotation Accepted Successfully");
                            $('#validate').show();
                            setTimeout(function() {
                                window.location.href = "{{ route('erp_acceptedquote.lists') }}";
                            }, 2000);

                        }
                    }
                });
            }

            
        }

        function quatation_reject_validation() {
            var quatation_reject_remark = jQuery("#quatation_reject_remark").val();
            if (quatation_reject_remark == '') {
                jQuery('#quatation_reject_remark_error').html("Please Enter remark");
                jQuery('#quatation_reject_remark_error').show().delay(0).fadeIn('show');
                jQuery('#quatation_reject_remark_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#quatation_reject_form').submit();
        }

        function viewdata(id){



            $('#survey_model').modal('show');

            $('#survey_model_body').html('<p>Loading...</p>');

            $.ajax({
           url: "{{ route('vendorquote.getSurveyDetails', ':id') }}".replace(':id', id),   // Laravel route
            type: "GET",
            success: function(response) {
                if (response.success) {
                    let data = response.data;
                    let addressHtml = '';

                    // if (data.service === 30) {
                    //     addressHtml = `
                    //         <tr><th>Origin Address:</th><td>${response.address.origin}</td></tr>
                    //         <tr><th>Destination Address:</th><td> ${response.address.desti}</td></tr>
                    //     `;
                    // } else {
                    //     addressHtml = `
                    //         <tr><th>Client Address:</th><td> ${response.address.client}</td></tr>
                    //     `;
                    // }

                   


                     let html = `
                        <table class="table table-bordered">
                            <tr><th>Enquiry Date</th><td>${data.enquiry_date}</td></tr>
                            <tr><th>Survey Date</th><td>${data.s_date}</td></tr>
                            <tr><th>Customer Name</th><td>${data.client_name}</td></tr>
                             <tr><th>Customer Address</th><td>${data.address}</td></tr>
                             <tr><th>Map Link</th><td><a href="${data.map_link}">${data.map_link}</a></td></tr>
                            
                        </table>
                    `;

                    $('#survey_model_body').html(html);
                } else {
                    $('#survey_model_body').html('<p>No data found</p>');
                }
            },
            error: function() {
                $('#survey_model_body').html('<p>Error loading data.</p>');
            }
        });


            //survey_model_body
        }

       </script>

   @stop
