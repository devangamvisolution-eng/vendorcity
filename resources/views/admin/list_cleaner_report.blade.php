@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        //
        $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $edit_perm = [];

        // if ($get_permission_data->editperm != '') {

        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);

        // }

        $user_data = Auth::user();
        // echo"<pre>";print_r($user_data);echo"</pre>";exit;

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

    <style>
        /* ACTION-FIRST DESIGN SYSTEM */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        .action-card {
            /* overflow: visible !important; */
            overflow: auto !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* PREMIUM PAGINATION STYLE - EXACTLY AS PER SCREENSHOT */
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 20px;
            display: flex;
            gap: 5px;
            justify-content: flex-end;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #fff !important;
            border-radius: 50px !important;
            color: var(--text-dark) !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--action-blue) !important;
            color: #fff !important;
            border-color: var(--action-blue) !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }

        /* Table Styling - UPDATED FOR REDUCED GAPS */
        .action-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .action-table thead th {
            background: #4c7aef;
            padding: 10px 12px;
            /* Reduced from 15px 20px */
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #ffffff;
            border-bottom: 2px solid var(--border-classic);

            /* Sticky Properties */
            position: sticky;
            top: var(--admin-header-height);
            /* This keeps it below the top nav */
            z-index: 100;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
            box-shadow: inset 0 -1px 0 var(--border-classic);
        }

        .action-table tbody tr {
            border-bottom: 1px solid var(--border-classic);
            transition: background 0.15s;
        }

        .action-table tbody tr:hover {
            background-color: var(--hover-bg) !important;
        }

        .action-table td {
            padding: 8px 12px;
            /* Reduced from 16px 20px to close column and row gaps */
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.2;
            /* Tighter line height for stacked text */
        }

        .stack-top {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stack-bottom {
            display: block;
            font-size: 0.75rem;
            color: #64748b;
        }

        .btn-utility {
            background: #fff;
            border: 1px solid var(--border-classic);
            padding: 6px;
            /* Reduced from 8px */
            border-radius: 6px;
            color: #64748b;
        }

        table.dataTable td,
        table.dataTable th {
            -webkit-box-sizing: content-box;
            box-sizing: content-box;
            border-bottom: 1px solid cornflowerblue;
        }

        @media only screen and (max-width: 767px) {

            .action-card {
                overflow: scroll !important;
            }

        }
    </style>




    <div class="content container-fluid">





        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Crew Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Crew Report</li>

                    </ul>

                </div>



                @if (in_array('37', $edit_perm))

                    <div class="col-auto">

                        @if ($filter_cleaner_id != '')
                            <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel
                                Download</a>
                        @endif

                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
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

        <form method="GET" action="{{ url('filter_data_cleaner') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_cleaner_id_fil" id="filter_cleaner_id_fil"
                value="{{ $filter_cleaner_id ?: '' }}">

        </form>


        @php

            if (!empty($startdate) || !empty($enddate) || !empty($filter_cleaner_id)) {
                $css = 'display:block;';
            } else {
                $css = 'display:none;';
            }

        @endphp

        <div id="filter_inputs" class="card filter-card" style="{{ $css }}">

            <div class="card-body pb-0">
                <form id="filter_form" action="{{ route('cleaner-report') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">

                    <div class="row">

                        <div class="col-sm-6 col-md-8">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" name="s_date" id="s_date"
                                            placeholder="Enter Start Date" value="{{ $startdate }}">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control" name="e_date" id="e_date"
                                            placeholder="Enter End Date" value="{{ $enddate }}">
                                    </div>
                                </div>

                                {{-- <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Select Service</label>
                                 <select name="servicename" class="form-control form-select"  id="servicename">
                                     <option value="">Select Service</option>
                                     @foreach ($service_data as $service_data_new)
                                         <option value="{{ $service_data_new->id }}"
                                             @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                             {{ $service_data_new->servicename }}</option>
                                     @endforeach
                                 </select>
                                 <p class="form-error-text" id="servicename_error"
                                 style="color: red; margin-top: 10px;"></p>
                             </div>
                         </div> --}}

                                @php

                                    if ($user_data->role_id == 16) {
                                        $style = 'display:none;';
                                    } else {
                                        $style = 'display:block;';
                                    }
                                @endphp

                                <div class="col-lg-4" style="{{ $style }}">
                                    <div class="form-group">
                                        <label>Select Crew</label>
                                        <select name="cleaner_name" class="form-control form-select" id="cleaner_name">
                                            <option value="">Select Crew</option>

                                            @foreach ($cleaner_data as $data)
                                                @if ($data->id != 2)
                                                    <option value="{{ $data->id }}"
                                                        @if ($data->id == $filter_cleaner_id) {{ 'selected' }} @endif>
                                                        {{ $data->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="cleaner_name_error"
                                            style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-4">
                            <div class="form-group">
                                <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;"
                                    onclick="filter_validation()">Submit</a>

                                <a class="btn btn-primary filter-btn" href="{{ route('cleaner-report') }}"
                                    style="margin-top: 22px;">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-12">

                <div class="action-card">
                    <div class="card-body p-4">
                        <form id="form" action="{{ route('delete_order') }}">
                            @csrf
                            <table class="action-table" id="example">
                                <thead>
                                    <tr>
                                        <th style="display: none">Sr no</th>
                                        <th>Order Id</th>
                                        <th>Booking Date</th>
                                        <th>Service Type</th>
                                        <th>Sales Person</th>
                                        <th>Customer Details</th>
                                        <th>Cleaners Name</th>
                                        <th>No. Of Cleaners</th>
                                        <th>Address</th>
                                        <th>Starting Time</th>
                                        <th>Ending Time</th>
                                        <th>Duration In Hours</th>
                                        <th>Amount Per Hour</th>
                                        <th>Total Amount</th>
                                        <th>Service Charge</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($filter_cleaner_id != '')
                                        @foreach ($cleaner_order_data as $data)
                                            @php
                                                // echo"<pre>";print_r($data);echo"</pre>";exit;

                                                $user_data = DB::table('frontloginregisters')
                                                    ->where('id', $data->user_info_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td style="display: none">{{ $data->order_id }}</td>
                                                <td>{{ $data->format_order_id }}</td>
                                                <td>{{ $data->visit_date }}</td>
                                                <td>
                                                    {!! Helper::servicename($data->service_id) !!}<br>
                                                    {!! Helper::subservicename($data->subservice_id) !!}

                                                </td>

                                                <td>
                                                    @if ($data->salesperson_id != '' && $data->salesperson_id != null)
                                                        {!! Helper::salesperson($data->salesperson_id) !!}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $user_data->name }}
                                                    <br>{{ $user_data->mobile }}
                                                </td>
                                                <td>
                                                    @php
                                                        $cleaner_Id = explode(',', $data->cleaner_id);
                                                    @endphp
                                                    {!! Helper::cleanername_new($cleaner_Id) !!}
                                                </td>
                                                <td>{{ $data->how_many_hours_should_they_stay ?? '-' }}</td>
                                                <td>{{ collect([$data->apartment_villa_no, $data->building_street_no, $data->area, $data->city])->filter()->implode(', ') }}
                                                </td>
                                                <td>8:30 AM</td>
                                                <td>12:30 AM</td>
                                                <td>4</td>
                                                <td>25.00</td>
                                                <td>100.00</td>
                                                <td>dev</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="15"> No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
        $(document).ready(function() {
            $('#example').DataTable({
                "searching": true,
                "paging": true,
                "pageLength": 10,
                "info": false,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Quick Search...",
                    "paginate": {
                        "next": '<i class="fas fa-chevron-right"></i>',
                        "previous": '<i class="fas fa-chevron-left"></i>'
                    }
                },
                "dom": '<"top"f>rt<"bottom"p><"clear">'
            });
        });
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

        function excel_download() {
            $('#filter_data').submit();
        }

        function filter_validation() {

            var cleaner_name = jQuery("#cleaner_name").val();

            if (cleaner_name == '') {
                jQuery('#cleaner_name_error').html("Please Select Cleaner");
                jQuery('#cleaner_name_error').show().delay(0).fadeIn('show');
                jQuery('#cleaner_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#cleaner_name').offset().top - 150
                }, 1000);
                return false;
            }

            $('#filter_form').submit();
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
