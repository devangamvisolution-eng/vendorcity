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
    .premium-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        background: #fff;
        margin-bottom: 24px;
    }
    .premium-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .premium-table thead th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #eef2f5;
        padding: 16px;
        white-space: nowrap;
    }
    .premium-table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #555;
        border-bottom: 1px solid #f1f3f5;
        font-size: 14px;
    }
    .premium-table tbody tr {
        transition: all 0.2s ease;
    }
    .premium-table tbody tr:hover {
        background-color: #fcfcfc;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .badge-status {
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 12px;
        display: inline-block;
        text-align: center;
    }
    .badge-completed { background-color: #e6f6ec; color: #2e8b57; }
    .badge-pending { background-color: #fff8e5; color: #d4a305; }
    .badge-cancelled { background-color: #fdeded; color: #c0392b; }
    
    .filter-card {
        border-radius: 12px;
        border: 1px solid #eef2f5;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        background: #fafbfc;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
    }
    .btn-premium {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
    }
    .page-title {
        font-weight: 700;
        color: #2c3e50;
        font-size: 24px;
    }
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
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
                            <a class="btn btn-primary btn-premium me-1" href="javascript:void('0');" onclick="excel_download();"><i class="fas fa-file-excel"></i> Excel Download</a>
                        @endif

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


        <div id="filter_inputs" class="card filter-card" style="display: block !important;">

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
                                <a class="btn btn-primary btn-premium filter-btn" href="javascript:void(0);" style="margin-top: 22px;"
                                    onclick="filter_validation()">Submit</a>

                                <a class="btn btn-secondary btn-premium filter-btn" href="{{ route('cleaner-report') }}"
                                    style="margin-top: 22px; background: #6c757d; color: white;">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-12">

                <div class="card premium-card">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_order') }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="table premium-table" id="example">
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
                                                        $c_id = isset($data->actual_cleaner_id) ? $data->actual_cleaner_id : $data->cleaner_id;
                                                        $cleaner_Id = explode(',', $c_id);
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



@stop
