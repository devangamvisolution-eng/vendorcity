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

                       <h3 class="page-title">Leads</h3>

                       <ul class="breadcrumb">

                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                           </li>

                           <li class="breadcrumb-item active">Leads</li>

                       </ul>

                   </div>

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

                           <form id="form" action="" enctype="multipart/form-data">

                               <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                               @csrf

                               <div class="table-responsive">

                                   <table class="table table-center table-hover datatable">

                                       <thead class="thead-light">

                                           <tr>
                                               <th>Sr No</th>
                                               <th>Name</th>
                                               <th>Email</th>
                                               <th>Service</th>
                                               <th>Sub Service</th>
                                               <th>Price</th>
                                               <th>Inquiry Date</th>
                                           </tr>

                                       </thead>

                                       <tbody>

                                        @php
                                                $i=1;
                                               @endphp

                                           @foreach ($all_data as $data)

                                               <tr>

                                                   <td>{{$i}}</td>
                                                   <td>{{ $data->name }}</td>
                                                   <td>{{ $data->email }}</td>
                                                   <td>
                                                       @if ($data->service_id != '')
                                                           {!! Helper::servicename(strval($data->service_id)) !!}
                                                       @endif
                                                   </td>
                                                   <td>
                                                        @if ($data->subservice_id != '')
                                                           {!! Helper::subservicename(strval($data->subservice_id)) !!}
                                                       @endif
                                                    
                                                    </td>
                                                   <td>{{ $data->price }}</td>
                                                   <td>{{ date("d-m-Y", strtotime($data->inquiry_date)) }}</td>
                                               </tr>
                                               @php
                                                $i++;
                                               @endphp
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

                       <h3>Are you sure you want to Set order of Groups</h3>

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



   </script>

