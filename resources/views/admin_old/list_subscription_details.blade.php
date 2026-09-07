   @extends('admin.includes.Template')

   @section('content')

       @php

           $userId = Auth::id();

           $get_user_data = Helper::get_user_data($userId);

           $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

           $edit_perm = [];

           if ($get_permission_data->editperm != '') {
               $edit_perm = $get_permission_data->editperm;

               $edit_perm = explode(',', $edit_perm);
           }

       @endphp

       <style type="text/css">
           .modal-dialog {
               max-width: 50%
           }
       </style>

       <div class="content container-fluid">





           <!-- Page Header -->

           <div class="page-header">

               <div class="row align-items-center">

                   <div class="col">

                       <h3 class="page-title">Subscription Details</h3>

                       <ul class="breadcrumb">

                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                           </li>

                           <li class="breadcrumb-item active">Subscription Details</li>

                       </ul>

                   </div>







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

                                   <table class="table table-center table-hover datatable" id="example">

                                       <thead class="thead-light">

                                           <tr>
                                               <th>Sr No</th>
                                               <th>Subscription Name</th>
                                               <th>Total</th>
                                               <th>Start Date</th>
                                               <th>End Date</th>
                                               <th>Status</th>
                                               <th>Detail</th>
                                               <th>Action</th>
                                           </tr>

                                       </thead>

                                       <tbody>
                                           @php
                                               $i = 1;
                                               //echo "<pre>";print_r($all_data);echo "</pre>";
                                           @endphp

                                           @foreach ($all_data as $data)
                                               <tr>

                                                   <td>{{ $i }}</td>
                                                   <td> {{ $data->subscription_name }} </td>
                                                   <td>{{ $data->total }} </td>
                                                   <td> {{ date('d-m-Y', strtotime($data->startdate)) }} </td>
                                                   <td>{{ date('d-m-Y', strtotime($data->enddate)) }}</td>
                                                   <td>
                                                       @if ($data->status == 'inactive')
                                                           <span class="badge badge-pill bg-danger-light">Inactive</span>
                                                       @endif
                                                       @if ($data->status == 'active')
                                                           <span class="badge badge-pill bg-success-light">Active</span>
                                                       @endif

                                                   </td>
                                                   <td><a class="btn btn-primary" href="javascript:void('0');"
                                                           onclick="delete_category('{{ $data->id }}');">View
                                                           Services</a></td>
                                                   <td class="text-end">
                                                       <div class="dropdown dropdown-action">
                                                           <a href="#" class="action-icon dropdown-toggle"
                                                               data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                   class="fas fa-ellipsis-h"></i></a>
                                                           <div class="dropdown-menu dropdown-menu-right">

                                                               <a class="dropdown-item"
                                                                   href="{{ route('subscription-details.show', $data->id) }}"><i
                                                                       class="far fa-eye me-2"></i>View Detail</a>

                                                               {{-- <a class="dropdown-item"
                                                                   href="{{ route('vendor-invoice', ['id' => $data->id]) }}"><i
                                                                       data-feather="clipboard"
                                                                       class="me-2"></i>Invoice</a> --}}

                                                           </div>
                                                       </div>
                                                   </td>
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
   @section('footer_js')




       <!-- Delete  Modal -->
       @if ($all_data != '')
           @foreach ($all_data as $data)
               <div class="modal custom-modal fade" id="delete_model_{{ $data->id }}" role="dialog">

                   <div class="modal-dialog modal-dialog-centered">

                       <div class="modal-content">

                           <div class="modal-body">


                               <div class="modal-text text-center">

                                <div id="div_replace_{{ $data->id }}">
                                </div>

                               </div>

                           </div>

                           <!-- <div class="modal-footer text-center">

                               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                               <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>

                           </div> -->

                       </div>

                   </div>

               </div>
           @endforeach
       @endif

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




       <script>
           function delete_category(id) {



            var url = '{{ url('subscription_replace') }}';

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    success: function(msg) {
                        document.getElementById('div_replace_'+ id).innerHTML = msg;
                        $('#delete_model_' + id).modal('show');
                    }
                });


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
