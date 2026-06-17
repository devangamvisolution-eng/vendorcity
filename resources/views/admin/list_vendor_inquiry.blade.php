@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern Layout Variables - Copied from reference */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Modern Action Card style */
        .action-card {
            overflow: visible !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Consistent Table Header and Hover effects */
        .action-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .action-table thead th {
            background: #4c7aef;
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #ffffff;
            border-bottom: 2px solid var(--border-classic);
            position: sticky;
            top: var(--admin-header-height);
            z-index: 100;
        }

        .action-table tbody tr:hover {
            background-color: var(--hover-bg) !important;
        }

        .action-table td {
            padding: 12px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-classic);
        }

        /* DataTables Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }

        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }

        @media only screen and (max-width: 767px) {
            .action-card {
                overflow-x: auto !important;
            }
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Inquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Inquiry</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
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
        </div>

        @php
            if (!empty($startdate) || !empty($enddate) || !empty($filter_service_id)) {
                $css = 'display:block;';
            } else {
                $css = 'display:none;';
            }
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('vendor-enquiry-filter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date"
                                value="{{ $startdate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date"
                                value="{{ $enddate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Select Services</label>
                            <select name="servicename" class="form-select" id="servicename">
                                <option value="">Select Service</option>
                                @foreach ($service_data as $service_data_new)
                                    <option value="{{ $service_data_new->id }}"
                                        @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                        {{ $service_data_new->servicename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('vendorinquiry.index') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="action-card">
                    <div class="card-body p-4">
                        <form id="form" action="" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            {{-- KEEPING ALL YOUR PHP LOGIC INTACT --}}
                            @php
                                $userId = Auth::id();
                                $currentDate = now();
                                $vendor_subscription = DB::table('subscription')
                                    ->select('*')
                                    ->where('vendor_id', '=', $userId)
                                    ->where('is_deleted', '=', '0')
                                    ->orderBy('id', 'desc')
                                    ->get();

                                $resultArray = [];
                                foreach ($vendor_subscription as $vendor_subscription_data) {
                                    $vendor_subscription_att = DB::table('subscription_subservice_attribute')
                                        ->select('*')
                                        ->where('subscription_id', '=', $vendor_subscription_data->id)
                                        ->get();
                                    foreach ($vendor_subscription_att as $vendor_subscription_att_data) {
                                        $resultArray[] = [
                                            'subs_id' => $vendor_subscription_data->id,
                                            'service_id' => $vendor_subscription_att_data->service_id,
                                            'subservice_id' => $vendor_subscription_att_data->subservice_id,
                                            'city_id' => $vendor_subscription_data->city,
                                            'country_id' => $vendor_subscription_data->country,
                                            'to_country' => $vendor_subscription_data->to_country,
                                            'type_of_package' => $vendor_subscription_data->type_of_package,
                                        ];
                                    }
                                }

                                $combined_data = [];
                                foreach ($resultArray as $resultArray_data) {
                                    $typeInquiry =
                                        $resultArray_data['type_of_package'] == '0'
                                            ? 'Local Move'
                                            : 'International Move';

                                    $query = DB::table('packages_enquiry')
                                        ->select('*')
                                        ->where('service_id', '=', $resultArray_data['service_id'])
                                        ->where('subservice_id', '=', $resultArray_data['subservice_id'])
                                        ->where('form_type', $typeInquiry);
                                    if (!empty($startdate)) {
                                        $query->where('added_date', '>=', date('Y-m-d', strtotime($startdate)));
                                    }
                                    if (!empty($enddate)) {
                                        $query->where('added_date', '<=', date('Y-m-d', strtotime($enddate)));
                                    }
                                    if (!empty($filter_service_id)) {
                                        $query->where('service_id', '=', $filter_service_id);
                                    }

                                    $packages_enquiry = $query->where('count', '<', 5)->orderBy('id', 'desc')->get();

                                    foreach ($packages_enquiry as $packages_enquiry_da) {
                                        if (
                                            ($packages_enquiry_da->service_id == 30 &&
                                                $packages_enquiry_da->subservice_id == 23) ||
                                            ($packages_enquiry_da->service_id == 30 &&
                                                $packages_enquiry_da->subservice_id == 26)
                                        ) {
                                            if ($packages_enquiry_da->form_type == 'International Move') {
                                                $package_inquiry_data_from = DB::table('more_formfields_details')
                                                    ->where('package_inquiry_id', $packages_enquiry_da->id)
                                                    ->where('form_field_id', 57)
                                                    ->first();
                                                $package_inquiry_data_to = DB::table('more_formfields_details')
                                                    ->where('package_inquiry_id', $packages_enquiry_da->id)
                                                    ->where('form_field_id', 47)
                                                    ->first();

                                                if (
                                                    !empty($package_inquiry_data_to) &&
                                                    !empty($package_inquiry_data_from)
                                                ) {
                                                    $form_attributes_data_to = DB::table('form_attributes')
                                                        ->where('id', $package_inquiry_data_to->formfield_value)
                                                        ->first();
                                                    $form_attributes_data_from = DB::table('form_attributes')
                                                        ->where('id', $package_inquiry_data_from->formfield_value)
                                                        ->first();
                                                    $country_to = DB::table('countries')
                                                        ->where('country', $form_attributes_data_to->form_option)
                                                        ->first();
                                                    $country_from = DB::table('countries')
                                                        ->where('country', $form_attributes_data_from->form_option)
                                                        ->first();

                                                    $country_id_to = $country_to->id ?? '';
                                                    $country_id_from = $country_from->id ?? '';

                                                    $subs_country_from = explode(',', $resultArray_data['country_id']);
                                                    $subs_country_to = explode(',', $resultArray_data['to_country']);
                                                    $packages_enquiry_type =
                                                        $packages_enquiry_da->form_type == 'Local Move' ? 0 : 1;

                                                    if (
                                                        in_array($country_id_to, $subs_country_to) &&
                                                        in_array($country_id_from, $subs_country_from) &&
                                                        isset($resultArray_data['type_of_package']) &&
                                                        $packages_enquiry_type == $resultArray_data['type_of_package']
                                                    ) {
                                                        $combined_data[] = $packages_enquiry_da->id;
                                                    }
                                                }
                                            } else {
                                                $package_inquiry_data = DB::table('more_formfields_details')
                                                    ->where('package_inquiry_id', $packages_enquiry_da->id)
                                                    ->where('form_field_id', 17)
                                                    ->first();
                                                if (!empty($package_inquiry_data)) {
                                                    $form_attributes_data = DB::table('form_attributes')
                                                        ->where('id', $package_inquiry_data->formfield_value)
                                                        ->first();
                                                    $city_data = DB::table('cities')
                                                        ->where('name', $form_attributes_data->form_option)
                                                        ->first();
                                                    $subs_city = explode(',', $resultArray_data['city_id']);
                                                    $packages_enquiry_type =
                                                        $packages_enquiry_da->form_type == 'Local Move' ? 0 : 1;

                                                    if (
                                                        in_array($city_data->id, $subs_city) &&
                                                        isset($resultArray_data['type_of_package']) &&
                                                        $packages_enquiry_type == $resultArray_data['type_of_package']
                                                    ) {
                                                        $combined_data[] = $packages_enquiry_da->id;
                                                    }
                                                }
                                            }
                                        } else {
                                            $combined_data[] = $packages_enquiry_da->id;
                                        }
                                    }
                                }

                                $uniqueArray = [];
                                foreach ($resultArray as $entry) {
                                    $key = $entry['service_id'] . '_' . $entry['subservice_id'];
                                    if (!isset($uniqueArray[$key])) {
                                        $uniqueArray[$key] = $entry;
                                    }
                                }
                                $resultArray = array_values($uniqueArray);
                            @endphp

                            <div class="table-responsive">
                                <table class="action-table table-hover" id="enqury_table">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">Sr No</th>
                                            <th>Date</th>
                                            <th>Inquiry No</th>
                                            <th>Customer Name</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vendor_subscription->isNotEmpty())
                                            @php $i = 1; @endphp
                                            @foreach ($resultArray as $resultArray_data)
                                                @php
                                                    $packages_enquiry = DB::table('packages_enquiry')
                                                        ->select('*')
                                                        ->where('service_id', '=', $resultArray_data['service_id'])
                                                        ->where(
                                                            'subservice_id',
                                                            '=',
                                                            $resultArray_data['subservice_id'],
                                                        )
                                                        ->where('count', '<', 5)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
                                                @endphp
                                                @foreach ($packages_enquiry as $packages_enquiry_data)
                                                    @php
                                                        $vendor_data = Auth::user();
                                                        $vendors_data = DB::table('package_inquiry_accepted')
                                                            ->where('packages_inquiry_id', $packages_enquiry_data->id)
                                                            ->where('vendor_id', $vendor_data->id)
                                                            ->first();
                                                    @endphp
                                                    @if ($vendors_data == '')
                                                        @if (in_array($packages_enquiry_data->id, $combined_data))
                                                            <tr>
                                                                <td style="display: none">{{ $packages_enquiry_data->id }}
                                                                </td>
                                                                <td>{{ date('d-m-Y', strtotime($packages_enquiry_data->added_date)) }}
                                                                </td>
                                                                <td><span
                                                                        class="fw-bold text-primary">#{{ $packages_enquiry_data->inquiry_id }}</span>
                                                                </td>
                                                                <td class="fw-bold">{{ $packages_enquiry_data->name }}</td>
                                                                <td>
                                                                    @if ($packages_enquiry_data->service_id != '')
                                                                        {!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($packages_enquiry_data->subservice_id != '')
                                                                        <div class="small text-muted">
                                                                            {!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    <a class="btn btn-sm btn-outline-primary"
                                                                        href="{{ url('enquiry_detail', $packages_enquiry_data->id) }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="View Information">
                                                                        <i class="far fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                    @php $i++; @endphp
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
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

    @isset($packages_enquiry)
        {{-- @if ($packages_enquiry != '') --}}
        @foreach ($packages_enquiry as $packages_enquirys)
            <div class="modal custom-modal fade" id="delete_model_{{ $packages_enquirys->id }}" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-text text-center">
                                <!-- <h3>Delete Expense Category</h3> -->
                                @php
                                    $result = DB::table('more_formfields_details')
                                        ->select('*')
                                        ->where('package_inquiry_id', '=', $packages_enquirys->id)
                                        ->get();
                                    //$servicename = Helper::servicename($result->service_id);
                                @endphp
                                @if ($result != '' && count($result) > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="invoice-table table table-bordered">
                                                    <thead>
                                                        @foreach ($result as $result_data)
                                                            <tr>
                                                                <th>{!! Helper::form_fields($result_data->form_field_id) !!}</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $result_data->formfield_value }}</td>
                                                        </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p>No Data Found</p>
        @endif
        </div>
        </div>
        </div>
        </div>
        </div>
        @endforeach
    @endisset
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
    <!-- /set orderModal -->
    {{-- <form id="form_new" action="{{ route('accept_vendor_inquiry') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="inquiry_id" id="inquiry_id" value="">
        <input type="hidden" name="vendor_id" id="vendor_id" value="">
    </form> --}}
    {{-- <script>
    function delete_category(id, vendor_id) {
        $('#inquiry_id').val(id);
        $('#vendor_id').val(vendor_id);
        $('#delete_model').modal('show');
    }
    function form_sub() {
        $('#form_new').submit();
    }
</script> --}}
    <script>
        function filter_validation() {
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
                "order": [
                    [0, "desc"]
                ]
            });
        })
        // $(document).ready(function() {
        //     // Destroy existing DataTable instance if it exists
        //     if ($.fn.DataTable.isDataTable('#enqury_table')) {
        //         $('#enqury_table').DataTable().destroy();
        //     }
        //     // Reinitialize DataTable with new options
        //     $('#enqury_table').DataTable({
        //         "order": [[ 0, "desc" ]], // Set initial sorting order
        //         "columnDefs": [{
        //             "targets": 0,
        //             "type": "date-eu"
        //         }]
        //     });
        // });
    </script>
@stop
