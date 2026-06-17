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
    <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Painting Inquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Painting Inquiry</li>
                    </ul>
                </div>
                <div class="col-auto">
                    {{-- <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a> --}}
                    
                    {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a> --}}
                    
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

   <!-- Search Filter -->
   <div id="filter_inputs" class="card filter-card" >
       <div class="card-body pb-0">
        <form id="filter_form" action="javascript:void(0);" method="POST">
            @csrf
            <input type="hidden" name="action" value="filter">
           <div class="row">
               <div class="col-sm-6 col-md-8">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date" placeholder="Enter Start Date"
                                value="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date" placeholder="Enter End Date"
                                value="">
                        </div>
                    </div>
                    
               </div>
               </div>
               <div class="col-sm-3 col-md-4">
                <div class="form-group">
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;">Reset</a>
                    </div>
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
                        <form id="form" action="" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf

                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="enqury_table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="display: none;">Sr No</th>
                                            <th>Date</th>
                                            <th>Painting Inquiry No</th>
                                            <th>Name</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th>Lead Info</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($all_data != '')
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($all_data as $data)                                                    
                                                        <tr>
                                                            <td style="display: none">{{ $i }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($data->added_date))}}</td>
                                                            <td>{{ $data->inquiry_id }}</td>
                                                            <td>{{ $data->name }}</td>
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
                                                            <td>
                                                                <a class="btn btn-primary"
                                                                    href="{{ url('painting-enquiry-detail', $data->id) }}">View Information</a>
                                                                {{-- <a class="btn btn-primary" href="javascript:void('0');"
                                                                    onclick="Enquiry('{{ $data->id }}');">View
                                                                    Details
                                                                </a> --}}
                                                            </td>
                                                            {{-- <td><a class="btn btn-primary" href="javascript:void('0');"
                                                                    onclick="delete_category('{{ $data->id }}','{{ $userId }}');">
                                                                    Accept
                                                                </a></td> --}}
                                                        </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                            @endforeach
                                        @else
                                            <p>No Data Found</p>
                                        @endif
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
    {{-- <div class="modal custom-modal fade" id="delete_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure want to Accept</h3>
                        <p></p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Yes</button>
                </div>
            </div>
        </div>
    </div> --}}
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
    <script>
         function filter_validation(){
                $('#filter_form').submit();
            }
        function Enquiry(id) {
            //    alert(id);
            $('#delete_model_' + id).modal('show');
        }
    </script>
    <script>
        if ($.fn.DataTable.isDataTable('#enqury_table')) {
            $('#enqury_table').DataTable().destroy();
        }
        $(document).ready(function() {
            $('#enqury_table').dataTable({
                "searching": true,
                "order": [[0, "desc" ]]
            });
        })
    </script>
@stop
