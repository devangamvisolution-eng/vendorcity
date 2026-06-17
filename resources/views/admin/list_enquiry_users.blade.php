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
                    <h3 class="page-title">Enquiry Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Enquiry Users</li>
                    </ul>
                </div>
                
                <div class="col-auto">

                    <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a>
                    
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>

                    
                </div>

                @if (in_array('31', $edit_perm))
                    <div class="col-auto">

                        {{-- <a class="btn btn-primary me-1" href="{{ route('Enquiry Users.create') }}">
                            <i class="fas fa-plus"></i> Add Enquiry Users
                        </a> --}}
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>

                    </div>
                @endif


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

        @php

        if(!empty($startdate) || !empty($enddate) || !empty($filter_service_id) || !empty($filter_subservice_id)){
            $css = "display:block;";
        }else{
            $css = "display:none;";
        }

        @endphp
        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card" style="{{ $css }}">

            <div class="card-body pb-0">
             <form id="filter_form" action="{{ route('filter-enquiryusers') }}" method="POST">
                 @csrf
                 <input type="hidden" name="action" value="filter">
     
                <div class="row">
     
                    <div class="col-sm-6 col-md-8">
                     <div class="row">
     
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Start Date</label>
                                 <input type="date" class="form-control" name="s_date" id="s_date" placeholder="Enter Start Date"
                                     value="{{ $startdate ?: '' }}">
                             </div>
                         </div>
     
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>End Date</label>
                                 <input type="date" class="form-control" name="e_date" id="e_date" placeholder="Enter End Date"
                                     value="{{ $enddate ?: '' }}">
                             </div>
                         </div>
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Select Services</label>
                                 <select name="servicename" class="form-control form-select"  id="servicename">
                                     <option value="">Select Service</option>
                                     @foreach ($service_data as $service_data_new)
                                         <option value="{{ $service_data_new->id }}"
                                             @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                             {{ $service_data_new->servicename }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                         {{-- <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Subservice Name</label>
                                 <select name="subservice_name" class="form-control form-select" id="subservice_name">
                                     <option value="">Select Subservice</option>
                                     @foreach ($subservice_data as $subservice_data_new)
                                         <option value="{{ $subservice_data_new->id }}"
                                             @if ($subservice_data_new->id == $filter_subservice_id) {{ 'selected' }} @endif>{{ $subservice_data_new->subservicename }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div> --}}
                    </div>
                    </div>
                    <div class="col-sm-3 col-md-4">
                     <div class="form-group">
                         <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>
     
                         <a class="btn btn-primary filter-btn" href="{{ route('enquiry-users.index') }}" style="margin-top: 22px;">Reset</a>
                         </div>
                    </div>
                </div>
             </form>
            </div>
     
        </div>
        <!-- /Search Filter -->


        <form method="GET" action="{{ url('filter_data_enquiryusers') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil" value="{{ $filter_service_id ?: '' }}">

            {{-- <input type="hidden" name="filter_subservice_id_fil" id="filter_subservice_id_fil" value="{{ $filter_subservice_id ?: '' }}"> --}}

        </form>




        <div class="row">
            <div class="col-sm-12">

                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete-enquiry-users') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Service</th>
                                            <th>Subservice</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- @php
                                            $i = 1;
                                        @endphp -->
                                        @foreach ($enquiry_users_data as $data)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                <td>
                                                    {{ Helper::servicename($data->service_id) }}
                                                </td>
                                                <td>
                                                    {{ Helper::subservicename($data->subservice_id) }}
                                                </td>
                                                <td>
                                                    {{ $data->name }}
                                                </td>
                                                <td>
                                                    {{ $data->email }}
                                                </td>
                                                <td>
                                                    {{ $data->country_code.' '.$data->mobile_number }}
                                                </td>
                                                <td>
                                                    {{ $data->created_at }}
                                                </td>


                                                {{-- @if (in_array('18', $edit_perm))
                                                    <td class="text-right">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('Enquiry Users.edit', $data->id) }}"><i
                                                                class="far fa-edit"></i></a>
                                                    </td>
                                                @endif --}}

                                            </tr>
                                            <!-- @php
                                                $i++;
                                            @endphp -->
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

    <script>
        function excel_download() {
           $('#filter_data').submit();
       }
       function filter_validation(){

               $('#filter_form').submit();
           }
   </script>
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
